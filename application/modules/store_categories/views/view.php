<h1><?=$cat_title ?></h1>
<h4 class="paginationn"><?=$statement ?></h5>
<h2 class="paginationn"><?= $pagination?></h2>

<div class="row">
<?php foreach($query->result() as $row){ 
	$pic_path = base_url().'assets/img/small_pic/'.$row->small_pic;
	$waz_price = number_format($row->waz_price, 2);
  $waz_price = str_replace('.00', "", $waz_price);

	$price = number_format($row->item_price, 2);
  $price = str_replace('.00', "", $price);
 	$page_url = base_url().$instrument.$row->item_url;

	?>
    <div class="col-xs-12 col-sm-6 col-md-3">
    	 <div class="thumbnail cat_thumb">
         <a href="<?=$page_url ?>">
          <img src="<?=$pic_path ?>" alt="<?=$row->item_title ?>" title="<?=$row->item_title ?>" ></a>
    	 	 <div class="caption">
    	 	   <a href="<?=$page_url ?>"><h5><?=$row->item_title ?></h5></a>
               <p>
               	<?php 
               	if($waz_price!=0){
               		echo '<span class="price2">'.$symbol.$price.'</span>'.' - ';
               		echo '<span class="waz">'.$symbol.$waz_price.'<span>';
               		
               	}else{
                    echo '<span class="price">$'.$price.'</span>';
               	}
               	?>
                 <a href="<?=$page_url ?>" class="pull-right"><span class="btn btn-info">Details</span></a>
               	</p>

            </div>
     
        </div>
    </div>

<?php  
}
?>


  
</div>
<h2 class="paginationn"><?= $pagination?></h2>