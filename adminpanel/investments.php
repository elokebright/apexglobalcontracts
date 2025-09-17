<?php
require_once("head.php");
require_once("nav.html");
?>

<div id="page-wrapper" style="min-height: 556px;">
    <h3 class="title1">Manage Investments</h3>
    	<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
							<table  class="UserTable table table-hover text-light"> 
									<thead> 
										<tr> 
											<th>ID</th> 
											<th>User</th>
											<th>Plan</th>
											<th>Capital</th>
											<th>Rate %</th>
											<th>Profit</th>
											<th>Active Days</th>
											<th>Status</th> 
										
											<th>Date</th>
											<th></th>
										</tr> 
									</thead> 
        									<tbody> 
        									<?php
        								if(isset($_GET["do"]) && isset($_GET["dref"])){
    if($_GET["do"]=='activate'){
        $dref = $_GET["dref"];
  $do = $conn->query("UPDATE investments SET status =1 WHERE sn = '$dref'");
        
        }
       
    if($_GET["do"]=='suspend'){
        $dref = $_GET["dref"];
         $do = $conn->query("UPDATE investments SET status =0 WHERE sn = '$dref'");
        
       
    }
      if($_GET["do"]=='delete'){
        $dref = $_GET["dref"];
         $do = $conn->query("DELETE FROM investments WHERE sn = '$dref'");
        
       
    }

}

$idata = $conn->query("SELECT * FROM investments ORDER BY dateactivated DESC");
if ($idata->num_rows != 0) {
    $sn =1;$totaldp = 0.00;
while($all = $idata->fetch_assoc()){
$damount = $all["capital"];
$plan = $all["plan"];
$user = $all["user"];
     $userdata = mysqli_fetch_array(mysqli_query($conn,"SELECT firstname, lastname,email FROM accounts WHERE userid = '$user'"));
        $user_name = $userdata["firstname"]." ". $userdata["lastname"];
$totaldp += $damount;
$rate = $all["rate"];
$dref=$all["sn"];
$dayscount = $all["dayscount"];
$current_profit = $all["currentprofit"];
$ddate = date("d M Y, H:i", strtotime($all["dateactivated"]));
$dstatus = $all["status"];
$st  = ($dstatus == "0") ? "<span class='label label-warning'>inactive</span>" : "<span class='label label-success'>active <i class='fa fa-cog fa-spin'></i></span>&nbsp; " ;
$action = ($dstatus =="0")?"<a href='?do=activate&dref=$dref' class='text-success'>Activate</a>&nbsp;<a onclick=\"return confirm('Are you sure about this? if you delete this investment, it cannot be reversed.')\" href='?do=delete&dref=$dref' class='text-danger'>Delete</a>":"<a href='?do=suspend&dref=$dref' class='text-warning'>Suspend</a> <a href='editprofit.php?dref=$dref' class='text-primary'>Edit  Profit</a>";
echo "
<tr>
<td>$sn</td>
<td>$user_name</td>
<td>$plan</td>
<td>$". number_format($damount)."</td>

<td>$rate</td>
<td>$$current_profit</td>
<td>$dayscount</td>
<td>$st</td>

<td>$action</td>
<td>$ddate</td>


</tr>
";
$sn++;

}
} else {
    echo '<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available in table</td></tr></tbody> ';
}
      
    
        									?>
        										        									
        								</table></div></div>
    </div>



<?php
require_once("footer.html");
?>	