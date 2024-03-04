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





        // //FETCH TBL_FEEDBACK FOR FEEDBACK HISTORY LIST
        // // Assuming you have a valid PDO connection in $conn
        // // SQL query to select all "firstName" values
        // // $sql1 = "SELECT activity FROM tbl_activity_logs WHERE activity = 'Submitted feedback' OR activity = 'Updated the profile'";
        // $sql1 = "SELECT feedback FROM tbl_feedback WHERE customer_ID = $customerID";
        // $sql2 = "SELECT suggestion FROM tbl_feedback WHERE customer_ID = $customerID";
        // $sql3 = "SELECT question FROM tbl_feedback WHERE customer_ID = $customerID";
        // $sql4 = "SELECT rating FROM tbl_feedback WHERE customer_ID = $customerID";
        // $sql5 = "SELECT date FROM tbl_feedback WHERE customer_ID = $customerID";
        // // Prepare and execute the query
        // $stmt1 = $conn->prepare($sql1);
        // $stmt2 = $conn->prepare($sql2);
        // $stmt3 = $conn->prepare($sql3);
        // $stmt4 = $conn->prepare($sql4);
        // $stmt5 = $conn->prepare($sql5);
        // $stmt1->execute();
        // $stmt2->execute();
        // $stmt3->execute();
        // $stmt4->execute();
        // $stmt5->execute();

        // // Fetch all the "firstName" values into an array
        // $feedbacks = $stmt1->fetchAll(PDO::FETCH_COLUMN);
        // $suggestions = $stmt2->fetchAll(PDO::FETCH_COLUMN);
        // $questions = $stmt3->fetchAll(PDO::FETCH_COLUMN);
        // $ratings = $stmt4->fetchAll(PDO::FETCH_COLUMN);
        // $dates = $stmt5->fetchAll(PDO::FETCH_COLUMN);

        // // $firstNames now contains an array of all "firstName" values
        // //END FETCH FEEDBACK FOR FEEDBACK LIST





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
    <link rel="stylesheet" href="pages/aboutUs_theme3/style_au_theme3.css">

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
                    <button class="btn btn-dark" type="button" id="homeLink" onclick="to_home_t3()" href="home_theme3.php" style="margin-left: -32px;">
                        Home
                    </button>
                    <button class="btn btn-dark" type="button" id="aboutUsLink" onclick="to_aboutUs_t3()" href="aboutus_theme3.php">
                        About Us
                    </button>
                    <button class="btn btn-dark" type="button" id="contactUsLink" onclick="to_contactUs_t3()" href="contactus_theme3.php">
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
                style="position: absolute; margin-left: 990px; margin-top: 0px;"
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


            <img src="images/<?php echo $image; ?>" class="img-fluid zoomable-image rounded-square" onclick="to_account_t3()" style="width: 25px; height: 25px; border-radius: 12.5px;">

            <div class = " m-2 text-light" >   
                <b class = "bg-transparent "  id="accountLink" onclick="to_account_t3()" style=" cursor: pointer;"> <img src="navigation/user.png" alt="">Account</b>
            </div>

        </div>
    </nav>




    
   <div class="row">
        <div class="container-fluid" id="au_body">

            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <div class="carousel-item active" id="first">
                        <video class="d-block w-100" controls autoplay loop>
                        <source src="pages/aboutUs_theme3/ADS1.mp4" type="video/mp4">
                        </video>
                    </div>
                    <div class="carousel-item">
                        <img src="pages/aboutUs/DEVBUGS (ABOUT US).png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="pages/aboutUs/DEVBUGS (ABOUT US).png" class="d-block w-100" alt="...">
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


            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var myCarousel = document.getElementById("carouselExampleControls");
                    var video = document.querySelector(".carousel-item.active video");
                    
                    myCarousel.addEventListener("slide.bs.carousel", function () {
                    if (video) {
                        // Pause the video when sliding to the next page
                        video.pause();
                    }
                    });
                });
            </script>

            <!-- AUTOPLAY ONLY BUT NO LOOP
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var video = document.querySelector(".carousel-item.active video");
                    var myCarousel = document.getElementById("myCarousel");

                    video.addEventListener("ended", function () {
                    // Pause the video
                    video.pause();
                    // Trigger the carousel to go to the next slide
                    var carousel = new bootstrap.Carousel(myCarousel);
                    carousel.next();
                    });
                });
            </script> -->




            <div class="card my-2">
                <h1 style="text-align: center; font-weight: 600;">SENIORS</h1>
                <div class="card-body">
                    <div class="d-flex my-2">
                    <div class="card mx-2" style="width: '25%';">
                    <div class="card-body">
                        <img src="pages/aboutUs/OCTAWIZ_ARMAR.jpg" class="float-left" style="width: 2in; height: 2in;" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Armar Jun Acuzar</h5>
                        <h6 class="card-subtitle mb-2 text-muted">IT30A - Database Backend Leader</h6>
                        <p class="card-text">"Everything will be okay at the end. If it's not okay, it's not yet the end."</p>
                        <a href="https://www.facebook.com/profile.php?id=100077511848993&mibextid=ZbWKwL" class="card-link" style="text-decoration: underline">See Facebook</a>
                        <a href="https://www.youtube.com/@armarjunacuzar7710" class="card-link" style="text-decoration: underline">See Youtube Channel</a>
                    </div>
                    
                </div>
                <div class="card mx-2" style="width: '25%';">
                    <div class="card-body">
                        <img src="pages/aboutUs/OCTAWIZ_JOY RUTH.jpg" class="float-left" style="width: 2in; height: 2in;" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Joy Ruth Purol</h5>
                        <h6 class="card-subtitle mb-2 text-muted">IT30A - Database Backend Vice-Leader</h6>
                        <p class="card-text">"Everything will be okay at the end. If it's not okay, it's not yet the end."</p>
                        <a href="https://www.facebook.com/angeljoy.purol.1?mibextid=ZbWKwL" class="card-link" style="text-decoration: underline">See Facebook</a>
                        <a href="https://www.youtube.com/@joyruthpurol5823" class="card-link" style="text-decoration: underline">See Youtube Channel</a>
                    </div>
                </div>
                <div class="card mx-2" style="width: '25%';">
                    <div class="card-body">
                        <img src="pages/aboutUs/OCTAWIZ_JULIET.jpg" class="float-left" style="width: 2in; height: 2in;" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Juliet Pinalas</h5>
                        <h6 class="card-subtitle mb-2 text-muted">IT30A - Database Backend Architect</h6>
                        <p class="card-text">"Everything will be okay at the end. If it's not okay, it's not yet the end."</p>
                        <a href="https://www.facebook.com/axelsadrite.margallo" class="card-link" style="text-decoration: underline">See Facebook</a>
                        <a href="https://www.youtube.com/@julietpinalas3040" class="card-link" style="text-decoration: underline">See Youtube Channel</a>
                    </div>
                </div>
                <div class="card mx-2" style="width: '25%';">
                    <div class="card-body">
                        <img src="pages/aboutUs/OCTAWIZ_JOYCE.jpg" class="float-left" style="width: 2in; height: 2in;" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Joyce Palomera</h5>
                        <h6 class="card-subtitle mb-2 text-muted">IT30A - Database Backend Architect</h6>
                        <p class="card-text">"Everything will be okay at the end. If it's not okay, it's not yet the end."</p>
                        <a href="https://www.facebook.com/joycenicol.stypayhorlikson.1?mibextid=ZbWKwL" class="card-link" style="text-decoration: underline">See Facebook</a>
                        <a href="https://www.youtube.com/@joycepalomera8952" class="card-link" style="text-decoration: underline">See Youtube Channel</a>
                    </div>
                </div>
            </div>

            <div class="d-flex my-2">
                <div class="card mx-2" style="width: '25%';">
                <div class="card-body">
                        <img src="pages/aboutUs/OCTAWIZ_RYAN.jpg" class="float-left" style="width: 2in; height: 2in;" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Ryan Cepada</h5>
                        <h6 class="card-subtitle mb-2 text-muted">IT30A - Database Backend Programmer</h6>
                        <p class="card-text">"Everything will be okay at the end. If it's not okay, it's not yet the end."</p>
                        <a href="https://web.facebook.com/rhayean.cepada/" class="card-link" style="text-decoration: underline">See Facebook</a>
                        <a href="https://www.youtube.com/channel/UCl29Cp5n-Z1jWbkB_c0DVug" class="card-link" style="text-decoration: underline">See Youtube Channel</a>
                    </div>
                </div>
                <div class="card mx-2" style="width: '25%';">
                    <div class="card-body">
                        <img src="pages/aboutUs/OCTAWIZ_JESSMAR.jpg" class="float-left" style="width: 2in; height: 2in;" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Jessmar Dalahigon</h5>
                        <h6 class="card-subtitle mb-2 text-muted">IT30A - Database Backend Programmer</h6>
                        <p class="card-text">"Everything will be okay at the end. If it's not okay, it's not yet the end."</p>
                        <a href="https://www.facebook.com/jeydon.bautista?mibextid=ZbWKwL" class="card-link" style="text-decoration: underline">See Facebook</a>
                        <a href="https://www.youtube.com/@jessmarivandalahigon3172" class="card-link" style="text-decoration: underline">See Youtube Channel</a>
                    </div>
                </div>
                <div class="card mx-2" style="width: '25%';">
                    <div class="card-body">
                        <img src="pages/aboutUs/OCTAWIZ_ROGER.jpg" class="float-left" style="width: 2in; height: 2in;" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Roger Dimatao</h5>
                        <h6 class="card-subtitle mb-2 text-muted">IT30A - Database Backend Presenter</h6>
                        <p class="card-text">"Everything will be okay at the end. If it's not okay, it's not yet the end."</p>
                        <a href="https://www.facebook.com/rogerdimatao19?mibextid=ZbWKwL" class="card-link" style="text-decoration: underline">See Facebook</a>
                        <a href="https://www.youtube.com/@rogerdimatao7041" class="card-link" style="text-decoration: underline">See Youtube Channel</a>
                    </div>
                </div>
                <div class="card mx-2" style="width: '25%';">
                    <div class="card-body">
                        <img src="pages/aboutUs/OCTAWIZ_MARIA FATIMA.jpg" class="float-left" style="width: 2in; height: 2in;" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Maria Fatima Paluga</h5>
                        <h6 class="card-subtitle mb-2 text-muted">IT30A - Database Backend Presenter</h6>
                        <p class="card-text">"Everything will be okay at the end. If it's not okay, it's not yet the end."</p>
                        <a href="https://m.facebook.com/profile.php/?id=100055721048105" class="card-link" style="text-decoration: underline">See Facebook</a>
                        <a href="https://www.youtube.com/@ma.fatimapaluga3049" class="card-link" style="text-decoration: underline">See Youtube Channel</a>
                    </div>
                </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


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
    function to_login_t3() {
$.post("login_theme3.php", {},function (data) {
      $("#contents").html(data);  
    });
}   
</script>


