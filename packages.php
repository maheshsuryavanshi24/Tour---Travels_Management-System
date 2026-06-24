<?php
include 'db.php';
include 'header.php';

$query = "SELECT * FROM packages";
$result = mysqli_query($conn, $query);

if(!$result){
    die("Database Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tour Packages</title>

<style>


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#eef3f8;
}


.container{
    width:90%;
    margin:auto;
    padding:30px 0;
}

/* TITLE */
h1{
    text-align:center;
    color:#1e3c72;
    margin-bottom:20px;
}

/* GRID */
.packages{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));
    gap:20px;
    margin-top:20px;
}

/* CARD */
.card{
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:0.3s;
    text-align:center;
}

.card:hover{
    transform:translateY(-5px);
}

/* IMAGE */
.card img{
    width:100%;
    height:200px;
    object-fit:cover;
}

/* CONTENT */
.card h3{
    margin:12px 0;
    color:#1e3c72;
}

.card p{
    font-size:14px;
    color:#555;
    padding:0 12px;
    height:60px;
    overflow:hidden;
}

.card h4{
    margin:10px 0;
    color:#28a745;
    font-size:18px;
}

/* BUTTON */
.btn{
    display:inline-block;
    margin:15px 0 20px;
    padding:10px 18px;
    background:#009688;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
}

.btn:hover{
    background:#00796b;
}

/* RESPONSIVE */
@media(max-width:768px){

    .container{
        width:95%;
    }

    .card img{
        height:180px;
    }

    h1{
        font-size:24px;
    }
}

@media(max-width:480px){

    .card p{
        font-size:13px;
    }

    .btn{
        width:80%;
    }
}

</style>

</head>

<body>

<div class="container">

    <h1>Our Tour Packages</h1>

    <div class="packages">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="card">

            <img src="images/<?php echo $row['image']; ?>" alt="Package Image">

            <h3><?php echo $row['title']; ?></h3>

            <p><?php echo substr($row['description'],0,90); ?>...</p>

            <h4>₹<?php echo $row['price']; ?></h4>

            <a class="btn"
               href="seat-selection.php?id=<?php echo $row['id']; ?>">
               Book Now
            </a>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>

<?php include 'footer.php'; ?>