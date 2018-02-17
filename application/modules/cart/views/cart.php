
<br>
<table class="table cart_table table-striped">
	<?php 
	echo form_open('store_basket/add_to_basket');
	?>
	<tr>
		<td colspan="2">Item ID : <?=$item_id ?></td>
	</tr>
	<?php if($num_colour >0){ ?>
	<tr>
		<td>Colour:</td>
		<td>
			<?php    
         
			$id_select_form = 'class="form-control"';
			echo form_dropdown('item_colour', $option_colour, $submetted_colour,$id_select_form);

			?>
	   
		</td>
	</tr>
	<?php } ?>
	<?php if($num_size>0){ ?>
	<tr>
		<td>Size:</td>
		<td>
			 <?php    

			$id_select_form = 'class="form-control"'; 
			echo form_dropdown('item_size', $option_size, $submetted_size,$id_select_form);

			?> 
		</td>
	</tr>
	<?php } ?>
	
	<tr>
		<td>QTY:</td>
		<td>
			
               <input type="number" name="item_qty" col="6" class="form-control" placeholder="0">
        
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<button class="btn btn-info" name="submit" type="submit" value="Submit">
				<span class="glyphicon glyphicon-shopping-cart"></span>
				Add To Shop
			</button>
		</td>
	</tr>
	<?php 
	echo form_hidden('item_id',$item_id);
	echo form_close();
	?>

</table>
<h5><b>Livraison Standard</b> 2-6 jours ouvrables</h5>
<h5><b>Livraison Express</b> - 1-2 jours ouvrables en commandant avant 15h (9,95 €)</h5>