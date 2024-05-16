<?php
$hostname = "localhost";
$usersname = "root";
$password = "";
$dbname = "sport";

$conn = mysqli_connect($hostname, $usersname, $password, $dbname);
if(!$conn){
    echo "Database connection error".mysqli_connect_error();
}
?>