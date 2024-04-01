<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="./images/favicon.png" type="image/png" sizes="16x16">
<title>Discussion Forum</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<?php
include '../../includes/session.php';
// End Session
include '../../includes/head.php';
?>

<body class="g-sidenav-show  bg-gray-200">
  
<?php include "../../includes/sidebar.php"?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    
<?php include "../../includes/navbar.php"?>

<?php if ($_SESSION['role'] == "Super Administrator") {
        $admin_id = $_SESSION['userid'];
    ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-0 text-white" style="font-family: sans-serif;">Discussion Forum</h3>
            </div>
            
            <div class="card-body">
                <form name="frm" method="post">
                    <input type="hidden" id="commentid" name="Pcommentid" value="0">
                    <div class="nav-item mb-2 mt-0">
                        <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                            <?php 
                            $getImg = mysqli_query($db, "SELECT img FROM tbl_super_ad WHERE admin_id = '$admin_id'");
                            while ($row = mysqli_fetch_array($getImg)) {
                                $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 7px;" src="' . $imgSrc . '" />';
                            }
                            ?>

                            <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                        </a>
                        <div class="form-group mb-3 text-black">
                            <label for="message" style="color: black; font-size: 16px;">Your Question:</label>
                            <textarea class="form-control" style="resize:none; border: 1px solid black; border-radius: 5px; padding: 10px;" rows="5" name="message" id="message" required></textarea>
                        </div>

                        <button type="submit-responsive" id="submit" name="submit" class="btn btn-dark">Post</button>
                        
                        <?php
                        date_default_timezone_set('Asia/Manila');

                        $message = isset($_POST['message']) ? $_POST['message'] : '';
                        $date = date("Y-m-d H:i:s A");

                        if (isset($_POST['submit'])) {
                            if (strlen($message) >= 1 && strlen($message) <= 500) {
                                $sql = "INSERT INTO tbl_forum (id, user, message, date) VALUES ('', '$user_name', '$message', '$date')";
                                if ($savepost = mysqli_query($db, $sql)) {
                                  echo "<script language=javascript>alert('Post success!')</script>";
                                  echo "<script> document.location='forum-form.php' </script>";
                                } else {
                                  echo "<script language=javascript>alert('Post unsuccessful.')</script>";
                                  echo "<script> document.location='forum-form.php' </script>";
                                }
                            } else {
                                echo "<script language=javascript>alert('Message must be between 1 and 500 characters.')</script>";
                                echo "<script> document.location='forum-form.php' </script>";
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    
        <?php

// Function to display comments and their replies
function displayComments($db, $parentId = 0, $level = 0, $user_name, $maxLevel = 7) {
    $comments = mysqli_query($db, "SELECT * FROM tbl_forum WHERE parent_id = $parentId ORDER BY id DESC");

    while ($comment = mysqli_fetch_assoc($comments)) {
        echo '<div style="margin-left: ' . ($level * 20) . 'px;">';
        echo '<div class="comment-text" style="border: 1px solid black; padding-left: 15px; border-radius: 5px;">';
        echo "<p style='margin-top: 5px;'>Replied by: <b>" . $comment['user'] . "</b></p>";
        echo "<p style='color: black;'>" . $comment['message'] . "</p>";
        echo "<p>Date: " . $comment['date'] . "</p>";

        // Display the reply button only for comments up to level 9
        if ($level <= $maxLevel) {
            echo '<button type="button" class="btn btn-info" style="margin-right: 20px;" data-toggle="modal" data-target="#replyModal" onclick="setReplyId(' . $comment['id'] . ')">Reply</button>';
        }

        // Add the delete button for the comment
        if ($comment['user'] == $user_name || $_SESSION['role'] == "Super Administrator") {
            echo '<button type="button" class="btn btn-danger" onclick="confirmDelete(' . $comment['id'] . ')">Delete</button>';
        }

        echo '</div>';

        // Recursively display replies
        displayComments($db, $comment['id'], $level + 1, $user_name, $maxLevel);

        echo '</div>';
    }
}


?>

<div class="card mt-4">
    <div class="card-body" style="background-color: #fff; border: 0px; border-radius: 10px">
        <h4 style="margin-bottom: 15px;">Recent Questions</h4>
        <?php
        // Pagination configuration
        $commentsPerPage = 5;
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current_page - 1) * $commentsPerPage;

        // Query to retrieve comments for the current page
        $display = mysqli_query($db, "SELECT f.*, COALESCE(sa.img, ad.img, re.img, st.img, al.img) AS imgSrc 
                    FROM tbl_forum f
                    LEFT JOIN tbl_super_ad sa ON f.user = sa.firstname
                    LEFT JOIN tbl_admin ad ON f.user = ad.username
                    LEFT JOIN tbl_registrar re ON f.user = re.username
                    LEFT JOIN tbl_student st ON f.user = st.username
                    LEFT JOIN tbl_alumni al ON f.user = al.username
                    WHERE f.parent_id = 0 ORDER BY f.id DESC LIMIT $offset, $commentsPerPage"); 

        $totalCommentsResult = mysqli_query($db, "SELECT COUNT(*) AS total FROM tbl_forum WHERE parent_id = 0");
        $totalComments = mysqli_fetch_assoc($totalCommentsResult)['total'];

        $totalPages = ceil($totalComments / $commentsPerPage);

        // Display pagination links
        echo '<ul class="pagination justify-content-center">';
                
        // Left arrow for previous page
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Right arrow for next page
        if ($current_page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>';
        }

        echo '</ul>';

        if (mysqli_num_rows($display) != 0) {
            while ($row = mysqli_fetch_assoc($display)) {
                echo '<div class="comment" data-user="' . $row['user'] . '" style="border: 1px solid black; padding: 10px; margin: 10px; margin-bottom: 20px; border-radius: 5px;">';
                        echo '<div style="display: flex; align-items: center;">';

                        // Display the user's image if it's available
                        $imgSrc = empty($row['imgSrc']) ? 'avatar.jpg' : 'data:image/jpeg;base64,' . base64_encode($row['imgSrc']);
                        echo '<img class="comment-image" src="' . $imgSrc . '" alt="User Avatar" style="width: 45px; height: 45px; border-radius: 50%; margin-right: 10px;  margin-bottom: 15px;">';

                        echo "<p ><b>" . $row['user'] . "</b></p>";
                        echo '</div>';
                        echo '<div class="comment-text" style="padding-left: 20px;">';
                        echo "<p style='color: black;'> " . $row['message'] . "</p>";
                        echo "<p>Date: " . $row['date'] . "</p>";

                        echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#replyModal" onclick="setReplyId(' . $row['id'] . ')">Reply</button>';

                        // Add the delete button for the comment
                        if ($row['user'] == $user_name) {
                            echo '<button type="button" class="btn btn-danger" style="margin-left: 20px;" onclick="confirmDelete(' . $row['id'] . ')">Delete</button>';
                        } elseif ($_SESSION ['role'] == "Super Administrator") {
                            echo '<button type="button" class="btn btn-danger" style="margin-left: 20px;" onclick="confirmDelete(' . $row['id'] . ')">Delete</button>';
                        }

                        echo '</div>';

                        // Recursively display replies
                        displayComments($db, $row['id'], 1, $user_name);

                        echo '</div>';
            }
        }

        // Display pagination links
        echo '<ul class="pagination justify-content-center">';
        
        // Left arrow for previous page
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Right arrow for next page
        if ($current_page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>';
        }

        echo '</ul>';
        ?>
    </div>
</div>


<script>
    function confirmDelete(commentId) {
        if (confirm('Are you sure you want to delete this comment?')) {
            deleteComment(commentId);
        } else {
        }
    }
    function deleteComment(commentId) {
        // Send an AJAX request to delete_comment.php
        $.ajax({
            type: 'POST',
            url: 'userData/ctrl-delete-comment.php',
            data: { comment_id: commentId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Reload the page or update the comment section
                    alert('Comment successfully deleted.');
                    location.reload();
                } else {
                    // Handle the error, you can show an alert or update the UI accordingly
                    alert('Failed to delete comment: ' + response.message);
                }
            },
            error: function() {
                // Handle the AJAX error
                alert('Failed to delete comment. Please try again.');
            }
        });
    }
</script>

        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reply Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="frm1" method="post">
                            <div class="form-group">
                                <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                                    <?php
                                    $getImg = mysqli_query($db, "SELECT img FROM tbl_super_ad WHERE admin_id = '$admin_id'");
                                    while ($row = mysqli_fetch_array($getImg)) {
                                        $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                        echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 7px;" src="' . $imgSrc . '" />';
                                    }
                                    ?>
                                    <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                                </a>
                            </div>
                            <div class="form-group">
                                <label for="replyMessage">Write your reply:</label>
                                <textarea class="form-control" style="resize:none; border: 1px solid black; border-radius: 5px; padding: 10px;" rows="5" name="replyMessage" id="replyMessage" required></textarea>
                            </div>
                            <input type="hidden" id="replyCommentId" name="replyCommentId" value="0">

                            <button type="submit" name="btnreply" class="btn btn-info">Reply</button>

                            <?php
                            if (isset($_POST['btnreply'])) {
                                $message = isset($_POST['replyMessage']) ? $_POST['replyMessage'] : '';
                                $date = date("Y-m-d h:i:s A");
                                $reply_id = isset($_POST['replyCommentId']) ? $_POST['replyCommentId'] : 0;

                                if (strlen($message) >= 1 && strlen($message) <= 200) {
                                    // Insert the reply into the database
                                    $sql = "INSERT INTO tbl_forum (user, message, date, parent_id) VALUES ('$user_name', '$message', '$date', $reply_id)";
                                    if ($savepost = mysqli_query($db, $sql)) {
                                        echo "<script language=javascript>alert('Reply posted successfully!')</script>";
                                        echo "<script>document.location='forum-form.php'</script>";
                                    } else {
                                        echo "<script language=javascript>alert('Reply unsuccessful.')</script>";
                                        echo "<script>document.location='forum-form.php'</script>";
                                    }
                                } else {
                                    echo "<script language=javascript>alert('Reply message must be between 1 and 200 characters.')</script>";
                                    echo "<script>document.location='forum-form.php'</script>";
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function setReplyId(commentId) {
            // Set the replyCommentId to the selected comment's comment_id
            document.getElementById('replyCommentId').value = commentId;
        }
        </script>
    

<?php } elseif ($_SESSION['role'] == "Admin") {
    $ad_id = $_SESSION['userid']; 
    ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-0 text-white" style="font-family: sans-serif;">Discussion Forum</h3>
            </div>
            
            <div class="card-body">
                <form name="frm" method="post">
                    <input type="hidden" id="commentid" name="Pcommentid" value="0">
                    <div class="nav-item mb-2 mt-0">
                        <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                            <?php 
                            $getImg = mysqli_query($db, "SELECT img FROM tbl_admin WHERE ad_id = '$ad_id'");
                            while ($row = mysqli_fetch_array($getImg)) {
                                $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 7px;" src="' . $imgSrc . '" />';
                            }
                            ?>

                            <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                        </a>
                        <div class="form-group mb-3 text-black">
                            <label for="message" style="color: black; font-size: 16px;">Your Question:</label>
                            <textarea class="form-control" style="resize:none; border: 1px solid black; border-radius: 5px; padding: 10px;" rows="5" name="message" id="message" required></textarea>
                        </div>

                        <button type="submit-responsive" id="submit" name="submit" class="btn btn-dark">Post</button>
                        
                        <?php
                        date_default_timezone_set('Asia/Manila');

                        $message = isset($_POST['message']) ? $_POST['message'] : '';
                        $date = date("Y-m-d H:i:s A");

                        if (isset($_POST['submit'])) {
                            if (strlen($message) >= 1 && strlen($message) <= 500) {
                                $sql = "INSERT INTO tbl_forum (id, user, message, date) VALUES ('', '$user_name', '$message', '$date')";
                                if ($savepost = mysqli_query($db, $sql)) {
                                  echo "<script language=javascript>alert('Post success!')</script>";
                                  echo "<script> document.location='forum-form.php' </script>";
                                } else {
                                  echo "<script language=javascript>alert('Post unsuccessful.')</script>";
                                  echo "<script> document.location='forum-form.php' </script>";
                                }
                            } else {
                                echo "<script language=javascript>alert('Message must be between 1 and 500 characters.')</script>";
                                echo "<script> document.location='forum-form.php' </script>";
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    
        <?php

// Function to display comments and their replies
function displayComments($db, $parentId = 0, $level = 0, $user_name, $maxLevel = 7) {
    $comments = mysqli_query($db, "SELECT * FROM tbl_forum WHERE parent_id = $parentId ORDER BY id DESC");

    while ($comment = mysqli_fetch_assoc($comments)) {
        echo '<div style="margin-left: ' . ($level * 20) . 'px;">';
        echo '<div class="comment-text" style="border: 1px solid black; padding-left: 15px; border-radius: 5px;">';
        echo "<p style='margin-top: 5px;'>Replied by: <b>" . $comment['user'] . "</b></p>";
        echo "<p style='color: black;'>" . $comment['message'] . "</p>";
        echo "<p>Date: " . $comment['date'] . "</p>";

        // Display the reply button only for comments up to level 9
        if ($level <= $maxLevel) {
            echo '<button type="button" class="btn btn-info" style="margin-right: 20px;" data-toggle="modal" data-target="#replyModal" onclick="setReplyId(' . $comment['id'] . ')">Reply</button>';
        }

        // Add the delete button for the comment
        if ($comment['user'] == $user_name || $_SESSION['role'] == "Admin") {
            echo '<button type="button" class="btn btn-danger" onclick="confirmDelete(' . $comment['id'] . ')">Delete</button>';
        }

        echo '</div>';

        // Recursively display replies
        displayComments($db, $comment['id'], $level + 1, $user_name, $maxLevel);

        echo '</div>';
    }
}

?>

<div class="card mt-4">
    <div class="card-body" style="background-color: #fff; border: 0px; border-radius: 10px">
        <h4 style="margin-bottom: 15px;">Recent Questions</h4>
        <?php
        // Pagination configuration
        $commentsPerPage = 5;
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current_page - 1) * $commentsPerPage;

        // Query to retrieve comments for the current page
        $display = mysqli_query($db, "SELECT f.*, COALESCE(sa.img, ad.img, re.img, st.img, al.img) AS imgSrc 
                    FROM tbl_forum f
                    LEFT JOIN tbl_super_ad sa ON f.user = sa.firstname
                    LEFT JOIN tbl_admin ad ON f.user = ad.username
                    LEFT JOIN tbl_registrar re ON f.user = re.username
                    LEFT JOIN tbl_student st ON f.user = st.username
                    LEFT JOIN tbl_alumni al ON f.user = al.username
                    WHERE f.parent_id = 0 ORDER BY f.id DESC LIMIT $offset, $commentsPerPage");

        $totalCommentsResult = mysqli_query($db, "SELECT COUNT(*) AS total FROM tbl_forum WHERE parent_id = 0");
        $totalComments = mysqli_fetch_assoc($totalCommentsResult)['total'];

        $totalPages = ceil($totalComments / $commentsPerPage);

        // Display pagination links
        echo '<ul class="pagination justify-content-center">';
                
        // Left arrow for previous page
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Right arrow for next page
        if ($current_page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>';
        }

        echo '</ul>';

        if (mysqli_num_rows($display) != 0) {
            while ($row = mysqli_fetch_assoc($display)) {
                echo '<div class="comment" data-user="' . $row['user'] . '" style="border: 1px solid black; padding: 10px; margin: 10px; margin-bottom: 20px; border-radius: 5px;">';
                        echo '<div style="display: flex; align-items: center;">';

                        // Display the user's image if it's available
                        $imgSrc = empty($row['imgSrc']) ? 'avatar.jpg' : 'data:image/jpeg;base64,' . base64_encode($row['imgSrc']);
                        echo '<img class="comment-image" src="' . $imgSrc . '" alt="User Avatar" style="width: 45px; height: 45px; border-radius: 50%; margin-right: 10px;  margin-bottom: 15px;">';

                        echo "<p ><b>" . $row['user'] . "</b></p>";
                        echo '</div>';
                        echo '<div class="comment-text" style="padding-left: 20px;">';
                        echo "<p style='color: black;'> " . $row['message'] . "</p>";
                        echo "<p>Date: " . $row['date'] . "</p>";

                        echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#replyModal" onclick="setReplyId(' . $row['id'] . ')">Reply</button>';

                        // Add the delete button for the comment
                        if ($row['user'] == $user_name) {
                            echo '<button type="button" class="btn btn-danger" style="margin-left: 20px;" onclick="confirmDelete(' . $row['id'] . ')">Delete</button>';
                        } elseif ($_SESSION ['role'] == "Admin") {
                            echo '<button type="button" class="btn btn-danger" style="margin-left: 20px;" onclick="confirmDelete(' . $row['id'] . ')">Delete</button>';
                        }

                        echo '</div>';

                        // Recursively display replies
                        displayComments($db, $row['id'], 1, $user_name);

                        echo '</div>';
            }
        }

        // Display pagination links
        echo '<ul class="pagination justify-content-center">';
        
        // Left arrow for previous page
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Right arrow for next page
        if ($current_page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>';
        }

        echo '</ul>';
        ?>
    </div>
</div>

<script>
    function confirmDelete(commentId) {
        if (confirm('Are you sure you want to delete this comment?')) {
            deleteComment(commentId);
        } else {
        }
    }

    function deleteComment(commentId) {
        // Send an AJAX request to delete_comment.php
        $.ajax({
            type: 'POST',
            url: 'userData/ctrl-delete-comment.php',
            data: { comment_id: commentId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Reload the page or update the comment section
                    alert('Comment successfully deleted.');
                    location.reload();
                } else {
                    // Handle the error, you can show an alert or update the UI accordingly
                    alert('Failed to delete comment: ' + response.message);
                }
            },
            error: function() {
                // Handle the AJAX error
                alert('Failed to delete comment. Please try again.');
            }
        });
    }
</script>

        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reply Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="frm1" method="post">
                            <div class="form-group">
                                <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                                    <?php
                                    $getImg = mysqli_query($db, "SELECT img FROM tbl_admin WHERE ad_id = '$ad_id'");
                                    while ($row = mysqli_fetch_array($getImg)) {
                                        $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                        echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 7px;" src="' . $imgSrc . '" />';
                                    }
                                    ?>
                                    <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                                </a>
                            </div>
                            <div class="form-group">
                                <label for="replyMessage">Write your reply:</label>
                                <textarea class="form-control" style="resize:none; border: 1px solid black; border-radius: 5px; padding: 10px;" rows="5" name="replyMessage" id="replyMessage" required></textarea>
                            </div>
                            <input type="hidden" id="replyCommentId" name="replyCommentId" value="0">

                            <button type="submit" name="btnreply" class="btn btn-info">Reply</button>

                            <?php
                            if (isset($_POST['btnreply'])) {
                                $message = isset($_POST['replyMessage']) ? $_POST['replyMessage'] : '';
                                $date = date("Y-m-d h:i:s A");
                                $reply_id = isset($_POST['replyCommentId']) ? $_POST['replyCommentId'] : 0;

                                if (strlen($message) >= 1 && strlen($message) <= 200) {
                                    // Insert the reply into the database
                                    $sql = "INSERT INTO tbl_forum (user, message, date, parent_id) VALUES ('$user_name', '$message', '$date', $reply_id)";
                                    if ($savepost = mysqli_query($db, $sql)) {
                                        echo "<script language=javascript>alert('Reply posted successfully!')</script>";
                                        echo "<script>document.location='forum-form.php'</script>";
                                    } else {
                                        echo "<script language=javascript>alert('Reply unsuccessful.')</script>";
                                        echo "<script>document.location='forum-form.php'</script>";
                                    }
                                } else {
                                    echo "<script language=javascript>alert('Reply message must be between 1 and 200 characters.')</script>";
                                    echo "<script>document.location='forum-form.php'</script>";
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function setReplyId(commentId) {
            // Set the replyCommentId to the selected comment's comment_id
            document.getElementById('replyCommentId').value = commentId;
        }
        </script>


<?php } elseif ($_SESSION['role'] == "Registrar") {
    $reg_id = $_SESSION['userid']; 
    ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-0 text-white" style="font-family: sans-serif;">Discussion Forum</h3>
            </div>
            
            <div class="card-body">
                <form name="frm" method="post">
                    <input type="hidden" id="commentid" name="Pcommentid" value="0">
                    <div class="nav-item mb-2 mt-0">
                        <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                            <?php 
                            $getImg = mysqli_query($db, "SELECT img FROM tbl_registrar WHERE reg_id = '$reg_id'");
                            while ($row = mysqli_fetch_array($getImg)) {
                                $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 7px;" src="' . $imgSrc . '" />';
                            }
                            ?>

                            <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                        </a>
                        <div class="form-group mb-3 text-black">
                            <label for="message" style="color: black; font-size: 16px;">Your Question:</label>
                            <textarea class="form-control" style="resize:none; border: 1px solid black; border-radius: 5px; padding: 10px;" rows="5" name="message" id="message" required></textarea>
                        </div>

                        <button type="submit-responsive" id="submit" name="submit" class="btn btn-dark">Post</button>
                        
                        <?php
                        date_default_timezone_set('Asia/Manila');

                        $message = isset($_POST['message']) ? $_POST['message'] : '';
                        $date = date("Y-m-d H:i:s A");

                        if (isset($_POST['submit'])) {
                            if (strlen($message) >= 1 && strlen($message) <= 500) {
                                $sql = "INSERT INTO tbl_forum (id, user, message, date) VALUES ('', '$user_name', '$message', '$date')";
                                if ($savepost = mysqli_query($db, $sql)) {
                                  echo "<script language=javascript>alert('Post success!')</script>";
                                  echo "<script> document.location='forum-form.php' </script>";
                                } else {
                                  echo "<script language=javascript>alert('Post unsuccessful.')</script>";
                                  echo "<script> document.location='forum-form.php' </script>";
                                }
                            } else {
                                echo "<script language=javascript>alert('Message must be between 1 and 500 characters.')</script>";
                                echo "<script> document.location='forum-form.php' </script>";
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    
        <?php

// Function to display comments and their replies
function displayComments($db, $parentId = 0, $level = 0, $user_name, $maxLevel = 7) {
    $comments = mysqli_query($db, "SELECT * FROM tbl_forum WHERE parent_id = $parentId ORDER BY id DESC");

    while ($comment = mysqli_fetch_assoc($comments)) {
        echo '<div style="margin-left: ' . ($level * 20) . 'px;">';
        echo '<div class="comment-text" style="border: 1px solid black; padding-left: 15px; border-radius: 5px;">';
        echo "<p style='margin-top: 5px;'>Replied by: <b>" . $comment['user'] . "</b></p>";
        echo "<p style='color: black;'>" . $comment['message'] . "</p>";
        echo "<p>Date: " . $comment['date'] . "</p>";

        // Display the reply button only for comments up to level 9
        if ($level <= $maxLevel) {
            echo '<button type="button" class="btn btn-info" style="margin-right: 20px;" data-toggle="modal" data-target="#replyModal" onclick="setReplyId(' . $comment['id'] . ')">Reply</button>';
        }

        // Add the delete button for the comment
        if ($comment['user'] == $user_name) {
            echo '<button type="button" class="btn btn-danger" onclick="confirmDelete(' . $comment['id'] . ')">Delete</button>';
        }

        echo '</div>';

        // Recursively display replies
        displayComments($db, $comment['id'], $level + 1, $user_name, $maxLevel);

        echo '</div>';
    }
}

?>

<div class="card mt-4">
    <div class="card-body" style="background-color: #fff; border: 0px; border-radius: 10px">
        <h4 style="margin-bottom: 15px;">Recent Questions</h4>
        <?php
        // Pagination configuration
        $commentsPerPage = 5;
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current_page - 1) * $commentsPerPage;

        // Query to retrieve comments for the current page
        $display = mysqli_query($db, "SELECT f.*, COALESCE(sa.img, ad.img, re.img, st.img, al.img) AS imgSrc 
                    FROM tbl_forum f
                    LEFT JOIN tbl_super_ad sa ON f.user = sa.firstname
                    LEFT JOIN tbl_admin ad ON f.user = ad.username
                    LEFT JOIN tbl_registrar re ON f.user = re.username
                    LEFT JOIN tbl_student st ON f.user = st.username
                    LEFT JOIN tbl_alumni al ON f.user = al.username
                    WHERE f.parent_id = 0 ORDER BY f.id DESC LIMIT $offset, $commentsPerPage");

        $totalCommentsResult = mysqli_query($db, "SELECT COUNT(*) AS total FROM tbl_forum WHERE parent_id = 0");
        $totalComments = mysqli_fetch_assoc($totalCommentsResult)['total'];

        $totalPages = ceil($totalComments / $commentsPerPage);

        // Display pagination links
        echo '<ul class="pagination justify-content-center">';
                
        // Left arrow for previous page
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Right arrow for next page
        if ($current_page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>';
        }

        echo '</ul>';

        if (mysqli_num_rows($display) != 0) {
            while ($row = mysqli_fetch_assoc($display)) {
                echo '<div class="comment" data-user="' . $row['user'] . '" style="border: 1px solid black; padding: 10px; margin: 10px; margin-bottom: 20px; border-radius: 5px;">';
                        echo '<div style="display: flex; align-items: center;">';

                        // Display the user's image if it's available
                        $imgSrc = empty($row['imgSrc']) ? 'avatar.jpg' : 'data:image/jpeg;base64,' . base64_encode($row['imgSrc']);
                        echo '<img class="comment-image" src="' . $imgSrc . '" alt="User Avatar" style="width: 45px; height: 45px; border-radius: 50%; margin-right: 10px;  margin-bottom: 15px;">';

                        echo "<p ><b>" . $row['user'] . "</b></p>";
                        echo '</div>';
                        echo '<div class="comment-text" style="padding-left: 20px;">';
                        echo "<p style='color: black;'> " . $row['message'] . "</p>";
                        echo "<p>Date: " . $row['date'] . "</p>";

                        echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#replyModal" onclick="setReplyId(' . $row['id'] . ')">Reply</button>';

                        // Add the delete button for the comment
                        if ($row['user'] == $user_name) {
                            echo '<button type="button" class="btn btn-danger" style="margin-left: 20px;" onclick="confirmDelete(' . $row['id'] . ')">Delete</button>';
                        }

                        echo '</div>';

                        // Recursively display replies
                        displayComments($db, $row['id'], 1, $user_name);

                        echo '</div>';
            }
        }

        // Display pagination links
        echo '<ul class="pagination justify-content-center">';
        
        // Left arrow for previous page
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Right arrow for next page
        if ($current_page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>';
        }

        echo '</ul>';
        ?>
    </div>
</div>

<script>
    function confirmDelete(commentId) {
        if (confirm('Are you sure you want to delete this comment?')) {
            deleteComment(commentId);
        } else {
        }
    }
    function deleteComment(commentId) {
        // Send an AJAX request to delete_comment.php
        $.ajax({
            type: 'POST',
            url: 'userData/ctrl-delete-comment.php',
            data: { comment_id: commentId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Reload the page or update the comment section
                    alert('Comment successfully deleted.');
                    location.reload();
                } else {
                    // Handle the error, you can show an alert or update the UI accordingly
                    alert('Failed to delete comment: ' + response.message);
                }
            },
            error: function() {
                // Handle the AJAX error
                alert('Failed to delete comment. Please try again.');
            }
        });
    }
</script>

        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reply Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="frm1" method="post">
                            <div class="form-group">
                                <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                                    <?php
                                    $getImg = mysqli_query($db, "SELECT img FROM tbl_registrar WHERE reg_id = '$reg_id'");
                                    while ($row = mysqli_fetch_array($getImg)) {
                                        $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                        echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 7px;" src="' . $imgSrc . '" />';
                                    }
                                    ?>
                                    <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                                </a>
                            </div>
                            <div class="form-group">
                                <label for="replyMessage">Write your reply:</label>
                                <textarea class="form-control" style="resize:none; border: 1px solid black; border-radius: 5px; padding: 10px;" rows="5" name="replyMessage" id="replyMessage" required></textarea>
                            </div>
                            <input type="hidden" id="replyCommentId" name="replyCommentId" value="0">

                            <button type="submit" name="btnreply" class="btn btn-info">Reply</button>

                            <?php
                            if (isset($_POST['btnreply'])) {
                                $message = isset($_POST['replyMessage']) ? $_POST['replyMessage'] : '';
                                $date = date("Y-m-d h:i:s A");
                                $reply_id = isset($_POST['replyCommentId']) ? $_POST['replyCommentId'] : 0;

                                if (strlen($message) >= 1 && strlen($message) <= 200) {
                                    // Insert the reply into the database
                                    $sql = "INSERT INTO tbl_forum (user, message, date, parent_id) VALUES ('$user_name', '$message', '$date', $reply_id)";
                                    if ($savepost = mysqli_query($db, $sql)) {
                                        echo "<script language=javascript>alert('Reply posted successfully!')</script>";
                                        echo "<script>document.location='forum-form.php'</script>";
                                    } else {
                                        echo "<script language=javascript>alert('Reply unsuccessful.')</script>";
                                        echo "<script>document.location='forum-form.php'</script>";
                                    }
                                } else {
                                    echo "<script language=javascript>alert('Reply message must be between 1 and 200 characters.')</script>";
                                    echo "<script>document.location='forum-form.php'</script>";
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function setReplyId(commentId) {
            // Set the replyCommentId to the selected comment's comment_id
            document.getElementById('replyCommentId').value = commentId;
        }
        </script>


<?php } if ($_SESSION['role'] == "Alum Stud") { 
    $alumni_id = $_SESSION['userid']; 
    ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-0 text-white" style="font-family: sans-serif;">Discussion Forum</h3>
            </div>
            
            <div class="card-body">
                <form name="frm" method="post">
                    <input type="hidden" id="commentid" name="Pcommentid" value="0">
                    <div class="nav-item mb-2 mt-0">
                        <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                            <?php 
                            $getImg = mysqli_query($db, "SELECT img FROM tbl_alumni WHERE alumni_id = '$alumni_id'");
                            while ($row = mysqli_fetch_array($getImg)) {
                                $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 7px;" src="' . $imgSrc . '" />';
                            }
                            ?>

                            <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                        </a>
                        <div class="form-group mb-3 text-black">
                            <label for="message" style="color: black; font-size: 16px;">Your Question:</label>
                            <textarea class="form-control" style="resize:none; border: 1px solid black; border-radius: 5px; padding: 10px;" rows="5" name="message" id="message" required></textarea>
                        </div>

                        <button type="submit-responsive" id="submit" name="submit" class="btn btn-dark">Post</button>
                        
                        <?php
                        date_default_timezone_set('Asia/Manila');

                        $message = isset($_POST['message']) ? $_POST['message'] : '';
                        $date = date("Y-m-d H:i:s A");

                        if (isset($_POST['submit'])) {
                            if (strlen($message) >= 1 && strlen($message) <= 500) {
                                $sql = "INSERT INTO tbl_forum (id, user, message, date) VALUES ('', '$user_name', '$message', '$date')";
                                if ($savepost = mysqli_query($db, $sql)) {
                                  echo "<script language=javascript>alert('Post success!')</script>";
                                  echo "<script> document.location='forum-form.php' </script>";
                                } else {
                                  echo "<script language=javascript>alert('Post unsuccessful.')</script>";
                                  echo "<script> document.location='forum-form.php' </script>";
                                }
                            } else {
                                echo "<script language=javascript>alert('Message must be between 1 and 500 characters.')</script>";
                                echo "<script> document.location='forum-form.php' </script>";
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    
        <?php

// Function to display comments and their replies
function displayComments($db, $parentId = 0, $level = 0, $user_name, $maxLevel = 7) {
    $comments = mysqli_query($db, "SELECT * FROM tbl_forum WHERE parent_id = $parentId ORDER BY id DESC");

    while ($comment = mysqli_fetch_assoc($comments)) {
        echo '<div style="margin-left: ' . ($level * 20) . 'px;">';
        echo '<div class="comment-text" style="border: 1px solid black; padding-left: 15px; border-radius: 5px;">';
        echo "<p style='margin-top: 5px;'>Replied by: <b>" . $comment['user'] . "</b></p>";
        echo "<p style='color: black;'>" . $comment['message'] . "</p>";
        echo "<p>Date: " . $comment['date'] . "</p>";

        // Display the reply button only for comments up to level 9
        if ($level <= $maxLevel) {
            echo '<button type="button" class="btn btn-info" style="margin-right: 20px;" data-toggle="modal" data-target="#replyModal" onclick="setReplyId(' . $comment['id'] . ')">Reply</button>';
        }

        // Add the delete button for the comment
        if ($comment['user'] == $user_name) {
            echo '<button type="button" class="btn btn-danger" onclick="confirmDelete(' . $comment['id'] . ')">Delete</button>';
        }

        echo '</div>';

        // Recursively display replies
        displayComments($db, $comment['id'], $level + 1, $user_name, $maxLevel);

        echo '</div>';
    }
}

?>

<div class="card mt-4">
    <div class="card-body" style="background-color: #fff; border: 0px; border-radius: 10px">
        <h4 style="margin-bottom: 15px;">Recent Questions</h4>
        <?php
        // Pagination configuration
        $commentsPerPage = 5;
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current_page - 1) * $commentsPerPage;

        // Query to retrieve comments for the current page
        $display = mysqli_query($db, "SELECT f.*, COALESCE(sa.img, ad.img, re.img, st.img, al.img) AS imgSrc 
                    FROM tbl_forum f
                    LEFT JOIN tbl_super_ad sa ON f.user = sa.firstname
                    LEFT JOIN tbl_admin ad ON f.user = ad.username
                    LEFT JOIN tbl_registrar re ON f.user = re.username
                    LEFT JOIN tbl_student st ON f.user = st.username
                    LEFT JOIN tbl_alumni al ON f.user = al.username
                    WHERE f.parent_id = 0 ORDER BY f.id DESC LIMIT $offset, $commentsPerPage");

        $totalCommentsResult = mysqli_query($db, "SELECT COUNT(*) AS total FROM tbl_forum WHERE parent_id = 0");
        $totalComments = mysqli_fetch_assoc($totalCommentsResult)['total'];

        $totalPages = ceil($totalComments / $commentsPerPage);

        // Display pagination links
        echo '<ul class="pagination justify-content-center">';
                
        // Left arrow for previous page
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Right arrow for next page
        if ($current_page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>';
        }

        echo '</ul>';

        if (mysqli_num_rows($display) != 0) {
            while ($row = mysqli_fetch_assoc($display)) {
                echo '<div class="comment" data-user="' . $row['user'] . '" style="border: 1px solid black; padding: 10px; margin: 10px; margin-bottom: 20px; border-radius: 5px;">';
                        echo '<div style="display: flex; align-items: center;">';

                        // Display the user's image if it's available
                        $imgSrc = empty($row['imgSrc']) ? 'avatar.jpg' : 'data:image/jpeg;base64,' . base64_encode($row['imgSrc']);
                        echo '<img class="comment-image" src="' . $imgSrc . '" alt="User Avatar" style="width: 45px; height: 45px; border-radius: 50%; margin-right: 10px;  margin-bottom: 15px;">';

                        echo "<p ><b>" . $row['user'] . "</b></p>";
                        echo '</div>';
                        echo '<div class="comment-text" style="padding-left: 20px;">';
                        echo "<p style='color: black;'> " . $row['message'] . "</p>";
                        echo "<p>Date: " . $row['date'] . "</p>";

                        echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#replyModal" onclick="setReplyId(' . $row['id'] . ')">Reply</button>';

                        // Add the delete button for the comment
                        if ($row['user'] == $user_name) {
                            echo '<button type="button" class="btn btn-danger" style="margin-left: 20px;" onclick="confirmDelete(' . $row['id'] . ')">Delete</button>';
                        }

                        echo '</div>';

                        // Recursively display replies
                        displayComments($db, $row['id'], 1, $user_name);

                        echo '</div>';
            }
        }

        // Display pagination links
        echo '<ul class="pagination justify-content-center">';
        
        // Left arrow for previous page
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Right arrow for next page
        if ($current_page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>';
        }

        echo '</ul>';
        ?>
    </div>
</div>

<script>
    function confirmDelete(commentId) {
        if (confirm('Are you sure you want to delete this comment?')) {
            deleteComment(commentId);
        } else {
        }
    }
    function deleteComment(commentId) {
        // Send an AJAX request to delete_comment.php
        $.ajax({
            type: 'POST',
            url: 'userData/ctrl-delete-comment.php',
            data: { comment_id: commentId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Reload the page or update the comment section
                    alert('Comment successfully deleted.');
                    location.reload();
                } else {
                    // Handle the error, you can show an alert or update the UI accordingly
                    alert('Failed to delete comment: ' + response.message);
                }
            },
            error: function() {
                // Handle the AJAX error
                alert('Failed to delete comment. Please try again.');
            }
        });
    }
</script>

        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reply Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="frm1" method="post">
                            <div class="form-group">
                                <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                                    <?php
                                    $getImg = mysqli_query($db, "SELECT img FROM tbl_alumni WHERE alumni_id = '$alumni_id'");
                                    while ($row = mysqli_fetch_array($getImg)) {
                                        $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                        echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 7px;" src="' . $imgSrc . '" />';
                                    }
                                    ?>
                                    <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                                </a>
                            </div>
                            <div class="form-group">
                                <label for="replyMessage">Write your reply:</label>
                                <textarea class="form-control" style="resize:none; border: 1px solid black; border-radius: 5px; padding: 10px;" rows="5" name="replyMessage" id="replyMessage" required></textarea>
                            </div>
                            <input type="hidden" id="replyCommentId" name="replyCommentId" value="0">

                            <button type="submit" name="btnreply" class="btn btn-info">Reply</button>

                            <?php
                            if (isset($_POST['btnreply'])) {
                                $message = isset($_POST['replyMessage']) ? $_POST['replyMessage'] : '';
                                $date = date("Y-m-d h:i:s A");
                                $reply_id = isset($_POST['replyCommentId']) ? $_POST['replyCommentId'] : 0;

                                if (strlen($message) >= 1 && strlen($message) <= 200) {
                                    // Insert the reply into the database
                                    $sql = "INSERT INTO tbl_forum (user, message, date, parent_id) VALUES ('$user_name', '$message', '$date', $reply_id)";
                                    if ($savepost = mysqli_query($db, $sql)) {
                                        echo "<script language=javascript>alert('Reply posted successfully!')</script>";
                                        echo "<script>document.location='forum-form.php'</script>";
                                    } else {
                                        echo "<script language=javascript>alert('Reply unsuccessful.')</script>";
                                        echo "<script>document.location='forum-form.php'</script>";
                                    }
                                } else {
                                    echo "<script language=javascript>alert('Reply message must be between 1 and 200 characters.')</script>";
                                    echo "<script>document.location='forum-form.php'</script>";
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function setReplyId(commentId) {
            // Set the replyCommentId to the selected comment's comment_id
            document.getElementById('replyCommentId').value = commentId;
        }
        </script>

<?php } if ($_SESSION['role'] == "Student") { 
    $student_id = $_SESSION['userid']; 
    ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-0 text-white" style="font-family: sans-serif;">Discussion Forum</h3>
            </div>
            
            <div class="card-body">
                <form name="frm" method="post">
                    <input type="hidden" id="commentid" name="Pcommentid" value="0">
                    <div class="nav-item mb-2 mt-0">
                        <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                            <?php 
                            $getImg = mysqli_query($db, "SELECT img FROM tbl_student WHERE student_id = '$student_id'");
                            while ($row = mysqli_fetch_array($getImg)) {
                                $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 7px;" src="' . $imgSrc . '" />';
                            }
                            ?>

                            <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                        </a>
                        <div class="form-group mb-3 text-black">
                            <label for="message" style="color: black; font-size: 16px;">Your Question:</label>
                            <textarea class="form-control" style="resize:none; border: 1px solid black; border-radius: 5px; padding: 10px;" rows="5" name="message" id="message" required></textarea>
                        </div>

                        <button type="submit-responsive" id="submit" name="submit" class="btn btn-dark">Post</button>
                        
                        <?php
                        date_default_timezone_set('Asia/Manila');

                        $message = isset($_POST['message']) ? $_POST['message'] : '';
                        $date = date("Y-m-d H:i:s A");

                        if (isset($_POST['submit'])) {
                            if (strlen($message) >= 1 && strlen($message) <= 500) {
                                $sql = "INSERT INTO tbl_forum (id, user, message, date) VALUES ('', '$user_name', '$message', '$date')";
                                if ($savepost = mysqli_query($db, $sql)) {
                                  echo "<script language=javascript>alert('Post success!')</script>";
                                  echo "<script> document.location='forum-form.php' </script>";
                                } else {
                                  echo "<script language=javascript>alert('Post unsuccessful.')</script>";
                                  echo "<script> document.location='forum-form.php' </script>";
                                }
                            } else {
                                echo "<script language=javascript>alert('Message must be between 1 and 500 characters.')</script>";
                                echo "<script> document.location='forum-form.php' </script>";
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    
        <?php

// Function to display comments and their replies
function displayComments($db, $parentId = 0, $level = 0, $user_name, $maxLevel = 7) {
    $comments = mysqli_query($db, "SELECT * FROM tbl_forum WHERE parent_id = $parentId ORDER BY id DESC");

    while ($comment = mysqli_fetch_assoc($comments)) {
        echo '<div style="margin-left: ' . ($level * 20) . 'px;">';
        echo '<div class="comment-text" style="border: 1px solid black; padding-left: 15px; border-radius: 5px;">';
        echo "<p style='margin-top: 5px;'>Replied by: <b>" . $comment['user'] . "</b></p>";
        echo "<p style='color: black;'>" . $comment['message'] . "</p>";
        echo "<p>Date: " . $comment['date'] . "</p>";

        // Display the reply button only for comments up to level 9
        if ($level <= $maxLevel) {
            echo '<button type="button" class="btn btn-info" style="margin-right: 20px;" data-toggle="modal" data-target="#replyModal" onclick="setReplyId(' . $comment['id'] . ')">Reply</button>';
        }

        // Add the delete button for the comment
        if ($comment['user'] == $user_name) {
            echo '<button type="button" class="btn btn-danger" onclick="confirmDelete(' . $comment['id'] . ')">Delete</button>';
        }

        echo '</div>';

        // Recursively display replies
        displayComments($db, $comment['id'], $level + 1, $user_name, $maxLevel);

        echo '</div>';
    }
}

?>

<div class="card mt-4">
    <div class="card-body" style="background-color: #fff; border: 0px; border-radius: 10px">
        <h4 style="margin-bottom: 15px;">Recent Questions</h4>
        <?php
        // Pagination configuration
        $commentsPerPage = 5;
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current_page - 1) * $commentsPerPage;

        // Query to retrieve comments for the current page
        $display = mysqli_query($db, "SELECT f.*, COALESCE(sa.img, ad.img, re.img, st.img, al.img) AS imgSrc 
                    FROM tbl_forum f
                    LEFT JOIN tbl_super_ad sa ON f.user = sa.firstname
                    LEFT JOIN tbl_admin ad ON f.user = ad.username
                    LEFT JOIN tbl_registrar re ON f.user = re.username
                    LEFT JOIN tbl_student st ON f.user = st.username
                    LEFT JOIN tbl_alumni al ON f.user = al.username
                    WHERE f.parent_id = 0 ORDER BY f.id DESC LIMIT $offset, $commentsPerPage");

        $totalCommentsResult = mysqli_query($db, "SELECT COUNT(*) AS total FROM tbl_forum WHERE parent_id = 0");
        $totalComments = mysqli_fetch_assoc($totalCommentsResult)['total'];

        $totalPages = ceil($totalComments / $commentsPerPage);

        // Display pagination links
        echo '<ul class="pagination justify-content-center">';
                
        // Left arrow for previous page
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Right arrow for next page
        if ($current_page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>';
        }

        echo '</ul>';

        if (mysqli_num_rows($display) != 0) {
            while ($row = mysqli_fetch_assoc($display)) {
                echo '<div class="comment" data-user="' . $row['user'] . '" style="border: 1px solid black; padding: 10px; margin: 10px; margin-bottom: 20px; border-radius: 5px;">';
                        echo '<div style="display: flex; align-items: center;">';

                        // Display the user's image if it's available
                        $imgSrc = empty($row['imgSrc']) ? 'avatar.jpg' : 'data:image/jpeg;base64,' . base64_encode($row['imgSrc']);
                        echo '<img class="comment-image" src="' . $imgSrc . '" alt="User Avatar" style="width: 45px; height: 45px; border-radius: 50%; margin-right: 10px;  margin-bottom: 15px;">';

                        echo "<p ><b>" . $row['user'] . "</b></p>";
                        echo '</div>';
                        echo '<div class="comment-text" style="padding-left: 20px;">';
                        echo "<p style='color: black;'> " . $row['message'] . "</p>";
                        echo "<p>Date: " . $row['date'] . "</p>";

                        echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#replyModal" onclick="setReplyId(' . $row['id'] . ')">Reply</button>';

                        // Add the delete button for the comment
                        if ($row['user'] == $user_name) {
                            echo '<button type="button" class="btn btn-danger" style="margin-left: 20px;" onclick="confirmDelete(' . $row['id'] . ')">Delete</button>';
                        } 

                        echo '</div>';

                        // Recursively display replies
                        displayComments($db, $row['id'], 1, $user_name);

                        echo '</div>';
            }
        }

        // Display pagination links
        echo '<ul class="pagination justify-content-center">';
        
        // Left arrow for previous page
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Right arrow for next page
        if ($current_page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>';
        }

        echo '</ul>';
        ?>
    </div>
</div>

<script>
    function confirmDelete(commentId) {
        if (confirm('Are you sure you want to delete this comment?')) {
            deleteComment(commentId);
        } else {
        }
    }
    function deleteComment(commentId) {
        // Send an AJAX request to delete_comment.php
        $.ajax({
            type: 'POST',
            url: 'userData/ctrl-delete-comment.php',
            data: { comment_id: commentId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Reload the page or update the comment section
                    alert('Comment successfully deleted.');
                    location.reload();
                } else {
                    // Handle the error, you can show an alert or update the UI accordingly
                    alert('Failed to delete comment: ' + response.message);
                }
            },
            error: function() {
                // Handle the AJAX error
                alert('Failed to delete comment. Please try again.');
            }
        });
    }
</script>

        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 10%;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reply Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="frm1" method="post">
                            <div class="form-group">
                                <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                                    <?php
                                    $getImg = mysqli_query($db, "SELECT img FROM tbl_student WHERE student_id = '$student_id'");
                                    while ($row = mysqli_fetch_array($getImg)) {
                                        $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                        echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 7px;" src="' . $imgSrc . '" />';
                                    }
                                    ?>
                                    <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                                </a>
                            </div>
                            <div class="form-group">
                                <label for="replyMessage">Write your reply:</label>
                                <textarea class="form-control" style="resize:none; border: 1px solid black; border-radius: 5px; padding: 10px;" rows="5" name="replyMessage" id="replyMessage" required></textarea>
                            </div>
                            <input type="hidden" id="replyCommentId" name="replyCommentId" value="0">

                            <button type="submit" name="btnreply" class="btn btn-info">Reply</button>

                            <?php
                            if (isset($_POST['btnreply'])) {
                                $message = isset($_POST['replyMessage']) ? $_POST['replyMessage'] : '';
                                $date = date("Y-m-d h:i:s A");
                                $reply_id = isset($_POST['replyCommentId']) ? $_POST['replyCommentId'] : 0;

                                if (strlen($message) >= 1 && strlen($message) <= 200) {
                                    // Insert the reply into the database
                                    $sql = "INSERT INTO tbl_forum (user, message, date, parent_id) VALUES ('$user_name', '$message', '$date', $reply_id)";
                                    if ($savepost = mysqli_query($db, $sql)) {
                                        echo "<script language=javascript>alert('Reply posted successfully!')</script>";
                                        echo "<script>document.location='forum-form.php'</script>";
                                    } else {
                                        echo "<script language=javascript>alert('Reply unsuccessful.')</script>";
                                        echo "<script>document.location='forum-form.php'</script>";
                                    }
                                } else {
                                    echo "<script language=javascript>alert('Reply message must be between 1 and 200 characters.')</script>";
                                    echo "<script>document.location='forum-form.php'</script>";
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function setReplyId(commentId) {
            // Set the replyCommentId to the selected comment's comment_id
            document.getElementById('replyCommentId').value = commentId;
        }
        </script>
    
    <?php } ?>

</main>


<?php include "../../includes/footer.php"?>
</body>
</html>
<!--   Core JS Files   -->
<?php include "../../includes/script.php"?>