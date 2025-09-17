<?php
require_once("cf/func.php");

    global $conn;


// Current date
$current_date = date('Y-m-d');

// SQL to select all records from the capitals table
 $result= mysqli_query($conn,"SELECT sn,user,capital,rate,dateactivated,duedate FROM investments WHERE status =1");

   $conn->query("DELETE FROM earnings WHERE 1");
if ($result->num_rows > 0) {
    // Loop through each record
    while($row = $result->fetch_assoc()) {
        $sn = $row['sn'];
        $start_date = $row['dateactivated'];
        $end_date = $row['duedate'];
        $amount_invested = $row['capital'];
        $rate = $row['rate'];
		$investor=$row["user"];
        // Calculate the number of 7-day periods between start_date and current_date or end_date
        $period_start = new DateTime($start_date);
        $period_end = new DateTime(min($end_date, $current_date));
        $interval = $period_start->diff($period_end);

        // Calculate the number of weeks (7-day periods)
        $weeks = floor($interval->days / 7);
     
 for($i = 0; $i < $weeks; $i++){
     $recdate = strtotime("+7 days",strtotime($start_date));
     $datetorecord = date("Y-m-d H:i:s",$recdate);
        // Calculate the profit
        $profit = $amount_invested * $rate /100;

        // If profit is greater than zero, insert it into the earning_history table
        if ($profit > 0) {
            $iq = "INSERT INTO earnings(amount,user,time_recorded, ref) 
                           VALUES ('$profit', '$investor','$datetorecord', '$sn')";
                           
            $conn->query($iq);
            $conn->query("UPDATE investments SET lastupdated ='$datetorecord' WHERE sn ='$sn' AND user='$investor'");
            
        }
        $start_date =$datetorecord;
    }    
    }
} else {
    echo "No records found in the capitals table.";
}

// Close connection
$conn->close();
?>
