 <?php
require_once("head.php");
require_once("nav.html");
if(!isset($_GET["dref"])){
    echo"<script>window.location.assign('investments.php')</script>";
}
else{
    $insn = $_GET["dref"];
    $invdata = $conn->query("SELECT * FROM investments WHERE sn ='$insn'");
    if($invdata->num_rows ==1){
        $invdata= $invdata->fetch_assoc();
        $cap = $invdata["capital"];
        $plan = $invdata["plan"];
        $days = $invdata["dayscount"];
        $cprofit = $invdata["currentprofit"];
        $upd = $invdata["lastupdated"];
        $r = $invdata["rate"];
    $user = $invdata["user"];
$userdata = mysqli_fetch_array(mysqli_query($conn,"SELECT firstname,lastname FROM accounts WHERE userid='$user'"));
$user_name = $userdata["firstname"]." ".$userdata["lastname"];
    }
}
  ?>
<div id="page-wrapper" style="padding-left: 0px; padding-right: 5px; min-height: 556px;">
			
					<div class="mt-2 mb-4">
					<h1 class="title1 text-light">Edit investment</h1>
					</div>

					<div class="col card p-4 bg-dark"> 
  <form  method="POST" action="">
<fieldset>
 <h4>User: <?=$user_name?></h4>
    <h4>Capital : $<?=$cap?></h4>
     <h4>Plan : <?=$plan?></h4>
      <h4>Daily % : <?=$r?></h4>
       <h4>Current Profit : $<?=$cprofit?></h4>
        <h4>Active Days : <?=$days?></h4>
        
        <div class="form-group row m-b-15">
   
<label class="col-md-3 col-form-label">Edit Capital Amount</label>
<div class="col-md-7">
<input type="text" name="newcap" value="<?=$cap?>" class="form-control" placeholder="10" />
</div>
</div>
<div class="form-group row m-b-15">
   
<label class="col-md-3 col-form-label">Edit Profit Amount</label>
<div class="col-md-7">
<input type="text" name="newprofit" value="<?=$cprofit?>" class="form-control" placeholder="10" />
</div>
</div>


<div class="form-group row m-b-15">
<small style="padding-left:40px" class="text-danger">NB: The capital and profit will be replaced with the new values</small>
</div>
<div class="form-group row">
<div class="col-md-7 offset-md-3">
    <input type='hidden' value='<?=$insn?>' name="invref">
     <input type='hidden' value='<?=$user?>' name="owner">
      <input type='hidden' value='<?=$cprofit?>' name="walletdiff">
<button type="submit" name="submitAddProfit" class="btn btn-sm btn-primary m-r-5">submit</button>
<button type="submit" class="btn btn-sm btn-default">Cancel</button>
</div>

<?php

if (isset($_POST["submitAddProfit"])) {
  $pamt = $_POST["newprofit"];
    $walletdiffamt = $_POST["walletdiff"];
    
  $camt = $_POST["newcap"];
 $usr = $_POST["owner"];
  $account = $_POST["invref"];
   $current_time =date("Y-m-d h:i:s");
  $saveDeposit = $conn->query("UPDATE investments SET currentprofit = '$pamt',capital='$camt',lastupdated ='$current_time' WHERE sn='$account'");
 if($pamt > $walletdiffamt){
     $diff = $pamt - $walletdiffamt;
      updateWallet($usr,$diff,'add');
 }
 if($pamt<$walletdiffamt){
       $diff = $walletdiffamt-$pamt;
      updateWallet($usr,$diff,'minus');
 }
  if ($saveDeposit ) {
    echo "
    <script>
    swal({
    icon:'success',
    text:'Edited successfully',
    title: 'Success!'
        
    });
    setTimeout(function(){
      window.location='investments.php?';
  },2000);
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
  <?php
  require_once("footer.html");
  
  ?>