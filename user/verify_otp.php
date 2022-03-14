<?php
    include('credentials.php');
    include('TypingDNAVerifyClient.php');
    $typingDNAVerifyClient = new TypingDNAVerifyClient($client_id, $application_id, $secret);

    $response = $typingDNAVerifyClient->validateOTP([
        'phoneNumber' => "+9779806268288",
    ], $_GET['otp1']);
    //print($response);
    header("Location: ../user/UserData/Dashboard.php");
?>
   
