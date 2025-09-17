<?php
require_once("head.php");
require_once("nav.html");

if (!isset($_GET["id"])) {

     echo"<script>window.location.assign('users.php')</script>";
}

$user_u= $_GET["id"];

$user_data = $conn->query("SELECT * FROM accounts WHERE username = '$user_u' OR userid ='$user_u' LIMIT 1");


$r = $user_data->fetch_assoc();

$regdate = date("Y-m-d",strtotime($r["regdate"]));$userfirstname = $r["firstname"];
$user_userid = $r["userid"];
$userlastname = $r["lastname"];
$usercountry =$r["country"];
$usercountry =(strlen($usercountry)<3)?$r["iplocation"]:$usercountry;
$userfname = $r["firstname"];$userlname = $r["lastname"];
$name = $r["firstname"]." ".$r["lastname"];
$userphone = $r["phone"];
$useremail = $r["email"];
$user_username = $r["username"];

$_SESSION["user_username"]=$user_username;
$sponsor = $r["sponsor"];

$getsponsorname = $conn->query("SELECT firstname,lastname FROM accounts WHERE refid ='$sponsor'")->fetch_assoc();
$sponsorname = $getsponsorname["firstname"]." ".$getsponsorname["lastname"];

$userrefid = $r["refid"];
$nextofkin =$r["nok"];
$nextofkinphone = $r["nokphone"];
$nextofkinrel = $r["nokrel"];
$nextofkinemail = $r["nokemail"];
$profileimage = $r["profileimage"];
$twofastatus = $r["twofa"];
$address = $r["address"];

$profileimage =(file_exists($profileimage))?$profileimage:"assets/user.png";

$referred_users = getReferredUsers($userrefid);
$iddocument = $r["iddocument"];
$idverified =$r["idverified"];




$walletbalance = $totalcapital = $totalrefbonus =$refBonusRate = $totalwithdrawal = $lastdeposit= $lastwithdrawal= $totaldeposit=$totalearning=$pendingdepsit=$pendingwithdrawal=$refcount=$totalbonuswithdrawal = $activecapital=0;

$totalearning = number_format(getEarningUSD($user_userid),2);

$walletbalance = number_format(walletBalance($user_userid),2);

$bonusdata = $conn->query("SELECT bonus AS amt FROM wallet WHERE userid = '$user_userid'");
if ($bonusdata->num_rows != 0) {
    $walletbonus =($bonusdata->fetch_assoc())["amt"];

}

$totaldeposit = number_format(getUserDeposits($user_userid),2);

$totalcapital =number_format(getTotalCapital($user_userid),2);

$activecapital=getActiveCapital($user_userid);


 if($activecapital >= 2000 ){
	$refBonusRate = "100%";
		}
	else if($activecapital >= 1000 && $activecapital <2000){
	   	$refBonusRate = "70%";
	}
	else if($activecapital >= 100 && $activecapital < 999){
	  	$refBonusRate = "50%";
	}
	else if($activecapital > 10 && $activecapital < 100 ){
	   	$refBonusRate = "30%";
	}
	else{
	    	$refBonusRate = "0%";
	}


$lastdeposit=number_format(getLastDeposit($user_userid),2);

$totaldeposit = number_format(getUserDeposits($user_userid),2);
$totalwithdrawal=number_format(getWithdrawals($user_userid),2);
$pendingwithdrawal = number_format(getWithdrawalsPending($user_userid),2);
$refcount = number_format(getRefCount($user_userid));


$lastwithdrawaldata = $conn->query("SELECT amount AS amt FROM withdrawals WHERE user = '$user_userid' AND  status =1 ORDER BY sn DESC LIMIT 1");

if ($lastwithdrawaldata->num_rows != 0) {
    $lastwithdrawal = ($lastwithdrawaldata->fetch_assoc())["amt"];
}


$referralBonus = number_format(getReferralEarning($user_userid),2);

$dailyprofit = $activecapital * 0.008;
$activecapital = number_format(getActiveCapital($user_userid),2);
$referralBonus = number_format(getReferralEarning($user_userid),2);

 

?>
<div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">
			    <br>
				<h3 class="title1">Manage User:  <?=$name?></h3>
				<div class="row mb-5">
<div class="col panel card p-4 bg-dark"> 
<div class="profile-content row">
<div class="col-xl-6 ui-sortable">

<div class="panel panel-inverse" data-sortable-id="form-validation-1">

<div class="panel-heading ui-sortable-handle">
<h4 class="panel-title">Personal Details</h4>

</div>


<div class="panel-body" style="padding-left:20px">
    
<div style="text-align:left">
<p >Upline(Sponsor)  : <?=$sponsorname ?></p>






