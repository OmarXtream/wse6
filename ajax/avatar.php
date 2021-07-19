<?php
require_once("../includes/req.php");

if(isset($_FILES['file'])){
	
	if(antiSpam("avatar:avatar.php")){
		returnJSON(array('t'=>'خطأ','m'=>'من فضلك انتظر قليلا ثم حاول مجدداً', 'tp'=>'error', 'b'=>'موافق'));
	}
    $img=$_FILES['file'];
	$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
	$detectedType = exif_imagetype($img['tmp_name']);
    if($img['name']=='' or !in_array($detectedType, $allowedTypes)){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'بجب أن يكون الملف صورة من صيغة PNG أو JPEG','b' => true));
	}elseif($img['size'] > (10*1048576)){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يجب أن يكون حجم الملف أقل من 10 ميجا بايت','b' => true));
	}elseif($img['error'] > 0){
		returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يبدو أن النظام لم يقبل هذه الصورة نرجو تغييرها','b' => true));
    }else{
		$conn=$database->openConnection();
		$stmt=$conn->query("SELECT lastavatar,img FROM Customers WHERE id={$_SESSION['memberId:wse6']}");
		foreach($stmt as $row){
			$lastavatar=$row["lastavatar"];
			$imga=$row["img"];
		}
		if(time() > $lastavatar+604800){
			 $filename = $img['tmp_name'];
			 $client_id="f43dd41f0aa7c2d";//Your Client ID here
			 $handle = fopen($filename, "r");
			 $data = fread($handle, filesize($filename));
			 $pvars   = array('image' => base64_encode($data));
			 $timeout = 30;
			 $curl    = curl_init();
			 curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
			 curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
			 curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
			 curl_setopt($curl, CURLOPT_POST, 1);
			 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			 curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
			 $out = curl_exec($curl);
			 curl_close ($curl);
			 $pms = json_decode($out,true);
			 $url=$pms['data']['link'];
			 if($url!=""){
				$a=$conn->query("UPDATE Customers SET img='".$url."',lastavatar=".time()." WHERE id='".$_SESSION['memberId:wse6']."'");
				if($a->rowCount() > 0){
					returnJSON(array('tp' => 'success', 't' => 'تم', 'm' => 'لقد تم رفع الصورة بنجاح','b' => true));
				}
			 }else{
				returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'نأسف ولكن لقد حدث خطأ vbvbnغير معروف','b' => true));
			 }
		}else{
			returnJSON(array('tp' => 'error', 't' => 'خطأ', 'm' => 'يرجى انتظار اسبوع لتغيير صورتك مرة اخرى','b' => true));
		}
    }
	
}

?>