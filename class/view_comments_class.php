<?php
class view_comments
{
	public $db;
	
    public function __construct(){
		$this->db = new mysqli('localhost', 'root', '', 'myDB') or die('error with connection');
	}
	
	function search_post($select, $table, $sign, $where, $extn, $type)
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
	
	function search_comments($select, $table, $sign, $where, $extn, $type)
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
	
	function Show_comments($search_comments, $id)
	{
		$temp = new template();
		$rows = count($search_comments);

		for($i=0; $i < $rows; $i++)
		{
			$blog_settings = array(
				"name"=>$search_comments[$i]["username"],
				"title"=>$search_comments[$i]["title"],
				"comment"=>$search_comments[$i]["comment"],
				"if_statment"=>isset($_SESSION["user_id"]) ? (($_SESSION["username"] == $search_comments[$i]["username"] || $_SESSION["username"] == "admin") ? "<a href='update_comment.php?id=".$search_comments[$i]["comment_id"]."'>update comment</a> <a id='delete_comment' href='delete_comment.php?id=".$search_comments[$i]["comment_id"]."'>delete comment</a>" : null) : null
			);
			
			$blog_htm = $temp->section($blog_settings,"views/view_comments1.html");
			echo $blog_htm;
		}
		
		$blog_settings = array(
			"post_id"=>$id,
		);
		
		$blog_htm = $temp->section($blog_settings,"views/view_comments2.html");
		echo $blog_htm;
	}
}
?>