<p >First Name  : <?=$userfname ?></p>


<p>Last Name : <?=$userlname ?></p>



<p>Email : <?=$useremail?></p>





<p>Address : <?=$address?></p>


<p>Country: <?=$usercountry?></p>


<p>Phone Number : <?=$userphone?></p>

</div>


</div>


</div>

</div>
<div class="col-xl-6 ui-sortable" style="padding-left:20px">  
<h3 class="m-t-0 m-b-20">Account Wallet And Transactions</h3>
<div class="card panel label-danger label-success" style="padding:6px">
    <h3>Wallet Balance : $<?=$walletbalance?></h3>
      <a href="editwallet?u=<?=$user_u?>" class="text-primary" style="width:200px">Edit Wallet Balance</a>
</div>


<div class="card panel label-danger label-success" style="padding:6px">
    <h3> Bonus : $<?=$walletbonus?></h3>
      <a href="addbonus?u=<?=$user_u?>" class="text-primary" style="width:200px">Edit/add Bonus </a>
</div> 

<div class="card panel label-success" style="padding:6px">
    <h3 class="" data-toggle="collapse" data-target="#userInvestments">Capital Invested : $<?=$activecapital?></h3>
       <a href="addcapital?u=<?=$user_u?>" style="width:100px" class="btn btn-xs btn-primary">Add Capital</a>
</div> 


<div id="userInvestments" class="collaps">
    <div class="table-responsive">
        <h3>Investments History</h3>
<table class="table">
<thead>
<tr>
<th>#</th>
<th nowrap>Date</th>
<th nowrap>Capital</th>
<th nowrap>Daily Rate/Profit</th>
<th nowrap>Active Days</th>
<th nowrap>Profits Earned</th>

<th nowrap>Due Date</th>
<th nowrap>Status</th>
<th nowrap></th>
</tr>
</thead>
<tbody>


<?php


$deposits = $conn->query("SELECT * FROM investments WHERE user='$user_userid'  ORDER BY dateactivated DESC");
if ($deposits->num_rows != 0) {
    $sn =1;$totaldp = 0.00;
while($all = $deposits->fetch_assoc()){
$damount = $all["capital"];
$profits = $all["currentprofit"];
$activedays = $all["dayscount"];
$rate = $all["rate"];
$dailyprofit = $damount * $rate/100;
$totaldp += $damount;
$dref = $all["sn"];
$startdate = date("d/m/Y", strtotime($all["dateactivated"]));
$duedate = date("d/m/Y", strtotime($all["duedate"]));
$dstatus = $all["status"];
  if(getActiveCapital($userid) >100){
                $fee = $damount * 0.1;
            }
            else{
                $fee = 0.00;
            }
$st  = ($dstatus == "0") ? "<span class='label label-danger'>Not Active</span>" : "<span class='label label-success'>Active</span>" ;

$action = ($dstatus =="1")?"&nbsp;<button class='label label-danger' onclick='cancellationAlert(\"$fee\",\"$dref\")'>Cancel</button>":"";
echo "
<tr>
<td>$sn</td>

<td><small>$startdate</small></td>
<td>$". number_format($damount)."</td>
<td>$rate % ($ $dailyprofit) </td>
<td>$activedays</td>
<td>$ $profits</td>
<td>$duedate</td>
<td>$st </td>



</tr>
";
$sn++;

}
} else {
    echo"<tr><td colspan='4'>No records found. You have not made any deposits.</td></tr>";
}



?>


</tbody>
</table>
</div>

    
</div>
<div class="card panel label-success" style="padding:6px">
    <h3 class="" data-toggle="collapse" data-target="#userDeposits">Total Deposit : $<?=$totaldeposit?> </h3>
    <a href="adddeposit?u=<?=$user_u?>" style="width:100px" class="btn btn-xs btn-primary">Add Deposit</a>
</div>

<div id="userDeposits" class="collaps">
    <div class="table-responsive">
        <h3>Deposits History</h3>
<table class="table">
<thead>
<tr>
<th>#</th>
<th nowrap>Date</th>
<th nowrap>Amount</th>
<th nowrap>Deposit Method</th>

</tr>
</thead>
<tbody>


<?php

$deposits_array=array();
$deposits = $conn->query("SELECT * FROM deposits WHERE user='$user_userid' AND status =1 ORDER BY sn DESC");
if ($deposits->num_rows != 0) {
    $sn =1;$totaldp = 0.00;
while($all = $deposits->fetch_assoc()){
$coinamount = $all["amount"];
$usdamount = $all["amount"];
$ref = $all["reference"];
$totaldp += $usdamount;
$wallet = $all["address"];
$coin = $all["coin"];
$ddate = date("d/m/Y H:i", strtotime($all["datesubmited"]));
$ar = array("amount"=>$usdamount,"method"=>"$coin deposit to $wallet","date"=>$ddate);
array_push($deposits_array,$ar);
}
}

