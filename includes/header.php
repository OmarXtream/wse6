<?php
if(count(get_included_files()) == 1){
	header('HTTP/1.0 403 Forbidden');
	exit;
}
require 'req.php';
ini_set('display_errors', 1);
$conn=$database->openConnection();
$sql = $conn->query("SELECT username,email,img,rank,phonenumber,Credits FROM Customers WHERE id='{$_SESSION['memberId:wse6']}'");

if($sql->rowCount() > 0){
	
	$row = $sql->fetch();
		$clientnickname = htmlspecialchars($row['username']);
		$clientemail = $row['email'];
		$clientimage = $row['img'];
		$clientPhoneNumber = $row['phonenumber'];
		$clientrank = $row['rank'];
		$clientbalance = $row['Credits'];
		$clientImage = $row['img'];

	if($clientimage == ""){
	$clientimage = 'https://png.icons8.com/cotton/64/000000/gender-neutral-user.png';
	}

} else {
	exit(header("Refresh:0; url=logout.php"));
}
$sql = $conn->query("SELECT notification,time FROM notification WHERE cid='{$_SESSION['memberId:wse6']}' ORDER BY id DESC");
$notifyCount = $sql->rowCount();
if($notifyCount > 0){
	$notifys = array();
	foreach($sql as $row){
		$notify = htmlspecialchars($row['notification']);
		$time = $row['time'];
		$arr = array($notify,$time);
		array_push($notifys,$arr);
	}
	$heightempty = '300px';
	$emptynotify = false;
}else{
	$emptynotify = true;
	$heightempty = 'auto';
}
$database->closeConnection();


