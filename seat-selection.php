<?php
session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['package_id'])){
    die("Invalid Package");
}

$package_id = intval($_GET['package_id']);

$query = mysqli_query(
    $conn,
    "SELECT * FROM buses WHERE package_id='$package_id'"
);

if(!$query){
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Select Bus</title>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#eef3f8;
}

/* CONTAINER */
.container{
    width:90%;
    margin:auto;
    padding:30px 0;
}

/* TITLE */
h1{
    text-align:center;
    margin-bottom:25px;
    color:#1e3c72;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));
    gap:20px;
}

/* CARD */
.card{
    background:#fff;
    padding:20px;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

/* BUS NAME */
.card h2{
    color:#009688;
    margin-bottom:10px;
}

/* ROUTE */
.route{
    font-size:16px;
    font-weight:bold;
    margin:10px 0;
    color:#333;
}

/* TIME */
.time{
    margin-top:8px;
    color:#555;
    font-size:14px;
}

/* BADGES */
.badge{
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    color:#fff;
    font-size:12px;
    margin-right:6px;
}

.ac{ background:#009688; }
.nonac{ background:#ff9800; }
.sleeper{ background:#673ab7; }
.seater{ background:#3f51b5; }

/* BUTTON */
.btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 16px;
    background:#009688;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
    width:100%;
    text-align:center;
}

.btn:hover{
    background:#00796b;
}

/* RESPONSIVE */
@media(max-width:768px){
    .container{
        width:95%;
    }

    h1{
        font-size:22px;
    }
}

@media(max-width:480px){
    .card{
        padding:15px;
    }

    .route{
        font-size:15px;
    }

    .btn{
        font-size:14px;
    }
}

</style>

</head>

<body>

<div class="container">

<h1>Available Buses</h1>

<div class="grid">

<?php while($bus = mysqli_fetch_assoc($query)){ ?>

<div class="card">

<h2>
    <?php echo htmlspecialchars($bus['bus_name']); ?>
</h2>

<div class="route">
📍 <?php echo htmlspecialchars($bus['from_city']); ?>
→ <?php echo htmlspecialchars($bus['to_city']); ?>
</div>

<p class="time">
🕒 Departure: <b><?php echo htmlspecialchars($bus['departure_time']); ?></b>
</p>

<p class="time">
🕒 Arrival: <b><?php echo htmlspecialchars($bus['arrival_time']); ?></b>
</p>

<p style="margin-top:10px;">
<span class="badge ac"><?php echo htmlspecialchars($bus['bus_type']); ?></span>
<span class="badge sleeper"><?php echo htmlspecialchars($bus['seat_type']); ?></span>
</p>

<p class="time">
💺 Seats: <b><?php echo htmlspecialchars($bus['total_seats']); ?></b>
</p>

<a class="btn"
href="select-seats.php?bus_id=<?php echo $bus['id']; ?>">
Select Seats
</a>

</div>

<?php } ?>

</div>

</div>

</body>
</html>