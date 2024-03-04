<?php
session_start();  // Start the session to access session variables

// Check if the user is logged in (you can adjust this based on your session variable)
if (isset($_SESSION['customerID'])) {
    // Replace these database connection details with your own
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cfms";

    try {
        // Create a PDO connection to your database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get the customer's first name and last name from the database based on the customer ID
        $customerID = $_SESSION['customerID'];

        $query = $conn->prepare("SELECT firstName, middleName, lastName, street, barangay, municipality, province, zipcode, birthdate, gender,
            phoneNumber, image FROM tbl_customer_info WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();

        // Fetch the user's information
        $user = $query->fetch(PDO::FETCH_ASSOC);

        $firstName = $user['firstName'];
        $middleName = $user['middleName'];
        $lastName = $user['lastName'];
        $street = $user['street'];
        $barangay = $user['barangay'];
        $municipality = $user['municipality'];
        $province = $user['province'];
        $zipcode = $user['zipcode'];
        // $day = $user['day'];
        // $month = $user['month'];
        // $year = $user['year'];
        $birthDate = $user['birthdate'];
        $gender = $user['gender'];
        $phoneNumber = $user['phoneNumber'];

        // $customerID = $_SESSION['customer_ID'];
        // $firstName = $user['firstName'];
        $image = $user['image'];


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
} else {
    // Handle the case where the user is not logged in
    echo "You must be logged in to view this page.";
    exit();  // Exit the script
}
?>







<?php
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="assets/css/boxicons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>DevBugs</title>
</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    <link rel="stylesheet" href="pages/home/style_h.css">

    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="" style="width: 7%; margin-left: 10px;">
            <img src="pages/home/LOGO.png" class="img-fluid" alt="">
        </div> 

        <div class="container-fluid">
            <a class="navbar-brand" id="logoname">Octawiz-Devbugs</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="m-2">
                    <button class="btn btn-dark" type="button" id="homeLink" onclick="to_home()" href="home_main.php">
                        Home
                    </button>
                    <button class="btn btn-dark" type="button" id="aboutUsLink" onclick="to_aboutUs()" href="aboutus_main.php">
                        About Us
                    </button>
                    <button class="btn btn-dark" type="button" id="contactUsLink" onclick="to_contactUs()" href="contactus_main.php">
                        Contact Us
                    </button>



                    <!-- <a onclick="to_home()" href="home_main.php" id="homeLink">Home</a> -->
                    <!-- <a onclick="to_aboutUs()" aria-current="page" id="aboutUsLink">About Us</a> -->
                    <!-- <a onclick="to_contactUs()" id="contactUsLink">Contact Us</a> -->


                    
                    <!-- <form style = "margin-left: 200px;">
                        <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" id="search">
                    </form> -->
                </div>
            </div>

            
            <button type="button" class="btn btn-secondary" id="openCustomerMessagesModalBtn" data-bs-toggle="modal" data-bs-target="#modal_customess"
                style="position: absolute; margin-left: 1030px; margin-top: 0px;"
                >Messages<span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                
                    <?php
                        $customerID = $_SESSION['customerID'];
                        // Fetch the count of new feedbacks for today
                        $sqlReply = "SELECT COUNT(reply_ID) AS replyCount FROM tbl_reply WHERE customer_ID = :customerID";
                        $stmtReply = $conn->prepare($sqlReply);
                        $stmtReply->bindParam(':customerID', $customerID, PDO::PARAM_INT); // Corrected the variable name here
                        $stmtReply->execute();
                        $replyCount = $stmtReply->fetchColumn();
                        echo $replyCount;
                    ?>

                    <span class="visually-hidden">unread messages</span>
                </span>
            </button>



            
            




            
            <?php
                $customerID = $_SESSION['customerID'];

                // Fetch the count of new feedbacks for today
                $sqlReply = "
                    SELECT COUNT(DISTINCT DATE(tbl_reply.date)) AS replyCount
                    FROM tbl_reply
                    WHERE customer_ID = :customerID
                ";
                $stmtReply = $conn->prepare($sqlReply);
                $stmtReply->bindValue(':customerID', $customerID, PDO::PARAM_INT);
                $stmtReply->execute();
                $replyCount = $stmtReply->fetchColumn();

                // $sqlReply = "SELECT COUNT(reply_ID) AS replyCount FROM tbl_reply
                //             WHERE customer_ID = :customerID";
                // $stmtReply = $conn->prepare($sqlReply);
                // $stmtReply->bindValue(':customerID', $customerID, PDO::PARAM_INT);
                // $stmtReply->execute();
                // $replyCount = $stmtReply->fetchColumn();

                // Fetch notifications from tbl_reply where the admin has messaged or replied
                $sqlNotifications = "
                    SELECT 
                        'Admin' AS Fullname,
                        reply AS Message,
                        date AS Date
                    FROM tbl_reply
                    WHERE customer_ID = :customerID
                    ORDER BY Date DESC
                ";
                $stmtNotifications = $conn->prepare($sqlNotifications);
                $stmtNotifications->bindParam(':customerID', $customerID);
                $stmtNotifications->execute();
                $notifications = $stmtNotifications->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <button type="button" class="btn btn-secondary position-relative" id="openCustomerNotifModalBtn" data-bs-toggle="modal" data-bs-target="#modal_customernotif" style="margin-right: 25px;">
                Notifications
                <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php echo $replyCount; ?>
                    <span class="visually-hidden">unread messages</span>
                </span>
            </button>

            <!-- CUSTOMER NOTIFICATIONS MODAL -- FOR VIEWING CUSTOMER NOTIFICATIONS -->
            <div class="modal fade" id="modal_customernotif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="margin-left: 500px; margin-top: -10px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="staticBackdropLabel" style="color: Black;">Notifications</h3>
                            <img src="pages/admin/GIF_NOTIFICATIONS.gif" style="width: 1.1in; height: .6in; margin-left: 0px; margin-top: 0px;" id="adminnotif_gif">
                        </div>

                        <div class="scrollable-content" id="inputfields" style="height: 500px; overflow-y: auto; color: black; background: lightgray;">
                            <div class="" style="position: relative;">
                                <?php
                                foreach ($notifications as $notification) {
                                    echo '<div class="row" style="background-color: white; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166);
                                        border-radius: 5px; font-size: 20px; width: 450px; margin-left: 15px; margin-top: 20px;">';

                                    echo '<p style="margin-top: 10px;"><strong>' . $notification['Fullname'] . '</strong> has messaged you.</p>';

                                    // Display relative date and time below
                                    echo '<p class="" style="color: blue; font-size: 15px; margin-top: -10px;">' . formatRelativeDate($notification['Date']) . '</p>';

                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="modal-footer" style="height: 70px;">
                            <button type="button" class="btn btn-primary" id="openCustomerReplyModalBtn" data-bs-toggle="modal" data-bs-target="#modal_customess" style="position: absolute; width: 100px; margin-right: 370px; margin-top: 5px">View all</button>
                            <button type="button" class="btn btn-secondary float-end" id="customernotif_closeModalBtn" data-bs-dismiss="modal" style="position: absolute; margin-top: 15px; margin-bottom: 15px; margin-right: 5px;">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openmodal_customernotif() {
                    $('#modal_customernotif').modal('show');
                }
            </script>
            <!-- END CUSTOMER NOTIFICATIONS MODAL -- FOR VIEWING CUSTOMER NOTIFICATIONS -->



            <!-- CUSTOMER MESSAGES MODAL -- FOR VIEWING CUSTOMER MESSAGES -->
            <div class="modal fade" id="modal_customess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="margin-left: 250px; margin-top: 20px;">
                <div class="modal-dialog">
                    <div class="modal-content bg-info">
                        <div class="modal-header">
                            <h3 class="modal-title" id="staticBackdropLabel" style="color: Black;">Messages</h3>
                        </div>

                        <div class="scrollable-content" id="messageContent" style="height: 450px; padding: 20px; overflow-y: auto; color: black;">
                            <div class="">

                                <?php
                                $customerID = $_SESSION['customerID'];

                                $sql = "SELECT 
                                        'Admin' AS Fullname,
                                        reply AS Message,
                                        date AS Date
                                    FROM tbl_reply
                                    WHERE customer_ID = :customerID

                                    UNION

                                    SELECT 
                                        CONCAT(firstName, ' ', lastName) AS Fullname,
                                        message AS Message,
                                        date AS Date
                                    FROM tbl_message
                                    WHERE customer_ID = :customerID

                                    ORDER BY Date DESC";

                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':customerID', $customerID);
                                $stmt->execute();
                                $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                ?>

                                <?php
                                // Output replies in the alternative design
                                foreach ($replies as $reply) {
                                    ?>
                                    <div class="reply-container">
                                        <div class="row" style="background-color: <?php echo ($reply["Fullname"] === 'Admin') ? '#f0ecff' : '#ecffed'; ?>; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166); border-radius: 15px; margin-bottom: 10px;">
                                            <strong class="reply-sender" style="margin-top: 10px;"><?php echo $reply["Fullname"]; ?></strong>
                                            <p class="reply-content" style="font-size: 20px;"><?php echo $reply["Message"]; ?></p>
                                        </div>
                                        <p class="reply-date text-muted" style="margin-bottom: 0px; color: blue;"><?php echo formatRelativeDate($reply["Date"]); ?></p>
                                    </div>

                                    <hr>
                                <?php
                                }

                                // Check if no messages found
                                if (empty($replies)) {
                                    echo "<p>No messages found</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <?php
                            // Function to format relative date and time
                            function formatRelativeDate($date)
                            {
                                $now = new DateTime();
                                $formattedDate = new DateTime($date);
                                $interval = $now->diff($formattedDate);

                                if ($interval->days == 0) {
                                    return 'Today @ ' . $formattedDate->format('h:i A'); // 12-hour format with AM/PM
                                } elseif ($interval->days == 1) {
                                    return 'Yesterday @ ' . $formattedDate->format('h:i A');
                                } else {
                                    return $interval->days . ' days ago at ' . $formattedDate->format('h:i A');
                                }
                            }
                        ?>

                        <div>
                            <button type="button" class="btn btn-primary" id="openCustomerReplyModalBtn" data-bs-toggle="modal" data-bs-target="#modal_customerreply" style="width: 150px; margin-left: 15px; margin-top: 15px"
                            >Reply</button>
                            <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px; margin-bottom: 15px; margin-right: 15px;" id="customess_closeModalBtn" data-bs-dismiss="modal"
                            >Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openmodal_customess() {
                    $('#modal_customess').modal('show');
                }
            </script>
            <!-- END CUSTOMER MESSAGES MODAL -- FOR VIEWING CUSTOMER MESSAGES -->







            <!-- CUSTOMER REPLY MESSAGE MODAL -- FOR REPLYING MESSAGES -->
            <div class="modal fade" id="modal_customerreply" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
                style="margin-left: 0px; margin-top: 150px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="row" id="messageContent" style="height: 230px; padding: 20px; overflow-y: auto; color: black;">
                            <!-- Previous messages here -->

                            <!-- Reply form -->
                            <form action="actions/insert_messreply.php" method="post">

                                <!-- Hidden input fields for additional information -->
                                <?php
                                // Fetch additional information from tbl_message based on customer_ID
                                if (isset($_SESSION['customerID'])) {
                                    $customerID = $_SESSION['customerID'];
                                    $sql = "SELECT firstName, lastName, email, contactNumber FROM tbl_message WHERE customer_ID = :customerID";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':customerID', $customerID);
                                    $stmt->execute();
                                    $customerInfo = $stmt->fetch(PDO::FETCH_ASSOC);
                                }
                                ?>

                                <!-- Display additional information -->
                                <?php if (isset($customerInfo)) : ?>
                                    <!-- Hidden input fields to include additional information in the form submission -->
                                    <input type="hidden" name="firstname" value="<?php echo $customerInfo['firstName']; ?>">
                                    <input type="hidden" name="lastname" value="<?php echo $customerInfo['lastName']; ?>">
                                    <input type="hidden" name="email" value="<?php echo $customerInfo['email']; ?>">
                                    <input type="hidden" name="contactnum" value="<?php echo $customerInfo['contactNumber']; ?>">
                                <?php endif; ?>

                                <!-- Form fields for the reply -->
                                <div class="form-group">
                                    <label class="text-muted" for="replyTextArea" style="margin-bottom: 10px;">Replying to: <strong class="replysender text-unmuted">Admin</strong></label>
                                    <textarea class="form-control" id="replyTextArea" name="message" rows="3" required></textarea>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Send Reply</button>
                                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 25px; margin-bottom: 0px; margin-right: 0px;" id="customess_closeModalBtn" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>

            <script>
                function openmodal_customerreply(replyId, customerId, senderName) {
                    // Set the message ID, customer ID, and sender name in the reply modal
                    $('#modal_customerreply').find('[name="reply_ID"]').val(replyId);
                    $('#modal_customerreply').find('[name="customer_ID"]').val(customerId);
                    $('#modal_customerreply').find('.reply-sender').text(senderName);

                    // Show the reply modal using Bootstrap's modal method
                    $('#modal_customerreply').modal('show');
                }
            </script>
            <!-- CUSTOMER REPLY MESSAGE MODAL -- FOR REPLYING MESSAGES -->


            <img src="images/<?php echo $image; ?>" class="img-fluid zoomable-image rounded-square" onclick="to_account()" style="width: 25px; height: 25px; border-radius: 12.5px;">

            <div class = " m-2 text-light" >   
                <b class = "bg-transparent "  id="accountLink" onclick="to_account()" style=" cursor: pointer;"> <img src="navigation/user.png" alt="">Account</b>
            </div>

        </div>
    </nav>





    
    <div class="body">
        <div class="container">

        
            <div class="row" style="position: absolute; margin-left: 1107px; margin-top: 20px; width: 300px; height: 581px; background: rgba(0, 0, 0, 0.3);">
            </div>
            <div class="row" style="position: absolute; margin-left: 1107px; margin-top: 177px; width: 300px; height: 320px; background: rgba(255, 255, 255, 0.2);">
            </div>

            
            
            <div class="row">
                <img src="pages/home/BUBBLE_FORMS.png" style="position: absolute; width: 75%; margin-left: -58px; margin-top: 30px;
                    filter: drop-shadow(0px 20px 50px rgba(20, 20, 20, 20));">

                <img src="pages/home/ICON_FEEDBACK.png" style="position: absolute; width: 10%; margin-left: 300px; margin-top: 30px;
                    filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20));">
                <!-- <img src="pages/home/ICON_QUESTION.png" style="position: absolute; width: 7%; margin-left: 990px; margin-top: 35px;
                    filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20)); transform: rotate(15deg);"> -->
                <img src="pages/home/ICON_QUESTION.png" style="position: absolute; width: 7%; height: 18%; margin-left: 980px; margin-top: 45px;
                    filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20)); transform: rotate(5deg);">
                <img src="pages/home/ICON_SUGGESTION.png" style="position: absolute; width: 11%; margin-left: 650px; margin-top: 395px;
                    filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20)); transform: rotate(0deg);">

                <img src="pages/home/ICON_1STAR.png" name="rating" value="1" id="star1" onclick="setRating(1)">
                <img src="pages/home/ICON_2STAR.png" name="rating" value="2" id="star2" onclick="setRating(2)">
                <img src="pages/home/ICON_3STAR.png" name="rating" value="3" id="star3" onclick="setRating(3)">
                <img src="pages/home/ICON_4STAR.png" name="rating" value="4" id="star4" onclick="setRating(4)">
                <img src="pages/home/ICON_5STAR.png" name="rating" value="5" id="star5" onclick="setRating(5)">
                
                <img src="pages/home/ICON_WHITE_PIE.png" style="position: absolute; margin-left: 1107px; margin-top: 415px; width: 110px; opacity: 25%">

                <script>
                    function setRating(value) {
                        // Set the value of the rating input
                        document.getElementById('box4').value = value;

                        // You can also add visual feedback like highlighting the selected stars
                        for (let i = 1; i <= 5; i++) {
                            const star = document.getElementById(`star${i}`);
                            if (i <= value) {
                                // Highlight the selected stars
                                star.classList.add('selected');
                            } else {
                                // Remove highlight from unselected stars
                                star.classList.remove('selected');
                            }
                        }
                    }
                </script>

                <img src="pages/home/ICON_RATEUS.png" style="position: absolute; width: 9%; margin-left: 1275px; margin-top: 200px;
                    filter: drop-shadow(0px 20px 50px rgba(20, 20, 20, 20)); transform: rotate(8deg);">

                <form id="feedback_form" method="POST" action="actions/insert_feedback.php">
                    
                    <textarea name="feedback" id="box1" placeholder="Type your feedback here"></textarea>
                    <textarea name="suggestion" id="box2" placeholder="Type your suggestion here"></textarea>
                    <textarea name="question" id="box3" placeholder="Type your question here"></textarea>
                    <input name="rating" id="box4">

                    <div class="bg-transparent text-center">
                        <!-- <button type="submit" class="bg-light" id="checkdone" style="width: 130px;">Check Done</button> -->
                        <button type="submit" class="btn btn-primary" id="submit_feeback" data-bs-toggle="modal" data-bs-target="#modal_submit_feedback"
                            style="position: absolute; font-size: 22px; margin-top: 520px; margin-left: 500px; width: 220px; height: 50px; border-radius: 35px;">
                            <b>Submit Feedback</b>
                        </button>
                    </div>


                </form>
                    

                <div class="home_leftbuttons">
                    <div class="col bg-transparent">
                        <p> </p>
                    </div>
                        
                    <div class="bg-transparent text-center">
                        <!-- <button class="bg-light" id="checkfeatures" style="width: 130px;">Check Feature</button> -->
                        <button type="button" class="btn btn-primary" id="openCheckFeaturesModalBtn" data-bs-toggle="modal" data-bs-target="#modal_checkfeatures"
                            style="position: absolute; width: 220px; height: 50px; margin-top: 25px; margin-left: 500px; border-radius: 25px;">
                            Features
                        </button>
                    </div>
                    <div class="col bg-transparent">
                        <p> </p>
                    </div>
                    <div class="bg-transparent text-center">
                        <!-- <button class="bg-light" id="checkhistory" style="width: 130px;">Check History</button> -->
                        <button type="button" class="btn btn-primary" id="openCheckHistoryModalBtn" data-bs-toggle="modal" data-bs-target="#modal_checkhistory"
                            style="position: absolute; width: 220px; height: 50px; margin-top: 90px; margin-left: 500px; border-radius: 25px;">
                            History
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>




    





    <!-- CHECK FEATURES MODAL -- FOR CHECKING FEATURES -->
    <div class="modal fade custom-fade" id="modal_checkfeatures" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="header"> <!--DON'T USE MODAL-HEADER, HEADER ONLY-->
                    <div class="row">
                        <h1 class="modal-title" id="staticBackdropLabel" style="margin-left: 15px;">Features</h1>
                    </div>
                    <div class="row">
                        <h style="margin-top: 5px; margin-left: 15px;">Explore our designed key features for a more convenient<br>customer experience.</h>
                    </div>
                </div>

                <div class="modal-body">
                    
                    <div class="scrollable-content" id="inputfields" style="height: 350px; overflow-y: auto;">

                        <div class="card-body">

                            <div class="d-flex justify-content-center">
                                    
                                <div class="col-6">
                                    <!-- <div class="card border-0" id="t" style="margin-left: -10px; margin-right: 10px;"> -->
                                    <div class="card-body text-center">
                                            <img src="pages/home/ICON_DASHBOARD.png" style="width: 1.6in; height: 1.6in; margin-left: -30px; margin-top: 15px;" id="db_icon" alt="..."
                                            id="openDashboardModalBtn" data-bs-toggle="modal" data-bs-target="#modal_dashboard">
                                        </div>
                                    <!-- </div> -->
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted" style="margin-left: -20px;">Dashboard</h6>
                                    </div>
                                </div>
                                <div class="col-0">
                                </div>
                                <div class="col-6">
                                    <!-- <div class="card border-0" id="vm" style="margin-left: -10px; margin-right: 10px;"> -->
                                    <div class="card-body text-center">
                                            <img src="pages/home/ICON_BELL.png" style="width: 1.8in; height: 1.8in; margin-left: -20px;" id="alnot_icon" alt="...">
                                        </div>
                                    <!-- </div> -->
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted" style="margin-top: -8px;">Alerts and Notifications</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                    
                                <div class="col-6">
                                    <!-- <div class="card border-0" id="vm" style="margin-left: -10px; margin-right: 10px;"> -->
                                        <div class="card-body text-center">
                                            <img src="pages/home/ICON_VOICEFEEDBACK.png" style="width: 1.8in; height: 1.8in; margin-left: -5px;" id="vm_icon" alt="..."
                                            id="openVoiceFeedbackModalBtn" data-bs-toggle="modal" data-bs-target="#modal_voicefeedback">
                                        </div>
                                    <!-- </div> -->
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted" style="margin-left: -10px;">Voice Feedback</h6>
                                    </div>
                                </div>
                                <div class="col-0">
                                </div>
                                <div class="col-6">
                                    <!-- <div class="card border-0" id="t" style="margin-left: -10px; margin-right: 10px;"> -->
                                        <div class="card-body text-center">
                                            <img src="pages/home/ICON_THEMES.png" style="width: 1.8in; height: 1.8in; margin-left: -20px;" id="t_icon" alt="..."
                                            id="openThemesModalBtn" data-bs-toggle="modal" data-bs-target="#modal_theme">
                                        </div>
                                    <!-- </div> -->
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Themes</h6>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px;" id="features_theme_closeModalBtn" data-bs-dismiss="modal">Close</button>
                            
                </div>
            
            </div>
        </div>
    </div>
    <!-- END CHECK FEATURES MODAL -- FOR CHECKING FEATURES -->

    <button type="button" class="btn btn-secondary" id="openVoiceFeedbackModalBtn" data-bs-toggle="modal" data-bs-target="#modal_voicefeedback"
        style="position: absolute; width: 250px; height: 70px; margin-top: -90px; margin-left: 20px; border-radius: 20px; font-size: 25px;">
        Voice Feedback
    </button>

    <img src="pages/home/ICON_VOICEFEEDBACK.png" style="position: absolute; width: .9in; height: .9in; margin-left: 230px; margin-top: -140px; padding: -100px;" id="" alt="..."
    id="openVoiceFeedbackModalBtn" data-bs-toggle="modal" data-bs-target="#modal_voicefeedback">
    
   

    <!-- DASHBOARD MODAL -- FOR VIEWING DASHBOARD -->
    <div class="modal fade" id="modal_dashboard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 1400px; max-height: 1000px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="staticBackdropLabel" style="color: black; margin-left: 10px;">Customer Dashboard</h1>
                    <h3 style="margin-right: 10px;"><?php echo $firstName; ?></h1>
                </div>
                <div class="modal-body" id="dashbody">  <!-- BODY COLOR -->
                    <!-- <form id="feedback_history_form" method="POST" action="actions/change_password.php"> -->
                    <h style="margin-top: 5px; margin-left: 10px;">See our latest trends</h>
                    
                    <div class="scrollable-content" id="inputfields" style="height: 450px; overflow-y: auto;">

                        <div class="card-body" id="cards_row1"> <!--BLUE-->
                        
                            <h5 style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">Today's data</h5>

                            <div class="d-flex justify-content-center" style="padding: 20px;"> <!-- RED -->

                                <div class="col-3 d-flex justify-content-center">
                                    <?php

                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                        // Step 2: Fetch all data from tbl_feedback with column aliases
                                        $sql = "SELECT COUNT(feedback_ID) AS feedbackCount
                                                FROM tbl_feedback WHERE DATE(date) = CURDATE()";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $feedbackCount = $result['feedbackCount'];
                                    ?>
                                    
                                    <div class="card border-0" id="card1">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 70px;">New Feedbacks</h6>
                                                <img src="pages/home/GIF_NEWFB.gif" style="width: 1.4in; height: .80in; margin-left: 117px; margin-top: -27px;" id="newfb_gif">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                

                                <div class="col-3 d-flex justify-content-center">
                                    <?php

                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                        // Step 2: Fetch all data from tbl_customer_info with column aliases
                                        $sql = "SELECT COUNT(feedback_ID) AS feedbackCount FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $feedbackCount = $result['feedbackCount'];
                                    ?>
                                    
                                    <div class="card border-0" id="card2">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 70px;">Total Feedbacks</h6>
                                                <img src="pages/home/GIF_TOTALFB.gif" style="width: 1.5in; height: .80in; margin-left: 105px; margin-top: -20px;" id="totalfb_gif">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>


                                <div class="col-3 d-flex justify-content-center">
                                    <?php

                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                        // Step 2: Fetch all data from tbl_feedback with column aliases
                                        $sql = "SELECT feedbackDate, ROUND(AVG(feedbackCount), 1) AS feedbackAverage
                                        FROM (
                                            SELECT DATE(date) AS feedbackDate, COUNT(*) AS feedbackCount
                                            FROM tbl_feedback
                                            GROUP BY DATE(date)
                                        ) AS subquery";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();


                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $feedbackAverage = $result['feedbackAverage'];
                                    ?>
                                    
                                    <div class="card border-0" id="card3">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackAverage; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 70px;">Feedbacks a day</h6>
                                                <img src="pages/home/GIF_FBPERDAY.gif" style="width: 1.4in; height: .85in; margin-left: 117px; margin-top: -20px;" id="fbperday_gif">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>


                                <div class="col-3 d-flex justify-content-center">
                                    <?php

                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_customer_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                        // Step 2: Fetch all data from tbl_customer_info with column aliases
                                        $sql = "SELECT COUNT(customer_ID) AS customerCount FROM tbl_customer_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $customerCount = $result['customerCount'];
                                    ?>
                                    
                                    <div class="card border-0" id="card4">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $customerCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 70px;">Customers</h6>
                                                <img src="pages/home/GIF_CUSTOMERS.gif" style="width: 1.2in; height: .7in; margin-left: 135px; margin-top: -15px;" id="customers_gif">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>




                            <div class="d-flex justify-content-center" style="padding: 20px;"> <!-- GREEN COLOR -->

                                <div class="col-3 d-flex justify-content-center">
                                    <?php

                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                        // Step 2: Fetch all data from tbl_feedback with column aliases
                                        $sql = "SELECT COUNT(*) AS ratingCount
                                            FROM tbl_feedback WHERE rating = 5;";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $ratingCount = $result['ratingCount'];
                                    ?>
                                    
                                    <div class="card border-0" id="card5">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $ratingCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 70px;">5-Rating</h6>
                                                <img src="pages/home/GIF_RATING.gif" style="width: 1.65in; height: .90in; margin-left: 90px; margin-top: -20px;" id="rating_gif">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-3 d-flex justify-content-center">
                                </div>
                                <div class="col-3 d-flex justify-content-center">
                                </div>
                                <div class="col-3 d-flex justify-content-center">
                                </div>
                                
                            </div>

                        </div> <!--BLUE-->



                        <div class="card-body" id="cards_row1"> <!--BLUE-->

                            <!-- for pie chart -->

                        </div>



                        


                    </div>

                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px;" id="dashboard_closeModalBtn" data-bs-dismiss="modal">Close</button>
                    
                </div> <!--BODY END -->
            </div>
        </div>
    </div>

    <script>
    function openmodal_dashboard() {
        $('#modal_dashboard').modal('show');
    }
    </script>
    <!-- END DASHBOARD MODAL -- FOR VIEWING DASHBOARD -->




    <!-- VOICE MESSAGE MODAL -- FOR RECORDING VOICE MESSAGE -->
    <div class="modal fade" id="modal_voicefeedback" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: gray; border-radius: 40px;">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                    <!-- <img src="pages/home/ICON_VOICEFEEDBACK.png" style="position: absolute; width: 1in; height: 1in; margin-left: 185px; margin-top: -35px; filter: drop-shadow(5px 5px 5px #444444);" alt="..."> -->
                    <!-- <img src="pages/home/ICON_MIC1.gif" style="position: absolute; width: 2in; margin-left: 133px; margin-top: -35px;" alt="..."> -->
                    <img src="pages/home/ICON_MIC2.gif" style="position: absolute; width: 2in; margin-left: 134px; margin-top: -40px;" alt="...">

                    <h3 class="modal-title" id="voiceMessageModalLabel" style="margin-left: 130px; margin-top: 110px; color: white;"
                    >Voice Feedback</h3>
                </div>
                <div class="modal-body">
                    <span id="timer" style="color: white;">00:00:00</span>
                    <audio id="audioPlayer" controls></audio>
                    <button class="btn btn-light" id="startRecording">Start</button>
                    <button class="btn btn-secondary" id="pauseRecording" disabled>Pause</button>
                    <button class="btn btn-secondary" id="stopRecording" disabled>Stop</button>

                    <img src="pages/home/ICON_TRASH.png" id="trash" style="position: absolute; width: .4in; margin-left: 220px; margin-top: 10px;
                        transition: transform 0.2s;" alt="...">
                        

                        <script>
                            let audioChunks = []; // Declare audioChunks globally

                            document.addEventListener('DOMContentLoaded', () => {
                                const startRecordingButton = document.getElementById('startRecording');
                                const pauseRecordingButton = document.getElementById('pauseRecording');
                                const stopRecordingButton = document.getElementById('stopRecording');
                                const sendRecordingButton = document.getElementById('sendRecording');
                                const timerDisplay = document.getElementById('timer');
                                const audioPlayer = document.getElementById('audioPlayer');
                                const trashIcon = document.getElementById('trash');

                                let mediaRecorder;
                                let timerInterval;
                                let seconds = 0;
                                let minutes = 0;
                                let hours = 0;

                                startRecordingButton.addEventListener('click', startRecording);
                                pauseRecordingButton.addEventListener('click', pauseRecording);
                                stopRecordingButton.addEventListener('click', stopRecording);
                                sendRecordingButton.addEventListener('click', sendRecording);
                                trashIcon.addEventListener('click', resetRecording);

                                function startRecording() {
                                    navigator.mediaDevices.getUserMedia({ audio: true })
                                        .then(stream => {
                                            mediaRecorder = new MediaRecorder(stream);

                                            mediaRecorder.ondataavailable = event => {
                                                if (event.data.size > 0) {
                                                    audioChunks.push(event.data);
                                                }
                                            };

                                            mediaRecorder.onstop = () => {
                                                const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                                                const audioUrl = URL.createObjectURL(audioBlob);
                                                audioPlayer.src = audioUrl;
                                                resetButtons();
                                            };

                                            mediaRecorder.start();
                                            startRecordingButton.disabled = true;
                                            pauseRecordingButton.disabled = false;
                                            stopRecordingButton.disabled = false;
                                            sendRecordingButton.disabled = true;

                                            // Start the timer
                                            timerInterval = setInterval(updateTimer, 1000);
                                        })
                                        .catch(err => console.error('Error accessing microphone:', err));
                                }

                                function pauseRecording() {
                                    if (mediaRecorder && mediaRecorder.state === 'recording') {
                                        mediaRecorder.pause();
                                        pauseRecordingButton.textContent = 'Resume';
                                        stopRecordingButton.disabled = false;
                                        clearInterval(timerInterval);
                                    } else if (mediaRecorder && mediaRecorder.state === 'paused') {
                                        mediaRecorder.resume();
                                        pauseRecordingButton.textContent = 'Pause';
                                        stopRecordingButton.disabled = false;
                                        // Resume the timer
                                        timerInterval = setInterval(updateTimer, 1000);
                                    }
                                }

                                function stopRecording() {
                                    if (mediaRecorder && (mediaRecorder.state === 'recording' || mediaRecorder.state === 'paused')) {
                                        mediaRecorder.stop();
                                    }
                                }

                                function sendRecording() {
                                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                                    const formData = new FormData();
                                    formData.append('audioData', audioBlob, 'voice_message.wav');

                                    fetch('actions/store_audio.php', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(response => {
                                        console.log('Response Status:', response.status);
                                        return response.text();
                                    })
                                    .then(message => {
                                        console.log('Server Message:', message);
                                        // Optionally, you can show a success message to the user
                                    })
                                    .catch(error => {
                                        console.error('Error sending audio data:', error);
                                        // Handle the error appropriately
                                    });
                                }

                                function updateTimer() {
                                    seconds++;
                                    if (seconds === 60) {
                                        seconds = 0;
                                        minutes++;
                                        if (minutes === 60) {
                                            minutes = 0;
                                            hours++;
                                        }
                                    }
                                    timerDisplay.textContent = formatTime(hours, minutes, seconds);
                                }

                                function formatTime(hours, minutes, seconds) {
                                    return `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
                                }

                                function pad(number) {
                                    return (number < 10) ? `0${number}` : number;
                                }

                                function resetButtons() {
                                    startRecordingButton.disabled = false;
                                    pauseRecordingButton.disabled = true;
                                    stopRecordingButton.disabled = true;
                                    sendRecordingButton.disabled = false;
                                    clearInterval(timerInterval);
                                    resetTimer();
                                }

                                function resetTimer() {
                                    seconds = 0;
                                    minutes = 0;
                                    hours = 0;
                                    timerDisplay.textContent = '00:00:00';
                                }

                                function resetRecording() {
                                    if (mediaRecorder && (mediaRecorder.state === 'recording' || mediaRecorder.state === 'paused')) {
                                        mediaRecorder.stop();
                                    }
                                    audioChunks = [];
                                    audioPlayer.src = '';
                                    resetButtons();
                                }
                            });

                            // Declare openmodal_voicefeedback outside of the DOMContentLoaded event
                            function openmodal_voicefeedback() {
                                $('#modal_voicefeedback').modal('show');
                            }
                        </script>


                    <button class="btn btn-primary" id="sendRecording" style="border: 1px solid lightblue;" disabled>Send Voice Feedback</button>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openmodal_voicefeedback() {
            $('#modal_voicefeedback').modal('show');
        }

        function sendRecording() {
            const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
            const formData = new FormData();
            formData.append('audioData', audioBlob, 'voice_message.wav');

            fetch('actions/store_audio.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response Status:', response.status);
                return response.text();
            })
            .then(message => {
                console.log('Server Message:', message);
                // Optionally, you can show a success message to the user
            })
            .catch(error => {
                console.error('Error sending audio data:', error);
                // Handle the error appropriately
            });
        }
    </script>
    <!-- END VOICE MESSAGE MODAL -- FOR RECORDING VOICE MESSAGE -->




    <!-- APPEARANCE AND THEME MODAL -- FOR CHANGING APPEARANCE AND THEME -->
    <div class="modal fade" id="modal_theme" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel">Appearance and Theme</h3>
                    <img src="pages/account/GIF_THEMES.gif" style="width: 1.6in; height: .9in; margin-right: -15px;" id="password_gif">
                </div>
                <div class="modal-body">
                    <!-- <form id="feedback_history_form" method="POST" action="actions/change_password.php"> -->
                    <h style="margin-top: 5px; margin-left: 10px;">Choose your theme:</h>
                    
                    <div class="scrollable-content" id="inputfields" style="height: 400px; overflow-y: auto;">

                            

                        <div class="card-body">

                            <div class="d-flex justify-content-center">
                                    
                                <div class="col-6">
                                    <div class="card border-0" id="default" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_DEFAULT.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Default</h6>
                                    </div>
                                </div>
                                <div class="col-0">
                                </div>
                                <div class="col-6">
                                    <div class="card border-0" id="theme1" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_THEME1.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Blue Water</h6>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-body" style="margin-top: -30px;">

                            <div class="d-flex justify-content-center">
                                    
                                <div class="col-6">
                                    <div class="card border-0" id="theme2" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_THEME2.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Green Archers</h6>
                                    </div>
                                </div>
                                <div class="col-0">
                                </div>
                                <div class="col-6">
                                    <div class="card border-0" id="theme3" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_THEME3.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Cold Blocks</h6>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                        
                        <div class="card-body" style="margin-top: -30px;">

                            <div class="d-flex justify-content-center">
                                    
                                <div class="col-6">
                                    <div class="card border-0" id="theme4" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_THEME4.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Great Wizard</h6>
                                    </div>
                                </div>
                                <div class="col-0">
                                </div>
                                <div class="col-6">
                                    <div class="card border-0" id="theme5" style="margin-left: 10px; margin-right: 10px;">
                                        <div class="card-body text-center">
                                            <img src="pages/account/BG_THEME5.png" style="width: 1.63in; height: 1in;" id="img" alt="...">
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-subtitle mb-2 text-muted">Red Bug</h6>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <script>
                            // Add a click event handler for the "Default" card
                            document.getElementById('default').addEventListener('click', function() {
                                // Close the modal here (you need to provide modal closing code)
                                $('#modal_appearanceandtheme').modal('hide');
                                alert("No changes made");
                            });

                            // Add a click event handler for the "Theme1" card
                            document.getElementById('theme1').addEventListener('click', function() {
                                // Redirect to home_theme1.php
                                window.location.href = 'home_theme1.php';
                                alert("Your theme is successfully changed to Blue Water!");
                            });

                            // Add a click event handler for the "Theme2" card
                            document.getElementById('theme2').addEventListener('click', function() {
                                // Redirect to home_theme2.php
                                window.location.href = 'home_theme2.php';
                                alert("Your theme is successfully changed to Green Archers!");
                            });

                            // Add a click event handler for the "Theme3" card
                            document.getElementById('theme3').addEventListener('click', function() {
                                // Redirect to home_theme3.php
                                window.location.href = 'home_theme3.php';
                                alert("Your theme is successfully changed to Cold Blocks!");
                            });

                            // Add a click event handler for the "Theme2" card
                            document.getElementById('theme4').addEventListener('click', function() {
                                // Redirect to home_theme4.php
                                window.location.href = 'home_theme4.php';
                                alert("Your theme is successfully changed to Great Wizard!");
                            });

                            // Add a click event handler for the "Theme3" card
                            document.getElementById('theme5').addEventListener('click', function() {
                                // Redirect to home_theme5.php
                                window.location.href = 'home_theme5.php';
                                alert("Your theme is successfully changed to Red Bug!");
                            });
                        </script>


                    </div>
                    <!-- <button type="submit" class="submit" name="submit" id="sett_cyp_modalsave">Save</button> -->

                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px;" id="sett_aat_closeModalBtn" data-bs-dismiss="modal">Close</button>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>

    <script>
    function openmodal_theme() {
        $('#modal_theme').modal('show');
    }
    </script>
    <!-- END APPEARANCE AND THEME MODAL -- FOR CHANGING APPEARANCE AND THEME -->





    <!-- CHECK HISTORY MODAL -- FOR CHECKING HISTORY -->
    <div class="modal fade" id="modal_checkhistory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="header"> <!--DON'T USE MODAL-HEADER, HEADER ONLY-->
                    <h1 class="modal-title" id="staticBackdropLabel" style="margin-left: 20px; margin-top: 30px; margin-bottom: -25px; line-height: 1.1;"
                    >Feedback<br>History</h1>
                    <img src="pages/home/GIF_FBHISTORY.gif" style="width: 2in; height: 1.15in; margin-left: 300px; margin-top: -80px;" id="fbhistory_gif">
                <div>
                </div class="row">
                    <!-- <h style="margin-top: 5px; margin-left: 15px;"><?php echo 'all of <b>' . $firstName . ' ' . $middleName. ' ' . $lastName . '</b>\'s submitted feedbacks<br>'; ?></h> -->
                </div>
                <hr>
                <div class="modal-body">
                    <div class="scrollable-content" id="inputfields" style="height: 400px; overflow-y: auto;">

                        <?php
                            // Make sure you have the customer ID from the session
                            $customerID = $_SESSION['customerID'];

                            // Modify your SQL query to filter data for the current customer user
                            $sql = "SELECT 
                                        feedback AS 'Feedback',
                                        suggestion AS 'Suggestion',
                                        question AS 'Question',
                                        rating AS 'Rating',
                                        date AS 'Date'
                                    FROM tbl_feedback
                                    WHERE customer_ID = :customerID
                                    ORDER BY date DESC";

                            // Prepare and execute the query with the customer ID as a parameter
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
                            $stmt->execute();

                            // Fetch the data for the current customer user
                            $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        ?>

                        <!-- Step 4: Display data in the table format with renamed columns -->
                        <div class="scrollable-content" id="inputfields" style="max-height: 400px; overflow-y: auto;">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered" style="color: black;">
                                        <thead>
                                            <tr>
                                                <?php
                                                // Display column aliases as headers
                                                $aliasRow = $customerData[0]; // Assuming the first row contains aliases

                                                foreach ($aliasRow as $alias => $value) {
                                                    echo "<th style='background-color: white; color: black;'>$alias</th>";
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Loop through the data and populate the table
                                            foreach ($customerData as $row) {
                                                echo "<tr>";
                                                foreach ($row as $value) {
                                                    echo "<td>$value</td>";
                                                }
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- <button type="submit" class="submit" name="submit" id="sett_cyp_modalsave">Save</button> -->

                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px;" id="sett_h_closeModalBtn" data-bs-dismiss="modal">Close</button>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>

    <script>
    function openmodal_checkhistory() {
        $('#modal_checkhistory').modal('show');
    }
    </script>
    <!-- END CHECK HISTORY MODAL -- FOR CHECKING HISTORY -->







    

  <!-- <button type="submit" class="submit" name="submit" id="feedbacksubmit">Submit Forms</button> -->
<!-- </form> -->


<!-- <script>
    // JavaScript to control the form submission for Check Done
    document.getElementById("checkdone").addEventListener("click", function() {
        document.getElementById("feedbacksubmit").click();
    });

    // JavaScript to prevent form submission for Create New, Check Feature, and Check History
    document.getElementById("createnew").addEventListener("click", function(e) {
        e.preventDefault();
    });
    document.getElementById("checkfeature").addEventListener("click", function(e) {
        e.preventDefault();
    });
    document.getElementById("checkhistory").addEventListener("click", function(e) {
        e.preventDefault();
    });
</script> -->


    <!-- <script>
        // Function to underline a link and remove underline from others
        function underlineLink(linkId) {
            const links = ["homeLink", "aboutUsLink", "contactUsLink", "accountLink"];

            for (const id of links) {
                const link = document.getElementById(id);
                if (id === linkId) {
                    link.style.textDecoration = "underline";
                } else {
                    link.style.textDecoration = "none";
                }
            }
        }

        underlineLink("homeLink");

        document.getElementById("aboutUsLink").addEventListener("click", function() {
            underlineLink("aboutUsLink");
        });

        document.getElementById("contactUsLink").addEventListener("click", function() {
            underlineLink("contactUsLink");
        });

        document.getElementById("accountLink").addEventListener("click", function() {
            underlineLink("accountLink");
        });
        
    </script> -->







<!-- <a id="admin" href="http://localhost/DevBugs/admin_main.php" >Admin</a> -->









</body>
</html>

<script>
    function to_navigation() {
$.post("pages/nav/nav.php", {},function (data) {
      $("#contents").html(data);  
    });
}  
</script>


<script>
    function to_home() {
        window.location.href = 'home_main.php';
    }
</script>

<script>
    function to_aboutUs() {
        window.location.href = 'aboutus_main.php';
    }
</script>

<script>
    function to_contactUs() {
        window.location.href = 'contactus_main.php';
    }
</script>

<script>
    function to_account() {
        window.location.href = 'account_main.php';
    }
</script>

<script>
    function to_settings() {
        window.location.href = 'settings_main.php';
    }
</script>





<script>
    function to_home_t1() {
        window.location.href = 'home_theme1.php';
    }
</script>

<script>
    function to_aboutUs_t1() {
        window.location.href = 'aboutus_theme1.php';
    }
</script>

<script>
    function to_contactUs_t1() {
        window.location.href = 'contactus_theme1.php';
    }
</script>

<script>
    function to_account_t1() {
        window.location.href = 'account_theme1.php';
    }
</script>

<script>
    function to_settings_t1() {
        window.location.href = 'settings_theme1.php';
    }
</script>



<script>
    function to_home_t2() {
        window.location.href = 'home_theme2.php';
    }
</script>

<script>
    function to_aboutUs_t2() {
        window.location.href = 'aboutus_theme2.php';
    }
</script>

<script>
    function to_contactUs_t2() {
        window.location.href = 'contactus_theme2.php';
    }
</script>

<script>
    function to_account_t2() {
        window.location.href = 'account_theme2.php';
    }
</script>

<script>
    function to_settings_t2() {
        window.location.href = 'settings_theme2.php';
    }
</script>







<script>
    function to_home_t3() {
        window.location.href = 'home_theme3.php';
    }
</script>

<script>
    function to_aboutUs_t3() {
        window.location.href = 'aboutus_theme3.php';
    }
</script>

<script>
    function to_contactUs_t3() {
        window.location.href = 'contactus_theme3.php';
    }
</script>

<script>
    function to_account_t3() {
        window.location.href = 'account_theme3.php';
    }
</script>

<script>
    function to_settings_t3() {
        window.location.href = 'settings_theme3.php';
    }
</script>


<script>
    function to_home_t4() {
        window.location.href = 'home_theme4.php';
    }
</script>

<script>
    function to_aboutUs_t4() {
        window.location.href = 'aboutus_theme4.php';
    }
</script>

<script>
    function to_contactUs_t4() {
        window.location.href = 'contactus_theme4.php';
    }
</script>

<script>
    function to_account_t4() {
        window.location.href = 'account_theme4.php';
    }
</script>

<script>
    function to_settings_t4() {
        window.location.href = 'settings_theme4.php';
    }
</script>







<script>
    function to_home_t5() {
        window.location.href = 'home_theme5.php';
    }
</script>

<script>
    function to_aboutUs_t5() {
        window.location.href = 'aboutus_theme5.php';
    }
</script>

<script>
    function to_contactUs_t5() {
        window.location.href = 'contactus_theme5.php';
    }
</script>

<script>
    function to_account_t5() {
        window.location.href = 'account_theme5.php';
    }
</script>

<script>
    function to_settings_t5() {
        window.location.href = 'settings_theme5.php';
    }
</script>








<script>
    function to_login() {
$.post("login_main.php", {},function (data) {
      $("#contents").html(data);  
    });
}   
</script>





<!-- 
<div class="container-fluid">
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="pages/home/DEVBUGS (FEEDBACK).png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="pages/home/DEVBUGS (FEEDBACK).png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="pages/home/DEVBUGS (FEEDBACK).png" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

<br/><br/><br/><br/> -->















