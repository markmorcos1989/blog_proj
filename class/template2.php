<?php
class template{
	public function section($settings,$page){
		ob_start();
		include $page;
		$file = ob_get_contents();
		foreach($settings as $key => $setting){
			$file = str_replace("{".$key."}",$setting,$file);
		}

		ob_end_clean();
		return $file;
	}

	public function bksection($settings,$page){
		ob_start();
		include $page;
		$file = ob_get_contents();
		foreach($settings as $key => $setting){
			$file = str_replace("{".$key."}",$setting,$file);
		}
		ob_end_clean();
		return $file;
	}
	
	public function get_string_between($string,$start,$end){
		$string = ' '.$string;
		$ini = strpos($string,$start);
		if($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string,$end,$ini)- $ini;
		return substr($string,$ini,$len);
	}
}
?>