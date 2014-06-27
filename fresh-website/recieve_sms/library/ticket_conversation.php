<?php

function ticket_conversations( $msg )
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
					$response = curl_get( $row[0] , $msg, 2);

					//logging the sms
					logger( $row[0], 'chats', $_GET[ 'message' ]);

					if( strlen($response) < 25 )
						{
							return 'Sorry there was some problem with the server or te ticket number. We didn\'t get any response from freshdesk server.'.PHP_EOL.
								   'Your ticket query didn\'t go through. Check the ticket number and Please try after sometime.';
						}
						
					$response = json_decode( $response,true );

					$body = 'Ticket ID  : '.$response["helpdesk_ticket"]["display_id"].PHP_EOL.
							'Created at : '.$response["helpdesk_ticket"]["created_at"].PHP_EOL.
							'Assigned Agent : '.$response["helpdesk_ticket"]["responder_name"].PHP_EOL.		
							'Last Updated : '.$response["helpdesk_ticket"]["updated_at"].PHP_EOL.		
							'Total No. of conv: '.count( $response["helpdesk_ticket"]["notes"]).PHP_EOL.
							'Conversation : ';
					if( isset($msg[3]) && is_numeric($msg[3]) )
						{
							if( isset( $response["helpdesk_ticket"]["notes"][($msg[3] - 1)] ) )
								{
									$body .= '"'.$response["helpdesk_ticket"]["notes"][($msg[3] - 1)]["note"]["body"].'"';	
								}
							else
								{
									return 'Sorry the conversation number you specified does not exist.';
								}	
						}
					else
						{	
							$i = 0;
							while ( isset($response["helpdesk_ticket"]["notes"][$i]) )
								{
									$body .= ($i+1).'. '.substr( $response["helpdesk_ticket"]["notes"][$i]["note"]["body"], 0, 15);
									++$i;
								}
						}						
				}
			else
				{
					$body = 'Sorry, We were unable to check the status of your ticket for the company you specified.'.PHP_EOL.
							'The company you have specified has not been registered in our SMS portal or there could be some typo error with the name specified.'.PHP_EOL.
							'The closest matches we could provide are : '.PHP_EOL;
					$query = 'select domain from fd_company_profiles where company like \'%'.trim($msg[0]).'%\' or domain like \'%'.trim($msg[0]).'%\'';
					$result = mysql_query($query) ;

					//logging the sms
					logger( 'UNKNOWN', 'chats', $_GET[ 'message' ]);

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