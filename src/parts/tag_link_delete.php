<?php
session_start();
require 'DB_connect.php';
if (isset($_SESSION['tag_link_delete'])) {
    unset($_SESSION['tag_link_delete']);
}
$tag_id = $_POST['tag_id'];
$memo_id = $_POST['memo_id'];
$page_name = $_POST['page_name'];
$_SESSION['tag_link_delete']['memo_id'] = $memo_id;
$sql_delete = $pdo->prepare('DELETE FROM MEMO_tag_link WHERE tag_id=? AND memo_id=?');
$sql_delete->execute([$tag_id, $memo_id]);

// var_dump($page_name);

$redirect_url = $page_name;
header("Location: ". $redirect_url);
// header("Location: https://aso2201203.babyblue.jp/php2/final/src/memo_detail.php?id=27");
exit();
?>