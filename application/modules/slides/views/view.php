<h1><?=$headline ?></h1>
<?php
if(isset($flash)){
  echo $flash;
} 
?>
<a href="<?=base_url().'slides/update_group/'.$parent_id; ?>">
	<button class="btn btn-default">Previous Page</button>
</a>
<div style="margin-top: 12px">
<?php
echo Modules::run("slides/_draw_img_btn", $update_id); 

?>
</div>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Slides Detail</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php $form_url = base_url().'slides/submit/'.$update_id;
			?>
			<form class="form-horizontal" action="<?php echo $form_url;?>" method="POST">
				<fieldset>
					<div class="control-group">
						<label class="control-label">Target Url <span style="color: #7bca73">(optional)</span> : </label>
						<div class="controls">
							<input type="text" class="span6" name="target_url" value="<?php echo $target_url;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Alt-text <span style="color: #7bca73">(optional)</span> : </label>
						<div class="controls">
							<input type="text" class="span6" name="img_text" value="<?php echo $img_text; ?>"  />
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