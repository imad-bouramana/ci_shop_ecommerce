	<h1><?= $headline?></h1>
	<?php echo validation_errors("<div style='color: red;margin: 10px 0'>","</div>"); ?>
	<?php 
	if(isset($flash)){
		echo $flash;
	} ?>
   
   <p class="invoice"><a href="<?= base_url() ?>invoice/test">
   	<button class="btn btn-success">View Invoice</button>
   </a></p>
	<?php
	echo Modules::run('paypal/_get_paypal_info', $paypal_id);
	?>
	<?php  if(is_numeric($update_id)): ?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Offers Detail : <?=$order_status ?></h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
	       if you want update order 


	       <?php $form_url = base_url().'store_orders/submit_update/'.$update_id;
			?>
			<form class="form-horizontal" action="<?php echo $form_url;?>" method="POST">
				<fieldset>
					<div class="control-group">
						<label class="control-label">Order Status Option: </label>
						<div class="controls">
							<?php    

							$id_select_form = 'id="selectError3"'; 
							
							echo form_dropdown('status_title', $options, $order_status,$id_select_form);

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
<?php endif; ?>
	
	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2><i class="halflings-icon white edit"></i><span class="break"></span>Order  Detail</h2>
				<div class="box-icon">

					<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
				</div>
			</div>
			 <div class="box-content">
			    <table class="table table-striped table-condensed table-bordered">
			    <a href="<?php echo base_url().'store_accounts/create/'.$shopper_id?>"><button class="btn btn-info">Visit Account</button>
			    </a>
			    	<tr>
			    		<td>First Name</td>
			    		<td><?= $acount_detail_data['firstname'] ?></td>
			    	</tr>
			    	<tr>
			    		<td>Last Name</td>
			    		<td><?= $acount_detail_data['lastname'] ?></td>
			    	</tr>
			    	<tr>
			    		<td>Company</td>
			    		<td><?= $acount_detail_data['company'] ?></td>
			    	</tr>
			    	<tr>
			    		<td>Custom Email</td>
			    		<td><?= $acount_detail_data['email'] ?></td>
			    	</tr>
			    	<tr>
			    		<td>Custom Telephone</td>
			    		<td><?= $acount_detail_data['telephone'] ?></td>
			    	</tr>
			    	<tr>
			    		<td>Custom Adress</td>
			    		<td><?= $custom_adress ?></td>
			    	</tr>
			    </table>
				
			


			</div> 
			</div><!--/span-->

	</div><!--/row-->
<?php
	$type_file = 'admin';
	echo Modules::run('cart/_draw_cart_item', $query_cc, $type_file);



