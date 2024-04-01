<?php
include('../../../includes/conn.php');

if (isset($_POST['comment_id'])) {
    $commentId = $_POST['comment_id'];

    // Implement your logic to delete the comment from the database
    $deleteQuery = "DELETE FROM tbl_forum WHERE id = $commentId";
    $result = mysqli_query($db, $deleteQuery);

    if ($result) {
        // Send a success response if the deletion was successful
        echo json_encode(['status' => 'success']);
    } else {
        // Send an error response if the deletion failed
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete comment']);
    }
} else {
    // Send an error response if the comment_id is not set
    echo json_encode(['status' => 'error', 'message' => 'Comment ID not provided']);
}
?>
