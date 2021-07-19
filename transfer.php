<?php $transfer="active";require_once("includes/header.php");?>
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
                <h1 class="font-w700 text-white mb-10">وسيط &mdash; الحوالات</h1>
                <h2 class="h4 font-w400 text-white-op">بإمكانك من هذه الصفحة تحويل مبالغ إلى الآخرين.</h2>
            </div>
        </div>
    </div>
</div>
    <div class="content">
        <div class="row">
            <div class="col-xl-4"></div>
				<div class="col-xl-4">
                <div class="block block-themed text-center">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">الحوالات</h3>
                    </div>
                    <div class="block-content" id="content" style="height: 300px;">
						<div class="form-group row">
						<label class="text-danger">مرحبًا ، <?=$clientnickname;?> » رصيدك حالياً &mdash; <span id="balance"><?=$clientbalance;?> » ملاحظة يوجد ضريبة %15</span></label>
						</div>
						<div class="form-group row">
						<label for="transfer-select">قم بإختيار الشخص »</label>
						<div class="col-lg-8">
						<input class="form-control" id="transfer-select" name="transfer-select" style="width: 100%;" placeholder="اسم الشخص" />
						</div>
						</div>
						<div class="form-group row">
							<label>الرصيد المراد تحويله »</label>
							<div class="col-lg-8">
								<input type="text" class="js-rangeslider" id="transfer-cost" value="0" data-min="0" data-max="50">
							</div>
						</div>
						<div class="col-md-12"><br/><br/>
							<button class="btn btn-alt-primary" onClick="_transfer()"> تحويل الرصيد <i class="fa fa-arrow-left mr-5"></i></button>
						</div>

                    </div>

                </div>
                </div>
                </div>
        </div>
        </div>
    </main>
<script>
	function _transfer() {
		var balanceToAdd=document.getElementById("transfer-cost").value;
		var selectedUser=document.getElementById("transfer-select").value;
		var transferEl = $("#transfer-cost").data("ionRangeSlider");
		if(typeof balanceToAdd !== 'undefined' && typeof selectedUser !== 'undefined'){
			if(balanceToAdd == 0){
				alertify.logPosition("bottom right");
				alertify.error("يرجى إختيار المبلغ.");
				throw new Error('حدث خطأ!')
			}
			alertify.confirm('هل انت متاكد من انك تريد تحويل المبلغ؟', function(){
				sendData("addbalance.php", "client="+selectedUser+"&balance="+balanceToAdd,'GET')
				.then(function(response){
					swal({
						title: response.t, 
						text: response.m,
						type: response.tp,
						showConfirmButton: response.b,
						confirmButtonText: 'موافق'
					});
					if(response.tp == 'success'){
						transferEl.update({ from: 0});
						document.getElementById("balance").innerText=response.balanceNow;
					}
				});
			}, function(){
				alertify.error("تم إلغاء العملية، بناءً على طلبك");
			});
		}
	}

		
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