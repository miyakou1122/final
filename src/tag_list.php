<?php
session_start();
require 'parts/DB_connect.php';
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<div class="content">
    <div class="tag_list">
        <span class="tag_list_caption">タグ一覧</span>
        <?php
        $user_id = $_SESSION['user']['user_id'];
        $sql = $pdo->prepare('SELECT * FROM MEMO_tag_list WHERE user_id=?');
        $sql->execute([
            $user_id
        ]);
        if ($sql->rowCount() === 0) {
            echo '<p>作成されたタグがありません<p>';
        } else {
            ?>
            <table class="tag_list_table">
                <tr>
                    <th>タグ名</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                $count = 0;
                foreach ($sql as $row) {
                    $tag_id = $row['tag_id'];
                    echo '<tr>';
                    echo '<td><a href="#">';
                    echo '<a href="tag_detail.php?id=', $tag_id, '">',$row['tag_name'],'</a>';
                    echo '</a></td>';
                    echo '<td>';
                    echo '<form action="tag_update.php" method="post">';
                    echo '<input type="hidden" name="tag_id" value=',$tag_id,'>';
                    echo '<button type="submit" class="tag_list-button">更新</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '<td>';
                    echo '<form action="parts/tag_delete.php" method="post">';
                    echo '<input type="hidden" name="tag_id" value=',$tag_id,'>';
                    echo '<input type="hidden" name="page_name" value="tag_list.php">';
                    echo '<button type="submit" class="tag_list-button">削除</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
        }
        ?>
    </div>
</div>
<?php
require 'parts/foot.php';
?>