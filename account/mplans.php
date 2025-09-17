<?php
require_once("head.php");
require_once("nav.html");
?>
<div id="page-wrapper" style="min-height: 556px;">
			<div class="main-page signup-page">
			     <?php
				    if(isset($_POST["joinplan"])){
				        $id = $_POST["id"];
				        $amount = $_POST["iamount"];
				   
					   $pl = $conn->query("SELECT * FROM plans WHERE id='$id'");
if($pl->num_rows == 1){
    
    $plandata = $pl->fetch_assoc();
    
    $pname = $plandata["name"];
    $pid = $plandata["id"];
    $prate = $plandata["weeklyrate"];
    $min = $plandata["minamount"];
    $max = $plandata["maxamount"];
   
    $pdur = $plandata["duration"];

    
}
					if($amount >=$min && $amount <= $max){
			if($amount <= $walletbalance){
      $now = date("Y-m-d H:i:s");
      
      $duetime=date("Y-m-d H:i:s",strtotime("$now + $pdur days"));

  
  $debit = updateWallet($userid,$amount,"minus");
  if ($debit) {
      $ref = uniqid(time());
      
      $up = $conn->query("UPDATE investments SET current = 0 WHERE user ='$userid'");
      $saveInvestment = $conn->query("INSERT INTO investments(user,reference,plan, capital,rate,duedate,lastupdated,current) VALUES('$userid','$ref','$pname','$amount','$prate','$duetime','$now','1')");
       $msg = "
                 
                 
                    <tr>
                        <td style=\"padding: 0 30px 20px\">
                            <p style=\"margin: 0;\"><span target=\"_blank\" style=\"color: #14183d;\">Dear $name,<br> Your investment of $$amount under the $pname plan has been activated. Details:<br></span>
                            Plan: $pname <br>
                            Amount: $$amount<br>
                            Date Activated: $now<br>
                            Duration: $pdur days<br>
                            Daily ROI: $prate %
                         
                            
                            
                            </p>
                        </td>
                    </tr>
                       <tr>
                        <td style=\"padding: 0 30px 20px\">
                           
                            <p>Your daily profits will be credited to your balance. Thank You.
                        </td>
                    </tr> 
                    ";
                     $mailmsg = createEmail2("Investment of $$amount Activated",$msg);
                    sendmail('Investment Activated<info@apexglobalcontracts.com>',$mailmsg,$useremail,"$pname Investment Activated");
                    push_notice($useremail, "$$amount Capital Invested", "Your investment of $amount under the $pname plan has been activated. Your profits will be credited every week");
      
    echo "
    <script>
      swal({
      title:'Investment submitted',
     icon:'info',
     text: 'Automatic trading begins instantly. Your weekly profit will be credited to your wallet every 7 days. Thank You'
         });
    setTimeout(function(){
      window.location='../account';
  },3000);
    </script>";
  }
}
					
					else{
					  echo "   <script>
      swal({
      title:'Insufficient Balance',
     icon:'error',
     text: 'You do not have sufficient funds in your balance to make investment on this plan. Please Make a new deposit.'
         });
    setTimeout(function(){
      window.location='nid';
  },2000);
    </script>";
					}
				        
				    }
				    }
				    ?>
				<h3 class="title1">Available packages</h3>
				
				
						<div class="row">
						    
						            
                                <?php
                                
$getdata = $conn->query("SELECT * FROM plans ORDER BY id ASC");
while ($dt= $getdata->fetch_assoc()){
    $x = $dt["id"];
$name= $dt["name"];
$rt = $dt["weeklyrate"];
$min = $dt["minamount"];
$max = $dt["maxamount"];
if($max <1){
    $maxi = "unlimited";
}
else{
    $maxi = "$".$max;
}
$ref = $dt["referral"];
$dur = $dt["duration"];
if($dur > 30){
    $dur = $dur/30 . " months"; 
}
else{
     $dur = $dur . " days"; 
}

		
                                ?>  
						  <div class="col-lg-4 ">
							<div class="sign-up-row widget-shadow nav-pills" style="width:100%; padding:0px;">
								<h3 style="background-color:#B0B0B0  ; text-align:center; padding:20px; text-transform:uppercase" class=" ">
								<?=$name?>
							
								</h3>
								<div style="padding:15px; text-align:center;">
									<h4><strong>$<?=$min?>+</strong><br><br><small> <b>Min. Possible deposit:</b>  $<?=$min?> <br><b>Max. Possible deposit:</b> <?=$maxi?></small></h4>
									<hr>
									<p><i class="fa fa-star"></i>$<?=$min?> Minimum return</p>
									<hr>
									<p><i class="fa fa-star"></i>$<?=$max?> Maximum return</p>
									<hr>
									<hr>
									<p><i class="fa fa-gift"></i> $0 Gift Bonus</p>
									<hr>
									<form style="padding:3px;" role="form" method="post" action="">
									    <label>Amount to invest: ($<?=$min?> default)</label><br><br>
                                        <input type="number" min="<?=$min?>" max="<?=$max?>" name="iamount" placeholder="$<?=$min?>" class="form-control">
                                       <hr>
            							   <label>Select investment duration</label><br>
                                           <select class="form-control" name="" style="border:0px solid #fff; height:50px; font-weight:bold;" disabled="">
            									<option><?=$dur?></option>
            								</select><br>

									

            							   <input type="hidden" name="id" value="<?=$x?>">
            					   		<input type="hidden" name="_token" value="dD3HpVqkfyGXu16xJn73rGTTfwBKH7zgiIu9acPA">
            					   		<input type="submit" name="joinplan" class="btn btn-block pricing-action btn-primary nav-pills" value="Join plan" style=" border-radius: 40px;">
            					   </form>
								</div>
							</div>
						</div>

				<!-- Deposit for a plan Modal -->
				<div id="depositModal23" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">×</button>
			        <h4 class="modal-title" style="text-align:center;">Make a deposit of <strong>$<?=$min?> to join this plan</strong></h4>
			      </div>
			      <div class="modal-body">
                        <form style="padding:3px;" role="form" method="post" action="">
					   		<input style="padding:5px;" class="form-control" value="<?=$min?>" type="text" name="amount" required=""><br>
                               
					   		<input type="hidden" name="_token" value="dD3HpVqkfyGXu16xJn73rGTTfwBKH7zgiIu9acPA">
					   		<input type="hidden" name="pay_type" value="plandeposit">
					   		<input type="hidden" name="plan_id" value="<?=$x?>">
					   		<input type="submit" class="btn btn-default" value="Continue">
					   </form>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- /deposit for a plan Modal -->
			<?php
}
?>
	
			
			<div id="plansModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">×</button>
			        <h4 class="modal-title" style="text-align:center;">Add new plan / package</h4>
			      </div>
			      <div class="modal-body">
              <form style="padding:3px;" role="form" method="post" action="https://apexglobalcontracts.com/account/addplan">
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

				<form style="padding:3px;" role="form" method="post" action="https://apexglobalcontracts.com/account/nid" id="priceform">
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
              			<form style="padding:3px;" role="form" method="post" action="https://apexglobalcontracts.com/account/savemt4details">
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
require_once("bottom.php");
?>	