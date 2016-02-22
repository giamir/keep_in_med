<?php

require_once 'functions/kim_fns.php';
session_start();

$type=htmlspecialchars($_GET['type']);
if($type!='login') check_valid_user(); // se non si è autenticati è possibile visualizzare l'iframe del solo login

do_iframe_header();

switch($type){
	case 'login': do_iframe_login(); break;
	case 'logout': do_iframe_logout(); break;
	case 'add_visit': do_iframe_add_visit($_GET); break;
	case 'delete_appointment': do_iframe_delete_appointment($_GET); break;
	case 'change_appointment': do_iframe_change_appointment($_GET); break;
	case 'delete_request': do_iframe_delete_request($_GET); break;
	case 'answer_request': do_iframe_answer_request($_GET); break;
	case 'change_basic': do_iframe_change_basic($_GET); break;
	case 'change_contact': do_iframe_change_contact($_GET); break;
	case 'change_residence': do_iframe_change_residence($_GET); break;
	case 'change_password': do_iframe_change_password($_GET); break;
	case 'delete_patient': do_iframe_delete_patient($_GET); break;
	case 'add_patient': do_iframe_add_patient($_GET); break;
	case 'add_appointment': do_iframe_add_appointment($_GET); break;
	case 'change_visit': do_iframe_change_visit($_GET); break;
	case 'delete_visit': do_iframe_delete_visit($_GET); break;
	case 'add_request': do_iframe_add_request($_GET); break;
	case 'confirm_appointment': do_iframe_confirm_appointment($_GET); break;
				
	default: echo 'L\'azione richiesta non è supportata';
}

do_iframe_footer();
	
?>
