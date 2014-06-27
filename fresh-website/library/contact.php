<?php


function contact( $email, $company)
		{
			$subject = 'Welcome to Freshdesk SMS Portal';
			$name = explode('@', $email);
			$message = '
						<html>
							<head>
							  <title>Freshdesk SMS Portal Registration</title>
							</head>
							<body>
							    <p>Hey '.$_POST['name'].', </p>
							  	<p> <blockquote /> welcome to Freshdesk SMS Portal. Thank you for signing up for this beta version of the SMS portal.
							  	</p>
							  	<p> We are very happy to inform that your company '.$company.' has been succesfully registered to our SMS portal free of cost.
							  		Now reach out to your customers through SMS also.</p>

							  	<br /> <br />
							  	<p> Thank You. </p>

							  	<br/> <br/> 
							  	For any further queries please contact ynos1234@gmail.com.	
							  
							</body>
						</html>';						

			return mailer( $name[0], $email, $subject, $message);

		}






?>