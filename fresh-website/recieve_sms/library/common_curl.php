<?php

	function curl_get( $company, $data , $query_type, $content = '')
		{
			$query = 'select domain,username,password from fd_company_profiles where name=\''.$company.'\' or domain=\''.$company.'\'';
			$result = mysql_query($query);
			check($result);

			$row = mysql_fetch_row($result);

			$connection = curl_init();
			curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($connection, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($connection, CURLOPT_HEADER, false);
			//curl_setopt($connection, CURLOPT_USERPWD, $row[1].":".base64_decode($row[2]));
			curl_setopt($connection, CURLOPT_USERPWD, $row[1].":".base64_decode($row[2]));

			/* query type 
			   type value '1' : create
			   type value '2' : status
			   type value '3' : chat
			   type value '4' : reply
			*/   

			if( $query_type == 1 || $query_type == 4)    
				{	
					curl_setopt($connection, CURLOPT_POST, 1);
					curl_setopt($connection, CURLOPT_POSTFIELDS, $data);
				}	

			switch ($query_type) 
				{
					case 1: $url = "http://".strtolower($row[0]).".freshdesk.com/helpdesk/tickets.json";
							break;
					case 2: $url = "http://".strtolower($row[0]).".freshdesk.com/helpdesk/tickets/".$data[2].".json";
							break;
					case 3: $url = "http://".strtolower($row[0]).".freshdesk.com/helpdesk/tickets/".$data[2].".json";
							break;
					case 4: $url = "http://".strtolower($row[0]).".freshdesk.com/helpdesk/tickets/".$content[2]."/notes.json";
							break;		
				}	
				
			curl_setopt($connection, CURLOPT_VERBOSE, 1);
			curl_setopt($connection, CURLOPT_URL, $url );
			
			
			$response = curl_exec($connection);

			return $response;
		}	


?>
