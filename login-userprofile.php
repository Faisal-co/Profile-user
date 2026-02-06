<?php
session_start();
include 'connection.php';
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass  = $_POST['password'];
    $sql = "SELECT * FROM profil WHERE email='$email' AND password='$pass'";
    $result = mysqli_query($conn,$sql);
// After clicking login button Verify the user exist in database.
    if(mysqli_num_rows($result) == 1){
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        header("Location: user-profile.php");
    }else{
        echo "Invalid Login";
    }
}
?>
<form method="POST">
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button name="login">Login</button>
</form>
