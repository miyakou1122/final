<?php
session_start();
require 'parts/DB_connect.php';
unset($_SESSION['user']);
$error = '';
if (isset($_POST['login_mail'])) {
    $login_mail = $_POST['login_mail'];
    $login_pass = $_POST['login_pass'];
    $sql = $pdo->prepare('SELECT * FROM MEMO_user WHERE user_mail=?');
    $sql->execute([$login_mail]);
    if ($sql->rowCount() === 0) {
        $error = 'メールアドレスかパスワードが間違っていますa';
    } else {
        foreach ($sql as $row) {
            if (password_verify($login_pass, $row['user_pass'])) {
                $_SESSION['user'] = [
                    'user_id' => $row['user_id'],
                    'user_name' => $row['user_name'],
                    'user_mail' => $row['user_mail']
                ];
                $redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/top.php';
                header("Location: $redirect_url");
                exit();
            } else {
                $error = 'メールアドレスかパスワードが間違っていますb';
            }
        }
    }
}
?>
<?php
require 'parts/head.php';
require 'parts/header_login.php';
?>
<center>
    <p>
    <div id="heading">
        <span>ログイン</span>
    </div>
    </p>
    <p>
    <div class="login-form">
        <form action="login.php" method="post">
            <span>メールアドレス</span>
            <input type="email" name="login_mail" class="login-textbox" required><br>
            <span>パスワード</span>
            <input type="password" name="login_pass" class="login-textbox" required><br>
            <?php
            if (isset($error)) {
                echo '<span class="signup-error">', $error, '</span><br>';
            }
            ?>
            <button type="submit" class="login-button">ログイン</button>
        </form>
    </div>
    <span>登録がまだの方</span><br>
    <a href="signup.php"><span>新規登録はこちら</span></a>
    </p>
</center>
<?php
require 'parts/foot.php';
?>