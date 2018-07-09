<?php
include ('overallheader.php');
include("class/show_post_class.php");

$show_post = new show_post;

$id = $_GET['id']; //post id

if(!$id || !is_numeric($id))
{
	header('Location: index.php');
}

$queri = array(
//"SELECT"=>"`posts`.`post_id`, `posts`.`user_name`, `posts`.`title`, LEFT(`posts`.`body`,100) AS body, `posts`.`posted`, COUNT(`comments`.`comment`) AS comment_count ",
"SELECT"=>"`posts`.`post_id`, `posts`.`username`, `posts`.`image`, `posts`.`title`, `posts`.`post`, `posts`.`date_created`, COUNT(`comments`.`comment`) AS comment_count ",
"FROM"=>"`posts` ",
"LEFT JOIN"=>"`comments` ON `posts`.`post_id`=`comments`.`post_id` ",
"where"=>" `posts`.`post_id`=? ",
"GROUP BY"=> "`posts`.`post_id` "
);

$where=array(
	"post_id"=>$id,
);

if($search_post_joined=$show_post->search_post_joined($queri, $where, "s"))
{
	$show_post->display_post($search_post_joined);
}
else
{
	header('Location: index.php');
	exit();
}

include ('overallfooter.php');
?>
