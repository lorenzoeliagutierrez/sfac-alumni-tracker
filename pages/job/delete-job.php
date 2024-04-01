<?php
include "../../includes/conn.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $jobId = mysqli_real_escape_string($db, $_GET['id']);

    $deleteQuery = "DELETE FROM tbl_job WHERE id = $jobId";

    if (mysqli_query($db, $deleteQuery)) {
        header("Location: job-display.php");
        exit();
    } else {
        echo "Error deleting job: " . mysqli_error($db);
    }
} else {
    header("Location: job-display.php");
    exit();
}
?>
