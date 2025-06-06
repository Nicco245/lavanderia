<?php
    function auth(){
        session_start();
        if(!isset($_SESSION["auth"]) || $_SESSION["auth"]=="false"){
            $msg = urlencode("Errore: non sei autenticato!");
            header("Location: ../index.php?err=".$msg);
            exit();
        }
    }

    function authIndex(){
        session_start();
        if(isset($_SESSION["auth"]) && $_SESSION["auth"]=="true"){
            header("Location: ../pages/home.php");
            exit();
        }
    }

    function authAdmin(){
        auth();
        if(!isset($_SESSION["ruolo"]) || $_SESSION["ruolo"]==="Semplice"){
            $msg = urlencode("Errore: non hai i permessi!");
            header("Location: ../pages/home.php?err=".$msg);
            exit();
        }
    }

    function containsNum($str){
        for($i=0;$i<strlen($str);$i++){
            if(is_numeric($str[$i])){
                return true;
            }
        }
        return false;
    }

    function getProp($conn){
        $sql = "SELECT * FROM clienti";
        $res = $conn->query($sql);
        $proprietari = [];
        if($res){
            if($res->num_rows!=0){
                while($row = $res->fetch_assoc()){
                    $proprietari[] = $row;
                }
                $res->free();
            }
        }
        return $proprietari;
    }

    function getIndumenti($conn){
        $sql = "SELECT * FROM indumenti";
        $res = $conn->query($sql);
        $indumenti = [];
        if($res){
            if($res->num_rows!=0){
                while($row = $res->fetch_assoc()){
                    $indumenti[] = $row;
                }
            }
            $res->free();
        }
        return $indumenti;
    }

    function getIndumentiUser($conn, $id_utente){
        $sql = "SELECT i.* FROM Indumenti i
                    JOIN Clienti c ON i.cliente=c.CF
                        WHERE c.id_utente=?"
        ;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_utente);
        if($stmt->execute()){
            $res = $stmt->get_result();
            $indumenti = [];
            if($res->num_rows!=0){
                while($row = $res->fetch_assoc()){
                    $indumenti[] = $row;
                }
            }
        }
        return $indumenti;
    }

    function getDati($conn, $id_utente){
        $sql = "SELECT CF,nominativo FROM Clienti WHERE id_utente=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_utente);
        if($stmt->execute()){
            $res = $stmt->get_result();
            $dati = [];
            if($res->num_rows!=0){
                $dati = $res->fetch_assoc();
            }
        }
        $res->free();
        $stmt->close();
        return $dati;
    }

    function getIndumento($conn, $id_indumento){
        $sql = "SELECT cliente,descrizione FROM indumenti WHERE id_indumento=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_indumento);
        if($stmt->execute()){
            $res = $stmt->get_result();
            $indumento = [];
            if($res->num_rows!=0){
                $indumento = $res->fetch_assoc();
            }
        }
        $res->free();
        $stmt->close();
        return $indumento;
    }

    function getUtenti($conn){
        $sql = "SELECT * FROM Utenti";
        $res = $conn->query($sql);
        $utenti = [];
        if($res){
            if($res->num_rows!=0){
                while($row = $res->fetch_assoc()){
                    $utenti[] = $row;
                }
            }
            $res->free();
        }
        return $utenti;
    }
?>