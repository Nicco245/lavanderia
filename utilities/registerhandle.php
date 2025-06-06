<?php
    include "../common/config.php";
    include_once "../common/functions.php";

    authAdmin();

    if(!isset($_POST["cf"]) || !isset($_POST["nome"]) || !isset($_POST["email"]) || !isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["ruolo"])){
        $msg = urlencode("Errore: dati mancanti!");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }

    $cf = strtoupper(trim($_POST["cf"]));
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $username = $_POST["username"];
    $password = $_POST["password"];
    $ruolo = ucfirst($_POST["ruolo"]);

    if(empty($username)){
        $msg = urlencode("Errore: username vuoto!");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }

    if(empty($password)){
        $msg = urlencode("Errore: password vuota!");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }
    
    if(strlen($username)<4){
        $msg = urlencode("Errore: username troppo corto (>4)");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }

    if(strlen($password)<8){
        $msg = urlencode("Errore: password troppo corta (>8)");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }

    if(strpos($username, " ")!==false){
        $msg = urlencode("Errore: L'username non può contenere spazi!");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }

    if(strpos($password, " ")!==false){
        $msg = urlencode("Errore: La password non può contenere spazi!");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }

    if(!containsNum($password)){
        $msg = urlencode("Errore: La password deve contenere almeno 1 numero!");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }

    if(strlen($cf)!=16){
        $msg = urlencode("Errore: codice fiscale non valido!");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }

    /*
    //https://www.php.net/manual/en/filter.examples.validation.php
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $msg = urlencode("Errore: Email non valida");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }
    */

    if($ruolo==="Default"){
        $msg = urlencode("Errore: ruolo non valido!");
        header("Location: ../pages/registra.php?err=".$msg);
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

    $cf = $conn->real_escape_string($cf);
    $nome = $conn->real_escape_string($nome);
    $email = $conn->real_escape_string($email);
    $username = $conn->real_escape_string($username);

    $sql = "SELECT * FROM Clienti WHERE CF=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cf);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0){
        $result->free();
        $conn->close();
        $msg = urlencode("Errore: codice fiscale gia presente!");
        header("Location: ../pages/registra.php?err=".$msg);
        exit();
    }else{
        $sql = "SELECT * FROM Utenti WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows>0){
            $result->free();
            $conn->close();
            $msg = urlencode("Errore: username già presente!");
            header("Location: ../pages/registra.php?err=".$msg);
            exit();
        }else{
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO Utenti(username,pwd,ruolo) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $password_hash, $ruolo);
            $stmt->execute();
            if($stmt->affected_rows>0){
                $idUtente = $stmt->insert_id; //con insert_id recupero l'id generato da AUTO_INCREMENT
                $sql = "INSERT INTO Clienti(CF,nominativo,email,id_utente) VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $cf, $nome, $email, $idUtente);
                $stmt->execute();
                if($stmt->affected_rows>0){
                    $msg = urlencode("Cliente registrato!");
                    header("Location: ../pages/home.php?msg=".$msg);
                    exit();
                }else{
                    $msg = urlencode("Errore: impossibile registrare il cliente!");
                    header("Location: ../pages/registra.php?err=".$msg);
                    exit();
                }
            }else{
                $msg = urlencode("Errore: impossibile registrare l'utente!");
                header("Location: ../pages/registra.php?err=".$msg);
                exit();
            }
        }
    }
?>