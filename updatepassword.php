<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Update</title>
</head>
<body>
   <?php
   require('connection.php');
   if(isset($_GET['email']) && isset($_GET['reset_token'])){
    date_default_timezone_set('Asia/Karachi');
    $date = date('Y-m-d');
    $query = "SELECT * FROM registered_users WHERE email = '$_GET[email]' AND resettoken = '$_GET[reset_token]' AND resettokenexpire = '$date'";
    $result = mysqli_query($conn,$query);
    if($result){
        if(mysqli_num_rows($result)==1){
            // user email found
            echo "
                <form method='POST' style='margin-top:100px; margin-left:40%;'>
                <h3>Create New Password</h3>
                <input type='password' name='password' placeholder='New Password' placeholder='Password'>
                <button type='submit' name='updatepassword'>Update Password</button>
                <input type='hidden' name='email' value = '$_GET[email]'>
                </form>
        ";
        }
        else{
            // user email not found
            echo "<script> alert('Invalid or Expired Link');
            window.location.href = 'index.php';
        </script>";
        }
    }
    else{
        echo "<script> alert('Email not found');
            window.location.href = 'index.php';
        </script>";
    }


   }
   ?> 
   <?php 
    if(isset($_POST['updatepassword'])){
        $hased_password = password_hash($_POST['password'],PASSWORD_BCRYPT);
        $query = "UPDATE registered_users SET password = '$hased_password', resettoken = NULL, resettokenexpire = NULL WHERE email = '$_POST[email]'";
        if(mysqli_query($conn,$query)){
            echo "<script> alert('Password Updated Successfully!');
            window.location.href = 'index.php';
        </script>";
        }
        else{
            echo "<script> alert('Server Down,try again later!');
            window.location.href = 'index.php';
        </script>";
        }
    }
   ?>
</body>
</html>