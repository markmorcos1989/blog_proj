<?php
if(!isset($_GET['id']))
{
	header('Location: index.php');
	exit();
}
else
{
	@$id = $_GET['id'];
}

if(!is_numeric($id))
{
	header('Location: index.php');
}
?>