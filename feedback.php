<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$message = "";

if(isset($_POST['submit'])){

    $rating = $_POST['rating'];
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    mysqli_query($conn,"
        INSERT INTO feedback (user_id, name, rating, message)
        VALUES ('$user_id','$user_name','$rating','$feedback')
    ");

    $message = "Feedback submitted successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>User Feedback</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f4f6f9;
}


.container{
    max-width:500px;
    margin:50px auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}


h2{
    text-align:center;
    color:#009688;
    margin-bottom:20px;
}


select, textarea{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:15px;
}

textarea{
    height:120px;
    resize:none;
}


button{
    width:100%;
    padding:12px;
    margin-top:15px;
    background:#009688;
    color:white;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#00796b;
}


.msg{
    text-align:center;
    background:#e0f2f1;
    color:#00695c;
    padding:10px;
    border-radius:6px;
    margin-bottom:15px;
}


@media(max-width:600px){
    .container{
        margin:20px;
        padding:20px;
    }
}

</style>

</head>

<body>

<div class="container">

    <h2>Give Your Feedback</h2>

    <?php if($message != ""){ ?>
        <div class="msg">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <select name="rating" required>
            <option value="">Select Rating</option>
            <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
            <option value="4">⭐⭐⭐⭐ Good</option>
            <option value="3">⭐⭐⭐ Average</option>
            <option value="2">⭐⭐ Poor</option>
            <option value="1">⭐ Very Bad</option>
        </select>

        <textarea name="feedback" placeholder="Write your feedback..." required></textarea>

        <button type="submit" name="submit">
            Submit Feedback
        </button>

    </form>

</div>

</body>
</html>