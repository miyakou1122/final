<?php
    const SERVER = 'mysql219.phy.lolipop.lan';
    const DBNAME = 'LAA1516811-final';
    const USER = 'LAA1516811';
    const PASS = 'Pass1122';
    $connect = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8';
    $pdo = new PDO($connect, USER, PASS);
?>