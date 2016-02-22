<?php

session_start();
require_once('functions/kim_fns.php');

$req=htmlspecialchars($_GET['req']);
if($req!='login') check_valid_user(); // se non si è autenticati è possibile processare solo richieste di login

switch($req){
	
	 case 'login': process_login($_GET); break;
				
	case 'logout': process_logout(); break;
				
	case 'add_visit': process_add_visit($_GET); break;
					
	case 'delete_appointment': process_delete_appointment($_GET); break;
							 
	case 'change_appointment': process_change_appointment($_GET); break;
							 
	case 'delete_request': process_delete_request($_GET); break;
							 
	case 'answer_request': process_answer_request($_GET); break;
						 
	case 'change_basic': process_change_basic($_GET); break;
					   
	case 'change_contact': process_change_contact($_GET); break;
	
	case 'change_residence': process_change_residence($_GET); break;
	
	case 'change_password': process_change_password($_GET); break;
						  
	case 'delete_patient': process_delete_patient($_GET); break;
						 
	case 'add_patient': process_add_patient($_GET); break;
	
	case 'add_appointment': process_add_appointment($_GET); break;
						  
	case 'change_visit': process_change_visit($_GET); break;
					   
	case 'delete_visit': process_delete_visit($_GET); break;	
					   
	case 'add_request': process_add_request($_GET); break;
	
	case 'confirm_appointment': process_confirm_appointment($_GET); break;			   
				  
	default: echo 'Errore di sistema: azione richiesta non supportata';
}
	
	
?>