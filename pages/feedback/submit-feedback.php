<?php
include '../../includes/conn.php';
include '../../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];
    $rating = (int)$_POST['rating'];
    $anonymous = isset($_POST['anonymous']) ? 1 : 0;

    // Use prepared statement to prevent SQL injection
    $insertQuery = "INSERT INTO tbl_feedback (user, email, feedback, rating, anonymous) VALUES (?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $db->prepare($insertQuery);

    // Bind parameters
    $stmt->bind_param("ssssi", $user_name, $email, $feedback, $rating, $anonymous);

    // Execute the statement
    $result = $stmt->execute();

    if ($result) {
        // Successful insertion
        $_SESSION['feedback_added'] = 'Feedback Submitted Successfully!';
        header("location: feedback-form.php");
    } else {
        // Error in insertion
        echo "<script> alert('Error! Feedback unsuccessful.') </script>" . $db->error;
        echo "<script>document.location='feedback-form.php'</script>";
    }

    // Close the statement
    $stmt->close();
}
?>
