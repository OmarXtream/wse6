<?php
if(count(get_included_files()) == 1){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

require_once("./../includes/db.php");
require_once("./../includes/functions.php");
require_once("protection.php");
?>