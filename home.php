<?php $activeHome="active"; require_once("includes/header.php");

?>
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
                <h1 class="font-w700 text-white mb-10">وسيط &mdash; إلرئيسية</h1>
                <h2 class="h4 font-w400 text-white-op">إلاحصائيات</h2>
            </div>
        </div>
    </div>
</div>
    <div class="content">
		<div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
        <div class="col-6 col-xl-3">
            <a class="block block-link-shadow text-right" href="javascript:void(0)">
                <div class="block-content block-content-full clearfix">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <i class="si si-wallet fa-3x text-body-bg-dark"></i>
                    </div>
                    <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="<?=$clientbalance;?>"><?=$clientbalance;?>$</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">رصيدي الحالي</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a class="block block-link-shadow text-right" href="javascript:void(0)">
                <div class="block-content block-content-full clearfix">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <i class="si si-calculator fa-3x text-body-bg-dark"></i>
                    </div>
                    <div class="font-size-h3 font-w600"><span data-toggle="countTo" data-speed="1000" data-to="<?=$totalwsa6h;?>" class="js-count-to-enabled"></span></div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">عدد مرات طلبي للوساطة</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a class="block block-link-shadow text-right" href="javascript:void(0)">
                <div class="block-content block-content-full clearfix">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <i class="si si-bubbles fa-3x text-body-bg-dark"></i>
                    </div>
                    <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="0">0</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">عدد تواصلك مع الإدارة</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a class="block block-link-shadow text-right" href="javascript:void(0)">
                <div class="block-content block-content-full clearfix">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <i class="si si-credit-card fa-3x text-body-bg-dark"></i>
                    </div>
                    <div class="font-size-h3 font-w600 js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="0">0</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">مرات الشحن في الموقع</div>
                </div>
            </a>
        </div>
    </div>
    </div>
</div>
    </main>
<script>
  (function (w,i,d,g,e,t,s) {w[d] = w[d]||[];t= i.createElement(g);
    t.async=1;t.src=e;s=i.getElementsByTagName(g)[0];s.parentNode.insertBefore(t, s);
  })(window, document, '_gscq','script','//widgets.getsitecontrol.com/177474/script.js');
</script>
<script>
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
<?php require_once("includes/footer.php");?>