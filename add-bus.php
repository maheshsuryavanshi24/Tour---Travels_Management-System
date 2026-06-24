<?php
include 'config.php';

if(isset($_POST['add_bus']))
{
    $bus_name = $_POST['bus_name'];
    $bus_number = $_POST['bus_number'];
    $bus_type = $_POST['bus_type'];
    $seat_type = $_POST['seat_type'];
    $total_seats = $_POST['total_seats'];
    $from_city = $_POST['from_city'];
    $to_city = $_POST['to_city'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = $_POST['price'];

    $query = "INSERT INTO buses
    (bus_name,bus_number,bus_type,seat_type,total_seats,from_city,to_city,departure_time,arrival_time,price)
    VALUES
    ('$bus_name','$bus_number','$bus_type','$seat_type','$total_seats','$from_city','$to_city','$departure_time','$arrival_time','$price')";

    mysqli_query($conn,$query);

    echo "<script>alert('Bus Added Successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Bus</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
}

.form-container{
    width:100%;
    max-width:500px;
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.form-container h2{
    text-align:center;
    margin-bottom:25px;
    color:#333;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
    color:#555;
}

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:5px;
    font-size:15px;
}

.form-control:focus{
    border-color:#007bff;
    outline:none;
}

.row{
    display:flex;
    gap:15px;
}

.col{
    flex:1;
}

.btn{
    width:100%;
    padding:14px;
    background:#007bff;
    color:#fff;
    border:none;
    border-radius:5px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    background:#0056b3;
}



@media(max-width:600px){

    .row{
        flex-direction:column;
        gap:0;
    }

    .form-container{
        padding:20px;
    }

    .btn{
        padding:12px;
    }
}

</style>
</head>
<body>

<div class="form-container">

    <h2>Add New Bus</h2>

    <form method="POST">

        <div class="form-group">
            <label>Bus Name</label>
            <input type="text" name="bus_name" class="form-control" placeholder="Bus Name" required>
        </div>

        <div class="form-group">
            <label>Bus Number</label>
            <input type="text" name="bus_number" class="form-control" placeholder="Bus Number" required>
        </div>

        <div class="row">

            <div class="col form-group">
                <label>Bus Type</label>
                <select name="bus_type" class="form-control">
                    <option>AC</option>
                    <option>Non-AC</option>
                </select>
            </div>

            <div class="col form-group">
                <label>Seat Type</label>
                <select name="seat_type" class="form-control">
                    <option>Sleeper</option>
                    <option>Seater</option>
                </select>
            </div>

        </div>

        <div class="form-group">
            <label>Total Seats</label>
            <input type="number" name="total_seats" class="form-control" placeholder="Total Seats">
        </div>

        <div class="row">

            <div class="col form-group">
                <label>From City</label>
                <input type="text" name="from_city" class="form-control" placeholder="From City">
            </div>

            <div class="col form-group">
                <label>To City</label>
                <input type="text" name="to_city" class="form-control" placeholder="To City">
            </div>

        </div>

        <div class="row">

            <div class="col form-group">
                <label>Departure Time</label>
                <input type="time" name="departure_time" class="form-control">
            </div>

            <div class="col form-group">
                <label>Arrival Time</label>
                <input type="time" name="arrival_time" class="form-control">
            </div>

        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" class="form-control" placeholder="Price">
        </div>

        <button type="submit" name="add_bus" class="btn">
            Add Bus
        </button>

    </form>

</div>

</body>
</html>