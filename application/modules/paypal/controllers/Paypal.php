<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Paypal extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _get_paypal_info($update_id){
	$this->load->module('datemade');
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
	   $date_created = $row->date_created;
	   $posted_information = $row->posted_information;
    }

    $data = unserialize($posted_information);
    $data['date_created'] = $this->datemade->get_nice_date($date_created, 'cool');
    if($data['payer_business_name'] == ''){
           $data['payer_business_name'] = '-';
    }
    $this->load->view('paypal_summary', $data);

}
function submet_test(){
	
	$paypal_local = $this->_paypal_test_acount();
	$num_order = $this->input->post('num_order', TRUE);
	$custom = $this->input->post('custom', TRUE);
    if(($paypal_local == FALSE) OR (!is_numeric($num_order))){
    	die();
    }
    $this->load->module('site_security');
    $this->load->module('store_orders');
    $this->load->module('store_basket');
    $paypale_id = 88;
    $customer_session_id = $this->site_security->_decrypted_string($custom);

    $query = $this->store_basket->get_where_custom('session_id', $customer_session_id);

	  foreach($query->result() as $row){
			$data_store['session_id'] = $row->session_id;
			$data_store['item_title'] = $row->item_title;
			$data_store['price'] = $row->price;
			$data_store['item_colour'] = $row->item_colour;
			$data_store['item_size'] = $row->item_size;
			$data_store['item_qty'] = $row->item_qty;
			$data_store['date_created'] = $row->date_created;
			$data_store['shopper_id'] = $row->shopper_id;
			$data_store['tax'] = $row->tax;
			$data_store['item_id'] = $row->item_id;
			$data_store['ip_address'] = $row->ip_address;
		}
    for ($i=0; $i < $num_order; $i++) { 
    	
    	$this->store_orders->_generate_orders($paypale_id, $customer_session_id);
    	$this->store_basket->_insert($data_store);
    }
    echo 'finished';
	
	
}
function ipn_listener(){
	header('HTTP/1.1 200 OK');
	// STEP 1: read POST data
	// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
	// Instead, read raw POST data from the input stream.
	$raw_post_data = file_get_contents('php://input');
	$raw_post_array = explode('&', $raw_post_data);
	$myPost = array();
	foreach ($raw_post_array as $keyval) {
	  $keyval = explode ('=', $keyval);
	  if (count($keyval) == 2)
	    $myPost[$keyval[0]] = urldecode($keyval[1]);
	}
	// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
	$req = 'cmd=_notify-validate';
	if (function_exists('get_magic_quotes_gpc')) {
	  $get_magic_quotes_exists = true;
	}
	foreach ($myPost as $key => $value) {
	  if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
	    $value = urlencode(stripslashes($value));
	  } else {
	    $value = urlencode($value);
	  }
	  $req .= "&$key=$value";
	}

	// Step 2: POST IPN data back to PayPal to validate
	$ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
	// In wamp-like environments that do not come bundled with root authority certificates,
	// please download 'cacert.pem' from "https://curl.haxx.se/docs/caextract.html" and set
	// the directory path of the certificate as shown below:
	// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
	if ( !($res = curl_exec($ch)) ) {
	  // error_log("Got " . curl_error($ch) . " when processing IPN data");
	  curl_close($ch);
	  exit;
	}
	curl_close($ch);
	// inspect IPN validation result and act accordingly
	if (strcmp ($res, "VERIFIED") == 0) {

	  // The IPN is verified, process it
		$data['date_created'] = time();
		$this->load->module('site_security');
		foreach ($_POST as $key => $value) {
			if($key == 'custom'){
				$customer_session_id = $this->site_security->_encrypted_string($value);
				$value = $customer_session_id;
			}
			$posted_information[$key]= $value; 
		}
		$data['posted_information'] = serialize($posted_information);
		$this->_insert($data);

		$max_id = $this->get_max();
		$this->load->module('store_orders');
		$this->store_orders->_generate_orders($max_id, $customer_session_id);
	
	} else if (strcmp ($res, "INVALID") == 0) {
	  // IPN invalid, log for manual investigation
	}
}
function _chekout_reale_btn($query){
  $this->load->module('site_security');
  $this->load->module('site_sittings');
  $this->load->module('shipping');

  foreach ($query->result() as $row) {
     $session_id = $row->session_id;
  }
  $paypal_local = $this->_paypal_test_acount();
	if($paypal_local == TRUE){
        $form_location  = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	}else{
        $form_location  = 'https://www.paypal.com/cgi-bin/webscr';
	}
	$data['paypal_local'] = $paypal_local;
  $data['return'] = base_url().'paypal/thankyou';
  $data['cancel_return'] = base_url().'paypal/cancel';
  $data['form_location'] = $form_location;
  $data['shipping'] = $this->shipping->_get_shipping();
  $data['custom'] = $this->site_security->_encrypted_string($session_id);
  $data['currency'] = $this->site_sittings->_get_currency_code();
  $data['paypal_email'] = $this->site_sittings->_paypal_email();
  $data['query'] = $query;
  $this->load->view('chekout_btn',$data);

}
function thankyou(){
	$data['view_file'] = 'thankyou';
	
 	$this->load->module('templates');
 	$this->templates->public_bootstrap($data);
}
function cancel(){
	$data['view_file'] = 'cancel';
    $is_mobile = $this->site_sittings->is_mobile();
   
 	$this->load->module('templates');
 	$this->templates-public_bootstrap($data);
}
function _paypal_test_acount(){
	return TRUE;
}

function get($order_by) {
$this->load->model('mdl_paypal');
$query = $this->mdl_paypal->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_paypal');
$query = $this->mdl_paypal->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_paypal');
$query = $this->mdl_paypal->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_paypal');
$query = $this->mdl_paypal->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_paypal');
$this->mdl_paypal->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_paypal');
$this->mdl_paypal->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_paypal');
$this->mdl_paypal->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_paypal');
$count = $this->mdl_paypal->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_paypal');
$max_id = $this->mdl_paypal->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_paypal');
$query = $this->mdl_paypal->_custom_query($mysql_query);
return $query;
}

}