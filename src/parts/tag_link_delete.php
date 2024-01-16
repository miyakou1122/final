<?php
session_start();
require 'DB_connect.php';
if (isset($_POST['tag_id']) && isset($_POST['memo_id']) && isset($_POST['page_name'])) {
    $tag_id = $_POST['tag_id'];
    $memo_id = $_POST['memo_id'];
    $page_name = $_POST['page_name'];
    $_SESSION['tag_link_delete']['memo_id'] = $memo_id;
    // echo $_SESSION['tag_link_delete']['memo_id'];
    // echo $memo_id;
    $sql_delete = $pdo->prepare('DELETE FROM MEMO_tag_link WHERE tag_id=? AND memo_id=?');
    $sql_delete->execute([$tag_id, $memo_id]);
    header("Location: " . $page_name);
    exit();
} else {
    echo "Error: Invalid input.";
}
?>