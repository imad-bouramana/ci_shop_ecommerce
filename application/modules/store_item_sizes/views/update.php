<h1><?=$headline ?></h1>
<?php
if(isset($flash)){
	echo $flash;
}
echo validation_errors('<p style="color: red";>', '</p>'); 
$form_location = base_url().'store_item_sizes/submit/'.$update_id; 
?>

<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white tag"></i><span class="break"></span>Sizes Options</h2>
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
				  <label class="control-label" for="typeahead">Item Size : </label>
				  <div class="controls">
					<input type="text" class="span6 typeahead" id="typeahead" name="Size" >
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
						<h2><i class="halflings-icon white tag"></i><span class="break"></span>Item Sizes</h2>
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
								  <th>Item Color</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php 
						  	$count = 0;
						  	foreach ($query->result() as $row) {
						  		$count++;
						  	$delete_url = base_url().'store_item_sizes/delete/'.$row->id;
						  	
						  		
						  	?>
							<tr>
								<td><?=$count ?></td>
								<td class="center"><?=$row->size ?></td>
								
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
