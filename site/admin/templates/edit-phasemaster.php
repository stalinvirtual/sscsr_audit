<?php
namespace App\Controllers;
use App\Helpers\Helpers;
Helpers::urlSecurityAudit();
echo $this->get_header();
if (!isset($_SESSION)) {
    session_start();
  }
  $csrfToken = bin2hex(random_bytes(32));
  $_SESSION['csrf_token'] = $csrfToken; ?>
<style>
.ui-datepicker-trigger{
margin: -27px 2px 3px 286px;
    width: 20px;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Phase Creation Form</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content   section div start -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <!-- /.card -->
                    <!-- Horizontal Form -->
                    <div class="card card-info" style="width:75%">
                        <div class="card-header">
                            <h3 class="card-title"> Phase Creation Forms </h3>
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
                        <form class="form-horizontal" method="post" id="phase_master_form" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Phase Name  <span style='color:red'>*</span></label>
                                    <div class="col-sm-6">
                                        <textarea required class="form-control exam_name" name="phase_name" id="phase_name"  rows="2" placeholder="Enter only 256 characters"><?php echo @$current_phasemaster['phase_name']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label"> Effect From Date <span style='color:red'>*</span></label>
                                    <div class="col-sm-3">
                                        <?php
                                        if (@$current_phasemaster['creation_date'] == "") {
                                            $creation_date = "";
                                        } else {
                                            $creation_date = date('d-m-Y', strtotime($current_phasemaster['creation_date']));
                                        }
                                        ?>
                                        <input class="form-control" type="text" name="creation_date" id="creation_date" value="<?php echo $creation_date; ?>" readonly>
                                    </div>
                                </div>
                                <?php
                                //echo '<pre>';
                                // echo $nomination_id;
                                //print_r($current_nomination); 
                                ?>
                                <input type="hidden" value="<?php echo @$current_phasemaster['phase_id']; ?>" name="id" class="phase_id">
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <input type="submit" class="btn btn-info" name="save_phase_master" value="Submit" style="margin: 0px 0px 0px -160px;" id="save_phase_master">
                                <input type="button" class="btn btn-default float-right" onclick="history.back();" value="Cancel" style="float: left !important; margin: 0px 0px 0px 310px;">
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
    </section>
    <!-- Main content section div end -->
</div>
<?php echo $this->get_footer(); ?>
<script src="<?php echo $this->theme_url; ?>/dist/js/jquery.validate.min.js"
        crossorigin="anonymous"></script>
    <script src="<?php echo $this->theme_url; ?>/dist/js/sweetalert.min.js"></script>
    <link href="<?php echo $this->theme_url; ?>/dist/css/jquery-ui.css" rel="stylesheet">
    <script src="<?php echo $this->theme_url; ?>/dist/js/jquery-ui.js"></script>
<script>
//     const usernameInput = document.getElementById('phase_name');
//   const submitButton = document.getElementById('save_phase_master');
//   submitButton.addEventListener('click', function() {
//     debugger;
//     if (!usernameInput.checkValidity()) {
//       usernameInput.setCustomValidity('Please provide a Phase name.'); // Set a custom validation message
//     } else {
//       usernameInput.setCustomValidity('');
//     }
//   });
    $.datepicker.setDefaults({
        showOn: "button",
        buttonImage: "<?php echo $this->theme_url; ?>/dist/img/datepicker.png",
        buttonText: "Date Picker",
        buttonImageOnly: true,
        dateFormat: 'dd-mm-yy'
    });
    $(function() {
        $("#creation_date").datepicker({
            changeMonth: true, 
            changeYear: true, 
            yearRange: '2020:+0',
            minDate: 0,
        });
    });
    $(document).ready(function() {
        $('#resume').on('change', function() {
            myfile = $(this).val();
            var ext = myfile.split('.').pop();
            if (ext == "pdf") {
                return true;
            } else {
                swal("Accept Only PDF Files", "", "warning");
                $('#resume').val('');
                return;
            }
        });
        var myfile = "";
        // $('#save-namination').click(function(e) {
        //     e.preventDefault();
        //     //$('.pdfclassupload').trigger('click');
        //     var exam_name = $('.exam_name').val();
        //     if (exam_name == "") {
        //         swal('Please Enter Exam Name');
        //         return false;
        //     }
        //     if (exam_name.length <= 256) {} else {
        //         swal('Please Enter Below 256 Characters');
        //         return false;
        //     }
        //     // return true;
        //     $("#nomination_form").submit();
        // });
        $(document).on('click', '.add', function() {
            var html = '';
            html += '<tr>';
            html += '<td><input type="text" name="pdf_name[]" class="form-control item_name" /></td>';
            html += '<td><input type="file" name="pdf_file[]" class="form-control item_quantity pdfclassupload" accept="application/pdf" /></td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
            $('#item_table').append(html);
        });
        $(document).on('click', '.remove', function() {
            //debugger;
            var pdfname = $(this).closest('tr').find('#pdfname').val();
            var pdf_id = $(this).closest('tr').find('#pdf_id').val();
            if (pdfname != "") {
                var sp_id = $('.sp_id').val();
                var baseurl = '<?php echo $this->route->site_url("Admin/ajaxresponseforselectionpostsforremovingfileupload"); ?>';
                jQuery.ajax({
                    url: baseurl,
                    data: {
                        sp_id: sp_id,
                        pdf_id: pdf_id
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(response) {
                        if (response.message == 1) {
                            //alert("Welcome")
                            window.location.href = redirecturl;
                        }
                    }
                });
            }
            // alert(pdfname);
            $(this).closest('tr').remove();
        });
        $('.pdfclassupload').on('change', function() {
            myfile = $(this).val();
            var ext = myfile.split('.').pop();
            if (ext == "pdf") {
               // alert(ext);
            } else {
               // alert(ext);
            }
        });
    });
</script>