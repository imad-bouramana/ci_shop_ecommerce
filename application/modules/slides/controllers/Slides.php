<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Slides extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _get_parent_title($parent_id){
	$this->load->module('sliders');
	$parent_title = $this->sliders->_get_slider_title($parent_id);
	return $parent_title;
}
function _get_type_sliders_name($type){
	if($type == 'plural'){
		$slider_name = 'slides';
	}else{
		$slider_name = 'slide';
	}
	$slider_name = ucfirst($slider_name);
	return $slider_name;
}
function _generate_slider_name($parent_id){
	$slider_title = ucfirst($this->_get_parent_title($parent_id));
	$sliders_on_type = ucfirst($this->_get_type_sliders_name('plural'));
	$title_of_sliders = ' Update '.$sliders_on_type.' Of '.$slider_title;
	return $title_of_sliders; 
}
function update_group($parent_id){

		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
	// get data from database
		$data['query'] = $this->get_where_custom('parent_id', $parent_id);
		$data['num_rows'] = $data['query']->num_rows();
		$data['flash'] = $this->session->flashdata('item');
		$data['headline'] = $this->_generate_slider_name($parent_id);
   // $data['stor_items'] = 'stor_items';
		$data['parent_id'] = $parent_id;
		$data['slider_title'] = $this->_get_parent_title($parent_id);
		$data['entity'] =  $this->_get_type_sliders_name('plural');
		$data['view_file'] = 'update_group';
		$this->load->module('templates');
		$this->templates->admin($data);
	
}
function _draw_modal($parent_id){
	$data['update_id'] = $parent_id;
    $data['form_location'] = base_url().'slides/submit_create';
	$this->load->view('create_modal', $data);
}
function submit_create(){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	$data['target_url'] = $this->input->post('target_url', TRUE);
	$data['img_text'] = $this->input->post('img_text', TRUE);
	$data['parent_id'] = $this->input->post('parent_id', TRUE);
	$this->_insert($data);
	$max_id = $this->get_max();
	redirect('slides/view/'.$max_id);
     
}
function view($update_id){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();


	$this->load->library('session');
    
	$update_id = $this->uri->segment(3);
	$submit = $this->input->post('submit', TRUE);
    //cansel button
	if($submit == 'Cancel'){
		redirect('slides/update_group/'.$update_id);
	}
    // insert data in table 
	if($submit == 'Submit'){}
		
    // submit handler
	if($submit != 'Submit'){
		$data = $this->get_data_from_db($update_id);
	}else{
		$data = $this->get_data_from_post();
		$data['picture'] = "";
	}

		
    $entity_name = ucfirst($this->_get_type_sliders_name('sungular'));
	$data['headline'] = 'Update '.$entity_name;

		 // load data to module
	$data['update_id'] = $update_id;
	$data['flash'] = $this->session->flashdata('item');
		//$data['stor_items'] = 'stor_items';
	$data['view_file'] = 'view';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function get_data_from_post(){
	    $data['target_url'] = $this->input->post('target_url', TRUE);
		$data['img_text'] = $this->input->post('img_text', TRUE);
		$data['parent_id'] = $this->input->post('parent_id', TRUE);
		return $data;
}
function get_data_from_db($update_id){
     //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$data['target_url'] = $row->target_url;
		$data['img_text'] = $row->img_text;
		$data['parent_id'] = $row->parent_id;
		$data['picture'] = $row->picture;
	}
	if(!isset($data)){
		$data = '';
	}
	return $data;
}
function _get_parent_id($update_id){
	$data = $this->get_data_from_db($update_id);
	$parent_id = $data['parent_id'];
	return $parent_id;
}
function _draw_img_btn($update_id){
	$data = $this->get_data_from_db($update_id);
	$picture = $data['picture'];
	if($picture == ''){
		$data['got_pic'] = FALSE;
		$data['btn_style'] = '';
		$data['btn_info'] = "no picture has been uploaded Here.";
	}else{
		$data['got_pic'] = TRUE;
		$data['btn_style'] = ' style="clear: both; margin-top: 24px"';
		$data['btn_info'] = "The pictue thas has used for this slide is blow here.";
		$data['pic_path'] = base_url().'assets/img/carouse/'.$picture;
	}
	$this->load->view('img_btn', $data);
}
function upload_image($update_id){
	//redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
    // security form
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
    // get id

		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');

	 // submit handler

		$data['headline'] = 'upload image';
    //$data['stor_items'] = 'stor_items';
		$data['view_file'] = 'upload_image';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function do_upload($update_id){
		//redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
		//submit value
		$submit = $this->input->post('submit', TRUE);
    //cansel button
		if($submit == 'Cancel'){
			$parent_id = $this->_get_parent_id($update_id);
			redirect('slides/update_group/'.$parent_id);
		}
		//upload
		$config['upload_path']          = './assets/img/carouse/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 3000;
		$config['max_width']            = 2024;
		$config['max_height']           = 968;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile'))
		{
			$data['error'] = array('error' => $this->upload->display_errors());
       
			//$this->load->view('upload_form', $error)
			$data['update_id'] = $update_id;
		    $data['flash'] = $this->session->flashdata('item');

			$data['headline'] = 'upload image';
          //$data['stor_items'] = 'stor_items';
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
	
             // insert image into database
			$upddate_data['picture'] = $file_name;
            $this->_update($update_id, $upddate_data);
			//get id 
			$data['update_id'] = $update_id;
		    $data['flash'] = $this->session->flashdata('item');

		    redirect('slides/view/'.$update_id);
		}
	}
function submit($update_id){
	$submit = $this->input->post('submit', TRUE);
	$target_url = $this->input->post('target_url', TRUE);
	$img_text = $this->input->post('img_text', TRUE);
	if($submit == 'Cancel'){
		$parent_id = $this->_get_parent_id($update_id);
		redirect('slides/update_group/'.$parent_id);
	}elseif($submit == 'Submit'){
		$data['target_url'] = $target_url;
		$data['img_text'] = $img_text;
		$this->_update($update_id, $data);
		$flash_msg = 'The Slide Details Was Successfully Updated';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
		redirect('slides/view/'.$update_id);
	}

}
function deleteconf($update_id){
         //redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
		//$this->load->view('upload_form', $error)
        $data['update_id'] = $update_id;
        $data['flash'] = $this->session->flashdata('item');


		$entity_name = ucfirst($this->_get_type_sliders_name('sungular'));
	    $data['headline'] = 'Delete '.$entity_name;
          //$data['stor_items'] = 'stor_items';
		$data['view_file'] = 'deleteconf';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
	function delete($update_id){
	     //redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}

         // security form
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
		//$this->load->view('upload_form', $error)
		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');
		$submit = $this->input->post('submit', TRUE);
		if($submit=='Cancel'){
			redirect('slides/view/'.$update_id);
		}elseif($submit=='Yes - delete'){
			$parent_id = $this->_get_parent_id($update_id);
           $this->_stor_delete_item($update_id);
           //flash data 
           $flash_msg = 'The Picture  Was Successfully Deleted';
		   $value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		   $this->session->set_flashdata('item', $value);
				
	       redirect('slides/update_group/'.$parent_id);
	
		}
	}
function _stor_delete_item($update_id){
			//delete coulor item
       
        $data = $this->get_data_from_db($update_id);
		$picture = $data['picture']; 
	
        //get path
        $picture_path = './assets/img/carouse/'.$picture;
        //unlik imag from 
         if(file_exists($picture_path)){
        	unlink($picture_path);
        }
			//delete  item
        $this->_delete($update_id);
	}
function get($order_by) {
$this->load->model('mdl_slides');
$query = $this->mdl_slides->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_slides');
$query = $this->mdl_slides->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_slides');
$query = $this->mdl_slides->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_slides');
$query = $this->mdl_slides->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_slides');
$this->mdl_slides->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_slides');
$this->mdl_slides->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_slides');
$this->mdl_slides->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_slides');
$count = $this->mdl_slides->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_slides');
$max_id = $this->mdl_slides->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_slides');
$query = $this->mdl_slides->_custom_query($mysql_query);
return $query;
}

}