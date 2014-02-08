<?php


	$connection = curl_init();
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($connection, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($connection, CURLOPT_HEADER, false);
	
	//your login credentials
	curl_setopt($connection, CURLOPT_USERPWD, "abcd@gmail.com:password");
	curl_setopt($connection, CURLOPT_VERBOSE, 1);


	//here in the url given below, 6 is my ticket id I want to query
	curl_setopt($connection, CURLOPT_URL, "http://companyname.freshdesk.com/helpdesk/tickets/6.json");
	
	$response = curl_exec($connection);

	$str = json_decode($response);

	print_r($str);

?>