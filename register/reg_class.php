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
		$un_rows = count($username_validation);
		$email_rows = count($email_validation);
		
		if(!$username)
		{
			$this->errors["username"] = "this field is required";
		}
		else if(!preg_match('/^[\w ]+$/',$username))
		{
			$this->errors["username"] = "username must not contain special characters";
		}
		else if($un_rows == 1)
		{
			$this->errors["username"] = "this user name already exists sorry try another username";
		}
		
		if(!$firstname)
		{
			$this->errors["firstname"] = "this field is required";
		}
		
		if(!$lastname)
		{
			$this->errors["lastname"] = "this field is required";
		}
		
		if(!$password)
		{
			$this->errors["password"] = "this field is required";
		}
		else if(strlen($password) < 8 || !preg_match('/[A-Z]/',$password)|| !preg_match('/[\d]/',$password) || preg_match('/[\W]/',$password) || preg_match('/_/',$password))
		{
			$this->errors["password"] = "make sure ur pass is more than 8 char , made only of alphabets(at least one uppercase) and digits(at least 1 digit)";
		}
		
		if($password && !$pass_again)
		{
			$this->errors["password_again"] = "this field is required";
		}
		else if($password != $pass_again)
		{
			$this->errors["password_again"] = "sorry your passwords dont match";
		}
		
		if(!$email)
		{
			$this->errors["email"] = "this field is required";
		}
		else if($email != filter_var($email, FILTER_SANITIZE_EMAIL))
		{
			$this->errors["email"] = "enter a valid email add";
		}
		else if($email_rows >= 1)
		{
			$this->errors["email"] = "this email already exists sorry try another email";
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
		echo json_encode($this->errors);
	}
}
?>