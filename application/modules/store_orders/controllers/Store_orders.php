<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_orders extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _set_message($update_id){
	$this->load->module('site_security');
	$this->load->module('store_order_status');
	$this->load->module('enquiries');

	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$shopper_id = $row->shopper_id;
		$order_ref = $row->order_ref;
		$order_status = $order_status;
	}
	$status_name = $this->store_order_status->_get_order_title($shopper_id);
	$msg = 'Your Order Status '.$order_ref.' Has Been Updated '.'<br>';
	$msg .= ' The New Order Name Is :'.$status_name;

	$data['subject'] = 'Update Order Status Name';
	$data['message'] = $msg;
	$data['sent_to'] = $shopper_id;
	$data['date_created'] = time();
	$data['sent_by'] = 0;
	$data['code'] = $this->site_security->generate_random_string(6);
    $data['opened'] = 0;
				
	$this->enquiries->_insert($data);
}
function update_opened($update_id){
	$data['openned'] = 1;
	$this->_update($update_id, $data);
}
function _get_order_title(){
	$this->load->module('store_order_status');
	$order_status =   $this->uri->segment(3);
	$order_status = str_replace('status', '', $order_status);
	if(!is_numeric($order_status)){
		$order_status = 0;
	}
	 if($order_status == 0){
       	  $order_title = 'Order Submited';
       }else{
       	  $order_title = $this->store_order_status->_get_order_title($order_status);
       }
       return $order_title;
}
function submit_update($update_id){
	
         // security form
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
          // get id

		
	    $submit = $this->input->post('submit', TRUE);
	    $status_name = $this->input->post('status_title', TRUE);
	    $query = $this->get_where($update_id);
	    if($submit=='Cancel'){
	    	$query = $this->get_where($update_id);
	    	foreach($query->result() as $row){
               $order_status = $row->order_status;
	    	}
	    	$target_url = base_url().'store_orders/browse/status'.$order_status; 
            redirect($target_url);
	    }else if($submit == 'Submit'){
	    	  $data['order_status'] = $status_name;
              $this->_update($update_id, $data);
              $this->_set_message($update_id);
              //flash data 
              $flash_msg = 'The Status Name Was Successfully Updated';
		      $value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		      $this->session->set_flashdata('item', $value);
	         redirect('store_orders/view/'.$update_id);
	    }
        
	}

function view(){
	$this->load->library('session');
    // security form
    $this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
    $this->load->module('datemade');
    $this->load->module('store_order_status');
    $this->load->module('store_accounts');
    $this->load->module('cart');


    // get id
	$update_id = $this->uri->segment(3);
	$this->update_opened($update_id);

	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		
       $date_created = $row->date_created;
       $data['order_ref'] = $row->order_ref;
       $data['paypal_id'] = $row->paypal_id;
       $session_id = $row->session_id;
       $data['openned'] = $row->openned;
       $data['shopper_id'] = $row->shopper_id;
       $data['mc_gross'] = $row->mc_gross;
       $order_status = $row->order_status;
	}
       $data['date_created'] = $this->datemade->get_nice_date($date_created, 'full');
       if($order_status == 0){
       	  $data['order_status'] = 'Order Submited';
       }else{
       	  $data['order_status'] = $this->store_order_status->get_status_title($order_status);
       }

    $table = 'store_shopertrack';
 
    $data['query_cc'] = $this->cart->_get_data_from_basket($session_id, $data['shopper_id'], $table);
    $data['num_rows'] = $data['query_cc']->num_rows();

    $data['acount_detail_data'] = $this->store_accounts->get_data_from_db($data['shopper_id']);
    $data['custom_adress'] = $this->store_accounts->_get_customer_adress($data['shopper_id'], '<br>');
    $data['options'] = $this->store_order_status->_get_status_title();
 
	$data['update_id'] = $update_id;
	$data['flash'] = $this->session->flashdata('item');
	$data['headline'] = 'Order : '.$data['order_ref'];
    $data['update_id'] = $update_id;
	$data['view_file'] = 'view';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function browse(){

		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

        //
        $this->load->module('site_sittings');
		$this->load->module("custom_pagination");
	
		$use_limit = FALSE;

		$mysql_query = $this->_generate_mysql_query($use_limit);
		$query  = $this->_custom_query($mysql_query);
		$total_items = $query->num_rows(); 
		
        $use_limit = TRUE;
		$mysql_query = $this->_generate_mysql_query($use_limit);
        $data['query'] = $this->_custom_query($mysql_query);
        $data['num_rows'] = $data['query']->num_rows();

		$pagination_data['template'] = 'admin';
        $pagination_data['target_base_url'] = $this->get_target_base_url();
        $pagination_data['total_rows'] = $total_items;
        $pagination_data['offset_segment'] = 4;
     	$pagination_data['limit'] = $this->get_limit();
		           
          //$data['stor_items'] = 'stor_items';
		$data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);
        $pagination_data['offset_segment'] = $this->get_offset();
		$data['statement'] = $this->custom_pagination->get_show_statement($pagination_data);
       
        $data['order_status_title'] = $this->_get_order_title();
 
		 // $data['query'] = $this->get('id');
		$data['flash'] = $this->session->flashdata('item');
         // $data['stor_items'] = 'stor_items';
		$data['view_file'] = 'browse';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function _generate_mysql_query($use_limit){
	$order_status =   $this->uri->segment(3);
	$order_status = str_replace('status', '', $order_status);
	if(!is_numeric($order_status)){
		$order_status = 0;
	}

	if($order_status > 0){
		$mysql_query = "
             SELECT
                store_orders.id,
				store_orders.order_ref,
				store_orders.date_created,
				store_orders.mc_gross,
				store_orders.openned,
				store_orders.order_status,
				store_order_status.status_title,
				store_accounts.firstname,
				store_accounts.lastname,
				store_accounts.company
				FROM
				store_orders
				INNER JOIN store_accounts ON store_orders.shopper_id = store_accounts.id
				INNER JOIN store_order_status ON store_orders.order_status = store_order_status.id
				WHERE
				store_orders.order_status = $order_status
				ORDER BY
				store_orders.date_created DESC
		";
	}else{
        $mysql_query = "
			SELECT
			store_orders.id,
			store_orders.order_ref,
			store_orders.date_created,
			store_orders.mc_gross,
			store_orders.openned,
			store_orders.order_status,
			store_accounts.firstname,
			store_accounts.lastname,
			store_accounts.company
			FROM
			store_orders
			INNER JOIN store_accounts ON store_orders.shopper_id = store_accounts.id
			WHERE
			store_orders.order_status = $order_status
			ORDER BY
			store_orders.date_created DESC

        ";
	}

   if($use_limit == TRUE){
		$limit = $this->get_limit();
		$offset = $this->get_offset();
		$mysql_query .= " LIMIT ".$offset.', '.$limit;
   }
   return $mysql_query;
}
function get_target_base_url(){
	$first_bit = $this->uri->segment(1);
	$second_bit = $this->uri->segment(2);
	$therd_bit = $this->uri->segment(3);
	$target_base_url = base_url().$first_bit.'/'.$second_bit.'/'.$therd_bit;
	return $target_base_url;
}

