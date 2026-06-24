<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}

$result = mysqli_query($conn,"SELECT name, mobile, email FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Users</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

/* GLOBAL */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#eef3f8;
    padding:20px;
}

/* CONTAINER */
.container{
    max-width:1000px;
    margin:auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:20px;
    color:#1e3c72;
}

/* TABLE */
.table-wrap{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:600px;
}

th{
    background:#009688;
    color:white;
    padding:12px;
    text-align:left;
}

td{
    padding:12px;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f5f5f5;
}

/* RESPONSIVE */
@media(max-width:768px){
    .container{
        padding:15px;
    }
}

@media(max-width:480px){
    body{
        padding:10px;
    }
}

</style>

</head>

<body>

<div class="container">

    <h2>Registered Users</h2>

    <div class="table-wrap">

        <table>

            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

            <tr>

                <td><?php echo $row['name']; ?></td>

                <td><?php echo $row['mobile']; ?></td>

                <td><?php echo $row['email']; ?></td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>