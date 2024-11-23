<?php
session_start();
if (isset($_SESSION['adm'])) {
    header("Location: dashboard.php");
    exit;
}
if (!isset($_SESSION['user']) && !isset($_SESSION['adm'])) {
    header("Location: login.php");
    exit;
}
require_once "components/db_connect.php";
if (isset($_SESSION["user"])) {
    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
    $result = mysqli_query($connect, $sql);
    $row1 = mysqli_fetch_assoc($result);
    // print_r($row1);
}
$sql = "SELECT * FROM animals WHERE age > 8 and status = 'AVAILABLE';";
$result = mysqli_query($connect, $sql);
$cards = "";
if (mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($rows as $row) {
        // print_r($row);
        $statusError = "";
        $buttonDisablen = "";
        if (($row["status"]) == 'ADOPTED') {
            $buttonDisablen = "disabled";
            $statusError = "Pet already adopted. Thank you very much!";
        }
        $cards .= "<div>
        <div class='card mx-auto my-3'>
            <div class='card-header text-center'>
               {$row['breed']}
            </div>
            <div class='text-center'>
               <img src='../pictures/{$row['picture']}' class='card-image-top mx-auto' alt='image'>
           </div>
           <div class='card-body'>
              <h5 class='card-title fw-bold text-center'>My name: {$row['name']}</h5>
              <p class='card-text fw-bold text-center'>Gender: {$row['gender']}</p>
              <p class='card-text1 fw-bold text-center'>Location: {$row['location']}</p>
              <p class='card-text2 fw-bold text-center'>Age: {$row['age']}</p>
              <div class='text-center'>
                <a href='details.php?id=$row[id]' class='{$buttonDisablen} btn btn-lg btn-secondary m-4 my-3'>Details</a>
                <a href='adopting.php?id=$row[id]' class='{$buttonDisablen} btn btn-warning btn-lg text-center m-4 my-3'>Take me home</a> 
              </div>
           </div>
        </div>
    </div>";
    }
} else {
    $cards = "<h3>No results found</h3>";
}
mysqli_close($connect);
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?= (isset($row1)) ? $row1['first_name'] : "guest" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Carlito:ital,wght@0,400;0,700;1,400;1,700&family=Doppio+One&family=Indie+Flower&family=Madimi+One&family=Ramaraja&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&family=Unkempt:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Carlito:ital,wght@0,400;0,700;1,400;1,700&family=Coda:wght@400;800&family=Doppio+One&family=Goldman:wght@400;700&family=Indie+Flower&family=Limelight&family=Madimi+One&family=Ramaraja&family=Skranji:wght@400;700&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&family=Unkempt:wght@400;700&family=Yusei+Magic&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Carlito:ital,wght@0,400;0,700;1,400;1,700&family=Coda:wght@400;800&family=Doppio+One&family=Goldman:wght@400;700&family=Indie+Flower&family=Limelight&family=Madimi+One&family=Ramaraja&family=Skranji:wght@400;700&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&family=Unkempt:wght@400;700&family=Yusei+Magic&display=swap');

        .header1 {
            font-size: 5rem;
            font-family: "Indie Flower", serif;
            font-weight: 400;
            font-style: normal;
            color: #640007;
            text-shadow: 6px 6px 0 gray;
            animation: tada;
            animation-duration: 5s;
            --animate-delay: 0.9s;
        }

        .image {
            width: 80px;
            height: auto;
        }

        .text1 {
            font-size: 1.8rem;
            font-family: "Yusei Magic", serif;
            font-weight: 400;
            font-style: normal;
            color: #003d34;
            text-shadow: 5px 5px 15px whitesmoke;
        }

        .card {
            border: double 10px black;
        }

        .card-body {
            background-color: #dce2e1;
        }

        .card-header {
            font-size: 3.5rem;
            background-color: #C91959;
            color: whitesmoke;
            font-family: "Indie Flower", serif;
            font-weight: 400;
            font-style: normal;
        }

        .card-image-top {
            width: 100%;
            height: 350px;
        }

        .card-title {
            font-size: 2.2rem;
            font-family: "Indie Flower", serif;
            font-weight: 400;
            font-style: normal;
            color: #640007;
        }

        .card-text {
            font-size: 1.3rem;
            font-family: "Unkempt", serif;
            font-weight: 700;
            font-style: normal;
            color: #639744;
        }

        .card-text1 {
            font-size: 1.3rem;
            font-family: "Unkempt", serif;
            font-weight: 700;
            font-style: normal;
            color: #fe47af;
        }

        .card-text2 {
            font-size: 1.3rem;
            font-family: "Unkempt", serif;
            font-weight: 700;
            font-style: normal;
            color: #ABA5E4;
        }

        .error-text {
            font-size: 1.1rem;
            font-family: "Skranji", serif;
            font-weight: 700;
            font-style: normal;
            letter-spacing: 0.5;
            color: #D71232;
        }

        .bg-image {
            background-image: url(https://static.vecteezy.com/system/resources/previews/011/410/588/original/abstract-watercolor-background-watercolor-texture-for-design-vector.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: auto;
            margin: 0;
        }

        .nav-link {
            font-size: 1.5rem;
            font-family: "Carlito", sans-serif;
            font-weight: 700;
            font-style: italic;
        }

        .nav-link:hover {
            background-color: #b3c6ff;
            border-radius: 15%;
            transform: scale(1.1);
        }

        #neonShadow {
            height: 30px;
            width: 100px;
            border: none;
            border-radius: 50px;
            transition: 0.3s;
            background-color: rgba(156, 161, 160, 0.3);
            animation: glow 1s infinite;
            transition: 0.5s;
            text-decoration: none;
            margin-block: 15rem;
            font-size: 1.5rem;
            font-family: "Skranji", system-ui;
            font-weight: 700;
            font-style: normal;
            padding: 2rem;
            margin: 5rem;
            color: #640007;
        }

        #neonShadow:hover {
            transform: translateX(-20px)rotate(30deg);
            border-radius: 5px;
            background-color: #c3bacc;
            transition: 0.5s;
        }

        @keyframes glow {
            0% {
                box-shadow: 5px 5px 20px rgb(93, 52, 168), -5px -5px 20px rgb(93, 52, 168);
            }

            50% {
                box-shadow: 5px 5px 20px rgb(81, 224, 210), -5px -5px 20px rgb(81, 224, 210)
            }

            100% {
                box-shadow: 5px 5px 20px rgb(93, 52, 168), -5px -5px 20px rgb(93, 52, 168)
            }
        }

        /* Mobile phone */
        @media screen and (max-width: 480px) {
            .header1 {
                font-size: 2.3rem;
            }

            .card-header {
                font-size: 2.2rem;
            }

            .card-title {
                font-size: 1.8rem;
            }

            .card-text {
                font-size: 1.2rem;
            }

            .card-text1 {
                font-size: 1.2rem;
            }

            .card-text2 {
                font-size: 1.2rem;
            }

            .error-text {
                font-size: 1rem;
            }

            .nav-link:hover {
                border-radius: 25%;
                width: 10rem;
                height: auto;
                transform: scale(1.0);
                text-align: center;
            }

            .footer h2,
            h5 {
                font-size: 1rem;
            }
        }

        /* Tablet */
        @media screen and (max-width: 1200px) and (min-width: 481px) {
            .header1 {
                font-size: 4rem;
            }

            .nav-link:hover {
                border-radius: 25%;
                width: 10rem;
                height: auto;
                transform: scale(1.0);
                text-align: center;
            }

            .card-header {
                font-size: 2.8rem;
            }

            .card-title {
                font-size: 2rem;
            }


            .footer h2,
            h5 {
                font-size: 1.2rem;
            }

            .footer-links {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar sticky-top bg-dark navbar-expand-lg bg-body-secondary fs-5">
        <div class="container-fluid">
            <div class="w-1">
                <img class="image"
                    src="pictures/<?= $row1['picture'] ?>"
                    alt="Logo" />
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse p-3" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    <!-- <a class="nav-link" href="listbook.php">My bookings</a> -->
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid bg-image">
        <h1 class="header1 text-center fw-bold">List of available senior pets</h1>
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">
            <?= $cards ?>
        </div>
        <br>
        <br>
    </div>

    <footer class="footer p-2 bg-dark-subtle text-secondary-emphasis">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-2">
                    <h2><i class="fa-solid fa-paw"></i></i>Pet adoption Breitenfurt</h2>
                </div>
                <div class="col-md-5 col-sm-2">
                    <h5>Contact us</h5>
                    <ul class="list-unstyled">
                        <li>Email: petadoption@gmail.com</li>
                        <li>Phone: +43 616/1240356</li>
                        <li>Address: Hauptstrasse 777, 2384 Breitenfurt, Austria</li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-5">
                    <h5>Follow Us</h5>
                    <ul class="list-inline footer-links">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr />
            <div id="foot" class="row">
                <div class="col-md-5">
                    <p>&copy; Pet adoption Breitenfurt 2024</p>
                </div>
                <div class="col-md-6">
                    <p>All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/1d760a24a6.js" crossorigin="anonymous"></script>
</body>

</html>