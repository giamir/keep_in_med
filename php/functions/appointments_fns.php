<?php

require_once('db_fns.php');
require_once('profiles_fns.php');

function get_appointment_info($id){ 

	$conn = db_connect();
	$result = $conn->query("SELECT * 
  							FROM Appointment
                        	WHERE Id_Appointment='$id'");
	
	$row=$result->fetch_assoc();		
	return $row;

} // end of get_appointment_info
 
 
 
function next_appointments($doctor){ 

	$conn = db_connect();
	$result = $conn->query("SELECT * 
  							FROM Appointment
                        	WHERE Doctor='$doctor' AND Status=2 AND DATE(DateTime)>=DATE(NOW())
							ORDER BY DateTime ASC");
							
	return $result;

} // end of next_appointments



function pending_appointments($doctor){ 

	$conn = db_connect();
	$result = $conn->query("SELECT * 
  							FROM Appointment
                        	WHERE Doctor='$doctor' AND Status=0
							ORDER BY DateRequest ASC");
							
	return $result;

} // end of pending_appointments



function delete_appointment($id){ 

	$conn = db_connect();
	$result = $conn->query("DELETE FROM Appointment
                        	WHERE Id_Appointment='$id'");
							
	return $result;

} // end of delete_appointment




function process_delete_appointment($params){ 
	
	$id=$params['id_appointment'];
	
	$result=delete_appointment($id);
	
	if(!$result || !$id) 
		$_SESSION['failed'] = 'Non &egrave; possibile eliminare l\'appuntamento';
	else
		$_SESSION['success'] = 'Appuntamento eliminato correttamente';

	$_SESSION['wait'] = 1;
	
	header("Location: ".BASE_URL."/php/appointments.php");

} // end of process_delete_appointment




function process_change_appointment($params){ 
	
	$id=$params['id_appointment'];
	$patient=$params['codfiscale'];
	$datetime=$params['appointmentyear'].'-'.$params['appointmentmonth'].'-'.$params['appointmentday'].' '.$params['appointmenthour'].':'.$params['appointmentminute'];
	
	$conn = db_connect();
	$result = $conn->query("UPDATE Appointment
							SET Patient='$patient', DateTime='$datetime'
							WHERE Id_Appointment='$id'");
	
	if(!$result || !$id) 
		$_SESSION['failed'] = 'Non &egrave; possibile modificare l\'appuntamento';
	else
		$_SESSION['success'] = 'Appuntamento modificato correttamente';

	$_SESSION['wait'] = 1;
	
	header("Location: ".BASE_URL."/php/dashboard.php");

} // end of process_change_appointment




function process_delete_request($params){ 
	
	$id=$params['id_appointment'];
	
	$result=delete_appointment($id);
	
	if(!$result || !$id) 
		$_SESSION['failed'] = 'Non &egrave; possibile eliminare la richiesta';
	else
		$_SESSION['success'] = 'Richiesta eliminata correttamente';

	$_SESSION['wait'] = 1;
	
	header("Location: ".BASE_URL."/php/dashboard.php");

} // end of process_delete_request



function process_answer_request($params){ 
	
	$id=$params['id_appointment'];
	$appointment=get_appointment_info($params['id_appointment']);
	$datetime=$params['appointmentyear'].'-'.$params['appointmentmonth'].'-'.$params['appointmentday'].' '.$params['appointmenthour'].':'.$params['appointmentminute'];
	$request=$appointment['Request'];
	if($params['request']) $request=$request.'<strong>'.$_SESSION['name'].' '.$_SESSION['surname'].'</strong> ha scritto:<br>'.nl2br($params['request']).'<br>';
	
	$conn = db_connect();
	
	$request = $conn->real_escape_string($request);
	
	$result = $conn->query("UPDATE Appointment
							SET DateTime='$datetime', Status=1, Request='$request'
							WHERE Id_Appointment='$id'");
	
	if(!$result || !$id) 
		$_SESSION['failed'] = 'Non &egrave; possibile rispondere alla richiesta di appuntamento';
	else
		$_SESSION['success'] = 'Risposta inviata. In attesa della conferma del paziente.';

	$_SESSION['wait'] = 1;
	
	header("Location: ".BASE_URL."/php/dashboard.php");

} // end of process_answer_request



function process_add_appointment($params){ 
	
	$codfiscale=htmlspecialchars($params['codfiscale']);
	is_patient($codfiscale);
	
	$codfiscale=htmlspecialchars($params['codfiscale']);
	$datetime=$params['appointmentyear'].'-'.$params['appointmentmonth'].'-'.$params['appointmentday'].' '.$params['appointmenthour'].':'.$params['appointmentminute'];

	$conn = db_connect();
	$result = $conn->query("INSERT INTO Appointment(Doctor,Patient,DateTime,Status)
  							VALUES('$_SESSION[codfiscale]','$codfiscale','$datetime', 2)");
	
	if(!$result) 
		$_SESSION['failed'] = 'Non &egrave; possibile aggiungere l\'appuntamento';
	else
		$_SESSION['success'] = 'Appuntamento aggiunto correttamente';

	$_SESSION['wait'] = 1;
	
	header("Location: ".BASE_URL."/php/appointments.php");

} // end of process_add_appointment


function count_today_appointments($codfiscale){ 

	$conn = db_connect();
	$result = $conn->query("SELECT COUNT(*) AS Conteggio
					  		FROM Appointment
					 		WHERE DATE(DateTime) = DATE(NOW()) AND Status = 2 AND Doctor='$codfiscale'");
	
	$row=$result->fetch_assoc();
	
	if($row) return $row;
	

} // end of count_today_appointments



function process_add_request($params){ 
	
	$codfiscale=$params['codfiscale'];
	$datetime=$params['appointmentyear'].'-'.$params['appointmentmonth'].'-'.$params['appointmentday'].' '.$params['appointmenthour'].':'.$params['appointmentminute'];
	$request='<strong>'.$_SESSION['name'].' '.$_SESSION['surname'].'</strong> ha scritto:<br>'.nl2br($params['request']).'<br><br>';
	
	$conn = db_connect();
	
	$request = $conn->real_escape_string($request);
	
	$result = $conn->query("INSERT INTO Appointment(DateRequest, Doctor, Patient, DateTime, Status, Request)
							VALUES(DATE(NOW()), '$_SESSION[doctor]', '$_SESSION[codfiscale]', '$datetime', 0, '$request')");
	
	if(!$result) 
		$_SESSION['failed'] = 'Non &egrave; possibile richiedere un appuntamento';
	else
		$_SESSION['success'] = 'Richiesta Inviata. In attesa della risposta del medico.';

	$_SESSION['wait'] = 1;
	
	header("Location: ".BASE_URL."/php/dashboard.php");

} // end of process_add_request


function process_confirm_appointment($params){ 
	$id=$params['id_appointment'];
	
	$conn = db_connect();
	$result = $conn->query("UPDATE Appointment
							SET Status=2
							WHERE Id_Appointment='$id'");
	
	if(!$result || !$id) 
		$_SESSION['failed'] = 'Non &egrave; possibile confermare l\'appuntamento';
	else
		$_SESSION['success'] = 'Appuntamento confermato correttamente';

	$_SESSION['wait'] = 1;
	
	header("Location: ".BASE_URL."/php/dashboard.php");

} // end of process_confirm_appointment

?>