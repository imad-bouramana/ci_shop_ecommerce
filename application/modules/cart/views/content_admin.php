
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white shopping-cart"></i><span class="break"></span>Your Shopping Items</h2>
			<div class="box-icon">

				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
	      <div class="table-responsive">
<table class="table table-bordered table-striped table-condensed">
<?php 
   $this->load->module('site_sittings');
     $this->load->module('shipping');
   $grand_total = 0;
   foreach($query->result() as $row){ 
   $symbol = $this->site_sittings->_get_symbol();
   $price = $row->price;
   $totale_price = $price*$row->item_qty;
   $shipping = $this->shipping->_get_shipping();
   $grand_total = $grand_total+$totale_price+$shipping; 
   
	?>
	<tr>
		<td><img src="<?=base_url() ?>assets/img/small_pic/<?=$row->small_pic?>" alt=""></td>
		<td>
		   Item Number : <?= $row->item_id?><br>
           <h2><span style="color: blue">Item Title : </span><?=$row->item_title ?></h2>
           <span style="color: blue">Item Price : </span><?=$symbol.$row->price ?><br>
           <span style="color: blue">Quantity : </span><?=$row->item_qty ?><br><br>
		</td>
		<td><?=$symbol.number_format($totale_price, 2)?></td>

	</tr>
	
	
<?php } 
 ?>
   <tr>

		<td colspan= "2" style="text-align: right;">Shipping </td>
		<td><?=$shipping ?></td>
	</tr>
    <tr>
		<td colspan= "2" style="text-align: right; font-weight: bold;font-size: 24px">Total :</td>
		<td style="font-weight: bold;font-size: 24px"><?=$symbol.number_format($grand_total, 2)?></td>
	</tr>
</table>
</div>


	
		</div>
	</div><!--/span-->

</div><!--/row-->
