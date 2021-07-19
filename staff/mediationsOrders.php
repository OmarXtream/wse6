<?php
ob_start();
$pageName="mediationsOrders";
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
<h3 class="block-title">سجل طلبات الوساطة &mdash; الغير مكتملة</h3>
</div>
<div class="block-content block-content-full">
<table class="table table-bordered table-striped table-vcenter js-dataTable-simple text-center" data-order='[[ 1, "DESC" ]]'>
<thead>
<tr>
<th class="">رقم الطلب</th>
<th class="d-none d-sm-table-cell">الشخص</th>
<th class="d-none d-sm-table-cell">قسم الطلب</th>
<th class="d-none d-sm-table-cell">العروض</th>
<th class="d-none d-sm-table-cell" >السعر</th>
<th class="d-none d-sm-table-cell">الوقت</th>
<th class="d-none d-sm-table-cell">الإعدادات</th>
</tr>
</thead>
<tbody>

<?php
	$conn=$database->openConnection();
	
	$stmt=$conn->query('SELECT id,creator,type,status,create_time FROM mediations WHERE mid_accepted = 0 ORDER BY create_time DESC');
	
	foreach($stmt as $st){
		$name=current($conn->query("SELECT username FROM Customers WHERE id={$st["creator"]}")->fetch());
		$type=current($conn->query("SELECT title FROM sections WHERE id={$st["type"]}")->fetch());
		$offers=current($conn->query("SELECT count(*) FROM mediations_reply WHERE reply_id={$st["id"]}")->fetch());
		$priceMax=current($conn->query("SELECT max( mid_price ) FROM mediations_reply WHERE reply_id={$st["id"]}")->fetch());
		$priceMin=current($conn->query("SELECT min( mid_price ) FROM mediations_reply WHERE reply_id={$st["id"]}")->fetch());
		if($priceMin == "" && $priceMax == ""){
			$price="لا يوجد عرض..";
		} else if($priceMax == $priceMin){
			$price= "0 - ".$priceMax;
		} else {
			$price= $priceMin." - ".$priceMin;
		}
		echo '
		<tr><td>'.$st["id"].'#</td>
		<td>'.htmlspecialchars($name).'</td>
		<td>'.$type.'</td><td>'.$offers.'</td>
		<td>'.$price.'</td>
		<td><i class="material-icons">access_time</i> '.ago($st["create_time"]).' </td>
		<td>
		<button type="button" class="btn btn-circle btn-alt-primary mr-5 mb-5" onclick="showInfo('.$st["id"].')" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="قراءة المعلومات"><i class="fa fa-info"></i></button><button type="button" class="btn btn-circle btn-alt-primary mr-5 mb-5" onclick="addOffer('.$st["id"].')" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="إضافة عرض لطالب الوساطة"><i class="fa fa-plus"></i></button></td></tr>';
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
		
		function addOffer(id){
			if(id != undefined){
				
				swal({
				  title: 'لإضافة عرض قم بكتابة تفاصيل العرض أدناه.',
				  type: 'info',
				  html:'<input id="offer-msg" class="swal2-input" placeholder="اهلاً، معك فارس يسعدني خدمتك اليوم.">' + '<input id="offer-price" class="swal2-input"  placeholder="المبلغ:">',
				  showCancelButton: true,
				  cancelButtonText: 'إلغاء',
				  confirmButtonText: 'إضافة',
				  showLoaderOnConfirm: true,
				  preConfirm: (text) => {
					let msg=document.getElementById("offer-msg").value;
					let price=document.getElementById("offer-price").value;
					return fetch("ajax/midAction.php?token="+document.getElementsByTagName('meta')["token"].content+"&id="+id+"&eventId=1&msg="+msg+"&price="+price)
					  .then(response => {
						 if(response.status == 520){
							throw new Error("تاكد من المدخلات..") 
						 } else if(response.status == 519){
							throw new Error("يوجد عرض مرسل بالفعل منك..") 
						 } else if(response.status == 518){
							throw new Error("يجب إن لا تتعدى المدخلات 200 حرف.") 
						 } else if(response.status == 506){
							throw new Error("يجب إن يكون المبلغ رقم، ولا يتعدى المبلغ 50$") 
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
					
				   if(result.value.tp == 'success'){
						swal({
								  title: result.value.t,
								  text: result.value.m,
								  type: result.value.tp,
								  confirmButtonText: 'موافق'
						});
				   }
				});
				
			}
		}
		
		function showInfo(id){
			if(id != undefined){
				sendData("midAction", "id="+id+"&eventId=0",'GET')
					.then(function(response){
						swal({
								  title: response.t,
								  text: response.m,
								  type: response.tp,
								  confirmButtonText: 'موافق'
						});
													
						if(response.reload == true){
								setTimeout(function(){
									location.reload();
								}, 3000);
						} else{}
				});
			}
		}


	</script>

<?php require_once("inc/footer.php"); ?>