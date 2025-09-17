
	<div id="depositModal" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">×</button>
			        <h4 class="modal-title" style="text-align:center;">Make new deposit</h4>
			      </div>
			      <div class="modal-body">
                        <form style="padding:3px;"  method="post" action="">
								 <input style="padding:5px;" class="form-control text-light bg-dark" placeholder="Enter amount here" type="text" name="amount" required><br/>
								 
								 <input type="hidden" name="deposit" value="new">
								 <input type="submit" name="newdeposit" class="btn btn-light" value="Continue">
						 </form>
			      </div>
			    </div>
			  </div>
			</div>
		
		<div id="wmethodModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">×</button>
			        <h4 class="modal-title" style="text-align:center;">Add new withdrawal method</h4>
			      </div>
			      <div class="modal-body">
                        <form style="padding:3px;" role="form" method="post" action="S">
					   		<input style="padding:5px;" class="form-control" placeholder="Enter method name" type="text" name="name" required=""><br>
					   		<input style="padding:5px;" class="form-control" placeholder="Minimum amount $" type="text" name="minimum" required=""><br>
					   		<input style="padding:5px;" class="form-control" placeholder="Maximum amount $" type="text" name="maximum" required=""><br>
					   		<input style="padding:5px;" class="form-control" placeholder="Charges (Fixed amount $)" type="text" name="charges_fixed" required=""><br>
					   		<input style="padding:5px;" class="form-control" placeholder="Charges (Percentage %)" type="text" name="charges_percentage" required=""><br>
					   		<input style="padding:5px;" class="form-control" placeholder="Payout duration" type="text" name="duration" required=""><br>
					   		<select name="status" class="form-control">
					   		    <option value="">Select action</option> 
					   		    <option value="enabled">Enable</option> 
					   		    <option value="disabled">Disable</option> 
					   		</select><br>
                             <input type="hidden" name="type" value="withdrawal">
					   		<input type="hidden" name="_token" value="dD3HpVqkfyGXu16xJn73rGTTfwBKH7zgiIu9acPA">
					   		<input type="submit" class="btn btn-default" value="Continue">
					   </form>
			      </div>
			    </div>
			  </div>
			</div>
			
			<div id="withdrawalModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">×</button>
			        <h4 class="modal-title" style="text-align:center;">Payment will be sent to your recieving address.</h4>
			      </div>
			      <div class="modal-body">
                        <form style="padding:3px;" role="form" method="post" action="">
					   		<input style="padding:5px;" class="form-control" placeholder="Enter amount here" type="text" name="amount" required=""><br>
                               
					   		<input type="hidden" name="_token" value="dD3HpVqkfyGXu16xJn73rGTTfwBKH7zgiIu9acPA">
					   		<input type="submit" class="btn btn-default" value="Submit">
					   </form>
			      </div>
			    </div>
			  </div>
			</div>
			
			<div id="plansModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">×</button>
			        <h4 class="modal-title" style="text-align:center;">Add new plan / package</h4>
			      </div>
			      <div class="modal-body">
              <form style="padding:3px;" role="form" method="post" action="https://www.apexpaytrading.com/dashboard/addplan">
							<label>Plan name</label><br>	
							<input style="padding:5px;" class="form-control" placeholder="Enter Plan name" type="text" name="name" required=""><br>
								 <label>Plan price</label><br>
								 <input style="padding:5px;" class="form-control" placeholder="Enter Plan price" type="text" name="price" required=""><br>
								 <label>Plan MIN. price</label><br>		 
            					  <input style="padding:5px;" placeholder="Enter Plan minimum price" class="form-control" type="text" name="min_price" required=""><br>
            					  <label>Plan MAX. price</label><br>		 
								  <input style="padding:5px;" class="form-control" placeholder="Enter Plan maximum price" type="text" name="max_price" required=""><br>
								  <label>Minimum return</label><br>
								<input style="padding:5px;" class="form-control" placeholder="Enter minimum return" type="text" name="minr" required=""><br>
								<label>Maximum return</label><br>
								<input style="padding:5px;" class="form-control" placeholder="Enter maximum return" type="text" name="maxr" required=""><br>
								<label>Gift Bonus</label><br>
								<input style="padding:5px;" class="form-control" placeholder="Enter Additional Gift Bonus" type="text" name="gift" required=""><br>	
								 <!-- <label>Plan expected return (ROI)</label><br/>
								 <input style="padding:5px;" class="form-control" placeholder="Enter expected return for this plan" type="text" name="return" required><br/> -->
								 					 
								<label>top up interval</label><br>
                               <select class="form-control" name="t_interval">
									<option>Monthly</option>
									<option>Weekly</option>
									<option>Daily</option>
									<option>Hourly</option>
								</select><br>
								 <label>top up type</label><br>
                               <select class="form-control" name="t_type">
																		<option>Percentage</option>
																		<option>Fixed</option>
															 </select><br>
															 <label>top up amount (in % or $ as specified above)</label><br>
															 <input style="padding:5px;" class="form-control" placeholder="top up amount" type="text" name="t_amount" required=""><br>
															 <label>Investment duration</label><br>
                               <select class="form-control" name="expiration">
																		<option>One week</option>
																		<option>One month</option>
																	<option>Three months</option>	
																		<option>Six months</option>
																		<option>One year</option>
															 </select><br>
					   		<input type="hidden" name="_token" value="dD3HpVqkfyGXu16xJn73rGTTfwBKH7zgiIu9acPA">
					   		<input type="submit" class="btn btn-default" value="Submit">
					   </form>
			      </div>
			    </div>
			  </div>
			</div>
			
			<div id="s_updModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">×</button>
			        <h4 class="modal-title" style="text-align:center;">This settings page was last updated by</h4>
			      </div>
			      <div class="modal-body">
                        <h3>A</h3>
                        
                        <h4 class="modal-title" style="text-align:center;">Date/Time</h4>
                        
                        <h3>2023-11-29 23:59:24</h3>
			      </div>
			    </div>
			  </div>
			</div>
			
			<div class="modal fade" id="SubpayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h4 class="modal-title" style="text-align:center;">Subscription Payment</h4>
			      </div>

				<form style="padding:3px;" role="form" method="post">
				<div class="modal-body">
					
					<label for="subpay">Duration</label>
						<select class="form-control" onchange="calcAmount(this)" name="duration" id="duratn">
							<option value="default">Select duration</option>
							<option>Monthly</option>
							<option>Quaterly</option>
							<option>Yearly</option>
						</select><br>

						<label>Amount to Pay</label><br>	
						<input style="padding:5px;" class="form-control subamount" type="text" id="amount" disabled=""><br>
						<input id="amountpay" type="hidden" name="amount">
						<input type="hidden" value="Subscription Trading" name="pay_type">
						<input type="hidden" name="_token" value="dD3HpVqkfyGXu16xJn73rGTTfwBKH7zgiIu9acPA">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Pay Now</button>
				</div>
				</form></div>
				

				<script type="text/javascript">
				function calcAmount(sub) {
					if(sub.value=="Quaterly"){
						var amount = document.getElementById('amount');
						var amountpay = document.getElementById('amountpay');
						amount.value = '$60';
						amountpay.value = '60';
					}if(sub.value=="Yearly"){
						var amount = document.getElementById('amount');
						var amountpay = document.getElementById('amountpay');
						amount.value = '$80';
						amountpay.value = '80';
					}if(sub.value=="Monthly"){
						var amount = document.getElementById('amount');
						var amountpay = document.getElementById('amountpay');
						amount.value = '$40';
						amountpay.value = '40';
					}
				}
				</script>
			</div>
			</div>
			
			<div id="submitmt4modal" class="modal fade" role="dialog">
			  <div class="modal-dialog">
			    <!-- Modal content-->
			    <div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h4 class="modal-title" style="text-align:center;">Submit your MT4 Login Details</h4>
			      </div>
			     	<div class="modal-body">
              			<form style="padding:3px;" role="form" method="post" action="https://www.apexpaytrading.com/dashboard/savemt4details">
			  				<label>MT4 ID*: </label><br>	
							<input style="padding:5px;" class="form-control" type="text" name="userid" required=""><br>
							<label>MT4 Password*:</label><br>	
							<input style="padding:5px;" class="form-control" type="text" name="pswrd" required=""><br>
							<label>Account Type:</label><br>	
							<input style="padding:5px;" class="form-control" placeholder="E.g. Standard" type="text" name="acntype" required=""><br>
							<label>Currency*:</label><br>	
							<input style="padding:5px;" class="form-control" placeholder="E.g. USD" type="text" name="currency" required=""><br>
							<label>Leverage*:</label><br>	
							<input style="padding:5px;" class="form-control" placeholder="E.g. 1:500" type="text" name="leverage" required=""><br>
							<label>Server*:</label><br>	
							<input style="padding:5px;" class="form-control" placeholder="E.g. HantecGlobal-live" type="text" name="server" required=""><br>
							<label>Subscription duration</label><br>
							<select class="form-control" name="duration">
								<option value="default">Select duration</option>
								<option>Monthly</option>
								<option>Quaterly</option>
								<option>Yearly</option>
							</select><br>

					   		<input type="hidden" name="_token" value="dD3HpVqkfyGXu16xJn73rGTTfwBKH7zgiIu9acPA">
					   		<input type="submit" class="btn btn-default" value="Submit">
					   </form>
			      </div>
			    </div>
			  </div>
			</div>
		<?php
