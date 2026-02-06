<?php
require('connection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function sendMail($email,$reset_token){
    require('PHPMailer/PHPMailer.php');
    require('PHPMailer/SMTP.php');
    require('PHPMailer/Exception.php');
    $mail = new PHPMailer(true);
    try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'faisalaxon@gmail.com';                     //SMTP username
    $mail->Password   = 'wpqnukdzxybmrovo';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;  
    //Recipients
    $mail->setFrom('faisalaxon@gmail.com', 'Tech World');
    $mail->addAddress($email);     //Add a recipient
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password Reset Link from Tech World';
    $mail->Body    = " We got a request to Reset your password <br>
                    Click the Link below : <br>
                    <a href='http://authenticationsystem.test/updatepassword.php?email=$email&reset_token=$reset_token'>Reset Password</a>";

    $mail->send();
    return true;    
    } 
    catch (Exception $e) {
    return false;
}             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
}
if(isset($_POST['send-reset-link'])){
    $query = "SELECT * FROM  registered_users WHERE email = '$_POST[email]'";
    $result = mysqli_query($conn, $query);
    if($result){
        if(mysqli_num_rows($result)==1){
            // email found
            $reset_token = bin2hex(random_bytes(16));  
            date_default_timezone_set('Asia/Karachi');
            $date = date('Y-m-d');    
            $query = "UPDATE registered_users SET resettoken = '$reset_token', resettokenexpire = '$date' WHERE email = '$_POST[email]'";   
            if(mysqli_query($conn,$query) && sendMail($_POST['email'],$reset_token)){
                echo "<script> alert('Password reset link sent to your email');
                window.location.href = 'index.php';
            </script>";
            }
            else{
                echo "<script> alert('Server Down,try again later!');
                window.location.href = 'index.php';
            </script>";
            }
        }
        else{
            // email not found
            echo "<script> alert('Email not found');
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
?>