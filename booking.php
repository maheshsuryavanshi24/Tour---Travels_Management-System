<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['package_id']) || !is_numeric($_GET['package_id'])){
    die("Invalid Package!");
}

$package_id = intval($_GET['package_id']);

$query = mysqli_query($conn,"
SELECT * FROM packages
WHERE id='$package_id'
");

if(mysqli_num_rows($query) == 0){
    die("Package Not Found!");
}

$package = mysqli_fetch_assoc($query);

/* BOOKED SEATS */

$booked_seats = [];

$seatQuery = mysqli_query($conn,"
SELECT seats
FROM bookings
WHERE package_id='$package_id'
AND booking_status!='Cancelled'
");

while($seatRow = mysqli_fetch_assoc($seatQuery)){

    $seatArray = explode(",", $seatRow['seats']);

    foreach($seatArray as $seat){

        $booked_seats[] = trim($seat);
    }
}

$seatResult = mysqli_query($conn,"
SELECT total_seats
FROM packages
WHERE id='$package_id'
");

$seatData = mysqli_fetch_assoc($seatResult);

$total_seats = $seatData['total_seats'];



$available_seats = $total_seats - count($booked_seats);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Select Seats</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#eef3f8;
}


.container{
    width:95%;
    max-width:1200px;
    margin:auto;
    padding:30px 15px;
}



.package-card{
    background:#fff;
    border-radius:18px;
    padding:25px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    margin-bottom:30px;
    position:relative;
    overflow:hidden;
}

.package-card::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:5px;
    background:linear-gradient(90deg,#1e3c72,#2a5298);
}

.package-card h1{
    text-align:center;
    color:#1e3c72;
    margin-bottom:20px;
    font-size:34px;
}

.package-info{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:15px;
}

.info-box{
    background:#f4f6f9;
    padding:15px;
    border-radius:12px;
    text-align:center;
    font-weight:600;
    color:#333;
    border:1px solid #ddd;
}

.info-box span{
    display:block;
    margin-top:8px;
    color:#009688;
    font-size:20px;
    font-weight:bold;
}



.seat-section{
    background:#fff;
    border-radius:18px;
    padding:30px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

.seat-title{
    text-align:center;
    margin-bottom:30px;
    color:#1e3c72;
    font-size:28px;
}



.screen{
    max-width:350px;
    margin:0 auto 35px;
    background:#dfe6ee;
    text-align:center;
    padding:12px;
    border-radius:10px;
    font-weight:bold;
    color:#444;
    letter-spacing:2px;
}



.seat-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
    max-width:500px;
    margin:auto;
}

.seat{
    position:relative;
}

.seat input{
    display:none;
}

.seat label{
    display:flex;
    justify-content:center;
    align-items:center;
    height:65px;
    border-radius:12px;
    background:#009688;
    color:#fff;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.seat label:hover{
    background:#00796b;
    transform:translateY(-2px);
}

.seat input:checked + label{
    background:#ff9800;
    transform:scale(1.05);
}

.booked label{
    background:#cfcfcf !important;
    color:#666;
    cursor:not-allowed;
}



.legend{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:20px;
    margin-top:35px;
}

.legend-box{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:15px;
}

.color{
    width:22px;
    height:22px;
    border-radius:5px;
}

.available{
    background:#009688;
}

.selected{
    background:#ff9800;
}

.booked-color{
    background:#cfcfcf;
}


.btn{
    display:block;
    width:100%;
    max-width:350px;
    margin:35px auto 0;
    padding:15px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#1e3c72,#2a5298);
    color:#fff;
    font-size:18px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(30,60,114,0.25);
}



@media(max-width:768px){

    .package-card h1{
        font-size:28px;
    }

    .seat-title{
        font-size:24px;
    }

    .seat-grid{
        gap:10px;
    }

    .seat label{
        height:55px;
        font-size:15px;
    }
}

@media(max-width:480px){

    .container{
        padding:20px 10px;
    }

    .package-card,
    .seat-section{
        padding:20px;
    }

    .seat-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .package-card h1{
        font-size:24px;
    }

    .info-box{
        font-size:14px;
    }

    .btn{
        font-size:16px;
        padding:13px;
    }
}

</style>

</head>

<body>

<div class="container">

    <div class="package-card">

        <h1>
            <?php echo htmlspecialchars($package['title']); ?>
        </h1>

        <div class="package-info">

            <div class="info-box">
                Package Price
                <span>
                    ₹<?php echo $package['price']; ?>
                </span>
            </div>

            <div class="info-box">
                Total Seats
                <span>
                    <?php echo $total_seats; ?>
                </span>
            </div>

            <div class="info-box">
                Available Seats
                <span id="availableSeats">
                    <?php echo $available_seats; ?>
                </span>
            </div>

            <div class="info-box">
                Selected Seats
                <span id="selectedSeatCount">
                    0
                </span>
            </div>

        </div>

    </div>

    <div class="seat-section">

        <h2 class="seat-title">
            Select Your Seats
        </h2>

        <div class="screen">
            DRIVER
        </div>

        <form action="payment.php" method="POST">

            <input type="hidden"
            name="package_id"
            value="<?php echo $package['id']; ?>">

            <input type="hidden"
            name="price"
            value="<?php echo $package['price']; ?>">

            <div class="seat-grid">

            <?php

            $rows = ['A','B','C','D'];

            foreach($rows as $row){

                for($i=1; $i<=4; $i++){

                    $seat = $row.$i;

                    $isBooked = in_array($seat, $booked_seats);
            ?>

                <div class="seat <?php if($isBooked){ echo 'booked'; } ?>">

                    <?php if($isBooked){ ?>

                        <label>
                            <?php echo $seat; ?>
                        </label>

                    <?php } else { ?>

                        <input
                        type="checkbox"
                        id="<?php echo $seat; ?>"
                        name="seats[]"
                        value="<?php echo $seat; ?>">

                        <label for="<?php echo $seat; ?>">
                            <?php echo $seat; ?>
                        </label>

                    <?php } ?>

                </div>

            <?php
                }
            }
            ?>

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
                    <div class="color booked-color"></div>
                    Booked
                </div>

            </div>

            <button type="submit" class="btn">
                Continue To Payment
            </button>

        </form>

    </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function(){

    let seatCheckboxes =
    document.querySelectorAll('input[name="seats[]"]');

    let maxSeats = 6;

    let selectedSeatCount =
    document.getElementById("selectedSeatCount");

    let availableSeats =
    document.getElementById("availableSeats");

    let totalAvailable =
    <?php echo $available_seats; ?>;

    seatCheckboxes.forEach(function(checkbox){

        checkbox.addEventListener("change", function(){

            let checkedSeats =
            document.querySelectorAll(
            'input[name="seats[]"]:checked'
            );

            if(checkedSeats.length > maxSeats){

                alert("Maximum 6 seats can be selected!");

                this.checked = false;

                checkedSeats =
                document.querySelectorAll(
                'input[name="seats[]"]:checked'
                );
            }

            selectedSeatCount.innerHTML =
            checkedSeats.length;

            availableSeats.innerHTML =
            totalAvailable - checkedSeats.length;

        });
    });
});

</script>

</body>
</html>