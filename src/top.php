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
            <?php
            $user_id = $_SESSION['user']['user_id'];
            $sql = $pdo->prepare('SELECT * FROM MEMO_memo WHERE author_id=? ORDER BY update_date DESC');
            $sql->execute([
                $user_id
            ]);
            if ($sql->rowCount() === 0) {
                echo '<p>作成されたメモがありません<p>';
            } else {
                ?>
                <p>
                <table class="memo_list_table">
                    <tr>
                        <th>作成済みのメモ</th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($sql as $row) {
                        $memo_id = $row['memo_id'];
                        echo '<tr>';
                        echo '<td><a href="memo_detail.php?id=', $memo_id, '">';
                        echo $row['memo_title'];
                        echo '</td>';
                        $count++;
                        if ($count >= 5) {
                            echo '<tr>';
                            echo '<td><a href ="memo_list.php" class = "memo_list_all">全てのメモ</a></td>';
                            break;
                        }
                    }
                    echo '</table>';
                    echo '</p>';
            }
            ?>
        </div>
        <hr>
        <p>
        <div class="tag_list">
            <?php
            $user_id = $_SESSION['user']['user_id'];
            $sql = $pdo->prepare('SELECT * FROM MEMO_tag_list WHERE user_id=? ORDER BY tag_id DESC');
            $sql->execute([
                $user_id
            ]);
            if ($sql->rowCount() === 0) {
                echo '<p>作成されたタグがありません<p>';
            } else {
                ?>
                <table class="tag_list_table">
                    <tr>
                        <th>作成済みのタグ</th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($sql as $row) {
                        $tag_id = $row['tag_id'];
                        echo '<tr>';
                        echo '<td><a href="#">';
                        echo '<a href="tag_detail.php?id=', $tag_id, '">', $row['tag_name'], '</a>';
                        echo '</a></td>';
                        echo '</tr>';
                        $count++;
                        if ($count >= 5) {
                            echo '<tr>';
                            echo '<td><a href ="tag_list.php" class = "memo_list_all">全てのタグ</a></td>';
                            break;
                        }
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