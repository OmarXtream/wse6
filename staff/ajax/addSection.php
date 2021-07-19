<?php
$amstaff = true;
require_once("../../includes/db.php");
require_once("../../includes/functions.php");
require_once("../inc/protection.php");
if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	if(!isset($_SESSION['_token']) OR !isset($_GET['token']) OR $_GET['token'] != $_SESSION['_token']){
		rreturnJSON(array('t'=>'خطأ', 'm'=>'حدث خطأ غير متوقع ، رجاءً قم بتحديث الصفحة.', 'tp'=>'error'));
	}
	
	if(isset($_GET['name'], $_SESSION['staffId:wse6'])){
		
		if(mb_strlen($_GET['name']) > 32 ){
			returnJSON(array('t'=>'خطأ','m'=>'يجب ان لايتعدى اسم القسم 32 حرف.','tp'=>'error','b'=>'موافق'));
		} else if(antiSpam('addSection:name')){
			returnJSON(array('t' => 'خطأ','m' => 'من فضلك أنتظر قليلا بين محاولاتك','tp' => 'error','b' => 'موافق'));		
		}  else if(!rankPermission($_SESSION['staffId:wse6'],4)) {
			returnJSON(array('t'=>'خطأ','m'=>'عذرًا، لا تمتلك صلاحيات كافية','tp'=>'error','b'=>'موافق'));
		} 
		
		$conn=$database->openConnection();
		
		$stmt = $conn->prepare('SELECT title FROM sections WHERE title = :title');
		$stmt->bindValue(":title", $_GET['name']);
		$stmt->execute();
		
		if($stmt->rowCount() > 0){
			returnJSON(array('t'=>'خطأ','m'=>'يوجد هاذا القسم بالفعل','tp'=>'error','b'=>'موافق'));
		} else {
			
			$insertIt = $conn->prepare('INSERT INTO sections (title) VALUES (:title)');
			$insertIt->bindValue(":title", $_GET['name']);
			$insertIt->execute();
			
			if($insertIt->rowCount() > 0){
				returnJSON(array('t'=>'حسناً','m'=>'تم اضافة القسم بنجاح','tp'=>'success', 'b'=>'موافق'));
			}
		}
	}

}
?>