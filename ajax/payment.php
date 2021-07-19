<?php
require_once("../includes/req.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){

	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token'] OR !isset($_SESSION['memberId:wse6'])){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'حدث خطأ غير معروف من فضلك أعد تحميل هذه الصفحة','b' => true));
	}
	
	if(isset($_POST['cardsData'],$_POST['typeData'],$_POST['company'],$_POST['price'])){
		$typesAllowed = array(15,20,30,50,100);
		$cardsData = explode(',', $_POST['cardsData']);
		$typeData = explode(',', $_POST['typeData']);
		$company = $_POST['company'];
		$price = $_POST['price'];
		if(antiSpam('payments.php:cards')){
			returnJSON(array('t' => 'خطأ','m' => 'من فضلك أنتظر قليلا بين محاولاتك','tp' => 'error','b' => true));		
		}elseif(!ctype_digit($price) or !in_array($price,explode(',', $Config['prices'])) or ($company != 'stc' and $company != 'mobily') or count($cardsData) > $price or count($typeData) != count($cardsData)){
			returnJSON(array('t' => 'خطأ','m' => 'من فضلك تأكد من المدخلات','tp' => 'error','b' => true));		
		}else{
			if($_POST['typeData'] == 'stc' and $closestc){
				returnJSON(array('t' => 'خطأ','m' => 'الدفع عن طريق بطائق شحن شركة الإتصالات تحت الصيانة في الوقت الحالي','tp' => 'error','b' => true));		
			}elseif($_POST['typeData'] == 'mobily' and $closemobily){
				returnJSON(array('t' => 'خطأ','m' => 'الدفع عن طريق بطائق شحن شركة موبايلي تحت الصيانة في الوقت الحالي','tp' => 'error','b' => true));		
			}
			$conn = $database->openConnection();
			$sql = $conn->query("SELECT id FROM Customers WHERE id='{$_SESSION['memberId:wse6']}'");
			if($sql->rowCount() == 0){
					returnJSON(array('t' => 'خطأ','m' => 'حدث خطأ غير معروف ','tp' => 'error','b' => true));		
			}
			$company == 'mobily' ? array_push($typesAllowed, 10) : array_push($typesAllowed, 25);
			foreach($cardsData as $card){
				if(!ctype_digit($card) or strlen($card) > 16 or strlen($card) < 14 or $card < 0){
					returnJSON(array('t' => 'خطأ','m' => 'من فضلك تأكد من المدخلات','tp' => 'error','b' => true));		
				}elseif($conn->query('SELECT id FROM cardsPayments WHERE card='.$card.' AND status=4')->rowCount() > 0){
					returnJSON(array('t' => 'خطأ','m' => 'هذه البطاقة مستخدمه مسبقاً','tp' => 'error','b' => true));		
				}
			}
			foreach($typeData as $type){
				if(!ctype_digit($type) or strlen($type) > 3 or strlen($type) < 1 or !in_array($type,$typesAllowed)){
					returnJSON(array('t' => 'خطأ','m' => 'من فضلك تأكد من المدخلات','tp' => 'error','b' => true));		
				}
			}
			$method = $company == 'stc' ? 2 : 3;
			$time = time();
			$conn->query('INSERT INTO payments (cid,price,method,status,time) VALUES ('.$_SESSION['memberId:wse6'].', '.$price.', '.$method.', 4, '.$time.')');
			$pid = current($conn->query('SELECT id FROM payments WHERE cid='.$_SESSION['memberId:wse6'].' AND time='.$time.' ORDER BY time DESC')->fetch());
			$i = 0;
			foreach($cardsData as $card){
				$conn->query('INSERT INTO cardsPayments (cid,pid,price,card,type,status) VALUES ('.$_SESSION['memberId:wse6'].', '.$pid.', '.$price.', "'.$card.'", '.$typeData[$i].', 4)');
				$i++;
			}
			returnJSON(array('t' => 'تم','m' => 'تم إرسال البطائق وسيتم مراجعتها بأقرب وقت','tp' => 'success','b' => true));		
		}
	}
	if(isset($_POST['editCard'],$_POST['newCard'])){
		$cid = $_POST['editCard'];
		$newCard = $_POST['newCard'];
		$conn = $database->openConnection();
		if(antiSpam('payments.php:editCard')){
			returnJSON(array('t' => 'خطأ','m' => 'من فضلك أنتظر قليلا بين محاولاتك','tp' => 'error','b' => true));		
		}
		$sql = $conn->query("SELECT id FROM Customers WHERE id='{$_SESSION['memberId:wse6']}'");
		if($sql->rowCount() == 0){
			returnJSON(array('t' => 'خطأ','m' => 'حدث خطأ غير معروف ','tp' => 'error','b' => true));		
		}elseif(!ctype_digit($cid) or strlen($cid) > 30 or empty($cid) or $cid < 0){
			returnJSON(array('t' => 'خطأ','m' => 'من فضلك تأكد من المدخلات','tp' => 'error','b' => true));		
		}elseif(!ctype_digit($newCard) or strlen($newCard) > 16 or strlen($newCard) < 14 or $newCard < 0){
			returnJSON(array('t' => 'خطأ','m' => 'رقم البطاقة الجديد غير صحيحه','tp' => 'error','b' => true));		
		}
		$statement = $conn->query('SELECT pid FROM cardsPayments WHERE cid='.$_SESSION['memberId:wse6'].' AND id='.$cid.' AND status <> 1 AND status <> 3');
		if($statement->rowCount() == 0){
			returnJSON(array('t' => 'خطأ','m' => 'هذه البطاقة لا يمكن تعديلها','tp' => 'error','b' => true));		
		}
		$pid = current($statement->fetch());
		$pstatement = $conn->query('SELECT id FROM payments WHERE cid='.$_SESSION['memberId:wse6'].' AND id='.$pid.' AND status <> 1 AND status <> 5');
		if($pstatement->rowCount() == 0){
			returnJSON(array('t' => 'خطأ','m' => 'هذا الطلب لا يمكن تعديله','tp' => 'error','b' => true));		
		}else{
			$conn->query('UPDATE cardsPayments SET card='.$newCard.',status=4 WHERE cid='.$_SESSION['memberId:wse6'].' AND id='.$cid.' AND status <> 1 AND status <> 3');
			$conn->query('UPDATE payments SET status=4 WHERE cid='.$_SESSION['memberId:wse6'].' AND id='.$pid.' AND status <> 1 AND status <> 5');
			returnJSON(array('t' => 'تم','m' => 'تم إرسال البطاقة الجديده','tp' => 'success','b' => false));		
			
		}
		
		
		
		
	}
}


?>