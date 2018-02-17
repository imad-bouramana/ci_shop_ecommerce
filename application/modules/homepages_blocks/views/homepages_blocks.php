
 
<h1 class="our_offers">Our Offers</h1>

<?php
function get_theme($count){
  switch ($count) {
    case '1':
      $theme = 'primary';
      break;
    case '2':
      $theme = 'success';
      break;
    case '3':
      $theme = 'danger';
      break;
    case '4':
      $theme = 'warning';
      break;
    default:
      $theme = 'success';
      break;
  }
  return $theme;
}
$count = 0;
$this->load->module('homepages_offers');
$this->load->module('site_sittings');
$instrument = $this->site_sittings->_get_item_instruments();
$symbol = $this->site_sittings->_get_symbol();
foreach ($query->result() as $row) {
  $block_id = $row->id;
  $number_block = $this->homepages_offers->count_where('block_id', $block_id);
  if($number_block >0){
  $count++;
  if($count >4){
    $count = 1;
  }
  $theme = get_theme($count);

  ?>
  
 
 <div class="panel panel-<?=$theme ?> panel-rec">
   <div class="panel-heading"><?=$row->block_title ?></div>
     <div class="panel-body">
  
     
        <?php $this->homepages_offers->_draw_offers($block_id,$theme,$instrument,$symbol); ?>
        
      
   
     </div>
    </div>



  <?php } }?>
