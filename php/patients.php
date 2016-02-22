<?php 

session_start();
require_once 'functions/kim_fns.php';
check_valid_user();



do_html_header('Pazienti', 'patients');
do_html_patients();
do_html_footer();

?>
