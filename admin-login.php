<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin
              WHERE username='$username'
              AND password='$password'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){

        $admin = mysqli_fetch_assoc($result);

        $_SESSION['admin_id'] = $admin['id'];

        echo "
        <script>
            alert('Login Successful');
            window.location='admin-dashboard.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Invalid Username or Password!');
            window.location='admin-login.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login</title>

<link rel="stylesheet" href="style.css">

<style>

body{
    margin:0;
    padding:0;
    background:#f1f1f1;
    font-family:Arial, sans-serif;
}

.booking-section{
    width:400px;
    background:#fff;
    margin:80px auto;
    padding:40px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.booking-section h2{
    text-align:center;
    margin-bottom:30px;
    color:#1e3c72;
    font-size:36px;
}

.booking-section input{
    width:100%;
    padding:15px;
    margin-bottom:20px;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:16px;
    background:#f5f7fa;
}

.btn-group{
    display:flex;
    gap:15px;
}

.login-btn{
    flex:1;
    padding:14px;
    border:none;
    background:#007bff;
    color:#fff;
    font-size:18px;
    border-radius:6px;
    cursor:pointer;
    transition:0.3s;
}

.login-btn:hover{
    background:#0056b3;
}

.back-btn{
    flex:1;
    padding:14px;
    background:#6c757d;
    color:#fff;
    text-decoration:none;
    text-align:center;
    font-size:18px;
    border-radius:6px;
    transition:0.3s;
}

.back-btn:hover{
    background:#545b62;
}

@media(max-width:500px){

    .booking-section{
        width:90%;
        padding:25px;
    }

    .btn-group{
        flex-direction:column;
    }
}

</style>

</head>

<body>

<form method="POST">

<div class="booking-section">

    <h2>Admin Login</h2>

    <input
    type="text"
    name="username"
    placeholder="Username"
    required>

    <input
    type="password"
    name="password"
    placeholder="Password"
    required>

    <div class="btn-group">

        <button
        type="submit"
        name="login"
        class="login-btn">

        Login

        </button>

        <a href="index.php" class="back-btn">

        ← Back

        </a>

    </div>

</div>

</form>

</body>
</html>