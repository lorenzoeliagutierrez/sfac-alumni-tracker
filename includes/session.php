<?php
session_start();
require 'conn.php';

if (!empty($_SESSION['role'])) {
  if ($_SESSION['role'] == "Super Administrator") {
    $admin_id = $_SESSION['userid'];

    $query_admin = $db->query("SELECT admin_id,img,firstname,email FROM tbl_super_ad WHERE admin_id = '$admin_id'");
    $row_admin = $query_admin->fetch_array();
    $user_image = $row_admin['img'];
    $user_name = $row_admin['firstname'];
    $email = $row_admin['email'];

    if ($admin_id === false) {
      header("location: ../login/sign-in.php");
      exit();
    }
  } elseif ($_SESSION['role'] === "Admin") {
    $ad_id = $_SESSION['userid'];

    $query_stud = $db->query("SELECT ad_id,img,username,email FROM tbl_admin WHERE ad_id = '$ad_id'");
    $row_stud = $query_stud->fetch_array();
    $user_image = $row_stud['img'];
    $user_name = $row_stud['username'];
    $email = $row_stud['email'];
   

    if ($ad_id == false) {
      header("location: ../login/sign-in.php");
      exit();
    }
  } elseif ($_SESSION['role'] === "Registrar") {
    $reg_id = $_SESSION['userid'];

    $query_stud = $db->query("SELECT reg_id,img,username,email FROM tbl_registrar WHERE reg_id = '$reg_id'");
    $row_stud = $query_stud->fetch_array();
    $user_image = $row_stud['img'];
    $user_name = $row_stud['username'];
    $email = $row_stud['email'];
    

    if ($reg_id == false) {
      header("location: ../login/sign-in.php");
      exit();
    }

  } elseif ($_SESSION['role'] === "Student") {
    $student_id = $_SESSION['userid'];

    $query_stud = $db->query("SELECT student_id,img,username,email,batch_id FROM tbl_student WHERE student_id = '$student_id'");
    $row_stud = $query_stud->fetch_array();
    $user_image = $row_stud['img'];
    $user_name = $row_stud['username'];
    $email = $row_stud['email'];
    $batch_id = $row_stud['batch_id'];
    

    if ($student_id == false) {
      header("location: ../login/sign-in.php");
      exit();
    }

  } elseif ($_SESSION['role'] === "Alum Stud") {
    $alumni_id = $_SESSION['userid'];

    $query_stud = $db->query("SELECT a.img, a.username,a.firstname,a.middlename,a.lastname,f.level_id,f.batch_id,f.program_id,f.email FROM tbl_alumni a LEFT JOIN tbl_form f USING(alumni_id) WHERE alumni_id = '$alumni_id'");
    $row_stud = $query_stud->fetch_array();
    $user_image = $row_stud['img'];
    $user_name = $row_stud['username'];
    $firstname = $row_stud['firstname'];
    $middlename = $row_stud['middlename'];
    $lastname = $row_stud['lastname'];
    $level_id = $row_stud['level_id'];
    $batch_id = $row_stud['batch_id'];
    $program_id = $row_stud['program_id'];
    $email = $row_stud['email'];

    if ($alumni_id === false) {
      header("location: ../login/sign-in.php");
      exit();
    }
  } else {
    session_destroy();
    header("location: ../login/sign-in.php");
    exit();
  }
} else {
  header("location: ../login/sign-in.php");
  exit();
}
