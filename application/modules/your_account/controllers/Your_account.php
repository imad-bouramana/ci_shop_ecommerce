<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Your_account extends MX_Controller
{

function __construct() {
parent::__construct();
$this->load->library('form_validation');
$this->form_validation->CI =& $this;
}
function test(){
	$this->load->module('site_security');
	$name = "imad";
	$hashed_name = $this->site_security->_hasshin_password($name);
	echo "name is $hashed_name".'<br>';
	$hashed_length = strlen($hashed_name);
	echo "$hashed_length".'<br>';
	$start_hash = $hashed_length-53;
	echo "$start_hash".'<br>';
	$last_char = substr($hashed_name, $start_hash, 6);
	echo $last_char;
	}
function logout(){
	unset($_SESSION['user_id']);
	$this->load->module('site_coukies');
	$this->site_coukies->_destroy_coukie();
	redirect(base_url());
}
function welcome(){

    $this->load->module('site_security');
    $this->site_security->_make_sure_is_login();
	$data['flash'] = $this->session->flashdata('item');
    $data['headline'] = 'Create Account';
	$data['view_file'] = 'welcome';
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);
}

function Login(){
	$data['username'] = $this->input->post('username', TRUE);
	$this->load->module('templates');
	$this->templates->login($data);
}
function submit_login(){
	$submit = $this->input->post('submit', TRUE);

     // insert data in table 
	if($submit == 'Submit'){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[35]|min_length[3]|callback_username_check');
		
		$this->form_validation->set_rules('password', 'PASSWORD', 'required|max_length[35]|min_length[3]');
		
		if($this->form_validation->run() == TRUE){

		    $col1 = 'username';
		    $value1 = $this->input->post('username', TRUE);
		    $col2 = 'email';
		    $value2 = $this->input->post('username', TRUE);

			$query =  $this->store_accounts->get_whith_double_condition($col1, $value1,$col2, $value2);
			foreach ($query->result() as $row) {
				$user_id = $row->id;
			}
			$remember = $this->input->post('remember',TRUE);
			if($remember=="remember-me"){
				$login_type = "long_term";
			}else{
				$login_type = "short_type";
			}
			$this->load->module('store_accounts');
			$data['last_login'] = time();
			$this->store_accounts->_update($user_id,$data);
			$this->in_you_go($user_id,$login_type);
			

		}else{
			echo validation_errors();
		}
	}
}
function in_you_go($user_id,$login_type){
	$this->load->module("site_coukies");
	if($login_type=="long_term"){
		//set coukies
		$this->site_coukies->_set_coukies($user_id);
	}else{
		//set session
	   $this->session->set_userdata('user_id',$user_id);
	}
	$this->_update_user_id($user_id);
    redirect('your_account/welcome');
}
function _update_user_id($user_id){
	$this->load->module('store_basket');
	$customer_session_id = $this->session->session_id;
	$col1 = 'session_id';
	$value1 = $customer_session_id;
	$col2 = 'shopper_id';
	$value2 = 0;
	$query = $this->store_basket->get_whith_double_condition($col1, $value1,$col2, $value2);
	$num_rows = $query->num_rows();
	if($num_rows>0){
		$mysql_query = "UPDATE store_basket SET shopper_id = $user_id WHERE session_id = '$customer_session_id'";
		$query = $this->store_basket->_custom_query($mysql_query);
		redirect('cart');
	}
}
function submit(){
	$submit = $this->input->post('submit', TRUE);

     // insert data in table 
	if($submit == 'Submit'){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[35]|min_length[3]');
		$this->form_validation->set_rules('email', 'Email', 'required|max_length[35]|min_length[3]|valid_email');
		$this->form_validation->set_rules('password', 'PASSWORD', 'required|max_length[35]|min_length[3]');
		$this->form_validation->set_rules('confirm_password', 'REPEATE PASSWORD', 'required|matches[password]');
		
		if($this->form_validation->run() == TRUE){
			$data = $this->get_data_from_post();
		    $this->_proccess_account();
          redirect('Your_account/welcome');
		}else{
			$this->start();
		}
	}
}

function _proccess_account(){
	$this->load->module('store_accounts');
	$this->load->module('site_security');

	$data = $this->get_data_from_post();
	unset($data['confirm_password']);
	$password = $data['password'];
	$data['password'] = $this->site_security->_hasshin_password($password);
	$this->store_accounts->_insert($data);
		
}
function start(){

	$data = $this->get_data_from_post();
	$data['flash'] = $this->session->flashdata('item');
    $data['headline'] = 'Create Account';
	$data['view_file'] = 'start';
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);
}
function get_data_from_post(){
	$data['username'] = $this->input->post('username', TRUE);
	$data['firstname'] = $this->input->post('firstname', TRUE);
	$data['email'] = $this->input->post('email', TRUE);
	$data['password'] = $this->input->post('password', TRUE);	
	$data['confirm_password'] = $this->input->post('confirm_password', TRUE);	

	return $data;
}
function username_check($str) {
    $this->load->module('store_accounts');
    $this->load->module('site_security');

    $msg_error = 'Your Username Or Email Is Not Correct';
    $col1 = 'username';
    $value1 = $str;
    $col2 = 'email';
    $value2 = $str;

	$query =  $this->store_accounts->get_whith_double_condition($col1, $value1,$col2, $value2);
	$num_rows = $query->num_rows();
	if($num_rows<1){
		$this->form_validation->set_message('username_check', $msg_error);
		return FALSE;
     }
	foreach ($query->result() as $row) {
		$password_in_table = $row->password;
	}
	$password = $this->input->post('password', TRUE);
	$result = $this->site_security->_confirm_password($password, $password_in_table);
	if($result ==TRUE){
		return TRUE;
	}else{
		$this->form_validation->set_message('username_check', $msg_error);
		return FALSE;
	}

	
}

}