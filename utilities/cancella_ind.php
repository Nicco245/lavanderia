<?php
    include "../common/config.php";
    include_once "../common/functions.php";
    
    authAdmin();

    if(!isset($_POST["id_indumento"])){
        $msg = urlencode("Errore: dati mancanti!");
        header("Location: ../pages/home.php?err=".$msg);
        exit();
    }
    if(empty($_POST["id_indumento"])){
        $msg = urlencode("Errore: dati vuoti!");
        header("Location: ../pages/home.php?err=".$msg);
        exit();
    }

    $id_indumento = $_POST["id_indumento"];

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

    $id_indumento = intval($id_indumento);

    $sql = "DELETE FROM indumenti WHERE id_indumento=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_indumento);
    if($stmt->execute() && $stmt->affected_rows>0){
        header("Location: ../pages/ricercaIndumenti.php");
        $stmt->close();
        $conn->close();
        exit();
    }else{
        $stmt->close();
        $conn->close();
        $msg = urlencode("Errore nell'eliminazione!");
        header("Location: ../pages/home.php?err=".$msg);
        exit();
    }
?>