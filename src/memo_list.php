<?php
session_start();
require 'parts/DB_connect.php';
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<div class="content">
    <?php
    if (isset($_SESSION['user'])) {
        ?>
        <div class="memo_list">
            <span class="memo_list_caption">メモ一覧</span>
            <?php
            $user_id = $_SESSION['user']['user_id'];
            $sql = $pdo->prepare('SELECT * FROM MEMO_memo WHERE author_id=?');
            $sql->execute([
                $user_id
            ]);
            if ($sql->rowCount() === 0) {
                echo '<p>作成されたメモがありません<p>';
            } else {
                ?>
                <table class="memo_list_table">
                    <tr>
                        <th>メモタイトル</th>
                        <th>作成日</th>
                        <th>更新日</th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($sql as $row) {
                        $memo_id = $row['memo_id'];
                        echo '<tr>';
                        echo '<td><a href="memo_detail.php?id=', $memo_id, '">';
                        echo $row['memo_title'];
                        echo '</a></td>';
                        echo '<td>', $row['created_date'], '</td>';
                        echo '<td>', $row['update_date'], '</td>';
                        echo '</tr>';
                    }
            }
            ?>
        </div>
        <?php
    } else {
        echo 'error';
    }
    ?>
</div>
<?php
require 'parts/foot.php';
?>