<?php

require_once('db_fns.php');
 
function do_html_header($title='',$id=''){ 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="it">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name = "author" lang = "it" content = "Giamir Buoncristiani">
	<meta name = "keywords" lang = "it" content = "Keep in Med, Medical Management System">

	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/css/<?php echo $id; ?>.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/favicon.ico"> 
    
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/js/utility.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/js/modal.js"></script>
    <?php if($id!='login'){ 
		echo '<script type="text/javascript" src="'.BASE_URL.'/js/menu.js"></script>'; 
		echo '<link rel="stylesheet" type="text/css" href="'.BASE_URL.'/css/menu.css">';
	}?>
    
    
    <title><?php if($title) echo $title.' - '; ?>Keep in Med</title> 
	<meta name="description" content="Keep in Med è un'applicazione web per la gestione e l'organizzazione di visite mediche.">

</head>


<body id='<?php echo $id; ?>'>

<?php if($id!='login') do_html_menu();?>
	
    <div id='content'>

<?php 
} // end of do_html_header 


function do_html_footer(){ 
?>

	</div><!-- end of content -->
    
    
    <div id='footer'>
        <p>Keep in Med &copy; <?php echo date('Y'); ?> | <a href="<?php echo BASE_URL; ?>/html/documentation.html" title="Documentazione">Documentazione</a></p>
    </div><!-- end of footer -->
    
</body>
</html>

<?php 
} // end of do_html_footer


function do_html_login(){ 
?>
			<div id="login_box">
                <h1><span>Keep in Med</span></h1>
                <h2><span>Medical Management System</span></h2>
                <button type="button" onclick="modalWindow=new Modal('login');">Accedi</button>
			</div><!-- end of login_box -->
<?php 
} // end of do_html_login


function do_html_menu(){ 
?>
        <div id="menu">
            <div id="menu-content">
                <ul id="navigation-left">
                    <li class="dashboard"><a href="dashboard.php" title="Dashboard"><span>Dashboard</span></a></li>
                    <?php if($_SESSION['auth']==1){ ?>
                    <li class="patients" title="Pazienti"><a href="patients.php">Pazienti</a></li>
                    <li class="visits"><a href="visits.php" title="Visite">Visite</a></li>
                    <li class="appointments"><a href="appointments.php" title="Appuntamenti">Appuntamenti</a></li>
                    <?php }?>
                    <?php if($_SESSION['auth']==2){ ?>
                    <li><a href="javascript: void(0)" onclick="modalWindow=new Modal('change_contact', {'codfiscale':'<?php echo $_SESSION['codfiscale']; ?>'});"  title="Aggiorna il tuo Profilo">Aggiorna Profilo</a></li>
                    <li><a href="view_profile.php?codfiscale=<?php echo $_SESSION['doctor']; ?>" title="Contatta Medico">Contatta Medico</a></li> 
                    <li><a href="javascript: void(0)" onclick="modalWindow=new Modal('add_request', {'codfiscale':'<?php echo $_SESSION['codfiscale']; ?>'});"  title="Richiedi Appuntamnento">Richiedi Appuntamento</a></li>
                    <?php }?>
                </ul>
                
                <ul id="navigation-right">
                    <li class="profile <?php if($_GET['codfiscale']==$_SESSION['codfiscale']) echo 'active'; ?>"><a href="view_profile.php?codfiscale=<?php echo $_SESSION['codfiscale']; ?>" title="Profilo"><?php echo $_SESSION['name'].' '.$_SESSION['surname'] ?></a></li>
                    <li class="logout"><a href="javascript: void(0);" onclick="modalWindow=new Modal('logout','',260);" title="Esci"><span>Esci</span></a></li>
                </ul>
            </div><!-- end of menu-content -->
            
            <?php if($_SESSION['success'] || $_SESSION['failed']){ ?>
            <div id="notice">
            	<?php 
				if($_SESSION['success']) echo '<p class="success">'.$_SESSION['success'].'</p>';
				if($_SESSION['failed']) echo '<p class="failed">'.$_SESSION['failed'].'</p>';
				if(!$_SESSION['wait']){$_SESSION['success']=''; $_SESSION['failed']='';}
				else $_SESSION['wait']--;
				?>
            </div><!-- end of notice -->
            <?php } ?>
        </div><!-- end of menu -->
        <script type="text/javascript">new Menu;</script>
			
            
<?php 
} // end of do_html_menu



