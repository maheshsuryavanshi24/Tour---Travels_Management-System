<?php

require_once 'config.php';

// CHECK BOOKING ID
if(!isset($_GET['id'])){
    die("Booking ID Missing");
}

$booking_id = intval($_GET['id']);

// FETCH BOOKING DETAILS
$query = mysqli_query($conn,"
SELECT 
bus_bookings.*, 
buses.bus_name
FROM bus_bookings
JOIN buses 
ON bus_bookings.bus_id = buses.id
WHERE bus_bookings.id='$booking_id'
");

if(mysqli_num_rows($query) == 0){
    die("Booking Not Found");
}

$booking = mysqli_fetch_assoc($query);

// PAYMENT SUCCESS
if(isset($_POST['pay_now'])){

    $payment_method = $_POST['payment_method'];

    // UPDATE PAYMENT STATUS
    mysqli_query($conn,"
    UPDATE bus_bookings
    SET payment_status='Paid'
    WHERE id='$booking_id'
    ");

    // INSERT PAYMENT RECORD
    mysqli_query($conn,"
    INSERT INTO payments
    (
        booking_id,
        user_id,
        payment_method,
        amount,
        payment_status
    )
    VALUES
    (
        '".$booking['id']."',
        '".$booking['user_id']."',
        '$payment_method',
        '".$booking['total_amount']."',
        'Paid'
    )
    ");

    echo "<script>
    alert('Payment Successful');
    window.location='ticketu.php?id=$booking_id';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Payment Page</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#eef3f8;
    padding:20px;
}

/* PAYMENT BOX */

.payment-box{
    max-width:550px;
    margin:40px auto;
    background:#fff;
    padding:30px;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
    position:relative;
    overflow:hidden;
}

.payment-box::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:5px;
    background:linear-gradient(90deg,#1e3c72,#2a5298);
}

/* TITLE */

.payment-box h2{
    text-align:center;
    color:#1e3c72;
    margin-bottom:25px;
    font-size:30px;
}

/* DETAILS */

.detail{
    background:#f7f9fc;
    padding:14px;
    border-radius:10px;
    margin-bottom:14px;
    color:#333;
    font-size:16px;
}

.detail i{
    color:#1e3c72;
    margin-right:8px;
}

/* AMOUNT */

.amount{
    text-align:center;
    margin:25px 0;
    font-size:34px;
    font-weight:bold;
    color:#28a745;
}

/* PAYMENT METHOD */

.payment-method h3{
    margin-bottom:15px;
    color:#1e3c72;
}

.payment-method label{
    display:flex;
    align-items:center;
    gap:12px;
    background:#f1f1f1;
    padding:14px;
    border-radius:10px;
    margin-bottom:12px;
    cursor:pointer;
    transition:0.3s;
}

.payment-method label:hover{
    background:#dff3f1;
}

.payment-method input{
    transform:scale(1.2);
}

/* BUTTON */

.pay-btn{
    width:100%;
    margin-top:20px;
    padding:15px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#1e3c72,#2a5298);
    color:#fff;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.pay-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(30,60,114,0.25);
}

/* RESPONSIVE */

@media(max-width:768px){

    .payment-box{
        padding:22px;
    }

    .payment-box h2{
        font-size:26px;
    }

    .amount{
        font-size:28px;
    }
}

@media(max-width:480px){

    body{
        padding:10px;
    }

    .payment-box{
        padding:18px;
    }

    .payment-box h2{
        font-size:22px;
    }

    .detail{
        font-size:14px;
    }

    .pay-btn{
        font-size:16px;
        padding:13px;
    }
}

</style>

</head>

<body>

<div class="payment-box">

    <h2>
        <i class="fa-solid fa-credit-card"></i>
        Bus Payment
    </h2>

    <div class="detail">
        <i class="fa-solid fa-bus"></i>
        <b>Bus:</b>
        <?php echo htmlspecialchars($booking['bus_name']); ?>
    </div>

    <div class="detail">
        <i class="fa-solid fa-calendar-days"></i>
        <b>Journey Date:</b>
        <?php echo htmlspecialchars($booking['journey_date']); ?>
    </div>

    <div class="detail">
        <i class="fa-solid fa-chair"></i>
        <b>Seats:</b>
        <?php echo htmlspecialchars($booking['seats']); ?>
    </div>

    <div class="amount">

        ₹<?php echo number_format($booking['total_amount']); ?>

    </div>

    <form method="POST">

        <div class="payment-method">

            <h3>Select Payment Method</h3>

            <label>
                <input type="radio"
                name="payment_method"
                value="UPI"
                required>

                <i class="fa-brands fa-google-pay"></i>

                UPI / Google Pay / PhonePe
            </label>

            <label>
                <input type="radio"
                name="payment_method"
                value="Card">

                <i class="fa-solid fa-credit-card"></i>

                Debit / Credit Card
            </label>

            <label>
                <input type="radio"
                name="payment_method"
                value="Net Banking">

                <i class="fa-solid fa-building-columns"></i>

                Net Banking
            </label>

            

        </div>

        <button type="submit"
        name="pay_now"
        class="pay-btn">

            Pay Now

        </button>

    </form>

</div>

</body>
</html>