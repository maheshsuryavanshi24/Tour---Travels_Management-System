<?php

require_once 'config.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    die("Bus ID Missing");
}

$bus_id = intval($_GET['id']);



$query = mysqli_query($conn,"
SELECT * FROM buses
WHERE id='$bus_id'
");

if (!$query || mysqli_num_rows($query) == 0) {
    die("Bus Not Found");
}

$bus = mysqli_fetch_assoc($query);



$selected_date = "";

if(isset($_POST['journey_date'])){
    $selected_date = $_POST['journey_date'];
}



$booked_seats = [];

if($selected_date != ""){

    $seatQuery = mysqli_query($conn,"
    SELECT seats
    FROM bus_bookings
    WHERE bus_id='$bus_id'
    AND journey_date='$selected_date'
    AND booking_status!='Cancelled'
    ");

    while($seatRow = mysqli_fetch_assoc($seatQuery)){

        $seatArray = explode(",", $seatRow['seats']);

        foreach($seatArray as $seat){

            $booked_seats[] = trim($seat);
        }
    }
}



if(isset($_POST['book_now']))
{
    $journey_date = $_POST['journey_date'];

    $today = date("Y-m-d");

    if($journey_date < $today){

        echo "<script>
        alert('Past date booking is not allowed');
        window.history.back();
        </script>";

        exit();
    }

    if(isset($_POST['seats']))
    {

       

        foreach($_POST['seats'] as $seat){

            if(in_array($seat, $booked_seats)){

                echo "<script>
                alert('Seat ".$seat." already booked for selected date');
                window.history.back();
                </script>";

                exit();
            }
        }

        $seats = implode(",", $_POST['seats']);

        $total_amount =
        count($_POST['seats']) * $bus['price'];
        if(isset($_POST['book_now']) && !empty($_POST['seats']))
        {
            
        
        $result = mysqli_query($conn,"
        INSERT INTO bus_bookings
        (
            bus_id,
            user_id,
            journey_date,
            seats,11
            total_amount,
            payment_status,
            booking_status
        )
        VALUES
        (
            '$bus_id',
            '$user_id',
            '$journey_date',
            '$seats',
            '$total_amount',
            'Pending',
            'Booked'
        )
        ");}
        
        if(!$result){
            die(mysqli_error($conn));
        }

        $booking_id = mysqli_insert_id($conn);

        echo "<script>
        window.location='paymentu.php?id=$booking_id';
        </script>";
    }
    else
    {
        echo "<script>
        alert('Please Select Seat');
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Bus Booking</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:
    linear-gradient(135deg,#dbeafe,#eef3f8,#c7d2fe);
    min-height:100vh;
    padding:20px;
}

/* CONTAINER */

.booking-container{
    max-width:1000px;
    width:100%;
    margin:30px auto;
    background:#fff;
    border-radius:25px;
    padding:35px;
    box-shadow:
    0 10px 40px rgba(0,0,0,0.12);
    overflow:hidden;
    position:relative;
}

.booking-container::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:6px;
    background:
    linear-gradient(90deg,#1e3c72,#2a5298,#00b4db);
}



.bus-header{
    background:
    linear-gradient(135deg,#1e3c72,#2a5298);
    color:white;
    padding:30px;
    border-radius:20px;
    margin-bottom:30px;
    text-align:center;
}

.bus-header h2{
    font-size:34px;
    margin-bottom:10px;
}

.route{
    font-size:20px;
    margin-bottom:10px;
}

.price{
    font-size:30px;
    color:#ffe082;
    font-weight:bold;
}



.date-box{
    margin-bottom:30px;
}

.date-box label{
    display:block;
    margin-bottom:10px;
    font-size:18px;
    font-weight:bold;
    color:#1e3c72;
}

.date-box input{
    width:100%;
    padding:15px;
    border-radius:12px;
    border:2px solid #dbeafe;
    font-size:16px;
    background:#f8fbff;
}

.date-box input:focus{
    outline:none;
    border-color:#2a5298;
}



.seat-title{
    text-align:center;
    font-size:30px;
    color:#1e3c72;
    margin-bottom:30px;
    font-weight:bold;
}



.driver-box{
    max-width:250px;
    margin:0 auto 30px;
    text-align:center;
    background:#dbeafe;
    padding:12px;
    border-radius:10px;
    font-weight:bold;
    color:#1e3c72;
}


.seat-container{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
}



.seat{
    position:relative;
}

.seat input{
    display:none;
}

.seat span{
    display:flex;
    justify-content:center;
    align-items:center;
    height:70px;
    border-radius:18px;

    background:
    linear-gradient(135deg,#f1f5f9,#dbeafe);

    color:#1e3c72;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;

    box-shadow:
    0 5px 12px rgba(0,0,0,0.08);
}



.seat span:hover{

    transform:
    translateY(-4px);

    background:
    linear-gradient(135deg,#2a5298,#1e3c72);

    color:white;
}



.seat input:checked + span{

    background:
    linear-gradient(135deg,#00b09b,#96c93d);

    color:white;

    transform:scale(1.05);
}



.seat input:disabled + span{

    background:#dc3545 !important;

    color:white;

    cursor:not-allowed;
}



.book-btn{

    width:100%;

    margin-top:35px;

    padding:18px;

    border:none;

    border-radius:16px;

    background:
    linear-gradient(135deg,#1e3c72,#2a5298);

    color:white;

    font-size:20px;

    font-weight:bold;

    cursor:pointer;

    transition:0.3s;
}

.book-btn:hover{

    transform:
    translateY(-3px);

    background:
    linear-gradient(135deg,#16325c,#1e3c72);
}



.legend{
    display:flex;
    justify-content:center;
    gap:20px;
    margin-top:30px;
    flex-wrap:wrap;
}

.legend-box{
    display:flex;
    align-items:center;
    gap:8px;
}

.color{
    width:20px;
    height:20px;
    border-radius:5px;
}

.available{
    background:#2a5298;
}

.selected{
    background:#00b09b;
}

.booked{
    background:#dc3545;
}



@media(max-width:768px){

    .seat-container{
        grid-template-columns:repeat(3,1fr);
    }

    .bus-header h2{
        font-size:28px;
    }

    .seat span{
        height:60px;
        font-size:15px;
    }
}

@media(max-width:480px){

    body{
        padding:10px;
    }

    .booking-container{
        padding:18px;
    }

    .seat-container{
        grid-template-columns:repeat(2,1fr);
        gap:12px;
    }

    .bus-header{
        padding:20px;
    }

    .bus-header h2{
        font-size:22px;
    }

    .route{
        font-size:15px;
    }

    .price{
        font-size:24px;
    }

    .seat span{
        height:55px;
        font-size:14px;
        border-radius:12px;
    }

    .book-btn{
        font-size:16px;
        padding:15px;
    }
}

</style>

</head>

<body>

<div class="booking-container">

    <div class="bus-header">

        <h2>
            🚌 <?php echo $bus['bus_name']; ?>
        </h2>

        <div class="route">

            <?php echo $bus['from_city']; ?>

            →

            <?php echo $bus['to_city']; ?>

        </div>

        <div class="price">

            ₹<?php echo $bus['price']; ?>

        </div>

    </div>

    <form method="POST">

<div class="date-box">

    <label>Select Journey Date</label>

    <input
    type="date"
    name="journey_date"
    min="<?php echo date('Y-m-d'); ?>"
    value="<?php echo $selected_date; ?>"
    required>

</div>
        <h3 class="seat-title">

            Select Seats

        </h3>

        <div class="driver-box">

            DRIVER

        </div>

        <div class="seat-container">

        <?php for($i=1; $i<=$bus['total_seats']; $i++) {

            $isBooked = in_array($i, $booked_seats);
        ?>

            <label class="seat">

                <?php if($isBooked){ ?>

                    <input type="checkbox" disabled>

                    <span>

                        Seat <?php echo $i; ?>

                    </span>

                <?php } else { ?>

                    <input
                    type="checkbox"
                    name="seats[]"
                    value="<?php echo $i; ?>">

                    <span>

                        Seat <?php echo $i; ?>

                    </span>

                <?php } ?>

            </label>

        <?php } ?>

        </div>

        <div class="legend">

            <div class="legend-box">

                <div class="color available"></div>

                Available

            </div>

            <div class="legend-box">

                <div class="color selected"></div>

                Selected

            </div>

            <div class="legend-box">

                <div class="color booked"></div>

                Booked

            </div>

        </div>

        <button
        type="submit"
        name="book_now"
        class="book-btn">

            Book Now

        </button>

    </form>

</div>

</body>
</html>