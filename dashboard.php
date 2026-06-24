<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$query = "
SELECT * FROM packages
ORDER BY id DESC
LIMIT 6
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>User Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#eef3f8;
}

/* NAVBAR */

.navbar{
    background:#009688;
    padding:15px 25px;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
}

.logo{
    font-size:24px;
    font-weight:bold;
}

.menu{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
}

.menu a{
    color:white;
    text-decoration:none;
    padding:10px 14px;
    border-radius:6px;
    transition:0.3s;
    font-size:15px;
}

.menu a:hover{
    background:rgba(255,255,255,0.2);
}

.menu select{
    padding:10px;
    border:none;
    border-radius:6px;
    outline:none;
    font-size:15px;
}

.menu-toggle{
    display:none;
    font-size:30px;
    cursor:pointer;
}
/* HERO */

.hero{
    height:50vh;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    padding:20px;

    background:
    linear-gradient(rgba(0,0,0,0.5),
    rgba(0,0,0,0.5)),

    url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1600&q=80');

    background-size:cover;
    background-position:center;

    color:white;
}

.hero-content h1{
    font-size:48px;
    margin-bottom:15px;
}

.hero-content p{
    font-size:20px;
}

/* CONTAINER */

.container{
    width:90%;
    max-width:1200px;
    margin:auto;
    padding:40px 0;
}

.welcome{
    font-size:24px;
    margin-bottom:25px;
    color:#333;
    font-weight:bold;
}

.section-title{
    font-size:32px;
    color:#1e3c72;
    margin-bottom:30px;
    text-align:center;
}

/* GRID */

.grid{
    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(270px,1fr));

    gap:25px;
}

/* CARD */

.card{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 30px rgba(0,0,0,0.12);
}

.card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.card-content{
    padding:18px;
}

.card-content h3{
    color:#1e3c72;
    margin-bottom:10px;
    font-size:22px;
}

.card-content p{
    color:#555;
    font-size:15px;
    line-height:1.6;
    margin-bottom:12px;
}

.price{
    color:#28a745;
    font-size:24px;
    font-weight:bold;
}

.btn{
    display:block;
    width:100%;
    text-align:center;
    margin-top:15px;
    padding:13px;
    background:
    linear-gradient(135deg,#1e3c72,#2a5298);

    color:white;
    text-decoration:none;
    border-radius:10px;
    font-weight:bold;
    transition:0.3s;
}

.btn:hover{
    background:#16325c;
}



@media(max-width:768px){

    .navbar{
 flex-wrap:wrap;
        flex-direction:column;
        align-items:flex-start;
    }

  
    .menu-toggle{
        display:block;
    }

    .menu{
        width:100%;
        display:none;
        flex-direction:column;
        margin-top:15px;
        background:#00796b;
        padding:15px;
        border-radius:10px;
    }
.menu.show{
        display:flex;
    }

    .menu a,
    .menu select{
        width:100%;
    }

    .hero{
        height:40vh;
    }

    .hero-content h1{
        font-size:34px;
    }

    .hero-content p{
        font-size:17px;
    }

    .section-title{
        font-size:28px;
    }
}

@media(max-width:480px){

    .container{
        width:95%;
    }

    .hero-content h1{
        font-size:28px;
    }

    .card img{
        height:180px;
    }

    .welcome{
        font-size:20px;
    }
}

</style>

<script>

function goToPage(page){

    if(page !== ""){
        window.location.href = page;
    }

}

</script>

</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">

        TravelWorld
<br>
 <div class="welcome">

        👋 Welcome,
        <?php echo htmlspecialchars($user_name); ?>

    </div>

    </div>
 <div class="menu-toggle" onclick="toggleMenu()">
        ☰
    </div>

    <div class="menu" id="mobileMenu">

        <a href="dashboard.php">
            Home
        </a>

        <a href="my-bookings.php">
            My Bookings
        </a>

        <a href="profile.php">
            Profile
        </a>

        <a href="feedback.php">
            Feedback
        </a>

        <a href="logout.php">
            Logout
        </a>

        <select onchange="goToPage(this.value)">

            <option value="">
                Bus 🚌
            </option>

            <option value="buses.php">
                Book Bus
            </option>

            <option value="my_booking_history.php">
                Bus Booking History
            </option>

		<option value="bus-tracking.php">
                Tracking  Bus  
            </option>
        </select>

    </div>

</div>

<!-- HERO -->

<section class="hero">

   <div class="hero-content">

    <h1>
            Explore Amazing Tours
     </h1>

    <p>
            Book Tours & Bus Tickets Easily
    </p>

  </div>

</section>



<div class="container">

   
    <h2 class="section-title">
        Available Tour Packages
    </h2>

    <div class="grid">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="card">

            <img
            src="uploads/<?php echo $row['image']; ?>">

            <div class="card-content">

                <h3>
                    <?php echo htmlspecialchars($row['title']); ?>
                </h3>

                <p>
                    <?php
                    echo substr(
                    htmlspecialchars($row['description']),
                    0,
                    90
                    );
                    ?>...
                </p>

                <div class="price">

                    ₹<?php echo $row['price']; ?>

                </div>

                <a class="btn"

                href="buses.php?package_id=<?php echo $row['id']; ?>">

                    View Buses

                </a>

            </div>

        </div>

        <?php } ?>

    </div>

</div>
<script>

function toggleMenu(){

    document
    .getElementById("mobileMenu")
    .classList.toggle("show");

}

</script>

</body>

</html>