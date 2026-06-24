<?php
session_start();
include 'db.php';


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);

// VALIDATE INPUT
if(!isset($_POST['seat_number'], $_POST['package_id'])){
    die("Invalid Request");
}

$seat_number = $_POST['seat_number'];
$package_id = intval($_POST['package_id']);


$update = "UPDATE seats 
           SET status='Booked' 
           WHERE seat_number='$seat_number' 
           AND package_id='$package_id'";

mysqli_query($conn, $update);


$insert = "INSERT INTO bookings
(user_id, package_id, seat_number)
VALUES
('$user_id','$package_id','$seat_number')";

mysqli_query($conn, $insert);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Booking Status</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    padding:20px;
}

.box{
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    text-align:center;
    max-width:420px;
    width:100%;
}


.box h2{
    color:#1e3c72;
    margin-bottom:15px;
}


.success{
    color:#28a745;
    font-size:18px;
    font-weight:bold;
    margin-bottom:20px;
}


.details{
    background:#f1f1f1;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
    font-size:15px;
}


.btn{
    display:inline-block;
    background:#1e3c72;
    color:#fff;
    padding:12px 18px;
    border-radius:8px;
    text-decoration:none;
    transition:0.3s;
}

.btn:hover{
    background:#16325c;
}


@media(max-width:480px){

    .box{
        padding:20px;
    }

    .box h2{
        font-size:20px;
    }

    .success{
        font-size:16px;
    }

}

</style>
</head>

<body>

<div class="box">

    <h2>Booking Confirmed 🎉</h2>

    <div class="success">
        Seat Booked Successfully!
    </div>

    <div class="details">
        <p><b>Seat:</b> <?php echo $seat_number; ?></p>
        <p><b>Package ID:</b> <?php echo $package_id; ?></p>
    </div>

    <a href="my-bookings.php" class="btn">
        View My Bookings
    </a>

</div>

</body>
</html>