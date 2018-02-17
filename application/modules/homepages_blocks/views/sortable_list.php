<ul class="sort" id="sortlist">
	<?php 
  	$this->load->module('homepages_blocks');
  	foreach ($query->result() as $row) {
  	
  		$edit_url = base_url().'homepages_blocks/create/'.$row->id;
  		
  	?>
	<li id="<?= $row->id?>"><i class="icon-sort"></i><?=$row->block_title ?>
	

		<a class="btn btn-success" href="<?=base_url() ?>">
		    <i class="halflings-icon white eye-open"></i>  
		    
	    </a>
	
		<a class="btn btn-info" href="<?=$edit_url ?>">
		<i class="halflings-icon white edit"></i>  
	</a>
	<?php
	}
	
	?>
	
	</li>
</ul>