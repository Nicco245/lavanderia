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
    <title>Ricerca indumenti</title>
</head>
<body>
    <?php
        include "../common/config.php";

        try {
            $conn = new mysqli(
                $dati_conn["host"],
                $dati_conn["user"],
                $dati_conn["pwd"],
                $dati_conn["db"]
            );
        } catch(Exception $e) {
            echo $e->getMessage();
            exit();
        }

        if($_SESSION["ruolo"]==="Amministratore"){
            $indumenti = getIndumenti($conn);
        }else{
            $idUtente = intval($_SESSION["idUtente"]);
            $indumenti = getIndumentiUser($conn, $idUtente);
        }
        $conn->close();

        if(count($indumenti)>0) {
            echo "<h1>Elenco indumenti</h1>";
            if(isset($_GET["msg"]) && !empty($_GET["msg"])){
                $msg = urldecode($_GET["msg"]);
                echo '<h2 style="color: green;">'.$msg.'</h2>';
                echo '<br>';
            }
            if(isset($_GET["err"]) && !empty($_GET["err"])){
                $err = urldecode($_GET["err"]);
                echo '<h2 style="color: red;">'.$err.'</h2>';
                echo '<br>';
            }
            echo '<table>';
            echo '<br>';
            echo '<tr>
                    <th>Codice</th>
                    <th>Cliente</th>
                    <th>Descrizione</th>
            ';
            if($_SESSION["ruolo"]==="Amministratore"){
                echo '<th>Azioni</th>';
            }
            echo '</tr>';

            foreach($indumenti as $indumento) {
                echo '
                <tr>
                    <td><b>'.$indumento["id_indumento"].'</b></td>
                    <td>'.$indumento["cliente"].'</td>
                    <td>'.$indumento["descrizione"].'</td>
                ';
                if($_SESSION["ruolo"]==="Amministratore"){
                    echo '
                    <td>
                        <form action="../utilities/cancella_ind.php" method="post" onsubmit="return conferma()" style="display:inline;">
                            <input type="hidden" name="id_indumento" value="'.$indumento["id_indumento"].'">
                            <input type="submit" style="background-color: #d10202;" value="Elimina">
                        </form>
                        <form action="./aggiornaIndumento.php" method="post" style="display:inline;">
                            <input type="hidden" name="id_indumento" value="'.$indumento["id_indumento"].'">
                            <input type="submit" value="Aggiorna">
                        </form>
                    </td>
                </tr>
                ';
                }
            }
            echo '</table>';
        }else{
            echo '
                <div class="container">
                    <h1>Nessun indumento trovato</h1>
                </div>
            ';
        }
    ?>
    <br>
    <form action="./home.php" method="post">
        <input type="submit" style="background-color: steelblue;" value="Torna alla home">
    </form>
    <script src="../script.js"></script>
</body>
</html>