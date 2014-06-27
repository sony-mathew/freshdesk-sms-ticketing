<?php


function user()       //username

     { 
            $u = 'ynos1234_admin' ;
            return $u ; 
     } 

function pass()      // password
   
     {
            $p = '1913som' ;
            return  $p ; 
     }
     
function domain_name()

     {
		$d = 'localhost' ;
		return $d ;  
	  }	      

function wic_db()

      {
		$w = 'ynos1234_ecbeta' ;
		return $w ;   
	  }	  



// sanitization 
function sanitizeVariables(&$item, $key) 
{ 
    if (!is_array($item)) 
    { 
        // undoing 'magic_quotes_gpc = On' directive 
        if (get_magic_quotes_gpc()) 
            $item = stripcslashes($item); 
        
        $item = sanitizeText($item); 
    } 
} 

// does the actual 'html' and 'sql' sanitization. customize if you want. 
function sanitizeText($text) 
{ 
    $text = str_replace("<", "&lt;", $text); 
    $text = str_replace(">", "&gt;", $text); 
    $text = str_replace("\"", "&quot;", $text); 
    $text = str_replace("'", "&#039;", $text); 
    
    // it is recommended to replace 'addslashes' with 'mysql_real_escape_string' or whatever db specific fucntion used for escaping. However 'mysql_real_escape_string' is slower because it has to connect to mysql. 
    $text = addslashes($text); 

    return $text; 
}




function sterilise($text)

   { 

     $vlaid_html_tags = '<p> <a> <b> <br> <i> <li> <ul> <h1> <h2> <h3> <h4> ' ;

     $text = strip_tags( $text , $vlaid_html_tags ) ; 

     $text = str_replace( "\\" , '&#980' , $text ) ;   
     $text = str_replace( "\'" , '&#981' , $text ) ;
     $text = str_replace( '\"' , '&#982' , $text ) ;
     $text = str_replace( ';' , '&#983' , $text ) ;
     //$text = str_replace( '/' , '&#984' , $text ) ;
     $text = str_replace( '(' , '&#985' , $text ) ;
     $text = str_replace( ')' , '&#986' , $text ) ;
        
     return $text ;
   } 




function desterilise ( $text )

   {
     
     $text = str_replace( '&#980' , "\\" ,  $text ) ;   
     $text = str_replace( '&#981' , "\'" ,  $text ) ;
     $text = str_replace( '&#982' , '\"' ,  $text ) ;
     $text = str_replace( '&#983' , ';' ,  $text ) ;
     //$text = str_replace( '&#984' , '/' ,  $text ) ;
     $text = str_replace( '&#985' , '(' ,  $text ) ;
     $text = str_replace( '&#986' , ')' ,  $text ) ;

     
    $vlaid_html_tags = '<p> <a> <b> <br> <i> <li> <ul> <h1> <h2> <h3> <h4> <div> <code> <style>' ;

    $text = strip_tags( $text , $vlaid_html_tags ) ;    
    $text =  stripcslashes($text); 

    $text = str_replace("&#039;", "'", $text); 
    $text = str_replace("&gt;", ">", $text); 
    $text = str_replace("&quot;", "\"", $text);    
    $text = str_replace("&lt;", "<", $text); 
         
     return $text ;
   }


function connect( )

    {

     $db_user = user() ;
     $db_pass = pass() ;
     $db_domain = domain_name() ; 
     $db_db = wic_db() ;
     
     $con = mysql_connect("$db_domain","$db_user","$db_pass");
     if (!$con)
             {     die('Could not connect to the database: ' . mysql_error());        }
     
     $link = mysql_connect( $db_domain , $db_user, $db_pass);
     
     mysql_select_db( $db_db , $link ) ;
     
     return $link ;

     }




?>