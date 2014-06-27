<?php

function login()
         {
             $conn = connect();

             $query = 'select password from fd_company_profiles where username = \''.$_POST['user'].'\'';
             $result =  mysql_query($query) ;

             if( mysql_num_rows($result) > 0 )
                 {
                     $row = mysql_fetch_row($result) ;
                     
                     if ( $row[0] == base64_encode($_POST['pass']) )     
                                  {  
                                     $str = random_str() ;
                                     setcookie('fd_user' , $_POST['user'].'+'.$str , time() + 3600 ) ;                             
                                     $query = 'update fd_company_profiles set cookie_key = \''.$str.'\' where username = \''.$_POST['user'].'\'';
                                     check( mysql_query($query)) ;
                                     return 1 ;
                                  }   

                     else         { return 0 ; }  
                 }    
         }

function validate()
         {
             $conn = connect();
             $user = explode('+', $_COOKIE['fd_user'] ) ;

             $query = 'select cookie_key from fd_company_profiles where username = \''.$user[0].'\'';
             $row = mysql_fetch_row(mysql_query($query)) ;
              
             if ( $row[0] == $user[1] )       { return 1 ; }
             else                             { return 0 ; }   

         }

function logout()
        {
             setcookie('fd_user' , $_COOKIE['fd_user'] , time() - 500 ) ;
             unset($_COOKIE['fd_user']);                              
        }

function random_str( $length = 5 )
                        {
                                $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";  
                                $size = strlen( $chars );
                                $str = '';
                                for( $i = 0; $i < $length; $i++ ) 
                                           {
                                                  $str .= ' '.$chars[ rand( 0, $size - 1 ) ];
                                           }
                                return $str;
                        }        

?>
