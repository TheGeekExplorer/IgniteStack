<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Dashboard">
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

        <title>BOA Systems</title>

        <!-- Bootstrap core CSS -->
        <link href="/public/css/bootstrap.css" rel="stylesheet">
        <!--external css-->
        <link href="/public/font-awesome/css/font-awesome.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="/public/css/style.css" rel="stylesheet">
        <link href="/public/css/style-responsive.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


    </head>

    <body ng-app="boast" ng-controller="index_login_controller">

        <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->

        <div id="login-page">
            <div class="container">

                <form class="form-login" role="form" name="loginform" id="loginform" ng-submit="processForm()">
                    <h2 class="form-login-heading">sign in now</h2>
                    <div class="login-wrap">

                        <input class="form-control" placeholder="Username" name="u" type="text" ng-model="formData.u" ng-minlength="6" ng-maxlength="50" minlength="6" maxlength="50" required autofocus>

                        <br>

                        <input class="form-control" placeholder="Password" name="p" type="password" ng-model="formData.p" ng-minlength="6" ng-maxlength="25" minlength="6" maxlength="25" value="" required>

                        <label class="checkbox">
                                <span class="pull-right">
                                    <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
                                </span>
                        </label>

                        <button class="btn btn-theme btn-block" type="submit">
                            <span class="{{ loading_gif_text }}">SIGN IN</span>
                            <img src="/public/img/loading.gif" class="element-hide {{ loading_gif }} loading-gif">
                        </button>

                        <hr>

                        <div class="element-hide {{login_error_message}} login-error-message">
                            {{formData.error_message}}
                            <hr>
                        </div>

                        <div class="registration">
                            <strong>Don't have an account yet?</strong><br/>
                            Contact the Group Digital Team on extension #1026 or #1815.
                        </div>

                    </div>

                </form>



                    <!-- Modal -->
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                        <form ng-submit="sendForgottenPassword()">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Forgot Password ?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Contact Admin</p>
                                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                                        <div class="element-hide {{formDataForgottenPassword.show_error_message}}" style="padding-top:1em;">
                                            <strong>{{formDataForgottenPassword.error_message}}</strong>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                        <button class="btn btn-theme" type="submit">Submit</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- modal -->

            </div>
        </div>

        <!-- js placed at the end of the document so the pages load faster -->
        <script src="/public/js/jquery.js"></script>
        <script src="/public/js/bootstrap.min.js"></script>

        <!--BACKSTRETCH-->
        <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
        <script type="text/javascript" src="/public/js/jquery.backstretch.min.js"></script>
        <script>
            $.backstretch("/public/img/.jpg", {speed: 500});
        </script>


        <!-- AngularJS APP -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
        <script>var boast = angular.module('boast', []);</script>
        <script src="/public/js/boast/controller.index.login.js"></script>

        <!-- Set initial CSRF Token-->
        <script>
            sessionStorage.removeItem("auth_token"); // Reset auth token
            sessionStorage.setItem("csrf_token", "<?php echo $_STATE['csrf_token']; ?>"); // Set CSRF Token
        </script>

        <!-- CSS -->
        <style type="text/css">
            .loading-gif { margin:auto; width:1em; }
            .element-hide  { display:none; !important; }
            .element-show { display:block !important; }
            .login-error-message { font-weight:bold; color:#990000; }
        </style>

    </body>
</html>
