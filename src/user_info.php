<?php
session_start();
require 'parts/DB_connect.php';
if (isset($_POST['hantei'])) {
    unset($_SESSION['user']);
    $redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/login.php';
    header("Location: $redirect_url");
    exit();
}
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<div class="content">
    <div class="user_info">
        <p><span class="user_info_caption">マイページ</span>
        </p>
        <p><span class="user_info_item">情報変更</span><br>
        <form method="POST" name="hantei" action="">
            <input type="name" name="hantei" value="0" hidden>
            <a href="user_info.php" onclick="user_info.php"><span class="user_info_item">ログアウト</span></a>
        </form>
        </p>
    </div>
</div>
<?php
require 'parts/foot.php';
?>