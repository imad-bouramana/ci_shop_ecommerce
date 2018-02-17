<?php 
$count = 1;
  foreach ($parent_title as $key => $value) {
    $parent_cat_id = $key;
    $cat_title = $value;
  
?>

  

<li>
  <a class="color<?=$count ?>" href=""><?=$cat_title ?></a>

<div class="megapanel">
          <div class="row">
           
 
        <?php 
        $this->load->module('store_categories');
        $query = $this->store_categories->get_where_custom('parent_cat_id', $parent_cat_id);
        foreach ($query->result() as $row) {
          $cat_url = $row->cat_url;
          ?>

       <div class="col1">
              <div class="h_nav">
                
                <h4><a href="<?=$start_url.$cat_url ?>"><?= $row->cat_title ?></a></h4>
               
              </div>              
            </div>
          <?php
         }
         ?>
      
   
  </li>

<?php 
$count++; } ?>

