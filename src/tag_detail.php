<?php
session_start();
require 'parts/DB_connect.php';
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
$tag_id = $_GET['id'];
$sql = $pdo->prepare('SELECT * FROM MEMO_tag_list WHERE tag_id=?');
$sql->execute([
    $tag_id
]);
foreach ($sql as $row) {
    $tag_name = $row['tag_name'];
}
?>
<div class="content">
    <div class="tag_detail">
        <span class="tag_detail_caption">
            <?php echo $tag_name; ?>
        </span>
        <table class="tag_detail_table">
            <?php
            echo '<th>追加済みのメモ</th><th></th><th></th>';

            $sql_tag = $pdo->prepare('SELECT * FROM MEMO_tag_link WHERE tag_id=?');
            $sql_tag->execute([$tag_id]);
            if ($sql_tag->rowCount() === 0) {
                echo '<tr><td>追加済みのメモがありません</td>';
            } else {
                foreach ($sql_tag as $row_tag) {
                    $memo_id = $row_tag['memo_id'];
                    $sql_memo_tilte = $pdo->prepare('SELECT * FROM MEMO_memo WHERE memo_id=?');
                    $sql_memo_tilte->execute([$memo_id]);
                    foreach ($sql_memo_tilte as $row_memo_tilte) {
                        $memo_title = $row_memo_tilte['memo_title'];
                        echo '<tr><td><span>', $memo_title, '</span></td>';
                        echo '<td><form action="memo_update.php" method="post">';
                        echo '<input type="text" name="memo_id" value="', $memo_id, '" hidden>';
                        echo '<button type="submit" class="memo_detail-button">更新</button>';
                        echo '</form></td>';
                        echo '<td><form action="memo_delete.php" method="post">';
                        echo '<input type="text" name="memo_id" value="', $memo_id, '" hidden>';
                        echo '<button type="submit" class="memo_detail-button">削除</button>';
                        echo '</form></td>';
                    }
                }
            }
            ?>
        </table>
    </div>
</div>
<?php
require 'parts/foot.php';
?>