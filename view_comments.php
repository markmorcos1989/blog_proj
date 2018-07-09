<?php 
include 'overallheader.php'; 
include('class/view_comments_class.php');

$view_comments = new view_comments;

$id = $_GET['id']; //post id

if(!$id || !is_numeric($id))
{
	header('Location: index.php');
}

$where=array(
	"post_id"=>$id,
);

if($search_post=$view_comments->search_post("*", "posts","=", $where, null, "s"))
{
	$search_comments=$view_comments->search_comments("*", "comments","=", $where, "ORDER BY comment_id DESC", "s");
	$view_comments->Show_comments($search_comments, $id);
}
else
{
	header('Location: index.php');
	exit();
}
include 'overallfooter.php'; 
?>