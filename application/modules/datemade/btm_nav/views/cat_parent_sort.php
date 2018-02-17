   <ul id="sortlist">
   	<?php 
   	
   	foreach($query->result() as $row): 
   		$homepage_title = $row->page_title;

         $items_delete_url = base_url().'btm_nav/delete/'.$row->id; 
   	?>
   	

   	<li class="sort" id="<?= $row->id?>"> <i class="icon-sort"></i>
         <b>Page Url : </b><?= $row->page_url; ?>
         |
   		<b>Page Title : </b><?= $row->page_title;   ?>
         <?php  if(!in_array($row->id, $special_page)){ ?>

   			<a class="btn btn-danger" href="<?=$items_delete_url ?>">
   				<i class="halflings-icon white trash"></i>  
   			</a>
      	<?php  } ?>
   		</li>



   	<?php endforeach; ?>
   </ul>