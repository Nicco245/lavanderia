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
    <title>Home</title>
</head>
<body>
    <h1>Lavanderia</h1>
    <?php
        if(isset($_GET["msg"]) && !empty($_GET["msg"])){
            $msg = urldecode($_GET["msg"]);
            echo '<h2 style="color: green;">'.$msg.'</h2>';
        }
        if(isset($_GET["err"]) && !empty($_GET["err"])){
            $err = urldecode($_GET["err"]);
            echo '<h2 style="color: red;">'.$err.'</h2>';
        }
    ?>
    <br>
    <div class="container">
        <?php
            echo '<h3>Benvenuto, '.$_SESSION["username"].'!</h3>';
            echo '<h3>Tipo utente: '.$_SESSION["ruolo"].'</h3>';
            echo '<br>';
        ?>
        <form action="./aggiungiIndumento.php" method="post">
            <input type="submit" value="Aggiungi indumento">
        </form>
        <br>
        <form action="./ricercaIndumenti.php" method="post">
            <input type="submit" value="Ricerca indumenti">
        </form>
        <br>
        <?php
            if($_SESSION["ruolo"]==="Amministratore"){
                echo '<br>';
                echo '<h3>Opzioni amministratore</h3>';
                echo '<form action="./registra.php" method="post">';
                echo '<input type="submit" value="Registra cliente">';
                echo '</form>';
                echo '<br>';
                echo '<form action="./gestioneUtenti.php" method="post">';
                echo '<input type="submit" value="Gestione utenti">';
                echo '</form>';
                echo '<br><br>';
            }
        ?>
        <form action="../utilities/logouthandle.php" method="post">
            <input type="submit" style="background-color: #d10202" value="Logout">
        </form>
    </div>
    <script src="../script.js"></script>
</body>
</html>