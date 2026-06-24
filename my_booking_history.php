<?php

session_start();
require_once 'config.php';
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,"
SELECT
    bus_bookings.id,
    bus_bookings.bus_id,
    bus_bookings.user_id,
    bus_bookings.journey_date,
    bus_bookings.seats,
    bus_bookings.total_amount,
    bus_bookings.payment_status,
    bus_bookings.booking_date,
    bus_bookings.booking_status,

    buses.bus_name,
    buses.from_city,
    buses.to_city,
    buses.departure_time

FROM bus_bookings
INNER JOIN buses ON bus_bookings.bus_id = buses.id

WHERE bus_bookings.user_id='$user_id'
AND bus_bookings.booking_status!='cancelled'

ORDER BY bus_bookings.id DESC
");

if(!$query){
    die("Query Failed : " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Bus Booking History</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#eef3f8;
    padding:40px;
}

.page-title{
    text-align:center;
    margin-bottom:30px;
}

.page-title h1{
    color:#1e3c72;
    font-size:38px;
}

.history-container{
    max-width:1100px;
    margin:auto;
}

.booking-card{
    background:#fff;
    border-radius:16px;
    padding:25px;
    margin-bottom:20px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    border-left:5px solid #1e3c72;
    transition:0.3s;
}

.booking-card:hover{
    transform:translateY(-4px);
}

.booking-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    margin-bottom:20px;
}

.bus-name{
    font-size:24px;
    font-weight:700;
    color:#1e3c72;
}

.status{
    padding:6px 14px;
    border-radius:20px;
    font-size:14px;
    font-weight:bold;
    color:#fff;
}

.paid{
    background:#28a745;
}

.pending{
    background:#ff9800;
}

.details{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:15px;
}

.detail-box{
    background:#f7f9fc;
    padding:15px;
    border-radius:10px;
}

.detail-box h4{
    font-size:13px;
    color:#666;
    margin-bottom:5px;
}

.detail-box p{
    font-size:16px;
    font-weight:600;
    color:#222;
}

.action-buttons{
    margin-top:20px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn{
    padding:10px 16px;
    border-radius:8px;
    text-decoration:none;
    color:#fff;
    font-weight:600;
    transition:0.3s;
    display:inline-block;
}

.ticket-btn{
    background:#1e3c72;
}

.ticket-btn:hover{
    background:#16325c;
}

.cancel-btn{
    background:#dc3545;
}

.cancel-btn:hover{
    background:#b52b38;
}

.disabled-btn{
    background:gray;
    cursor:not-allowed;
}

.closed-btn{
    background:#ff9800;
    cursor:not-allowed;
}

.empty-box{
    background:#fff;
    padding:40px;
    text-align:center;
    border-radius:16px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
}

.empty-box h2{
    color:#777;
}

@media(max-width:768px){

    body{
        padding:20px;
    }

    .page-title h1{
        font-size:28px;
    }

    .bus-name{
        font-size:20px;
    }

    .action-buttons{
        flex-direction:column;
    }

    .btn{
        width:100%;
        text-align:center;
    }
}

</style>

</head>

<body>

<div class="page-title">
    <h1>My Bus Booking History</h1>
</div>

<div class="history-container">

<?php if(mysqli_num_rows($query) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($query)){ ?>

<?php

$payment_class = (
    strtolower($row['payment_status']) == 'paid'
) ? 'paid' : 'pending';

$today = strtotime(date("Y-m-d"));
$journey_date = strtotime($row['journey_date']);

$days_left = floor(
    ($journey_date - $today) / (60*60*24)
);

?>

<div class="booking-card">

    <div class="booking-top">

        <div class="bus-name">
            <?php echo htmlspecialchars($row['bus_name']); ?>
        </div>

        <div class="status <?php echo $payment_class; ?>">
            <?php echo $row['payment_status']; ?>
        </div>

    </div>

    <div class="details">

        <div class="detail-box">
            <h4>Route</h4>
            <p>
                <?php echo $row['from_city']; ?>
                →
                <?php echo $row['to_city']; ?>
            </p>
        </div>

        <div class="detail-box">
            <h4>Journey Date</h4>
            <p><?php echo $row['journey_date']; ?></p>
        </div>

        <div class="detail-box">
            <h4>Departure Time</h4>
            <p><?php echo $row['departure_time']; ?></p>
        </div>

        <div class="detail-box">
            <h4>Seats</h4>
            <p><?php echo $row['seats']; ?></p>
        </div>

        <div class="detail-box">
            <h4>Total Amount</h4>
            <p>₹<?php echo $row['total_amount']; ?></p>
        </div>

        <div class="detail-box">
            <h4>Booking Date</h4>
            <p>
                <?php
                echo !empty($row['booking_date'])
                ? date("d M Y", strtotime($row['booking_date']))
                : "N/A";
                ?>
            </p>
        </div>

    </div>

    <div class="action-buttons">

        <a class="btn ticket-btn"
           href="ticketu.php?id=<?php echo $row['id']; ?>">
           View Ticket
        </a>

        <?php

        if($journey_date < $today){

            echo '<span class="btn disabled-btn">
                    Journey Completed
                  </span>';

        }elseif($days_left <= 1){

            echo '<span class="btn closed-btn">
                    Cancellation Closed
                  </span>';

        }else{
        ?>

            <a class="btn cancel-btn"
               href="cancel-booking.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Are you sure you want to cancel this booking?')">
               Cancel Booking
            </a>

        <?php } ?>

    </div>

</div>

<?php } ?>

<?php } else { ?>

<div class="empty-box">
    <h2>No Booking History Found</h2>
</div>

<?php } ?>

</div>

</body>
</html>