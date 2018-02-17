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
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Update Account Detail</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
		
        <a href="<?= base_url().'store_accounts/update_password/'.$update_id?>"><button class="btn btn-primary">Update Password</button></a>
        <a href="<?= base_url().'store_accounts/deleteconf/'.$update_id?>"><button class="btn btn-danger">Delete Account</button></a>



		</div>
	</div><!--/span-->

</div><!--/row-->
<?php endif; ?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Accounts Detail</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php $form_url = base_url().'store_accounts/create/'.$update_id;
			?>
			<form class="form-horizontal" action="<?php echo $form_url;?>" method="POST">
				<fieldset>
					<div class="control-group">
						<label class="control-label">USERNAME : </label>
						<div class="controls">
							<input type="text" class="span6" name="username" value="<?php echo $username;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">FIRSTNAME : </label>
						<div class="controls">
							<input type="text" class="span6" name="firstname" value="<?php echo $firstname;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">LASTNAME : </label>
						<div class="controls">
							<input type="text" class="span6" name="lastname" value="<?php echo $lastname; ?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">COMPANY : </label>
						<div class="controls">
							<input type="text" class="span6" name="company" value="<?php echo $company;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Email : </label>
						<div class="controls">
							<input type="email" class="span6" name="email" value="<?php echo $email;?>"  />
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">ADRESS1 : </label>
						<div class="controls">
							<input type="text" class="span6" name="adress1" value="<?php echo $adress1;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">ADRESS2 : </label>
						<div class="controls">
							<input type="text" class="span6" name="adress2" value="<?php echo $adress2;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">TOWN : </label>
						<div class="controls">
							<input type="text" class="span6" name="town" value="<?php echo $town;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Country : </label>
						<div class="controls">
							<input type="text" class="span6" name="country" value="<?php echo $country;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">POST CODE : </label>
						<div class="controls">
							<input type="text" class="span6" name="postecode" value="<?php echo $postecode;?>"  />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">TETEPHONE : </label>
						<div class="controls">
							<input type="text" class="span6" name="telephone" value="<?php echo $telephone;?>"  />
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
