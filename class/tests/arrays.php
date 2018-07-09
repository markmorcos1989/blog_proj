<?php
class arrays{
	public $where;
	public $update;
	public $insert;
	public $varif;
	public $queri;
	
	function activate_arrays($username,$code){
		
			$this->update = array(
				"active"=>1,
				"username"=>$username,
				"email_code"=>$code
			);
				
			$this->where = array(
				"username"=>$username,
				"email_code"=>$code
			);
	}
	
	function add_comm_arrays($id, $date, $name, $comment){
		
		$this->insert = array(
			"post_id"=>$id,
			"date"=>$date,
			"name"=>$name,
			"comment"=>$comment
		);
	}
	
	function add_post_arrays($username, $title, $body, $date){
		
		$this->insert = array(
			"user_name"=>$username,
			"title"=>$title,
			"body"=>$body,
			"posted"=>$date
		);
	}
	
	function change_pass_arrays($username,$current_pass, $new_pass,$new_pass_again ){
		
		$this->varif = array(
			"username"=>$username,
			"current_password"=>$current_pass,
			"current_password_hash"=>md5($current_pass),
			"new_password"=>$new_pass,
			"new_password_len"=>strlen($new_pass),
			"new_password_again"=>$new_pass_again,
			"new_password_hash"=>md5($new_pass)
		);
		
		$this->where = array(
			"username"=>$username,
			"password"=>md5($current_pass),
		);
		
		$this->update = array(
			"password"=>md5($new_pass),
			"username"=>$username
		);
	}
	
	function delete_comm_arrays($id){
		
		$this->where = array(
			"comment_id"=>$id
		);
	}
	
	function delete_post_arrays($id)
	{
		$this->where=array(
			"post_id"=>$id
		);
	}
	
	function index_arrays($start, $per_page)
	{
		$this->queri = array(
		"SELECT"=>"`posts`.`post_id`, `posts`.`user_name`, `posts`.`title`, LEFT(`posts`.`body`,100) AS body, `posts`.`posted`, COUNT(`comments`.`comment`) AS comment_count ",
		"FROM"=>"`posts` ",
		"LEFT JOIN"=>"`comments` ON `posts`.`post_id`=`comments`.`post_id` ",
		"GROUP BY"=> "`posts`.`post_id` ",
		"order by"=> "`posts`.`post_id` desc limit $start, $per_page"
		);
	}
	
	function getwhere()
	{
		return $this->where;
	}
	
	function getupdate()
	{
		return $this->update;
	}
	
	function getinsert()
	{
		return $this->insert;
	}
	
	function getvarif()
	{
		return $this->varif;
	}
	
	function getqueri()
	{
		return $this->queri;
	}
}
?>