<!DOCTYPE html>
<html lang="en">

<?php
require '../../includes/conn.php';
include '../../includes/head.php';
include '../../includes/session.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add News</title>
    <style>
        .container {
            padding: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        h3 {
            font-family: 'Sans-serif';
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #555;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            display: inline-block;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        button:hover {
            background-color: #0056b3;
        }

        #confirmModal .modal-dialog {
            margin: 15% auto;
        }

        .modal-content {
            text-align: center;
        }

        .modal-header, .modal-body, .modal-footer {
            padding: 20px;
        }

        .modal-title {
            font-family: 'Sans-serif';
            color: #333;
            margin-bottom: 20px;
        }

        .btn-dark, .btn-info {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-dark:hover {
            background-color: #555;
        }

        .btn-info:hover {
            background-color: #007bff;
        }
    </style>
</head>

<?php if ($_SESSION['role'] == "Super Administrator" || $_SESSION['role'] == "Admin") {?>

<body class="g-sidenav-show  bg-gray-200">

<?php include "../../includes/sidebar.php";?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

<?php include "../../includes/navbar.php"?>
<div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9 mt-3">
                <div class="card">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4" style="font-family: sans-serif;">Add News</h3>
                        <form id="newsForm" method="post" action="submit-news.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title">News Title:</label>
                            <input type="text" style="border: 1px solid black; border-radius: 3px; color: black;" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="content">News Content:</label>
                            <textarea name="content" style="resize: none; border: 1px solid black; border-radius: 5px; color: black;" id="content" rows="8" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image">Image:</label>
                            <input type="file" name="image" style="width: auto;"accept=".gif, .jpeg, .jpg, .png">
                            <small class="form-text text-muted">Accepted file types: .gif, .jpeg, .jpg, .png</small>
                        </div>

                        <div class="text-center">
                            <button type="button" onclick="showConfirmDialog()">Submit News</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php include "../../includes/footer.php"?>

<?php } ?>

<script>
    function showConfirmDialog() {
        $('#confirmModal').modal('show');
    }
    function closeConfirmDialog() {
        $('#confirmModal').modal('hide');
    }
    function submitForm() {
        $('#newsForm').submit();
    }
</script>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel"></h5>
            </div>
            <div class="modal-body">
                Are you sure you want to post this news article?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" onclick="closeConfirmDialog()">Cancel</button>
                <button type="button" class="btn btn-info" onclick="submitForm()">Submit</button>
            </div>
        </div>
    </div>
</div>

</main>

<?php include "../../includes/script.php"; ?>

<script>
<?php
  if (!empty($_SESSION['news_added'])) { ?>
  Swal.fire("News","Posted Successfully ", "success");
  <?php
  unset($_SESSION['news_added']);
  }?>
</script>

</body>
</html>