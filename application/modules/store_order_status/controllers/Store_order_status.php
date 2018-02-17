<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_order_status extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _get_status_title(){
	// $this->load->module('site_security');
	// $this->site_security->_make_sure_is_admin();
	$options['0'] = 'Order Submited.';
    
    $query = $this->get('status_title');
    foreach($query->result() as $row){
    	$options[$row->id] = $row->status_title;
    }
    return $options;
}
function get_status_title($update_id){
	$query = $this->get_where($update_id);
	foreach ($query->result() as $row) {
		$status_title = $row->status_title;
	}
	if(!isset($status_title)){
		$status_title = 'Uknown';
	}
	return $status_title;
}
function _draw_status_title(){
	$data['query_status'] = $this->get('status_title');
	$this->load->view('draw_status_title',$data);
}
function create(){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	$this->load->library('session');

	$update_id = $this->uri->segment(3);
	$submit = $this->input->post('submit', TRUE);
     //cansel button
	if($submit == 'Cancel'){
		redirect('store_order_status/manage');
	}
     // insert data in table 
	if($submit == 'Submit'){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('status_title', 'Status Title', 'required');
		
		
		if($this->form_validation->run() == TRUE){
			$data = $this->get_data_from_post();

			if(is_numeric($update_id)){
			
				$this->_update($update_id, $data);
				$flash_msg = 'The Order Status Detail Was Successfully Updated';
				$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
				redirect('store_order_status/create/'.$update_id);
			}else{
			
				$this->_insert($data);
				$update_id = $this->get_max();
				$flash_msg = 'The Order Status  Was Successfully Aded';
				$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
				redirect('store_order_status/create/'.$update_id);
			}
		}
	}
     // submit handler
	if((is_numeric($update_id))&&($submit!='Submit')){
		$data = $this->get_data_from_db($update_id);
		
	}else{
		$data = $this->get_data_from_post();
	}
     // create headline 
	if(!is_numeric($update_id)){
		$data['headline'] = 'Add New Order Status';
	}else{
		$data['headline'] = 'Update  Order Status';
	}
    // load data to module
	$data['update_id'] = $update_id;
	
	$data['flash'] = $this->session->flashdata('item');
    //$data['store_items'] = 'store_items';
	$data['view_file'] = 'create';
	$this->load->module('templates');
	$this->templates->admin($data);
}


function get_data_from_post(){
	$data['status_title'] = $this->input->post('status_title', TRUE);
	return $data;
}
function get_data_from_db($update_id){
 //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$data['status_title'] = $row->status_title;
	}
	if(!isset($data)){
		$data = '';
	}
	return $data;
}


function manage(){

	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	$data['query'] = $this->get('status_title');
	$data['flash'] = $this->session->flashdata('item');


	$data['headline'] = 'Manage Order Status';
	$data['view_file'] = 'manage';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function delete($update_id){
     //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$this->load->library('session');
     // security form
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	//$this->load->view('upload_form', $error)
	$data['update_id'] = $update_id;
	$data['flash'] = $this->session->flashdata('item');
	$submit = $this->input->post('submit', TRUE);
	if($submit=='Cancel'){
		redirect('store_order_status/create/'.$update_id);
	}elseif($submit=='Yes - delete'){
		$allowd_delete = $this->_make_sure_is_allowed($update_id);
		if($allowd_delete==FALSE){
			$flash_msg = 'You Cant Delete This Account';
		    $value = '<div class="alert alert-danger">'.$flash_msg.'</div>';
		    $this->session->set_flashdata('item', $value);
		    redirect('store_order_status/manage/');
		}
		$this->_delete($update_id);
       //flash data 
		$flash_msg = 'The Order Status  Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
		redirect('store_order_status/manage/');
	}
}
function _make_sure_is_allowed($update_id){
	$mysql_query = "SELECT * FROM store_orders WHERE order_status = $update_id";
	$query = $this->_custom_query($mysql_query);
	$num_rows = $query->num_rows();
	if($num_rows>0){
		return FALSE;
	}else{
		return TRUE;
	}
	
}
function deleteconf($update_id){
     //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$this->load->library('session');
     // security form
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	$data['update_id'] = $update_id;
	$data['flash'] = $this->session->flashdata('item');
	$data['headline'] = 'Delete Order Status';
      //$data['store_items'] = 'store_items';
	$data['view_file'] = 'deleteconf';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function _get_order_title($update_id){
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$status_name = $row->status_title;
	}
	if(!isset($status_name)){
		$status_name = 'Order Submited';
	}
	return $status_name;
}
function get($order_by) {
$this->load->model('mdl_store_order_status');
$query = $this->mdl_store_order_status->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_store_order_status');
$query = $this->mdl_store_order_status->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_store_order_status');
$query = $this->mdl_store_order_status->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_store_order_status');
$query = $this->mdl_store_order_status->get_where_custom($col, $value);
return $query;
}
function get_whith_double_condition($col1, $value1,$col2, $value2) {
$this->load->model('mdl_store_order_status');
$query = $this->mdl_store_order_status->get_whith_double_condition($col1, $value1,$col2, $value2);
return $query;
}

function _insert($data) {
$this->load->model('mdl_store_order_status');
$this->mdl_store_order_status->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_store_order_status');
$this->mdl_store_order_status->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_store_order_status');
$this->mdl_store_order_status->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_store_order_status');
$count = $this->mdl_store_order_status->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_store_order_status');
$max_id = $this->mdl_store_order_status->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_store_order_status');
$query = $this->mdl_store_order_status->_custom_query($mysql_query);
return $query;
}

}
// function autogene(){
// 	$mysql_query = "SHOW COLUMNS FROM store_order_status";
//     $query = $this->_custom_query($mysql_query);
//     foreach ($query->result() as $row) {
//     	$colume_name = $row->Field;
//     	echo '$data[\''.$colume_name.'\'] = $this->input->post(\''.$colume_name.'\', TRUE)'.'<br>';
//     }
//      foreach ($query->result() as $row) {
//     	$colume_name = $row->Field;
//     	echo '$data[\''.$colume_name.'\'] = $row->'.$colume_name.';<br>';
  
//     }
// }