<?php 
include 'overallheader.php'; 
include("class/add_comment_class.php");

$add_comm = new add_comment();
$temp = new template();

log_status();

$id = $_GET['id']; //post id

if(!$id || !is_numeric($id))
{
	header('Location: index.php');
}

$where = array(
	"post_id"=>$id
);

if($add_comm->search_post("*","posts","=", $where, null, "s"))
{
	$blog_settings = array(
		"post_id"=>$id
	);

	$blog_htm = $temp->section($blog_settings,"views/add_comment_form.html");
	echo $blog_htm;

	if(isset($_POST['submit']))
	{
		$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
		$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
		
		$add_comm->validation($comment, $title);
		
		if(!$add_comm->errors)
		{
			$insert = array(
				"post_id"=>$id,
				"date_created"=>date('Y-m-d G:i:s'),
				"username"=>$_SESSION['username'],
				"comment"=>filter_var($_POST['comment'], FILTER_SANITIZE_STRING),
				"title"=>filter_var($_POST['title'], FILTER_SANITIZE_STRING),
				"user_id"=>$_SESSION['user_id']
			);
			
			if($add_comm->insert_comment("comments", $insert, "ssssss"))
			{
				header('Location: view_comments.php?id='.$id);
			}
		}
		else
		{
			$add_comm->errors();
		}
	}
}
else
{
	header('Location: index.php');
	exit();
}

include 'overallfooter.php';
?>