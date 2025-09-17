<?php
session_start();
require_once("db_config.php");


function validateFormInput($input){
	$output = trim($input);
	$output = stripcslashes($output);
	$output = htmlspecialchars($output);
	return $output;

}


function getReferredUsers($user_refid) {
    global $conn;
    $referrals = [
        1 => [],
        2 => [],
        3 => []
    ];

    // LEVEL 1: Direct referrals
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE sponsor = ?");
    $stmt->bind_param("s", $user_refid);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $referrals[1][] = $row;
        $level1_ids[] = $row['refid'];
    }
    $stmt->close();

    // LEVEL 2: Referred by level 1 users
    if (!empty($level1_ids)) {
        $in = implode(',', array_fill(0, count($level1_ids), '?'));
        $types = str_repeat('s', count($level1_ids));
        $stmt = $conn->prepare("SELECT * FROM accounts WHERE sponsor IN ($in)");
        $stmt->bind_param($types, ...$level1_ids);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $referrals[2][] = $row;
            $level2_ids[] = $row['refid'];
        }
        $stmt->close();
    }

    // LEVEL 3: Referred by level 2 users
    if (!empty($level2_ids)) {
        $in = implode(',', array_fill(0, count($level2_ids), '?'));
        $types = str_repeat('s', count($level2_ids));
        $stmt = $conn->prepare("SELECT * FROM accounts WHERE sponsor IN ($in)");
        $stmt->bind_param($types, ...$level2_ids);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $referrals[3][] = $row;
        }
        $stmt->close();
    }

    return $referrals;
}

function sigFig($value, $digits)
{
    if ($value == 0) {
        $decimalPlaces = $digits - 1;
    } elseif ($value < 0) {
        $decimalPlaces = $digits - floor(log10($value * -1)) - 1;
    } else {
        $decimalPlaces = $digits - floor(log10($value)) - 1;
    }

    $answer = ($decimalPlaces > 0) ?
        number_format($value, $decimalPlaces) : round($value, $decimalPlaces);
    return $answer;
}

function coinRate($coin){
    $data = json_decode(file_get_contents("https://coinremitter.com/api/v3/get-coin-rate"));
    if($data->msg == "success"){
        $rate = $data->data->$coin->price;
        return $rate;
    }
    else{
        return "error";
    }
}
function walletBalance($user){
    global $conn;
    $walletbalance = 0;
    $walletdata = $conn->query("SELECT * FROM wallet WHERE userid ='$user'");
if($walletdata->num_rows > 0){
$walletbalance = ($walletdata->fetch_assoc())["balance"];
$walletbalance = round($walletbalance,4);
return $walletbalance;
}
else{
    return 0;
}

}

function getWorkingDays($startDate, $endDate)
{
 $begin = strtotime($startDate);
    $end   = strtotime($endDate);
    if ($begin > $end) {
return 0;
    } else {
        $no_days  = 0;
        $begin += 86400; 
        while ($begin <= $end) {
      $no_days++;
      $begin += 86400; 
        };
       
        return $no_days;
    }
}

function getWorkDays($startDate, $endDate)
{
    //$daysArray=array();
    $begin = strtotime($startDate);
    $end   = strtotime($endDate);
    if ($begin > $end) {

        return 0;
    } else {
        $no_days  = 0;
        $begin += 86400; // +1 day
        while ($begin <= $end) {
             
            $what_day = date("N", $begin);
            if (!in_array($what_day, [6,7]) ) // 6 and 7 are weekend
                $no_days++;
                //array_push($daysArray,date("Y-m-d",$begin));
              $begin += 86400; // +1 day;  
           
        }
        //$_SESSION["daysarray"]=$daysArray;
        return $no_days;
    }
}
function push_notice($user,$title,$msg){
    global $conn;
    
    $push = $conn->query("INSERT INTO notifications (user,title,message,status) VALUES('$user','$title','$msg','0')");
}

function verifyLoginStatus(){
	if (isset($_SESSION["userid"])) {
		return $_SESSION["userid"];
	}
	else{
	return false;
	}
}

function verifyAdminLoginStatus(){
	if (isset($_SESSION["adminid"])) {
		return $_SESSION["adminid"];
	}
	else{
	return false;
	}
}
function gentoken(){
	global $conn1;
	$chars = '123456ABCDEFGHIJ789klmnopqrstuvwxyzabcdefghijKLMNOPQRSTUVWXYZ';
	$generated_token= substr(str_shuffle($chars), 0,  10);
	$select="SELECT * FROM tokens WHERE id='$generated_token'";
  $myquerry=mysqli_query($conn1,$select);
  if (mysqli_num_rows($myquerry)>0){
gentoken();
  }
	else {
		# code...
			return $generated_token;
	}

}


