<?php
session_start();
require 'parts/DB_connect.php';
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<?php

?>
<div class="content">
    <?php
    if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['user_id'];
        $memo_id = $_GET['id'];
        $sql_user = $pdo->prepare('SELECT * FROM MEMO_memo WHERE author_id=? AND memo_id=?');
        $sql_user->execute([
            $user_id,
            $memo_id
        ]);
        if (!($sql_user->rowCount() === 0)) {
            ?>
            <div class="memo_detail">
                <div class="memo_detail_form">
                    <center>
                        <?php
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
                echo '<form action="memo_share.php" method="post">';
                echo '<input type="text" name="memo_id" value="', $memo_id, '" hidden>';
                echo '<button type="submit" class="memo_detail-button">共有</button>';
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
            if (isset($_SESSION['share']['memo_id'])) {
                $share_memo_id = $_SESSION['share']['memo_id'];
                unset($_SESSION['share']['memo_id']);
                if ($share_memo_id == $memo_id) {
                    ?>
                    <div class="memo_detail">
                        <div class="memo_detail_form">
                            <center>
                                <?php
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
                        require 'parts/detail_info_share.php';
                        ?>
                    </div>
                    <?php
                }
            }
        }
    } else {
        echo 'error';
    }
    ?>
    <?php
    ?>
</div>
<?php
require 'parts/foot.php';
?>