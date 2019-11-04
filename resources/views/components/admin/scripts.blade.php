
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{admin_plugins()}}/respond.min.js"></script>
<script src="{{admin_plugins()}}/excanvas.min.js"></script> 
<![endif]-->
<script src="{{admin_plugins()}}/jquery.min.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/jquery.serializejson.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{admin_plugins()}}/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/jquery.blockui.min.js" type="text/javascript"></script>

<!--<script src="{{admin_plugins()}}/jquery.cokie.min.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>-->
<!-- END CORE PLUGINS -->
<script src="{{admin_plugins()}}/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/jquery-validation/js/messages.js" type="text/javascript"></script>
<script type="text/javascript" src="{{admin_plugins()}}/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{admin_plugins()}}/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="{{admin_plugins()}}/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="{{admin_plugins()}}/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="{{admin_plugins()}}/select2/select2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- BEGIN PAGE LEVEL PLUGINS -->
@stack('js_plugins')
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{admin_plugins()}}/metronic.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/layout.js" type="text/javascript"></script>
<script src="{{admin_plugins()}}/demo.js" type="text/javascript"></script>
<script src="{{admin_scripts('')}}/my.js" type="text/javascript"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

<script src="{{admin_scripts()}}/main.js" type="text/javascript"></script>
<script src="{{admin_scripts()}}/index.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE SCRIPTS -->
@stack('js_custom')
<!-- END PAGE SCRIPTS -->


