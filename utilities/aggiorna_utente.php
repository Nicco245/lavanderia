<?php
    include "../common/config.php";
    include_once "../common/functions.php";

    authAdmin();

    if(!isset($_POST["id_utente"]) || !isset($_POST["ruolo"])){
        $msg = urlencode("Errore: dati mancanti!");
        header("Location: ../pages/home.php?err=".$msg);
        exit();
    }

    $idUtente = intval($_POST["id_utente"]);
    $oldRuolo = $_POST["ruolo"];
    $newRuolo = "";
    if(isset($_POST["toggleRuolo"]) && $_POST["toggleRuolo"]==="on"){
        $newRuolo = "Amministratore";
    }else{
        $newRuolo = "Semplice";
    }

    session_start();
    if($idUtente===intval($_SESSION["idUtente"])){
        $msg = urlencode("Errore: non puoi aggiornare te stesso!");
        header("Location: ../pages/gestioneUtenti.php?err=".$msg);
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

    $sql = "UPDATE Utenti SET ruolo=? WHERE id_utente=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newRuolo, $idUtente);
    if($stmt->execute()){
        $stmt->close();
        $conn->close();
        $msg = urlencode("Utente aggiornato!");
        header("Location: ../pages/gestioneUtenti.php?msg=".$msg);
        exit();
    }else{
        $stmt->close();
        $conn->close();
        $msg = urlencode("Errore: impossibile aggiornare!");
        header("Location: ../pages/gestioneUtenti.php?err=".$msg);
        exit();
    }
?>