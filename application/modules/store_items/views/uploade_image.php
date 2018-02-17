<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white picture"></i><span class="break"></span>Upload Image</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
<?php 
if(isset($error)){
  foreach ($error as  $value) {
  	echo $value;
  }
 }?>


<?php 
$atrribute  = array('class' => 'form-horizontal');
echo form_open_multipart('store_items/do_upload/'.$update_id, $atrribute);?>
<p>Please Choose A Image And Press Save Change .</p>

   <div class="control-group">
	  <label class="control-label" for="fileInput">File input</label>
	  <div class="controls">
		<input class="input-file uniform_on" id="fileInput"  name="userfile" type="file">
	  </div>
	</div>          
	
	<div class="form-actions">
	  <button type="submit" class="btn btn-primary" name="submit" value="Submit">Save changes</button>
	  <button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
	</div>
  
</form>   

</div>
</div>
</div>


