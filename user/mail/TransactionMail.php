<?php 
    


    require 'PHPMailerAutoload.php';
    require 'class.smtp.php';
    
    // debitMoneyMail("prativapun96@gmail.com", "Digambar", "40", "60", "12-04-21", "1234567890");




    function OtpMail($otp, $userMail){

        
        $mail  = new PHPMailer;
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->Port=587;
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';

        $mail->Username = 'punprativa46@gmail.com';
        $mail->Password='moyfrqcmvtddfzjl';

        $content = file_get_contents('../mail/otpMailTemp.php');
        $mail->setFrom("punprativa46@gmail.com", "Sky Bank");
        $mail->addAddress($userMail);
        $mail->addReplyTo("punprativa46@gmail.com");

        $mail->isHTML(true);
        $mail->Subject="Sky Bank Transaction OTP";

        $swap_var = array(

            "{otp}"=> "$otp",

        );

        foreach(array_keys($swap_var) as $key){
            if(strlen($key) > 2 && trim($key) !=""){
                $content = str_replace($key, $swap_var[$key], $content);
            }

        }
         
        $mail->Body="$content";
        
        if(!$mail->send()){
            echo"mail not sent";
            return "fail";
        }
        else{
            
            return "done";
        }
        
    }







    function debitMoneyMail($customerMail, $name, $amount, $totalAmount, $date, $AccountNo){

        
        $mail  = new PHPMailer;
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->Port=587;
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';

        $mail->Username = 'punprativa46@gmail.com';
        $mail->Password='moyfrqcmvtddfzjl';

        $content = file_get_contents('../mail/DebitMailTemp.php');
        $mail->setFrom("punprativa46@gmail.com", "Sky Bank");
        $mail->addAddress($customerMail);
        $mail->addReplyTo("punprativa46@gmail.com");

        $mail->isHTML(true);
        $mail->Subject="Your Account '$AccountNo' has been debited";

        $swap_var = array(

            "{Name}"=> "$name",
            "{AccountNo}"=>"$AccountNo",
            "{Amount}"=>"$amount",
            "{Date}"=>"$date",
            "{totalAmount}"=>"$totalAmount"

        );

        foreach(array_keys($swap_var) as $key){
            if(strlen($key) > 2 && trim($key) !=""){
                $content = str_replace($key, $swap_var[$key], $content);
            }

        }
         
        $mail->Body="$content";
        

        if(!$mail->send()){
            echo"mail not sent";
        }
        
    }

    function creditMoneyMail($customerMail, $name, $amount, $totalAmount, $date, $AccountNo){
        $mail  = new PHPMailer;
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->Port=587;
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';

        $mail->Username = 'punprativa46@gmail.com';
        $mail->Password='moyfrqcmvtddfzjl';

        $content = file_get_contents('../mail/CreditMailTemp.php');
        $mail->setFrom("punprativa46@gmail.com", "Sky Bank");
        $mail->addAddress($customerMail);
        $mail->addReplyTo("punprativa46@gmail.com");

        $mail->isHTML(true);
        $mail->Subject="Your Account '$AccountNo' can be credited";

        $swap_var = array(

            "{Name}"=> "$name",
            "{AccountNo}"=>"$AccountNo",
            "{Amount}"=>"$amount",
            "{Date}"=>"$date",
            "{totalAmount}"=>"$totalAmount"

        );

        foreach(array_keys($swap_var) as $key){
            if(strlen($key) > 2 && trim($key) !=""){
                $content = str_replace($key, $swap_var[$key], $content);
            }

        }
         
        $mail->Body="$content";
        

        if(!$mail->send()){
            echo"mail not sent";
        }
        
    }  

?>
