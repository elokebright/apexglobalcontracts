
<?php
require_once("../cf/func.php");

$totalusers = getTotalMembers();
$totalcapital = number_format(getTotalCapitals(),2);
$totalactivecapital =number_format(getActiveCapitals(),2);
$totaldeposits=number_format(getTotalDeposits(),2);
$totalwithdrawals =number_format(getTotalWithdrawals(),2);
$pendingwithdrawal = number_format(getTotalPendingWithdrawals(),2);
$pendingdeposits =number_format(getTotalPendingDeposits(),2);

$result = array(
'totalusers' => $totalusers ,
'totaldeposits'=>$totaldeposits,
'totalinvestment'=>$totalcapital,
'totalactivecapital'=>$totalactivecapital,
'pendingdeposit'=>$pendingdeposits,
'totalwithdrawal'=>$totalwithdrawals,
'pendingwithdrawal'=>$pendingwithdrawal);

echo json_encode($result);




?>