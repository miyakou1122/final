<aside>
    <?php
    if (isset($_SESSION['user'])) {
        ?>
        <p>
        <form action="search.php" method="post">
            <input type="text" name="search" class="search_textbox" placeholder="検索フォーム" required>
            <button type="submit">検索</button>
        </form>
        </p>
        <p>
            <a href="mypage">マイページ</a>
        </p>
        <hr>
        <a href="memo_create.php"><span class="side_caption">＋メモの作成</span></a>
        <ul class="side_ul">
            <?php
            $user_id = $_SESSION['user']['user_id'];
            $sql = $pdo->prepare('SELECT * FROM MEMO_memo WHERE author_id=? ORDER BY `update_date` DESC, `created_date` DESC');
            $sql->execute([$user_id]);

            if ($sql->rowCount() === 0) {
                echo '<li>メモがありません</li>';
            } else {
                $count = 0;
                foreach ($sql as $row) {
                    if ($count >= 3) {
                        break;
                    } else {
                        $memo_ids = $row['memo_id'];
                        echo '<li><a href="memo_detail.php?id=', $memo_ids, '">', $row['memo_title'], '</a></li>';
                        $count++;
                    }
                }
            }
            ?>
            <li><a href="memo_list.php"><span class="side_caption">全てのメモ</span></a></li>
        </ul>
        <hr>
        <a href="tag_create.php"><span class="side_caption">＋タグの作成</span></a>
        <ul class="side_ul">
            <?php
            $sql = $pdo->prepare('SELECT * FROM MEMO_tag_list WHERE user_id=? ORDER BY `tag_id` DESC');
            $sql->execute([$user_id]);
            if ($sql->rowCount() === 0) {
                echo '<li>タグがありません</li>';
            } else {
                $count = 0;
                foreach ($sql as $row) {
                    if ($count >= 3) {
                        break;
                    } else {
                        $tag_ids = $row['tag_id'];
                        echo '<li><a href="tag_detail.php?id=', $tag_ids, '">', $row['tag_name'], '</a></li>';
                        $count++;
                    }
                }
            }
            ?>
            <li><a href="tag_list.php"><span class="side_caption">全てのタグ</span></a></li>
        </ul>
        </p>
        <?php
    } else {
        echo 'error';
    }
    ?>
</aside>