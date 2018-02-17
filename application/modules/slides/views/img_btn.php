<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Slide Detail</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>

		<div class="box-content">
		 <p><?= $btn_info ?></p>
		 <?php if($got_pic == FALSE) { ?>
			<a href="<?php echo base_url().'slides/upload_image/'.$update_id?>">
				<button class="btn btn-primary">Upload Slide Image</button>
			</a>
		<?php }else{ 
		echo '<img src="'.$pic_path.'" alt="" >';
		 } ?>
		  <a href="<?php echo base_url().'slides/deleteconf/'.$update_id?>" >
		  	<button class="btn btn-danger" <?=$btn_style ?>>Delete Slide Image</button>
		  </a>
			
		</div>
	</div><!--/span-->

</div><!--/row-->