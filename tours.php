<?php
session_start();

include 'db.php';

/*
GET ALL TOUR PACKAGES
*/

$query = "SELECT * FROM packages ORDER BY id DESC";

$result = mysqli_query($conn,$query);

if(!$result){
    die("Database Error : " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Tour Packages</title>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f4f7fb;
}

/* HEADER SPACE */

.top-title{
    width:100%;
    background:#009688;
    color:white;
    text-align:center;
    padding:40px 20px;
}

.top-title h1{
    font-size:40px;
    margin-bottom:10px;
}

.top-title p{
    font-size:18px;
}

/* CONTAINER */

.container{
    width:92%;
    max-width:1300px;
    margin:40px auto;
}

/* GRID */

.tour-grid{
    display:grid;
    grid-template-columns:
    repeat(auto-fit,minmax(280px,1fr));

    gap:25px;
}

/* CARD */

.card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-6px);
}

/* IMAGE */

.card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

/* CONTENT */

.card-content{
    padding:20px;
}

.card-content h3{
    color:#222;
    margin-bottom:12px;
    font-size:24px;
}

.description{
    color:#555;
    line-height:1.6;
    font-size:15px;
    margin-bottom:15px;
    min-height:70px;
}

/* DETAILS */

.details{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.price{
    color:#009688;
    font-size:24px;
    font-weight:bold;
}

.days{
    background:#e0f2f1;
    color:#00796b;
    padding:6px 10px;
    border-radius:20px;
    font-size:13px;
}

/* BUTTONS */

.btn-group{
    display:flex;
    gap:10px;
}

.btn{
    flex:1;
    text-align:center;
    text-decoration:none;
    padding:12px;
    border-radius:8px;
    color:white;
    font-weight:bold;
    transition:0.3s;
}

.book-btn{
    background:#009688;
}

.book-btn:hover{
    background:#00796b;
}

.bus-btn{
    background:#1e3c72;
}

.bus-btn:hover{
    background:#162d55;
}

/* RESPONSIVE */

@media(max-width:768px){

    .top-title h1{
        font-size:30px;
    }

    .top-title p{
        font-size:15px;
    }

    .card img{
        height:190px;
    }

    .card-content h3{
        font-size:20px;
    }

}

</style>

</head>

<body>

<?php include 'header.php'; ?>

<!-- TOP TITLE -->

<div class="top-title">

<h1>
🌍 Explore Amazing Tours
</h1>

<p>
Best Tour & Travel Packages Available
</p>

</div>

<!-- MAIN CONTAINER -->

<div class="container">

<div class="tour-grid">

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div class="card">

<img
src="images/<?php echo htmlspecialchars($row['image']); ?>"
alt="Tour Image">

<div class="card-content">

<h3>

<?php
echo htmlspecialchars($row['title']);
?>

</h3>

<p class="description">

<?php
echo substr(
htmlspecialchars($row['description']),
0,
120
);
?>

...

</p>

<div class="details">

<div class="price">

₹<?php echo $row['price']; ?>

</div>

<div class="days">

<?php
echo htmlspecialchars(
$row['days']
?? 'Tour Package'
);
?>

</div>

</div>

<div class="btn-group">

<!-- VIEW BUSES -->

<a class="btn bus-btn"

href="buses.php?package_id=<?php echo $row['id']; ?>">

View Buses

</a>

<!-- BOOK NOW -->

<a class="btn book-btn"

href="seat-selection.php?package_id=<?php echo $row['id']; ?>">

Book Now

</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>