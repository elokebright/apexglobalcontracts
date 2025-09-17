<?php
require_once("../cf/func.php");
$settings = $conn->query("SELECT * FROM settings");
$settings = $settings->fetch_assoc();
$_SESSION["wallets"]=$settings;
$userid = verifyLoginStatus();
if ($userid==false) {
    header("Location: ../login");
}
//require_once("update.php");
$user_data = $conn->query("SELECT * FROM accounts WHERE userid = '$userid' LIMIT 1");

//$user_data->bind_param("s",$userid);
//$user_data->execute();
//$details = $user_data->get_result();

$walletbalance = $bonusbalance = $totalcapital = $totalcommissions = $totalwithdrawals = "00";

$walletdata = $conn->query("SELECT * FROM wallet WHERE userid ='$userid'");
if($walletdata->num_rows > 0){
    $walletdata=$walletdata->fetch_assoc();
$walletbalance = $walletdata["balance"];
$bonusbalance = $walletdata["bonus"];
}

$activeplans = "None";
$getactiveplans =$conn->query("SELECT * FROM investments WHERE status=1 AND user ='$userid'");
$activeplanscount = $getactiveplans->num_rows;
if( $activeplanscount > 0){
    
  while(  $userplans = $getactiveplans->fetch_assoc()){
   // $activeplans .= $userplans["plan"]." ";
  }
  $activeplans = $activeplanscount;
}
$r = $user_data->fetch_assoc();

$user_sort = $r["sort"];
if ($user_sort == "user2") {
    header("Location: ../agent/");
}
if ($user_sort == "user3") {
    header("Location: ../");
}
$regdate = date("Y-m-d",strtotime($r["regdate"]));$userfirstname = $r["firstname"];
$userlastname = $r["lastname"];
$usercountry =$r["country"];
$usercountry =(strlen($usercountry)<3)?$r["iplocation"]:$usercountry;
$userfname = $r["firstname"];$userlname = $r["lastname"];
$name = $r["firstname"]." ".$r["lastname"];
$userphone = $r["phone"];
$useremail = $r["email"];
$_SESSION["useremail"] = $useremail;
$user_username = $r["username"];
$_SESSION["user_username"]=$user_username;
$sponsor_user = $r["sponsor"];

if(empty($sponsor_user)){
    $sponsor_user ="None";
}else{
    $getsponsor = $conn->query("SELECT * FROM accounts WHERE refid = '$sponsor_user' LIMIT 1");
    $getsponsor = $getsponsor->fetch_assoc();
    $sponsor_user = $getsponsor["firstname"] ." ".$getsponsor["lastname"];
}
$userrefid = $r["refid"];
$nextofkin =$r["nok"];
$dob =$r["dob"];
$nextofkinphone = $r["nokphone"];
$nextofkinrel = $r["nokrel"];
$nextofkinemail = $r["nokemail"];
$profileimage = $r["profileimage"];
$twofastatus = $r["twofa"];
$address = $r["address"];

$lastlogin = date("Y-m-d h:i:s",strtotime($r["lastlogin"]));

$profileimage =(file_exists($profileimage))?$profileimage:"assets/dummy-profile.png";



$idverified =$r["idverified"];

$getmessages = $conn->query("SELECT * FROM notifications WHERE user='$useremail' AND status = '0' ORDER BY sn DESC");
$messagecount = $getmessages->num_rows;

$idfrontimage = $r["idfront"];
$idbackimage = $r["idback"];
//$iddocument = $r["iddocument"];

$idverified =$r["idverified"];
$frontid_exists = file_exists($idfrontimage);
$backid_exists = file_exists($idbackimage);

 $idfrontuploaded = $idbackuploaded =1;
if(!$frontid_exists){
    $idfrontimage="assets/dummyid.png";
    $idfrontuploaded =0;
}

if(!$backid_exists){
    $idbackimage="assets/idbackdummy.jpg";
     $idbackuploaded =0;
}



$idverified =$r["idverified"];
$kyc =$r["kyc"];



 ?>