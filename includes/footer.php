<?php

if(count(get_included_files()) == 1){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

?>    <footer id="page-footer" class="bg-primary-dark text-white opacity-0">
    <div class="content py-20 font-size-xs clearfix">
        <div class="float-left">
          تم برمجة وتطوير الموقع بواسطة<a href="https://www.t2d.group"> فريق وقت التطوير </a>
        </div>
        <div class="float-right">
            <a class="font-w600" href="" target="_blank">موقع وسيط</a> &copy; <span >1439</span>
        </div>
    </div>
</footer>
		<script src="https://unpkg.com/sweetalert2@7.21.1/dist/sweetalert2.all.js"></script>
		<script src="assets/js/plugins/alertify/alertify.js"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="assets/js/codebase.min-2.1.js"></script>
		<script src="assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
		<script src="assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
		<script src="assets/js/plugins/select2/select2.full.min.js"></script>
		<script src="assets/js/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
		<script src="assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
		<script src="assets/js/plugins/masked-inputs/jquery.maskedinput.min.js"></script>
		<script src="assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
		<script src="assets/js/pages/be_forms_plugins.js"></script>
		<script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>
		<script src="assets/js/pages/be_tables_datatables.js"></script>
		<script src="assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
		<!--<script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
		<script src="assets/js/plugins/jquery-validation/additional-methods.js"></script>-->
		<script src="assets/js/pages/be_forms_validation.min.js"></script>
		<script>jQuery(function(){Codebase.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);});</script>
		<script src="assets/js/script.js?v=<?php echo rand(0,9999999999);?>"></script>
		<script>window.setInterval(function(){notification();}, 10000);</script>
    </body>
</html>