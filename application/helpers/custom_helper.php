<?php

function setFlashData($class,$message,$url){
	$CI = get_instance();
	$CI->load->library('session');
	$CI->session->set_flashdata('class',$class);
	$CI->session->set_flashdata('message',$message);
	redirect($url);
}
	function adminLoggedIn(){
	$CI = get_instance();
	$CI->load->library('session');
		if ($CI->session->userdata('aId')) {
			return TRUE;
		} else {
			return FALSE;
		}

}

	function getAdminId(){
	$CI = get_instance();
	$CI->load->library('session');
	if ($CI->session->userdata('aId')) {
		return $CI->session->userdata('aId');
	} else {
		return FALSE;
	}

}

function userLoggedIn(){
    $CI = get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('uId')) {
        return TRUE;
    } else {
        return FALSE;
    }

}
 function checkFlash(){
     $CI = get_instance();
     $CI->load->library('session');
	if ($CI->session->flashdata('class')) {
		$data['class'] =  $CI->session->flashdata('class');
		$data['message'] =  $CI->session->flashdata('message');
		$CI->load->view('flashdata',$data);
	}
 }

?>


