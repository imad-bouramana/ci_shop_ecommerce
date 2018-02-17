<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Webe_pages extends MX_Controller
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
     // security form
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	//$this->load->view('upload_form', $error)
	$data['update_id'] = $update_id;
	$data['flash'] = $this->session->flashdata('item');
	$submit = $this->input->post('submit', TRUE);
	if($submit=='Cancel'){
		redirect('webe_pages/create/'.$update_id);
	}elseif($submit=='Yes - delete'){
		$this->_delete($update_id);
       //flash data 
		$flash_msg = 'The Page  Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
		redirect('webe_pages/manage/');
	}
}
function deleteconf($update_id){
     //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}elseif($update_id <3){
		redirect('site_security/not_allowed');
	}
	$this->load->library('session');
     // security form
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	$data['update_id'] = $update_id;
	$data['flash'] = $this->session->flashdata('item');
	$data['headline'] = 'Delete Pages';
      //$data['store_items'] = 'store_items';
	$data['view_file'] = 'deleteconf';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function create(){
	$this->load->library('session');

    $this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
// get id
	$update_id = $this->uri->segment(3);
	$submit = $this->input->post('submit', TRUE);
//cansel button
	if($submit == 'Cancel'){
		redirect('webe_pages/manage');
	}
	// insert data in table 
		if($submit == 'Submit'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('page_title', 'Page Title', 'required|max_length[250]');
			$this->form_validation->set_rules('page_keyword', 'Page Keyword', 'required|max_length[250]');
			$this->form_validation->set_rules('page_content', 'Page Centent', 'required');
			

			if($this->form_validation->run() == TRUE){
				$data = $this->get_data_from_post();
				$data['page_url'] = url_title($data['page_title']); 
				if(is_numeric($update_id)){
					if($update_id < 3){
                        unset($data['page_url']);
					}
					$this->_update($update_id, $data);
					
					$flash_msg = 'The Page Detail Was Successfully Updated';
					$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('webe_pages/create/'.$update_id);
				}else{
					$this->_insert($data);
					$update_id = $this->get_max();
					$flash_msg = 'The Page  Was Successfully Created';
					$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('webe_pages/manage');
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
			$data['headline'] = 'Add New Page';
		}else{
			$data['headline'] = 'Update  Page';
		}
        // load data to module
		$data['update_id'] = $update_id;
		
		$data['flash'] = $this->session->flashdata('item');
        //$data['webe_pages'] = 'webe_pages';
		$data['view_file'] = 'create';
		$this->load->module('templates');
		$this->templates->admin($data);
	}

function get_data_from_post(){
	$data['page_title'] = $this->input->post('page_title', TRUE);
	$data['page_keyword'] = $this->input->post('page_keyword', TRUE);
	$data['page_headline'] = $this->input->post('page_headline', TRUE);
	$data['page_description'] = $this->input->post('page_description', TRUE);
	$data['page_content'] = $this->input->post('page_content', TRUE);
	return $data;
}
function get_data_from_db($update_id){
 //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$data['page_title'] = $row->page_title;
		$data['page_description'] = $row->page_description;
		$data['page_keyword'] = $row->page_keyword;
		$data['page_headline'] = $row->page_headline;
		$data['page_content'] = $row->page_content;
		$data['page_url'] = $row->page_url;
	}
	if(!isset($data)){
		$data = '';
	}
	return $data;
}

function manage(){

		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$data['query'] = $this->get('page_url');
		$data['flash'] = $this->session->flashdata('item');
		// $data['view_module'] = 'webe_pages';
		$data['update_id'] = $this->uri->segment(3);
		$data['headline'] = 'Centent Management System';
		$data['view_file'] = 'manage';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function get($order_by) {
$this->load->model('mdl_webe_pages');
$query = $this->mdl_webe_pages->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_webe_pages');
$query = $this->mdl_webe_pages->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_webe_pages');
$query = $this->mdl_webe_pages->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_webe_pages');
$query = $this->mdl_webe_pages->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_webe_pages');
$this->mdl_webe_pages->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_webe_pages');
$this->mdl_webe_pages->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_webe_pages');
$this->mdl_webe_pages->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_webe_pages');
$count = $this->mdl_webe_pages->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_webe_pages');
$max_id = $this->mdl_webe_pages->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_webe_pages');
$query = $this->mdl_webe_pages->_custom_query($mysql_query);
return $query;
}

}