if (isset($_POST["updatepass"])) {
  $old = $_POST["old_password"];
    $newp1 = $_POST["new_password"];
      $newp2 = $_POST["new_password2"];

 
  $user = $_SESSION["userid"];
$getold = $conn->query("SELECT password FROM accounts WHERE userid ='$user'");
$oldpass = $getold->fetch_assoc()["password"];
if (password_verify($old,$oldpass)) {
         if($newp1  == $newp2){
  $newhash = password_hash($newp1,PASSWORD_DEFAULT);
      
        $emailnotice ="   <tr>
            <td style=\"padding: 0 30px 20px\">
                  <p>Password Changed</p>
                    <p>Your account password has been changed. If you do not recognize this activity, quickly contact our support team for immediate action to protect your account</p>

            </td>
        </tr>";
                    $msg = createEmail2("Account Password Changed",$emailnotice);
                    sendmail("Account Password Changed<info@apexglobalcontracts.com>",$msg,$_SESSION["useremail"],"Account Password Changed");
      $conn->query("UPDATE accounts SET password ='$newhash' WHERE userid ='$user'");
   
        echo "<script>
      swal({
      title:'Done',
     icon:'success',
     text: 'Password Updated'
         });
    setTimeout(function(){
      window.location='index';
  },2000);
    </script>";

}
else{
           echo "<script>
      swal({
      title:'Wrong Password',
     icon:'error',
     text: 'The new passwords you provided does not match'
         });
    setTimeout(function(){
      window.location='changepassword';
  },2000);
    </script>";
}
        
        }
        else{
             echo "<script>
      swal({
      title:'Wrong Password',
     icon:'error',
     text: 'The old password you provided is incorrect'
         });
    setTimeout(function(){
      window.location='changepassword';
  },2000);
    </script>";
        }
 

  
  

}		
		
		
if (isset($_POST["withdrawbonus"])) {
  $amt = $_POST["amount2withdraw"];
  
 
  $user = $_SESSION["userid"];
  
  $bonusbal = $bonusbalance;
  if($amt > 1 && $amt <=$bonusbal){
 

   
      updateWallet($user,$amt,'add');
      $newbal = $walletbalance + $amt;
      $newbonus = $bonusbalance - $amt;
      
        $emailnotice ="   <tr>
            <td style=\"padding: 0 30px 20px\">
                  <p>Bonus Withdrawal of $$amt</p>
                    <p>You have withdrawn $$amt from your bonus to your main account balance.<br>Current Account Balance is $$newbal <br Current Bonus Balance: $$newbonus<</p>

            </td>
        </tr>";
                    $msg = createEmail2("Bonus withdrawal of $$amt",$emailnotice);
                    sendmail("$$amt bonus withdrawal successful<info@apexglobalcontracts.com>",$msg,$_SESSION["useremail"],"Bonus withdrawal of $$amt");
      $conn->query("UPDATE wallet SET bonus ='$newbonus' WHERE userid ='$userid'");
   
        echo "<script>
      swal({
      title:'Done',
     icon:'success',
     text: 'The bonus has been withdrawn into your account balance'
         });
    setTimeout(function(){
      window.location='index';
  },2000);
    </script>";

}

 else{
       echo "<script>
      swal({
      title:'Not Allowed',
     icon:'error',
     text: 'You have insufficient balance to transfer this amount'
         });
    setTimeout(function(){
      window.location='withdraw-bonus';
  },2000);
    </script>";
 }   

}

