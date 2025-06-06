<?php
    include_once "./common/functions.php";
    authIndex();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
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
    <div class="container">
        <h3>Ciao benvenuto nella mia lavanderia!<br>Fai il login.<br>🫧👕🚿</h3>
        <br>
        <form action="./pages/login.php" method="post">
            <input type="submit" value="Login">
        </form>
    </div>
    <script src="./script.js"></script>
</body>
</html>