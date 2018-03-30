<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Shahadat">
        <meta name="keyword" content="trendx,brac,micro-finance,dhaka,bangladesh">
        <link rel="shortcut icon" href="<?php echo $baseurl; ?>assets/img/icon.png">
        <title><?php echo $title ?></title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo $baseurl; ?>assets/media/css/demo_table.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/DT_bootstrap.css" />        
        <link href="<?php echo $baseurl; ?>assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- custom search start here-->
        <link rel="stylesheet" type="text/css" href="<?php echo $baseurl; ?>assets/customsearch/css/bootstrap-select.css">
        <script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/jquery.js"></script>   
        <script type="text/javascript" src="<?php echo $baseurl; ?>assets/customsearch/js/bootstrap-select.js"></script>
        <script type="text/javascript" src="<?php echo $baseurl; ?>assets/customsearch/js/bootstrap-min.js"></script>
        <!-- custom search endhere here-->


        <link href="<?php echo $baseurl; ?>assets/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="<?php echo $baseurl; ?>assets/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo $baseurl; ?>assets/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/owl.carousel.css" type="text/css">
        <link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/datepicker.css" type="text/css">
        <link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/jquery.datetimepicker.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo $baseurl; ?>assets/nestable/jquery.nestable.css" />
        <!--dynamic table-->
        <link href="<?php echo $baseurl; ?>assets/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
        <link href="<?php echo $baseurl; ?>assets/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo $baseurl; ?>assets/assets/data-tables/DT_bootstrap.css" />
        <!--Form Wizard-->
        <link rel="stylesheet" type="text/css" href="<?php echo $baseurl; ?>assets/css/jquery.steps.css" /> 
        <link href="<?php echo $baseurl ?>assets/summernote/dist/summernote.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/jquery-multi-select/css/multi-select.css"  rel="stylesheet" type="text/css" />
        <!-- Custom styles for this template -->
        <link href="<?php echo $baseurl; ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/css/custom.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/css/style-responsive.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseurl; ?>assets/assets/gritter/css/jquery.gritter.css" /> 
    </head>
    <body>

        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-91229729-1', 'auto');
            ga('send', 'pageview');

        </script>

        <?php
        $userid = $this->session->userdata("user_name");
        $userqr = $this->db->query("SELECT * FROM user WHERE user_pin = '$userid'");
        $userinfo = $userqr->row();
        $baseurl_crm = $this->config->item('base_url_crm');
        ?>

        <section id="container" >
            <header class="header white-bg">
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
                </div>
                <a style="color: rgb(209, 0, 116);" href="<?php echo site_url('home'); ?>" class="logo">BRAC Microfinance</a>

                <div class="top-nav">
                    <!-- OPTIONS LIST -->
                    <ul class="nav pull-right">
                        <!-- USER OPTIONS -->
                        <li class="dropdown pull-left">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img class="user-avatar" alt="" src="<?php echo $baseurl_crm; ?>assets/images/upload/profile/<?php echo $userinfo->image_path; ?>" height="20" /> 
                                <span class="user-name">
                                    <span class="hidden-xs">
                                        <?php echo $userinfo->name; ?>  <i class="fa fa-angle-down"></i>
                                    </span>
                                </span>
                            </a>
                            <ul class="dropdown-menu hold-on-click">                                                                               
                                <li>
                                    <a href="<?php echo site_url('dashboard/logout'); ?>"><i class="fa fa-power-off"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                        <!-- /USER OPTIONS -->
                    </ul>
                    <!-- /OPTIONS LIST -->
                </div>

                <?php if ($active_menu == "dashboard"): ?>
                    <?php //if ($this->session->userdata('user_level') != '6'): ?>
                    <div style="margin-left: 42%">
                        <h4 style="margin-top: 25px;"> <?php //echo $program_name; ?> </h4>
                    </div> 
                    <?php //endif; ?>
                <?php endif; ?>
            </header>
