<?php
    include "../common/config.php";
    include_once "../common/functions.php";

    if(!isset($_POST["username"]) || !isset($_POST["password"])){
        $msg = urlencode("Errore: dati mancanti!");
        header("Location: ../login.php?err=".$msg);
        exit();
    }

    if(empty($_POST["username"]) || empty($_POST["password"])){
        $msg = urlencode("Errore: credenziali non valide!");
        header("Location: ../login.php?err=".$msg);
        exit();
    }

    try{
        $conn = new mysqli(
            $dati_conn["host"],
            $dati_conn["user"],
            $dati_conn["pwd"],
            $dati_conn["db"]
        );
    }catch(Exception $e){
        echo $e->getMessage();
        exit();
    }

    $username = $conn->real_escape_string($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT id_utente,pwd,ruolo FROM Utenti WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $string_hash = $row["pwd"];
        $idUtente = intval($row["id_utente"]);
        $ruolo = $row["ruolo"];

        if(password_verify($password, $string_hash)){
            if(password_needs_rehash($string_hash, PASSWORD_BCRYPT)) { //Ho trovato questa funzione sulla documentazione di PHP
                $newHash = password_hash($password, PASSWORD_BCRYPT); //https://www.php.net/manual/en/function.password-needs-rehash.php
                $sql = "UPDATE Utenti SET pwd=? WHERE idUtente=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $newHash, $idUtente);
                $stmt->execute();
                $stmt->close();
            }

            session_start();
            $_SESSION["auth"] = "true";
            $_SESSION["idUtente"] = $idUtente;
            $_SESSION["username"] = $username;
            $_SESSION["ruolo"] = ucfirst($ruolo); //Rendo la prima lettera maiuscola per evitare errori

            $result->free();
            $stmt->close();
            $conn->close();
            header("Location: ../pages/home.php");
            exit();
        }else{
            $result->free();
            $stmt->close();
            $conn->close();
            $msg = urlencode("Errore: password errata!");
            header("Location: ../pages/login.php?err=".$msg);
            exit();
        }
    }else{
        $stmt->close();
        $conn->close();
        $msg = urlencode("Errore: username errato!");
        header("Location: ../pages/login.php?err=".$msg);
        exit();
    }
?>