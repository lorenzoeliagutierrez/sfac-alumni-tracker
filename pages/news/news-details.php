<?php
include '../../includes/conn.php';
include '../../includes/session.php';
include '../../includes/head.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Details</title>
    <style>
        .container {
            color: black;
            border: transparent;
            padding: 10px;
            border-radius: 10px;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        h2 {
            color: #333;
            margin: 10px;

        }

        img {
            width: 35%;
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin: 0 auto 10px;
            display: block;
        }

        p {
            font-size: 18px;
            margin: 10px;
            color: #555;
            margin-bottom: 10px;
        }

        .back-button {
            margin-left: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            color: #fff;
            background-color: #0056b3;
        }

        .date-published {
            color: #888;
        }

        .delete-button {
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .delete-button:hover {
            background-color: #99232E;
        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-200">

<?php if ($_SESSION['role'] == "Super Administrator" || $_SESSION['role'] == "Admin" || $_SESSION['role'] == "Registrar" || $_SESSION['role'] == "Student" || $_SESSION['role'] == "Alum Stud") {?>

<?php include "../../includes/sidebar.php";?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

<?php include "../../includes/navbar.php"?>

<?php

if (isset($_GET['id'])) {
    $newsId = $_GET['id'];
    $query = $db->prepare("SELECT * FROM tbl_news WHERE id = ?");
    $query->bind_param("i", $newsId);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '<div class="container mt-6" style="background-color: white; padding-bottom: 20px;">';
        echo '<h2>' . $row['title'] . '</h2>';
        
        if (!empty($row['image_filename'])) {
            echo '<img src="newsimages/' . $row['image_filename'] . '" alt="' . $row['title'] . '">';
        }

        echo '<p style="text-indent: 25px; text-align: justify;">' . $row['content'] . '</p>';
        echo '<p id="viewCount_' . $row['id'] . '" style="margin-top: 20px;font-size: 17px;">Date Published: ' . $row['date_published'] . ' | Views: ' . $row['view_count'] . '</p>';
        echo '<a class="back-button" style="margin-bottom: 15px;" href="news-display.php">Back to News</a>';

        if ($_SESSION['role'] == "Super Administrator" || $_SESSION['role'] == "Admin"){
            echo '<form method="post" action="delete-news.php" style="margin-top: 10px; margin-left: 10px;" onsubmit="return confirmDelete();">';
            echo '<input type="hidden" name="news_id" value="' . $row['id'] . '">';
            echo '<button type="submit" class="delete-button">Delete</button>';
            echo '</form>'; }

        echo '</div>';
    } else {
        echo '<p>No news article found.</p>';
    }

    $query->close();
} else {
    echo '<p>No news article ID specified.</p>';
}
?>

<?php include "../../includes/footer.php"?>

<?php } ?>

</main>

<?php include '../../includes/script.php'?>

</body>
</html>
