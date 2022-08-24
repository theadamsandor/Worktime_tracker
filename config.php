<?php
ob_start();
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('SQL_HOST', 'localhost');
define('SQL_USERNAME', '');
define('SQL_PASSWORD', '');
define('DB_NAME', '');
 
//SQL CONNECTION
$SqlConnection = mysqli_connect(SQL_HOST, SQL_USERNAME, SQL_PASSWORD, DB_NAME);
if($SqlConnection === false){
    die("HIBA TÖRTÉNT: Hibás kapcsolódás az adatbázishoz. " . mysqli_connect_error());
}

?>