<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cart extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _calc_total_shopping($data_cart){
  
  $customer_session_id = $data_cart['customer_session_id'];
  $shopper_id = $data_cart['shopper_id'];
  $table = $data_cart['table'];
  $get_shipping = $data_cart['get_shipping'];

  $query = $this->_get_data_from_basket($customer_session_id, $shopper_id, $table);
  $grand_total = 0;
  foreach($query->result() as $row){ 
  
     $price = $row->price;
     $totale_price = $price*$row->item_qty;
     $grand_total = $grand_total+$totale_price; 
   }
   if($get_shipping == TRUE){
       $this->load->module('shipping');
       $shipping = $this->shipping->_get_shipping();
   }else{
       $shipping = 0;
   }
   $grand_total = $grand_total+$shipping;
   $grand_total = number_format($grand_total, 2);
   return $grand_total;

}
function get_session_id_from_uri($chekout_token){
	$session_id = $this->_get_session_id_from_token($chekout_token);
	if($session_id==''){
		redirect(base_url());
	}
	$this->load->module('store_basket');
	$query = $this->store_basket->get_where_custom('session_id',$session_id);
	$num_rows = $query->num_rows();
	if($num_rows<1){
		redirect(base_url());
	}
	return $session_id;
}
function _create_chekout_token($session_id){
      $this->load->module('site_security');
      $encrypted_string = $this->site_security->_encrypted_string($session_id);
      $chekout_token = str_replace('+', '-plus-', $encrypted_string);
      $chekout_token = str_replace('/', '-slsh-', $chekout_token);
      $chekout_token = str_replace('=', '-equl-', $chekout_token);
      return $chekout_token;
}
function _get_session_id_from_token($chekout_token){
      $this->load->module('site_security');
    
      $session_id = str_replace('-plus-', '+', $chekout_token);
      $session_id = str_replace('-slsh-', '/', $session_id);
      $session_id = str_replace('-equl-', '=', $session_id);
      $session_id = $this->site_security->_decrypted_string($session_id);
      return $session_id;
}

function _generete_chekout_token($chekout_token){
   $this->load->module('site_security');
   $this->load->module('store_basket');
   $this->load->module('store_accounts');


   $ref = $this->site_security->generate_random_string(4);
   $customer_session_id = $this->_get_session_id_from_token($chekout_token);

   $data['firstname'] = 'Guest';
   $data['lastname'] = 'Acount';
   $data['username'] = 'Guest'.$ref;
   $data['date_create'] = time();

   $data['password'] = $chekout_token;

   $this->store_accounts->_insert($data);
   $new_acount_id = $this->store_accounts->get_max();

   $mysql_query = "UPDATE store_basket SET shopper_id = '$new_acount_id' WHERE session_id = '$customer_session_id'";
   $query = $this->store_basket->_custom_query($mysql_query);
 
}
function submit_checkout(){
	$submit = $this->input->post('submit',TRUE);
	if($submit == 'Yes Create One'){
		redirect('your_account/start');
	}elseif($submit== 'No Thanks'){
         $chekout_token = $this->input->post('chekout_token', TRUE);
         $this->_generete_chekout_token($chekout_token);
          redirect('cart/index/'.$chekout_token);
	}
}
function chekout_btn(){
	$this->load->module('site_security');
	$shopper_id = $this->site_security->_get_user_id();
	if(is_numeric($shopper_id)){
		redirect('cart');
	}
	 $data['chekout_token'] = $this->uri->segment(3);
	$data['flash'] = $this->session->flashdata('item');
	$data['view_file'] = 'chekout_btn';
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);

}
function _draw_item_to_cart($query){
	$this->load->module('site_security');
	$shopper_id = $this->site_security->_get_user_id();
	$third_bit = $this->uri->segment(3);
	if((!is_numeric($shopper_id)) and ($third_bit=='')){
		$this->_chekout_fake_btn($query);
	}else{
		$this->_chekout_reale_btn($query);
	}
}
function _chekout_reale_btn($query){
	$this->load->module('paypal');
	$this->paypal->_chekout_reale_btn($query);
}
function _chekout_fake_btn($query){
	foreach($query->result() as $row){
		$session_id = $row->session_id;
	}
	 $data['chekout_token'] = $this->_create_chekout_token($session_id);
	$this->load->view('chekout_fake_btn',$data);
}
function _draw_cart_item($query,$file_type){
	$this->load->module('site_sittings');
	$this->load->module('shipping');

	if($file_type== 'public'){
		$view_file = 'content_public';
	}else{
		$view_file = 'content_admin';
	}
	$data['shipping'] = $this->shipping->_get_shipping();
	$data['symbole'] = $this->site_sittings->_get_symbol();
	$data['query'] = $query;
	$this->load->view($view_file,$data);
}
function index(){
	$this->load->module('site_security');
	$data['flash'] = $this->session->flashdata('item');
	$data['view_file'] = 'add_to_cart';
	$third_bit = $this->uri->segment(3);
	if($third_bit!=""){
		$session_id = $this->get_session_id_from_uri($third_bit);
	}else{
		$session_id = $this->session->session_id;
	}
	
	$shopper_id = $this->site_security->_get_user_id();

	if(!is_numeric($shopper_id)){
		$shopper_id = 0;
	}
	$table = 'store_basket';
	$data['query'] = $this->_get_data_from_basket($session_id,$shopper_id,$table);
	$data['num_rows'] = $data['query']->num_rows();
	$data['showing_statement'] = $this->_showing_statement($data['num_rows']);
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);
}
function _showing_statement($num_items){
	if($num_items == 1){
		$showing_statement = "You Have One Item In Your Basket.";
	}else{
		$showing_statement = "You Have ".$num_items." Items In Your Basket.";
	}
	return $showing_statement;
}
function _get_data_from_basket($session_id,$shopper_id,$table){
	$this->load->module('store_basket');
	$mysql_query = "
	SELECT $table.*,store_items.small_pic,store_items.item_description
    FROM
      $table
    LEFT JOIN store_items ON $table.item_id = store_items.id
	";
	if($shopper_id > 0){
        $and_where = " WHERE $table.shopper_id = $shopper_id";
    }else{
    	$and_where = " WHERE $table.session_id = '$session_id'";
    }
    $mysql_query .= $and_where;
    $query = $this->store_basket->_custom_query($mysql_query);
    return $query;
}
function _draw_in_shop($item_id){
	
	$submetted_colour = $this->input->post('colour', TRUE);
	if($submetted_colour=='')
		$option_colour[''] = "Select ...";
	$this->load->module('store_item_colours');
	$query = $this->store_item_colours->get_where_custom('item_id',$item_id);
	$data['num_colour'] = $query->num_rows();
	foreach($query->result() as $row){
		$option_colour[$row->id] = $row->colour;
	}

	$submetted_size = $this->input->post('size', TRUE);
	if($submetted_size=='')
		$option_size[''] = "Select ...";
	$this->load->module('store_item_sizes');
	$query = $this->store_item_sizes->get_where_custom('item_id',$item_id);
	$data['num_size'] = $query->num_rows();
	foreach($query->result() as $row){
		$option_size[$row->id] = $row->size;
	}
	$data['submetted_colour'] = $submetted_colour;
	$data['option_colour'] = $option_colour;
	$data['submetted_size'] = $submetted_size;
	$data['option_size'] = $option_size;
	$data['item_id'] = $item_id;
	$this->load->view('cart',$data);
}
}