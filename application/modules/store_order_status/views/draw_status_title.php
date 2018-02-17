<li>
	<a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Manage Order </span></a>
	<ul>
		<?php
      
      $status_url = base_url().'store_orders/browse/status0'; ?>

	  <li><a class="submenu" href="<?= $status_url?>"><i class="icon-file-alt"></i><span class="hidden-tablet">
	    submited order</span></a>
	   </li>
		<?php 
		foreach ($query_status->result() as $row) {
			$edit_url = base_url().'store_orders/browse/status'.$row->id;
			echo '<li><a class="submenu" href="'.$edit_url.'">';
			echo '<i class="icon-file-alt"></i><span class="hidden-tablet">';
			echo ' '.$row->status_title.'</span></a></li>';
		}
		?>
	
	</ul>	
</li>