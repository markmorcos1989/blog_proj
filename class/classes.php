<?php
require ("database.php");
require ("arrays.php");
class activate {

	function activate_update($select_pdo, $update_pdo){
		
		$outputs=array();

		$rows=count($select_pdo);
		if($rows != 1)
		{
			header('Location: index.php');
			exit();
		}

		if(!isset($_POST['secure']) || empty($_POST['secure']))
		{
			$_SESSION['secure'] = rand(1000, 9999);
		}
		else if($_SESSION['secure'] == $_POST['secure'])
		{	
			if($update_pdo)
			{
				die("your account is activated");
			}
		}
		else
		{
			$outputs[]="incorrect, try again";
			$_SESSION['secure']=rand(1000, 9999);
		}
		return $outputs;
		
	}
	
	function outputs($x)
	{
		foreach($x as $output)
		{
			echo $output.'<br><br>';
		}
	}
}

class add_comment {
	
	function insert_comment($comment, $insert_pdo, $link_name, $link_extn){

		$outputs = array();
		
		if($comment)
		{
			if($insert_pdo)
			{
				header('Location: '.$link_name.'.php?id='.$link_extn);
			}
			else
			{
				$outputs[]= "Error";
			}
		}
		else
		{
			$outputs[]= "please enter all feilds";
		}
		return $outputs;
	}
	
	function outputs($x)
	{
		foreach($x as $output)
		{
			echo $output.'<br><br>';
		}
	}
}

class add_post {
	
	function insert_post($title, $body, $insert_pdo, $link_name, $link_extn){
		
		$outputs = array();
		
		if($title && $body)
		{
			if($insert_pdo)
			{
				header('Location: '.$link_name.'.php?id='.$link_extn);
			}
			else
			{
				$outputs[]= "Error";
			}
		}
		else
		{
			$outputs[]= "please enter all feilds";
		}
		
		return $outputs;
	}
	
	function outputs($x)
	{
		foreach($x as $output)
		{
			echo $output.'<br><br>';
		}
	}
}

class change_password {
		
	function change_pass($current_password, $new_password, $new_password_again, $new_password_len, $select_pdo, $update_pdo){
		
		$outputs = array();
		
		if(!$current_password || !$new_password || !$new_password_again)
		{
			$outputs[] = "plz enter all info";
		}
		else
		{
			$rows = count($select_pdo);
			
			if($rows != 1)
			{
				$outputs[] = "plz enter your right current password";
			}
			else if($current_password == $new_password)
			{
				$outputs[] = "your new password must be diff from your current one";
			}
			else if($new_password_len < 8 || !preg_match('/[A-Z]/',$new_password)|| !preg_match('/[\d]/',$new_password) || preg_match('/[\W]/',$new_password) || preg_match('/_/',$new_password))
			{
				$outputs[] = "plz make sure ur new pass is more than 8 char , made only of alphabets(at least one uppercase) and digits(at least 1 digit)";
			}
			else if($new_password != $new_password_again)
			{
				$outputs[] = "plz confirm your pass correctly";
			}
				
			if(!$outputs)
			{
				if(@$update_pdo)
				{
					$outputs[] = "your password has been changed";
				}
			}
		}
		
		return $outputs;
	}
	
	function outputs($x)
	{
		foreach($x as $output)
		{
			echo $output.'<br><br>';
		}
	}
}

class delete_comment{
		
	function delete_comm($select_pdo, $delete_pdo, $link_name, $link_extn){
		
		$rows=count($select_pdo);

		if($delete_pdo)
		{
			for($i=0; $i < $rows; $i++ )
			{
				header('Location: '.$link_name.'.php?id='.$select_pdo[$i]["$link_extn"]);
			}
		}
	}
}

class delete_posts{
	function delete_post($delete_pdo, $link_name, $link_extn)
	{
		if($delete_pdo)
		{
			header('Location: '.$link_name.'.php');
		}
	}
}

class index{
	public $per_page;
	public $pages;
	public $start;
	public $page;
	public $blog_htm;
	
	function per_page($x)
	{
		$this->per_page = $x;
	}
	
