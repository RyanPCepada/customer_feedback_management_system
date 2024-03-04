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
            phoneNumber, password, image FROM tbl_customer_info WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();


        //FETCH ACTIVITY LOGS FOR HISTORY LIST
        // $sql1 = "SELECT activity FROM tbl_activity_logs WHERE activity = 'Submitted feedback' OR activity = 'Updated the profile'";
        $sql1 = "SELECT activity FROM tbl_activity_logs WHERE customer_ID = $customerID";
        $sql2 = "SELECT dateAdded FROM tbl_activity_logs WHERE customer_ID = $customerID";
        // Prepare and execute the query
        $stmt1 = $conn->prepare($sql1);
        $stmt2 = $conn->prepare($sql2);
        $stmt1->execute();
        $stmt2->execute();

        // Fetch all the "firstName" values into an array
        $activities = $stmt1->fetchAll(PDO::FETCH_COLUMN);
        $dates = $stmt2->fetchAll(PDO::FETCH_COLUMN);
        //END FETCH ACTIVITY LOGS FOR HISTORY LIST


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
        
        // Extract day, month, and year from the birthdate
        $birthDate = new DateTime($user['birthdate']);
        $birthDay = $birthDate->format('d');
        $birthMonth = $birthDate->format('m');
        $birthYear = $birthDate->format('Y');

        $gender = $user['gender'];
        $phoneNumber = $user['phoneNumber'];
        $password = $user['password'];

        // $customerID = $_SESSION['customer_ID'];
        // $firstName = $user['firstName'];
        $image = $user['image'];



        $customerID = $_SESSION['customerID'];
        $query = $conn->prepare("SELECT bio, hobby1, hobby2, hobby3, hobby4, favorite1, favorite2, favorite3, favorite4
            FROM tbl_background_info WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();
        
        // Fetch the user's information
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        // Check if data was found in the database
        if ($user !== false) {
            $bio = $user['bio'];
            $hobby1 = $user['hobby1'];
            $hobby2 = $user['hobby2'];
            $hobby3 = $user['hobby3'];
            $hobby4 = $user['hobby4'];
            $favorite1 = $user['favorite1'];
            $favorite2 = $user['favorite2'];
            $favorite3 = $user['favorite3'];
            $favorite4 = $user['favorite4'];
        } else {
            // Set default values if no data was found
            $bio = '';
            $hobby1 = '';
            $hobby2 = '';
            $hobby3 = '';
            $hobby4 = '';
            $favorite1 = '';
            $favorite2 = '';
            $favorite3 = '';
            $favorite4 = '';
        }
        
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
// Step 1: Connect to the database (replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cfms";

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
    <link rel="stylesheet" href="pages/account/style_acc.css">

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

                // Fetch and display customer registrations and feedback submissions
                $sqlNotifications = "
                    SELECT CONCAT(firstName, ' ', lastName) AS name, dateAdded AS date
                    FROM tbl_customer_info
                    WHERE customer_ID = :customerID
                    ORDER BY date DESC
                ";
                $stmtNotifications = $conn->prepare($sqlNotifications);
                $stmtNotifications->bindValue(':customerID', $customerID, PDO::PARAM_INT);
                $stmtNotifications->execute();
                $notifications = $stmtNotifications->fetchAll();
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
                                    // Fetch the number of messages for the current notification
                                    $messagesCount = $replyCount;

                                    for ($i = 0; $i < $messagesCount; $i++) {
                                        echo '<div class="row" style="background-color: white; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166);
                                            border-radius: 5px; font-size: 20px; width: 450px; margin-left: 15px; margin-top: 20px;">';

                                        echo '<p style="margin-top: 10px;"><strong>Admin</strong> has messaged you.</p>';
                                        
                                        // Display relative date and time below
                                        echo '<p class="" style="color: blue; font-size: 15px; margin-top: -10px;">' . formatRelativeDate($notification['date']) . '</p>';

                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="modal-footer" style="height: 70px;">
                            <button type="button" class="btn btn-primary" id="openCustomerReplyModalBtn" data-bs-toggle="modal" data-bs-target="#modal_customess" style="position: absolute; width: 100px; margin-right: 370px; margin-top: 5px"
                            >View all</button>
                            <button type="button" class="btn btn-secondary float-end" id="customernotif_closeModalBtn" data-bs-dismiss="modal" style="position: absolute; margin-top: 15px; margin-bottom: 15px; margin-right: 5px;"
                            >Close</button>
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
                    <div class="modal-content">
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





            
            <img src="images/<?php echo $image; ?>" class="" onclick="to_account()" style="width: 25px; height: 25px; border-radius: 12.5px;">

            <div class="m-2 text-light">
                <b class="bg-transparent" id="accountLink" onclick="to_account()" style="cursor: pointer;"> <img src="navigation/user.png" alt="">Account</b>
            </div>
        </div>
    </nav>
    

    <div class="accbg">
        <img src="pages/account/ICON_PROFILE_BACK.png" style="position: absolute; width: 100%; margin-left: 0px; margin-top: 0px;
            filter: drop-shadow(0px 7px 15px rgba(20, 20, 20, 20)); transform: rotate(0deg); z-index: 0;">
        
        <div class="container"> <!-- style="background-color: yellow;"-->
            <div class="row">
                <div class="col-2 bg-transparent">
                    <div class="col-2">
                        <!-- <button class="text-primary" style="width: 200px;">Profile</button> -->
                        <button type="button" class="btn btn-primary" id="openProfileModalBtn" data-bs-toggle="modal" data-bs-target="#modal_profile"
                            style="position: absolute; width: 200px; height: 60px; margin-left: 240px; margin-top: 261px;"
                            >Profile
                        </button>
                    </div>
                    <div class="col-2">
                        <p> </p>
                    </div>
                    <div class="col-2">
                        <!-- <button onclick="to_back()" style="width: 200px;">Background Information</button> -->
                        <button type="button" class="btn btn-primary" id="openBGInfoModalBtn" data-bs-toggle="modal" data-bs-target="#modal_bginfo"
                            style="position: absolute; width: 200px; height: 60px; margin-left: 445px; margin-top: 245px;"
                            >Background Information
                        </button>
                    </div>
                    <div class="col-2">
                        <p> </p>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-primary" id="openSettingsModalBtn" data-bs-toggle="modal" data-bs-target="#modal_settings"
                            style="position: absolute; width: 200px; height: 60px; margin-left: 650px; margin-top: 245px;"
                            >Settings
                        </button>
                    </div>
                    <div class="col-2">
                        <p> </p>
                    </div>
                    <div class="col-2 text-danger">
                        <!-- <button class="text-danger" style="width: 200px;"><a id="logout" href="http://localhost/DevBugs/login_main.php">Log Out</a></button> -->
                        <form action="actions/logoutAction.php" method="post">
                            <style>
                                .blue-button {
                                    background-color: black;
                                    color: white;
                                    height: 44px;
                                    padding: 10px 20px;
                                    border: none;
                                    border-radius: 5px;
                                }
                            </style>

                            <button class="btn btn-dark" type="submit" id="logout" onclick="window.location.href='login_main.php'"
                            style="position: absolute; width: 150px; height: 60px; margin-left: 855px; margin-top: 245px;"
                            >Log Out</button>

                        </form>

                    </div>
                    <div class="col-2 ">
                        <p> </p>
                    </div>
                </div>
                <div class="col-10 bg-transparent">
                    <div class="row">
                        <div class="col-4">
                            <div class="m-2" style="width: 80%; position: relative;">
                                <?php
                                    $sql = "SELECT image FROM tbl_customer_info WHERE customer_ID = :customerID";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
                                    $stmt->execute();

                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $image = $result['image'];
                                ?>

                                <img src="images/<?php echo $image; ?>" class="img-fluid zoomable-image rounded-square" style="width: 2in; height: 2in;">

                                <i class="fa fa-camera" onclick="openChangeProfilePicModal()" style="position: absolute; margin-right: 60px;"></i>
                                
                            </div>
                        </div>



                        <div class="col-8">
                            <h1 class="text-info" style="position: absolute; width: 700px; margin-left: -120px; margin-top: 70px;">
                                <?php echo $firstName . ' ' . $middleName. ' ' . $lastName; ?>
                                <!-- <h1>Welcome, <php echo $firstName . ' ' . $lastName; ?></h1> -->
                            </h1>
                            <p class="text-light" name="bio" style="position: absolute; width: 500px; margin-left: -120px; margin-top: 130px;"
                            ><?php echo $bio; ?></p>
                        </div>

                        <hr style="color: white; margin-left: 30px; margin-top: 100px; width: 70%;">

                    </div>
                    
                    <div class="row">
                        <div class="col text-light" style="position: absolute; width: 350px; margin-left: 30px; margin-top: 0px;">
                            <h3 class="text-light">Hobbies:</h3>
                            <p name="hobby1"><?php echo $hobby1; ?></p>
                            <p name="hobby2"><?php echo $hobby2; ?></p>
                            <p name="hobby3"><?php echo $hobby3; ?></p>
                            <p name="hobby4"><?php echo $hobby4; ?></p>
                        </div>
                        <div class="col text-light" style="position: absolute; width: 350px; margin-left: 440px; margin-top: 0px;">
                            <h3 class="text-light">Favorites:</h3>
                            <p name="favorite1"><?php echo $favorite1; ?></p>
                            <p name="favorite2"><?php echo $favorite2; ?></p>
                            <p name="favorite3"><?php echo $favorite3; ?></p>
                            <p name="favorite4"><?php echo $favorite4; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- PROFILE MODAL -- FOR EDITING PROFILE -->
    <div class="modal fade" id="modal_profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Profile</h5>
                    <img src="pages/account/GIF_PROFILE.gif" style="width: 1.4in; height: .8in; margin-left: 0px;" id="profile_gif">
                    <!-- <img  src="pages/account/profpic.png"> -->
                </div>

                <div class="modal-body">

                    <form id="editprofile_form" method="POST" action="actions/edit_profile.php">
                        <div class="input" id="inputfields" style="height: 400px;">
                            <p class="sub_title_2" id="sub_title_name">Name</p>
                            <input type="text" placeholder="Firstname" class="firstname" name="firstname" id="p_row1" value="<?php echo $firstName; ?>"/>
                            <input type="text" placeholder="Middlename" class="middlename" name="middlename" id="p_row1" value="<?php echo $middleName; ?>" />
                            <input type="text" placeholder="Lastname" class="lastname" name="lastname" id="p_row1" value="<?php echo $lastName; ?>" />
                            <hr>
                            <p class="sub_title_2" id="sub_title_address">Address</p>
                            <input type="text" placeholder="Street" class="street" name="street" id="p_row2" value="<?php echo $street; ?>"/>
                            <input type="text" placeholder="Barangay" class="barangay" name="barangay" id="p_row2" value="<?php echo $barangay; ?>" />
                            
                            <input type="text" placeholder="Municipality" class="municipality" name="municipality" id="p_row3" value="<?php echo $municipality; ?>" />
                            <input type="text" placeholder="Province" class="province" name="province" id="p_row3" value="<?php echo $province; ?>"/>
                            
                            <input type="text" placeholder="Zipcode" class="zipcode" name="zipcode" id="p_row4" value="<?php echo $zipcode; ?>" />
                            <input type="text" placeholder="Phone number" class="phonenumber" name="phonenumber" id="p_row4" value="<?php echo $phoneNumber; ?>" />

                            <!-- <input type="date" placeholder="Birthdate" class="birthdate" name="birthdate" id="p_row5" value="<php echo $birthDate; ?>" /> -->
                            <hr>
                            <label id="sub_title_dob">Date of Birth</label>
                            <label id="sub_title_gend">Gender</label>
                            <div class="options">
                                
                                <select class="box1" id="day" name="day">
                                    <option value="<?php echo $birthDay; ?>" selected><?php echo $birthDay; ?></option>
                                </select>

                                <select class="box2" id="month" name="month">
                                    <option value="<?php echo $birthMonth; ?>" selected><?php echo $birthMonth; ?></option>
                                </select>

                                <select class="box3" id="year" name="year">
                                    <option value="<?php echo $birthYear; ?>" selected><?php echo $birthYear; ?></option>
                                </select>

                                <input type="radio" id="fem" name="gender" value="Female" <?php echo ($gender === 'Female') ? 'checked' : ''; ?> required>
                                <label for="fem">Female</label>
                                <input type="radio" id="mal" name="gender" value="Male" <?php echo ($gender === 'Male') ? 'checked' : ''; ?> required>
                                <label for="mal">Male</label>
                            </div>
                            <hr>

                        </div>
                        
                        <button type="submit" class="submit" name="submit" id="prof_modalsave">Save</button>
                        <button type="button" class="btn btn-secondary" id="prof_closeModalBtn" data-bs-dismiss="modal">Close</button>
                        
                    </form>
                    
                        
            
                </div>
            
            </div>
        </div>
    </div>
    <!-- END PROFILE MODAL -- FOR EDITING PROFILE -->

    
    <script>
        // Function to generate options for day select
        function generateDayOptions() {
            var daySelect = document.getElementById("day");
            daySelect.innerHTML = "";
        
            for (var i = 1; i <= 31; i++) {
            var option = document.createElement("option");
            option.text = i;
            option.value = i;
            daySelect.appendChild(option);
            }
        }
        
        // Function to generate options for month select
        function generateMonthOptions() {
            var monthSelect = document.getElementById("month");
            monthSelect.innerHTML = "";
        
            var months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ];
        
            for (var i = 0; i < months.length; i++) {
            var option = document.createElement("option");
            option.text = months[i];
            option.value = i + 1;
            monthSelect.appendChild(option);
            }
        }
        
        // Function to generate options for year select
        function generateYearOptions() {
            var yearSelect = document.getElementById("year");
            yearSelect.innerHTML = "";
        
            var currentYear = new Date().getFullYear();
        
            for (var i = currentYear; i >= 1800; i--) {
            var option = document.createElement("option");
            option.text = i;
            option.value = i;
            yearSelect.appendChild(option);
            }
        }
        
        // Call the functions to generate options
        generateDayOptions();
        generateMonthOptions();
        generateYearOptions();
    </script>
    




    <!-- PROFILE PICTURE MODAL -- FOR CHANGING PROFILE PICTURE -->
    <div class="modal fade" id="changeProfilePicModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Profile Picture</h5>
                </div>
                <div class="modal-body">
                    <form class="form" id="form" action="actions/update_profile_pic.php" enctype="multipart/form-data" method="post">
                        <div class="upload">
                            <?php
                                $sql = "SELECT image FROM tbl_customer_info WHERE customer_ID = :customerID";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
                                $stmt->execute();

                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                $image = $result['image'];
                            ?>
                            <img src="images/<?php echo $image; ?>" id="selectedImage" style="width: 2in; height: 2in; margin-bottom: 20px;">
                            <div class="round">
                                <input type="hidden" name="id" value="<?php echo $customerID; ?>">
                                <input type="hidden" name="name" value="<?php echo $firstName; ?>">
                                <input type="file" class="image" name="image" id="image" accept=".jpg, .jpeg, .png">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="submit" id="saveProfilePic">Save</button>
                            <button type="button" class="btn btn-secondary" id="profpic_closeModalBtn" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PROFILE PICTURE MODAL -- FOR CHANGING PROFILE PICTURE -->

    <!-- JavaScript code to open the modal -->
    <script type="text/javascript">
        function openChangeProfilePicModal() {
            $('#changeProfilePicModal').modal('show');
        }
    </script>


    <!-- TO DISPLAY THE NEW CHOSEN PICTURE FROM THE COMPUTER -->
    <script>
        document.getElementById("image").addEventListener("change", function() {
            const selectedFile = this.files[0];
            if (selectedFile) {
                const selectedImage = document.getElementById("selectedImage");
                const objectURL = URL.createObjectURL(selectedFile);
                selectedImage.src = objectURL;
            } else {
                // You can handle the case when no file is selected
            }
        });
    </script>


    <!--SCRIPT FROM DAVID -- NOT FOUND BUT STORED IN DATABASE-->
    <script type="text/javascript">
        function openChangeProfilePicModal() {
            $('#changeProfilePicModal').modal('show');
        }
        document.getElementById("image").onchange = function(){
            document.getElementById("form").submit();
        };
    </script>



    <!-- BACKGROUND INFORMATION MODAL -- FOR EDITING BACKGROUND INFORMATION -->
    <div class="modal fade" id="modal_bginfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Background Information</h5>
                    <img src="pages/account/GIF_BGINFO.gif" style="width: 1.5in; height: 1in; margin-right: -15px;" id="bginfo_gif">
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">

                <form id="background_information_form" method="POST" action="actions/change_bg.php">
                    <div class="input" id="inputfields" style="height: 410px;">
                        <h id="bg_bio">Bio</h>
                        <input type="text" placeholder="Enter bio" class="bio" name="bio" id="bg_row1" value="<?php echo $bio;?>"/>
                        <hr>
                        <h id="bg_hobbies">Hobbies</h>
                        <div>
                            <input type="text" placeholder="Enter 1st hobby" class="hob1" name="hob1" id="bg_row2" value="<?php echo $hobby1;?>"/>
                            <input type="text" placeholder="Enter 2nd hobby" class="hob2" name="hob2" id="bg_row3" value="<?php echo $hobby2;?>"/>
                            <input type="text" placeholder="Enter 3rd hobby" class="hob3" name="hob3" id="bg_row4" value="<?php echo $hobby3;?>"/>
                            <input type="text" placeholder="Enter 4th hobby" class="hob4" name="hob4" id="bg_row5" value="<?php echo $hobby4;?>"/>
                        </div>
                        <hr>
                        <h id="bg_favorites">Favorites</h>
                        <div>
                            <input type="text" placeholder="Enter 1st Favorite" class="fav1" name="fav1" id="bg_row6" value="<?php echo $favorite1;?>"/>
                            <input type="text" placeholder="Enter 2nd Favorite" class="fav2" name="fav2" id="bg_row7" value="<?php echo $favorite2;?>"/>
                            <input type="text" placeholder="Enter 3rd Favorite" class="fav3" name="fav3" id="bg_row8" value="<?php echo $favorite3;?>"/>
                            <input type="text" placeholder="Enter 4th Favorite" class="fav4" name="fav4" id="bg_row9" value="<?php echo $favorite4;?>"/>
                        </div>
                        <hr style="margin-top: 17px;">
                    </div>

                    <button type="submit" class="submit" name="submit" id="bg_modalsave">Save</button>
                    <button type="button" class="btn btn-secondary" id="bg_closeModalBtn" data-bs-dismiss="modal">Close</button>
                </form>

                    
                </div>
            
            </div>
        </div>
    </div>
    <!-- END BACKGROUND INFORMATION MODAL -- FOR EDITING BACKGROUND INFORMATION -->


    <!-- SETTINGS MODAL -- FOR EDITING SETTINGS -->
    <div class="modal fade custom-fade" id="modal_settings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Settings</h5>
                    <img src="pages/account/GIF_SETTINGS.gif" style="width: 1.5in; height: 1in; margin-left: 0px;" id="settings_gif">
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">


                    <form id="registration_form" method="POST"> <!--action="actions/edit_profile.php" -->
                        <div class="input" id="inputfields" style="height: 400px;">

                            <button type="button" class="btn btn-secondary" id="openChangeYourPasswordModalBtn" data-bs-toggle="modal" data-bs-target="#modal_changeyourpassword"
                                style="width: 250px; height: 50px; margin-top: 20px; margin-left: 105px;">
                                Change Your Password
                            </button>
                            <br>
                            <button type="button" class="btn btn-secondary" id="openHistoryModalBtn" data-bs-toggle="modal" data-bs-target="#modal_history"
                                style="width: 250px; height: 50px; margin-top: 20px; margin-left: 105px;">
                                History
                            </button>
                            <br>
                            <button type="button" class="btn btn-secondary" id="openAppearanceAndThemeModalBtn" data-bs-toggle="modal" data-bs-target="#modal_appearanceandtheme"
                                style="width: 250px; height: 50px; margin-top: 20px; margin-left: 105px;">
                                Appearance and Theme
                            </button>
                            <br>
                            <button type="button" class="btn btn-secondary" id="openTermsAndPrivacyPolicyModalBtn" data-bs-toggle="modal" data-bs-target="#modal_termsandprivacypolicy"
                                style="width: 250px; height: 50px; margin-top: 20px; margin-left: 105px;">
                                Terms and Privacy Policy
                            </button>

                        </div>
                            <!-- <button type="submit" class="submit" name="submit" id="sett_modalsave">Save</button> -->
                            <button type="button" class="btn btn-secondary" id="sett_closeModalBtn" data-bs-dismiss="modal"
                            
                            window.location.href = 'account_main.php';>Close</button> <!--WORK HERE!!!!!-->
                        
                    </form>
                    
                        
            
                </div>
            
            </div>
        </div>
    </div>
    <!-- <script>
        function openmodal_settings() {
            $('#modal_settings').modal('show');
        }
    </script> -->
    <!-- END SETTINGS MODAL -- FOR EDITING SETTINGS -->






    <!-- CHANGE PASSWORD MODAL -- FOR CHANGING YOUR PASSWORD -->
    <div class="modal fade" id="modal_changeyourpassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Change Your Password</h5>
                    <img src="pages/account/GIF_PASSWORD.gif" style="width: 1.6in; height: .9in; margin-right: -15px;" id="password_gif">
                </div>
                <div class="modal-body">
                    <form id="change_password_form" method="POST" action="actions/change_password.php">
                        <div class="input" id="inputfields" style="height: 350px;">

                            <div class="row">
                                <br>
                                <h style="margin-top: 10px; margin-left: 83px;">Enter old password</h>
                                <input type="password" class="oldpassword" name="oldpassword" id="cyp_row1" style="margin-top: 10px;"/>
                                <br>
                                <h style="margin-top: 10px; margin-left: 83px;">Enter new password</h>
                                <input type="password" class="newpassword" name="newpassword" id="cyp_row2" style="margin-top: 10px;"/>
                                <br>
                                <h style="margin-top: 10px; margin-left: 83px;">Confirm new password</h>
                                <input type="password" class="confirmnewpassword" name="confirmnewpassword" id="cyp_row3" style="margin-top: 10px;"/>
                            </div>
                        </div>
                        <button type="submit" class="submit" name="submit" id="sett_cyp_modalsave">Save</button>

                        <button type="button" class="btn btn-secondary" id="sett_cyp_closeModalBtn" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        document.getElementById("sett_cyp_modalsave").addEventListener("click", function(event) {
            //event.preventDefault(); // Prevent the form from being submitted

            <?php
                $password = $user['password'];
            ?>

            let oldPassword = document.querySelector('.oldpassword').value;
            let newPassword = document.querySelector('.newpassword').value;
            let confirmNewPassword = document.querySelector('.confirmnewpassword').value;
            let password = "<?php echo $password; ?>"; // Echo the PHP variable as a JavaScript variable

            if (oldPassword === password) {
                if (newPassword.length !== 0) {
                    if (newPassword === confirmNewPassword) {
                        // alert("Password changed successfully");
                        document.getElementById("change_password_form").submit();
                    } else {
                        event.preventDefault();
                        alert("Passwords don't match");
                    }
                } else {
                    event.preventDefault();
                    alert("New password can't be empty");
                }
            } else {
                event.preventDefault();
                alert("Old password is incorrect");
            }
        });
    </script>
    <!-- END CHANGE PASSWORD MODAL -- FOR CHANGING YOUR PASSWORD -->

    
    
    <!-- HISTORY MODAL -- FOR VIEWING HISTORY -->
    <div class="modal fade" id="modal_history" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">History</h5>
                <img src="pages/account/GIF_HISTORY.gif" style="width: 1.75in; height: 1in; margin-left: 208px;" id="bginfo_gif">
                <!-- <img src="pages/account/HISTORY_GIF.gif" style="width: 1.5in; height: 1in; margin-left: 0px;" id="bginfo_gif"> -->
            </div>

                <div class="modal-body">
                    <!-- <form id="feedback_history_form" method="POST" action="actions/change_password.php"> -->
                    <div class="row">
                        <div class="col-1">
                        </div>
                        <div class="col-4" style="margin-bottom: 10px; margin-left: 0px;">
                            <h><b>Activity</b></h>
                        </div>
                        <div class="col-2">
                        </div>
                        <div class="col-5" style="margin-bottom: 10px; margin-left: 0px;">
                            <h><b>Date</b></h>
                        </div>
                    </div>
                    
                    <div class="scrollable-content" id="inputfields" style="height: 400px; overflow-y: auto;">
                        <table class="table table-bordered">
                            <!-- <thead>
                                <tr>
                                    <th class="col-5">Activities</th>
                                    <th class="col-5">Dates</th>
                                </tr>
                            </thead> -->
                            <tbody>
                                <?php
                                // Assuming both arrays have the same length
                                $count = count($activities);

                                for ($i = $count - 1; $i >= 0; $i--) {
                                ?>
                                <tr>
                                    <td class="col-5"><?php echo $activities[$i]; ?></td>
                                    <td class="col-5"><?php echo $dates[$i]; ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <!-- <button type="submit" class="submit" name="submit" id="sett_cyp_modalsave">Save</button> -->

                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px;" id="sett_h_closeModalBtn" data-bs-dismiss="modal">Close</button>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>

    <script>
    function openmodal_history() {
        $('#modal_history').modal('show');
    }
    </script>
    <!-- END FEEDBACK HISTORY MODAL -- FOR VIEWING FEEDBACK HISTORY -->


    <!-- APPEARANCE AND THEME MODAL -- FOR CHANGING APPEARANCE AND THEME -->
    <div class="modal fade" id="modal_appearanceandtheme" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Appearance and Theme</h5>
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
                                // Redirect to account_theme1.php
                                window.location.href = 'account_theme1.php';
                                alert("Your theme is successfully changed to Blue Water!");
                            });

                            // Add a click event handler for the "Theme2" card
                            document.getElementById('theme2').addEventListener('click', function() {
                                // Redirect to account_theme2.php
                                window.location.href = 'account_theme2.php';
                                alert("Your theme is successfully changed to Green Archers!");
                            });

                            // Add a click event handler for the "Theme3" card
                            document.getElementById('theme3').addEventListener('click', function() {
                                // Redirect to account_theme3.php
                                window.location.href = 'account_theme3.php';
                                alert("Your theme is successfully changed to Cold Blocks!");
                            });

                            // Add a click event handler for the "Theme2" card
                            document.getElementById('theme4').addEventListener('click', function() {
                                // Redirect to account_theme4.php
                                window.location.href = 'account_theme4.php';
                                alert("Your theme is successfully changed to Great Wizard!");
                            });

                            // Add a click event handler for the "Theme3" card
                            document.getElementById('theme5').addEventListener('click', function() {
                                // Redirect to account_theme5.php
                                window.location.href = 'account_theme5.php';
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
    function openmodal_appearanceandtheme() {
        $('#modal_appearanceandtheme').modal('show');
    }
    </script>
    <!-- END APPEARANCE AND THEME MODAL -- FOR CHANGING APPEARANCE AND THEME -->


    <!-- TERMS AND POLICY MODAL -- FOR VIEWING TERMS AND POLICY -->
    <div class="modal fade" id="modal_termsandprivacypolicy" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Terms and Privacy Policy</h5>
                        <img src="pages/account/GIF_TERMSPRIVACY.gif" style="width: 1.6in; height: .9in; margin-right: -15px;" id="password_gif">
                </div>
                <div class="modal-body">
                    <div class="scrollable-content" style="height: 400px; overflow-y: auto;">
                        <b>Customer Feedback Management System</b>
                            <br><br>
                            Effective Date: September 09, 2023
                            <br><br>
                            Thank you for using our Customer Feedback Management System. Please read the following terms and policies carefully before using our platform. By accessing and using this system, you agree to these terms and policies.
                            <br><br>
                            <b>User Registration</b>
                            <br>
                            Users are required to register for an account to access and use our system. When registering, you must provide accurate and complete information.
                            <br><br>
                            <b>Privacy</b>
                            <br>
                            Your privacy is important to us. Please review our Privacy Policy to understand how we collect, use, and protect your personal information.
                            <br><br>
                            <b>Feedback Submission</b>
                            <br>
                            Users are encouraged to submit honest and constructive feedback.
                            Feedback should not contain offensive, discriminatory, or harmful content.
                            <br><br>
                            <b>Moderation</b>
                            <br>
                            All submitted feedback is subject to moderation. We reserve the right to review and approve or reject feedback.
                            Moderation is conducted to maintain a respectful and safe environment.
                            <br><br>
                            <b>Intellectual Property</b>
                            <br>
                            All content, including feedback, on the system is protected by intellectual property rights. Users may not use or reproduce this content without authorization.
                            <br><br>
                            <b>User Conduct</b>
                            <br>
                            Users must not engage in any activities that violate laws or harm the system or its users.
                            Users must not attempt to access restricted areas of the system or compromise its security.
                            <br><br>
                            <b>Feedback Ownership</b>
                            <br>
                            Users retain ownership of the feedback they submit. However, by submitting feedback, users grant us a non-exclusive, royalty-free license to use, display, and reproduce the feedback.
                            <br><br>
                            <b>Termination</b>
                            <br>
                            We reserve the right to terminate or suspend a user's account for violating these terms and policies or for any other reason at our discretion.
                            <br><br>
                            <b>Disclaimer</b>
                            <br>
                            The system is provided "as is" without warranties of any kind. We do not guarantee the accuracy, completeness, or reliability of the content.
                            <br><br>
                            <b>Limitation of Liability</b>
                            <br>
                            We shall not be liable for any damages, including indirect or consequential damages, arising from the use of the system.
                            <br><br>
                            <b>Changes to Terms and Policies</b>
                            <br>
                            We may revise and update these terms and policies from time to time. It is the user's responsibility to review these terms periodically.
                            <br><br>
                            <b>Contact Information</b>
                            <br>
                            If you have any questions or concerns about these terms and policies, please contact us at Octawiz_Devbugs2023@gmail.com.
                            <br>
                        <h style="margin-top: 5px; margin-left: 10px; font-size: 10px;">
                            <!-- Your terms and policy text here -->
                        </h>
                    </div>
                    <!-- <button type="button" class="btn btn-secondary" style="margin-top: 10px; margin-left: 200px;" id="sett_tap_closeModalBtn" data-bs-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px;" id="sett_tap_closeModalBtn" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function openmodal_termsandprivacypolicy() {
        $('#modal_termsandprivacypolicy').modal('show');
    }
    </script>
    <!-- END TERMS AND POLICY MODAL -- FOR VIEWING TERMS AND POLICY -->



    <script>
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
        underlineLink("accountLink");

        document.getElementById("homeLink").addEventListener("click", function() {
            underlineLink("homeLink");
        });
        document.getElementById("aboutUsLink").addEventListener("click", function() {
            underlineLink("aboutUsLink");
        });
        document.getElementById("contactUsLink").addEventListener("click", function() {
            underlineLink("contactUsLink");
        });
    </script>



    <script>
        function insertNewUser(){
            $.post("actions/insert_new_account.php", {
                fname: $('.firstname').val(),
                mname: $('.middlename').val(),
                lname: $('.lastname').val(),
                st: $('.street').val(),
                brgy: $('.barangay').val(),
                mun: $('.municipality').val(),
                prov: $('.province').val(),
                zipc: $('.zipcode').val(),
                pnum: $('.phonenumber').val(),

                day: $('.day').val(),
                month: $('.month').val(),
                year: $('.year').val(),
                bdate: $('.year') + '-' + $('.month') + '-' + $('.day').val(),

                gend: $('.gender').val(),

                
                pword: $('.password').val(),
                conpw: $('.confirmpassword').val(),

                image: $('.image').val()
                

    // Combine the values into a single date string in YYYY-MM-DD format
    // $bdate = "$year-$month-$day";
                
            }, function (data) {
                if (data === "Registered Successfully!") { /*HERE*/
                    alert(data);
                } else {
                    alert("Insertion failed: " + data);
                }
            });
        }
    </script>


    

    <script>
        // Function to generate options for day select
        function generateDayOptions() {
            var daySelect = document.getElementById("day");
            daySelect.innerHTML = "";
        
            for (var i = 1; i <= 31; i++) {
            var option = document.createElement("option");
            option.text = i;
            option.value = i;
            daySelect.appendChild(option);
            }
        }
        
        // Function to generate options for month select
        function generateMonthOptions() {
            var monthSelect = document.getElementById("month");
            monthSelect.innerHTML = "";
        
            var months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ];
        
            for (var i = 0; i < months.length; i++) {
            var option = document.createElement("option");
            option.text = months[i];
            option.value = i + 1;
            monthSelect.appendChild(option);
            }
        }
        
        // Function to generate options for year select
        function generateYearOptions() {
            var yearSelect = document.getElementById("year");
            yearSelect.innerHTML = "";
        
            var currentYear = new Date().getFullYear();
        
            for (var i = currentYear; i >= 1800; i--) {
            var option = document.createElement("option");
            option.text = i;
            option.value = i;
            yearSelect.appendChild(option);
            }
        }
        
        // Call the functions to generate options
        generateDayOptions();
        generateMonthOptions();
        generateYearOptions();
    </script>




</body>
</html>









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


<script>
    function to_back() {
        $.post("pages/account/back_acc.php", {},function (data) {
            $("#nav_contents").html(data);
        });
    }
</script>

<script>
    function to_nav(){
        $.post("navigation/nav.php", {}, function (data) {
            $("#nav_contents").html(data);
        });
    }
</script>

