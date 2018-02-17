<h1><?=$headline ?></h1>
<?php
if(isset($flash)){
	echo $flash;
}
echo validation_errors('<p style="color: red";>', '</p>'); 
$form_location = base_url().'homepages_offers/submit/'.$update_id; 
?>

<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white tag"></i><span class="break"></span>Home Page Offers</h2>
			<div class="box-icon">
				<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form class="form-horizontal" action="<?=$form_location ?>" method='POST'>
			  <fieldset>
			  	<div class="control-group">
				  <label class="control-label" for="typeahead"> Offers : </label>
				  <div class="controls">
					<input type="text" class="span6 typeahead" id="typeahead" name="item_id" placeholder="Add A Itel ID">
				  </div>
				</div>
				
				<div class="form-actions">
				  <button type="submit" class="btn btn-primary" name="submit" value="Submit">Save changes</button>
				  <button type="submit" name="submit" value="Finished" class="btn">Finished</button>
				</div>
			  </fieldset>

			</form>   
			

		</div>
	</div>

</div>
<?php if($num_rows>0){ ?>
<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white tag"></i><span class="break"></span>Home Page Offers</h2>
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
								  <th>Count</th>
								  <th> Home Page Offers </th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php 
						  	$count = 0;
						  	$this->load->module('store_items');
						  	foreach ($query->result() as $row) {
						  		$count++;
						  	$delete_url = base_url().'homepages_offers/delete/'.$row->id;
						  	$item_title = $this->store_items->_get_item_title($row->item_id);
						  		
						  	?>
							<tr>
								<td><?=$count ?></td>
								<td class="center">Item ID: <?=$row->item_id.' | '.$item_title  ?></td>
								
								<td class="center">
								
									<a class="btn btn-danger" href="<?=$delete_url ?>">
										<i class="halflings-icon white trash"></i>  
									</a>
									
								</td>
							</tr>
							<?php } ?>
							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
<?php } ?>
