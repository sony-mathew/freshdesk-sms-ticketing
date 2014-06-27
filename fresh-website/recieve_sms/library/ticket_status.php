<?php

function ticket_status( $msg )
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
					logger( $row[0], 'status', $_GET[ 'message' ]);

					if( strlen($response) < 25 )
						{
							return 'Sorry there was some problem with the server or the ticket number. We didn\'t get any response from freshdesk server.'.PHP_EOL.
								   'Your ticket query didn\'t go through. Check the ticket number and Please try after sometime.';
						}
						
					$response = json_decode( $response, true );

					$body = 'The status of your ticket with ticket number '.$msg[2].'.'.PHP_EOL.
							'Ticket ID  : '.$response["helpdesk_ticket"]["display_id"].PHP_EOL.
							'Created at : '.$response["helpdesk_ticket"]["created_at"].PHP_EOL.
							'Status 	: '.$response["helpdesk_ticket"]["status_name"].','.$response["helpdesk_ticket"]["requester_status_name"].PHP_EOL.
							'Priority   : '.$response["helpdesk_ticket"]["priority"].' , '.$response["helpdesk_ticket"]["priority_name"].PHP_EOL.
							'Assigned Agent : '.$response["helpdesk_ticket"]["responder_name"].PHP_EOL.		
							'Last Updated : '.$response["helpdesk_ticket"]["updated_at"].PHP_EOL.		
							'Total No. of conv: '.count( $response["helpdesk_ticket"]["notes"]).PHP_EOL;		
				}
			else
				{
					$body = 'Sorry, We were unable to check the status of your ticket for the company you specified.'.PHP_EOL.
							'The company you have specified has not been registered in our SMS portal or there could be some typo error with the name specified.'.PHP_EOL.
							'The closest matches we could provide are : '.PHP_EOL;
					$query = 'select domain from fd_company_profiles where company like \'%'.trim($msg[0]).'%\' or domain like \'%'.trim($msg[0]).'%\'';
					$result = mysql_query($query) ;

					//logging the sms
					logger( 'UNKNOWN', 'status', $_GET[ 'message' ]);

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