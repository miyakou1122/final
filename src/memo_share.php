<?php
session_start();
require 'parts/DB_connect.php';
if ($_POST['memo_id']) {
    $memo_id = $_POST['memo_id'];
}
if (isset($_POST['hantei'])) {
    $hantei = $_POST['hantei'];
    if ($hantei == 0) {
        $share_pass = $_POST['share_pass'];
        $memo_id = $_POST['memo_id'];
        // $pass_hash = password_hash($share_pass, PASSWORD_DEFAULT);
        $sql = $pdo->prepare('INSERT INTO MEMO_share (share_pass ,memo_id) VALUES(?,?) ');
        $sql->execute([
            $share_pass,
            $memo_id
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
        ?>
        <div class="memo_share">
            <form action="memo_share.php" method="post">
                <?php
                $sql = $pdo->prepare('SELECT * FROM MEMO_memo WHERE memo_id=?');
                $sql->execute([
                    $memo_id
                ]);
                foreach ($sql as $row) {
                    $memo_title = $row['memo_title'];
                }
                echo '<span>', $memo_title, '</span><br>';
                $sql_share = $pdo->prepare('SELECT * FROM MEMO_share WHERE memo_id=?');
                $sql_share->execute([
                    $memo_id
                ]);
                if ($sql_share->rowCount() === 0) {
                    ?>
                    <span>共有パスワード</span><br>
                    <input type="text" name="share_pass" class="memo_share-textbox" placeholder="共有パスワード" required>
                    <input type="hidden" name="memo_id" value=<?php echo $memo_id; ?>>
                    <input type="hidden" name="hantei" value="0">
                    <button type="submit" class="memo_share-button">発行</button>
                </form>
                <?php
                } else {
                    foreach ($sql_share as $row_share) {
                        $share_id = $row_share['share_id'];
                        $share_pass = $row_share['share_pass'];
                    }
                    echo '<span>共有ID</span><br>';
                    echo '<span>', $share_id, '</span><br>';
                    echo '<span>パスワード</span><br>';
                    echo '<span>', $share_pass, '</span><br>';

                }

                ?>
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