<?php 
require_once('includes/req.php');
$req = true;
require_once('includes/class/paypal.php');
require_once('includes/class/httprequest.php');
if(isset($_POST['checkout'],$_POST['price'])){
		$prices = explode(',',$Config['prices']);
	if(in_array($_POST['price'],$prices)){
		$price = $_POST['price'];
		$r = new PayPal(true);
		$ret = ($r->doExpressCheckout($price, ' لقد قمت بشراء '.$price.' نقطة '));
	}else{
		$error[3] == true;
	}
}
if(isset($_GET['token'],$_GET['PayerID'])){
$r = new PayPal(true);


$final = $r->doPayment();

if ($final['ACK'] == 'Success') {
	$response = $r->getCheckoutDetails($final['TOKEN']);
$db = $database->openConnection();
$price = str_replace("|USD|", "", $response['CUSTOM']);
$money = taxCalc($price,0.15,2);
$time = time();
print_r($final);
print_r($response);
$db->query("INSERT INTO payments (id,cid,price,method,email,status,token,payerid,country,time) VALUES ('',{$_SESSION['memberId:wse6']},'{$price}',1,'{$response['EMAIL']}',1,'{$response['TOKEN']}','{$response['PAYERID']}','{$response['COUNTRYCODE']}',{$time})");
$db->query("UPDATE Customers SET Credits=Credits + {$money} WHERE id={$_SESSION['memberId:wse6']}");
$_SESSION['buystatus'] = 'success';
$database->closeConnection();
} else {
$_SESSION['buystatus'] = 'error';
}
}elseif(isset($_GET['token'])){
}

require_once("includes/header.php");
if(isset($error[3]) && $error[3]){
	alertprinter(3);
}

