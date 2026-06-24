<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}


if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    mysqli_query($conn,"DELETE FROM feedback WHERE id='$id'");

    header("Location: admin-feedback.php");
    exit();
}


$result = mysqli_query($conn,"
    SELECT * FROM feedback
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Feedback</title>

<style>


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f4f6f9;
    padding:20px;
}


.container{
    max-width:1000px;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}


h2{
    text-align:center;
    color:#009688;
    margin-bottom:20px;
}


.table-responsive{
    overflow-x:auto;
}


table{
    width:100%;
    border-collapse:collapse;
    min-width:700px;
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
    background:#f1f1f1;
}


.rating{
    color:#ff9800;
    font-weight:bold;
}


.delete-btn{
    background:#dc3545;
    color:white;
    padding:8px 12px;
    border-radius:5px;
    text-decoration:none;
    font-size:14px;
}

.delete-btn:hover{
    background:#b02a37;
}


@media(max-width:768px){
    .container{
        padding:15px;
    }

    th,td{
        font-size:14px;
    }
}

</style>

</head>

<body>

<div class="container">

    <h2>User Feedback</h2>

    <div class="table-responsive">

        <table>

            <tr>
                <th>User Name</th>
                <th>Rating</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>

            <tr>

                <td><?php echo $row['name']; ?></td>

                <td class="rating">
                    <?php echo str_repeat("⭐", $row['rating']); ?>
                </td>

                <td><?php echo $row['message']; ?></td>

                <td><?php echo $row['created_at']; ?></td>

                <td>
                    <a class="delete-btn"
                       href="?delete=<?php echo $row['id']; ?>"
                       onclick="return confirm('Delete this feedback?')">
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