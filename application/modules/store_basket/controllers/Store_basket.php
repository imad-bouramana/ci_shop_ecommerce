<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_basket extends MX_Controller
{

function __construct() {
parent::__construct();
}
function reginerate_session_id($data){
	$this->load->module('store_shopertrack');
	$old_shopper_id = $data['shopper_id'];
	$old_session_id = $data['session_id'];

	$col1 = 'shopper_id';
	$value1 = $old_shopper_id;
	$col2 = 'session_id';
	$value2 = $old_session_id;
	
	$query = $this->store_shopertrack->get_withe_double_condition($col1, $value1,$col2, $value2);
	$num_rows = $query->num_rows();

	if($num_rows>0){
		session_regenerate_id();
		$session_id = $this->session->session_id;
		$data['session_id'] = $session_id;
	}
	return $data;
}
function add_to_basket(){
	
	$submit = $this->input->post('submit', TRUE);
		if($submit == 'Submit'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('item_colour', 'Item Colour', 'numeric');
			$this->form_validation->set_rules('item_size', 'Item Size', 'numeric');
			$this->form_validation->set_rules('item_qty', 'item qty', 'required|numeric');
			$this->form_validation->set_rules('item_id', 'item id', 'required|numeric');
			
			if($this->form_validation->run() == TRUE){
               $data  = $this->_get_data();
               $data = $this->reginerate_session_id($data);
               $this->_insert($data);
              redirect('cart');
			}else{
                $refer_url = $_SERVER['HTTP_REFERER'];
				$error_msg = validation_errors('<div class="alert alert-danger">', '</div>');
			    $this->session->set_flashdata('item', $error_msg);
				redirect($refer_url);
			}

	}
}
function _make_sure_is_allowed($update_id){
    $query = $this->get_where($update_id);
    foreach($query->result() as $row){
    	$shopper_id = $row->shopper_id;
    	$session_id = $row->session_id;
    }
    if(!isset($shopper_id)){
    	return FALSE;
    }
    $this->load->module('site_security');
	$customer_shopper_id = $this->site_security->_get_user_id();
    $customer_session_id = $this->session->session_id;
    if(($customer_shopper_id == $shopper_id) OR ($customer_session_id == $session_id)){
    	return TRUE;
    }else{
    	return FALSE;
    }
}
function remove(){
	
	$item_id = $this->uri->segment(3);
	$allowed = $this->_make_sure_is_allowed($item_id);
	if($allowed == FALSE){
		redirect('cart');
	}
	$this->_delete($item_id);
	redirect('cart');
}
function _get_data(){
	$this->load->module('site_security');
	$this->load->module('store_items');

    $item_id = $this->input->post('item_id', TRUE);

    $data_items = $this->store_items->get_data_from_db($item_id);
     
    $shopper_id = $this->site_security->_get_user_id();
    
    if(!is_numeric($shopper_id)){
    	$shopper_id = 0;
    }
	$item_size = $this->input->post('item_size', TRUE);
	$item_qty = $this->input->post('item_qty', TRUE);
	$item_price = $data_items['item_price'];
	$item_colour = $this->input->post('item_colour', TRUE);

	$data['item_title'] = $data_items['item_title'];
	$data['item_id'] = $item_id;
	$data['price'] = $item_price;
	$data['tax'] = 0;
	$data['item_colour'] = $this->get_type('colour', $item_colour);
	$data['item_size'] = $this->get_type('size', $item_size);
	$data['shopper_id'] = $shopper_id;
	$data['date_created'] = time();
	$data['item_qty'] = $item_qty;
	$data['ip_address'] = $this->input->ip_address();
	$data['session_id'] = $this->session->session_id;
	return $data;
}
function get_type($type, $update_id){
	if($type == 'size'){
		$this->load->module('store_item_sizes');
		$query = $this->store_item_sizes->get_where($update_id);
		foreach($query->result() as $row){
			$item_size = $row->size;
		}
		if(!isset($item_size)){
			$item_size = '';
		}
		$value = $item_size;
	}else{
		$this->load->module('store_item_colours');
		$query = $this->store_item_colours->get_where($update_id);
		foreach($query->result() as $row){
			$item_colour = $row->colour;
		}
		if(!isset($item_colour)){
			$item_colour = '';
		}
		$value = $item_colour;
	}
	return $value;
}
function get_whith_double_condition($col1, $value1,$col2, $value2) {
$this->load->model('mdl_store_basket');
$query = $this->mdl_store_basket->get_whith_double_condition($col1, $value1,$col2, $value2);
return $query;
}
function get($order_by) {
$this->load->model('mdl_store_basket');
$query = $this->mdl_store_basket->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_store_basket');
$query = $this->mdl_store_basket->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_store_basket');
$query = $this->mdl_store_basket->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_store_basket');
$query = $this->mdl_store_basket->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_store_basket');
$this->mdl_store_basket->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_store_basket');
$this->mdl_store_basket->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_store_basket');
$this->mdl_store_basket->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_store_basket');
$count = $this->mdl_store_basket->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_store_basket');
$max_id = $this->mdl_store_basket->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_store_basket');
$query = $this->mdl_store_basket->_custom_query($mysql_query);
return $query;
}
function autogene(){
	$mysql_query = "SHOW COLUMNS FROM store_basket";
    $query = $this->_custom_query($mysql_query);
    foreach ($query->result() as $row) {
    	$colume_name = $row->Field;
    	echo '$data[\''.$colume_name.'\'] = $this->input->post(\''.$colume_name.'\', TRUE)'.'<br>';
    }
     foreach ($query->result() as $row) {
    	$colume_name = $row->Field;
    	echo '$data[\''.$colume_name.'\'] = $row->'.$colume_name.';<br>';
  
    }
}
}