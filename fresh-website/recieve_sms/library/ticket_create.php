<?php

function ticket_create( $msg )
		{
			$query = 'select domain from fd_company_profiles where name=\''.trim($msg[0]).'\' or domain=\''.trim($msg[0]).'\'';
			$result = mysql_query( $query );

			//var_dump($msg);
			$num = mysql_num_rows($result);

			if( mysql_num_rows($result) > 0 )
				{
					if(!(filter_var($msg[2], FILTER_VALIDATE_EMAIL) ))
						{
							return 'You have specified a wrong email ID.';
						}
					$row = mysql_fetch_row($result);

					//logging the sms
					logger( $row[0], 'create', $_GET[ 'message' ]);

					$data = array(
										'helpdesk_ticket[email]' => $msg[2],
										'helpdesk_ticket[subject]' => substr($msg[3], 0,25),
										'helpdesk_ticket[description]' =>  $msg[3],
										'helpdesk_ticket[source]' => '3',
										'helpdesk_ticket[priority]' => '1'
										//'helpdesk_ticket[attachments][][resource]' =>  "@" . "/Users/thanashyam/dev/freshdesk-php/test.doc"
									);

					$response = curl_get( $row[0] , $data, 1);

					if( strlen($response) < 25 )
						{
							return 'Sorry there was some problem with the server. We didn\'t get any response from freshdesk server.'.PHP_EOL.
								   'Your ticket query didn\'t go through. Please try after sometime.';
						}

					$response = json_decode( $response, true);

					$body = 'Your ticket was succesfully created.'.PHP_EOL.
							'Ticket ID  : '.$response["helpdesk_ticket"]["display_id"].PHP_EOL.
							'Created at : '.$response["helpdesk_ticket"]["created_at"].PHP_EOL.
							'Status 	: '.$response["helpdesk_ticket"]["status_name"].','.$response["helpdesk_ticket"]["requester_status_name"].PHP_EOL.
							'Priority   : '.$response["helpdesk_ticket"]["priority"].PHP_EOL.
							'Assigned Agent : '.$response["helpdesk_ticket"]["responder_name"].PHP_EOL;		
				}
			else
				{
					$body = 'Sorry, We were unable to create a ticket under your name for the company you specified.'.PHP_EOL.
							'The company you have specified has not been registered in our SMS portal or there could be some typo error with the name specified.'.PHP_EOL.
							'The closest matches we could provide are : '.PHP_EOL;
					$query = 'select domain from fd_company_profiles where company like \'%'.trim($msg[0]).'%\' or domain like \'%'.trim($msg[0]).'%\'';
					$result = mysql_query($query) ;


					//logging the sms
					logger( 'UNKNOWN', 'create', $_GET[ 'message' ]);


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