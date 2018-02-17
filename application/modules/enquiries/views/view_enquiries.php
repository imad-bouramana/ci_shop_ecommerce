<h2><?= $headline.$folder_type ?></h2>
<?php
if(isset($flash)){
	echo $flash;
}
?>
<p>
	<a href="<?= base_url()?>enquiries/create"><button type="button" class="btn btn-primary">Compose Message</button>
	</a>
</p>

<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white envelope"></i><span class="break"></span><?=$folder_type ?></h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
							  	  <th>&nbsp;</th>
							  	   <th>Ranking</th>
								  <th>Subject</th>
								  <th>Sent BY</th>
								  <th>Sent To</th>
								  <th>DATE Sent</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php 
						  	$this->load->module('datemade');
						  	$this->load->module('store_accounts');

						  	foreach ($query->result() as $row) {
						  		$opened = $row->opened;
						  		$urgent = $row->urgent;

						  		$date_created = $this->datemade->get_nice_date($row->date_created, 'full');
						  		if($opened==1){
						  			$icon = '<i><span class="icon icon-envelope"></span></i>';
						  		}else{
						  			$icon = '<i><span class="icon icon-envelope-alt" style="color:orange"></span></i>';
						  		}
						  		$sent_by = $this->store_accounts->_get_customer_name($row->sent_by);
						  		$sent_to = $row->sent_to;
						  		$ranking = $row->ranking;

						  		if($sent_to==0){
						  			$sent_to = 'admin';
						  		}
						  		$view_url = base_url().'enquiries/view/'.$row->id;
						  	?>
							<tr <?php 
							if($urgent==1){
								echo "class='urgent'";
							} ?>>
								<td><?=$icon ?></td>
								<td><?php
								if($ranking<1){
									echo '-';
								}else{
									for ($i=0; $i < $ranking; $i++) { 
										echo '<i><span class="icon icon-star"></span></i>';
									}
								}
								?></td>
								<td><?=$row->subject ?></td>
								<td><?=$sent_by ?></td>
								<td class="center"><?=$sent_to ?></td>
								<td class="center">
									<?=$date_created ?>
								</td>
								<td class="center">
									<a class="btn btn-info" href="<?=$view_url ?>">
										<i class="halflings-icon white edit"></i>  
									</a>
									
								</td>
							</tr>
							<?php } ?>
							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
