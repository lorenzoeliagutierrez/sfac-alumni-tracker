<?php
include '../../includes/conn.php';
include '../../includes/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    $image_filename = "";
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowed_extensions = ['gif', 'jpeg', 'jpg', 'png'];
        $upload_dir = "newsimages/";
        $image_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        if (in_array($image_extension, $allowed_extensions)) {
            $image_filename = uniqid() . "_" . $_FILES["image"]["name"];
            move_uploaded_file($_FILES["image"]["tmp_name"], $upload_dir . $image_filename);
        } else {
            echo "<script>alert('Invalid file type. Please upload a .gif, .jpeg, .jpg, or .png file.')</script>";
        }
    }

    $sql = "INSERT INTO tbl_news (title, content, image_filename) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sss", $title, $content, $image_filename);
    
    if ($stmt->execute()) {
        $_SESSION['news_added'] = 'News Posted Successfully!';
        header("location: news-form.php");
    } else {
        echo "<script language=javascript>alert('News post unsuccessful.')</script>";
        echo "<script> document.location='news-display.php' </script>";
    }

    $stmt->close();
}
?>