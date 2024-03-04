
<?php
require_once '../connection.php';

session_start();  // Start the session to access session variables

$feedback = $_POST['feedback'];
$suggestion = $_POST['suggestion'];
$question = $_POST['question'];
$rating = $_POST['rating'];



try {
    $conn->beginTransaction();


    if (isset($_SESSION['customerID'])) {
        $customerID = $_SESSION['customerID']; // Retrieve the customerID from the session
    } else {
        // Handle the case where the customer is not logged in
        echo "You must be logged in to submit feedback.";
        exit(); // Exit the script
    }

    
    // Update feedback in tbl_feedback for the specified customer
    // $updateFeedback = $conn->prepare('UPDATE tbl_feedback SET feedback = ?, suggestion = ?, question = ?, rating = ? WHERE customer_ID = ?');
    // $updateFeedback->execute([$feedback, $suggestion, $question, $rating, $customerID]);

    // First, you need to insert the feedback into tbl_feedback with the retrieved customer ID
    $insertFeedback = $conn->prepare('INSERT INTO tbl_feedback (feedback, suggestion, question, rating, customer_ID) VALUES (?, ?, ?, ?, ?)');
    $insertFeedback->execute([$feedback, $suggestion, $question, $rating, $customerID]);

    // Insert an activity log in tbl_activity_logs
    $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
    $insertActivity->execute(["Sent feedback", $customerID]);

    $conn->commit();
    echo '<script>alert("Feedback Submitted!");';
    echo 'window.location.href = "http://localhost/DevBugs/home_theme1.php";</script>';

} catch (\Throwable $th) {
    echo $th;
    $conn->rollBack();
}
?>
















