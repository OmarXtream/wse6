<?php
require_once("../includes/req.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){

	if(!isset($_SESSION['_token']) OR !isset($_POST['token']) OR $_POST['token'] != $_SESSION['_token']){
		returnJSON(array('t'=>'خطأ','m'=>'حدث خطأ غير معروف من فضلك أعد تحميل هذه الصفحة', 's'=>'error', 'b'=>'موافق'));
	} else if(antiSpam("Mediations")){
		returnJSON(array('t'=>'خطأ','m'=>'من فضلك انتظر قليلا ثم حاول مجدداً', 's'=>'error', 'b'=>'موافق'));
	}

	
	if(isset($_POST['qasm'],$_POST['describe'])){
		$qasm=$_POST['qasm'];
		$describe=htmlspecialchars($_POST['describe']);
		
		if(empty($qasm) || empty($describe)){
			returnJSON(array('t' =>'خطأ', 'm' => 'تأكد من المدخلات', 's' => 'error', 'b' => 'موافق'));
		} else if(mb_strlen($describe) > 256){
			returnJSON(array('t' => 'خطأ', 'm' => 'يجب أن لا يتعدى الوصف 256 حرف.', 's'=>'error','b' => 'موافق'));
		}else if(!ctype_digit($qasm)){
			returnJSON(array('t' => 'خطأ', 'm' => 'وش قاعد تسوي ؟', 's'=>'error','b' => 'خلاص أسف'));
		}else{
			$conn=$database->openConnection();
			
			$credits=current($conn->query("SELECT Credits FROM Customers WHERE id='{$_SESSION['memberId:wse6']}'")->fetch());
			
			if($credits == 0){
				returnJSON(array('t' => 'خطأ', 'm' => 'يجب توفر على الإقل دولار في الحساب لطلب الوساطة', 's'=>'error','b' => 'موافق'));
			}
			
			
			$count=current($conn->query("SELECT count(*) FROM mediations WHERE creator='{$_SESSION['memberId:wse6']}' AND status=1;")->fetch());
			if($count > 0){
				returnJSON(array('t' => 'خطأ', 'm' => 'لا تستطيع فتح اكثر من طلب غير معالج.', 's'=>'error','b' => 'موافق'));
			} else {
				$stmtz=$conn->prepare("SELECT id FROM sections WHERE id=:id");
				$stmtz->bindParam(":id", $qasm, PDO::PARAM_INT);
				$stmtz->execute();
				if($stmtz->rowCount() > 0){
				
					$stmt=$conn->prepare("INSERT INTO mediations (creator,type,describes,status,create_time) VALUES ({$_SESSION['memberId:wse6']}, :qasm, :describe, 1,".time().")");
					$stmt->bindParam(":qasm", $qasm, PDO::PARAM_INT);
					$stmt->bindValue(":describe", $describe);
					$stmt->execute();
					
					if($stmt->rowCount() > 0){
						$database->closeConnection();
						
						returnJSON(array('t' => 'حسناً', 'm' => 'تم إنشاء طلبك بنجاح.', 's'=>'success','b' => 'موافق','done'=>true));	
					}else{
						$database->closeConnection();
						
						returnJSON(array('t' => 'خطأ', 'm' => 'حدث خطاً غير متوقع حاول مججدا لأحقاً.', 's'=>'error','b' => 'موافق'));			
					}
				}else{
					returnJSON(array('t' => 'خطأ', 'm' => 'ماذا تحاول فعله؟', 's'=>'error','b' => 'موافق'));
				}
			}
			
		}
		
	}else if(isset($_POST['action'],$_POST['id'])){
		$action=$_POST['action'];
		$id=$_POST['id'];
		$allowedActions=array("info","accept");
		if(!in_array($action,$allowedActions) || empty($id) || !ctype_digit($id)){
			returnJSON(array('error'=>true,'errorCode'=>'Trying to hack our website...'));	
		}else{
			
			$conn=$database->openConnection();
			$info=$conn->query("SELECT id FROM mediations WHERE creator={$_SESSION['memberId:wse6']} AND status=1");
			
			if($info->rowCount() == 1){
				
				foreach($info as $row){
					$idz=$row["id"];
				}
				
				if($action == "info"){
					
					$stmtz=$conn->prepare("SELECT reply_text,mid_price,reply_mid FROM mediations_reply WHERE reply_id={$idz} AND reply_mid=:id");
					$stmtz->bindParam(":id", $id, PDO::PARAM_INT);
					$stmtz->execute();
					
					if($stmtz->rowCount() == 1){
						
						foreach($stmtz as $stz){
							$text=htmlspecialchars($stz["reply_text"]);
							$idwseet=$stz["reply_mid"];
							$price=$stz["mid_price"];
						}

						$stmt=$conn->query("SELECT username FROM Customers WHERE id={$idwseet}");
						
						if($stmt->rowCount() > 0){
						
						foreach($stmt as $row){
							$username=htmlspecialchars($row["username"]);
						}
						
						$database->closeConnection();
						
						returnJSON(array('name' => $username, 'text' => $text, 'price'=>$price,'type' => 'doneInfo'));
						
						} else {
						returnJSON(array('error'=>true,'t' => 'خطأ', 'm' => 'حدث مشكلة غير متوقعة يرجى تحديث الصفحة..', 's'=>'error','b' => 'موافق'));	
		
						}
					}else{die();}
					
					
					
				}else{
					$stmtz=$conn->prepare("SELECT reply_mid,mid_price FROM mediations_reply WHERE reply_mid=:id");
					$stmtz->bindParam(":id", $id,PDO::PARAM_INT);
					$stmtz->execute();
					
					if($stmtz->rowCount() > 0){
						$dataFetchedFromReplies=$stmtz->fetch(PDO::FETCH_ASSOC);
						$checkMoney=$conn->query("SELECT Credits FROM Customers WHERE id={$_SESSION['memberId:wse6']}")->fetch();
						$moneyRemains=$dataFetchedFromReplies["mid_price"] - $checkMoney["Credits"];
						if($checkMoney["Credits"] >= $dataFetchedFromReplies["mid_price"]){
						
						$sttmt=$conn->prepare("SELECT username,phonenumber FROM Customers WHERE id=:id");
						$sttmt->bindParam(":id", $id,PDO::PARAM_INT);
						$sttmt->execute();
						
						if($sttmt->rowCount() > 0){
						
						foreach($sttmt as $st){$username=htmlspecialchars($st["username"]);
						$phonenumber=$st["phonenumber"];}
						
						$acode= substr(uniqid(rand(), true), 11, 6);
						$stmt=$conn->prepare("UPDATE mediations SET status='0', mid_accepted=:id,accept_code='{$acode}' WHERE creator={$_SESSION['memberId:wse6']} AND status=1");
						$stmt->bindParam(":id", $id, PDO::PARAM_INT);
						$stmt->execute();
						
						if($stmt->rowCount() > 0){
								$database->closeConnection();
													
								$resp=array("type" => "doneAccept","code" => $acode,"name" => $username,"content" => "<p>
								تم قبول الوسيط : {$username}<br/>
								يرجى إرسال الكود : {$acode}<br/> إلى هاذا الرقم : {$phonenumber} </p><hr/>
								<p class='text-danger'>إذا كنت تريد تبديل الوسيط قم بالضغط على الزر بالإسفل.</p>
								<button class='btn btn-alt-danger' onClick=_cancel('tbdeel')><i class='fa fa-arrow-right mr-5'></i> تبديل الوسيط </button>");
							
								returnJSON($resp);
						}
					
								}else{
									returnJSON(array('error'=>true,'t' => 'خطأ', 'm' => 'حدثت مشكلة غير متوقعة يرجى تحديث الصفحة', 's'=>'error','b' => 'موافق'));	
								}
						}else{
							returnJSON(array('error'=>true,'t' => 'خطأ', 'm' => "يجب أن يتوفر لديك ".$moneyRemains."$ لقبول الوسيط..", 's'=>'error','b' => 'موافق'));
						}
					
					}else{
						returnJSON(array('error'=>true,'t' => 'خطأ', 'm' => 'حدثت مشكلة غير متوقعة يرجى تحديث الصفحة', 's'=>'error','b' => 'موافق'));	
					}
					
				}
				
				
				
			}else{
				returnJSON(array('error'=>true,'t' => 'خطأ', 'm' => 'حدثت مشكلة غير متوقعة يرجى تحديث الصفحة', 's'=>'error','b' => 'موافق'));	
			}
			
			
		}
		
	}else if(isset($_POST['cancel']) && !empty($_POST['cancel'])){
		$conn=$database->openConnection();
		
		if($_POST['cancel'] == "wsa6h"){
		
			$stmt=$conn->query("SELECT id FROM mediations WHERE status='1' AND mid_accepted='0' AND creator='{$_SESSION['memberId:wse6']}'");
		
			if($stmt->rowCount() > 0){
				
				foreach($stmt as $st){$id=$st["id"];}
				
				$close=$conn->query("UPDATE mediations SET status='0' WHERE id={$id}");
				
				if($close->rowCount() > 0){
					$database->closeConnection();
					returnJSON(array('doneClose'=>true));
				}
				
			}else{
				returnJSON(array('t' => 'خطأ', 'm' => 'حدثت مشكلة غير متوقعة يرجى تحديث الصفحة', 's'=>'error','b' => 'موافق'));
			}
			
		
		}else if($_POST['cancel'] == "tbdeel"){
			$stmtz=$conn->query("SELECT id FROM mediations WHERE status='0' AND mid_accepted != '0' AND accept_code != '' AND creator='{$_SESSION['memberId:wse6']}'");
			
			if($stmtz->rowCount() > 0){
				
				foreach($stmtz as $st){$id=$st["id"];}
				
			} else {
				returnJSON(array('t' => 'خطأ', 'm' => 'حدثت مشكلة غير متوقعة يرجى تحديث الصفحة', 's'=>'error','b' => 'موافق'));
			}
						
			$stmt=$conn->query("UPDATE mediations SET mid_accepted='0',accept_code='', status='1' WHERE id={$id}");
			
			if($stmt->rowCount() > 0){
				$database->closeConnection();
					
				returnJSON(array('doneTbdel' => true));
				
			} else {
				$database->closeConnection();

				returnJSON(array('t' => 'خطأ', 'm' => 'حدثت مشكلة غير متوقعة يرجى تحديث الصفحة', 's'=>'error','b' => 'موافق'));	

			}
			
			
			
			
		}else{}
		
		
	} else if(isset($_POST['update'])){
		$conn=$database->openConnection();
		$stmt=$conn->query("SELECT id FROM mediations WHERE status='1' AND creator={$_SESSION['memberId:wse6']}");
		
		if($stmt->rowCount() > 0){
				
			foreach($stmt as $row){
				$id=$row["id"];
			}
			

				$stmt=$conn->query("SELECT * FROM mediations_reply WHERE reply_id={$id}");
				$arr=array();
				$data='';
				if($stmt->rowCount() > 0){
				
				foreach($stmt as $row){
					$price=$row["mid_price"];
					$wsa=$row["reply_mid"];
					$time=$row["time"];
					$text=htmlspecialchars($row["reply_text"]);
					$name=current($conn->query("SELECT username FROM Customers WHERE id={$wsa}")->fetch());
					array_push($arr,$price);
					$data .= '<div id="'.$wsa.'">
                   <label>'.htmlspecialchars($name).' , '.getRank($wsa).' , <i class="fa fa-clock-o"></i> منذ '.ago($time).'</label><br/>
                    <button class="btn btn-sm btn-alt-success" onClick=wseet("accept",'.$wsa.')>
                        قبول
                    </button>
                    <button class="btn btn-sm btn-alt-warning" onClick=wseet("info",'.$wsa.')>
                       المزيد »
                    </button><hr/></div>
				';
				}
				$database->closeConnection();
				
				}else{
					$data .= "<p style='color:red;'> عذرًا، لأ يوجد وسيط لخدمتك حالياً.</p>";
				}
				
					$cc=count($arr);
					
					if(empty($arr)){
						$max=0;
						$a=0;
					}else if($cc == 1){
						$max=max($arr);
						$a=0;
					}else{
						$max=max($arr);
						$a=min($arr);
						
						if($a == $max){
							$a=0;
						}
						
					}
				returnJSON(array('doneUpdated' => true, 'dataws6a' => $data,'maxPrice' => '$'.$max, 'minPrice' => '$'.$a, 'count' => $cc));
		}else{
			$database->closeConnection();
			
			returnJSON(array('error' => true, 'data' => 'حدث خطاً غير متوقع ،، يرجى تحديث الصفحة وإعادة المحاولة..'));
		}
		
		
		
		
		
	}else{}
	
}


?>