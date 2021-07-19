<?php
ini_set('session.cookie_httponly', true);
session_start();
require_once("includes/db.php");


if(isset($_SESSION['memberId:wse6'])){
	exit(header('Location: home'));
}else if(isset($_SESSION['account'])){
	exit(header('Location: login'));
}else{}

if(!isset($_SESSION['_token'])){
	$_SESSION['_token']=bin2hex(openssl_random_pseudo_bytes(16));
}
if(isset($_GET['verify'])){
	
	$verifyToken=$_GET['verify'];
	
	if(strlen($verifyToken) > 70){
		die("<center><p style='color: red;'>HOLD DOWN!!, ARE YOU TRYING TO HACK OUR WEBSITE? HAHA DON'T TRY!</p><a href='register'>Click here to back...</a>"); // Some bitch trying to hack the website. //
	}else{

	$conn=$database->openConnection();
	
	$stmt=$conn->prepare('SELECT verifyCode FROM Customers WHERE verifyCode=:verify');
	
	$stmt->bindValue(':verify', $verifyToken);
	$stmt->execute();
	
	if($stmt->rowCount() == 0){

		exit(header("Refresh:0; url=register"));
	}else{
		
		$stmtz=$conn->prepare('UPDATE Customers SET verify="1" WHERE verifyCode=:verify');
		$stmtz->bindValue(':verify', $verifyToken);
		$stmtz->execute();
		
		if($stmtz->rowCount() > 0){
			$_SESSION['verifiedNow'] = true;
			exit(header("Refresh:0; url=login"));
			
		}else{
			
			exit(header("Refresh:0; url=register"));
			
		}
		
		

		
	}
	}
	
}
?>
<!DOCTYPE html>
<!--[if lte IE 9]>     <html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-focus"> <!--<![endif]-->
    <head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Wse6 &bull; Register</title>
        <meta name="description" content="">
        <meta name="author" content="TimeToDev">
		<meta name="token" content="<?php if(isset($_SESSION['_token'])) { echo $_SESSION['_token']; } ?>">
        <meta name="robots" content="noindex, nofollow">
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
		<link rel="stylesheet" id="css-main" href="assets/css/codebase.min-2.1.css">
		<script src="assets/js/pages/sweetalert.js"></script>
		<script src="assets/js/script.js"></script>
		<noscript><meta HTTP-EQUIV="refresh" content=0;url="javascriptErr.php"></noscript>
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
                        <span class="font-size-xl text-primary-dark">وسيط</span>&nbsp;&nbsp;<span class="font-size-xl">إنشاء حساب</span>
                    </a>
                </div>
                <form class="js-validation-signup text-right" autocomplete="off" onSubmit="return false;">
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
                                    <label for="signup-username">إلاسم</label>
                                    <input type="text" class="form-control" id="username" name="signup-username" placeholder="Example: Ahmed">
                                </div>
                            </div>
							<div class="form-group row">
                                <div class="col-12">
                                    <label for="signup-email">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" name="signup-email" placeholder="Example: e@mail.com">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="signup-phonenumber">رقم الجوال</label>
                                    <input type="text" class="form-control" id="phonenumber" name="signup-phonenumber" placeholder="Example: 96650123xxxxx">
                                </div>
                            </div> 
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="signup-password">كلمة المرور</label>
                                    <input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="********">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="signup-password-confirm">تأكيد كلمة المرور</label>
                                    <input type="password" class="form-control" id="signup-password-confirm" name="signup-password-confirm" placeholder="********">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
									<center><div class="g-recaptcha" data-sitekey="<?=$Config["reCAPTCHA"];?>"></div></center>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-sm-6 push">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="signup-terms" name="signup-terms">
                                        <label class="custom-control-label" for="signup-terms">أوافق على الشروط والأحكام</label>
                                    </div>
                                </div></form>
                                <div class="col-sm-6 text-sm-right push">
                                    <button class="btn btn-alt-success" onClick="register()"><i class="fa fa-plus mr-10"></i> إنشاء حساب</button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content bg-body-light">
                            <div class="form-group text-center">
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#" data-toggle="modal" data-target="#modal-terms">
                                    <i class="fa fa-book text-muted mr-5"></i> قراءة القوانين
                                </a>
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="login">
                                    <i class="fa fa-user text-muted mr-5"></i> تسجيل الدخول
                                </a>
                            </div>
                        </div>
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
                <button type="button" class="btn btn-alt-success" data-dismiss="modal" onClick="acceptrules()">
                    <i class="fa fa-check"></i> موافق
                </button>
            </div>
        </div>
    </div>
</div>

		<script>
		<?php if(isset($_GET['timeout']) && $_GET['timeout'] == 1){ ?>
		alertify.logPosition("top right");
		alertify.error("تم تسجيل خروجك بنجاح، نظرًأ لعدم تفاعلك سجل مججدا!");
		<?php } ?>
		const toast = swal.mixin({
		  toast: true,
		  position: 'top-end',
		  showConfirmButton: false,
		  timer: 3000
		});
		 function acceptrules(){
			 document.getElementById('signup-terms').setAttribute("checked", "");
		 }
		 function validatePwd(pwd){
			// at least one number, one lowercase and one uppercase letter
			// at least six characters
			var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
			return re.test(pwd);
		 }
		function validateEmail(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(email).toLowerCase());
		}
		function register(){
				var username=document.getElementById("username").value;
				var password=document.getElementById("signup-password").value;
				var phonenumber=document.getElementById("phonenumber").value;
				var email=document.getElementById("email").value;
				if(!validateEmail(email)){
					toast({
					  type: 'error',
					  title: 'من فضلك تأكد من صحة البريد'
					});
				}else if(!validatePwd(password)){
					toast({
					  type: 'error',
					  title: 'يجب أن تحتوي كلمة المرور على حرف صغير وكبير ورقم على الأقل وأن تكون اكثر من 8 أحرف'
					});
				}else if(username == null || username == "" || phonenumber == "" || phonenumber == null){
					toast({
					  type: 'error',
					  title: 'من فضلك تأكد من المدخلات'
					});
				}else{
					if (grecaptcha === undefined) {
						toast({
						  type: 'error',
						  title: 'عذراً ولاكن التحقق غير موجود'
						});
						setTimeout(function () { location.href = "register.php";}, 3000);
						throw new Error("Empty RECAPTCHA");
					}else if (!grecaptcha.getResponse()) {
						swal({
						  title: "خطأ",
						  text: "من فضلك تحقق من أنك لست روبوت",
						  type: "error"
						});
						throw new Error("Robot Check");
					}
					sendData("reg.php", "email="+email+"&password="+password+"&username="+username+"&phonenumber="+phonenumber+"&reCAPTCHA="+grecaptcha.getResponse())
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
							grecaptcha.reset();
							document.getElementById("username").value = '';
							document.getElementById("signup-password").value = '';
							document.getElementById("signup-password-confirm").value = '';
							document.getElementById("phonenumber").value = '';
							document.getElementById("email").value = '';
							document.location = 'login.php';
						}
					});
				}
		}
			


		</script><script src="assets/js/codebase.min-2.1.js"></script><script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    </body>
</html>