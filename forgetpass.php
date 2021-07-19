<?php
ini_set('session.cookie_httponly', true);
session_start();
require_once("includes/db.php");


if(isset($_SESSION['memberId:wse6'])){
	exit(header('Location: home'));
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
        <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
		<link rel="stylesheet" id="css-main" href="assets/css/codebase.min-2.1.css">
		<noscript><meta HTTP-EQUIV="refresh" content=0;url="javascriptErr.php"></noscript>
		<script src="assets/js/pages/sweetalert.js"></script>
		<script src="assets/js/script.js"></script>
		<script src='https://www.google.com/recaptcha/api.js?hl=ar'></script>
		
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
                        <span class="font-size-xl text-primary-dark">وسيط</span>&nbsp;&nbsp;<span class="font-size-xl">نسيت كلمة المرور</span>
                    </a>
                </div>
                <form class="js-validation-signin text-right" autocomplete="off" onSubmit="return false;">
                    <div class="block block-themed block-rounded block-shadow">
                        <div class="block-header bg-gd-emerald">
                            <h3 class="block-title">يرجئ كتابة بريد الإلكتروني من فضلك</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="login-username">البريد الإلكتروني</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
									<center><div class="g-recaptcha" data-sitekey="6LfjwaMUAAAAAP3HvcIISjRFyGcZ4U3mpt94PFm5"></div></center>
                                </div>
                            </div>
                                <div class="col-sm-6 text-center push" style="margin-left: auto; margin-right: auto;">
                                    <button class="btn btn-alt-success" onClick="forgetpass()"><i class="fa fa-plus mr-10"></i> إرسال رسالة تحقق </button>
                                </div>
                            </div>
							<div class="block-content bg-body-light">
								<div class="form-group text-center">
									<a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="login">
										<i class="fa fa-user text-muted mr-5"></i> تسجيل الدخول
									</a>
									<a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="register">
										<i class="fa fa-user text-muted mr-5"></i> إنشاء حساب
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
<script src="https://cdn.rawgit.com/alertifyjs/alertify.js/v1.0.10/dist/js/alertify.js"></script>
<script>
		const toast = swal.mixin({
		  toast: true,
		  position: 'top-end',
		  showConfirmButton: false,
		  timer: 3000
		});

	function forgetpass(){
		var email=document.getElementById("email").value;
		if(email == null){
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
		sendData("forgetpass", "email="+email+"&reCAPTCHA="+grecaptcha.getResponse())
		.then(function(response){
			swal({
				title: response.t, 
				text: response.m,
				type: response.tp,
				showConfirmButton: response.b,
				confirmButtonText: 'موافق'
			});
			if(response.updateCAPTCHA){
				grecaptcha.reset();
			}
		});
	}
		</script>
		<script src="assets/js/codebase.min-2.1.js"></script><script src="https://unpkg.com/sweetalert2@7.21.1/dist/sweetalert2.all.js"></script><script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
		<script src="assets/js/pages/op_auth_signin.js"></script>
    </body>
</html>