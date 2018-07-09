<?php
class search{
	public $per_page;
	public $num_of_pages;
	public $start;
	public $page;
	public $db;
	
    public function __construct(){
		$this->db = new mysqli('localhost', 'root', '', 'myDB') or die('error with connection');
	}
	
	function validation($type, $keyword)
	{
		if (!$type || !$keyword)
		{
			echo '<p style="color:red">You have not entered search details.  Please go back and try again.</p>';
			exit;
		}
		
		switch ($type)
		{
			case 'username':
			case 'title':
			case 'post':
			case 'date_created':
				break;
			default:
			echo '<p style="color:red">That is not a valid search type <br />
					Please go back and try again!</p>';
				exit;
		}
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
	
	function page_num()
	{
		if(isset($_GET['p']) && is_numeric($_GET['p']))
		{
			$this->page = $_GET['p'];
		}
		else
		{
			$this->page = 1;
		}
	}
	
	function start()
	{
		if($this->page<=0)
		{
			$this->start = 0;
		}
		else
		{
			$this->start = ($this->page * $this->per_page) - $this->per_page;
		}
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
		$temp = new template();
		$rows = count($search_posts_joined);

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
			echo $blog_htm;
		}
	}
	
	function links($type, $keyword)
	{
		$prev = $this->page - 1;
		$next = $this->page + 1;
		
		if($prev > 0)
		{
			//echo "<a style='color:blue' href='index.php?p=$prev'>prev</a>  ";
			echo "<a style='color:blue' href='search.php?p=$prev&type=$type&k=$keyword&search=search'>prev</a>  ";
		}
		if($this->page < $this->num_of_pages)
		{
			//echo "<a style='color:blue' href='index.php?p=$next'>next</a>";
			echo "<a style='color:blue' href='search.php?p=$next&type=$type&k=$keyword&search=search'>next</a>";
		}
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