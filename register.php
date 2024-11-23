<?php
ob_start();
session_start();
if (isset($_SESSION["user"])) {
  header("Location: home.php");
}
if (isset($_SESSION["adm"])) {
  header("Location: dashboard.php");
}
require_once "components/db_connect.php";
require_once "components/file_upload.php";
$error = false;
$first_name = $last_name = $email = $password = $address = $phone = "";
$fnameError = $lnameError = $addressError = $emailError = $passwordError = $phoneError = "";

function cleanInputs($input)
{
  $data = trim($input);
  $data = strip_tags($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_POST["register"])) {
  // var_dump($_POST);
  $first_name = cleanInputs($_POST["first_name"]);
  $last_name = cleanInputs($_POST["last_name"]);
  $email = cleanInputs($_POST["email"]);
  $password = cleanInputs($_POST["password"]);
  $address = cleanInputs($_POST["address"]);
  $phone = cleanInputs($_POST["phone"]);
  $picture = fileUpload($_FILES["picture"]);
  //check firstname
  if (empty($first_name)) {
    $error = true;
    $fnameError = "Please enter your first name!";
  } elseif (strlen($first_name) < 3) {
    $error = true;
    $fnameError = "First name must have at least 3 characters!";
  } elseif (!preg_match("/^[a-zA-Z\s]+$/", $first_name)) {
    $error = true;
    $fnameError = "First name cannot contain special characters and numbers!";
  }
  //check lastname
  if (empty($last_name)) {
    $error = true;
    $lnameError = "Please enter your first name!";
  } elseif (strlen($last_name) < 3) {
    $error = true;
    $lnameError = "First name must have at least 3 characters!";
  } elseif (!preg_match("/^[a-zA-Z\s]+$/", $last_name)) {
    $error = true;
    $lnameError = "First name cannot contain special characters and numbers!";
  }
  //check address
  if (empty($address)) {
    $error = true;
    $addressError = "Please enter your address!";
  }
  //check email
  if (empty($email)) {
    $error = true;
    $emailError = "Please enter your email!";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = true;
    $emailError = "Please enter a valid email!";
  }
  $emailsql = "SELECT email FROM users WHERE email='$email'";
  $emailresult = mysqli_query($connect, $emailsql);
  if (mysqli_num_rows($emailresult) > 0) {
    $error = true;
    $emailError = "Entered email is already in use!";
  }
  //check password  
  if (empty($password)) {
    $error = true;
    $passError = "Please enter your password!";
  } elseif (strlen($password) < 6) {
    $error = true;
    $passError = "Password must have at least 6 characters!";
  }
  //check phone number
  if (empty($phone)) {
    $error = true;
    $phoneError = "Please enter your phone number!";
  } elseif (!preg_match("/^[0-9]+$/", $phone)) {
    $error = true;
    $phoneError = "Please enter a valid phone number!";
  }
  //if no error, insert users-table
  if (!$error) {
    $password = hash("sha256", $password);
    $sql = "INSERT INTO users(first_name, last_name, password, email, address, picture, phone_number) VALUES 
        ('$first_name','$last_name','$password','$email','$address', '$picture[0]', '$phone')";
    $result = mysqli_query($connect, $sql);
    if ($result) {
      echo "<div class='alert alert-success' role='alert'>
            New user has been successfully created, {$picture[1]};
           </div>";
      header("Location: home.php");
    } else {
      echo "<div class='alert alert-danger' role='alert'>
            Something went wrong
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
  <title>Registration</title>
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
        <h3 class="text-center header1 fw-bold">Registration</h3>
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3 mt-3">
            <label for="first_name" class="text1 form-label">First name</label>
            <input type="text" class="form-control" id="first_name" name="first_name"
              placeholder="Enter your first name" required>
            <span class="text-danger"><?= $fnameError ?></span>
          </div>
          <div class="mb-3 mt-3">
            <label for="last_name" class="text1 form-label">Last name</label>
            <input type="text" class="form-control" id="last_name" name="last_name"
              placeholder="Enter your last name" required>
            <span class="error-text fw-bold"><?= $lnameError ?></span>
          </div>
          <div class="mb-3 mt-3">
            <label for="address" class="text1 form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address"
              placeholder="Enter your address" required>
            <span class="error-text fw-bold"><?= $addressError ?></span>
          </div>
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
          <div class="mb-3 mt-3">
            <label for="phone" class="text1 form-label">Phone number</label>
            <input type="text" class="form-control" id="phone" name="phone"
              placeholder="Enter your phone number" required>
            <span class="error-text fw-bold"><?= $phoneError ?></span>
          </div>
          <div class="mb-3">
            <label for="picture" class="text1 form-label">Picture</label>
            <input type="file" class="form-control" id="picture" aria-describedby="picture" name="picture">
          </div>
          <div class="text-center">
            <button name="register" id="neonShadow" type="submit">Create account</button>

            <span class="text2">You have an account already? <a href="login.php">sign in here</a></span>
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