<?php 

session_start();
require_once 'functions/kim_fns.php';
check_valid_user();

do_html_header('Dashboard','dashboard');
do_html_mainbox();
if($_SESSION['auth']==1){
do_html_next_appointments();
do_html_pending_appointments();
}
else{
do_html_patient_visits();
do_html_patient_appointments();
}
do_html_footer();

?>