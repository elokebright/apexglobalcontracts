<?php
require_once("head.php");
require_once("nav.html");
?>
<div id="page-wrapper" style="min-height: 556px;">
			<div class="main-page signup-page">
				<h3 class="title1">Manage KYC approval</h3>
					<div class="table-responsive">
<table id="" class="table UserTable table-striped table-bordered table-td-valign-middle">
<thead>
<tr>
<th width="#"></th>

<th class="text-nowrap">Full Name</th>
<th class="text-nowrap">Prof. Image</th>
<th class="text-nowrap">Id Front</th>
<th class="text-nowrap">Id Back</th>
<th class="text-nowrap">KYC Status</th>
<th class="text-nowrap"></th>
<th></th>
</tr>
</thead>
<tbody>




<?php 




if (!isset ($_GET['page']) ) {  
    $pagenum = 1;  
} else {  
    $pagenum = $_GET['page'];  
} 
   
$results_per_page = 15;
$usersquery = "SELECT * FROM accounts WHERE sort != 'user3'";  
$result = mysqli_query($conn, $usersquery);  
 $number_of_accounts = mysqli_num_rows($result);  
$number_of_pages = ceil ($number_of_accounts / $results_per_page);  
$page_first_result = ($pagenum-1) * $results_per_page; 
$allusers = $conn->query("SELECT * FROM accounts WHERE sort != 'user3'");
if(isset($_GET["q"])){
    $q= $_GET["q"];

$usersquery = "SELECT * FROM accounts WHERE sort != 'user3' AND (username LIKE '%$q%' OR email LIKE '%$q%' OR firstname LIKE '%$q%' OR lastname LIKE '%$q%')";  
$result = mysqli_query($conn, $usersquery);  
 $number_of_accounts = mysqli_num_rows($result);  
$number_of_pages = ceil ($number_of_accounts / $results_per_page);  
$page_first_result = ($pagenum-1) * $results_per_page; 
$allusers = $conn->query("SELECT * FROM accounts WHERE sort != 'user3' AND (username LIKE '%$q%' OR email LIKE '%$q%' OR firstname LIKE '%$q%' OR lastname LIKE '%$q%') LIMIT $page_first_result,$results_per_page");
}



if ($allusers->num_rows != 0) {
    $sn =$page_first_result+1;$totalusers = 0;
while($all = $allusers->fetch_assoc()){
//$username = $all["username"];
$fullname = $all["firstname"]." ".$all["lastname"];
$userid= $all["userid"];
$walletbal = number_format(walletBalance($userid),2);
$totaldeposit = number_format(getUserDeposits($userid),2);
$totalwithdrawal=number_format(getWithdrawals($userid),2);
$activecapital=getActiveCapital($userid);

$email = $all["email"];
//$userpass = $all["plainp"];
$totalusers += 1;
$phone = $all["phone"];
$status = $all["status"];
$ddate = date("M d,Y ", strtotime($all["regdate"]));
$country = $all["iplocation"];
$emailverified = $all["emailverified"];
$st  = ($emailverified == "n") ? "<span class='label label-warning'>no</span>" : "<span class='label text-success'>yes</span>" ;
$action = ($status == "active")?"<a href='?do=suspend&dref=$userid' class='label text-warning'>suspend</a> &nbsp; &nbsp;<a href='?do=delete&dref=$userid' class='label text-danger'>Delete</a>" : "<a href='?do=activate&dref=$userid' class='label text-primary'>activate</a> &nbsp; &nbsp;<a href='?do=delete&dref=$userid' class='label text-danger'>Delete</a>";

$profileimage = $all["profileimage"];
$idfrontimage=$all["idfront"];
$idbackimage = $all["idback"];
$userphoto_exists = file_exists("../account/".$profileimage);
$profileimage =($userphoto_exists)?"<a href='../account/$profileimage'><img src='../account/$profileimage' style='max-width:60px'></a>":"Not uploaded";



$idfront ="../account/".$idfrontimage;
$frontid_exists = file_exists($idfront);
if(!$frontid_exists){
    $idfrontimage="Not uploaded";
}
else{
    $idfrontimage="<a href='../account/$idfrontimage'><img src='../account/$idfrontimage' style='max-width:100px'></a>";
}
$backid_exists = file_exists("../account/".$idbackimage);
//$idfrontimage =($frontid_exists)?"<a href='../dashboard/$idfrontimage'>View</a>":"Not uploaded";
$idbackimage =($backid_exists)?"<a href='../account/$idbackimage'><img src='../account/$idbackimage' style='max-width:100px'></a>":"Not uploaded";

$idverified =$all["idverified"];
$kyc =$all["kyc"];
$kycstatus =($kyc ==1)?"Approved":"pending";
$kycstatus =($kyc ==2)?"Declined":$kycstatus;

if($kyc==0){
    $act = "KYC pending <a href=\"#\" onclick='approveID(\"$userid\")' class=\"btn btn-xs btn-success\">Approve KYC</a>&nbsp;<a href=\"cancelkyc?u=$userid\" class=\"btn btn-danger btn-xs\">Cancel KYC</a>";
    
}
else if($kyc==2){
    $act = "<span style='color:red'>declined</span> <a href=\"#\" onclick='approveID(\"$userid\")' class=\"btn btn-xs btn-success\">Approve Again</a>&nbsp";
    
}
else{$act= "KYC completed</h3>";}

echo "
<tr class='odd gradeX' onclick='window.location=\"user.php?id=$userid\"' style='cursor: pointer; '>
<td width='25px' class='f-w-600 text-inverse'>$sn</td>

<td>$fullname</td>
<td>$profileimage</td>

<td>$idfrontimage</td>
<td> $idbackimage</td>
<td>$kycstatus</td>

<td>$act</td>


</tr>

";
$sn++;

}
} else {
    echo"<tr><td colspan='4'>No records found.</td></tr>";
}



?>


</tbody>
</table>



</div>
			</div>
		</div>

		

			
	  <script>
    function approveID(user){
          $.get("id_approval.php?user="+user, function(data, status){
              if(data =="success"){
                  	swal({
							    icon:'success',
							    text:'ID approved'
							});
							window.location.refresh;	
              }
              else{
                  	swal({
							    icon:'error',
							    text:'something went wrong. Try again'
							});
              }
  
  });
    }
</script>
			
		
			
		<?php
require_once("footer.html");
?>	