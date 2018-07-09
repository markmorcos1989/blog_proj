<?php
//require ("database.php");
class add_post {
	public $errors;
	public $db;
	
    public function __construct(){
		$this->db = new mysqli('localhost', 'root', '', 'myDB') or die('error with connection');
	}
	
	function validation($title, $body, $file_extn, $allowed, $file_name)
	{
		$this->errors = array();
		
		if(!$title || !$body)
		{
			$this->errors[] = "plz enter all info";
		}
		else
		{
			if($file_name)
			{
				if(in_array($file_extn, $allowed) == false)
				{
					$this->errors[] = 'incorrect file type. allowed: '.implode(', ', $allowed);
				}
			}
		}
	}
	
	function move_file($file_path, $file_temp)
	{
		move_uploaded_file($file_temp, $file_path);
	}
	
	function insert_post($table, $data, $type) {
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