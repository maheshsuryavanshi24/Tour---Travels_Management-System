<?php
session_start();

include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}

$message = "";



if(!file_exists("uploads")){
    mkdir("uploads",0777,true);
}



if(isset($_POST['add_package'])){

    $title =
    mysqli_real_escape_string(
    $conn,
    $_POST['title']
    );

    $price =
    mysqli_real_escape_string(
    $conn,
    $_POST['price']
    );

    $description =
    mysqli_real_escape_string(
    $conn,
    $_POST['description']
    );

    $total_seats =
    mysqli_real_escape_string(
    $conn,
    $_POST['total_seats']
    );

   

    $image_name =
    $_FILES['image']['name'];

    $tmp_name =
    $_FILES['image']['tmp_name'];

    

    $new_image =
    time() . "_" . $image_name;

    $folder =
    "uploads/" . $new_image;

    

    if(move_uploaded_file($tmp_name,$folder)){

        $query = "INSERT INTO packages
        (
        title,
        description,
        price,
        image,
        total_seats
        )

        VALUES
        (
        '$title',
        '$description',
        '$price',
        '$new_image',
        '$total_seats'
        )";

        if(mysqli_query($conn,$query)){

            $message =
            "✅ Package Added Successfully!";

        }else{

            $message =
            "❌ Database Error : "
            . mysqli_error($conn);
        }

    }else{

        $message =
        "❌ Image Upload Failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Package</title>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<style>

body{
    margin:0;
    font-family:Arial;
    background:#eef3f8;
}



.container{
    max-width:550px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}



h2{
    text-align:center;
    color:#1e3c72;
    margin-bottom:25px;
}



input,
textarea{

    width:100%;
    padding:12px;
    margin-top:12px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:15px;
}

textarea{
    resize:none;
    height:120px;
}



button{

    width:100%;
    padding:14px;
    margin-top:18px;
    background:#009688;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#00796b;
}


.message{
    text-align:center;
    margin-bottom:15px;
    font-weight:bold;
}



@media(max-width:768px){

.container{
    margin:20px;
}

}

</style>

</head>

<body>

<div class="container">

<h2>
➕ Add New Package
</h2>

<?php if($message!=""){ ?>

<div class="message">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST"
enctype="multipart/form-data">

<input
type="text"
name="title"
placeholder="Package Title"
required>

<input
type="number"
name="price"
placeholder="Package Price"
required>

<input
type="number"
name="total_seats"
placeholder="Total Seats"
required>

<textarea
name="description"
placeholder="Package Description"
required></textarea>

<input
type="file"
name="image"
required>

<button
type="submit"
name="add_package">

Add Package

</button>

</form>

</div>

</body>
</html>