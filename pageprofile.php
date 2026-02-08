<?php
include 'connection.php';
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login-userprofile.php");
}
$id = $_SESSION['user_id'];

$sql = "SELECT * FROM profil WHERE id='$id'";
$result = mysqli_query($conn,$sql);
$user = mysqli_fetch_assoc($result);
?>
<img src="uploads/<?php echo $user['imag']; ?>" width="120"><br><br>
<h1> <?php echo "Hi, ".$user['username']; ?> </h1>
<h1> <?php echo $user['email']; ?> </h1>

