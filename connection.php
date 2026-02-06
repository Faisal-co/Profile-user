<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "testing";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_error()) {
    echo "<script> alert('Cannot Connect to database') </script>";
    die();
}


?>