<?php
if(isset($_GET["loginas"])){
    session_start();
    $_SESSION["userid"] = $_GET["loginas"];
}
require_once("head.php");
require_once("nav.html");
?>
	
		<!-- Verify Modal -->
			<div id="verifyModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">×</button>
			        <h4 class="modal-title" style="text-align:center;">KYC verification - Upload documents below to get verified.</h4>
			      </div>
			      <div class="modal-body">
                        <form style="padding:3px;" role="form" method="post" action="https://apexglobalcontracts.com/account/savevdocs" enctype="multipart/form-data">
                            <label>Valid identity card. (e.g. Drivers licence, international passport or any government approved document).</label>
                            <input type="file" name="id" required=""><br>
					   		<label>Passport photogragh</label>
                            <input type="file" name="passport" required=""><br>
                               
					   		<input type="hidden" name="_token" value="Ic0ESRHjYkuYJD7YkK4rvKpdAucQnnULdnAwKapW">
					   		<input type="submit" class="btn btn-default" value="Submit documents">
					   </form>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- /Verify Modal --><br><br>		<!-- main content start-->
		<div id="page-wrapper" style="padding-left: 0px; padding-right: 5px; min-height: 556px;">
			<div class="main-page mp">
				<div class="sign-u" style="background-color:#fff; padding:5px 15px 5px 15px;">
						<div class="sign-up1">
							<h4><i class="fa fa-bell"></i> 
							
<!--Dear esteemed investor, 
Kind regards 
Apexpay Management 
Teams -->
							
							</h4>
						</div>
					<div class="clearfix"> </div>
				</div>

				
				
                
<div style="height:62px; background-color: #FFFFFF; overflow:hidden; box-sizing: border-box; border: 1px solid #56667F; border-radius: 4px; text-align: right; line-height:14px; block-size:62px; font-size: 12px; font-feature-settings: normal; text-size-adjust: 100%; box-shadow: inset 0 -20px 0 0 #56667F;padding:1px;padding: 0px; margin: 0px; width: 100%;"><div style="height:40px; padding:0px; margin:0px; width: 100%;"><iframe src="assets/widget.html" width="100%" height="36px" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe></div><div style="color: #FFFFFF; line-height: 14px; font-weight: 400; font-size: 11px; box-sizing: border-box; padding: 2px 6px; width: 100%; font-family: Verdana, Tahoma, Arial, sans-serif;"><a href="https://coinlib.io/" target="_blank" style="font-weight: 500; color: #FFFFFF; text-decoration:none; font-size:11px"></a>&nbsp;</div></div>



				<div class="row" style="margin-top:20px; text-align:center;">
				    <div class="col-md-3 rp t-b" style="">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-money fa-stack-1x"></i>
                        </span><br>
					    AVAILABLE Balance
					    </h4>
						<h3 style="color:green; margin-top:20px; text-align:center;" title="Your account balance">
							$<b id="walletbal">0.00</b>
						</h3>
					</div>
					
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon3-background"></i>
                          <i class="fa fa-gift fa-stack-1x"></i>
                        </span><br>
					    BONUS Balance
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							$<b id="totalBonus">0.00</b> 
						</h3>
					</div>
					<div class="col-md-3 col-xs-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-briefcase fa-stack-1x"></i>
                        </span><br>
					    Total Deposits
					    </h4>
						<h3 style=" margin-top:20px;" title="Your account balance">
						    						    							$<b id="totalDeposit">0.00</b>
																				</h3>
					</div>
						<div class="col-md-3 col-xs-6 rp t-b" style="">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-unlock fa-stack-1x"></i>
                        </span><br>
					    Total Withdrawals
					    </h4>
						<h3 style=" margin-top:20px;" title="Your account balance">
													$<b id="totalWith">0</b>
												</h3>
					</div>
					</div>
			<div class="row" style="margin-top:20px; text-align:center;">
					<div class="col-md-3 col-xs-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon3-background"></i>
                          <i class="fa fa-gift fa-stack-1x"></i>
                        </span><br>
					    Invested Capital
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							$<b id="activeInv">0.00</b> 
						</h3>
					</div>
					<div class="col-md-3 col-xs-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon2-background"></i>
                          <i class="fa fa-lock fa-stack-1x"></i>
                        </span><br>
					   Total Profit
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							$<b id="totalEarning">0.00</b>
						</h3>
					</div>
				
				
					<div class="col-md-3 col-xs-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon3-background"></i>
                          <i class="fa fa-bullhorn fa-stack-1x"></i>
                        </span><br>
					    Affiliate BONUS
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							$<b id="totalRefBonus">0.00</b>
						</h3>
					</div>

					

				
					<div class="col-md-3 col-xs-6 rp t-b" style="">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-unlock-alt fa-stack-1x"></i>
						</span><br>
						ACTIVE PACKAGES
					    </h4>
						<h3 style=" margin-top:20px;" title="Your account balance">
															<b id="activepackages">0</b>
													</h3>
					</div>
					</div>
					<!--
										<div class="col-md-3 rp" style="text-align:center; color:#fa3425;">
					<h4>Activate account!<br>
					<small>
					<a style="background-color:#fa3425; color:#fff; padding:4px;" href="https://apexglobalcontracts.com/account/mplans">Join a plan</a> 
					</small>
					</h4>
					</div>
						
					-->
			
				<div class="clearfix"> </div>
			</div>
			
			<div id="chart-page">
                <div class="row" style="margin:15px 0px 0px 65px;">




