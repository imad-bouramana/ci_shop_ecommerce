<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Default_module extends MX_Controller
{

function __construct() {
parent::__construct();
}
function index(){
	$first_bit = trim($this->uri->segment(1));
	$this->load->module('webe_pages');

	$query = $this->webe_pages->get_where_custom('page_url',$first_bit);
	$num_rows = $query->num_rows();
	if($num_rows>0){
		foreach($query->result() as $row){
		$data['page_title'] = $row->page_title;
		$data['page_description'] = $row->page_description;
		$data['page_keyword'] = $row->page_keyword;
		$data['page_headline'] = $row->page_headline;
		$data['page_content'] = $row->page_content;
		$data['page_url'] = $row->page_url;
	   }
	
	
	}else{
		$this->load->module('site_sittings');
		$data['page_content'] = $this->site_sittings->_get_not_found();
	}
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);
	
}

}