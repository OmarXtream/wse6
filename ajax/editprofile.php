<?php
require_once("../includes/req.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){

	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'حدث خطأ غير معروف من فضلك أعد تحميل هذه الصفحة','b' => true));
	}
	
	if(isset($_POST['newName'])){
		$newName = $_POST['newName'];
		if(antiSpam("changeName:editprofile.php")){
			returnJSON(array('t'=>'خطأ','m'=>'من فضلك انتظر قليلا ثم حاول مجدداً', 'tp'=>'error', 'b'=>'موافق'));
		}elseif($newName == null || $newName == ""){
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'تأكد من المدخلات','b' => true));
		}elseif(strlen($newName) < 3 || strlen($newName) > 16){
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يجب إن يكون الاسم اكثر من 3 احرف او ارقام ولا يتعدى 16 ','b' => true));
		}elseif(!preg_match("/^[A-Za-z0-9_]+$/", $newName)) {
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يجب إن يحتوي الاسم فقط على احرف إنجليزية وارقام و_','b' => true));
		}else{
			$conn=$database->openConnection();
			$stmt=$conn->prepare("SELECT username FROM Customers WHERE username=:name");
			$stmt->bindValue(":name", $newName);
			$stmt->execute();
			if($stmt->rowCount() == 0){
				$time= current($conn->query("SELECT lastupname FROM Customers WHERE id={$_SESSION['memberId:wse6']}")->fetch());
				if(time() > $time+604800){
					$sstmt=$conn->prepare("UPDATE Customers SET username=:name,lastupname=".time()." WHERE id={$_SESSION['memberId:wse6']}");
					$sstmt->bindValue(":name", $newName);
					$sstmt->execute();
					if($sstmt->rowCount() > 0){
						returnJSON(array('tp' => 'success', 't' => 'تم', 'm' => 'تم تغيير إسم المستخدم بنجاح، تهانينا ','b' => true));
					}else{ 
						returnJSON(array('tp' => 'success', 't' => 'خطأ', 'm' => 'حدث خطاً غير متوقع،، حاول من جديد','b' => true));		
					}
				}else{
					returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يرجى إنتظار اسبوع لتغيير اسمك مرة اخرى ','b' => true));
				}
			}else{
				returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'إلاسم مستخدم من قبل ','b' => true));
			}
		}
	}elseif(isset($_POST['nwePhone'])){
		$nwePhone = $_POST['nwePhone'];
		if(antiSpam("changePhone:editprofile.php")){
			returnJSON(array('t'=>'خطأ','m'=>'من فضلك انتظر قليلا ثم حاول مجدداً', 'tp'=>'error', 'b'=>'موافق'));
		}elseif($nwePhone == null || $nwePhone == ""){
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'تأكد من المدخلات','b' => true));
		}elseif(strlen($nwePhone) < 7 || strlen($nwePhone) > 14){
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يجب إن يكون رقم الهاتف صحيح ','b' => true));
		}elseif(!validateMobile($nwePhone)){
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يجب إن يكون رقم الهاتف صحيح','b' => true));
		}else{
			$conn=$database->openConnection();
				$time= current($conn->query("SELECT lastphonechanged FROM Customers WHERE id={$_SESSION['memberId:wse6']}")->fetch());
				if(time() > $time+604800){
					$sstmt=$conn->prepare("UPDATE Customers SET phonenumber=:phone,lastphonechanged=".time()." WHERE id={$_SESSION['memberId:wse6']}");
					$sstmt->bindValue(":phone", $nwePhone);
					$sstmt->execute();
					if($sstmt->rowCount() > 0){
						returnJSON(array('tp' => 'success', 't' => 'تم', 'm' => 'تم تغيير رقم الهاتف بنجاح، تهانينا ','b' => true));
					}else{ 
						returnJSON(array('tp' => 'success', 't' => 'خطأ', 'm' => 'حدث خطاً غير متوقع،، حاول من جديد','b' => true));		
					}
				}else{
					returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يرجى إنتظار اسبوع لتغيير رقمك مرة اخرى ','b' => true));
				}
		}
	}elseif(isset($_POST['newPwd']) && isset($_POST['oldPwd'])){
		$newPwd=htmlspecialchars($_POST['newPwd']);
		$oldPwd=$_POST['oldPwd'];
		if(antiSpam("changePwd:editprofile.php")){
			returnJSON(array('t'=>'خطأ','m'=>'من فضلك انتظر قليلا ثم حاول مجدداً', 'tp'=>'error', 'b'=>'موافق'));
		}elseif($newPwd == $oldPwd){
			returnJSON(array('t' => 'خطأ','m' => 'الرمز السابق يطابق الجديد.','tp' => 'error', 'b' => true));
		}elseif(strlen($newPwd) < 8 || strlen($newPwd) > 36){
			returnJSON(array('t' => 'خطأ','m' => 'يجب ان تكون كلمة المرور من 8 أحرف او ارقام ولا تتعدى 36.','tp' => 'error', 'b' => true));
			exit(json_encode($response));				
		}elseif(!password_strength($newPwd)){
			returnJSON(array('t' => 'خطأ','m' => 'يجب إن تحتوي كلمة المرور على حروف كبيرة وصغيره وأرقام.','tp' => 'error', 'b' => true));
		}else{
			$conn=$database->openConnection();
			$stmt=$conn->query("SELECT password,lastpwdu FROM Customers WHERE id={$_SESSION['memberId:wse6']}")->fetch();
			$password=$stmt["password"];
			$lastpwdu=$stmt["lastpwdu"];
			if(password_verify($oldPwd, $password)){
				if(time() > $lastpwdu+604800){
					$newPasswordHashed=password_hash($newPwd, PASSWORD_DEFAULT); // تشفير الباس لحماية خصوصية الاشخاص
					$cc=$conn->prepare("UPDATE Customers SET password=:pwd,lastpwdu=".time()." WHERE id={$_SESSION['memberId:wse6']}");
					$cc->bindValue(":pwd", $newPasswordHashed);
					$cc->execute();
					if($cc->rowCount() > 0){
						session_regenerate_id();
						returnJSON(array('tp' => 'success', 't' => 'تم', 'm' => 'تم تحديث كلمة المرور بنجاح،','b' => true));
					}
				}else{
					returnJSON(array('t' => 'خطأ','m' => 'يرجى إنتظار اسبوع لتغيير كلمة مرورك.','tp' => 'error', 'b' => true));			
				}
			}else{
				returnJSON(array('t' => 'خطأ','m' => 'الرمز السابق لا يطابق الحآلي.','tp' => 'error', 'b' => true));
			}
		}
	}
}

?>