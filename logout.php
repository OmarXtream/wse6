<?php
if (session_status() == PHP_SESSION_NONE) {
	ini_set('session.cookie_httponly', true);
	session_start();
}

if(isset($_SESSION['memberId:wse6'])){

	session_unset();
	session_destroy();
	exit(header("Refresh:0; url=login"));
	
}else{
	exit(header("Refresh:0; url=login"));
}
	
	




?>