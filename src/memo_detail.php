<?php
session_start();
require 'parts/DB_connect.php';
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<?php

if (isset($_GET['id'])) {
    ?>
    <div class="content">
        <?php
        if (isset($_SESSION['user'])) {
            ?>
            <div class="memo_detail">
                <div class="memo_detail_form">
                    <center>
                        <?php
                        $memo_id = $_GET['id'];
                        $sql = $pdo->prepare('SELECT * FROM MEMO_memo WHERE memo_id=?');
                        $sql->execute([$memo_id]);
                        foreach ($sql as $row) {
                            echo '<p><div class="detail_title"><span>', $row['memo_title'], '</span></div></p>';
                            echo '<p><div class="detail_content"><span>', $row['memo_content'], '</span></div></p>';
                        }
                        ?>
                    </center>
                </div>
                <?php
                require 'parts/detail_info.php';
                echo '<div class = "memo_update_delete_button">';
                echo '<form action="memo_update.php" method="post">';
                echo '<input type="text" name="memo_id" value=', $memo_id, ' hidden>';
                echo '<button type="submit" class="memo_detail-button">更新</button>';
                echo '</form>';
                echo '<form action="memo_delete.php" method="post">';
                echo '<input type="text" name="memo_id" value="', $memo_id, '" hidden>';
                echo '<button type="submit" class="memo_detail-button">削除</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                ?>
            </div>
            <?php
        } else {
            echo 'error';
        }
        ?>
        <?php
} else {
    echo 'error';
}
?>
</div>
<?php
require 'parts/foot.php';
?>