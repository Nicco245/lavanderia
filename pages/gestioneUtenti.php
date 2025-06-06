<?php
    include_once "../common/functions.php";
    authAdmin();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Gestione utenti</title>
</head>
<body>
    <h1>Gestione utenti</h1>
    <?php
        include "../common/config.php";

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
    
        $utenti = getUtenti($conn);

        if(isset($_GET["msg"]) && !empty($_GET["msg"])){
            $msg = urldecode($_GET["msg"]);
            echo '<h2 style="color: green;">'.$msg.'</h2>';
        }
        if(isset($_GET["err"]) && !empty($_GET["err"])){
            $err = urldecode($_GET["err"]);
            echo '<h2 style="color: red;">'.$err.'</h2>';
        }
    ?>
    <div class="container">
        <form action="./home.php" method="post">
            <input type="submit" style="background-color: steelblue;" value="Torna alla home">
        </form>
        
        <table>
            <tr>
                <th>Username</th>
                <th>Ruolo</th>
                <th>Amministratore</th>
            </tr>
            <?php
                foreach($utenti as $utente){
                    echo '
                        <tr>
                            <td>'.htmlspecialchars($utente['username']).'</td>
                            <td>'.htmlspecialchars($utente['ruolo']).'</td>
                            <td>
                                <form action="../utilities/aggiorna_utente.php" method="post">
                                    <input type="hidden" name="id_utente" value="'.$utente['id_utente'].'">
                                    <input type="hidden" name="ruolo" value="'.$utente['ruolo'].'">
                                    <input type="checkbox" name="toggleRuolo"';
                                    if($utente["ruolo"]==="Amministratore"){
                                        echo 'checked';
                                    }
                                    echo '>
                                    <input type="submit" value="Aggiorna">
                                </form>
                            </td>
                        </tr>
                    ';
                }
            ?>
        </table>
    </div>
</body>
</html>
