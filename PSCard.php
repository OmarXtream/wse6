<?php $apply='active';require_once("includes/header.php");?>
<main id="main-container" style="background-color: rgb(240, 242, 245);">
    <div class="bg-primary-dark">
        <div class="content content-top">

        </div>
    </div>
    <div>
        <div class="bg-primary">
            <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                <div class="content text-center">
                    <div class="pt-50 pb-20">
                        <h1 class="font-w700 text-white mb-10">وسيط &mdash; ستور سعودي</h1>
                        <h2 class="h4 font-w400 text-white-op">الآن نتيح لك شراء أكواد الستور السعودي للبلاستيشن!</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-xl-4"></div>
                <div class="col-xl-4">
                    <div class="block block-themed text-center">
					<?php
					
					if($closeps){
						?>
                            <h3 class="block-title text-danger">عفوا لكن شراء الستور مغلق حالياً</h3>

						<?php
						
					}else{
					
					?>
                        <div class="block-header bg-gd-dusk">
                            <h3 class="block-title">ستور سعودي</h3>
                        </div>
                        <div class="block-content" id="content" style="height: 300px;">
                        <label>مرحباً ، <?=$clientnickname;?> هل تريد شراء كود ستور سعودي؟ من هنا..</label><hr/>
                        <div class="form-group row">

							<label for="job-select">قم بإختيار البطاقة »</label>
								<div class="col-lg-8">
                                <select class="js-select2 form-control" id="job-select" name="job-select" style="width: 100%;" data-placeholder="إختر الوظيفة">
									<option value='1'>5 Dollar KSA</option>
									<option value='2'>10 Dollar KSA</option>
									<option value='3'>15 Dollar KSA</option>
									<option value='4'>20 Dollar KSA</option>
									<option value='5'>30 Dollar KSA</option>
									<option value='6'>50 Dollar KSA</option>
									<option value='7'>70 Dollar KSA</option>
									<option value='8'>100 Dollar KSA</option>

                                </select>
                            </div>
                        </div>
						<div class="form-group row">
                        </div>
						<button class="btn btn-alt-primary" onClick="_PSCard()"> شراء <i class="fa fa-arrow-left mr-5"></i></button>
                        </div>
					<?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>

	function _PSCard() {
		var jobId = document.getElementById('job-select').value;
		var requesterInfo = document.getElementById('requesterInfo');
		if(typeof jobId != 'undefined' && typeof requesterInfo.value != 'undefined' && jobId == 1 || jobId == 3){
			if(jobId == null || jobId == "" || requesterInfo.value == null || requesterInfo.value == ""){
				alertify.logPosition("bottom right");
				alertify.error("تأكد من المدخلات..");
				throw new Error('حدث خطأ!')
			} else if(requesterInfo.length > 256){
				alertify.logPosition("bottom right");
				throw new Error('حدث خطأ!')	
			} else{}
			sendData("apply", "job="+jobId+"&msg="+requesterInfo.value)
			.then(function(response){
				swal({
					title: response.t, 
					text: response.m,
					type: response.tp,
					showConfirmButton: response.b,
					confirmButtonText: 'موافق'
				});
			});
		} else { console.log('heehe'); }
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