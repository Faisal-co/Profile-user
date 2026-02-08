<?php
include 'connection.php';
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
        $id = $_SESSION['user_id'];

        $sql = "SELECT * FROM profil WHERE id='$id'";
        $result = mysqli_query($conn,$sql);
        $user = mysqli_fetch_assoc($result);
        echo "Hi, ".$user['username']; ?>
    </title>
</head>
<body style="background-color: green;">
<?php
    if(!isset($_SESSION['user_id'])){
    header("Location: login-userprofile.php");
}
$id = $_SESSION['user_id'];

$sql = "SELECT * FROM profil WHERE id='$id'";
$result = mysqli_query($conn,$sql);
$user = mysqli_fetch_assoc($result);
?>
<div style="margin-left: 500px; margin-top: 100px;"> <img src="uploads/<?php echo $user['imag']; ?>" width="120"><br><br> </div>
<h1 style="margin-left: 500px; color: white;"> <?php echo "Hi, ".$user['username']; ?> </h1>
<h1 style = "margin-left: 460px; color: white;"> <?php echo $user['email']; ?> </h1>
</body>
</html>



