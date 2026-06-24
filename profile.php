<?php
session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$message = "";

/* UPDATE PROFILE */
if(isset($_POST['update_profile'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    $update = "UPDATE users SET name='$name', email='$email', mobile='$mobile'
               WHERE id='$user_id'";

    if(mysqli_query($conn, $update)){
        $_SESSION['user_name'] = $name;
        $message = "Profile Updated Successfully!";
    }
}


if(isset($_POST['change_password'])){

    $old_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    $check = mysqli_query($conn,
        "SELECT * FROM users WHERE id='$user_id' AND password='$old_password'"
    );

    if(mysqli_num_rows($check) == 0){
        $message = "Old Password Incorrect!";
    }else{

        if($new_password != $confirm_password){
            $message = "Password Not Match!";
        }else{

            mysqli_query($conn,
                "UPDATE users SET password='$new_password' WHERE id='$user_id'"
            );

            $message = "Password Changed Successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile</title>

<style>


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#eef3f8;
    padding:20px;
}


.container{
    width:100%;
    max-width:550px;
    margin:auto;
}


.card{
    background:#fff;
    padding:25px;
    border-radius:14px;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
    margin-bottom:20px;
}


h2{
    text-align:center;
    color:#1e3c72;
    margin-bottom:15px;
}


input{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:1px solid #ccc;
    border-radius:8px;
    outline:none;
}

input:focus{
    border-color:#009688;
}


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


.message{
    background:#e0f2f1;
    color:#00695c;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
    font-size:14px;
}


@media(max-width:768px){
    body{
        padding:10px;
    }

    .card{
        padding:20px;
    }
}

@media(max-width:480px){

    h2{
        font-size:18px;
    }

    button{
        font-size:15px;
    }
}

</style>

</head>

<body>

<div class="container">

<?php if($message != ""){ ?>
<div class="message">
    <?php echo $message; ?>
</div>
<?php } ?>


<div class="card">

<h2>Update Profile</h2>

<form method="POST">

<input type="text" name="name"
value="<?php echo htmlspecialchars($user['name']); ?>"
placeholder="Name" required>

<input type="email" name="email"
value="<?php echo htmlspecialchars($user['email']); ?>"
placeholder="Email" required>

<input type="text" name="mobile"
value="<?php echo htmlspecialchars($user['mobile']); ?>"
placeholder="Mobile" required>

<button type="submit" name="update_profile">
Update Profile
</button>

</form>

</div>


<div class="card">

<h2>Change Password</h2>

<form method="POST">

<input type="password" name="old_password"
placeholder="Old Password" required>

<input type="password" name="new_password"
placeholder="New Password" required>

<input type="password" name="confirm_password"
placeholder="Confirm Password" required>

<button type="submit" name="change_password">
Change Password
</button>

</form>

</div>

</div>

</body>
</html>