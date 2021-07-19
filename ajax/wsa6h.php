<?php
session_start();
require_once("../includes/db.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){

	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		die();
	}
   
   if(isset($_POST['choose'])){
		
		if(antiSpam("choose:wsa6h.php")){
			returnJSON(array('t'=>'خطأ','m'=>'من فضلك انتظر قليلا ثم حاول مجدداً', 's'=>'error', 'b'=>'موافق'));
		}
		$value=$_POST['choose'];
			
		if(filter_var($value, FILTER_VALIDATE_INT) === false){
			returnJSON(array('t'=>'حسنأً','m'=>'تم اغلاق التذكرة بنجاح!','s'=>'success', 'b'=>'موافق'));
		}else{	
		
			$database=$database->openConnection();
			
			$stmt=$database->prepare("SELECT * FROM sections WHERE id=:id");
			$stmt->bindParam(":id", $value, PDO::PARAM_INT);
			$stmt->execute();
			
			if($stmt->rowCount() > 0){
				foreach($stmt as $row){
					$title=$row["title"];
				}
				returnJSON(array('title'=>"طلب وساطه &mdash;".htmlspecialchars($title),'data'=>'<select class="js-select2 form-control" onchange="_change(this)"><option> إسم البرنامج </option><option value="1"> يوتيوب </option></select>'));
			}
			
		}
		
		
	}else{}
	

}
?>