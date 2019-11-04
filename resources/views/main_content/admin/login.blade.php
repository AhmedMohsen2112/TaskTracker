<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>{{t('APPROCKS')}}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for " name="description" />
        <meta content="" name="author" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="{{admin_plugins()}}/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{admin_plugins()}}/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{admin_plugins()}}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{admin_plugins()}}/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{admin_plugins()}}/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{admin_css()}}/login-soft.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME STYLES -->
        <link href="{{admin_css()}}/components-md.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="{{admin_css()}}/plugins-md.css" rel="stylesheet" type="text/css"/>
        <link href="{{admin_css()}}/layout.css" rel="stylesheet" type="text/css"/>
        <link id="style_color" href="{{admin_css()}}/login/default.css" rel="stylesheet" type="text/css"/>
        <link href="{{admin_css()}}/login/custom.css" rel="stylesheet" type="text/css"/>



        <link rel="shortcut icon" href="{{admin_img()}}/favicon.png" />
        <style>

            .logo h2{
                color: #fff;
                font-size: 4rem;
            }
            .login .content .form-actions .checkbox{
                margin-left: 20px;
            }
        </style>
        <script>
            var config = {
                public_path: " {{ url_public_path('') }}",
                admin_url: " {{ url('apanel') }}",
                asset_url: " {{ url_public_path('') }}",
                img_path: " {{ admin_img('') }}",
            };
            var lang = {

            };

            // alert(config.lang);
        </script>
    </head>
    <!-- END HEAD -->
    <body class="page-md login">
        <div class="logo"> 
            <h2>{{t('APPROCKS')}} </h2>
        </div>
        <!-- BEGIN LOGIN -->
        <div class="content">

            <!-- BEGIN LOGIN FORM -->
            <form class="login-form"  id="login-form"  method="post"  action="{{ route('admin.login.submit') }}">
                <h3 class="form-title text-center bold">Login to your account</h3>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label">{{t('username')}}</label>
                    <input class="form-control" type="text" placeholder="{{t('username')}}" id="username" name="username"/>

                    <div class="help-block"></div>
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input class="form-control" type="password"  placeholder="{{t('password')}}" id="password" name="password"/>

                    <div class="help-block"></div>
                </div>
                <div class="form-actions">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" value="1"/> Remember me 
                    </label>
                    <button type="button" class="btn blue pull-right submit-form">
                        {{t('login')}} 
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </button>

                </div>
                <div class="create-account">
                    <p>
                        Don't have an account yet ?&nbsp; <a href="javascript:;" id="register-btn">
                            Create an account </a>
                    </p>
                </div>

            </form>
            <form class="register-form" id="register-form" action="index.html" autocomplete="off" method="post" novalidate="novalidate" style="display: none;">
                <h3>  {{t('sign_up')}}</h3>
                <div class="form-group">
                    <label class="control-label">{{t('name')}}</label>
                    <input class="form-control" type="text" placeholder="{{t('name')}}" name="name">
                    <div class="help-block"></div>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label">{{t('email')}}</label>
                    <input class="form-control" type="text" placeholder="{{t('email')}}" name="email">
                    <div class="help-block"></div>
                </div>
                <div class="form-group">
                    <label class="control-label">{{t('phone')}}</label>
                    <input class="form-control" type="text" placeholder="{{t('phone')}}" name="phone">
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">{{t('username')}}</label>
                    <input class="form-control" type="text"  placeholder="{{t('username')}}" name="username">
                    <div class="help-block"></div>

                </div>
                <div class="form-group">
                    <label class="control-label">{{t('password')}}</label>
                    <input class="form-control" type="password"  placeholder="{{t('password')}}" name="password">
                    <div class="help-block"></div>

                </div>
                <div class="form-group">
                    <label class="control-label">{{t('confirm_password')}}</label>
                    <input class="form-control" type="password"  placeholder="{{t('confirm_password')}}" name="confirm_password">
                    <div class="help-block"></div>

                </div>

                <div class="form-actions">
                    <button id="register-back-btn" type="button" class="btn">
                        <i class="fa fa-arrow-circle-o-left"></i> {{t('back')}} </button>
                    <button type="submit" id="register-submit-btn" class="btn blue pull-right submit-form">
                        {{t('sign_up')}} <i class="fa fa-arrow-circle-o-right"></i></i>
                    </button>
                </div>
            </form>
            <!-- END LOGIN FORM -->

        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright" style="color: #000;">
            All Rights Reserved ©    Co. {{date('Y')}}
        </div>
        <!-- END COPYRIGHT -->
        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE PLUGINS -->
        <!--[if lt IE 9]>
        <script src="{{admin_plugins()}}/respond.min.js"></script>
        <script src="{{admin_plugins()}}/excanvas.min.js"></script> 
        <![endif]-->
        <script src="{{admin_plugins()}}/jquery.min.js" type="text/javascript"></script>
        <script src="{{admin_plugins()}}/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="{{admin_plugins()}}/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="{{admin_plugins()}}/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
        <script src="{{admin_plugins()}}/jquery.blockui.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{admin_plugins()}}/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="{{admin_plugins()}}/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="{{admin_plugins()}}/jquery-validation/js/messages.js" type="text/javascript"></script>
        <script src="{{admin_plugins()}}/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{admin_plugins()}}/metronic.js" type="text/javascript"></script>
        <script src="{{admin_plugins()}}/layout.js" type="text/javascript"></script>
        <script src="{{admin_plugins()}}/demo.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="{{admin_scripts()}}/my.js" type="text/javascript"></script>
        <script src="{{admin_scripts()}}/login.js" type="text/javascript"></script>
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                //Login.init();
                Demo.init();
                // init background slide images
                $.backstretch([
                    //                            config.asset_url+"/backend/img/bg/1.jpg",
                    config.img_path + "/bg/1.jpg",
                    config.img_path + "/bg/2.jpg",
                    config.img_path + "/bg/3.jpg",
                            //                    config.img_path + "/bg/4.jpg"
                ], {
                    fade: 1000,
                    duration: 4000
                }
                );
            });
        </script>
        <!-- END JAVASCRIPTS -->
    </body>


</html>