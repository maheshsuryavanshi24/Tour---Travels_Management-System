<?php
session_start();

include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}



if(!isset($_GET['id'])){
    die("Package ID Missing");
}

$id = intval($_GET['id']);


$result = mysqli_query(
$conn,
"SELECT * FROM packages WHERE id='$id'"
);

$package = mysqli_fetch_assoc($result);

if(!$package){
    die("Package Not Found");
}

$message = "";

/*
CREATE uploads FOLDER
IF NOT EXISTS
*/

if(!file_exists("uploads")){
    mkdir("uploads",0777,true);
}



if(isset($_POST['update_package'])){

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

    $total_seats =
    mysqli_real_escape_string(
    $conn,
    $_POST['total_seats']
    );

    $description =
    mysqli_real_escape_string(
    $conn,
    $_POST['description']
    );

   

    if(!empty($_FILES['image']['name'])){

        $image_name =
        $_FILES['image']['name'];

        $tmp_name =
        $_FILES['image']['tmp_name'];

        /*
        UNIQUE IMAGE NAME
        */

        $new_image =
        time() . "_" . $image_name;

        $folder =
        "uploads/" . $new_image;

        /*
        MOVE IMAGE
        */

        move_uploaded_file(
        $tmp_name,
        $folder
        );

        /*
        SAVE ONLY IMAGE NAME
        */

        $image = $new_image;

    }else{

        /*
        KEEP OLD IMAGE
        */

        $image = $package['image'];
    }

   

    $update = "UPDATE packages SET

    title='$title',

    price='$price',

    total_seats='$total_seats',

    description='$description',

    image='$image'

    WHERE id='$id'";

    if(mysqli_query($conn,$update)){

        $message =
        "✅ Package Updated Successfully!";

        /*
        REFRESH PACKAGE DATA
        */

        $result = mysqli_query(
        $conn,
        "SELECT * FROM packages WHERE id='$id'"
        );

        $package =
        mysqli_fetch_assoc($result);

    }else{

        $message =
        "❌ Update Failed : "
        . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Package</title>

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
    margin-bottom:20px;
}



.message{
    text-align:center;
    font-weight:bold;
    margin-bottom:15px;
    color:green;
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



.preview{
    width:100%;
    height:220px;
    object-fit:cover;
    border-radius:10px;
    margin-top:15px;
}



button{

    width:100%;
    padding:14px;
    margin-top:20px;
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



@media(max-width:768px){

.container{
    margin:20px;
    padding:20px;
}

}

</style>

</head>

<body>

<div class="container">

<h2>
✏ Edit Package
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

value="<?php
echo htmlspecialchars(
$package['title']
);
?>"

required>

<input
type="number"
name="price"

value="<?php
echo htmlspecialchars(
$package['price']
);
?>"

required>

<input
type="number"
name="total_seats"

value="<?php
echo htmlspecialchars(
$package['total_seats']
?? 40
);
?>"

required>

<textarea
name="description"
required><?php

echo htmlspecialchars(
$package['description']
);

?></textarea>

<!-- CURRENT IMAGE -->

<img

class="preview"

src="uploads/<?php
echo htmlspecialchars(
$package['image']
);
?>"

alt="Package Image">

<!-- NEW IMAGE -->

<input
type="file"
name="image">

<button
type="submit"
name="update_package">

Update Package

</button>

</form>

</div>

</body>
</html>