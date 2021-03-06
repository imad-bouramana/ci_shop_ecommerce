<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Custom_pagination extends MX_Controller
{

function __construct() {
parent::__construct();
}

function _generate_pagination($data){
	$this->load->library('pagination');
    
     $template = $data['template'];
     $target_base_url = $data['target_base_url'];
     $total_rows = $data['total_rows'];
     $offset_segment = $data['offset_segment'];
     $limit = $data['limit'];

	if($template == 'public_bootstrap'){
		$settings = $this->get_sittings_for_public_boostrap($data);
    }
    $settings = $this->get_sittings_for_public_boostrap($data);
    $config['base_url'] = $target_base_url;
    $config['total_rows'] = $total_rows;
    $config['uri_segment'] = $offset_segment;

    $config['per_page'] = $limit;
	$config['num_links'] = $settings['num_links'];

	$config['full_tag_open'] = $settings['full_tag_open'] ;
	$config['full_tag_close'] = $settings['full_tag_close'];

	$config['cur_tag_open'] = $settings['cur_tag_open'];
	$config['cur_tag_close'] = $settings['cur_tag_close'];

	$config['num_tag_open'] = $settings['num_tag_open'];
	$config['num_tag_close'] = $settings['num_tag_close'];

	$config['first_link'] = $settings['first_link'];
	$config['first_tag_open'] = $settings['first_tag_open'];
	$config['first_tag_close'] = $settings['first_tag_close'];

	$config['last_link'] = $settings['last_link'];
	$config['last_tag_open'] = $settings['last_tag_open'];
	$config['last_tag_close'] = $settings['last_tag_close'];

	$config['prev_link'] = $settings['prev_link'];
	$config['prev_tag_open'] = $settings['prev_tag_open'];
	$config['prev_tag_close'] = $settings['prev_tag_close'];

	$config['next_link'] = $settings['next_link'];
	$config['next_tag_open'] = $settings['next_tag_open'];
	$config['next_tag_close'] = $settings['next_tag_close'];

$this->pagination->initialize($config);

$pagination =  $this->pagination->create_links();
return $pagination;
}
function get_show_statement($data){
   $offset_segment = $data['offset_segment'];
   $limit = $data['limit'];
   $total_rows = $data['total_rows'];

   $value1 = $offset_segment+1;
   $value2 = $offset_segment+$limit;
   $value3 = $total_rows;
   if($value2>$value3){
   	$value2 = $value3;
   }
   $show_statement = 'Showing '.$value1.' To '.$value2.' Of '.$value3.' Result';
   return $show_statement;
}


function get_sittings_for_public_boostrap(){
	//$settings['per_page'] = 20;
	$settings['num_links'] = 12;

	$settings['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pager">';
	$settings['full_tag_close'] = '</ul></nav>';

	$settings['cur_tag_open'] = '<li class="active"><a href="#">';
	$settings['cur_tag_close'] = '</a></li>';

	$settings['num_tag_open'] = '<li>';
	$settings['num_tag_close'] = '</li>';

	$settings['first_link'] = 'FIRST';
	$settings['first_tag_open'] = '<li>';
	$settings['first_tag_close'] = '</li>';

	$settings['last_link'] = 'LAST';
	$settings['last_tag_open'] = '<li>';
	$settings['last_tag_close'] = '</li>';

	$settings['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
	$settings['prev_tag_open'] = '<li>';
	$settings['prev_tag_close'] = '</li>';

	$settings['next_link'] = '<span aria-hidden="true">&raquo;</span>';
	$settings['next_tag_open'] = '<li>';
	$settings['next_tag_close'] = '</li>';
    
     return $settings;
}


}