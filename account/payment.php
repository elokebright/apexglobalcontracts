 <?php
require_once("head.php");
require_once("nav.html");
if(isset($_GET["ref"])){
    $dref = $_GET["ref"];




$getDeposit = $conn->query("SELECT * FROM deposits WHERE reference = '$dref'");
if ($getDeposit->num_rows  != 1) {
    echo "<script>window.location.assign('nid');</script>";
}
else {
    $depositData = $getDeposit->fetch_assoc();
    $depositAmount = $depositData["amount"];
    
    
    $usernotified = $depositData["notified"];
} 
}
else{
     echo "<script>window.location.assign('nid');</script>";
}
    
  ?>
<div id="page-wrapper" style="min-height: 814px;">
			<div class="main-page signup-page">
				
				
                
                    					<div class="sign-u" style="background-color:#fff; padding:20px;">
						<div class="sign-up1">
							<h4>You are to make payment of <strong>$<?=$depositAmount?></strong> using your preferred mode of payment below. </h4>
							<br>
							<strong>Bitcoin - </strong><br><?=$_SESSION["wallets"]["btcaddress"]?>
							<br>
							<br>
							<strong>USDT trc20 - </strong><br><?=$_SESSION["wallets"]["usdttrc20address"]?>
							<br>
							<br>
							<strong>Ethereum - </strong><br><?=$_SESSION["wallets"]["ethaddress"]?>
							<br>
							<br>
							<strong>USDT erc20 - </strong><br><?=$_SESSION["wallets"]["usdterc20address"]?>
							<br>
							<br>
							
							

							<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  alert("You Copied: " + copyText.value);
}
</script>

																				
							
							
							

														
														
																			
							<div class="alert alert-danger alert-dismissable">
		                         
								<h4>Contact management at <strong>support@apexglobalcontracts.com</strong> for other payment methods.</h4>
							</div>							
						</div>
						
						<div class="clearfix"> </div>
					</div>
				
					<form method="post" action="" enctype="multipart/form-data" style="background-color:#fff; padding:20px; margin-top:10px;">
					<div class="sign-u">
						<div class="sign-up1">
							<label>Upload Payment proof after payment.</label>
						</div>
						<div class="sign-up2">
							<input type="file" name="proof" required="">
						</div>
						<div class="clearfix"> </div>
					</div><br>

					<div class="sign-u">
						<div class="sign-up1">
							<label>Payment mode:</label>
						</div>
						<div class="sign-up2">
						<select name="payment_mode" style="height:40px;">
						
							<option>Bitcoin</option>
							<option>USDT trc20</option>
							<option>Ethereum</option>
							<option>USDT erc20</option>
							
						</select>
						</div>
						<div class="clearfix"> </div>
					</div>

					<div class="sub_home">
						<input type="submit" class="btn btn-default" name="savedeposit" value="Submit payment">
						
						<div class="clearfix"> </div>
					</div>
					<input type="hidden" name="amount" value="<?=$depositAmount?>">
									<input type="hidden" name="pay_type" value="">
									<input type="hidden" name="ref" value="<?=$dref?>">
					<!--<input type="hidden" name="payment_mode" value="">-->
					<input type="hidden" name="_token" value="GxkhFbXbV9whLady8fz8CWlR7QIs3vXr0UceB2SU"><br>
				</form>
							</div>
		</div>
 <?php
 if(isset($_POST["savedeposit"])){
     $dref= $_POST["ref"];
     $paymode = $_POST["payment_mode"];
     $amt = $_POST["amount"];
   switch($paymode){
       case "Bitcoin";
       $payaddr = $_SESSION["wallets"]["btcaddress"];
       break;
       case "Ethereum";
       $payaddr = $_SESSION["wallets"]["ethaddress"];
       break;
         case "BNB";
       $payaddr = $_SESSION["wallets"]["bnbaddress"];
       break;
       case "USDT erc20";
       $payaddr = $_SESSION["wallets"]["usdterc20address"];
       break; 
        case "USDT trc20";
       $payaddr = $_SESSION["wallets"]["usdttrc20address"];
       break;
   }
      $file_folder = "assets/depositproof/";
    $selected_file = $_FILES["proof"]["name"];
    $file_extension = pathinfo($selected_file, PATHINFO_EXTENSION);
    $filetokeep =  $file_folder.$dref.".".$file_extension;
    $conn->query("UPDATE deposits SET coin ='$paymode', address='$payaddr',proof='$filetokeep' WHERE reference='$dref'");
    if(move_uploaded_file($_FILES["proof"]["tmp_name"],$filetokeep)){
           $emailnotice ="<tr>
            <td style=\"padding: 0 30px 20px\">
                  <p>We have received your deposit request of $$amt</p>
                    <p>Payment Mode: $paymode<br>Wallet Address/Account: <b>$payaddr</b> </p>
<p>We will verify your payment and credit your account accordingly. Thank you for believing in us.</p>
            </td>
        </tr>";
                    $msg = createEmail2("Deposit of $$amt submitted",$emailnotice);
                    sendmail('Deposit Submitted<info@apexglobalcontracts.com>',$msg,$_SESSION["useremail"],"Deposit of $$amt submitted");
       
        
        
           $adminemailnotice ="   <tr>
            <td style=\"padding: 0 30px 20px\">
                  <p>A user submitted deposit of $$amt</p>
                  <p>User: $name
                    <p>Payment Mode: $paymode<br>Wallet Address/Account: <b>$payaddr</b> </p>

            </td>
        </tr>";
                    $msg = createEmail2("Deposit of $$amt submitted",$adminemailnotice);
                    sendmail('New Deposit Submitted<no-reply@apexglobalcontracts.com>',$msg,'info@apexglobalcontracts.com',"New Deposit of $$amt submitted");
        echo "<script>alert('payment submitted');
        location.assign('../')</script>";
        
        
    }
 }
  require_once("bottom.php");

  ?>
