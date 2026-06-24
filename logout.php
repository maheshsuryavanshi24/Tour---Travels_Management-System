<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Logout</title>

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
    height:100vh;
    padding:20px;
}


.box{
    background:#fff;
    padding:35px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    text-align:center;
    max-width:400px;
    width:100%;
}

.box h2{
    color:#1e3c72;
    margin-bottom:10px;
}

.box p{
    color:#555;
    margin-bottom:20px;
}


.btn{
    display:inline-block;
    background:#009688;
    color:#fff;
    padding:12px 18px;
    border-radius:8px;
    text-decoration:none;
    transition:0.3s;
}

.btn:hover{
    background:#00796b;
}


@media(max-width:480px){
    .box{
        padding:25px;
    }

    .box h2{
        font-size:20px;
    }
}

</style>

</head>

<body>

<div class="box">
<div>
    <h2>Logged Out Successfully</h2>

    <p>You have been safely logged out.</p>

    <a href="login.php" class="btn">
        Go to Login
    </a>
</div>
<div class="">
<br>
          <a href="index.php" class="btn">
        Home
    </a>

</div>

</div>

<br>
<br>

</body>
</html>