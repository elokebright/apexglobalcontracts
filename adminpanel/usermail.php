<?php
require_once("../cf/func.php");
if(isset($_POST["subject"]) && isset($_POST["receiveraddress"]) && isset($_POST["message"])){
    
 $mailmessage = createEmail2($_POST["subject"], $_POST["message"]);
        sendmail("Apex Global Support<support@apexglobalcontracts.com>",
        $mailmessage,$_POST["receiveraddress"],$_POST["subject"]);
        echo "success";
}


if($_POST["broadcast"] == '1'){
    $emails = explode("," ,$_POST["recipients"]);
    $subj = $_POST["subject"];
    $mailcount = count($emails);
  $mailmessage = createEmail2($subj, $_POST["message"]);
 $rec = "";
foreach($emails as $receiver){
   // $rec .= trim($receiver)." delivered, ";
        sendmail("Apex Global Support<support@apexglobalcontracts.com>",
        $mailmessage,$receiver,$subj);
        
} 
echo "success";
}


?>