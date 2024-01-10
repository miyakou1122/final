<?php
session_start();
unset($_SESSION['user']);
$redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/login.php';
header("Location: $redirect_url");
exit();
?>
