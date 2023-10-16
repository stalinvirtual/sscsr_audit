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
                    <h1>Search Year Creation</h1>
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
                            <h3 class="card-title">Search Year Creation </h3>
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
                        <form class="form-horizontal" method="post" id="searchyear_form" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Search Year  <span style='color:red'>*</span></label>
                                    <div class="col-sm-5">
                                        <!-- <input type="text" required class="form-control" name="search_year" id="search_year"  value="<?php echo @$current_searchyear['search_year']; ?>" readonly> -->
                                    

                                    <div class="year-picker">
    <input type="text"  placeholder="Select year"  required class="form-control" name="search_year" id="search_year"  value="<?php echo @$current_searchyear['search_year']; ?>" >
    <div class="year-dropdown"></div>
  </div></div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label"> Effect From Date <span style='color:red'>*</span></label>
                                    <div class="col-sm-3">
                                        <?php
                                        if (@$current_searchyear['creation_date'] == "") {
                                            $creation_date = "";
                                        } else {
                                            $creation_date = date('d-m-Y', strtotime($current_searchyear['creation_date']));
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
                                <input type="hidden" value="<?php echo @$current_searchyear['searchyear_id']; ?>" name="searchyear_id" class="searchyear_id">
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <input type="submit" class="btn btn-info" name="save_searchyear" value="Submit" style="margin: 0px 0px 0px -160px;" id="save_searchyear">
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
  <style>
     .year-picker {
      position: relative;
      display: inline-block;
      min-width: 285px;
    }

    .year-dropdown {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 250px;
      max-height: 150px; /* Set a maximum height for scrolling */
      overflow-y: auto; /* Enable vertical scrolling */
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      padding: 12px 16px;
      z-index: 1;
      cursor: pointer;
    }

    .year-option {
      padding: 8px 0;
      min-width: 250px;
    }
  </style>
  <script>
    $(document).ready(function() {
      // Generate a list of years (current year to 100 years into the future)
      var currentYear = new Date().getFullYear();
      for (var i = currentYear; i <= currentYear + 50; i++) {
        $('.year-dropdown').append('<div class="year-option">' + i + '</div>');
      }

      // Show the year dropdown when clicking on the year picker
      $('.year-picker').on('click', function(event) {
        event.stopPropagation();
        $('.year-dropdown').toggle();
      });

      // Set the selected year when a year is clicked
      $('.year-option').on('click', function() {
        var selectedYear = $(this).text();
        $('.year-picker input').val(selectedYear);
        $('.year-dropdown').hide();
      });

      // Close the year dropdown when clicking outside of it
      $(document).on('click', function() {
        $('.year-dropdown').hide();
      });

      $('#searchyear_form').validate({
        rules: {
            search_year: {
                required: true
            },
            creation_date: {
                required: true
            }
        },
        messages: {
            search_year: {
                required: "Please select a year"
            },
            creation_date: {
                required: "Please select an effect from date"
            }
        },errorPlacement: function(error, element) {
    if (element.attr("name") === "creation_date") {
// Place the error message after the image tag
error.insertAfter(element.next("img.ui-datepicker-trigger"));
} else {
// Use the default error placement for other fields
error.insertAfter(element);
}
},
    });
    });
  </script>
<script src="<?php echo $this->theme_url; ?>/dist/js/jquery.validate.min.js"
        crossorigin="anonymous"></script>
    <script src="<?php echo $this->theme_url; ?>/dist/js/sweetalert.min.js"></script>
    <link href="<?php echo $this->theme_url; ?>/dist/css/jquery-ui.css" rel="stylesheet">
    <script src="<?php echo $this->theme_url; ?>/dist/js/jquery-ui.js"></script>

<script>

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