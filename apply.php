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
                        <h1 class="font-w700 text-white mb-10">وسيط &mdash; تقديم على الإدارة</h1>
                        <h2 class="h4 font-w400 text-white-op">الآن نتيح لك الانظمام مع طاقم عمل موقع وسيط!</h2>
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
					
					if($closeapply){
						?>
                            <h3 class="block-title text-danger">عفوا لكن التقديم مغلق حالياً</h3>
						<?php
						
					}else{
					
					?>
                        <div class="block-header bg-gd-dusk">
                            <h3 class="block-title">تقديم على الإدارة</h3>
                        </div>
                        <div class="block-content" id="content" style="height: 300px;">
                        <label>مرحباً ، <?=$clientnickname;?> هل تريد إن تريد تصبح إداري في موقع وسيط ؟ أذن وفرنا لك الحل..</label><hr/>
                        <div class="form-group row">
							<label for="job-select">قم بإختيار الوظيفة »</label>
								<div class="col-lg-8">
                                <select class="js-select2 form-control" id="job-select" name="job-select" style="width: 100%;" data-placeholder="إختر الوظيفة">
									<option value='1'>وسيط</option>
									<option value='3'>الدعم الفني</option>
                                </select>
                            </div>
                        </div>
						<div class="form-group row">
                            <div class="col-12">
                                <textarea class="form-control" id="requesterInfo" placeholder="عرف عن نفسك، واذكر لنا بضع من خبراتك.." maxlength="256"></textarea>
                            </div>
                        </div>
						<button class="btn btn-alt-primary" onClick="_apply()"> إنهاء عملية التقديم <i class="fa fa-arrow-left mr-5"></i></button>
                        </div>
					<?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>

	function _apply() {
		var jobId = document.getElementById('job-select').value;
		var requesterInfo = document.getElementById('requesterInfo');
		if(typeof jobId != 'undefined' && typeof requesterInfo.value != 'undefined' && jobId == 1 || jobId == 3){
			if(jobId == null || jobId == "" || requesterInfo.value == null || requesterInfo.value == ""){
				alertify.logPosition("bottom right");
				alertify.error("تأكد من المدخلات..");
				throw new Error('حدث خطأ!')
			} else if(requesterInfo.length > 256){
				alertify.logPosition("bottom right");
				alertify.error("تأكد ان الوصف لأ يتعدى 256 حرف..");
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