 <?php
require_once("head.php");
require_once("nav.html");
$get = $conn->query("SELECT * FROM settings");
if($get->num_rows >0){
    $d=$get->fetch_assoc();
    $wbtc=$d["btcaddress"];
    $wbnb=$d["bnbaddress"];
   
    $weth=$d["ethaddress"];
    
     $werc=$d["usdterc20address"];
     $wtrc=$d["usdttrc20address"];
    $phones=$d["phone"];
     $bank = $d["bank"];
    $bank_acc_name = $d["bank_acc_name"];
    $bank_num = $d["bank_acc_num"];
    $bankswift =$d["swiftcode"];
    $bankdetail = $bank. ": ".$bank_num.' $bank_acc_name';
} 
$myfile = fopen("../home/livechat.txt", "r+") ;
$chatcode = fread($myfile,filesize("../home/livechat.txt"));
fclose($myfile);
  ?>
<div id="page-wrapper" style="min-height: 556px;">
			<div class="main-page signup-page">
			
					<h1 class="jumbotron  text-light">Manage Wallets</h1>

						<div class="table-responsive">
<table class="table">
<thead>

<tr>
<th>1</th>
<th nowrap>BTC Wallet:</th>
<th nowrap><?=$wbtc?></th>
<th nowrap><a href="?edit=btcaddress"  class='text-primary'>Edit</a></th>
</tr>
<tr>
<th>2</th>
<th nowrap>ETH Wallet:</th>
<th nowrap><?=$weth?></th>
<th nowrap><a href='?edit=ethaddress' class='text-primary'>Edit</a></th>
</tr>



<tr>
<th>4</th>
<th nowrap>USDT-ERC20 Wallet:</th>
<th nowrap><?=$werc?></th>
<th nowrap><a href='?edit=usdterc20address' class='text-primary'>Edit</a></th>
</tr>
<tr>
    
    
<tr>
<th>5</th>
<th nowrap>USDT-TRC20 Wallet:</th>
<th nowrap><?=$wtrc?></th>
<th nowrap><a href='?edit=usdttrc20address' class='text-primary'>Edit</a></th>
</tr>


<tr>
   
    
<th>6</th>
<th nowrap>Live Chat Code:</th>
<th nowrap>smartsupp code here ...</th>
<th nowrap><a href='?edit=chatcode' class='text-primary'>View/Change</a></th>
</tr>


</thead>
<tbody>




</tbody>
</table>
</div>
        								</div>
        								
      								
<?php 
if(isset($_GET["edit"]) && $_GET["edit"] != "password" && $_GET["edit"] !="bank" && $_GET["edit"] != 'chatcode'){
    $toedit = $_GET["edit"];
    switch($toedit){
        case "btcaddress":
            $coin="Bitcoin Wallet Address";
            $old = $wbtc;
            break;
        case "bnbaddress":
            $coin="BNBWallet Address";
            $old = $wbnb;
            break;  
      case "ltcaddress":
            $coin="Litecoin Wallet Address";
            $old = $wltc;
            break;
      case "ethaddress":
            $coin="Ethereum Wallet Address";
            $old = $weth;
            break; 
            
     case "usdttrc20address":
            $coin="USDT(TRC20) Address";
            $old = $wtrc;
            break; 
            
     case "usdterc20address":
            $coin="USDT(ERC20) Address";
            $old = $werc;
            break;         
      case "phone":
            $coin="Phone Numbers";
            $old = $phones;
            break;  
            
            case "password":
            $coin="Admin Password";
            $old = "";
            break;
    }

?>
<div class="modal fade" id="modal-edit">
<div class="modal-dialog modal-md">
<div class="modal-content alert">
<div class="modal-header">
<h4 class="modal-title ">Edit <?=$coin?></h4>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick=$('#modal-edit').hide()>×</button>
</div>
<div class="modal-body alert-primary">
<p>
<form method="post" id="settings_form">
    Enter the new value and Save
    <input type="text" name="newval" class="form-control" value="<?=$old?>">
    <input type="hidden" name="toedit" value="<?=$toedit?>">

</p>
</div>
<div class="modal-footer">
<a class="btn btn-white" data-dismiss="modal" onclick=$('#modal-edit').hide()>Close</a>
<button class="btn btn-success" type="submit" id="settings_form_btn">Save</button>
</form>
</div>
</div>
</div>
</div>
<script>
$(document).ready(function(){
    $("#modal-edit").modal();
   // $("#settings_form_btn").click(function(){
    $("#settings_form").submit(function(e){
		e.preventDefault();
			$("#settings_form_btn").text("saving...");
			$("#settings_form_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "save-data.php",
				method: "post",
				data: $("#settings_form").serialize(),
				dataType: "text",
				success:function(status){
				var status = $.trim(status);
					if(status == 'failed'){
					$("#settings_form_btn").text("Save");
					$("#settings_form_btn").attr("disabled", false);
						alert("Failed!", "something went wrong. Try again");
						
					}
					else if(status == 'success'){
					$("#settings_form_btn").text("Save");
						$("#settings_form_btn").attr("disabled", false);
					    alert("Successful!", "Data Saved");
						setTimeout(function(){
							window.location="addresses.php";
						},2000);
					}
				}
			//});
    });

		});
});
</script>
<?php

}
?>
<?php
if(isset($_GET["edit"]) && $_GET["edit"] == "password"){

?>
<div class="modal fade show label-success" id="modal-edit_pass">
<div class="modal-dialog modal-md">
<div class="modal-content alert">
<div class="modal-header">
<h4 class="modal-title ">Change Admin Password</h4>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick=$('#modal-edit_pass').hide()>Close>×</button>
</div>
<div class="modal-body alert-primary">
<p>
<form method="post" id="pass_form">
    Enter new password
    
    <input type="password" class="form-control" name="newpass" value="">
    <br>
    Confirm new password
    
    <input type="password" class="form-control" name="newpass2" value="">
</p>
</div>
<div class="modal-footer">
<a class="btn btn-white" data-dismiss="modal" onclick=window.location.assign('index')>Close</a>
<button class="btn btn-success" type="submit" id="pass_form_btn">Save</button>
</form>
</div>
</div>
</div>
</div>
<script>
    $(document).ready(function(){
    $("#modal-edit_pass").modal();
   // $("#settings_form_btn").click(function(){
    $("#pass_form").submit(function(e){
		e.preventDefault();
			$("#pass_form_btn").text("saving...");
			$("#pass_form_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "save-data.php",
				method: "post",
				data: $("#pass_form").serialize(),
				dataType: "text",
				success:function(status){
				var status = $.trim(status);
					if(status == 'failed'){
					$("#settings_form_btn").text("Save");
					$("#settings_form_btn").attr("disabled", false);
						alert("Failed!", "something went wrong. Try again");
						
					}
					else if(status == 'success'){
					$("#settings_form_btn").text("Save");
						$("#settings_form_btn").attr("disabled", false);
					    alert("Successful!", "Data Saved");
						setTimeout(function(){
							window.location="index.php";
						},1000);
					}
				}
			//});
    });

		});
    });
