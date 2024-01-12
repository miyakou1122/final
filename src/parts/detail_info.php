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
            $tag_id = $row_tag['tag_id'];
            echo '<table>';
            echo '<th></th>';
            foreach ($sql_tag_name as $row_tag_name) {
                echo '<tr>';
                echo '<td>', $row_tag_name['tag_name'], '</td>';
                echo '<td>';
                echo '<form action="parts/tag_link_delete.php" method="post">';
                echo '<input type=hidden name="tag_id" value=', $tag_id, '>';
                echo '<input type=hidden name="memo_id" value=', $memo_id, '>';
                echo '<input type=hidden name="page_name" id="urlTextbox">';
                echo '<button type="submit" class="">削除</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo $memo_id;
        }
    }
    ?>
    <script>
        var currentURL = window.location.href;
        document.getElementById('urlTextbox').value = currentURL;
    </script>