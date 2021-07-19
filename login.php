<?php
ini_set('session.cookie_httponly', true);
session_start();
require_once("includes/db.php");


if(isset($_SESSION['memberId:wse6'])){
	exit(header('Location: home'));
} else if(isset($_GET['status'])) {
	if($_GET['status'] == 1){
		$what = 1;
	} else if($_GET['status'] == 2){
		$what = 2;
	} else if($_GET['status'] == 3){
		$what = 3;
	}
}


$_SESSION['_token']=bin2hex(openssl_random_pseudo_bytes(16));

?>
<!DOCTYPE html>
<html lang="en" class="no-focus">
    <head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Wse6 &bull; Login</title>
        <meta name="description" content="">
        <meta name="author" content="TimeToDev">
        <meta name="token" content="<?=$_SESSION['_token']?>">
        <meta name="robots" content="noindex, nofollow">
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
		<link rel="stylesheet" id="css-main" href="assets/css/codebase.min-2.1.css">
		<noscript><meta HTTP-EQUIV="refresh" content=0;url="javascriptErr.php"></noscript>
		<script src="assets/js/pages/sweetalert.js"></script>
		<script src="assets/js/script.js"></script>
		<script src='https://www.google.com/recaptcha/api.js?hl=ar'></script>
		<link rel="shortcut icon" type="image/x-icon" href="img/logo16.png">

		<style>
		
		html {direction: rtl;}
		
		</style>
    </head>
<body style="overflow-x: hidden;"><div id="page-container" class="main-content-boxed">
                <main id="main-container">
<div class="bg-body-dark bg-pattern" style="background-image: url('assets/media/various/bg-pattern-inverse.png');">
    <div class="row mx-0 justify-content-center">
        <div class="hero-static col-lg-6 col-xl-4">
            <div class="content content-full overflow-hidden">
                <div class="py-30 text-center">
                    <a class="link-effect font-w700" href="#">
                        <span class="font-size-xl text-primary-dark">وسيط</span>&nbsp;&nbsp;<span class="font-size-xl">تسجيل الدخول</span>
                    </a>
                </div>
                <form class="js-validation-signin text-right" autocomplete="off" onSubmit="return false;">
                    <div class="block block-themed block-rounded block-shadow">
                        <div class="block-header bg-gd-emerald">
                            <h3 class="block-title">من فضلك أدخل بياناتك</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="login-username">إسم المستخدم او البريد الإلكتروني</label>
                                    <input type="text" class="form-control" id="login-username" name="login-username">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="login-password">كلمة المرور</label>
                                    <input type="password" class="form-control" id="login-password" name="login-password">
                                </div>
                            </div><hr/>
                            <div class="form-group row">
                                <div class="col-12">
									<center><div class="g-recaptcha" data-sitekey="<?=$Config["reCAPTCHA"];?>"></div></center>
                                </div>
                            </div>
                                <div class="col-sm-6 text-center push" style="margin-left: auto; margin-right: auto;">
                                    <button class="btn btn-alt-success" onClick="login()"><i class="fa fa-plus mr-10"></i> تسجيل الدخول </button>
                                </div>
                            </div>
							<div class="block-content bg-body-light">
								<div class="form-group text-center">
									<a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#" data-toggle="modal" data-target="#modal-terms">
										<i class="fa fa-book text-muted mr-5"></i> قراءة القوانين
									</a>
									<a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="register">
										<i class="fa fa-user text-muted mr-5"></i> إنشاء حساب
									</a>
									<a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="forgetpass">
										<i class="fa fa-key text-muted mr-5"></i> نسيت كلمة المرور
									</a>
								</div>
							</div>
                        </div>
					</form>
                    </div>
            </div>
        </div>
    </div>
</div>
    </main>
    </div>
<div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-labelledby="modal-terms" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slidedown" role="document">
        <div class="modal-content text-center">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">شروط اتفاقية الخدمة</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                 <p>*نحن غير مسؤولين*

- على أي شخص قام بسرقة حسابك عن طريق تسريب الا اذا كانت ثغرة لدى الموقع</p>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">اغلاق</button>
                <button type="button" class="btn btn-alt-success" data-dismiss="modal">
                    <i class="fa fa-check"></i> موافق
                </button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.rawgit.com/alertifyjs/alertify.js/v1.0.10/dist/js/alertify.js"></script>
<script>
		const toast = swal.mixin({
		  toast: true,
		  position: 'top-end',
		  showConfirmButton: false,
		  timer: 3000
		});
		<?php if(isset($_GET['timeout']) && $_GET['timeout'] == 1){ ?>	
		alertify.logPosition("top right");
		alertify.error("تم تسجيل خروجك بنجاح، نظرًأ لعدم تفاعلك سجل مجددا!");
	 <?php } ?>
		<?php if(isset($what) && $what == 1) { ?>
			toast({
				type: 'success',
				title: 'تم إرسال كلمة مرور جديدة إلى البريد الإلكتروني'
			});	
		<?php } else if(isset($what) && $what == 2){ ?>
			toast({
				type: 'error',
				title: 'حدث خطأ إثناء ارسال البريد الإلكتروني، اعد المحاولة.'
			});			
		<?php } else if(isset($what) && $what == 3){?>
			toast({
				type: 'error',
				title: 'انتهت صلاحية رابط التحقق الخاصة بالبريد الإلكتروني'
			});		
		<?php } ?>
	function login(){
		var useroremail=document.getElementById("login-username").value;
		var password=document.getElementById("login-password").value;
		if(useroremail == null || useroremail == "" || password == "" || password == null){
			swal({
				title: "خطأ",
				text: "عذراً ولكن التحقق غير موجود",
				type: "error"
			});
		}else if (grecaptcha === undefined) {
			swal({
			  title: "خطأ",
			  text: "عذراً ولكن التحقق غير موجود",
			  type: "error"
			});
			setTimeout(function () { location.href = "login.php";}, 3000);
			throw new Error("Empty RECAPTCHA");
		}
		var response = grecaptcha.getResponse();
		if (!response) {
			swal({
				title: "خطأ",
				text: "من فضلك تحقق من أنك لست روبوت",
				type: "error"
			});
			throw new Error("Robot Check");
		}
		sendData("login.php", "useroremail="+useroremail+"&password="+password+"&reCAPTCHA="+grecaptcha.getResponse())
		.then(function(response){
			swal({
				title: response.t, 
				text: response.m,
				type: response.tp,
				showConfirmButton: response.b,
				confirmButtonText: 'موافق'
			});
			if(response.tp == 'error'){
				grecaptcha.reset();
			}else if(response.tp == 'success'){
				setTimeout(function () { location.href = "./";}, 3000);
			}
		});
	}
		</script>
		<script src="assets/js/codebase.min-2.1.js"></script><script src="https://unpkg.com/sweetalert2@7.21.1/dist/sweetalert2.all.js"></script><script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
		<script src="assets/js/pages/op_auth_signin.js"></script>
    </body>
</html>