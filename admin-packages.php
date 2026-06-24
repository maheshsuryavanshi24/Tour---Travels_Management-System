<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}

if(isset($_GET['delete'])){

    $id = intval($_GET['delete']);

    mysqli_query($conn,"DELETE FROM packages WHERE id=$id");

    header("Location: admin-packages.php");
    exit();
}

$result = mysqli_query($conn,"SELECT * FROM packages");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Packages</title>

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
    width:100%;
    max-width:1100px;
    margin:auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
    margin-bottom:25px;
}

.top-bar h2{
    color:#333;
}

.add-btn{
    background:#009688;
    color:white;
    text-decoration:none;
    padding:10px 18px;
    border-radius:6px;
    font-weight:bold;
}

.add-btn:hover{
    background:#00796b;
}

.table-responsive{
    width:100%;
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:700px;
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
}

table tr:hover{
    background:#f1f1f1;
}


.action a{
    display:inline-block;
    margin-right:8px;
    padding:7px 12px;
    border-radius:5px;
    text-decoration:none;
    font-size:14px;
}

.edit-btn{
    background:#007bff;
    color:#fff;
}

.edit-btn:hover{
    background:#0056b3;
}

.delete-btn{
    background:#dc3545;
    color:#fff;
}

.delete-btn:hover{
    background:#b02a37;
}


@media(max-width:768px){

    .top-bar{
        flex-direction:column;
        align-items:flex-start;
    }

    table th, table td{
        font-size:14px;
        padding:10px;
    }
}

</style>

</head>

<body>

<div class="container">

    <div class="top-bar">

        <h2>Manage Packages</h2>

        <a href="add-package.php" class="add-btn">
            + Add New Package
        </a>

    </div>

    <div class="table-responsive">

        <table>

            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Price</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><?php echo $row['title']; ?></td>

                <td>₹<?php echo $row['price']; ?></td>

                <td class="action">

                    <!-- EDIT -->
                    <a href="edit-package.php?id=<?php echo $row['id']; ?>"
                       class="edit-btn">
                        Edit
                    </a>

                    <!-- DELETE -->
                    <a href="?delete=<?php echo $row['id']; ?>"
                       class="delete-btn"
                       onclick="return confirm('Are you sure?')">
                        Delete
                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>