<meta charset="utf-8" />
<title>@yield('pageTitle')</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content="Markat" name="description" />
<meta content="Markat" name="author" />

<link href="{{admin_plugins()}}/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="{{admin_plugins()}}/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
@if($lang_code=='ar')
<link href="http://fonts.googleapis.com/earlyaccess/droidarabickufi.css?ver=3.9.2" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Gochi+Hand" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Harmattan" rel="stylesheet">
<link href="{{admin_plugins()}}/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
@else
<link href="https://fonts.googleapis.com/css?family=Martel:700&display=swap" rel="stylesheet">
<link href="{{admin_plugins()}}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
@endif

<link href="{{admin_plugins()}}/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
<link href="{{admin_plugins()}}/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="{{admin_plugins()}}/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/select2/select2.css"/>
@stack('css_plugins')
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME STYLES -->
<!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
@if($lang_code=='ar')
<link href="{{admin_css()}}/components-md-rtl.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{admin_css()}}/plugins-md-rtl.css" rel="stylesheet" type="text/css"/>
<link href="{{admin_css()}}/layout-rtl.css" rel="stylesheet" type="text/css"/>
<link href="{{admin_css()}}/grey-rtl.css" rel="stylesheet" type="text/css" id="style_color"/>
@else
<link href="{{admin_css()}}/components-md.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{admin_css()}}/plugins-md.css" rel="stylesheet" type="text/css"/>
<link href="{{admin_css()}}/layout.css" rel="stylesheet" type="text/css"/>
<link href="{{admin_css()}}/light.css" rel="stylesheet" type="text/css" id="style_color"/>
@endif
<link href="{{admin_css()}}/animate.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="{{admin_css()}}/custom.css" rel="stylesheet" type="text/css"/>
<link href="{{admin_css()}}/my.css" rel="stylesheet" type="text/css"/>
@if($lang_code=='ar')
<link href="{{admin_css()}}/style-rtl.css" rel="stylesheet" type="text/css"/>
@else
<link href="{{admin_css()}}/style.css" rel="stylesheet" type="text/css"/>
@endif
<!-- END THEME STYLES -->

<!-- BEGIN PAGE STYLES -->
@stack('css_custom')
<!-- END PAGE STYLES -->


