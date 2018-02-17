<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_item_sizes extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _delete_item($update_id){
	$mysql_query = "DELETE FROM store_item_sizes WHERE item_id = $update_id";
    $query = $this->_custom_query($mysql_query); 

}
function update($update_id){
       if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
	
		$data['query'] = $this->get_where_custom('item_id', $update_id);
		$data['num_rows'] = $data['query']->num_rows();
		$data['flash'] = $this->session->flashdata('item');
        $data['update_id'] = $update_id;
		$data['headline'] = 'Manage Item';
		$data['view_file'] = 'update';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function submit($update_id){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	//redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
   

		
	    $submit = $this->input->post('submit', TRUE);
	    $Size = trim($this->input->post('Size', TRUE));
	    if($submit=='Finished'){
            redirect('store_items/create/'.$update_id);
	    }else if($submit == 'Submit'){
	    	if($Size !=''){
              $data['item_id'] = $update_id;
              $data['Size'] = $Size;
              $data = $this->_insert($data);
              //flash data 
              $flash_msg = 'The Item Size Was Successfully added';
		      $value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		      $this->session->set_flashdata('item', $value);
	
	    	}
	    }
        redirect('store_item_sizes/update/'.$update_id);
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
		$flash_msg = 'The Item Size Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
	    //redirect
	    redirect('store_item_sizes/update/'.$item_id);
		// get id
		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');
	 // submit handler
		$data['headline'] = 'Update Size Item';
    //$data['stor_items'] = 'stor_items';
		$data['view_file'] = 'update';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function get($order_by) {
$this->load->model('mdl_store_item_sizes');
$query = $this->mdl_store_item_sizes->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_store_item_sizes');
$query = $this->mdl_store_item_sizes->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_store_item_sizes');
$query = $this->mdl_store_item_sizes->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_store_item_sizes');
$query = $this->mdl_store_item_sizes->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_store_item_sizes');
$this->mdl_store_item_sizes->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_store_item_sizes');
$this->mdl_store_item_sizes->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_store_item_sizes');
$this->mdl_store_item_sizes->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_store_item_sizes');
$count = $this->mdl_store_item_sizes->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_store_item_sizes');
$max_id = $this->mdl_store_item_sizes->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_store_item_sizes');
$query = $this->mdl_store_item_sizes->_custom_query($mysql_query);
return $query;
}

}