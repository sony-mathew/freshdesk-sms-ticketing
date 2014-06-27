<?php

	$data = array(
		'helpdesk_note[body]' => 'Man this is a new note added. to an existing one.',
		'helpdesk_note[source]' => '3',
		'helpdesk_note[private]' => 'false'
		//'helpdesk_ticket[attachments][][resource]' =>  "@" . "/Users/thanashyam/dev/freshdesk-php/test.doc"
	);


	$connection = curl_init();
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($connection, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($connection, CURLOPT_HEADER, false);
	curl_setopt($connection, CURLOPT_USERPWD, "ynos1234@gmail.com:2014wehtamynos");

	curl_setopt($connection, CURLOPT_POST, 1);
	curl_setopt($connection, CURLOPT_POSTFIELDS, $data);
	curl_setopt($connection, CURLOPT_VERBOSE, 1);

	curl_setopt($connection, CURLOPT_URL, "http://forwork.freshdesk.com/helpdesk/tickets/10/notes.json");
	$response = curl_exec($connection);

	echo $response;

	$str = json_decode($response);
	var_dump($str);

	print_r($str);

/*

*/
?>