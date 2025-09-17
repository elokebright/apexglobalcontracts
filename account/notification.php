<?php
require_once("head.php");
require_once("nav.html");
?>
<div id="page-wrapper" style="min-height: 594px;">
			<div class="main-page signup-page">
				<h3 class="title1">Your Message Notifications </h3>

				
				<h3 class="title1"></h3>
				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table class="table table-hover"> 
									<thead> 
										<tr> 
											<th>Message</th>
										
											<th>&nbsp;</th>
										</tr> 
									</thead> 
									<tbody> 
									
    <?php
    
    $getmessages = $conn->query("SELECT * FROM notifications WHERE user='$useremail'   ORDER BY status ASC");
    while($msg = $getmessages->fetch_assoc()){
        $noticetitle = $msg["title"];
        $noticedate = $msg["datereceived"];
        $noticebody = $msg["message"];
        $noticesn=$msg["sn"];
        $read = $msg["status"];
        $label =($read == 0)?"<i class='text-success' style='font-size:80%'>new</i><br>":"";
        $noticestatus = $msg["status"];
        $firstsentence = explode(".",$noticebody)[0];
         $excerpt = substr($noticebody,0,50);
        $read = ($noticestatus ==0)?'unread': '';
        
        
        
        echo "
        <tr style='margin-bottom:25px'>
        <td>$label <b>$noticetitle</b><br><small>$noticebody</small></td>
        <!--<td>$noticedate</td>-->
        <td><a href='notice_detail?n=$noticesn' class='email-user bg-blue'>
<span class='text-primary'></span>
</a></td>
        </tr>
        
        
        ";
        
    }
    
    
    ?>
									
																			</tbody> 
								</table>
				</div>
			</div>
		</div>
		
		<?php
require_once("bottom.php");
?>