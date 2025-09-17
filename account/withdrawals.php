<?php
require_once("head.php");
require_once("nav.html");
$m ="";
if(isset($_GET["m"])){
    $m = $_GET["m"];
    if($m =="success"){

						$m = "<script>
      swal({
      title:'Success',
     icon:'success',
     text: 'Withdrawal Request was was successfully submitted. Please wait for your withdrawal to be processed.'
         });
          setTimeout(function(){
      window.location='withdrawals';
  },2000);
  
    </script>";
    }
    
        if($m =="insufficient"){
       
									$m = "<script>
      swal({
      title:'Low Balance',
     icon:'warning',
     text: 'Sorry, your account balance is insufficient for this request.'
         });
   setTimeout(function(){
      window.location='withdrawals';
  },2000);
    </script>";
    }
           if($m =="blocked"){
       
					
					$m = "<script>
      swal({
      title:'Not Allowed',
     icon:'error',
     text: 'Sorry, withdrawals are not allowed on your account at the moment. Please contact our support team for more details and assistance.'
         });
   setTimeout(function(){
      window.location='withdrawals';
  },2000);
    </script>";
    }
}
?>
<div id="page-wrapper" style="min-height: 556px;">
			<div class="main-page signup-page">
				
				
               <!-- <a class="btn btn-default" href="#" data-toggle="modal" data-target="#withdrawalModal"><i class="fa fa-plus"></i> Request withdrawal</a>-->
			   
