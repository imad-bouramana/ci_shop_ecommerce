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
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Message Detail</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php $form_url = base_url().'enquiries/create/'.$update_id;
			?>
			<form class="form-horizontal" action="<?php echo $form_url;?>" method="POST">
				<fieldset>
					<?php 
					if(!isset($sent_to)){
					?>
					<div class="control-group">
						<label class="control-label">Customer Name : </label>
						<div class="controls">
						<?php    

							$id_select_form = 'id="selectError3"';

							echo form_dropdown('sent_to', $options, $sent_to,$id_select_form);

							?>
						</div>
					</div>
					<?php } ?>
					<div class="control-group">
						<label class="control-label">Subject : </label>
						<div class="controls">
							<input type="text" class="span6" name="subject" value="<?php echo $subject?>"  />
						</div>
					</div>
				
					
					<div class="control-group">
						<label class="control-label">Message : </label>
						<div class="controls">
							<textarea class="cleditor"   id="textarea2"  name="message"><?php echo $message; ?></textarea>
						</div>
					</div>

					
					<div class="form-actions">
						<button type="submit" class="btn btn-primary" name="submit" value="Submit">Save changes</button>
						<button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
					</div>
					<?php 
					if(isset($sent_to)){
						echo form_hidden('sent_to',$sent_by);
					}
					?>
				</fieldset>
			</form>   

		</div>
	</div><!--/span-->

</div><!--/row-->