function get_limit(){
	$limit = 20;
	return $limit;
}
function get_offset(){
	$offset_segment = $this->uri->segment(4);
	if(!is_numeric($offset_segment)){
		$offset_segment = 0;
	}
	return $offset_segment;
}
function _get_mc_gross($paypal_id){
	$this->load->module('paypal');
	$query = $this->paypal->get_where($paypal_id);
	foreach($query->result() as $row){
		$posted_information = $row->posted_information;
	}
	if(!isset($posted_information)){
		$mc_gross = 0;
	}else{
		$posted_information = unserialize($posted_information);
	    $mc_gross = $posted_information['mc_gross'];
	}
	return $mc_gross;
}
function _get_shopper_id($customer_session_id){
	$this->load->module('store_basket');
	$query = $this->store_basket->get_where_custom('session_id', $customer_session_id);
	foreach($query->result() as $row){
		$shopper_id = $row->shopper_id;
	}
	if(!isset($shopper_id)){
		$shopper_id = 0;
	}
	return $shopper_id;
}
function _generate_orders($paypal_id, $customer_session_id){
	
	$this->load->module('site_security');
	$order_ref = $this->site_security->generate_random_string(6);
	$order_ref = strtoupper($order_ref);
	$data['order_ref'] = $order_ref;
	$data['date_created'] = time();
	$data['paypal_id'] = $paypal_id;
	$data['session_id'] = $customer_session_id;
	$data['openned'] = 0;
	$data['order_status'] = 0;
	$data['shopper_id'] = $this->_get_shopper_id($customer_session_id);
	$data['mc_gross'] =  $this->_get_mc_gross($paypal_id);

	$this->_insert($data);

	$this->load->module('store_shopertrack');
	$this->store_shopertrack->_trensfer_from_basket($customer_session_id);
}

function get($order_by) {
$this->load->model('mdl_store_orders');
$query = $this->mdl_store_orders->get($order_by);
return $query;
}
function get_withe_double_condition($col1, $value1,$col2, $value2) {
$this->load->model('mdl_store_orders');
$query = $this->mdl_store_orders->get_withe_double_condition($col1, $value1,$col2, $value2) ;
return $query;
}
function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_store_orders');
$query = $this->mdl_store_orders->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_store_orders');
$query = $this->mdl_store_orders->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_store_orders');
$query = $this->mdl_store_orders->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_store_orders');
$this->mdl_store_orders->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_store_orders');
$this->mdl_store_orders->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_store_orders');
$this->mdl_store_orders->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_store_orders');
$count = $this->mdl_store_orders->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_store_orders');
$max_id = $this->mdl_store_orders->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_store_orders');
$query = $this->mdl_store_orders->_custom_query($mysql_query);
return $query;
}

}