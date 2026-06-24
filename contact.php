<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Contact</title>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f4f6f9;
}


.contact-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:80vh;
    padding:20px;
}

.contact-box{
    background:#fff;
    padding:40px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    max-width:500px;
    width:100%;
    text-align:center;
    transition:0.3s;
}

.contact-box:hover{
    transform:translateY(-5px);
}


.contact-box h2{
    color:#1e3c72;
    margin-bottom:20px;
    font-size:28px;
}


.contact-box p{
    font-size:16px;
    color:#555;
    margin-bottom:12px;
    line-height:1.6;
}


.contact-box p::before{
    margin-right:8px;
}


@media(max-width:768px){

    .contact-box{
        padding:30px;
    }

    .contact-box h2{
        font-size:24px;
    }
}

@media(max-width:480px){

    .contact-box{
        padding:20px;
    }

    .contact-box h2{
        font-size:22px;
    }

    .contact-box p{
        font-size:14px;
    }
}

</style>

</head>

<body>

<?php include 'header.php'; ?>

<div class="contact-wrapper">

    <div class="contact-box">

        <h2>Contact Us</h2>

        <p>📧 Email: patilnileshv25@gmail.com</p>

        <p>📞 Phone: +917020070774</p>

        <p>📍 Location: Sangli, India</p>

    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>