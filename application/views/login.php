<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#424242" />
        <title>Login</title>
        <!--favican-->
        <link href="<?php echo base_url(); ?>img/s-favicon.png" rel="shortcut icon" type="image/x-icon">
        <!-- CSS -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/style.css">
        <style type="text/css">
            .bgwhite{ background: #e4e5e7;
                      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.5);overflow: auto;border-radius: 6px;}
            .llpb20{padding-bottom: 20px;}
            .around40{padding: 40px;}
            .formbottom2{text-align: left;border: 1px solid #e4e4e4;}
            button.btn:hover {opacity: 100 !important; color: #fff;background: #424242;}
            .form-top2 {text-align: left;}
            .img2{width: 100%}
            .spacingmb30{margin-bottom: 30px;}
            .borderR{border-right: 1px solid rgba(66, 66, 66, 0.16);padding: 0px 40px;}
            input[type="text"], input[type="password"], textarea, textarea.form-control {
                height: 40px;border: 1px solid #999;}
            input[type="text"]:focus, input[type="password"]:focus, textarea:focus, textarea.form-control:focus {
                border: 1px solid #424242;}
            button.btn {height: 40px;line-height: 40px;}
            .ispace{ padding-right:5px;}
            .form-top {background: rgba(0, 0, 0, 0.50);
                       box-shadow: 0px 7px 12px rgba(0, 0, 0, 0.29);
                       border-bottom: 1px solid rgba(255, 255, 255, 0.19);}
            .form-bottom{background: rgba(0, 0, 0, 0.50);box-shadow: 0px 7px 12px rgba(0, 0, 0, 0.29);}
            .font-white{color: #fff;}
        </style>
    </head>
    <body>
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <img src="<?php echo base_url(); ?>img/s_logo.png" style="width:100px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3 class="font-white">Login.</h3>      
                                </div>
                                <div class="form-top-right">
                                    <i class="fa fa-key"></i>
                                </div>
                            </div>
                            <div class="form-bottom">
                                <form action="admin_login" method="post">
                                    <input type='hidden' name='ci_csrf_token' value=''/>                                
                                    <div class="form-group">
                                        <label class="sr-only" for="form-username">User ID</label>
                                        <input type="text" name="username" placeholder="User ID" value="" class="form-username form-control" id="form-username">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Password</label>
                                        <input type="password" value="" name="password" placeholder="Password" class="form-password form-control" id="form-password">
                                        <span class="text-danger"></span>
                                    </div>
                                    <button type="submit" class="btn">Sign In</button>
                                </form>
								<a href="forget-password" class="forgot">Forgot Password?</a>
                                <?php echo $this->session->flashdata("error"); ?>
                                <div class="text-center spacingmb30" style="margin-top: 20px;">
                                    <p class="font-white">Download SEP App</p>
                                    <a href="<?php echo base_url(); ?>final_sep.apk" class="btn btn-default" download>
                                        <i class="fa fa-android ispace"></i>For Android
                                    </a>
                                </div>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <script src="<?php echo base_url(); ?>src_admin/src/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>src_admin/src/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>src_admin/src/jquery.backstretch.min.js"></script>
        <!-- <script src="src/scripts.js"></script> -->
        <!--[if lt IE 10]>
            <script src="src/placeholder.js"></script>
        <![endif]-->
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        var base_url = '';
        $.backstretch([
            base_url + "<?php echo base_url(); ?>src_admin/img/bg.png"
        ], {duration: 3000, fade: 750});
                
    });
</script>