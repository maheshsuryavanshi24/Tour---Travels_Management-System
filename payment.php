<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(
    !isset($_POST['package_id']) ||
    !isset($_POST['price']) ||
    !isset($_POST['seats'])
){
    die("Invalid Access!");
}

$package_id = intval($_POST['package_id']);
$price = floatval($_POST['price']);
$seats = $_POST['seats'];

$total_seats = count($seats);
$total_amount = $price * $total_seats;
$seat_list = implode(", ", $seats);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Payment Page</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#eef3f8;
    padding:20px;
}


.payment-box{
    max-width:500px;
    margin:40px auto;
    background:#fff;
    padding:30px;
    border-radius:14px;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
}


.payment-box h2{
    text-align:center;
    color:#1e3c72;
    margin-bottom:20px;
}

.summary{
    background:#f7f9fc;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

.summary p{
    font-size:16px;
    margin:8px 0;
    color:#333;
}


.methods{
    margin-top:15px;
}

.methods h3{
    margin-bottom:10px;
    color:#1e3c72;
}

.methods label{
    display:flex;
    align-items:center;
    gap:10px;
    background:#f1f1f1;
    padding:12px;
    margin-top:10px;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

.methods label:hover{
    background:#e0f2f1;
}


button{
    margin-top:20px;
    width:100%;
    padding:12px;
    background:#009688;
    color:#fff;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#00796b;
}


@media(max-width:768px){
    body{
        padding:10px;
    }

    .payment-box{
        padding:20px;
    }

    .summary p{
        font-size:15px;
    }
}

@media(max-width:480px){
    .payment-box{
        padding:15px;
    }

    button{
        font-size:15px;
    }
}

</style>

</head>

<body>

<div class="payment-box">

    <h2>Payment Summary</h2>

    <div class="summary">

        <p><b>Selected Seats:</b> <?php echo htmlspecialchars($seat_list); ?></p>

        <p><b>Total Seats:</b> <?php echo $total_seats; ?></p>

        <p><b>Total Amount:</b> ₹<?php echo $total_amount; ?></p>

    </div>

    <form action="payment-success.php" method="POST">

        <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
        <input type="hidden" name="seats" value="<?php echo htmlspecialchars($seat_list); ?>">
        <input type="hidden" name="amount" value="<?php echo $total_amount; ?>">

        <div class="methods">

            <h3>Select Payment Method</h3>

            <label>
                <input type="radio" name="payment_method" value="UPI" required>
                UPI / Google Pay / PhonePe
            </label>

            <label>
                <input type="radio" name="payment_method" value="Card">
                Credit / Debit Card
            </label>

            <label>
                <input type="radio" name="payment_method" value="Net Banking">
                Net Banking
            </label>

            <label>
                <input type="radio" name="payment_method" value="COD">
                Cash On Arrival
            </label>

        </div>

        <button type="submit">
            Pay Now
        </button>

    </form>

</div>

</body>
</html>