<?php
include("class/login_class.php");

$login = new login;
$temp = new template();

$blog_htm = $temp->section(null,"views/login_form.html");
echo $blog_htm;

if(isset($_POST['submit']))
{
	$username=$_POST['username'];
	$password=md5($_POST['pwrd']);
	
	$where=array(
		"username"=>$_POST['username'],
		"password"=>md5($_POST['pwrd'])
	);

	$search_user=$login->search_user("*", "users", "=", $where, null, "ss");
	
	$login->validation($search_user, $username, $password);
	
	if(!$login->errors)
	{
		$login->log_in($search_user);
	}
	else
	{
		$login->errors();
	}
}
?>