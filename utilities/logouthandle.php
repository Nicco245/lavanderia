<?php
    session_start();
    include_once "../common/functions.php";
    auth();
    session_unset();
    $_SESSION = [];
    session_destroy();
    $msg = urlencode("Logout effettuato!");
    header("Location: ../index.php?msg=".$msg);
    exit();
?>