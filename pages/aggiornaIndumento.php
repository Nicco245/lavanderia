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
    <title>Aggiorna indumento</title>
</head>
<body>
    <?php
        if(!isset($_POST["id_indumento"])){
            $msg = urlencode("Errore: dati mancanti");
            header("Location: ./home.php?err=".$msg);
            exit();
        }
        if(empty($_POST["id_indumento"])){
            $msg = urlencode("Errore: dati vuoti");
            header("Location: ./home.php?err=".$msg);
            exit();
        }

        $id_indumento = intval($_POST["id_indumento"]);

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

        $indumento = getIndumento($conn, $id_indumento);
        $proprietari = getProp($conn);
    ?>
    <div class="container">
        <h1>Aggiorna indumento</h1>
        <?php
            echo '<table>';
            echo '<br>';
            echo '<h3>Dati attuali</h3>';
            echo '<tr>
                    <th>Codice</th>
                    <th>Proprietario</th>
                    <th>Descrizione</th>
                </tr>
                ';
            echo '
                <tr>
                <td><b>'.$id_indumento.'</b></td>
                <td>'.$indumento["cliente"].'</td>
                <td>'.$indumento["descrizione"].'</td>
                </table>
            ';
        ?>
        <br>
        <form action="../utilities/aggiorna_ind.php" method="post" autocomplete="off">
            <?php
                echo '<input type="hidden" name="id_indumento" value="'.$id_indumento.'">';
            ?>
            <label for="prop">Proprietario</label>
            <br>
            <select name="prop" id="prop" required>
                <option value="default" hidden selected>-- Scegli un'opzione --</option>
                <?php
                    for($i=0;$i<count($proprietari);$i++){
                        echo '<option value="'.$proprietari[$i]["CF"].'">'.$proprietari[$i]["CF"].' - '.$proprietari[$i]["nominativo"].'</option>';
                    }
                ?>
            </select>
            <br><br>
            <label for="desc">Descrizione</label>
            <br>
            <input type="text" name="desc" id="desc" placeholder="Inserisci la descrizione" required>
            <br><br>
            <input type="submit" value="Aggiorna">
        </form>
    </div>
    <br><br>
    <form action="./ricercaIndumenti.php" method="post">
        <input type="submit" value="Torna indietro">
    </form>
    <br>
    <form action="./home.php" method="post">
        <input type="submit" style="background-color: steelblue;" value="Torna alla home">
    </form>
    <script src="../script.js"></script>
</body>
</html>