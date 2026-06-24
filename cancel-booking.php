<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}


if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("Invalid Booking ID");
}

$booking_id = intval($_GET['id']);
$user_id = intval($_SESSION['user_id']);

// GET BOOKING + BUS DETAILS
$getBooking = mysqli_query($conn,"
SELECT
    bus_bookings.*,
    buses.bus_name,
    buses.from_city,
    buses.to_city,
    buses.departure_time,
    buses.total_seats,
    buses.available_seats

FROM bus_bookings

INNER JOIN buses
ON bus_bookings.bus_id = buses.id

WHERE bus_bookings.id='$booking_id'
AND bus_bookings.user_id='$user_id'
");

if(mysqli_num_rows($getBooking) == 0){
    die("Booking Not Found");
}

$booking = mysqli_fetch_assoc($getBooking);

$bus_id = $booking['bus_id'];

// COUNT BOOKED SEATS
$seat_array = array_filter(
    explode(",", $booking['seats'])
);

$seat_count = count($seat_array);

// CHECK ALREADY CANCELLED
if($booking['booking_status'] == 'Cancelled'){

    $message = "Booking Already Cancelled!";
    $success = false;

}else{

    mysqli_begin_transaction($conn);

    try{

        

        mysqli_query($conn,"
        UPDATE bus_bookings
        SET booking_status='Cancelled'
        WHERE id='$booking_id'
        ");

       

        mysqli_query($conn,"
        UPDATE buses
        SET available_seats =
        available_seats + $seat_count
        WHERE id='$bus_id'
        ");

        mysqli_commit($conn);

        $message = "Bus Booking Cancelled Successfully!";
        $success = true;

    }catch(Exception $e){

        mysqli_rollback($conn);

        $message = "Something Went Wrong!";
        $success = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Cancel Bus Booking</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#eef3f8;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}



.box{
    width:100%;
    max-width:520px;
    background:#fff;
    border-radius:20px;
    padding:35px 28px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    position:relative;
    overflow:hidden;
}



.box::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:6px;
    background:
    linear-gradient(90deg,#1e3c72,#2a5298);
}


.box h2{
    text-align:center;
    color:#1e3c72;
    margin-bottom:28px;
    font-size:32px;
}



.status-message{
    text-align:center;
    font-size:18px;
    font-weight:700;
    padding:14px;
    border-radius:10px;
    margin-bottom:25px;
}

.success{
    background:#e8f7ee;
    color:#28a745;
}

.error{
    background:#fdeaea;
    color:#dc3545;
}



.details{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:15px;
    margin-bottom:25px;
}

.detail-box{
    background:#f7f9fc;
    padding:16px;
    border-radius:12px;
}

.detail-box h4{
    color:#777;
    margin-bottom:6px;
    font-size:14px;
}

.detail-box p{
    color:#222;
    font-size:17px;
    font-weight:600;
}



.actions{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.btn{
    flex:1;
    text-align:center;
    text-decoration:none;
    padding:14px;
    border-radius:12px;
    font-weight:600;
    transition:0.3s;
}

.back-btn{
    background:#1e3c72;
    color:#fff;
}

.back-btn:hover{
    background:#16325c;
}

.home-btn{
    background:#28a745;
    color:#fff;
}

.home-btn:hover{
    background:#218838;
}



@media(max-width:768px){

    .details{
        grid-template-columns:1fr;
    }

    .box{
        padding:28px 20px;
    }

    .box h2{
        font-size:28px;
    }
}

@media(max-width:480px){

    body{
        padding:15px;
    }

    .box{
        padding:24px 18px;
    }

    .box h2{
        font-size:24px;
    }

    .status-message{
        font-size:16px;
    }

    .detail-box p{
        font-size:15px;
    }

    .actions{
        flex-direction:column;
    }

    .btn{
        width:100%;
    }
}

</style>

</head>

<body>

<div class="box">

    <h2>Cancel Booking</h2>

    <div class="status-message
    <?php echo $success ? 'success' : 'error'; ?>">

        <?php echo $message; ?>

    </div>

    <div class="details">

        <div class="detail-box">

            <h4>Bus Name</h4>

            <p>
                <?php echo htmlspecialchars($booking['bus_name']); ?>
            </p>

        </div>

        <div class="detail-box">

            <h4>Route</h4>

            <p>
                <?php
                echo htmlspecialchars($booking['from_city']);
                ?>
                →
                <?php
                echo htmlspecialchars($booking['to_city']);
                ?>
            </p>

        </div>

        <div class="detail-box">

            <h4>Journey Date</h4>

            <p>
                <?php echo $booking['journey_date']; ?>
            </p>

        </div>

        <div class="detail-box">

            <h4>Seats Cancelled</h4>

            <p>
                <?php echo htmlspecialchars($booking['seats']); ?>
            </p>

        </div>

        <div class="detail-box">

            <h4>Total Amount</h4>

            <p>
                ₹<?php echo $booking['total_amount']; ?>
            </p>

        </div>

        <div class="detail-box">

            <h4>Available Seats Now</h4>

            <p>
                <?php
                echo $booking['available_seats']
                + $seat_count;
                ?>
            </p>

        </div>

    </div>

    <div class="actions">

        <a href="my_booking_history.php"
           class="btn back-btn">

           My Bookings

        </a>

        <a href="dashboard.php"
           class="btn home-btn">

           Back Home

        </a>

    </div>

</div>

</body>
</html>