<?=Modules::run('templates/_draw_breadcrumbs',$breadcrumbs_data) ?>
<?php if(isset($flash)){
	echo $flash;
}
?>

<div class="row">
	<div class="col-md-2">
	<h1>
		
		<a href="<?=base_url().'assets/img/big_pic/'.$big_pic?>" data-featherlight="<?=base_url().'assets/img/big_pic/'.$big_pic?>">
			<img src="<?=base_url().'assets/img/big_pic/'.$big_pic?>" class="img-responsive" >
	</a>
	</h1>
	</div>
	<div class="col-md-7">
		<h2><?=$item_title ?></h2>
		<h2>Our Price :<?=$symbole.number_format($item_price,2) ?></h2>

		<p><?=$item_description ?></p>

	</div>
	<div class="col-md-3">
		<?= Modules::run('cart/_draw_in_shop',$update_id); ?>
		
	</div>

</div>
<div class="row">
	
 <?= Modules::run('store_items/_get_recommand',$update_id); ?> 
 




 
</div>