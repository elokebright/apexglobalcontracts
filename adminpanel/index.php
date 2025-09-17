<?php
require_once("head.php");
require_once("nav.html");
?>
	
		
			<!-- /Verify Modal --><br><br>		<!-- main content start-->
		<div id="page-wrapper" style="padding-left: 0px; padding-right: 5px; min-height: 556px;">
			<div class="main-page mp">
				<div class="sign-u" style="background-color:#fff; padding:5px 15px 5px 15px;">
						<div class="sign-up1">
							<h4><i class="fa fa-bell"></i> 

							
							</h4>
						</div>
					<div class="clearfix"> </div>
				</div>

				
				
                



				<div class="row-one" style="margin-top:20px; text-align:center;">
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-users fa-stack-1x"></i>
                        </span><br>
					    <a href="accounts" class="text-primary">Total Users</a>
					    </h4>
						<h3 style=" margin-top:20px;" title="User count">
						    						    							 <b id="totalUsers">0</b> 
																				</h3>
					</div>
					
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-briefcase fa-stack-1x"></i>
                        </span><br>
					   <a href="deposits" class="text-primary"> Total Deposits</a>
					    </h4>
						<h3 style=" margin-top:20px;" title="User count">
						    						    							 $<b id="totalFundsDeposited">0.00</b> 
																				</h3>
					</div>
					
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon3-background"></i>
                          <i class="fa fa-gift fa-stack-1x"></i>
                        </span><br>
					    <a href="withdrawals" class="text-primary">Withdrawals</a>
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							$ <b id="totalWithdrawal">0.00</b>
						</h3>
					</div>
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon3-background"></i>
                          <i class="fa fa-bullhorn fa-stack-1x"></i>
                        </span><br>
					   <a href="investments" class="text-primary"> Total Investments</a>
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							$ <b id="totalInvestment">0.00</b>
						</h3>
					</div>

					<div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-money fa-stack-1x"></i>
                        </span><br>
					    <a href="deposits" class="text-primary">Pending Deposit</a>
					    </h4>
						<h3 style="color:green; margin-top:20px; text-align:center;" title="Your account balance">
							$<b id="pendingdeposits">0.00</b>
						</h3>
					</div>

					<div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-unlock fa-stack-1x"></i>
                        </span><br>
					    <a href="withdrawals" class="text-primary">Pending Withdrawals</a>
					    </h4>
						<h3 style=" margin-top:20px;" title="Your account balance">
													$<b id="pendingwithdrawal">0.00</b>
												</h3>
					</div>
					<div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-unlock-alt fa-stack-1x"></i>
						</span><br>
						Plans
					    </h4>
						<h3 style=" margin-top:20px;" title="Your account balance">
															<?php $g =$conn->query("SELECT * FROM plans");
															echo $g->num_rows;
															?>
													</h3>
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
				</div>
				<div class="row">
					
				</div>
				<div class="clearfix"> </div>
			</div>
			
			<div id="chart-page">
                <div class="row" style="margin:15px 0px 0px 65px;">




<div class="col-lg-12 col-md-12 col-sm-12">
                        
                       <div style="height:62px; background-color: #FFFFFF; overflow:hidden; box-sizing: border-box; border: 1px solid #56667F; border-radius: 4px; text-align: right; line-height:14px; block-size:62px; font-size: 12px; font-feature-settings: normal; text-size-adjust: 100%; box-shadow: inset 0 -20px 0 0 #56667F;padding:1px;padding: 0px; margin: 0px; width: 100%;"><div style="height:40px; padding:0px; margin:0px; width: 100%;"><iframe src="assets/widget(1).html" width="100%" height="36px" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe></div><div style="color: #FFFFFF; line-height: 14px; font-weight: 400; font-size: 11px; box-sizing: border-box; padding: 2px 6px; width: 100%; font-family: Verdana, Tahoma, Arial, sans-serif;"><a href="https://coinlib.io/" target="_blank" style="font-weight: 500; color: #FFFFFF; text-decoration:none; font-size:11px"></a>&nbsp;</div></div>



<div style="height:560px; background-color: #FFFFFF; overflow:hidden; box-sizing: border-box; border: 1px solid #56667F; border-radius: 4px; text-align: right; line-height:14px; font-size: 12px; font-feature-settings: normal; text-size-adjust: 100%; box-shadow: inset 0 -20px 0 0 #56667F;padding:1px;padding: 0px; margin: 0px; width: 100%;"><div style="height:540px; padding:0px; margin:0px; width: 100%;"><iframe src="assets/widget(2).html" width="100%" height="536px" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;line-height:14px;"></iframe></div><div style="color: #FFFFFF; line-height: 14px; font-weight: 400; font-size: 11px; box-sizing: border-box; padding: 2px 6px; width: 100%; font-family: Verdana, Tahoma, Arial, sans-serif;"><a href="https://coinlib.io/" target="_blank" style="font-weight: 500; color: #FFFFFF; text-decoration:none; font-size:11px"></a>&nbsp;</div></div>





    
    
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="white-box" style="height: 450px;">
                            <h4 style="margin-bottom:5px;"> Forex Market Fundamental Data</h4>
<!-- TradingView Widget BEGIN -->


<div style="width: 100%; height: 100%;"><style>
	.tradingview-widget-copyright {
		font-size: 13px !important;
		line-height: 32px !important;
		text-align: center !important;
		vertical-align: middle !important;
		/* @mixin sf-pro-display-font; */
		font-family: -apple-system, BlinkMacSystemFont, 'Trebuchet MS', Roboto, Ubuntu, sans-serif !important;
		color: #B2B5BE !important;
	}

	.tradingview-widget-copyright .blue-text {
		color: #2962FF !important;
	}

	.tradingview-widget-copyright a {
		text-decoration: none !important;
		color: #B2B5BE !important;
	}

	.tradingview-widget-copyright a:visited {
		color: #B2B5BE !important;
	}

	.tradingview-widget-copyright a:hover .blue-text {
		color: #1E53E5 !important;
	}

	.tradingview-widget-copyright a:active .blue-text {
		color: #1848CC !important;
	}

	.tradingview-widget-copyright a:visited .blue-text {
		color: #2962FF !important;
	}
	</style><iframe scrolling="no" allowtransparency="true" frameborder="0" src="assets/saved_resource.html" title="forex cross-rates TradingView widget" lang="en" style="user-select: none; box-sizing: border-box; display: block; height: calc(100% - 32px); width: 100%;"></iframe><div style="height: 32px; line-height: 32px; width: 100%; text-align: center; vertical-align: middle;"><a ref="nofollow noopener" target="_blank" href="https://www.tradingview.com/?utm_source=apexglobalcontracts.com&amp;utm_medium=widget&amp;utm_campaign=forex-cross-rates" style="color: rgb(173, 174, 176); font-family: &quot;Trebuchet MS&quot;, Tahoma, Arial, sans-serif; font-size: 13px;"></a></div></div>

                        </div>

<!-- TradingView Widget END -->
                </div>
                    
               
        
                </div>
        	</div>
		</div>	
<?php
require_once("footer.html");
?>