<?php
include('overallheader.php');
include("class/search_class.php");

if(isset($_GET['search']))
{
	$search = new search();
	
	$type = $_GET['type'];
	$keyword = trim($_GET['k']);
	
	$search->validation($type, $keyword);

	$search->per_page(5);
	$per_page=$search->getper_page();

	$where = array(
		$type => '%'.$keyword.'%',
	);
	
	if($search_posts=$search->search_posts("*","posts","LIKE",$where,null,"s"))
	{
		$search->num_of_pages($search_posts);

		$search->page_num(); //to get page number from the brows

		$search->start();
		$start=$search->getstart();

		$queri = array(
		//"SELECT"=>"`posts`.`post_id`, `posts`.`user_name`, `posts`.`title`, LEFT(`posts`.`body`,100) AS body, `posts`.`posted`, COUNT(`comments`.`comment`) AS comment_count ",
		"SELECT"=>"`posts`.`post_id`, `posts`.`username`, `posts`.`image`, `posts`.`title`, `posts`.`post`, `posts`.`date_created`, COUNT(`comments`.`comment`) AS comment_count ",
		"FROM"=>"`posts` ",
		"LEFT JOIN"=>"`comments` ON `posts`.`post_id`=`comments`.`post_id` ",
		"where"=>" `posts`.`$type` LIKE ? ",
		"GROUP BY"=> "`posts`.`post_id` ",
		"order by"=> "`posts`.`post_id` desc limit $start, $per_page"
		);
		
		$where = array(
			$type => '%'.$keyword.'%',
		);

		$search_posts_joined=$search->search_posts_joined($queri,$where,"s");

		$search->display_posts($search_posts_joined);

		$search->links($type, $keyword);
	}
	else
	{
		echo "<p style='color:red'>no results are found</p>";
	}
}
else
{
	$temp = new template();

	$blog_settings = array(
		"if_statement"=>isset($_GET['k']) ? $_GET['k'] : null
	);

	$blog_htm = $temp->section($blog_settings,"views/search_form.html");
	echo $blog_htm;
}
include('overallfooter.php');
?>