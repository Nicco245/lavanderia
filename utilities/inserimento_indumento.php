<?php
    include "../common/config.php";
    include_once "../common/functions.php";
    
    auth();

    if(!isset($_POST["prop"]) || !isset($_POST["desc"])){
        $msg = urlencode("Errore: dati mancanti!");
        header("Location: ../pages/home.php?err=".$msg);
        exit();
    }
    if(empty($_POST["prop"]) || empty($_POST["desc"])){
        $msg = urlencode("Errore: dati vuoti!");
        header("Location: ../pages/home.php?err=".$msg);
        exit();
    }

    $prop = $_POST["prop"];
    $desc = $_POST["desc"];

    if($prop=="default") {
        $msg = urlencode("Errore: seleziona un proprietario valido!");
        header("Location: ../pages/home.php?err=".$msg);
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

    $prop = $conn->real_escape_string($prop);
    $desc = $conn->real_escape_string($desc);

    $sql = "INSERT INTO indumenti (descrizione,cliente) VALUES(?,?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $desc,$prop);
    if($stmt->execute()){
        $stmt->close();
        $conn->close();
        $msg = urlencode("Indumento inserito!");
        header("Location: ../pages/home.php?msg=".$msg);
        exit();
    }else{
        $stmt->close();
        $conn->close();
        $msg = urlencode("Errore nell'inserimento!");
        header("Location: ../pages/home.php?err=".$msg);
        exit();
    }
?>