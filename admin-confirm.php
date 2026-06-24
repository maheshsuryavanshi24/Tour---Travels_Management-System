<?php
session_start();

include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}



$query = "SELECT

bus_bookings.*,

users.name,
users.mobile,

buses.bus_name,
buses.from_city,
buses.to_city

FROM bus_bookings

JOIN users
ON bus_bookings.user_id = users.id

JOIN buses
ON bus_bookings.bus_id = buses.id

WHERE
bus_bookings.booking_status='Booked'
OR
bus_bookings.booking_status='Booked'

ORDER BY bus_bookings.id DESC";

$result = mysqli_query($conn, $query);

if(!$result){
    die(mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Confirm Bus Tickets</title>

<style>

body{
    font-family:Arial;
    background:#f5f5f5;
    margin:0;
}



.navbar{
    background:#009688;
    color:white;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.navbar a{
    color:white;
    text-decoration:none;
    margin-left:20px;
}

.navbar a:hover{
    text-decoration:underline;
}



.container{
    width:95%;
    margin:30px auto;
}

h1{
    text-align:center;
    margin-bottom:30px;
    color:#333;
}



table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

table th{
    background:#009688;
    color:white;
    padding:14px;
}

table td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

table tr:hover{
    background:#f1f1f1;
}

.cancel{
    color:red;
    font-weight:bold;
}

.route{
    font-weight:bold;
}

.no-data{
    text-align:center;
    padding:20px;
    color:red;
    font-size:18px;
}

@media(max-width:768px){

    table{
        font-size:14px;
    }

    .navbar{
        flex-direction:column;
        gap:10px;
    }
}

</style>

</head>

<body>



<div class="navbar">

<div>
    <b>Admin Panel</b>
</div>

<div>

<a href="admin-dashboard.php">
Dashboard
</a>

<a href="admin-bookings.php">
Bookings
</a>

<a href="cancelled-bookings.php">
Cancelled Tickets
</a>

<a href="logout.php">
Logout
</a>

</div>

</div>



<div class="container">

<h1>
 Confirm Bus Tickets
</h1>

<table>

<tr>

<th>ID</th>

<th>User Name</th>

<th>Mobile</th>

<th>Bus Name</th>

<th>Route</th>

<th>Seats</th>

<th>Amount</th>

<th>Payment</th>

<th>Status</th>

<th>Date</th>

</tr>

<?php

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo htmlspecialchars($row['name']); ?>
</td>

<td>
<?php echo htmlspecialchars($row['mobile']); ?>
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

<?php
echo htmlspecialchars(
$row['seat_number']
?? $row['seats']
?? 'N/A'
);
?>

</td>

<td>

₹<?php
echo htmlspecialchars(
$row['total_amount']
);
?>

</td>

<td>

<?php
echo htmlspecialchars(
$row['payment_method']
?? 'Online'
);
?>

</td>

<td class="cancel">

<?php
echo htmlspecialchars(
$row['booking_status']
?? $row['status']
?? 'Confirm'
);
?>

</td>

<td>

<?php
echo htmlspecialchars(
$row['booking_date']
?? 'N/A'
);
?>

</td>

</tr>

<?php
}
}else{
?>

<tr>

<td colspan="10" class="no-data">

No Comfirm Tickets Found

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>