	function pages($select_pdo)
	{
		$rows = count($select_pdo);
		$this->pages = ceil($rows/$this->per_page);
	}
	
	function page_num()
	{
		if(isset($_GET['p']) && is_numeric($_GET['p']))
		{
			$this->page = $_GET['p'];
		}
		else
		{
			$this->page = 1;
		}
	}
	
	function start()
	{
		if($this->page<=0)
		{
			$this->start = 0;
		}
		else
		{
			$this->start = ($this->page * $this->per_page) - $this->per_page;
		}
	}
	
	function posts($select2_pdo, $body, $title, $user_name, $posted, $post_id, $comment_count)
	{
		require ("template2.php");
		$temp = new template();
		$rows = count($select2_pdo);

		for($i=0; $i < $rows; $i++)
		{
			$blog_settings = array(
				"user_name"=>$select2_pdo[$i][$user_name],
				"title"=>$select2_pdo[$i][$title],
				"body"=>substr($select2_pdo[$i][$body], 0, 10),
				"date"=>$select2_pdo[$i][$posted],
				"post_id"=>$select2_pdo[$i][$post_id],
				"comment_count"=>$select2_pdo[$i][$comment_count],
				"if_statment1"=>$select2_pdo[$i][$comment_count] == 0 ? 'no comments to show' : null,
				"if_statment2"=>$select2_pdo[$i][$comment_count] == 1 ? 'view 1 comment' : null,
				"if_statment3"=>$select2_pdo[$i][$comment_count] > 1 ? "view ".$select2_pdo[$i][$comment_count]." comments" : null,
				"if_statment4"=>$_SESSION[$user_name] == true ? (($_SESSION[$user_name] == $select2_pdo[$i][$user_name] || $_SESSION[$user_name] == "admin") ? "<a href='update_post.php?id=".$select2_pdo[$i][$post_id]."'>update post</a> <a href='delete_post.php?id=".$select2_pdo[$i][$post_id]."'>delete post</a>" : null) : null,
				"if_statment5"=>strlen($select2_pdo[$i][$body]) > 10 ? "<a href='show_post.php?id=".$select2_pdo[$i][$post_id]."'>......read more</a></p>" : null
			);
			
			$blog_htm = $temp->section($blog_settings,"views/a7a.html");
			echo $blog_htm;
		}
	}
	
	function links()
	{
		$prev = $this->page - 1;
		$next = $this->page + 1;
		
		if($prev > 0)
		{
			echo "<a href='index.php?p=$prev'>prev</a>  ";
		}
		if($this->page < $this->pages)
		{
			echo "<a href='index.php?p=$next'>next</a>";
		}
	}
	
	function getblog_htm()
	{
		return $this->blog_htm;
	}
	
	function getper_page()
	{
		return $this->per_page;
	}
	
	function getpages()
	{
		return $this->pages;
	}
	
	function getstart()
	{
		return $this->start;
	}
	
	function getpage()
	{
		return $this->page;
	}
}

class login{
	function log_in($select_pdo, $username, $password)
	{
		$outputs = array();
		
		if(!$username || !$password)
		{
			$outputs[]= "missing information";
		}
		else
		{
			$rows=count($select_pdo);
			
			if($rows===1)
			{
				for($i=0; $i < $rows; $i++) 
				{
					if($select_pdo[$i]["active"] === 0)
					{
						$outputs[]="your account is not active";
					}
					else
					{
						$_SESSION["user_name"] = $select_pdo[$i]["username"];
						
						header('Location:index.php');
						exit();
					}
				}
			}
			else
			{
				$outputs[]= "invalid username/password";
			}
		}
		
		return $outputs;
	}
	
	function outputs($x)
	{
		foreach($x as $output)
		{
			echo $output.'<br><br>';
		}
	}
}

