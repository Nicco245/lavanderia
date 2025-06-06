<?php
    include "../common/config.php";
    include_once "../common/functions.php";

    authAdmin();

    if(!isset($_POST["id_indumento"]) || !isset($_POST["prop"]) || !isset($_POST["desc"])){
        $msg = urlencode("Errore: dati mancanti!");
        header("Location: ../pages/home.php?err=".$msg);
        exit();
    }
    if(empty($_POST["id_indumento"]) || empty($_POST["prop"]) || empty($_POST["desc"])){
        $msg = urlencode("Errore: dati vuoti!");
        header("Location: ../pages/home.php?err=".$msg);
        exit();
    }

    $id_indumento = intval($_POST["id_indumento"]);
    $prop = $_POST["prop"];
    $desc = $_POST["desc"];

    if($prop=="default"){
        $msg = urlencode("Errore: seleziona un proprietario valido!");
        header("Location: ../pages/aggiornaIndumento.php?err=".$msg);
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

    $sql = "UPDATE indumenti SET cliente=?, descrizione=? WHERE id_indumento=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $prop, $desc, $id_indumento);
    if($stmt->execute()){
        $stmt->close();
        $conn->close();
        $msg = urlencode("Indumento aggiornato!");
        header("Location: ../pages/ricercaIndumenti.php?msg=".$msg);
        exit();
    }else{
        $stmt->close();
        $conn->close();
        $msg = urlencode("Errore: impossibile aggiornare!");
        header("Location: ../pages/home.php?err=".$msg);
        exit();
    }
?>