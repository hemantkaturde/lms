<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>LMS | Login</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <!-- <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet" /> -->
    <link href="<?php echo base_url(); ?>assets/css/main.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="<?php echo base_url(); ?>assets/css/pages/auth-light.css" rel="stylesheet" />
</head>

<body class="bg-silver-300">
    <div class="content">
        <div class="brand">
        <a href="https://doctor.iictn.org/"  target="_blank"><img src="<?php echo base_url('assets/img/logos/iictn_lms.png'); ?>" alt="" height="100"></a>
            <!-- <a class="link" href="#" style="font-size: 24px;">LMS Management</a> -->
        </div>
        <form id="login-form" action="javascript:;" method="post" novalidate="novalidate">
        <!-- <form action="<?php echo base_url(); ?>loginMe" method="post"> -->
            <h4 class="login-title">Log in</h4>
            <div class="alert_msg"></div> 
            <div class="form-group">
                
                <div class="input-group-icon right">
                    <label for=""> Username / Email</label>
                    <div class="input-icon"><i class="fa fa-envelope"></i></div>
                    <input class="form-control" type="username" name="username" placeholder="Username" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <label for="">Password</label>
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="off">
                </div>
            </div>
            <div class="form-group d-flex justify-content-between">
                <label class="ui-checkbox ui-checkbox-info">
                    <input type="checkbox">
                    <span class="input-span"></span>Remember me</label>
                <!-- <a href="#">Forgot password?</a> -->
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-block" id="login_btn" value="Login" type="submit">Login</button>
                <!-- <a class="btn btn-info btn-block" href="<?php echo base_url(); ?>dashboard">Login</a> -->
            </div>
            <!-- <div class="social-auth-hr">
                <span>Or login with</span>
            </div>
            <div class="text-center social-auth m-b-20">
                <a class="btn btn-social-icon btn-twitter m-r-5" href="javascript:;"><i class="fa fa-twitter"></i></a>
                <a class="btn btn-social-icon btn-facebook m-r-5" href="javascript:;"><i class="fa fa-facebook"></i></a>
                <a class="btn btn-social-icon btn-google m-r-5" href="javascript:;"><i class="fa fa-google-plus"></i></a>
                <a class="btn btn-social-icon btn-linkedin m-r-5" href="javascript:;"><i class="fa fa-linkedin"></i></a>
                <a class="btn btn-social-icon btn-vk" href="javascript:;"><i class="fa fa-vk"></i></a>
            </div> -->
            <!-- <div class="text-center">Not a member? -->
                <!-- <a class="color-blue" href="#">Create accaunt</a> -->
            <!-- </div> -->
        </form>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <!-- <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div> -->
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="<?php echo base_url(); ?>assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?php echo base_url(); ?>assets/js/app.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom/login.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
</body>
</html>