?>
<main id="main-container" style="background-color:#f0f2f5;">
   <div class="bg-primary-dark">
      <div class="content content-top">
      </div>
   </div>
   <div>
      <div class="bg-primary">
         <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
            <div class="content text-center">
               <div class="pt-50 pb-20">
                  <h1 class="font-w700 text-white mb-10">وسيط &mdash; شحن رصيد</h1>
                  <h2 class="h4 font-w400 text-white-op">شحن رصيدك</h2>
               </div>
            </div>
         </div>
      </div>
      <div class="content ">
         <div class="row">
		 		 <?php
		 
		 if(isset($_GET['price'],$_GET['type']) and in_array($_GET['price'],explode(',', $Config['prices'])) and ($_GET['type'] == 'stc' or $_GET['type'] == 'mobily')){
			 if($_GET['type'] == 'stc' and $closestc){
				 ?><h4 class="font-w400">الدفع عن طريق بطائق شحن شركة الإتصالات مغلق في الوقت الحالي</h4><?php
			 }elseif($_GET['type'] == 'mobily' and $closemobily){
				 ?><h4 class="font-w400">الدفع عن طريق بطائق شحن شركة موبايلي مغلق في الوقت الحالي</h4><?php
			 }else{
			 ?>
			 <div class="col-lg-2"></div>
			<div class="col-md-8" dir="rtl" align="right">
				<div class="block" id="blocksarea">
					<div class="block-header block-header-default">
					<h3 class="block-title">إدخال البطائق</h3>
					<span class="muted text-left" id="resualt">0 / <?=$_GET['price'] * 8?></span>
					</div>
					<div class="block-content" id="cardsarea">
						<div class="form-group row">
                            <div class="col-2">
								<div class="form-material">
                                	البطاقة رقم 1
                                </div>
                            </div>
                            <div class="col-md-8 floating">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="cardNumber1" name="cardNumber1" type="number" onChange="insertCardNumber(this)" number="0" maxlength="16" placeholder="من فضلك ادخل رقم البطاقة هنا">
                                    <label for="material-text">رقم البطاقة</label>
                                </div>
                            </div>
							<div class="col-2 floating">
								<div class="form-material">
										<select class="form-control" id="cardtype0" onchange="calculate(0)">
											<option value="none">اختر</option>
											<?php 
											if($_GET['type'] == 'mobily'){
												echo'<option value="10">10</option>';
											}
											?>
											<option value="15">15</option>
											<option value="20">20</option>
											<?php 
											if($_GET['type'] == 'stc'){
												echo'<option value="25">25</option>';
											}
											?>
											<option value="30">30</option>
											<option value="50">50</option>
											<option value="100">100</option>
										</select>
										<label for="cardtype">نوع البطاقه</label>
								</div>
                            </div>
                        </div>
					</div>
					<div class="block-content block-content-full bg-body-light text-center">
						<button type="button" class="btn btn-circle btn-alt-primary mr-5 mb-5" id="addCardButton" onclick="addCard()" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="إضافة بطاقة">
							<i class="fa fa-plus"></i>
						</button>
						<button type="button" class="btn btn-circle btn-alt-success mr-5 mb-5" id="sendorder" onclick="sendCard()" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="إرسال الطلب" disabled>
							<i class="fa fa-check"></i>
						</button>
					</div>
				</div>
			</div>
		<?php
			 }
		 }elseif(isset($_GET['pid']) and ctype_digit($_GET['pid']) and strlen($_GET['pid']) < 30 and !empty($_GET['pid']) and $_GET['pid'] > 0){
			$pid = $_GET['pid'];
			$conn = $database->openConnection();
			$sql = $conn->prepare('SELECT b.id,b.cid,b.price,b.method,b.status,b.time,sa.username FROM payments b INNER JOIN Customers sa on sa.id = b.cid AND b.id = :pid AND b.method <> 1 AND b.status <> 1 AND b.status <> 5');
			$sql->bindValue(':pid',$pid);
			$sql->execute();
			if($sql->rowCount() != 1){
				echo 'error';
			}else{
				$row = $sql->fetch();
				$statement = $conn->query('SELECT card,type,status,id FROM cardsPayments WHERE pid='.$row['id']);
				if($statement->rowCount() == 0){
					echo'error';
				}else{
					$method = $row['method'] == 2 ? 'stc' : 'mobily';
					switch($row['status']){
						case 1:
							$status = "مكتمل";
						break;
						case 2:
							$status = "بطاقة خاطئة";
						break;
						case 3:
							$status = "جاري التنفيذ";
						break;
						case 4:
							$status = "في الإنتظار";
						break;
						case 5:
							$status = "ملغي‬‎";
						break;
					}
	?>
				<br><br>
			<div class="col-md-6"><center><br>
				<div class="col-md-6">الشركة : <?=$method?></div><br>
				<div class="col-md-6">حالة الطلب : <span id="orderStatus"><?=$status?></span></div><br>
				<div class="col-md-6">المال المطلوب : <?=$row['price']?>$</div></center><br><br>
			</div>
			<div class="col-md-6"><center><br>
				<div class="col-md-6">المدفوع : <?=$row['price']?></div><br>
				<div class="col-md-6">عدد البطائق : <?=$statement->rowCount();?></div><br>
				<div class="col-md-6">منذ : <?=ago($row['time']);?></div></center><br><br>
			</div>
			<div class="col-md-12"  dir="rtl" align="middle">
				<div class="block">
					<div class="block-header block-header-default">
						<h3 class="block-title">معلومات البطائق</h3>
					</div>
					<div class="block-content">
						<div class="table-responsive">
							<table class="table table-striped table-vcenter text-center">
								<thead>
									<tr>
										<th>#</th>
										<th style="width: 30%;">النوع</th>
										<th style="width: 15%;">الرقم</th>
										<th class="text-center">الحالة</th>
										<th class="text-center">الإجراء</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$i = 1;
								foreach($statement as $stmt){
											$disabled = '';
									switch($stmt['status']){
										case 1:
											$status = "بطاقة صحيحة";
											$bdgcolor = "success";
											$disabled = 'disabled';
										break;
										case 2:
											$status = "بطاقة خاظئة";
											$bdgcolor = "warning";
										break;
										case 3:
											$status = "جاري التنفيذ";
											$bdgcolor = "primary";
											$disabled = 'disabled';
										break;
										case 4:
											$status = "في الإنتظار";
											$bdgcolor = "info";
										break;
										case 5:
											$status = "ملغي‬‎";
											$bdgcolor = "danger";
										break;
									}
									echo'
									<tr>
										<td class="font-w600">'.$i++.'</td>
										<td class="font-w600">'.$stmt['type'].'</td>
										<td id="cardv'.$stmt['id'].'">'.$stmt['card'].'</td>
										<td id="card'.$stmt['id'].'st">
											<span class="badge bg-'.$bdgcolor.' text-white">'.$status.'</span>
										</td>
										<td class="text-center" dir="ltr">
											<div class="btn-group">
												<button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="" data-original-title="تعديل البطاقة" '.$disabled.' onclick="editCard('.$stmt['id'].')">
													<i class="fa fa-pencil-square-o"></i>
												</button>
											</div>
										</td>
									</tr> 
									';
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php
			 
		 }}}else{
		 ?>
			<div class="col-lg-4">
				<div class="block" dir="ltr">
					<ul class="nav nav-tabs nav-tabs-block nav-fill" data-toggle="tabs" role="tablist">
					<?php
					$paidWay = 0;
					if(!$closepaypal){
					?>
						<li class="nav-item">
							<a class="nav-link <?= $paidWay == 0 ? 'active' : '';?>" href="#btabs-static-home"><img src="assets/img/photos/paypal.png"style="height:32px;width:32px:"/></a>
						</li>
						<?php
					}else{
						$paidWay++;
					}
					if(!$closestc){
						?>
						<li class="nav-item">
							<a class="nav-link <?= $paidWay == 1 ? 'active' : '';?>" href="#btabs-static-profile"><img src="assets/img/photos/stc.png"style="height:32px;width:32px:"/></a>
						</li>
						<?php
					}else{
						$paidWay++;
					}
					if(!$closemobily){
						?>
						<li class="nav-item ml-auto">
							<a class="nav-link <?= $paidWay == 2 ? 'active' : '';?>" href="#btabs-static-settings"><img src="assets/img/photos/rajhi.png"style="height:32px;width:32px:"/></a>
						</li>
						<?php
					}else{
						$paidWay++;
					}
						?>
					</ul>
					<div class="block-content tab-content" dir="rtl" align="center">
					<?php
					$paidWayBox = 0;
					if(!$closepaypal){
					?>
						<div class="tab-pane <?= $paidWayBox == 0 ? 'active' : '';?>" id="btabs-static-home" role="tabpanel">
							<h4 class="font-w400">الدفع الإلكتروني عن طريق البايبال</h4>
							<p>يمكنك الدفع الإلكتروني من الحصول على الرصيد مباشره بعد الدفع</p>
							<form method="post">
								<div class="col-lg-12">
									<input type="text" class="js-rangeslider" name="price" data-grid="true" data-from="2" data-values="<?=$Config['prices']?>" data-prefix="$">
								</div>
								<br>
								<center>
									<button  name="checkout" type="submit" onclick="wait()" class="btn btn-warning waves-effect waves-light">
										<img src="assets/img/photos/paypal-btn.png" width="20px"></img>
										 الدفع الآن
									</button>
								</center>
								<br>
							</form>
						</div>
						<?php
					}else{
						$paidWayBox++;
					}
					if(!$closestc){
						?>
						<div class="tab-pane <?= $paidWayBox == 1 ? 'active' : '';?>" id="btabs-static-profile" role="tabpanel">
							<h4 class="font-w400">الدفع عن طريق بطائق الشحن لشركة الإتصالات السعودية</h4>
							<p>يسنغرق الدفع عن طريق بطائق الشحن مسبقة الدفع الخاصه بشركة الإتصالات السعودية من يوم إلى 3 ايام</p>
							<form method="GET" action="payment.php">
								<input name="type" value="stc" hidden>
								<div class="col-lg-12">
									<input type="text" class="js-rangeslider" name="price" data-grid="true" data-from="2" data-values="<?=$Config['prices']?>" data-prefix="$">
								</div>
								<br>
								<center>
									<button  type="submit" class="btn btn-secondary waves-effect waves-light">
										<img src="assets/img/photos/stc-btn.png" width="20px"></img>
										 الدفع الآن
									</button>
								</center>
								<br> 
							</form>
						</div>
						<?php
					}else{
						$paidWayBox++;
					}
					if(!$closemobily){
						?>
						<div class="tab-pane <?= $paidWayBox == 2 ? 'active' : '';?>" id="btabs-static-settings" role="tabpanel">
							<h4 class="font-w400">الدفع عن طريق تحويل بنك الراجحي</h4>
							<p>يسنغرق الدفع عن طريق التحويل مسبقة الدفع الخاصه ببنك الراجحي من يوم إلى 3 ايام</p>
							<form method="GET" action="payment.php">
								<input name="type" value="mobily" hidden>
								<div class="col-lg-12">
									<input type="text" class="js-rangeslider" name="price" data-grid="true" data-from="2" data-values="<?=$Config['prices']?>" data-prefix="$">
								</div>
								<br>
								<center>
									<button type="submit" class="btn btn-primary mr-5 mb-5">
										<img src="assets/img/photos/rajhi-bttn.png" width="20px"></img>
										 الدفع الآن
									</button>
								</center>
								<br>
							</form>
						</div>
						<?php
					}else{
						$paidWayBox++;
					}
						?>
					</div>
				</div>
			</div>
			<div class="col-lg-8"> 
			<div class="block text-right">
				<div class="block-header block-header-default">
					<h3 class="block-title">سجل المدفوعات</h3>
				</div>
				<div class="block-content">
					<div class="table-responsive">
					<table class="table table-bordered table-striped table-vcenter js-dataTable-simple text-center" id="tablePayments">
						<thead>
							<tr>
								<th class="" aria-sort="descending" aria-controls="tablePayments">الفاتورة</th>
								<th>الرصيد</th>
								<th>الشركة</th>
								<th>الحاله</th>
								<th class="">التاريخ</th>
								<th class="">الإعدادات</th>
							</tr>
						</thead>
						<tbody>
<?php
$db = $database->openConnection();
$sql = $db->query("SELECT * FROM payments WHERE cid={$_SESSION['memberId:wse6']} ORDER BY id DESC");
foreach($sql as $row){
	$date = date('m/d/Y', $row['time']);
	$disabled = '';
	$href = '?pid='.$row['id'];
	switch($row['method']){
		case 1:
			$method = "paypal";
		break;
		case 2:
			$method = "stc";
		break;
		case 3:
			$method = "mobily";
		break;
	}
	switch($row['status']){
		case 1:
			$status = "مكتمل";
			$bdgcolor = "success";
			$disabled='disabled';
			$href='';
		break;
		case 2:
			$status = "بطاقة خاطئة";
			$bdgcolor = "warning";
		break;
		case 3:
			$status = "جاري التنفيذ";
			$bdgcolor = "primary";
		break;
		case 4:
			$status = "في الإنتظار";
			$bdgcolor = "info";
		break;
		case 5:
			$status = "ملغي‬‎";
			$bdgcolor = "danger";
			$disabled='disabled';
		break;
	}
	echo"
                                    <tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['price']}$</td>
                                        <td>{$method}</td>
                                        <td><span class='badge badge-{$bdgcolor}'>{$status}</span></td>
										<td>{$date}</td>
										<td class='text-center'>
											<a href='{$href}' class='btn btn-sm btn-secondary {$disabled}' data-toggle='tooltip' title='' data-original-title='حالة الطلب' {$disabled}>
												<i class='fa fa-info'></i>
											</a>
										</td>
                                   </tr>
	";
}
$database->closeConnection();

?>
						</tbody>
					</table>
				</div>
				</div>
			</div>
         </div>
<?php }?>
      </div>
   </div>
   </div>
