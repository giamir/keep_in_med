<?php

if(!defined('KIM_ROOT')) 
	define('KIM_ROOT', str_replace('\\', '/', dirname(dirname(dirname(__FILE__)))) );

if(!defined('BASE_URL'))
	define('BASE_URL', substr(KIM_ROOT, strlen($_SERVER['DOCUMENT_ROOT'])-strlen(KIM_ROOT)));
	

if(!defined('DB_HOST')) 
	define('DB_HOST', 'localhost');
	
if(!defined('DB_USER')) 
	define('DB_USER', 'root');
	
if(!defined('DB_PASSWORD')) 
	define('DB_PASSWORD', '');
	
if(!defined('DB_DATABASE')) 
	define('DB_DATABASE', 'KIM');
	
	
date_default_timezone_set('Europe/Paris');
	
$monthnames = array(
					'1'=>'Gennaio',
					'2'=>'Febbraio',
					'3'=>'Marzo',
					'4'=>'Aprile',
					'5'=>'Maggio',
					'6'=>'Giugno',
					'7'=>'Luglio',
					'8'=>'Agosto',
					'9'=>'Settembre',
					'10'=>'Ottobre',
					'11'=>'Novembre',
					'12'=>'Dicembre'
				);
				
define ('MONTHS', serialize ($monthnames));
	
function convert_datetime_to_stamp($datetime){
	
	$datetimearray = explode (' ',$datetime);
	$date = $datetimearray[0];
	
	$yearmonthday = explode ('-',$date);
	$year = $yearmonthday[0]; $month = $yearmonthday[1]; $day = $yearmonthday[2];
	$date = implode(array($day, $month, $year),'/');	
	
	$time=null; $hour=null; $minute=null;
	if(sizeof($datetimearray)>1){ 
		$time = $datetimearray[1];
		$hourminutesecond = explode (':',$time);
		$hour = $hourminutesecond[0]; $minute = $hourminutesecond[1];
		$time = implode(array($hour, $minute),':');
	}
	
	$result = array ("year" => $year, "month" => $month, "day" => $day, "hour" => $hour, "minute" => $minute, "date" => $date, "time" => $time);
	
	return $result;
}

?>