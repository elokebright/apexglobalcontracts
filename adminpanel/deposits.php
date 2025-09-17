<?php
require_once("head.php");
require_once("nav.html");
?>
<div id="page-wrapper" style="min-height: 556px;">
			<div class="main-page signup-page">
				<h3 class="title1">Manage Deposits</h3>
				<p> Pending deposits are shown first</p>
				
				
				
				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
				<table  class="UserTable table table-hover text-light"> 
									<thead> 
										<tr> 
											<th>ID</th> 
											<th>User</th>
											<th>Amount</th>
											<th>Payment mode</th>
											<th>Wallet Address</th>
											<th>Status</th> 
											<th>Proof</th>
											<th>Date</th>
											<th></th>
										</tr> 
									</thead> 
									<tbody> 
									<?php
									
if(isset($_GET["do"]) && isset($_GET["dref"])){
    if($_GET["do"]=='approve'){
        $dref = $_GET["dref"];
        $getdata = $conn->query("SELECT * FROM deposits WHERE reference ='$dref' AND status = 0");
        
        if($getdata->num_rows ==1){
            $ddata = $getdata->fetch_assoc();
            $user = $ddata["user"];
            $amt = $ddata["amount"];
             //$camt = $ddata["coinvalue"];
            //$plan = $ddata["plan"];
            $add = $ddata["address"];
            $coin = $ddata["coin"];
            $userdata = mysqli_fetch_array(mysqli_query($conn,"SELECT firstname,sponsor, lastname,email FROM accounts WHERE userid = '$user'"));
        $user_name = $userdata["firstname"]." ". $userdata["lastname"];
        $useremail = $userdata["email"];
        
       
        $user_sponsor = $userdata["sponsor"];
        $getsponsordata = $conn->query("SELECt userid,email FROM accounts WHERE refid ='$user_sponsor'");
        $sponsordata = $getsponsordata->fetch_assoc();
        $sponsor = $sponsordata["userid"];
        $sponsor_email = $sponsordata["email"];
        if(!empty($sponsor)){
            $sponsor_bonus = $amt * 0.1;
              updateWallet($sponsor,$sponsor_bonus,'add');
              $bonus_detail = "Referral commission earned from $$amt deposit made by $user_name";
              $do= $conn->query("INSERT INTO commissions(user,amount,type,description) VALUES('$sponsor','$sponsor_bonus','refbonus','$bonus_detail')");
              
              
                $sponsormsg = "
                 
                 
                    <tr>
                        <td style=\"padding: 0 30px 20px\">
                            <p style=\"margin: 0;\"><span target=\"_blank\" style=\"color: #14183d;\">You have received a referral commission<br></span>
                            Amount: $$sponsor_bonus <br>
                            Detail: $bonus_detail<br>
                         
                           
                         
                            
                            
                            </p>
                        </td>
                    </tr>
                       <tr>
                        <td style=\"padding: 0 30px 20px\">
                           
                            <p>This amount has been credited to your account balance
                        </td>
                    </tr> 
                    ";
                     $mailmsg = createEmail2("Referral Commission of $$sponsor_bonus Received",$sponsormsg);
                    sendmail('Referral Commission<info@apexglobalcontracts.com>',$mailmsg,$sponsor_email,'Referral Commission');
                    push_notice($sponsor_email, "$$sponsor_bonus commission received", "You have earned a referral commission of $$sponsor_bonus. The amount has been credited to your balance");
        }
             $do = $conn->query("UPDATE deposits SET status =1 WHERE reference = '$dref'");
             
             updateWallet($user,$amt,'add');
         
         $msg = "
                 
                 
                    <tr>
                        <td style=\"padding: 0 30px 20px\">
                            <p style=\"margin: 0;\"><span target=\"_blank\" style=\"color: #14183d;\">Dear $user_name,<br> we have verified your deposit of $$amt. Transaction details:<br></span>
                            Coin: $coin <br>
                            Wallet Address: $add<br>
                            Amount: $amt<br>
                           
                            Reference: $dref<br>
                            
                            
                            </p>
                        </td>
                    </tr>
                       <tr>
                        <td style=\"padding: 0 30px 20px\">
                           
                            <p>Your account balance has been updated. Thank You.
                        </td>
                    </tr> 
                    ";
                     $mailmsg = createEmail2("Deposit of $$amt Confirmed",$msg);
                    sendmail('Deposit confirmed<info@apexglobalcontracts.com>',$mailmsg,$useremail,'Deposit Payment Confirmation');
                    push_notice($useremail, "$$amt Deposit Confirmed", "Your deposit of $amt $coin to the address: $add has been confirmed. The amount has been credited to your balance");
        
             if($do){
               
                    echo "<script>alert('Deposit Approved');location.assign('deposits.php');</script>";
                
             }
        }
       else{
                 echo "<script>location.assign('deposits.php');</script>";
       }
    }
    if($_GET["do"]=='cancel'){
        $dref = $_GET["dref"];
        $getdata = $conn->query("SELECT * FROM deposits WHERE reference ='$dref'");
        if($getdata->num_rows ==1){
            $ddata = $getdata->fetch_assoc();
            $user = $ddata["user"];
            $amt = $ddata["amount"];
             $do = $conn->query("UPDATE deposits SET status =0 WHERE reference = '$dref'");
             if($do){
                if(updateWallet($user,$amt,'minus')){
                    echo "<script>alert('Deposit Cancelled');location.assign('deposits.php');</script>";
                }
             }
        }
       
    }
    
    if($_GET["do"]=='delete'){
        $dref = $_GET["dref"];
        $do = $conn->query("DELETE FROM deposits WHERE reference = '$dref'");
    }
}
									
									$getdeposit = $conn->query("SELECT * FROM deposits  ORDER BY datesubmited DESC");
									if($getdeposit->num_rows >0){
									     $sn=1;
									     $totaldp=0;
									    while($dp = $getdeposit->fetch_assoc()){
									       $user = $dp["user"];
									       
$userdata = mysqli_fetch_array(mysqli_query($conn,"SELECT firstname,lastname FROM accounts WHERE userid='$user'"));
$depositorname = $userdata["firstname"]." ".$userdata["lastname"];

$dref = $dp["reference"];
									       $proof =$dp["proof"];
									       $prooflink = (!empty($proof))?"<a href='../account/$proof'>view proof</a>":"none";
									        $damt = $dp["amount"];
									        $totaldp += $damt;
									        $meth = $dp["coin"];
									         $add = $dp["address"];
									        $dst = $dp["status"];
									        $st = ($dst ==0)?"<span class='text-warning'><i class='fa fa-question-circle'></i> pending</span>":"<span class='text-success'><i class='fa fa-check'></i> confirmed</span>";
									        $dt = date("D M d, Y, h:ia",strtotime($dp["datesubmited"]));
									        $action = ($dst =="0")?"<a href='?do=approve&dref=$dref' class='text-success'>Approve</a> &nbsp; &nbsp;<a href='?do=delete&dref=$dref' class='text-danger'>Delete</a>":"<a href='?do=cancel&dref=$dref' class='text-danger'>Cancel</a>";
									        echo "		<tr> 
											<th scope=\"row\">$sn</th>
											<td>$depositorname</td>
											<td>$$damt</td> 
											<td>$meth</td> 
												<td>$add</td>
											<td>$st</td> 
											<td>$prooflink</td>
											<td>$dt</td> 
											<td>$action</td>
										</tr> ";
										$sn++;
									    }
									}
									?>
																		</tbody> 
								</table>
				</div>
			</div>
		</div>

		

			
	
			
		
			
		<?php
require_once("footer.html");
?>	