<?php
session_start();

include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}

$users = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM users"
);

$users = mysqli_fetch_assoc($users)['total'];

$packages = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM packages"
);

$packages = mysqli_fetch_assoc($packages)['total'];

$package_bookings = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM bus_bookings"
);

$package_bookings =
mysqli_fetch_assoc($package_bookings)['total'];

$bus_bookings = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM bus_bookings"
);

$bus_bookings =
mysqli_fetch_assoc($bus_bookings)['total'];

$total_tickets =
$package_bookings + $bus_bookings;

$buses = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM buses"
);

$buses = mysqli_fetch_assoc($buses)['total'];

$cancelled = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM bus_bookings
     WHERE booking_status='Cancelled'"
);

$cancelled =
mysqli_fetch_assoc($cancelled)['total'];

$confirmed = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM bus_bookings
     WHERE booking_status='Booked'"
);

$confirmed =
mysqli_fetch_assoc($confirmed)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f5f5f5;
}

.nav{
    background:#009688;
    padding:15px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

.logo{
    color:white;
    font-size:24px;
    font-weight:bold;
}

.nav-links{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}

.nav-links a{
    color:white;
    text-decoration:none;
    padding:10px 15px;
    border-radius:5px;
    transition:0.3s;
}

.nav-links a:hover{
    background:rgba(255,255,255,0.2);
}

.container{
    width:95%;
    margin:auto;
    padding:30px 0;
}

.heading{
    margin-bottom:25px;
    color:#333;
}

.cards{
    display:grid;
    grid-template-columns:
    repeat(auto-fit,minmax(230px,1fr));
    gap:20px;
}

.card{
    background:white;
    border-radius:12px;
    padding:25px;
    text-align:center;
    box-shadow:0 3px 12px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card h2{
    font-size:40px;
    margin-bottom:10px;
}

.card p{
    color:#555;
    font-size:18px;
}

.green h2{
    color:#009688;
}

.blue h2{
    color:#2196f3;
}

.orange h2{
    color:#ff9800;
}

.red h2{
    color:#f44336;
}

.purple h2{
    color:#673ab7;
}

.btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 18px;
    background:#009688;
    color:white;
    text-decoration:none;
    border-radius:5px;
    transition:0.3s;
}

.btn:hover{
    background:#00796b;
}

@media(max-width:768px){

    .nav{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .nav-links{
        width:100%;
    }

    .nav-links a{
        flex:1;
        text-align:center;
    }
}

</style>

<script>

function goToPage(page){

    if(page !== ""){
        window.location.href = page;
    }

}

</script>
</head>

<body>

<div class="nav">

<div class="logo">
Admin Panel
</div>

<div class="nav-links">
 <div class="menu-toggle" onclick="toggleMenu()">
        ☰
    </div>

    <div class="menu" id="mobileMenu">
<a href="admin-dashboard.php">
Dashboard
</a>

<a href="admin-packages.php">
Packages
</a>

<a href="admin-bookings.php">
Bookings
</a>

<a href="cancelled-bookings.php">
Cancelled Tickets
</a>

        <select onchange="goToPage(this.value)">

            <option value="">
               Genrate Report
            </option>

            <option value="payment-report.php">
                Payment Report
            </option>

            <option value="booking-report.php">
                Bus Report
            </option>
	               
          		<option value="admin-bookings.php">
                Booking Report  
            </option>
	<option value="feedbackreport.php">
                Feedback Report  
            </option>
        </select>



<a href="index.php">
Logout
</a>

</div>

</div>
</div>
<div class="container">

<h1 class="heading">
📊 Dashboard Overview
</h1>

<div class="cards">

<div class="card green">

<h2>+</h2>

<p>Add Package</p>

<a class="btn"
href="add-package.php">

Add Package

</a>

</div>

<div class="card blue">

<h2>+</h2>

<p>Add Bus</p>

<a class="btn"
href="add-bus.php">

Add Bus

</a>

</div>

<div class="card orange">

<h2>
<?php echo $users; ?>
</h2>

<p>Total Users</p>

<a class="btn"
href="admin-users.php">

View Users

</a>

</div>

<div class="card green">

<h2>
<?php echo $packages; ?>
</h2>

<p>Total Packages</p>

<a class="btn"
href="admin-packages.php">

Manage Packages

</a>

</div>

<div class="card blue">

<h2>
<?php echo $total_tickets; ?>
</h2>

<p>Total Tickets</p>

<a class="btn"
href="admin-bookings.php">

View Bookings

</a>

</div>

<div class="card purple">

<h2>
<?php echo $confirmed; ?>
</h2>

<p>Confirmed Tickets</p>

<a class="btn"
href="admin-confirm.php">

View Confirm Ticket

</a>

</div>

<div class="card red">

<h2>
<?php echo $cancelled; ?>
</h2>

<p>Cancelled Tickets</p>

<a class="btn"
href="admin_ticket.php">

View Cancelled

</a>

</div>

<div class="card orange">

<h2>
<?php echo $buses; ?>
</h2>

<p>Total Buses</p>

<a class="btn"
href="buses-summary.php">

Bus Summary

</a>

</div>

<div class="card purple">

<h2>💬</h2>

<p>User Feedback</p>

<a class="btn"
href="admin-feedback.php">

View Feedback

</a>

</div>
<div class="card purple">

<h2>💵</h2>

<p>Total Payment</p>

<a class="btn"
href="admin-payment.php">

View payment

</a>

</div>
</div>

</div>

</body>
</html>