<div class="col-lg-12 col-md-12 col-sm-12">
                        
                       <div style="height:62px; background-color: #FFFFFF; overflow:hidden; box-sizing: border-box; border: 1px solid #56667F; border-radius: 4px; text-align: right; line-height:14px; block-size:62px; font-size: 12px; font-feature-settings: normal; text-size-adjust: 100%; box-shadow: inset 0 -20px 0 0 #56667F;padding:1px;padding: 0px; margin: 0px; width: 100%;"><div style="height:40px; padding:0px; margin:0px; width: 100%;"><iframe src="https://widget.coinlib.io/widget?type=horizontal_v2&theme=light&pref_coin_id=1505&invert_hover=" width="100%" height="36px" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe></div><div style="color: #FFFFFF; line-height: 14px; font-weight: 400; font-size: 11px; box-sizing: border-box; padding: 2px 6px; width: 100%; font-family: Verdana, Tahoma, Arial, sans-serif;"><a href="https://coinlib.io" target="_blank" style="font-weight: 500; color: #FFFFFF; text-decoration:none; font-size:11px"></a>&nbsp;</div></div>



<div style="height:560px; background-color: #FFFFFF; overflow:hidden; box-sizing: border-box; border: 1px solid #56667F; border-radius: 4px; text-align: right; line-height:14px; font-size: 12px; font-feature-settings: normal; text-size-adjust: 100%; box-shadow: inset 0 -20px 0 0 #56667F;padding:1px;padding: 0px; margin: 0px; width: 100%;"><div style="height:540px; padding:0px; margin:0px; width: 100%;"><iframe src="https://widget.coinlib.io/widget?type=chart&theme=light&coin_id=859&pref_coin_id=1505" width="100%" height="536px" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;line-height:14px;"></iframe></div><div style="color: #FFFFFF; line-height: 14px; font-weight: 400; font-size: 11px; box-sizing: border-box; padding: 2px 6px; width: 100%; font-family: Verdana, Tahoma, Arial, sans-serif;"><a href="https://coinlib.io" target="_blank" style="font-weight: 500; color: #FFFFFF; text-decoration:none; font-size:11px"></a>&nbsp;</div></div>





    
    
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="white-box" style="height: 450px;">
                            <h4 style="margin-bottom:5px;"> Forex Market Fundamental Data</h4>
<!-- TradingView Widget BEGIN -->

<span id="tradingview-copyright"><a ref="nofollow noopener" target="_blank" href="https://www.tradingview.com" style="color: rgb(173, 174, 176); font-family: &quot;Trebuchet MS&quot;, Tahoma, Arial, sans-serif; font-size: 13px;"></a></span>
<script src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js">{
  "currencies": [
    "EUR",
    "USD",
    "JPY",
    "BTC",
    "ETH",
    "LTC",
    "GBP",
    "CHF",
    "AUD",
    "CAD",
    "NZD",
    "CNY"
  ],
  "width": "100%",
  "height": "100%",
  "locale": "en"
}</script>

                        </div>

<!-- TradingView Widget END -->
                </div>
                    
               
        
                </div>
        	</div>
		</div>	
<?php
require_once("bottom.php");
?>