</main> 
<?php
if(isset($_GET['type'],$_SESSION['buystatus'])){
	if($_GET['type'] == 'success' and $_SESSION['buystatus'] == 'success'){
	unset($_SESSION['buystatus']);
	alertprinter(2);
	}elseif($_GET['type'] == 'error' and $_SESSION['buystatus'] == 'error'){
	unset($_SESSION['buystatus']);
	alertprinter(1);
	}
}
?>

<script>
   var cid = 0;
   var cards = [];
   var cardNumbers = [];
function wait(){
swal({
  title: 'إنتظر',
  imageUrl: '../img/time2devlogo.png',
  imageHeight: 200,
  allowOutsideClick: false,
  allowEscapeKey: false,
  text: 'إنتظر قليلا من فضلك جاري تحويلك للموقع المطلوب',
  timer: 9000,
  confirmButtonText: null,
  onOpen: () => {
    swal.showLoading()
  }
});
}
function getUrlData(){
	var data = [];
	var url_string = window.location.href; 
	var url = new URL(url_string);
	var price = url.searchParams.get("price");
	var companytype = url.searchParams.get("type");
	data['price'] = price * 8;
	data['dollarPrice'] = price;
	data['companytype'] = companytype;
	return data;
}
 function calculate(id){
	var resualt = 0;
	price = getUrlData()['price'];
	if(document.getElementById('cardtype'+id).value == 'none'){
		cards.splice(id, 1)
		console.log(cards[id]);
	}else{
		cards[id] = document.getElementById('cardtype'+id).value;
	}
	cards.forEach(function(crd){
		console.log(parseInt(crd));
		resualt += parseInt(crd);
	});
	document.getElementById('resualt').innerHTML = resualt+' / '+price;
	if(resualt >= price){
		document.getElementById('sendorder').disabled = false;
		document.getElementById('addCardButton').disabled = false;
	}
 }
 function insertCardNumber(e){
	 var numberInArray = e.getAttribute("number");
	 cardNumbers[numberInArray] = e.value;
 }
 
 function addCard(){
	var resualt = 0;
	var i = 0;
	var card10 = '';
	var card25 = '';
	var urlData = getUrlData()
	price = urlData['price'];
	maxcard = urlData['dollarPrice'];
 	companytype = urlData['companytype'];
	cards.forEach(function(crd){
		resualt += parseInt(crd);
	});
	var cardnum = cid + 2;
	if(resualt < price && cardnum <= maxcard){
		cid++;
		 var vid = cid + 1;
		 if(companytype == 'mobily'){
			card10 = '<option value="10">10</option>';
		}else if (companytype == 'stc'){
			card25 = '<option value="25">25</option>';
		}
		document.getElementById('cardsarea').innerHTML += '<div class="form-group row"> <div class="col-2"><div class="form-material"> البطاقة رقم '+vid+' </div></div><div class="col-md-8 floating"> <div class="form-material"> <input type="text" class="form-control" id="cardNumber'+vid+'" type="number" onChange="insertCardNumber(this)" number="'+cid+'" name="material-text" maxlength="16" placeholder="من فضلك ادخل رقم البطاقة هنا"> <label for="material-text">رقم البطاقة</label> </div></div><div class="col-2 floating"><div class="form-material"><select class="form-control" id="cardtype'+cid+'" onchange="calculate('+cid+')"><option value="none">اختر</option>'+card10+'<option value="15">15</option><option value="20">20</option>'+card25+'<option value="30">30</option><option value="50">50</option><option value="100">100</option></select><label for="cardtype">نوع البطاقه</label></div></div></div>';
		cards.forEach(function(crd){
			console.log(cards[i]);
				document.getElementById('cardtype'+i).value = cards[i];
				loll = i+1;
				typeof cardNumbers[i] != 'undefined' ? document.getElementById('cardNumber'+loll).value = cardNumbers[i] : '';
				i++;
		});
	}
 }
 function sendCard(){
	 var resualt = 0;
	 var cardsData = [];
	 var typeData = [];
	 var cardType,lol,card;
	 var urlData = getUrlData();
	 var price = urlData['price'];
	 var dollarPrice = urlData['dollarPrice'];
	 var company = urlData['companytype'];
	 cards.forEach(function(crd){
		resualt += parseInt(crd);
	 });
	 if(resualt < price){
		swal({
			title: 'خطأ',
			text: 'عذرا ولكن المبلغ المرسل أقل من المبلغ المطلوب',
			type: 'error',
			confirmButtonText: 'حسناً'
		});
	 }else{
		 for(let i = 0; i <= cid; i++){
			cardType = document.getElementById('cardtype'+i).value;
			lol = i+1;
			card = document.getElementById('cardNumber'+lol).value;
			cardsData[i] = card;
			typeData[i] = cardType;
		 }
				sendData("payment.php", 'cardsData='+cardsData+'&typeData='+typeData+'&price='+dollarPrice+'&company='+company)
				.then(function(response){
					if(response.tp == 'success'){
						swal({
							title: response.t, 
							text: response.m,
							type: response.tp,
							showConfirmButton: response.b,
							allowOutsideClick: false,
							allowEnterKey: false,
							allowEscapeKey: false
						});
						window.setTimeout(function () {
							location.href = window.location.href.split('?')[0];
						}, 3000);
					}else{
						swal({
							title: response.t, 
							text: response.m,
							type: response.tp,
							showConfirmButton: response.b,
							confirmButtonText: 'موافق'
						});
					}
					if(response.tp == 'success'){
						document.getElementById('card'+id+'st').innerHTML = '<span class="badge bg-info text-white">في الإنتظار</span>';
						document.getElementById('cardv'+id).innerText = gg;
						document.getElementById('orderStatus').innerText = 'في الإنتظار';
					}
				});
	 }
 }

