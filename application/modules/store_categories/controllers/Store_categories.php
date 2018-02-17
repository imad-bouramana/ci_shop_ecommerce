<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_categories extends MX_Controller
{

function __construct() {
parent::__construct();
}
function get_cat_url($update_id){
	$this->load->module('site_sittings');
	$cat_segments = $this->site_sittings->_get_items_instruments();
    $data = $this->get_data_from_db($update_id);
    $cat_url = $data['cat_url'];
    $sub_cat_title = base_url().$cat_segments.$cat_url;
    return $sub_cat_title;
}
function text(){
	$users['sana'] = 120;
	$users['hayat'] = 150;
	$users['dounya'] = 100;
	$users['raja'] = 140;
	$users['fatima'] = 130;
	$users['malika'] = 170;
	$users['rachida'] = 180;


 echo 'hight value is <br>';
 $hight_value = $this->get_hight_value($users);
 echo $hight_value;

}
function get_hight_value($users_array){
	foreach($users_array as $key => $value){


	if(!isset($key_of_high_value)){
		$key_of_high_value = $key;
	}elseif($value > $users_array[$key_of_high_value]){
		$key_of_high_value = $key;
	}
   }
   return $key_of_high_value;
}
function view($update_id){
         //redirect if not allowd
		if(!is_numeric($update_id)){
			redirect('site_security/not_allowed');
		}
		$this->load->library('session');
		$this->load->module('site_sittings');
		$this->load->module('custom_pagination');

     
		// $this->load->module('site_security');
		// $this->site_security->_make_sure_is_admin();
	
		$data = $this->get_data_from_db($update_id);
		//  start page not found
	    $first_bit = trim($this->uri->segment(3));
		$query = $this->get_where_custom('cat_url',$first_bit);
		$num_rows = $query->num_rows();
		if($num_rows<1){
			$this->load->module('site_sittings');
			$data['page_content'] = $this->site_sittings->_get_not_found();
		}
		// end page not found

	    $use_limit = FALSE;

		$mysql_query = $this->_generate_mysql_query($update_id, $use_limit);
		$query  = $this->_custom_query($mysql_query);
		$total_items = $query->num_rows(); 
		
        $use_limit = TRUE;
		$mysql_query = $this->_generate_mysql_query($update_id, $use_limit);

		$pagination_data['template'] = 'public_bootstrap';
        $pagination_data['target_base_url'] = $this->get_target_base_url();
        $pagination_data['total_rows'] = $total_items;
        $pagination_data['offset_segment'] = 4;
     	$pagination_data['limit'] = $this->get_limit();
		

        $pagination_data['offset_segment'] = $this->get_offset();
		$data['statement'] = $this->custom_pagination->get_show_statement($pagination_data);
        $data['query'] = $this->_custom_query($mysql_query);
        $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);
        $data['symbol'] = $this->site_sittings->_get_symbol();
        $data['instrument'] = $this->site_sittings->_get_item_instruments();
		$data['update_id'] = $update_id;
		$data['flash'] = $this->session->flashdata('item');
        $data['view_module'] = 'store_categories';
		$data['view_file'] = 'view';
		$this->load->module('templates');
		$this->templates->public_bootstrap($data);
	}
function _generate_mysql_query($update_id,$use_limit){
     $mysql_query = "SELECT
          store_items.item_title,
          store_items.item_price,
          store_items.small_pic,
          store_items.waz_price,
          store_items.item_url
          FROM
          store_cat_assign
          INNER JOIN store_items ON store_cat_assign.item_id = store_items.id
          WHERE
          store_cat_assign.cat_id = $update_id AND
          store_items.status = 1 ";
          if($use_limit==TRUE){
          	$limit = $this->get_limit();
          	$offset = $this->get_offset();

          	$mysql_query .= " LIMIT ".$offset.", ".$limit;
          }
          return $mysql_query;
}
function get_target_base_url(){
	$first_bit = $this->uri->segment(1);
	$second_bit = $this->uri->segment(2);
	$therd_bit = $this->uri->segment(3);
	$target_base_url = base_url().$first_bit.'/'.$second_bit.'/'.$therd_bit;
	return $target_base_url;

}
function get_limit(){
	$limit = 16;
	return $limit;
}
function get_offset(){
	$offset = $this->uri->segment(4);
	if(!is_numeric($offset)){
		$offset = 0;
	}
	return $offset;
}
function _get_cat_id_from_cat_url($cat_url){
	$query = $this->get_where_custom('cat_url',$cat_url);
	foreach($query->result() as $row){
		$cat_id = $row->id;
	}
	if(!isset($cat_id)){
		$cat_id = 0;
	}
	return $cat_id;
}

