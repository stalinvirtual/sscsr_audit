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
<!-- Content Wrapper. Contains page content -->

<style>
    .ui-datepicker-trigger {
        margin: -27px 2px 3px 286px;
        width: 20px;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nomination Creation Form</h1>
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
                    <div class="card card-info" style="width: 75%;">
                        <div class="card-header">
                            <h3 class="card-title">Nomination creation Form</h3>
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
                        <form class="form-horizontal" name="nomination_form" method="post" id="nomination_form"
                            enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Category <span
                                            style='color:red'>*</span></label>
                                    <div class="col-sm-6">
                                        <select name="category_id" class="form-control">
                                            <?php foreach ($categories as $key => $category):
                                                $selected = "";
                                                if ($current_nomination['category_id'] == $category->category_id) {
                                                    $selected = "selected=\"selected\"";
                                                }
                                                ?>
                                                <option <?php echo $selected; ?>
                                                    value="<?php echo $category->category_id; ?>">
                                                    <?php echo $category->category_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name of the Examination
                                        <span style='color:red'>*</span></label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control exam_name" name="exam_name" rows="5"
                                            placeholder="Enter only 256 characters"
                                            id='exam_name' required><?php echo $current_nomination['exam_name']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Effect From Date<span
                                            style='color:red'>*</span></label>
                                    <div class="col-sm-3">
                                        <?php
                                        if (@$current_nomination['effect_from_date'] == "") {
                                            $effort_from_date = "";
                                        } else {
                                            $effort_from_date = date('d-m-Y', strtotime($current_nomination['effect_from_date']));
                                        }
                                        ?>
                                        <input class="form-control" type="text" name="effect_from_date"
                                            id="effect_from_date" value="<?php echo $effort_from_date; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Effect To Date <span
                                            style='color:red'>*</span></label>
                                    <div class="col-sm-3">
                                        <?php
                                        if (@$current_nomination['effect_to_date'] == "") {
                                            $effect_to_date = "";
                                        } else {
                                            $effect_to_date = date('d-m-Y', strtotime($current_nomination['effect_to_date']));
                                        }
                                        ?>
                                        <input class="form-control" type="text" name="effect_to_date"
                                            id="effect_to_date" value="<?php echo $effect_to_date; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label"> Attachment <span
                                            style='color:red'>*</span></label>
                                    <div class="col-sm-6">
                                        <table class="table table-bordered" id="item_table">
                                            <tr>
                                                <th style="text-align: center">Enter Pdf Name</th>
                                                <th style="text-align: center">Enter Pdf </th>
                                                <th style="text-align: center"><button type="button" name="add"
                                                        class="btn btn-success btn-sm add"><i class="fa fa-plus"
                                                            aria-hidden="true"></i></button></th>
                                            </tr>
                                            <?php
                                            if ($nomination_id == 0) {
                                                ?>
                                                <tr>
                                                    <td><input type="text" name="pdf_name[]" class="form-control item_name"
                                                            id="pdfname" value="" />
                                                        <input type="hidden" id="pdf_id" name="nomination_child_id[]"
                                                            class="form-control item_name" value="" />
                                                    </td>
                                                    <td><input type="file" name="pdf_file[]"
                                                            class="form-control item_quantity pdfnomination"
                                                            accept="application/pdf" value="" />
                                                        <!-- <input type="text" name="pdf_files[]"
                                                                    class="form-control item_quantity"
                                                                    value="" /> -->
                                                        <!-- <p><?php //echo $childlist->attachment; 
                                                            ?></p> -->
                                                    </td>
                                                    <td><button type="button" name="remove"
                                                            class="btn btn-danger btn-sm remove"><i class="fa fa-minus"
                                                                aria-hidden="true"></i></button></td>
                                                    <br>
                                                </tr>
                                                <?php
                                            } else {
                                                foreach ($nominationchildlist as $key => $childlist):
                                                    $selected = "";
                                                    if ($current_nomination['nomination_id'] == $childlist->nomination_id) {
                                                        $selected = "selected=\"selected\"";
                                                        $uploadPath = 'nominations' . '/' . $childlist->attachment;
                                                        $file_location = $this->route->get_base_url() . "/" . $uploadPath; ?>
                                                        <tr>
                                                            <td><input type="text" name="pdf_name[]" class="form-control item_name"
                                                                    id="pdfname" value="<?php echo $childlist->pdf_name; ?>" />
                                                                <input type="hidden" id="pdf_id" name="nomination_child_id[]"
                                                                    class="form-control item_name"
                                                                    value="<?php echo $childlist->nomination_child_id; ?>" />
                                                            </td>
                                                            <td><input type="file" name="pdf_file[]"
                                                                    class="form-control item_quantity pdfnomination"
                                                                    accept="application/pdf"
                                                                    value="<?php echo $childlist->attachment; ?>" />
                                                                <input type="text" name="pdf_files[]"
                                                                    class="form-control item_quantity"
                                                                    value="<?php echo $childlist->attachment; ?>" />
                                                                    <input type="hidden" name="old_pdf_files[]"
                                                                    class="form-control item_quantity"
                                                                    value="<?php echo $childlist->attachment; ?>" />
                                                                <!-- <p><?php //echo $childlist->attachment; 
                                                                            ?></p> -->
                                                            </td>
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-sm remove"><i class="fa fa-minus"
                                                                        aria-hidden="true"></i></button></td>
                                                            <br>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                <?php endforeach; ?>
                                                <?php
                                                // echo '<tr>';
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $current_nomination['nomination_id']; ?>"
                                    name="id" id="txt_userid">
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <input type="submit" class="btn btn-info save_btn" name="save-nomination" value="Submit"
                                    style="margin: 0px 0px 0px -160px;" id="save-namination">
                                <input type="button" class="btn btn-default float-right" onclick="history.back();"
                                    style="float: left !important; margin: 0px 0px 0px 310px;" value="Cancel">
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
<script src="dist/js/jquery.validate.min.js" crossorigin="anonymous"></script>
<script src="dist/js/sweetalert.min.js"></script>
<link href="dist/css/jquery-ui.css" rel="stylesheet">
<script src="dist/js/jquery-ui.js"></script>
<script>
    $(".save_btn").click(function () {
        $("#effect_to_date").datepicker("option", "disabled", false);
    });
    $.datepicker.setDefaults({
        showOn: "button",
        buttonImage: "<?php echo $this->theme_url; ?>/dist/img/datepicker.png",
        buttonText: "Date Picker",
        buttonImageOnly: true,
        dateFormat: 'dd-mm-yy'
    });
    $(function () {
        $("#effect_from_date").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '2020:+0',
            minDate: 0,

        });
    });
    $.datepicker.setDefaults({
        showOn: "button",
        buttonImage: "<?php echo $this->theme_url; ?>/dist/img/datepicker.png",
        buttonText: "Date Picker",
        buttonImageOnly: true,
        dateFormat: 'dd-mm-yy'
    });
    $(function () {
        $("#effect_to_date").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '2020:2025',
            minDate: 0,
            disabled: true
        });
    });
    $("#effect_from_date").on("change", function () {
        var fromDateValue = $("#effect_from_date").datepicker("getDate");
        if (fromDateValue) {
            // If a date is selected in the "From Date" datepicker, enable the "To Date" datepicker
            $("#effect_to_date").datepicker("option", "disabled", false);
            // Set the minimum date for the "To Date" datepicker to the selected date in "From Date"
            $("#effect_to_date").datepicker("option", "minDate", fromDateValue);
        } else {
            // If no date is selected in "From Date," disable and reset the "To Date" datepicker
            $("#effect_to_date").datepicker("option", "disabled", true);
            $("#effect_to_date").datepicker("setDate", null);
        }
    });
    $(document).ready(function () {
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
        $('.pdfnomination').on('change', function () {
       // debugger;
        var fileInput = this;
        var myfile = fileInput.files[0];

        if (myfile) {
            var reader = new FileReader();
            reader.onloadend = function (e) {
                var arr = (new Uint8Array(e.target.result)).subarray(0, 4);
                var header = "";
                for (var i = 0; i < arr.length; i++) {
                    header += arr[i].toString(16);
                }

                // Check the PDF file header
                if (header.toUpperCase() === "25504446") {
                    // PDF file header matches
                    return true;
                } else {
                    swal("Invalid PDF File", "", "warning");
                    fileInput.value = ''; // Clear the file input
                    return false;
                }
            };
            reader.readAsArrayBuffer(myfile);
        }
    });
        $(document).on('click', '.add', function () {
    let dynamicCount = 1;
    var html = '';
    html += '<tr>';
    html += '<td><input type="text" name="pdf_name[]" class="form-control item_name pdf_name" id="pdf_name"   value="" /></td>';
    html += '<td><input type="file" name="pdf_file[]" class="form-control item_quantity pdfnomination" accept="application/pdf"   /></td>';
    html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fa fa-minus" aria-hidden="true"></i></button></td></tr>';
    $('#item_table').append(html);

    // dynamicCount ++;
    $('.pdfnomination').on('change', function () {
        //debugger;
        var fileInput = this;
        var myfile = fileInput.files[0];

        if (myfile) {
            var reader = new FileReader();
            reader.onloadend = function (e) {
                var arr = (new Uint8Array(e.target.result)).subarray(0, 4);
                var header = "";
                for (var i = 0; i < arr.length; i++) {
                    header += arr[i].toString(16);
                }

                // Check the PDF file header
                if (header.toUpperCase() === "25504446") {
                    // PDF file header matches
                    return true;
                } else {
                    swal("Invalid PDF File", "", "warning");
                    fileInput.value = ''; // Clear the file input
                    return false;
                }
            };
            reader.readAsArrayBuffer(myfile);
        }
    });
});

        $(document).on('click', '.remove', function () {
            //debugger;
            var pdfname = $(this).closest('tr').find('#pdfname').val();
            var pdf_id = $(this).closest('tr').find('#pdf_id').val();
            if (pdfname != "") {
                var nomination_id_class = $('.nomination_id_class').val();
                var baseurl = '<?php echo $this->route->site_url("Admin/ajaxresponseforfileupload"); ?>';
                jQuery.ajax({
                    url: baseurl,
                    data: {
                        nomination_id: nomination_id_class,
                        pdf_id: pdf_id
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function (response) {
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
    });
</script>