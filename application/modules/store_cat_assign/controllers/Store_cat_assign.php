<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_cat_assign extends MX_Controller
{

function __construct() {
parent::__construct();
}

function delete($update_id){
	//redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
 
		//get data from dataase
		$query = $this->get_where($update_id);
		foreach($query->result() as $row){
			$item_id = $row->item_id;
		}
		//delete item 
		$this->_delete($update_id);
		$flash_msg = 'The Category Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
	    //redirect
	    redirect('store_cat_assign/update/'.$item_id);
		// get id
	}
function submit($item_id){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	//redirect if not allowd
		if(!is_numeric($item_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
		
	    $submit = $this->input->post('submit', TRUE);
	    $cat_id = trim($this->input->post('cat_id', TRUE));
	    if($submit=='Finished'){
            redirect('store_items/create/'.$item_id);
	    }else if($submit == 'Submit'){
	    	if($cat_id !=''){
              $data['item_id'] = $item_id;
              $data['cat_id'] = $cat_id;
              $data = $this->_insert($data);
              //flash data 
              $this->load->module('store_categories');
              $cat_title = $this->store_categories->_get_parent_title($cat_id);
              $flash_msg = 'The Category '.$cat_title.' Was Successfully Assigned To Item';
		      $value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		      $this->session->set_flashdata('item', $value);
	
	    	}
	    }
        redirect('Store_cat_assign/update/'.$item_id);
	}
function update($item_id){
   if(!is_numeric($item_id)){
		redirect('site_security/not_allowed');
	}

    $this->load->module('store_categories');
	$sub_category = $this->store_categories->_get_sub_cat_from_drpdown();

	$query = $this->get_where_custom('item_id', $item_id);
	$data['num_rows'] = $query->num_rows();
	foreach ($query->result() as $row) {
		$cat_title = $this->store_categories->_get_parent_title($row->cat_id);
		$parent_title = $this->store_categories->_get_parent_cat_title($row->cat_id);
		$assign_category[$row->id] = $parent_title.' > '.$cat_title;
	}
	if(!isset($assign_category)){
		$assign_category = '';
	}else{
		$sub_category = array_diff($sub_category, $assign_category);
	}
	$data['query'] = $query;
	
	$data['options'] = $sub_category;
	$data['cat_id'] = $this->input->post('cat_id', TRUE);
	$data['flash'] = $this->session->flashdata('item');
    $data['item_id'] = $item_id;
	$data['headline'] = 'Update Category Assign';
	$data['view_file'] = 'update';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function get($order_by) {
$this->load->model('mdl_store_cat_assign');
$query = $this->mdl_store_cat_assign->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_store_cat_assign');
$query = $this->mdl_store_cat_assign->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_store_cat_assign');
$query = $this->mdl_store_cat_assign->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_store_cat_assign');
$query = $this->mdl_store_cat_assign->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_store_cat_assign');
$this->mdl_store_cat_assign->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_store_cat_assign');
$this->mdl_store_cat_assign->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_store_cat_assign');
$this->mdl_store_cat_assign->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_store_cat_assign');
$count = $this->mdl_store_cat_assign->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_store_cat_assign');
$max_id = $this->mdl_store_cat_assign->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_store_cat_assign');
$query = $this->mdl_store_cat_assign->_custom_query($mysql_query);
return $query;
}

}