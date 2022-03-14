<?php


// Remove Image of qr code

// check logic in check.php 


session_start();
require "Authenticator.php";
include 'connection.php';


if (isset($_SESSION['verifyCode'])) {
    $authenticator = new Authenticator();
    $username = $_SESSION['verifyCode'];

    $query = "SELECT AuthKey FROM login WHERE Username = '$username' ";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $key = $row['AuthKey'];
        }

        $_SESSION['userKey'] = $key;
    }
} else {
    header('Location: ../user/CreateAccount.php');
}

$message = "";

if (isset($_GET['error'])) {
    $message = $_GET['error'];
}
else{
    $message = "";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Time-Based Authentication like Google Authenticator</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <meta name="description" content="Implement Google like Time-Based Authentication into your existing PHP application. And learn How to Build it? How it Works? and Why is it Necessary these days." />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel='shortcut icon' href='/favicon.ico' />
    <style>
        body,
        html {
            height: 100%;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .bg {
            /* The image used */
            background-image: url("https://iconscout.com/illustration/privacy-protection-2381448");
            /* Full height */
            height: 100%;
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;

            background-size: cover;
        }
    </style>
</head>

<body class="bg">
    <div class="container">
        <div class="row text">
            <div class="col-md-6 offset-md-6" style="background: white; padding: 20px; margin-top: 80px;">
                <h1 class="text-center">Two Step Verification</h1>
                <p style="font-style: italic; color:gray" class="text-center">Get the Code from the Google Authenticator</p>
                <hr>
                <form action="check.php" method="post">
                    <div style="text-align: center;">
                    <img style="text-align: center; height: 240px;" class="" src="../assets/img/two_step.gif" alt="Verify this Google Authenticator"><br><br>
                        
                        <p class="text-center text-danger" style="font-style: italic; margin-top: -10px;" > <?php echo $message ?></p>
                        <input type="number" class="form-control mt-2" name="Scode" placeholder="Enter Code" style="font-size: 16px; width: 300px; border-radius: 40px;text-align: center;display: inline;color: #0275d8;"><br> <br>

                        <button type="submit" name="verifyBtn" class="btn btn-md btn-primary" style="width: 160px;border-radius: 40px;">Verify</button>

                    </div>
                    <hr>
                    <p style="font-style: italic;" class="text-center">Power by Google Authenticator </p>

                </form>
            </div>
        </div>
    </div>
</body>

</html>