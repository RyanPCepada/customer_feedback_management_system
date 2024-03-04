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

        
        <link rel="stylesheet" href="pages/landing/style_land.css">

        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <div class="container-fluid">
                <div class="m-1" style="width: 5%">
                <img src="pages/landing/octawiz-devbugs.png" class="img-fluid" style="width: 2in;" alt="">
                </div>
                <h1 class=" navbar-brand" style="font-size: 40px; color: lightblue; margin-left: 15px;"
                >Octawiz-Devbugs</h1>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                </div>

                <button class="btn btn-dark" type="button" id="get_started" data-bs-toggle="modal" data-bs-target="#modal_registration"
                style="margin-top: 0px;">
                    GET STARTED
                </button>

                <button class="btn btn-dark" type="button" id="log_in" onclick="window.location.href='login_main.php'" style="margin-top: 0px;">
                    LOG IN
                </button>


            </div>
        </nav>


        <!-- CUSTOMER REGISTRATION MODAL -->
        <div class="modal fade" id="modal_registration" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: lightgray;">Customer Registration</h5>
                        <img src="pages/landing/GIF_REGISTER.gif" style="width: 1.6in; height: .9in; margin-right: -10px;" id="register_gif">
                    </div>
                    <div class="modal-body">

                        <form id="registration_form" method="POST" action="actions/insert_new_account.php">
                            <div class="input" id="inputfields">
                                <input type="text" placeholder="Firstname" class="firstname" name="firstname" id="row1"/>
                                <input type="text" placeholder="Lastname" class="lastname" name="lastname" id="row1" />
                                <input type="text" placeholder="Email" class="email" name="email" id="row2" /> 
                                <input type="text" placeholder="Password" class="password" name="password" id="row3"/> 
                                <input type="text" placeholder="Confirm Password" class="confirmpassword" name="confirmpassword" id="row4" /> 
                                <!-- <p id="message" style="background: white;"></p> -->
                            </div>
                            <hr>
                            <div class="boxandlink">
                                <input type="checkbox" id="privacy-checkbox" name="privacy-checkbox" required>
                                <label for="privacy-checkbox" id="privacy-link" style="color: #f5f5f5;">I already read and understand the <a href="privacy_details_main.php"
                                style="color: white;"><b>privacy details</b></a>.</label>
                            </div>
                            <!-- <button type="submit" class="submit" name="submit" id="modalsubmit">Create account</button> ORIGINAL-->
                            
                            <!-- <button type="button" onclick="checkPassword()">SUBMIT</button> NEW-->
                            
                            <button type="submit" class="btn bg-primary" name="submit" id="modalsubmit" onclick="checkPassword(event)">Create</button>
                            <button type="button" class="btn btn-secondary" id="closeModalBtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button id="closeModalBtn" data-bs-dismiss="modal">Back</button> -->
                            
                        </form>
                        
                            
                
                    </div>
                
                </div>
            </div>
        </div>

        <!-- END CUSTOMER REGISTRATION MODAL -->
            

            
        <!-- LOGINAS MODAL -- FOR CHOOSING ADMIN OR CUSTOMER -->
        <div class="modal fade custom-fade" id="modal_loginas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color: rgba(0, 0, 0, 0.5); border-radius: 15px; height: 420px;"> <!-- Transparent background -->

                    <div class="header" style="text-align: center;"> <!--DON'T USE MODAL-HEADER, HEADER ONLY-->
                        <div class="row">
                            <h1 class="modal-title" id="staticBackdropLabel" style="color: white; margin-top: 25px;">Login as:</h1>
                        </div>
                    </div>

                    <div class="modal-body" style="background-color: rgba(0, 0, 0, 0.5); border-radius: 50px;"> <!-- Semi-transparent white background -->
                        
                        <div class="card-body">

                            <div class="d-flex justify-content-center">
                                    
                            <div class="row">
                                <div class="col-5">
                                    <div class="card-body text-center" id="admin_card">
                                        <img src="pages/landing/ICON_ADMIN.png" style="height: 120px; width: 120px; margin-bottom: 10px;">
                                        <a class="admin-link" id="admin">Admin</a>
                                    </div>
                                </div>
                                <div class="col-2">
                                </div>
                                <div class="col-5">
                                    <div class="card-body text-center" id="customer_card">
                                        <img src="pages/landing/ICON_CUSTOMER.png" style="height: 120px; width: 120px; margin-bottom: 10px;">
                                        <a class="customer-link" id="customer">Customer</a>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.getElementById("admin_card").addEventListener("click", function() {
                                // Handle the click event, e.g., navigate to the desired URL
                                window.location.href = "http://localhost/DevBugs/admin_login.php";
                                });

                                document.getElementById("customer_card").addEventListener("click", function() {
                                    // Handle the click event, e.g., navigate to the desired URL
                                    window.location.href = "http://localhost/DevBugs/login_main.php";
                                });
                            </script>


                            </div>

                        </div>

                        <button type="button" class="btn btn-secondary float-end" id="landing_modal_X"
                        data-bs-dismiss="modal">X</button>
                                
                    </div>
                
                </div>
            </div>
        </div>
        <!-- END LOGINAS MODAL -- FOR CHOOSING ADMIN OR CUSTOMER -->

        


        <div class="background">
            <!-- <div class="row" style="position: absolute; width: 420px; height: 530px; margin-left: 120px; margin-top: 60px; border-radius: 30px; background: rgba(255, 255, 255, 0.1);">
            </div> -->
            <div class="card" id="card3" style="position: absolute; width: 7in; height: 1in;">
                    <div class="card-body bg-#00bd35 fold" style="position: absolute; width: 7in; height: 1in; margin-left: -170px; margin-top: 230px;">
                        <img src="pages/landing/img_landing_crop.png" class="img-fluid" style="filter: drop-shadow(10px 10px 7px rgba(20, 20, 20, 20));">
                    </div>
                </div>

            <!-- <img src="pages/landing/IMG_LANDING.png" style="position: absolute; width: 3in; margin-left: 950px; margin-top: 190px; transform: rotate(-15deg);" id="bubble_blue"> -->

            <img src="pages/landing/ICON_GIRL.png" style="position: absolute; width: 3in; margin-left: 1050px; margin-top: 70px; transform: rotate(-15deg);" id="bubble_blue">
            
            <img src="pages/landing/ICON_LANDING_STYLE.png" style="position: absolute; width: 100%; margin-left: 0px; margin-right: 0px; margin-top: 30px;
                transform: rotate(0deg); filter: drop-shadow(0px 20px 50px rgba(20, 20, 20, 20)); opacity: 100%;" id="bubble_blue">

            <img src="pages/landing/ICON_GIRL_LARGE.png" style="position: absolute; width: 6.9in; margin-left: 850px; margin-top: 25px; filter: drop-shadow(15px 15px 15px rgba(20, 20, 20, 20)); transform: rotate(0deg);" id="bubble_blue">
            <!-- <img src="pages/landing/ICON_GIRL2_LARGE.png" style="position: absolute; width: 3in; margin-left: 0px; margin-top: 225px; filter: drop-shadow(15px 15px 15px rgba(20, 20, 20, 20)); transform: rotate(0deg);" id="bubble_blue"> -->


             <!--<h1 style="position: absolute; color: lightblue; width: 200px; margin-left: 115px; margin-top: 80px; font-size: 20px; font-family: 'Ink Free', sans-serif; filter: drop-shadow(2px 2px 3px rgba(20, 20, 20, 20));"
            >Welcome to</h1> filter: drop-shadow(3px 3px 3px rgba(20, 20, 20, 20));-->
            <h1 style="position: absolute; color: white; width: 1000px; margin-left: 35px; margin-top: 25px; font-size: 100px; font-family: 'Berlin Sans FB'; filter: drop-shadow(5px 5px 5px rgba(20, 20, 20, 20));"
            >Customer Feedback</h1> <!-- filter: drop-shadow(5px 5px 5px rgba(20, 20, 20, 20));-->
            <h1 style="position: absolute; color: yellow; width: 1000px; margin-left: 145px; margin-top: 110px; font-size: 70px; font-family: 'Berlin Sans FB', sans-serif; filter: drop-shadow(5px 5px 5px rgba(20, 20, 20, 20));"
            >Management System</h1> <!-- filter: drop-shadow(5px 5px 5px rgba(20, 20, 20, 20));-->

            <p id="card2" style="position: absolute; color: white; width: 800px; margin-left: 157px; margin-top: 190px; font-size: 20px; font-family: 'Ink Free', sans-serif; filter: drop-shadow(3px 3px 3px rgba(20, 20, 20, 20));"
            >Every thoughts you share is a step towards making our service better.</p>  <!--Your feedback is the key to our success! -->

            <div class="d-flex">
            </div>

            <img src="pages/landing/ICON_BUBBLE_BLUE.png" style="position: absolute; width: 1.6in; height: .9in; margin-left: 700px; margin-right: -10px; margin-top: 240px; transform: rotate(-15deg);" id="bubble_blue">
            <img src="pages/landing/ICON_BUBBLE_RED.png" style="position: absolute; width: 1in; margin-left: 780px; margin-right: -10px; margin-top: 310px; transform: rotate(25deg);" id="bubble_red">
            <!-- <img src="pages/landing/ICON_CITY.png" style="position: absolute; width: 4.4in; margin-left: 114px; margin-right: -10px; margin-top: 395px; transform: rotate(0deg); color: rgba(255, 255, 255, 0.1);" id="bubble_blue">
            <img src="pages/landing/ICON_COMMUNITY.png" style="position: absolute; width: 2.4in; margin-left: 215px; margin-right: -10px; margin-top: 450px; transform: rotate(0deg);" id="bubble_blue"> -->

                


            <!-- <p3 id="card4" style="position: absolute; color: white; width: 500px; margin-left: 59%; margin-top: 280px; font-size: 100px; font-family: 'Ink Free', sans-serif; transform: scaleX(1.0); transform: rotate(-15deg);">
                <strong>Your Voice,</strong>
            </p3><!-- filter: drop-shadow(5px 5px 5px rgba(20, 20, 20, 20));--
            <p3 id="card4" style="position: absolute; color: white; width: 650px; margin-left: 55%; margin-top: 370px; font-size: 100px; font-family: 'Ink Free', sans-serif; transform: scaleX(1.0); transform: rotate(-15deg);">
                <strong>Our Excellence!</strong>
            </p3>filter: drop-shadow(5px 5px 5px rgba(20, 20, 20, 20)); -->
            
            <!-- <hr style="width: 1300px; margin-left: -100px;"> -->
        </div>


        <footer class="bg-transparent text-light text-center p-3" style="height: 10px; margin-top: -55px;">
            <p>&copy; 2023 Octawiz-DevBugs. All rights reserved.</p>
        </footer>

        <!-- <footer class="bg-dark text-light text-center p-3" style="margin-top: -40px;">
            <p>&copy; 2023 Octawiz-DevBugs. All rights reserved.</p>
        </footer> -->

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




