<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Comments extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _draw_comment($comments_type, $update_id){
	$mysql_query = "SELECT * FROM comments WHERE comments_type = '$comments_type' AND update_id = $update_id ORDER BY date_created DESC";
	$data['query'] = $this->_custom_query($mysql_query);
	$num_rows = $data['query']->num_rows();
	if($num_rows>0){
	    $this->load->view('comments', $data);
    }
}
function submit(){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	$data['comment'] = $this->input->post('comment',TRUE);
	$data['comments_type'] = $this->input->post('comments_type',TRUE);
	$data['update_id'] = $this->input->post('update_id',TRUE);
	$data['date_created'] = time();
	
	if($data['comment']!=''){
		$this->_insert($data);
		$flash_msg = 'The Comment Waz Succusfuly Submited ';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
		
	}
	$url_referer = $_SERVER['HTTP_REFERER']; 
	redirect($url_referer);
}
function get($order_by) {
$this->load->model('mdl_comments');
$query = $this->mdl_comments->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_comments');
$query = $this->mdl_comments->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_comments');
$query = $this->mdl_comments->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_comments');
$query = $this->mdl_comments->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_comments');
$this->mdl_comments->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_comments');
$this->mdl_comments->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_comments');
$this->mdl_comments->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_comments');
$count = $this->mdl_comments->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_comments');
$max_id = $this->mdl_comments->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_comments');
$query = $this->mdl_comments->_custom_query($mysql_query);
return $query;
}

}