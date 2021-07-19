<?php
$amstaff = true;
require_once("../../includes/db.php");
require_once("../../includes/functions.php");
require_once("../inc/protection.php");
if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	/*
		We used http response code to recongized error using sweetalert...
		More Info: Ask The Developer Of this page..
	*/
	
	if(!isset($_SESSION['_token']) OR !isset($_GET['token']) OR $_GET['token'] != $_SESSION['_token']){
		returnJSON(array('t' => 'خطأ', 'm' => 'حدث خطأ غير متوقع جاري تحديث الصفحة','tp'=>'error'));
	}
	if(rankPermission($_SESSION['staffId:wse6'],3,true)){
		returnJSON(array('t' => 'خطأ', 'm' => 'ليس لديك صلاحية لدخول هذه الصفحة', 'tp'=>'error'));
	}
	
	if(isset($_GET['id'], $_GET['code'])){
		
		if(empty($_GET['id']) OR empty($_GET['code'])) {
			http_response_code(520);
			returnJSON(array('isSuccess' => false), false);
		} else if(!is_numeric($_GET['id'])){
			http_response_code(519);
			returnJSON(array('isSuccess' => false), false);
		} else if(strlen($_GET['code']) > 32 OR strlen($_GET['id']) > 32) {
			http_response_code(518);
			returnJSON(array('isSuccess' => false), false);
		}  else if(antiSpam('MidAcc:code')){
			returnJSON(array('t' => 'خطأ','m' => 'من فضلك أنتظر قليلا بين محاولاتك','tp' => 'error','b' => 'موافق'));		
		} else {
			
			$conn=$database->openConnection();
			
			$check=$conn->prepare("SELECT accept_code FROM mediations WHERE id=:id AND mid_accepted = {$_SESSION['staffId:wse6']} AND status=0");
			$check->bindParam(":id", $_GET['id'],PDO::PARAM_INT);
			$check->execute();
			
			if($check->rowCount() > 0){
				
				$fetchData=$check->fetch(PDO::FETCH_ASSOC);
				
				if($fetchData["accept_code"] == $_GET['code']) {
					
					$updateStatus=$conn->prepare("UPDATE mediations SET status= 3 WHERE id=:id AND mid_accepted={$_SESSION['staffId:wse6']} AND status=0");
					$updateStatus->bindParam(":id", $_GET['id'],PDO::PARAM_INT);
					$updateStatus->execute();
					
					if($updateStatus->rowCount() > 0){
						
						
						returnJSON(array('isSuccess' => true,'verifyToFinish'=>'<button class="btn btn-circle btn-alt-danger mr-5 mb-5" onclick="goToSure('.$_GET['id'].')" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="إنهاء الوساطة"><i class="fa fa-close"></i></button>'));
					} else {
						http_response_code(519);
						returnJSON(array('isSuccess' => false), false);
					}
				} else {
					http_response_code(517);
					returnJSON(array('isSuccess' => false), false);
				}
			} else {
				http_response_code(519);
				returnJSON(array('isSuccess' => false), false);
		
			}
		}
	} else if(isset($_GET['id'], $_GET['finish'])){
		
		if(empty($_GET['id']) OR !ctype_digit($_GET['id']) OR strlen($_GET['id']) > 32){
			returnJSON(array('isSuccess' => false));
		} else{
			
			$conn=$database->openConnection();
			
			$check=$conn->prepare("SELECT id FROM mediations WHERE id=:id AND mid_accepted = {$_SESSION['staffId:wse6']} AND status=3;");
			$check->bindParam(":id", $_GET['id'],PDO::PARAM_INT);
			$check->execute();
			
			if($check->rowCount() > 0){				
				
				$deleteFinish=$conn->prepare("DELETE FROM mediations WHERE id=:id AND mid_accepted = {$_SESSION['staffId:wse6']} AND status=3; DELETE FROM mediations_reply WHERE reply_id=:id AND reply_mid = {$_SESSION['staffId:wse6']}");
				$deleteFinish->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
				$deleteFinish->execute();
				
				if($deleteFinish->rowCount() > 0){
					
					returnJSON(array('isSuccess'=>true, 't'=>'حسناً','m'=>'تم إنهاء الوساطة وحذفها بنجاحً!','tp'=>'success'));
					
				} else {
					returnJSON(array('isSuccess' => false,'t'=>'خطأ','m'=>'حدث خطأ غير متوقع، يرجى تحديث الصفحة.','tp'=>'error'));	
				}
				
				
			} else {
				returnJSON(array('isSuccess' => false,'t'=>'خطأ','m'=>'حدث خطأ غير متوقع، يرجى تحديث الصفحة.','tp'=>'error'));	
			}
			
			
			
		}
		
	}else{}
}



?>