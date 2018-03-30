<section id="main-content">
    <section class="wrapper">          
        <div class="row">

            <?php if (sizeof($branchwisedata)): ?>
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Branch Wise Achievement Till Month: <?= $max_month ?>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <table  class="display table table-bordered table-striped" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>Branch Name </th>
                                            <th>Branch Code </th>
                                            <th colspan="2">Current Borrower</th>
                                            <th colspan="2">Current Borrower(Growth)</th>
                                            <th colspan="2">Current to Late</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Target</th>
                                            <th>Position</th>
                                            <th>Target</th>
                                            <th>Position</th>
                                            <th>Target</th>
                                            <th>Position</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($branchwisedata as $datarow): ?>
                                            <tr>
                                                <td> <?= $datarow->branch_name; ?> </td>
                                                <td> <?= $datarow->branch_id; ?> </td>
                                                <td> <?= $datarow->cb_target; ?> </td>
                                                <td> <?= $datarow->cb_mlast; ?> </td>
                                                <td> <?= $datarow->cbgrowth_target; ?> </td>
                                                <td> <?= $datarow->cb_lastgrowth; ?> </td>
                                                <td> <?= $datarow->c2l_target; ?> </td>
                                                <td> <?= $datarow->c2late_percentage; ?> </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>                              
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            <?php endif; ?>


        </div>
    </section>
</section>


<style type="text/css">
    #data-table thead tr th, #data-table tbody tr td {
        text-align: center;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        var oTable = $('#data-table').dataTable({
            "order": [],
            "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }],
            //"bFilter": false
        });
    });
</script>
