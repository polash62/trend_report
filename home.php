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
        <link href="<?php echo $baseurl; ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="<?php echo $baseurl; ?>assets/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <!--right slidebar-->
        <link href="<?php echo $baseurl; ?>assets/css/slidebars.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?php echo $baseurl; ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/css/style-responsive.css" rel="stylesheet" />
        <link href="<?php echo $baseurl; ?>assets/css/semantic.min.css" rel="stylesheet">       
        <link href="<?php echo $baseurl; ?>assets/css/custom.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>

    <style type="text/css">
        #main-content {
            margin-left: 0px;
        }

        .wrapper {
            /*  background: url(assets/img/4b.png) no-repeat center center fixed;  */
            /* background-color: #F1F2F7; */
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            opacity: 1;
        }
        body {
            background:#FFF url(assets/img/bg.png);  
            /* background: #f1f2f7 none repeat scroll 0 0; */
        }
        .col-md-3 {
            padding-left: 8px;
            padding-right: 8px;
        }
    </style>  


    <script type="text/javascript">
        jssor_1_slider_init = function() {

            var jssor_1_options = {
                $AutoPlay: true,
                $Idle: 0,
                $AutoPlaySteps: 4,
                $SlideDuration: 2500,
                $SlideEasing: $Jease$.$Linear,
                $PauseOnHover: 4,
                $SlideWidth: 180,
                $Cols: 7
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*responsive code begin*/
            /*you can remove responsive code if you don't want the slider scales while window resizing*/
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 809);
                    jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*responsive code end*/
        };
    </script>
    <body>

        <?php
        $userid = $this->session->userdata("user_name");
        $userqr = $this->db->query("SELECT * FROM user WHERE user_pin = '$userid'");
        $userinfo = $userqr->row();
        ?>

        <section id="container" class="">
            <!--header start-->
            <header class="header white-bg">

                <a style="color: rgb(209, 0, 116);" href="<?php echo site_url('home'); ?>" class="logo">BRAC Microfinance</a>

                <div class="top-nav ">
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
                                    <a href="<?= $baseurl_crm; ?>myprofile"><i class="fa fa-user"></i> Update Profile </a>
                                </li>
                                <li>
                                    <a href="<?= $baseurl_crm; ?>myprofile/changepassword"><i class="fa fa-pencil"></i> Change Password</a>
                                </li>
                                <li>
                                    <a href="<?= site_url('dashboard/logout'); ?>"><i class="fa fa-power-off"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                        <!-- /USER OPTIONS -->
                    </ul>
                    <!-- /OPTIONS LIST -->
                </div>

            </header>
            <!--header end-->

            <!--main content start-->
            <section id="main-content">
                <section class="wrapper site-min-height">
                    <!-- page start-->
                    <div class="col-md-6 col-md-offset-1">

                        <div class="row margintop5px">                         
                            <div class="col-md-3">
                                <a style="display: block" title="BRAC Microfinance All Circulars" class="ui segment home-block" href="<?php echo site_url('circulars/home_circulars'); ?>">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/circular.jpg">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal">Circulars</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a style="display: block" class="ui segment home-block" target="_blank" href="http://118.179.217.226:8888">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/cis.jpg">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal"> CIS </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a style="display: block" title="Automation Support & Material Requisitions" class="ui segment home-block" href="<?php echo $baseurl_crm; ?>">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/crm.jpg">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal"> CRM </div>
                                    </div>
                                </a>
                            </div> 

                            <div class="col-md-3">
                                <a style="display: block" class="ui segment home-block" href="<?php echo site_url('csa/collection'); ?>">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/csa.jpg">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal"> CSA </div>
                                    </div>
                                </a>
                            </div>
                        </div>  

                        <div class="row margintop5px">                         
                            <div class="col-md-3">
                                <a style="display: block" class="ui segment home-block" href="<?php echo $baseurl_crm; ?>pmwl/verification">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/approval.jpg">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal"> e-Approval</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a style="display: block" class="ui segment home-block" href="<?php echo site_url('comming_soon'); ?>">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/incentive.jpg">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal">  Incentive </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a style="display: block" class="ui segment home-block" href="<?php echo site_url('gridreport/globalsummary'); ?>">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/grid.jpg">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal"> Activity Grid </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a style="display: block" class="ui segment home-block" target="_blank" href="http://trendx.brac.net:8080/ODKAggregate">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/rdu.jpg">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal"> RDU Reports </div>
                                    </div>
                                </a>
                            </div>                                
                        </div> 

                        <div class="row margintop5px">
                            <div class="col-md-3">
                                <a style="display: block" target="_blank" class="ui segment home-block" href="<?php echo $sbmHR_url; ?>">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/sbmhr.png">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal"> sbmHR </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a style="display: block" title="Trend Reports, Analysis & Compare" class="ui segment home-block" href="<?php echo site_url('dashboard'); ?>">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/trendx.png">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal"> Trend Report</div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-3">
                                <a style="display: block" title="all branch location" class="ui segment home-block" href="<?php echo site_url('comming_soon'); ?>">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/location-map.jpg">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal"> Location </div>
                                    </div>
                                </a>
                            </div>  
                            
                            <div class="col-md-3">
                                <a style="display: block" title="Albhum and Images" class="ui segment home-block" href="<?php echo site_url('comming_soon'); ?>">
                                    <h1 class="ui image rounded"> <img src="<?php echo $baseurl; ?>assets/img/gallery.png">  </h1>
                                    <div class="content">
                                        <div class="ui ribbon label teal"> Gallery </div>
                                    </div>
                                </a>
                            </div>  
                        </div>

                    </div>

                    <div class="col-md-3 col-md-offset-2">         
                        <?php if (!in_array($this->session->userdata('userrole'), array(108))): ?>
                            <div class="col-md-12">
                                <header class="panel-heading margintop5px">
                                    Notice Board
                                </header>
                                <div class="homepage-news">
                                    <?php
                                    //$data['noticedata'] = $this->common->getAllData('notice_board');
                                    $noticedata = array();
                                    $this->db->select('*');
                                    $this->db->where('status', 'Active');
                                    $this->db->where('home_notice', '1');
                                    $this->db->order_by('date', 'desc');
                                    $query = $this->db->get('home_notice');
                                    $noticedata=$query->result();
                                    //foreach ($query->result_array() as $row):
                                     //   $noticedata[] = $row;
                                   // endforeach;
                                    if (sizeof($noticedata) > 0):
                                        ?>
                                        <marquee height="290px" direction="up" scrollamount="2" onMouseOver="stop()" onMouseOut="start()"> 
                                            <?php foreach ($noticedata as $row): ?>
                                            <?php if ($row->notice_type == 2): ?>
                                             <i class="fa fa-hand-o-right"> </i> &nbsp; <a class="btn-link" target="_blank" href="<?php echo site_url('circulars/acirculars/notice_view?id=' . $row->id) ?>"> <?php echo $row->title; ?> </a><br>
                                                <span class="notice_datetext"> <?php echo date('F j, Y, g:i a', strtotime($row->date)); ?> </span> <br>
                                                <div class="small-gapnotice"> </div>
                                                <?php else:   ?>
                                                <i class="fa fa-hand-o-right"> </i> &nbsp; <a class="btn-link" target="_blank" href="<?php echo site_url(); ?>uploads/home_notice/<?php echo $row->file_name; ?>"> <?php echo $row->title; ?> </a><br>
                                                <span class="notice_datetext"> <?php echo date('F j, Y, g:i a', strtotime($row->date)); ?> </span> <br>
                                                <div class="small-gapnotice"> </div>
                                                <?php endif;   ?>
                                                
                                            <?php endforeach; ?>
                                        </marquee>
                                    <?php else:
                                        ?>
                                        <marquee height="290px" direction="up" scrollamount="2" onMouseOver="stop()" onMouseOut="start()"><i class="fa fa-times"> </i>&nbsp; <a href=""> No Notice Available Right Now!</a><br>                       
                                        </marquee>
                                    <?php endif;
                                    ?>
                                </div>
                            </div>   
                        <?php endif; ?>
                    </div>
                    
                    <a href="<?php echo $baseurl_crm; ?>gallery/gallery/allgallery">
                       <div class="col-md-12" style="margin-top: 40px;margin-bottom: 30px;">
                           <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1080px; height: 110px; overflow: hidden; visibility: hidden;">
                                <!-- Loading Screen -->
                                <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
                                    <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                                    <div style="position:absolute;display:block;background:url('<?php echo $baseurl; ?>assets/img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
                                </div>
                                <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1080px; height: 120px; overflow: hidden;">
                                    <?php foreach ($querynf as $drow) : ?>
                                        <div style="display:none; cursor: pointer">
                                            <img data-u="image" src="<?php echo $baseurl_crm; ?>uploads/gallery/<?php echo $drow->image_path; ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div></a>

                    </div>
                </section>
            </section>
            <!--main content end-->


            <!--footer start-->
            <footer class="site-footer">
                <div class="text-center">A Product of  
                    <a style="color: #E8E8E8; font-family: arial; font-size: 14px;" href="http://brac.net/" target="_blank"><?php //echo date("Y");                               ?> <b>BRAC MF Automation</b></a>, Developed by
                    <a style="color: #E8E8E8; font-family: arial; font-size: 14px;" href="http://clouditbd.com/" target="_blank">Cloud IT Limited</a>
                    <a href="#" class="go-top">
                        <i class="fa fa-angle-up"></i>
                    </a>
                </div>
            </footer>
            <!--footer end-->           
        </section>
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo $baseurl; ?>assets/js/jquery.js"></script>
        <script src="<?php echo $baseurl; ?>assets/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="<?php echo $baseurl; ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="<?php echo $baseurl; ?>assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo $baseurl; ?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="<?php echo $baseurl; ?>assets/js/respond.min.js" ></script>
        <script src="<?php echo $baseurl; ?>assets/js/jssor.slider-21.1.6.min.js" type="text/javascript"></script>
        <!--right slidebar-->
        <script src="<?php echo $baseurl; ?>assets/js/slidebars.min.js"></script>

        <!--common script for all pages-->
        <script src="<?php echo $baseurl; ?>assets/js/common-scripts.js"></script>

        <script src="<?php echo $baseurl; ?>assets/js/semantic.min.js"></script>

        <script type="text/javascript">
                                            $(function() {
                                                $('.desk-wrapper span.desk').transition('pulse');
                                                $('a.home-block').hover(function() {
                                                    $(this).find('.ui.ribbon.label').removeClass('teal');
                                                    $(this).find('.ui.ribbon.label').addClass('red');
                                                    $(this).find('.ui.image').removeClass('rounded');
                                                    $(this).find('.ui.image').addClass('circular');
                                                }, function() {
                                                    $(this).find('.ui.ribbon.label').removeClass('red');
                                                    $(this).find('.ui.ribbon.label').addClass('teal');
                                                    $(this).find('.ui.image').removeClass('circular');
                                                    $(this).find('.ui.image').addClass('rounded');
                                                });
                                            });
        </script> 

        <script type="text/javascript">
            jssor_1_slider_init();
        </script>
    </body>
</html>
