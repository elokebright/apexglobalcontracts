<?php
require_once("../cf/func.php");


$userid = $_SESSION["userid"];

$walletbonus=$walletbalance = $totalcapital = $totalrefbonus =$refBonusRate = $totalwithdrawal = $lastdeposit= $lastwithdrawal= $totaldeposit=$totalearning=$pendingdepsit=$pendingwithdrawal=$refcount=$totalbonuswithdrawal = $activecapital=0;
$totalcapital =getTotalCapital($userid);
$totalearning= getEarningUSD($userid);
$walletbalance = walletBalance($userid);
$totaldeposit = getUserDeposits($userid);
$totalwithdrawal =getWithdrawals($userid);


$bonusdata = $conn->query("SELECT bonus AS amt FROM wallet WHERE userid = '$userid'");
if ($bonusdata->num_rows != 0) {
    $totalbonus = $bonusdata->fetch_assoc()["amt"];


}

$correct_balance = $totaldeposit + $totalearning+$totalbonus-$totalcapital-$totalwithdrawal;
//$conn->query("UPDATE wallet SET balance ='$correct_balance' WHERE userid ='$userid'");
$totalearning = number_format($totalearning,2);
$walletbalance = number_format($walletbalance,2);
$totalcapital =number_format($totalcapital,2);
$totalbonus =number_format( $totalbonus,2);
$totaldeposit = number_format($totaldeposit,2);
$totalwithdrawal=number_format($totalwithdrawal,2);

$activecapital=getActiveCapital($userid);



$totalpak = $conn->query("SELECT * FROM investments WHERE user ='$userid'");
$totalpackages = $totalpak->num_rows;
$activepak = $conn->query("SELECT * FROM investments WHERE user ='$userid' AND status = 1");
$activepackages = $activepak->num_rows;

$lastdeposit=number_format(getLastDeposit($userid),2);


$pendingwithdrawal = number_format(getWithdrawalsPending($userid),2);
$refcount = number_format(getRefCount($userid));


$lastwithdrawaldata = $conn->query("SELECT amount AS amt FROM withdrawals WHERE user = '$userid' AND  status =1 ORDER BY sn DESC LIMIT 1");

if ($lastwithdrawaldata->num_rows != 0) {
    $lastwithdrawal = ($lastwithdrawaldata->fetch_assoc())["amt"];
}


$commissiondata = $conn->query("SELECT SUM(amount) AS amt FROM commissions WHERE user = '$userid'");
if ($commissiondata->num_rows != 0) {
    $totalcommissions =($commissiondata->fetch_assoc())["amt"];

}

$dailyprofit = $activecapital * 0.008;
$activecapital = number_format(getActiveCapital($userid),2);
$referralBonus = number_format(getReferralEarning($userid),2);
$result = array('walletbalance' => $walletbalance,
'totalinvestment'=>$totalcapital, 
'totalactiveinvestment'=>$activecapital,
'dailyprofit'=>$dailyprofit,
'totaldeposit'=>$totaldeposit,
'referralCount'=>$refcount,
'referralbonus'=>$referralBonus,
'totalpackages'=>$totalpackages,
'activepackages'=>$activepackages,
'totalwithdrawal'=>$totalwithdrawal,
'lastwithdrawal'=>$lastwithdrawal, 
'pendingwithdrawal'=>$pendingwithdrawal,
'totalearning'=>$totalearning,
'walletbonus'=>$totalbonus,
'lastdeposit'=>$lastdeposit
);

echo json_encode($result);




?>