function _draw_cat_title(){
		$mysql_query = "SELECT * FROM store_categories WHERE parent_cat_id = 0 ORDER BY priority";
		$query = $this->_custom_query($mysql_query);
		foreach($query->result() as $row){
			$parent_tilte[$row->id] = $row->cat_title;
		}
		$this->load->module('site_sittings');
		$segment = $this->site_sittings->_get_items_instruments();
		$data['start_url'] = base_url().$segment;
		$data['parent_title'] = $parent_tilte;
		$this->load->view('draw_cat_title', $data);
}
function _get_parent_cat_title($item_id){

	$data = $this->get_data_from_db($item_id);
	$parent_cat_id = $data['parent_cat_id'];
	$parent_title = $this->_get_parent_title($parent_cat_id);
	return $parent_title;
}
function _get_sub_cat_from_drpdown(){
	$mysql_query = "SELECT * FROM store_categories WHERE parent_cat_id != 0 ORDER BY parent_cat_id, cat_title";
	$query = $this->_custom_query($mysql_query);
	foreach($query->result() as $row){
		$parent_tilte = $this->_get_parent_title($row->parent_cat_id);
		$sub_category[$row->id] = $parent_tilte.' > '.$row->cat_title;
	}
	return $sub_category;
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
function _draw_sortable_list($parent_cat_id){
	$mysql_query = "SELECT * FROM store_categories WHERE parent_cat_id = '$parent_cat_id' ORDER BY priority";
	$data['query'] = $this->_custom_query($mysql_query);
	$this->load->view('sortable_list', $data);
}
function _get_count_cat($parent_cat_id){
	$query = $this->get_where_custom('parent_cat_id',$parent_cat_id);
	$count_parent = $query->num_rows();
	return $count_parent;
}
function _get_parent_title($update_id){
	$data = $this->get_data_from_db($update_id);
	$parent_tilte = $data['cat_title'];
	return $parent_tilte;
}
function _get_dropdawn_parent($update_id){
	if(!is_numeric($update_id)){
		$update_id = 0;
	}
	$options[''] = 'Please Select...';
	$mysql_query = "SELECT * FROM store_categories WHERE parent_cat_id = 0 AND id !='$update_id'";
	$query = $this->_custom_query($mysql_query);
	foreach ($query->result() as $row) {
		$options[$row->id] = $row->cat_title;
	}
	return $options;
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
		redirect('store_categories/manage');
	}
	  // insert data in table 
	if($submit == 'Submit'){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cat_title', 'Category Title', 'required|max_length[250]');

		if($this->form_validation->run() == TRUE){
			$data = $this->get_data_from_post();
			$data['cat_url'] = url_title($data['cat_title']);
		
			if(is_numeric($update_id)){
				$this->_update($update_id, $data);
				$flash_msg = 'The Category Detail Was Successfully Updated';
				$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
				redirect('store_categories/create/'.$update_id);
			}else{
				$this->_insert($data);
				$update_id = $this->get_max();
				$flash_msg = 'The Category  Was Successfully Aded';
				$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
				redirect('store_categories/create/'.$update_id);
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
			$data['headline'] = 'Add New Category';
		}else{
			$data['headline'] = 'Update  Category';
		}
              // load data to module
		$data['update_id'] = $update_id;
		
		$data['flash'] = $this->session->flashdata('item');
            //$data['store_items'] = 'store_items';
		$data['options'] = $this->_get_dropdawn_parent($update_id); 
		$data['num_parent_cat'] = count($data['options']);
		$data['view_file'] = 'create';
		$this->load->module('templates');
		$this->templates->admin($data);
	}


function manage(){

	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
    // get data from database
    $parent_cat_id = $this->uri->segment(3);
    if(!is_numeric($parent_cat_id)){
    	$parent_cat_id = 0;
    }
	$data['query'] = $this->get_where_custom('parent_cat_id',$parent_cat_id);
	$data['flash'] = $this->session->flashdata('item');
    $data['sortable'] = TRUE;
    $data['parent_cat_id'] = $parent_cat_id;
	$data['headline'] = 'Manage Category';
	$data['view_file'] = 'manage';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function get_data_from_post(){
	$data['cat_title'] = $this->input->post('cat_title', TRUE);
	$data['parent_cat_id'] = $this->input->post('parent_cat_id', TRUE);
	return $data;
}
function get_data_from_db($update_id){
 //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$data['cat_title'] = $row->cat_title;
		$data['cat_url'] = $row->cat_url;
		$data['parent_cat_id'] = $row->parent_cat_id;
	}
	if(!isset($data)){
		$data = '';
	}
	return $data;
}


function get($order_by) {
$this->load->model('mdl_store_categories');
$query = $this->mdl_store_categories->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_store_categories');
$query = $this->mdl_store_categories->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_store_categories');
$query = $this->mdl_store_categories->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_store_categories');
$query = $this->mdl_store_categories->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_store_categories');
$this->mdl_store_categories->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_store_categories');
$this->mdl_store_categories->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_store_categories');
$this->mdl_store_categories->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_store_categories');
$count = $this->mdl_store_categories->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_store_categories');
$max_id = $this->mdl_store_categories->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_store_categories');
$query = $this->mdl_store_categories->_custom_query($mysql_query);
return $query;
}

}