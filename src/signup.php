<?php
require 'parts/DB_connect.php';
$error = '';
$judgment = 0;
if (isset($_POST['user_pass'])) {
    $user_name = $_POST['user_name'];
    $user_mail = $_POST['user_mail'];
    $user_pass = $_POST['user_pass'];
    $user_pass_con = $_POST['user_pass_con'];
    $sql = $pdo->prepare('SELECT * FROM MEMO_user WHERE user_mail=?');
    $sql->execute([$user_mail]);
    if (!($sql->rowCount() === 0)) {
        $error = 'メールアドレスが既に使われています';
        $judgment = 1;
    }
    if (!($user_pass === $user_pass_con)) {
        if ($judgment === 1) {
            $error = $error . '<br>';
        }
        $error = $error . '確認のパスワードが一致しません';
        $judgment = 1;
    }
    $pass_hash = password_hash($user_pass, PASSWORD_DEFAULT);
    if ($judgment === 0) {
        $sql_insert = $pdo->prepare('INSERT INTO MEMO_user (user_name,user_mail,user_pass) VALUES(?,?,?)');
        $sql_insert->execute([
            $user_name,
            $user_mail,
            $pass_hash
        ]);
        $sql = $pdo->prepare('SELECT * FROM MEMO_user WHERE user_mail=?');
        $sql->execute([$user_mail]);
        if (!($sql->rowCount() === 0)) {
            $redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/login.php';
            header("Location: $redirect_url");
            exit();
        }
    }
}
require 'parts/head.php';
require 'parts/header_login.php';
?>
<center>
    <p>
    <div id="heading">
        <span>新規登録</span>
    </div>
    </p>
    <p>
    <div class="signup-form">
        <form action="signup.php" method="post">
            <span>ユーザー名</span><br>
            <input type="text" class="signup-textbox" name="user_name" maxlength="50" placeholder="最大50文字" required><br>
            <span>メールアドレス</span><br>
            <input type="email" class="signup-textbox" name="user_mail" maxlength="100" placeholder="最大100文字"
                required><br>
            <span>パスワード</span><br>
            <input type="password" class="signup-textbox" name="user_pass" maxlength="8" placeholder="最大8文字"
                required><br>
            <span>確認のためもう一度</span><br>
            <input type="password" class="signup-textbox" name="user_pass_con" maxlength="8" placeholder="最大8文字"
                required><br>
            <?php
            if ((isset($error))) {
                echo '<span class="login-error">', $error, '</span><br>';
            }
            ?>
            <button type="submit" class="signup-button">登録</button>
        </form>
        <p>
        <form action="login.php" method="post">
            <button type="submit" class="signup-button">戻る</button>
        </form>
        </p>
    </div>
    </p>
</center>

<?php
require 'parts/foot.php';
?>