<?php
include('overallheader.php');
include('unlogged.php');
include("class/update_comment_class.php");

$update_comment = new update_comment;
$temp = new template();

$id = $_GET['id']; //comment id

if(!$id || !is_numeric($id))
{
	header('Location: index.php');
}

$where = array(
	"comment_id"=>$id
);

if($search_comment=$update_comment->search_comment("*", "comments", "=", $where, null, "s"))
{
	if(isset($_POST['update_comment']))
	{
		$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
		$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
		
		$update_comment->validation($comment, $title);
	}

	$blog_settings = array(
		"comment_id"=>$id,
		"if_statement"=>isset($_POST['update_comment']) ? $title : $search_comment[0]["title"],
		"if_statement2"=>isset($_POST['update_comment']) ? $comment : $search_comment[0]["comment"],
		"post_id"=>$search_comment[0]["post_id"]
	);

	$blog_htm = $temp->section($blog_settings,"views/update_comment_form.html");
	echo $blog_htm;

	if(isset($_POST['update_comment']))
	{
		if(!$update_comment->errors)
		{
			$update=array(
				"title"=>filter_var($_POST['title'], FILTER_SANITIZE_STRING),
				"comment"=>filter_var($_POST['comment'], FILTER_SANITIZE_STRING),
				"date_updated"=>date('Y-m-d G:i:s'),
				"comment_id"=>$id
			);
			
			if($update_comment->update_comm("comments", $update, 3, "ssss"))
			{
				header('Location: view_comments.php?id='.$search_comment[0]["post_id"]);
				exit();
			}
		}
		else
		{
			$update_comment->errors();
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