function getUserDeposits($user){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT amount as amt,sn FROM deposits WHERE user='$user' AND status =1");
    if(mysqli_num_rows($q)>0){
    $sum=0.00;
	while($r= mysqli_fetch_array($q)){
	    $sum += $r["amt"];
	    
	}
	return $sum;
    }
    else{
        return '0.00';
    }


}
function getUserPendingDeposits($user){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT amount as amt,sn FROM deposits WHERE user='$user' AND status =0");
    if(mysqli_num_rows($q)>0){
    $sum=0.00;
	while($r= mysqli_fetch_array($q)){
	    $sum += $r["amt"];
	    
	}
	return $sum;
    }
    else{
        return '0.00';
    }


}
function getActiveCapital($investor){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM investments WHERE user='$investor' AND status = 1");
	if (mysqli_num_rows($q) !=0) {
	    $amount=0;
	while($data = mysqli_fetch_array($q)){
		$amount += $data["capital"];
	}
	return $amount;
	}
	else{
	return '0.00';
	}
}
function getActiveCapitals(){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM investments WHERE status = 1");
	if (mysqli_num_rows($q) !=0) {
	    $amount=0;
	while($data = mysqli_fetch_array($q)){
		$amount += $data["capital"];
	}
	return $amount;
	}
	else{
	return '0.00';
	}
}
function getTotalCapital($investor){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM investments WHERE user='$investor'");
	if (mysqli_num_rows($q) !=0) {
	    $amount=0;
	while($data = mysqli_fetch_array($q)){
		$amount += $data["capital"];
	}
	return $amount;
	}
	else{
	return '0.00';
	}
}
function getTotalCapitals(){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM investments");
	if (mysqli_num_rows($q) !=0) {
	    $amount=0;
	while($data = mysqli_fetch_array($q)){
		$amount += $data["capital"];
	}
	return $amount;
	}
	else{
	return '0.00';
	}
}

function getTotalMembers(){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM accounts");
	
	
	
	return mysqli_num_rows($q);

}
$wallets= array("btc"=>"asdfghjkl","eth"=>"poiuytrewq");
function getRefCount($investor){
    global $conn1;
    $investorRefID = mysqli_fetch_array(mysqli_query($conn1,"SELECT username FROM accounts WHERE userid='$investor'"))["username"];
    $q= mysqli_query($conn1,"SELECT * FROM accounts WHERE sponsor ='$investorRefID'");
	
	
	
	return mysqli_num_rows($q);

}

function updateWallet($user_or_wallet,$amount,$action){
    global $conn;
    $do = false;
    if($action =="add"){
        $do =$conn->query("UPDATE wallet SET balance = balance+'$amount' WHERE userid ='$user_or_wallet' OR BTCaddress='$user_or_wallet'");
        
        
    }
    if($action =="minus"){
        $do =$conn->query("UPDATE wallet SET balance = balance-'$amount' WHERE userid ='$user_or_wallet' OR BTCaddress='$user_or_wallet'");
    
    }
   return $do; 
}

function getTotalPendingDeposits(){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM deposits WHERE status = 0");
		$sum=0.00;
	while($r= mysqli_fetch_array($q)){
	    $sum += $r["amount"];
	}
	return $sum;

}
function getTotalPendingWithdrawals(){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM withdrawals WHERE status =0");
	$sum=0.00;
	while($r= mysqli_fetch_array($q)){
	    $sum += $r["amount"];
	}
	return $sum;

}

function getTotalConfirmedDeposits(){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM deposits WHERE status =1");
    $sum=0.00;
	while($r= mysqli_fetch_array($q)){
	    $sum += $r["amount"];
	}
	return $sum;


}
function getTotalDeposits(){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM deposits");
    $sum=0.00;
	while($r= mysqli_fetch_array($q)){
	    $sum += $r["amount"];
	}
	return $sum;


}

function getPaidWithdrawals(){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM withdrawals WHERE status =1");
    $sum=0.00;
	while($r= mysqli_fetch_array($q)){
	    $sum += $r["amount"];
	}
	return $sum;


}
function getTotalWithdrawals(){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM withdrawals");
    $sum=0.00;
	while($r= mysqli_fetch_array($q)){
	    $sum += $r["amount"];
	}
	return $sum;


}

function generateVoucherCode(){
    $chars = array('A', 'Q','G','b','H','q','f','n','P','J','R','M','r', 'd','N','F','a','p','D', 'h','m','i','c','j','L','E','B','e','T','t',1,2,'K',3,'C',4,5,'k',6,'S',7,8,'s',9,'g','v','W','z','Z','X','x');
    $voucher ='';
    while(strlen($voucher)<=16){
        $voucher .= $chars[mt_rand(0,(count($chars)-1))];
    }
    return $voucher;
}
function getEarningUSD($investor){
    global $conn1;
    $amount=0;
    $q= mysqli_query($conn1,"SELECT * FROM investments WHERE user='$investor'");
	if (mysqli_num_rows($q) !=0) {
	    
	while($data = mysqli_fetch_array($q)){
	
		$amount += $data["currentprofit"];
	}
		return $amount;
}

	return "0.00";
	
}
$refNetCapital = 0;
function getUplineCommission($userid){
    global $conn;
    $get = $conn->query("SELECT commission_paid FROM investments WHERE user ='$userid'");
    $r = 0 ;
    if($get->num_rows > 0){
        while($a = $get->fetch_assoc()){
            $r += $a["commission_paid"];
        }
    }
    return $r;
}

