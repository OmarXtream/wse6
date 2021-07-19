<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$requestBalance = 'active';
require_once("includes/header.php");

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
      <div class="content">
		<div class="row">
			<div class="col-md-3 "></div>
			<div class="col-md-6 text-center">
				<div class="block">
					<div class="block-header block-header-default">
						<h3 class="block-title">الأرباح</h3>
					</div>
					<div class="block-content">
						<div class="block block-transparent">
							<div class="block-content block-content-full bg-gd-lake text-center">
								<div class="item item-2x item-circle bg-black-op-10 mx-auto mb-20">
									<i class="si si-wallet text-white-op"></i>
								</div>
								<div class="font-size-h3 font-w600 text-white">$<span id="clientBalance"><?=$clientbalance?></span></div>
								<div class="font-size-sm font-w600 text-uppercase text-white-op">الأرباح</div>
							</div>
						</div>
						<button type="button" class="btn btn-alt-success min-width-125" onclick="requestBalance()"> طلب الأرباح <i class="fa fa-money"></i></button>						
<br/><br/>
					</div>
				</div>
			</div>
		</div>
	  </div>
   </div>
</main> 
<script>


function requestBalance(){
	sendData("requestbalance.php", "requestBalance=1")
	.then(function(response){
		swal({
			title: response.t, 
			text: response.m,
			type: response.tp,
			showConfirmButton: response.b,
			confirmButtonText: 'موافق'
		});
		if(response.tp == 'success'){
			
		}
	});
}

</script>
<?php require_once("includes/footer.php");?>