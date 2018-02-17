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
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Offers Detail</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
	       <a href="<?php echo base_url().'homepage_offers/update/'.$update_id?>"><button class="btn btn-primary">Update Offers Blocks</button></a>
		   <a href="<?php echo base_url().'btm_nav/deleteconf/'.$update_id?>"><button class="btn btn-danger">Delete Entire Offers Blocks</button></a>
		   <a href="<?php echo base_url().'btm_nav/manage'?>"><button class="btn btn-default">Previous Page</button></a>



		</div>
	</div><!--/span-->

</div><!--/row-->
<?php endif; ?>
	
	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2><i class="halflings-icon white edit"></i><span class="break"></span>Homepage Offers Detail</h2>
				<div class="box-icon">

					<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
				</div>
			</div>
			 <div class="box-content">
				<?php $form_url = base_url().'btm_nav/create/'.$update_id;
				?>
				<form class="form-horizontal" action="<?php echo $form_url;?>" method="POST">
				 	<fieldset>
				 	
				 		<div class="control-group"> <label class="control-label"> blocks offers Name: </label>
				 		 <div class="controls">
				 		    <input type="text" class="span6" name="blocks_title" value="<?php echo $blocks_title;?>"  /> 
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
