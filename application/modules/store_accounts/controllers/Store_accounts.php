<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Store_accounts extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _get_customer_adress($update_id, $delemtere){
   $data = $this->get_data_from_db($update_id);
   $adress = '';
   if($data['adress1'] != ''){
      $adress .= $data['adress1'];
      $adress .= $delemtere;
   }
   if($data['adress2'] != ''){
      $adress .= $data['adress2'];
      $adress .= $delemtere;
   }
   if($data['town'] != ''){
      $adress .= $data['town'];
      $adress .= $delemtere;
   }
   if($data['country'] != ''){
      $adress .= $data['country'];
      $adress .= $delemtere;
   }
   if($data['postecode'] != ''){
      $adress .= $data['postecode'];
      $adress .= $delemtere;
   }
   return $adress;
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
		redirect('store_accounts/create/'.$update_id);
	}elseif($submit=='Yes - delete'){
		$allowd_delete = $this->_make_sure_is_allowed($update_id);
		if($allowd_delete==FALSE){
			$flash_msg = 'You Cant Delete This Account';
		    $value = '<div class="alert alert-danger">'.$flash_msg.'</div>';
		    $this->session->set_flashdata('item', $value);
		    redirect('store_accounts/manage/');
		}
		$this->_delete($update_id);
       //flash data 
		$flash_msg = 'The Account Was Successfully Deleted';
		$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
		$this->session->set_flashdata('item', $value);
		redirect('store_accounts/manage/');
	}
}
function _make_sure_is_allowed($update_id){
	$mysql_query = "SELECT * FROM store_basket WHERE shopper_id = $update_id";
	$query = $this->_custom_query($mysql_query);
	$num_rows = $query->num_rows();
	if($num_rows>0){
		return FALSE;
	}else{
		$mysql_query = "SELECT * FROM store_shopertrack WHERE shopper_id = $update_id";
	    $query = $this->_custom_query($mysql_query);
	    $num_rows = $query->num_rows();
	    if($num_rows>0){
	    	return FALSE;
	    }
	}
	return TRUE;
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
	$data['headline'] = 'Delete Account';
      //$data['store_items'] = 'store_items';
	$data['view_file'] = 'deleteconf';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function _get_token_from_post($update_id){
	$data = $this->get_data_from_db($update_id);
	$date_made = $data['date_create'];
	$last_login = $data['last_login'];
	$password = $data['password'];

	$pass_lenght = strlen($password);
	$pass_start = $pass_lenght-6;
	$last_sex_chars = substr($password, $pass_start, 6);

	if(($pass_lenght>5) AND ($last_login > 0)){
		$token = $last_sex_chars.$date_made.$last_login;
	}else{
		$token = '';
	}
	return $token;

}
function _get_customer_id_from_token($token){
   $last_sex_chars = substr($token, 0, 6);
   $date_made = substr($token, 6, 10);
   $last_login = substr($token, 16, 10);

   $sql = "SELECT * FROM store_accounts WHERE date_create = ? AND password LIKE ? AND last_login = ?";
   $query = $this->db->query($sql, array($date_made, '%'.$last_sex_chars, $last_login));
   foreach($query->result() as $row){
   	$customer_id = $row->id;
   }
   if(!isset($customer_id)){
   	$customer_id = 0;
   }
   return $customer_id;
}
function _get_customer_name($update_id){
	$data = $this->get_data_from_db($update_id);
	if($data==""){
		$customer_name = 'Uknown';
	}else{
		$firstname = trim($data['firstname']);
		$lastname = trim($data['lastname']);
		$company = trim($data['company']);
		
		$company_length = strlen($company);
		if($company_length>2){
			$customer_name = $company;
		}else{
	        $customer_name = $firstname.' '.$lastname;
		}
	}
	return $customer_name;
}
function update_password(){
	$this->load->library('session');

    $this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();

	$update_id = $this->uri->segment(3);
	$submit = $this->input->post('submit', TRUE);
     //cansel button
	if(!is_numeric($update_id)){
		redirect('store_accounts/create');
	}elseif($submit == 'Cancel'){
		redirect('store_accounts/manage');
	}
     // insert data in table 
	if($submit == 'Submit'){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'PASSWORD', 'required|max_length[35]|min_length[3]');
		$this->form_validation->set_rules('repeate_password', 'REPEATE PASSWORD', 'required|matches[password]');

		
		if($this->form_validation->run() == TRUE){
			$password = $this->input->post('password', TRUE);
			$data['password'] = $this->site_security->_hasshin_password($password);
			$this->_update($update_id, $data);
			$flash_msg = 'The Account password Detail Was Successfully Updated';
			$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
			$this->session->set_flashdata('item', $value);
			redirect('store_accounts/create/'.$update_id);
			
		}
	}
   
	
     // create headline 

	$data['headline'] = 'Update Password Account';

	$data['update_id'] = $update_id;
	
	$data['flash'] = $this->session->flashdata('item');
    //$data['store_items'] = 'store_items';
	$data['view_file'] = 'update_password';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function create(){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	$this->load->library('session');

	$update_id = $this->uri->segment(3);
	$submit = $this->input->post('submit', TRUE);
     //cansel button
	if($submit == 'Cancel'){
		redirect('store_accounts/manage');
	}
     // insert data in table 
	if($submit == 'Submit'){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('firstname', 'Firstname', 'required');
		
		if($this->form_validation->run() == TRUE){
			$data = $this->get_data_from_post();

			if(is_numeric($update_id)){
			
				$this->_update($update_id, $data);
				$flash_msg = 'The Account Detail Was Successfully Updated';
				$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
				redirect('store_accounts/create/'.$update_id);
			}else{
				$data['date_create'] = time();
				$this->_insert($data);
				$update_id = $this->get_max();
				$flash_msg = 'The Account  Was Successfully Aded';
				$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
				redirect('store_accounts/create/'.$update_id);
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
		$data['headline'] = 'Add New Account';
	}else{
		$data['headline'] = 'Update  Account';
	}
    // load data to module
	$data['update_id'] = $update_id;
	
	$data['flash'] = $this->session->flashdata('item');
    //$data['store_items'] = 'store_items';
	$data['view_file'] = 'create';
	$this->load->module('templates');
	$this->templates->admin($data);
}


function get_data_from_post(){
	$data['username'] = $this->input->post('username', TRUE);
	$data['firstname'] = $this->input->post('firstname', TRUE);
	$data['lastname'] = $this->input->post('lastname', TRUE);
	$data['email'] = $this->input->post('email', TRUE);
	$data['company'] = $this->input->post('company', TRUE);
	$data['adress1'] = $this->input->post('adress1', TRUE);
	$data['adress2'] = $this->input->post('adress2', TRUE);
	$data['town'] = $this->input->post('town', TRUE);
	$data['country'] = $this->input->post('country', TRUE);
	$data['postecode'] = $this->input->post('postecode', TRUE);
	$data['telephone'] = $this->input->post('telephone', TRUE);
	return $data;
}
function get_data_from_db($update_id){
 //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$data['username'] = $row->username;
		$data['firstname'] = $row->firstname;
		$data['lastname'] = $row->lastname;
		$data['email'] = $row->email;
		$data['company'] = $row->company;
		$data['adress1'] = $row->adress1;
		$data['adress2'] = $row->adress2;
		$data['town'] = $row->town;
		$data['country'] = $row->country;
		$data['postecode'] = $row->postecode;
		$data['date_create'] = $row->date_create;
		$data['telephone'] = $row->telephone;
		$data['password'] = $row->password;

		$data['last_login'] = $row->last_login;
	}
	if(!isset($data)){
		$data = '';
	}
	return $data;
}


function manage(){

	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	$data['query'] = $this->get('lastname');
	$data['flash'] = $this->session->flashdata('item');


	$data['headline'] = 'Manage Acounts';
	$data['view_file'] = 'manage';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function get($order_by) {
$this->load->model('mdl_store_accounts');
$query = $this->mdl_store_accounts->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_store_accounts');
$query = $this->mdl_store_accounts->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_store_accounts');
$query = $this->mdl_store_accounts->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_store_accounts');
$query = $this->mdl_store_accounts->get_where_custom($col, $value);
return $query;
}
function get_whith_double_condition($col1, $value1,$col2, $value2) {
$this->load->model('mdl_store_accounts');
$query = $this->mdl_store_accounts->get_whith_double_condition($col1, $value1,$col2, $value2);
return $query;
}

function _insert($data) {
$this->load->model('mdl_store_accounts');
$this->mdl_store_accounts->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_store_accounts');
$this->mdl_store_accounts->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_store_accounts');
$this->mdl_store_accounts->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_store_accounts');
$count = $this->mdl_store_accounts->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_store_accounts');
$max_id = $this->mdl_store_accounts->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_store_accounts');
$query = $this->mdl_store_accounts->_custom_query($mysql_query);
return $query;
}

}
function autogene(){
	$mysql_query = "SHOW COLUMNS FROM store_accounts";
    $query = $this->_custom_query($mysql_query);
    foreach ($query->result() as $row) {
    	$colume_name = $row->Field;
    	echo '$data[\''.$colume_name.'\'] = $this->input->post(\''.$colume_name.'\', TRUE)'.'<br>';
    }
     foreach ($query->result() as $row) {
    	$colume_name = $row->Field;
    	echo '$data[\''.$colume_name.'\'] = $row->'.$colume_name.';<br>';
  
    }
}