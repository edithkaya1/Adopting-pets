<?php
ob_start();
session_start();
if (isset($_SESSION["user"])) {
  header("Location: home.php");
}
if (isset($_SESSION["adm"])) {
  header("Location: dashboard.php");
  exit;
}
// var_dump($_SESSION);
require_once "components/db_connect.php";
$error = false;
$email = $password = "";
$emailError = $passwordError = "";

function cleanInputs($input)
{
  $data = trim($input);
  $data = strip_tags($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_POST["login"])) {
  $email = cleanInputs($_POST["email"]);
  $password = cleanInputs($_POST["password"]);
  //check email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = true;
    $emailError = "Please enter a valid email!";
  }
  //check password  
  if (empty($password)) {
    $error = true;
    $passError = "Please enter your password!";
  }
  if (!$error) {
    $password = hash("sha256", $password);
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) == 1) {
      // var_dump($row);
      if ($row["status"] == "adm") {
        $_SESSION["adm"] = $row["id"];
        // var_dump($_SESSION);
        header("Location: animals/index.php");
      } else {
        $_SESSION["user"] = $row["id"];
        // var_dump($_SESSION);
        header("Location: home.php");
      }
    } else {
      echo "<div class='alert alert-danger'>
                        <p>Something went wrong, please try again later ...</p>
                      </div>";
    }
  }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login page</title>
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
    input[type=date],
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

    input[type="date"]:focus {
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
      /* background-image: url(https://www.wallpapersun.com/wp-content/uploads/2020/12/Pastel-Wallpaper-21.jpg); */
      background-image: url(https://www.teahub.io/photos/full/21-213210_pink-and-gold-wallpaper-yellow-pink-background-hd.jpg);
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: 150vh;
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
        <h3 class="text-center header1 fw-bold">Login Page</h3>
        <form method="POST">
          <div class="mb-3 mt-3">
            <label for="email" class="text1 form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
              placeholder="Enter your email" required>
            <span class="error-text fw-bold"><?= $emailError ?></span>
          </div>
          <div class="mb-3 mt-3">
            <label for="password" class="text1 form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password"
              placeholder="Enter your password" required>
            <span class="error-text fw-bold"><?= $passwordError ?></span>
          </div>
          <div class="text-center">
            <button name="login" id="neonShadow" type="submit">Login</button>

            <span class="text2">You don't have an account? <a href="register.php">create an account</a></span>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/1d760a24a6.js" crossorigin="anonymous"></script>
</body>

</html>