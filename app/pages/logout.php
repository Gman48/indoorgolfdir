<?php

// only logout if person was previously logged in
if(!empty($_SESSION['USER']))
{
	unset($_SESSION['USER']); //empty session
	session_destroy(); //destroys whole session (this will also get rid of things in a cart or any history)
	session_regenerate_id(); //sets up new empty session
}

redirect('login');