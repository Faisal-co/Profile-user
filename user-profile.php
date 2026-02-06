<?php
session_start();
include 'connection.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login-userprofile.php");
}
$id = $_SESSION['user_id'];
$sql = "SELECT * FROM profil WHERE id='$id'";
$result = mysqli_query($conn,$sql);
$user = mysqli_fetch_assoc($result);
?>
<h2>User Profile</h2>
<!-- if image exist in database -->
<!-- Displaying user image from database -->
<img src="uploads/<?php echo $user['image']; ?>" width="120"><br><br>
<form action="update_profile.php" method="POST" enctype="multipart/form-data">
    <!-- Displaying user details from database -->
    Name:<br>
    <input type="text" name="username" value="<?php echo $user['username']; ?>"><br><br>
    Email:<br>
    <input type="email" name="email" value="<?php echo $user['email']; ?>"><br><br>
    Update Image:<br>
    <input type="file" name="image"><br><br>
    <button name="update">Update Profile</button>
</form>
<br>
<a href="logout.php">Logout</a>
