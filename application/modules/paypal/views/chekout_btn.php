<?php 
echo form_open($form_location);
echo form_hidden('upload','1');
echo form_hidden('cmd','_cart');
echo form_hidden('business',$paypal_email);
echo form_hidden('currency_code',$currency);
echo form_hidden('custom',$custom);
echo form_hidden('return', $return);
echo form_hidden('cancel_return', $cancel_return);

$count = 0;
foreach($query->result() as $row){
	$count++;
	$item_title = $row->item_title;
	$item_price = $row->price;
	$item_colour = $row->item_colour;
	$item_size = $row->item_size;
	$item_qty = $row->item_qty;
  
    echo form_hidden('item_name_'.$count, $item_title);
    echo form_hidden('amount_'.$count, $item_price);
    echo form_hidden('item_qty_'.$count, $item_qty);
    

    if($item_colour !=''){
    echo form_hidden('on0_'.$count, 'Colour');
    echo form_hidden('os0_'.$count, $item_colour);

    }
    if($item_size !=''){
    echo form_hidden('on1_'.$count, 'Size');
    echo form_hidden('os1_'.$count, $item_size);

    }
    echo form_hidden('shipping_'.$count, $shipping);
}

?>
<div class="col-md-offset-5">
<button  class="btn btn-success"  type="submit" name="submit" value="Submit"> 
     <span class="glyphicon glyphicon-shopping-cart"></span>	Chekout To Basket
</button>
</div>
<?php

echo form_close();

if($paypal_local==TRUE){
    echo '<div>';
    echo form_open('paypal/submet_test');
    echo 'create items to store order';
    echo form_input('num_order');
    echo form_submit('submit','Submit');
    echo form_hidden('custom',$custom);

    echo form_close();
    echo '</div>';

}