function do_html_mainbox(){ 
?>
            <div id="mainbox" class="box">
        
                <object class="clock" width="220" height="90" name="clock" data="<?php echo BASE_URL; ?>/swf/clock.swf" type="application/x-shockwave-flash">
                    <param value="<?php echo BASE_URL; ?>/swf/clock.swf" name="movie">
                    <param value="transparent" name="wmode">
                </object>
            
                <div class="main">
                    <?php if($_SESSION['auth']==1) echo '<img src="'.BASE_URL.'/images/profiles/maledoctor.png" alt="Medico">'; 
						  if($_SESSION['auth']==2) echo '<img src="'.BASE_URL.'/images/profiles/malepatient.png" alt="Paziente">';
					?>
                    <h1><?php echo $_SESSION['name'].' '.$_SESSION['surname']; ?></h1>
                    <?php if($_SESSION['auth']==1) echo '<h3>Medico</h3>'; if($_SESSION['auth']==2) echo '<h3>Paziente</h3>';?>
                </div><!-- end of main -->
                
                <?php if($_SESSION['auth']==1) { ?>
                <div class="report">
				<p>Buongiorno <strong><?php echo $_SESSION['name']; ?></strong>, sono previsti ancora
				<strong><a href="<?php echo BASE_URL; ?>/php/appointments.php" title="Appuntamenti"><?php $count=count_today_appointments($_SESSION['codfiscale']); echo $count['Conteggio'];?></a></strong>
                appuntamenti per la giornata odierna.</p>
                	<a href="javascript: void(0)" onclick="modalWindow=new Modal('add_appointment');" class="add" title="Aggiungi Appuntamento"><span>Aggiungi</span> Appuntamento</a>
                	<a href="javascript: void(0)" onclick="modalWindow=new Modal('add_visit');" class="add" title="Aggiungi Visita"><span>Aggiungi</span> Visita</a>
                	<a href="javascript: void(0)" onclick="modalWindow=new Modal('add_patient');" class="add" title="Aggiungi Paziente"><span>Aggiungi</span> Paziente</a>             
                </div><!-- end of report -->
               	 <?php } ?>
            
            </div><!-- end of mainbox -->
			
            
<?php 
} // end of do_html_mainbox



function do_html_next_appointments(){
?>

            <div class="column">
                <div id="next_appointments" class="box list">
                
                    <h2>Prossimi Appuntamenti</h2>
             
                    <?php 
					$result=next_appointments($_SESSION['codfiscale']);
					if($result->num_rows==0) echo '<p>Non sono previsti appuntamenti</p>';
					else{
					?>
                    <table> 
                    <?php
						for($i=0; $i<5 && $row=$result->fetch_assoc(); $i++){
							$id=$row['Id_Appointment'];
							
							$patient=get_profile_info($row['Patient']);
							$namepatient=$patient['Name'];
							$surnamepatient=$patient['Surname'];
							
							$datetime=convert_datetime_to_stamp($row['DateTime']);
							
					?>
					<tr>
                    <td class="first"><span class="time"><?php echo $datetime['time']; ?></span><br><?php echo $datetime['date']; ?></td> 
                    <td><a href="view_profile.php?codfiscale=<?php echo $row['Patient']; ?>" title="Dettagli Paziente"><?php echo $namepatient.' '.$surnamepatient; ?></a></td> 
                    <td>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('add_visit',{'id_appointment':'<?php echo $id; ?>'});" class="handle" title="Effettua Visita"><span>Effettua Visita</span></a>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('delete_appointment',{'id_appointment':'<?php echo $id; ?>'},260);" class="delete" title="Elimina Appuntamento"><span>Elimina Appuntamento</span></a>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('change_appointment',{'id_appointment':'<?php echo $id; ?>'});" class="modify" title="Modifica Appuntamento"><span>Modifica Appuntamento</span></a>
                    </td>
					</tr>
                    <?php
						}
					?>
					</table>
                    <?php
					}
					?>
            
                </div><!-- end of next_appointments -->
            </div><!-- end of column -->
            
<?php 
} // end of do_html_next_appointments