function getReferralEarning($investor){
    global $conn1;
    
    $refEarning=0;
    $investorRefId=mysqli_fetch_array(mysqli_query($conn1,"SELECT username FROM accounts WHERE userid='$investor'"))["username"];
    
    $q1 = mysqli_query($conn1,"SELECT * FROM accounts WHERE sponsor='$investorRefId'");
    
    if(mysqli_num_rows($q1) != 0){
    while($ref= mysqli_fetch_array($q1)){
    	$refinv=$ref["userid"];
    	$amount=0;
    	$q2= mysqli_query($conn1,"SELECT * FROM investments WHERE user='$refinv'");
		if (mysqli_num_rows($q2) !=0) {
		    while($data = mysqli_fetch_array($q2)){
		        //$refNetCapital +=$data["capital"];
		$amount += $data["commission_paid"];
		
		}
	$refEarning += $amount; 	
	}

    }

      
        
    }
    else{
         $refEarning='0.00';
    }
    
	return $refEarning;
	
}

function getWithdrawals($investor){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM withdrawals WHERE user='$investor' AND status =1");
	if (mysqli_num_rows($q) != 0) {
	    $getdata=mysqli_query($conn1," SELECT SUM(amount) AS sum FROM withdrawals WHERE user='$investor' AND status =1");
		$data = mysqli_fetch_array($getdata);
		return $data["sum"];
	}
	else{
	return '0.0';
	}
}
function getWithdrawalsPending($investor){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM withdrawals WHERE user='$investor' AND status =0");
	if (mysqli_num_rows($q) != 0) {
	    $getdata=mysqli_query($conn1," SELECT SUM(amount) AS sum FROM withdrawals WHERE user='$investor' AND status =0");
		$data = mysqli_fetch_array($getdata);
		return $data["sum"];
	}
	else{
	return '0.00';
	}
}

function getAvailableFundForWithdrawal($investor){
    global $conn1;
    $q1= mysqli_query($conn1,"SELECT * FROM withdrawals WHERE investorid='$investor' AND status =1");
	if (mysqli_num_rows($q1) != 0) {
	    $getdata=mysqli_query($conn1," SELECT SUM(amount) AS sum FROM withdrawals WHERE investorid='$investor' AND status =1");
		$data = mysqli_fetch_array($getdata);
		$totalwithdrawn=$data["sum"];
	}
	else{
	$totalwithdrawn=0;
	}
	
$totalEarning =  getEarningUSD($investor);
/*
	$totaltopupEarning=0;
		 $q3= mysqli_query($conn1,"SELECT * FROM topups WHERE investorid='$investor'");
	if (mysqli_num_rows($q2) != 0) {
	    
	    $getdata=mysqli_query($conn1,"SELECT currentvalue FROM earnings WHERE investorid='$investor' AND status =1");
		while($data = mysqli_fetch_array($getdata)){
		$totaltopopEarning=$data["currentvalue"];
		}
	}
	else{
	$totaltopupEarning=0;
	}
	*/
	$refBonus = getReferralEarning($investor);
	
	
$availableFund= $totalEarning  + $refBonus- $totalwithdrawn;
	return $availableFund;
	
	
}
function getLastDeposit($user){
    global $conn;
    $g = $conn->query("SELECT amount as amt,sn FROM deposits WHERE user='$user' AND status =1 ORDER BY sn DESC");
    if($g->num_rows >= 1){
        $d=$g->fetch_assoc();
        return $d["amt"];
    }
    else{
        return 0.00;
    }
}

