<?php
ob_start();
session_start();
if (isset($_SESSION["adm"])) {
    header("Location: dashboard.php");
}
if (!isset($_SESSION["adm"]) && !isset($_SESSION["user"])) {
    header("Location: login.php");
}
require_once "components/db_connect.php";
$sql = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
$result = mysqli_query($connect, $sql);
$row1 = mysqli_fetch_assoc($result);
$iduser = $_SESSION["user"];
//  echo"<pre>";
//     var_dump($_SESSION);
//   echo"</pre>";
$id = $_GET["id"];
$sqlpet = "SELECT * FROM animals WHERE id = {$id}";
$petResult = mysqli_query($connect, $sqlpet);
$petRow = mysqli_fetch_all($petResult, MYSQLI_ASSOC);
// var_dump($petRow);
$cards = "";

$options = '';
foreach ($petRow as $pets) {
    $options .= "<option value='{$pets['id']} selected'>{$pets['breed']} {$pets['name']}</option>";
    $cards .= "<div>
                <div class='card mx-auto my-3'>
                   <div class='card-header text-center'>
                     {$pets['breed']} {$pets['name']}
                   </div>
                   <div class='text-center'>
                      <img src='pictures/{$pets["picture"]}' class='card-image-top' alt='{$pets["picture"]}'>
                   </div>
                   <div class='card-body'>
                    <p class='card-title fw-bold text-center'>Gender: {$pets['gender']}</p>
                    <p class='card-title fw-bold text-center'>Age: {$pets['age']}</p>
                    <p class='card-title fw-bold text-center'>Location: {$pets['location']}</p>
               </div>
           </div>";
}

if (isset($_POST["adopt"])) {
    $iduser = $_SESSION["user"];
    $petid = $id;
    $fname = $_POST["first_name"];
    $lname = $_POST["last_name"];
    $email = $_POST["email"];
    $adate = $_POST["adopt_date"];
    $status = 'ADOPTED';

    // var_dump($_POST);

    $sqlins = "INSERT INTO pet_adoption (first_name, last_name, email, adopt_date, fk_user_id, fk_animal_id) 
    VALUES ('$fname','$lname','$email','$adate', $iduser, $petid)";
    $sqlupd = "UPDATE animals SET status = '$status' WHERE id = {$petid}";
    // var_dump($sqlins);
    // var_dump($sqlupd);
    if (mysqli_query($connect, $sqlins) && mysqli_query($connect, $sqlupd)) {
        echo "<div class='alert alert-success' role='alert'>
           New adoption has been successfully created
         </div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>
           Something went wrong
         </div>";
    }
    header("refresh: 3; url=home.php");
}
//  mysqli_close($connect);
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
        @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&family=Madimi+One&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Carlito:ital,wght@0,400;0,700;1,400;1,700&family=Coda:wght@400;800&family=Doppio+One&family=Goldman:wght@400;700&family=Indie+Flower&family=Madimi+One&family=Ramaraja&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&family=Unkempt:wght@400;700&display=swap');

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
            height: 400px;
        }

        .card-title {
            font-size: 1.5rem;
            font-family: "Unkempt", serif;
            font-weight: 700;
            font-style: normal;
            color: #640007;
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

        .card-title:nth-child(4) {
            color: #6B9A6E;
        }

        .text1 {
            font-size: 1.8rem;
            font-family: "Madimi One", sans-serif;
            font-weight: 400;
            font-style: normal;
            color: #C91959;
        }

        .box {
            width: 100%;
            font-size: 1.5rem;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 2px solid #110707;
            border-radius: 4px;
            outline: none;
            position: relative;
            resize: vertical;
            background-color: #FEF5E7;
            font-family: "Goldman", sans-serif;
            font-weight: 700;
            font-style: normal;
            color: #6B9A6E;
        }

        input[type=text],
        input[type=email],
        input[type=date],
        input[type=time] {
            width: 100%;
            font-size: 1.5rem;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 2px solid #110707;
            border-radius: 4px;
            outline: none;
            position: relative;
            resize: vertical;
            background-color: #FEF5E7;
            font-family: "Goldman", sans-serif;
            font-weight: 700;
            font-style: normal;
        }

        input[type="text"]:focus {
            background-color: #cedf90;
        }

        input[type="email"]:focus {
            background-color: #cedf90;
        }

        input[type="date"]:focus {
            background-color: #cedf90;
        }

        input[type="time"]:focus {
            background-color: #cedf90;
        }

        .box:focus {
            background-color: #cedf90;
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

        .bg-image {
            background-image: url(https://static.vecteezy.com/system/resources/previews/011/410/588/original/abstract-watercolor-background-watercolor-texture-for-design-vector.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: auto;
            margin: 0;
        }
        /* Mobile phone */
        @media screen and (max-width: 480px) {
            .header1 {
                font-size: 2.8rem;
            }

            .card-header {
                font-size: 2.5rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .card-text {
                font-size: 1.5rem;
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-user"></i>My account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="edit-profile.php">Edit profile</a></li>
                            <li><a class="dropdown-item" href="logout.php?logout">Logout</a></li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid bg-image">
        <div class="row">
            <div class="col col-md-6 mx-auto my-3">
                <h3 class="text-center header1 fw-bold">Adopt a pet</h3>
                <div class="row row-cols-1">
                    <?= $cards ?>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="first_name" class="text1 form-label">First name</label>
                        <input type="text" class="form-control" id="first_name" aria-describedby="first_name"
                            name="first_name" placeholder="Enter first name"
                            value="<?= $row1["first_name"] ?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="last_name" class="text1 form-label">Last name</label>
                        <input type="text" class="form-control" id="first_name" aria-describedby="last_name"
                            name="last_name" placeholder="Enter last name"
                            value="<?= $row1["last_name"] ?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email" class="text1 form-label">Email</label>
                        <input type="email" class="form-control" id="email" aria-describedby="email" name="email"
                            placeholder="Enter email"
                            value="<?= $row1["email"] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pet" class="text1 form-label">My favorite pet to adopt</label>
                        <select name="pet" id="car" class="box form-select">
                            <?= $options ?>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="adopt_date" class="text1 form-label">Adoption date</label>
                        <input type="date" class="form-control" id="adopt_date" aria-describedby="adopt_date"
                            name="adopt_date" placeholder="Enter adoption date" required>
                    </div>
                    <div class="text-center">
                        <button name="adopt" type="submit" class="btn btn-lg btn-outline-secondary m-4">Save
                            adoption</button>
                        <a href="home.php" class="btn btn-lg btn-outline-dark m-4">Back to home</a>
                    </div>
                    <br>
                    <br>
                </form>
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