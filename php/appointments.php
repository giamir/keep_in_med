<?php 

session_start();
require_once 'functions/kim_fns.php';
check_valid_user();



do_html_header('Appuntamenti', 'appointments');
do_html_appointments();
do_html_footer();
?>