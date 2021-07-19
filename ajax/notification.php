<?php
session_start();
require_once("../includes/db.php");
require_once("../includes/functions.php");

if($_SERVER['REQUEST_METHOD'] == "GET"){

	if(isset($_GET['notification'],$_SESSION['memberId:wse6'])){
		if(antiSpam("notification:notification.php")){
			exit;
		}
		if(!isset($database)) { exit('sdfsdffs'); }
		$conn = $database->openConnection();
		$sql = $conn->query("SELECT notification,time FROM notification WHERE cid='{$_SESSION['memberId:wse6']}' ORDER BY id DESC");
		$notifyCount = $sql->rowCount();
			$response['notification'] = '';
		if($notifyCount > 0){
			foreach($sql as $row){
				$notify = htmlspecialchars($row['notification']);
				$time = $row['time'];
				$timeago = ago($time);
				$response['notification'] .= "
					<li>
						<a class='text-body-color-dark media mb-15'>
							<div class='media-body '>
								<p class='mb-0'>{$notify}</p>
								<div class='text-muted font-size-sm font-italic'>{$timeago}</div>
							</div>
						</a>
					</li>
				";
			}
			$notification = $response['notification'];
			$database->closeConnection();
			returnJSON(array('notifyCount' => $notifyCount, 'emptynotify'=>false, 'notification'=>$notification),false);
		}else{
			$database->closeConnection();
			returnJSON(array('notifyCount' => $notifyCount, 'emptynotify'=>true),false);
		}
	}

	if(isset($_GET['remnotify'],$_SESSION['memberId:wse6'])){
		if(antiSpam("remnotify:notification.php")){
			exit();
		}
		$conn = $database->openConnection();
		$sql = $conn->query("DELETE FROM notification WHERE cid='{$_SESSION['memberId:wse6']}'");
		$database->closeConnection();
		returnJSON(array('done' => true),false);
	}
}



?>