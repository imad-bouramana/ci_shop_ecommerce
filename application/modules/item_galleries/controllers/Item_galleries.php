<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Item_galleries extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _get_parent_title($parent_id){
	$this->load->module('store_items');
	$parent_title = $this->store_items->_get_gallerie_parent_title($parent_id);
	return $parent_title;
}
function _get_type_sliders_name($type){
	if($type == 'plural'){
		$slider_name = 'pictures';
	}else{
		$slider_name = 'picture';
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

		$data['headline'] = 'Update Galleries';
		$data['sub_headline'] = $this->_generate_slider_name($parent_id);
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
    $data['form_location'] = base_url().'item_galleries/submit_create';
	$this->load->view('create_modal', $data);
}
function submit_create(){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	$data['parent_id'] = $this->input->post('parent_id', TRUE);
	$this->_insert($data);
	$max_id = $this->get_max();
	redirect('item_galleries/view/'.$max_id);
     
}

function get_data_from_post(){
	  
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
		$data['btn_info'] = "The pictue thas has used for this galleries is blow here.";
		$data['pic_path'] = base_url().'assets/img/gallery/'.$picture;
	}
	$this->load->view('img_btn', $data);
}
function upload_image($parent_id){
	//redirect if not allowd
		if(!is_numeric($parent_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
    // security form
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
    // get id

		$data['parent_id'] = $parent_id;
		$data['flash'] = $this->session->flashdata('item');

	 // submit handler

		$data['headline'] = 'upload image';
    //$data['stor_items'] = 'stor_items';
		$data['view_file'] = 'upload_image';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function do_upload($parent_id){
		//redirect if not allowd
		if(!is_numeric($parent_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
		$this->load->module('site_security');
		$this->site_security->_make_sure_is_admin();
		//submit value
		$submit = $this->input->post('submit', TRUE);
    //cansel button
		if($submit == 'Cancel'){
	
			redirect('item_galleries/update_group/'.$parent_id);
		}
		//upload
		$config['upload_path']          = './assets/img/gallery/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 3000;
		$config['max_width']            = 2024;
		$config['max_height']           = 1568;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile'))
		{
			$data['error'] = array('error' => $this->upload->display_errors());
       
			//$this->load->view('upload_form', $error)
			$data['parent_id'] = $parent_id;
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
	       unset($data);
             // insert image into database
	       $data['parent_id'] = $parent_id;
			$data['picture'] = $file_name;
            $this->_insert($data);
			//get id 
			
		    $data['flash'] = $this->session->flashdata('item');

		    redirect('item_galleries/update_group/'.$parent_id);
		}
	}
function submit($update_id){
	$submit = $this->input->post('submit', TRUE);
	if($submit == 'Cancel'){
		$parent_id = $this->_get_parent_id($update_id);
		redirect('item_galleries/update_group/'.$parent_id);
	}elseif($submit == 'Submit'){
		$this->_update($update_id, $data);
		$flash_msg = 'The Slide Details Was Successfully Updated';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
		redirect('item_galleries/view/'.$update_id);
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
			redirect('item_galleries/view/'.$update_id);
		}elseif($submit=='Yes - delete'){
			$parent_id = $this->_get_parent_id($update_id);
           $this->_stor_delete_item($update_id);
           //flash data 
           $flash_msg = 'The Picture  Was Successfully Deleted';
		   $value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		   $this->session->set_flashdata('item', $value);
				
	       redirect('item_galleries/update_group/'.$parent_id);
	
		}
	}
function _stor_delete_item($update_id){
			//delete coulor item
       
        $data = $this->get_data_from_db($update_id);
		$picture = $data['picture']; 
	
        //get path
        $picture_path = './assets/img/gallery/'.$picture;
        //unlik imag from 
         if(file_exists($picture_path)){
        	unlink($picture_path);
        }
			//delete  item
        $this->_delete($update_id);
	}
function get($order_by) {
$this->load->model('mdl_item_galleries');
$query = $this->mdl_item_galleries->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_item_galleries');
$query = $this->mdl_item_galleries->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_item_galleries');
$query = $this->mdl_item_galleries->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_item_galleries');
$query = $this->mdl_item_galleries->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_item_galleries');
$this->mdl_item_galleries->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_item_galleries');
$this->mdl_item_galleries->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_item_galleries');
$this->mdl_item_galleries->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_item_galleries');
$count = $this->mdl_item_galleries->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_item_galleries');
$max_id = $this->mdl_item_galleries->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_item_galleries');
$query = $this->mdl_item_galleries->_custom_query($mysql_query);
return $query;
}

}