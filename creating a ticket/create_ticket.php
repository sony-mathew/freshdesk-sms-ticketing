<?php

	$data = array(
		'helpdesk_ticket[email]' => 'again_priority@gmail.com',
		'helpdesk_ticket[subject]' => 'Setting priorities and source type using script',
		'helpdesk_ticket[description]' => 'If this pop ups in dashboard then creating ticket using php script is a success.',
		'helpdesk_ticket[source]' => '3',
		'helpdesk_ticket[priority]' => '3'
		//'helpdesk_ticket[attachments][][resource]' =>  "@" . "/Users/thanashyam/dev/freshdesk-php/test.doc"
	);


	$connection = curl_init();
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($connection, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($connection, CURLOPT_HEADER, false);
	//your login credentials
	curl_setopt($connection, CURLOPT_USERPWD, "abcd@gmail.com:password");

	curl_setopt($connection, CURLOPT_POST, 1);
	curl_setopt($connection, CURLOPT_POSTFIELDS, $data);
	curl_setopt($connection, CURLOPT_VERBOSE, 1);

	curl_setopt($connection, CURLOPT_URL, "http://companyname.freshdesk.com/helpdesk/tickets.json");
	$response = curl_exec($connection);

	$str = json_decode($response);

	print_r($str);

?>