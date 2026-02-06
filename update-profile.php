<?php
include 'connection.php';
session_start();
if(isset($_POST['update'])){
    $id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    // file Upload type will be stored in ['name']
    if($_FILES['image']['name'] != ""){
        $img_name = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        $folder = "uploads/".$img_name;
        move_uploaded_file($tmp,$folder);
        // Save the image in database which is uploaded by user matching id = '$id'.
        $update = "UPDATE profil SET username='$username', email='$email', imag='$img_name' WHERE id='$id'";
    }else{
        $update = "UPDATE profil SET username='$username', email='$email' WHERE id='$id'";
    }
    mysqli_query($conn,$update);
    header("Location: user-profile.php");
}
/* 
When a file is uploaded, PHP automatically creates a special array:
$_FILES['image'] = array(
    'name' => 'photo.png',
    'type' => 'image/png',
    'tmp_name' => 'C:\xampp\tmp\phpA1B.tmp',
    'error' => 0,
    'size' => 24567
);

*/
?>
