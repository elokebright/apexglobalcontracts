<?php
require_once("head.php");
require_once("nav.html");
if(!isset($_GET["u"])){
    echo"<script>window.location.assign('accounts')</script>";
}
else{
    $usr = $_GET["u"];
   $user_data = $conn->query("SELECT * FROM accounts WHERE username = '$usr' OR userid='$usr' LIMIT 1");
$r = $user_data->fetch_assoc();

$regdate = date("Y-m-d",strtotime($r["regdate"]));
$userfirstname = $r["firstname"];
$user_userid = $r["userid"];
$userlastname = $r["lastname"];
$user_email = $r["email"];
$userfname = $r["firstname"];$userlname = $r["lastname"];
$name = $r["firstname"]." ".$r["lastname"]; 
}
?>
  
  <div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">
			    <br><br>
	<h1 class="title1 text-light">Add Deposit to user</h1>
	
	
	
	<div class="row mb-5">
					<div class="col text-center card p-4 bg-dark"> 

<form  method="POST" action="">
<fieldset>
   User: <?=$name?>
<div class="form-group row m-b-15">
 
<label class="col-md-3 col-form-label">Enter Amount to Add</label>
<div class="col-md-7">
<input type="text" name="amt2send" class="form-control" placeholder="10" />
</div>
</div>
<div class="form-group row m-b-15">
<label class="col-md-3 col-form-label">Deposit Method</label>
<div class="col-md-7">
	<select name="payment_mode" class="form-control col-lg-4 bg-dark text-light" required>
											<option value="BTC">Bitcoin</option>
										<option value="ETH">Ethereum</option>
										<option value="BNB">BNB</option>
											<option value="usdterc20">USDT ERC20</option>
									
									</select>
									</div>
</div>


<div class="form-group row m-b-15">
<input type="hidden" name="receiverEmail" value="<?=$user_email?>">
</div>
<div class="form-group row">
<div class="col-md-7 offset-md-3">
<button type="submitd" name="submitAddFund" class="btn btn-sm btn-primary m-r-5">submit</button>
<button type="submit" class="btn btn-sm btn-default">Cancel</button>
</div>

<?php

if (isset($_POST["submitAddFund"])) {
  $amt = $_POST["amt2send"];
  $reference_id = uniqid(time());
  $account = $_POST["receiverEmail"];
  $userdt = mysqli_query($conn,"SELECT userid,firstname,lastname FROM accounts WHERE email ='$account'");
  if(mysqli_num_rows($userdt) ==1){
      $userdt =mysqli_fetch_array($userdt);
  $user_id = $userdt["userid"];
  $user_name = $userdt["firstname"]." ".$userdt["lastname"];
       $paymode = $_POST["payment_mode"];
   switch($paymode){
       case "BTC";
       $payaddr = $_SESSION["wallets"]["btcaddress"];
       break;
       case "ETH";
       $payaddr = $_SESSION["wallets"]["ethaddress"];
       break;
         case "BNB";
       $payaddr = $_SESSION["wallets"]["bnbaddress"];
       break;
       case "usdterc20";
       $payaddr = $_SESSION["wallets"]["usdterc20"];
       break;
   }

  $saveDeposit = $conn->query("INSERT INTO deposits (user,amount,reference,coin,status,address) VALUES('$user_id','$amt','$reference_id','$paymode',1,'$payaddr')");
 ;
  if ($saveDeposit &&   updateWallet($user_id,$amt,'add')) {
    echo "
    <script>
    swal({
    icon:'success',
    text:'$$amt has been added to the User $user_name',
    title: 'Success!'
        
    });
    setTimeout(function(){
      window.location='accounts?';
  },2000);
    </script>";
  }
  }
  else{
       echo "
    <script>
    swal({
    icon:'error',
    text:'No account found for this email',
    title: 'Error!'
        
    });
  
    </script>";  
  }
}


?>
</div>
</fieldset>
</form>
    
  	</div>
			</div>
			</div>
			</div>
		</div>

<?php
require_once("bottom.php");
?>