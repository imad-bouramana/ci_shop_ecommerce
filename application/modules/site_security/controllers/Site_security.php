<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Site_security extends MX_Controller
{

function __construct() {
parent::__construct();
}
function test(){
	echo phpinfo();
}
function _get_admin_details($username,$password){
	$admin_username = 'bouraimad';
	$admin_password = '123456';
	if(($admin_username==$username) && ($admin_password==$password)){
		return TRUE;
	}else{
		return FALSE;
	}

}
function _get_coukies_name(){
	$coukies_name = "abcdefjhik";
	return $coukies_name;
}
function _get_admin_datail($userename, $password){
     $admin_userename = 'admin';
     $admin_password = 'bouraimad';
     if(($userename == $admin_userename ) && ($password == $admin_password)){
     	return TRUE;
     }else{
     	return FALSE;
     }
}
function _make_sure_is_login(){
	$user_id = $this->_get_user_id();
	if(!is_numeric($user_id)){
		redirect('your_account/login');
	}
}
function _get_user_id(){
	$user_id = $this->session->userdata('user_id');
	if(!is_numeric($user_id)){
		$this->load->module('site_coukies');
		$user_id = $this->site_coukies->_get_user_from_coukies();
	}
	return $user_id;
}
function generate_random_string($length) {
	$characters = '23456789abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomstring = "";
	for($i =0 ;$i < $length; $i++){
		$randomstring .= $characters[rand(0,strlen($characters) - 1)];
	}
	return $randomstring;
}
function _hasshin_password($str){
	$hash = password_hash($str, PASSWORD_BCRYPT, array('cost' => 11));
	return $hash;
}
function _confirm_password($confirm_password, $hash){
    $password_confirm = password_verify($confirm_password, $hash);
    return $password_confirm;
}
function _encrypted_string($str){
	$this->load->library('encryption');
	$encryptend_string = $this->encryption->encrypt($str);
	return $encryptend_string;
}
function _decrypted_string($str){
	$this->load->library('encryption');
	$decryptend_string = $this->encryption->decrypt($str);
	return $decryptend_string;
}
function _make_sure_is_admin(){
  
    $is_admin = $this->session->userdata('is_admin');
    
   if($is_admin == 1){
   	 return TRUE;
   }else{
   	 redirect ('site_security/not_allowed');
   }
   
}
function not_allowed(){
	echo 'You Cant Be Here Now';
}


}