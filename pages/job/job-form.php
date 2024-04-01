<!DOCTYPE html>
<html lang="en">

<?php
require '../../includes/conn.php';
include '../../includes/session.php';
include '../../includes/head.php';
?>

<?php if ($_SESSION['role'] == "Super Administrator") {
    $super_admin = mysqli_query($db, "SELECT * FROM tbl_super_ad WHERE username = '$username'");
} else if ($_SESSION['role'] == "Admin") {
    $admin = mysqli_query($db, "SELECT * FROM tbl_admin WHERE username = '$username'");
} else if ($_SESSION['role'] == "Registrar") {
    $registrar = mysqli_query($db, "SELECT * FROM tbl_registrar WHERE username = '$username'");
} else if ($_SESSION['role'] == "Student") {
    $student = mysqli_query($db, "SELECT * FROM tbl_student WHERE username = '$username'");
} else if ($_SESSION['role'] == "Alum Stud") {
    $alumni = mysqli_query($db, "SELECT * FROM tbl_alumni WHERE username = '$username'");
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Opportunity Form</title>
    <style>

        .container-fluid {
            padding: 4rem 0;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border: 1px solid black;
            border-radius: 10px;
            padding: 10px;
        }

        .form-control:focus {
            outline: none; 
            border: 1px solid black;
        }

        .form-check-input {
            margin-top: 0.25rem;
        }

        .form-select option {
        margin-left: 20px;
        }

        .btn-dark {
            background-color: #343a40;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
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
<body class="g-sidenav-show  bg-gray-200">
<?php include "../../includes/sidebar.php"; ?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

<?php include "../../includes/navbar.php"?>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9 mt-3">
                <div class="card">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4" style="font-family: sans-serif;">Job Opportunity Form</h3>
                        <form method="post" id="jobForm" action="submit-job.php" id="jobForm">
                            <div class="mb-3">
                                <label for="name" class="form-label" style="color: black;">Name:</label>
                                <label class="text-bold ms-1 ps-1" style="color: black;"><?= $user_name ?></label>
                                <input type="hidden" name="name" value="<?= $user_name ?>">
                        
                                <label for="email" class="form-label" style="color: black; margin-left: 50%;">Email:</label>
                                <label class="text-bold ms-1 ps-1" style="color: black;"><?= $email ?></label>
                                <input type="hidden" name="email" value="<?= $email ?>">
                            </div>

                            <div class="mb-3">
                                <label for="contact" class="form-label" style="color: black;">Contact No:</label>
                                <input type="tel" class="form-control" name="contact" style="color: black;" placeholder="Your Contact Number" required>
                            </div>

                            <div class="mb-3">
                                <label for="job_name" class="form-label" style="color: black;">Job Title:</label>
                                <input type="text" class="form-control" style="border: 1px solid black; border-radius: 10px; color: black;" name="job_name" placeholder="ex. Teacher, Doctor etc." required>
                            </div>

                            <div class="mb-3">
                                <label for="job_desc" class="form-label" style="color: black;">Job Description:</label>
                                <textarea class="form-control" name="job_desc" rows="8" style="resize:none; color: black;" required placeholder="Enter job description here, please include details on how the user will be able to apply regarding on the job offer you will post (ex. sending the applicant's resume on your email)..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edu_background" class="form-label" style="color: black;">Required Educational Background:</label>
                                <select class="form-select" name="edu_background" style="border: 1px solid black; border-radius: 10px; color: black; padding-left: 6px; width: 250px;" required>
                                    <option value="" selected disabled>Select Educational Background</option>
                                    <option value="None">None</option>
                                    <option value="Elementary Graduate">Elementary Graduate</option>
                                    <option value="Junior High School Graduate">Junior High School Graduate</option>
                                    <option value="Senior High School Graduate">Senior High School Graduate</option>
                                    <option value="College Graduate (Any Course)">College Graduate (Any Course)</option>
                                    <option value="CS Graduate">CS Graduate</option>
                                    <option value="EDUC Graduate">EDUC Graduate</option>
                                    <option value="BA Graduate">BA Graduate</option>
                                    <option value="HM/HRM Graduate">HM/HRM Graduate</option>
                                    <option value="LA Graduate">LA Graduate</option>
                                    <option value="ENG Graduate">ENG Graduate</option>
                                    <option value="NURS Graduate">NURS Graduate</option>
                                </select>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-dark mt-3" onclick="showConfirmDialog(event)">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include "../../includes/footer.php"; ?>

<script>
    function showConfirmDialog(event) {
        event.preventDefault();
        $('#confirmModal').modal('show');
    }

    function closeConfirmDialog() {
        $('#confirmModal').modal('hide');
    }

    function submitForm() {
        $('#jobForm').submit();
    }
</script>


<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel"></h5>
            </div>
            <div class="modal-body">
                Are you sure you want to submit this job offer?
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
  if (!empty($_SESSION['job_added'])) { ?>
  Swal.fire("Job","Submitted Successfully ", "success");
  <?php
  unset($_SESSION['job_added']);
  }?>
</script>

</body>
</html>
