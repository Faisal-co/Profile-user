<?php
require('connection.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email,$verf_code){
    require ("PhpMailer/PHPMailer.php");
    require ("PhpMailer/SMTP.php");
    require ("PhpMailer/Exception.php");
    $mail = new PHPMailer(true);
    try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'faisalaxon@gmail.com';                     //SMTP username
    $mail->Password   = 'wpqnukdzxybmrovo';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('faisalaxon@gmail.com', 'Tech World');
    $mail->addAddress($email);     //Add a recipient
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email Verification from Tech World';
    $mail->Body    = "Thanks for registration!
                    Click the Link below to verify the email address
                    <a href='http://authenticationsystem.test/verify.php?email=$email&varification_code=$verf_code'>Verify Email</a>";

    $mail->send();
    return true;
    } 
    catch (Exception $e) {
    return false;
}
}
// for Login
if(isset($_POST['login'])){
    $query="SELECT * FROM registered_users WHERE email = '$_POST[email_username]' OR username = '$_POST[email_username]'";
    $result = mysqli_query($conn,$query);
    if($result){
        if(mysqli_num_rows($result)==1){
            $result_fetch = mysqli_fetch_assoc($result);
            if($result_fetch['is_verified']==1){
                if(password_verify($_POST['password'],$result_fetch['password'])){
                $_SESSION['looged_in'] = true; // create Session variable with key looged_in
                $_SESSION['username'] = $result_fetch['username']; // create Session variable with key username
                if(isset($_POST['remember_me'])){
                    // To Store Email and Password in Cookies
                    setcookie('email_username',$_POST['email_username'],time() + (60*60*24));
                    setcookie('password',$_POST['password'],time() + (60*60*24));
                }
                else{
                    setcookie('email_username','',time() - (60*60*24));
                    setcookie('password','',time() - (60*60*24));
                }
                header('location: index.php');
            }
            else{
                echo "<script> alert('Incorrect Password');
                window.location.href = 'index.php';
            </script>";
            }
            }
        else{
            echo "<script> alert('Email not verified first verify via email');
        window.location.href = 'index.php';
    </script>";
        }
            
        }
        else{
            echo "<script> alert('Email or Username not Registered');
        window.location.href = 'index.php';
    </script>";
        }
    }
    else{
        echo "<script> alert('Cannot run query');
        window.location.href = 'index.php';
    </script>";

    }
}

// for registration
if(isset($_POST['register'])){
    $user_exist_query="SELECT * FROM registered_users WHERE username = '$_POST[username]' OR email = '$_POST[email]'";
    $result = mysqli_query($conn,$user_exist_query);

if($result){
    if(mysqli_num_rows($result)>0){//if username or email already exist
        $result_fetch = mysqli_fetch_assoc($result);
        if($result_fetch['username']==$_POST['username']){
            echo "<script> alert('$result_fetch[username], username Already Exist');
        window.location.href = 'index.php';
    </script>";
        }
        else{
            echo "<script> alert('$result_fetch[email], email Already Exist');
        window.location.href = 'index.php';
    </script>";
        }
    }
    else{
        $hashed_password = password_hash($_POST['password'],PASSWORD_BCRYPT);
        $verification_code = bin2hex(random_bytes(16));        
        $query = "INSERT INTO registered_users (full_name, username, email, password, varification_code, is_verified) VALUES('$_POST[fullname]','$_POST[username]','$_POST[email]','$hashed_password','$verification_code',0)";
        if(mysqli_query($conn,$query) && sendMail($_POST['email'],$verification_code)){// if username and password unique ok inserted
            echo "<script> alert('Successfully Registered');
        window.location.href = 'index.php';
    </script>"; 
        }
        else{
          echo "<script> alert('Cannot Connect run query');
        window.location.href = 'index.php';
    </script>";  
        }
    }

}

else{
    echo "<script> alert('Cannot Connect to database');
        window.location.href = 'index.php';
    </script>";

    die();

}
}
?>