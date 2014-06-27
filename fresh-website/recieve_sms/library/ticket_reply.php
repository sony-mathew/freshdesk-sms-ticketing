<?php

function reply_ticket( $msg )
		{
			$query = 'select domain from fd_company_profiles where name=\''.trim($msg[0]).'\' or domain=\''.trim($msg[0]).'\'';
			$result = mysql_query( $query );

			if( !( is_numeric( trim($msg[2]) ) ) )
				{
					return 'Sorry the ticket number should be a numeric value.';
				}

			if( mysql_num_rows($result) > 0 )
				{
					$row = mysql_fetch_row($result);

					//logging the sms
					logger( $row[0], 'reply', $_GET[ 'message' ]);

					$data = array(
										'helpdesk_note[body]' => $msg[3],
										'helpdesk_note[source]' => '3',
										'helpdesk_note[private]' => 'false'
									);

					$response = curl_get( $row[0] , $data, 4, $msg);

					//echo $response;
					
					if( strlen($response) < 20 )
						{
							return 'Sorry there was some problem with the server. We didn\'t get any response from freshdesk server.'.PHP_EOL.
								   'Your ticket query didn\'t go through. Please try after sometime.';
						}

					$response = json_decode( $response,true );

					$body = 'Your ticket was succesfully updated.'.PHP_EOL.
							'Ticket ID  : '.$msg[2].PHP_EOL.
							'Created at : '.$response["note"]["created_at"].PHP_EOL.
							'Updated at : '.$response["note"]["updated_at"].PHP_EOL.
							'Source     : '.$response["note"]["source"].PHP_EOL;		
				}
			else
				{
					$body = 'Sorry, We were unable to reply to the specified ticket under your name for the company you specified.'.PHP_EOL.
							'The company you have specified has not been registered in our SMS portal or there could be some typo error with the name specified.'.PHP_EOL.
							'The closest matches we could provide are : '.PHP_EOL;
					$query = 'select domain from fd_company_profiles where company like \'%'.trim($msg[0]).'%\' or domain like \'%'.trim($msg[0]).'%\'';
					$result = mysql_query($query) ;


					//logging the sms
					logger( 'UNKNOWN', 'reply', $_GET[ 'message' ]);


					if( mysql_num_rows($result) > 0 )
						{
							while( $row = mysql_fetch_row($result))
								{
									$body .= $row[0].' , ' ;
								}
						}
					else
						{
							$body .= 'No results found'; 
						}	
				}	
			return $body;	
		}
?>