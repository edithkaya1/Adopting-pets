<?php
ob_start();
session_start();
if (!isset($_SESSION['adm'])) {
    header("Location: login.php");
    exit;
}
require_once 'components/db_connect.php';
require_once 'components/file_upload.php';
// var_dump($_SESSION);
if (isset($_SESSION['adm'])) {
    $id = $_SESSION['adm'];
    $redirectTo = 'dashboard.php';
}
function cleanInputs($input)
{
    $data = trim($input);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);
    return $data;
}
$id = $_GET["id"];
// var_dump($id);
// var_dump($_POST);

$sql = "SELECT * FROM users where id = {$id}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
// var_dump($row);
if (isset($_POST['update-profile'])) {
    $first_name = cleanInputs($_POST['first_name']);
    $last_name = cleanInputs($_POST['last_name']);
    $email = cleanInputs($_POST['email']);
    $password = cleanInputs($_POST['password']);
    $address = cleanInputs($_POST["address"]);
    $phone = cleanInputs($_POST["phone_number"]);
    $picture = fileUpload($_FILES['picture']);
    if ($_FILES['picture']['error'] == 4) {
        $updateSql = "UPDATE `users` SET `first_name`='$first_name',`last_name`='$last_name',`address`='$address',`email`='$email', `phone_number`='$phone' WHERE id = {$id}";
    } else {
        if ($row['picture'] != 'avatar.png') {
            unlink("pictures/{$row['picture']}");
        }
        $updateSql = "UPDATE `users` SET `first_name`='$first_name',`last_name`='$last_name',`address`='$address',`email`='$email', `phone_number`='$phone', `picture`='$picture[0]' WHERE id = {$id}";
    }
    $result = mysqli_query($connect, $updateSql);
    if ($result) {
        header("Location: $redirectTo");
    }
}
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

        .text1 {
            font-size: 1.8rem;
            font-family: "Madimi One", sans-serif;
            font-weight: 400;
            font-style: normal;
            color: #21263E;
        }

        .text2 {
            font-size: 1.3rem;
            font-family: "Madimi One", sans-serif;
            font-weight: 400;
            font-style: normal;
            color: #2A3058;
        }

        .error-text {
            font-size: 1.5rem;
            font-family: "Madimi One", sans-serif;
            font-weight: 400;
            font-style: normal;
            color: darkred;
        }

        input[type=text],
        input[type=email],
        input[type=tel],
        input[type=password],
        input[type=file] {
            width: 100%;
            font-size: 1.2rem;
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
            background-color: #FDD1E8;
        }

        input[type="tel"]:focus {
            background-color: #FDD1E8;
        }

        input[type="email"]:focus {
            background-color: #FDD1E8;
        }

        input[type="password"]:focus {
            background-color: #FDD1E8;
        }

        input[type="file"]:focus {
            background-color: #FDD1E8;
        }

        .bg-image {
            background-image: url(https://www.teahub.io/photos/full/21-213210_pink-and-gold-wallpaper-yellow-pink-background-hd.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: auto;
            margin: 0;
        }

        #neonShadow {
            height: 50px;
            width: 120px;
            border: none;
            border-radius: 50px;
            transition: 0.3s;
            background-color: rgba(156, 161, 160, 0.3);
            animation: glow 1s infinite;
            transition: 0.5s;
            text-decoration: none;
            /* margin-block: 10rem; */
            font-size: 1.1rem;
            font-family: "Skranji", system-ui;
            font-weight: 700;
            font-style: normal;
            /* padding: 4rem; */
            margin: 3rem;
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
                font-size: 3rem;
            }

            .text1 {
                font-size: 1.3rem;
            }
        }

        /* Tablet */
        @media screen and (max-width: 1200px) and (min-width: 481px) {
            .header1 {
                font-size: 4rem;
            }

            .text1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid bg-image">
        <div class="row">
            <div class="col col-md-6 mx-auto my-3">
                <h3 class="text-center header1 fw-bold">Update profile</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="first_name" class="text1 form-label">First name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="<?= $row["first_name"] ?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="last_name" class="text1 form-label">Last name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="<?= $row["last_name"] ?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="address" class="text1 form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="<?= $row["address"] ?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email" class="text1 form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $row["email"] ?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="phone_number" class="text1 form-label">Phone number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            value="<?= $row["phone_number"] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="picture" class="text1 form-label">Picture</label>
                        <input type="file" class="form-control" id="picture" aria-describedby="picture" name="picture">
                    </div>
                    <div class="mb-3">
                        <input type="submit" id="neonShadow" name="update-profile">
                        <a href="<?= $redirectTo ?>" class="btn btn-lg btn-outline-dark">Back</a>
                    </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/1d760a24a6.js" crossorigin="anonymous"></script>
</body>

</html>