function updateProfit($investor){
    global $conn;
    
    $q= mysqli_query($conn,"SELECT sn,user,capital,rate,dateactivated,lastupdated,currentprofit,commission_paid,DATEDIFF(CURRENT_TIMESTAMP,dateactivated) as dcount,DATEDIFF(CURRENT_TIMESTAMP,lastupdated) as dcount2 FROM investments WHERE user = '$investor' AND status =1");
	if (mysqli_num_rows($q) !=0) {
		while($data = mysqli_fetch_array($q)){
		$investmentsn=$data["sn"];
			$investor=$data["user"];
			//$totaldays = $conn->query("SELECT DATEDIFF(day,dateactivated,NOW())")
		$capital =$data["capital"];
		$rate= $data["rate"];
		$activefrom=$data['dateactivated'];
		$lastupdated = $data["lastupdated"];
		$last_profit = $data["currentprofit"];
		$commissionpaid = $data["commission_paid"];
		$sponsor_username = mysqli_fetch_array(mysqli_query($conn,"SELECT sponsor FROM accounts WHERE userid='$investor'"))["sponsor"];
		$sponsor = $conn->query("SELECT userid FROM accounts WHERE username ='$sponsor_username'");
		$sponsor = ($sponsor->fetch_assoc())["userid"];
		$sponsor_capital =  getActiveCapital($sponsor);
		$daycount1 = $data["dcount"];
		$daycount2 = $data["dcount2"];
	
/*$date1=date_create($activefrom);
$date2=date_create($lastupdated);
$now=date_create(date("Y-m-d h:i:s"));

$diff1=date_diff($date1,$now);
$diff2=date_diff($date2,$now);
$current_time =date("Y-m-d h:i:s");
$dayz = getWorkingDays($activefrom,$current_time);
$numberdaysPassedsinceactivation= $diff1->format("%a");
$numberdaysPassedsinceupdate= $diff2->format("%a");
*/
$total_profit = ($capital * ($rate/100)* $daycount1);
$current_profit = ($capital * ($rate/100)* $daycount2);
if($daycount2 >= 1){
	if($sponsor_capital >= 2000 ){
		$sponsor_bonus = $current_profit; 
		}
	else if($sponsor_capital >= 1000 && $sponsor_capital <2000){
	    $sponsor_bonus = $current_profit*0.7; 
	}
	else if($sponsor_capital >= 100 && $sponsor_capital < 999){
	    $sponsor_bonus = $current_profit*0.5; 
	}
	else if($sponsor_capital > 10 && $sponsor_capital < 100 ){
	    $sponsor_bonus = $current_profit*0.3; 
	}
	else{
	      $sponsor_bonus = $current_profit*0; 
	}
		$sponsor_commission = $sponsor_bonus + $commissionpaid;
   $profit_update=$last_profit+$current_profit; 
$q2= "UPDATE investments SET currentprofit = '$profit_update',dayscount='$daycount1',commission_paid = '$sponsor_commission', lastupdated='$current_time',currentvalue='$dayz' WHERE sn ='$investmentsn'";
//$wallet_update = $current_profit - $last_profit;

updateWallet($investor,$current_profit,'add');
updateWallet($sponsor,$sponsor_bonus,'add');
$do = mysqli_query($conn,$q2);
//$do = mysqli_query($conn,$q3);
}
}
}


}

function updateAllProfit($investor){
    global $conn;
    
    $q= mysqli_query($conn,"SELECT sn,user,capital,rate,dateactivated,lastupdated,currentprofit,commission_paid,DATEDIFF(CURRENT_TIMESTAMP,dateactivated) as dcount,DATEDIFF(CURRENT_TIMESTAMP,lastupdated) as dcount2 FROM investments WHERE status =1");
	if (mysqli_num_rows($q) !=0) {
		while($data = mysqli_fetch_array($q)){
		$investmentsn=$data["sn"];
			$investor=$data["user"];
	        $capital =$data["capital"];
		    $rate= $data["rate"];
		    $activefrom=$data['dateactivated'];
		    $lastupdated = $data["lastupdated"];
		    $last_profit = $data["currentprofit"];
		    $commissionpaid = $data["commission_paid"];
		   // $sponsor_username = mysqli_fetch_array(mysqli_query($conn,"SELECT sponsor FROM accounts WHERE userid='$investor'"))["sponsor"];
		    //$sponsor = $conn->query("SELECT userid FROM accounts WHERE username ='$sponsor_username'");
		    //$sponsor = ($sponsor->fetch_assoc())["userid"];
		   // $sponsor_capital =  getActiveCapital($sponsor);
		    $daycount1 = abs($data["dcount"]/7);
		    $daycount2 = abs($data["dcount2"]/7);

    $total_profit = ($capital * ($rate/100)* $daycount1);
    $current_profit = ($capital * ($rate/100)* $daycount2);
    if($daycount2 >= 1){
	if($sponsor_capital >= 2000 ){
		$sponsor_bonus = $current_profit; 
		}
	else if($sponsor_capital >= 1000 && $sponsor_capital <2000){
	    $sponsor_bonus = $current_profit*0.7; 
	}
	else if($sponsor_capital >= 100 && $sponsor_capital < 999){
	    $sponsor_bonus = $current_profit*0.5; 
	}
	else if($sponsor_capital > 10 && $sponsor_capital < 100 ){
	    $sponsor_bonus = $current_profit*0.3; 
	}
	else{
	      $sponsor_bonus = $current_profit*0; 
	}
		$sponsor_commission = $sponsor_bonus + $commissionpaid;
   $profit_update=$last_profit+$current_profit; 
  $current_time =date("Y-m-d h:i:s");
$q2= "UPDATE investments SET currentprofit = '$profit_update',dayscount='$daycount1',commission_paid = '$sponsor_commission', lastupdated='$current_time' WHERE sn ='$investmentsn'";
//$wallet_update = $current_profit - $last_profit;

updateWallet($investor,$current_profit,'add');
updateWallet($sponsor,$sponsor_bonus,'add');
$do = mysqli_query($conn,$q2);
//$do = mysqli_query($conn,$q3);
}
}
}


}

function generateOTP($length) {
    $characters = '0123456789023456789';
    $otp = '';
    $char_length = strlen($characters);

    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, $char_length - 1)];
    }

    return $otp;
}

