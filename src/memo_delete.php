<?php
session_start();
require 'parts/DB_connect.php';
$memo_id = $_POST['memo_id'];
if (isset($_POST['check'])) {
    $sql_delete = $pdo->prepare('DELETE FROM MEMO_tag_link WHERE memo_id=?');
    $sql_delete->execute([$_POST['memo_id']]);
    $sql_delete = $pdo->prepare('DELETE FROM MEMO_memo WHERE memo_id=?');
    $sql_delete->execute([$_POST['memo_id']]);
    $redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/top.php';
    header("Location: $redirect_url");
    exit();
}
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
$sql_memo = $pdo->prepare('SELECT * FROM MEMO_memo WHERE memo_id=?');
$sql_memo->execute([$_POST['memo_id']]);
foreach ($sql_memo as $row_memo) {
    $memo_title = $row_memo['memo_title'];
}
?>
<div class="content">
    <div class="memo_delete">
        <?php
        echo '<span class="memo_delete_sentence">本当に<span class="memo_delete_word">', $memo_title, '</span>を削除してもいいですか</span>';
        echo '<div class="delete_YES_NO_button">';
        echo '<form action="memo_delete.php" method="POST">';
        echo '<input type="hidden" name="memo_id" value="', $_POST['memo_id'], '">';
        echo '<input type="hidden" name="check" value="1">';
        echo '<button type="submit" class="memo_delete-button">削除</button>';
        echo '</form>';
        echo '<form action="memo_detail.php" method="GET">';
        echo '<input type="hidden" name="id" value="' . $_POST['memo_id'] . '">';
        echo '<button type="submit" class="memo_delete-button">戻る</button>';
        echo '</form>';
        ?>
    </div>
</div>
<?php
require 'parts/foot.php';
?>