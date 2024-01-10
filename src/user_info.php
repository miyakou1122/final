<?php
session_start();
require 'parts/DB_connect.php';
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<div class="content">
    <div class="user_info">
        <p><span class="user_info_caption">マイページ</span>
        </p>
        <p><span class="user_info_item">情報変更</span><br>
            <a href="parts/logout.php"><span class="user_info_item">ログアウト</span></a>
        </p>
    </div>
</div>
<?php
require 'parts/foot.php';
?>