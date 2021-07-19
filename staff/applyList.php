<?php
ob_start();
$pageName = "applyList";
require_once("inc/header.php");

if(rankPermission($_SESSION['staffId:wse6'],3,true) OR rankPermission($_SESSION['staffId:wse6'],1,true)){
	exit(header('Location: ./home'));
}
?>
<main id="main-container">
	<div class="content">
		<div class="row text-center">
			<div class="col-xl-2"></div>
			<div class="col-xl-8">
			<div class="block block-themed">
				<div class="block-header bg-gd-dusk">
					<h3 class="block-title" id="title">الإدارة &mdash; قائمة تقديم على الإدارة</h3>
				</div>
				<div class="block-content" id="content" style="height: 350px;">
					<form method="post" onsubmit="return false;" autocomplete="off">
						<div class="form-group">
							<div class="form-material">
								<select class="js-select2 form-control" id="applySelect" style="width: 100%;" data-placeholder="اختر الشخص" onChange="_getInfoApply()">
									<option></option>
									<?php
									$stmt=$conn->query('SELECT b.requester,b.requestrank,b.request_msg, sb.username reqUsername FROM apply_requests b INNER JOIN Customers sa on sa.id = b.requester INNER JOIN Customers sb on sb.id = b.requester');
									foreach($stmt as $row){
										echo '<option value="'.$row['requester'].'">'.$row['reqUsername'].'</option>';
									}
									?>
									</select><br/><br/>
									<div id="infoHere"></div>
									</div>
									</div>	
									
								</form><br/>
								</div>
							</div>
						</div>
					</div>
		</div>
	</main>
	

	<script>
		 function _getInfoApply() {
				var applySelect=document.getElementById("applySelect").value;
				sendData("applyList", "reqId="+applySelect,'POST')
					.then(function(response){
						if(typeof response.isSuccess !== 'undefined' && response.isSuccess == true){ 
							document.getElementById("infoHere").innerHTML="<p>معلومات الطلب: <br/> الوصف: "+response.desc+" <br/> رقم الجوال: "+response.number+" <br/> الرتبة: "+response.rank+" <br/></p><button class='btn btn-alt-success' onclick='_acceptApply("+response.id+")'> قبول الطلب </button>&nbsp;<button class='btn btn-alt-danger' onclick='_cancelApply("+response.id+")'> رفض الطلب </button>";
						} else {
							swal({
								title: response.t,
								text: response.m,
								type: response.tp,
								confirmButtonText: response.b
							});
						}
				});
			
		 }
		 
		 function _acceptApply(id) {
				sendData("applyList", "accept="+id,'POST')
					.then(function(response){
						swal({
								title: response.t,
								text: response.m,
								type: response.tp,
								confirmButtonText: response.b
							});
						
						if(response.isSuccess != undefined && response.isSuccess == true){
							setTimeout(function(){ location.reload(); }, 3000);
						}
					});
		}
		
		function _cancelApply(id){
				sendData("applyList", "cancel="+id,'POST')
					.then(function(response){
							swal({
								title: response.t,
								text: response.m,
								type: response.tp,
								confirmButtonText: response.b
							});
						
						if(response.isSuccess != undefined && response.isSuccess == true){
							setTimeout(function(){ location.reload(); }, 3000);
						}
					});			
		}
		


	</script>

<?php require_once("inc/footer.php"); ?>