function formatPhoneNumber($phone){
    
	$phone_formatted = ($phone[0] =='0')? substr_replace($phone,"234",0,1): $phone;
	  return $phone_formatted;
	}



function getEarningRate($investor){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM investments WHERE investorid='$investor'");
	if (mysqli_num_rows($q) !=0) {
		$data = mysqli_fetch_array($q);
		
		    $plan= strtolower($data['plan']);
		    $asset= strtolower($data['asset']);
		    $getrate =mysqli_query($conn1,"SELECT * FROM plans WHERE name='$plan' AND asset='$asset'");
		    $rate=mysqli_fetch_array($getrate)['dailypercentage'];
		    return $rate."% daily <br><i>
            <small><a href='#' data-toggle='control-sidebar' style='color:gold'><i class='fa fa-cog fa-2x fa-spin'></i></a>
          </i>Trading in progress</small>";
	}
	else{
	return '0.00% daily';
	}
}

function getPlan($investor){
    global $conn1;
    $q= mysqli_query($conn1,"SELECT * FROM investments WHERE investorid='$investor'");
	if (mysqli_num_rows($q) !=0) {
		$data = mysqli_fetch_array($q);
		$asset = $data["asset"];
		$assetname="";
		switch($asset){
		    case "forex":
		        $assetname = "Forex";
		        break;
		  case "crypto":
		        $assetname = "Crypto";
		        break; 
		  case "btcmining":
		        $assetname = "BTC Mining";
		        break;      
		        
		}
		return $assetname." ".$data["plan"];
	}
	else{
	return 'None';
	}
}

function sendmail($from,$body,$to,$subject)
        {
     
            $headersfrom='';
            $headersfrom = "MIME-Version: 1.0" . "\r\n";
            $headersfrom .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headersfrom .= 'From: '.$from.' '. "\r\n";
            mail($to,$subject,$body,$headersfrom);
   }
   
   function sendVerificationCode($receiver,$fname,$code){
       $code2=base64_encode($code);
       $rec = base64_encode($receiver);
       $mailmessage ="<tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\">
                            <p style=\"margin: 0;\">We're excited to have you get started. First, you need to confirm your email address and verify your account. Use the Code below or click the confirm button.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor=\"#ffffff\" align=\"left\">
                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                    <td bgcolor=\"#ffffff\" align=\"center\" style=\"padding: 20px 30px 60px 30px;\">
                                        <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                            <tr>
                                                <td align=\"center\">
                                                    <h2>$code</h2>
                                                    <a href=\"https://apexglobalcontracts.com/verify?code=$code2&user=$rec\" target=\"_blank\" style=\"font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px;background-color: navy; border-radius: 2px; border: 1px solid #14183d; display: inline-block;\">Confirm Account</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 0px 30px 0px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\">
                            <p style=\"margin: 0;\">If that doesn't work, copy and paste the following link in your browser:</p>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 20px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\">
                            <p style=\"margin: 0;\"><span target=\"_blank\" style=\"color: #14183d;\">https://apexglobalcontracts.com/verify?code=$code2&user=$rec</span></p>
                        </td>
                    </tr>
                    ";
                    $msg = createEmail2("Hello $fname, Welcome to ApexGlobal",$mailmessage);
                    sendmail('Account Verification<info@apexglobalcontracts.com>',$msg,$receiver,'Account Verification');
                    
   }
 function createEmail2($heading,$body){
     $mailbody = "<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" />
    <style type=\"text/css\">
        @media screen {
            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 400;
                src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 700;
                src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 400;
                src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 700;
                src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
            }
        }

        /* CLIENT-SPECIFIC STYLES */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*=\"margin: 16px 0;\"] {
            margin: 0 !important;
        }
    </style>
</head>

<body style=\"background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;\">
    <!-- HIDDEN PREHEADER TEXT -->
    <div style=\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\"> $heading</div>
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
        <!-- LOGO -->
        <tr>
            <td bgcolor=\"#14183d\" align=\"center\">
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;\">
                    <tr>
                        <td align=\"center\" valign=\"top\" style=\"padding: 40px 10px 40px 10px;\"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor=\"#ffffff\" align=\"center\" style=\"padding: 0px 10px 0px 10px;\">
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;\">
                    <tr>
                        <td align=\"center\" valign=\"top\" style=\"padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;\">
                            <img src=\"https://www.apexglobalcontracts.com/home/template/assets/media/general/apexlogo.png\" width=\"90%\" height=\"100\" style=\"display: block; border: 0px;\" />
                            <h1 style=\"font-size: 28px; font-weight: 300; margin: 2;\">$heading</h1> 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor=\"#f4f4f4\" align=\"center\" style=\"padding: 0px 10px 0px 10px;\">
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;font-size: 14px;\">
                 $body
              
                    <tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 0px 5px 5px 5px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 300; line-height: 25px;\">
                            <p style=\"margin: 0;\">If you have any questions, just reply to this email or contact our support team via live Chat on our website. We're always happy to help out.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 0px 10px 10px 20px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 25px;\">
                            <p style=\"margin: 0;\">Cheers, <br>Apex Global Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
  
       
    </table>
