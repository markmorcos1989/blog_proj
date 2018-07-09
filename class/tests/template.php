<?php
class template{
	private $vars = array();
	
	public function assign($key, $value){
		$this->vars[$key] = $value; 
	}
	
	public function render($temple_name){
		$path = $temple_name . '.html';
		
		if(file_exists($path)){
			$contents = file_get_contents($path);
			
			foreach($this->vars as $key => $value)
			{
				$contents = preg_replace('/\[' . $key . '\]/', $value, $contents);
			}
			
			$contents = preg_replace('/\<\!\-\- if (.*) \-\-\>/', '<?php if ($1) : ?>', $contents);
			$contents = preg_replace('/\<\!\-\- else \-\-\>/', '<?php else : ?>', $contents);
			$contents = preg_replace('/\<\!\-\- endif \-\-\>/', '<?php endif; ?>', $contents);
			
			eval(' ?>' . $contents . '<?php ');
		}else{
			exit('<h1>template error</h1>');
		}
	}
	
	public function section($sittings ,$temple_name){
		$path = $temple_name . '.html';
		
		if(file_exists($path)){
			$contents = file_get_contents($path);
			
			foreach($sittings as $key => $value)
			{
				$contents = preg_replace('/\[' . $key . '\]/', $value, $contents);
			}
			echo $contents;
		}else{
			exit('<h1>template error</h1>');
		}
	}
}
?>