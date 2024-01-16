<?php
session_start();
require 'parts/DB_connect.php';
$memo_id=0;
$hantei=0;
// echo $_POST['memo_id'];
if (isset($_POST['memo_id'])) {
    $memo_id = $_POST['memo_id'];
}
if (isset($_SESSION['tag_link_delete']['memo_id'])) {
    $memo_id = $_SESSION['tag_link_delete']['memo_id'];
    $hantei = $_SESSION['tag_link_delete']['memo_id'];
    unset($_SESSION['tag_link_delete']);
}



if (isset($_POST['update_judge'])) {
    if ($_POST['update_judge'] == 1) {
        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
        } else {
            $title = 'タイトルなし';
        }
        $content = $_POST['content'];
        $user_id = $_SESSION['user']['user_id'];
        $update_date = date('Y-m-d H:i:s');
        $sql_update = $pdo->prepare('UPDATE MEMO_memo SET memo_title=?,memo_content=?,update_date=?,update_id=? WHERE memo_id=?');
        $sql_update->execute([
            $title,
            $content,
            $update_date,
            $user_id,
            $memo_id
        ]);
        $redirect_url = 'https://aso2201203.babyblue.jp/php2/final/src/memo_detail.php?id=' . $_POST['memo_id'];
        header("Location: $redirect_url");
        exit();
    }
    if ($_POST['update_judge'] == 2) {
        $memo_id = $_POST['memo_id'];
        $tag_add = $_POST['tag_add'];
        $sql_hantei = $pdo->prepare('SELECT * FROM MEMO_tag_link WHERE tag_id=? AND memo_id=?');
        $sql_hantei->execute([
            $tag_add,
            $memo_id
        ]);
        if ($sql_hantei->rowCount() === 0) {
            $sql = $pdo->prepare('INSERT INTO MEMO_tag_link (tag_id,memo_id) VALUES(?,?)');
            $sql->execute([
                $tag_add,
                $memo_id
            ]);
        }
    }
}

require 'parts/head.php';
require 'parts/header.php';
require 'parts/side.php';
?>
<div class="content">
    <?php
    
    // echo $hantei."遷移元メモID<br>";
    // echo $memo_id."現在メモID";
    if (isset($_SESSION['user'])) {
        ?>
        <div class="memo_update">
            <div class="memo_update-form">
                <form action="memo_update.php" method="post">
                    <?php
                    $update_judge = 0;
                    if (isset($_POST['memo_id'])) {
                        $memo_id = $_POST['memo_id'];
                    }
                    $sql_memo = $pdo->prepare('SELECT * FROM MEMO_memo WHERE memo_id=?');
                    $sql_memo->execute([$memo_id]);
                    foreach ($sql_memo as $row) {
                        $memo_title = $row['memo_title'];
                        $memo_content = $row['memo_content'];
                    }
                    echo '<span>タイトル</span><br>';
                    echo '<input type="text" name="title" class="memo_update-textbox" placeholder="最大20文字" maxlength="20" value="', $memo_title, '"><br>';
                    echo '<span>内容</span><br>';
                    echo '<textarea name="content" class="memo_update-textarea" placeholder="最大2000文字" maxlength="2000" required>', $memo_content, '</textarea><br>';
                    $update_judge = 1;
                    echo '<input type="hidden" name = "memo_id" value=', $memo_id, '>';
                    echo '<input type="hidden" name = "update_judge" value="', $update_judge, '">';
                    ?>
                    <button type="submit" class="memo_update-button">更新</button>
                </form>
            </div>
            <?php
            require 'parts/detail_info.php';
            ?>
            <p>タグの追加</p>
            <?php
            $sql_tag = $pdo->prepare('SELECT * FROM MEMO_tag_list WHERE user_id=?');
            $sql_tag->execute([$user_id]);
            if ($sql_tag->rowCount() === 0) {
                echo 'タグがありません';
            } else {
                echo '<form action="memo_update.php" method="post">';
                echo '<p><select id="tag_add" name="tag_add">';
                foreach ($sql_tag as $row_tag) {
                    $tag_id = $row_tag['tag_id'];
                    $tag_name = $row_tag['tag_name'];
                    echo '<option value=', $tag_id, '>', $tag_name, '</option>';
                }
                echo '</select></p>';
                $update_judge = 2;
                echo '<input type="hidden" name = "memo_id" value=', $memo_id, '>';
                echo '<input type="hidden" name = "update_judge" value="', $update_judge, '">';
                echo '<p><button type="submit">追加</button></p>';
                echo '</form>';
            }
            echo '</div>';
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