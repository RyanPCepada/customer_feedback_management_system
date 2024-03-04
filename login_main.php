<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="assets/css/boxicons.min.css">
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>DevBugs - Login</title>
</head>
<body>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>
    
    <link rel="stylesheet" href="pages/login/style_L.css">

    <div class="background"></div>
    
    <div class="body">
        <img src="pages/login/LOGIN_PAD.png" style="position: absolute; width: 437px; margin-top: 0px; margin-left: 0px;
            filter: drop-shadow(10px 10px 5px rgba(0, 0, 0, 0.2)); z-index: 1;" alt="">
        
        <!-- <a id="back" href="http://localhost/DevBugs/landing_main.php">Back</a> -->

        <div class="container">
            <label class="login">Login</label>
            <div class="login-container">
                <!-- <form action="pages/home/home_main.php" method="POST" id="login_form"> -->
                <form action="DevBugs/home_main.php" method="POST" id="login_form">
                    <div class="entryarea">
                        <input type="text" placeholder="Email" id="email" class="form-control" name="email" style="position: absolute; width: 330px; margin-top: -55px; font-size: 25px;" required>
                        <i class='bx bxs-user' style="margin-top: -53px;"></i>
                    </div>
                    <div class="entryarea">
                        <input type="password" placeholder="Password" id="password" class="form-control" name="password" style="position: absolute; width: 290px; margin-top: -43px; font-size: 25px;" required>
                        <i class='bx bxs-lock-alt' id="lockIcon" style="margin-top: -41px;"></i>
                        <!-- Show Password Icon -->
                        <i class='bx bx-hide show-password' style="position: absolute; margin-right: 0px; margin-top: -41px; color: white;" onclick="togglePasswordVisibility()"></i>
                    </div>
                    <div class="remember-forgot">
                        <input type="checkbox" id="checkbox" style="position: absolute; color: rgb(199, 198, 228); margin-top: -30px;">
                        <span id="rm" style="position: absolute; color: rgb(199, 198, 228); margin-top: -36px; margin-left: 13px; width: 100px;">Remember me</span>
                        <a onclick="to_forgotpassword_main()" style="position: absolute; color: rgb(199, 198, 228); margin-top: -36px; margin-left: 200px; width: 150px;">Forgot password?</a>
                    </div>
                    <button type="submit" id="login_customer">Login</button>

                    <script>
                    // Initially hide the show-password icon
                    document.querySelector(".show-password").style.display = "none";

                    function togglePasswordVisibility() {
                        var passwordInput = document.getElementById("password");
                        var passwordIcon = document.querySelector(".show-password");
                        var lockIcon = document.getElementById("lockIcon");

                        if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        passwordIcon.classList.remove("bx-hide");
                        passwordIcon.classList.add("bx-show");
                        lockIcon.style.display = "none";
                        } else {
                        passwordInput.type = "password";
                        passwordIcon.classList.remove("bx-show");
                        passwordIcon.classList.add("bx-hide");

                        // Show the lock icon only when the password field is empty
                        if (passwordInput.value.trim() === "") {
                            lockIcon.style.display = "block";
                        }
                        }
                    }

                    // Check if the password field is not empty on input change
                    document.getElementById("password").addEventListener("input", function () {
                        var passwordIcon = document.querySelector(".show-password");
                        var lockIcon = document.getElementById("lockIcon");

                        if (this.value.trim() !== "") {
                        passwordIcon.style.display = "block";
                        lockIcon.style.display = "none";
                        } else {
                        passwordIcon.style.display = "none";

                        // Show the lock icon only when the password field is empty
                        lockIcon.style.display = "block";
                        }
                    });
                    </script>
                </form>


                
                <div class="register-link">
                    
                    <p style="position: absolute; color: rgb(199, 198, 228); margin-top: 90px; margin-left: 53px; width: 150px;">Don't have an account?</p>

                    </html><!-- Button trigger modal -->

                    <a id="create_account" data-bs-toggle="modal" data-bs-target="#modal_registration"
                    style="position: absolute; color: rgb(199, 198, 228); margin-top: 90px; margin-left: -2px; width: 150px; background: transparent;">
                    Create one</a>

                </div>
                <!-- <div id="contents"></div> THE REASON WHY LOGIN APPEARS ON LANDING OR LOGIN IS BROKEN-->
            </div>
        </div>
    </div>

    

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


    
    <script>
        
        function checkPassword(event) {

            let password = document.getElementById("row3").value;
            let cnfrmPassword = document.getElementById("row4").value;
            console.log(password, cnfrmPassword);
            let message = document.getElementById("message");

            if (password.length !== 0) {
                if (password === cnfrmPassword) {
                    // message.textContent = "Passwords match";
                    // alert("Passwords match");

                    // If passwords match, you can manually submit the form here:
                     document.getElementById("registration_form").submit();

                     
                } else {
                    event.preventDefault(); // Prevent the form from submitting
                    // message.textContent = "Passwords don't match";
                    alert("Passwords don't match");
                }
            } else {
                event.preventDefault(); // Prevent the form from submitting
                alert("Password can't be empty!");
                message.textContent = "";
            }
        }

    </script>






    <script>
        $('#login_form').submit(function(e){
            e.preventDefault();
            $.post("actions/loginAction.php", {
                email: $('#email').val(),
                password: $('#password').val()
            },
            function(data){
                try {
                    var response = JSON.parse(data);
                    if(response.status === "success"){
                        if(response.role === "admin"){
                            alert("Logged in Successfully as Admin!");
                            setTimeout(function() {
                                window.location.href = 'admin_main.php';
                            }, 500); // Delay the redirect by 500 milliseconds
                        } else if(response.role === "customer"){
                            alert("Logged in Successfully as Customer!");
                            setTimeout(function() {
                                window.location.href = 'home_main.php';
                            }, 500); // Delay the redirect by 500 milliseconds
                        }
                    } else {
                        alert("Login failed: " + response.message);
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                }
            }).fail(function(xhr, status, error) {
                console.error("AJAX Request Failed:", status, error);
            });
        });
    </script>





<!-- MODAL FADEIN -->
<script>
document.getElementById('openModalBtn').addEventListener('click', function() {
    document.getElementById('registrationModal').style.display = 'block';

    // Add a class to trigger the fade-in effect
    document.getElementById('registrationModal').classList.add('fade-in');
});

document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('registrationModal').style.display = 'none';

    // Remove the fade-in class to reset the effect
    document.getElementById('registrationModal').classList.remove('fade-in');
});
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
        function to_regis() {
            window.location.href = '/DevBugs/registration_main.php';
        }
    </script>
    <script>
        function to_home() {
            $.post("home_main.php", {}, function (data) {
                $("#contents").html(data);  
            });
        }
    </script>
    <script>
        function to_forgotpassword_main() {
            window.location.href = '/DevBugs/forgot_password_main.php';
        }
    </script>
</body>
</html>
