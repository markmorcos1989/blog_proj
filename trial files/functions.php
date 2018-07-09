<?php
function insert($table, $data, $type) {
	include('connect.php');
	$keys = array_keys($data);
	$values = array_values($data);
	$params = rtrim(str_repeat("?, ", count($values)), ", ");
	
	$stmt = $db->prepare("INSERT INTO $table (".implode(", ", $keys).") VALUES ($params)");

	$merged_array = array_merge(array($type), $values);
	
	call_user_func_array(array($stmt, "bind_param"), $merged_array);
	
	$stmt->execute();
	
	return true;
}

function update($table, $data, $num_sets, $type)
{
	include('connect.php');
	$keys = array_keys($data);
	$values = array_values($data);
	$x ="";
	$s="";
	
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
	
	$query = $db -> prepare("UPDATE $table SET $s where $w");
	
	$merged_array = array_merge(array($type), $values);
	
	call_user_func_array(array($query, "bind_param"), $merged_array);
	
	$query -> execute();
	$query -> store_result();
	
	return true; 
}

function select($select, $table, $sign, $where, $extn, $type)
{
	include('connect.php');
	
	$row = array();
	$results = array();
	$c = array();
	$w ="";
	
	if($where)
	{
		$keys = array_keys($where);
		
		foreach($keys as $k)
		{
			$w .= $k." $sign ? AND ";
			
		}
		
		$w = rtrim($w, " AND ");
		
		$query = $db -> prepare("SELECT $select FROM $table WHERE $w $extn");
		
		$values = array_values($where);
	
		$merged_array = array_merge(array($type), $values);
		
		call_user_func_array(array($query, "bind_param"), $merged_array);
	}
	else
	{
		$query = $db -> prepare("SELECT $select FROM $table $extn");
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
	include('connect.php');
	$row = array();
	$results = array();
	$c = array();
	$q ="";
	
	foreach($queri as $k => $v)
	{
		$q .= $k.$v;	
	}
	
	$query = $db -> prepare("$q");
	
	if($where)
	{
		$values = array_values($where);
		
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
}

function delet($table, $where, $type) {
	include('connect.php');
	
	if($where)
	{
		$keys = array_keys($where);
		
		foreach($keys as $k)
		{
			$w .= $k." = ? AND ";	
		}
		
		$w = rtrim($w, " AND ");
		
		$stmt = $db->prepare("DELETE FROM $table WHERE $w");
		
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

//function upload_pic($file_temp, $file_extn, $username, $db)
function upload_pic($file_path, $username, $db)
{
	$query = $db->prepare("SELECT profile FROM user WHERE username=?");
	$query->bind_param('s', $username);
	$query->execute();
	$query->store_result();
	$query->bind_result($profile);

	while($query->fetch()) 
	{
		if($profile)
		{
			@unlink($profile);
		}
	}
	
	$query = $db -> prepare("UPDATE `user` SET profile = ? WHERE username = ?");
	$query->bind_param('ss', $file_path, $username);
	$query->execute();
}

/*function captcha($image_width, $image_height, $ICAa1, $ICAa2, $ICAa3, $ICAb1, $ICAb2, $ICAb3, $font_size,  $angle, $x_c, $y_c, $fontfile, $text)
{
	//session_start();
	header('content-type: image/jpeg');

	$image = imagecreate($image_width, $image_height);

	imagecolorallocate($image, $ICAa1, $ICAa2, $ICAa3);
	$text_color = imagecolorallocate($image, $ICAb1, $ICAb2, $ICAb3);

	for($x=1; $x<=$font_size; $x++) 
	{
		$x1 = rand(1, 100);
		$y1 = rand(1, 100);
		$x2 = rand(1, 100);
		$y2 = rand(1, 100);
		
		imageline($image, $x1, $y1, $x2, $y2, $text_color);
	}

	imagettftext($image, $font_size, $angle, $x_c, $y_c, $text_color, $fontfile, $text);
	imagejpeg($image);
	
	//return $image;
}*/
?>