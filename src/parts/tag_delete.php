<?php
session_start();
require 'DB_connect.php';
$tag_id = $_POST['tag_id'];
$page_name = $_POST['page_name'];
$sql_delete = $pdo->prepare('DELETE FROM MEMO_tag_link WHERE tag_id=?');
$sql_delete->execute([$tag_id]);
$sql_delete = $pdo->prepare('DELETE FROM MEMO_tag_list WHERE tag_id=?');
$sql_delete->execute([$tag_id]);
$redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/'.$page_name;
header("Location: $redirect_url");
exit();
?>