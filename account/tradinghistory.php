<?php
  require_once("head.php");
require_once("nav.html");
  ?>
<div id="page-wrapper" style="min-height: 556px;">
			<div class="main-page signup-page">
					
					<h3 class="title1">Your transaction (ROI) history</h3>
					
							
										<div class="row">
						<div class="col text-center card shadow-lg bg-dark p-3">
							<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
								<div id="UserTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
								    
								  <div class="row"><div class="col-sm-12"><table id="UserTable" class="UserTable table table-hover text-light dataTable no-footer" role="grid" aria-describedby="UserTable_info"> 
									<thead> 
										<tr role="row"><th class="sorting_desc" tabindex="0" aria-controls="UserTable" rowspan="1" colspan="1" style="width: 139.816px;" aria-sort="descending" aria-label="ID: activate to sort column ascending">Sn </th><th class="sorting" tabindex="0" aria-controls="UserTable" rowspan="1" colspan="1" style="width: 185.993px;" aria-label="Plan: activate to sort column ascending">Profit</th><th class="sorting" tabindex="0" aria-controls="UserTable" rowspan="1" colspan="1" style="width: 255.134px;" aria-label="Amount: activate to sort column ascending">Reference </th><th class="sorting" tabindex="0" aria-controls="UserTable" rowspan="1" colspan="1" style="width: 192.118px;" aria-label="Type: activate to sort column ascending">Date</th><th class="sorting" tabindex="0" aria-controls="UserTable" rowspan="1" colspan="1" style="width: 347.586px;" aria-label="Date created: activate to sort column ascending">#</th></tr> 
									</thead> 
									<tbody> 
									   <?php
    $get = $conn->query("SELECT * FROM earnings WHERE user='$userid'");
    if($get->num_rows >0){
        $total =0;
        $sn=1;
        while($d = $get->fetch_assoc()){
            
            $amt = $d["amount"];
            $total+=$amt;
            $rf = $d["ref"];
            $pl = $conn->query("SELECT * FROM investments WHERE sn='$rf'");
            $plandata = $pl->fetch_assoc();
    $pname = $plandata["plan"];
 
            
            $dd = date("Y-m-d H:i",strtotime($d["time_recorded"]));
     
            
            echo "<tr><td>$sn</td>
            <td>$$amt</td>
           
            <td>Earning from $pname.</td>
             <td>$dd</td>
            </tr>";
            $sn++;
            
        }
        
    }
    
    else{
        echo '<tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No data available in table</td></tr></tbody> ';
        
    }    
?>
									
									
									
										
								</table></div></div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	
			
			
	
			
		


	

		

			

			
			
	
		
            <?php
            require_once("bottom.php");
            ?>