<?php
$amstaff = true;
require_once("../../includes/db.php");
require_once("../../includes/functions.php");
require_once("../inc/protection.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		returnJSON(array('t'=>'خطأ', 'm'=>'حدث خطأ غير متوقع ، رجاءً قم بتحديث الصفحة.', 'tp'=>'error'));
	}
	if(rankPermission($_SESSION['staffId:wse6'],3,true) OR rankPermission($_SESSION['staffId:wse6'],1,true)){
		returnJSON(array('t' => 'خطأ', 'm' => 'ليس لديك صلاحية لدخول هذه الصفحة', 'tp'=>'error'));
	}
	if(isset($_POST['reqId'], $_SESSION['staffId:wse6'])) {
		
		if(empty($_POST['reqId']) OR !ctype_digit($_POST['reqId']) OR strlen($_POST['reqId']) > 30){
			returnJSON(array('error'=>true));
		} else if(antiSpam('applyList:req')){
			returnJSON(array('t' => 'خطأ','m' => 'من فضلك أنتظر قليلا بين محاولاتك','tp' => 'error','b' => 'موافق'));		
		} 
		
		$conn = $database->openConnection();
		
		$stmt = $conn->prepare('SELECT request_msg,requestrank FROM apply_requests WHERE requester = :req');
		$stmt->bindValue(":req", $_POST['reqId']);
		$stmt->execute();
		
		if($stmt->rowCount() > 0){
			
			$data = $stmt->fetch();
			$rank = $data['requestrank'] == 1 ? 'وسيط' : 'دعم فني';
			
			returnJSON(array('isSuccess' => true,'desc'=>htmlspecialchars($data['request_msg']), 'rank'=>$rank,'id'=>$_POST['reqId'],'updatetoken'=>tokenHandler()));
			
		} else {
			returnJSON(array('isSuccess'=>false, 't'=>'خطأ','m'=>'لم يتم العثور على الطلب، أعد تحديث الصفحة..','tp'=>'error', 'b'=>'موافق','updatetoken'=>tokenHandler()));
		}
		
		
		
	} else if(isset($_POST['accept'], $_SESSION['staffId:wse6'])) {
	
		if(empty($_POST['accept']) OR !ctype_digit($_POST['accept']) OR strlen($_POST['accept']) > 30){
			returnJSON(array('error'=>true));
		} 
		
		$conn = $database->openConnection();
		
		$stmt = $conn->prepare('SELECT requestrank FROM apply_requests WHERE requester = :req');
		$stmt->bindValue(":req", $_POST['accept'], PDO::PARAM_INT);
		$stmt->execute();
		
		if($stmt->rowCount() > 0){
			
			$data = $stmt->fetch();
			$rank = $data["requestrank"] == 1 ? 1 : 3;
			
			$update = $conn->prepare('UPDATE Customers SET isStaff = 1,rank = '.$rank.' WHERE id =:req; DELETE FROM apply_requests WHERE requester= :req ');
			$update->bindValue(":req", $_POST['accept'], PDO::PARAM_INT);
			$update->execute();
			
			if($update->rowCount() > 0){
				addNotify("تهانيناً، تم قبول طلب التقديم بنجاح!", $_POST['accept']);
				returnJSON(array('isSuccess' => true , 't'=>'حسناً','m'=>'تم قبول الطلب بنجاحً، جاري تحديث الصفحة..','tp'=>'success','b'=>'شكرًا'));
			} else {
				returnJSON(array('isSuccess'=>false, 't'=>'خطأ','m'=>'حدث خطأ، المقدم يمتلك رتبة إدارية فعلاً!','tp'=>'error', 'b'=>'موافق'));	

			}
			
		} else {
			returnJSON(array('isSuccess'=>false, 't'=>'خطأ','m'=>'لم يتم العثور على الطلب، أعد تحديث الصفحة..','tp'=>'error', 'b'=>'موافق'));	
		}
		
		
	} else if(isset($_POST['cancel'], $_SESSION['staffId:wse6'])){
	
		if(empty($_POST['cancel']) OR !ctype_digit($_POST['cancel']) OR strlen($_POST['cancel']) > 30){
			returnJSON(array('error'=>true));
		}
		
		$conn = $database->openConnection();
		
		$stmt = $conn->prepare('SELECT id FROM apply_requests WHERE requester = :req');
		$stmt->bindValue(":req", $_POST['cancel'], PDO::PARAM_INT);
		$stmt->execute();
		
		if($stmt->rowCount() > 0){
			
			$delete= $conn->prepare('DELETE FROM apply_requests WHERE requester = :req');
			$delete->bindValue(":req", $_POST['cancel'], PDO::PARAM_INT);
			$delete->execute();
			
			if($delete->rowCount() > 0 ) {
				addNotify("نأسف، تم رفض طلبك للتقديم!", $_POST['cancel']);
				returnJSON(array('isSuccess' => true , 't'=>'حسناً','m'=>'تم رفض الطلب بنجاح','tp'=>'success','b'=>'شكرًا'));
			} else {
				returnJSON(array('isSuccess'=>false, 't'=>'خطأ','m'=>'حدث خطأ غير متوقع.. يرجئ تحديث الصفحة..','tp'=>'error', 'b'=>'موافق'));	
			}
			
			
		} else {
			returnJSON(array('isSuccess'=>false, 't'=>'خطأ','m'=>'لم يتم العثور على الطلب، أعد تحديث الصفحة..','tp'=>'error', 'b'=>'موافق'));	
		}
		
	}

}
?>