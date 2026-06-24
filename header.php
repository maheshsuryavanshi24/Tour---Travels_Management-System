<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

/* HEADER */
header{
    background:#1e3c72;
    color:#fff;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

/* TITLE */
header h1{
    font-size:22px;
}

/* NAV */
nav{
    display:flex;
    gap:15px;
    align-items:center;
}

/* LINKS */
nav a{
    color:#fff;
    text-decoration:none;
    padding:8px 12px;
    border-radius:5px;
    transition:0.3s;
}

nav a:hover{
    background:#16325c;
}

/* HAMBURGER */
.menu-toggle{
    display:none;
    font-size:26px;
    cursor:pointer;
}

/* MOBILE */
@media(max-width:768px){

    .menu-toggle{
        display:block;
    }

    nav{
        display:none;
        width:100%;
        flex-direction:column;
        margin-top:10px;
        background:#1e3c72;
        padding:10px;
        border-top:1px solid rgba(255,255,255,0.2);
    }

    nav.show{
        display:flex;
    }

    nav a{
        width:100%;
        text-align:left;
        padding:10px;
    }
}
</style>

<header>

    <h1>RS Tour & Travels</h1>

    <!-- HAMBURGER ICON -->
    <div class="menu-toggle" onclick="toggleMenu()">
        ☰
    </div>

    <nav id="menu">
        <a href="index.php">Home</a>
        <a href="tours.php">Tours</a>
        <a href="booking.php">Booking</a>
        <a href="contact.php">Contact</a>
        <a href="login.php">Login</a>
        <a href="admin-login.php">Admin Login</a>
    </nav>

</header>

<script>
function toggleMenu(){
    document.getElementById("menu").classList.toggle("show");
}
</script>