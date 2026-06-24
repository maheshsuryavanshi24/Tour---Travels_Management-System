<?php

include '../db.php';

$message = "";

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description'];

    $query = "INSERT INTO tours
    (name,price,image,description)
    VALUES
    ('$name','$price','$image','$description')";

    mysqli_query($conn,$query);

    $message = "Tour Added Successfully!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Tour</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:#f4f6f9;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .booking-section{
            width:100%;
            max-width:500px;
            background:#fff;
            padding:30px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        .booking-section h2{
            text-align:center;
            margin-bottom:25px;
            color:#333;
        }

        form{
            display:flex;
            flex-direction:column;
            gap:15px;
        }

        input,
        textarea{
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:6px;
            font-size:15px;
        }

        input:focus,
        textarea:focus{
            border-color:#007bff;
            outline:none;
        }

        textarea{
            min-height:120px;
            resize:vertical;
        }

        button{
            background:#007bff;
            color:white;
            border:none;
            padding:14px;
            font-size:16px;
            border-radius:6px;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#0056b3;
        }

        .message{
            margin-top:20px;
            text-align:center;
            color:green;
            font-size:16px;
            font-weight:bold;
        }

        /* Responsive */

        @media(max-width:600px){

            .booking-section{
                padding:20px;
            }

            h2{
                font-size:24px;
            }

            input,
            textarea,
            button{
                font-size:14px;
            }

        }

    </style>

</head>
<body>

<div class="booking-section">

    <h2>Add Tour Package</h2>

    <form method="POST">

        <input type="text"
        name="name"
        placeholder="Tour Name"
        required>

        <input type="text"
        name="price"
        placeholder="Tour Price"
        required>

        <input type="text"
        name="image"
        placeholder="Image URL"
        required>

        <textarea
        name="description"
        placeholder="Description"
        required></textarea>

        <button type="submit"
        name="submit">
            Add Tour
        </button>

    </form>

    <?php if($message != "") { ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
    <?php } ?>

</div>

</body>
</html>