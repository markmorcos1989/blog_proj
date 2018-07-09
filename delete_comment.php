<?php
session_start();
include('unlogged.php');
include('functions.php');
include("class/delete_comment_class.php");

$delete_comm = new delete_comment;

$id = $_GET['id']; //comment id

if(!$id || !is_numeric($id))
{
	header('Location: index.php');
}

$where = array(
	"comment_id"=>$id
);

if($search_comment=$delete_comm->search_comment("*","comments","=", $where, null, "s"))
{
	if($delete_comm->delete_comm("comments", $where, "s"))
	{
		header('Location: view_comments.php?id='.$search_comment[0]["post_id"]);
	}
}
else
{
	header('Location: index.php');
	exit();
}
?>
