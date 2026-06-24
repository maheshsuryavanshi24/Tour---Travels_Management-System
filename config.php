<?php


$host = "localhost";
$username = "root";
$password = "";
$database = "tour_travel";


$conn = mysqli_connect($host, $username, $password, $database);


if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}



date_default_timezone_set("Asia/Kolkata");



if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>