<?php
session_start();  // Start the session to access session variables

// Check if the user is logged in (you can adjust this based on your session variable)
if (isset($_SESSION['adminID'])) {
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
        $customerID = $_SESSION['adminID'];
        $query = $conn->prepare("SELECT firstName, middleName, lastName, street, barangay, municipality, province, zipcode, birthdate, gender,
            phoneNumber, password, image FROM tbl_customer_info WHERE customer_ID = :customerID");
        $query->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $query->execute();



        // Fetch the user's information
        $user = $query->fetch(PDO::FETCH_ASSOC);

        // Check if data was found in the database
        if ($user !== false) {
            // $customerID = $user['customer_ID'];
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
            $password = $user['password'];
            $image = $user['image'];
        } else {
            $firstName = '';
            $middleName = '';
            $lastName = '';
            $street = '';
            $barangay = '';
            $municipality = '';
            $province = '';
            $zipcode = '';
            // $day = '';
            // $month = '';
            // $year = '';
            $birthDate = '';
            $gender = '';
            $phoneNumber = '';
            $password = '';
            $image = '';
        }



        //FETCH ACTIVITY LOGS FOR HISTORY LIST
        // $sql1 = "SELECT activity FROM tbl_activity_logs WHERE activity = 'Submitted feedback' OR activity = 'Updated the profile'";
        $sql1 = "SELECT activity FROM tbl_activity_logs WHERE customer_ID = $customerID ORDER BY dateAdded DESC";
        $sql2 = "SELECT dateAdded FROM tbl_activity_logs WHERE customer_ID = $customerID ORDER BY dateAdded DESC";
        // Prepare and execute the query
        $stmt1 = $conn->prepare($sql1);
        $stmt2 = $conn->prepare($sql2);
        $stmt1->execute();
        $stmt2->execute();

        // Fetch all the "firstName" values into an array
        $activities = $stmt1->fetchAll(PDO::FETCH_COLUMN);
        $dates = $stmt2->fetchAll(PDO::FETCH_COLUMN);
        //END FETCH ACTIVITY LOGS FOR HISTORY LIST






        // Get admin information based on adminID from the session
        $adminID = $_SESSION['adminID'];
        $adminQuery = $conn->prepare("SELECT userName, image FROM tbl_admin WHERE admin_ID = :adminID");
        $adminQuery->bindParam(':adminID', $adminID, PDO::PARAM_INT);
        $adminQuery->execute();

        // Fetch the admin's information
        $admin = $adminQuery->fetch(PDO::FETCH_ASSOC);

        // Check if data was found in the database
        if ($user !== false) {
            // Assign the username to $userName
            $userName = $admin['userName'];
            $adminimage = $admin['image'];
        } else {
            $userName = '';
            $adminimage = '';
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!--FOR PIE CHART-->

    <title>DevBugs</title>
</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    <link rel="stylesheet" href="pages/admin/style_ad.css">

    


    <!-- PARALLAX -->
    <div class="container-fluid">
        <div class="parallax">


            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-dark" style="position: absolute; margin-top: -655px; height: 110px;">

                    <div class="container-fluid col-9">
                        <div class="" style="position: absolute; width: 100px; height: 100px;">
                            <img src="pages/home/LOGO.png" class="img-fluid" alt="">
                        </div> 
                        
                        <h1 style="position: absolute; margin-left: 100px; margin-top: -20px; color: lightblue;">Octawiz-Devbugs</h1>
                        <h1 class="tit" style="position: absolute; margin-top: 50px; margin-left: 100px; color: smokewhite; font-size: 20px;"
                        >Customer Feedback Management System</h1>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        
                        <!-- <form style="margin-left: 450px;">
                            <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" id="search">
                        </form> -->
                    </div>
                    <div class="container-fluid col-3">

                        <button type="button" class="btn btn-secondary position-relative" id="openAdminNotifModalBtn" data-bs-toggle="modal" data-bs-target="#modal_adminmess"
                            style="margin-right: 20px; margin-left: -40px;"">
                            Messages
                            <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <!-- 0 -->
                                
                                <?php
                                    $sqlMessage = "SELECT COUNT(message_ID) AS messageCount FROM tbl_message";  //WHERE DATE(date) = CURDATE()
                                    $stmtMessage = $conn->prepare($sqlMessage);
                                    $stmtMessage->execute();
                                    $messageCount = $stmtMessage->fetchColumn();
                                    echo $messageCount;
                                ?>

                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </button>


                        <!-- ADMIN MESSAGES MODAL -- FOR VIEWING ADMIN MESSAGES -->
                        <div class="modal fade" id="modal_adminmess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
                            style="margin-left: 350px;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="staticBackdropLabel" style="color: Black;">Messages</h3>
                                        <img src="pages/admin/GIF_MESSAGES.gif" style="width: 1.1in; height: .6in; margin-left: 0px; margin-top: 0px;" id="adminnotif_gif">
                                    </div>

                                    <div class="scrollable-content" id="messageContent" style="height: 450px; padding: 20px; overflow-y: auto; color: black;">

                                        <div class="">
                                            <?php
                                            // Fetch messages with concatenated first and last names as Sender
                                            $sqlMessage = "SELECT message_ID AS Message_ID, CONCAT(firstName, ' ', lastName) AS Sender, message AS Message, date AS Date,
                                                        email AS Email, contactNumber AS Contact, customer_ID AS Customer_ID FROM tbl_message ORDER BY date DESC";
                                            $stmtMessage = $conn->prepare($sqlMessage);
                                            $stmtMessage->execute();
                                            $messages = $stmtMessage->fetchAll(PDO::FETCH_ASSOC);
                                            ?>

                                            <?php
                                            // Output messages in the alternative design
                                            foreach ($messages as $message) {
                                                $messageDate = new DateTime($message["Date"]);
                                                $currentDate = new DateTime();

                                                $interval = $currentDate->diff($messageDate);
                                                $formattedDate = '';

                                                if ($interval->d == 0) {
                                                    $formattedDate = 'Today';
                                                } elseif ($interval->d == 1) {
                                                    $formattedDate = 'Yesterday';
                                                } else {
                                                    $formattedDate = $interval->d . ' days ago';
                                                }

                                                // Append time if it's not today
                                                if ($interval->d > 0 || $interval->h > 0 || $interval->i > 0) {
                                                    $formattedDate .= ' @ ' . $messageDate->format('h:i A');
                                                }

                                                ?>
                                                <div class="message-container">
                                                    <div class="row" style="width: 450px; background-color: #ecffed; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166);
                                                        border-radius: 15px; margin-bottom: 10px;  margin-left: -5px;">
                                                        <strong class="message-sender" style="margin-top: 10px;"><?php echo $message["Sender"]; ?></strong>
                                                        <p class="message-content" style="font-size: 20px;"><?php echo $message["Message"]; ?></p>
                                                    </div>

                                                    <p class="message-date" style="margin-bottom: 0px; color: blue;"><?php echo $formattedDate; ?></p>
                                                    <p class="message-email text-muted" style="margin-bottom: 0px;">Email: <?php echo $message["Email"]; ?></p>
                                                    <p class="message-contactnum text-muted">Contact #: <?php echo $message["Contact"]; ?></p>
                                                    <p class="visually-hidden">Message ID: <?php echo $message["Message_ID"]; ?></p>
                                                    <p class="visually-hidden">Customer ID: <?php echo $message["Customer_ID"]; ?></p>

                                                    <button type="button" class="btn btn-primary reply-btn" id="openAdminReplyModalBtn_<?php echo $message["Customer_ID"]; ?>" data-bs-toggle="modal" style="width: 150px;"
                                                    data-bs-target="#modal_adminreply" onclick="openmodal_adminreply('<?php echo $message["Message_ID"]; ?>', '<?php echo $message["Customer_ID"]; ?>', '<?php echo $message["Sender"]; ?>')"
                                                    >Reply</button>

                                                    <hr>
                                                </div>
                                            <?php
                                            }

                                            // Check if no messages found
                                            if (empty($messages)) {
                                                echo "<p>No messages found</p>";
                                            }
                                            ?>
                                        </div>

                                    </div>

                                    <div class="modal-footer" style="height: 70px;">
                                        <button type="button" class="btn btn-secondary float-end" style="margin-top: 5px; margin-bottom: 15px; margin-right: 5px;" id="adminmess_closeModalBtn" data-bs-dismiss="modal"
                                        >Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                        function openmodal_adminmess() {
                            $('#modal_adminmess').modal('show');
                        }
                        </script>
                        <!-- END ADMIN MESSAGES MODAL -- FOR VIEWING ADMIN MESSAGES -->




                        <!-- ADMIN REPLY MESSAGE MODAL -- FOR REPLYING MESSAGES -->
                        <div class="modal fade" id="modal_adminreply" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
                            style="margin-left: 0px; margin-top: 150px;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="row" id="messageContent" style="height: 230px; padding: 20px; overflow-y: auto; color: black;">
                                        <!-- Previous messages here -->

                                        <!-- Reply form -->
                                        <form action="actions_admin/admin_reply.php" method="post">
                                            
                                            <input type="hidden" name="message_ID" value="<?php echo $message['Message_ID']; ?>">
                                            <input type="hidden" name="customer_ID" value="<?php echo $message['Customer_ID']; ?>">
                                            <input type="hidden" id="customer_id_input" name="customer_id" value="">

                                            <div class="form-group">
                                                <label class="text-muted" for="replyTextArea" style="margin-bottom: 10px;">Replying to: <strong class="message-sender text-unmuted"><?php echo $message["Sender"]; ?></strong></label>
                                                <textarea class="form-control" id="replyTextArea" name="admin_reply" rows="3" required></textarea>
                                            </div>

                                            <div >
                                                <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Send Reply</button>
                                                <button type="button" class="btn btn-secondary float-end" style="margin-top: 25px; margin-bottom: 0px; margin-right: 0px;" id="adminmess_closeModalBtn" data-bs-dismiss="modal"
                                                >Close</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <script>
                            function openmodal_adminreply(messageId, customerId, senderName) {
                                // Set the message ID, customer ID, and sender name in the reply modal
                                $('#modal_adminreply').find('[name="message_ID"]').val(messageId);
                                $('#modal_adminreply').find('[name="customer_ID"]').val(customerId);
                                $('#modal_adminreply').find('.message-sender').text(senderName);

                                // Show the reply modal using Bootstrap's modal method
                                $('#modal_adminreply').modal('show');
                            }
                        </script>
                        <!-- ADMIN REPLY MESSAGE MODAL -- FOR REPLYING MESSAGES -->



                        <button type="button" class="btn btn-secondary position-relative" id="openAdminNotifModalBtn" data-bs-toggle="modal" data-bs-target="#modal_adminnotif" style="margin-right: 25px;">
                            Notifications
                            <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php
                                // Fetch the count of new feedbacks for today
                                $sqlFeedback = "SELECT COUNT(feedback_ID) AS feedbackCount FROM tbl_feedback"; // WHERE DATE(date) = CURDATE()
                                $stmtFeedback = $conn->prepare($sqlFeedback);
                                $stmtFeedback->execute();
                                $feedbackCount = $stmtFeedback->fetchColumn();

                                // Fetch the count of new customers for today
                                $sqlCustomers = "SELECT COUNT(customer_ID) AS customerCount FROM tbl_customer_info"; // WHERE DATE(dateAdded) = CURDATE()
                                $stmtCustomers = $conn->prepare($sqlCustomers);
                                $stmtCustomers->execute();
                                $customerCount = $stmtCustomers->fetchColumn();

                                // Calculate and display the combined count of feedbacks and new customers
                                $totalNotifications = $feedbackCount + $customerCount;
                                echo $totalNotifications;
                                ?>
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </button>

                        <!-- ADMIN NOTIFICATIONS MODAL -- FOR VIEWING ADMIN NOTIFICATIONS -->
                        <div class="modal fade" id="modal_adminnotif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="margin-left: 350px;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="staticBackdropLabel" style="color: Black;">Notifications</h3>
                                        <img src="pages/admin/GIF_NOTIFICATIONS.gif" style="width: 1.1in; height: .6in; margin-left: 0px; margin-top: 0px;" id="adminnotif_gif">
                                    </div>

                                    <div class="scrollable-content" id="inputfields" style="height: 500px; overflow-y: auto; color: black; background: lightgray;">
                                        <div class="" style="position: relative;">
                                            <?php
                                            // Fetch and display customer registrations and feedback submissions
                                            $sqlNotifications = "
                                                (SELECT CONCAT(firstName, ' ', lastName) AS name, dateAdded AS date, 'registration' AS type
                                                FROM tbl_customer_info)
                                                UNION
                                                (SELECT CONCAT(firstName, ' ', lastName) AS name, date, 'feedback' AS type
                                                FROM tbl_customer_info ci
                                                JOIN tbl_feedback f ON ci.customer_id = f.customer_id)
                                                ORDER BY date DESC
                                            ";

                                            $stmtNotifications = $conn->prepare($sqlNotifications);
                                            $stmtNotifications->execute();
                                            $notifications = $stmtNotifications->fetchAll();

                                            foreach ($notifications as $notification) {
                                                echo '<div class="row" style="background-color: white; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.166);
                                                    border-radius: 5px; font-size: 20px; width: 450px; margin-left: 15px; margin-top: 20px;">'; //#ecffed

                                                if ($notification['type'] == 'registration') {
                                                    // echo '<img src="images/<?php echo $image; >" class="img-fluid zoomable-image rounded-square" style="position: absolute; width: 50px; border-radius: 25px;">';
                                                    echo '<p style="margin-top: 10px;"><strong>' . $notification['name'] . '</strong> has registered an account.</p>';
                                                } elseif ($notification['type'] == 'feedback') {
                                                    echo '<p style="margin-top: 10px;"><strong>' . $notification['name'] . '</strong> has submitted a feedback.</p>';
                                                }

                                                // Display relative date and time below
                                                echo '<p class="" style="color: blue; font-size: 15px; margin-top: -10px;">' . formatRelativeDate($notification['date']) . '</p>';

                                                echo '</div>';
                                            }

                                            // Function to format relative date and time
                                            function formatRelativeDate($date)
                                            {
                                                $now = new DateTime();
                                                $formattedDate = new DateTime($date);
                                                $interval = $now->diff($formattedDate);

                                                if ($interval->days == 0) {
                                                    if ($interval->h == 0) {
                                                        return 'Today';
                                                    } else {
                                                        return 'Today @ ' . $formattedDate->format('h:i A'); // 12-hour format with AM/PM
                                                    }
                                                } elseif ($interval->days == 1) {
                                                    return 'Yesterday @ ' . $formattedDate->format('h:i A');
                                                } else {
                                                    return $interval->days . ' days ago @ ' . $formattedDate->format('h:i A');
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer" style="height: 70px;">
                                        <button type="button" class="btn btn-secondary float-end" style="margin-top: 15px; margin-bottom: 15px; margin-right: 5px;" id="adminnotif_closeModalBtn" data-bs-dismiss="modal"
                                        >Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            function openmodal_adminnotif() {
                                $('#modal_adminnotif').modal('show');
                            }
                        </script>
                        <!-- END ADMIN NOTIFICATIONS MODAL -- FOR VIEWING ADMIN NOTIFICATIONS -->









                        

                        <img src="images/<?php echo $adminimage; ?>" class="img-fluid zoomable-image rounded-square" onclick="to_adminacc()" style="width: 30px; height: 30px; border-radius: 15px;">

                        <div class = " m-2 text-light" >   
                            <b class = "bg-transparent "  id="accountLink" onclick="to_adminacc()" style=" cursor: pointer;"> <img src="navigation/user.png" alt=""
                            >Account</b>
                        </div>

                    </div>
                </nav>
            </div>







            <div class="row">
                <div class="col-1">
                </div>
                <div class="col-11">
                    
                    <!-- ROW1 -->
                    <h3 style="position: relative; width: 200px; color: white; margin-left: 60px; margin-top: 20px;"
                    >Customer List</h3>
                    
                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                    style="width: 150px; float: right; margin-top: -50px; margin-right: -660px;" onclick="editUser()"
                    >Edit User</button>

                    <div class="col-11" style="margin-top: 0px;">
                        <!-- Step 4: Display data in the table format -->
                        <div class="scrollable-content" id="inputfields" style="margin-left: 60px; height: 400px; overflow-y: auto;">
                            <?php
                                // Step 2: Fetch all data from tbl_customer_info with column aliases
                                $sql = "SELECT customer_ID AS 'Customer ID',
                                        firstName AS 'Firstname',
                                        middleName AS 'Middlename',
                                        lastName AS 'Lastname',
                                        street AS 'Street',
                                        barangay AS 'Barangay',
                                        municipality AS 'Municipality',
                                        province AS 'Province',
                                        zipcode AS 'Zipcode',
                                        phoneNumber AS 'Phone Number',
                                        birthDate AS 'Birthdate',
                                        gender AS 'Gender',
                                        email AS 'Email',
                                        password AS 'Password',
                                        dateAdded AS 'Creation Date'
                                FROM tbl_customer_info";

                                // $sql = "SELECT customer_ID AS 'Customer ID',
                                //     CONCAT(firstName, ' ', lastName) AS 'Full Name',
                                //     email AS 'Email',
                                //     dateAdded AS 'Creation Date'
                                // FROM tbl_customer_info";

                                $stmt = $conn->prepare($sql);
                                $stmt->execute();

                                // Step 3: Create arrays to store the data
                                $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <div class="scrollable-content" id="inputfields" style="position: absolute; height: 470px; overflow-y: auto; width: 1300px;">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Move the button outside of the table -->
                                        <table class="table table-bordered" style="color: white;">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    $aliasRow = $customerData[0];

                                                    foreach ($aliasRow as $alias => $value) {
                                                        echo "<th style='background-color: rgb(255, 204, 0); color: black;'>$alias</th>";
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Loop through the data and populate the table
                                                foreach ($customerData as $row) {
                                                    echo "<tr onclick='highlightRow(this)' style='cursor: pointer;'>";
                                                    
                                                    // Display the data columns
                                                    foreach ($row as $key => $value) {
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

                            <style>
                                .highlighted-row {
                                    background-color: rgba(248, 215, 218, 0.2) !important;
                                }
                                /* Remove the edit-column class and style */
                            </style>

                            <script>
                                function highlightRow(row) {
                                    // Remove 'highlighted-row' class from all rows
                                    var rows = document.querySelectorAll('tr');
                                    rows.forEach(function (r) {
                                        r.classList.remove('highlighted-row');
                                    });

                                    // Add 'highlighted-row' class to the clicked row
                                    row.classList.add('highlighted-row');
                                }

                                // Function to handle the "Edit" button click
                                function editUser() {
                                    // Find the highlighted row
                                    var highlightedRow = document.querySelector('.highlighted-row');

                                    // Check if a row is highlighted
                                    if (highlightedRow) {
                                        // Get the customer_ID from the highlighted row
                                        var customerID = highlightedRow.cells[0].textContent; // Assuming customer_ID is in the first column
                                        var firstName = highlightedRow.cells[1].textContent;
                                        var middleName = highlightedRow.cells[2].textContent;
                                        var lastName = highlightedRow.cells[3].textContent;
                                        var street = highlightedRow.cells[4].textContent;
                                        var barangay = highlightedRow.cells[5].textContent;
                                        var municipality = highlightedRow.cells[6].textContent;
                                        var province = highlightedRow.cells[7].textContent;
                                        var zipcode = highlightedRow.cells[8].textContent;
                                        var phoneNumber = highlightedRow.cells[9].textContent;
                                        var birthDate = highlightedRow.cells[10].textContent;
                                        // var gender = highlightedRow.cells[11].textContent;

                                        // Set the customer_ID value in the offcanvas input field
                                        document.getElementById('customer_ID').value = customerID;
                                        document.getElementById('firstname').value = firstName;
                                        document.getElementById('middlename').value = middleName;
                                        document.getElementById('lastname').value = lastName;
                                        document.getElementById('street').value = street;
                                        document.getElementById('barangay').value = barangay;
                                        document.getElementById('municipality').value = municipality;
                                        document.getElementById('province').value = province;
                                        document.getElementById('zipcode').value = zipcode;
                                        document.getElementById('phonenumber').value = phoneNumber;
                                        document.getElementById('birthdate').value = birthDate;
                                        // document.getElementById('').value = gender;

                                        // Open the offcanvas
                                        var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
                                        offcanvas.show();
                                    } else {
                                        alert("Please select a row before clicking 'Edit User'.");
                                    }
                                }
                            </script>

                        </div>



                                                


                        <!-- OFFCANVA -->
                        <div class="offcanvas offcanvas-end bg-dark" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width: 520px;">
                            <div class="offcanvas-header">
                                <form id="edituser_form" method="POST" action="actions_admin/edit_customer_info.php">
                                    <h5 class="modal-title" id="staticBackdropLabel" style="font-size: 30px;">Edit Customer Data</h5>
                                    <hr>
                                    <div class="input" id="inputfields" style="height: 400px;">
                                        <div class="row">
                                            <p class="sub_title_2" id="sub_title_name" style="width: 116px;">Customer ID:</p>
                                            <input type="text" placeholder="ID#" class="customer_ID" name="customer_ID" id="customer_ID" value="<?php echo $customerID; ?>"/>
                                        </div>
                                        <hr>
                                        <p class="sub_title_2" id="sub_title_name">Name</p>
                                        <input type="text" placeholder="Firstname" class="firstname" name="firstname" id="firstname" value="<?php echo $firstName; ?>"/>
                                        <input type="text" placeholder="Middlename" class="middlename" name="middlename" id="middlename" value="<?php echo $middleName; ?>" />
                                        <input type="text" placeholder="Lastname" class="lastname" name="lastname" id="lastname" value="<?php echo $lastName; ?>" />
                                        <hr>
                                        <p class="sub_title_2" id="sub_title_address">Address</p>
                                        <input type="text" placeholder="Street" class="street" name="street" id="street" value="<?php echo $street; ?>"/>
                                        <input type="text" placeholder="Barangay" class="barangay" name="barangay" id="barangay" value="<?php echo $barangay; ?>" />
                                        
                                        <input type="text" placeholder="Municipality" class="municipality" name="municipality" id="municipality" value="<?php echo $municipality; ?>" />
                                        <input type="text" placeholder="Province" class="province" name="province" id="province" value="<?php echo $province; ?>"/>
                                        
                                        <input type="text" placeholder="Zipcode" class="zipcode" name="zipcode" id="zipcode" value="<?php echo $zipcode; ?>" />
                                        <input type="text" placeholder="Phone number" class="phonenumber" name="phonenumber" id="phonenumber" value="<?php echo $phoneNumber; ?>" />

                                        <!-- <input type="date" placeholder="Birthdate" class="birthdate" name="birthdate" id="p_row5" value="<php echo $birthDate; ?>" /> -->
                                        <hr>
                                        <label id="sub_title_dob">Date of Birth</label>
                                        <label id="sub_title_gend">Gender</label>
                                        <div class="options">
                                            <!-- Update these lines in the profile modal -->
                                            <select class="box1" id="day" name="day" style="color: gray;">
                                                
                                            </select>
                                            <select class="box2" id="month" name="month" style="color: gray;">
                                                
                                            </select>
                                            <select class="box3" id="year" name="year" style="color: gray;">
                                                
                                            </select>

                                            
                                            <input type="radio" id="fem" name="gender" value="Female">
                                            <label for="gender">Female</label>

                                            <input type="radio" id="mal" name="gender" value="Male">
                                            <label for="mal">Male</label>

                                            <!-- <input type="radio" id="fem" name="gender" value="Female" <?php echo ($gender === 'Female') ? 'checked' : ''; ?> required>
                                            <label for="fem" style="color: lightgray;">Female</label>
                                            <input type="radio" id="mal" name="gender" value="Male" <?php echo ($gender === 'Male') ? 'checked' : ''; ?> required>
                                            <label for="mal" style="color: lightgray;">Male</label> -->

                                        </div>
                                        <hr>
                                    </div>

                                    <div class="offcanvas-body">
                                        <button type="submit" class="btn bg-secondary" name="submit" id="prof_modalsave">Save</button>
                                        <button type="button" class="btn bg-secondary" id="prof_closeModalBtn" data-bs-dismiss="offcanvas" >Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END OFFCANVA -->

                    </div>
                    <div class="col-1">
                    </div>
                </div>
                <!-- ROW1 END -->

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



                <!-- ROW2 -->
                <div class="row">
                    <div class="col-1">
                    </div>
                    <div class="col-10">
                        <!-- ROW2 -->
                        <h3 style="position: relative; width: 350px; color: white; margin-left: 60px; margin-top: 100px; margin-bottom: 10px;"
                        >Feedback List</h3>
                        <div class="row">
                            <!-- Step 4: Display data in the table format -->
                            <div class="scrollable-content" id="inputfields" style="margin-left: 60px; height: 400px; overflow-y: auto;">
                                <?php
                                // Step 2: Fetch all data from tbl_customer_info
                                $sql = "SELECT * FROM tbl_customer_info";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();

                                // Step 3: Create arrays to store the data
                                $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Step 2: Fetch data from tbl_customer_info
                                $sql = "SELECT
                                    ci.customer_ID AS 'Customer ID',
                                    CONCAT(ci.firstName, ' ', ci.MiddleName, ' ',ci.lastName) AS 'Full Name',
                                    fb.feedback AS 'Feedback',
                                    fb.suggestion AS 'Suggestion',
                                    fb.question AS 'Question',
                                    fb.rating AS 'Rating',
                                    fb.date AS 'Date'
                                FROM tbl_customer_info AS ci
                                JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID";

                                $stmt = $conn->prepare($sql);
                                $stmt->execute();

                                // Step 3: Create arrays to store the data
                                $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <!-- Step 4: Display data in the table format with renamed columns -->
                                <div class="scrollable-content" id="inputfields" style="position: absolute; height: 470px; overflow-y: auto; width: 1300px; margin-bottom: -50px;">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-bordered" style="color: white;">
                                                <thead>
                                                    <tr>
                                                        <?php
                                                        // Display column aliases as headers
                                                        $aliasRow = $customerData[0];

                                                        foreach ($aliasRow as $alias => $value) {
                                                            echo "<th style='background-color: rgb(255, 204, 0); color: black;'>$alias</th>";
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
                        </div>
                    </div>
                    <div class="col-1">
                    </div>
                    <!-- COL-11 END -->
                </div>
                <!-- ROW2 END -->
            </div>
        </div>
    </div>
    <!-- END PARALLAX -->



    <!-- ADMIN DASHBOARD - FOR VIEWING ADMIN DASHBOARD -->
    <div class="row" id="dash_bg">

        <div class="col-1">
            <div class="card-body" id="cards_body1">

            </div>
        </div>

        <div class="col-11">

            <div class="body">
            
                <h5 style="position: absolute; margin-top: 40px; margin-bottom: 25px; margin-left: 140px; font-size: 70px; color: gray;"
                >Feedback Report</h5>
                <img src="pages/admin/GIF_REPORT.gif" style="position: absolute; width: 2.15in; height: 1.1in; margin-left: 680px; margin-top: 35px;" id="newfb_gif">

                <div class="container">
                
                    <!-- <div class="modal-body" id="dashbody" style="justify-content: center; background: yellow;">  BODY COLOR -->
                




                    <div class="row"> <!-- ROW 1 - ADMIN DASHBOARD - REPORTS -->

                        <div class="card-body" id="cards_body2" style="justify-content: center; background: white;"> <!--BLUE-->
                        
                            <h5 style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">Today's data</h5>
                            
                            <h6 style="position: absolute; margin-top: -12px; margin-left: 960px; color: grey">Newest data appears first</h6>

                            <hr>

                            <!-- ROW 1 -->
                            <div class="" style="padding: 20px;">

                                <div class="col-4 justify-content-center";>

                                    <?php
                                        // Step 2: Fetch all data from tbl_feedback
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Step 3: Create arrays to store the data
                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT COUNT(feedback_ID) AS feedbackCount
                                                FROM tbl_feedback WHERE DATE(date) = CURDATE()";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Fetch the count of feedback entries
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $feedbackCount = $result['feedbackCount'];
                                    ?>
                                    
                                    <div class="card border-0 fixed-width-element" id="card1">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 75px;"
                                                >New Feedbacks</h6>
                                                <img src="pages/home/GIF_NEWFB.gif" style="width: 1.4in; height: .80in; margin-left: 142px; margin-top: -27px;" id="newfb_gif">

                                                <div style="position: absolute; margin-left: 1px; margin-top: 67px; width: 280px; line-height: 1.1;">
                                                    <?php
                                                        // Step 1: Get the count of total customers from tbl_customer_info
                                                        $sqlTotalCustomers = "SELECT COUNT(*) AS totalCustomers FROM tbl_customer_info";
                                                        $stmtTotalCustomers = $conn->prepare($sqlTotalCustomers);
                                                        $stmtTotalCustomers->execute();
                                                        $resultTotalCustomers = $stmtTotalCustomers->fetch(PDO::FETCH_ASSOC);
                                                        $totalCustomers = $resultTotalCustomers['totalCustomers'];

                                                        // Step 2: Get the count of feedback entries for today from tbl_feedback
                                                        $sqlFeedbackToday = "SELECT COUNT(DISTINCT customer_ID) AS feedbackCount FROM tbl_feedback WHERE DATE(date) = CURDATE()";
                                                        $stmtFeedbackToday = $conn->prepare($sqlFeedbackToday);
                                                        $stmtFeedbackToday->execute();
                                                        $resultFeedbackToday = $stmtFeedbackToday->fetch(PDO::FETCH_ASSOC);
                                                        $feedbackCountToday = $resultFeedbackToday['feedbackCount'];

                                                        // Display the result
                                                        echo "$feedbackCountToday out of $totalCustomers customers sent us new feedbacks today.";
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>

                                <div class="col-8" style="position: absolute; margin-left: 380px; margin-top: -200px;">
                                    <?php
                                    $sql = "SELECT * FROM tbl_customer_info";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();

                                    $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    $sql = "SELECT
                                        CONCAT(ci.firstName, ' ', ci.MiddleName, ' ',ci.lastName) AS 'Customer',
                                        fb.feedback AS 'Feedback',
                                        fb.suggestion AS 'Suggestion',
                                        fb.question AS 'Question',
                                        fb.rating AS 'Rating',
                                        fb.date AS 'Date'
                                    FROM tbl_customer_info AS ci
                                    JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID
                                    WHERE DATE(date) = CURDATE()
                                    ORDER BY date DESC";

                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();

                                    $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table1">
                                        <table class="table table-bordered class alternate-row-table" id="card1_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    if (!empty($customerData)) {
                                                        $aliasRow = $customerData[0]; // Assuming the first row contains aliases
                                                        foreach ($aliasRow as $alias => $value) {
                                                            echo "<th style='background-color: #c8e7c9; color: black;'>$alias</th>";
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (empty($customerData)) {
                                                    // Display the "No feedback yet for today" message in the table body
                                                    echo '<tr><td colspan="6" style="text-align: center; background-color: transparent; color: black;"
                                                    >No feedbacks yet for today</td></tr>';
                                                } else {
                                                    // Loop through the data and populate the table
                                                    foreach ($customerData as $row) {
                                                        echo "<tr>";
                                                        foreach ($row as $value) {
                                                            echo "<td>$value</td>";
                                                        }
                                                        echo "</tr>";
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                
                            </div>
                            <!-- END ROW 1 -->

                            <hr>

                            <!-- END ROW 2 -->
                            <div class="" style="padding: 20px;"> <!-- ROW 2 -->  

                                <div class="col-4 justify-content-center">
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
                                    
                                    <div class="card border-0 fixed-width-element" id="card2">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 75px;"
                                                >Total Feedbacks</h6>
                                                <img src="pages/home/GIF_TOTALFB.gif" style="width: 1.5in; height: .80in; margin-left: 130px; margin-top: -20px;" id="totalfb_gif">
                                                
                                                <div style="position: absolute; margin-left: 1px; margin-top: 60px; width: 280px; line-height: 1.1;">
                                                    <?php
                                                        // Step 1: Get the count of total customers from tbl_customer_info
                                                        $sqlTotalCustomers = "SELECT COUNT(*) AS totalCustomers FROM tbl_customer_info";
                                                        $stmtTotalCustomers = $conn->prepare($sqlTotalCustomers);
                                                        $stmtTotalCustomers->execute();
                                                        $resultTotalCustomers = $stmtTotalCustomers->fetch(PDO::FETCH_ASSOC);
                                                        $totalCustomers = $resultTotalCustomers['totalCustomers'];

                                                        // Step 2: Get the count of distinct customer IDs who sent feedback today from tbl_feedback
                                                        $sqlFeedbackToday = "SELECT COUNT(DISTINCT customer_ID) AS feedbackCount FROM tbl_feedback";
                                                        $stmtFeedbackToday = $conn->prepare($sqlFeedbackToday);
                                                        $stmtFeedbackToday->execute();
                                                        $resultFeedbackToday = $stmtFeedbackToday->fetch(PDO::FETCH_ASSOC);
                                                        $feedbackCountToday = $resultFeedbackToday['feedbackCount'];

                                                        // Display the result
                                                        echo "$feedbackCountToday out of $totalCustomers customers sent us feedbacks.";
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-8" style="position: absolute; margin-left: 380px; margin-top: -200px;">

                                    <?php
                                        $sql = "SELECT * FROM tbl_customer_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT
                                            fb.feedback AS 'Feedback',
                                            fb.suggestion AS 'Suggestion',
                                            fb.question AS 'Question',
                                            fb.rating AS 'Rating',
                                            fb.date AS 'Date',
                                            CONCAT(ci.firstName, ' ', ci.MiddleName, ' ',ci.lastName) AS 'Customer'
                                        FROM tbl_customer_info AS ci
                                        JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID
                                        ORDER BY date DESC";

                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table2"> <!-- border: black 5px solid;-->
                                    
                                        <table class="table table-bordered class alternate-row-table" id="card2_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    $aliasRow = $customerData[0]; // Assuming the first row contains aliases

                                                    foreach ($aliasRow as $alias => $value) {
                                                        echo "<th style='background-color: #d0c9e8; color: black;'>$alias</th>";
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
                            <!-- END ROW 2 -->

                            <hr>

                            <!-- ROW 3 -->
                            <div class="" style="padding: 20px;"> <!-- RED -->  

                                <div class="col-4 justify-content-center">
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
                                    
                                    <div class="card border-0 fixed-width-element" id="card3">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $feedbackAverage; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 75px;"
                                                >Feedbacks a day</h6>
                                                <img src="pages/home/GIF_FBPERDAY.gif" style="width: 1.4in; height: .85in; margin-left: 142px; margin-top: -20px;" id="fbperday_gif">

                                                <div style="position: absolute; margin-left: 1px; margin-top: 56px; width: 280px; line-height: 1.1;">
                                                <?php
                                                    // Step 1: Get the average feedback count for the past days
                                                    $sqlFeedbackPast = "SELECT AVG(feedbackCount) AS averageFeedbackCountPast FROM (
                                                        SELECT COUNT(*) AS feedbackCount FROM tbl_feedback
                                                        WHERE DATE(date) < CURDATE()
                                                        GROUP BY DATE(date)
                                                    ) AS subquery";
                                                    $stmtFeedbackPast = $conn->prepare($sqlFeedbackPast);
                                                    $stmtFeedbackPast->execute();
                                                    $resultFeedbackPast = $stmtFeedbackPast->fetch(PDO::FETCH_ASSOC);
                                                    $averageFeedbackCountPast = $resultFeedbackPast['averageFeedbackCountPast'];

                                                    // Step 2: Get the feedback count for today
                                                    $sqlFeedbackToday = "SELECT AVG(feedbackCount) AS averageFeedbackCountToday FROM (
                                                        SELECT COUNT(*) AS feedbackCount FROM tbl_feedback
                                                        GROUP BY DATE(date)
                                                    ) AS subquery";
                                                    $stmtFeedbackToday = $conn->prepare($sqlFeedbackToday);
                                                    $stmtFeedbackToday->execute();
                                                    $resultFeedbackToday = $stmtFeedbackToday->fetch(PDO::FETCH_ASSOC);
                                                    $averageFeedbackCountToday = $resultFeedbackToday['averageFeedbackCountToday'];

                                                    // Calculate the improvement as today's feedback count divided by past average
                                                    $improvementPercentage = ($averageFeedbackCountToday / $averageFeedbackCountPast);

                                                    // Format the percentage with two decimal places
                                                    $formattedImprovementPercentage = number_format($improvementPercentage, 2);

                                                    // Display the result
                                                    echo "We are " . $formattedImprovementPercentage . " times improved compared to the previous days.";
                                                ?>
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-8" style="position: absolute; margin-left: 380px; margin-top: -200px;">

                                    <?php
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT
                                            COUNT(feedback_ID) AS 'Number of Feedbacks',
                                            DATE(date) AS 'Date'
                                        FROM tbl_feedback
                                        GROUP BY DATE(date) DESC";

                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table3"> <!-- border: black 5px solid;-->
                                    
                                        <table class="table table-bordered class alternate-row-table" id="card3_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    $aliasRow = $customerData[0]; // Assuming the first row contains aliases

                                                    foreach ($aliasRow as $alias => $value) {
                                                        echo "<th style='background-color: #e3c8c8; color: black;'>$alias</th>";
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
                            <!-- END ROW 3 -->

                            <hr>

                            <!-- ROW 4 -->
                            <div class="" style="padding: 20px;"> <!-- RED -->  

                                <div class="col-4 justify-content-center">
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
                                    
                                    <div class="card border-0 fixed-width-element" id="card4">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $customerCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 75px;"
                                                >Customers</h6>
                                                <img src="pages/home/GIF_CUSTOMERS.gif" style="width: 1.2in; height: .7in; margin-left: 160px; margin-top: -15px;" id="customers_gif">
                                                    
                                                    <div style="position: absolute; margin-left: 1px; margin-top: 65px; width: 280px; line-height: 1.1;">
                                                        <?php
                                                            // Calculate the number of new customers for the past 3 days
                                                            $sqlNewCustomers = "SELECT COUNT(*) AS newCustomers FROM tbl_customer_info WHERE DATE(dateAdded) BETWEEN CURDATE() - INTERVAL 3 DAY AND CURDATE()";
                                                            $stmtNewCustomers = $conn->prepare($sqlNewCustomers);
                                                            $stmtNewCustomers->execute();
                                                            $resultNewCustomers = $stmtNewCustomers->fetch(PDO::FETCH_ASSOC);
                                                            $newCustomers = $resultNewCustomers['newCustomers'];

                                                            // Display the result
                                                            echo "We have gained $newCustomers new customers for the past 3 days.";
                                                        ?>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-8" style="position: absolute; margin-left: 380px; margin-top: -200px;">

                                    <?php
                                        $sql = "SELECT * FROM tbl_customer_info";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT
                                            ci.customer_ID AS 'ID',
                                            CONCAT(ci.firstName, ' ', ci.MiddleName, ' ',ci.lastName) AS 'Customer',
                                            ci.dateAdded AS 'Registration Date'
                                        FROM tbl_customer_info AS ci
                                        ORDER BY customer_ID DESC";

                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table4"> <!-- border: black 5px solid;-->
                                    
                                        <table class="table table-bordered class alternate-row-table" id="card4_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    $aliasRow = $customerData[0]; // Assuming the first row contains aliases

                                                    foreach ($aliasRow as $alias => $value) {
                                                        echo "<th style='background-color: #cacbe8; color: black;'>$alias</th>";
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

                            <!-- END ROW 4 -->

                            <hr>

                            <!-- ROW 5 -->
                            <div class="" style="padding: 20px;"> <!-- GREEN COLOR -->

                                <div class="col-4 justify-content-center">
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
                                    
                                    <div class="card border-0 fixed-width-element" id="card5">
                                        <div class="card-body" style="text-align: left;">
                                            <div class="card-body">
                                                <h1 class="card-title"style="font-size: 90px; position: absolute; margin-top: -25px;"><?php echo $ratingCount; ?></h1>
                                                <h6 class="card-subtitle mb-2 text-muted" style="font-size: 30px; position: absolute; margin-top: 75px;"
                                                >5&#9733; Rating</h6>
                                                <img src="pages/home/GIF_RATING.gif" style="width: 1.65in; height: .90in; margin-left: 115px; margin-top: -20px;" id="rating_gif">
                                                
                                                <div style="position: absolute; margin-left: 1px; margin-top: 50px; width: 280px; line-height: 1.1;">
                                                    <?php
                                                        // Step 1: Get the count of all feedback entries
                                                        $sqlTotalFeedback = "SELECT COUNT(*) AS totalFeedback FROM tbl_feedback";
                                                        $stmtTotalFeedback = $conn->prepare($sqlTotalFeedback);
                                                        $stmtTotalFeedback->execute();
                                                        $resultTotalFeedback = $stmtTotalFeedback->fetch(PDO::FETCH_ASSOC);
                                                        $totalFeedback = $resultTotalFeedback['totalFeedback'];

                                                        // Step 2: Get the count of feedback entries rated with 5 stars
                                                        $sqlFeedbackWithFiveStars = "SELECT COUNT(*) AS feedbackCount FROM tbl_feedback WHERE rating = 5";
                                                        $stmtFeedbackWithFiveStars = $conn->prepare($sqlFeedbackWithFiveStars);
                                                        $stmtFeedbackWithFiveStars->execute();
                                                        $resultFeedbackWithFiveStars = $stmtFeedbackWithFiveStars->fetch(PDO::FETCH_ASSOC);
                                                        $feedbackCountWithFiveStars = $resultFeedbackWithFiveStars['feedbackCount'];

                                                        // Calculate the percentage of feedbacks rated with 5 stars
                                                        if ($totalFeedback > 0) {
                                                            $percentage = ($feedbackCountWithFiveStars / $totalFeedback) * 100;
                                                        } else {
                                                            $percentage = 0;
                                                        }

                                                        // Format the percentage with two decimal places
                                                        $formattedPercentage = number_format($percentage, 2);

                                                        // Display the result
                                                        echo "$formattedPercentage% of feedbacks rated us with 5 stars.";
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-8" style="position: absolute; margin-left: 380px; margin-top: -200px;">

                                    <?php
                                        $sql = "SELECT * FROM tbl_feedback";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $sql = "SELECT
                                            fb.rating AS 'Rating',
                                            CONCAT(ci.firstName, ' ', ci.MiddleName, ' ',ci.lastName) AS 'Customer',
                                            fb.date AS 'Date'
                                        FROM tbl_customer_info AS ci
                                        JOIN tbl_feedback AS fb ON ci.customer_ID = fb.customer_ID
                                        WHERE rating = 5
                                        ORDER BY date DESC";

                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="scrollable-content" id="table5"> <!-- border: black 5px solid;-->
                                    
                                        <table class="table table-bordered class alternate-row-table" id="card5_table">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    // Display column aliases as headers
                                                    $aliasRow = $customerData[0]; // Assuming the first row contains aliases

                                                    foreach ($aliasRow as $alias => $value) {
                                                        echo "<th style='background-color: #dcddc7; color: black;'>$alias</th>";
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

                            <hr>

                        </div> <!--BLUE-->

                    </div>  <!-- END ROW 1 - ADMIN DASHBOARD - REPORTS -->

                    





                    <div class="row"> <!-- ROW 2 - ADMIN DASHBOARD - LINE CHART -->

                        <div class="card-body" id="cards_body3" style="justify-content: center; background: white;"> <!--BLUE-->
                        
                            <div class="row">
                                
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-6" style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">
                                        <h5>Line Chart</h5>
                                    </div>
                                    <div class="col-6">
                                        <h5></h5>
                                    </div>
                                    <hr>
                                </div>


                                <div class="row">

                                    <div class="col-6" style="margin-bottom: 20px;">
                                        
                                        <?php
                                            $sql = "SELECT DATE(date) as day, COUNT(*) as feedbackCount
                                                    FROM tbl_feedback
                                                    GROUP BY DATE(date)
                                                    ORDER BY DATE(date)";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            $days = [];
                                            $feedbackCounts = [];

                                            foreach ($result as $row) {
                                                $days[] = $row['day'];
                                                $feedbackCounts[] = $row['feedbackCount'];
                                            }
                                        ?>

                                        <script>
                                            var days = <?php echo json_encode($days); ?>;
                                            var feedbackCounts = <?php echo json_encode($feedbackCounts); ?>;
                                        </script>



                                        <div style="width: 500px; margin: 0 auto;">
                                            <canvas id="LineChart1"></canvas>
                                        </div>

                                        <script>
                                            var ctx = document.getElementById('LineChart1').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: days,
                                                    datasets: [{
                                                        label: 'Feedbacks per Day',
                                                        data: feedbackCounts,
                                                        borderColor: 'rgba(75, 192, 192, 1)',
                                                        borderWidth: 1,
                                                        fill: false
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    },
                                                    plugins: {
                                                        legend: {
                                                            display: false,
                                                            position: 'bottom' // or 'top', 'left', 'right' based on your preference
                                                        }
                                                    }
                                                }
                                            });
                                        </script>

                                        <h5 style="text-align: center; font-size: 18px; margin-top: 20px; color: rgb(128, 128, 128);"
                                        >Feedbacks per Day</h5>

                                    </div>



                                    <div class="col-6" style="margin-bottom: 20px;">
                                        
                                        <?php
                                            $sql = "SELECT DATE(dateAdded) as day, COUNT(*) as customerCount
                                                    FROM tbl_customer_info
                                                    GROUP BY DATE(dateAdded)
                                                    ORDER BY DATE(dateAdded)";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            $days = [];
                                            $customerCounts = [];

                                            foreach ($result as $row) {
                                                $days[] = $row['day'];
                                                $customerCounts[] = $row['customerCount'];
                                            }
                                        ?>

                                        <script>
                                            var days = <?php echo json_encode($days); ?>;
                                            var customerCounts = <?php echo json_encode($customerCounts); ?>;
                                        </script>



                                        <div style="width: 500px; margin: 0 auto;">
                                            <canvas id="LineChart2"></canvas>
                                        </div>

                                        <script>
                                            var ctx = document.getElementById('LineChart2').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: days,
                                                    datasets: [{
                                                        label: 'Customers per Day',
                                                        data: customerCounts,
                                                        borderColor: 'rgba(75, 192, 192, 1)',
                                                        borderWidth: 1,
                                                        fill: false
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    },
                                                    plugins: {
                                                        legend: {
                                                            display: false,
                                                            position: 'bottom' // or 'top', 'left', 'right' based on your preference
                                                        }
                                                    }
                                                }
                                            });
                                        </script>

                                        <h5 style="text-align: center; font-size: 18px; margin-top: 20px; color: rgb(128, 128, 128);"
                                        >Customers per Day</h5>

                                    </div>

                                    <hr>



                                </div>

                            </div>

                        </div>
                    </div>  <!-- END ROW 2 - ADMIN DASHBOARD - LINE CHART -->






                    <div class="row"> <!-- ROW 3 - ADMIN DASHBOARD - PIE CHART -->

                        <div class="card-body" id="cards_body4" style="justify-content: center; background: white;"> <!--BLUE-->
                        
                            <div class="row">
                                
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-6" style="margin-top: 5px; margin-left: 30px; margin-bottom: -10px;">
                                        <h5>Pie Chart</h5>
                                    </div>
                                    <div class="col-6">
                                        <h5></h5>
                                    </div>
                                    <hr>
                                </div>


                                <div class="row">

                                    <div class="col-6" style="margin-bottom: 20px;">
                                        
                                        <div style="width: 400px; margin: 0 auto;">
                                            <canvas id="pieChart1"></canvas>
                                        </div>

                                        <script>
                                            <?php
                                            // Sample SQL query to calculate average ratings
                                            $sql = "SELECT rating, COUNT(*) as count FROM tbl_feedback GROUP BY rating";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            $ratings = [];
                                            $counts = [];

                                            foreach ($result as $row) {
                                                $ratings[] = $row['rating'];
                                                $counts[] = $row['count'];
                                            }
                                            ?>

                                            // Create a JavaScript array with your PHP data
                                            var ratings = <?php echo json_encode($ratings); ?>;
                                            var counts = <?php echo json_encode($counts); ?>;

                                            var ctx = document.getElementById('pieChart1').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'pie',
                                                data: {
                                                    labels: ratings,
                                                    datasets: [{
                                                        data: counts,
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.6)',
                                                            'rgba(255, 159, 64, 0.6)',
                                                            'rgba(255, 205, 86, 0.6)',
                                                            'rgba(75, 192, 192, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)',
                                                        ],
                                                    }]
                                                },
                                                options: {
                                                    plugins: {
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(context) {
                                                                    var label = context.label + 'rating'|| '';
                                                                    var value = context.parsed || 0;
                                                                    var total = context.dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                                                        return previousValue + currentValue;
                                                                    });
                                                                    var percentage = (value / total * 100).toFixed(2) + '%';
                                                                    return percentage + " (" + value + " of " + total + " Feedbacks)";
                                                                    
                                                                }

                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                            
                                        </script>
                                        
                                        <h5 style="text-align: center; font-size: 18px; margin-top: 20px; color: rgb(128, 128, 128);"
                                        >Rating Percentage</h5>

                                    </div>



                                    <!-- <div class="col-6" style="margin-bottom: 20px;">
                                        
                                        <div style="width: 400px; margin: 0 auto;">
                                            <canvas id="pieChart2"></canvas>
                                        </div>

                                        <script>
                                            <?php
                                            // Sample SQL query to calculate average ratings
                                            $sql = "SELECT rating, COUNT(*) as count FROM tbl_feedback GROUP BY rating";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            $ratings = [];
                                            $counts = [];

                                            foreach ($result as $row) {
                                                $ratings[] = $row['rating'];
                                                $counts[] = $row['count'];
                                            }
                                            ?>

                                            // Create a JavaScript array with your PHP data
                                            var ratings = <?php echo json_encode($ratings); ?>;
                                            var counts = <?php echo json_encode($counts); ?>;

                                            var ctx = document.getElementById('pieChart2').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'pie',
                                                data: {
                                                    labels: ratings,
                                                    datasets: [{
                                                        data: counts,
                                                        backgroundColor: [
                                                            'rgba(255, 199, 132, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)',
                                                            'rgba(255, 205, 86, 0.6)',
                                                            'rgba(75, 192, 192, 0.6)',
                                                            'rgba(153, 102, 255, 0.6)',
                                                        ],
                                                    }]
                                                },

                                                options: {
                                                    plugins: {
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(context) {
                                                                    var label = context.label + 'rating'|| '';
                                                                    var value = context.parsed || 0;
                                                                    var total = context.dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                                                        return previousValue + currentValue;
                                                                    });
                                                                    var percentage = (value / total * 100).toFixed(2) + '%';
                                                                    return percentage + " (" + value + " of " + total + " Feedbacks)";
                                                                    
                                                                }

                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                            
                                        </script>

                                        <h5 style="text-align: center; font-size: 18px; margin-top: 20px; color: rgb(128, 128, 128);"
                                        >Products Percentage</h5>

                                    </div> -->

                                    <hr>



                                </div>

                            </div>

                        </div>
                    </div>  <!-- END ROW 3 - ADMIN DASHBOARD - PIE CHART -->











                    













                    <!-- </div> BODY END -->
                </div>
            </div>

        </div>
    </div>
    <!-- END ADMIN DASHBOARD -- FOR VIEWING ADMIN DASHBOARD -->




    

</body>
</html>



<script>
    function to_adminacc() {
        window.location.href = 'admin_account.php';
    }
</script>








































