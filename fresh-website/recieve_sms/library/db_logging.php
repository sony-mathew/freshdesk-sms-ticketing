<?php


function logger( $company, $query_type, $message)
	{
		//getting date and time in mysql db format
        $dt = date("Y-m-d h:i:s");

		$query = 'select id from fd_client_phone_profiles where phone=\''.$_GET[ 'mobile' ].'\'';
		$result = mysql_query($query);

		if( mysql_num_rows($result) == 0 )
			{
				$query = 'insert into fd_client_phone_profiles (phone, company, query_type, r_date) values  
						(\''.$_GET['mobile'].'\',\''.$company.'\',\''.$query_type.'\',\''.$dt.'\' )';
				$result = mysql_query($query);		
			}


		$query = 'insert into fd_sms_log (phone, company, query_type, message, recieved_date) values 
				  (\''.$_GET['mobile'].'\',\''.$company.'\',\''.$query_type.'\',\''.$message.'\',\''.$dt.'\')';
		$result = mysql_query($query);		  	
	}

?>