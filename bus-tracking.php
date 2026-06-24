<?php
include 'db.php';

$bus = null;
$journey_date = '';

if(isset($_GET['search'])){

    $bus_number = mysqli_real_escape_string(
    $conn,
    $_GET['bus_number']
);

$journey_date = mysqli_real_escape_string(
    $conn,
    $_GET['journey_date']
);

    $query = mysqli_query($conn,"
    SELECT * FROM buses
    WHERE bus_name LIKE '%$bus_number%'
    OR bus_number LIKE '%$bus_number%'
    ");

    if(mysqli_num_rows($query) > 0){

        $bus = mysqli_fetch_assoc($query);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Bus Tracking</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#eef3f8;
    padding:40px 20px;
}

.container{
    max-width:950px;
    margin:auto;
}

.title{
    text-align:center;
    margin-bottom:30px;
}

.title h1{
    color:#1e3c72;
    font-size:42px;
}

.title p{
    color:#666;
    margin-top:10px;
    font-size:18px;
}

.search-box{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    margin-bottom:30px;
}

.search-form{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.search-form input{
    flex:1;
    padding:15px;
    border:1px solid #ccc;
    border-radius:10px;
    font-size:16px;
}

.search-form button{
    padding:15px 25px;
    border:none;
    border-radius:10px;
    background:#1e3c72;
    color:white;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

.search-form button:hover{
    background:#16325c;
}

.track-card{
    background:white;
    border-radius:18px;
    padding:30px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
}

.bus-name{
    text-align:center;
    margin-bottom:25px;
}

.bus-name h2{
    color:#1e3c72;
    font-size:36px;
}

.route{
    text-align:center;
    font-size:22px;
    color:#444;
    margin-bottom:20px;
    font-weight:bold;
}

.status{
    text-align:center;
    margin-bottom:30px;
}

.status span{
    background:#28a745;
    color:white;
    padding:12px 20px;
    border-radius:30px;
    font-size:15px;
    font-weight:bold;
}

.info-grid{
    display:grid;
    grid-template-columns:
    repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-top:25px;
}

.info-box{
    background:#f4f6f9;
    padding:20px;
    border-radius:14px;
    text-align:center;
    border-left:5px solid #1e3c72;
}

.info-box h3{
    color:#1e3c72;
    margin-bottom:10px;
    font-size:20px;
}

.info-box p{
    color:#444;
    font-size:18px;
    font-weight:bold;
}

.timeline{
    margin-top:40px;
}

.timeline h2{
    color:#1e3c72;
    margin-bottom:20px;
    text-align:center;
}

.step{
    background:#f8f9fa;
    padding:18px;
    border-radius:12px;
    margin-bottom:15px;
    border-left:5px solid #009688;
}

.step h3{
    color:#1e3c72;
    margin-bottom:8px;
}

.step p{
    color:#555;
    line-height:1.6;
}

.no-data{
    background:white;
    padding:40px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.no-data h2{
    color:#dc3545;
    margin-bottom:10px;
}

@media(max-width:768px){

    .search-form{
        flex-direction:column;
    }

    .title h1{
        font-size:32px;
    }

    .bus-name h2{
        font-size:28px;
    }

    .route{
        font-size:18px;
    }

    .info-box p{
        font-size:16px;
    }
}

</style>

</head>

<body>

<div class="container">

<div class="title">

<h1>
🚌 Live Bus Tracking
</h1>

<p>
Track Your Bus Using Bus Number
</p>

</div>

<div class="search-box">

<form method="GET" class="search-form">
<input
type="text"
name="bus_number"
placeholder="Enter Bus Number or Bus Name"
required>

<input
type="date"
name="journey_date"
required>

<button type="submit" name="search">
Track Bus
</button>

</form>

</div>

<?php if($bus){ ?>

<div class="track-card">

<div class="bus-name">

<h2>
<?php echo htmlspecialchars($bus['bus_name']); ?>
</h2>

</div>

<div class="route">

📍
<?php echo htmlspecialchars($bus['from_city']); ?>

→

<?php echo htmlspecialchars($bus['to_city']); ?>

</div>

<?php

$today = date("Y-m-d");

if($journey_date > $today){

    $bus_status = "📅 Journey Not Started";
    $status_color = "#ff9800";

}
elseif($journey_date < $today){

    $bus_status = "✅ Journey Completed";
    $status_color = "#6c757d";

}
else{

    $current_time = date("H:i");
    $departure_time = date("H:i",strtotime($bus['departure_time']));

    if($current_time >= $departure_time){

        $bus_status = "🟢 Bus Running";
        $status_color = "#28a745";

    }else{

        $bus_status = "🟡 Bus Not Started";
        $status_color = "#ff9800";
    }
}
?>

<div class="status">

<span style="background:<?php echo $status_color; ?>;">

<?php echo $bus_status; ?>

</span>

</div>

<div class="info-grid">

<div class="info-box">

<h3>
Bus Started From
</h3>

<p>
<?php echo htmlspecialchars($bus['from_city']); ?>
</p>

</div>

<div class="info-box">

<h3>
Current Location
</h3>

<p>

<?php
echo htmlspecialchars(
$bus['current_location']
?? 'On The Way'
);
?>

</p>

</div>

<div class="info-box">

<h3>
Destination
</h3>

<p>
<?php echo htmlspecialchars($bus['to_city']); ?>
</p>

</div>

<div class="info-box">

<h3>
Departure Time
</h3>

<p>
<?php echo htmlspecialchars($bus['departure_time']); ?>
</p>

</div>

<div class="info-box">

<h3>
Expected Arrival
</h3>

<p>

<?php
echo htmlspecialchars(
$bus['arrival_time']
?? '10:30 PM'
);
?>

</p>

</div>

<div class="info-box">

<h3>
Bus Type
</h3>

<p>
<?php echo htmlspecialchars($bus['bus_type']); ?>
</p>

</div>
<div class="info-box">

<h3>Journey Date</h3>

<p>
<?php echo date("d M Y",strtotime($journey_date)); ?>
</p>

</div>

</div>

<div class="timeline">

<h2>
Journey Updates
</h2>

<div class="step">

<h3>
Journey Started
</h3>

<p>

<?php

$today = date("Y-m-d");

if($journey_date > $today){

    echo "Journey has not started yet.";

}
else{

?>

Bus departed from
<b>
<?php echo htmlspecialchars($bus['from_city']); ?>
</b>

at

<b>
<?php echo htmlspecialchars($bus['departure_time']); ?>
</b>

<?php } ?>

</p>

</div>

<div class="step">

<h3>
Current Running Status
</h3>

<p>

<?php

$today = date("Y-m-d");
$current_time = date("H:i");
$departure_time = date("H:i", strtotime($bus['departure_time']));

if($journey_date > $today){

    echo "Journey has not started yet.";

}
elseif($journey_date < $today){

    echo "Journey has been completed.";

}
else{

    if($current_time >= $departure_time){

        echo "Bus is currently in <b>" .
        htmlspecialchars($bus['current_location'] ?? 'Mid Route')
        . "</b>";

    }else{

        echo "Bus has not started yet. Departure time is <b>" .
        htmlspecialchars($bus['departure_time'])
        . "</b>";
    }
}

?>

</p>

</div>

<div class="step">

<h3>
Destination Arrival
</h3>

<p>

<?php

if($journey_date > $today){

    echo "Bus will arrive at <b>" .
    htmlspecialchars($bus['to_city']) .
    "</b> around <b>" .
    htmlspecialchars($bus['arrival_time'] ?? '10:30 PM') .
    "</b>";

}
elseif($journey_date < $today){

    echo "Bus has already reached <b>" .
    htmlspecialchars($bus['to_city']) .
    "</b>";

}
else{

?>

Bus will arrive at

<b>
<?php echo htmlspecialchars($bus['to_city']); ?>
</b>

around

<b>
<?php echo htmlspecialchars($bus['arrival_time'] ?? '10:30 PM'); ?>
</b>

<?php } ?>

</p>

</div>

<?php } elseif(isset($_GET['search'])) { ?>

<div class="no-data">

<h2>
No Bus Found
</h2>

<p>
Please Enter Valid Bus Number
</p>

</div>

<?php } ?>

</div>

</body>

</html>