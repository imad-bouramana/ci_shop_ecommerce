
 <p>
 	<a href="<?=base_url().'sliders/create/'.$parent_id; ?>">
	<button class="btn btn-default">Previous Page</button>
    </a>
    
      <!-- Button to trigger modal -->
		<a href="#myModal2" role="button" class="btn btn-info" data-toggle="modal">Create A Slide</a>
 
		<!-- Modal -->
		<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">Slide</h3>
		  </div>
		  <div class="modal-body">
		      <form class="form-horizontal" action="<?=$form_location ?>" method="post">
		     <p>
				  <div class="control-group">
				    <label class="control-label" for="inputcomments">Target Url :
				    	<span style="color: green">(optional)</span></label>
				    <div class="controls">
				       <input type="text" name="target_url" class="form-control" placeholder="Enter A Taget Url">
				   </div>
				    </div>
				
				  <div class="control-group">
				    <label class="control-label" for="inputcomments">Taxt Slide :<span style="color: green">(optional)</span></label>
				    <div class="controls">
				       <input type="text" name="img_text" class="form-control" placeholder="Enter A Text Slider">
				   </div>
				  </div>
				 
</p> 
		  </div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		    <button class="btn btn-primary" name="submit" type="submit"  value="Submit">Create</button>
		  </div>
		<?php 
	
        echo form_hidden('parent_id', $parent_id);
		?>
		  </form>
		</div>