$vdeposits = $conn->query("SELECT * FROM deposits WHERE user ='$user_userid' AND status =1 AND (address='voucher' OR address ='transfer') ORDER BY datesubmited DESC");
if ($vdeposits->num_rows > 0) {
 while($all = $vdeposits->fetch_assoc()){
$amount = $all["amount"];

if($all["address"] == "voucher"){
$code = $all["reference"];
$from = mysqli_fetch_array(mysqli_query($conn,"SELECT generator FROM transfercodes WHERE code = '$code'"))["generator"];
$from = mysqli_fetch_array(mysqli_query($conn,"SELECT username FROM accounts WHERE userid='$from'"))["username"];
$from = "Voucher: $code, received from $from ";
}
else{
    $from = $all["reference"];
}
$ddate = date("d/m/Y H:i", strtotime($all["datesubmited"]));

$ar = array("amount"=>$amount,"method"=>$from,"date"=>$ddate);
array_push($deposits_array,$ar);
}
}

if(count($deposits_array)>0){
    $n=1;
    foreach($deposits_array as $dp){
        $amt = $dp["amount"];
        $mtd = $dp["method"];
        $dt = $dp["date"];
        echo "<tr>
        <td>$n</td>
        <td>$dt</td>
        <td>$amt</td>
        <td>$mtd</td>
        </tr>";
        $n++;
    }
    
} else {
    echo"<tr><td colspan='4'>No records found. This user has not made any deposits.</td></tr>";
}



?>


</tbody>
</table>
</div>
</div>
<div class="card panel label-success" style="padding:6px">
    <h3>Last Deposit : $<?=$lastdeposit?></h3>
</div>

<div class="card panel label-success" style="padding:6px">
    <h3 data-toggle="collapse" data-target="#userWithdrawals">Total Withdrawal : $<?=$totalwithdrawal?></h3>
</div>
<div id="userWithdrawals" class="collaps">
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th>#</th>
<th nowrap>Amount</th>
<th nowrap>Date</th>
<th nowrap>Description</th>
<th nowrap>Status</th>

</tr>
</thead>
<tbody>
<?php 

$withdrawals = $conn->query("SELECT * FROM withdrawals WHERE user='$user_userid' ORDER BY daterequested DESC");
 $all_withdrawals = array();
$vcher = $conn->query("SELECT * FROM transfercodes WHERE generator = '$user_userid'");
if($vcher->num_rows != 0){
   
    while($vdata = $vcher->fetch_assoc()){
        $vcode = $vdata["code"];
        $used = $conn->query("SELECT * FROM deposits WHERE reference = '$vcode'");
        if($used->num_rows ==1){
            $vcodeuserdata = $used->fetch_assoc();
            $vcodeuser = $vcodeuserdata["user"];
            $status = $vcodeuserdata["status"];
            $st= ($status == "0") ? "<span class='label label-warning'>pending</span>" : "<span class='label label-success'>completed</span>" ;
            $vcodeuser = mysqli_fetch_array(mysqli_query($conn,"SELECT username FROM accounts WHERE userid='$vcodeuser'"))["username"];
            $amount = $vcodeuserdata["amount"];
            $dateused = date("d/m/Y H:i a", strtotime($vcodeuserdata["datesubmited"]));
            $description = "Voucher Code: $vcode sent to $vcodeuser";
            
            $r = array("status"=>$st,"amount"=>$amount,"date"=>$dateused,"desc"=>$description);
            array_push($all_withdrawals,$r);
            
        }
    }
}
if ($withdrawals->num_rows != 0) {
    $sn =1;$totalwd = 0.00;
while($all = $withdrawals->fetch_assoc()){
$wamount = $all["amount"];
$totalwd += $wamount;
$woption = $all["payoption"];
$wwallet = $all["wallet"];
$wdate = date("d/m/Y H:i a", strtotime($all["daterequested"]));
$wstatus = $all["status"];
$st  = ($wstatus == "0") ? "<span class='label label-warning'>pending</span>" : "<span class='label label-success'>completed</span>" ;
if(strlen($woption)<6){
$des="Withdrawal to $woption Address: $wwallet";
}else{
    $des = $wwallet;
}

$r =   $r = array("status"=>$st,"amount"=>$wamount,"date"=>$wdate,"desc"=>$des);
array_push($all_withdrawals,$r);
}
}

