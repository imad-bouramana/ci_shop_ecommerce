<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Bouraimad extends MX_Controller
{

function __construct() {
parent::__construct();
$this->load->library('form_validation');
$this->form_validation->CI =& $this;
}

function index(){
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
        $this->in_you_go();
		   
		}else{
			echo validation_errors();
		}
	}
}
function in_you_go(){
		//set session
	$this->session->set_userdata('is_admin','1');
	redirect('dashboard/home');
}
function logout(){
	unset($_SESSION['is_admin']);
	redirect(base_url());
}
function username_check($str) {
   
    $this->load->module('site_security');
    $msg_error = 'Your Username Or Password Is Not Correct';
    $password = $this->input->post('password', TRUE);
    $result = $this->site_security->_get_admin_details($str,$password);
	if($result==FALSE){
		$this->form_validation->set_message('username_check', $msg_error);
		return FALSE;
     }else{
     	return TRUE;
     }
	
}
}