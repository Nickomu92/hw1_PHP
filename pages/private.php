<h3 class="text-center">Приватно</h3><hr/>

<?php
	$conn = connect_to_db();

	echo '<form action="index.php?page=6" method="POST" enctype="multipart/form-data" class="">';
	echo '<select name="userid">';

	$sel = 'SELECT * FROM `users`
			ORDER BY login';

	$res = mysqli_query($conn, $sel);

	while($row = mysqli_fetch_array($res,MYSQLI_NUM)){
		echo '<option value="' . $row[0].'">' . $row[1] . '</option>';
	}

	mysqli_free_result($res);

	echo '</select>';
	echo '<input type="hidden" name="MAX_FILE_SIZE" value="500000" />';
	echo '<input type="file" name="file" accept="image/*" class="m-t-10">';
	echo '<input type="submit" name="addadmin" value="Загрузить аватар" class="btn btn-sm btn-info m-t-10 m-b-10">';
	
	echo '</form>';

	if(isset($_REQUEST['addadmin']))
	{
		$userid = $_POST['userid'];
		$fn = $_FILES['file']['tmp_name'];
		$file = fopen($fn,'rb');

		$img = fread($file, filesize($fn));

		fclose($file);

		$img = addslashes($img);

		$upd = 'UPDATE `users` SET avatar = "' . $img . '", roleid = 1 WHERE id = '. $userid;

		mysqli_query($conn, $upd);
		$err = mysqli_errno($conn);

		if ($err)
		{
			echo $err;
		}
	}

	$sel = 'SELECT * FROM `users` 
			WHERE roleid = 1 
			ORDER BY login';

	$res = mysqli_query($conn, $sel);

	echo '<table class="table table-striped">';

	while($row = mysqli_fetch_array($res, MYSQLI_NUM)){
		echo '<tr>';
		echo '<td>' . $row[0] . '</td>';
		echo '<td>' . $row[1] . '</td>';
		echo '<td>' . $row[3] . '</td>';
		
		$img = base64_encode($row[6]);

		echo '<td><img height="100px" src="data:image/png; base64,' . $img . '"/></td>';
	}

	mysqli_free_result($res);
	echo '</table>';
?>