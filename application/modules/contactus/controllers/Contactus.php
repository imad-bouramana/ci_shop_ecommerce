<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contactus extends MX_Controller
{

function __construct() {
parent::__construct();
}

function index(){
	$this->load->module('site_sittings');
	$data = $this->get_data_from_post();
	$data['adress'] = $this->site_sittings->_get_adress();
	$data['telephone'] = $this->site_sittings->_get_telephone();
	$data['company'] = $this->site_sittings->_get_company();
	$data['map_code'] = $this->site_sittings->_get_map_code();
    
    $data['flash'] = $this->session->flashdata('item');
	$data['view_file'] = 'contactus';
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);
}
function submit(){
        $submit = $this->input->post('submit', TRUE);
		$url_referer = $_SERVER['HTTP_REFERER']; 
		$target_url_referer = base_url().'contactus';
		$firstname = trim($this->input->post('firstname', TRUE));
			if($firstname!=''){
				$this->_blacklist();
			}

	// insert data in table 
		if(($submit == 'Submit') AND $url_referer == $target_url_referer){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('yourname', 'yourname', 'required|max_length[50]');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email');
			$this->form_validation->set_rules('telenum', 'telephone', 'required|max_length[20]');
			$this->form_validation->set_rules('message', 'message', 'required');
		
			if($this->form_validation->run() == TRUE){
				$data_post = $this->get_data_from_post();

				$this->load->module('enquiries');
				$this->load->module('site_security');

				$data['date_created'] = time();
				$data['sent_by'] = 0;
				$data['sent_to'] = 0;
				$data['opened'] = 0;
				$data['urgent'] = 0;
				$data['message'] = $this->build_msg($data_post);
				$data['subject'] = 'Contact Us';
				$data['code'] = $this->site_security->generate_random_string(6);

				$this->enquiries->_insert($data);
				redirect('contactus/thankyou');
				
			}else{
               $this->index();
		   }
		}
}
function thankyou(){
	$data['view_file'] = 'thankyou';
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);
}

function build_msg($data_post){
	$yourname = ucfirst($data_post['yourname']);
    $msg = $yourname.' Welcome Your Submitted Details :<br><br>';
    $msg .= 'Name : '.$yourname.'<br>';
    $msg .= 'Email : '.$data_post['email'].'<br>';
    $msg .= 'telenum : '.$data_post['telenum'].'<br>';
    $msg .= 'Message : '.$data_post['message'];
    return $msg;
}
function get_data_from_post(){
	$data['yourname'] = $this->input->post('yourname', TRUE);
	$data['telenum'] = $this->input->post('telenum', TRUE);
	$data['email'] = $this->input->post('email', TRUE);
	$data['message'] = $this->input->post('message', TRUE);
	return $data;
}
function _blacklist(){
	$this->load->module('blacklist');
	$data['ip_address'] = $this->input->post->ip_address();
	$data['date_created'] = time();
	$this->blacklist->_insert($data);
}
}