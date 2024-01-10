<?php
session_start();
require 'parts/DB_connect.php';
if (isset($_POST['content'])) {
    if (!empty($_POST['title'])) {
        $title = $_POST['title'];
    } else {
        $title = 'タイトルなし';
    }

    $content = $_POST['content'];
    $user_id = $_SESSION['user']['user_id'];
    $created_date = date('Y-m-d H:i:s');
    $sql = $pdo->prepare('INSERT INTO MEMO_memo (memo_title,memo_content,created_date,author_id) VALUES(?,?,?,?)');
    $sql->execute([
        $title,
        $content,
        $created_date,
        $user_id
    ]);
    $redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/top.php';
    header("Location: $redirect_url");
    exit();
}
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<div class="content">
    <?php
    if (isset($_SESSION['user'])) {
        ?>
        <div class="memo_create-form">
            <form action="memo_create.php" method="post">
                <span>タイトル</span><br>
                <input type="test" name="title" class="memo_create-textbox" placeholder="最大20文字" maxlength="20"><br>
                <span>内容</span><br>
                <textarea name="content" class="memo_create-textarea" placeholder="最大2000文字" maxlength="2000"
                    required></textarea><br>
                <button type="submit" class="memo_create-button">作成</button>
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