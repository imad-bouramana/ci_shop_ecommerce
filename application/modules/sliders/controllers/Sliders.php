<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sliders extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _attemp_draw_slides(){
	$current_url = current_url();
	$query_sliders = $this->get_where_custom('target_url', $current_url);
	$num_rows_sliders = $query_sliders->num_rows();
	
	if($num_rows_sliders > 0){
		
		$this->load->module('slides');
		foreach($query_sliders->result() as $row_sliders){
			$parent_id = $row_sliders->id;
			$data['query_slides'] = $this->slides->get_where_custom('parent_id', $parent_id);
		}
		$this->load->view('draw_slides', $data);
	}
}





function _get_cat_from_url_cat($slider_title){
		$query = $this->get_where_custom('slider_title',$slider_title);
		foreach($query->result() as $row){
			$cat_id = $row->id;
		}
		if(!isset($cat_id)){
			$cat_id = 0;
		}
		return $cat_id;
	}


function _get_slider_title_title($update_id){
	$data = $this->get_data_from_db($update_id);
	$slider_title = $data['slider_title'];
	$slider_title_title = $this->_get_slider_title($slider_title);
	return $slider_title_title;
}
function _get_sliders_title($update_id){
	$get_sliders_name = $this->_get_slider_title_title($update_id);
	return $get_sliders_name;
}



function _get_slider_title($update_id){
	$data = $this->get_data_from_db($update_id);
	$slider_title = $data['slider_title'];
	return $slider_title;
}
function get_data_from_post(){
		$data['slider_title'] = $this->input->post('slider_title', TRUE);
		$data['target_url'] = $this->input->post('target_url', TRUE);
		return $data;
}
function get_data_from_db($update_id){
         //redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$query = $this->get_where($update_id);
		foreach($query->result() as $row){
			$data['slider_title'] = $row->slider_title;	
			$data['target_url'] = $row->target_url;		
		}
		if(!isset($data)){
			$data = '';
		}
		return $data;
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
			redirect('sliders/create/'.$update_id);
		}elseif($submit=='Yes - delete'){
           $this->_stor_delete_item($update_id);
           //flash data 
           $flash_msg = 'The Sliders  Was Successfully Deleted';
		   $value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		   $this->session->set_flashdata('item', $value);
				
	    redirect('sliders/manage');
	
		}
	}
function _stor_delete_item($update_id){
	$this->load->module('slides');
	$query = $this->slides->get_where_custom('parent_id',$update_id);
	foreach($query->result() as $row){
		$this->slides->_stor_delete_item($row->id);
	}
			//delete  page
    $this->_delete($update_id);
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
		//$this->load->view('upload_form', $error)
			$data['update_id'] = $update_id;
		    $data['flash'] = $this->session->flashdata('item');


		$data['headline'] = 'Delete Sliders';
          //$data['stor_items'] = 'stor_items';
		$data['view_file'] = 'deleteconf';
		$this->load->module('templates');
		$this->templates->admin($data);
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
			redirect('sliders/manage');
		}
	// insert data in table 
		if($submit == 'Submit'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('slider_title', 'slider name', 'required|max_length[150]');
			$this->form_validation->set_rules('target_url', 'Target Url', 'required|max_length[150]');

			if($this->form_validation->run() == TRUE){
				$data = $this->get_data_from_post();
				
				if(is_numeric($update_id)){
					$this->_update($update_id, $data);
					$flash_msg = 'The slider Detail Was Successfully Updated';
					$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('sliders/create/'.$update_id);
				}else{
					$this->_insert($data);
					$update_id = $this->get_max();
					$flash_msg = 'The slider  Was Successfully Created';
					$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('sliders/create/'.$update_id);
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
			$data['headline'] = 'Add New slider';
		}else{
			$slider_title = $this->_get_slider_title($update_id);
			$data['headline'] = 'Update  '.$slider_title;
		}
		//$data['options'] = $this->_get_sliders_parent($update_id);
		// $data['count_parent_cat'] = count($data['options']);
   // load data to module
		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');
    //$data['stor_items'] = 'stor_items';
		$data['view_file'] = 'create';
		$this->load->module('templates');
		$this->templates->admin($data);
}

function manage(){

		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
	// get data from database
		$data['query'] = $this->get('slider_title');
		$data['num_rows'] = $data['query']->num_rows();
		$data['sort_this'] = TRUE;
		$data['flash'] = $this->session->flashdata('item');
   
		$data['view_file'] = 'manage';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function get($order_by) {
$this->load->model('mdl_sliders');
$query = $this->mdl_sliders->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_sliders');
$query = $this->mdl_sliders->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_sliders');
$query = $this->mdl_sliders->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_sliders');
$query = $this->mdl_sliders->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_sliders');
$this->mdl_sliders->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_sliders');
$this->mdl_sliders->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_sliders');
$this->mdl_sliders->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_sliders');
$count = $this->mdl_sliders->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_sliders');
$max_id = $this->mdl_sliders->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_sliders');
$query = $this->mdl_sliders->_custom_query($mysql_query);
return $query;
}

}