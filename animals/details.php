<?php
ob_start();
session_start();
if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
}
if (!isset($_SESSION["adm"]) && !isset($_SESSION["user"])) {
    header("Location: ../login.php");
}
require_once "../components/db_connect.php";
$sql = "SELECT * FROM users WHERE id = {$_SESSION["adm"]}";
// echo $sql;
$result = mysqli_query($connect, $sql);
$row1 = mysqli_fetch_assoc($result);
// print_r($row1);

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM animals where id = {$id}";
    $result = mysqli_query($connect, $sql);
    $layout = "";
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // print_r($row);
            $layout .= "<div class='container'>
              <div class='card text-center my-3'>
             <div class='card-header'>
                {$row['name']}
             </div>
              <div class='text-center'>
                    <img src='../pictures/{$row["picture"]}' class='card-img-top' alt='{$row["picture"]}'>
              </div>
              <div class='card-body bg-success-subtle'>
               <h5 class='card-title text-center fw-bold'>Breed: {$row["breed"]}</h5>
                <h5 class='card-title text-center fw-bold'>Gender: {$row["gender"]}</h5>
                 <h5 class='card-title text-center fw-bold'>Age: {$row["age"]}</h5>
                <h6 class='card-text text-center'>Location: {$row["location"]}</h6>
                <h6 class='card-text text-center'>Size: {$row["size"]}</h6>
                <h6 class='card-text text-center'>Vaccinated: {$row["vaccine"]}</h6>
                <p class='card-text1 text-center'>{$row["description"]}</p>
               <div style='text-align: center'>
                  <a href='index.php' class='btn btn-outline-secondary btn-lg text-center mx-4 my-3'>Home</a> 
                   <a href='update.php?id=$row[id]' class='btn btn-outline-warning btn-lg text-center mx-4 my-3'>Edit pet</a> 
                   <a href='delete.php?id=$row[id]' class='btn btn-outline-danger btn-lg text-center mx-4 my-3'>Delete pet</a>
             </div>
             </div>
            </div>         
          </div>";
        }
    } else {
        $layout = "<h3>Animal not found</h3>";
    }
} else {
    $layout = "<h3>No valid animal selected</h3>";
};
mysqli_close($connect);
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?= $row1['first_name'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Carlito:ital,wght@0,400;0,700;1,400;1,700&family=Doppio+One&family=Indie+Flower&family=Madimi+One&family=Ramaraja&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&family=Unkempt:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Carlito:ital,wght@0,400;0,700;1,400;1,700&family=Coda:wght@400;800&family=Doppio+One&family=Indie+Flower&family=Madimi+One&family=Ramaraja&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&family=Unkempt:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Carlito:ital,wght@0,400;0,700;1,400;1,700&family=Coda:wght@400;800&family=Doppio+One&family=Goldman:wght@400;700&family=Indie+Flower&family=Madimi+One&family=Ramaraja&family=Skranji:wght@400;700&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&family=Unkempt:wght@400;700&family=Yusei+Magic&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Carlito:ital,wght@0,400;0,700;1,400;1,700&family=Coda:wght@400;800&family=Coustard:wght@400;900&family=Doppio+One&family=Goldman:wght@400;700&family=Indie+Flower&family=Limelight&family=Madimi+One&family=Ramaraja&family=Reggae+One&family=Skranji:wght@400;700&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&family=Unkempt:wght@400;700&family=Yusei+Magic&display=swap');

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
            width: 44rem;
        }

        .card-title {
            font-size: 2.1rem;
            font-family: "Unkempt", serif;
            font-weight: 700;
            font-style: normal;
            color: #C91959;
        }

        .card-title:first-child {
            color: #639744;
        }

        .card-title:nth-child(2) {
            color: #fe47af;
        }

        .card-title:nth-child(3) {
            color: #c70054;
        }

        .card-text {
            font-size: 1.3rem;
            font-family: "Reggae One", system-ui;
            font-weight: 400;
            font-style: normal;
            letter-spacing: 0.5;
            color: #3b7430;
        }

        .card-text1 {
            font-size: 1.1rem;
            font-family: "Yusei Magic", serif;
            font-weight: 400;
            font-style: normal;
            letter-spacing: 0.5;
            color: #3f3aaa;
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

        /* Mobile phone */
        @media screen and (max-width: 480px) {
            .header1 {
                font-size: 3.5rem;
            }

            .card-header {
                font-size: 3.2rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .card-text {
                font-size: 1.1rem;
            }

            .card-text1 {
                font-size: 0.9rem;
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
                font-size: 4.5rem;
            }

            .card-header {
                font-size: 3.5rem;
            }

            .card-title {
                font-size: 2.1rem;
            }

            .card-text {
                font-size: 1.3rem;
            }

            .card-text1 {
                font-size: 1.1rem;
            }

            .error-text {
                font-size: 1.1rem;
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
                    src="../pictures/<?= $row1['picture'] ?>"
                    alt="Logo" />
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse p-3" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" href="index.php">List of pets</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid bg-image">
        <h1 class="header1 text-center fw-bold mb-3">Pet details</h1>
        <div class="row">
            <div class="col col-md-6 mx-auto">
                <?= $layout ?>
            </div>
        </div>
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