</body>

</html>";
return $mailbody;
 }
   
function createEmailMessage($caption, $message){
    $mailbody="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\">
<head>
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\"/>
<meta content=\"width=device-width\" name=\"viewport\"/>
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\"/>
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<link href=\"https://fonts.googleapis.com/css?family=Cabin\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Merriweather\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Oswald\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Roboto+Slab\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Lato\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}
	</style>
<style id=\"media-query\" type=\"text/css\">
		@media (max-width: 675px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:#ffffff;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 655px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:#ffffff;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:655px\"><tr class=\"layout-full-width\" style=\"background-color:transparent\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"655\" style=\"background-color:transparent;width:655px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 655px; display: table-cell; vertical-align: top; width: 655px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" height=\"15\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 15px; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td height=\"15\" style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:#fb8039;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 655px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #fb8039;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#fb8039;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:#fb8039;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:655px\"><tr class=\"layout-full-width\" style=\"background-color:#fb8039\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"655\" style=\"background-color:#fb8039;width:655px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;background-color:#fb833d;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 655px; display: table-cell; vertical-align: top; background-color: #fb833d; width: 655px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Georgia, serif\"><![endif]-->
<div style=\"color:#555555;font-family:Merriwheater, Georgia, serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"line-height: 1.2; font-size: 12px; color: #555555; font-family: Merriwheater, Georgia, serif; mso-line-height-alt: 14px;\">
<p style=\"font-size: 14px; line-height: 1.2; word-break: break-word; text-align: right; mso-line-height-alt: 17px; margin: 0;\"><a href=\"https://apexglobalcontracts.com\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\">Open in Browser</a></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid mixed-two-up no-stack\" style=\"Margin: 0 auto; min-width: 320px; max-width: 655px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:655px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"218\" style=\"background-color:#ffffff;width:218px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:10px; padding-bottom:10px;\"><![endif]-->
<div class=\"col num4\" style=\"display: table-cell; vertical-align: top; max-width: 320px; min-width: 216px; width: 218px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:10px; padding-bottom:10px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Alternate text\" border=\"0\" class=\"center autowidth\" src=\"https://apexglobalcontracts.com/assets/imqges/meatund-logo.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 218px; display: block;\" title=\"Alternate text\" width=\"218\"/>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td><td align=\"center\" width=\"436\" style=\"background-color:#ffffff;width:436px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num8\" style=\"display: table-cell; vertical-align: top; min-width: 320px; max-width: 432px; width: 436px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div class=\"mobile_hide\">
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 7px; padding-right: 7px; padding-bottom: 7px; padding-left: 7px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid #BBBBBB; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 655px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:655px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"655\" style=\"background-color:#ffffff;width:655px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 655px; display: table-cell; vertical-align: top; width: 655px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 15px; padding-bottom: 10px; padding-left: 15px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px solid #484F4F; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 40px; padding-left: 15px; padding-top: 0px; padding-bottom: 10px; font-family: serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Merriwheater', 'Georgia', serif;line-height:1.5;padding-top:0px;padding-right:40px;padding-bottom:10px;padding-left:15px;\">
<div style=\"font-size: 14px; line-height: 1.5; font-family: 'Merriwheater', 'Georgia', serif; color: #555555; mso-line-height-alt: 21px;\">
<p style=\"font-size: 14px; line-height: 1.5; word-break: break-word; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 21px; margin: 0;\"></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 15px; padding-top: 23px; padding-bottom: 0px; font-family: Georgia, serif\"><![endif]-->
<div style=\"color:#000000;font-family:Merriwheater, Georgia, serif;line-height:1.5;padding-top:23px;padding-right:10px;padding-bottom:0px;padding-left:15px;\">
<div style=\"font-size: 14px; line-height: 1.5; color: #000000; font-family: Merriwheater, Georgia, serif; mso-line-height-alt: 21px;\">
<p style=\"font-size: 18px; line-height: 1.5; word-break: break-word; mso-line-height-alt: 27px; margin: 0;\"><span style=\"font-size: 18px; color: #3366ff;\"><strong><span style=\"\">$caption</span></strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 15px; padding-left: 15px; padding-top: 0px; padding-bottom: 10px; font-family: serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Merriwheater', 'Georgia', serif;line-height:1.5;padding-top:0px;padding-right:15px;padding-bottom:10px;padding-left:15px;\">
<div style=\"font-size: 14px; line-height: 1.5; font-family: 'Merriwheater', 'Georgia', serif; color: #555555; mso-line-height-alt: 21px;\">
<p style=\"font-size: 13px; line-height: 1.5; word-break: break-word; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 20px; mso-ansi-font-size: 14px; margin: 0;\"><span style=\"font-size: 13px; color: #000000; mso-ansi-font-size: 14px;\">$message</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 15px; padding-bottom: 10px; padding-left: 15px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px solid #E9EBEB; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid mixed-two-up no-stack\" style=\"Margin: 0 auto; min-width: 320px; max-width: 655px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:655px\"><tr class=\"layout-full-width\" style=\"background-color:transparent\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"436\" style=\"background-color:transparent;width:436px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num8\" style=\"display: table-cell; vertical-align: top; min-width: 320px; max-width: 432px; width: 436px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"left\" class=\"img-container left fixedwidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"left\"><![endif]--><img alt=\"Alternate text\" border=\"0\" class=\"left fixedwidth\" src=\"https://res.cloudinary.com/ddiec2wxr/image/upload/v1596282410/812d7937-eabd-4519-a38f-0adc6ef6b4b8_rxppc1.jpg\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 393px; display: block;\" title=\"Alternate text\" width=\"393\"/>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td><td align=\"center\" width=\"218\" style=\"background-color:transparent;width:218px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num4\" style=\"display: table-cell; vertical-align: top; max-width: 320px; min-width: 216px; width: 218px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table cellpadding=\"0\" cellspacing=\"0\" class=\"social_icons\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;\" valign=\"top\">
<table align=\"left\" cellpadding=\"0\" cellspacing=\"0\" class=\"social_table\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-tspace: 0; mso-table-rspace: 0; mso-table-bspace: 0; mso-table-lspace: 0;\" valign=\"top\">
<tbody>
<tr align=\"left\" style=\"vertical-align: top; display: inline-block; text-align: left;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 2.5px; padding-left: 0px;\" valign=\"top\"><a href=\"https://www.facebook.com/\" target=\"_blank\"><img alt=\"Facebook\" height=\"32\" src=\"https://res.cloudinary.com/ddiec2wxr/image/upload/v1596282650/facebook2x_hdrv71.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;\" title=\"Facebook\" width=\"32\"/></a></td>
<td style=\"word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 2.5px; padding-left: 0px;\" valign=\"top\"><a href=\"https://twitter.com/\" target=\"_blank\"><img alt=\"Twitter\" height=\"32\" src=\"https://res.cloudinary.com/ddiec2wxr/image/upload/v1596282652/twitter2x_yes9ny.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;\" title=\"Twitter\" width=\"32\"/></a></td>


</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 655px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:655px\"><tr class=\"layout-full-width\" style=\"background-color:transparent\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"655\" style=\"background-color:transparent;width:655px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 655px; display: table-cell; vertical-align: top; width: 655px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" height=\"0\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 0px; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td height=\"0\" style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 655px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:655px\"><tr class=\"layout-full-width\" style=\"background-color:transparent\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"655\" style=\"background-color:transparent;width:655px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 655px; display: table-cell; vertical-align: top; width: 655px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" height=\"50\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 50px; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td height=\"50\" style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:#f6d16c;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 655px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:#f6d16c;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:655px\"><tr class=\"layout-full-width\" style=\"background-color:transparent\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"655\" style=\"background-color:transparent;width:655px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 655px; display: table-cell; vertical-align: top; width: 655px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" height=\"5\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 5px; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td height=\"5\" style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:#f4eded;\">
<div class=\"block-grid mixed-two-up\" style=\"Margin: 0 auto; min-width: 320px; max-width: 655px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:#f4eded;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:655px\"><tr class=\"layout-full-width\" style=\"background-color:transparent\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"436\" style=\"background-color:transparent;width:436px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num8\" style=\"display: table-cell; vertical-align: top; min-width: 320px; max-width: 432px; width: 436px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 20px; padding-left: 20px; padding-top: 10px; padding-bottom: 10px; font-family: serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Merriwheater', 'Georgia', serif;line-height:1.2;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;\">
<div style=\"line-height: 1.2; font-size: 12px; font-family: 'Merriwheater', 'Georgia', serif; color: #555555; mso-line-height-alt: 14px;\">
<p style=\"font-size: 14px; line-height: 1.2; word-break: break-word; text-align: left; font-family: Merriwheater, Georgia, serif; mso-line-height-alt: 17px; margin: 0;\"><em><span style=\"font-size: 18px; color: #f6d16c;\"><span style=\"\">Contact us:</span></span></em></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 20px; padding-left: 20px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:0px;padding-right:20px;padding-bottom:10px;padding-left:20px;\">
<div style=\"line-height: 1.2; font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #555555; mso-line-height-alt: 14px;\">
<p style=\"font-size: 14px; line-height: 1.2; word-break: break-word; text-align: left; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px; margin: 0;\"><span style=\"color: #333333;\">info@apexglobalcontracts.com</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 20px; padding-left: 20px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif\"><![endif]-->
<div style=\"color:#7e7979;font-family:'Lato', Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;\">
<div style=\"line-height: 1.2; font-size: 12px; font-family: 'Lato', Tahoma, Verdana, Segoe, sans-serif; color: #7e7979; mso-line-height-alt: 14px;\">
<p style=\"font-size: 14px; line-height: 1.2; word-break: break-word; text-align: left; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px; margin: 0;\">© 2022 Mettabase Trading Ltd. All Rights Reserved.</p>
<p style=\"font-size: 14px; line-height: 1.2; word-break: break-word; text-align: left; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px; margin: 0;\"></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td><td align=\"center\" width=\"218\" style=\"background-color:transparent;width:218px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num4\" style=\"display: table-cell; vertical-align: top; max-width: 320px; min-width: 216px; width: 218px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div></div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->
</body>
</html>";

return $mailbody;
    
}
function verifyEmail($name,$email,$code,$link){
    $year = date("Y");
    $mailbody = "<!DOCTYPE html>
<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"x-apple-disable-message-reformatting\">
    <style>
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            font-size: 15px;
            font-family: Roboto, Helvetica, Arial, sans-serif;
            margin-bottom: 10px;
            line-height: 24px;
            color:#8094ae;
            font-weight: 400;
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
        }
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }
        p {
            margin: 10px 0;
        }
        p:last-child {
            margin-bottom: 0;
        }
        a {
            text-decoration: none;
        }
        img {
            -ms-interpolation-mode:bicubic;
        }
    </style>

