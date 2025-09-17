<?php
require_once("head.php");
require_once("nav.html");


$referred_users = getReferredUsers($userrefid);

// Display

function abonusFromUser($usr){
    global $conn;
    $q= $conn->query("SELECT SUM(amount) AS sm FROM commissions WHERE userfrom ='$usr'");
     $r= $q->fetch_assoc()["sm"];
    if(!is_null($r)){
        return $r;
    }
    else{
        return 0;
    }
}
?>

<div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">
				<h3 class="title1">Refer users to Apexglobal Contracts community</h3>

				                
                
                

				<div class="sign-up-row widget-shadow">
                    <strong>You can refer users by sharing your referral link:</strong><br>
					<h4 style="color:green;"> https://apexglobalcontracts.com?ref=<?=$userrefid?></h4>
                
				</div>
				
				<h3 class="title1">
                <small>Your sponsor</small><br>
                <i class="fa fa-user"></i><br>
                <small><?=$sponsor_user?></small>
                </h3>

<p>There are 3 Referral Levels: <br>
Level 1 -- 7% commission, Level 2 -- 3% commission, Level 3 -- 1% commission  </p>


<?php
foreach ($referred_users as $level => $users) {
   
?>


				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
				<h5>Level <?=$level?> Referrals</h5>
					<table class="table table-hover"> 
						<thead> 
							<tr> 
							<th>#</th>
								<th>Name</th>
                              <th> Email</th>
                                <th>Date registered</th>
                                <th>My Bonus</th>
                              
							</tr> 
						</thead> 
						<tbody>

<?php

    if (empty($users)) {
        echo "<tr><td colspan=4>No records found.</td></tr>";
    } else {
  $sn = 1;
        foreach ($users as $user) {
            $mybonus = abonusFromUser($user["userid"]);
            echo "<tr><td>$sn</td>	<td>{$user['firstname']} {$user['lastname']}</td><td>{$user['email']}</td><td>{$user['regdate']}</td><td>$ {$mybonus}</td></tr>";
            $sn++;
        }
      
    }
echo "	</tbody> 
					</table>
				</div>";    
}

?>


						                                      
							
				
			</div>
		</div>
<?php
require_once("bottom.php");
?>