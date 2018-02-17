<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_item_colours extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _delete_item($update_id){
	$mysql_query = "DELETE FROM store_item_colours WHERE item_id = $update_id";
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
	    $colour = trim($this->input->post('colour', TRUE));
	    if($submit=='Finished'){
            redirect('store_items/create/'.$update_id);
	    }else if($submit == 'Submit'){
	    	if($colour !=''){
              $data['item_id'] = $update_id;
              $data['colour'] = $colour;
              $data = $this->_insert($data);
              //flash data 
              $flash_msg = 'The Item Colour Was Successfully added';
		      $value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		      $this->session->set_flashdata('item', $value);
	
	    	}
	    }
        redirect('Store_item_colours/update/'.$update_id);
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
		$flash_msg = 'The Item Colour Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
	    //redirect
	    redirect('store_item_colours/update/'.$item_id);
		// get id
		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');
	 // submit handler
		$data['headline'] = 'Update Colour Item';
    //$data['stor_items'] = 'stor_items';
		$data['view_file'] = 'update';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function get($order_by) {
$this->load->model('mdl_store_item_colours');
$query = $this->mdl_store_item_colours->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_store_item_colours');
$query = $this->mdl_store_item_colours->get_with_limit($limit, $offset, $order_by);
return $query;
}
function get_where_custom($col, $value) {
$this->load->model('mdl_store_item_colours');
$query = $this->mdl_store_item_colours->get_where_custom($col, $value);
return $query;
}
function get_where($id) {
$this->load->model('mdl_store_item_colours');
$query = $this->mdl_store_item_colours->get_where($id);
return $query;
}



function _insert($data) {
$this->load->model('mdl_store_item_colours');
$this->mdl_store_item_colours->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_store_item_colours');
$this->mdl_store_item_colours->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_store_item_colours');
$this->mdl_store_item_colours->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_store_item_colours');
$count = $this->mdl_store_item_colours->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_store_item_colours');
$max_id = $this->mdl_store_item_colours->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_store_item_colours');
$query = $this->mdl_store_item_colours->_custom_query($mysql_query);
return $query;
}

}