<h1>Manage bottom navigation</h1>
<?php 
if(isset($flash)){
	echo $flash;
} 
?>
<?php 
$items_account_url = base_url().'btm_nav/create';
echo Modules::run("btm_nav/_draw_modal"); 
?>

<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Bottom Navigation</h2>
			<div class="box-icon">
				<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			
			
			
			<?php 
			echo Modules::run('btm_nav/_manage_home_blokcs'); ?>
			
		</div>
	</div><!--/span-->
	
</div><!--/row-->


