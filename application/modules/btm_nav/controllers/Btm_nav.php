<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Btm_nav extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _draw_nav_link(){
     $mysql_query = "
	    SELECT
			btm_nav.id,
			btm_nav.page_id,
			btm_nav.priority,
			webe_pages.page_url,
			webe_pages.page_title
			FROM
			btm_nav
			INNER JOIN webe_pages ON webe_pages.id = btm_nav.page_id
			ORDER BY
			btm_nav.priority 

	    ";
     $data['query'] = $this->_custom_query($mysql_query);
     $this->load->view('draw_nav_link', $data);
}
function delete($update_id){
	     //redirect if not allowd
	    $this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		
		
		$data['flash'] = $this->session->flashdata('item');
		$this->_delete($update_id);
           //flash data 
        $flash_msg = 'The Navigation Link  Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
				
	    redirect('btm_nav/manage');
	
		
	}
function submit_create(){
       // security form
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
  
		$submit = $this->input->post('submit', TRUE);
		$page_id = $this->input->post('page_id', TRUE);

    //cansel button
		if($submit == 'Cancel'){
			redirect('btm_nav/manage');
		}
	// insert data in table 
		if($submit == 'Submit'){
			$data['page_id'] = $page_id;
			$data['priority'] = 0;
			$this->_insert($data);

			$flash_msg = 'The bottom navigation  Was Successfully Aded';
			$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
			$this->session->set_flashdata('item', $value);
				
			redirect('btm_nav/manage');
		}
	}
function _draw_modal(){
	$query  = $this->get('priority');
	foreach($query->result() as $row){
		$option_selected[$row->page_id] = $row->page_id;
	}
	$data['options'] = $this->_get_category_parent($option_selected);
    $data['form_location'] = base_url().'btm_nav/submit_create';
	$this->load->view('create_modal', $data);
}
function _get_category_parent($option_selected){
	
	$options[''] = 'Please Select ...';
	$this->load->module('webe_pages');
	$query = $this->webe_pages->get('page_url');
	foreach($query->result() as $row){
		if($row->page_url == ''){
		   $row->page_url = 'Home';
	    }
		if(!in_array($row->id, $option_selected)){
			$options[$row->id] = $row->page_url;
		}
	}
	if(!isset($options)){
		$options = '';
	}

    return $options;
}
function _draw_blokcs(){
	$data['query'] = $this->get('priority');
	$num_rows = $data['query']->num_rows();
	if($num_rows > 0){
		$this->load->view('home_page_blocks',$data);
	}
}


function _manage_home_blokcs(){
    $mysql_query = "
    SELECT
		btm_nav.id,
		btm_nav.page_id,
		btm_nav.priority,
		webe_pages.page_url,
		webe_pages.page_title
		FROM
		btm_nav
		INNER JOIN webe_pages ON webe_pages.id = btm_nav.page_id
		ORDER BY
		btm_nav.priority ASC

    ";
    $data['special_page'] = $this->_get_speciale_page();
    $data['query'] = $this->_custom_query($mysql_query);
    $this->load->view('cat_parent_sort',$data);
}
function _get_speciale_page(){
	$special_page[] = 1;
	$special_page[] = 2;
	return $special_page;

}
function manage(){

		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
	// get data from database
		
		$data['sort_this'] = TRUE;
		$data['flash'] = $this->session->flashdata('item');
   // $data['stor_items'] = 'stor_items';
		$data['view_file'] = 'manage';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function get($order_by) {
$this->load->model('mdl_btm_nav');
$query = $this->mdl_btm_nav->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_btm_nav');
$query = $this->mdl_btm_nav->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_btm_nav');
$query = $this->mdl_btm_nav->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_btm_nav');
$query = $this->mdl_btm_nav->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_btm_nav');
$this->mdl_btm_nav->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_btm_nav');
$this->mdl_btm_nav->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_btm_nav');
$this->mdl_btm_nav->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_btm_nav');
$count = $this->mdl_btm_nav->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_btm_nav');
$max_id = $this->mdl_btm_nav->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_btm_nav');
$query = $this->mdl_btm_nav->_custom_query($mysql_query);
return $query;
}

}