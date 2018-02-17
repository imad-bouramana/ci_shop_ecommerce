  
    <?php 
  $this->load->module('site_sittings');
  $symbol = $this->site_sittings->_get_symbol();
 
foreach($query->result() as $row){
  $image = $row->small_pic;
  $items_price = $row->item_price;
  $waz_price = $row->waz_price;
  $items_title = $row->item_title;
  $description = $row->item_description;
  $url_link = base_url().$instrument.$row->item_url;
  $items_price = number_format($items_price, 2);
  $items_price = str_replace('.00', '', $items_price);

  ?>
  <div class="col-xs-12   col-md-3">
    <div class="offer offer-<?=$theme; ?>">
      <div class="shape">
        <div class="shape-text">
          <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
        </div>
      </div>
      <div class="offer-content">
        <h4 class="lead">
          Our Price
          <?=$symbol ?><?=$items_price?>
        </h4>
        <hr>
        <a href="<?= $url_link?>">
          <img src="<?=base_url().'assets/img/small_pic/'.$image ?>" alt="<?= $items_title?>" class="img-responsive" title="<?= $items_title?>">
        </a>
        <hr>
        <a href="<?= $url_link?>"><h4><?= $items_title?></h4></a>
        
      </div>
    </div>
  </div>
  <?php } ?>