class register{
	function reg($username, $email, $password, $pass_again, $pass_len, $email_code, $select_pdo, $select2_pdo, $insert_pdo)
	{
		$outputs = array();
		
		if(!$username || !$email || !$password || !$pass_again)
		{
			$outputs[] = "plz enter all info";
		}
		else
		{
			if($password != $pass_again)
			{
				$outputs[] = "sorry your passwords dont match";
			}
			
			if(preg_match('/[\W]/',$username))
			{
				$outputs[] = "username must contain only alphabets, numbers and _";
			}
			
			if($pass_len < 8 || !preg_match('/[A-Z]/',$password)|| !preg_match('/[\d]/',$password) || preg_match('/[\W]/',$password) || preg_match('/_/',$password))
			{
				$outputs[] = "plz make sure ur pass is more than 8 char , made only of alphabets(at least one uppercase) and digits(at least 1 digit)";
			}
			
			if($email != filter_var($email, FILTER_SANITIZE_EMAIL))
			{
				$outputs[] = "plz enter a valid email add";
			}
			
			//@$result = select("*" ,"user","=", $where, null, "s");
			$rows = count($select_pdo);

			if($rows == 1)
			{
				$outputs[] = "this user name already exists sorry try another username";
			}
			
			//@$result = select("*" ,"user","=", $where2, null, "s");
			$rows = count($select2_pdo);

			if($rows >= 1)
			{
				$outputs[] = "this email already exists sorry try another email";
			}
				
			if(!$outputs)
			{
				//if(@insert("user", $insert, "ssss"))
				if(@$insert_pdo)
				{	
					$outputs[] = "thank you, you are registered, plz activate <br><br><a href='activate.php?un=$username&code=$email_code'>activate</a> ";
				}
			}
		}
		
		return $outputs;
	}
	
	function outputs($x)
	{
		foreach($x as $output)
		{
			echo $output.'<br><br>';
		}
	}
}

class search{
	public $per_page;
	public $pages ;
	public $start;
	public $page;
	
	function varif($type, $keyword)
	{
		if (!$type || !$keyword)
		{
			echo 'You have not entered search details.  Please go back and try again.';
			exit;
		}
		
		switch ($type)
		{
			case 'user_name':
			case 'title':
			case 'body':
			case 'posted':
				break;
			default:
			echo '<p>That is not a valid search type <br />
					Please go back and try again!</p>';
				exit;
		}
	}
		
	function per_page($x)
	{
		$this->per_page = $x;
	}
	
	function pages($select_pdo)
	{
		$rows = count($select_pdo);
		$this->pages = ceil($rows/$this->per_page);
	}
	
	function page_num()
	{
		if(isset($_GET['p']) && is_numeric($_GET['p']))
		{
			$this->page = $_GET['p'];
		}
		else
		{
			$this->page = 1;
		}
	}
	
	function start()
	{
		if($this->page<=0)
		{
			$this->start = 0;
		}
		else
		{
			$this->start = ($this->page * $this->per_page) - $this->per_page;
		}
	}
	
	function posts($select2_pdo, $body, $title, $user_name, $posted, $post_id, $comment_count)
	{
		require ("template2.php");
		$temp = new template();
		$rows = count($select2_pdo);

		for($i=0; $i < $rows; $i++)
		{
			$blog_settings = array(
				"user_name"=>$select2_pdo[$i][$user_name],
				"title"=>$select2_pdo[$i][$title],
				"body"=>substr($select2_pdo[$i][$body], 0, 10),
				"date"=>$select2_pdo[$i][$posted],
				"post_id"=>$select2_pdo[$i][$post_id],
				"comment_count"=>$select2_pdo[$i][$comment_count],
				"if_statment1"=>$select2_pdo[$i][$comment_count] == 0 ? 'no comments to show' : null,
				"if_statment2"=>$select2_pdo[$i][$comment_count] == 1 ? 'view 1 comment' : null,
				"if_statment3"=>$select2_pdo[$i][$comment_count] > 1 ? "view ".$select2_pdo[$i][$comment_count]." comments" : null,
				"if_statment4"=>$_SESSION[$user_name] == true ? (($_SESSION[$user_name] == $select2_pdo[$i][$user_name] || $_SESSION[$user_name] == "admin") ? "<a href='update_post.php?id=".$select2_pdo[$i][$post_id]."'>update post</a> <a href='delete_post.php?id=".$select2_pdo[$i][$post_id]."'>delete post</a>" : null) : null,
				"if_statment5"=>strlen($select2_pdo[$i][$body]) > 10 ? "<a href='show_post.php?id=".$select2_pdo[$i][$post_id]."'>......read more</a></p>" : null
			);
			
			$blog_htm = $temp->section($blog_settings,"views/a7a.html");
			echo $blog_htm;
		}
	}
	
