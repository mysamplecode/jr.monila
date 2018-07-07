<?php
$dbhost ='localhost';
$dbuser = 'root';
$dbpass = 'bugs';

$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
	die("Database connection failed: " . mysql_error());
}
$dbname = "jrmolina";
$db_select = mysql_select_db($dbname);
if (!$db_select) {
	die("Database connection failed: " . mysql_error());
}
?>
