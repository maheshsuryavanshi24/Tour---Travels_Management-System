<?php
include 'config.php';

$search = "";
$search1 = "";
$package_name = "";
$package_id = "";
$journey_date = date("Y-m-d");

if(isset($_GET['journey_date']) && !empty($_GET['journey_date']))
{
    $journey_date = $_GET['journey_date'];
}

$query = "
SELECT * FROM buses
WHERE status='Available'
";

if(isset($_GET['package_id']) && !empty($_GET['package_id']))
{
    $package_id = intval($_GET['package_id']);

    $package_query = mysqli_query($conn,"
    SELECT title
    FROM packages
    WHERE id='$package_id'
    ");

    if(mysqli_num_rows($package_query) > 0)
    {
        $package_data = mysqli_fetch_assoc($package_query);

        $package_name = $package_data['title'];

        $query .= "
        AND (
            from_city LIKE '%$package_name%'
            OR to_city LIKE '%$package_name%'
        )
        ";
    }
}


       
        
        if(
            isset($_GET['search'], $_GET['search1']) &&
            !empty($_GET['search']) &&
            !empty($_GET['search1'])
        )
        {
            $search = mysqli_real_escape_string(
                $conn,
                $_GET['search']
            );
        
            $search1 = mysqli_real_escape_string(
                $conn,
                $_GET['search1']
            );
        
            $query .= "
            AND (
                from_city LIKE '%$search%'
                AND to_city LIKE '%$search1%'
            )
            ";
        }

$query .= " ORDER BY id DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Available Buses</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#eef3f8;
    padding:40px 20px;
}

.page-title{
    text-align:center;
    margin-bottom:25px;
}

.page-title h1{
    color:#1e3c72;
    font-size:40px;
    margin-bottom:10px;
}

.page-title p{
    color:#666;
    font-size:17px;
}