</head>

<body width=\"100%\" style=\"margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f5f6fa;\" dir=\"ltr\">
<center style=\"width: 100%; background-color: #f5f6fa;\">
    <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#212230\">
        <tr>
            <td style=\"padding: 30px 0;\">
                <table style=\"width:100%;max-width:620px;margin:0 auto;\">
        <tbody>
        <tr>
            <td style=\"text-align: center; padding-bottom:15px\">
                <img class=\"logo-img\" style=\"max-height: 50px; width: auto;\" src=\"https://www.apexglobalcontracts.com/home/template/assets/media/general/apexlogo.png\" alt=\"ApexGlobal\">
            </td>
        </tr>
        </tbody>
    </table>
                    <table style=\"width:100%;max-width:620px;margin:0 auto;background-color:#ffffff;\">
        <tbody>
        <tr>
            <td style=\"padding: 30px 30px 20px\">
                <p><b>Welcome $name!</b></p>

            </td>
        </tr>
        <tr>
            <td style=\"padding: 0 30px 20px\">
               <p>Thank you for joining our company. You're almost ready to start.</p>
<p>We need you to confirm your email address. Simply click the button below to confirm your email address and active your account.</p>

            </td>
        </tr>
        <tr>
            <td style=\"padding: 0 30px 20px\">
                <p style=\"margin-bottom: 25px;\">This link will expire in 30 minutes and can only be used once.</p>
                <a href=\"$link\"
                style=\"background-color:#6576ff;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0 30px\">Verify Email</a>
            </td>
        </tr>
        <tr>
            <td style=\"padding: 0 30px 20px\">
                <h4 style=\"font-size: 15px; color: #000000; font-weight: 600; margin: 0; text-transform: uppercase; margin-bottom: 10px\">or</h4>
                <p style=\"margin-bottom: 10px;\">If the button above does not work, paste this link into your web browser:</p>
                <a href=\"#\" style=\"color: #6576ff; text-decoration:none;word-break: break-all;\">$link</a>
            </td>
        </tr>
        <tr>
            <td style=\"padding: 0 30px\">
                <h4 style=\"font-size: 15px; color: #000000; font-weight: 