if (isset($_POST["newtransfer"])) {
  $amt = $_POST["amount2send"];
  
 
  $user = $_SESSION["userid"];
  
  $ownerbalance = $walletbalance;
  if($amt > 5 && $amt <=$ownerbalance){
  $receiver = $_POST["receiver"];
  $receiver_data = $conn->query("SELECT * FROM accounts WHERE email ='$receiver' OR username ='$receiver' OR phone ='$receiver'");
  if($receiver_data->num_rows ==1){
      $dta = $receiver_data->fetch_assoc();
       $receiver_userid=$dta["userid"];
          $receiver_email = $dta["email"];
       
       if($receiver_email ==$_SESSION["useremail"]){
               echo "<script>
      swal({
      title:'Not Allowed',
     icon:'error',
     text: 'You cannot transfer funds to yourself'
         });
    setTimeout(function(){
      window.location='fund-transfer';
  },2000);
    </script>";
    
       }
       else{
       $sender = $user_username;
      $receiver_name = $dta["firstname"]." ".$dta["lastname"];
   
      updateWallet($user,$amt,'minus');
    $sendFund = $conn->query("INSERT INTO deposits (user,amount,reference,address,status) VALUES('$receiver_userid','$amt','fund transfer from $sender','transfer',1)");
    $sendFund = $conn->query("INSERT INTO withdrawals (user,amount,wallet,payoption,status) VALUES('$user','$amt','fund transfer to $receiver_name','$receiver_userid',1)");
    updateWallet($receiver_userid,$amt,'add');
  if ($sendFund) {
      $newbal = $walletbalance - $amt;
      $emailnotice ="   <tr>
            <td style=\"padding: 0 30px 20px\">
                  <p>Fund Transfer of $$amt</p>
                    <p>Your transfer of $$amt to $receiver_name is successful. Your new Account Balance is $$newbal</p>

            </td>
        </tr>";
                    $msg = createEmail2("Transfer of $$amt",$emailnotice);
                    sendmail("$$amt transfer successful<info@apexglobalcontracts.com>",$msg,$_SESSION["useremail"],"Transfer of $$amt");
      
            $emailnotice2 ="   <tr>
            <td style=\"padding: 0 30px 20px\">
                  <p>$$amt Received</p>
                    <p>$name has transfered $$amt to you. The amount has been credited to your account balance</p>

            </td>
        </tr>";
                    $msg = createEmail2("$$amt Received",$emailnotice2);
                    sendmail("$$amt received from $name <info@apexglobalcontracts.com>",$msg,$receiver_email,"Transfer of $$amt recieved");
    echo "<script>
      swal({
      title:'Transfer Success',
     icon:'success',
     text: 'You have transfered $$amt to  $receiver_name'
         });
    setTimeout(function(){
      window.location='fund-transfer';
  },2000);
    </script>";
    
  }
}
}
else{
        echo "<script>
      swal({
      title:'Not Found',
     icon:'warning',
     text: 'The receiver data you provided was not found'
         });
    setTimeout(function(){
      window.location='fund-transfer';
  },2000);
    </script>";
}
}

 else{
       echo "<script>
      swal({
      title:'Transfer Failed',
     icon:'error',
     text: 'You have insufficient balance to transfer this amount'
         });
    setTimeout(function(){
      window.location='fund-transfer';
  },2000);
    </script>";
 }   

}


