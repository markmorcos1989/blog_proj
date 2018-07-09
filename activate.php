<?php
include 'overallheader.php';
include("class/activate_class.php"); 

$activate = new activate();
$temp = new template();

$username = $_GET['un']; 
$code = $_GET['code'];

if(!$username || !$code)
{
	header('Location: index.php');
	exit();
}
	
$where = array(
	"username"=>$username,
	"email_code"=>$code
);

if($search_user=$activate->search_user("*","users","=", $where, null, "ss")) //validate username email_code
{
	if($search_user[0]["active"] == 1)
	{
		die("<p style='color:blue'>this account is already activated</p>");
	}
	
	if(isset($_POST['activate']))
	{
		$security_code = $_POST['security_code'];
		
		$activate->validation($security_code);
	}
	else
	{
		$_SESSION['security_code'] = rand(1000, 9999);
	}

	$blog_settings = array(
		"username"=>$username,
		"code"=>$code
	);

	$blog_htm = $temp->section($blog_settings,"views/activate_form.html");
	echo $blog_htm;

	if(isset($_POST['activate']))
	{
		if(!$activate->errors)
		{
			$update = array(
				"active"=>1,
				"username"=>$username,
				"email_code"=>$code
			);
			
			if($activate->activate_user("users", $update, 1, "sss"))
			{
				die("<p style='color:blue'>your account is activated</p>");
			}
		}
		else
		{
			$activate->errors();
		}
	}
}
else
{
	header('Location: index.php');
	exit();
}
include('overallfooter.php'); 
?>