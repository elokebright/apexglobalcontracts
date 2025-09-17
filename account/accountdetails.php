<?php
require_once("head.php");
require_once("nav.html");
$bankname =$walletdata["bankname"];
$bankaccname =$walletdata["accountname"];
$bankaccnum =$walletdata["accountnumber"];
$btc =$walletdata["BTCaddress"];
$eth =$walletdata["ETHaddress"];
$bnb =$walletdata["BNBaddress"];
$usdterc20 =$walletdata["USDTERC20address"];
$usdttrc20 =$walletdata["USDTTRC20address"];
$gcash =$walletdata["GCASHaddress"];
$binanceid =$walletdata["BINANCEIDaddress"];

 
?>
<div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">
				<h3 class="title1">Add your withdrawal info</h3>
				
				<?php
				
				  if(isset($_POST["updateacc"])){
       
       $usdterc20 = $_POST["usdterc20_address"];
       $usdttrc20 = $_POST["usdttrc20_address"];
     
       $eth = $_POST["eth_address"];
        $btc = $_POST["btc_address"];
         $acc = $_POST["account_number"];
          $accname = $_POST["account_name"];
           $bank = $_POST["bank_name"]; 
           
          $save= $conn->query("UPDATE wallet SET BTCaddress='$btc',ETHaddress='$eth',BNBaddress='$bnb',GCASHaddress='$gcash',BINANCEIDaddress='$binanceid',USDTERC20address='$usdterc20',USDTTRC20address='$usdttrc20',bankname='$bank',accountname='$accname',accountnumber='$acc' WHERE userid='$userid'");
           if($save){
               echo '<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-info alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<i class="fa fa-info-circle"></i> Withdrawal Info updated Sucessfully. You can request withdrawal using this updated detail.
							</div>
						</div>
					</div>';
           }
      }
				?>
                                
				<div class="sign-up-row widget-shadow">
					<form method="post" action="">
					
					<h5>Withdrawal account :</h5>
				
						
						<div class="panel panel-default" style="border:0px solid #fff;">
                                <!-- Panel Heading Starts -->
                    	<div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#bank">
                                Bank transfer</a>
                            </h4>
                    	</div>
                               
                        <div id="bank" class="panel-collapse collapse">
    					
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Bank Name* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="bank_name" value="<?=$bankname?>">
							</div>
							<div class="clearfix"> </div>
						</div>					
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Account Name* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="account_name" value="<?=$bankaccname?>">
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Account Number* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="account_number" value="<?=$bankaccnum?>">
							</div>
							<div class="clearfix"> </div>
						</div>
					

                        </div>
                    </div>
                    
                    
					
					    <div class="panel panel-default" style="border:0px solid #fff;">
                                <!-- Panel Heading Starts -->
                    	<div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#btc">
                                Bitcoin</a>
                            </h4>
                    	</div>
                               
                        <div id="btc" class="panel-collapse collapse">
    				
						<div class="sign-u">
							<div class="sign-up1">
								<h4>BTC Address* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="btc_address" value="<?=$btc?>">
							</div>
							<div class="clearfix"> </div>
						</div>
					

                        </div>
                    </div>
                    
                    <div class="panel panel-default" style="border:0px solid #fff;">
                                <!-- Panel Heading Starts -->
                    	<div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#eth">
                                Ethereum</a>
                            </h4>
                    	</div>
                               
                        <div id="eth" class="panel-collapse collapse">
    				
						<div class="sign-u">
							<div class="sign-up1">
								<h4>ETH Address* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="eth_address" value="<?=$eth?>">
							</div>
							<div class="clearfix"> </div>
						</div>
					

                        </div>
                    </div>
                    
                    <div class="panel panel-default" style="border:0px solid #fff;">
                                <!-- Panel Heading Starts -->
                    	<div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#ltc">
                                Tether (USDT trc20)</a>
                            </h4>
                    	</div>
                               
                        <div id="ltc" class="panel-collapse collapse">
    				
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Tether Address* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="usdttrc20_address" value="<?=$usdttrc20?>">
							</div>
							<div class="clearfix"> </div>
						</div>
					

                        </div>
                    </div>
                     <div class="panel panel-default" style="border:0px solid #fff;">
                                <!-- Panel Heading Starts -->
                    	<div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#erc">
                                USDT erc20</a>
                            </h4>
                    	</div>
                               
                        <div id="erc" class="panel-collapse collapse">
    				
						<div class="sign-u">
							<div class="sign-up1">
								<h4>USDT erc20 Address* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="usdterc20_address" value="<?=$usdterc20?>">
							</div>
							<div class="clearfix"> </div>
						</div>
					

                        </div>
                    </div>
					   
					
					<div class="sub_home">
						<input type="submit" value="Submit" name="updateacc">  &nbsp; &nbsp; 
						<a href="index" style="color:red;">Skip</a>
						<div class="clearfix"> </div>
					</div>
					<input type="hidden" name="id" value="3560">
					<input type="hidden" name="_token" value="dD3HpVqkfyGXu16xJn73rGTTfwBKH7zgiIu9acPA"><br>
				</form>
				</div>
			</div>
		</div>
		
		<?php
require_once("bottom.php");
?>