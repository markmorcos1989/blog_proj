<?php
$arry = array(
		"username"=>"mark",
		"password_hash"=>"jhghgjhgjg",
		"email"=>"markmorcos@gmail.com",
		"email_code"=>"jhfggjgjgjg",
		"password"=>"hjghjghj",
		"pass_again"=>"jhjhgjhg"
	);
	
/*$arry = array(
		"username"=>$_POST['username'],
		"password_hash"=>md5($_POST['password']),
		"email"=>$_POST['email'],
		"email_code"=>md5($_POST['username'] ."". date('H:i')),
		"password"=>$_POST['password'],
		"pass_again"=>$_POST['password_again']
	);*/

//$arry = array_slice($arry, 0, 4);

//print_r($arry);
	
/*function insert($tablename,$array, $a, $b){
	
	$array = array_slice($array, $a, $b);
	
	foreach($array as $k=>$v)
	{
		$x .= $k." = ? AND ";
		
	}
	
	$x=substr($x, 0, -4);
	$query = $db -> prepare("INSERT INTO $tablename set $x");
	//$query = $db -> prepare("INSERT INTO user set username = ? AND password = ? AND email = ? AND email_code = ? ");
	
	$i= 1;
	while(i<count($array)){
		$db->bindvalue($i,$array[$i]);
	}

	$query->execute();
}

function insert($table, $data) {
  $keys = array_keys($data);
  $values = array_values($data);
  $params = rtrim(", ", str_repeat("?, ", count($values)));
  try {
    $stmt = $this->DBH->prepare("INSERT INTO $table (`".implode("`,`", $keys)."`) VALUES ($params)");
    $stmt->execute($values);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    echo "Oops... {$e->getMessage()}";
  }
}

function insert($table, $data, $b) {
	include('connect.php');
	$new_array = array_slice($data, 0, $b);
	$keys = array_keys($new_array);
	$values = array_values($new_array);
	$params = rtrim(", ", str_repeat("?, ", count($values)));
	$stmt = $db->prepare("INSERT INTO $table (`".implode("`,`", $keys)."`) VALUES ($params)");
	for($i = 1; $i <= count($values); $i++) {
      $stmt->bindvalue($i, $values[$i-1]);
    }
	$stmt->execute();
}*/

$arry = array(
		"username"=>"mark",
		"password_hash"=>"jhghgjhgjg",
		"email"=>"markmorcos@gmail.com",
		"email_code"=>"jhfggjgjgjg",
		"password"=>"hjghjghj",
		"pass_again"=>"jhjhgjhg"
	);

function insert($table, $data, $b, $s) {
	include('connect.php');
	$new_array = array_slice($data, 0, $b);
	$keys = array_keys($new_array);
	$values = array_values($new_array);
	$params = rtrim(str_repeat("?, ", count($values)), ", ");
	
	$stmt = $db->prepare("INSERT INTO $table (".implode(", ", $keys).") VALUES ($params)");
	
	$type = array();
	
	$type[]=$s;
	
	//$params2 = array_merge($type, $values);
	//print_r ($type);
	//print_r ($params2);
	//$tmp = array();
	foreach($values as $key => $value) 
	{
		$type[] = &$values[$key];
	}
	
	call_user_func_array(array($stmt, 'bind_param'),$type);
	
	$stmt->execute();
}

insert('user', $arry, 4, 'ssss');

function insert($table, $data, $b) {
	include('connect.php');
	$new_array = array_slice($data, 0, $b);
	//print_r ($new_array);
	$keys = array_keys($new_array);
	//print_r ($keys);
	$values = array_values($new_array);
	//print_r ($values);
	$params = rtrim(str_repeat("?, ", count($values)), ", ");
	
	$newarray = array();
	//echo $params;
	//echo "'".str_repeat("s", count($values))."' , ". implode(", ", $values);
	
	$stmt = $db->prepare("INSERT INTO $table (".implode(", ", $keys).") VALUES ($params)");
	
	//call_user_func_array(array($stmt, "bind_param"), array_merge(array("ssss"), array($values[0], $values[1], $values[2], $values[3])));
	
    //$stmt->bind_param("ssss", $values[0], $values[1], $values[2], $values[3]);
	
	//echo count($values);
	
	/*for($i = 1; $i <= count($values); $i++) {
		array_push($newarray, $values[$i-1]);
		//echo $values[$i-1];
		/*$stmt->bind_param("ssss", $values[0], $values[1], $values[2], $values[3]);
    }*/
	
	print_r ($newarray);
	print_r ($values);

	$newa = array_merge(array("ssss"), $values);
	
	call_user_func_array(array($stmt, "bind_param"), $newa);
	
	$stmt->execute();
}

/*function select2($queri, $data)
{
	include('connect.php');
	$row = array();
	$results = array();
	$c = array();
	$w ="";
	$q ="";
	
	if($data)
	{
		$keys = array_keys($data);
		
		foreach($keys as $k)
		{
			$w .= $k." = ? AND ";
			
		}
		
		$w = rtrim($w, " AND ");
	}
	
	if($queri)
	{
		foreach($queri as $k => $v)
		{
			$q .= $k.$v;
			
		}
		
		$query = $db -> prepare("$q");
	}
	else
	{
		$query = $db -> prepare("SELECT $select FROM $table WHERE $w $extn");
	}
	
	if($data)
	{
		$values = array_values($data);
		
		$merged_array = array_merge(array($type), $values);
		
		call_user_func_array(array($query, "bind_param"), $merged_array);
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
}*/
?>
?>