<?php
session_start();
include('unlogged.php');
include('functions.php');
include("class/delete_post_class.php");

$delete_posts = new delete_posts;

$id = $_GET['id']; //post id

if(!$id || !is_numeric($id))
{
	header('Location: index.php');
}

$where=array(
	"post_id"=>$id
);

if($search_post=$delete_posts->search_post("*", "posts", "=", $where, null, "s"))
{
	if($delete_posts->delete_post("posts", $where, "s"))
	{
		header('Location: index.php');
	}
}
else
{
	header('Location: index.php');
}
?>