<?php
session_start();

include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}

$query = "
SELECT

bus_bookings.*,

users.name,

packages.title,

buses.bus_name,
buses.from_city,
buses.to_city

FROM bus_bookings

JOIN users
ON bus_bookings.user_id = users.id

JOIN buses
ON bus_bookings.bus_id = buses.id

LEFT JOIN packages
ON packages.title = buses.to_city

ORDER BY bus_bookings.id DESC
";

$result = mysqli_query($conn,$query);

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>All Bus Bookings</title>


<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f4f6f9;
    padding:20px;
}

.container{
    width:100%;
    max-width:1300px;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    margin-bottom:25px;
    color:#333;
}

.table-responsive{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:1000px;
}

table th{
    background:#009688;
    color:white;
    padding:14px;
    text-align:center;
}

table td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

table tr:hover{
    background:#f1f1f1;
}

.status{
    padding:6px 12px;
    border-radius:5px;
    font-size:14px;
    font-weight:bold;
}

.confirmed{
    background:#d4edda;
    color:#155724;
}

.cancelled{
    background:#f8d7da;
    color:#721c24;
}

.pending{
    background:#fff3cd;
    color:#856404;
}

.route{
    font-weight:bold;
    color:#1e3c72;
}

.price{
    color:green;
    font-weight:bold;
}

@media(max-width:768px){

    .container{
        padding:15px;
    }

    h2{
        font-size:24px;
    }

    table th,
    table td{
        font-size:14px;
        padding:10px;
    }
}

</style>

</head>

<body>

<div class="container">

<h2>
📋 All Bus Bookings
</h2>
<button type="button"
onclick="window.print()"
class="btn-print">
Print / Save PDF
</button>

<div class="table-responsive">

<table>

<tr>

<th>ID</th>

<th>User</th>

<th>Package</th>

<th>Bus</th>

<th>Route</th>

<th>Journey Date</th>

<th>Seats</th>

<th>Amount</th>

<th>Payment</th>

<th>Status</th>

<th>Booking Date</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo htmlspecialchars($row['name']); ?>
</td>

<td>
<?php echo htmlspecialchars($row['title'] ?? 'N/A'); ?>
</td>

<td>
<?php echo htmlspecialchars($row['bus_name']); ?>
</td>

<td class="route">

<?php echo htmlspecialchars($row['from_city']); ?>

→

<?php echo htmlspecialchars($row['to_city']); ?>

</td>

<td>
<?php echo htmlspecialchars($row['journey_date']); ?>
</td>

<td>
<?php echo htmlspecialchars($row['seats']); ?>
</td>

<td class="price">
₹<?php echo htmlspecialchars($row['total_amount']); ?>
</td>

<td>
<?php echo htmlspecialchars($row['payment_status']); ?>
</td>

<td>

<?php
$status =
$row['booking_status']
?? 'Pending';
?>

<span class="status <?php echo strtolower($status); ?>">

<?php echo $status; ?>

</span>

</td>

<td>

<?php
echo $row['booking_date']
?? 'N/A';
?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>