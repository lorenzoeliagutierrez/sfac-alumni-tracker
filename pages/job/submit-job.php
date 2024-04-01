<?php
require '../../includes/conn.php';
include '../../includes/session.php';

$username = $_POST['user'];
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$job_name = $_POST['job_name'];
$job_desc = $_POST['job_desc'];
$edu_background = $_POST['edu_background'];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s A");

$sql = "INSERT INTO tbl_job (user, name, email, contact, job_name, job_desc, edu_background, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $db->prepare($sql);

$stmt->bind_param("ssssssss", $user_name, $name, $email, $contact, $job_name, $job_desc, $edu_background, $date);

if ($stmt->execute()) {
    $_SESSION['job_added'] = 'Job Submitted Successfully!';
    header("location: job-form.php");
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
    header("location: job-form.php");
}

$stmt->close();
?>