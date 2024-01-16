<?php
session_start();
require 'parts/DB_connect.php';
if (isset($_POST['hantei'])) {
    if (isset($error)) {
        $error = '';
    }
    $user_id = $_SESSION['user']['user_id'];
    $new_pass = $_POST['new_pass'];
    $new_pass_conf = $_POST['new_pass_conf'];
    if (!($new_pass === $new_pass_conf)) {
        $error = '確認のパスワードが一致しません';
    } else {
        $pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);
        $pass_update = $pdo->prepare('UPDATE MEMO_user SET user_pass=? WHERE user_id=?');
        $pass_update->execute([
            $pass_hash,
            $user_id
        ]);
        $redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/mypage.php';
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
        <div class="pass_change">
            <span class="user_info_caption">パスワード変更</span>
            <center>
                <div class="user_info-form">
                    <p>
                    <form action="pass_change.php" method="post">
                        <span>新しいパスワード</span><br>
                        <input type="password" class="user_info-textbox" name="new_pass" placeholder="新しいパスワード"
                            required><br>
                        <span>確認のためもう一度</span><br>
                        <input type="password" class="user_info-textbox" name="new_pass_conf" maxlength="100"
                            placeholder="確認のためもう一度" required></p>
                        <p>
                            <?php
                            if ((isset($error))) {
                                echo '<span class="login-error">', $error, '</span><br>';
                            }
                            ?>
                        </p>
                        <input type="hidden" name="hantei" value=0>
                        <button type="submit" class="user_info-button">変更</button>
                    </form>
                    <p>
                    <form action="mypage.php" method="post">
                        <button type="submit" class="user_info-button">戻る</button>
                    </form>
                    </p>
                </div>
            </center>
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