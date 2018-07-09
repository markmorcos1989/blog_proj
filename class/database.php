<?php
class database
{
	public $db;
	
    public function __construct(){
		$this->db = new mysqli('localhost', 'root', '', 'myDB') or die('error with connection');
	}
	
	function insert($table, $data, $type) {
		$keys = array_keys($data);
		$values = array_values($data);
		$params = rtrim(str_repeat("?, ", count($values)), ", ");
		
		$stmt = $this->db->prepare("INSERT INTO $table (".implode(", ", $keys).") VALUES ($params)");

		$merged_array = array_merge(array($type), $values);
		
		call_user_func_array(array($stmt, "bind_param"), makeValuesReferenced($merged_array));
		
		$stmt->execute();
		
		return true;
	}

	function update($table, $data, $num_sets, $type)
	{
		$keys = array_keys($data);
		$values = array_values($data);
		$x ="";
		$s="";
		$w="";
		
		$sets = array_slice($keys, 0, $num_sets);

		foreach($sets as $k1) 
		{
			$s .= $k1." = ? , ";	
		}
		
		$s = rtrim($s, " , ");
		
		foreach($keys as $k)
		{
			$w .= $k." = ? AND ";
			
		}
		
		$w = rtrim($w, " AND ");
		$w = str_replace(str_replace(",", "AND", $s)." AND ", "", $w);
		
		$query = $this->db -> prepare("UPDATE $table SET $s where $w");
		
		$merged_array = array_merge(array($type), $values);
		
		call_user_func_array(array($query, "bind_param"), makeValuesReferenced($merged_array));
		
		$query -> execute();
		$query -> store_result();
		
		return true; 
	}

	function select($select, $table, $sign, $where, $extn, $type)
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

	function select2($queri, $where, $type)
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

	function delet($table, $where, $type) {
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