<?php

session_start();
include 'db.php';

$message = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users
              WHERE email='$email'
              AND password='$password'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        echo "
        <script>
            alert('Login Successful');
            window.location='dashboard.php';
        </script>
        ";

    }else{

        $message = "Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>User Login</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
    background:
    linear-gradient(120deg,#84fab0,#8fd3f4);
}

.login-container{
    width:100%;
    max-width:420px;
    background:#fff;
    border-radius:20px;
    padding:40px 30px;
    box-shadow:
    0 15px 40px rgba(0,0,0,0.2);
    animation:fadeIn 0.5s ease;
}

.login-container h2{
    text-align:center;
    color:#1e3c72;
    margin-bottom:30px;
    font-size:34px;
    font-weight:bold;
}

.input-box{
    margin-bottom:20px;
}

.input-box input{
    width:100%;
    padding:15px;
    border:2px solid #e5e7eb;
    border-radius:12px;
    font-size:16px;
    transition:0.3s;
    background:#f8fafc;
}

.input-box input:focus{
    border-color:#667eea;
    outline:none;
    background:#fff;
    box-shadow:
    0 0 10px rgba(102,126,234,0.3);
}

.btn-group{
    display:flex;
    gap:15px;
    margin-top:10px;
}

.login-btn{
    flex:1;
    padding:15px;
    border:none;
    border-radius:12px;
    background:
    linear-gradient(135deg,#667eea,#764ba2);
    color:#fff;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.login-btn:hover{
    transform:translateY(-2px);
    box-shadow:
    0 10px 20px rgba(102,126,234,0.3);
}

.back-btn{
    flex:1;
    text-align:center;
    padding:15px;
    border-radius:12px;
    background:#6c757d;
    color:#fff;
    text-decoration:none;
    font-size:18px;
    font-weight:bold;
    transition:0.3s;
}

.back-btn:hover{
    background:#545b62;
    transform:translateY(-2px);
}

.message{
    margin-top:18px;
    text-align:center;
    color:#dc3545;
    font-weight:bold;
    font-size:15px;
}

.links{
    margin-top:25px;
    display:flex;
    flex-direction:column;
    gap:12px;
}

.links a{
    text-decoration:none;
    text-align:center;
    padding:13px;
    border-radius:10px;
    font-weight:600;
    transition:0.3s;
}

.register-link{
    background:#28a745;
    color:#fff;
}

.register-link:hover{
    background:#218838;
}

.admin-link{
    background:#343a40;
    color:#fff;
}

.admin-link:hover{
    background:#23272b;
}

@media(max-width:480px){

    .login-container{
        padding:30px 20px;
    }

    .login-container h2{
        font-size:28px;
    }

    .btn-group{
        flex-direction:column;
    }
}

@keyframes fadeIn{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

</style>

</head>

<body>

<div class="login-container">

    <h2>User Login</h2>

    <form method="POST">

        <div class="input-box">

            <input
            type="email"
            name="email"
            placeholder="Enter Email"
            required>

        </div>

        <div class="input-box">

            <input
            type="password"
            name="password"
            placeholder="Enter Password"
            required>

        </div>

        <div class="btn-group">

            <button
            type="submit"
            name="login"
            class="login-btn">

            Login

            </button>

            <a href="index.php"
            class="back-btn">

            ← Back

            </a>

        </div>

    </form>

    <div class="message">
        <?php echo $message; ?>
    </div>

    <div class="links">

        <a href="register.php"
        class="register-link">

        Create New Account

        </a>

        <a href="admin-login.php"
        class="admin-link">

        Go Admin Login

        </a>

    </div>

</div>

</body>
</html>