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
    <title>School News</title>
    <style>
        .container {
            width: 60%;
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
            font-family: sans-serif;
            font-size: 30px;
        }

        #newsText .p {
            color: #555;
            text-align: justify;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .date-published {
            color: #888;
        }

        .button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            color: #fff;
            background-color: #0056b3;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .page-link, .arrow-link {
            padding: 2px 10px;
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 50%;
            display: inline-block;
        }

        .page-link:hover, .arrow-link:hover {
            background-color: #007bff;
            color: white;
        }

        .current-page {
            background-color: #007bff;
            color: white;
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
$newsPerPage = 3;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $newsPerPage;

$query = $db->query("SELECT id, title, image_filename, content, date_published, view_count FROM tbl_news ORDER BY date_published DESC LIMIT $offset, $newsPerPage");

while ($row = $query->fetch_assoc()) {
    echo '<div class="container" style="background-color: white; color: black; border: transparent; padding: 10px; border-radius: 10px; margin-top: 10px; margin-bottom: 15px;">';
    echo '<h2>' . $row['title'] . '</h2>';
    
    if (!empty($row['image_filename'])) {
        echo '<img style="width: 100%; max-width: 100%; height: auto; border-radius: 5px; margin-bottom: 10px;" src="newsimages/' . $row['image_filename'] . '" alt="default.jpg">';
    }

    $content = $row['content'];
    $wordLimit = 31;
    $words = explode(' ', $content);
    $limitedContent = implode(' ', array_slice($words, 0, $wordLimit));

    echo '<p style="text-indent: 25px; margin-bottom: 15px; font-size: 19px;" text-align: justify;>' . $limitedContent;
    
    if (count($words) > $wordLimit) {
        echo ' ...<br>';
        
    }
    echo '</p>';
    // Inside your while loop
    echo '<a class="button" style="margin-top: 20px;" href="news-details.php?id=' . $row['id'] . '" onclick="updateViewCount(' . $row['id'] . ')">Read more</a>';

    if ($_SESSION['role'] == "Super Administrator" || $_SESSION['role'] == "Admin"){
        echo '<form method="post" action="delete-news.php" style="margin-top: 10px;" onsubmit="return confirmDelete();">';
        echo '<input type="hidden" name="news_id" value="' . $row['id'] . '">';
        echo '<button type="submit" class="delete-button">Delete</button>';
        echo '</form>'; }
    
    echo '<p id="viewCount_' . $row['id'] . '" style="margin-top: 20px;font-size: 17px;">Date Published: ' . $row['date_published'] . ' | Views: ' . $row['view_count'] . '</p>';
    echo '</div>';
}

$query->close();

$totalNews = $db->query("SELECT COUNT(id) AS total FROM tbl_news")->fetch_assoc()['total'];

$totalPages = ceil($totalNews / $newsPerPage);


echo '<div class="pagination">';
echo '<a class="arrow-link" href="?page=' . max(1, $currentPage - 1) . '">&#8249;</a>';
for ($i = 1; $i <= $totalPages; $i++) {
    $class = ($i == $currentPage) ? 'current-page' : '';
    echo '<a class="page-link ' . $class . '" href="?page=' . $i . '">' . $i . '</a>';
}
echo '<a class="arrow-link" href="?page=' . min($totalPages, $currentPage + 1) . '">&#8250;</a>';
echo '</div>';
?>

<?php include "../../includes/footer.php"?>

<?php }?>

</main>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this news article?");
    }
</script>

</body>

<?php include "../../includes/script.php"; ?>

</html>


<!-- if ($_SESSION['role'] == "Super Administrator" || $_SESSION['role'] == "Admin" || $_SESSION['role'] == "Registrar") {
                            echo '<a style="margin-left: 10px;" href="#" onclick="deleteJob(' . $row['id'] . ')"><i class="fas fa-trash-alt"></i></a>'; } -->