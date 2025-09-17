<?php
require_once("../cf/func.php");
$_SESSION["adminid"]="ur8748w49848374djhsjer47394834iydhi737467398ujduy377e89384uue3467949";
$userid = $_SESSION["adminid"];
if ($userid==false) {
    header("Location: ../cpanel.html");
}
//require_once("update.php");
$user_data = $conn->query("SELECT * FROM accounts WHERE userid = '$userid' LIMIT 1");



$r = $user_data->fetch_assoc();

$user_sort = $r["sort"];

if ($user_sort == "user1") {
    header("Location: ../dashboard");
}
$userfirstname = $r["firstname"];
$userlastname = $r["lastname"];

$userfname = $r["firstname"];$userlname = $r["lastname"];
$name = $r["firstname"]." ".$r["lastname"];

$user_username = $r["username"];

//updateAllProfit($userid);

 ?>