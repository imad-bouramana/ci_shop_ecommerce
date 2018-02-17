
 <p>
 	
    
      <!-- Button to trigger modal -->
		<a href="#myModal2" role="button" class="btn btn-info" data-toggle="modal">Create A Bottom Navigation</a>
 
		<!-- Modal -->
		<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">Navigation </h3>
		  </div>
		  <div class="modal-body">
		      <form class="form-horizontal" action="<?=$form_location ?>" method="post">
		     <p>
				  <div class="control-group">
				    <label class="control-label" for="inputcomments">Page Url :</label>
				      <div class="controls">
						<?php    

							$id_select_form = 'id="selectError3"'; 
							

							echo form_dropdown('page_id', $options, '',$id_select_form);

							?>

						</div>
				   </div>
				
				 
				 
          </p> 
		  </div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		    <button class="btn btn-primary" name="submit" type="submit"  value="Submit">Create</button>
		  </div>
		</form>
</div>