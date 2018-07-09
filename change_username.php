<?php 
include 'overallheader.php';  
include("class/change_username_class.php");

$change_username = new change_username;
$temp = new template();

log_status();

$blog_htm = $temp->section(null,"views/change_username_form.html");
echo $blog_htm;

if(isset($_POST['change_username']))
{
	$current_username = $_POST['current_username'];
	$new_username = $_POST['new_username'];
	
	$where = array(
		"user_id"=>$_SESSION['user_id'],
		"username"=>$_POST['current_username']
	);

	$vali_current_username=$change_username->search_user("*","users","=", $where, null, "ss");
	
	$where2 = array(
		"username"=>$_POST['new_username'],
	);
	
	$vali_new_username=$change_username->search_user("*","users","=", $where2, null, "s");
	
	$change_username->validation($current_username, $new_username, $vali_current_username, $vali_new_username);
	
	if(!$change_username->errors)
	{
		$update = array(
			"date_updated"=>date('Y-m-d G:i:s'),
			"username"=>$_POST['new_username'],
			"user_id"=>$_SESSION['user_id']
		);
		
		if($change_username->update_username("users", $update, 2, "sss") && 
			$change_username->update_username("posts", $update, 2, "sss") && 
			$change_username->update_username("comments", $update, 2, "sss"))
		{
			unset($_SESSION['username']);
			$_SESSION['username'] = $new_username;
			
			echo "<p style='color:blue'>your username has been changed</p>";
			
		}
	}
	else
	{
		$change_username->errors();
	}
}

include 'overallfooter.php';
?>