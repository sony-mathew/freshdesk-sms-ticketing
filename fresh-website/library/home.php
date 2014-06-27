<?php


function home()
	{
		if( isset($_COOKIE['fd_user']))
			{
				$user1 = explode('+', $_COOKIE['fd_user']);
				$user = $user1[0];
			}
		else
			{
				$user = $_POST['user'];
			}	

        $query = 'select name,domain from fd_company_profiles where username=\''.$user.'\'';
        $result = mysql_query($query);
        $details = mysql_fetch_row($result);

        $query1 = sql_result('select count(id) from fd_sms_log where company=\''.$details[0].'\' or company=\''.$details[1].'\'');
        $query2 = sql_result('select count(id) from fd_sms_log where query_type=\'create\' and company=\''.$details[1].'\'');
        $query3 = sql_result('select count(id) from fd_sms_log where query_type=\'status\' and company=\''.$details[1].'\'');
        $query4 = sql_result('select count(id) from fd_sms_log where query_type=\'chats\' and company=\''.$details[1].'\'');
        $query5 = sql_result('select count(id) from fd_sms_log where query_type=\'reply\' and company=\''.$details[1].'\'');
        $query6 = sql_result('select count(id) from fd_client_phone_profiles where company=\''.$details[1].'\'');

        $avg_sms = ( $query1 != 0) ? (($query6 != 0) ? $query1/$query6 : 0 ): 0;

        $page = file_get_contents('./index.html');

        $page = str_replace('{total-sms}', $query1, $page);
        $page = str_replace('{tickets-created}', $query2, $page);
        $page = str_replace('{average-sms}', ceil($avg_sms), $page);
        $page = str_replace('{tikcets-status}', $query3, $page);
        $page = str_replace('{tikcets-chat}', $query4, $page);
        $page = str_replace('{tikcets-reply}', $query5, $page);
        $page = str_replace('{total-users}', $query6, $page);


        $page = str_replace('{user}', $user, $page);
        $page = str_replace('{domain}', $details[1], $page);

        return $page;

	}


function sql_result( $query )
	{
		$result = mysql_query($query);
		check( $result);
		$row = mysql_fetch_row($result);

		if( is_null($row))
			{
				$row = array(0,0);
			}	

		return $row[0];
	}	 


?>