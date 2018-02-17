<div class="row">
	<table class="table table-striped table-condensed table-bordered">
		<?php 
		$first_bit = $this->uri->segment(1);
		$grand_totale = 0;
		foreach ($query->result() as $row) { 
			$price = number_format($row->price,2);
			$totale = $row->price*$row->item_qty;
		    $totale_desc = $symbole.number_format($totale,2);
			$grand_totale = $grand_totale+$totale;

			?>
			
		<tr>
			<td class="col-md-2">
				<img src="<?= base_url() .'assets/img/small_pic/'.$row->small_pic?>" alt="">
			</td>
			<td class="col-md-8">
				Item Number : <?=$row->id ?><br>
				Item Qty : <?=$row->item_qty ?><br>
				Item Title : <b><?=$row->item_title ?></b><br>
				Description : <?=$row->item_description ?><br>
				Price : <b><?=$symbole.$price ?></b><br>
				<?php
				if($first_bit!='yourorders'){
				echo anchor('store_basket/remove/'.$row->id,'Remove'); 
			}
				?>
			</td>
			<td class="col-md-2">
				Totale : 
				<b><?=$totale_desc?></b>
			</td>
		</tr>
		
		<?php } ?>
		<tr>
			<td colspan="2" class="text-right">Shipping :</td>
			<td><b><?=$symbole.number_format($shipping,2);?></b></td>
		</tr>
		<tr>
			<?php $grand_totale = $grand_totale+$shipping; ?>
			<td colspan="2" class="text-right">
				Grand Totale :
			</td>
			<td><b><?=$symbole.number_format($grand_totale,2);?></b></td>
		</tr>
	</table>
</div>