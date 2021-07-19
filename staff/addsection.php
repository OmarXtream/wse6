<?php
$pageName = "addsection";
ob_start();
require_once("inc/header.php");
if(!rankPermission($_SESSION['staffId:wse6'],5,true) && !rankPermission($_SESSION['staffId:wse6'],4,true)){
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
									<h3 class="block-title" id="title">الإدارة &mdash; اضافة قسم</h3>
								</div>
								<div class="block-content" id="content" style="height: 350px;">
									<form method="post" onsubmit="return false;" autocomplete="off">
											<div class="form-group">
												<div class="form-material form-material-primary">
												<input class="form-control" id="sectionName" placeholder="العاب الكمبيوتر" type="text"><label for="sectionName">القسم:</label></div>
												
											</div>									
									</form>
									
									<div class="col-12"><br/><br/><br/>
										<button class="btn btn-alt-primary" onClick="addSection()"><i class="fa fa-arrow-right mr-5"></i> اضافة قسم </button>
									</div>
									
									<br/>
									
								</div>
							</div>
						</div>
					</div>
		</div>
	</main>
	

	<script>
		function addSection() {

			var sectionName=document.getElementById("sectionName").value;

			if(typeof sectionName !== 'undefined'){
				sendData("addSection", "name="+sectionName,'GET')
					.then(function(response){
						if(response.error != true){
						
						swal({
							  title: response.t,
							  text: response.m,
							  type: response.tp,
							  confirmButtonText: response.b,
						});
						
						}else{
							location.reload();
						}
				});

			}
		}


	</script>

<?php require_once("inc/footer.php"); ?>