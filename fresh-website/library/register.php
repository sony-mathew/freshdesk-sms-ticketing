<?php

function register_new()
	{

			$body = '';
			$flag = 1;

			if( strlen($_POST['company']) < 2 || strlen($_POST['domain']) < 2 )
				{
					$body = 'The company name and domain name must have atleast 2 characters.<br/>';
					$flag = 0;
				}
			if( ($_POST['fresh_pass_1'] != $_POST['fresh_pass_1']) || strlen($_POST['fresh_pass_1']) < 5 )
				{
					$body .= 'Either the two passwords does not match or the password length is less than 5 characters.<br/>';
					$flag = 0;
				}
			if(!(filter_var($_POST['fresh_user'], FILTER_VALIDATE_EMAIL) ))
				{
					$body .= 'You have entered an invalid email as the username.<br/>';
					$flag = 0;
				}	

			if( $flag )
				{
					$dt = date("Y-m-d h:i:s");
					$query = 'insert into fd_company_profiles (name, domain, username, password, last_activity, join_date) values 
							  (\''.strtolower( $_POST['company'] ).'\',\''.strtolower( $_POST['domain'] ).'\',\''.strtolower( $_POST['fresh_user'] ).'\'
							  	,\''.base64_encode( $_POST['fresh_pass_1'] ).'\',\''.$dt.'\',\''.$dt.'\')';
					$result = mysql_query($query);
					check($result);
					
					include_once('./library/contact.php');
					contact( $_POST['fresh_user'], $_POST['company'] );

					return 0;
				}	
			else 
				{
					return $body;
				}	
	}



?>