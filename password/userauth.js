$(document).ready(function(){

/*	function alert(title,message){

    alertify.alert(title, message);
   }
   
   function alerterror(msg,delay){
    alertify.set('notifier','position', 'top-center');
    alertify.error(msg, delay);
   }
   */
   
   
   
   
//Registration Field
	$("#register_Form").submit(function(e){
		e.preventDefault();
		
	
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var password = $("#passcode").val();
		var cpassword = $("#passcode2").val();
	
	
	
		if (password != cpassword) {
		
			  	err = '<div class="alert-notices mb-4"><ul><li class="alert alert-danger alert-icon"><em class="icon ni ni-alert-fill"></em> Passwords do not match. check your password.</li></ul</div>';
						
						$("#msgbox").html(err);
			return false;
		}
		
              
			$("#registerBtn").text("processing, wait...");
			$("#registerBtn").attr("disabled", true);
			$.ajax({
				url: "auth.php",
				method: "post",
				data: $("#register_Form").serialize(),
				dataType: 'text',
                cache: false,             // To unable request pages to be cached
                success:function(status){
				    	status = $.trim(status);
					if(status === 'found'){
					        $("#registerBtn").text("Register");
							$("#registerBtn").attr("disabled", false);
						err = '<div class="alert-notices mb-4"><ul><li class="alert alert-danger alert-icon"><em class="icon ni ni-alert-fill"></em> The email address you entered is registered already. Login instead.</li></ul</div>';
						
						$("#msgbox").html(err);
						
						
					}
			
					else if(status === 'usernamefound'){
					        $("#registerBtn").text("Register");
							$("#registerBtn").attr("disabled", false);
					//	alerterror("Email Found!", "The username you provided has been taken, try a different one.");
						err = '<div class="alert-notices mb-4"><ul><li class="alert alert-danger alert-icon"><em class="icon ni ni-alert-fill"></em> The username you provided has been taken, try a different one.</li></ul</div>';
						
						$("#msgbox").html(err);
					}
					else if(status === 'success'){
					   	err = '<div class="alert-notices mb-4"><ul><li class="alert alert-success successt-icon"><em class="icon ni ni-alert-fill"></em> Success</li></ul</div>';
						
						$("#msgbox").html(err);
						setTimeout(function(){
							window.location="login?m=registered";
						},2000);
                    }
                    else if(status === 'incomplete'){
					   	err = '<div class="alert-notices mb-4"><ul><li class="alert alert-danger alert-icon"><em class="icon ni ni-alert-fill"></em> All fields are required.</li></ul</div>';
						
						$("#msgbox").html(err);
				
					}
					else{
							err = '<div class="alert-notices mb-4"><ul><li class="alert alert-danger alert-icon"><em class="icon ni ni-alert-fill"></em> Error creating your account.</li></ul</div>';
						
						$("#msgbox").html(err);
						console.log(status);
						$("#registerBtn").text("Register");
						$("#registerBtn").attr("disabled", false);
					}
				}
			});
		 });
		 
		 

	//LOGIN FORM
	$("#emailverify_form").submit(function(e){
        e.preventDefault();
        
        var emailcode = $("#emailcode").val();
		
	
	

		 if(emailcode==""){   
		    alert("", "Please enter activation code");
			return false;
		}
	$("#emailverify_btn").text("Verifying...");
			$("#emailverify_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "auth.php",
				method: "post",
				data: $("#emailverify_form").serialize(),
                dataType: "text",
                cache: false,    
				success:function(status){
				var status = $.trim(status);
					if(status == 'verified'){
					$("#login_btn").text("Success");
					$("#login_btn").attr("class", "btn-success");
						alert("Email Verified!", "Success. You have verified your email address. Proceed to complete your profile setup!");
						   setTimeout(function(){
                        window.location="https://apexglobalcontracts.com/account";
                    },2000);
                    }
                 
                    else if(status == 'notmatch'){
					$("#emailverify_btn").text("Submit");
					$("#emailverify_btn").attr("disabled", false);
						alert("Verification Failed!", "You entered a wrong code. If you did not receive the activation code, click 'Resent Code'!");
                    }
                 else{
                     
                 }
				
                    
				}
			});

		});		 
		 
		 
		 
	$("#adminlogin_form").submit(function(e){
        e.preventDefault();
        
        var email = $("#adminemail_username").val();
		
		var password = $("#adminloginpass").val();
	

		 if(email==""){   
		    alert("", "Please enter your email or username");
			return false;
		}
		if (password =="") {
			alert("", "Please enter your password!");
			return false;
		}

			$("#adminlogin_btn").text("Please Wait...");
			$("#adminlogin_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "auth.php",
				method: "post",
				data: $("#adminlogin_form").serialize(),
                dataType: "text",
                cache: false,    
				success:function(status){
				var status = $.trim(status);
				console.log(status);
					if(status == 'not found'){
					$("#adminlogin_btn").text("Sign In");
					$("#adminlogin_btn").attr("disabled", false);
						alert("Login Failed!", "Email Address or Username is not correct!");
                    }
                 
                    else if(status == 'incorrect'){
					$("#adminlogin_btn").text("Sign In");
					$("#adminlogin_btn").attr("disabled", false);
						alert("Login Failed!", "Wrong Password!");
                    }
                 
					else if(status == 'success'){
                    $("#adminlogin_btn").text("Login Successful");
                    setTimeout(function(){
                        window.location="adminpanel";
                    },2000);
							
                    }
                    else{
                        alert("",status);
                    }
                    
				}
			});

		});		 
		 
		 

	//LOGIN FORM
	$("#login_form").submit(function(e){
        e.preventDefault();
        
        var email = $("#username").val();
		
		var password = $("#passcode").val();
	

		 if(email==""){   
			err = '<div class="alert-notices mb-4"><ul><li class="alert alert-danger alert-icon"><em class="icon ni ni-alert-fill"></em> Please enter your email</li></ul</div>';
						
						$("#msgbox").html(err);
		}
		if (password =="") {
			
				err = '<div class="alert-notices mb-4"><ul><li class="alert alert-danger alert-icon"><em class="icon ni ni-alert-fill"></em> Please enter your password</li></ul</div>';
						
						$("#msgbox").html(err);
			return false;
		}

			$("#login_btn").text("Please Wait...");
			$("#login_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "auth.php",
				method: "post",
				data: $("#login_form").serialize(),
                dataType: "text",
                cache: false,    
				success:function(status){
				var status = $.trim(status);
					$("#login_btn").text("Login");
					$("#login_btn").attr("disabled", false);
				console.log(status);
					if(status == 'not found'){
					$("#login_btn").text("Sign In");
					$("#login_btn").attr("disabled", false);
					
						err = '<div class="alert-notices mb-4"><ul><li class="alert alert-danger alert-icon"><em class="icon ni ni-alert-fill"></em> Incorrect email or passcode.</li></ul</div>';
						
						$("#msgbox").html(err);
                    }
                 
                    else if(status == 'incorrect'){
					$("#login_btn").text("Login");
					$("#login_btn").attr("disabled", false);
							err = '<div class="alert-notices mb-4"><ul><li class="alert alert-danger alert-icon"><em class="icon ni ni-alert-fill"></em> Incorrect email or passcode.</li></ul</div>';
						
						$("#msgbox").html(err);
                    }
                      else if(status == 'suspended'){
					$("#login_btn").text("Login");
					$("#login_btn").attr("disabled", false);
					//	alert("Login Failed!", "This account has been blocked. Please contact our support via email or live chat for assistance");
							err = '<div class="alert-notices mb-4"><ul><li class="alert alert-danger alert-icon"><em class="icon ni ni-alert-fill"></em> This account has been suspended. Please contact our support via email or live chat for assistance.</li></ul</div>';
						
						$("#msgbox").html(err);
                    }
                    else if(status == '2fa'){
					$("#login_btn").text("Login");
					$("#login_btn").attr("disabled", false);
					//	alert("OTP Authentication required!", "You'll receive an email with your login code.");
							err = '<div class="alert-notices mb-4"><ul><li class="alert alert-info alert-icon"><em class="icon ni ni-alert-fill"></em> You will receive an email with your login code</li></ul</div>';
						
						setTimeout(function(){
                        window.location="login2fa.html";
                    },2000);
                    }
                    
                    else if(status == 'unverified'){
				
					
						 setTimeout(function(){
                        window.location="confirm-email";
                    },1000);
                    }
                 
					else if(status == 'success'){
                    $("#login_btn").text("Login Successful");
                    setTimeout(function(){
                        window.location="account";
                    },2000);
							
                    }
                    else{
                        alert("",status);
                    }
                    
				}
			});

		});
		$("#login-2fa_form").submit(function(e){
        e.preventDefault();
        
    	$("#login-2fa_btn").text("Processing...");
			$("#login-2fa_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "auth.php",
				method: "post",
				data: $("#login-2fa_form").serialize(),
                dataType: "text",
                cache: false,    
				success:function(status){
				var status = $.trim(status);
				
                 if(status == 'mismatch'){
					$("#login-2fa_btn").text("Sign In");
					$("#login-2fa_btn").attr("disabled", false);
						alert("Login Failed!", "Wrong Authentication Code!");
                    }
             
					else if(status == 'success'){
                    $("#login-2fa_btn").text("Login Successful");
                    setTimeout(function(){
                        window.location="panel/";
                    },2000);
							
                    }
                    else{
                        
                    }
        
                    
				}
			});

		});
		
		$("#forgotpassword_form").submit(function(e){
		e.preventDefault();
			$("#forgotpassword_form_btn").text("Verifying...");
			$("#forgotpassword_form_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "../auth.php",
				method: "post",
				data: $("#forgotpassword_form").serialize(),
				dataType: "text",
				success:function(status){
				var status = $.trim(status);
					if(status == 'not found'){
					$("#forgotpassword_form_btn").text("Recover Password");
					$("#forgotpassword_form_btn").attr("disabled", false);
						alert("Failed, Account not found for this email or phone number");
					}
					else if(status == 'codesent'){
					$("#forgotpassword_form_btn").text("Reset Account");
					    alert("Successful, A password reset code has been sent to your email address. Check all your email folders if not in inbox");
						setTimeout(function(){
							window.location="resetpassword.php";
						},4000);
					}
				}
			});

		});
		
		$("#reset_form").submit(function(e){
		e.preventDefault();
			$("#reset_form_btn").text("saving...");
			$("#reset_form_btn").attr("disabled", true);
			//Form Submission via Ajax
			$.ajax({
				url: "../auth.php",
				method: "post",
				data: $("#reset_form").serialize(),
				dataType: "text",
				success:function(status){
				var status = $.trim(status);
					if(status == 'failed'){
					$("#reset_form_btn").text("Reset Password");
					$("#reset_form_btn").attr("disabled", false);
						alert("Failed!", "Wrong reset code or expired session. Try again");
							setTimeout(function(){
							window.location="reset.html";
						},3000);
					}
					else if(status == 'success'){
					$("#forgotpassword_form_btn").text("Reset Account");
					    alert("Successful!", "Your account password has been reset. You can sign in using the new password");
						setTimeout(function(){
							window.location="../login.html";
						},3000);
					}
				}
			});

		});
	
	    $.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
       return "";
    }
    return decodeURI(results[1]) || 0;
}
let m = $.urlParam('m');
if(m !=""){
alert('Information',m);
}     

});
