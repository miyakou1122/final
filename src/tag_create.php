<?php
session_start();
require 'parts/DB_connect.php';
if(isset($_POST['tag_name'])){
    $tag_name = $_POST['tag_name'];
    $user_id = $_SESSION['user']['user_id'];
    $sql = $pdo->prepare('INSERT INTO MEMO_tag_list (tag_name,user_id) VALUES(?,?)');
    $sql->execute([
        $tag_name,
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
    <div class="tag_create-form">
        <form action="tag_create.php" method="post">
            <span>タグ名</span><br>
            <input type="text" name="tag_name" class="tag_create-textbox" placeholder="最大20文字" maxlength="20" required>
            <button type="submit" class="tag_create-button">作成</button>
    </div>
</div>
<?php
require 'parts/foot.php';
?>