if(isset($_POST["deposit"])){
    $amt = $_POST["amount"];
    $ref=uniqid(time());
    $save=$conn->query("INSERT INTO deposits(user,amount,reference) VALUES('$userid','$amt','$ref')");
    
echo "<script>location.assign('payment?ref=$ref')</script>";
}
							  
  if(isset($_POST["newwithdrawal"])){
      $checkstatus = $conn->query("SELECT withdrawal FROM accounts WHERE userid ='$userid'");
      $wstatus = $checkstatus->fetch_assoc()["withdrawal"];
      if($wstatus =="blocked"){
           echo "<script>location.assign('withdrawals?m=blocked')</script>";
      }
      else{
      $wamount = $_POST["amount"];
      $method = $_POST["method_id"];
      $paymentmode = $_POST["payment_mode"];
      
      switch($paymentmode){
          case "BTC":
             $userwalletaddress = $walletdata["BTCaddress"]; 
             break;
          case "ETH":
             $userwalletaddress = $walletdata["ETHaddress"]; 
             break;   
         case "usdterc20":
             $userwalletaddress = $walletdata["USDTERC20address"]; 
             break;  
            case "BNB":
             $userwalletaddress = $walletdata["BNBaddress"]; 
             break; 
             case "usdttrc20":
             $userwalletaddress = $walletdata["USDTTRC20address"]; 
             break;
              case "gcash":
             $userwalletaddress = $walletdata["GCASHaddress"]; 
             break;
             case "binanceid":
             $userwalletaddress = $walletdata["BINANCEIDaddress"]; 
             break;
      }
if($userwalletaddress == ""){
    echo "<script>
      swal({
      title:'Missing Wallet Address',
     icon:'error',
     text: 'Please update your account and withdrawal wallet address for ".$paymetmode. ". Then try again.'
         });
    setTimeout(function(){
      window.location='accountdetails';
  },2000);
    </script>";
    
}
    else  if( $wamount <= $walletbalance && $userwalletaddress !=""){
          updateWallet($userid,$wamount,'minus');
          $save=$conn->query("INSERT INTO withdrawals(amount,user,coin,wallet) VALUES('$wamount','$userid','$paymentmode','$userwalletaddress')") ;
          
          
           $emailnotice ="<tr>
            <td style=\"padding: 0 30px 20px\">
                  <p>We have received your withdrawal request for $$wamount</p>
                    <p>Withdrawal Method: $paymentmode<br>Wallet Address: <b>$userwalletaddress</b> </p>
<p>Your request will be processed shortly. A confirmation notice will be sent to you upon completion of your request.</p>
<p>If you do not recognize this activity, quickly contact our support team for immediate action to protect your funds.</p>
            </td>
        </tr>";
                   $msg = createEmail2("Withdrawal of $$wamount submitted",$emailnotice);
                   sendmail('Withdrawal Request Submitted<noreply@apexglobalcontracts.com>',$msg,$_SESSION["useremail"],"Withdrawal Request of $$wamount submitted");
                     
                     
                     
           $adminemailnotice ="   <tr>
            <td style=\"padding: 0 30px 20px\">
                  <p>A user submitted withdrawal of $$wamount</p>
                  <p>User: $name
                    <p>Payment Mode: $paymentmode<br>Wallet Address/Account: <b>$userwalletaddress</b> </p>

            </td>
        </tr>";
                    $msg = createEmail2("withdrawal of $$wamount submitted",$adminemailnotice);
                   sendmail('New Withdrawal Submitted<noreply@apexglobalcontracts.com>',$msg,'support@apexglobalcontracts.com',"New Withdrawal of $$wamount submitted");
                   sendmail('New Withdrawal Submitted<noreply@apexglobalcontracts.com>',$msg,'info@apexglobalcontracts.com',"New Withdrawal of $$wamount submitted");
           
          
          
                    echo "<script>location.assign('withdrawals?m=success')</script>";
      }
      else{
          echo "<script>location.assign('withdrawals?m=insufficient')</script>";
     
      }
  }
  } 
  
?>	
		<?php
require_once("footer.html");
?>	