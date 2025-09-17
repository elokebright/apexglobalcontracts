<?php
require_once("cf/func.php");

    global $conn;
    
    $q= mysqli_query($conn,"SELECT sn,user,capital,plan,rate,intervals,dateactivated,lastupdated,currentprofit,DATEDIFF(CURRENT_TIMESTAMP,dateactivated) as dcount,DATEDIFF(CURRENT_TIMESTAMP,lastupdated) as dcount2 FROM investments WHERE status =1 ");
	if (mysqli_num_rows($q) !=0) {
		while($data = mysqli_fetch_array($q)){
		$investmentsn=$data["sn"];
			$investor=$data["user"];
	        $capital =$data["capital"];
		    $rate= $data["rate"];
		    $activefrom=$data['dateactivated'];
		    $lastupdated = $data["lastupdated"];
		    $last_profit = $data["currentprofit"];
	$pname = $data["plan"];
	$intervals = $data["intervals"];
		     $daycount = $data["dcount"];
		     $daycount2 = $data["dcount2"];
		     //check if the number of days since last activation is above zero 
		     if($daycount > 0){
		         //get number of weeks since last activation
		    $daycount1 = floor($data["dcount"]/$intervals);
		    ;
$dailyprofit = ($capital * ($rate/100));
    $total_profit = ($capital * ($rate/100)* $daycount1);
    $current_profit = ($capital * ($rate/100)* $daycount1);
    $profit_update=$last_profit+$current_profit; 
  $current_time =date("Y-m-d h:i:s");
$q2= "UPDATE investments SET currentprofit = '$total_profit',dayscount='$daycount' WHERE sn ='$investmentsn'";
$do = mysqli_query($conn,$q2);
$wallet_update = $total_profit - $last_profit;
updateWallet($investor,$last_profit,'minus');
updateWallet($investor,$current_profit,'add');
if($daycount2 == $intervals){
   
$q2= "UPDATE investments SET lastupdated='$current_time' WHERE sn ='$investmentsn'";
       $userdata = mysqli_fetch_array(mysqli_query($conn,"SELECT firstname , lastname,email FROM accounts WHERE userid = '$investor'"));
        $user_name = $userdata["firstname"]." ". $userdata["lastname"];
        $useremail = $userdata["email"];
    $msg = "
                 
                 
                    <tr>
                        <td style=\"padding: 0 30px 20px\">
                            <p style=\"margin: 0;\"><span target=\"_blank\" style=\"color: #14183d;\">You have received a profit<br></span>
                            Amount: $$dailyprofit <br>
                            Detail: Weekly Profit from capital of $capital invested on the $pname plan.<br>
                         
                           
                         
                            
                            
                            </p>
                        </td>
                    </tr>
                       <tr>
                        <td style=\"padding: 0 30px 20px\">
                           
                            <p>This amount has been credited to your account balance
                        </td>
                    </tr> 
                    ";
                     $mailmsg = createEmail2("Profit of $$dailyprofit Received",$msg);
                    sendmail('Apex Global Weekly Profit<noreply@apexglobalcontracts.com>',$mailmsg,$useremail,'Profit Received');
                    push_notice($useremail, "$$dailyprofit profit received", "You have earned a profit of $$dailyprofit. The amount has been credited to your balance");
}

$do = mysqli_query($conn,$q2);

}
}
}






?>