</script>
<?php

 
}
?>

<?php
if(isset($_GET["edit"]) && $_GET["edit"] =='bank'){
  ?>  

<div class="modal fade show " id="modal-edit-bank">
<div class="modal-dialog modal-md">
<div class="modal-content alert">
<div class="modal-header">
<h4 class="modal-title ">Edit Bank Details</h4>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick=$('#modal-edit-bank').hide()>×</button>
</div>
<div class="modal-body alert-primary">
<p>
<form method="post" id="bank_form">
    Bank
    <input type="text" name="bank" class="form-control" value="<?=$bank?>">
   <br>
   Account Number
    <input type="text" name="accnum" class="form-control" value="<?=$bank_num
    ?>">
    <br>
    Account Name
        <input type="text" name="accname" class="form-control" value="<?=$bank_acc_name?>">
    <br>
    Swift Code
        <input type="text" name="bankswift" class="form-control" value="<?=$bankswift?>">
    
</p>
</div>
<div class="modal-footer">
<a class="btn btn-white" data-dismiss="modal" onclick=$('#modal-edit-bank').hide()>Close</a>
<button class="btn btn-success" type="submit" id="bank_form_btn">Save</button>
</form>
</div>
</div>
</div>
</div>
<script>
    $("#modal-edit-bank").show();
   // $("#settings_form_btn").click(function(){
    $("#bank_form").submit(function(e){
		e.preventDefault();
			$("#bank_form_btn").text("saving...");
			$("#bank_form_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "save-data.php",
				method: "post",
				data: $("#bank_form").serialize(),
				dataType: "text",
				success:function(status){
				var status = $.trim(status);
					if(status == 'failed'){
					$("#bank_form_btn").text("Save");
					$("#bank_form_btn").attr("disabled", false);
						alert("Failed!", "something went wrong. Try again");
						
					}
					else if(status == 'success'){
					$("#bank_form_btn").text("Save");
						$("#bank_form_btn").attr("disabled", false);
					    alert("Successful!", "Data Saved");
						setTimeout(function(){
							window.location="addresses.php";
						},2000);
					}
				}
			//});
    });

		});
</script>

<?php
    }

?>			
					
<?php
if(isset($_GET["edit"]) && $_GET["edit"] == "chatcode"){

?>
<div class="modal fade" id="modal-edit">
<div class="modal-dialog modal-md">
<div class="modal-content alert">
<div class="modal-header">
<h4 class="modal-title ">Edit Chatcode</h4>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick=$('#modal-edit').hide()>×</button>
</div>
<div class="modal-body alert-primary">
<p>
<form method="post" id="pass_form">
    Past the new chat code copied from smartsupp, tidio or any other system
      
<textarea rows='12' name='newchat' class='form-control'>
    <?=$chatcode?>
    </textarea>
 
    <br>
 
</p>
</div>
<div class="modal-footer">
<a class="btn btn-white" data-dismiss="modal" onclick=$('#modal-edit_chat').hide()>Close</a>
<button class="btn btn-success" type="submit" id="pass_form_btn">Save</button>
</form>
</div>
</div>
</div>
</div>
<script>
$(document).ready(function(){
    $("#modal-edit").modal();
   // $("#settings_form_btn").click(function(){
    $("#pass_form").submit(function(e){
		e.preventDefault();
			$("#pass_form_btn").text("saving...");
			$("#pass_form_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "save-data.php",
				method: "post",
				data: $("#pass_form").serialize(),
				dataType: "text",
				success:function(status){
				var status = $.trim(status);
					if(status == 'failed'){
					$("#settings_form_btn").text("Save");
					$("#settings_form_btn").attr("disabled", false);
						alert("Failed!", "something went wrong. Try again");
						
					}
					else if(status == 'success'){
					$("#settings_form_btn").text("Save");
						$("#settings_form_btn").attr("disabled", false);
					    alert("Successful!", "Data Saved");
						setTimeout(function(){
							window.location="addresses";
						},2000);
					}
				}
			//});
    });

		});
});
</script>
<?php
} 

?>
				
				
				</div>

			

  <?php

  require_once("footer.html");
  
  ?>