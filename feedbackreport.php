<?php
require_once 'config.php';

$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';

$sql = "SELECT * FROM feedback";

if(!empty($from_date) && !empty($to_date))
{
    $sql .= " WHERE DATE(created_at)
              BETWEEN '$from_date' AND '$to_date'";
}

$sql .= " ORDER BY id DESC";

$query = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Feedback Report</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f4f6f9;
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
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    justify-content:flex-end;
    margin-bottom:20px;
}

input[type="date"]{
    padding:10px;
    border:1px solid #ccc;
    border-radius:5px;
}

.btn{
    padding:10px 20px;
    border:none;
    border-radius:5px;
    color:#fff;
    cursor:pointer;
    font-weight:bold;
}

.filter-btn{
    background:#007bff;
}

.filter-btn:hover{
    background:#0056b3;
}

.print-btn{
    background:#28a745;
}

.print-btn:hover{
    background:#218838;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#1e3c72;
    color:#fff;
    padding:12px;
    text-align:center;
}

table td{
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

table tr:nth-child(even){
    background:#f9f9f9;
}

table tr:hover{
    background:#eef4ff;
}

.rating{
    color:#ff9800;
    font-weight:bold;
}

@media print{

    .no-print{
        display:none;
    }

    body{
        background:#fff;
        padding:0;
    }

    .container{
        box-shadow:none;
    }
}

@media(max-width:768px){

    .filter-box{
        flex-direction:column;
    }

    .filter-box input,
    .filter-box button{
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

<h2>Customer Feedback Report</h2>

<div class="no-print">

<form method="GET" class="filter-box">

    <input type="date"
           name="from_date"
           value="<?= $from_date ?>">

    <input type="date"
           name="to_date"
           value="<?= $to_date ?>">

    <button type="submit"
            class="btn filter-btn">
        Filter Report
    </button>

    <button type="button"
            onclick="window.print()"
            class="btn print-btn">
        Print / Save PDF
    </button>

</form>

</div>

<table>

<tr>
    <th>ID</th>
    <th>Name</th>
   
    <th>Rating</th>
    <th>Feedback</th>
    <th>Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($query)){ ?>

<tr>

    <td><?= $row['id']; ?></td>

    <td><?= $row['name']; ?></td>

   

    <td class="rating">
        <?= $row['rating']; ?>/5
    </td>

    <td>
        <?= $row['message']; ?>
    </td>

    <td>
        <?= $row['created_at']; ?>
    </td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>