600; margin: 0; text-transform: uppercase; margin-bottom: 10px\">or</h4>
                <p style=\"margin-bottom: 10px;\">If needed, you may use the code below to verify your email:</p>
                <h3 style=\"color: #6576ff; text-decoration:none;word-break: break-all;\">$code</h3>
            </td>
        </tr>

                    <tr>
                <td style=\"padding: 20px 30px 30px\">
                    <p>Best Regard,<br />
ApexGlobal Team </p>

                </td>
            </tr>
                </tbody>
    </table>
                <table style=\"width:100%;max-width:620px;margin:0 auto;\">
    <tbody>
    <tr>
        <td style=\"text-align: center; padding:25px 20px 0;\">
            <p style=\"font-size: 13px;\">ApexGlobal &copy; $year.</p>
        
            <ul style=\"margin: 10px -4px 0;padding: 0;\">
                                                        <li style=\"display: inline-block; list-style: none; padding: 4px;\">
                        <a style=\"display: inline-block;\" href=\"https://facebook.com\">
                            Facebook
                           
                        </a>
                    </li>
                                                                         
 <li style=\"display: inline-block; list-style: none; padding: 4px;\">
                        <a style=\"display: inline-block;\" href=\"https://twitter.com\">
                            Twitter
                           
                        </a>
                    </li>
                                                                           
 <li style=\"display: inline-block; list-style: none; padding: 4px;\">
                        <a style=\"display: inline-block;\" href=\"https://linkedin.com\">
                            Linkedin
                          
                        </a>
                    </li>
                                                </ul>
                    </td>
    </tr>
    </tbody>
</table>
            </td>
        </tr>
    </table>
</center>

<br/>
</body>
</html>";
    return $mailbody;
}
?>