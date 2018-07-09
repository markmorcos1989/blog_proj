<?php
require ("database.php");
class delete_comment
{
	public $db;
	
    public function __construct(){
		$this->db = new mysqli('localhost', 'root', '', 'myDB') or die('error with connection');
	}
	
	function search_comment($select, $table, $sign, $where, $extn, $type)
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
	
	function delete_comm($table, $where, $type) {
		if($where)
		{
			$keys = array_keys($where);
			
			foreach($keys as $k)
			{
				$w .= $k." = ? AND ";	
			}
			
			$w = rtrim($w, " AND ");
			
			$stmt = $this->db->prepare("DELETE FROM $table WHERE $w");
			
			$values = array_values($where);

			$merged_array = array_merge(array($type), $values);
			
			call_user_func_array(array($stmt, "bind_param"), $merged_array);
		}
		else
		{
			$stmt = $db->prepare("DELETE FROM $table");
		}
		$stmt->execute();
		
		return true;
	}
}
?>