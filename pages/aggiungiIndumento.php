<?php
    include_once "../common/functions.php";
    auth();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Aggiungi indumento</title>
</head>
<body>
    <h1>Inserimento indumento</h1>
    <?php
        include "../common/config.php";

        try {
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

        $proprietari = getProp($conn);

        if(count($proprietari)<=0){
            echo '
                <div class="container">
                    <h2 style="color: red;">Nessun proprietario disponibile</h2>
                </div>
            ';
        }else{
            $ruolo = $_SESSION["ruolo"];
            echo '
                <br>
                <div class="container">
                    <form action="../utilities/inserimento_indumento.php" method="post" autocomplete="off">
                        <label for="prop">Proprietario</label>
                        <br>';
            
            if($ruolo==="Semplice"){
                $idUtente = $_SESSION["idUtente"];
                $dati = getDati($conn, $idUtente);
                echo '<select name="prop" required>
                        <option value="'.$dati["CF"].'" selected>'.$dati["CF"].' - '.$dati["nominativo"].'</option>
                      </select>
                ';
            }else{
                echo '<select name="prop" required>
                        <option value="default" hidden>-- Scegli un\'opzione --</option>';
                foreach($proprietari as $prop){
                    echo '<option value="'.$prop["CF"].'">'.$prop["CF"].' - '.$prop["nominativo"].'</option>';
                }
                echo '</select>';
            }
            echo '
                        <br><br>
                        <label for="desc">Descrizione</label>
                        <br>
                        <input type="text" name="desc" id="desc" placeholder="Inserisci la descrizione" required>
                        <br><br>
                        <input type="submit" value="Inserisci">
                        <br><br>
                    </form>
                    <form action="../pages/home.php" method="post">
                        <input type="submit" style="background-color: steelblue;" value="Torna alla home">
                    </form>
                </div>
            ';
        }
    ?>
    <script src="../script.js"></script>
</body>
</html>