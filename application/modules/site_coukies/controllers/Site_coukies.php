<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Site_coukies extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _set_coukies($user_id){
	$this->load->module('site_sittings');
	$this->load->module('site_security');

	$time = time();
	$one_day = 86400;
	$two_week = $one_day * 14;
	$expire_date = $time+$two_week;
    
    $data['coukies_code'] = $this->site_security->generate_random_string(128);
    $data['user_id'] = $user_id;
    $data['expire_date'] = $expire_date;
    $this->_insert($data);

	$coukies_name = $this->site_sittings->_get_coukies_name(); 

	setcookie($coukies_name, $data['coukies_code'],$data['expire_date']);
}
function _get_user_from_coukies(){
	$this->load->module('site_sittings');
	$coukies_name = $this->site_sittings->_get_coukies_name();

	if(isset($_COOKIE[$coukies_name])){
		$coukie_code = $_COOKIE[$coukies_name];

		$query = $this->get_where_custom('coukies_code', $coukies_code);
		$num_rows = $query->num_rows();
        
        if($num_rows < 1){
        	$user_id = '';
        }

		foreach($query->result() as $row){
           $user_id = $row->user_id;
		}
	}else{
		$user_id = '';
	}
	return $user_id;
}
function _destroy_coukie(){
	$this->load->module('site_sittings');
	$coukies_name = $this->site_sittings->_get_coukies_name();

    setcookie($coukies_name, '', time()-3600);

}
function get($order_by) {
$this->load->model('mdl_site_coukies');
$query = $this->mdl_site_coukies->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_site_coukies');
$query = $this->mdl_site_coukies->get_with_limit($limit, $offset, $order_by);
return $query;
}

function get_where($id) {
$this->load->model('mdl_site_coukies');
$query = $this->mdl_site_coukies->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_site_coukies');
$query = $this->mdl_site_coukies->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_site_coukies');
$this->mdl_site_coukies->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_site_coukies');
$this->mdl_site_coukies->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_site_coukies');
$this->mdl_site_coukies->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_site_coukies');
$count = $this->mdl_site_coukies->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_site_coukies');
$max_id = $this->mdl_site_coukies->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_site_coukies');
$query = $this->mdl_site_coukies->_custom_query($mysql_query);
return $query;
}

}