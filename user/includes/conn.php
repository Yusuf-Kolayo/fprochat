<?php  session_start();     require_once('constant.php');       require_once('functions.php');   
 
error_reporting(1);
  
$my_conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);