	function links($type, $keyword)
	{
		$prev = $this->page - 1;
		$next = $this->page + 1;
		
		if($prev > 0)
		{
			echo "<a href='search.php?p=$prev&type=$type&k=$keyword&search=search'>prev</a>  ";
		}
		if($this->page < $this->pages)
		{
			echo "<a href='search.php?p=$next&type=$type&k=$keyword&search=search'>next</a>";
		}
	}
	
	function getper_page()
	{
		return $this->per_page;
	}
	
	function getpages()
	{
		return $this->pages;
	}
	
	function getstart()
	{
		return $this->start;
	}
	
	function getpage()
	{
		return $this->page;
	}
}

class show_post{
	function ShowPost($select2_pdo, $title, $body, $user_name, $posted, $post_id, $comment_count)
	{
		$rows=count($select2_pdo);

		if($rows != 1)
		{
			header('Location: index.php');
			exit();
		}

		require ("template2.php");
		$temp = new template();
		$rows = count($select2_pdo);

		for($i=0; $i < $rows; $i++)
		{
			$blog_settings = array(
				"user_name"=>$select2_pdo[$i][$user_name],
				"title"=>$select2_pdo[$i][$title],
				"body"=>$select2_pdo[$i][$body],
				"date"=>$select2_pdo[$i][$posted],
				"post_id"=>$select2_pdo[$i][$post_id],
				"comment_count"=>$select2_pdo[$i][$comment_count],
				"if_statment1"=>$select2_pdo[$i][$comment_count] == 0 ? 'no comments to show' : null,
				"if_statment2"=>$select2_pdo[$i][$comment_count] == 1 ? 'view 1 comment' : null,
				"if_statment3"=>$select2_pdo[$i][$comment_count] > 1 ? "view ".$select2_pdo[$i][$comment_count]." comments" : null,
				"if_statment4"=>$_SESSION[$user_name] == true ? (($_SESSION[$user_name] == $select2_pdo[$i][$user_name] || $_SESSION[$user_name] == "admin") ? "<a href='update_post.php?id=".$select2_pdo[$i][$post_id]."'>update post</a> <a href='delete_post.php?id=".$select2_pdo[$i][$post_id]."'>delete post</a>" : null) : null
			);
			
			$blog_htm = $temp->section($blog_settings,"views/a7a2.html");
			echo $blog_htm;
		}
	}
}

class update_comment{
	function protection($select_pdo)
	{
		$rows = count($select_pdo);

		if($rows != 1)
		{
			header('Location: index.php');
			exit();
		}
	}
	
	function update_comm($comment, $update_pdo, $select_pdo, $link_extn)
	{
		$outputs = array();
		
		if($comment)
		{
			if($update_pdo)
			{
				header('Location: view_comments.php?id='.$select_pdo[0][$link_extn]);
				exit();
			}
		}
		else
		{
			$outputs[]="missing data";
		}
		
		return $outputs;
	}
	
	function outputs($x)
	{
		foreach($x as $output)
		{
			echo $output.'<br><br>';
		}
	}
}

class update_post{
	function protection($select_pdo)
	{
		$rows = count($select_pdo);

		if($rows != 1)
		{
			header('Location: index.php');
			exit();
		}
	}
	
	function updatepost($title, $body, $update_pdo)
	{
		$outputs = array();
		
		if($title && $body)
		{
			if($update_pdo)
			{
				header('Location: index.php');
				exit();
			}
		}
		else
		{
			$outputs[]="missing data";
		}
		
		return $outputs;
	}
	
	function outputs($x)
	{
		foreach($x as $output)
		{
			echo $output.'<br><br>';
		}
	}
}
?>