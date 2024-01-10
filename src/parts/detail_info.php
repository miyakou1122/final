<div class="memo_detail_info_form">
    <?php
    echo '<p><span>詳細情報</span></p>';
    echo '<p><span>作成日時：', $row['created_date'], '</span></p>';
    echo '<p><span>更新日時：', $row['update_date'], '</span></p>';
    echo '<p><span>タグ一覧</span><p>';
    $sql_tag = $pdo->prepare('SELECT * FROM MEMO_tag_link WHERE memo_id=?');
    $sql_tag->execute([$memo_id]);
    if ($sql_tag->rowCount() === 0) {
        echo 'タグがありません';
    } else {
        foreach ($sql_tag as $row_tag) {
            $sql_tag_name = $pdo->prepare('SELECT * FROM MEMO_tag_list WHERE tag_id=?');
            $sql_tag_name->execute([$row_tag['tag_id']]);
            foreach ($sql_tag_name as $row_tag_name){
                echo '<span>',$row_tag_name['tag_name'],'</span><br>';
            }
        }
    }
    ?>