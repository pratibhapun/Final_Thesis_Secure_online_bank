<?php
include ("../user/connection.php");
session_start();
require "../UserData/GoogleAuthenticator.php";



$authenticator = new Authenticator();
if (empty($_SESSION['id'])) {

    header("Location: ../UserData/Transfer.php");
   
}
$user_id =$_SESSION['id'];
$user_result = mysqli_query("select * from transaction where id= '$user_id'") or die (mysql_error());
$user_row=mysql_fetch_array($user_result);

$key =$user_row['TAuthKey'];
$AccountNo=$user_row['AccountNo';]

$qrCodeUrl = $authenticator->getQRCodeGoogleURL($AccountNo, $key,'SkyBank');


if (!isset($_SESSION['failed'])) {
    $_SESSION['failed'] = false;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            background-image: url("https://media.istockphoto.com/photos/iiluminated-padlock-icon-on-blue-background-digital-data-protect-picture-id1325092772?b=1&k=20&m=1325092772&s=170667a&w=0&h=uIUdJMfvBppbPVmhzgDM25pVpuq4TRmuihrxgnvIxuo=");
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
                <p style="font-style: italic; color:gray" class="text-center">Download Google Authenticator in your mobile from play store and scan QR code</p>
                <hr>
                <form id= "LI-form">
                <input type="hidden" id="process_name" name="process_name" value="verify_code" />
                    <div style="text-align: center;">

                        <img style="text-align: center;;" class="img-fluid" src="<?php echo $qrCodeUrl ?>" alt="Verify this Google Authenticator"><br><br>
                        <input type="number" class="form-control mt-2" name="scan_code" id ="scan_code" placeholder="Enter Code" style="font-size: 16px; width: 300px; border-radius: 40px;text-align: center;display: inline;color: #0275d8;"><br> <br>

                        <button type="submit" name="registerVerify" class="btn btn-sucess btn-submit " style="width: 160px;border-radius: 40px;">Verify</button>

                    </div>
                    <hr>
                    <p style="font-style: italic;" class="text-center">Power by Google Authenticator </p>

                </form>
            </div>
        </div>
    </div>

    <script src="js/query.validate.min.js"></script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '.btn-submit', function(ev){
                if ($'#LI-form').valid() == true){
                    var data= $('#LI-form').serialize();
                    $.post('check_user.php'), data, function(data, status){
                        if (data =='done'){
                            window.location= 'Transfer.php';

                        }else{
                            alert('not done');
                        }
                    }
                }

            });

        });
    </script>
</body>

</html>