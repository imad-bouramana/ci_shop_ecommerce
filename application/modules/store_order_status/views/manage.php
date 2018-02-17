<h2><?= $headline ?></h2>
<?php
if(isset($flash)){
	echo $flash;
}
?>
<p>
	<a href="<?= base_url()?>store_order_status/create"><button type="button" class="btn btn-primary">Create Order Statuss</button>
	</a>
</p>
<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white list-alt"></i><span class="break"></span>Customer Order Statuss</h2>
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
								  <th>Status Title</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php 
						  	$this->load->module('datemade');
						  	foreach ($query->result() as $row) {
						  		$edit_url = base_url().'store_order_status/create/'.$row->id;
						  		
						  		
						  	?>
							<tr>
							
								<td class="center"><?=$row->status_title ?></td>
								
								<td class="center">
									<a class="btn btn-info" href="<?=$edit_url ?>">
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