.search-box{
    max-width:700px;
    margin:0 auto 35px;
    background:#fff;
    padding:20px;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

.search-form{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.search-form input{
    flex:1;
    min-width:220px;
    padding:14px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:16px;
}

.search-form button{
    padding:14px 28px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#1e3c72,#2a5298);
    color:#fff;
    cursor:pointer;
    font-size:16px;
    font-weight:600;
    transition:0.3s;
}

.search-form button:hover{
    transform:translateY(-2px);
}

.container{
    max-width:1350px;
    margin:auto;
    display:grid;
    grid-template-columns:
    repeat(auto-fit,minmax(320px,1fr));
    gap:25px;
}

.bus-card{
    background:#fff;
    border-radius:20px;
    padding:25px;
    position:relative;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    transition:0.3s;
    border:1px solid #e5e7eb;
}

.bus-card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

.bus-card::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:6px;
    background:
    linear-gradient(90deg,#1e3c72,#2a5298);
}

.bus-card h3{
    color:#1e3c72;
    font-size:28px;
    margin-bottom:15px;
    text-align:center;
}

.detail{
    margin-bottom:12px;
    font-size:16px;
    color:#555;
    line-height:1.6;
}

.route{
    font-size:20px;
    font-weight:700;
    color:#222;
    text-align:center;
}

.departure-box{
    margin-top:18px;
    background:#f8fafc;
    border-radius:14px;
    padding:15px;
    text-align:center;
    border:1px solid #e2e8f0;
}

.departure-box h4{
    color:#1e3c72;
    margin-bottom:8px;
    font-size:16px;
}

.departure-time{
    font-size:24px;
    font-weight:bold;
    color:#0f172a;
}

.badges{
    margin-top:18px;
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:10px;
}

.badge{
    padding:8px 14px;
    border-radius:30px;
    color:#fff;
    font-size:14px;
    font-weight:600;
}

.bus-type{
    background:#1e3c72;
}

.seat-type{
    background:#673ab7;
}

.status{
    background:#28a745;
}

.seat-info{
    margin-top:20px;
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:12px;
}

.seat-box{
    padding:16px 10px;
    border-radius:12px;
    text-align:center;
    color:#fff;
}

.total-seat{
    background:#1e3c72;
}

.booked-seat{
    background:#dc3545;
}

.available-seat{
    background:#28a745;
}

.seat-box h4{
    font-size:14px;
    margin-bottom:6px;
    font-weight:500;
}

.seat-box p{
    font-size:24px;
    font-weight:bold;
}

.price{
    margin-top:22px;
    text-align:center;
}

.price h2{
    color:#28a745;
    font-size:34px;
}

.book-btn{
    display:block;
    width:100%;
    margin-top:22px;
    text-align:center;
    text-decoration:none;
    background:
    linear-gradient(135deg,#1e3c72,#2a5298);
    color:#fff;
    padding:15px;
    border-radius:12px;
    font-size:17px;
    font-weight:600;
    transition:0.3s;
}

.book-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(30,60,114,0.25);
}

.no-bus{
    max-width:600px;
    margin:auto;
    background:#fff;
    padding:50px 30px;
    text-align:center;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

.no-bus h2{
    color:#777;
}

@media(max-width:768px){

    body{
        padding:20px 15px;
    }

    .page-title h1{
        font-size:32px;
    }

    .container{
        grid-template-columns:
        repeat(auto-fit,minmax(280px,1fr));
        gap:20px;
    }

    .seat-info{
        grid-template-columns:1fr;
    }

    .search-form{
        flex-direction:column;
    }
}

</style>

</head>

<body>

<div class="page-title">

<h1>Available Buses</h1>

<?php if($package_name != ""){ ?>

<p style="
text-align:center;
color:#1e3c72;
font-size:20px;
margin-bottom:20px;
font-weight:bold;
">

Showing buses for:
<?php echo htmlspecialchars($package_name); ?>

</p>

<?php } ?>

<p>
Search & Book AC / Non-AC Sleeper & Seater Buses
</p>

</div>

<div class="search-box">

<form method="GET" class="search-form">

<?php if($package_id != ""){ ?>

<input
type="hidden"
name="package_id"
value="<?php echo $package_id; ?>">

<?php } ?>

<input
type="text"
name="search"
placeholder="Search by From City "
value="<?php echo htmlspecialchars($search); ?>">
<input
type="text"
name="search1"
placeholder=" Destination"
value="<?php echo htmlspecialchars($search1); ?>">

<input
type="date"
name="journey_date"
value="<?php echo $journey_date; ?>">

<button type="submit">
Search Bus
</button>

</form>

</div>

<?php
if(mysqli_num_rows($result) > 0){
?>

<div class="container">

<?php

while($row = mysqli_fetch_assoc($result))
{
$bus_id = $row['id'];

$today = date("Y-m-d");

$booked_query = mysqli_query($conn,"
SELECT seats
FROM bus_bookings
WHERE bus_id='$bus_id'
AND booking_status!='Cancelled'
AND journey_date='$journey_date'
");

    $booked_seats = 0;

    while($seat_row = mysqli_fetch_assoc($booked_query))
    {
        $seat_array =
        array_filter(
            explode(",", $seat_row['seats'])
        );

        $booked_seats += count($seat_array);
    }

    $total_seats =
    (int)$row['total_seats'];

    $available_seats =
    $total_seats - $booked_seats;

    if($available_seats < 0){
        $available_seats = 0;
    }
?>

<div class="bus-card">

<h3>
<?= htmlspecialchars($row['bus_name']); ?>
</h3>

<div class="detail route">

📍
<?= htmlspecialchars($row['from_city']); ?>

→

<?= htmlspecialchars($row['to_city']); ?>

</div>

<div class="departure-box">

<h4>Departure Time</h4>

<div class="departure-time">
<?= htmlspecialchars($row['departure_time']); ?>
</div>

</div>

<div class="badges">

<span class="badge bus-type">
<?= htmlspecialchars($row['bus_type']); ?>
</span>

<span class="badge seat-type">
<?= htmlspecialchars($row['seat_type']); ?>
</span>

<span class="badge status">
Available
</span>

</div>

<div class="seat-info">

<div class="seat-box total-seat">

<h4>Total Seats</h4>

<p><?= $total_seats; ?></p>

</div>

<div class="seat-box booked-seat">

<h4>Booked</h4>

<p><?= $booked_seats; ?></p>

</div>

<div class="seat-box available-seat">

<h4>Available</h4>

<p><?= $available_seats; ?></p>

</div>

</div>

<div class="price">

<h2>
₹<?= $row['price']; ?>
</h2>

</div>

<?php if($available_seats > 0){ ?>

<a class="book-btn"
href="bus-book.php?id=<?= $row['id']; ?><?php if($package_id != ''){ ?>&package_id=<?= $package_id; ?><?php } ?>">

Book Seats

</a>

<?php } else { ?>

<a class="book-btn"
style="background:#dc3545; pointer-events:none;">

Bus Full

</a>

<?php } ?>

</div>

<?php } ?>

</div>

<?php } else { ?>

<div class="no-bus">

<h2>No Buses Found</h2>

</div>

<?php } ?>

</body>
</html>