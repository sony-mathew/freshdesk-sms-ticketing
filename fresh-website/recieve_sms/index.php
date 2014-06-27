<?php
  
//including the database authentication functions and variables
include_once('../library/db_common.php');

//sanitizing all the get and post variables so that it can be directly inserted into mysql database
  array_walk_recursive($_POST, 'sanitizeVariables'); 
  array_walk_recursive($_GET, 'sanitizeVariables'); 

//connecting to database
$link = connect();

include_once('./library/default.php');              
include_once('./library/common_curl.php');             
include_once('./library/db_logging.php');               

    if ( isset( $_GET[ 'mobile' ] ) && isset( $_GET[ 'message' ] ) )
        {   
            $result = '';
            $temp_msg = trim( strtolower($_GET['message']) ); 

            if( strlen($temp_msg) < 3 )
                {
                    $result = default_reply().'1';
                }
            else
                {   
                    //var_dump($_GET);
                    if ( substr_count($temp_msg, '#') > 0)
                        {
                            $msg = explode('#', $temp_msg);
                            if ( trim($msg[1]) == 'create' ) 
                                {
                                    include_once('./library/ticket_create.php');
                                    $result = ticket_create( $msg );
                                }
                            elseif ( trim($msg[1]) == 'status' ) 
                                {
                                    include_once('./library/ticket_status.php');
                                    $result = ticket_status( $msg);
                                }  
                            elseif ( trim($msg[1]) == 'chats' ) 
                                {
                                    include_once('./library/ticket_conversation.php');
                                    $result = ticket_conversations( $msg);
                                }       
                            elseif ( trim($msg[1]) == 'reply' ) 
                                {
                                    include_once('./library/ticket_reply.php');
                                    $result = reply_ticket( $msg);
                                }
                            else
                                { $result = default_reply().'2';  }           
                        }
                    else
                        {
                            $result = default_reply().'3';
                        }
                }    

            echo '<response>
                        <content> '.$result.'(ynos)
                        </content>
                  </response> ';
        }
        
    else
        {
            echo 'Sorry this request is not intended to process(Error Code #07 : no parameters).(ynos)';
        }                       
?> 

