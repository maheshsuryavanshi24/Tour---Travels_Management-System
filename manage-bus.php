<?php
include 'config.php';

$result = mysqli_query($conn,"SELECT * FROM buses");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Buses</title>

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
    max-width:1100px;
    margin:auto;
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}


h2{
    text-align:center;
    margin-bottom:20px;
    color:#1e3c72;
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

th{
    background:#009688;
    color:#fff;
    padding:12px;
    text-align:left;
}

td{
    padding:12px;
    border-bottom:1px solid #ddd;
    color:#333;
}

tr:hover{
    background:#f1f1f1;
}


a{
    text-decoration:none;
    padding:6px 12px;
    border-radius:6px;
    font-size:14px;
    margin-right:5px;
    display:inline-block;
}

.edit{
    background:#1e3c72;
    color:#fff;
}

.delete{
    background:#dc3545;
    color:#fff;
}


.edit:hover{
    background:#16325c;
}

.delete:hover{
    background:#b02a37;
}


@media(max-width:768px){

    .container{
        padding:15px;
    }

    table{
        min-width:600px;
    }

    td, th{
        font-size:14px;
        padding:10px;
    }
}

@media(max-width:480px){

    body{
        padding:10px;
    }

    table{
        min-width:500px;
    }
}

</style>

</head>

<body>

<div class="container">

    <h2>Manage Buses</h2>

    <div class="table-responsive">

        <table>

            <tr>
                <th>ID</th>
                <th>Bus Name</th>
                <th>Route</th>
                <th>Price</th>
                <th>Action</th>
            </tr>

            <?php while($row=mysqli_fetch_assoc($result)) { ?>

            <tr>

                <td><?= $row['id']; ?></td>

                <td><?= $row['bus_name']; ?></td>

                <td><?= $row['from_city']; ?> → <?= $row['to_city']; ?></td>

                <td>₹<?= $row['price']; ?></td>

                <td>
                    <a class="edit" href="edit-bus.php?id=<?= $row['id']; ?>">
                        Edit
                    </a>

                    <a class="delete" href="delete-bus.php?id=<?= $row['id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this bus?')">
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