<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Blog extends MX_Controller
{

function __construct() {
parent::__construct();
}

function article(){
		//
    $first_bit = trim($this->uri->segment(3));
	$query = $this->get_where_custom('blog_url',$first_bit);
	$num_rows = $query->num_rows();
	if($num_rows<1){
		$this->load->module('site_sittings');
		$data['page_content'] = $this->site_sittings->_get_not_found();
	}

		//
	$blog_url = $this->uri->segment(3);
	$data['query'] = $this->get_where_custom('blog_url',$blog_url);
	$data['headline'] = 'Centent Management System';
	$data['view_file'] = 'article';
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);

}
function _draw_feed_hp(){
	$this->load->helper('text');
	$mysql_query = "SELECT * FROM blog Order By date_created DESC LIMIT 0,3";
	$data['query'] = $this->_custom_query($mysql_query);
	$this->load->view('feed_hd', $data);
}
function delete_image($update_id){
	//redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
    // security form
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
    // get id

		$data = $this->get_data_from_db($update_id);
		$picture = $data['picture']; 
        //get path
		$picture_path = './assets/img/picture/'.$picture;
		$small_pic = str_replace('.', '_thumb.', $picture);
        $thumb_path = './assets/img/picture/'.$small_pic;

        //unlik imag from 
		if(file_exists($picture_path)){
			unlink($picture_path);
		}
		if(file_exists($thumb_path)){
			unlink($thumb_path);
		}
		unset($data);
		$data['picture'] = "";
		$this->_update($update_id, $data);
        //flash data
		$flash_msg = 'The Blog Image Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
		redirect('blog/create/'.$update_id);
	}
function _manage_thumbnail($file_name,$thumb_file){
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/picture/'.$file_name;
		$config['new_image'] = './assets/img/picture/'.$thumb_file;
		
		$config['maintain_ratio'] = TRUE;
		$config['width']         = 200;
		$config['height']       = 200;
       

		$this->load->library('image_lib', $config);

		$this->image_lib->resize();
	}
function do_upload($update_id){
		//redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
    // security form
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
		//submit value
		$submit = $this->input->post('submit', TRUE);
    //cansel button
		if($submit == 'Cancel'){
			redirect('blog/create/'.$update_id);
		}
		//upload
		$config['upload_path']          = './assets/img/picture/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 300;
		$config['max_width']            = 2024;
		$config['max_height']           = 968;
		 $config['file_name']       = $this->site_security->generate_random_string(16);

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile'))
		{
			$data['error'] = array('error' => $this->upload->display_errors());

			//$this->load->view('upload_form', $error)
			$data['update_id'] = $update_id;
			$data['flash'] = $this->session->flashdata('item');

			$data['headline'] = 'upload image';
          //$data['store_items'] = 'store_items';
			$data['view_file'] = 'upload_image';
			$this->load->module('templates');
			$this->templates->admin($data);
		}
		else
		{   
			$data = array('upload_data' => $this->upload->data());
			//get finename 
			$upload_data = $data['upload_data'];
			$file_name = $upload_data['file_name'];

			$raw_name  = $upload_data['raw_name'];
			$file_ext = $upload_data['file_ext'];
			$thumb_file = $raw_name.'_thumb'.$file_ext;
			$this->_manage_thumbnail($file_name,$thumb_file);
             // insert image into database
			$update_data['picture'] = $file_name;
			$this->_update($update_id, $update_data);
			//get id 
			$data['update_id'] = $update_id;
			$data['flash'] = $this->session->flashdata('item');

			$data['headline'] = 'upload Success';
          //$data['store_items'] = 'store_items';
			$data['view_file'] = 'upload_success';
			$this->load->module('templates');
			$this->templates->admin($data);

			
		}
	}
	
