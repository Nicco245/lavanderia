<?php
    include_once "../common/functions.php";
    authIndex();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <div class="container">
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
        <form action="../utilities/loginhandle.php" method="post" autocomplete="off">
            <label for="username">Username</label>
            <br>
            <input type="text" name="username" id="username" placeholder="Inserisci l'username" required>
            <br><br>
            <label for="password">Password</label>
            <br>
            <input type="password" name="password" id="password" placeholder="Inserisci la password" required>
            <br><br>
            <input type="reset" value="Reset">
            <br><br>
            <input type="submit" value="Login">
        </form>
        <br>
        <form action="../index.php" method="post">
            <input type="submit" style="background-color: steelblue;" value="Torna alla home"> <!--#015c91-->
        </form>
    </div>
    <script src="../script.js"></script>
</body>
</html>