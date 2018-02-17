<h2><?= $folder_type ?></h2>
<?php
if(isset($flash)){
	echo $flash;
}
?>
<p>
	<a href="<?= base_url()?>yourmessage/create"><button type="button" class="btn btn-primary">Compose Message</button>
	</a>
</p>

					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
							  	  <th>&nbsp;</th>
							  	 
							  	  <th>Date Sent</th>
							  	  <th>Sent BY</th>
								  <th>Subject</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php 
						  	$this->load->module('datemade');
						  	$this->load->module('site_sittings');

						  	$this->load->module('store_accounts');

						  	foreach ($query->result() as $row) {
						  		$opened = $row->opened;
			

						  		$date_created = $this->datemade->get_nice_date($row->date_created, 'mini');
						  		if($opened==1){
						  			$icon = '<i><span class="icon icon-envelope"></span></i>';
						  		}else{
						  			$icon = '<i><span class="icon icon-envelope-alt" style="color:orange"></span></i>';
						  		}
						  		$sent_by = $this->store_accounts->_get_customer_name($row->sent_by);
						  		$sent_to = $row->sent_to;
						  		


						  		if($sent_by==0){
						  			$sent_to = $this->site_sittings->_get_customer_support();
						  		}
						  		$view_url = base_url().'yourmessage/view/'.$row->code;
						  	?>
							<tr>
								<td><?=$icon ?></td>
								
								<td class="center">
									<?=$date_created ?>
								</td>
								<td><?=$sent_by ?></td>
								<td><?=$row->subject ?></td>
								<td class="center">
									<a class="btn btn-info" href="<?=$view_url ?>">
										<i><span class="icon icon-eye-open"></span></i> view  
									</a>
									
								</td>
							</tr>
							<?php } ?>
							
						  </tbody>
					  </table>            
					</div>
			