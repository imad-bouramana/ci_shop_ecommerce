<ol class="breadcrumb">
	<?php 
	foreach ($breadcrumbs_array as $key => $value) {
		echo '<li><a href="'.$key.'">'.$value.'</a></li>';
	}
	?>
  
  <li class="active"><?=$target_url ?></li>
</ol>