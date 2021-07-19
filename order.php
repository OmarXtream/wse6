<?php $activeOrder="active";
require_once("includes/header.php");
?>
<main id="main-container" style="background-color: rgb(240, 242, 245);">
<div class="bg-primary-dark">
    <div class="content content-top">

    </div>
</div>

<div class="bg-body-light">
<div class="bg-primary">
    <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
        <div class="content text-center">
            <div class="pt-50 pb-20">
                <h1 class="font-w700 text-white mb-10">وسيط &mdash; طلب وساطة </h1>
                <h2 class="h4 font-w400 text-white-op">يمكنك القيام بطلب وسيط من هذه الصفحة</h2>
            </div>
        </div>
    </div>
</div>
  

<div class="content">
   <div class="row">
      <div class="content">
         <div class="row">
			<?php 
			$stmtx=$conn->query("SELECT c.username FROM Customers c, mediations mid WHERE c.id = mid.mid_accepted AND mid.creator = {$_SESSION['memberId:wse6']} AND mid.status = 3 AND mid.accept_code != ''");
			
			if($stmtx->rowCount() > 0){
				$username = $stmtx->fetch()['username'];
			?>
			<div class="col-xl-4"></div>
			<div class="col-xl-4">
				<div class="block block-themed text-center">
                  <div class="block-header indigo">
                     <h3 class="block-title">قام الوسيط بقبولك</h3>
                  </div>
					
				<div class="block-content" style="height: 300px;" id="wsatacontent">
						<p>
						تواصل مع الوسيط الآن <?=htmlspecialchars($username);?><br/>
						
						
						</p><hr/>اذا واجهت أي مشكلة في وقت الوساطة تواصل مع الدعم الفني‬‎
                  </div>
								
								
				</div>
			</div>
						
			<?php
			} else {
			$stmtz=$conn->query("SELECT mid_accepted,accept_code FROM mediations WHERE creator='{$_SESSION['memberId:wse6']}' AND status='0' AND accept_code != '';");
			
			if($stmtz->rowCount() > 0){
					$sz = $stmtz->fetch();
					$midAccepted=$sz["mid_accepted"];
					$acceptCode=$sz["accept_code"];
				
				$getData = $conn->query('SELECT username,phonenumber FROM Customers WHERE id = '.$midAccepted)->fetch();
			?>
			
			<div class="col-xl-4"></div>
			<div class="col-xl-4">
				
				<div class="block block-themed text-center">
                  <div class="block-header indigo">
                     <h3 class="block-title">التحقق من الكود</h3>
                  </div>
					
				<div class="block-content" style="height: 300px;" id="wsatacontent">
						<p>
						تم قبول الوسيط : <?=htmlspecialchars($getData['username']);?><br/>
						يرجى إرسال الكود : <?=$acceptCode;?><br/> إلى هاذا الرقم : <?=$getData['phonenumber'];?></p><hr/>
						<p class="text-danger">إذا كنت تريد تبديل الوسيط قم بالضغط على الزر بالإسفل.</p>
                        <button class="btn btn-alt-danger" onClick="_cancel('tbdeel')"><i class="fa fa-arrow-right mr-5"></i> تبديل الوسيط </button>
                  </div>
								
								
					</div>
				  
					
				
				</div>
			
			<?php } else{
					
			
			
			$count=current($conn->query("SELECT count(*) FROM mediations WHERE creator='{$_SESSION['memberId:wse6']}' AND status=1;")->fetch());
			if($count == 0){
			?>            <div class="col-xl-4"></div>

            <div class="col-xl-4">
               <div class="block block-themed text-center">
                  <div class="block-header bg-gd-dusk">
                     <h3 class="block-title">طلب وساطة</h3>
                  </div>
                  <div class="block-content" id="content" style="height: 300px;">
					<?php if($clientbalance == 0){?>
						<p>يجب توفر على الإقل دولار لطلب وساطة في الموقع</p>
					<?php } else { ?>
                     <form method="post" onsubmit="return false;" autocomplete="off">
                        <div class="form-group row">
                           <div class="col-12">
							
							<div class="form-material">
								<label for="selectQasm" style="right:0 !important;text-align: right !important;">إختيار القسم</label><br/>
								<select class="js-select2 form-control" id="selectQasm"><option value=""> إختر القسم</option><?php
								$conn=$database->openConnection();
								$x=$conn->query("SELECT title,id FROM sections ORDER BY id ASC");
								foreach($x as $row){
									echo "<option style='text-align: right !important;' value='{$row["id"]}'>{$row["title"]}</option>";
								}?></select>
                              </div>
							  <div class="form-material text-right"><br/>
								<label for="describe" style="right:0 !important; text-align: right !important;">الوصف</label>
								
                                <textarea class="form-control" id="describe" rows="3" placeholder="مثأل : إسم البرنامج ،،الخ.." style="resize:none;font-family:nes !important;"></textarea>
							  </div>
							  
							  
                           </div>
                        </div>
                     </form>
                     <div class="col-12">
                        <button class="btn btn-alt-primary" onClick="_orderCreate()"><i class="fa fa-arrow-right mr-5"></i> إنشاء طلب </button>
                     </div>
					<?php } ?>
                  </div>
               </div>
            </div>
			
			<?php } else {
			$inform=$conn->query("SELECT id,type,describes FROM mediations WHERE creator='{$_SESSION['memberId:wse6']}' AND status=1;");
			$im = $inform->fetch();
			$orderNumber=$im["id"];
			$type=$im["type"];
			$desc=htmlspecialchars($im["describes"]);
			$sectionName=current($conn->query("SELECT title FROM sections WHERE id={$type}")->fetch());
			
			?>
				
				<div class="col-xl-4">
				
<div class="block block-themed text-right" id="wsta">
        <div class="block-header bg-danger text-center">
            <h3 class="block-title">عروض الوسطاء</h3>
        </div>
      <div class="block-content" data-toggle="slimscroll" data-height="300px" data-color="#ef5350" data-opacity="1" data-always-visible="true">
				معلومات الوسطاء&nbsp;:<br/><br/><div id="repliesMid">
                <?php

				$stmt=$conn->query("SELECT mid_price,reply_mid,time,reply_text FROM mediations_reply WHERE reply_id={$orderNumber}");
				$arr=array();
				if($stmt->rowCount() > 0){
				
				foreach($stmt as $row){
					$price=$row["mid_price"];
					$wsa=$row["reply_mid"];
					$time=$row["time"];
					$text=htmlspecialchars($row["reply_text"]);
					$name=current($conn->query("SELECT username FROM Customers WHERE id={$wsa}")->fetch());
					array_push($arr,$price);
					echo '<div id="'.$wsa.'">
                   <label>'.htmlspecialchars($name).' , '.getRank($wsa).' , <i class="fa fa-clock-o"></i> منذ '.ago($time).'</label><br/>
                    <button class="btn btn-sm btn-alt-success" onClick=wseet("accept",'.$wsa.')>
                        قبول
                    </button>
                    <button class="btn btn-sm btn-alt-warning" onClick=wseet("info",'.$wsa.')>
                       المزيد »
                    </button><hr/></div>
				';
				}
				
				
				}else{
					echo "<p style='color:red;'> عذرًا، لأ يوجد وسيط لخدمتك حالياً.</p>";
				}
				?>
				</div>
        </div>
    </div>
			</div>
			<div class="col-xl-4">
				
				<div class="block block-themed text-center">
                  <div class="block-header indigo">
                     <h3 class="block-title" id="wsataboxtitle">طلب وساطة &mdash; <?=$orderNumber?>#</h3>
                  </div>
					
<div class="block-content" style="height: 300px;" id="wsatacontent">
                     <form method="post" onsubmit="return false;" autocomplete="off">
                        <div class="form-group row">
                           <div class="col-12">
							
								<p>نوع الوساطة: <?=htmlspecialchars($sectionName);?></p>
								<p style="word-wrap: break-word;">وصف الوساطة: <br/><?=$desc;?></p>
								
							  
							</div>
                     </form>
                     <div class="col-12">
                        <!--<button class="btn btn-alt-primary" onClick="_orderCreate()"><i class="fa fa-arrow-right mr-5"></i> إنشاء طلب </button>-->
                     </div>
                  </div>
								
								
					</div>
				  
					
				
				</div>
			</div>	
			<div class="col-xl-4">
				
				<div class="block block-themed text-center" id="wstacard">
                  <div class="block-header bg-danger">
                     <h3 class="block-title">بطاقة الوساطة</h3>
                  </div>
					<?php
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
					
					
					?>
					<div class="block-content" id="content" style="height: 300px;">
					<div class="row mrg--as" style="padding-left: 45px;">
						<table class="table table-borderless mrg--an text-meta">
							<colgroup>
								<col class="col-xs-2">
								<col class="col-xs-2">
							</colgroup>
							<tbody>
				
							<tr>
								<td>رقم الوساطة »</td>
								<td><span dir="rtl" id="orderNumber"><?=$orderNumber;?></span></td>
							</tr>
							<tr>
								<td>أعلى سعر عرض »</td>
								<td id="maxPrice">$<?=$max;?></td>
							</tr>
							<tr>
								<td>أدنى سعر عرض »</td>
								<td id="minPrice">$<?=$a;?></td>
							</tr>

							<tr>
								<td>عدد العروض »</td>
								<td id="countWas6a"><?=$cc;?></td>
							</tr>
							<tr>
								<td>غلق الوساطة »</td>
								<td><i class="fa fa-times" onClick="_sure('هل أنت متاكد من أنك تريد غلق الوساطة؟','info',_cancel,'wsa6h','')"></i></td>
							</tr>              
							</tbody>
							</table>
							</div>
				
					</div>
										
								
					</div>
				  
					
				
				</div>
			</div>
			<?php } } } ?>
      </div>
   </div>
</div>
</div>
</main>

	
<?php require_once("includes/footer.php");?>