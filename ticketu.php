<?php
require_once 'config.php';

if(!isset($_GET['id'])){
    die("Booking ID Missing");
}

$booking_id = intval($_GET['id']);

$query = mysqli_query($conn,"
SELECT users.id,
users.name, 
bus_bookings.*, 
buses.bus_name,
buses.bus_number,
buses.from_city, 
buses.to_city

FROM bus_bookings
JOIN users
ON bus_bookings.user_id = users.id
JOIN buses 
ON bus_bookings.bus_id = buses.id
WHERE bus_bookings.id='$booking_id'
");

if(!$query || mysqli_num_rows($query) == 0){
    die("Ticket Not Found");
}

$ticket = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>

<title>Bus Ticket</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#eef3f8;
    padding:20px;
}

/* MAIN TICKET BOX */
.ticket{
    max-width:650px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    border-top:6px solid #1e3c72;
}

/* TITLE */
.ticket h2{
    text-align:center;
    color:#1e3c72;
    margin-bottom:25px;
    font-size:28px;
}

/* DETAILS */
.detail{
    background:#f7f9fc;
    padding:12px 15px;
    border-radius:10px;
    margin-bottom:12px;
    font-size:17px;
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
}

.detail b{
    color:#333;
}

/* STATUS */
.status{
    color:#28a745;
    font-weight:bold;
}

/* PRINT BUTTON */
.print-btn{
    margin-top:20px;
    width:100%;
    padding:14px;
    background:#1e3c72;
    color:#fff;
    border:none;
    border-radius:10px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

.print-btn:hover{
    background:#16325c;
}

/* RESPONSIVE */
@media(max-width:768px){

    body{
        padding:10px;
    }

    .ticket{
        padding:20px;
    }

    .ticket h2{
        font-size:22px;
    }

    .detail{
        font-size:15px;
        flex-direction:column;
        gap:5px;
    }

    .print-btn{
        font-size:15px;
    }
}

</style>

</head>

<body>

<div class="ticket">

<h2>🚌 Bus Ticket</h2>

<div class="detail">
<b>Bus:</b>
<span><?php echo $ticket['bus_name']; ?></span>
</div>

<div class="detail">
<b>Bus Number:</b>
<span><?php echo $ticket['bus_number']; ?></span>
</div>

<div class="detail">
<b>Route:</b>
<span>
<?php echo $ticket['from_city']; ?>
→
<?php echo $ticket['to_city']; ?>
</span>
</div>

<div class="detail">
<b>Journey Date:</b>
<span><?php echo $ticket['journey_date']; ?></span>
</div>
<div class="detail">
<b>Name:</b>
<span><?php echo $ticket['name']; ?></span>
</div>
<div class="detail">
<b>Seats:</b>
<span><?php echo $ticket['seats']; ?></span>
</div>

<div class="detail">
<b>Total Amount:</b>
<span>₹<?php echo $ticket['total_amount']; ?></span>
</div>

<div class="detail">
<b>Payment Status:</b>
<span class="status">
<?php echo $ticket['payment_status']; ?>
</span>
</div>

<button onclick="window.print()" class="print-btn">
Print Ticket
</button>

</div>

</body>
</html>