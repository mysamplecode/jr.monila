<?php
$dbhost ='localhost';
$dbuser = 'paperfli_jrmolin';
$dbpass = 'triad1234';

$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
	die("Database connection failed: " . mysql_error());
}
$dbname = "paperfli_idx";
$db_select = mysql_select_db($dbname);
if (!$db_select) {
	die("Database connection failed: " . mysql_error());
}
?>