if(count($all_withdrawals) !=0){
    $sn =1;
    foreach($all_withdrawals as $wd){
        $wamount = $wd["amount"];
        $wdate = $wd["date"];
        $des = $wd["desc"];
        echo "
<tr>
<td>$sn</td>
<td>$". number_format($wamount)."</td>
<td>$wdate</td>
<td>$des</td>
<td>$st</td>


</tr>
";
$sn++;

    }
}
 else {
    echo"<tr><td colspan='4'>No records found. User not made any withdrawals.</td></tr>";
}



?>

</tbody>
</table>
</div>
</div>


<div class="card panel label-success" style="padding:6px">
    <h3>Pending Withdrawal : $<?=$pendingwithdrawal?></h3>
</div>
<div class="card panel label-success" style="padding:6px">
    <h3>Referral Commissions : $<?=$referralBonus?></h3>
    <a href="addrefbonus?u=<?=$user_u?>" class="btn btn-xs btn-primary" style="width:200px">Add Ref Bonus </a>
</div>


</div>

<script>
    $(document).ready(function(){
       
            $("#2faform").submit(function(e){
                e.preventDefault();
                $.ajax({
				url: "profile_data.php",
				method: "post",
				data: $("#2faform").serialize(),
				dataType: 'text',
                cache: false,             // To unable request pages to be cached
                success:function(status){
				    	status = $.trim(status);
					if(status === 'enabled'){
					        //$("#register_btn").text("Sign Up");
							//$("#register_btn").attr("disabled", false);
							swal({
							    icon:'success',
							    text:'2FA now enabled'
							});
						//alert("Email Found!", "The email address you provided has already been registered!");
					}
						if(status === 'disabled'){
					        //$("#register_btn").text("Sign Up");
							//$("#register_btn").attr("disabled", false);
							swal({
							    icon:'error',
							    text:'2FA Disabled'
							});
						//alert("Email Found!", "The email address you provided has already been registered!");
					}
                
                }
        });
        
    });
    $("#changepasswordform").submit(function(e){
                e.preventDefault();
                $("#changepassword_btn").text("processing ...");
                	$("#changepassword_btn").attr("disabled", true);
                $.ajax({
				url: "profile_data.php",
				method: "post",
				data: $("#changepasswordform").serialize(),
				dataType: 'text',
                cache: false,            
                success:function(status){
				    	status = $.trim(status);
					if(status === 'success'){
	
					        $("#changepassword_btn").text("change Password");
							$("#changepassword_btn").attr("disabled", false);
							swal({
							    icon:'success',
							    text:'Password updated'
							});

					}
						if(status === 'error'){
					       
							$("#changepassword_btn").attr("disabled", false);
							swal({
							    icon:'error',
							    text:'Incorrect Data'
							});

					}
                
                }
        });
        
    });
    
      $("#profile-form").submit(function(e){
                e.preventDefault();
                $("#saveprofilebtn").text("processing ...");
                	$("#saveprofilebtn").attr("disabled", true);
                $.ajax({
				url: "profile_data.php",
				method: "post",
				data: $("#profile-form").serialize(),
				dataType: 'text',
                cache: false,            
                success:function(status){
				    	status = $.trim(status);
					if(status === 'success'){
	
					        $("#saveprofilebtn").text("Submit");
							$("#saveprofilebtn").attr("disabled", false);
							swal({
							    icon:'success',
							    text:'Profile update successful'
							});

					}
						if(status === 'error'){
					       
							$("#saveprofilebtn").attr("disabled", false);
							swal({
							    icon:'error',
							    text:'something went wrong, try again'
							});

					}
                
                }
        });
        
    });
    });
</script>




</div>


<div class="row">


<div class="col-xl-6">
<div class="panel panel-inverse" data-sortable-id="table-basic-4">

<div class="panel-heading">
<h4 class="panel-title">Referrals</h4>

</div>


<div class="panel-body">

<?php
foreach ($referred_users as $level => $users) {
   
?>


				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
				<h5>Level <?=$level?> Referrals</h5>
					<table class="table table-hover"> 
						<thead> 
							<tr> 
							<th>#</th>
								<th>Name</th>
                              <th> Email</th>
                                <th>Date registered</th>
                              
							</tr> 
						</thead> 
						<tbody>

<?php
    if (empty($users)) {
        echo "<tr><td colspan=4>No records found.</td></tr>";
    } else {
  $sn = 1;
        foreach ($users as $user) {
            echo "<tr><td>$sn</td>	<td>{$user['firstname']} {$user['lastname']}</td><td>{$user['email']}</td><td>{$user['regdate']}</td></tr>";
            $sn++;
        }
      
    }
echo "	</tbody> 
					</table>
				</div>";    
}

?>

</div>

</div>










</div>



</div>
    
  	</div>
			</div>
			
					</div>
			</div>
		</div>

<?php
require_once("footer.html");
?>