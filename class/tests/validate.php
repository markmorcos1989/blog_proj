<?php
class validate {
	
    function __construct() {
        //print "In BaseClass constructor\n";
    }
	
	function reg($array){
		
		if(!$array['username'] || !$array['email'])
		{
			return false;
		}
		else{
			return true;
		}
		
	}
	
}
?>