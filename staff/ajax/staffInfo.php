<?php
$amstaff = true;
require_once("../../includes/db.php");
require_once("../../includes/functions.php");
require_once("../inc/protection.php");
if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	if(!isset($_SESSION['_token']) OR !isset($_GET['token']) OR $_GET['token'] != $_SESSION['_token']){
		returnJSON(array('t'=>'خطأ', 'm'=>'حدث خطأ غير متوقع ، رجاءً قم بتحديث الصفحة.', 'tp'=>'error'));
	}

	if(isset($_GET['staff'],$_SESSION['staffId:wse6'])){
			if(antiSpam('staffInfo:info')){
				returnJSON(array('t' => 'خطأ','m' => 'من فضلك أنتظر قليلا بين محاولاتك','tp' => 'error','b' => 'موافق'));		
			} else if(rankPermission($_SESSION['staffId:wse6'],3,true) OR rankPermission($_SESSION['staffId:wse6'],1,true)){
				returnJSON(array('t'=>'خطأ','m'=>'عذرًا، لا تمتلك صلاحيات كافية','tp'=>'error','b'=>'موافق'));
			} else	if(!ctype_digit($_GET['staff']) OR strlen($_GET['staff']) > 32){
				returnJSON(array('t' => 'خطأ','m' => 'محاولة جيدة، نرجو عدم تكرارها','tp' => 'error','b' => 'موافق'));		
			}
			$conn=$database->openConnection();
			$check=$conn->query('SELECT username,Credits FROM Customers WHERE id= '.$_GET['staff'].'');
			if($check->rowCount() > 0){
				$dataCheck=$check->fetch();
				$username=htmlspecialchars($dataCheck["username"]);
				$earnings=$dataCheck["Credits"];
				returnJSON(array('done' => true,'name' => $username, 'earnings' => $earnings));
			} else {
				returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'لم يتم العثور على الشخص ...'));
			}
	}
}



?>