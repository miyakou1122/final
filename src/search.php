<?php
session_start();
require 'parts/DB_connect.php';
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<div class="content">
    <?php
    $user_id = $_SESSION['user']['user_id'];
    if (isset($_SESSION['user'])) {
        ?>
        <div class="search">
            <?php
            $search = $_POST['search'];
            echo '<p><span class="search_caption">',$search,'の検索結果</span></p>';
            echo "<hr>";
            $sql_memo = $pdo->prepare('SELECT * FROM MEMO_memo WHERE author_id = ? AND (memo_title LIKE ? OR memo_content LIKE ?)');
            $sql_memo->execute([
                $user_id,
                "%$search%",
                "%$search%"
            ]);
            if ($sql_memo->rowCount() === 0) {
                echo '<p><span class = "search_error">一致するメモがありません</span></p>';
            } else {
                echo '<table class="search_list_table">';
                echo '<tr><th>メモタイトル</th></tr>';
                foreach ($sql_memo as $row_memo) {
                    $memo_id = $row_memo['memo_id'];
                    echo '<tr>';
                    echo '<td><a href="memo_detail.php?id=', $memo_id, '">';
                    echo $row_memo['memo_title'];
                    echo '</td>';
                }
                echo '</table>';
            }
            echo "<hr>";
            $sql_tag = $pdo->prepare('SELECT * FROM MEMO_tag_list WHERE user_id = ? AND tag_name LIKE ?');
            $sql_tag->execute([
                $user_id,
                "%$search%",
            ]);
            if ($sql_tag->rowCount() === 0) {
                echo '<p><span class = "search_error">一致するタグがありません</span></p>';
            } else {
                echo '<table class="search_list_table">';
                echo '<tr><th>タグ名</th></tr>';
                foreach ($sql_tag as $row_tag) {
                    $tag_id = $row_tag['tag_id'];
                    echo '<tr>';
                    echo '<td><a href="tag_detail.php?id=', $tag_id, '">';
                    echo $row_tag['tag_name'];
                    echo '</td>';
                }
                echo '</table>';
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