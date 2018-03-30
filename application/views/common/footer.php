<!-- Js For Month Piker -->
<link rel="stylesheet" href="<?php echo $baseurl; ?>assets/monthpiker/jquery-ui.css">
<script src="<?php echo $baseurl; ?>assets/monthpiker/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/monthpiker/jquery.mtz.monthpicker.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/dynamic_table_init.js"></script>
<script>

    $(".date_picker_from_class").change(function () {
        var from_date = $(".date_picker_from_class").val();
        var split_date = from_date.split("-");
        var to_date = parseInt(split_date[0]) + 1 + "-" + split_date[1];
        $(".date_picker_to_class").val(to_date);

        $('.date_picker_to_class').monthpicker('destroy');
        $('.date_picker_to_class').monthpicker({
            pattern: 'yyyy-mm',
            selectedYear: parseInt(split_date[0]) + 1,
            startYear: parseInt(split_date[0]),
            finalYear: <?php echo date('Y') + 10; ?>
        });
    });


    $('#demo-2').monthpicker({
        pattern: 'yyyy-mm',
        selectedYear: '<?php echo date('Y'); ?>',
        startYear: 2012,
        finalYear: <?php echo date('Y') + 10; ?>, });
    /* var options = {
     selectedYear: 2020,
     startYear: 2012,
     finalYear: <?php echo date('Y') + 10; ?>,
     openOnFocus: false
     };  */
    $('#monthtodate').monthpicker({
        pattern: 'yyyy-mm',
        selectedYear: '<?php echo date('Y'); ?>',
        startYear: 2012,
        finalYear: <?php echo date('Y') + 10; ?>, });
    /*
     var options = {
     selectedYear: '<?php echo date('Y'); ?>',
     startYear: 2012,
     finalYear: <?php echo date('Y') + 10; ?>,
     openOnFocus: false
     };  */
    $('#monthfromdate').monthpicker({
        pattern: 'yyyy-mm',
        selectedYear: '<?php echo date('Y'); ?>',
        startYear: 2012,
        finalYear: <?php echo date('Y') + 10; ?>, });
    /*
     var options = {
     selectedYear: '<?php echo date('Y'); ?>',
     startYear: 2012,
     finalYear: <?php echo date('Y') + 10; ?>,
     openOnFocus: false
     }; */
    $('#monthfromdatetwo').monthpicker({
        pattern: 'yyyy-mm',
        selectedYear: '<?php echo date('Y'); ?>',
        startYear: 2012,
        finalYear: <?php echo date('Y') + 10; ?>, });
    /*    
     var options = {
     selectedYear: '<?php echo date('Y'); ?>',
     startYear: 2012,
     finalYear: <?php echo date('Y') + 10; ?>,
     openOnFocus: false
     };  */

    $('#advexpmonthfrom').monthpicker({
        pattern: 'yyyy-mm',
        selectedYear: '<?php echo date('Y'); ?>',
        startYear: 2012,
        finalYear: <?php echo date('Y') + 10; ?>, });
    /*
     var options = {
     selectedYear: '<?php echo date('Y'); ?>',
     startYear: 2012,
     finalYear: <?php echo date('Y') + 10; ?>,
     openOnFocus: false
     }; */
    $('#advexpmonthto').monthpicker({
        pattern: 'yyyy-mm',
        selectedYear: '<?php echo date('Y'); ?>',
        startYear: 2012,
        finalYear: <?php echo date('Y') + 10; ?>, });
    /*
     var options = {
     selectedYear: '<?php echo date('Y'); ?>',
     startYear: 2012,
     finalYear: <?php echo date('Y') + 10; ?>,
     openOnFocus: false
     }; */
    $('#fromdate').monthpicker({
        pattern: 'yyyy-mm',
        selectedYear: '<?php echo date('Y'); ?>',
        startYear: 2012,
        finalYear: <?php echo date('Y') + 10; ?>, });

    /*
     var options = {
     selectedYear: '<?php echo date('Y'); ?>',
     startYear: 2012,
     finalYear: <?php echo date('Y') + 10; ?>,
     openOnFocus: false
     };  */

</script>
<!-- ///Js For Month Piker ///-->


<!--footer start-->
<footer class="site-footer">
    <div class="text-center">A Product of  
        <a style="color: #E8E8E8; font-family: arial; font-size: 14px;" href="http://brac.net/" target="_blank"><?php //echo date("Y");                              ?> <b>BRAC MF Automation</b></a>, Developed by
        <a style="color: #E8E8E8; font-family: arial; font-size: 14px;" href="http://clouditbd.com/" target="_blank">Cloud IT Limited</a>
        <a href="#" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</footer>
