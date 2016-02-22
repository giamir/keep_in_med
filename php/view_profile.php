<?php 

session_start();
require_once 'functions/kim_fns.php';
check_valid_user();

$codfiscale=$_GET['codfiscale'];
$profile=get_profile_info($codfiscale);
if(!$profile) header("Location: ".BASE_URL."/php/dashboard.php");


do_html_header($profile['Name'].' '.$profile['Surname'], 'profile');
do_html_profile($codfiscale);
do_html_footer();

?>