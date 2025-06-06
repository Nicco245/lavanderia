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
    <title>Registra un utente</title>
</head>
<body>
    <h1>Registra un cliente</h1>
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
    <div class="form-container">
        <form action="../utilities/registerhandle.php" method="post" autocomplete="off">
            <div class="input-group">
                <label for="cf">Codice fiscale</label>
                <input type="text" name="cf" id="cf" placeholder="Inserisci il codice fiscale" minlength="16" maxlength="16" pattern="[a-zA-Z]{6}\d{2}[abcdehlmprstaABCDEHLMPRST]\d{2}[a-zA-Z]\d{3}[a-zA-Z]" required>
            </div>
            <br>
            <div class="input-group">
                <label for="nome">Nominativo</label>
                <input type="text" name="nome" id="nome" placeholder="Inserisci il nome" required>
            </div>
            <br>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Inserisci l'email" required>
            </div>
            <br>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Inserisci l'username" required>
            </div>
            <br>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Inserisci la password" required>
            </div>
            <br>
            <div class="input-group">
                <label for="ruolo">Tipo utente</label>
                <select name="ruolo" id="ruolo">
                    <option value="default" hidden selected>-- Scegli un'opzione --</option>
                    <option value="amministratore">Amministratore</option>
                    <option value="semplice">Semplice</option>
                </select>
            </div>
            <br>
            <div class="form-actions">
                <input type="reset" class="btn-reg" value="Reset">
                <input type="submit" class="btn-reg" value="Registra l'utente">
            </div>
        </form>
        <br>
        <form action="../pages/home.php" method="post">
            <input type="submit" style="background-color: steelblue;" class="btn-reg" value="Torna alla home">
        </form>
    </div>
    <script src="../script.js"></script>
</body>
</html>