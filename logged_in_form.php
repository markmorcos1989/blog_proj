<?php
include("class/upload_pic_class.php");

$upload_pic = new upload_pic;
$temp = new template();

$ref = $_SERVER['SCRIPT_NAME'];

$where = array(
	"user_id"=>$_SESSION['user_id']
);

$search_user=$upload_pic->search_user("*", "users", "=", $where, null, "s");

$file_path = $search_user[0]["profile_pic"];

if(isset($_FILES['profile']))
{
	$file_name = $_FILES['profile']['name'];
	$tmp = explode('.', $file_name);
	$file_extn = strtolower(end($tmp)); //end() will take the last element of the array as a string

	$allowed = array('jpg','jpeg','gif','png');

	$upload_pic->validation($file_extn, $allowed, $file_name);
	
	if(!$upload_pic->errors)
	{
		$file_temp = $_FILES['profile']['tmp_name'];
		$file_path = 'images/profile/'.substr(md5(time()), 0, 10).'.'.$file_extn;
			
		$upload_pic->move_file($file_path, $file_temp);
		
		$upload_pic->delete_prev_pic_link($search_user);
		
		$update = array(
			"profile_pic"=> $file_path,
			"date_updated"=>date('Y-m-d G:i:s'),
			"user_id"=>$_SESSION['user_id']
		);
		
		$upload_pic->update_user_pic("users", $update, 2, "sss");
		
		echo "<script>function loadImage() {alert('Image is loaded');}</script>";	
	}
}

$blog_settings = array(
	"ref"=>$ref,
	"username"=>$_SESSION['username'],
	"profile_pic"=>$file_path
);

$blog_htm = $temp->section($blog_settings,"views/logged_in_form.html");
echo $blog_htm;

if(isset($_FILES['profile']))
{
	if($upload_pic->errors)
	{
		$upload_pic->errors();
	}
}
?>
