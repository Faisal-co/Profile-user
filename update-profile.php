<?php
session_start();
include 'connection.php';
if(isset($_POST['update'])){
    $id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    // image upload
    if($_FILES['image']['name'] != ""){
        $img_name = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $folder = "images/".$img_name;
        move_uploaded_file($tmp,$folder);
        $update = "UPDATE users SET username='$username', email='$email', image='$img_name' WHERE id='$id'";
    }else{
        $update = "UPDATE users SET username='$username', email='$email' WHERE id='$id'";
    }
    mysqli_query($conn,$update);
    // header("Location: user-profile.php");
}
?>
