<?php
$pagetitle = isset($pageTitle) ? : '';
$this->load->view('header', $pagetitle);
if(isset($view_data)) {
	$this->load->view(@$template , $view_data);
} else {
	$this->load->view(@$template);
}

$this->load->view('footer');
?>