<?php
require_once '../connection.php';

session_start();  // Start the session to access session variables

$bio = $_POST['bio'];
$hob1 = $_POST['hob1'];
$hob2 = $_POST['hob2'];
$hob3 = $_POST['hob3'];
$hob4 = $_POST['hob4'];
$fav1 = $_POST['fav1'];
$fav2 = $_POST['fav2'];
$fav3 = $_POST['fav3'];
$fav4 = $_POST['fav4'];

try {
    $conn->beginTransaction();
    
    if (isset($_SESSION['customerID'])) {
        $customerID = $_SESSION['customerID']; // Retrieve the customerID from the session
    } else {
        // Handle the case where the customer is not logged in
        echo "You must be logged in to submit feedback.";
        exit(); // Exit the script
    }

    // Update customer information in tbl_customer_info without changing the dateAdded
    $updateAccount = $conn->prepare('UPDATE tbl_background_info 
    SET bio = ?, hobby1 = ?, hobby2 = ?, hobby3 = ?, hobby4 = ?, favorite1 = ?, favorite2 = ?, favorite3 = ?, favorite4 = ?
    WHERE customer_ID = ?');
    $updateAccount->execute([$bio, $hob1, $hob2, $hob3, $hob4, $fav1, $fav2, $fav3, $fav4, $customerID]);

    // Insert an activity log in tbl_activity_logs
    $insertActivity = $conn->prepare('INSERT INTO tbl_activity_logs (activity, customer_ID) VALUES (?, ?)');
    $insertActivity->execute(["Updated background info", $customerID]);

    $conn->commit();
    echo '<script>alert("Background Information Updated Successfully!");';
    echo 'window.location.href = "http://localhost/DevBugs/account_theme2.php";</script>';
} catch (\Throwable $th) {
    echo $th;
    $conn->rollBack();
}

?>