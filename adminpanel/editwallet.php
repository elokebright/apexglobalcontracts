<?php
require_once("head.php");
require_once("nav.html");
if(!isset($_GET["u"])){
    echo"<script>window.location.assign('users.php')</script>";
}
else{
    $usr = $_GET["u"];
   $user_data = $conn->query("SELECT * FROM accounts WHERE username = '$usr' OR userid='$usr' LIMIT 1");


$r = $user_data->fetch_assoc();

$regdate = date("Y-m-d",strtotime($r["regdate"]));$userfirstname = $r["firstname"];
$user_userid = $r["userid"];
$userlastname = $r["lastname"];

$userfname = $r["firstname"];$userlname = $r["lastname"];
$name = $r["firstname"]." ".$r["lastname"];

$walletbalance = number_format(walletBalance($user_userid),2);
}

  ?>
  
  <div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">
			    <br><br>
	<h1 class="title1 text-light">Edit Wallet Balance</h1>

									 	<div class="row mb-5">
			







<form  method="POST" action="">
<fieldset>
 <h4>User: <?=$name?></h4>
    <h4>Current Balance : $<?=$walletbalance?></h4>
  
<div class="form-group row m-b-15">
   
<label class="col-md-3 col-form-label">Enter New Balance</label>
<div class="col-md-7">
<input type="text" name="amt2add" class="form-control" placeholder="10" />
</div>
</div>


<div class="form-group row m-b-15">

</div>
<div class="form-group row">
<div class="col-md-7 offset-md-3">
 
     <input type='hidden' value='<?=$user_userid?>' name="owner">
<button type="submit" name="submitEditBalance" class="btn btn-sm btn-primary m-r-5">submit</button>
<button type="submit" class="btn btn-sm btn-default">Cancel</button>
</div>

<?php

if (isset($_POST["submitEditBalance"])) {
  $amt = $_POST["amt2add"];
 $usr = $_POST["owner"];
  
   $current_time =date("Y-m-d h:i:s");
  $save = $conn->query("UPDATE wallet SET balance= '$amt',lastupdated ='$current_time' WHERE userid='$usr'");
 ;
  if ($save) {
    echo "
    <script>
    swal({
    icon:'success',
    text:'User Balance has been updated',
    title: 'Success!'
        
    });
    setTimeout(function(){
      window.location='user.php?id=$usr';
  },3000);
    </script>";
  }
    else{
       echo "
    <script>
    swal({
    icon:'error',
    text:'something went wrong',
    title: 'Error!'
        
    });
  
    </script>";  
  
}
  
}


?>
</div>
</fieldset>
</form>





</div>
			</div>
			</div>
		</div>

<?php
require_once("bottom.php");
?>