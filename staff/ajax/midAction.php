<?php
$amstaff = true;
require_once("../../includes/db.php");
require_once("../../includes/functions.php");
require_once("../inc/protection.php");
if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	if(!isset($_SESSION['_token']) OR !isset($_GET['token']) OR $_GET['token'] != $_SESSION['_token']){
		returnJSON(array('t' => 'خطأ', 'm' => 'حدث خطأ غير متوقع جاري تحديث الصفحة', 'tp'=>'error'));
	}
	if(rankPermission($_SESSION['staffId:wse6'],3,true)){
		returnJSON(array('t' => 'خطأ', 'm' => 'ليس لديك صلاحية لدخول هذه الصفحة', 'tp'=>'error'));
	}
	if(isset($_GET['id'],$_GET['eventId'],$_SESSION['staffId:wse6'])){
		
		if(!ctype_digit($_GET['id']) OR !ctype_digit($_GET['eventId'])){
			returnJSON(array('t' => 'خطأ', 'm' => 'حدث خطأ غير متوقع جاري تحديث الصفحة..', 'tp' => 'error','reload' => true));
		} else if(antiSpam('Mid:eventId')){
			returnJSON(array('t' => 'خطأ','m' => 'من فضلك أنتظر قليلا بين محاولاتك','tp' => 'error','b' => 'موافق'));		
		} 
			
		$conn=$database->openConnection();

		$checkStaff=$conn->query("SELECT isStaff FROM Customers WHERE id={$_SESSION['staffId:wse6']}");
		
		if($checkStaff->rowCount() > 0) {
			
			$dataStaff=$checkStaff->fetch(PDO::FETCH_ASSOC);
			
			if($dataStaff["isStaff"] == 1){

				if($_GET['eventId'] == 0){
					
					$getOrderInfo=$conn->prepare("SELECT describes FROM mediations WHERE id=:id AND mid_accepted = 0");
					$getOrderInfo->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
					$getOrderInfo->execute();
					
					if($getOrderInfo->rowCount() > 0){
						
						$_SESSION['_token']=bin2hex(openssl_random_pseudo_bytes(16));
						$fetchInfo=$getOrderInfo->fetch(PDO::FETCH_ASSOC);
						$describes=$fetchInfo['describes'] == null ? "لا يوجد تفاصيل": htmlspecialchars($fetchInfo['describes']);
						
						returnJSON(array('isSuccess' => true, 't' => 'تفاصيل الطلب:', 'm' => $describes, 'tp' => 'info','updatetoken' => $_SESSION['_token']));
						
					
					} else {
						returnJSON(array('isSuccess' => false, 't' => 'خطأ', 'm' => 'حدث خطأ غير متوقع جاري تحديث الصفحة..', 'tp' => 'error','reload' => true));
		
					}
					
				} else if($_GET['eventId'] == 1 && isset($_GET['msg'],$_GET['price'])){
					if(empty($_GET['msg']) or empty($_GET['price'])){
						http_response_code(520);
						returnJSON(array('isSuccess' => false,'tp' => 'error', 't' => 'خطأ', 'm' => 'تاكد من المدخلات..'), false);
					} else if(strlen($_GET['msg']) > 200 OR strlen($_GET['price']) > 200){
						http_response_code(518);
						returnJSON(array('isSuccess' => false,'tp' => 'error', 't' => 'خطأ', 'm' => 'يجب إن لا تتعدى المدخلات 64 حرف..'), false);

					}else if(!is_numeric($_GET['price']) OR $_GET['price'] > 50){
						http_response_code(506);
						returnJSON(array('isSuccess' => false,'tp' => 'error', 't' => 'خطأ', 'm' => 'يجب إن يكون المبلغ رقم وأن لا يتعدى المبلغ 50$'), false);	
					}else{}
					
					$checkIf=$conn->prepare("SELECT id FROM mediations WHERE id=:id AND mid_accepted=0");
					$checkIf->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
					$checkIf->execute();
					
					if($checkIf->rowCount() > 0){
						
						$checkRequester=$conn->query("SELECT reply_mid FROM mediations_reply WHERE reply_mid={$_SESSION['staffId:wse6']}");
						
						if($checkRequester->rowCount() == 0){
							
							$insertText=$conn->prepare("INSERT INTO mediations_reply (reply_id,reply_mid,reply_text,mid_price,time) VALUES (:id, {$_SESSION['staffId:wse6']}, :msg, :price, ".time().")");
							$insertText->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
							$insertText->bindValue(":msg", htmlspecialchars($_GET['msg']));
							$insertText->bindValue(":price", $_GET['price']);
							$insertText->execute();
							
							if($insertText->rowCount() > 0){
								returnJSON(array('tp' => 'success', 't' => 'حسناً', 'm' => 'تم إضافتك عرضك بنجاح!'));								
							} else {}
							
							
							
						} else {
							http_response_code(519);
							returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يوجد عرض مرسل بالفعل منك..'), false);
							
						}
						
						
						
					} else{}
					
					
				
				}else{}
				
			
			} else {
				returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'انت لست من طاقم الإدارة او ليس لديك صلاحية ..'));
			}
			
			
		
		} else {
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'انت لست من طاقم الإدارة او ليس لديك صلاحية ..'));
		}
		 
	}
}



?>