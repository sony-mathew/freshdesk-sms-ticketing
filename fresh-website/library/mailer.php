<?php


function mailer( $name, $to , $subject, $content )
	{

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: '.$name.'<'.$to.'>'."\r\n";
		$headers .= 'From: Sony Mathew <ynos1234@gmail.com>' . "\r\n";
		$headers .= 'Cc: ynos1234 <ynos1234junk@gmail.com>' . "\r\n";

		// Mail it
		$result = mail( $to, $subject, $content, $headers);

		if( $result )
			{
				$body = ' An email was sent to you ('.ucwords($name).') succesfully.';
			}
		else
			{
				$body = ' Failure: Email sending ('.ucwords($name).') failed.';	
			}

		return $body;	
	}



?>	