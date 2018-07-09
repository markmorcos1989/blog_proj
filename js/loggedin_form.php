<style type="text/css">
	#img_prof{
		margin:5px;
		width:200px;
		height:200px
	}
</style>
<div class="widget">
	<h2>hello, <?php echo $_SESSION['username']; ?>!</h2>
	<div class="inner">
		<div class="profile">
			<?php //include('upload_pic.php'); ?>
			<img id="img_prof" src="{profile_pic}"><br>
			<form action="{ref}" method="post" enctype="multipart/form-data">
				<input id="file" type="file" name="profile">
				<input id="submit" type="submit" value="upload">
			</form>
		</div>
		<ul>
			<li>
				<a href="logout.php">log out</a>
			</li>
			<li>
				<a href="change_pass.php">change password</a>
			</li>
			<li>
				<a href="change_username.php">change username</a>
			</li>
		</ul>
	</div>
</div>