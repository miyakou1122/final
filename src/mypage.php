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
        <div class="user_info">
            <p><span class="user_info_caption">マイページ</span></p>
            <p><a href="user_info.php" class="user_info_item">情報確認・変更</a></p>
            <p><a href="parts/logout.php" class="user_info_item">ログアウト</a></p>
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