function do_html_pending_appointments(){
?>

            <div class="column">
                <div id="pending_appointments" class="box list">
                
                    <h2>Richieste Appuntamento</h2>
  
                    <?php 
					$result=pending_appointments($_SESSION['codfiscale']);
					if($result->num_rows==0) echo '<p>Attualmente non sono presenti richieste</p>';
					else{
					?>
                    <table> 
                    <?php
						for($i=0; $i<5 && $row=$result->fetch_assoc(); $i++){
							$id=$row['Id_Appointment'];
							
							$patient=get_profile_info($row['Patient']);
							$namepatient=$patient['Name'];
							$surnamepatient=$patient['Surname'];
							
							$daterequest=convert_datetime_to_stamp($row['DateRequest']);
							
					?>
					<tr>
                    <td class="first"><a href="view_profile.php?codfiscale=<?php echo $row['Patient']; ?>" title="Dettagli Paziente"><?php echo $namepatient.' '.$surnamepatient; ?></a></td> 
                    <td>richiesta del <?php echo $daterequest['date']; ?></td> 
                    <td>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('delete_request',{'id_appointment':'<?php echo $id; ?>'},260);" class="delete" title="Elimina Richiesta"><span>Elimina Richiesta</span></a>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('answer_request',{'id_appointment':'<?php echo $id; ?>'});" class="modify" title="Rispondi alla Richiesta"><span>Rispondi alla Richiesta</span></a>
                    </td>
					</tr>
                    <?php
						}
					?>
					</table>
                    <?php
					}
					?>
            
                </div><!-- end of pending_appointments -->
            </div><!-- end of column -->
            
<?php 
} // end of do_html_pending_appointments



