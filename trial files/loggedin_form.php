<div class="widget">
	<h2>hello, <?php echo $_SESSION['username']; ?>!</h2>
	<div class="inner">
		<div class="profile">
			<?php include('upload_pic.php'); ?>
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