<?php

function logs()
	{
 		if( isset($_COOKIE['fd_user']))
			{
				$user1 = explode('+', $_COOKIE['fd_user']);
				$user = $user1[0];
			}
		else
			{
				echo 'Please login to continue.';
				exit;
			}	

 		$query = 'select *from fd_sms_log where company=( select domain from fd_company_profiles where username=\''.$user.'\')';
        $result = mysql_query($query);

        $body = '<style>
        			table
        			{
        				margin:auto;
        			}
        			td,th {
        				border:1px solid grey;
        				padding: 8px;
        				font-family: verdana;
        				text-align:center;
        			}
        			th  {
        				background: grey;
        				color:white;
        			}
        		</style>';

        $body .= '<table> 
        			<tr>
        				<th> Sl No.</th>
        				<th> Phone(hashed)</th>
        				<th> Company </th>
        				<th> Query Type</th>
        				<th> Message</th>
        				<th> Recieved Date </th>
        			</tr>';
        $i = 0;
        while( $row = mysql_fetch_row($result))
        	{
        		$body .= '<tr>
	        				<td> '.(++$i).'</td>
	        				<td> '.$row[1].'</td>
	        				<td> '.$row[2].'</td>
	        				<td> '.$row[3].'</td>
	        				<td> '.$row[4].'</td>
	        				<td> '.$row[5].' </td>
        				 </tr>';
        	}

        $body .= '</table>';

        return $body;	
    }    

?>