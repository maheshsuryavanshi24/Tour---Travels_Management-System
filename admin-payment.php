<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| PAYMENT REPORT QUERY
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn,"
SELECT
bus_bookings.id,
bus_bookings.seats,
bus_bookings.total_amount,
bus_bookings.payment_status,
bus_bookings.booking_status,
bus_bookings.booking_date,

users.name,
users.mobile,

packages.title

FROM bus_bookings
LEFT JOIN users
ON bus_bookings.user_id = users.id

LEFT JOIN packages
ON bus_bookings.package_id = packages.id

ORDER BY bus_bookings.id DESC
");

/*
|--------------------------------------------------------------------------
| TOTAL PAYMENT
|--------------------------------------------------------------------------
*/

$totalQuery = mysqli_query($conn,"
SELECT SUM(total_amount) AS total_payment
FROM bus_bookings
WHERE payment_status='Paid'
");

$totalData = mysqli_fetch_assoc($totalQuery);

$total_payment = $totalData['total_payment'];

if(!$total_payment){
    $total_payment = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Payment Report</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

/* NAVBAR */

.navbar{
    background:#1e3c72;
    padding:15px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

.logo{
    color:#fff;
    font-size:24px;
    font-weight:bold;
}

.nav-links{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
}

.nav-links a{
    color:#fff;
    text-decoration:none;
    padding:10px 15px;
    border-radius:8px;
    transition:0.3s;
}

.nav-links a:hover{
    background:rgba(255,255,255,0.15);
}

/* CONTAINER */

.container{
    width:95%;
    max-width:1400px;
    margin:30px auto;
}

/* SUMMARY CARD */

.summary-card{
    background:#fff;
    padding:25px;
    border-radius:18px;
    margin-bottom:25px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    position:relative;
    overflow:hidden;
}

.summary-card::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:5px;
    background:linear-gradient(90deg,#1e3c72,#2a5298);
}

.summary-title{
    color:#1e3c72;
    margin-bottom:15px;
    font-size:30px;
}

.total-payment{
    font-size:38px;
    color:#28a745;
    font-weight:bold;
}

/* TABLE */

.table-box{
    background:#fff;
    border-radius:18px;
    padding:25px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    overflow:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:1100px;
}

table th{
    background:#1e3c72;
    color:#fff;
    padding:15px;
    text-align:left;
    font-size:15px;
}

table td{
    padding:14px;
    border-bottom:1px solid #eee;
    color:#444;
}

table tr:hover{
    background:#f9fbfd;
}

/* STATUS */

.paid{
    background:#d4edda;
    color:#155724;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:bold;
}

.pending{
    background:#fff3cd;
    color:#856404;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:bold;
}

.cancelled{
    background:#f8d7da;
    color:#721c24;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:bold;
}

/* NO DATA */

.no-data{
    text-align:center;
    padding:20px;
    color:#777;
    font-size:18px;
}

/* RESPONSIVE */

@media(max-width:768px){

    .navbar{
        flex-direction:column;
        gap:15px;
        align-items:flex-start;
    }

    .summary-title{
        font-size:24px;
    }

    .total-payment{
        font-size:30px;
    }

    .table-box{
        padding:15px;
    }
}

@media(max-width:480px){

    .container{
        width:100%;
        padding:10px;
    }

    .summary-card,
    .table-box{
        padding:18px;
    }

    .summary-title{
        font-size:22px;
    }

    .total-payment{
        font-size:26px;
    }
}

</style>

</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        <i class="fa-solid fa-money-bill-wave"></i>
        Payment Report
    </div>

    <div class="nav-links">

        <a href="admin-dashboard.php">
            Dashboard
        </a>

        <a href="admin-bookings.php">
            Bookings
        </a>

        <a href="admin-packages.php">
            Packages
        </a>

        <a href="logout.php">
            Logout
        </a>

    </div>

</div>

<div class="container">

    <!-- TOTAL PAYMENT -->

    <div class="summary-card">

        <h2 class="summary-title">
            Total Payment Received
        </h2>

        <div class="total-payment">

            ₹<?php echo number_format($total_payment); ?>

        </div>

    </div>

    <!-- PAYMENT TABLE -->

    <div class="table-box">

        <table>

            <tr>

                <th>ID</th>
                <th>User Name</th>
                <th>Mobile</th>
                <th>Package</th>
                <th>Seats</th>
                <th>Amount</th>
                <th>Payment Status</th>
                <th>Booking Status</th>
                <th>Booking Date</th>

            </tr>

            <?php

            if(mysqli_num_rows($query) > 0){

                while($row = mysqli_fetch_assoc($query)){
            ?>

            <tr>

                <td>
                    <?php echo $row['id']; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['name'] ?? 'N/A'); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['mobile'] ?? 'N/A'); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['title'] ?? 'N/A'); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['seats']); ?>
                </td>

                <td>
                    ₹<?php echo number_format($row['total_amount']); ?>
                </td>

                <td>

                    <span class="<?php echo strtolower($row['payment_status']); ?>">

                        <?php echo $row['payment_status']; ?>

                    </span>

                </td>

                <td>

                    <span class="<?php echo strtolower($row['booking_status']); ?>">

                        <?php echo $row['booking_status']; ?>

                    </span>

                </td>

                <td>
                    <?php echo $row['booking_date']; ?>
                </td>

            </tr>

            <?php
                }

            } else {
            ?>

            <tr>
                <td colspan="9" class="no-data">
                    No Payment Records Found
                </td>
            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>