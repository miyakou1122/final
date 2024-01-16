<div class="memo_detail_info_form">
    <?php
    
    echo '<p><span>詳細情報</span></p>';
    echo '<p><span>最終更新日：<br>', $row['update_date'], '</span></p>';
    echo '<p><span>タグ一覧</span></p>';
    $sql_tag = $pdo->prepare('SELECT * FROM MEMO_tag_link WHERE memo_id=?');
    $sql_tag->execute([$memo_id]);
    if ($sql_tag->rowCount() === 0) {
        echo 'タグがありません';
    } else {
        echo '<table>';
        echo '<th></th><th></th>';

        foreach ($sql_tag as $row_tag) {
            $sql_tag_name = $pdo->prepare('SELECT * FROM MEMO_tag_list WHERE tag_id=?');
            $sql_tag_name->execute([$row_tag['tag_id']]);
            $tag_id = $row_tag['tag_id'];
            foreach ($sql_tag_name as $row_tag_name) {
                echo '<tr>';
                echo '<td>', $row_tag_name['tag_name'], '</td>';
                echo '<td>';
                echo '<form action="parts/tag_link_delete.php" method="post">';
                echo '<input type=hidden name="tag_id" value=', $tag_id, '>';
                echo '<input type="hidden" name="memo_id" value=', $memo_id, '>';
                echo '<input type="hidden" name="page_name" class="urlTextbox" value="">'; // クラスに変更
                echo '<button type="submit" class="">削除</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';

    }

    echo '</table>';
    echo '<script defer>';
    echo 'window.onload = function () {';
    echo 'var currentURL = window.location.href;';
    echo 'var urlTextboxElements = document.getElementsByClassName("urlTextbox");';
    echo 'for (var i = 0; i < urlTextboxElements.length; i++) {';
    echo 'urlTextboxElements[i].value = currentURL;';
    echo '}';
    echo '};';
    echo '</script>';
    ?>