<?php
session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$payment_method = $_POST['payment_method'];
$package_id = intval($_POST['package_id']);
$seats = $_POST['seats'];
$amount = floatval($_POST['amount']);

$payment_status = "Paid";
$booking_status = "Confirmed";


$stmt = $conn->prepare("
    INSERT INTO bookings
    (user_id, package_id, seats, amount, payment_status, booking_status)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "iisdss",
    $user_id,
    $package_id,
    $seats,
    $amount,
    $payment_status,
    $booking_status
);

$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Payment Successful</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#eef3f8;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
}


.box{
    background:#fff;
    padding:40px;
    border-radius:16px;
    text-align:center;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
    max-width:420px;
    width:100%;
}


.icon{
    font-size:60px;
    color:#28a745;
    margin-bottom:10px;
}

/* TITLE */
.box h2{
    color:#1e3c72;
    margin-bottom:10px;
}


.box p{
    color:#555;
    margin-bottom:20px;
    font-size:16px;
}


a{
    display:inline-block;
    margin-top:10px;
    padding:12px 20px;
    background:#009688;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
    font-weight:600;
}

a:hover{
    background:#00796b;
}


@media(max-width:480px){
    .box{
        padding:25px;
    }

    .box h2{
        font-size:20px;
    }

    .box p{
        font-size:14px;
    }
}

</style>

</head>

<body>

<div class="box">

    <div class="icon">✔</div>

    <h2>Payment Successful</h2>

    <p>Your booking has been confirmed successfully.</p>

    <a href="my-bookings.php">
        View My Bookings
    </a>

</div>

</body>
</html>