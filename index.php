<?php 
include 'overallheader.php'; 
include("class/index_class2.php");

echo "<h1>home</h1>";

$index = new index;

$index->per_page(5);
$per_page=$index->getper_page();

$search_posts=$index->search_posts("*","posts","","","","");
$index->num_of_pages($search_posts);

$index->page_num(); //to get page number from the browser

$index->start();
$start=$index->getstart();


$queri = array(
//"SELECT"=>"`posts`.`post_id`, `posts`.`user_name`, `posts`.`title`, LEFT(`posts`.`body`,100) AS body, `posts`.`posted`, COUNT(`comments`.`comment`) AS comment_count ",
"SELECT"=>"`posts`.`post_id`, `posts`.`username`, `posts`.`image`, `posts`.`title`, `posts`.`post`, `posts`.`date_created`, COUNT(`comments`.`comment`) AS comment_count ",
"FROM"=>"`posts` ",
"LEFT JOIN"=>"`comments` ON `posts`.`post_id`=`comments`.`post_id` ",
"GROUP BY"=> "`posts`.`post_id` ",
"order by"=> "`posts`.`post_id` desc limit $start, $per_page"
);

$search_posts_joined=$index->search_posts_joined($queri,"","");

$index->display_posts($search_posts_joined);

$index->links();

include 'overallfooter.php';
?>
