	<h1><?= $headline?></h1>
	<?php echo validation_errors("<div style='color: red;margin: 10px 0'>","</div>"); ?>
	<?php 
	if(isset($flash)){
		echo $flash;
	} 
	?>
	<?php  if(is_numeric($update_id)): ?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Sliders</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
	       <a href="<?= base_url() ?>slides/update_group/<?=$update_id?>"><button class="btn btn-primary">Update Sliders</button></a>
		   <a href="<?php echo base_url().'sliders/deleteconf/'.$update_id?>"><button class="btn btn-danger">Delete Entire Sliders</button></a>
		   <a href="<?php echo base_url().'sliders/manage'?>"><button class="btn btn-default">Previous Page</button></a>



		</div>
	</div><!--/span-->

</div><!--/row-->
<?php endif; ?>
	
	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2><i class="halflings-icon white edit"></i><span class="break"></span>Homepage Sliders</h2>
				<div class="box-icon">

					<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
				</div>
			</div>
			 <div class="box-content">
				<?php $form_url = base_url().'sliders/create/'.$update_id;
				?>
				<form class="form-horizontal" action="<?php echo $form_url;?>" method="POST">
				 	<fieldset>
				 	
				 		<div class="control-group"> <label class="control-label"> slide Name: </label>
				 		 <div class="controls">
				 		    <input type="text" class="span6" name="slider_title" value="<?php echo $slider_title;?>"  /> 
				 		</div> 
				 		</div>

				 			<div class="control-group"> <label class="control-label"> Target Url: </label>
				 		 <div class="controls">
				 		    <input type="text" class="span6" name="target_url" value="<?php echo $target_url;?>"  /> 
				 		</div> 
				 		</div>
				 
				 
				 
				 		<div class="form-actions">
				 			<button type="submit" class="btn btn-primary" name="submit" value="Submit">Save changes</button>
				 			<button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
				 		</div>
				 	</fieldset>
				 </form>
			
			</div> 
		</div><!--/span-->

	</div><!--/row-->
