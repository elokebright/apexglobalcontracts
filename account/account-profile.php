<?php
require_once("head.php");
require_once("nav.html");
$kycstatus =($kyc ==1)?"<scan class='text-success'>Verified</scan>":"<scan class='text-warning'>Pending</scan>";
$kycstatus =($kyc ==2)?"<scan class='text-danger'>Declined</scan>":$kycstatus;
$profile_status = $kycstatus;


$profile_status_msg = ($kyc==1)?"Your ID document has been verified":"You profile is incomplete as you are yet to provide some 
relevant KYC information. Ensure to upload a profile photo and a 
government-issued ID card. If you have uploaded the documents, wait for our team to review and approve";


$profile_status_msg = ($kyc==2)?"Your KYC submission was rejected as it didn't meet our verification criteria. Kindly review and upload new documents ":$profile_status_msg;

?>
<div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">
				<h3 class="title1">Profile Information</h3>
	<div class="row">

<div class="col-md-12" style="margin-left:15px; padding 10px">
<div class="contacts">
	<div class="profile-icon ">
	<h4 class="page-content-title">Profile Status</h4>
																	<i class="fangle fa-5x"></i>
									
<h3 class="name-profile"><?=$profile_status?></h3>
									
									<p><?=$profile_status_msg?></p>



																</div>
							</div>
						</div>
	<div class="card col-md-6">
	    <br>
    <h4 class="id-btns idbtn1 text-center">Profile Photo</h4>
    <img src="<?=$profileimage?>" style="height:170px;width:150px;border:1px solid blue">
    	<button onclick="changeDp()"><span class="fa fa-camera" aria-hidden="true"></span>Upload Photo</button>
</div>
						</div>
						<div class="row">
    
  <div class="content col-md-6" style="margin-right:15px; padding: 10px">
  	<div style="padding: 10px;">
  	
  		
  		<style>
  			.id-btns{
  				background: #26be21;
  				width: 40%;
  				height: 30px;
  				border:0;
  				color:#fff;
  				text-transform: uppercase;
  			}

  			.gov-id2{
  				display: none;
  			}
  		</style>
  			<style type="text/css">
			.thumb-image{
 width:150px;
 height:170px; 
 padding:1px;

 margin: auto;
 border: 1px solid lightblue;
 border-radius: 7px;
}
<
		</style>
  	</div>

  	

 <div class="contacts ">
     <h3 class="id-btns idbtn1 text-center">ID FRONT</h3>
     <br>
<div class="text-xs-center">
	<div class="image-profile"><a href="<?=$idfrontimage?>"><img src="<?=$idfrontimage?>" alt="ID Card" style="height:170px; width:250px; margin:auto"></a></div>
	<h3 class="name-profile"><button type="button" class="btn btn-primary" onclick="uploadFrontId()">Upload/Replace</button></h3>

	</div>
<br><br>
<h3 class="id-btns idbtn1 text-center">ID BACK</h3>
<br>
	<div class="contacts">
<div class="text-xs-center">
	<div class="image-profile"><a href="<?=$idbackimage?>"><img src="<?=$idbackimage?>" alt="ID Card" style="height:170px; width:250px; margin:auto"></a></div>
	<h3 class="name-profile"><button type="button" class="btn btn-primary" onclick="uploadBackId()">Upload/Replace</button></h3>
	
	</div>

</div>
						



</div>

			</div>
		</div>	
		<script>