<?=$m?>
                <div class="row">
                    <h3 class="title1">Request For Withdrawal</h3>
                    	<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-info">
								
								<i class="fa fa-info-circle"></i> Select any of the available withdrawal options: Bitcoin or USDT 
							</div>
						</div>
					</div>
                                        <div class="col-lg-4">
                        <div class="panel panel-default" style="border:0px solid #fff;">
                                    <!-- Panel Heading Starts -->
                        	<div class="panel-heading">
                                <h3>
                                    Bitcoin
                                </h3>
                        	</div>
                                   
                            <div class="panel-body">
    						<h4>Minimum amount: <strong style="float:right;"> $20</strong></h4><br>
    						
    						<h4>Maximum amount:<strong style="float:right;"> $100000</strong></h4><br>
    						
    						<h4>Charges (Fixed):<strong style="float:right;"> $0</strong></h4><br>
    						
    						<h4>Charges (%): <strong style="float:right;"> 0%</strong></h4><br>
    						
    						<h4>Duration:<strong style="float:right;"> Immediately</strong></h4><br>
    						
    						<a class="btn btn-default" href="#" data-toggle="modal" data-target="#withdrawalModal7"><i class="fa fa-plus"></i> Request withdrawal</a>
    						</div>
                        </div>
                    </div>
                    
                    <!-- Withdrawal Modal -->
        			<div id="withdrawalModal7" class="modal fade" role="dialog">
        			  <div class="modal-dialog">
        
        			    <!-- Modal content-->
        			    <div class="modal-content">
        			      <div class="modal-header">
        			        <button type="button" class="close" data-dismiss="modal">×</button>
        			        <h4 class="modal-title" style="text-align:center;">Payment will be sent through your selected method: Bitcoin</h4>
        			      </div>
        			      <div class="modal-body">
                             	<form style="padding:3px;" role="form" method="post" action="">
										    <label>Available Balance: $<?=$walletbalance?></label>
										    <br>
											   <input class="form-control p-3 text-light bg-dark" placeholder="Enter amount to withdraw" type="text" name="amount" required=""><br>
											   <input class="form-control text-light bg-dark " value="Bitcoin" type="text" disabled=""><br>
											   <input value="BTC" type="hidden" name="payment_mode">
											   <input value="1" type="hidden" name="method_id"><br>
											   
											   <input type="hidden" name="_token" value="VXLmUjaxjMfsOcScAV3RFvKXzf0VBVdmRdia1sB8">
											   <input type="submit" class="btn btn-primary" name="newwithdrawal" value="Submit" >
									   </form>
        			      </div>
        			    </div>
        			  </div>
        			</div>
        			<!-- /Withdrawals Modal -->
                                        <div class="col-lg-4">
                        <div class="panel panel-default" style="border:0px solid #fff;">
                                    <!-- Panel Heading Starts -->
                        	<div class="panel-heading">
                                <h3>
                                    USDT erc20
                                </h3>
                        	</div>
                                   
                            <div class="panel-body">
    						<h4>Minimum amount: <strong style="float:right;"> $20</strong></h4><br>
    						
    						<h4>Maximum amount:<strong style="float:right;"> $100000</strong></h4><br>
    						
    						<h4>Charges (Fixed):<strong style="float:right;"> $0</strong></h4><br>
    						
    						<h4>Charges (%): <strong style="float:right;"> 0%</strong></h4><br>
    						
    						<h4>Duration:<strong style="float:right;"> Immediately</strong></h4><br>
    						
    						<a class="btn btn-default" href="#" data-toggle="modal" data-target="#withdrawalModal9"><i class="fa fa-plus"></i> Request withdrawal</a>
    						</div>
                        </div>
                    </div>
                    
                    <!-- Withdrawal Modal -->
        			<div id="withdrawalModal9" class="modal fade" role="dialog">
        			  <div class="modal-dialog">
        
        			    <!-- Modal content-->
        			    <div class="modal-content">
        			      <div class="modal-header">
        			        <button type="button" class="close" data-dismiss="modal">×</button>
        			        <h4 class="modal-title" style="text-align:center;">Payment will be sent through your selected method: USDT erc20</h4>
        			      </div>
        			      <div class="modal-body">
                             	<form style="padding:3px;" role="form" method="post" action="">
										    										    <label>Available Balance: $<?=$walletbalance?></label><br>
											   <input class="form-control p-3 text-light bg-dark" placeholder="Enter amount to withdraw" type="text" name="amount" required=""><br>
											   <input class="form-control text-light bg-dark " value="usdterc20" type="text" disabled=""><br>
											   <input value="usdterc20" type="hidden" name="payment_mode">
											   <input value="7" type="hidden" name="method_id"><br>
											   
											   <input type="hidden" name="_token" value="VXLmUjaxjMfsOcScAV3RFvKXzf0VBVdmRdia1sB8">
											   <input type="submit" class="btn btn-primary" name="newwithdrawal" value="Submit">
									   </form>
        			      </div>
        			    </div>
        			  </div>
        			</div>
        			<!-- /Withdrawals Modal -->
        			
        			
        			
        			         <div class="col-lg-4">
                        <div class="panel panel-default" style="border:0px solid #fff;">
                                    <!-- Panel Heading Starts -->
                        	<div class="panel-heading">
                                <h3>
                                    USDT trc20
                                </h3>
                        	</div>
                                   
                            <div class="panel-body">
    						<h4>Minimum amount: <strong style="float:right;"> $20</strong></h4><br>
    						
    						<h4>Maximum amount:<strong style="float:right;"> $100000</strong></h4><br>
    						
    						<h4>Charges (Fixed):<strong style="float:right;"> $0</strong></h4><br>
    						
    						<h4>Charges (%): <strong style="float:right;"> 0%</strong></h4><br>
    						
    						<h4>Duration:<strong style="float:right;"> Immediately</strong></h4><br>
    						
    						<a class="btn btn-default" href="#" data-toggle="modal" data-target="#withdrawalModal9b"><i class="fa fa-plus"></i> Request withdrawal</a>
    						</div>
                        </div>
                    </div>
                    
                    <!-- Withdrawal Modal -->
        			<div id="withdrawalModal9b" class="modal fade" role="dialog">
        			  <div class="modal-dialog">
        
        			    <!-- Modal content-->
        			    <div class="modal-content">
        			      <div class="modal-header">
        			        <button type="button" class="close" data-dismiss="modal">×</button>
        			        <h4 class="modal-title" style="text-align:center;">Payment will be sent through your selected method: USDT trc20</h4>
        			      </div>
        			      <div class="modal-body">
                              	<form style="padding:3px;" role="form" method="post" action="">
										    										    <label>Available Balance: $<?=$walletbalance?></label><br>
											   <input class="form-control p-3 text-light bg-dark" placeholder="Enter amount to withdraw" type="text" name="amount" required=""><br>
											   <input class="form-control text-light bg-dark " value="usdttrc20" type="text" disabled=""><br>
											   <input value="usdttrc20" type="hidden" name="payment_mode">
											   <input value="7" type="hidden" name="method_id"><br>
											   
											   <input type="hidden" name="_token" value="VXLmUjaxjMfsOcScAV3RFvKXzf0VBVdmRdia1sB8">
											   <input type="submit" class="btn btn-primary" name="newwithdrawal" value="Submit">
									   </form>
        			      </div>
        			    </div>
        			  </div>
        			</div>
        			<!-- /Withdrawals Modal -->
                                    </div>
				
                <h3 class="title1">Your Withdrawals</h3>
				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th>ID</th> 
								<th>Amount requested</th>
								<th>Amount + charges</th>
                                <th>Recieving mode</th>
								<th>Status</th> 
                                <th>Date created</th>
							</tr> 
						</thead> 
						<tbody> 
													</tbody> 
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
                        <form style="padding:3px;" role="form" method="post" action="">
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
              <form style="padding:3px;" role="form" method="post" action="">
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

				<form style="padding:3px;" role="form" method="post" action="" id="priceform">
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
              			<form style="padding:3px;" role="form" method="post" action="">
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