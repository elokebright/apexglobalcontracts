<?php
require_once("head.php");
require_once("nav.html");
?>
	<div id="page-wrapper">
			<div class="main-page">
				<div class="row">
					<div class="col-lg-5 col-md-5 col-sm-5" style="margin-bottom:5px; padding:0px;">
						<h3 style="color:#555; margin:20px 0px 20px 0px;">Your packages</h3>				
					</div>
				</div>
				
				
				
	<div class="row">
					
					
					<?php 


$deposits = $conn->query("SELECT * FROM investments WHERE user='$userid' AND current =1");
if ($deposits->num_rows != 0) {
    $sn =1;$totaldp = 0.00;
$all = $deposits->fetch_assoc();
$capital = $all["capital"];
$profits = $all["currentprofit"];
$activedays = $all["dayscount"];
$rate = $all["rate"];
$pln = $all["plan"];
$dailyprofit = $capital * $rate/100;
$totaldp += $capital;
$dref = $all["sn"];
$startdate = date("d-m-Y", strtotime($all["dateactivated"]));
$duedate = date("d-m-Y", strtotime($all["duedate"]));
$dstatus = $all["status"];
  if(getActiveCapital($userid) >100){
                $fee = $capital * 0.1;
            }
            else{
                $fee = 0.00;
            }
$st  = ($dstatus == "0") ? "<span class='label label-danger'>Not Active</span>" : "<span class='label label-success'>Active</span>" ;

$action = ($dstatus =="1")?"&nbsp;<button class='label label-danger' onclick='cancellationAlert(\"$fee\",\"$dref\")'>Cancel</button>":"";
echo "";
?>

     <div class="sign-u" style="background-color:#fff; padding:5px 15px 15px 15px;">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 nav-pills bg-primary" style="color:#fff; padding:30px 20px 30px 20px;">
                            <h3><i class="fa fa-money"></i> Current package</h3>
                        </div>
                        <div class="col-lg-8 col-md-8" >
                            <p style="color:#999;">Activated on: <?=$startdate?></p>
                            
                            <h4>Package name: <small><?=$pln?></small></h4>
                            
                            <h4>Amount: <small>$<?=$capital?></small></h4>
                            <h4>Duration: <small>Six months</small></h4>
                                                        <p style="color:green;">Active! <i class="glyphicon glyphicon-ok"></i></p>
                                                    </div>
                    </div>
						
					<div class="clearfix"> </div>
				</div>
<?php
}
else{
    
}
?>
							    
<h3 style="margin:20px 0px 20px 0px;">Concurrent packages</h3>
    
<script>

function cancellationAlert(fee,dref){    
swal({
  title: "Are you sure?",
  theme:'dark',
  text: "Cancelling this investment will terminate your trading profits and attract a charge of $"+fee+"!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
if (willDelete) {
window.location.assign("?do=delete&dref="+dref);
   
    
  } else {
    swal({text:"Investment Not Cancelled!",icon:"info"});
   
  }
});
}
</script>

<?php 
if(isset($_GET["do"]) && isset($_GET["dref"])){
    if($_GET["do"]=='delete'){
        $dref = $_GET["dref"];
        $user = $_SESSION["userid"];
        $invdata = $conn->query("SELECT * FROM investments WHERE sn ='$dref' AND user = '$user'");
        if($invdata->num_rows ==1){
            $invdata = $invdata->fetch_assoc();
            $invamt = $invdata["capital"];
            if(getActiveCapital($user) >100){
                $fee = $invamt * 0.1;
            }
            else{
                $fee = 0.00;
            }
            $capital= $invamt - $fee;
             $do = $conn->query("UPDATE investments SET status =0  WHERE sn = '$dref'");
             updateWallet($user,$capital,'add');
        
          echo "<script>swal('Investment Cancelled');location.assign('mpack.php');</script>";
  
        }
    
       
         
    }
}

$deposits = $conn->query("SELECT * FROM investments WHERE user='$userid' AND current = '0'  ORDER BY sn DESC");
if ($deposits->num_rows != 0) {
    $sn =1;$totaldp = 0.00;
while($all = $deposits->fetch_assoc()){
$capital = $all["capital"];
$profits = $all["currentprofit"];
$activedays = $all["dayscount"];
$pln = $all["plan"];

$getplandata = $conn->query("SELECT * FROM plans WHERE name = '$pln'");
$plandata = $getplandata->fetch_assoc();
$rate = $all["rate"];
$dailyprofit = $capital * $rate/100;
$totaldp += $capital;
$dref = $all["sn"];
$startdate = date("d-m-Y", strtotime($all["dateactivated"]));
$duedate = date("d-m-Y", strtotime($all["duedate"]));
$dstatus = $all["status"];
  if(getActiveCapital($userid) >100){
                $fee = $capital * 0.1;
            }
            else{
                $fee = 0.00;
            }
$st  = ($dstatus == "0") ? "  <p style='color:#fa3425;'>Expired! <i class='fa fa-info-circle'></i></p>" : " <p style='color:green;'>Active! <i class='glyphicon glyphicon-ok'></i></p>" ;

$action = ($dstatus =="1")?"&nbsp;<button class='label label-danger' onclick='cancellationAlert(\"$fee\",\"$dref\")'>Cancel</button>":"";


$sn++;
?>

 
                <a href="mplans" class="btn btn-lg btn-default nav-pills" style="color:#fff; background-color:brown; border-radius: none; ">Add plan</a>
                

  <div class="sign-u" style="background-color:#fff; padding:5px 15px 15px 15px;">

                    <div class="row row-one" style="margin-top:10px;">
                                                                 <div class="col-md-4" style="margin-bottom: 18px;">
                            <div class="flip-card">
                                <div class="flip-card-inner">
                                    <div class="flip-card-front text-center" style="padding-top:25px;">
                                        <i class="fa fa-th" style="font-size:50px; color: red;"></i>
                                        <h1 style="color:green;"><?=$pln?></h1>
										<div style="text-align:left; padding:6px;">
                                        <p style="color:black;"> <b style="color: green;">Activated on: </b><?=$startdate?></p>
																				<p style="color:black;"> <b style="color: green;">ROI: </b><?=$rate?>%</p>
																				<p style="color:black;"> <b style="color: green;">Interval: </b>Weekly</p>
										</div>
                                    </div>
                                    <div class="flip-card-back" style="text-align:left; padding:30px;">
                                        <h3> <b>Amount:</b> $<?=$capital?></h3> 
                                        <h3> <b>Duration: </b>Six months</h3>
										<p style="color:black;"> <b style="color: red;">Min Return: </b>$<?=$plandata['minamount']?></p>
										<p style="color:black;"> <b style="color: red;">Max Return: </b>$<?=$plandata['maxamount']?></p>
                                                                                <?=$st?>
                                                                            </div>
                                </div>
                            </div>
                        </div></div>
                   

<?php

}
} 

else {
    echo"<p>No other plans.</p>";
}



?>


</div>
							</div>
	
	
			</div>
		</div>





<?php
require_once("bottom.php");
?>