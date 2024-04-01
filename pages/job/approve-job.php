<?php
require '../../includes/conn.php';

if (isset($_GET['id'])) {
    $approved_job_id = $_GET['id'];

    // Update request_id to 1 for the approved job
    $update_sql = "UPDATE tbl_job SET request_id = 1 WHERE id = ?";
    $update_stmt = $db->prepare($update_sql);
    $update_stmt->bind_param("i", $approved_job_id);

    if ($update_stmt->execute()) {
        header("location: job-request.php");
    } else {
        echo "Error: " . $update_sql . "<br>" . $db->error;
        header("location: job-request.php");
    }

    $update_stmt->close();
}
?>