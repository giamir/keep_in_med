<?php

require_once('db_fns.php');
 
function do_iframe_header(){ 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="it">

<head>

	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/css/modal.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/css/select.css">

    <script type="text/javascript" src="<?php echo BASE_URL; ?>/js/validate.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/js/select.js"></script>
    
    <title>Keep in Med</title>

</head>


<body class="modal">

	<div id="modal-box">

<?php 
} // end of do_iframe_header 


function do_iframe_footer(){ 
?>
	</div><!-- end of modal-box -->
    
</body>
</html>

<?php 
} // end of do_iframe_footer


function do_iframe_login(){ 
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Login</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="login" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="login">
                
                <table>
                
                    <tr>
                        <td class="key"><label>Codice Fiscale</label></td>
                        <td class="field"><input type="text" class="required codfiscale" name="codfiscale">
                        <td class="message"></td>
                    </tr>
                    
                    <tr>
                        <td class="key"><label>Password</label></td>
                        <td class="field"><input type="password" class="required password" name="password"></td>
                        <td class="message"></td>
                    </tr>
                    
                </table>
                
                <div id="ajax_error"></div>
                
                <input class="submit" type="submit" value="Accedi">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
            <script type="text/javascript">new FormValidator('login');</script> 
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_login



function do_iframe_logout(){ 
?>
		<div id="modal-top">
  
            <h2>Logout</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="logout" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="logout">
                
                
                <input class="submit" type="submit" onclick="parent.modalWindow.success();" value="Esci">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_login



function do_iframe_add_visit($params){
	if(isset($params['codfiscale']))$patient=$params['codfiscale'];
	if(!isset($patient) && isset($params['id_appointment'])){
		$patient=get_appointment_info($params['id_appointment']);
		$patient=$patient['Patient'];
	}
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Aggiungi Visita</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="add_visit" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="add_visit">
                <?php if(isset($params['id_appointment'])) echo'<input type="hidden" name="id_appointment" value="'.$params['id_appointment'].'">'; ?>
                
                <table>
                
                    <tr>
                        <td class="key"><label>Codice Fiscale Paziente</label></td>
                        <td class="field"><input type="text" class="required codfiscale" name="codfiscale" value="<?php if(isset($patient)) echo $patient; ?>">
                        <td class="message"></td>
                    </tr>
                    
                 	<tr>
                        <td class="key"><label>Data</label></td>
                        <td class="field">
                        <select name="visitday" class="day">
                          <?php
						  	$day = date('j');
						  	for($i=1; $i<=31; $i++){
								if($i==$day) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('add_visit','visitday','day');</script>
                         
                        <select name="visitmonth" class="month">
                            <?php
							$monthnames= unserialize(MONTHS);
						  	$month = date('n');
						  	for($i=1; $i<=12; $i++){
								if($i==$month) echo '<option value="'.$i.'" selected>'.$monthnames[$i].'</option>';
								else echo '<option value="'.$i.'">'.$monthnames[$i].'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('add_visit','visitmonth','month');</script>
                        <input type="text" class="required numeric exact_length[4] year" name="visityear" value="<?php echo date('Y'); ?>">
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <tr>
                        <td class="key"><label>Ora</label></td>
                        <td class="field">
                        <select name="visithour" class="hour">
                          <?php
						  $hour = date('H');
						  	for($i=0; $i<24; $i++){
								if($i==$hour) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('add_visit','visithour','hour');</script>
                         
                        <select name="visitminute" class="minute">
                            <?php
						  	$minute = date('i');
						  	for($i=0; $i<60; $i++){
								if($i==$minute) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('add_visit','visitminute','minute');</script>
                        </td>
            			<td class="message"></td>
           		</tr>
 
                <tr>
                <td class="key"><label>Diagnosi</label></td>
                <td class="textarea" colspan="2">
                <textarea  class="" name="diagnosi"></textarea>
                </td>
                </tr>
                
                <tr>
                <td class="key"><label>Ricetta</label></td>
                <td class="textarea" colspan="2">
                <textarea  class="" name="ricetta"></textarea>
                </td>
                </tr>
 
                </table>
                
                <div id="ajax_error"></div>
                
                <input class="submit" type="submit" value="Aggiungi">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
            <script type="text/javascript">new FormValidator('add_visit');</script> 
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_add_visit



function do_iframe_delete_appointment($params){ 
?>
		<div id="modal-top">
  
            <h2>Elimina Appuntamento</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="delete_appointment" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="delete_appointment">
                <input type="hidden" name="id_appointment" value="<?php echo $params['id_appointment']; ?>">
                
                <input class="submit" type="submit" onclick="parent.modalWindow.success();" value="Elimina">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_delete_appointment




function do_iframe_change_appointment($params){
		$appointment=get_appointment_info($params['id_appointment']);
		$patient=$appointment['Patient'];
		$datetime=convert_datetime_to_stamp($appointment['DateTime']);
		
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Modifica Appuntamento</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="change_appointment" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="change_appointment">
                <input type="hidden" name="id_appointment" value="<?php echo $params['id_appointment']; ?>">
                
                <table>
                
                    <tr>
                        <td class="key"><label>Codice Fiscale Paziente</label></td>
                        <td class="field"><input type="text" class="required codfiscale" name="codfiscale" value="<?php echo $patient; ?>">
                        <td class="message"></td>
                    </tr>
                    
                 	<tr>
                        <td class="key"><label>Data</label></td>
                        <td class="field">
                        <select name="appointmentday" class="day">
                          <?php
						  	$day = $datetime['day'];
						  	for($i=1; $i<=31; $i++){
								if($i==$day) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('change_appointment','appointmentday','day');</script>
                         
                        <select name="appointmentmonth" class="month">
                            <?php
							$monthnames= unserialize(MONTHS);
						  	$month = $datetime['month'];
						  	for($i=1; $i<=12; $i++){
								if($i==$month) echo '<option value="'.$i.'" selected>'.$monthnames[$i].'</option>';
								else echo '<option value="'.$i.'">'.$monthnames[$i].'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('change_appointment','appointmentmonth','month');</script>
                        <?php $year = date('Y'); ?>
                        <input type="text" class="required year" name="appointmentyear" value="<?php echo $datetime['year']; ?>">
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <tr>
                        <td class="key"><label>Ora</label></td>
                        <td class="field">
                        <select name="appointmenthour" class="hour">
                          <?php
						  $hour = $datetime['hour'];
						  	for($i=0; $i<24; $i++){
								if($i==$hour) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('change_appointment','appointmenthour','hour');</script>
                         
                        <select name="appointmentminute" class="minute">
                            <?php
						  	$minute = $datetime['minute'];
						  	for($i=0; $i<60; $i++){
								if($i==$minute) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('change_appointment','appointmentminute','minute');</script>
                        </td>
            			<td class="message"></td>
           		</tr>
 
                </table>
                
                <div id="ajax_error"></div>
                
                <input class="submit" type="submit" value="Modifica">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
            <script type="text/javascript">new FormValidator('change_appointment');</script> 
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_change_appointment


function do_iframe_delete_request($params){ 
?>
		<div id="modal-top">
  
            <h2>Elimina Richiesta</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="delete_request" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="delete_request">
                <input type="hidden" name="id_appointment" value="<?php echo $params['id_appointment']; ?>">
                
                <input class="submit" type="submit" onclick="parent.modalWindow.success();" value="Elimina">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_delete_request



function do_iframe_answer_request($params){
		$appointment=get_appointment_info($params['id_appointment']);
		$patient=get_profile_info($appointment['Patient']);
		$datetime=convert_datetime_to_stamp($appointment['DateTime']);
		$datetimerequest=convert_datetime_to_stamp($appointment['DateRequest']);
		
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Rispondi alla Richiesta</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="answer_request" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="answer_request">
                <input type="hidden" name="id_appointment" value="<?php echo $params['id_appointment']; ?>">
                
                <table>
                
                    <tr>
                        <td class="info" colspan="3">Richiesta del <strong><?php echo $datetimerequest['date']; ?></strong>:<br> 
                        <strong><?php echo $patient['Name'].' '.$patient['Surname']; ?></strong> ha richiesto un appuntamento.<br>
                       
                       
                        
                        </td>
                    </tr>
                    
                 	<tr>
                        <td class="key"><label>Data richiesta</label></td>
                        <td class="field">
                        <select name="appointmentday" class="day">
                          <?php
						  	$day = $datetime['day'];
						  	for($i=1; $i<=31; $i++){
								if($i==$day) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('answer_request','appointmentday','day');</script>
                         
                        <select name="appointmentmonth" class="month">
                            <?php
							$monthnames= unserialize(MONTHS);
						  	$month = $datetime['month'];
						  	for($i=1; $i<=12; $i++){
								if($i==$month) echo '<option value="'.$i.'" selected>'.$monthnames[$i].'</option>';
								else echo '<option value="'.$i.'">'.$monthnames[$i].'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('answer_request','appointmentmonth','month');</script>
                        <input type="text" class="required year" name="appointmentyear" value="<?php echo $datetime['year']; ?>">
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <tr>
                        <td class="key"><label>Ora richiesta</label></td>
                        <td class="field">
                        <select name="appointmenthour" class="hour">
                          <?php
						  $hour = $datetime['hour'];
						  	for($i=0; $i<24; $i++){
								if($i==$hour) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('answer_request','appointmenthour','hour');</script>
                         
                        <select name="appointmentminute" class="minute">
                            <?php
						  	$minute = $datetime['minute'];
						  	for($i=0; $i<60; $i++){
								if($i==$minute) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('answer_request','appointmentminute','minute');</script>
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <tr>
                        <td class="key"><label>Messaggio</label></td>
                        <td class="textarea" colspan="2">
                        <p><?php echo $appointment['Request']; ?></p>
                        <textarea name="request"></textarea>
                        </td>
                </tr>
 
                </table>
                
                <div id="ajax_error"></div>
                
               
                <input class="submit" type="submit" onclick="parent.modalWindow.success();" value="Rispondi">
                <button class="delete" type="button" onclick="window.location.assign('<?php echo BASE_URL; ?>/php/process.php?req=delete_request&id_appointment=<?php echo $params['id_appointment']; ?>'); parent.modalWindow.success();">Elimina</button>
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
            
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_answer_request





function do_iframe_change_basic($params){
		$profile=get_profile_info($_GET['codfiscale']);
		$datetime=convert_datetime_to_stamp($profile['Birthday']);
		
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Informazioni di Base</h2>
            <ul>
            <li class="basic_active"><a href="javascript: void(0)" title="Informazioni di Base"><span>Informazioni di Base</span></a></li>
            <li class="contact"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_contact')" title="Recapiti"><span>Recapiti</span></a></li>
             <?php if($profile['auth']==2){ ?>
             <li class="residence"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_residence')" title="Residenza"><span>Residenza</span></a></li> 
			 <?php } ?>
             <?php if($_SESSION['codfiscale']==$profile['CodFiscale']){ ?>
            <li class="password"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_password')" title="Password"><span>Password</span></a></li>
            <?php } ?>
            </ul>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="change_basic" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="change_basic">
                <input type="hidden" name="codfiscale" value="<?php echo $_GET['codfiscale']; ?>">
                
                <table>
                
                    <tr>
                        <td class="key"><label>Codice Fiscale</label></td>
                        <td class="field"><input type="text" class="required codfiscale" name="newcodfiscale" value="<?php echo $profile['CodFiscale']; ?>">
                        <td class="message"></td>
                    </tr>
                    
                    <tr>
                        <td class="key"><label>Nome</label></td>
                        <td class="field"><input type="text" class="required name" name="name" value="<?php echo $profile['Name']; ?>"></td>
                        <td class="message"></td>
                    </tr>
                    
                    <tr>
                        <td class="key"><label>Cognome</label></td>
                        <td class="field"><input type="text" class="required name" name="surname" value="<?php echo $profile['Surname']; ?>"></td>
                        <td class="message"></td>
                    </tr>
                    
                 	<tr>
                        <td class="key"><label>Data di Nascita</label></td>
                        <td class="field">
                        <select name="birthday" class="day">
                          <?php
						  	$day = $datetime['day'];
						  	for($i=1; $i<=31; $i++){
								if($i==$day) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('change_basic','birthday','day');</script>
                         
                        <select name="birthmonth" class="month">
                            <?php
							$monthnames= unserialize(MONTHS);
						  	$month = $datetime['month'];
						  	for($i=1; $i<=12; $i++){
								if($i==$month) echo '<option value="'.$i.'" selected>'.$monthnames[$i].'</option>';
								else echo '<option value="'.$i.'">'.$monthnames[$i].'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('change_basic','birthmonth','month');</script>
                        <input type="text" class="required numeric year" name="birthyear" value="<?php echo $datetime['year']; ?>">
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <?php if($profile['auth']==2){ ?>
                <tr>
                    <td class="key"><label>Sesso</label></td>
                    <td class="field">
                    <select name="gender" class="gender">
                         <option value="M" <?php if($profile['Gender']=='M') echo 'selected'; ?>>Maschio</option>
                         <option value="F" <?php if($profile['Gender']=='F') echo 'selected'; ?>>Femmina</option>
                    </select>
                    <script type="text/javascript">var gender=new Select('change_basic','gender');</script> 
                    </td>
                    <td class="message"></td>
                </tr>
                <?php } ?>
				
                <?php if($profile['auth']==1){ ?>
                <tr>
                    <td class="key"><label>Specializzazione</label></td>
                    <td class="field"><input type="text" class="required name" name="specialization" value="<?php echo $profile['Specialization']; ?>"></td>
                    <td class="message"></td>
                </tr>
				<?php } ?>
 
                </table>
                
                <div id="ajax_error"></div>
                
               
                <input class="submit" type="submit" value="Salva">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
             <script type="text/javascript">new FormValidator('change_basic');</script> 
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_change_basic


function do_iframe_change_contact($params){
		$profile=get_profile_info($_GET['codfiscale']);
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Recapiti</h2>
            <ul>
            <?php if($_SESSION['auth']==1){ ?>
            <li class="basic"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_basic')" title="Informazioni di Base"><span>Informazioni di Base</span></a></li>
            <?php } ?>
            <li class="contact_active"><a href="javascript: void(0)" title="Recapiti"><span>Recapiti</span></a></li>
             <?php if($profile['auth']==2){ ?>
             <li class="residence"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_residence')" title="Residenza"><span>Residenza</span></a></li> 
			 <?php } ?>
             <?php if($_SESSION['codfiscale']==$profile['CodFiscale']){ ?>
            <li class="password"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_password')" title="Password"><span>Password</span></a></li>
            <?php } ?>
            </ul>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="change_contact" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="change_contact">
                <input type="hidden" name="codfiscale" value="<?php echo $_GET['codfiscale']; ?>">
                
                <table>
                
                    <tr>
                        <td class="key"><label>Telefono</label></td>
                        <td class="field"><input type="text" class="required numeric" name="phone" value="<?php echo $profile['Phone']; ?>">
                        <td class="message"></td>
                    </tr>
                    
                    <tr>
                        <td class="key"><label>Email</label></td>
                        <td class="field"><input type="text" class="required email" name="email" value="<?php echo $profile['Email']; ?>"></td>
                        <td class="message"></td>
                    </tr>
                    
                </table>
                
                <div id="ajax_error"></div>
                
               
                <input class="submit" type="submit" value="Salva">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
             <script type="text/javascript">new FormValidator('change_contact');</script> 
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_change_contact




function do_iframe_change_residence($params){
		$profile=get_profile_info($_GET['codfiscale']);
		
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Residenza</h2>
            <ul>
            <?php if($_SESSION['auth']==1){ ?>
            <li class="basic"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_basic')" title="Informazioni di Base"><span>Informazioni di Base</span></a></li>
            <?php } ?>
            <li class="contact"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_contact')" title="Recapiti"><span>Recapiti</span></a></li>
             <?php if($profile['auth']==2){ ?>
             <li class="residence_active"><a href="javascript: void(0)"  title="Residenza"><span>Residenza</span></a></li> 
			 <?php } ?>
             <?php if($_SESSION['codfiscale']==$profile['CodFiscale']){ ?>
            <li class="password"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_password')" title="Password"><span>Password</span></a></li>
            <?php } ?>
            </ul>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="change_residence" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="change_residence">
                <input type="hidden" name="codfiscale" value="<?php echo $_GET['codfiscale']; ?>">
                    
                <table>
                
                    <tr>
            			<td class="key"><label>Indirizzo</label></td>
            			<td class="field"><input type="text" class=" " name="address" value="<?php echo $profile['Address']; ?>">
           				<td class="message"></td>
           			</tr>
                    
                    <tr>
           				<td class="key"><label>Città</label></td>
            			<td class="field"><input type="text" class="name" name="city" value="<?php echo $profile['City']; ?>"></td>
            			<td class="message"></td>
           			</tr>
                    
                 	<tr>
                        <td class="key"><label>Regione</label></td>
                        <td class="field">
                        <select name="region" class="region">
                          <?php
						  	$conn = db_connect();
							$result=$conn->query("SELECT nome_regione
										  		  FROM istat_regioni
												  ORDER BY nome_regione ASC");
							echo '<option value="" selected>Scegli una regione</option>';
						  	for(; $row=$result->fetch_array(); ){
								if($row[0]==$profile['Region']) echo '<option value="'.$row[0].'" selected>'.$row[0].'</option>';
								else echo '<option value="'.$row[0].'">'.$row[0].'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('change_residence','region', 'region');</script>
                         </td>
                         <td class="message"></td>
                       </tr>
                       
            
                       <tr>
                        <td class="key"><label>Provincia</label></td>
                        <td class="field">
                        <select name="province" class="province">
                        <?php
						  	$conn = db_connect();
							$result=$conn->query("SELECT nome_provincia
										  		  FROM istat_regioni NATURAL JOIN istat_province
												  
												  ORDER BY nome_provincia ASC");
							echo '<option value="" selected>Scegli una provincia</option>';
						  	for(; $row=$result->fetch_array(); ){
								if($row[0]==$profile['Province']) echo '<option value="'.$row[0].'" selected>'.$row[0].'</option>';
								else echo '<option value="'.$row[0].'">'.$row[0].'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('change_residence','province', 'province');</script>
                       </td>
                         <td class="message"></td>
                       </tr>
            
                        <tr>
                            <td class="key"><label>CAP</label></td>
                            <td class="field"><input type="text" class="cap" name="cap" value="<?php if($profile['CAP']) echo $profile['CAP']; ?>"></td>
                            <td class="message"></td>
                        </tr>
         
                        </table>
                
                <div id="ajax_error"></div>
                
               
                <input class="submit" type="submit" value="Salva">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
             <script type="text/javascript">new FormValidator('change_residence');</script> 
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_change_residence




function do_iframe_change_password($params){
		$profile=get_profile_info($_GET['codfiscale']);
		
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Password</h2>
            <ul>
             <?php if($_SESSION['auth']==1){ ?>
            <li class="basic"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_basic')" title="Informazioni di Base"><span>Informazioni di Base</span></a></li>
             <?php } ?>
            <li class="contact"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_contact')" title="Recapiti"><span>Recapiti</span></a></li>
             <?php if($profile['auth']==2){ ?>
             <li class="residence"><a href="javascript: void(0)" onclick="parent.modalWindow.change('change_residence')"  title="Residenza"><span>Residenza</span></a></li> 
			 <?php } ?>
             <?php if($_SESSION['codfiscale']==$profile['CodFiscale']){ ?>
            <li class="password_active"><a href="javascript: void(0)"  title="Password"><span>Password</span></a></li>
            <?php } ?>
            </ul>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="change_password" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="change_password">
                <input type="hidden" name="codfiscale" value="<?php echo $profile['CodFiscale']; ?>">
                    
                <table>
            
                    <tr>
                        <td class="key"><label>Vecchia Password</label></td>
                        <td class="field"><input type="password" class="required password" name="old_password">
                        <td class="message"></td>
                    </tr>
                    
                    <tr>
                        <td class="key"><label>Nuova Password</label></td>
                        <td class="field"><input type="password" class="required password" name="new_password"></td>
                        <td class="message"></td>
                    </tr>
                    
                    <tr>
                        <td class="key"><label>Ripeti Nuova Password</label></td>
                        <td class="field"><input type="password" class="required password matches[new_password]" name="password_confirmation"></td>
                        <td class="message"></td>
                    </tr>
                
                </table>
                
                  
                
                <div id="ajax_error"></div>
                
               
                <input class="submit" type="submit" value="Salva">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
             <script type="text/javascript">new FormValidator('change_password');</script> 
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_change_password





function do_iframe_delete_patient($params){ 
?>
		<div id="modal-top">
  
            <h2>Elimina Paziente</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="delete_patient" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="delete_patient">
                <input type="hidden" name="codfiscale" value="<?php echo $params['codfiscale']; ?>">
                
                <input class="submit" type="submit" onclick="parent.modalWindow.success();" value="Elimina">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_delete_patient






function do_iframe_add_patient($params){
		if(isset($params['codfiscale']))
			$profile=get_profile_info($params['codfiscale']);
		
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Aggiungi Paziente</h2>
            
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="add_patient" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="add_patient">
                
                    
                <table>
                
                
                	<tr>
                        <td class="key"><label>Codice Fiscale</label></td>
                        <td class="field"><input type="text" class="required codfiscale" name="codfiscale" value="">
                        <td class="message"></td>
                    </tr>
                    
                    <tr>
                        <td class="key"><label>Nome</label></td>
                        <td class="field"><input type="text" class="required name" name="name" value=""></td>
                        <td class="message"></td>
                    </tr>
                    
                    <tr>
                        <td class="key"><label>Cognome</label></td>
                        <td class="field"><input type="text" class="required name" name="surname" value=""></td>
                        <td class="message"></td>
                    </tr>
                    
                 	<tr>
                        <td class="key"><label>Data di Nascita</label></td>
                        <td class="field">
                        <select name="birthday" class="day">
                          <?php
						  	for($i=1; $i<=31; $i++){
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('add_patient','birthday','day');</script>
                         
                        <select name="birthmonth" class="month">
                            <?php
							$monthnames= unserialize(MONTHS);
						  	for($i=1; $i<=12; $i++){
								echo '<option value="'.$i.'">'.$monthnames[$i].'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('add_patient','birthmonth','month');</script>
                        <input type="text" class="required numeric year" name="birthyear" value="1970">
                        </td>
            			<td class="message"></td>
           			</tr>
                	
                    <tr>
                        <td class="key"><label>Sesso</label></td>
                        <td class="field">
                        <select name="gender" class="gender">
                             <option value="M" selected>Maschio</option>
                             <option value="F" >Femmina</option>
                        </select>
                        <script type="text/javascript">var gender=new Select('add_patient','gender');</script> 
                        </td>
                        <td class="message"></td>
                	</tr>
                
                	<tr>
                        <td class="key"><label>Telefono</label></td>
                        <td class="field"><input type="text" class="required numeric" name="phone" value="">
                        <td class="message"></td>
                    </tr>
                    
                    <tr>
                        <td class="key"><label>Email</label></td>
                        <td class="field"><input type="text" class="required email" name="email" value=""></td>
                        <td class="message"></td>
                    </tr>
                
                    <tr>
            			<td class="key"><label>Indirizzo</label></td>
            			<td class="field"><input type="text" class=" " name="address" value="">
           				<td class="message"></td>
           			</tr>
                    
                    <tr>
           				<td class="key"><label>Città</label></td>
            			<td class="field"><input type="text" class="name" name="city" value=""></td>
            			<td class="message"></td>
           			</tr>
                    
                 	<tr>
                        <td class="key"><label>Regione</label></td>
                        <td class="field">
                        <select name="region" class="region">
                          <?php
						  	$conn = db_connect();
							$result=$conn->query("SELECT nome_regione
										  		  FROM istat_regioni
												  ORDER BY nome_regione ASC");
							echo '<option value="" selected>Scegli una regione</option>';
						  	for(; $row=$result->fetch_array(); ){
								echo '<option value="'.$row[0].'">'.$row[0].'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('add_patient','region', 'region');</script>
                         </td>
                         <td class="message"></td>
                       </tr>
                       
            
                       <tr>
                        <td class="key"><label>Provincia</label></td>
                        <td class="field">
                        <select name="province" class="province">
                        <?php
						  	$conn = db_connect();
							$result=$conn->query("SELECT nome_provincia
										  		  FROM istat_regioni NATURAL JOIN istat_province
												  
												  ORDER BY nome_provincia ASC");
							echo '<option value="" selected>Scegli una provincia</option>';
						  	for(; $row=$result->fetch_array(); ){
								echo '<option value="'.$row[0].'">'.$row[0].'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('add_patient','province', 'province');</script>
                       </td>
                         <td class="message"></td>
                       </tr>
            
                        <tr>
                            <td class="key"><label>CAP</label></td>
                            <td class="field"><input type="text" class="cap" name="cap" value=""></td>
                            <td class="message"></td>
                        </tr>
                        
                        <tr>
                            <td class="key"><label>Password</label></td>
                            <td class="field"><input type="password" class="required password" name="new_password"></td>
                            <td class="message"></td>
                    	</tr>
                    
                        <tr>
                            <td class="key"><label>Ripeti Password</label></td>
                            <td class="field"><input type="password" class="required password matches[new_password]" name="password_confirmation"></td>
                            <td class="message"></td>
                        </tr>
         
                        </table>
                
                <div id="ajax_error"></div>
                
               
                <input class="submit" type="submit" value="Aggiungi">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
             <script type="text/javascript">new FormValidator('add_patient');</script> 
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_change_residence






function do_iframe_add_appointment($params){
	if(isset($params['codfiscale']))
		$codfiscale=$params['codfiscale'];
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Aggiungi Appuntamento</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="add_appointment" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="add_appointment">
                
                <table>
                
                    <tr>
                        <td class="key"><label>Codice Fiscale Paziente</label></td>
                        <td class="field"><input type="text" class="required codfiscale" name="codfiscale" value="<?php if(isset($codfiscale)) echo $codfiscale; ?>">
                        <td class="message"></td>
                    </tr>
                    
                 	<tr>
                        <td class="key"><label>Data</label></td>
                        <td class="field">
                        <select name="appointmentday" class="day">
                          <?php
						  	$day = date('d');
						  	for($i=1; $i<=31; $i++){
								if($i==$day) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('add_appointment','appointmentday','day');</script>
                         
                        <select name="appointmentmonth" class="month">
                            <?php
							$monthnames= unserialize(MONTHS);
						  	$month = date('m');
						  	for($i=1; $i<=12; $i++){
								if($i==$month) echo '<option value="'.$i.'" selected>'.$monthnames[$i].'</option>';
								else echo '<option value="'.$i.'">'.$monthnames[$i].'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('add_appointment','appointmentmonth','month');</script>
                        <?php $year = date('Y'); ?>
                        <input type="text" class="required year" name="appointmentyear" value="<?php echo date('Y'); ?>">
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <tr>
                        <td class="key"><label>Ora</label></td>
                        <td class="field">
                        <select name="appointmenthour" class="hour">
                          <?php
						  $hour = date('H');
						  	for($i=0; $i<24; $i++){
								if($i==$hour) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('add_appointment','appointmenthour','hour');</script>
                         
                        <select name="appointmentminute" class="minute">
                            <?php
						  	$minute = date('i');
						  	for($i=0; $i<60; $i++){
								if($i==$minute) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('add_appointment','appointmentminute','minute');</script>
                        </td>
            			<td class="message"></td>
           		</tr>
 
                </table>
                
                <div id="ajax_error"></div>
                
                <input class="submit" type="submit" value="Aggiungi">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
            <script type="text/javascript">new FormValidator('add_appointment');</script> 
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_add_appointment





function do_iframe_change_visit($params){
	$id_visit=$params['id_visit'];
	$visit=get_visit_info($id_visit);
	$datetime=convert_datetime_to_stamp($visit['DateTime']);
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Modifica Visita</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="change_visit" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="change_visit">
                <input type="hidden" name="id_visit" value="<?php echo $id_visit; ?>">
                
                <table>
                
                    <tr>
                        <td class="key"><label>Codice Fiscale Paziente</label></td>
                        <td class="field"><input type="text" class="required codfiscale" name="codfiscale" value="<?php echo $visit['Patient']; ?>">
                        <td class="message"></td>
                    </tr>
                    
                 	<tr>
                        <td class="key"><label>Data</label></td>
                        <td class="field">
                        <select name="visitday" class="day">
                          <?php
						  	$day = $datetime['day'];
						  	for($i=1; $i<=31; $i++){
								if($i==$day) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('change_visit','visitday','day');</script>
                         
                        <select name="visitmonth" class="month">
                            <?php
							$monthnames= unserialize(MONTHS);
						  	$month = $datetime['month'];
						  	for($i=1; $i<=12; $i++){
								if($i==$month) echo '<option value="'.$i.'" selected>'.$monthnames[$i].'</option>';
								else echo '<option value="'.$i.'">'.$monthnames[$i].'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('change_visit','visitmonth','month');</script>
                        <input type="text" class="required numeric year" name="visityear" value="<?php echo $datetime['year']; ?>">
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <tr>
                        <td class="key"><label>Ora</label></td>
                        <td class="field">
                        <select name="visithour" class="hour">
                          <?php
						  $hour = $datetime['hour'];
						  	for($i=0; $i<24; $i++){
								if($i==$hour) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('change_visit','visithour','hour');</script>
                         
                        <select name="visitminute" class="minute">
                            <?php
						  	$minute = $datetime['minute'];
						  	for($i=0; $i<60; $i++){
								if($i==$minute) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('change_visit','visitminute','minute');</script>
                        </td>
            			<td class="message"></td>
           		</tr>
 
                <tr>
                <td class="key"><label>Diagnosi</label></td>
                <td class="textarea" colspan="2">
                <textarea  class="" name="diagnosi"><?php echo $visit['Diagnosi']; ?></textarea>
                </td>
                </tr>
                
                <tr>
                <td class="key"><label>Ricetta</label></td>
                <td class="textarea" colspan="2">
                <textarea  class="" name="ricetta"><?php echo $visit['Ricetta']; ?></textarea>
                </td>
                </tr>
 
                </table>
                
                <div id="ajax_error"></div>
                
                <input class="submit" type="submit" value="Modifica">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
            <script type="text/javascript">new FormValidator('change_visit');</script> 
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_change_visit





function do_iframe_delete_visit($params){ 
?>
		<div id="modal-top">
  
            <h2>Elimina Visita</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="delete_request" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="delete_visit">
                <input type="hidden" name="id_visit" value="<?php echo $params['id_visit']; ?>">
                
                <input class="submit" type="submit" onclick="parent.modalWindow.success();" value="Elimina">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_delete_visit





function do_iframe_add_request($params){
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Richiedi Appuntamento</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="add_request" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="add_request">
                <input type="hidden" name="codfiscale" value="<?php echo $params['codfiscale']; ?>">
                
                <table>
                
                  
                    
                 	<tr>
                        <td class="key"><label>Data richiesta</label></td>
                        <td class="field">
                        <select name="appointmentday" class="day">
                          <?php
						  	$day = date('d');
						  	for($i=1; $i<=31; $i++){
								if($i==$day) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('add_request','appointmentday','day');</script>
                         
                        <select name="appointmentmonth" class="month">
                            <?php
							$monthnames= unserialize(MONTHS);
						  	$month = date('m');
						  	for($i=1; $i<=12; $i++){
								if($i==$month) echo '<option value="'.$i.'" selected>'.$monthnames[$i].'</option>';
								else echo '<option value="'.$i.'">'.$monthnames[$i].'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('add_request','appointmentmonth','month');</script>
                        <input type="text" class="required year" name="appointmentyear" value="<?php echo date('Y'); ?>">
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <tr>
                        <td class="key"><label>Ora richiesta</label></td>
                        <td class="field">
                        <select name="appointmenthour" class="hour">
                          <?php
						  $hour = date('H');
						  	for($i=0; $i<24; $i++){
								if($i==$hour) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                         <script type="text/javascript">new Select('add_request','appointmenthour','hour');</script>
                         
                        <select name="appointmentminute" class="minute">
                            <?php
						  	$minute = date('i');
						  	for($i=0; $i<60; $i++){
								if($i==$minute) echo '<option value="'.$i.'" selected>'.$i.'</option>';
								else echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
                        </select>
                        <script type="text/javascript">new Select('add_request','appointmentminute','minute');</script>
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <tr>
                        <td class="key"><label>Messaggio</label></td>
                        <td class="textarea" colspan="2">
                        <textarea name="request"></textarea>
                        </td>
                </tr>
 
                </table>
                
                
               
                <input class="submit" type="submit" onclick="parent.modalWindow.success();" value="Richiedi">
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
            
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_add_request


function do_iframe_confirm_appointment($params){
	$appointment=get_appointment_info($params['id_appointment']);
	$datetime=convert_datetime_to_stamp($appointment['DateTime'])
?>
		<div id="modal-top">
        
            <a href="javascript: void(0);" onclick="parent.modalWindow.deleteIframe();" class="close" title="Chiudi"></a>
            <h2>Conferma Appuntamento</h2>
        
        </div><!-- end of modal-top -->
        
		<div id="modal-form">
            
            <form name="confirm_appointment" action="<?php echo BASE_URL; ?>/php/process.php">
           		<input type="hidden" name="req" value="confirm_appointment">
                <input type="hidden" name="id_appointment" value="<?php echo $params['id_appointment']; ?>">
                
                <table>
                
                  
                    
                 	<tr>
                        <td class="key"><label>Data</label></td>
                        <td class="field">
                        <p><?php echo $datetime['date']; ?></p>
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <tr>
                        <td class="key"><label>Ora</label></td>
                        <td class="field">
                       	<p><?php echo $datetime['time']; ?></p>
                        </td>
            			<td class="message"></td>
           		</tr>
                
                <tr>
                        <td class="key"><label>Messaggio</label></td>
                        <td class="textarea" colspan="2">
                        <p><?php echo $appointment['Request']; ?></p>
                        </td>
                </tr>
 
                </table>
                
                
               
                <input class="submit" type="submit" onclick="parent.modalWindow.success();" value="Accetta">
                <button class="delete" type="button" onclick="window.location.assign('<?php echo BASE_URL; ?>/php/process.php?req=delete_request&id_appointment=<?php echo $params['id_appointment']; ?>'); parent.modalWindow.success();">Rifiuta</button>
                <button class="cancel" type="button" onclick="parent.modalWindow.deleteIframe();">Annulla</button> 
                
            </form>
            
		
        </div><!-- end of modal-form -->

<?php 
} // end of do_iframe_confirm_appointment
