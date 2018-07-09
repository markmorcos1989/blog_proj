<?php
include('overallheader.php');
include('unlogged.php');
//include('get.php');
include("class/update_post_class.php");

$update_post = new update_post;
$temp = new template();

$id = $_GET['id']; //post id

if(!$id || !is_numeric($id))
{
	header('Location: index.php');
}

$where = array(
	"post_id"=>$id
);

if($search_post=$update_post->search_post("*", "posts", "=", $where, null, "s"))
{
	$file_path = $search_post[0]["image"] ;
	
	if(isset($_POST['update_post']))
	{
		//image
		$file_extn = "";
		
		if($file_name = $_FILES['update_image']['name'])
		{
			$tmp = explode('.', $file_name);
			$file_extn = strtolower(end($tmp)); //end() will take the last element of the array as a string
		}
		
		$allowed = array('jpg','jpeg','gif','png');
		
		//title & body
		$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
		$body = filter_var($_POST['body'],FILTER_SANITIZE_STRING);
		
		$update_post->validation($title, $body, $file_extn, $allowed, $file_name);
		
		if(!$update_post->errors)
		{
			if($file_name)
			{
				$file_temp = $_FILES['update_image']['tmp_name'];
				$file_path = 'images/posts/'.substr(md5(time()), 0, 10).'.'.$file_extn;
				$update_post->move_file($file_path, $file_temp); //link the path to a certain image in specific location
			}

			$update_post->delete_prev_pic_link($search_post);
			
			$update=array(
				"title"=>filter_var($_POST['title'], FILTER_SANITIZE_STRING),
				"image"=> $file_path,
				"post"=>filter_var($_POST['body'],FILTER_SANITIZE_STRING),
				"date_updated"=>date('Y-m-d G:i:s'),
				"post_id"=>$id
			);

			if($update_post->updatepost("posts", $update, 4, "sssss"))
			{
				header('Location: index.php');
				exit();
			}
		}
	}

	$blog_settings = array(
		"image"=>$file_path,
		"post_id"=>$id,
		"if_statement1"=>isset($_POST['update_post']) ? $title : $search_post[0]['title'],
		"if_statement2"=>isset($_POST['update_post']) ? $body : $search_post[0]['post'],
	);

	$blog_htm = $temp->section($blog_settings,"views/update_post_form.html");
	echo $blog_htm;

	if(isset($_POST['update_post']))
	{
		$update_post->errors();
	}
}
else
{
	header('Location: index.php');
	exit();
}
include('overallfooter.php');
?>