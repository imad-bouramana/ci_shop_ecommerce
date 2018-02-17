<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Homepages_offers extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _draw_offers($block_id,$theme,$instrument,$symbol){
	$mysql_query = "
SELECT
store_items.item_description,
store_items.item_price,
store_items.item_title,
store_items.item_url,
store_items.big_pic,
store_items.small_pic,
store_items.waz_price,
store_items.status,
store_items.id
FROM
homepages_offers
INNER JOIN homepages_blocks ON homepages_offers.block_id = homepages_blocks.id
INNER JOIN store_items ON store_items.id = homepages_offers.item_id
WHERE
homepages_offers.block_id = 
		 $block_id";
	$query = $this->_custom_query($mysql_query);
	$num_rows = $query->num_rows();
	if($num_rows>0){
		$data['query']  = $query;
        $data['theme'] = $theme;
        $data['instrument'] = $instrument;
        $data['symbol'] = $symbol;
		$this->load->view('offers',$data);
	}

}
function _delete_item($update_id){
	$mysql_query = "DELETE FROM homepages_offers WHERE block_id = $update_id";
    $query = $this->_custom_query($mysql_query); 

}
function update($update_id){
       if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
	
		$data['query'] = $this->get_where_custom('block_id', $update_id);
		$data['num_rows'] = $data['query']->num_rows();
		$data['flash'] = $this->session->flashdata('item');
        $data['update_id'] = $update_id;
		$data['headline'] = 'Manage Home Page Offers';
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
	    $item_id = trim($this->input->post('item_id', TRUE));
	    if($submit=='Finished'){
            redirect('Homepages_blocks/manage');
            
	    }else if($submit == 'Submit'){
	    	$is_valid = $this->_is_valid_item_id($item_id);
	    	if($is_valid==FALSE){
	    		$flash_msg = 'The Item Id Is Not Valid';
		        $value = '<div class="alert alert-danger">'.$flash_msg.'</div>';
		        $this->session->set_flashdata('item', $value);
		        redirect('Homepages_offers/update/'.$update_id);
	    	}
	    	if($item_id !=''){
              $data['block_id'] = $update_id;
              $data['item_id'] = $item_id;
              $data = $this->_insert($data);
              //flash data 
              $flash_msg = 'The Home Page Offers Was Successfully added';
		      $value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		      $this->session->set_flashdata('item', $value);
	
	    	}
	    }
        redirect('Homepages_offers/update/'.$update_id);
	}
function _is_valid_item_id($item_id){
	if(!is_numeric($item_id)){
		return FALSE;
	}
	$this->load->module('store_items');
	$query = $this->store_items->get_where($item_id);
	$num_rows = $query->num_rows();
	if($num_rows >0){
		return TRUE;
	}else{
		
		return FALSE;
	}
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
			$block_id = $row->block_id;
		}
		//delete item 
		$this->_delete($update_id);
		$flash_msg = 'The Offer Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
	    //redirect
	    redirect('homepages_offers/update/'.$block_id);
		// get id
		// $data['update_id'] = $update_id;
		// $data['flash'] = $this->session->flashdata('item');
	 // // submit handler
		// $data['headline'] = 'Update Offer Block';
  //   //$data['stor_items'] = 'stor_items';
		// $data['view_file'] = 'update';
		// $this->load->module('templates');
		// $this->templates->admin($data);
	}
function get($order_by) {
$this->load->model('mdl_homepages_offers');
$query = $this->mdl_homepages_offers->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_homepages_offers');
$query = $this->mdl_homepages_offers->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_homepages_offers');
$query = $this->mdl_homepages_offers->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_homepages_offers');
$query = $this->mdl_homepages_offers->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_homepages_offers');
$this->mdl_homepages_offers->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_homepages_offers');
$this->mdl_homepages_offers->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_homepages_offers');
$this->mdl_homepages_offers->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_homepages_offers');
$count = $this->mdl_homepages_offers->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_homepages_offers');
$max_id = $this->mdl_homepages_offers->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_homepages_offers');
$query = $this->mdl_homepages_offers->_custom_query($mysql_query);
return $query;
}

}