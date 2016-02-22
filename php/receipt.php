<?php 

session_start();
require_once 'functions/kim_fns.php';
require_once 'functions/fpdf/fpdf.php';
check_valid_user();

$id_visit=$_GET['id_visit'];
$visit=get_visit_info($id_visit);
if(!$visit) header("Location: ".BASE_URL."/php/dashboard.php");
$datetime=convert_datetime_to_stamp($visit['DateTime']);
$doctor=get_profile_info($visit['Doctor']);
$patient=get_profile_info($visit['Patient']);

// Crea PDF Ricetta

// impostazioni PDF
$pdf = new FPDF(); 
$pdf->addPage('P','A5');
$pdf->setTitle($datetime['year'].$datetime['month'].$datetime['day'].'ricetta'.$patient['CodFiscale'], true);
$pdf->setAutoPageBreak(false);


// genera header
$pdf->setFont("Helvetica", 'B', 14); 
$pdf->cell(0, 10, "Dott. ".$doctor['Name'].' '.$doctor['Surname']);
$pdf->ln(10);
$pdf->setFont("Helvetica", 'I', 10); 
$pdf->cell(0, 0, $doctor['Specialization']);
$pdf->ln(6);
$pdf->setFont("Helvetica", '', 8); 
$pdf->cell(0, 0, 'Tel. +39 '.$doctor['Phone']);
$pdf->ln(4);
$pdf->cell(0, 0, 'Email: '.$doctor['Email']);
$pdf->line(10, 35, 140, 35);
$pdf->ln(15);

// genera info paziente
$pdf->setFont("Helvetica", '', 9);
$pdf->cell(0, 0, 'Al paziente:');
$pdf->ln(5);
$pdf->setFont("Helvetica", 'I', 9); 
$pdf->cell(0, 0, $patient['Name'].' '.$patient['Surname']);
if($patient['Address'] && $patient['CAP'] && $patient['City'] && $patient['Province']){
$pdf->ln(5);
$pdf->cell(0, 0, $patient['Address']);
$pdf->ln(5);
$pdf->cell(0, 0, $patient['CAP'].' - '.$patient['City']);
$pdf->ln(5);
$pdf->cell(0, 0, $patient['Province']);
}
$pdf->ln(12);

// genera contenuto ricetta
$pdf->setFont("Helvetica", '', 10); 
$pdf->write(5, $visit['Ricetta']);

// genera data e firma medico
$pdf->SetY(-35);
$pdf->setFont("Helvetica", '', 9); 
$pdf->cell(0, 0, "Li, ".$datetime['date']);
$pdf->setFont("Helvetica", 'I', 9);
$pdf->SetX(-60);
$pdf->cell(0, 0, "Dott. ".$doctor['Name'].' '.$doctor['Surname']);


//genera footer
$pdf->line(10, 193, 140, 193);
$pdf->setY(-15);
$pdf->SetX(11);
$pdf->image(dirname(__FILE__).'/functions/fpdf/logo_black.png', null, null, 4, 4);
$pdf->setFont("Helvetica", '', 8);
$pdf->setY(-15);
$pdf->SetX(17);
$pdf->cell(0, 6, "Powered by Keep in Med");

//genera PDF e forza il download tramite browser
$pdf->output($datetime['year'].$datetime['month'].$datetime['day'].'ricetta'.$patient['CodFiscale'].'.pdf', 'D');



?>