function do_html_profile($codfiscale){
	$profile=get_profile_info($codfiscale);
	$birthday=convert_datetime_to_stamp($profile['Birthday']);
	$monthnames= unserialize(MONTHS);
?>

	<div class="column">
	
    <div id="mainbox" class="box">
        <div class="main">
            <?php if($profile['auth']==1) echo '<img src="'.BASE_URL.'/images/profiles/maledoctor.png" alt="Medico">'; 
                  if($profile['auth']==2) echo '<img src="'.BASE_URL.'/images/profiles/malepatient.png" alt="Paziente">';
            ?>
            <h1><?php echo $profile['Name'].' '.$profile['Surname'] ?></h1>
            <?php if($profile['auth']==1) echo '<h3>Medico</h3>'; if($profile['auth']==2) echo '<h3>Paziente</h3>';?>
           <?php if($profile['auth']==2 && $_SESSION['auth']==1) { ?>
           <a href="javascript: void(0)" onclick="modalWindow=new Modal('delete_patient',{'codfiscale':'<?php echo $codfiscale; ?>'},260);" class="delete" title="Elimina Paziente"><span>Elimina Paziente</span></a>
           <?php } ?>
         </div><!-- end of main -->
     </div><!-- end of mainbox -->


    <div id="basic" class="box">
        <h2>Informazioni di Base</h2>
        <table>
        <tr>
        <td class="key">Codice Fiscale</td> <td><?php echo $profile['CodFiscale']; ?></td>
        </tr>
        <tr>
        <td class="key">Nome</td> <td><?php echo $profile['Name']; ?></td>
        </tr>
        <tr>
        <td class="key">Cognome</td> <td><?php echo $profile['Surname']; ?></td>
        </tr>
        <tr>
        <td class="key">Data di Nascita</td> <td><?php echo $birthday['day'].' '.$monthnames[intval($birthday['month'])].' '.$birthday['year']; ?></td>
        </tr>
        <?php if($profile['auth']==2){ ?>
        <tr>
        <td class="key">Sesso</td> <td><?php if($profile['Gender']=='M') echo 'Maschio'; else echo 'Femmina'; ?></td>
        </tr>
        <?php } ?>
        <?php if($profile['auth']==1){ ?>
        <tr>
        <td class="key">Specializzazione</td> <td><?php echo $profile['Specialization']; ?></td>
        </tr>
        <?php } ?>
        </table>
        
    <?php if($_SESSION['auth']==1){ ?>
    <a href="javascript: void(0)" onclick="modalWindow=new Modal('change_basic',{'codfiscale':'<?php echo $codfiscale; ?>'});" class="modify" title="Modifica"><span>Modifica</span></a>
    <?php } ?>
    
    </div><!-- end of basic -->
    
    </div><!-- end of column -->
    
    
    <div class="column">

    
    <div id="contact" class="box">
    <h2>Informazioni di Contatto</h2>
    
    <h4>Recapiti</h4>
    <table>
    <tr>
    <td class="key">Telefono</td> <td><?php echo $profile['Phone']; ?></td>
    </tr>
    <tr>
    <td class="key">Email</td> <td><a href="mailto:<?php echo $profile['Email']; ?>" title="Invia una mail"><?php echo $profile['Email']; ?></a></td>
    </tr>
    </table>
    
    <?php if($_SESSION['auth']==1){ ?>
    <a href="javascript: void(0)" onclick="modalWindow=new Modal('change_contact',{'codfiscale':'<?php echo $codfiscale; ?>'});" class="modify" title="Modifica"><span>Modifica</span></a>
    <?php } ?>
    
    <?php if($profile['auth']==2){ ?>
    <h4>Residenza</h4>
    <table>
    <tr>
    <td class="key">Indirizzo</td> <td><?php echo $profile['Address']; ?></td>
    </tr>
    <tr>
    <td class="key">Città</td> <td><?php echo $profile['City']; ?></td>
    </tr>
    <tr>
    <td class="key">Provincia</td> <td><?php echo $profile['Province']; ?></td>
    </tr>
    <tr>
    <td class="key">Regione</td> <td><?php echo $profile['Region']; ?></td>
    </tr>
    <tr>
    <td class="key">CAP</td> <td><?php if($profile['CAP']) echo $profile['CAP']; ?></td>
    </tr>
    </table>
    
    <?php if($_SESSION['auth']==1){ ?>
    <a href="javascript: void(0)" onclick="modalWindow=new Modal('change_residence',{'codfiscale':'<?php echo $codfiscale; ?>'});" class="modify" title="Modifica"><span>Modifica</span></a>
    <?php } ?>
    
    <?php } ?>
    
    </div> <!-- end of contact -->
       
    </div><!-- end of column -->

<?php 
} // end of do_html_profile





