<?php
class register{
	public $errors;
	public $db;
	
    public function __construct(){
		$this->db = new mysqli('localhost', 'root', '', 'myDB') or die('error with connection');
	}
	
	function search_user_data($select, $table, $sign, $where, $extn, $type)
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

	function validation($username, $firstname, $lastname, $email, $password, $pass_again, $username_validation, $email_validation)
	{
		//$this->outputs = array();
		
		if(!$username || !$email || !$password || !$pass_again || !$firstname || !$lastname)
		{
			$this->errors[] = "plz enter all info";
		}
		else
		{
			if($password != $pass_again)
			{
				$this->errors[] = "sorry your passwords dont match";
			}
			
			if(preg_match('/[\W]/',$username))
			{
				$this->errors[] = "must contain only alphabets, numbers and _";
			}
			
			if(strlen($password) < 8 || !preg_match('/[A-Z]/',$password)|| !preg_match('/[\d]/',$password) || preg_match('/[\W]/',$password) || preg_match('/_/',$password))
			{
				$this->errors[] = "make sure ur pass is more than 8 char , made only of alphabets(at least one uppercase) and digits(at least 1 digit)";
			}
			
			if($email != filter_var($email, FILTER_SANITIZE_EMAIL))
			{
				$this->errors[] = "enter a valid email add";
			}
			
			$rows = count($username_validation);

			if($rows == 1)
			{
				$this->errors[] = "this user name already exists sorry try another username";
			}
			
			$rows = count($email_validation);

			if($rows >= 1)
			{
				$this->errors[] = "this email already exists sorry try another email";
			}
		}
	}
	
	function reg_user($table, $data, $type) {
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