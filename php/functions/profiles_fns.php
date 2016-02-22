<?php

require_once('db_fns.php');
 
function check_login($codfiscale, $password){ 

	if (isset($_SESSION['codfiscale'])) throw new Exception('Sei già autenticato come '.$_SESSION['name'].' '.$_SESSION['surname']);

	try{$conn = db_connect();}
	catch(Exception $e){echo $e->getMessage();}
	
	$result = $conn->query("select CodFiscale 
  							from Doctor
                        	where CodFiscale='$codfiscale' and Password = sha1('$password')
						 	union
							select CodFiscale 
  							from Patient
                         	where CodFiscale='$codfiscale' and Password = sha1('$password')");
							
	if (!$result || $result->num_rows==0)
		throw new Exception('Codice Fiscale e/o Password non corretti.');
		
  
	if ($result->num_rows==1)
		return true;
	else 
		throw new Exception('Errore di Sistema: ci sono più utenti con le stesse credenziali.');

} // end of check_login



function process_login($params){ // per il momento il dottore curante è unico (il paziente non può scegliere fra più dottori)
	$codfiscale = $params['codfiscale'];
	$password = $params['password'];
	
	check_login($codfiscale, $password); 

	$conn = db_connect();
	$doctor = $conn->query("select CodFiscale, Name, Surname
  							from Doctor
                        	where CodFiscale='$codfiscale' and Password = sha1('$password')");
							
	$patient = $conn->query("select CodFiscale, Name, Surname
  							from Patient
                        	where CodFiscale='$codfiscale' and Password = sha1('$password')");
							
	$patient_doctor = $conn->query("select CodFiscale
  									from Doctor");
	$patient_doctor=$patient_doctor->fetch_assoc();
		
  
	if ($doctor->num_rows==1){
		$row=$doctor->fetch_assoc();
		$_SESSION['auth'] = 1;
	}
	else if ($patient->num_rows==1){
		$row=$patient->fetch_assoc();
		$_SESSION['auth'] = 2;
		$_SESSION['doctor'] = $patient_doctor['CodFiscale'];
	}
	else 
		throw new Exception('Errore di login: effettua nuovamente l\'accesso.');
		
	$_SESSION['codfiscale'] = $row['CodFiscale'];
	$_SESSION['name'] = $row['Name'];
	$_SESSION['surname'] = $row['Surname'];
	$_SESSION['success']='';
	$_SESSION['failed']='';
	
	header("Location: ".BASE_URL."/php/dashboard.php");

} // end of process_login


function process_logout(){ 

	session_unset();
	session_destroy();
	
	header("Location: ".BASE_URL."/");

} // end of process_logout



function get_profile_info($codfiscale){ 

	$conn = db_connect();
	$doctor = $conn->query("select *
  							from Doctor
                        	where CodFiscale='$codfiscale'");
							
	$patient = $conn->query("select *
  							from Patient
                        	where CodFiscale='$codfiscale'");
		
  	$row=null;
  
	if ($doctor->num_rows==1){
		$row=$doctor->fetch_assoc();
		$row['auth']=1;
	}
		
	else if ($patient->num_rows==1){
		$row=$patient->fetch_assoc();
		$row['auth']=2;
	}
	
	return $row;

} // end of get_profile_info



function is_patient($codfiscale){ 

	$conn = db_connect();
							
	$patient = $conn->query("select *
  							from Patient
                        	where CodFiscale='$codfiscale'");
		
	if ($patient->num_rows==1)
		return true;
	else
		throw new Exception('Questo codice fiscale non e\' presente nel database pazienti.');

} // end of is_patient

function check_valid_user(){ 

	if (!isset($_SESSION['auth'])){
		header("Location: ".BASE_URL."/");
		exit;
	}

} // end of check_valid_user




function process_change_basic($params){
	$codfiscale=strtoupper($params['codfiscale']);
	$newcodfiscale=strtoupper($params['newcodfiscale']);
	$name=htmlspecialchars($params['name']);
	$surname=htmlspecialchars($params['surname']);
	$specialization=htmlspecialchars($params['specialization']);
	
	$profile=get_profile_info($params['codfiscale']);
	$birthday=$params['birthyear'].'-'.$params['birthmonth'].'-'.$params['birthday'];
	

	$conn = db_connect();
	
	$name = $conn->real_escape_string($name);
	$surname = $conn->real_escape_string($surname);
	$specialization = $conn->real_escape_string($specialization);
	
	if($profile['auth']==1){
	$result = $conn->query("UPDATE Doctor
  							SET CodFiscale='$newcodfiscale', Name='$name', Surname='$surname', Birthday='$birthday', Specialization='$specialization'
                        	WHERE CodFiscale='$codfiscale'");
	}
	else{
	$result = $conn->query("UPDATE Patient
  							SET CodFiscale='$newcodfiscale', Name='$name', Surname='$surname', Birthday='$birthday', Gender='$params[gender]'
                        	WHERE CodFiscale='$codfiscale'");
	}
	
	$_SESSION['wait'] = 1;
	
	if(!$result) {
		$_SESSION['failed'] = 'Non &egrave; possibile aggiornare il profilo';
		header("Location: ".BASE_URL."/php/view_profile.php?codfiscale=".$codfiscale);
	}
	else{
		$_SESSION['success'] = 'Profilo aggiornato correttamente.';
		if($_SESSION['codfiscale']==$codfiscale) {
			$_SESSION['codfiscale'] = $newcodfiscale;
			$_SESSION['name'] = $name;
			$_SESSION['surname'] = $surname;
		}
		header("Location: ".BASE_URL."/php/view_profile.php?codfiscale=".$newcodfiscale);
	}

} // end of process_change_basic





function process_change_contact($params){
	$codfiscale=strtoupper($params['codfiscale']);
	$phone=htmlspecialchars($params['phone']);
	$email=htmlspecialchars($params['email']);

	$profile=get_profile_info($codfiscale);
	
	$conn = db_connect();
	
	$phone = $conn->real_escape_string($phone);
	$email = $conn->real_escape_string($email);
	
	if ($profile['auth']==1){
	$result = $conn->query("UPDATE Doctor
  							SET Phone='$phone', Email='$email'
                        	WHERE CodFiscale='$codfiscale'");
	}
	
	if ($profile['auth']==2){
	$result = $conn->query("UPDATE Patient
  							SET Phone='$phone', Email='$email'
                        	WHERE CodFiscale='$codfiscale'");
	}
	
	$_SESSION['wait'] = 1;
	
	if(!$result) 
		$_SESSION['failed'] = 'Non &egrave; possibile aggiornare il profilo';
	else
		$_SESSION['success'] = 'Profilo aggiornato correttamente.';
	
	header("Location: ".BASE_URL."/php/view_profile.php?codfiscale=".$codfiscale);

} // end of process_change_contact


function process_change_residence($params){
	$codfiscale=strtoupper($params['codfiscale']);
	$address=htmlspecialchars($params['address']);
	$city=htmlspecialchars($params['city']);
	$region=htmlspecialchars($params['region']);
	$province=htmlspecialchars($params['province']);
	$cap=htmlspecialchars($params['cap']);
	
	$conn = db_connect();
	
	$address = $conn->real_escape_string($address);
	$city = $conn->real_escape_string($city);
	
	$result = $conn->query("UPDATE Patient
  							SET Address='$address', City='$city', Region='$region', Province='$province', CAP='$cap'
                        	WHERE CodFiscale='$codfiscale'");
	
	
	$_SESSION['wait'] = 1;
	
	if(!$result) 
		$_SESSION['failed'] = 'Non &egrave; possibile aggiornare il profilo';
	else
		$_SESSION['success'] = 'Profilo aggiornato correttamente.';
	
	header("Location: ".BASE_URL."/php/view_profile.php?codfiscale=".$codfiscale);

} // end of process_change_contact




function check_change_password($params){
	$codfiscale=strtoupper($params['codfiscale']);
	$oldpassword=htmlspecialchars($params['old_password']);
	
	$conn = db_connect();
	if($_SESSION['auth']==1){
	$result = $conn->query("SELECT *
  							FROM Doctor
                        	WHERE CodFiscale='$codfiscale' AND Password = sha1('$oldpassword')");
	}
	else{
	$result = $conn->query("SELECT *
  							FROM Patient
                        	WHERE CodFiscale='$codfiscale' AND Password = sha1('$oldpassword')");
	}
	
	$_SESSION['wait'] = 1;
	
	if(!$result || $result->num_rows!=1) 
		throw new Exception('La vecchia password non e\' corretta');
	else
		return true;

} // end of check_change_password




function process_change_password($params){
	$codfiscale=strtoupper($params['codfiscale']);
	$oldpassword=htmlspecialchars($params['old_password']);
	$newpassword=htmlspecialchars($params['new_password']);
	
	check_change_password($params);
	
	$conn = db_connect();
	if($_SESSION['auth']==1){
	$result = $conn->query("UPDATE Doctor
  							SET Password=sha1('$newpassword')
                        	WHERE CodFiscale='$codfiscale'");
	}
	else{
	$result = $conn->query("UPDATE Patient
  							SET Password=sha1('$newpassword')
                        	WHERE CodFiscale='$codfiscale'");
	}
	
	$_SESSION['wait'] = 1;
	
	if(!$result) 
		$_SESSION['failed'] = 'Non &egrave; possibile modificare la password';
	else
		$_SESSION['success'] = 'Password modificata correttamente.';
	
	header("Location: ".BASE_URL."/php/view_profile.php?codfiscale=".$codfiscale);

} // end of process_change_password





function process_delete_patient($params){
	$codfiscale=$params['codfiscale'];
	
	$conn = db_connect();

	$result = $conn->query("DELETE FROM Patient
                        	WHERE CodFiscale='$codfiscale'");

	$_SESSION['wait'] = 1;
	
	if(!$result) 
		$_SESSION['failed'] = 'Non &egrave; possibile eliminare il paziente';
	else
		$_SESSION['success'] = 'Paziente eliminato correttamente';
	
	header("Location: ".BASE_URL."/php/patients.php");

} // end of process_delete_patient




function check_already_exists($params){
	$codfiscale=$params['codfiscale'];
	
	$conn = db_connect();
	$result = $conn->query("SELECT * 
							FROM Patient
                        	WHERE CodFiscale='$codfiscale'");

	$_SESSION['wait'] = 1;
	
	if(!$result || $result->num_rows!=0) 
		throw new Exception('Il paziente risulta essere gia\' presente nel database');
	else
		return true;

} // end of check_already_exists




function process_add_patient($params){
	$codfiscale=strtoupper($params['codfiscale']);
	$password=htmlspecialchars($params['new_password']);
	$name=htmlspecialchars($params['name']);
	$surname=htmlspecialchars($params['surname']);
	$birthday=$params['birthyear'].'-'.$params['birthmonth'].'-'.$params['birthday'];
	$gender=htmlspecialchars($params['gender']);
	$phone=htmlspecialchars($params['phone']);
	$email=htmlspecialchars($params['email']);
	$address=htmlspecialchars($params['address']);
	$city=htmlspecialchars($params['city']);
	$province=htmlspecialchars($params['province']);
	$region=htmlspecialchars($params['region']);
	$cap=htmlspecialchars($params['cap']);
	
	
	check_already_exists($params);
	
	$conn = db_connect();
	
	$name = $conn->real_escape_string($name);
	$surname = $conn->real_escape_string($surname);
	$city = $conn->real_escape_string($city);
	$address = $conn->real_escape_string($address);
	$province = $conn->real_escape_string($province);
	$region = $conn->real_escape_string($region);

	$result = $conn->query("INSERT INTO Patient(CodFiscale, Password, Name, Surname, Birthday, Gender, Phone, Email, Address, City, Province, Region, CAP)
  							VALUES('$codfiscale', sha1('$password'), '$name', '$surname', '$birthday', '$gender', '$phone', '$email', '$address', '$city', '$province', '$region', '$cap')");
	
	$_SESSION['wait'] = 1;
	
	if(!$result) 
		$_SESSION['failed'] = 'Non &egrave; possibile aggiungere il paziente'.$codfiscale.sha1('$password').$name.$surname.$birthday.$gender.$phone.$email. $address.$city.$province.$region.$cap;
	else
		$_SESSION['success'] = 'Paziente aggiunto correttamente.';
	
	header("Location: ".BASE_URL."/php/patients.php");

} // end of process_add_patient
?>