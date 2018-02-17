<h1><?= $headline?></h1>
<?php echo validation_errors("<div style='color: red;margin: 10px 0'>","</div>"); ?>
<?php 
if(isset($flash)){
	echo $flash;
} 

						  	$this->load->module('datemade');
						  	$this->load->module('store_accounts');

						  	foreach ($query->result() as $row) {
						  		
						  		$date_created = $this->datemade->get_nice_date($row->date_created, 'full');
						  		
						  		$sent_by = $this->store_accounts->_get_customer_name($row->sent_by);
						  		$message = $row->message;
                                $subject = $row->subject;
                                $ranking = $row->ranking;
						  		
						  	}
?>
<p>
	<a href="<?= base_url()?>enquiries/create/<?= $update_id?>"><button type="button" class="btn btn-primary">Reply To This Message</button>
	</a>
	<!-- Button trigger modal -->
<button type="button" data-toggle="modal" class="btn btn-info" data-target="#myModal">Create New Comment</button>

<!-- Button to trigger modal -->

 
<!-- Modal -->
<div  class="modal  hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Create Comment</h3>
  </div>
  <form class="form-horizontal" action="<?php echo base_url().'comments/submit/'.$update_id; ?>" method="POST">
  <div class="modal-body">
    <p>
    	<div class="control-group hidden-phone">
			<label class="control-label" for="textarea2">Comment :</label>
			<div class="controls">
				<textarea   id="textarea2" rows="7" name="comment"></textarea>
			</div>
		</div>
		<?php  
		echo form_hidden('comments_type','e');
		echo form_hidden('update_id',$update_id);

		?>
    	
    </p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</form>
</div>
</p>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white star"></i><span class="break"></span>Ranking Detail</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php $form_url = base_url().'enquiries/submit_ranking/'.$update_id;
			?>
			<form class="form-horizontal" action="<?php echo $form_url;?>" method="POST">
				<fieldset>
				
					<div class="control-group">
						<label class="control-label">Rankings : </label>
						<div class="controls">
						<?php    

							$id_select_form = 'id="selectError3"';
                            if($ranking>0){
                           	   unset($options['']);
                            }
							echo form_dropdown('ranking', $options, $ranking,$id_select_form);
                     
						?>
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

<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white envelope"></i><span class="break"></span>Message Details</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						 <tbody>

							
							<tr>
								<td class="enquires">Sent By :</td><td><?=$sent_by ?></td>
							</tr>
							<tr>
								<td class="enquires">Date Sent :</td><td><?=$date_created ?></td>
							</tr>
							<tr>
								<td class="enquires">Subject :</td><td><?=$subject ?></td>
							</tr>
								
							<tr>
								<td class="enquires">Message :</td><td><pre><?=$message ?></pre><td>
							</tr>
						
							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
<?php 
echo Modules::run('comments/_draw_comment', 'e',$update_id);