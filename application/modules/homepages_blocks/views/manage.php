<h2><?= $headline ?></h2>
<?php
if(isset($flash)){
	echo $flash;
}
?>
<p>
	<a href="<?= base_url()?>homepages_blocks/create"><button type="button" class="btn btn-primary">Create Homepage Offer</button>
	</a>
</p>
<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white tag"></i><span class="break"></span>Home page Offer Envatory</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php echo Modules::run('homepages_blocks/_draw_sortable_list') ?>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
