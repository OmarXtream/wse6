<?php
require_once("../includes/req.php");


if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'حدث خطأ غير معروف من فضلك أعد تحميل هذه الصفحة','b' => true));
	}

	if(isset($_POST['job'],$_POST['msg'],$_SESSION['memberId:wse6'])){		

		if(antiSpam("apply:apply.php")){
			returnJSON(array('t'=>'خطأ','m'=>'من فضلك انتظر قليلا ثم حاول مجدداً', 'tp'=>'error', 'b'=>'موافق'));
		}
		if($closeapply){
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'عفوا لكن التقديم مغلق حالياً','b' => true));
		}
		if(!ctype_digit($_POST['job']) OR mb_strlen($_POST['msg']) > 256 OR mb_strlen($_POST['job']) > 32){
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'حدث خطأ تاكد ان المدخلات صحيحة وايضأ تاكد ان الرسالة لا تتعدى 256 حرف..','b' => true));
		}
		
		if($_POST['job'] == 1 || $_POST['job'] == 3){
			// Wse6 = 1, Support => 3
			
			$conn=$database->openConnection();
			
			$checkRank= $conn->query('SELECT id FROM Customers WHERE id = '.$_SESSION['memberId:wse6'].' AND rank = 0');
			if($checkRank->rowCount() != 1){
				returnJSON(array('t'=>'خطأ','m'=>'انت إداري،  لا تستطيع تقديم طلب','tp'=>'error','b'=>true));
			} else {
			
				$stmt=$conn->query("SELECT id FROM apply_requests WHERE requester={$_SESSION['memberId:wse6']}");
				
				if($stmt->rowCount() > 0){
					
					returnJSON(array('t'=>'خطأ','m'=>'لديك طلب مسبقاً، تحت المراجعة..','tp'=>'error','b'=>true));

					
				} else {
					
					$addToDB=$conn->prepare("INSERT INTO apply_requests (requester,requestrank,request_msg) VALUES (".$_SESSION['memberId:wse6'].", ".$_POST['job'].",:msg)");
					$addToDB->bindValue(":msg", $_POST['msg']);
					$addToDB->execute();
					
					if($addToDB->rowCount() > 0) { 
						returnJSON(array('t'=>'حسناً','m'=>'تم ارسال طلبك بنجاحً!','tp'=>'success','b'=>true));
					}
					
					
				}	
			}
		}else{
			returnJSON(array('error'=>true));
		}
	}
}

?>