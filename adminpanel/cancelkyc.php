<?php
require_once("../cf/func.php");
if(isset($_GET["u"])){
    $usr=validateFormInput($_GET['u']);
    
  $user_data = $conn->query("SELECT * FROM accounts WHERE userid = '$usr' LIMIT 1");
  $r = $user_data->fetch_assoc();
  $emailverified = $r["emailverified"];
  $owner_email = $r["email"];
  $owner_fname = $r["firstname"];
$kyc = $r["kyc"];

$save=mysqli_query($conn,"UPDATE accounts SET idverified='0',kyc='2', idfront='', idback='' WHERE userid ='$usr'");

    $msg = "
                    <tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 20px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\">
                            <p style=\"margin: 0;\"><span target=\"_blank\" style=\"color: #14183d;\"><b>Dear $owner_fname,</b><br>Your KYC application was declined. Kindly update your profile 
                            </p>
                        </td>
                    </tr>
                   
                    ";
                     $mailmsg = createEmail2("KYC declined",$msg);
                    sendmail('KYC declined<info@apexglobalcontracts.com>',$mailmsg,$owner_email,'KYC Declined');

    if($save){
       
         echo '<script>alert("cancelled");location.assign("kycs");</script>';
    }
    else{
      
          echo '<script>alert("cancelled");location.assign("kycs");</script>';
    }
   
}
?>