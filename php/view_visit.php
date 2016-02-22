<?php 

session_start();
require_once 'functions/kim_fns.php';
check_valid_user();

$id_visit=$_GET['id_visit'];
$visit=get_visit_info($id_visit);
if(!$visit) header("Location: ".BASE_URL."/php/dashboard.php");


do_html_header('Visita n. '.$id_visit, 'visit');
do_html_visit($id_visit);
do_html_footer();

?>