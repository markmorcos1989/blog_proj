<input type="button" value="hide number of users" id="toggle_users"/><br><br>
<div class="widget" id="user_count">
	<div class="inner">
	<?php
		$where = array(
			"active"=>1
		);
		
		$bdo = new database();

		$select_pdo=$bdo->select("*","users","=", $where, null, "s");
		
		$rows=count($select_pdo);
	?>
	<p>we currently have <?php echo $rows; ?> user<?php if($rows > 1){echo "s";} ?></p>
	</div>
</div>