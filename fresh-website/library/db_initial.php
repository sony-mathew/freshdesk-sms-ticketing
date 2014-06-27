<?php

include_once('db_common.php');

		$con = connect();
		if (!$con)         {     die('Could not connect: ' . mysql_error());        }
		else               {     print "connection succesful....!!!! <br/>";         }

	mysql_select_db( db , $con);

		//creating first table fd_company_profiles
		$sql = "CREATE TABLE fd_company_profiles
											(
													id smallint NOT NULL AUTO_INCREMENT,
													primary key (id),
													name varchar(90),
													domain varchar(80),
													username varchar(100),
													password varchar(200),
													last_activity datetime,
													join_date datetime,
													cookie_key varchar(12)
											)";


		if(mysql_query($sql,$con))         {  print "fd_company_profiles table created..!!<br/>";              }
		else                               {  print "fd_company_profiles table could not be created..!!<br/>".mysql_error(); }

		//creating 2nd table fd_client_phone_profiles
		$sql = "CREATE TABLE fd_client_phone_profiles
										(
												id smallint NOT NULL AUTO_INCREMENT,
												primary key (id),
												phone varchar(36) NOT NULL UNIQUE,
												company varchar(100) NOT NULL,
												query_type varchar(20),
												r_date datetime
										)";


		if(mysql_query($sql,$con))     {    print "fd_client_phone_profiles table created..!!<br/>";              }
		else                           {    print "fd_client_phone_profiles table could not be created..!!<br/>".mysql_error(); }

		//creating 3rd table fd_sms_log
		$sql = "CREATE TABLE fd_sms_log
										(
											id smallint NOT NULL AUTO_INCREMENT,
											primary key (id),
											phone varchar(50) NOT NULL,
											company varchar(200),
											query_type varchar(20),
											message text,
											recieved_date datetime
										)";


		if(mysql_query($sql,$con))       {    print "fd_sms_log  table created..!!<br/>";             }
		else                             {    print "fd_sms_log table could not be created..!!<br/>".mysql_error(); }



	mysql_close($con);

?>
