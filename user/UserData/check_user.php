<?php
include("../user/connection.php");
require "../UserData/GoogleAuthenticator.php";
$authenticator = new Authenticator();
$key =  $authenticator->generateRandomSecret();

$process_name= $_POST['process_name'];
if ($process_name == "transfer_user"){
    $AccountNo= $_POST['AccountNo'];
    $Amount = $_POST['Amount'];
  
   $result = mysql_query("select * from transaction where AccountNo='$AccountNo'") or die(mysql_error)
    if(mysqli_num_rows($result)==0){
        $query = "UPDATE transaction SET TAuthKey='{$key}' WHERE AccountNo='{$AccountNo}'";
        $result = mysqli_query($conn, $query) or die("query fail!") and exit();
        $_SESSION['id']= mysql_insert_id();
        echo "done"

        
    }
    else{
        echo "This Account alrady exixts";
    }


}

if ($process_name == "verify_code"){
    $scan_code=$_POST['scan_code'];
    $user_id =$_SESSION['id'];
    $user_result = mysqli_query('select * from transaction where id ='$user_id'')or die(mysql_error());
    $user_row= mysql_fetch_array($user_result);
    $secret_key =$user_row['TAuthKey'];

    $checkResult = $authenticator-> verifyCode($key, $scan_code,2);

    if ($checkResult){
        $_SESSION['googleVerifyCode'] =$scan_code;
        echo'done'

    }
    else {
        echo ' Code not matched';
    }


}




?>