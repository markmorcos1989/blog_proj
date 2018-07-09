<?php
class add_comment {
	
	public $errors;
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
	
	function validation($comment, $title)
	{
		$this->errors = array();
		
		if(!$comment || !$title)
		{
			$this->errors[] = "plz enter all info";
		}
	}
	
	function insert_comment($table, $data, $type) {
		$keys = array_keys($data);
		$values = array_values($data);
		$params = rtrim(str_repeat("?, ", count($values)), ", ");
		
		$stmt = $this->db->prepare("INSERT INTO $table (".implode(", ", $keys).") VALUES ($params)");

		$merged_array = array_merge(array($type), $values);
		
		call_user_func_array(array($stmt, "bind_param"), makeValuesReferenced($merged_array));
		
		$stmt->execute();
		
		return true;
	}
	
	function errors()
	{
		foreach($this->errors as $error)
		{
			echo '<p style="color:red">'.$error.'</p>';
		}
	}
}
?>