<?php
require_once("../cf/func.php");
if(isset($_POST["toedit"])){
    $newplname = $_POST["newplname"];
    $newplmin = $_POST["newplmin"];
    $newplmax = $_POST["newplmax"];
    $newplrate = $_POST["newplrate"];
    $newpldur = $_POST["newpldur"];
    $toedit = $_POST["toedit"];
    
    if($toedit == "newplan"){
       $save= $conn->query("INSERT INTO plans(name,minamount,minreturn,maxamount,maxreturn,weeklyrate,duration) VALUES('$newplname','$newplmin','$newplmin','$newplmax','$newplmax','$newplrate','$newpldur')");
        echo 'success';
        exit();
    }
    else{
       $save= $conn->query("UPDATE plans SET name='$newplname', minamount ='$newplmin',maxamount ='$newplmax',weeklyrate='$newplrate',duration='$newpldur' WHERE id='$toedit'");
        echo 'success';
        exit();
    }
   $save =$conn->query("UPDATE settings SET $toedit='$new_val' WHERE 1");
    if($save){
        echo "success";
    }
    
}


?>