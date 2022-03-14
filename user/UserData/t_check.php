<?php
session_start();


require "../UserData/GoogleAuthenticator.php";
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("location: ../UserData/Transfer.php");
    die();
}
$Authenticator = new Authenticator();


$checkResult = $Authenticator->verifyCode($_SESSION['auth_secret'], $_POST['code'], 0);    // 2 = 2*30sec clock tolerance


if ($checkResult) {
    echo "Matched";
    //$_SESSION['failed'] = true;
    header("location: ../UserData/Transfer.php");
    die();
} else {
    header("location:../UserData/transfer_twostep.php?error=invalid code");
       
    
}

