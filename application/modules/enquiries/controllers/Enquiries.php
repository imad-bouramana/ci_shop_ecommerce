<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Enquiries extends MX_Controller
{

function __construct() {
parent::__construct();
}
function submit_ranking(){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	$data['ranking'] = $this->input->post('ranking', TRUE); 
	$submit = $this->input->post('submit', TRUE); 
   if($submit=='Cancel'){
   	redirect('enquiries/inbox');
   }
	$update_id = $this->uri->segment(3);
	$this->_update($update_id,$data);
	$flash_msg = 'The Ranking Waz Succusfuly Updated ';
	$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
	$this->session->set_flashdata('item', $value);
	redirect('enquiries/view/'.$update_id);


}
function _attempt_get_data_for_db($customer_id,$code){
	$query = $this->get_where_custom('code',$code);
	$num_rows = $query->num_rows();
    foreach($query->result() as $row){
    	$data['subject'] = $row->subject;
		$data['message'] = $row->message;
		$data['sent_to'] = $row->sent_to;
		$data['sent_by'] = $row->sent_by;
		$data['date_created'] = $row->date_created;
		$data['opened'] = $row->opened;
		$data['code'] = $row->code;
		$data['urgent'] = $row->urgent;

    }
    if(($num_rows < 1) OR ($customer_id!=$data['sent_to'])){
    	redirect('site_security/not_allowed');
    }
    return $data;
}
function _draw_customer_details($customer_id){
	$data['customer_id'] = $customer_id;
	$folder_type = ' Your inbox';
	$data['query'] = $this->_get_customer_enquiries($folder_type,$customer_id);

	$data['flash'] = $this->session->flashdata('item');
	$data ['folder_type'] = $folder_type;
	$this->load->view('customer_details',$data);
}
function _get_customer_enquiries($folder_type,$customer_id){
	$mysql_query = "SELECT enquiries.*, store_accounts.firstname, store_accounts.lastname, store_accounts.company 
	 FROM enquiries LEFT JOIN store_accounts  ON enquiries.sent_to = store_accounts.id WHERE enquiries.sent_to = $customer_id
	  ORDER BY enquiries.date_created DESC";
	$query = $this->_custom_query($mysql_query);
	return $query;
}
function create(){
	$this->load->library('session');

    $this->load->module('site_security');
    $this->load->module('datemade');

	$this->site_security->_make_sure_is_admin();
// get id
	$update_id = $this->uri->segment(3);
	$submit = $this->input->post('submit', TRUE);
//cansel button
	if($submit == 'Cancel'){
		redirect('enquiries/inbox');
	}
	// insert data in table 
		if($submit == 'Submit'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('message', 'Message', 'required');
			$this->form_validation->set_rules('subject', 'Subject', 'required|max_length[250]');
			$this->form_validation->set_rules('sent_to', 'Sent To', 'required');
			

			if($this->form_validation->run() == TRUE){
				$data = $this->get_data_from_post();
				
				$data['date_created'] = time();
				$data['sent_by'] = 0;
				$data['opened'] = 0;
				$data['code'] = $this->site_security->generate_random_string(6);

				$this->_insert($data);
				$flash_msg = 'The Message Waz Succusfuly Sent ';
				$value = '<div class="alert alert-success">'.$flash_msg.'</div>';
				$this->session->set_flashdata('item', $value);
				redirect('enquiries/inbox');
				
			}
		}
	      // submit handler
		if((is_numeric($update_id))&&($submit!='Submit')){
			$data = $this->get_data_from_db($update_id);
			$data['message'] = "<br><br>------------------------------------------- <br>
			The Original Message Is Shown  Bellow<br><br>".$data['message'];
			
		}else{
			$data = $this->get_data_from_post();
		}
         // create headline 
		if(!is_numeric($update_id)){
			$data['headline'] = 'Add New Message';
		}else{
			$data['headline'] = 'Reply To Message';
		}
        // load data to module
         
		$data['update_id'] = $update_id;
		$data['options'] = $this->get_customer_name();
		$data['flash'] = $this->session->flashdata('item');
        //$data['blog'] = 'blog';
		$data['view_file'] = 'create';
		$this->load->module('templates');
		$this->templates->admin($data);
	}

function get_customer_name(){
	$this->load->module('store_accounts');
	$options[''] = 'Please Select...';
	$query = $this->store_accounts->get('lastname');
	foreach($query->result() as $row){
		$customer_name = $row->firstname." ".$row->lastname;
		$company_lenght = strlen($row->company);
		if($company_lenght>2){
			$customer_name .= ' From '.$row->company;
		}
		$options[$row->id] = $customer_name;
	}
	return $options;
}
function get_data_from_post(){
	$data['subject'] = $this->input->post('subject', TRUE);
	$data['message'] = $this->input->post('message', TRUE);
	$data['sent_to'] = $this->input->post('sent_to', TRUE);
	return $data;
}
function get_data_from_db($update_id){
 //redirect if not allowd
	if(!is_numeric($update_id)){
		redirect('site_security/not_allowed');
	}
	$query = $this->get_where($update_id);
	foreach($query->result() as $row){
		$data['subject'] = $row->subject;
		$data['message'] = $row->message;
		$data['sent_to'] = $row->sent_to;
		$data['sent_by'] = $row->sent_by;
		$data['date_created'] = $row->date_created;
		$data['opened'] = $row->opened;
		$data['urgent'] = $row->urgent;
		$data['ranking'] = $row->ranking;

	}
	if(!isset($data)){
		$data = '';
	}
	return $data;
}
function view(){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();

  
    $update_id = $this->uri->segment(3);
    $this->_enquiries_opened($update_id);
	$data['query'] = $this->get_where($update_id);

	$data['flash'] = $this->session->flashdata('item');
    $options[''] = 'Please Select...';
	$options['1'] = 'One Star';
	$options['2'] = 'Two Stars';
	$options['3'] = 'Three Stars';
	$options['4'] = 'Four Stars';
	$options['5'] = 'Five Stars';
	$data['options'] = $options;

 
	$data['headline'] = 'Enquiry ID : '.$update_id;
	$data['update_id'] = $update_id;
	$data['view_file'] = 'view';
	$this->load->module('templates');
	$this->templates->admin($data);
}
function _enquiries_opened($update_id){
	$data['opened'] = 1;
	$this->_update($update_id,$data);
}
function inbox(){
	$this->load->module('site_security');
	$this->site_security->_make_sure_is_admin();
	//
    
		
	//

	$folder_type = 'inbox';
	$data['query'] = $this->_get_enquiries($folder_type);

	$data['flash'] = $this->session->flashdata('item');
	$data ['folder_type'] = $folder_type;
	$data['headline'] = 'Manage ';
	$data['view_file'] = 'view_enquiries';
	$this->load->module('templates');
	$this->templates->admin($data);
}

function _get_enquiries($folder_type){
	$mysql_query = "SELECT * FROM enquiries WHERE sent_to = 0 ORDER BY date_created DESC";
	$query = $this->_custom_query($mysql_query);
	return $query;
}

function get($order_by) {
$this->load->model('mdl_enquiries');
$query = $this->mdl_enquiries->get($order_by);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_enquiries');
$query = $this->mdl_enquiries->get_with_limit($limit, $offset, $order_by);
return $query;
}
function get_whith_double_condition($col1, $value1,$col2, $value2) {
$this->load->model('mdl_enquiries');
$query = $this->mdl_enquiries->get_whith_double_condition($col1, $value1,$col2, $value2);
return $query;
}
function get_where($id) {
$this->load->model('mdl_enquiries');
$query = $this->mdl_enquiries->get_where($id);
return $query;
}

function get_where_custom($col, $value) {
$this->load->model('mdl_enquiries');
$query = $this->mdl_enquiries->get_where_custom($col, $value);
return $query;
}

function _insert($data) {
$this->load->model('mdl_enquiries');
$this->mdl_enquiries->_insert($data);
}

function _update($id, $data) {
$this->load->model('mdl_enquiries');
$this->mdl_enquiries->_update($id, $data);
}

function _delete($id) {
$this->load->model('mdl_enquiries');
$this->mdl_enquiries->_delete($id);
}

function count_where($column, $value) {
$this->load->model('mdl_enquiries');
$count = $this->mdl_enquiries->count_where($column, $value);
return $count;
}

function get_max() {
$this->load->model('mdl_enquiries');
$max_id = $this->mdl_enquiries->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_enquiries');
$query = $this->mdl_enquiries->_custom_query($mysql_query);
return $query;
}

}