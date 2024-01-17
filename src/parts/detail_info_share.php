<div class="memo_detail_info_form">
    <?php

    echo '<p><span>詳細情報</span></p>';
    $sql_name = $pdo->prepare('SELECT * FROM MEMO_user WHERE user_id=?');
    $user_id = $row['author_id'];
    $sql_name->execute([
        $user_id
    ]);
    foreach($sql_name as $row_name){
        $user_name = $row_name['user_name'];
    }
    echo '<p><span>作成者：<br>', $user_name, '</span></p>';
    echo '<p><span>最終更新日：<br>', $row['update_date'], '</span></p>';
    ?>