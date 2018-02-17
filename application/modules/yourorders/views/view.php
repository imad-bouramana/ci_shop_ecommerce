<h1>Order : <?=$order_ref ?></h1>
<p class="lead">Date Ordered : <?=$date_created ?></p>
<p class="lead">Order Status Title : <?=$order_status_name ?></p>
<?php
	$type_file = 'public';
	echo Modules::run('cart/_draw_cart_item', $query_cc, $type_file);
