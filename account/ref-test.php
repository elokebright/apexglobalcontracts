<?php
require_once("head.php");
require_once("nav.html");

function getReferredUsers($conn, $user_refid) {
    $referrals = [
        1 => [],
        2 => [],
        3 => []
    ];

    // LEVEL 1: Direct referrals
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE sponsor = ?");
    $stmt->bind_param("i", $user_refid);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $referrals[1][] = $row;
        $level1_ids[] = $row['refid'];
    }
    $stmt->close();

    // LEVEL 2: Referred by level 1 users
    if (!empty($level1_ids)) {
        $in = implode(',', array_fill(0, count($level1_ids), '?'));
        $types = str_repeat('i', count($level1_ids));
        $stmt = $conn->prepare("SELECT * FROM users WHERE sponsor IN ($in)");
        $stmt->bind_param($types, ...$level1_ids);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $referrals[2][] = $row;
            $level2_ids[] = $row['refid'];
        }
        $stmt->close();
    }

    // LEVEL 3: Referred by level 2 users
    if (!empty($level2_ids)) {
        $in = implode(',', array_fill(0, count($level2_ids), '?'));
        $types = str_repeat('i', count($level2_ids));
        $stmt = $conn->prepare("SELECT * FROM users WHERE sponsor IN ($in)");
        $stmt->bind_param($types, ...$level2_ids);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $referrals[3][] = $row;
        }
        $stmt->close();
    }

    return $referrals;
}

$referred_users = getReferredUsers($conn, $userrefid);

// Display


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
Level 1 - 7% commission, Level 2 - 3% commission, Level 3 - 1% commission  </p>


<?php
foreach ($referred_users as $level => $users) {
   
?>


				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
				<h5>Level <?=$level?> Referrals</h5>
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th>Name</th>
                              <th> Email</th>
                                <th>Date registered</th>
                              
							</tr> 
						</thead> 
						<tbody>

<?php
    if (empty($users)) {
        echo "<tr><td colspan=3>No records found.</td></tr>";
    } else {
  
        foreach ($users as $user) {
            echo "<tr>	<td>{$user['firstname']} {$user['lastname']}</td><td>{$user['email']}</td><td>{$user['regdate']}</td></tr>";
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