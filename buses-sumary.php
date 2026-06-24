<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}



$query = mysqli_query($conn, "SELECT * FROM buses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Bus Summary</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

body{
    font-family:Arial;
    background:#eef3f8;
    padding:20px;
}

h1{
    text-align:center;
    margin-bottom:25px;
    color:#1e3c72;
}


.container{
    max-width:1200px;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:20px;
}


.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.title{
    font-size:20px;
    font-weight:bold;
    color:#1e3c72;
    margin-bottom:10px;
}

.route{
    color:#555;
    margin-bottom:15px;
}

.info{
    display:flex;
    justify-content:space-between;
    margin:8px 0;
    padding:8px;
    background:#f5f7fa;
    border-radius:6px;
}


.label{
    color:#555;
}

.value{
    font-weight:bold;
    color:#009688;
}


@media(max-width:600px){
    .info{
        flex-direction:column;
        gap:5px;
    }
}

</style>

</head>

<body>

<h1>Bus Summary (Availability Status)</h1>

<div class="container">

<?php while($bus = mysqli_fetch_assoc($query)) {

  
    $total = (int)$bus['total_seats'];

   
    $booked_query = mysqli_query($conn,
        "SELECT seats FROM bus_bookings WHERE bus_id='{$bus['id']}'"
    );

    $booked_count = 0;

    while($b = mysqli_fetch_assoc($booked_query)){
        if(!empty($b['seats'])){
            $seat_array = explode(",", $b['seats']);
            $booked_count += count($seat_array);
        }
    }

    $available = $total - $booked_count;
    if($available < 0) $available = 0;

?>

<div class="card">

    <div class="title">
        <?php echo $bus['bus_name']; ?>
    </div>

    <div class="route">
        <?php echo $bus['from_city']; ?> → <?php echo $bus['to_city']; ?>
    </div>

    <div class="info">
        <span class="label">Total Seats</span>
        <span class="value"><?php echo $total; ?></span>
    </div>

    <div class="info">
        <span class="label">Booked Seats</span>
        <span class="value"><?php echo $booked_count; ?></span>
    </div>

    <div class="info">
        <span class="label">Available Seats</span>
        <span class="value"><?php echo $available; ?></span>
    </div>

</div>

<?php } ?>

</div>

</body>
</html>