<?php
$serername="localhost";
$username ="u992425573_apex";
$password ='B2nS3YLufv?nytytyy';
$database ="u992425573_apexglobal";

$conn1= mysqli_connect($serername,$username,$password,$database) or die("Server Connection failed");
$conn = new mysqli($serername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>