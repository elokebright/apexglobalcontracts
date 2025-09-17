<?php
require_once("head.php");
require_once("nav.html");
if(!isset($_GET["u"])){
    echo"<script>window.location.assign('users.php')</script>";
}
else{
    $usr = $_GET["u"];
   $user_data = $conn->query("SELECT * FROM accounts WHERE username = '$usr' Or userid = '$usr' LIMIT 1");
$r = $user_data->fetch_assoc();

$regdate = date("Y-m-d",strtotime($r["regdate"]));

$userfirstname = $r["firstname"];
$user_userid = $r["userid"];
$userlastname = $r["lastname"];

$userfname = $r["firstname"];$userlname = $r["lastname"];
$name = $r["firstname"]." ".$r["lastname"]; 
}
  ?>
  
  <div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">
			    <br><br>
	<h1 class="title1 text-light">Add Capital to user</h1>
	
	
	
	<div class="row mb-5">
					<div class="col text-center card p-4 bg-dark"> 
<form  method="POST" action="">
<fieldset>
    User: <?=$name?>
    <div class="form-group row m-b-15">
<label class="col-md-3 col-form-label">Select Plan</label>
<div class="col-md-7">
<select name="plan" class="form-control">
    <?php
    
    $plans = $conn->query("SELECT * FROM plans");
if($plans->num_rows > 0){
    while(
    $pldata = $plans->fetch_assoc()
    ){
    $plname = $pldata["name"];
    $plsn = $pldata["id"];
    $plrate = $pldata["dailyrate"];
    $plmin = $pldata["minamount"];
    $plmax = $pldata["maxamount"];
   
    $pldur = $pldata["duration"];
  
    $pltotalroi= $plrate * $pldur;
    
        echo "<option value='$plname'>$plname ($plrate% min: $plmin)</option>";
    }
}
    ?>
    
</select>
</div>
</div>

<div class="form-group row m-b-15">
<label class="col-md-3 col-form-label">Amount</label>
<div class="col-md-7">
<input type="text" name="capt" id="invamt" class="form-control" placeholder="10" />
</div>
</div>

<div class="form-group row m-b-15">
<label class="col-md-3 col-form-label">Profit</label>
<div class="col-md-7">
<input type="text" name="prft" class="form-control" placeholder="0" />
<input type="hidden" name="usr" value="<?=$user_userid?>" class="form-control" placeholder="0" />
</div>
</div>



<div class="form-group row m-b-15">

</div>
<div class="form-group row">
<div class="col-md-7 offset-md-3">
<button type="submit" name="submitAddCapital" class="btn btn-sm btn-primary m-r-5">submit</button>
<button type="submit" class="btn btn-sm btn-default">Cancel</button>
</div>

<?php

if (isset($_POST["submitAddCapital"])) {
  $amt = $_POST["capt"];
  $reference_id = uniqid(time());
  $account = $_POST["usr"];
   $prft = $_POST["prft"];
   $pln = $_POST["plan"];
     $pl = $conn->query("SELECT * FROM plans WHERE name='$pln'");
if($pl->num_rows == 1){
    
    $plan = $pl->fetch_assoc();
    
    $pname = $plan["name"];
    $psn = $plan["id"];
    $prate = $plan["dailyrate"];
    $pmin = $plan["minamount"];
    $pmax = $plan["maxamount"];
   
    $pdur = $plan["duration"];

    
}
 if($amt > $pmax){
        echo "
    <script>
      swal({
      title:'Amount too much',
     icon:'error',
     text: 'the capital amount is above the maximum for this plan'
         });
  
    </script>";
 }

  
 else if($amt >= $pmin && $amt <= $pmax){
      $now = date("Y-m-d H:i:s");
      
      $duetime=date("Y-m-d H:i:s",strtotime("$now + $pdur days"));
      $ref = uniqid(time());

      $saveInvestment = $conn->query("INSERT INTO investments(user,plan,reference, capital,rate,duedate,lastupdated,currentprofit) VALUES('$account','$pname','$ref','$amt','$prate','$duetime','$now','$prft')");
      
    echo "
    <script>
      swal({
      title:'Capital added successfully',
     icon:'info',
     text: 'Automatic trading begins instantly'
         });
    setTimeout(function(){
      window.location='accounts';
  },3000);
    </script>";
  
}
else{
    echo "
    <script>
      swal({
      title:'Amount too small',
     icon:'error',
     text: 'the capital amount is less than the minimum for this plan'
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
		</div>

<?php
require_once("bottom.php");
?>