<?php 
include 'overallheader.php';
include("class/add_post_class.php");

log_status();

$add_post = new add_post();
$temp = new template();

$blog_htm = $temp->section(null,"views/add_post_form.html");
echo $blog_htm;

if(isset($_POST['submit']))
{
	$file_path = 'images/posts/default.PNG';
	
	//image
	$file_extn = "";

	if($file_name = $_FILES['image']['name'])
	{
		$tmp = explode('.', $file_name);
		$file_extn = strtolower(end($tmp)); //end() will take the last element of the array as a string
	}
	
	$allowed = array('jpg','jpeg','gif','png');
	
	//title & body
	$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
	$body = filter_var($_POST['body'], FILTER_SANITIZE_STRING);
	
	$add_post->validation($title, $body, $file_extn, $allowed, $file_name);
	
	if(!$add_post->errors)
	{
		if($file_name)
		{
			$file_temp = $_FILES['image']['tmp_name'];
			$file_path = 'images/posts/'.substr(md5(time()), 0, 10).'.'.$file_extn;
			$add_post->move_file($file_path, $file_temp); //move the file from the temp location to the targeted location with new name 
		}
		
		$insert = array(
			"username"=>$_SESSION['username'],
			"image"=> $file_path,
			"title"=>filter_var($_POST['title'], FILTER_SANITIZE_STRING),
			"post"=>filter_var($_POST['body'], FILTER_SANITIZE_STRING),
			"date_created"=>date('Y-m-d G:i:s'),
			"user_id"=>$_SESSION['user_id']
		);
		
		if($add_post->insert_post("posts", $insert , "ssssss"))
		{
			header('Location: index.php');
		}
	}
	else
	{
		$add_post->errors();
	}
}

include 'overallfooter.php';
?>