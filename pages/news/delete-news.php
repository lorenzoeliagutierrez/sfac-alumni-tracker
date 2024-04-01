<?php
include '../../includes/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newsId = $_POST["news_id"];

    $sql = "DELETE FROM tbl_news WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $newsId);

    if ($stmt->execute()) {
        echo "<script language=javascript>alert('News deleted successfully!')</script>";
        echo "<script> document.location='news-display.php' </script>";
    } else {
        echo "<script language=javascript>alert('News deletion unsuccessful.')</script>";
        echo "<script> document.location='news-display.php' </script>";
    }

    $stmt->close();
}
?>
