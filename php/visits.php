<?php 

session_start();
require_once 'functions/kim_fns.php';
check_valid_user();



do_html_header('Visite', 'visits');
do_html_visits();
do_html_footer();
?>
