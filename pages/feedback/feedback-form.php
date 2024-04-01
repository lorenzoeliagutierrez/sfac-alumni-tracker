<!DOCTYPE html>
<html lang="en"><!DOCTYPE html>
<html lang="en">

<?php
require '../../includes/conn.php';
include '../../includes/session.php';
include '../../includes/head.php';
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback Form</title>
  <style>
        #confirmModal .modal-dialog{
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

<body class="g-sidenav-show  bg-gray-200">
    
<?php
include "../../includes/sidebar.php";
?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

<?php include "../../includes/navbar.php"?>

<?php if ($_SESSION['role'] == "Alum Stud") { ?>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9 mt-3">
                <div class="card">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4" style="font-family: sans-serif;">Feedback Form</h3>
                        <form method="post" action="submit-feedback.php" id="feedbackForm">
                            <a href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
                                <?php 
                                $getImg = mysqli_query($db, "SELECT img FROM tbl_alumni WHERE alumni_id = '$alumni_id'");
                                while ($row = mysqli_fetch_array($getImg)) {
                                    $imgSrc = empty($row['img']) ? '../../assets/img/image.png' : 'data:image/jpeg;base64,' . base64_encode($row['img']);
                                    echo '<img class="avatar" style="height:45px; width:45px; margin-bottom: 15px;" src="' . $imgSrc . '" />';
                                }
                                ?>

                                <label class="text-bold ms-1 ps-1"><?= $user_name ?></label>
                                <input type="hidden" name="user" value="<?= $user_name ?>">
                            </a>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <label class="text-bold ms-1 ps-1"><?= $email ?></label>
                                <input type="hidden" name="email" value="<?= $email ?>">
                            </div>

                            <label for="rating">Rate your overall experience of the institution (5 as the highest, 1 as the lowest): </label>
                            <div class="rating-buttons ms-3">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    echo '<input type="radio" name="rating" value="' . $i . '" style="margin-left: 20px; margin-right: 5px;">' . $i;
                                }
                                ?>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="feedback" class="form-label">Feedback:</label>
                                <textarea class="form-control" name="feedback" style="resize:none; border: 1px solid black; border-radius: 10px; padding: 10px;" rows="8" required placeholder="Enter your feedback or concerns about the institution and the website here..."></textarea>
                            </div>

                            <div class="mb-3 mt-3 form-check">
                                <input type="checkbox" class="form-check-input" id="anonymousCheckbox" name="anonymous">
                                <label class="form-check-label" for="anonymousCheckbox">Submit Anonymously</label>
                            </div>

                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-dark mt-3" onclick="showConfirmDialog(event)">Submit</button>
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
    function showConfirmDialog(event) {
        event.preventDefault();
        $('#confirmModal').modal('show');
    }

    function closeConfirmDialog() {
        $('#confirmModal').modal('hide');
    }

    function submitForm() {
        $('#feedbackForm').submit();
    }
</script>


<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel"></h5>
            </div>
            <div class="modal-body">
                Are you sure you want to submit this feedback?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" onclick="closeConfirmDialog()">Cancel</button>
                <button type="button" class="btn btn-info" onclick="submitForm()">Submit</button>
            </div>
        </div>
    </div>
</div>

</main>

<?php include "../../includes/script.php"?>

<script>
<?php
  if (!empty($_SESSION['feedback_added'])) { ?>
  Swal.fire("Feedback","Submitted Successfully ", "success");
  <?php
  unset($_SESSION['feedback_added']);
  }?>
</script>

</body>
</html>



