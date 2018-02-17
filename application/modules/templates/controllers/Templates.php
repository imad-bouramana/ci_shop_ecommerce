<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Templates extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _draw_top_nav(){
	$this->load->module('site_security');
	$shopper_id = $this->site_security->_get_user_id();
	
    $this->_draw_top_midle($shopper_id);
    // $this->_draw_top_right($shopper_id);

}	

function _draw_top_midle($shopper_id ){
	
	if((is_numeric($shopper_id)) AND ($shopper_id >0)){
		$view_file = 'nav_top_out';
	}else{
		$view_file  = 'nav_top_in';
	}
	$this->load->view($view_file);
}
function _draw_top_right($shopper_id){
	$this->load->module('cart');
	$this->load->module('site_sittings');

	$data_cart['customer_session_id'] = $this->session->session_id;
	$data_cart['shopper_id'] = $shopper_id;
	$data_cart['table'] = 'store_basket';
	$data_cart['get_shipping'] = FALSE;
    
    $total_cart = $this->cart->_calc_total_shopping($data_cart);
    if($total_cart < 0.01){
    	$info_cart = ' Your Basket Is Empty';
    }else{
    	$symbol = $this->site_sittings->_get_symbol();
    	$info_cart = ' Total Shopping : '.$symbol.$total_cart;
    }
    $data['info_cart'] = $info_cart;
    $this->load->view('draw_top_right', $data);

}


function _draw_breadcrumbs($data){
	$this->load->view('public_breadcrumbs',$data);
}

function login($data){
	if(!isset($data['view_module'])){
        $data['view_module'] = $this->uri->segment(1);
    }
	$this->load->view('login',$data);
}
function admin($data){
	if(!isset($data['view_module'])){
        $data['view_module'] = $this->uri->segment(1);
    }
	$this->load->view('admin',$data);
}
function public_bootstrap($data){
	if(!isset($data['view_module'])){
        $data['view_module'] = $this->uri->segment(1);
    }

    $this->load->module('site_security');
    $data['customer_id'] = $this->site_security->_get_user_id();
    $data['uri'] = $this->uri->segment(1);
	$this->load->view('public_bootstrap',$data);
}
function public_jqm($data=""){
	if(!isset($data['view_module'])){
        $data['view_module'] = $this->uri->segment(1);
    }

	$this->load->view('public_jqm',$data);
}


}