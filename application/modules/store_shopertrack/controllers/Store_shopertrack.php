<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_shopertrack extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _trensfer_from_basket($customer_session_id){
	$this->load->module('store_basket');
	$query = $this->store_basket->get_where_custom('session_id', $customer_session_id);
	foreach($query->result() as $row){
	
		$data['session_id'] = $row->session_id;
		$data['item_title'] = $row->item_title;
		$data['price'] = $row->price;
		$data['item_colour'] = $row->item_colour;
		$data['item_size'] = $row->item_size;
		$data['item_qty'] = $row->item_qty;
		$data['date_created'] = $row->date_created;
		$data['shopper_id'] = $row->shopper_id;
		$data['tax'] = $row->tax;
		$data['item_id'] = $row->item_id;
		$data['ip_address'] = $row->ip_address;

		$this->_insert($data);
		

	}
	$mysql_query = "DELETE FROM store_basket WHERE session_id = '$customer_session_id'";
	$query = $this->_custom_query($mysql_query);
}
function get($order_by) {
$this->load->model('mdl_Store_shopertrack');
$query = $this->mdl_Store_shopertrack->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_Store_shopertrack');
$query = $this->mdl_Store_shopertrack->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_Store_shopertrack');
$query = $this->mdl_Store_shopertrack->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_Store_shopertrack');
$query = $this->mdl_Store_shopertrack->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_Store_shopertrack');
$this->mdl_Store_shopertrack->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_Store_shopertrack');
$this->mdl_Store_shopertrack->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_Store_shopertrack');
$this->mdl_Store_shopertrack->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_Store_shopertrack');
$count = $this->mdl_Store_shopertrack->count_where($column, $value);
return $count;
}
function get_withe_double_condition($col1, $value1,$col2, $value2) {
$this->load->model('mdl_Store_shopertrack');
$query = $this->mdl_Store_shopertrack->get_withe_double_condition($col1, $value1,$col2, $value2) ;
return $query;
}

function get_max() {
$this->load->model('mdl_Store_shopertrack');
$max_id = $this->mdl_Store_shopertrack->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_Store_shopertrack');
$query = $this->mdl_Store_shopertrack->_custom_query($mysql_query);
return $query;
}

}