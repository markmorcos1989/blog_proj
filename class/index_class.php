<?php
class index{
	public $per_page;
	public $num_of_pages;
	public $start;
	public $page;
	public $db;
	
    public function __construct(){
		$this->db = new mysqli('localhost', 'root', '', 'myDB') or die('error with connection');
	}
	
	function per_page($x)
	{
		$this->per_page = $x;
	}
	
	function search_posts($select, $table, $sign, $where, $extn, $type)
	{
		$row = array();
		$results = array();
		$c = array();
		$w ="";
		$result = array();
		
		if($where)
		{
			$keys = array_keys($where);
			
			foreach($keys as $k)
			{
				$w .= $k." $sign ? AND ";
				
			}
			
			$w = rtrim($w, " AND ");
			
			$query = $this->db->prepare("SELECT $select FROM $table WHERE $w $extn");
			
			$values = array_values($where);
		
			$merged_array = array_merge(array($type), $values);
			
			call_user_func_array(array($query, "bind_param"), makeValuesReferenced($merged_array));
		}
		else
		{
			$query = $this->db->prepare("SELECT $select FROM $table $extn");
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
	
	function num_of_pages($search_posts)
	{
		$rows = count($search_posts);
		$this->num_of_pages = ceil($rows/$this->per_page);
	}
	
	function page_num($p)
	{
		if(isset($p) && is_numeric($p))
		{
			$this->page = $p;
		}
		else
		{
			$this->page = 1;
		}
	}
	
	function start()
	{
		$this->start = ($this->page - 1) * $this->per_page;
	}
	
	function search_posts_joined($queri, $where, $type)
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
	
	function display_posts($search_posts_joined)
	{
		/*$temp = new template();
		$rows = count($search_posts_joined);
		
		$output = "";
		
		$output .= "<h1>home</h1>";

		for($i=0; $i < $rows; $i++)
		{
			$blog_settings = array(
				"username"=>$search_posts_joined[$i]["username"],
				"image"=>$search_posts_joined[$i]["image"],
				"title"=>$search_posts_joined[$i]["title"],
				"body"=>substr($search_posts_joined[$i]["post"], 0, 10),
				"date"=>$search_posts_joined[$i]["date_created"],
				"post_id"=>$search_posts_joined[$i]["post_id"],
				"comment_count"=>$search_posts_joined[$i]["comment_count"],
				"if_statment1"=>$search_posts_joined[$i]["comment_count"] == 0 ? 'no comments to show' : null,
				"if_statment2"=>$search_posts_joined[$i]["comment_count"] == 1 ? 'view 1 comment' : null,
				"if_statment3"=>$search_posts_joined[$i]["comment_count"] > 1 ? "view ".$search_posts_joined[$i]["comment_count"]." comments" : null,
				"if_statment4"=>isset($_SESSION["user_id"]) ? (($_SESSION["username"] == $search_posts_joined[$i]["username"] || $_SESSION["username"] == "admin") ? "<a style='color:blue' href='update_post.php?id=".$search_posts_joined[$i]["post_id"]."'>update post</a> <a style='color:blue' id='delete_post' href='delete_post.php?id=".$search_posts_joined[$i]["post_id"]."'>delete post</a>" : null):null,
				"if_statment5"=>strlen($search_posts_joined[$i]["post"]) > 10 ? "<a style='color:blue' href='show_post.php?id=".$search_posts_joined[$i]["post_id"]."'>......read more</a></p>" : null
			);
			
			$blog_htm = $temp->section($blog_settings,"views/index.html");
			
			$output .= $blog_htm;
		}
		
		$prev = $this->page - 1;
		$next = $this->page + 1;
		
		if($prev > 0)
		{
			$output .= "<span class='pagination_link' style='cursor:pointer; color:blue;' id='".$prev."'>prev</span>  ";
		}
		
		if($this->page < $this->num_of_pages)
		{
			$output .= "<span class='pagination_link' style='cursor:pointer; color:blue;' id='".$next."' >next</span>";
		}
		
		echo $output;*/
		
		$rows = count($search_posts_joined);
		
		$output = "";
		
		$output .= "<h1>home</h1>";
		
		function link_title($x)
		{
			if($x == 0)
			{
				return 'no comments to show';
			}
			else if($x == 1)
			{
				return 'view 1 comment';
			}
			else
			{
				return "view ".$x." comments";
			}
		}

		for($i=0; $i < $rows; $i++)
		{
			$username=$search_posts_joined[$i]["username"];
			$image=$search_posts_joined[$i]["image"];
			$title=$search_posts_joined[$i]["title"];
			$post=$search_posts_joined[$i]["post"];
			$date=$search_posts_joined[$i]["date_created"];
			$post_id=$search_posts_joined[$i]["post_id"];
			$comment_count=$search_posts_joined[$i]["comment_count"];
			
			$body = substr($post, 0, 10);
			$dots_link = strlen($post) > 10 ? "<a style='color:blue' href='show_post.php?id=".$post_id."'>......read more</a></p>" : null;
			
			$link_title = link_title($comment_count);
			
			
			$update_link = "<a style='color:blue' href='update_post.php?id=".$post_id."'>update post</a>";
			$delete_link = "<a style='color:blue' id='delete_post' href='delete_post.php?id=".$post_id."'>delete post</a>";
			
			$output .= "<img id='img_id' src='".$image."'><br>";
			$output .= "<div>";
			$output .= "<article>";
			$output .= "<h2>".$title."</h2>";
			$output .= "<p>".$body.$dots_link."</p>";
			$output .= "<p>name: ".$username."</p>";
			$output .= "<p>date posted: ".$date."</p>";
			$output .= "</article>";
			$output .= "</div>";
			$output .= "<a style='color:blue' href='view_comments.php?id=".$post_id."' title='".$link_title."'>show comments</a>";
			$output .= " <a style='color:blue' href='add_comment.php?id=".$post_id."'>add comment</a>";
			$output .= isset($_SESSION["user_id"]) ? (($_SESSION["username"] == $username || $_SESSION["username"] == "admin") ? $update_link." ".$delete_link : null):null;
			$output .= "<br><hr/><br>";
		}
		
		$prev = $this->page - 1;
		$next = $this->page + 1;
		
		if($prev > 0)
		{
			$output .= "<span class='pagination_link' style='cursor:pointer; color:blue;' id='".$prev."'>prev</span>  ";
		}
		
		if($this->page < $this->num_of_pages)
		{
			$output .= "<span class='pagination_link' style='cursor:pointer; color:blue;' id='".$next."' >next</span>";
		}
		
		echo $output;
	}
	
	function getper_page()
	{
		return $this->per_page;
	}
	
	function getstart()
	{
		return $this->start;
	}
}
?>