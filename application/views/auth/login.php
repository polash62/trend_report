<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="cloudit limited">    
        <link rel="shortcut icon" href="<?php echo $baseurl; ?>assets/img/icon.png">
        <title>Brac Microfinance -> Login</title>
        <link href="<?php echo $baseurl; ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/css/bootstrap-reset.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo $baseurl; ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/css/style-responsive.css" rel="stylesheet" />
        <style>
            .form-control{
                margin-left: 0px
            }
        </style>
    </head>
    <body class="login-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="margin-top: 5%">
                    <img style="margin-left: 39%; margin-bottom: -50px" src="<?php echo $baseurl; ?>assets/img/brac_logo.png">
                    <form class="form-signin" action="<?php echo site_url('auth/login'); ?>" method="post">

                        <h2 class="form-signin-heading">TrendX</h2>
                        <?php
                        if ($this->session->userdata('login_error')):
                            echo '<div class="alert alert-dismissable alert-danger"><a class="close" data-dismiss="alert">×</a><i class="icon icon-warning-sign"></i> ' . $this->session->userdata('login_error') . '</i></div>';
                            $this->session->unset_userdata('login_error');
                        endif;
                        ?>
                        <div class="login-wrap"> 
<!--                            <img style="margin-left: 38%" src="<?php echo $baseurl; ?>assets/img/brac_logo.png">-->
                            <input class="form-control" type="text" name="username" id="username" placeholder="User ID" autofocus>
                            <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                            <!--    <label class="checkbox">
                                    <input type="checkbox" value="remember-me"> Remember me
                                    <span class="pull-right">
                                        <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
                                    </span>
                                </label>  -->

                            <center> <button class="btn btn-success" type="submit">Sign in</button> </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="<?php echo $baseurl; ?>assets/js/jquery.js"></script>
        <script src="<?php echo $baseurl; ?>assets/js/bootstrap.min.js"></script>
        <script>
            function getfyear(id) {
                var dataString = "cid=" + id;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('home/getcompanyyear'); ?>",
                    data: dataString,
                    success: function (data) {
                        $("#fyear").html(data);
                    }
                });
            }
        </script>
    </body>
</html>
