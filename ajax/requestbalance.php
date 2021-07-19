<?php
require_once("../includes/req.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		returnJSON(array('tp' => 'error', "m" => "Invalid CSRF Token", "b" => true, "t" => 'خطأ'));
	}

	if(isset($_POST['requestBalance'],$_SESSION['memberId:wse6'])){
		if($_POST['requestBalance'] == 1){
			if(antiSpam("requestbalance.php:requestBalance")){
				returnJSON(array('tp' => 'error', "m" => "من فضلك إنتظر قليلا بين محاولاتك", "b" => true, "t" => 'خطأ'));
			}else{
				$conn = $database->openConnection();
				$statement = $conn->query('SELECT Credits FROM Customers WHERE id='.$_SESSION['memberId:wse6'].' AND rank >= 1');
				if($statement->rowCount() == 0){
					returnJSON(array('tp' => 'error', "m" => "عفوا ولكن أنت لا تملك صلاحية للوصول إلى هذه الصفحه", "b" => true, "t" => 'خطأ'));
				}else{
					$balance = current($statement->fetch());
					if(floor($balance) >= 20){
						$stmt = $conn->query('SELECT id FROM ticket WHERE creator='.$_SESSION['memberId:wse6'].' AND type=5 AND status <> 0');
						if($stmt->rowCount() != 0){
							returnJSON(array('tp' => 'error', "m" => "يتضح أن لديك طلب أرباح سابق", "b" => true, "t" => 'خطأ'));
						}else{
							$time = time();
							$insertData = $conn->prepare("INSERT INTO ticket (creator, title, msg, type, status, time, for_rank) VALUES (:creator,:title,:msg, 5, 1, {$time}, 5)");
							$insertData->bindValue(':creator', $_SESSION['memberId:wse6']);
							$insertData->bindValue(':title', 'طلب أرباحي');
							$insertData->bindValue(':msg', 'الأرباح : '.$balance);
							$insertData->execute();
							if($insertData->rowCount() > 0){
								returnJSON(array('tp' => 'success', "m" => "تم فتح تذكره لطلب الأرباح راجع صفحة التذاكر لمعرفة حالة الطلب", "b" => true, "t" => 'تم'));
							}
						}
					}else{
						returnJSON(array('tp' => 'error', "m" => "يجب أن تكون إرباحك أكثر من 20 دولار لتنفيذ هذه العملية", "b" => true, "t" => 'خطأ'));
					}
				}
			}
		}
	}
}



?>