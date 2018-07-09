<?php
class login{
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
	
	function validation($search_user, $username, $password)
	{
		$this->errors = array();
		
		$email_code = md5($username ."". date('H:i'));
		
		if(!$username || !$password)
		{
			$this->errors[]= "missing information";
		}
		else
		{
			if($search_user)
			{
				if($search_user[0]["active"] === 0)
				{
					$this->errors[]="your account is not active<br><a style='color:blue' href='activate.php?un=$username&code=$email_code'>activate</a>";
				}
			}
			else
			{
				$this->errors[]= "invalid username/password";
			}
		}
	}
	
	function log_in($search_user)
	{
		$_SESSION["username"] = $search_user[0]["username"];
		$_SESSION["user_id"] = $search_user[0]["user_id"];
						
		header('Location:index.php');
		exit();
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