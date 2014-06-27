<?php


function default_reply()
	{

        return 'Send in your SMS to 09773997739 is the format specified as follows.'.PHP_EOL.
                   '1. #freshdesk CompanyName#create#email#query for creating a new query.'.PHP_EOL.
                   '2. #freshdesk CompanyName#status#TicketNumber for knowing the status of a ticket.'.PHP_EOL.
                   '3. #freshdesk CompanyName#chats#TicketNumber#ConversationNumber for getting a detailed conversation.'.PHP_EOL.
                   '4. #freshdesk CompanyName#reply#TicketNumber#query for sending the reply.'.PHP_EOL; 
	}



?>