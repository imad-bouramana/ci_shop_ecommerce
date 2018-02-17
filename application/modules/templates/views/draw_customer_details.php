<?php
function _attempt_link_active($link_test){
   if((current_url()==base_url().'your_account/welcome') AND($link_test=='Your Message')){
   	  echo ' class="active"';
   }elseif((current_url()==base_url().'yourorders/browse') AND($link_test=='Your Order')){
   	  echo ' class="active"';
   }elseif((current_url()==base_url().'cart') AND($link_test=='Your Basket')){
      echo ' class="active"';}
}


?>
<ul class="nav nav-tabs">
  <li role="presentation" <?=_attempt_link_active('Your Message') ?>>
  	<a href="<?=base_url().'your_account/welcome' ?>">Your Message</a>
  </li>
  <li role="presentation" <?=_attempt_link_active('Your Order') ?>>
  	<a href="<?= base_url().'yourorders/browse' ?>">Your Order</a>
  </li>
  <li role="presentation" <?=_attempt_link_active('Your Basket') ?>>
    <a href="<?= base_url().'cart' ?>">Your Basket</a></li>
  <li role="presentation"><a href="<?=base_url().'your_account/logout' ?>">Log Out</a></li>

</ul>