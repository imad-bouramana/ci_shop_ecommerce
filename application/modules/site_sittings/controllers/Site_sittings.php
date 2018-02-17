<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Site_sittings extends MX_Controller
{

function __construct() {
parent::__construct();
}
function _get_adress(){
	$adress = '46000 Rue Menaret <br>';
	$adress .= 'Ancienne Medina Safi Morocco';
	return $adress;
}
function _get_telephone(){
	$telephone = '0641256021';
	return $telephone;
}
function _get_company(){
	$company = 'Ci Shop Inc';
	return $company;
}
function _get_map_code(){
	$code = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26979.25236815015!2d-9.218064727412917!3d32.30092989327386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdac212049843597%3A0x6b618c47dfd85d40!2z2KPYs9mB2YrYjCDYp9mE2YXYutix2Kg!5e0!3m2!1sar!2s!4v1510609744027" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>';
	return $code;
}
function _get_customer_support(){
	$suport = "Customer Support";
	return $suport;
}
function _get_coukies_name(){
	$coukies_name = "abcdefjhik";
	return $coukies_name;
}
function _get_symbol(){
	$symbol = '&pound;';
	return $symbol;
}
function _get_currency_code(){
	$code = 'EUR';
	return $code;
}
function _paypal_email(){
	$email = 'bouraima2016d@hotmail.com';
	return $email;
}
function _get_item_instruments(){
	$segment = 'Clothings/Shoes__Jewelrys/';
	//$segment = 'musical/instruments/';
	return $segment;
}
function _get_items_instruments(){
	$segment = 'Clothing/Shoes__Jewelry/';
	//$segment = 'music/instruments/';
	return $segment;
}
function _get_not_found(){
	$msg = '<h1>This Page Not Found .</h1>';
	$msg .= '<p>Chek Your url To Find A Real Pages</p>';
	return $msg;
}

}