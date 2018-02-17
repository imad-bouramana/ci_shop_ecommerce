<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Yourmessage extends MX_Controller
{

function __construct() {
parent::__construct();
}
function messagesent(){
        $data['headline'] = 'Message Sent';
        //$data['stor_items'] = 'stor_items';
        $data['view_file'] = 'messagesent';
        $this->load->module('templates');
        $this->templates->public_bootstrap($data);
}
function create(){
    $this->load->library('session');

    $this->load->module('site_security');
    $this->load->module('store_accounts');

    $this->load->module('enquiries');

    $submit = $this->input->post('submit', TRUE);
    $customer_id = $this->site_security->_get_user_id();
//cansel button
    $code = $this->uri->segment(3);
    $data = $this->get_data_from_post();
    if($submit == 'Cancel'){
        redirect('your_account/welcome');
    }
    // insert data in table 
        if($submit == 'Submit'){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('message', 'Message', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required|max_length[250]');
       
            
            if($this->form_validation->run() == TRUE){
                if((!is_numeric($customer_id))OR($customer_id==0)){
                    $token = $this->input->post('token', TRUE);
                    $customer_id = $this->store_accounts->_get_customer_id_from_token($token);
                    $not_login_in = TRUE;
                }

                $data['date_created'] = time();
                $data['sent_to'] = 0;
                $data['opened'] = 0;
                $data['sent_by'] = $customer_id;
                $data['code'] = $this->site_security->generate_random_string(6);

                if($data['urgent']!=1){
                   $data['urgent'] = 0;
                }
                if($customer_id>0){
                    $this->enquiries->_insert($data);
                    $flash_msg = 'The  message Was Successfully Sent';
                    $value = '<div class="alert alert-success">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item', $value);
                }
                if(isset($not_login_in)){
                    $target_url = base_url().'yourmessage/messagesent';
                }else{
                    $target_url = base_url().'your_account/welcome';
                }
                redirect($target_url);
                
            }
        }elseif($code!=''){
            $data = $this->enquiries->_attempt_get_data_for_db($customer_id,$code);
            $data['message'] = "<br>---------------------------------------------------------------------------------- <br>".$data['message'];
        }
            
       
          // create headline 
        $this->site_security->_make_sure_is_login();
        $data['token'] = $this->store_accounts->_get_token_from_post($customer_id);
        if($code==''){
           $data['headline'] = 'Add New Message';
        }else{
            $data['headline'] = 'Reply To Message';
        }
        $data['message'] = $this->_stripe_msg($data['message']);
        $data['flash'] = $this->session->flashdata('item');
        //$data['blog'] = 'blog';
        $data['code'] = $code;
        $data['view_file'] = 'create';
        $this->load->module('templates');
        $this->templates->public_bootstrap($data);
    }
function _stripe_msg($msg){
    $replace = ' 

    ';
   $msg = str_replace('<br>', $replace, $msg);
   $msg = strip_tags($msg);
   return $msg;
}
function get_data_from_post(){
    $data['subject'] = $this->input->post('subject', TRUE);
    $data['message'] = $this->input->post('message', TRUE);
    $data['urgent'] = $this->input->post('urgent', TRUE);
    return $data;
}
function view(){
	$this->load->module('site_security');

	$this->load->module('enquiries');
	$this->load->module('datemade');
    $this->load->module('site_sittings');


	$this->site_security->_make_sure_is_login();

    $code = $this->uri->segment(3);
    $col1 = 'sent_to';
    $value1 = $this->site_security->_get_user_id();
    $col2 = 'code';
    $value2 = $code;
    $query = $this->enquiries->get_whith_double_condition($col1, $value1,$col2, $value2);
    $num_rows = $query->num_rows();
    if($num_rows >1){
    	redirect('site_security/not_allowed');
    }
    foreach($query->result() as $row){
    	$update_id = $row->id;
    	$data['subject'] = $row->subject;
		$data['message'] = $row->message;
		$data['sent_to'] = $row->sent_to;
		$data['sent_by'] = $row->sent_by;
		$date_created = $row->date_created;
		$data['opened'] = $row->opened;
    }
    $data['date_created'] = $this->datemade->get_nice_date($date_created, 'full');
    $this->enquiries->_enquiries_opened($update_id);
	
   
	$data['flash'] = $this->session->flashdata('item');

	$data['code'] = $code;
	$data['view_file'] = 'view';
	$this->load->module('templates');
	$this->templates->public_bootstrap($data);
}
}