<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}

$query = "SELECT bookings.*, users.name, packages.title
FROM bookings
JOIN users ON bookings.user_id = users.id
JOIN packages ON bookings.package_id = packages.id";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>All Bookings</title>

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

/* Container */

.container{
    width:100%;
    max-width:1100px;
    margin:auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

.heading{
    text-align:center;
    margin-bottom:25px;
    color:#333;
}



.table-responsive{
    width:100%;
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:650px;
}

table th{
    background:#009688;
    color:white;
    padding:14px;
    text-align:left;
}

table td{
    padding:12px;
    border-bottom:1px solid #ddd;
    color:#333;
}

table tr:hover{
    background:#f1f1f1;
}



.status{
    padding:6px 12px;
    border-radius:5px;
    font-size:14px;
    font-weight:bold;
    background:#e0f7f5;
    color:#009688;
    display:inline-block;
}


@media(max-width:768px){

    .container{
        padding:15px;
    }

    .heading{
        font-size:24px;
    }

    table th,
    table td{
        font-size:14px;
        padding:10px;
    }

}

@media(max-width:480px){

    body{
        padding:10px;
    }

    .container{
        padding:12px;
    }

    .heading{
        font-size:20px;
    }

}

</style>
</head>
<body>

<div class="container">

    <h2 class="heading">All Bookings</h2>

    <div class="table-responsive">

        <table>

            <tr>
                <th>User</th>
                <th>Package</th>
                <th>Seat</th>
                <th>Status</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>

            <tr>

                <td><?php echo $row['name']; ?></td>

                <td><?php echo $row['title']; ?></td>

                <td><?php echo $row['seat_number']; ?></td>

                <td>
                    <span class="status">
                        <?php echo $row['status']; ?>
                    </span>
                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>