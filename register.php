<?php

include 'db.php';

$message = "";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $check = mysqli_query($conn,
        "SELECT * FROM users WHERE email='$email'"
    );

    if(mysqli_num_rows($check) > 0){
        $message = "Email Already Exists";
    }else{

        $query = "INSERT INTO users(name,mobile,email,password)
                  VALUES('$name','$mobile','$email','$password')";

        mysqli_query($conn,$query);

        $message = "Registration Successful";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>User Register</title>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#eef3f8;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
}

/* BOX */
.booking-section{
    width:100%;
    max-width:420px;
    background:#fff;
    padding:30px;
    border-radius:16px;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
}

/* TITLE */
h2{
    text-align:center;
    color:#1e3c72;
    margin-bottom:20px;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    margin-top:12px;
    border:1px solid #ccc;
    border-radius:8px;
    outline:none;
    transition:0.3s;
}

input:focus{
    border-color:#009688;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    margin-top:15px;
    background:#009688;
    color:#fff;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
    transition:0.3s;
}

button:hover{
    background:#00796b;
}

/* MESSAGE */
p{
    margin-top:12px;
    text-align:center;
    color:#d32f2f;
    font-size:14px;
}

/* LINK */
a{
    display:block;
    margin-top:15px;
    text-align:center;
    color:#1e3c72;
    text-decoration:none;
    font-weight:600;
}

a:hover{
    text-decoration:underline;
}

/* RESPONSIVE */
@media(max-width:480px){

    .booking-section{
        padding:20px;
    }

    h2{
        font-size:20px;
    }

    input, button{
        font-size:15px;
    }
}

</style>

</head>

<body>

<div class="booking-section">

    <h2>User Registration</h2>

    <form method="POST">

        <input type="text" name="name" placeholder="Enter Name" required>

        <input type="email" name="email" placeholder="Enter Email" required>

        <input type="text" name="mobile" placeholder="Enter Mobile Number" required>

        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit" name="register">
            Register
        </button>

    </form>

    <p><?php echo $message; ?></p>

    <a href="login.php">
        Already have an account? Login
    </a>

</div>

</body>
</html>