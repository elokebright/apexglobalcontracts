<?php
require_once("nav.html");
?>
<div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">

				
                
				<div class="sign-up-row widget-shadow">
					<form method="post" action="https://apexglobalcontracts.com/account/updatepass">
					<h5>Change Password :</h5>
					
					<div class="sign-u">
						<div class="sign-up1">
							<h4>Old Password* :</h4>
						</div>
						<div class="sign-up2">
							<input type="password" name="old_password" required="">
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="sign-u">
						<div class="sign-up1">
							<h4>New Password* :</h4>
						</div>
						<div class="sign-up2">
							<input type="password" name="password" required="">
						</div>
						<div class="clearfix"> </div>
					</div>
					
					<div class="sign-u">
						<div class="sign-up1">
							<h4>Confirm* :</h4>
						</div>
						<div class="sign-up2">
							<input type="password" name="password_confirmation" required="">
						</div>
						<div class="clearfix"> </div>
					</div>
					
					<div class="sub_home">
						<input type="submit" value="Submit">
						<div class="clearfix"> </div>
					</div>
					<input type="hidden" name="id" value="3560">
                    <input type="hidden" name="current_password" value="$2y$10$P2Rlc1TbbL5yXEL17pQ6sO83tFl.jjuaJNpzb8UpIFj60mAJXtDrW">
					<input type="hidden" name="_token" value="dD3HpVqkfyGXu16xJn73rGTTfwBKH7zgiIu9acPA"><br>
				</form>
				</div>
			</div>
		</div>
		
		<?php
require_once("footer.html");
?>