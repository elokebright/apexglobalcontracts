<?php
require_once("head.php");
require_once("nav.html");
?>
<div id="page-wrapper" style="min-height: 556px;">
			<div class="main-page signup-page">
				<h3 class="title1">Manage Packages</h3>
				
				
					
			

<div class="table-responsive">
<table id="" class="table table-striped table-bordered table-td-valign-middle">
<thead>
<tr>
<th>#</th>
<th nowrap>Name</th>
<th nowrap>Min</th>
<th nowrap>Max</th>
<th nowrap>Weekly Rate</th>
<th>Referral</th>
<th nowrap>Duration</th>

<th nowrap></th>

</thead>
<tbody>

<?php 
if(isset($_GET["remove"])){
    $toremove = $_GET["remove"];
    
    $conn->query("DELETE  FROM plans WHERE id ='$toremove'");
}

$plans = $conn->query("SELECT * FROM plans ORDER BY id ASC ");
if($plans->num_rows > 0){
    while(
    $pldata = $plans->fetch_assoc()
    ){
    $plname = $pldata["name"];
    $plsn = $pldata["id"];
    $plrate = $pldata["weeklyrate"];
    $plmin = $pldata["minamount"];
    $plmax = $pldata["maxamount"];
    if($plmax ==0 ){
        $plmax = "unlimited";
    }
   $plref = $pldata["referral"];
    $pldur = $pldata["duration"];
    if($pldur < 30){
        $pldur = $pldur. " Days";
    }
    else{
        $pldur = $pldur." days(". $pldur/30 . " months)";
    }
  
    
$action ="<a href='?edit=$plsn' class='label label-primary'>Edit</a> &nbsp;<a href='?remove=$plsn' class='label text-danger'>Remove</a>";
echo "
<tr>
<td>$plsn</td>
<td>$plname</td>

<td>$". $plmin."</td>
<td>$". $plmax."</td>
<td>$plrate %</td>
<td>$plref %</td>
<td>$pldur</td>

<td>$action</td>


</tr>
";


}
} 
    echo"<tr><td colspan='4'><a href='?edit=0' class='btn btn-primary'>Add New Plan</a></td></tr>";




?>


</tbody>
</table>
</div>
	</div>
		</div>
				<?php
if(isset($_GET["edit"]) && $_GET["edit"] !="0"){
    $toedit = $_GET["edit"];
    
    $editplan = $conn->query("SELECT * FROM plans WHERE id ='$toedit'");
if($editplan->num_rows > 0){
    while(
    $edpldata = $editplan->fetch_assoc()
    ){
    $editplname = $edpldata["name"];
    $editplsn = $edpldata["id"];
    $editplrate = $edpldata["weeklyrate"];
      $editplref = $edpldata["referral"];
    $editplmin = $edpldata["minamount"];
    $editplmax = $edpldata["maxamount"];
   
    $editpldur = $edpldata["duration"];
    }
}
  

?>

	<div id="modal-edit" class="modal fade" role="dialog">
				<div class="modal-dialog">
  
				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-header bg-dark">
					  <h4 class="modal-title text-light">Edit <?=$editplname?> Plan</h4>
					  <button type="button" class="close text-light" data-dismiss="modal" onclick='$("#modal-edit").hide()'>&times;</button>
					</div>
					<div class="modal-body bg-dark">
					<form method="post" id="settings_form">
    Enter the new values and Save 
    Name:<input type="text" name="newplname" class="form-control" value="<?=$editplname?>"><br>
    Minimum:<input type="text" name="newplmin" class="form-control" value="<?=$editplmin?>"><br>
    Maximum:<input type="text" name="newplmax" class="form-control" value="<?=$editplmax?>"><br>
    Weekly Rate:<input type="text" name="newplrate" class="form-control" value="<?=$editplrate?>"><br>   
Referral :<input type="text" name="newplref" class="form-control" value="<?=$editplref?>"><br> 
    Duration(Days):<input type="text" name="newpldur" class="form-control" value="<?=$editpldur?>"><br>
    <input type="hidden" name="toedit" value="<?=$toedit?>">

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
				url: "save-plan.php",
				method: "post",
				data: $("#settings_form").serialize(),
				dataType: "text",
				success:function(status){
				var status = $.trim(status);
				console.log(status);
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
							window.location="manageplans.php";
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
if(isset($_GET["edit"]) && $_GET["edit"] =="0"){
    $toedit = $_GET["edit"];


?>
	<div id="modal-edit" class="modal fade" role="dialog" style="z-index:100">
				<div class="modal-dialog">
  
				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-header bg-dark">
					  <h4 class="modal-title text-light">Add New Plan</h4>
					  <button type="button" class="close text-light" data-dismiss="modal" onclick='$("#modal-edit").hide()'>&times;</button>
					</div>
					<div class="modal-body bg-dark">
						 <form method="post" id="settings_form">
    Enter the new values and Save
    Name:<input type="text" name="newplname" class="form-control" value=""><br>
    Minimum:<input type="text" name="newplmin" class="form-control" value=""><br>
    Maximum:<input type="text" name="newplmax" class="form-control" value=""><br>
    Weekly Rate:<input type="text" name="newplrate" class="form-control" value=""><br>  
    Referral:<input type="text" name="newplref" class="form-control" value=""><br>  
    Duration(Days):<input type="text" name="newpldur" class="form-control" value=""><br>
    <input type="hidden" name="toedit" value="newplan">

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
				url: "save-plan.php",
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
							window.location="manageplans.php";
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
require_once("footer.html");
?>	