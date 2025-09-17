<?php
require_once("head.php");
require_once("nav.html");
?>
<div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">
				<h3 class="title1">Manager All User Accounts</h3>
				
				
                
		<div class="table-responsive">		      
		<table id="" class="table UserTable table-striped table-bordered table-td-valign-middle">
		  
				
<thead>
<tr>
<th width="#"></th>

<th class="text-nowrap">Full Name</th>
<th class="text-nowrap">Email</th>


<!--<th class="text-nowrap">Pass</th>-->
<th class="text-nowrap">Reg. Date</th>
<th class="text-nowrap">Email Verified</th>
<th class="text-nowrap">Wallet Bal.</th>
<th class="text-nowrap">Total Deposit</th>
<th class="text-nowrap">Total Invest</th>
<th class="text-nowrap">Total Withd.</th>
<th></th>
</tr>
</thead>
<tbody>




<?php 

if(isset($_GET["do"]) && isset($_GET["dref"])){
    if($_GET["do"]=='activate'){
        $dref = $_GET["dref"];
        $getdata = $conn->query("SELECT * FROM accounts WHERE userid ='$dref'");
        if($getdata->num_rows ==1){
            $ddata = $getdata->fetch_assoc();
            $user = $ddata["user"];
            $amt = $ddata["amount"];
           $do = $conn->query("UPDATE accounts SET status = 'active' WHERE userid = '$dref' AND status != 'active'");
             if($do){
            
                       echo "<script>alert('Account Activated');location.assign('accounts.php');</script>";
                
             }
        }
       
    }
    if($_GET["do"]=='suspend'){
        $dref = $_GET["dref"];
        $getdata = $conn->query("SELECT * FROM accounts WHERE userid ='$dref'");
        if($getdata->num_rows ==1){
           
             $do = $conn->query("UPDATE accounts SET status = 'suspended' WHERE userid = '$dref' AND status ='active'");
             if($do){
               
                    echo "<script>alert('Account suspended');location.assign('accounts.php');</script>";
                
             }
        }
       
    }
    
    if($_GET["do"]=='delete'){
        $dref = $_GET["dref"];
         $do = $conn->query("DELETE FROM accounts WHERE userid= '$dref'");
        $do = $conn->query("DELETE FROM deposits WHERE user = '$dref'");
         $do = $conn->query("DELETE FROM investments WHERE user = '$dref'");
          $do = $conn->query("DELETE FROM withdrawals WHERE user = '$dref'");
           $do = $conn->query("DELETE FROM wallet WHERE userid = '$dref'");
    }
}


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
$username = $all["username"];
$fullname = $all["firstname"]." ".$all["lastname"];
$userid= $all["userid"];
$walletbal = number_format(walletBalance($userid),2);
$totaldeposit = number_format(getUserDeposits($userid),2);
$totalwithdrawal=number_format(getWithdrawals($userid),2);
$activecapital=getActiveCapital($userid);

$email = $all["email"];

$totalusers += 1;
$phone = $all["phone"];
$status = $all["status"];
$ddate = date("M d,Y ", strtotime($all["regdate"]));
$country = $all["iplocation"];
$emailverified = $all["emailverified"];
$st  = ($emailverified == "n") ? "<span class='label text-warning'>no</span>" : "<span class='text-success'>yes</span>" ;
$action = ($status == "active")?"<a href='?do=suspend&dref=$userid' class='text-warning'>suspend</a> &nbsp; &nbsp;<a href='?do=delete&dref=$userid' class='text-danger'>Delete</a>" : "<a href='?do=activate&dref=$userid' class='text-primary'>activate</a> &nbsp; &nbsp;<a href='?do=delete&dref=$userid' class='text-danger'>Delete</a>";


echo "
<tr class='odd gradeX' >
<td width='25px' class='f-w-600 text-inverse'>$sn</td>

<td><span class='text-primary' onclick='window.location=\"user.php?id=$userid\"' style='cursor: pointer; '>$fullname</span></td>
<td>$email</td>


<td>$ddate</td>
<td>$st</td>
<td>$$walletbal</td>
<td>$$totaldeposit</td>
<td>$$activecapital</td>
<td>$$totalwithdrawal</td>
<td>$action
<a class='btn' href='singlemail?uid=$userid'>Send Mail</a>
</td>


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
		</div>
		
		<?php
require_once("footer.html");
?>