<!--footer end-->

</section>
<script class="include" type="text/javascript" src="<?php echo $baseurl; ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.sparkline.js" type="text/javascript"></script>
<!--<script src="<?php echo $baseurl; ?>assets/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>-->
<script src="<?php echo $baseurl; ?>assets/js/owl.carousel.js" ></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.customSelect.min.js" ></script>
<script src="<?php echo $baseurl; ?>assets/js/respond.min.js" ></script>
<script src="<?php echo $baseurl; ?>assets/nestable/jquery.nestable.js" ></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/jquery.dataTables.js"></script>

<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/data-tables/DT_bootstrap.js"></script>

<!--script for this page-->

<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/jquery.datetimepicker.js"></script>

<!--common script for all pages | All includes some function by clicking menu hide and show option -->
<script src="<?php echo $baseurl; ?>assets/js/common-scripts.js"></script>

<!--gitter files -->
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/assets/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/gritter.js" ></script>
<!-- END JAVASCRIPTS -->

<!--script for nestable list page only-->
<script src="<?php echo $baseurl; ?>assets/js/nestable.js"></script>

<!-- Script for numeric value allowed only -->
<script src="<?php echo $baseurl; ?>assets/js/numeric/jquery.numeric.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/numeric/jquery.numeric.min.js"></script>

<script type="text/javascript">
    var today_date = "<?php echo date("Y-m-d"); ?>";
    var today_day = "<?php echo date("d"); ?>";
    var today_month = "<?php echo date("m"); ?>";
    var today_year = "<?php echo date("Y"); ?>";
    $('#data_import_date').datetimepicker({
        beforeShowDay: function (date) {
            if (date.getDate() == 31) {
                return [true, ''];
            } else if (date.getDate() == 30) {
                return [true, ''];
            } else if (date.getDate() == 29) {
                return [true, ''];
            } else if (date.getDate() == 28) {
                return [true, ''];
            } else {
                return [false, ''];
            }
        },
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        timepicker: false
    });
    $('#circular_date').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        timepicker: false
    });
    $('#csavisit_date').datetimepicker({
        beforeShowDay: function (date) {
            if (date.getDate() > today_day) {
                return [false, ''];
            }
            if (date.getMonth() > today_month) {
                return [false, ''];
            }
            if (date.getFullYear() > today_year) {
                return [false, ''];
            }
            return [true, ''];
        },
        format: 'Y-m-d',
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        timepicker: false
    });
    $('#csavisit_date2').datetimepicker({
        beforeShowDay: function (date) {
            if (date.getDate() > today_day) {
                return [false, ''];
            }
            if (date.getMonth() > today_month) {
                return [false, ''];
            }
            if (date.getFullYear() > today_year) {
                return [false, ''];
            }
            return [true, ''];
        },
        format: 'Y-m-d',
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        timepicker: false
    });
    $('#from_date').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        timepicker: false
    });
    $('#to_date').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        timepicker: false
    });
    $('#birthday_date').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        timepicker: false
    });
    $('#date_from').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        minDate: '2000-01-01',
        maxDate: today_date,
        timepicker: false
    });
    $('#date_to').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        minDate: '2000-01-01',
        maxDate: today_date,
        timepicker: false
    });
    $(document).ready(function () {
        $('#editable-sample').dataTable({
            "sPaginationType": "full_numbers"
        });
        $('.yearlydatatable').dataTable({
            "sPaginationType": "full_numbers",
            "zeroRecords": "No matching records found",
            "order": [[0, 'desc']],
            "lengthMenu": [
                [9, 18, 27, -1],
                [9, 18, 27, "All"] // change per page values here
            ]
        });
    });
    //Initially hide collapse nestable section
    $(document).ready(function () {
        $('.dd').nestable('collapseAll');
    });
    /**
     * Set idle timeout after 1 hour
     */
    var IDLE_TIMEOUT = 3600; //seconds
    var _idleSecondsCounter = 0;
    document.onclick = function () {
        _idleSecondsCounter = 0;
    };
    document.onmousemove = function () {
        _idleSecondsCounter = 0;
    };
    document.onkeypress = function () {
        _idleSecondsCounter = 0;
    };
    window.setInterval(CheckIdleTime, 1000);
    function CheckIdleTime() {
        _idleSecondsCounter++;
        //var oPanel = document.getElementById("SecondsUntilExpire");
        //if (oPanel)
        //  oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
        if (_idleSecondsCounter >= IDLE_TIMEOUT) {
            document.location.href = "<?= site_url('dashboard/logout'); ?>";
        }
    }
</script>

</body>
</html>