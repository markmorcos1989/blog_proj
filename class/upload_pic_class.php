<?php
class upload_pic{
	public $errors;
	public $db;
	
    public function __construct(){
		$this->db = new mysqli('localhost', 'root', '', 'myDB') or die('error with connection');
	}
	
	function search_user($select, $table, $sign, $where, $extn, $type)
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
	
	function validation($file_extn, $allowed, $file_name)
	{
		$this->errors = array();
		
		if(!$file_name)
		{
			$this->errors[] = 'plz choose a file';
		}
		else
		{
			if(in_array($file_extn, $allowed) == false)
			{
				$this->errors[] = 'incorrect file type. allowed: '.implode(', ', $allowed);
			}
		}
	}
	
	function move_file($file_path, $file_temp)
	{
		move_uploaded_file($file_temp, $file_path);
	}
	
	
	function delete_prev_pic_link($search_user)
	{	
		if($search_user[0]['profile_pic'] != 'images/profile/default.PNG')
		{
			@unlink($search_user[0]['profile_pic']);
		}
	}
	
	function update_user_pic($table, $data, $num_sets, $type)
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

	
	function errors()
	{
		foreach($this->errors as $error)
		{
			echo '<p style="color:red">'.$error.'</p>';
		}
	}
}
?>