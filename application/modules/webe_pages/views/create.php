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
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Page Detail</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
	
       <?php  
       if($update_id >2){ ?>
		<a href="<?php echo base_url().'webe_pages/deleteconf/'.$update_id?>"><button class="btn btn-danger">Delete Page</button></a>
		<?php } ?> 
		<a href="<?php echo base_url().$page_url?>"><button class="btn btn-default">View Page</button></a>



		</div>
	</div><!--/span-->

</div><!--/row-->
<?php endif; ?>

<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Page Detail</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php $form_url = base_url().'webe_pages/create/'.$update_id;
			?>
			<form class="form-horizontal" action="<?php echo $form_url;?>" method="POST">
				<fieldset>
					<div class="control-group">
						<label class="control-label">Page Title : </label>
						<div class="controls">
							<input type="text" class="span6" name="page_title" value="<?php echo $page_title;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Page Headline : </label>
						<div class="controls">
							<input type="text" class="span6" name="page_headline" value="<?php echo $page_headline;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Page Keyword : </label>
						<div class="controls">
							<textarea   id="textarea2" rows="6" name="page_keyword"><?php echo $page_keyword; ?></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Page Description : </label>
						<div class="controls">
							<textarea   id="textarea2" rows="6" name="page_description"><?php echo $page_description; ?></textarea>
						</div>
					</div>

					

					<div class="control-group hidden-phone">
						<label class="control-label" for="textarea2">Page Centent :</label>
						<div class="controls">
							<textarea class="cleditor"  id="textarea2" rows="3" name="page_content"><?php echo $page_content; ?></textarea>
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
