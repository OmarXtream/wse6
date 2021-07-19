<?php
ob_start();
$pageName = "mediationsacc";
require_once("inc/header.php");
if(rankPermission($_SESSION['staffId:wse6'],3,true)){
	exit(header('Location: ./home'));
}
?>
            <main id="main-container">
				<div class="content">
					<div class="row text-center">
					<div class="col-lg-12">
<div class="block text-right">
<div class="block-header block-header-default">
<h3 class="block-title">سجل قبول الوساطات</h3>
</div>
<div class="block-content block-content-full">
<table class="table table-bordered table-striped table-vcenter js-dataTable-simple text-center" id="tblacc">
<thead>
<tr>
<th class="">رقم الطلب</th>
<th class="d-none d-sm-table-cell">الشخص</th>
<th class="d-none d-sm-table-cell">قسم الطلب</th>
<th class="d-none d-sm-table-cell">عمولتك</th>
<th class="d-none d-sm-table-cell">الإعدادات</th>
</tr>
</thead>
<tbody>

<?php
	$conn=$database->openConnection();
	
	$stmt=$conn->query('SELECT id,creator,type,status FROM mediations WHERE mid_accepted='.$_SESSION['staffId:wse6'].'');
	
	foreach($stmt as $st){
		$name=current($conn->query("SELECT username FROM Customers WHERE id={$st["creator"]}")->fetch());
		$type=current($conn->query("SELECT title FROM sections WHERE id={$st["type"]}")->fetch());
		$mid_price=current($conn->query("SELECT mid_price FROM mediations_reply WHERE reply_id={$st["id"]}")->fetch());
		
		if($st["status"] == 3){
			$finishButton="<button class='btn btn-circle btn-alt-danger mr-5 mb-5' onclick='goToSure(".$st["id"].")' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='إنهاء الوساطة'><i class='fa fa-close'></i></button>";
			$verifyButton='';
		} else {
			$finishButton='';
			$verifyButton='<v id="verifyButton"><button class="btn btn-circle btn-alt-primary mr-5 mb-5" onclick="addCode('.$st["id"].')" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="وضع الكود المرسل اليك من قبل العميل"><i class="fa fa-plus"></i></button></v>';
		}
		
		echo '
		<tr>
		<td id="data'.$st["id"].'">'.$st["id"].'#</td>
		<td>'.htmlspecialchars($name).'</td>
		<td>'.$type.'</td>
		<td><i class="fa fa-money"></i> '.$mid_price.' </td>
		<td>'.$finishButton.' '.$verifyButton.'</td></tr>';
	}
	
?>

</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</main>
	

	<script>
		
		function goToSure(id){
			_sure('هل انت متاكد من انك تريد إنهاء الوساطة ؟','info',finishMid,id,'');
		}
		
		function _sure(question,qicon,runthis,thisarg,twoarg){
			
		swal({
			title: "هل انت متاكد؟",
			text: question,
			type: qicon,
			showCancelButton: true,
			cancelButtonColor: "#ef5350",
			confirmButtonText: "نعم",
			cancelButtonText: "لأ"
			})
			.then((rep) => {
				if (rep) {
					if(rep.dismiss !== 'overlay' && rep.dismiss !== 'esc'){
						if(rep.value == true){
							if(typeof thisarg != 'undefined' && typeof twoarg == 'undefined'){
							runthis(thisarg); // _sure("ثفثقف","info",wseet,"info",75);
							}else{
							runthis(thisarg,twoarg);
							}	
						}else{
							
						}
				}
				}
				
			});
			
			
		}
		
		
		function addCode(id){
			if(id != undefined){
				
				swal({
				  title: 'لتوثيق وساطتك مع العميل، قم بكتابة الكود المرسل اليك..',
				  type: 'info',
				  html:'<input id="verifycode" class="swal2-input" placeholder="b70dc1">',
				  showCancelButton: true,
				  cancelButtonText: 'إلغاء',
				  confirmButtonText: 'توثيق',
				  showLoaderOnConfirm: true,
				  preConfirm: (text) => {
					let code=document.getElementById("verifycode").value;
					return fetch("ajax/midacc.php?token="+document.getElementsByTagName('meta')["token"].content+"&id="+id+"&code="+code)
					  .then(response => {
						 if(response.status == 520){
							throw new Error("تاكد من المدخلات.")
						 } else	if(response.status == 519){
							throw new Error("حدثت مشكلة غير متوقعة، إعد المحاولة..")
						 } else	if(response.status == 518){
							throw new Error("يجب إن لا تتعدى المدخلات 32 حرف.")
						 } else	if(response.status == 517){
							throw new Error("رمز التحقق خاطئ يرجى إعادة المحاولة.")
						 } else	if(response.status == 516){
							throw new Error("حدثت مشكلة غير متوقعة، يرجى تحديث الصفحة..")
						 }
						return response.json()
					  })
					  .catch(error => {
						swal.showValidationError(
						  `${error}`
						)
					  })
				  },
				  allowOutsideClick: () => !swal.isLoading()
				}).then((result) => {
										
					if(typeof result.value.updatetoken != 'undefined'){
						document.getElementsByTagName('meta')["token"].content = result.value.updatetoken;
					}
					
				   if(result.value.isSuccess == true){
						swal({
								  title: "حسناً",
								  text: "تم التأكد من رمز التحقق، شكرًا لك.",
								  type: "success",
								  confirmButtonText: 'تهانينا!'
						});
						document.getElementById("verifyButton").innerHTML=result.value.verifyToFinish;
				   }
				});
				
			}
		}
		
		function finishMid(id){
			if(id != undefined){
				sendData("midacc", "id="+id+"&finish=1",'GET')
					.then(function(response){
							if(response.isSuccess == true){
									$('#data'+id).closest('tr').remove();
								}
								
								swal({
								  title: response.t,
								  text: response.m,
								  type: response.tp,
								  confirmButtonText: 'موافق'
								});
				});
			}
		}


	</script>

<?php require_once("inc/footer.php"); ?>