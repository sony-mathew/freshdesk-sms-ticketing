<?php


function update_password()
	{
		$user = explode('+', $_COOKIE['fd_user']);

		$query = 'update fd_company_profiles set password=\''.base64_encode( $_POST['fresh_pass'] ).'\' where username=\''.$user[0].'\'';
		$result = mysql_query($query);
		check($result);			
	}


?>