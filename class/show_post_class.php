<?php
class show_post
{
	public $db;
	
    public function __construct(){
		$this->db = new mysqli('localhost', 'root', '', 'myDB') or die('error with connection');
	}
	
	function search_post_joined($queri, $where, $type)
	{
		$row = array();
		$results = array();
		$c = array();
		$q ="";
		$result = array();
		
		foreach($queri as $k => $v)
		{
			$q .= $k.$v;	
		}
		
		$query = $this->db -> prepare("$q");
		
		if($where)
		{
			$values = array_values($where);
			
			$merged_array = array_merge(array($type), $values);
			
			call_user_func_array(array($query, "bind_param"), makeValuesReferenced($merged_array));
		}
		
		$query -> execute();
		$query -> store_result();
		
		$meta = $query->result_metadata(); 
		while ($field = $meta->fetch_field()) 
		{ 
			$results[] = &$row[$field->name]; 
		} 
		
		call_user_func_array(array($query, "bind_result"), $results);
		
		while ($query->fetch()) { 
			foreach($row as $key => $val) 
			{ 
				$c[$key] = $val; 
			} 
			$result[] = $c; 
		} 
		
		return $result; 
	}
	
	function display_post($search_post_joined)
	{
		$temp = new template();
		
		$blog_settings = array(
			"username"=>$search_post_joined[0]["username"],
			"image"=>$search_post_joined[0]["image"],
			"title"=>$search_post_joined[0]["title"],
			"post"=>$search_post_joined[0]["post"],
			"date"=>$search_post_joined[0]["date_created"],
			"post_id"=>$search_post_joined[0]["post_id"],
			"comment_count"=>$search_post_joined[0]["comment_count"],
			"if_statment1"=>$search_post_joined[0]["comment_count"] == 0 ? 'no comments to show' : null,
			"if_statment2"=>$search_post_joined[0]["comment_count"] == 1 ? 'view 1 comment' : null,
			"if_statment3"=>$search_post_joined[0]["comment_count"] > 1 ? "view ".$search_post_joined[0]["comment_count"]." comments" : null,
			"if_statment4"=>isset($_SESSION["user_id"]) ? (($_SESSION["username"] == $search_post_joined[0]["username"] || $_SESSION["username"] == "admin") ? "<a href='update_post.php?id=".$search_post_joined[0]["post_id"]."'>update post</a> <a id='delete_post' href='delete_post.php?id=".$search_post_joined[0]["post_id"]."'>delete post</a>" : null):null
		);

		$blog_htm = $temp->section($blog_settings,"views/show_post.html");
		echo $blog_htm;
	}
}
?>