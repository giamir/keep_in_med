<?php

require_once('db_fns.php');
require_once('profiles_fns.php');

function get_visit_info($id){ 

	$conn = db_connect();
	$result = $conn->query("SELECT * 
  							FROM Visit
                        	WHERE Id_Visit='$id'");
							
	$row=$result->fetch_assoc();		
	return $row;

} // end of get_visit_info


function process_add_visit($params){ 
	
	$codfiscale=htmlspecialchars($params['codfiscale']);
	is_patient($codfiscale);
	
	$datetime=$params['visityear'].'-'.$params['visitmonth'].'-'.$params['visitday'].' '.$params['visithour'].':'.$params['visitminute'];
	$diagnosi=htmlspecialchars($params['diagnosi']);
	$ricetta=htmlspecialchars($params['ricetta']);

	$conn = db_connect();
	
	$diagnosi = $conn->real_escape_string($diagnosi);
	$ricetta = $conn->real_escape_string($ricetta);
	
	$result = $conn->query("INSERT INTO Visit(Doctor,Patient,DateTime,Diagnosi,Ricetta)
  							VALUES('$_SESSION[codfiscale]','$codfiscale','$datetime','$diagnosi','$ricetta')");
	
	if(!$result) $_SESSION['failed'] = 'Non &egrave; possibile aggiungere la visita';
	else{
		if($params['id_appointment']) delete_appointment($params['id_appointment']);
		$_SESSION['success'] = 'Visita aggiunta correttamente';
	}
	$_SESSION['wait'] = 1;
	
	header("Location: ".BASE_URL."/php/visits.php");

} // end of process_add_visit




function process_change_visit($params){ 
	
	$codfiscale=htmlspecialchars($params['codfiscale']);
	is_patient($codfiscale);
	
	$id=$params['id_visit'];
	$datetime=$params['visityear'].'-'.$params['visitmonth'].'-'.$params['visitday'].' '.$params['visithour'].':'.$params['visitminute'];
	$diagnosi=htmlspecialchars($params['diagnosi']);
	$ricetta=htmlspecialchars($params['ricetta']);
	
	$conn = db_connect();
	
	$diagnosi = $conn->real_escape_string($diagnosi);
	$ricetta = $conn->real_escape_string($ricetta);
	
	$result = $conn->query("UPDATE Visit
							SET Patient='$codfiscale', DateTime='$datetime', Diagnosi='$diagnosi', Ricetta='$ricetta'
							WHERE Id_Visit='$id'");
	
	if(!$result || !$id) 
		$_SESSION['failed'] = 'Non &egrave; possibile modificare la visita';
	else
		$_SESSION['success'] = 'Visita modificata correttamente';

	$_SESSION['wait'] = 1;
	
	header("Location: ".BASE_URL."/php/view_visit.php?id_visit=".$id);

} // end of process_change_visit




function process_delete_visit($params){ 
	
	$id=$params['id_visit'];
	
	$conn = db_connect();
	$result = $conn->query("DELETE FROM Visit
                        	WHERE Id_Visit='$id'");
	
	if(!$result || !$id) 
		$_SESSION['failed'] = 'Non &egrave; possibile eliminare la visita';
	else
		$_SESSION['success'] = 'Visita eliminata correttamente';

	$_SESSION['wait'] = 1;
	
	header("Location: ".BASE_URL."/php/visits.php");

} // end of process_delete_visit
