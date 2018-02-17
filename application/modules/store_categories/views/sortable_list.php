<ul id="sortlist" class="sort">
	<?php 
  	$this->load->module('store_categories');
  	foreach ($query->result() as $row) {
  		$parent_url = base_url().'store_categories/manage/'.$row->id;
  		$count_cat_parent = $this->store_categories->_get_count_cat($row->id);
  		$edit_url = base_url().'store_categories/create/'.$row->id;
  		if($row->parent_cat_id==0){
            $parent_title = '<span class="mark"> Sub </span>';
  		}else{
  		    $parent_title = '<span class="mark"> Sub </span>'.$this->store_categories->_get_parent_title($row->parent_cat_id);
  	    }
  	?>
	<li id="<?= $row->id?>"><i class="icon-sort"></i><?=$row->cat_title ?>
		<?=$parent_title ?>
<?php 
	if($count_cat_parent == 1){
		$entity = 'Category';
	}else{
		$entity = 'Categories';
	}
	if($count_cat_parent <1){
		echo '-';
	}else{
		
		?>
		<a class="btn btn-success" href="<?=$parent_url ?>">
		    <i class="halflings-icon white eye-open"></i>  
		    <?=  $count_cat_parent.' '.$entity; ?>
	    </a>
	<?php
	}
	
	?>
		<a class="btn btn-info" href="<?=$edit_url ?>">
		<i class="halflings-icon white edit"></i>  
	</a>
	<?php } ?>
	</li>
</ul>