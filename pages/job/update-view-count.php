<?php

include "../../includes/conn.php";

if (isset($_GET['id'])) {
    $jobId = $_GET['id'];

    $result = $db->query("SELECT view_count FROM tbl_job WHERE id = $jobId");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentViewCount = $row['view_count'];

        $updatedViewCount = $currentViewCount + 1;
        $updateQuery = $db->query("UPDATE tbl_job SET view_count = $updatedViewCount WHERE id = $jobId");

        if ($updateQuery) {
            echo $updatedViewCount;
        } else {
            echo "Error updating view count";
        }
    } else {
        echo "Job not found";
    }
} else {
    echo "Invalid parameters";
}
?>
