<?php
session_start();
require 'parts/DB_connect.php';
if (isset($_POST['hantei'])) {
    $share_id = $_POST['share_id'];
    $share_pass = $_POST['share_pass'];
    $error = '';
    $sql_share = $pdo->prepare('SELECT * FROM MEMO_share WHERE share_id=? AND share_pass = ?');
    $sql_share->execute([
        $share_id,
        $share_pass
    ]);
    if ($sql_share->rowCount() === 0) {
        $error = '共有IDまたはパスワードが間違っています';
    } else {
        foreach ($sql_share as $row_share) {
            $memo_id = $row_share['memo_id'];
        }
        $_SESSION['share']['memo_id'] = $memo_id;
        $redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/memo_detail.php?id='.$memo_id;
        header("Location: $redirect_url");
        exit();
    }
}
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<div class="content">
    <?php
    if (isset($_SESSION['user'])) {
        ?>
        <div class="tag_create-form">
            <form action="share_check.php" method="post">
                <span>共有ID</span><br>
                <input type="number" name="share_id" class="tag_create-textbox" placeholder="共有ID(数字のみ)" required><br>
                <span>共有パスワード</span><br>
                <input type="text" name="share_pass" class="tag_create-textbox" placeholder="共有パスワード" required>
                <input type="hidden" name="hantei" value="0">
                <?php
                if (isset($error)) {
                    echo '<br><span class="signup-error">', $error, '</span><br>';
                }
                ?>
                <button type="submit" class="tag_create-button">閲覧</button>
            </form>
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