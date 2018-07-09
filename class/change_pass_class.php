<?php
class change_password {
	public $errors;
	public $outputs;
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
	
	function validation($current_password, $new_password, $new_password_again, $new_password_len, $search_user)
	{
		$this->errors = array();
		
		if(!$current_password || !$new_password || !$new_password_again)
		{
			$this->errors[] = "plz enter all info";
		}
		else
		{
			if(!$search_user)
			{
				$this->errors[] = "plz enter your right current password";
			}
			else if($current_password == $new_password)
			{
				$this->errors[] = "your new password must be diff from your current one";
			}
			else if($new_password_len < 8 || !preg_match('/[A-Z]/',$new_password)|| !preg_match('/[\d]/',$new_password) || preg_match('/[\W]/',$new_password) || preg_match('/_/',$new_password))
			{
				$this->errors[] = "plz make sure ur new pass is more than 8 char , made only of alphabets(at least one uppercase) and digits(at least 1 digit)";
			}
			else if($new_password != $new_password_again)
			{
				$this->errors[] = "plz confirm your pass correctly";
			}
		}
	}
	
	function update_pass($table, $data, $num_sets, $type)
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