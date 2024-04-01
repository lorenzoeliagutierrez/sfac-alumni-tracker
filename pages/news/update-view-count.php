<?php

require_once '../../includes/conn.php';

if (isset($_GET['id'])) {
    $newsId = (int)$_GET['id'];

    $db->query("UPDATE tbl_news SET view_count = view_count + 1 WHERE id = $newsId");
}