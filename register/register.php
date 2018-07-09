<?php 
include("functions.php");
include("reg_class.php");

$register = new register();

$username = $_POST['username'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$password = $_POST['password'];
$pass_again = $_POST['password_again'];
$email = $_POST['email'];

$email_code = md5($username ."". date('H:i'));

$where = array(
	"username"=>$_POST['username']
);

$username_validation = $register->search_user_data("*", "users", "=", $where, null, "s");

$where2 = array(
	"email"=>$_POST['email']
);

$email_validation = $register->search_user_data("*", "users", "=", $where2, null, "s");

$register->validation($username, $firstname, $lastname, $email, $password, $pass_again, $username_validation, $email_validation);

if(!$register->errors)
{
	$insert = array(
		"username"=>$_POST['username'],
		"firstname"=>$_POST['firstname'],
		"lastname"=>$_POST['lastname'],
		"password"=>md5($_POST['password']),
		"email"=>$_POST['email'],
		"email_code"=>md5($_POST['username'] ."". date('H:i')),
		"date_created"=>date('Y-m-d G:i:s'),
		"profile_pic"=>'images/profile/default.PNG'
	);
	
	if($register->reg_user("users", $insert, "ssssssss"))
	{
		$data["activate"] = "<p style='color:blue'>thank you, you are registered, plz activate<br><a style='color:blue' href='activate.php?un=$username&code=$email_code'>activate</a></p>";
		echo json_encode($data);
	}
}
else
{
	$register->errors();
}

?>