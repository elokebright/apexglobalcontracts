<?php
require_once("head.php");
require_once("nav.html");
?>
<div id="page-wrapper" style="min-height: 556px;">
			<div class="main-page signup-page">
				
			
				
                <h3 class="title1">Manage Withdrawals</h3>
				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table  class="UserTable table table-hover text-light"> 
									<thead> 
										<tr> 
											<th>Sn</th> 
											<th>User</th>
											<th>Amount</th>
											<th>Charge</th>
												<th>Method</th>
												<th>Date</th>
											<th>Status</th> 
											<th></th>
										
										</tr> 
									</thead> 
        									<tbody> 
        									
        									<?php
        									
        									 if(isset($_GET["confirm"])){
        $tc = $_GET["confirm"];
        $getdata = $conn->query("SELECT * FROM withdrawals WHERE sn = '$tc'");
        if($getdata->num_rows ==1){
            $dt = $getdata->fetch_assoc();
            $user = $dt["user"];
              $userdata = mysqli_fetch_array(mysqli_query($conn,"SELECT firstname, lastname,email FROM accounts WHERE userid = '$user'"));
        $user_name = $userdata["firstname"]." ". $userdata["lastname"];
        $useremail = $userdata["email"];
             $amt = $dt["amount"];
                $wcoin = $dt["coin"];
                $coinval = $dt["coinvalue"];
                $waddress = $dt["wallet"];
        switch($wcoin){
            case "bitcoin":
                $wcoin = "BTC";
                break;
            case "ethereum":
                $wcoin = "ETH";
                break;
            case "litecoin":
                $wcoin = "LTC";
                break;
                
                
        }
             $do = $conn->query("UPDATE withdrawals SET status =1 WHERE sn = '$tc'");
             if($do){
               
                    
                    $msg = "
                 
              
                    <tr>
                        <td style=\"padding: 0 30px 20px\">
                            <p>Your withdrawal of $$amt has been processed. Find Transaction details below:<br></b>
                            Coin: $wcoin <br>
                            Wallet Address: $waddress<br>
                            
                         
                            </p>
                        </td>
                    </tr>
                      
                    ";
                     $mailmsg = createEmail2("withdrawal Processed",$msg);
                    sendmail('Withdrawal confirmation<noreply@apexglobalcontracts.com>',$mailmsg,$useremail,'Fund Withdrawal Processed');
                     push_notice($useremail, "$$amt Withdrawal  Processed", "Your withdrawal request for of $$amt  to the  $wcoin address: $waddress has been processed.");

                    echo "<script>
                    
                    alert('Withdrawal Approved');location.assign('withdrawals.php');</script>";
                
             }
        }
    }
    if(isset($_GET["cancel"])){
        $tc = $_GET["cancel"];
        $dt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM withdrawals WHERE sn = '$tc'"));
        $amt = $dt["amount"];
        $user = $dt["user"];
        $d = $conn->query("DELETE FROM withdrawals WHERE sn ='$tc'");
        if($d){
           updateWallet($user,$amt,'add') ;
        }
    }
        									
$d = mysqli_query($conn,"SELECT * FROM withdrawals ORDER BY sn DESC");
if (mysqli_num_rows($d) > 0) {
    $n =1;
    while($r = mysqli_fetch_array($d)) {
      $sn = $r["sn"];
        $amount = $r["amount"];
        $method = $r["coin"];
        $investor = $r["user"];
      $wallet =$r["wallet"];
        $investor = $conn->query("SELECT firstname,lastname FROM accounts WHERE userid='$investor'");
        $investor = $investor->fetch_assoc();
        $investorname  = $investor["firstname"]." ".$investor["lastname"];
        $status = $r["status"];
       $coinvalue = $r["coinvalue"];
        $st =($status ==1)?"paid":"pending";
      $action = ($status ==1)?"paid":"<a class='text-primary' href='?confirm=$sn'>Confirm</a><br> &nbsp;<a class='text-danger' href='?cancel=$sn'>Cancel</a>";
        $date_requested = $r["daterequested"];
       $charge =3;
       $pluscharge = $amount + $charge;
        
        echo "<tr  role=\"row\">
        <td>$n</td>
     
        <td>$investorname</td>
           <td>$amount</td>
           <td>$pluscharge</td>
        <td class=\"center\">$method: $wallet</td>
        <td class=\"center\"> $date_requested </td>
        <td class=\"center\">$st</td>
         <td class=\"center\">$action</td>
        </tr>";
        $n++;

    }
}
    else{
        echo '<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available in table</td></tr></tbody> ';
    }
        									?>
        										        									
        								</table>
				</div>
			</div>
		</div>

	<div id="depositModal" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">×</button>
			        <h4 class="modal-title" style="text-align:center;">Make new deposit</h4>
			      </div>
			      <div class="modal-body">
                        <form style="padding:3px;" role="form" method="post" action="">
					   		<input style="padding:5px;" class="form-control" placeholder="Enter amount here" type="text" name="amount" required=""><br>
                               
					   		<input type="hidden" name="_token" value="dD3HpVqkfyGXu16xJn73rGTTfwBKH7zgiIu9acPA">
					   		<input type="submit" class="btn btn-default" value="Continue">
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
                        <form style="padding:3px;" role="form" method="post" action="https://apexglobalcontracts.com/account/addwdmethod">
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
                        <form style="padding:3px;" role="form" method="post" action="https://apexglobalcontracts.com/account/withdrawal">
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

				<form style="padding:3px;" role="form" method="post" action="https://apexglobalcontracts.com/account/deposit" id="priceform">
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
require_once("footer.html");
?>	