 <?php
$ref = $_SERVER['SCRIPT_NAME'];

if(!isset($_SESSION['user_id']))
{
	if(preg_match('/add_comment.php/',$ref))
	{
		die("plz login to add a comment<br>"); 
	}
	else if(preg_match('/add_post.php/',$ref))
	{
		die("plz login to add a post<br>"); 
	}
	else if(preg_match('/register.php/',$ref)== false) 
	{
		die('plz log in');
	}
}
else
{
	if(preg_match('/register.php/',$ref))
	{
		header('Location: index.php');
		exit();
	}
}

/*function log_status()
{
	$ref = $_SERVER['SCRIPT_NAME'];

	if(!isset($_SESSION['user_id']))
	{
		if(preg_match('/add_comment.php/',$ref))
		{
			die("plz login to add a comment<br>"); 
		}
		else if(preg_match('/add_post.php/',$ref))
		{
			die("plz login to add a post<br>"); 
		}
		else if(preg_match('/change_pass.php/',$ref) || preg_match('/change_username.php/',$ref))
		{
			die('plz log in to change username/password');
		}
	}
	else
	{
		if(preg_match('/register.php/',$ref))
		{
			header('Location: index.php');
			exit();
		}
	}
}*/
?>