function loadPPreview() {
      
          //Get count of selected files
          var countFiles = $("#passportinput")[0].files.length;
          var imgPath = $("#passportinput")[0].value;
          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
          var image_holder = $("#passportPreview");
          image_holder.empty();
          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
              //loop for each file selected for uploaded.
              for (var i = 0; i < countFiles; i++) 
              {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image"
                  }).appendTo(image_holder);
                }
                image_holder.show();
                reader.readAsDataURL($("#passportinput")[0].files[i]);
              }
            } else {
              alert("This browser does not support FileReader.");
            }
          } else {
            alert("Pls select only images");
          }

}
 function uploadFrontId(){
        //$("#modal-changedp").modal();
        var htmlContent = document.createElement("div");
htmlContent.innerHTML = "<form method='POST' id='uploadidfrontform' enctype='multipart/form-data'><div id='passportPreview'></div><br><input id='passportinput' onchange='loadPPreview()' type='file' name='idfrontphoto' accept='image/x-png,image/jpeg'><input type='submit' name='uploadidfront' id='uploadidfrontbtn' style='display:none'></form>";
        swal({title:'UPLOAD ID FRONT VIEW',
    
    content:htmlContent,
    buttons: true,
  dangerMode: true
    
    }).then((ok) => {
  if (ok) {
  $('#uploadidfrontbtn').click(); 
    
  } else {
   window.location.assign(window.location.href);
    
  }
});
    }
    
 function uploadBackId(){
        //$("#modal-changedp").modal();
        var htmlContent = document.createElement("div");
htmlContent.innerHTML = "<form method='POST' id='uploadidbackform' enctype='multipart/form-data'><div id='passportPreview'></div><br><input id='passportinput' onchange='loadPPreview()' type='file' name='idbackphoto' accept='image/x-png,image/jpeg'><input type='submit' name='uploadidback' id='uploadidbackbtn' style='display:none'></form>";
        swal({title:'UPLOAD ID BACK VIEW',
    
    content:htmlContent,
    buttons: true,
  dangerMode: true
    
    }).then((ok) => {
  if (ok) {
  $('#uploadidbackbtn').click(); 
    
  } else {
   window.location.assign(window.location.href);
    
  }
});
    }    
    
      function changeDp(){
        //$("#modal-changedp").modal();
        var htmlContent = document.createElement("div");
htmlContent.innerHTML = "<form method='POST' id='uploadppform' enctype='multipart/form-data'><div id='passportPreview'></div><br><input id='passportinput' onchange='loadPPreview()' type='file' name='pp' accept='image/x-png,image/jpeg'><input type='submit' name='uploadpp' id='uploadppbtn' style='display:none'></form>";
        swal({title:'UPLOAD YOUR PICTURE',
    
    content:htmlContent,
    buttons: true,
  dangerMode: true
    
    }).then((ok) => {
  if (ok) {
  $('#uploadppbtn').click(); 
    
  } else {
     
   window.location.assign(window.location.href);
    
  }
});
    }
</script>
<?php
if(isset($_POST["uploadpp"])){
    $file_folder = "assets/userimages/";
    $selected_file = $_FILES["pp"]["name"];
    $file_extension = pathinfo($selected_file, PATHINFO_EXTENSION);
      $imageSize = getimagesize($_FILES["pp"]["tmp_name"]);
       if ($imageSize === false) {
            echo "The uploaded file is not a valid image.";
        } 
        else{
    $filetokeep =  $file_folder.$userid.".".$file_extension;
    $conn->query("UPDATE accounts SET profileimage = '$filetokeep' WHERE userid='$userid'");
    if(move_uploaded_file($_FILES["pp"]["tmp_name"],$filetokeep)){
    echo "<script>  alert('upload success'); window.location.assign('account-profile');</script>";
    }
    else{
        echo "error"; 
    }
        }
}

if(isset($_POST["uploadidfront"])){
    $file_folder = "assets/idfrontimages/";
    $selected_file = $_FILES["idfrontphoto"]["name"];
    $file_extension = pathinfo($selected_file, PATHINFO_EXTENSION);
      $imageSize = getimagesize($_FILES["idfrontphoto"]["tmp_name"]);
       if ($imageSize === false) {
            echo "The uploaded file is not a valid image.";
        } 
        else{
    $filetokeep =  $file_folder.$userid.".".$file_extension;
    $conn->query("UPDATE accounts SET idfront = '$filetokeep' WHERE userid='$userid'");
    if(move_uploaded_file($_FILES["idfrontphoto"]["tmp_name"],$filetokeep)){
     echo "<script>  alert('upload success'); window.location.assign('account-profile');</script>";
    }
    else{
        echo "error"; 
    }
        }
}

if(isset($_POST["uploadidback"])){
    $file_folder = "assets/idbackimages/";
    $selected_file = $_FILES["idbackphoto"]["name"];
    $file_extension = pathinfo($selected_file, PATHINFO_EXTENSION);
      $imageSize = getimagesize($_FILES["idbackphoto"]["tmp_name"]);
       if ($imageSize === false) {
            echo "The uploaded file is not a valid image.";
        } 
        else{
    $filetokeep =  $file_folder.$userid.".".$file_extension;
    $conn->query("UPDATE accounts SET idback = '$filetokeep' WHERE userid='$userid'");
    if(move_uploaded_file($_FILES["idbackphoto"]["tmp_name"],$filetokeep)){
    echo "<script>  alert('upload success'); window.location.assign('account-profile');</script>";
    }
    else{
        echo "error"; 
    }
        }
}
require_once("bottom.php");
?>	
	