?>
<!DOCTYPE html>
<!--[if lte IE 9]>     <html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title><?=$Config["title"];?></title>
        <meta name="description" content="<?=$Config["description"];?>">
        <meta name="author" content="TimeToDev [T2D]">
        <meta name="robots" content="noindex, nofollow">
        <meta name="token" content="<?=$_SESSION['_token']?>">
        <meta property="og:title" content="">
        <meta property="og:site_name" content="<?=$Config["title"];?>">
        <meta property="og:description" content="<?=$Config["description"];?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
		<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/js/plugins/select2/select2.min.css">
		<link rel="stylesheet" href="assets/js/plugins/select2/select2-bootstrap.min.css">
		<link rel="stylesheet" href="assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
		<link rel="stylesheet" href="assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
		<link rel="stylesheet" href="assets/js/plugins/jquery-tags-input/jquery.tagsinput.min.css">
		<link rel="stylesheet" href="assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.css">
		<link rel="stylesheet" href="assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.min.css">
		<link rel="stylesheet" href="assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css" />
        <link rel="stylesheet" id="css-main" href="assets/css/codebase.min-2.1.css">
        <link rel="stylesheet" id="css-theme" href="assets/css/themes/corporate.min-2.1.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.js"></script>
		<script src="https://unpkg.com/sweetalert2@7.21.1/dist/sweetalert2.all.js"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		
		<style>
			html {
                direction: rtl;
            }
			
			.dz-hidden-input{
				overflow: hidden !important;
			}
			
			
			     .nav-main a {
                padding-right: 40px;
                padding-left: 18px;
				text-align: right;
            }

            .nav-main a > i {
                right: auto;
            }

            .nav-main a.nav-submenu {
                padding-right: 40px;
                padding-left: 35px;
            }

            .nav-main a.nav-submenu::before, .nav-main a.nav-submenu::after {
                right: auto;
                left: 15px;
            }

            .nav-main a.nav-submenu::before {
                content: '\f105';
            }

            .nav-main a.nav-submenu::after {
                -webkit-transform: rotate(-90deg);
                -o-transform: rotate(-90deg);
                transform: rotate(-90deg);
            }

            .nav-main ul {
                padding-right: 40px;
                padding-left: 0;
            }

            .nav-main ul a,
            .nav-main ul a.nav-submenu {
                padding-right: 0;
                padding-left: 8px;
            }

            .nav-main ul a > i {
                margin-right: 0;
                margin-left: 15px;
            }

            .nav-main ul ul {
                padding-right: 12px;
            }
			
				.customhover a:hover{
					color: white !important;
					background-color: #34495e !important;
				}
				
				.scrumboard{display:-ms-flexbox;display:flex;-ms-flex-align:start;align-items:flex-start;-ms-flex-wrap:nowrap;flex-wrap:nowrap;overflow-x:auto;opacity:0;-webkit-overflow-scrolling:touch;padding:12px 12px 1px}@media (min-width:768px){.scrumboard{padding:24px 24px 1px}}.scrumboard .scrumboard-col{-ms-flex:0 0 auto;flex:0 0 auto;width:320px;margin-right:12px}@media (min-width:768px){.scrumboard .scrumboard-col{margin-right:24px}}.scrumboard .scrumboard-item{position:relative;min-height:42px;padding:10px 87px 10px 10px;margin-bottom:15px;font-weight:600;color:#a87e00;background-color:#fcf7e6;border-bottom:1px solid rgba(168,126,0,.1);box-shadow:0 5px 8px rgba(168,126,0,.05)}.scrumboard .scrumboard-item-options{position:absolute;top:7px;right:7px}.scrumboard .scrumboard-item-handler{cursor:move}.scrumboard .scrumboard-item-placeholder{min-height:42px;border:1px dashed #ffca28}
				

            /* Main Header Navigation */
            @media (min-width: 992px) {
                .nav-main-header a > i {
                    margin-right: 0;
                    margin-left: 8px;
                }

                .nav-main-header a.nav-submenu {
                    padding-right: 14px;
                    padding-left: 28px;
                }

                .nav-main-header a.nav-submenu::before {
                    right: auto;
                    left: 6px;
                }

                .nav-main-header ul {
                    right: 0;
                    left: auto;
                }

                .nav-main-header ul a.nav-submenu::before {
                    content: '\f104';
                }

                .nav-main-header ul ul {
                    right: 100%;
                    left: auto;
                }

                .nav-main-header > li:last-child ul {
                    right: auto;
                    left: 0;
                }

                .nav-main-header > li:last-child ul a.nav-submenu::before {
                    content: '\f105';
                }

                .nav-main-header > li:last-child ul ul {
                    right: auto;
                    left: 100%;
                }
				
            }
		</style>
		
		
    </head>
<body><div id="page-container" class="sidebar-inverse side-scroll page-header-fixed page-header-glass page-header-inverse main-content-boxed">
        <nav id="sidebar">
    <div class="sidebar-content">
        <div class="content-header content-header-fullrow bg-black-op-10">
            <div class="content-header-section text-center align-parent">
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <div class="content-header-item">
                    <a class="link-effect font-w700" href="home">
						<span class="text-dual-primary-dark">موقع</span><span class="text-primary"> وسيط </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li>
					<a class="<?php if(isset($activeHome)){echo $activeHome;}?>" href="home"><i class="si si-home"></i>الرئيسية</a>
				</li>
				<li>
					<a class="<?php if(isset($activeOrder)){echo $activeOrder;}?>" href="order"><i class="si si-settings"></i>طلب وساطة</a>
				</li>
				<li>
					<a class="<?php if(isset($ticket)){echo $ticket;}?>" href="ticket"><i class="si si-support"></i>الدعم الفني</a>
				</li>
				<li>
					<a class="<?php if(isset($transfer)){echo $transfer;}?>" href="transfer"><i class="si si-credit-card"></i>الحوالات</a>
				</li>
				<li>
					<a class="<?php if(isset($apply)){echo $apply;}?>" href="apply"><i class="si si-envelope"></i>التقديم على الإدارة</a>
				</li>
				<?php
				if(!rankPermission($_SESSION['memberId:wse6'],0)){
				?>
				<li>
					<a href="staff"><i class="si si-chemistry"></i><body text="red">لوحة التحكم</body></a>
				</li>
				<?php }?>
            </ul>
        </div>
    </div>
</nav>
<header id="page-header">
    <div class="content-header">
        <div class="content-header-section">
            <div class="content-header-item">
                <a class="link-effect font-w600" href="home">
                    <span class="text-dual-primary-dark">موقع</span><span class="text-primary"> وسيط </span>
                </a>
            </div>
        </div>
        <div class="content-header-section mr-100">
            <ul class="nav-main-header">
                <li>
					<a class="<?php if(isset($activeHome)){echo $activeHome;}?>" href="home"><i class="si si-home"></i>الرئيسية</a>
				</li>
				<li>
					<a class="<?php if(isset($activeOrder)){echo $activeOrder;}?>" href="order"><i class="si si-earphones-alt"></i>طلب وساطة</a>
				</li>
				<li>
					<a class="<?php if(isset($ticket)){echo $ticket;}?>" href="ticket"><i class="si si-support"></i>الدعم الفني</a>
				</li>
				<li>
					<a class="<?php if(isset($transfer)){echo $transfer;}?>" href="transfer"><i class="si si-credit-card"></i>الحوالات</a>
				</li>
				<li>
					<a class="<?php if(isset($apply)){echo $apply;}?>" href="apply"><i class="si si-envelope"></i>التقديم على الإدارة</a>
				</li>
				<?php
				if(rankPermission($_SESSION['memberId:wse6'],1)){
				?>
				<li>
					<a href="staff"><i class="si si-chemistry"></i><body text="red">لوحة التحكم</body></a>
				</li>
				<?php }?>

            </ul>
			<button type="button" class="btn btn-circle btn-dual-secondary d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
        </div>
        <div class="content-header-section">
				<div class="btn-group" role="group" dir="rtl" id="oncc">
					<button type="button" class="btn btn-rounded btn-dual-secondary" id="notifyListener" data-toggle="dropdown">
						<i class="fa fa-flag"></i> 
						<span class="badge badge-danger badge-pill" id="notifyCount"><?=$notifyCount?></span>
					</button>
					<div class="dropdown-menu dropdown-menu-left min-width-300" id="notifybox" style="height:<?=$heightempty?>;overflow-y:auto;">
						<h5 class="h6 text-center py-10 mb-0 border-b text-uppercase">التنبيهات</h5>
						<ul class="list-unstyled my-20 text-right" id="allnotifications">
						<?php
						if(!$emptynotify){
						foreach($notifys as $nf){
							$timeago = ago($nf[1]);
							$time=time();
							echo"
							<li>
								<a class='text-body-color-dark media mb-15'>
									<div class='media-body '>
										<p class='mb-0'>{$nf[0]}</p>
										<div class='text-muted font-size-sm font-italic'>{$timeago}</div>
									</div>
								</a>
							</li>
							";
						}
						}
						?>
						</ul>
						<div id="nonotify">
						<?php if($emptynotify){?>
							<h5 class="h6 text-center py-10 mb-50 mt-50 text-uppercase">لا يوجد أي تنبيهات</h5>
						<?php }?>
						</div>
					</div>
				</div>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-user d-sm-none"></i>
						<span class="d-none d-sm-inline-block" id="name"><?=$clientnickname;?></span>
						<i class="fa fa-angle-down ml-5"></i>
					</button>
					<div class="dropdown-menu dropdown-menu-left min-width-200 customhover" aria-labelledby="page-header-user-dropdown" >
						<h5 class="h6 text-center py-10 mb-5 border-b text-uppercase" id="name2"><?=$clientnickname;?></h5>
						<a class="dropdown-item text-right text-dark" href="profile">
							<i class="si si-user mr-5"></i> الملف الشخصي
						</a>
						<a class="dropdown-item text-right text-dark" href="payment">
							<i class="si si-wallet mr-5"></i> شحن رصيد
						</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item text-right text-dark" href="logout">
							<i class="si si-logout mr-5"></i> تسجيل الخروج
						</a>
					</div>
                </div>
        </div>
    </div>
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>
</header>