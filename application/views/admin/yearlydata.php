<link href="<?php echo $baseurl; ?>assets/css/yearlydata.css" rel="stylesheet"/>
<section id="main-content">
    <section class="wrapper site-min-height">
        <section class="panel">
            <header class="panel-heading">
                Yearly Data
            </header>
            <div class="panel-body ">
                <div class="panel-body">
                    <?php
                    if ($this->session->userdata('successfull')):
                        echo '<div class="alert alert-success fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><strong>Success Message !!! </strong> ' . $this->session->userdata('successfull') . '</div>';
                        $this->session->unset_userdata('successfull');
                    endif;
                    if ($this->session->userdata('failed')):
                        echo '<div class="alert alert-block alert-danger fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><strong>Failed Meaasge !!! </strong> ' . $this->session->userdata('failed') . '</div>';
                        $this->session->unset_userdata('failed');
                    endif;
                    ?>
                <div class="col-md-10 col-md-offset-1 paddingBody">
                    <form class="tasi-form" method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/yearlydata/getaction'); ?>">
                    <div class="col-lg-3 marginTop">
                        <label><b>Program Name:</b></label>
                        <select id="program_name" name="programId" class="form-control btn btn-primary" required="">
                            <option value="">--Select--</option>
                            <?php
                            if (sizeof($programlist) > 0):
                                foreach ($programlist as $data): ?>
                                    <option value="<?php echo $data->program_id; ?>"><?php echo $data->program_name; ?></option>
                                    <?php endforeach; endif;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 marginTop">
                            <label><b>Division Name:</b></label>
                            <select id="division_id" name="divisionList[]" class="multiselect-ui form-control"
                                    multiple="multiple" >
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-5 marginTop">
                            <div class="col-lg-6">
                                <label><b>Year From:</b></label>
                                <select id="year_from" name="year_from" class="form-control btn btn-primary">
                                    <option value="">--Select--</option>
                                    <?php
                                    if (sizeof($yearList) > 0):
                                        foreach ($yearList as $data): ?>
                                            <option value="<?php echo $data->year; ?>"><?php echo $data->year; ?></option>
                                        <?php endforeach;endif; ?>
                                </select>
                            </div>
                            <div class="col-lg-6 ">
                                <label><b>Year To:</b></label>
                                <select id="year_to" name="year_to" class="form-control btn btn-primary">
                                    <option>--Select--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 marginTop">
                        <label for="program" class="control-label marginTop" >
                            <button class="form-control btn btn-info" id="submit" type="submit">Submit</button>
                        </label>
                    </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
    <script type="text/javascript">
        $('select#program_name').change(function () {

            var program = $(this).val();
            $.ajax({
                type: 'GET',
                url: "<?php echo site_url('admin/yearlydata/getdivision'); ?>",
                dataType: 'json',
                data: {
                    program: program
                },
                cache: false,
                success: function (response) {
                    $('.multiselect-ui').multiselect('destroy');

                    $("select[name='divisionList[]'] option")
                        .remove();
                    $.each(response, function (key, value) {
                        $('select#division_id')
                            .append($("<option></option>")
                                .attr("value", value.division_id)
                                .text(value.division_name));
                    });

                    $(function () {
                        $('.multiselect-ui').multiselect({
                            includeSelectAllOption: true
                        });
                    });
                }
            });
        });

        $('select#year_from').change(function () {

            var date = $(this).val();

            $.ajax({
                type: 'GET',
                url: "<?php echo site_url('admin/yearlydata/getyear'); ?>",
                dataType: 'json',
                data: {
                    date: date
                },
                cache: false,
                success: function (response) {
                    $("select[name='year_to'] option")
                        .remove();
                    $.each(response, function (key, value) {
                        $('select#year_to')
                            .append($("<option></option>")
                                .attr("value", value.year)
                                .text(value.year));
                    });
                }
            });
        });
    </script>
    <script src="<?php echo $baseurl; ?>assets/js/yearlydata.js"></script>
    <script>
        $(function () {
            $('.multiselect-ui').multiselect({
                includeSelectAllOption: true
            });
        });

    </script>
</section>


