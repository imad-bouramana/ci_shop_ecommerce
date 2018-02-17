<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_items extends MX_Controller
{

function __construct() {
	parent::__construct();
	$this->load->library('form_validation');
	$this->form_validation->CI =& $this;
	//$this->form_validation->set_ci_reference( $this ); 
}
function _get_recommand($update_id){
	$data = $this->get_data_from_db($update_id);
	$mark = $data['mark'];
	$mysql_query = "SELECT * FROM store_items WHERE mark = '$mark'";
    $data['query'] = $this->_custom_query($mysql_query);
	$data['num_rows'] = $data['query']->num_rows();	
	$this->load->view('get_recommand',$data);
}
function _get_gallerie_parent_title($update_id){
	$data = $this->get_data_from_db($update_id);
	$item_name = $data['item_title'];
	return $item_name;
}
function _get_item_id_from_item_url($item_url){
	$query = $this->get_where_custom('item_url',$item_url);
	foreach($query->result() as $row){
		$item_id = $row->id;
	}
	if(!isset($item_id)){
		$item_id = 0;
	}
	return $item_id;
}

function view($update_id){
         //redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
         // security form
		$this->load->module('site_sittings');
		$data = $this->get_data_from_db($update_id);

		$gallery_picture = $this->_manage_gallery_pics($update_id);
        $num_rowss = $gallery_picture->num_rows();
        if($num_rowss > 0){
        	$data['angularjs'] = TRUE;
        	
        	$count = 0;
        	foreach ($gallery_picture->result() as $row ) {
        		$picture_count[$count] = base_url().'assets/img/gallery/'.$row->picture;
        		$count++;
        	}
        
        	$data['angular_pics'] = $picture_count;
        	$data['view_file'] = 'view_angular';
        	
        }else{
        	$data['view_file'] = 'view';
        }
        	
        

		$breadcrumbs_data['template'] = 'public_bootstrap';
		$breadcrumbs_data['target_url'] = $data['item_title'];
		$breadcrumbs_data['breadcrumbs_array'] = $this->_get_breadcrumbs_array($update_id);
		$data['breadcrumbs_data'] = $breadcrumbs_data;
        $data['symbole'] = $this->site_sittings->_get_symbol();
		$data['update_id'] = $update_id;
		$data['featherlight_library'] = TRUE;
		$data['flash'] = $this->session->flashdata('item');
        $data['view_module'] = 'store_items';
		
		$this->load->module('templates');
		$this->templates->public_bootstrap($data);
        
	}
function _manage_gallery_pics($update_id){

		$this->load->module('item_galleries');
		$query = $this->item_galleries->get_where_custom('parent_id', $update_id);
		return $query;
	}
	function _get_breadcrumbs_array($update_id){
		$home_url = base_url();
		$breadcrumbs_array[$home_url] = 'Home';
		//get sub_cat_id
		$sub_cat_id = $this->get_sub_cat_id($update_id);
	    //get cat_title
	    $this->load->module('store_categories');
	    $sub_cat_title = $this->store_categories->_get_parent_title($sub_cat_id);
        //get cat url
	    $sub_cat_url = $this->store_categories->get_cat_url($sub_cat_id);

	    $breadcrumbs_array[$sub_cat_url] = $sub_cat_title;
		return $breadcrumbs_array;
	}
	function get_sub_cat_id($update_id){
		if(!isset($_SERVER['HTTP_REFERER'])){
			$refer_url = '';
		}else{
	        $refer_url = $_SERVER['HTTP_REFERER'];
	   }
	    $this->load->module('site_sittings');
	    $this->load->module('store_categories');

	    $cat_segments = $this->site_sittings->_get_items_instruments();
	    $full_cat_url = base_url().$cat_segments;
        $cat_url = str_replace($full_cat_url, '', $refer_url);
	
        $sub_cat_id = $this->store_categories->_get_cat_id_from_cat_url($cat_url);
        if($sub_cat_id > 0){
        	return $sub_cat_id;
        }else{
        	$sub_cat_id = $this->_get_best_sub_cat_id($update_id);
        	return $sub_cat_id;
        }
		
	}
function _get_best_sub_cat_id($update_id){
	   $this->load->module('store_cat_assign');
		$query = $this->store_cat_assign->get_where_custom('item_id',$update_id);
		foreach($query->result() as $row){
			$potensial_sub_cat[] = $row->cat_id;
		}
		$count_sub_cat = count($potensial_sub_cat);
		if($count_sub_cat == 1){
			$sub_cat_id = $potensial_sub_cat['0'];
			return $sub_cat_id;
		}else{
			foreach ($potensial_sub_cat as $key => $value) {
				$sub_cat_id = $value;
				$count_potensial_cat = $this->store_cat_assign->count_where('cat_id', $sub_cat_id);
				$num_items_in_sub[$sub_cat_id] = $count_potensial_cat;
			}
			$sub_cat_id = $this->get_best_sub_cat($num_items_in_sub);
			return $sub_cat_id;
		}
}
function get_best_sub_cat($users_array){
	foreach($users_array as $key => $value){


	if(!isset($key_of_high_value)){
		$key_of_high_value = $key;
	}elseif($value > $users_array[$key_of_high_value]){
		$key_of_high_value = $key;
	}
   }
   return $key_of_high_value;
}
	function _stor_delete_item($update_id){
			//delete coulor item
		$this->load->module('store_item_colours');
		$this->store_item_colours->_delete_item($update_id);
			//delete size item
		$this->load->module('store_item_sizes');
		$this->store_item_sizes->_delete_item($update_id);
			//delete pic item
		$data = $this->get_data_from_db($update_id);
		$big_pic = $data['big_pic']; 
		$small_pic = $data['small_pic']; 
        //get path
		$big_pic_path = './assets/img/big_pic/'.$big_pic;
		$small_pic_path = './assets/img/small_pic/'.$small_pic;

        //unlik imag from 

		if(file_exists($big_pic_path)){
			unlink($big_pic_path);
		}
		if(file_exists($small_pic_path)){
			unlink($small_pic_path);
		}
			//delete  item
		$this->_delete($update_id);

	}
	function delete($update_id){
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
		$submit = $this->input->post('submit', TRUE);
		if($submit=='Cancel'){
			redirect('store_items/create/'.$update_id);
		}elseif($submit=='Yes - delete'){
			$this->_stor_delete_item($update_id);
           //flash data 
			$flash_msg = 'The Item  Was Successfully Deleted';
			$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
			$this->session->set_flashdata('item', $value);

			redirect('store_items/manage/');

		}
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
	function delete_image($update_id){
	//redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
    // security form
		// $this->load->module('site_security');
		// $this->site_security->_make_sure_is_admin();
    // get id

		$data = $this->get_data_from_db($update_id);
		$big_pic = $data['big_pic']; 
		$small_pic = $data['small_pic']; 
        //get path
		$big_pic_path = './assets/img/big_pic/'.$big_pic;
		$small_pic_path = './assets/img/small_pic/'.$small_pic;

        //unlik imag from 

		if(file_exists($big_pic_path)){
			unlink($big_pic_path);
		}
		if(file_exists($small_pic_path)){
			unlink($small_pic_path);
		}
		unset($data);
		$data['big_pic'] = "";
		$data['small_pic'] = "";
		$this->_update($update_id, $data);
        //flash data
		$flash_msg = 'The Item Image Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);

		redirect('store_items/create/'.$update_id);
	}
	function _manage_thumbnail($file_name){
		$config['image_library'] = 'gd2';
		$config['source_image'] = './assets/img/big_pic/'.$file_name;
		$config['new_image'] = './assets/img/small_pic/'.$file_name;

		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width']         = 250;
		$config['height']       = 300;

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
		// $this->load->module('site_security');
		// $this->site_security->_make_sure_is_admin();
		//submit value
		$submit = $this->input->post('submit', TRUE);
    //cansel button
		if($submit == 'Cancel'){
			redirect('store_items/create/'.$update_id);
		}
		//upload
		$config['upload_path']          = './assets/img/big_pic/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 420;
		$config['max_width']            = 2524;
		$config['max_height']           = 1568;

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
			$this->_manage_thumbnail($file_name);
             // insert image into database
			$upddate_data['big_pic'] = $file_name;
			$upddate_data['small_pic'] = $file_name;
			$this->_update($update_id, $upddate_data);
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
        // $this->load->module('site_security');
        // $this->site_security->_make_sure_is_admin();

		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');


		$data['headline'] = 'upload image';
        $data['view_module'] = 'store_items';
		$data['view_file'] = 'uploade_image';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
	function create(){
		$this->load->library('session');
    // security form
		// $this->load->module('site_security');
		// $this->site_security->_make_sure_is_admin();
    // get id
		$update_id = $this->uri->segment(3);
		$submit = $this->input->post('submit', TRUE);
    //cansel button
		if($submit == 'Cancel'){
			redirect('store_items/manage');
		}
	// insert data in table 
		if($submit == 'Submit'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('item_title', 'Item Title', 'required|max_length[150]|callback_item_check');
			$this->form_validation->set_rules('item_price', 'Item Price', 'required|numeric');
			$this->form_validation->set_rules('was_price', 'Was Price', 'numeric');
			$this->form_validation->set_rules('status', 'Status', 'required|numeric');
			//$this->form_validation->set_rules('item_description', 'Item Description', 'required');

			if($this->form_validation->run() == TRUE){
				$data = $this->get_data_from_post();
				$data['item_url'] = url_title($data['item_title']); 
				if(is_numeric($update_id)){
					$this->_update($update_id, $data);
					$flash_msg = 'The Item Detail Was Successfully Updated';
					$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('store_items/create/'.$update_id);
				}else{
					$this->_insert($data);
					$update_id = $this->get_max();
					$flash_msg = 'The Item  Was Successfully Aded';
					$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
					$this->session->set_flashdata('item', $value);
					redirect('store_items/create/'.$update_id);
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
			$data['headline'] = 'Add New Item';
		}else{
			$data['headline'] = 'Update  Item';
		}
   // load data to module
		$data['update_id'] = $update_id;
		$data['gallery_pic'] = $this->_gallery_pic($update_id);
		$data['flash'] = $this->session->flashdata('item');
    //$data['store_items'] = 'store_items';
		$data['view_file'] = 'create';
		$this->load->module('templates');
		$this->templates->admin($data);
	}
function _gallery_pic($update_id){
	$this->load->module('item_galleries');
	$query = $this->item_galleries->get_where_custom('parent_id',$update_id);
	$num_rows = $query->num_rows();
	if($num_rows>0){
		return TRUE;
	}else{
		return FALSE;
	}
}

function manage(){

	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
// get data from database
	$data['query'] = $this->get('item_title');
	$data['flash'] = $this->session->flashdata('item');
// $data['store_items'] = 'store_items';
	// $data['view_module'] = 'store_items';
	$data['headline'] = 'Manage Item';
	$data['view_file'] = 'manage';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function get_data_from_post(){
	$data['item_title'] = $this->input->post('item_title', TRUE);
	$data['item_price'] = $this->input->post('item_price', TRUE);
	$data['waz_price'] = $this->input->post('was_price', TRUE);
	$data['item_description'] = $this->input->post('item_description', TRUE);
	$data['status'] = $this->input->post('status', TRUE);
	$data['mark'] = $this->input->post('mark', TRUE);

	return $data;
}

function _get_item_title($update_id){
	$data = $this->get_data_from_db($update_id);
	$item_title = $data['item_title'];
	return $item_title;
}
function get_data_from_db($update_id){
 //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$data['item_title'] = $row->item_title;
		$data['item_description'] = $row->item_description;
		$data['item_price'] = $row->item_price;
		$data['item_url'] = $row->item_url;
		$data['big_pic'] = $row->big_pic;
		$data['small_pic'] = $row->small_pic;
		$data['waz_price'] = $row->waz_price;
		$data['status'] = $row->status;
		$data['mark'] = $row->mark;

	}
	if(!isset($data)){
		$data = '';
	}
	return $data;
}



function get($order_by) {
	$this->load->model('mdl_store_items');
	$query = $this->mdl_store_items->get($order_by);
	return $query;
}

function get_with_limit($limit, $offset, $order_by) {
	$this->load->model('mdl_store_items');
	$query = $this->mdl_store_items->get_with_limit($limit, $offset, $order_by);
	return $query;
}

function get_where($id) {
	$this->load->model('mdl_store_items');
	$query = $this->mdl_store_items->get_where($id);
	return $query;
}

function get_where_custom($col, $value) {
	$this->load->model('mdl_store_items');
	$query = $this->mdl_store_items->get_where_custom($col, $value);
	return $query;
}

function _insert($data) {
	$this->load->model('mdl_store_items');
	$this->mdl_store_items->_insert($data);
}

function _update($id, $data) {
	$this->load->model('mdl_store_items');
	$this->mdl_store_items->_update($id, $data);
}

function _delete($id) {
	$this->load->model('mdl_store_items');
	$this->mdl_store_items->_delete($id);
}

function count_where($column, $value) {
	$this->load->model('mdl_store_items');
	$count = $this->mdl_store_items->count_where($column, $value);
	return $count;
}

function get_max() {
	$this->load->model('mdl_store_items');
	$max_id = $this->mdl_store_items->get_max();
	return $max_id;
}

function _custom_query($mysql_query) {
	$this->load->model('mdl_store_items');
	$query = $this->mdl_store_items->_custom_query($mysql_query);
	return $query;
}

function item_check($str) {
	$item_url = url_title($str);
	$mysqli_query = "SELECT * FROM store_items WHERE item_title = '$str' AND item_url = '$item_url'";
	$update_id = $this->uri->segment(3);
	if(is_numeric($update_id)){
		$mysqli_query .= "AND id != '$update_id'";
	}
	$query = $this->_custom_query($mysqli_query);
	$num_rows = $query->num_rows();
	if ($num_rows>0){
		$this->form_validation->set_message('item_check', 'The Item Already Exist');
		return FALSE;
	} else {
		return TRUE;
	}
}

}