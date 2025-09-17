<?php
require_once("head.php");
require_once("nav.html");
$m ="";
if(isset($_GET["m"])){
    $m = $_GET["m"];
    if($m =="success"){
       $m= '			<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<i class="fa fa-info-circle"></i> Action Sucessful! Please wait for system to validate this transaction.
							</div>
						</div>
					</div>' ;
    }
        if($m =="insufficient"){
       $m= '				<div class="row">
						<div class="col-lg-12">
						<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<i class="fa fa-info-circle"></i> Your account is insufficient to purchase this plan. Please make a deposit.
							</div>
						</div>
					</div>' ;
    }
}
?>
<div id="page-wrapper" style="min-height: 556px;">
			<div class="main-page signup-page">
				<h3 class="title1">Your deposits</h3>
				
				
				<a class="btn btn-default" href="#" data-toggle="modal" data-target="#depositModal"><i class="fa fa-plus"></i> New deposit</a>
					<?=$m?>
				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table  class="UserTable table table-hover text-light"> 
									<thead> 
										<tr> 
											<th>ID</th> 
											<th>Amount</th>
											<th>Payment mode</th>
											<th>Status</th> 
											<th>Date</th>
											<th></th>
										</tr> 
									</thead> 
									<tbody> 
									<?php
									
									$getdeposit = $conn->query("SELECT * FROM deposits WHERE user ='$userid' ORDER BY datesubmited DESC");
									if($getdeposit->num_rows >0){
									     $sn=1;
									    while($dp = $getdeposit->fetch_assoc()){
									       
									        $damt = $dp["amount"];
									        $meth = $dp["coin"];
									        $dref = $dp["reference"];
									        $st = $dp["status"];
									        $sts = ($st ==0)?"<span class='text-danger'>pending</span>":"<span class='text-primary'>confirmed</span>";
									        $action  = ($st ==0)?"<a class=' btn btn-primary' href='payment?ref=$dref'>pay now</a>":"<a href='' class='btn-default'>view</a>";
									        $dt = date("D M d, Y, h:ia",strtotime($dp["datesubmited"]));
									        echo "		<tr> 
											<th scope=\"row\">$sn</th>
											<td>$$damt</td> 
											<td>$meth</td> 
											<td>$sts</td> 
											<td>$dt</td> 
											<td>$action</td> 
										</tr> ";
										$sn++;
									    }
									}
									?>
																		</tbody> 
								</table>
				</div>
			</div>
		</div>
<?php
require_once("bottom.php");
?>