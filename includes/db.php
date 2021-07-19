<?php
require_once("config.php");

class DB
{
  private $db_host = "localhost";
  private $db_port = 3306;
  private $db_user = "msafatco_test";
  private $db_pass = 'bHpBcN7bL-@X';
  private $db_name = "msafatco_test";
  private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4");
  protected $conn;

  public function openConnection(){

    $this->conn = null;

    try{
    $this->conn = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_pass, $this->options);

    }catch(PDOException $exception){
		die("Error [DB].");
    }
    return $this->conn;
  }
  public function closeConnection() {
    $this->conn = null;
  }
}



$database = new DB();

$conn = $database->openConnection();
$stmt = $conn->query('SELECT * FROM sitesettings')->fetch();
$closeSite = $stmt['closeSite'];
$closeapply = $stmt['closeapply'];
$closepaypal = $stmt['closepaypal'];
$closestc = $stmt['closestc'];
$closemobily = $stmt['closemobily'];
$closeps = $stmt['closeps'];

if($closeSite and !isset($amstaff)){
	?>
	
<!DOCTYPE html>
<!--[if lte IE 9]>     <html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>وسيط | تحت الصيانة</title>
        <meta name="author" content="TimeToDev [T2D] FarisDev #PABLO~">
        <meta name="robots" content="noindex, nofollow">
        <meta property="og:title" content="">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">
		
        <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
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
            }

            .nav-main a > i {
                right: 19px;
                left: auto;
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
<body>

<div id="page-container" class="main-content-boxed">
                <main id="main-container">
<div class="hero bg-white bg-pattern" style="background-image: url('assets/media/various/bg-pattern-inverse.png');">
    <div class="hero-inner">
        <div class="content content-full">
            <div class="py-30 text-center">
                <i class="si si-chemistry text-primary display-3"></i>
                <h1 class="h2 font-w700 mt-30 mb-10">سنعود قريباً</h1>
                <h2 class="h3 font-w400 text-muted mb-50">موقع وسيط تحت الصيانة في الوقت الحالي..</h2>
            </div>
        </div>
    </div>
</div>
    </main>
    </div>

		<script src="https://unpkg.com/sweetalert2@7.21.1/dist/sweetalert2.all.js"></script> 
		<script src="https://cdn.rawgit.com/alertifyjs/alertify.js/v1.0.10/dist/js/alertify.js"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="assets/js/codebase.core.min-3.0.js"></script>
		<script src="assets/js/codebase.min-2.1.js"></script>
    </body>
</html>
	<?php
	exit();
}
?>
