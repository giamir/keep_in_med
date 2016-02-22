<?php

require_once('constants.php');

function db_connect(){
   $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE); 
   if ($mysqli->connect_errno)
     throw new Exception('Non è possibile connettersi al database');
   else
     return $mysqli;
}

?>
