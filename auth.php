<?php
require_once("cf/func.php");


if(isset($_POST["fname"]) && isset($_POST["lname"])){
$sponsor = "";
if(isset($_COOKIE["sponsor"])){
    $sponsor = $_COOKIE["sponsor"];
}

//$captcha_code = $_SESSION["captcha_code"];
$erro_msg ="";

    $fname = mysqli_real_escape_string($conn,validateFormInput($_POST["fname"]));
   // $username = mysqli_real_escape_string($conn,validateFormInput($_POST["username"]));
    $email = mysqli_real_escape_string($conn,validateFormInput($_POST["email"]));
   
    $lname = mysqli_real_escape_string($conn,validateFormInput($_POST["lname"]));
    // $usercaptcha = mysqli_real_escape_string($conn,validateFormInput($_POST["captcha"]));
   
   $phone = mysqli_real_escape_string($conn,validateFormInput($_POST["phone"]));
    $password = mysqli_real_escape_string($conn,validateFormInput($_POST["password"]));
      $password2 = mysqli_real_escape_string($conn,validateFormInput($_POST["password2"]));
      $hashed_pass = password_hash($password,PASSWORD_DEFAULT);
    $country =validateFormInput($_POST["country"]);

    $userid = time().uniqid();
    $refid=uniqid();
    $upline="";
    $upline = (!empty($_POST["sponsor"]))? mysqli_real_escape_string($conn,validateFormInput($_POST["sponsor"])): $sponsor;

    
    //$pass_hash = password_hash($password,PASSWORD_DEFAULT);
    $checkEmail = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM accounts WHERE email ='$email'"));
    if ($checkEmail >0) {
        echo "found";
        exit();
    }
  
    
   
  


if( $fname == "" || $lname =="" || $email == ""  || $password ==""){
    echo "incomplete";
    exit();
    
}
       $activationcode=generateOTP(6);;

    $save = mysqli_query($conn,"INSERT INTO accounts(sponsor,refid,userid, firstname,lastname,password,email,phone,emailcode,country) VALUES ('$upline','$refid','$userid','$fname','$lname','$hashed_pass','$email','$phone','$activationcode','$country')")
     or die("server error");
     
    

     if ($save){
         $_SESSION["useremail"]=$email;
         $fullname = $fname." ". $lname;
         $now = date("Y-m-d H:i:s");
         $createwallet = mysqli_query($conn,"INSERT INTO wallet(userid,balance,lastupdated) VALUES('$userid',0,'$now')");
         
         $smsmessage = "Welcome to Apexglobal Contracts. Your account has been created. We are glad to have you among our esteemed investors. Thank you.";
        $mailmessage = createEmailMessage("Welcome, $fullname", "Your ApexGlobal  account has been created. You can login to your user panel and make your first deposit.<br>
        <h3>$activationcode</h3>");
        $token = base64_encode($activationcode);
        $token_user = base64_encode($email);
        $verifylink="https://app.apexglobalcontracts.com/verify?token=$token&user=$token_user";
        $mailmessage = verifyEmail($fullname,$email,$activationcode,$verifylink);
               sendmail("Apex Global<nonreply@apexglobalcontracts.com>",$mailmessage,$email,"Confirmation Email for $fullname at ApexGlobalContracts");
        
        $mailmessage=createEmailMessage("New User Alert","A new account has been created. The account details are: <br>Name :-$fullname. <br>Email Adress:- $email <br> Phone Number:- $phone<br>Country :- $country<br>");
        sendmail("Apex Global Contracts Account<info@apexglobalcontracts.com>",$mailmessage,'info@apexglobalcontracts.com','Apexglobal Contracts New Account');
        
            if($upline !=""){
    $getuplinedata = $conn->query("SELECT * FROM accounts WHERE username='$upline'");
    if($getuplinedata->num_rows ==1){
        $sponsordata = $getuplinedata->fetch_assoc();
        $sponsor_email = $sponsordata["email"];
     $sponsor_msg = "<tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\">
                            <p style=\"margin: 0;\">New Referral Registered</p>
                        </td>
                    </tr>
                 
                 
                    <tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 10px 10px 10px 10px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\">
                            <p style=\"margin: 0;\"><span target=\"_blank\" style=\"color: #14183d;\"><b>Dear $upline,</b><br>A new user has registered under you:></span>
                            Name-: $fullname <br>
                            Email Address-: $email<br>
                        Thank you for referring users to our platform and keep up the good work.<br> You will earn commissions up to 100%  on every profit made by your your referrals.
                         
                            </p>
                        </td>
                    </tr>
                       <tr>
                        <td bgcolor=\"#ffffff\" align=\"center\" style=\"padding: 0px 5px 0px 5px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\">
                    
                        </td>
                    </tr> <!-- COPY -->
                    ";
                     $mailmsg = createEmail2("New Referral Alert",$sponsor_msg);
                    sendmail('Apexglobal Contracts Affiliate Program<info@apexglobalcontracts.com>',$mailmsg,$sponsor_email,'New Referral Alert');
                     
    }
    }
        
        
        echo "success";
     }
     else {
         echo "failed";
     }
    }


if (isset($_POST["email"]) && isset($_POST["passcode"])) {
    $email_phone=validateFormInput($_POST["email"]);
    $email_phone = mysqli_real_escape_string($conn,$email_phone);
    $pass =validateFormInput($_POST["passcode"]);
    $pass = mysqli_real_escape_string($conn,$pass);

    $check = mysqli_query($conn,"SELECT * FROM accounts WHERE email ='$email_phone'") or die(mysqli_error($conn));
    if (mysqli_num_rows($check) ==0) {
        echo 'not found';
    }
    else{
        $saved_data = mysqli_fetch_array($check);
        $hashed_pass = $saved_data["password"];
        $userid = $saved_data["userid"];
        $useremail= $saved_data["email"];
        $email_verified = $saved_data["emailverified"];
        $suspended = $saved_data["status"];
        $twofa= $saved_data["twofa"];
    

        if (password_verify($pass,$hashed_pass)) {
            if($suspended == 'suspended'){
                echo 'suspended';
                exit();
            }
        if($email_verified =="y"){
           
            
            if($twofa == 0){
             $_SESSION["userid"] = $userid;
             $logintime = date("Y-m-d h:i:s");
             $conn->query("UPDATE accounts SET lastlogin = '$logintime' WHERE userid='$userid'");
            echo 'success';
            exit();
            }
            else{
                $_SESSION["useremail"] = $useremail;
                 $twofacode = substr(uniqid(""),6);
                 $_SESSION["2facode"] = $twofacode;
                 
                 $mailmessage ="<tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\">
                            <p style=\"margin: 0;\">Your Account Login Code is:</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor=\"#ffffff\" align=\"left\">
                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                    <td bgcolor=\"#ffffff\" align=\"center\" style=\"padding: 20px 30px 60px 30px;\">
                                        <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                            <tr>
                                                <td align=\"center\">
                                                    <h1>$twofacode</h1>
                                                    </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> <!-- COPY -->
                 
                    ";
                    $msg = createEmail2("2-FA Login Code",$mailmessage);
                    sendmail('Login Code<no-reply@apexglobalcontracts.com>',$msg,$useremail,'Apexglobal Contracts Login Code');
                echo "2fa";
            }
        
            }
        else{
             $_SESSION["userid"] = $userid;
             $_SESSION["useremail"] = $useremail;
            echo 'unverified';
        }
        }
        else{
            echo 'incorrect';
        }

    }

}


if (isset($_POST["forgotpassword_email"])) {
  
    $email_or_phone=validateFormInput($_POST["forgotpassword_email"]);
    

    $check = mysqli_query($conn,"SELECT * FROM accounts WHERE email ='$email_or_phone' OR phone = '$email_or_phone'");
    if (mysqli_num_rows($check) ==0) {
        echo 'not found';
    }
    else{
        $saved_data = mysqli_fetch_array($check);
        //$hashed_pass = $saved_data["password"];
        $userid = $saved_data["userid"];
        $user_email = $saved_data["email"];
        $resetcode = substr(uniqid(""),8);
        //$mailmessage = createEmailMessage("Reset Password", "You have requested to reset your account password. Use the code below to reset your password:<br><h3>$resetcode</h3>
        //");
        
        $mailmessage ="<tr>
                        <td bgcolor=\"#ffffff\" align=\"left\" style=\"padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;\">
                            <p style=\"margin: 0;\">You have requested to reset your account password. Your Password Reset Code is:</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor=\"#ffffff\" align=\"left\">
                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                    <td bgcolor=\"#ffffff\" align=\"center\" style=\"padding: 20px 30px 60px 30px;\">
                                        <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                            <tr>
                                                <td align=\"center\">
                                                    <h1>$resetcode</h1>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> <!-- COPY -->
                 
                    ";
                    $msg = createEmail2("Reset Your Password",$mailmessage);
                    sendmail('Password Reset Code<no-reply@apexglobalcontracts.com>',$msg,$user_email,'Apexglobal Contracts Account Recovery');

        $_SESSION["resetcode"]= $resetcode;
        $_SESSION["resetcodeemail"]= $user_email;
        echo "codesent";

    }

}



if (isset($_POST["resetcode"]) && isset($_POST["new_pass1"])) {
  
    $resetemail=validateFormInput($_SESSION["resetcodeemail"]);
    $resetcode = validateFormInput($_POST["resetcode"]);
    $newpass1 = validateFormInput($_POST["new_pass1"]);
     $newpass2 = validateFormInput($_POST["new_pass2"]);
     if($newpass1 == $newpass2 && $resetcode == $_SESSION["resetcode"]){
         $passhash = password_hash($newpass1,PASSWORD_DEFAULT);
     
    $save = mysqli_query($conn,"UPDATE accounts SET password ='$passhash' WHERE email ='$resetemail'");
    if ($save) {
        echo 'success';
    }
    else{
        echo "failed";
    }
     }
     else{
         echo "failed";
     }

}

if (isset($_POST["adminemail_username"]) && isset($_POST["adminloginpass"])) {
    $email_phone=validateFormInput($_POST["adminemail_username"]);
    //$email_phone = mysqli_real_escape_string($conn,$email_phone);
    $pass =validateFormInput($_POST["adminloginpass"]);
    //$pass = mysqli_real_escape_string($conn,$pass);

    $check = mysqli_query($conn,"SELECT * FROM accounts WHERE (email ='$email_phone' OR username ='$email_phone') AND sort ='user3'") or die(mysqli_error($conn));
    if (mysqli_num_rows($check) ==0) {
        echo 'not found';
    }
    else{
        $saved_data = mysqli_fetch_array($check);
        $hashed_pass = $saved_data["password"];
        $userid = $saved_data["userid"];

        if (password_verify($pass,$hashed_pass)) {
        
            $_SESSION["adminid"] = $userid;
            echo 'success';
        }
        else{
            echo 'incorrect';
        }

    }

}


if(isset($_GET["action"]) && $_GET["action"] == "resendemailcode"){
     $activationcode=substr(uniqid(""),8);
     
     $useremail = $_SESSION["useremail"];
     $do = mysqli_query($conn,"UPDATE accounts SET emailcode ='$activationcode' WHERE email ='$useremail'");
     
     
     if($do){
         
sendVerificationCode($useremail,"",$activationcode);
         echo 'sent';
     }
     else{
         echo 'error';
     }
}

if(isset($_POST["2facode"])){
    $code = mysqli_real_escape_string($conn,validateFormInput($_POST["2facode"]));
    
    if(!isset($_SESSION["useremail"]) || !isset($_SESSION["2facode"])){
        header("Location : login.html");
    }
    $useremail = $_SESSION["useremail"];
    $okcode  = $_SESSION["2facode"];
   
    if($code == $okcode){
        $dat = mysqli_fetch_array(mysqli_query($conn,"SELECT userid FROM accounts WHERE email ='$useremail'"))["userid"];
        $_SESSION["userid"] = $dat;
       echo "success";
    }
    else{
        echo "mismatch";
    }
}

if(isset($_POST["emailcode"])){
    $emailcode = mysqli_real_escape_string($conn,validateFormInput($_POST["emailcode"]));
    
    if(!isset($_SESSION["useremail"]) && !isset($_POST["user"])){
        header("Location : index.html");
    }
    $useremail = $_SESSION["useremail"];
    $getcode  = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM accounts WHERE email ='$useremail'"));
    $savedcode = $getcode["emailcode"];
    $userid = $getcode["userid"];
    
    if($emailcode == $savedcode){
        $update = mysqli_query($conn,"UPDATE accounts SET emailverified='y' WHERE userid ='$userid'");
        $_SESSION["userid"] = $userid;
       echo "verified";
    }
    else{
        echo "notmatch";
    }
}
    



?>