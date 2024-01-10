<?php
session_start();
require 'parts/DB_connect.php';
$tag_id = $_POST['tag_id'];
if (isset($_POST['hantei'])) {
    $tag_name = $_POST['tag_name'];
    $sql_update = $pdo->prepare('UPDATE MEMO_tag_list SET tag_name=? WHERE tag_id=?');
        $sql_update->execute([
            $tag_name,
            $tag_id
        ]);
    $redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/tag_list.php';
    header("Location: $redirect_url");
    exit();
}
require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<div class="content">
    <div class="tag_update-form">
        <form action="tag_update.php" method="post">
            <span>タグ名</span><br>
            <?php
            $sql = $pdo->prepare('SELECT * FROM MEMO_tag_list WHERE tag_id=?');
            $sql->execute([
                $tag_id
            ]);
            foreach ($sql as $row) {
                $tag_name = $row['tag_name'];
            }
            echo '<input type="text" name="tag_name" class="tag_update-textbox" placeholder="最大20文字" maxlength="20" value="',$tag_name,'" required>';
            echo '<input type="hidden" name="tag_id" value=',$tag_id,'>';
            ?>
            <input type="hidden" name="hantei" value="0">
            <button type="submit" class="tag_update-button">更新</button>
    </div>
</div>
<?php
require 'parts/foot.php';
?>