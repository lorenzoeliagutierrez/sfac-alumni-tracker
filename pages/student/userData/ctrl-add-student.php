<?php
session_start();
require '../../../includes/conn.php';

if (isset($_POST['submit'])) {

  $stud_no    = mysqli_real_escape_string($db, $_POST['stud_no']);
  $firstname    = mysqli_real_escape_string($db, $_POST['firstname']);
  $middlename    = mysqli_real_escape_string($db, $_POST['middlename']);
  $lastname    = mysqli_real_escape_string($db, $_POST['lastname']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $batch_id = mysqli_real_escape_string($db, $_POST['batch_id']);
  $username    = mysqli_real_escape_string($db, $_POST['username']);
  $password    = mysqli_real_escape_string($db, $_POST['password']);
  $confirm_pass = mysqli_real_escape_string($db, $_POST['confirm_pass']);


  if ($password == $confirm_pass) {
    $hashedPwd = password_hash($confirm_pass, PASSWORD_DEFAULT);
    $insertStudent = mysqli_query($db, "INSERT INTO tbl_student (stud_no, firstname, middlename, lastname, email, batch_id, username, password) VALUES ('$stud_no','$firstname','$middlename', '$lastname', '$email', '$batch_id','$username', '$hashedPwd')") or die(mysqli_error($db));
    $_SESSION['Student_added'] = 'Student Successfully Added!';
    header("location: ../add-student.php");
  } else {
    $_SESSION['Student_notAdded'] = 'Password does not match';
    header("location: ../add-student.php");
  }
} else {
  $_SESSION['usernameExist'] = true;
  header("location: ../add-student.php");
}
