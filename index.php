<?php require('connection.php');
session_start();
// Getting Cooking values of user emial and password 
if(isset($_COOKIE['email_username']) && isset($_COOKIE['password'])){
    $id = $_COOKIE['email_username'];
    $passwrd = $_COOKIE['password'];
}
else{
    $id = "";
    $passwrd = "";
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Login and Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Tech World</h2>
        <nav>
            <a href="#">Home</a>
            <a href="#">Blog</a>
            <a href="#">Contact</a>
            <a href="#">About</a>
        </nav> 
        <?php
         if(isset($_SESSION['looged_in']) && $_SESSION['looged_in'] == true){
            echo "<div class='userlogin'>
            $_SESSION[username] - <a href = 'logout.php'>Logout</a>
        </div>";
         }
         else{
            echo "<div class='signin-register'>
        <button type='button' onclick = \"popup('login-popup')\">Login</button> 
        <button type='button' onclick = \"popup('register-popup')\">Register</button> 
    </div>";
         }
        ?>
      
    </header>
    <?php 
    ?>
    <!-- Login Popup -->
    <div class="popup-container" id = login-popup>
        <div class="popup">
            <form action="login_register_fetch.php" method="POST">
                <h2>
                <span>User Login</span>
                <button class= "close-btn" type= "reset" onclick="popup('login-popup')">X</button>
            </h2>
            <input type="text" placeholder="Email or Username" name="email_username" value = "<?php echo $id ?>">
            <input type="password" placeholder="Password" name="password" value = "<?php echo $passwrd ?>">
            <label for="">
                <input type="checkbox" name="remember_me"> Remember Me
            </label>
            <button class="login-btn" type="submit" name="login">Login</button>    
        </form>
        <!-- Button Forgot password -->
        <div class="forgot-btn">
            <button type="button" onclick="forgotPopup()">Forgot Password ?</button>
        </div>

        </div>
    </div>
    <!-- Register Popup -->
    <div class="popup-container" id = register-popup>
        <div class="register popup">
            <form action="login_register_fetch.php" method="POST">
                <h2>
                <span>User Register</span>
                <button class= "close-btn" type= "reset" onclick="popup('register-popup')">X</button>
            </h2>
            <input type="text" placeholder="Full Name" name="fullname">
            <input type="text" placeholder="Username" name="username">
            <input type="email" placeholder="E-mail" name="email">
            <input type="password" placeholder="Password" name="password">
            <button class="register-btn" type="submit" name="register">Register</button>    
        </form>
        </div>
    </div>
    <!-- Forgot password Popup -->
    <div class="popup-container" id = forgot-popup>
        <div class="forgot popup">
            <form action="forgotpassword.php" method="POST">
                <h2>
                <span>Reset Password</span>
                <button class= "close-btn" type= "reset" onclick="popup('forgot-popup')">X</button>
            </h2>
            <input type="text" placeholder="Email" name="email">
            <button class="reset-btn" type="submit" name="send-reset-link">SEND Link</button>    
        </form>
        
    </div>
    <?php
    if(isset($_SESSION['looged_in']) && $_SESSION['looged_in'] == true){
        echo "<h1 style = 'text-align: center; margin-top: 200px;'>Welcome to this website - $_SESSION[username]</h1>";
    }
    ?>
    <script>
        function popup(popup_name){
            get_popup = document.getElementById(popup_name);
            if(get_popup.style.display == "flex"){
                get_popup.style.display = "none";
            }
            else{
                get_popup.style.display = "flex";
            }
        }
        function forgotPopup(){ // onclick event applied on both popup containers login popup and forgot popup
            document.getElementById('login-popup').style.display = "none";
            document.getElementById('forgot-popup').style.display = "flex";
        }
    </script>
</body>
</html>