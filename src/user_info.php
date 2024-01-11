<?php
session_start();
require 'parts/DB_connect.php';
if (isset($_POST['hantei'])) {
    $user_name = $_POST['user_name'];
    $user_mail = $_POST['user_mail'];
    $user_id = $_SESSION['user']['user_id'];
    $error = '';
    $sql = $pdo->prepare('SELECT * FROM MEMO_user WHERE user_mail=?');
    $sql->execute([$user_mail]);
    if (!($sql->rowCount() === 0)) {
        $error = 'メールアドレスが既に使われています';
    } else {
        $sql_update = $pdo->prepare('UPDATE MEMO_user SET user_name=?, user_mail=? WHERE user_id=?');
        $sql_update->execute([
            $user_name,
            $user_mail,
            $user_id
        ]);
    }
}
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<div class="content">
        <?php
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user']['user_id'];
            $sql = $pdo->prepare('SELECT * FROM MEMO_user WHERE user_id=?');
            $sql->execute([
                $user_id
            ]);
            foreach ($sql as $row) {
                $user_name = $row['user_name'];
                $user_mail = $row['user_mail'];
            }
            ?>
            <div class="user_info">
                <span class="user_info_caption">情報確認・変更</span>
                <center>
                <div class="user_info-form">
                    <p>
                    <form action="user_info.php" method="post">
                        <span>ユーザー名</span><br>
                        <input type="text" class="user_info-textbox" name="user_name" maxlength="50" placeholder="最大50文字"
                            value="<?php echo $user_name; ?>" required><br>
                        <span>メールアドレス</span><br>
                        <input type="email" class="user_info-textbox" name="user_mail" maxlength="100" placeholder="最大100文字"
                            value="<?php echo $user_mail; ?>" required></p>
                        <p>
                            <?php
                            if ((isset($error))) {
                                echo '<span class="login-error">', $error, '</span><br>';
                            }
                            ?>
                        </p>
                        <input type="hidden" name="hantei" value=0>
                        <button type="submit" class="user_info-button">更新</button>
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