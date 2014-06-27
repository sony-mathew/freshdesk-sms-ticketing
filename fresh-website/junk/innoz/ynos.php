<?php


if(isset($_GET['mobile']))
		{

			$val = strtolower( trim($_GET['message']));


			if( substr_count($val, '#') > 0 )
				{ 
				    
				    $url = 'http://php-ynos1234.rhcloud.com/recieve_sms/index.php?mobile='.$_GET['mobile'].'&message='.urlencode($_GET['message']);
				    $ch = curl_init();
	                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Accepts all CAs 
	                curl_setopt($ch, CURLOPT_URL, $url); 
	                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Tells cURL to follow redirects 
                	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
	                $output1 = curl_exec($ch);
	                echo $output1;
	                exit;
				}


			if( substr_count($val, 'level') || substr_count($val,'error') || substr_count($val , 'name') || substr_count($val , 'place'))
				{ 
				     include_once('../smart_trash/library/bin_sms_process.php');
				}
			else
				{
					$num = rand(1,236);
					if ( $num ==7 ) { $num = 13 ; }

		    		include_once('./db.php');

				 	$link = connect() ;
				 		 
		            $query = "SELECT * FROM quotes where id= $num " ;
				 	$result = mysql_query( $query , $link );
				 	$myrow = mysql_fetch_row($result) ;  

					if( strlen($myrow[1]) < 3 ) 
						{ 	
							$myrow[1] = 'What lies behind us and what lies before us are tiny matters compared to what lives within us. -Emerson.
		      							 sms #ynos to 55444 for a motivational quote.'; 
		      		    }

					echo '
					    <response>
					         <content>
					               '.desterilise($myrow[1]).' .

					               sms #ynos to 55444 for a motivational quote. 
					         </content>
					    </response> ';
		  		}    
		}

else
	    {  
			echo '<response>
			         <content>
			               A dream you dream alone is a dream. But a dream you dream together is a reality.

			               sms #ynos to 55444 for a motivational quote. 
			         </content>
			      </response> ';
		}


?>