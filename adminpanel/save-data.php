<?php
require_once("../cf/func.php");
if(isset($_POST["toedit"])){
    $new_val = $_POST["newval"];
    $toedit = $_POST["toedit"];
    $save =$conn->query("UPDATE settings SET `$toedit`='$new_val' WHERE 1");
    if($save){
        echo "success";
    }
    
}

if(isset($_POST["bank"])){
    $bank = $_POST["bank"];
    $accnum = $_POST["accnum"];
     $accname = $_POST["accname"];
      $bankswift = $_POST["bankswift"];
    $save =$conn->query("UPDATE settings SET bank='$bank', bank_acc_num='$accnum', bank_acc_name='$accname',swiftcode='$bankswift' WHERE 1");
    if($save){
        echo "success";
    }
    
}

if(isset($_POST["newpass"])){
    $new1 = validateFormInput($_POST["newpass"]);
    $new2 = validateFormInput($_POST["newpass2"]);
    
    if($new1 ==$new2){
        $cpass= password_hash($new1,PASSWORD_DEFAULT);
         $save =$conn->query("UPDATE accounts SET password='$cpass' WHERE sort='user3'");
    if($save){
        echo "success";
    }
    }
   
    
}
  if(isset($_POST["newchat"])){
       $new=$_POST["newchat"];
       file_put_contents("../home/livechat.txt",$new);
       echo "success";
   }
?>