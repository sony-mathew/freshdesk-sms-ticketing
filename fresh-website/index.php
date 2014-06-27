<?php
  
//including the database authentication functions and variables
include_once('./library/db_common.php');

//sanitizing all the get and post variables so that it can be directly inserted into mysql database
  array_walk_recursive($_POST, 'sanitizeVariables'); 
  array_walk_recursive($_GET, 'sanitizeVariables'); 

//connecting to database
$link = connect();

include_once('./library/login.php');
include_once('./library/home.php');



        if ( isset($_COOKIE['fd_user'] ) && validate() ) 
                { 
                    if( isset($_GET['q']) && $_GET['q'] == 'logout' )
                        {
                            logout();
                            echo str_replace('{message}', '', file_get_contents("./login.html") );
                        }

                    //updating the password    
                    elseif (isset($_GET['update']) && $_GET['update'] == 'new') 
                        {
                            include_once('./library/update_password.php');
                            update_password();
                            echo str_replace('If you have changed your freshdesk password please change it here too.', 'Your password was succesfully updated.', home());
                        }

                    elseif (isset($_GET['q']) && $_GET['q'] == 'sms_log') 
                        {
                            include_once('./library/log_table.php');
                            echo logs();
                        }        
                    else
                        {
                            echo home();
                        }    
                }


        elseif ( isset ( $_GET ['register'] ) && $_GET['register'] == 'new' )   
                {
                    include_once('./library/register.php');
                    
                    $body = register_new();
                    if( $body )  
                        {       
                            $page = str_replace('{message}', '', file_get_contents("./login.html") );     
                            echo str_replace('<!--{register-message}-->', 'Registration failure.<br/>'.$body, $page );
                        }       
                    else
                        {  
                            $page = str_replace('{message}', '', file_get_contents("./login.html") );     
                            echo str_replace('<!--{register-message}-->', 'Registration Success.', $page );     
                        }
                }

        elseif ( isset ( $_GET['login'] ) && $_GET['login'] == 'old' )   

                {
                    if( login() )  //if its a valid username and password then the cookie and show him admin panel
                        {               
                            echo home();
                        }
                    //in case the username and password is wrong,show him the login page itself    
                    else
                        {  echo str_replace('{message}', 'Invalid Login.', file_get_contents("./login.html") );     }            
                }       


        //in case an un authorised personal gets the page, show him the login page
        else

                {    echo str_replace('{message}', '', file_get_contents("./login.html") );         }           

?>