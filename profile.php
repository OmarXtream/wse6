<?php require_once("includes/header.php");

?>
    <main id="main-container"  style="background-color:#f0f2f5;">
<div class="bg-primary-dark">
    <div class="content content-top">

    </div>
</div>

<div>
<div class="bg-primary">
    <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
        <div class="content text-center">
            <div class="pt-50 pb-20">
                <h1 class="font-w700 text-white mb-10">وسيط &mdash; الملف الشخصي</h1>
                <h2 class="h4 font-w400 text-white-op">تغيير الإعدادات</h2>
            </div>
        </div>
    </div>
</div>
    <div class="content">
        <div class="row">
            <div class="col-xl-4">
                <div class="block block-themed text-center">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">تغيير إسم المستخدم</h3>
                    </div>
                    <div class="block-content" id="content" style="height: 350px;">
                        <form method="post" onsubmit="return false;" autocomplete="off">
                            <div class="form-group row">
                                <div class="col-12">
									<p id="name3">إلاسم الحالي &mdash; <?=$clientnickname;?></p>
                                    <div class="form-material floating text-center">
                                        <input type="text" class="form-control text-right" id="newNameV">
                                        <label for="newNameV">إلاسم الجديد</label>
                                    </div>
                                </div>
								<div class="col-12 pt-3">
									<button class="btn btn-alt-primary" onClick="profile('name')"><i class="fa fa-arrow-right mr-5"></i> تغيير الإسم</button>
								</div>
                                <div class="col-12 pt-3">
									<p id="phoneNumber">الرقم الحالي &mdash; <?=$clientPhoneNumber;?></p>
                                    <div class="form-material floating text-center">
                                        <input type="text" class="form-control text-right" id="newPhoneNumber">
                                        <label for="newPhoneNumber">الرقم الجديد</label>
                                    </div>
                                </div>
								<div class="col-12 pt-3">
									<button class="btn btn-alt-primary" onClick="profile('newPhone')"><i class="fa fa-arrow-right mr-5"></i> تغيير رقم الهاتف</button>
								</div>
                            </div>
                        </form>
						<br/>
                    </div>

                </div>
                </div>
				<div class="col-xl-4">
                <div class="block block-themed text-center">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">تغيير صورة بروفايلك</h3>
                    </div>
                    <div class="block-content" id="content" style="height: 350px;">
                                    <form class="dropzone" id="myDrop" >
                                        <div class="fallback">
                                            <input name="file" type="file" accept="image/*"/>
                                        </div>
                                    </form>
						<br/>
                    </div>

                </div>
                </div>
				<div class="col-xl-4">
                <div class="block block-themed text-center">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">تغيير كلمة المرور</h3>
                    </div>
                    <div class="block-content" id="content" style="height: 350px;">
                        <form method="post" onsubmit="return false;" autocomplete="off">
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material floating">
                                        <input type="password" class="form-control" id="oldpassword">
                                        <label for="oldpassword">كلمة المرور الحالية</label>
                                    </div>     
									<div class="form-material floating">
                                        <input type="password" class="form-control" id="newpassword">
                                        <label for="newpassword">كلمة المرور الجديدة</label>
                                    </div>
                                </div>
                            </div>
                        </form>
						<div class="col-12">
							<button class="btn btn-alt-primary" onClick="profile('newpwd')"><i class="fa fa-arrow-right mr-5"></i>تغيير كلمة المرور </button>
						</div>
						<br/>
                    </div>
                </div>
                </div>
                </div>
        </div>
        </div>
    </main>
	<script src="https://unpkg.com/sweetalert2@7.21.1/dist/sweetalert2.all.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
	new Dropzone("form#myDrop", { 
		maxFiles: 1, 
		uploadMultiple :false,
		maxFilesize: 10,
		url: "ajax/avatar.php",
		acceptedFiles: 'image/png,image/jpeg',
		success: function(file, response){
			swal({
				title: response.t,
				text: response.m,
				type: response.tp,
				confirmButtonText: 'موافق'
			});
		}
	});

	function profile(type) {
		var name=document.getElementById("newNameV").value;
		var phone=document.getElementById("newPhoneNumber").value;
		var oldpwd=document.getElementById("oldpassword").value;
		var nnewpwd=document.getElementById("newpassword").value;
		if(type == "name"){
			var data = "newName="+name;
			if(name.length < 3 ||name.length > 16) {
				swal({
					title: "خطأ",
					text: "يحب أن يكون الإسم أكثر من حرفين وأقل من 16 حرف",
					type: "error",
					confirmButtonText: "موافق"
				});
				throw new Error("wrong value");
			}		
		}else if(type == "newpwd"){
			var data = "oldPwd="+oldpwd+"&newPwd="+nnewpwd;
			if(oldpwd.length > 36 || oldpwd.length < 8 || nnewpwd.length > 36 || nnewpwd.length < 8) {
				swal({
					title: "خطأ",
					text: "يجب أن تكون كلمة المرور أكثر من 8 حروف وأقل من 36 حرف",
					type: "error",
					confirmButtonText: "موافق"
				});
				throw new Error("wrong value");
			}
		}else if(type == "newPhone"){
			var data = "nwePhone="+phone;
			if(phone.length > 16 || phone.length < 7) {
				swal({
					title: "خطأ",
					text: "من فضلك تأكد من إدخال رقم هاتف صحيح",
					type: "error",
					confirmButtonText: "موافق"
				});
				throw new Error("wrong value");
			}
		}
		sendData("editprofile.php", data)
		.then(function(response){
			swal({
				title: response.t, 
				text: response.m,
				type: response.tp,
				showConfirmButton: response.b,
				confirmButtonText: 'موافق'
			});
			if(response.tp == 'success'){
				if(type == "name"){
					document.getElementById("name").innerText=name;
					document.getElementById("name2").innerText=name;
					document.getElementById("name3").innerHTML="إلاسم الحالي &mdash; "+name;
				}else if(type == "newpwd"){
					document.getElementById("oldpassword").value="";
					document.getElementById("newpassword").value="";
				}else if(type == "newPhone"){
					document.getElementById("phoneNumber").innerHTML="الرقم الحالي &mdash; "+phone;
					document.getElementById("newPhoneNumber").value="";
				}
			}
		});
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