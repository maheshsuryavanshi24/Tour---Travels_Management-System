<?php
require_once 'config.php';

$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';
$bus_id = $_GET['bus_id'] ?? '';
$package_id = $_GET['package_id'] ?? '';

$sql = "
SELECT
bus_bookings.*,
buses.bus_name,
tours.tour_name
FROM bus_bookings
LEFT JOIN buses ON buses.id = bus_bookings.bus_id
LEFT JOIN tours ON tours.id = bus_bookings.package_id
WHERE payment_status='Paid'
";

if(!empty($from_date) && !empty($to_date))
{
    $sql .= " AND journey_date BETWEEN '$from_date' AND '$to_date'";
}

if(!empty($bus_id))
{
    $sql .= " AND bus_bookings.bus_id='$bus_id'";
}

if(!empty($package_id))
{
    $sql .= " AND bus_bookings.package_id='$package_id'";
}

$sql .= " ORDER BY bus_bookings.id DESC";

$result = mysqli_query($conn,$sql);

$buses = mysqli_query($conn,"SELECT id, bus_name FROM buses");
$packages = mysqli_query($conn,"SELECT id, tour_name FROM tours");

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment Report</title>

<style>

body{
    font-family:Arial, sans-serif;
    background:#f4f6f9;
    margin:0;
    padding:20px;
}

.container{
    max-width:1300px;
    margin:auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    color:#1e3c72;
    margin-bottom:25px;
}

.filter-box{
    background:#f8f9fa;
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    align-items:center;
}

.filter-box label{
    font-weight:bold;
}

input[type="date"],
select{
    padding:10px;
    border:1px solid #ccc;
    border-radius:5px;
    min-width:180px;
}

button{
    padding:10px 20px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-weight:bold;
}

.btn-filter{
    background:#007bff;
    color:white;
}

.btn-filter:hover{
    background:#0056b3;
}

.btn-print{
    background:#28a745;
    color:white;
}

.btn-print:hover{
    background:#218838;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

table th{
    background:#1e3c72;
    color:white;
    padding:12px;
    text-align:center;
}

table td{
    padding:10px;
    border:1px solid #ddd;
    text-align:center;
}

table tr:nth-child(even){
    background:#f9f9f9;
}

table tr:hover{
    background:#eef4ff;
}

.total-row{
    background:#d4edda !important;
    font-weight:bold;
    font-size:16px;
}

@media print{

    .no-print{
        display:none;
    }

    body{
        background:white;
        padding:0;
    }

    .container{
        box-shadow:none;
    }
}

@media(max-width:768px){

    .filter-box{
        flex-direction:column;
        align-items:stretch;
    }

    input[type="date"],
    select,
    button{
        width:100%;
    }

    table{
        font-size:13px;
    }
}

</style>

</head>

<body>

<div class="container">

<h2>Payment Report</h2>

<div class="no-print">

<form method="GET" class="filter-box">

<label>From Date</label>
<input type="date" name="from_date" value="<?= $from_date ?>">

<label>To Date</label>
<input type="date" name="to_date" value="<?= $to_date ?>">

<label>Bus</label>
<select name="bus_id">

<option value="">All Buses</option>

<?php while($bus=mysqli_fetch_assoc($buses)){ ?>

<option value="<?= $bus['id']; ?>"
<?= ($bus_id==$bus['id']) ? 'selected' : ''; ?>>

<?= $bus['bus_name']; ?>

</option>

<?php } ?>

</select>

<label>Package</label>
<select name="package_id">

<option value="">All Packages</option>

<?php while($pkg=mysqli_fetch_assoc($packages)){ ?>

<option value="<?= $pkg['id']; ?>"
<?= ($package_id==$pkg['id']) ? 'selected' : ''; ?>>

<?= $pkg['tour_name']; ?>

</option>

<?php } ?>

</select>

<button type="submit" class="btn-filter">
Filter Report
</button>

<button type="button"
onclick="window.print()"
class="btn-print">
Print / Save PDF
</button>

</form>

</div>

<table>

<tr>
    <th>ID</th>
    <th>Bus Name</th>
    <th>Package Name</th>
    <th>Journey Date</th>
    <th>Seats</th>
    <th>Amount</th>
    <th>Payment Status</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){

$total += $row['total_amount'];
?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['bus_name']; ?></td>

<td><?= $row['tour_name']; ?></td>

<td><?= $row['journey_date']; ?></td>

<td><?= $row['seats']; ?></td>

<td>₹<?= $row['total_amount']; ?></td>

<td><?= $row['payment_status']; ?></td>

</tr>

<?php } ?>

<tr class="total-row">

<td colspan="5">
Total Revenue
</td>

<td colspan="2">
₹<?= $total; ?>
</td>

</tr>

</table>

</div>

</body>
</html>