function do_html_patients(){

$letters = range('A', 'Z');
$conn=db_connect();
$i=0;
foreach($letters as $letter){
	$result=$conn->query("SELECT Surname, Name, CodFiscale
				  FROM Patient
				  WHERE Surname LIKE '$letter%'
				  ORDER BY Surname ASC");
				  
	if($result->num_rows!=0){ ?>
		<?php if($i%3==0) echo'<div class="column clear">';
        else echo '<div class="column">'; ?>
        <div class="box">
        	<h2><?php echo $letter; ?></h2>
            <?php for(;$row=$result->fetch_assoc();){ ?>
                <p>
                <a href="view_profile.php?codfiscale=<?php echo $row['CodFiscale']; ?>" title="Dettagli Paziente"><?php echo $row['Surname'].' '.$row['Name']; ?></a>
                <a href="javascript: void(0)" onclick="modalWindow=new Modal('delete_patient',{'codfiscale':'<?php echo $row['CodFiscale']; ?>'},260);" class="delete" title="Elimina Paziente"><span>Elimina Paziente</span></a>
                <a href="javascript: void(0)" onclick="modalWindow=new Modal('add_visit',{'codfiscale':'<?php echo $row['CodFiscale']; ?>'});" class="handle" title="Effettua una Visita"><span>Effettua una Visita</span></a>
                <a href="javascript: void(0)" onclick="modalWindow=new Modal('add_appointment',{'codfiscale':'<?php echo $row['CodFiscale']; ?>'});" class="modify" title="Aggiungi Appuntamento"><span>Aggiungi Appuntamento</span></a>
                </p>
            <?php } ?>
        </div>
        </div>
	<?php 
		$i++;
      }
}    

} // end of do_html_patients



function do_html_visit($id_visit){
	
$visit=get_visit_info($id_visit);
$datetime=convert_datetime_to_stamp($visit['DateTime']);
$patient=get_profile_info($visit['Patient']);
$doctor=get_profile_info($visit['Doctor']);
?> 


<div class="column">
	
    <div id="mainbox" class="box">
            
            <h1>Visita</h1>
            <table>
                <tr>
                <td class="key">Identificativo</td> <td><?php echo $visit['Id_Visit']; ?></td>
                </tr>
                <tr>
                <td class="key">Data</td> <td><?php echo $datetime['date'].' - '.$datetime['time']; ?></td>
                </tr>
                <tr>
                <td class="key">Paziente</td> <td><a href="view_profile.php?codfiscale=<?php echo $patient['CodFiscale']; ?>" title="Dettagli Paziente"><?php echo $patient['Name'].' '.$patient['Surname']; ?></a></td>
                </tr>
                <tr>
                <td class="key">Medico</td> <td><a href="view_profile.php?codfiscale=<?php echo $doctor['CodFiscale']; ?>" title="Dettagli Medico"><?php echo $doctor['Name'].' '.$doctor['Surname']; ?></a></td>
                </tr>
            </table>

            <div id="action">
            <a href="<?php echo BASE_URL.'/php/receipt.php?id_visit='.$visit['Id_Visit']; ?>" class="download" title="Scarica Ricetta"><span>Scarica Ricetta</span></a>
            <?php if($_SESSION['auth']==1){ ?>
            <a href="javascript: void(0)" onclick="modalWindow=new Modal('change_visit',{'id_visit':'<?php echo $visit['Id_Visit']; ?>'});" class="modify" title="Modifica Visita"><span>Modifica Visita</span></a>
            <a href="javascript: void(0)" onclick="modalWindow=new Modal('delete_visit',{'id_visit':'<?php echo $visit['Id_Visit']; ?>'}, 260);" class="delete" title="Elimina Visita"><span>Elimina Visita</span></a>
            <?php } ?>
            </div><!-- end of action -->
            
    </div><!-- end of mainbox -->
    
</div><!-- end of column -->
    
    
<div class="column">
    
    <div class="box">
    <h2>Dettagli Visita</h2>
    
    <h4>Diagnosi</h4>
    <pre><?php echo $visit['Diagnosi']; ?></pre>
   
    

    <h4>Ricetta</h4>
 	<pre><?php echo $visit['Ricetta']; ?></pre>
    
    </div> 
       
</div><!-- end of column -->

<?php
} // end of do_html_visit





function do_html_visits(){

$monthnames= unserialize(MONTHS);
$conn=db_connect();

$result=$conn->query("SELECT Id_Visit, Patient, DateTime, YEAR(DateTime) AS Y, MONTH(DateTime) AS M, DAY(DateTime) AS D
					  FROM Visit
					  ORDER BY Y DESC, M DESC, DateTime ASC");
				  
if($result->num_rows!=0){
	$row=$result->fetch_assoc();
	for($i=0;$row && $i<12;$i++){
?>	
	<?php if($i%2==0) echo '<div class="column clear">';
			else echo '<div class="column">'; ?>
        <div class="box list">
        <h2><?php echo $monthnames[$row['M']].' '.$row['Y']; ?></h2>
        <table>
<?php
		$row2=$row;
		for($j=0; $row['Y']==$row2['Y'] && $row['M']==$row2['M']; $j++){ 
			$datetime=convert_datetime_to_stamp($row2['DateTime']);
			$patient=get_profile_info($row2['Patient']);
?>
					<tr>
                    <td class="first"><?php echo $datetime['date']; ?></td> 
                    <td><a href="view_profile.php?codfiscale=<?php echo $patient['CodFiscale']; ?>" title="Dettagli Paziente"><?php echo $patient['Name'].' '.$patient['Surname']; ?></a></td> 
                    <td>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('delete_visit',{'id_visit':'<?php echo $row2['Id_Visit']; ?>'},260);" class="delete" title="Elimina Visita"><span>Elimina Visita</span></a>
                    <a href="<?php echo BASE_URL.'/php/view_visit.php?id_visit='.$row2['Id_Visit']; ?>" class="modify" title="Vedi Visita"><span>Vedi Visita</span></a>
                    </td>
					</tr>
	
<?php 
			$row2=$result->fetch_assoc();
		}
		$row=$row2;
?>
		</table>
		</div><!--end of box -->
    </div><!-- end of column -->
	
<?php
	}
}

} // end of do_html_visits






function do_html_appointments(){

$conn=db_connect();

$today=$conn->query("SELECT *
					  FROM Appointment
					  WHERE DATE(DateTime) = DATE(NOW()) AND Status = 2
					  ORDER BY DateTime");
					  
$tomorrow=$conn->query("SELECT *
						FROM Appointment
						WHERE DATE(DateTime) = DATE(NOW() + INTERVAL 1 DAY) AND Status = 2
						ORDER BY DateTime");
						
$thisweek=$conn->query("SELECT *
						FROM Appointment
						WHERE (DATE(DateTime) BETWEEN DATE(NOW() + INTERVAL 2 DAY) AND DATE(NOW() + INTERVAL 7 DAY)) AND Status = 2
						ORDER BY DateTime");
				  
$thismonth=$conn->query("SELECT *
						 FROM Appointment
						 WHERE (DATE(DateTime) BETWEEN DATE(NOW() + INTERVAL 8 DAY) AND DATE(NOW() + INTERVAL 31 DAY)) AND Status = 2
						 ORDER BY DateTime");
						 
$thisyear=$conn->query("SELECT *
						FROM Appointment
						WHERE (DATE(DateTime) BETWEEN DATE(NOW() + INTERVAL 32 DAY) AND DATE(NOW() + INTERVAL 365 DAY)) AND Status = 2
						ORDER BY DateTime");
						
?>

<?php function display_appointments($name, $result){ ?>									  
            <?php if($name=='Oggi' || $name=='Prossima Settimana' || $name=='Prossimo Anno') echo '<div class="column clear">';
					else echo '<div class="column">';
			
			 ?>
                <div class="box list">
                
                    <h2><?php echo $name; ?></h2>
             
                    <?php 
					if($result->num_rows==0) echo '<p>Non sono previsti appuntamenti.</p>';
					else{
					?>
                    <table> 
                    <?php
						for($i=0; $row=$result->fetch_assoc(); $i++){
							$id=$row['Id_Appointment'];
							$patient=get_profile_info($row['Patient']);
							$datetime=convert_datetime_to_stamp($row['DateTime']);
							
					?>
					<tr>
                    <td class="first"><?php if($name=='Oggi' || $name=='Domani') echo '<span class="time">'.$datetime['time'].'</span><br>'; ?><?php echo $datetime['date']; ?></td> 
                    <td><a href="view_profile.php?codfiscale=<?php echo $row['Patient']; ?>" title="Dettagli Paziente"><?php echo $patient['Name'].' '.$patient['Surname']; ?></a></td> 
                    <td>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('add_visit',{'id_appointment':'<?php echo $id; ?>'});" class="handle" title="Effettua Visita"><span>Effettua Visita</span></a>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('delete_appointment',{'id_appointment':'<?php echo $id; ?>'},260);" class="delete" title="Elimina Appuntamento"><span>Elimina Appuntamento</span></a>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('change_appointment',{'id_appointment':'<?php echo $id; ?>'});" class="modify" title="Modifica Appuntamento"><span>Modifica Appuntamento</span></a>
                    </td>
					</tr>
                    <?php
						}
					?>
					</table>
                    <?php
					}
					?>
            
                </div>
            </div><!-- end of column -->
<?php } 
display_appointments('Oggi', $today);
display_appointments('Domani', $tomorrow);
display_appointments('Prossima Settimana', $thisweek);
display_appointments('Prossimo Mese', $thismonth);
display_appointments('Prossimo Anno', $thisyear);

} // end of do_html_appointments





function do_html_patient_visits(){

$conn=db_connect();

$result=$conn->query("SELECT *
					  FROM Visit
					  WHERE Patient='$_SESSION[codfiscale]'
					  ORDER BY DateTime DESC");
?>  
<div class="column">
    <div class="box list">
    <h2>Le tue visite</h2>
<?php
if($result->num_rows!=0){ ?>
	<table>
<?php 
		for($i=0; $row=$result->fetch_assoc(); $i++){ 
			$datetime=convert_datetime_to_stamp($row['DateTime']);
?>
					<tr>
                    <td class="first"><?php echo $datetime['date']; ?></td> 
                    <td><a href="view_profile.php?codfiscale=<?php echo $_SESSION['codfiscale']; ?>" title="Dettagli Paziente"><?php echo $_SESSION['name'].' '.$_SESSION['surname']; ?></a></td> 
                    <td>
                    <a href="<?php echo BASE_URL.'/php/view_visit.php?id_visit='.$row['Id_Visit']; ?>" class="modify" title="Vedi Visita"><span>Vedi Visita</span></a>
                    </td>
					</tr>
	
<?php 
		}
?>
		</table>
<?php
} else echo '<p>Non hai effettuato nessuna visita</p>'; ?>

		</div><!--end of box -->
    </div><!-- end of column -->
<?php
} // end of do_html_patient_visits





function do_html_patient_appointments(){

$conn=db_connect();

$result=$conn->query("SELECT *
					  FROM Appointment
					  WHERE Patient='$_SESSION[codfiscale]'
					  ORDER BY DateTime");
?>  
<div class="column">
    <div class="box list">
    <h2>I tuoi appuntamenti</h2>
<?php
if($result->num_rows!=0){ ?>
	<table>
<?php 
		for($i=0; $row=$result->fetch_assoc(); $i++){ 
			$datetime=convert_datetime_to_stamp($row['DateTime']);
?>
					<tr>
                    <td class="first"><span class="time"><?php echo $datetime['time']; ?></span><br><?php echo $datetime['date']; ?></td> 
                    <td>
					<?php switch($row['Status']){
						case 0: echo 'in attesa di risposta'; break; 
						case 1: echo 'da confermare'; break; 
						case 2: echo 'confermato'; break; 
					}
					?>
                    </td> 
                    <td>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('delete_request',{'id_appointment':'<?php echo $row['Id_Appointment']; ?>'},260);" class="delete" title="Elimina"><span>Elimina</span></a>
                    <?php if($row['Status']==1){ ?>
                    <a href="javascript: void(0)" onclick="modalWindow=new Modal('confirm_appointment',{'id_appointment':'<?php echo $row['Id_Appointment']; ?>'});" class="modify" title="Conferma Appuntamento"><span>Conferma Appuntamento</span></a>
					<?php } ?>
                    </td>
					</tr>
	
<?php 
		}
?>
		</table>
<?php
} else echo '<p>Non sono presenti appuntamenti.</p>'; ?>

		</div><!--end of box -->
    </div><!-- end of column -->
<?php
} // end of do_html_patient_appointments
?>