<h1><?=$headline ?></h1>
<?php
if(isset($flash)){
	echo $flash;
}
echo validation_errors('<p style="color: red";>', '</p>'); 
$form_location = base_url().'store_cat_assign/submit/'.$item_id; 
?>

<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white tag"></i><span class="break"></span>Category Assign Options</h2>
			<div class="box-icon">
				<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form class="form-horizontal" action="<?=$form_location ?>" method='POST'>
			  <fieldset>
			  	<p>Choose An Category And Hit Submit ..</p>
			  	<div class="control-group">
				  <label class="control-label" for="typeahead">Item Category : </label>
				  <div class="controls">
					<?php    

							$id_select_form = 'id="selectError3"';

							echo form_dropdown('cat_id', $options, $cat_id,$id_select_form);

							?>
				  </div>
				</div>
				
				<div class="form-actions">
				  <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
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
						<h2><i class="halflings-icon white tag"></i><span class="break"></span>Assing Category</h2>
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
								  <th>Category</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php 
						  	$count = 0;
						  	$this->load->module('store_categories');
						  	foreach ($query->result() as $row) {
						  		$count++;
						  	$delete_url = base_url().'store_cat_assign/delete/'.$row->id;
						  	$sub_cat = $this->store_categories->_get_parent_title($row->cat_id);
						  	$cat_parent = $this->store_categories->_get_parent_cat_title($row->cat_id);

						  	
						  		
						  	?>
							<tr>
								<td><?=$count ?></td>
								<td class="center"><?=$cat_parent.' > '.$sub_cat; ?></td>
								
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

