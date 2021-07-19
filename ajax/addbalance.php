<?php
require_once("../includes/req.php");

if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	if(!isset($_SESSION['_token']) OR !isset($_GET['token']) OR $_GET['token'] != $_SESSION['_token']){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'حدث خطأ غير معروف من فضلك أعد تحميل هذه الصفحة','b' => true));
	}

	if(isset($_GET['client'],$_GET['balance'])){		
		if(antiSpam("addbalance:addbalance.php")){
			returnJSON(array('t'=>'خطأ','m'=>'من فضلك انتظر قليلا ثم حاول مجدداً', 'tp'=>'error', 'b'=>'موافق'));
		}
		if(!ctype_digit($_GET['balance']) OR mb_strlen($_GET['client']) > 32 OR mb_strlen($_GET['balance']) > 32){
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'حدث خطأ تأكد ان جميع المدخلات ارقام ،، و لاتتعدى ال32 حرف..','b' => true));
		}
		
		if($_GET['balance'] > 0 && $_GET['balance'] <= $Config['maxSendBalance']){
				
				if($_GET['client'] != $_SESSION['memberId:wse6']){
				
				$conn=$database->openConnection();
				$stmt=$conn->prepare('SELECT username,Credits FROM Customers WHERE username=:nm');
				$stmt->bindValue(":nm", $_GET['client']);
				$stmt->execute();
	
				if($stmt->rowCount() > 0){
					$toSendData=$stmt->fetch(PDO::FETCH_ASSOC);
					$sender=$conn->query("SELECT Credits,username FROM Customers WHERE id={$_SESSION['memberId:wse6']}");
						if($sender->rowCount() > 0){
							$senderData=$sender->fetch(PDO::FETCH_ASSOC);
							if($senderData["Credits"] >= $_GET['balance']) {
								
								$removeCredits=$conn->query('UPDATE Customers SET Credits= Credits - '.$_GET['balance'].' WHERE id='.$_SESSION['memberId:wse6'].'');
								
								if($removeCredits->rowCount() > 0){
									$balance = taxCalc($_GET['balance'],0.15,2);
									$addCredits=$conn->prepare('UPDATE Customers SET Credits = Credits + '.$balance.' WHERE username=:nm');
									$addCredits->bindValue(":nm", $_GET['client']);
									$addCredits->execute();
									
									
									if($addCredits->rowCount() > 0){
										$time=time();
										$balanceWill=$senderData["Credits"] - $_GET['balance'];
										$sendToName = htmlspecialchars($toSendData["username"]);
										$responserId = $conn->prepare('SELECT id FROM Customers WHERE username = :user');
										$responserId->bindValue(":user", $_GET['client']);
										$responserId->execute();
										if($responserId->rowCount() > 0){
										$responserId=$responserId->fetch()['id'];
										$conn->query("INSERT INTO notification (notification,time,cid) VALUES ('لقد قمت بإرسال مبلغ:{$balance} إلى {$sendToName}',{$time},{$_SESSION['memberId:wse6']})");
										$notifyto = $conn->prepare("INSERT INTO notification (notification,time,cid) VALUES ('لقد استلمت مبلغ:{$balance} من {$senderData["username"]}',{$time},:id)");
										$notifyto->bindParam(":id", $responserId, PDO::PARAM_INT);
										$notifyto->execute();
										$database->closeConnection();
										
										returnJSON(array('tp' => 'success', 't' => 'حسناً', 'm' => 'تم إضافة المبلغ:'.$balance.' إلى '.htmlspecialchars($toSendData["username"]).' بنجاح!','balanceNow' => $balanceWill,'b' => true));
										}
										
									} else {
										
									}
									
								} else {

								}
								
							} else {
								$database->closeConnection();
								returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'الرصيد الذي يحتويه حسابك غير كافي.', 'b' => true));
								
							}
							
							
							
						}
	
	
	
					} else {
						$database->closeConnection();
						returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'لم يتم العثور على الشخص ...', 'b' => true));

					}
				} else {
				$database->closeConnection();
				returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'عذراً ولكن لايمكنك إرسال الأوموال إلى نفسك','b' => true));
	
					
				}
			}else{
				returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يجب اختيار رقم من 0 إلى '.$max.' من فضلك.', 'b' => true));
			}
}
}



?>