function uploade_image($update_id){
	//redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
        $this->load->module('site_security');
        $this->site_security->_make_sure_is_admin();

		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');


		$data['headline'] = 'upload image';
        $data['view_module'] = 'blog';
		$data['view_file'] = 'uploade_image';
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
		redirect('blog/create/'.$update_id);
	}elseif($submit=='Yes - delete'){
		$this->_delete($update_id);
       //flash data 
		$flash_msg = 'The Blog Entry  Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
		redirect('blog/manage/');
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
	$data['headline'] = 'Delete Blog Entrys';
      //$data['store_items'] = 'store_items';
	$data['view_file'] = 'deleteconf';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function create(){
	$this->load->library('session');

    $this->load->module('site_security');
    $this->load->module('datemade');

	$this->site_security->_make_sure_is_admin();
// get id
	$update_id = $this->uri->segment(3);
	$submit = $this->input->post('submit', TRUE);
//cansel button
	if($submit == 'Cancel'){
		redirect('blog/manage');
	}
	// insert data in table 
		if($submit == 'Submit'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('date_created', 'Date Created', 'required');
			$this->form_validation->set_rules('blog_title', 'Blog Entry Title', 'required|max_length[250]');
			$this->form_validation->set_rules('author', 'Author', 'required|max_length[65]');
			$this->form_validation->set_rules('blog_content', 'Blog Entry Centent', 'required');
			

			if($this->form_validation->run() == TRUE){
				$data = $this->get_data_from_post();
				$data['blog_url'] = url_title($data['blog_title']); 
				$data['date_created'] = $this->datemade->make_timestamp_from_datepicker_us($data['date_created']); 

				if(is_numeric($update_id)){
					
					$this->_update($update_id, $data);
					
					$flash_msg = 'The Blog Entry Detail Was Successfully Updated';
					$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('blog/create/'.$update_id);
				}else{
					$this->_insert($data);
					$update_id = $this->get_max();
					$flash_msg = 'The Blog Entry  Was Successfully Created';
					$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('blog/manage');
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
			$data['headline'] = 'Add New Blog Entry';
		}else{
			$data['headline'] = 'Update  Blog Entry';
		}
        // load data to module
        if($data['date_created']>0){
        	$data['date_created'] = $this->datemade->get_nice_date($data['date_created'], 'datepicker_us');
        }
		$data['update_id'] = $update_id;
		
		$data['flash'] = $this->session->flashdata('item');
        //$data['blog'] = 'blog';
		$data['view_file'] = 'create';
		$this->load->module('templates');
		$this->templates->admin($data);
	}

function get_data_from_post(){
	$data['blog_title'] = $this->input->post('blog_title', TRUE);
	$data['blog_keyword'] = $this->input->post('blog_keyword', TRUE);
	$data['blog_description'] = $this->input->post('blog_description', TRUE);
	$data['blog_content'] = $this->input->post('blog_content', TRUE);
	$data['date_created'] = $this->input->post('date_created', TRUE);
	$data['author'] = $this->input->post('author', TRUE);
	return $data;
}
function get_data_from_db($update_id){
 //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$data['blog_title'] = $row->blog_title;
		$data['blog_description'] = $row->blog_description;
		$data['blog_keyword'] = $row->blog_keyword;
		$data['blog_content'] = $row->blog_content;
		$data['blog_url'] = $row->blog_url;
		$data['date_created'] = $row->date_created;
		$data['author'] = $row->author;
		$data['picture'] = $row->picture;

	}
	if(!isset($data)){
		$data = '';
	}
	return $data;
}

function manage(){

		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();

		$data['query'] = $this->get('date_created desc');
		$data['flash'] = $this->session->flashdata('item');
		// $data['view_module'] = 'blog';
		$data['update_id'] = $this->uri->segment(3);
		$data['headline'] = 'Centent Management System';
		$data['view_file'] = 'manage';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function get($order_by) {
$this->load->model('mdl_blog');
$query = $this->mdl_blog->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_blog');
$query = $this->mdl_blog->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_blog');
$query = $this->mdl_blog->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_blog');
$query = $this->mdl_blog->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_blog');
$this->mdl_blog->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_blog');
$this->mdl_blog->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_blog');
$this->mdl_blog->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_blog');
$count = $this->mdl_blog->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_blog');
$max_id = $this->mdl_blog->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_blog');
$query = $this->mdl_blog->_custom_query($mysql_query);
return $query;
}

}