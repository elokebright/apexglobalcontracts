<?php
require_once("../cf/func.php");
if(isset($_GET["user"])){
    $usr=validateFormInput($_GET['user']);
    
  $user_data = $conn->query("SELECT * FROM accounts WHERE userid = '$usr' LIMIT 1");
  $r = $user_data->fetch_assoc();
  $emailverified = $r["emailverified"];
  $owner_email = $r["email"];
  $owner_fname = $r["firstname"];
$kyc = $r["kyc"];

$save=mysqli_query($conn,"UPDATE accounts SET idverified='1',kyc='1' WHERE userid ='$usr'");

    $msg = "
                    <tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 20px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\">
                            <p style=\"margin: 0;\"><span target=\"_blank\" style=\"color: #14183d;\"><b>Dear $owner_fname,</b><br>Your KYC application has been approved and your identity is confirmed. Your account status has updated to 'VERIFIED'.<br> Thanks you.
                            </p>
                        </td>
                    </tr>
                   
                    ";
                     $mailmsg = createEmail3("KYC verified",$msg);
                    sendmail('Account Verification<info@apexglobalcontracts.com>',$mailmsg,$owner_email,'KYC Approved');

    if($save){
       
         echo 'success';
    }
    else{
      
         echo 'error';
    }
   
}
?>