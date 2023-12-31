<?php
namespace App\Controllers;
use App\Helpers\Helpers;
Helpers::urlSecurityAudit();
echo $this->get_header(); ?>
<div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Selection Post  Archives By Month</h1>
                </div><!-- /.col -->
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <!-- /.card -->
            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Selection Post  Archives By Month </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <?php if (isset($errorMsg) && !empty($errorMsg)) {
                    echo '<div class="alert alert-danger errormsg">';
                    echo $errorMsg;
                    echo '</div>';
                    //unset($errorMsg);
                }
                ?>
                <form class="form-horizontal" method="post" id="sp_arc_form" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Year : <span style='color:red'>*</span></label>
                            <div class="col-sm-10">
                                <select name="sp_year" class="form-control" id="sp_year">
                                    <?php for ($i = 0; $i <= 5; $i++) {
                                        $year = date('Y', strtotime("last day of +$i year"));
                                        echo "<option name='$year'>$year</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Month : <span style='color:red'>*</span></label>
                            <div class="col-sm-10">
                                <select name="sp_month" class="form-control" id="sp_month">
                                    <option value="All">All</option>
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        $month = date('F', strtotime("$i/12/10"));
                                        if (strlen($i) == 1) {
                                            $value = "0" . $i;
                                        } else {
                                            $value = $i;
                                        }
                                        echo "<option value=$value>$month</option> ";
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <!-- <input type="submit" class="btn btn-info" name="save_na" value="submit" id="nomination_arc"> -->
                        <!-- <input type="button" class="btn btn-default float-right" onclick="history.back();" value="Cancel"> -->
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
                <!-- <button class="btn btn-default float-right" onclick="goBack()">Cancel</button> -->
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <table id="example" class="table table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Exam Name</th>
                <th>Category Name</th>
                <th>Date Archived</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Exam Name</th>
                <th>Category Name</th>
                <th>Date Archived</th>
            </tr>
        </tfoot>
    </table>
    <?php echo $this->get_footer(); ?>
    <script src="js/jquery.validate.min.js" crossorigin="anonymous"></script>
<script src="js/sweetalert.min.js"></script>
<link href="css/jquery-ui.css" rel="stylesheet">
<script src="js/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $("#sp_arc_form").submit(function(event) {
                event.preventDefault();
                $('#example').dataTable().fnDestroy();
     var baseurl = '<?php echo $this->route->site_url("Admin/ajaxresponseforSelectionPostarchievesByMonth"); ?>';
                var formData = {
                    sp_year: $("#sp_year option:selected").text(),
                    sp_month: $("#sp_month option:selected").val(),
                };
               // dbshow(formData);
                var table = $('#example').DataTable({
                    "ajax": {
                        'type': 'POST',
                        'url': baseurl,
                        data: formData,
                    },
                    'columnDefs': [{
                        'targets': 0,
                        'checkboxes': true
                    }],
                    'order': [
                        [2, 'desc']
                    ],
                    "lengthMenu": [
                 [5, 10, 25, 50, -1],
                 [5, 10, 25, 50, "All"]
             ],
			//fixedColumns: true,
             'responsive': true
                });
                table.clear().draw();
            });
        });
    </script>