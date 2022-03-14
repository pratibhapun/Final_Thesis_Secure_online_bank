<?php
   include('credentials.php');
   include("TypingDNAVerifyClient.php");

   $typingDNAVerifyClient = new TypingDNAVerifyClient($client_id, $application_id, $secret);

   $typingDNADataAttributes = $typingDNAVerifyClient->getDataAttributes([
      "phoneNumber" => "+9779806268288",
      "language" => "en",
      "mode" => "standard"
   ]);
?>
<html>
   <script src="https://cdn.typingdna.com/verify/typingdna-verify.js"></script>
   <script>
       function callbackFn(payload)
       {
           window.location.href = "verify_otp.php?otp=".concat(payload["otp1"]);
       }
   </script>
   <head>
   </head>
   <body>
   <div class="col-md-6 offset-md-6" style=" text-align:center;" background: white;padding:20px; margin-top:80px;">
        <h1 class="text-center"> TypingDNA Verify </h1>
        <p  style=" font-size:20px; text-aligh:center; font-style: italic; color:gray" class="text-center"> Authenticate by click on the button below </p>
            <div style="text-align:center;">
                    <img style="text-align: center; height: 390px;" class="" src="../assets/img/typing.gif" alt="Verify this Google Authenticator"><br><br>
                                
                        <button
                            class = "typingdna-verify"
                            style=" height: 50px; width: 200px;border-radius: 60px; font-size: 18px; "
                            data-typingdna-client-id=<?php echo $typingDNADataAttributes["clientId"]?>
                            data-typingdna-application-id=<?php echo $typingDNADataAttributes["applicationId"] ?> 
                            data-typingdna-payload=<?php echo $typingDNADataAttributes["payload"]?> 
                            data-typingdna-callback-fn= "callbackFn"
                            >Verify with Typingdna
                        </button>
                </div>

    </div>
   </body>
</html>y>
</html>