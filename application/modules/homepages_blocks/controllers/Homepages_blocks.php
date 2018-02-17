<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Homepages_blocks extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _draw_offer(){
   $data['query'] = $this->get('priority');
   $num_rows = $data['query']->num_rows();
   if($num_rows >0){
   	$this->load->view('homepages_blocks',$data);
   }
}
function _get_block_title($update_id){
	$data = $this->get_data_from_db($update_id);
	$block_title = $data['block_title'];
	return $block_title;
}

function deleteconf($update_id){
         //redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
         // security form
		// $this->load->module('site_security');
		// $this->site_security->_make_sure_is_admin();
		//$this->load->view('upload_form', $error)
		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');


		$data['headline'] = 'Delete Items';
          //$data['store_items'] = 'store_items';
		$data['view_file'] = 'deleteconf';
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
			redirect('homepages_blocks/create/'.$update_id);
		}elseif($submit=='Yes - delete'){
			$this->_stor_delete_item($update_id);
           //flash data 
			$flash_msg = 'The Home Page Block  Was Successfully Deleted';
			$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
			$this->session->set_flashdata('item', $value);

			redirect('homepages_blocks/manage/');

		}
}
function _stor_delete_item($update_id){
	
   $mysql_query = "DELETE FROM homepages_offers WHERE block_id =$update_id";
   $query = $this->_custom_query($mysql_query);
	
		//delete  item
	$this->_delete($update_id);

}


function _draw_sortable_list(){
	$mysql_query = "SELECT * FROM homepages_blocks ORDER BY priority";
	$data['query'] = $this->_custom_query($mysql_query);
	$this->load->view('sortable_list', $data);
}
function sort(){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	//get post id
	$number = $this->input->post('number', TRUE);
	for($i= 1; $i <= $number;$i++){
	  $update_id = $_POST['order'.$i];
	  $data['priority'] = $i;
      $this->_update($update_id, $data);
	}
}


function create(){
	$this->load->library('session');
     // security form
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
     // get id
	$update_id = $this->uri->segment(3);
	$submit = $this->input->post('submit', TRUE);
      //cansel button
	if($submit == 'Cancel'){
		redirect('homepages_blocks/manage');
	}
	  // insert data in table 
	if($submit == 'Submit'){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('block_title', 'Category Title', 'required|max_length[250]');

		if($this->form_validation->run() == TRUE){
			$data = $this->get_data_from_post();
			
			if(is_numeric($update_id)){
				$this->_update($update_id, $data);
				$flash_msg = 'The Category Detail Was Successfully Updated';
				$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
				redirect('homepages_blocks/create/'.$update_id);
			}else{
				$this->_insert($data);
				$update_id = $this->get_max();
				$flash_msg = 'The Category  Was Successfully Aded';
				$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
				redirect('homepages_blocks/create/'.$update_id);
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
			$data['headline'] = 'Add New Block';
		}else{
			$block_title =  $this->_get_block_title($update_id);
			$data['headline'] = 'Update  '.$block_title;
		}
              // load data to module
		$data['update_id'] = $update_id;
		
		$data['flash'] = $this->session->flashdata('item');
   
		$data['view_file'] = 'create';
		$this->load->module('templates');
		$this->templates->admin($data);
	}


function manage(){

	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
    // get data from database
   
	
	$data['flash'] = $this->session->flashdata('item');
    $data['sortable'] = TRUE;
  
	$data['headline'] = 'Manage Home page Offer';
	$data['view_file'] = 'manage';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function get_data_from_post(){
	$data['block_title'] = $this->input->post('block_title', TRUE);
	return $data;
}
function get_data_from_db($update_id){
 //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$data['block_title'] = $row->block_title;
	}
	if(!isset($data)){
		$data = '';
	}
	return $data;
}


function get($order_by) {
$this->load->model('mdl_homepages_blocks');
$query = $this->mdl_homepages_blocks->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_homepages_blocks');
$query = $this->mdl_homepages_blocks->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_homepages_blocks');
$query = $this->mdl_homepages_blocks->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_homepages_blocks');
$query = $this->mdl_homepages_blocks->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_homepages_blocks');
$this->mdl_homepages_blocks->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_homepages_blocks');
$this->mdl_homepages_blocks->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_homepages_blocks');
$this->mdl_homepages_blocks->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_homepages_blocks');
$count = $this->mdl_homepages_blocks->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_homepages_blocks');
$max_id = $this->mdl_homepages_blocks->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_homepages_blocks');
$query = $this->mdl_homepages_blocks->_custom_query($mysql_query);
return $query;
}

}