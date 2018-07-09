<?php
$data = array(
	"posts.username"=>"(select users.username from users where users.user_id=posts.user_id)",
);
$keys = array_keys($data);
$values = array_values($data);
$x ="";
$s="";
$w="";

print_r($keys);
echo "<br>";
print_r($values);
echo "<br>";

$sets = array_slice($keys, 0, 1);

print_r($sets);
echo "<br>";

foreach($sets as $k1) 
{
	$s .= $k1." = ? , ";	
}

$s = rtrim($s, " , ");
echo $s."<br>";

foreach($keys as $k)
{
	$w .= $k." = ? AND ";
	
}

$w = rtrim($w, " AND ");
$w = str_replace(str_replace(",", "AND", $s)." AND ", "", $w);
if($w)
{
	echo $w."<br>";
}
?>