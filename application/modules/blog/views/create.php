<h1><?= $headline?></h1>
<?php echo validation_errors("<div style='color: red;margin: 10px 0'>","</div>"); ?>
<?php 
if(isset($flash)){
	echo $flash;
} 
?>


<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Blog Entry Detail</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php $form_url = base_url().'blog/create/'.$update_id;
			?>
			<form class="form-horizontal" action="<?php echo $form_url;?>" method="POST">
				<fieldset>
					<div class="control-group">
						<label class="control-label">Date Blog Entry  : </label>
						<div class="controls">
							<input type="text" class="input-xlarge datepicker" id="date01" name="date_created" value="<?php echo $date_created;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Author : </label>
						<div class="controls">
							<input type="text" class="span6" name="author" value="<?php echo $author;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Blog Entry Title : </label>
						<div class="controls">
							<input type="text" class="span6" name="blog_title" value="<?php echo $blog_title;?>"  />
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Blog Entry Keyword : </label>
						<div class="controls">
							<textarea   id="textarea2" rows="2" name="blog_keyword"><?php echo $blog_keyword; ?></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Blog Entry Description : </label>
						<div class="controls">
							<textarea   id="textarea2" rows="2" name="blog_description"><?php echo $blog_description; ?></textarea>
						</div>
					</div>

					

					<div class="control-group hidden-phone">
						<label class="control-label" for="textarea2">Blog Entry Centent :</label>
						<div class="controls">
							<textarea class="cleditor"  id="textarea2" rows="3" name="blog_content"><?php echo $blog_content; ?></textarea>
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
<?php 
$picture = (isset($picture)?$picture: '');
if($picture!=''):?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Blog Image</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			
         <img src="<?= base_url().'assets/img/picture/'.$picture?>">
		</div>
	</div><!--/span-->

</div><!--/row-->
<?php endif; ?>
