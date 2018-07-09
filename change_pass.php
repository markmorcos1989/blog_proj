<?php 
include 'overallheader.php'; 
include("class/change_pass_class.php");

$change_pass = new change_password;
$temp = new template();

log_status();

$blog_htm = $temp->section(null,"views/change_pass_form.html");
echo $blog_htm;

if(isset($_POST['change_pass']))
{
	$current_password = $_POST['current_password'];
	$current_password_hash = md5($_POST['current_password']);
	$new_password = $_POST['new_password'];
	$new_password_len = strlen($_POST['new_password']);
	$new_password_again = $_POST['new_password_again'];
	$new_password_hash = md5($_POST['new_password']);
	
	$where = array(
		"user_id"=>$_SESSION['user_id'],
		"password"=>md5($_POST['current_password']),
	);

	$search_user=$change_pass->search_user("*","users","=", $where, null, "ss");
	
	$change_pass->validation($current_password, $new_password, $new_password_again, $new_password_len, $search_user);
	
	if(!$change_pass->errors)
	{
		$update = array(
			"date_updated"=>date('Y-m-d G:i:s'),
			"password"=>md5($_POST['new_password']),
			"user_id"=>$_SESSION['user_id']
		);
		
		if($change_pass->update_pass("users", $update, 2, "sss", true))
		{
			echo "<p style='color:blue'>your password has been changed</p>";
		}
	}
	else
	{
		$change_pass->errors();
	}
}

include 'overallfooter.php';
?>