function editCard(id){
	swal({
		title: 'أدخل الرقم',
		inputPlaceholder: "أدخل رقم البطاقة الجديد",
		input: 'number',
		inputAttributes: {
			min: 11111111111111,
			max: 9999999999999999,
			maxlength: 16,
			style:'max-width: 100%;'
		},
		width: '32rem',
		showCancelButton: true,
		type: 'question',
		cancelButtonText: 'إلغاء الأمر',
		inputValidator: (value) => {
			if (parseInt(value).toString().length > 16 || parseInt(value).toString().length < 14) {
				return 'يجب أن تكتب رقم بطاقة صحيح';
			  }
		}
	}).then((result) => {
		if (result.value) {
			var gg = parseInt(result.value);
			if (gg.toString().length > 16 || gg.toString().length < 14) {
				swal({
					title: 'خطأ',
					text: 'من فضلك تأكد ان البطاقة صحيحه',
					type: 'error',
					confirmButtonText: 'حسناً'
				});
			}else{
				sendData("payment.php", "editCard="+id+"&newCard="+gg)
				.then(function(response){
					swal({
						title: response.t, 
						text: response.m,
						type: response.tp,
						showConfirmButton: response.b,
						confirmButtonText: 'موافق'
					});
					if(response.tp == 'success'){
						document.getElementById('card'+id+'st').innerHTML = '<span class="badge bg-info text-white">في الإنتظار</span>';
						document.getElementById('cardv'+id).innerText = gg;
						document.getElementById('orderStatus').innerText = 'في الإنتظار';
					}
				});
			}
		}
	});
}


