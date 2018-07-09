<?php
$ref = $_SERVER['SCRIPT_NAME'];

if(preg_match('/aside.php/',$ref))
{
	die("this page doesnt exist<br>"); 
}

echo "<aside>";
if(!isset($_SESSION['user_id']))
{
	include 'login.php'; 
}
else
{
	include ('logged_in_form.php');
}
echo "<br><br>";
include ('user_count.php');
echo "</aside>";
?>