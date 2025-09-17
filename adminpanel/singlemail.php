<?php
$page_title = "Send Email to Single User";
require_once("head.php");
require_once("nav.html");

$uid= $_GET["uid"];
$view = "profile";
if(!empty($uid)){
    $user_data = $conn->query("SELECT * FROM accounts WHERE userid = '$uid' LIMIT 1");
$r = $user_data->fetch_assoc();
$name = $r["firstname"]." ".$r["lastname"];
$em =$r["email"]; 
}
else{
    $em ="[Enter the email address of the receiver]";$name ="";
}

?>

  <div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">
			    <br><br>
	<h1 class="title1 text-light">Send Mail to user</h1>

									 	<div class="row mb-5">
									 	    
									 	    
		<h4 class="nk-modal-title">Send Email to <?=$name?></h4>
<div class="nk-modal-text">
<p>This is where you sent customised emails to individual accounts</p>
<form class="form" id="mail_form" method="post">
     <div class ="form-group">
        <label for = "ammt">Receiver Email Address</label>
        
        <input class="form-control" name="receiveraddress" id="" value = "<?=$em?>" >
        
    </div>
    <div class ="form-group">
        <label for = "ammt">Subject</label>
        
        <input class="form-control" name="subject" id="msgsubject">
        
    </div>
     <div class ="form-group">
        <label for = "ammt">Message Body</label>
        
       <textarea rows="6" class="form-control" name="message" id="msgbody">
           
       </textarea>
        
    </div>
     <div class ="form-group">
       
<input class="btn btn-primary " type="submit" value="Send" id="mail_form_btn">
        
    </div>
    
</form>
							 	    
									 	    
</div>
			</div>
			</div>
		</div>

<?php
require_once("footer.html");
?>

<script>
    $(document).ready(function(){
        $("#mail_form").submit(function(e){
            	e.preventDefault();
			$("#mail_form_btn").text("sending...");
			$("#mail_form_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "usermail.php",
				method: "post",
				data: $("#mail_form").serialize(),
				dataType: "text",
				success:function(status){
				    console.log(status);
				var status = $.trim(status);
					if(status == 'failed'){
					$("#mail_form_btn").text("Send Message");
					$("#mail_form_btn").attr("disabled", false);
						alert("Failed!", "Email was not sent");
						
					}
						if(status == 'success'){
					$("#mail_form_btn").text("Mail Sent");
					$("#mail_form_btn").attr("disabled", false);
						
							swal({
							    icon:'success',
							    text:'Message has been sent successfully'
							});
							$("#msgsubject").val("");
							$("#msgbody").val("");
						}
				}
        });
        
    });
    });
</script>