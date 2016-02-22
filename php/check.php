<?php

session_start();
require_once('functions/kim_fns.php');


$check=htmlspecialchars($_GET['check']);
if($check!='login') check_valid_user(); // se non si è autenticati è possibile fare il controllo del solo login


switch($check){
	
	case 'login': $codfiscale=strtoupper($_GET['codfiscale']);
				  $password=htmlspecialchars($_GET['password']);
				  try{echo check_login($codfiscale,$password);}
				  catch(Exception $e){echo $e->getMessage();}
				  break;
				
	case 'add_visit': $codfiscale=htmlspecialchars(strtoupper($_GET['codfiscale']));
					try{echo is_patient($codfiscale);}
					catch(Exception $e){echo $e->getMessage();}
					break;
				
	case 'change_appointment':  $codfiscale=htmlspecialchars(strtoupper($_GET['codfiscale']));
								try{echo is_patient($codfiscale);}
								catch(Exception $e){echo $e->getMessage();}
								break;
							
	case 'change_basic': try{echo true;}		// inserire qui i controlli
						 catch(Exception $e){echo $e->getMessage();}
						 break;
						
	case 'change_contact': 	try{echo true;}		// inserire qui i controlli
							catch(Exception $e){echo $e->getMessage();}
							break;
						
	case 'change_residence': try{echo true;}		// inserire qui i controlli
							 catch(Exception $e){echo $e->getMessage();}
							 break;
						
	case 'change_password': try{echo check_change_password($_GET);}		// inserire qui i controlli
							catch(Exception $e){echo $e->getMessage();}
							break;
							
	case 'add_patient': try{echo check_already_exists($_GET);}		// inserire qui i controlli
						catch(Exception $e){echo $e->getMessage();}
						break;
						
	case 'add_appointment': $codfiscale=htmlspecialchars(strtoupper($_GET['codfiscale']));
						 	try{echo is_patient($codfiscale);}
						 	catch(Exception $e){echo $e->getMessage();}
							break;	
						  
	case 'change_visit': $codfiscale=htmlspecialchars(strtoupper($_GET['codfiscale']));
						 try{echo is_patient($codfiscale);}
						 catch(Exception $e){echo $e->getMessage();}
						 break;	
					
					
	default: echo 'Il controllo richiesto non è supportato';
}
	
	
?>