/*function calculate(id){
	var card10 = '';
	var card25 = '';
	var bool;
	var resualt = 0;
	var url_string = window.location.href; 
	var url = new URL(url_string);
	var price = url.searchParams.get("price");
	var type = url.searchParams.get("type");
	price *= 6; 
	var maxinput = price / 10;
	if(id == cards.length){
		bool = true;
	}else{
		bool = false;
	}
	cards[id] = document.getElementById('cardtype'+id).value;
	cards.forEach(function(crd){
		resualt += parseInt(crd);
	});
	if(type == 'mobily'){
		card10 = '<option value="10">10</option>';
	}else if (type == 'stc'){
		card25 = '<option value="25">25</option>';
	}
	console.log(resualt);
	if(resualt < price && bool){
		var i = 0;
		var aid = id+1;
		var vid = aid+1;
		document.getElementById('cardsarea').innerHTML += '<div class="form-group row"> <div class="col-2"><div class="form-material"> البطاقة رقم '+vid+' </div></div><div class="col-md-8 floating"> <div class="form-material"> <input type="text" class="form-control" id="material-text" name="material-text" maxlength="16" placeholder="من فضلك ادخل رقم البطاقة هنا"> <label for="material-text">رقم البطاقة</label> </div></div><div class="col-2 floating"><div class="form-material"><select class="form-control" id="cardtype'+aid+'" onchange="calculate('+aid+')"><option>اختر</option>'+card10+'<option value="15">15</option><option value="20">20</option>'+card25+'<option value="30">30</option><option value="50">50</option><option value="100">100</option></select><label for="cardtype">نوع البطاقه</label></div></div></div>';
		cards.forEach(function(crd){
			document.getElementById('cardtype'+i).value = cards[i];
			i++;
		});
		document.getElementById('cardtype'+id).value = cards[id];
	}else{
		cards.forEach(function(crd){
			document.getElementById('cardtype'+i).value = cards[i];
			i++;
		});
		document.getElementById('blocksarea').innerHTML += '<div class="block-content block-content-full bg-body-light text-left"><button type="button" class="btn btn-alt-success" data-toggle="tooltip" title="" data-original-title="Edit">إرسال الطلب <i class="fa fa-arrow-circle-left"></i></button></div>';
	}

}*/
</script>
<?php require_once("includes/footer.php");?>
<body>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5c84e443101df77a8be1ce01/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>