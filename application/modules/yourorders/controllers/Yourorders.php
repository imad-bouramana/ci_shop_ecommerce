<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Yourorders extends MX_Controller
{

function __construct() {
parent::__construct();
}
function view(){
	 $this->load->module('site_security');
     $this->site_security->_make_sure_is_login();

    $this->load->module('site_sittings');

	$this->load->module("store_orders");
	$this->load->module("store_order_status");
	$this->load->module("cart");
	$this->load->module("datemade");


	$shopper_id = $this->site_security->_get_user_id();
	$order_ref = $this->uri->segment(3);

    $col1 = "shopper_id";
    $value1 = $shopper_id;
    $col2 = 'order_ref'; 
    $value2 = $order_ref;
	$query = $this->store_orders->get_withe_double_condition($col1, $value1,$col2, $value2);
  
    $num_rows = $query->num_rows();
    if($num_rows < 1){
    	redirect('site_security/not_allowed');
    }
     foreach($query->result() as $row){
     	$session_id = $row->session_id;
     	$order_ref = $row->order_ref;
     	$order_status = $row->order_status;
     	$date_created = $row->date_created;
     }
     $data['date_created'] = $this->datemade->get_nice_date($date_created, 'cool');
      $data['order_ref'] = $order_ref;
      if($order_status ==0){
      	$data['order_status_name'] = 'Order Submited';
      }else{
         $data['order_status_name'] = $this->store_order_status->_get_order_title($order_status);
      }
    

     $table = 'store_shopertrack';
 
     $data['query_cc'] = $this->cart->_get_data_from_basket($session_id, $shopper_id, $table);
     $data['num_rows'] = $data['query_cc']->num_rows();

	$data['flash'] = $this->session->flashdata('item');
	$data['view_file'] = 'view';
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);
	}
function browse(){
	 $this->load->module('site_security');
     $this->site_security->_make_sure_is_login();

    $this->load->module('site_sittings');
	$this->load->module("custom_pagination");
	$this->load->module("store_orders");
	$this->load->module("store_order_status");


	$shopper_id = $this->site_security->_get_user_id();
	$use_limit = FALSE;

	$mysql_query = $this->_generate_mysql_query($use_limit, $shopper_id);
	$query  = $this->store_orders->_custom_query($mysql_query);
	$total_items = $query->num_rows(); 
		
    $use_limit = TRUE;
    $mysql_query = $this->_generate_mysql_query($use_limit, $shopper_id);
    $data['query'] = $this->store_orders->_custom_query($mysql_query);
    $data['num_rows'] = $data['query']->num_rows();

    $pagination_data['template'] = 'template_boostrap';
    $pagination_data['target_base_url'] = $this->get_target_base_url();
    $pagination_data['total_rows'] = $total_items;
    $pagination_data['offset_segment'] = 3;
    $pagination_data['limit'] = $this->get_limit();
		           
          //$data['stor_items'] = 'stor_items';
    $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);
    $pagination_data['offset_segment'] = $this->get_offset();
    $data['statement'] = $this->custom_pagination->get_show_statement($pagination_data);
       
    $data['order_status_title'] = $this->store_orders->_get_order_title();
    $data['order_status_name'] = $this->_get_status_order_name();
 



	$data['flash'] = $this->session->flashdata('item');
	$data['view_file'] = 'browse';
	
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);
}
function _generate_mysql_query($use_limit, $shopper_id){
	
		$mysql_query = "
             SELECT * FROM store_orders WHERE shopper_id = '$shopper_id' ORDER BY date_created DESC
        ";
	

   if($use_limit == TRUE){
		$limit = $this->get_limit();
		$offset = $this->get_offset();
		$mysql_query .= " LIMIT ".$offset.', '.$limit;
   }
   return $mysql_query;
}
function get_target_base_url(){
	$first_bit = $this->uri->segment(1);
	$second_bit = $this->uri->segment(2);
	$target_base_url = base_url().$first_bit.'/'.$second_bit;
	return $target_base_url;
}

function get_limit(){
	$limit = 20;
	return $limit;
}
function get_offset(){
	$offset_segment = $this->uri->segment(3);
	if(!is_numeric($offset_segment)){
		$offset_segment = 0;
	}
	return $offset_segment;
}
function _get_status_order_name(){
	$this->load->module('store_order_status');
	$status_order_name = $this->store_order_status->_get_status_title();
	return $status_order_name;
}
}