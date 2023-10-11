<?php
namespace App\Controllers;
use App\Helpers\Helpers;
echo $this->get_header();
if (!isset($_SESSION)) {
    session_start();
}
$csrfToken = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrfToken; ?>
<style>
    .ui-datepicker-trigger {
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
                    <h1>Announcements Creation Form</h1>
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
                            <h3 class="card-title"> Announcement Creation Form </h3>
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
                        <form class="form-horizontal" method="post" name="announcement_form" id="announcementForm" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Announcement Name <span style='color:red'>*</span></label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="announcement_name" id="announcement_name" required value="<?php echo @$current_announcement['announcement_name']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label"> Announcement Content <span style='color:red'>*</span></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" type="text" name="announcement_content" id="announcement_content" required><?php echo @$current_announcement['announcement_content']; ?>
      </textarea>
                                        <script src="<?php echo $this->theme_url; ?>/dist/js/jquery.min.js"></script>
                                        <script src="<?php echo $this->theme_url; ?>/dist/ckeditor/ckeditor.js" type="text/javascript"></script>
                                        <script type="text/javascript">
                                            CKEDITOR.replace('announcement_content', {
                                                filebrowserUploadUrl: '<?php echo $list_ckeditor_link_file; ?>',
                                                filebrowserImageUploadUrl: '<?php echo $list_ckeditor_link_image; ?>',
                                                filebrowserUploadMethod: 'form',
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label"> Effect From Date <span style='color:red'>*</span></label>
                                    <div class="col-sm-3">
                                        <?php
                                        if (@$current_announcement['effect_from_date'] == "") {
                                            $effect_from_date = "";
                                        } else {
                                            $effect_from_date = date('d-m-Y', strtotime($current_announcement['effect_from_date']));
                                        }
                                        if (@$current_announcement['effect_to_date'] == "") {
                                            $effect_to_date = "";
                                        } else {
                                            $effect_to_date = date('d-m-Y', strtotime($current_announcement['effect_to_date']));
                                        }
                                        ?>
                                        <input class="form-control" type="text" name="effect_from_date" id="effect_from_date" value="<?php echo @$effect_from_date; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label"> Effect To Date <span style='color:red'>*</span></label>
                                    <div class="col-sm-3">
                                        <input class="form-control" type="text" name="effect_to_date" id="effect_to_date" value="<?php echo @$effect_to_date; ?>" readonly>
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $current_announcement['announcement_id']; ?>" name="announcement_id">
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <input type="submit" class="btn btn-info save_btn" name="save_announcement" value="Submit" style="margin: 0px 0px 0px -160px;">
                                <input type="button" class="btn btn-default float-right" onclick="history.back();" value="Cancel" style="float: left !important; margin: 0px 0px 0px 310px;">
                            </div>
                            <!-- /.card-footer -->
                        </form>
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
<script src="<?php echo $this->theme_url; ?>/dist/js/jquery.validate.min.js" crossorigin="anonymous"></script>
<script src="<?php echo $this->theme_url; ?>/dist/js/sweetalert.min.js"></script>
<link href="<?php echo $this->theme_url; ?>/dist/css/jquery-ui.css" rel="stylesheet">
<script src="<?php echo $this->theme_url; ?>/dist/js/jquery-ui.js"></script>
<script>
    $(".save_btn").click(function () {
        $("#effect_to_date").datepicker("option", "disabled", false);
    });
    $(document).ready(function() {
        $('#announcementForm').validate({ // initialize the plugin
            ignore: [],
            rules: {
                announcement_name: {
                    required: true,
                    maxlength: 256,
                    restrictedChars: true 
                },
                announcement_content: {
                    required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement();
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                    return editorcontent.length === 0;
                    }
                },
                effect_from_date: "required",
                effect_to_date: {
                    required: true,
                    greaterAnnouncement: "#effect_from_date"
                },
            },
            // Specify validation error messages
            messages: {
                announcement_name: {
                    required: "Please Enter Announcement Name",
                    maxlength: "Your Announcement Name must be maximum 256 characters long",
                    restrictedChars: "Special characters are not allowed."
                },
                announcement_content: {
                    required: "Please Enter Announcement Content",
                    //maxlength: "Your Announcement Content must be maximum 256 characters long"
                },
                effect_from_date: "Please Enter  From Date",
                effect_to_date: {
                    required: "Please Enter To Date",
                    greaterAnnouncement: "Must be greater than From date"
                },
            },
            errorPlacement: function(error, element) {
                debugger;
                if (element.attr("name") === "effect_from_date") {
                    // Place the error message after the image tag
                    error.insertAfter(element.next("img.ui-datepicker-trigger"));
                } else if (element.attr("name") === "effect_to_date") {
                    // Place the error message after the Select2 element
                    error.insertAfter(element.next("img.ui-datepicker-trigger"));
                } else if (element.attr("id") === "announcement_content") {
                    debugger;
                    error.insertAfter("#cke_announcement_content");
                } else {
                    // Use the default error placement for other fields
                    error.insertAfter(element);
                }
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                form.submit();
            }
        });
        jQuery.validator.addMethod("greaterAnnouncement", function(value, element, params) {
            var startDate = document.getElementById("effect_from_date").value;
            var startDate = startDate.split("-").reverse().join("-");
            var endDate = document.getElementById("effect_to_date").value;
            var endDate = endDate.split("-").reverse().join("-");
            var startDateParseData = Date.parse(startDate);
            var endDateParseData = Date.parse(endDate);
            return this.optional(element) || endDateParseData >= startDateParseData;
        }, 'Must be greater than start date.');
        $("#announcementForm").on("submit", function() {});
        $.validator.addMethod("restrictedChars", function (value, element) {
    // Define the restricted characters
    var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
    return !restrictedChars.test(value);
  }, "Special characters are not allowed.");
    });
    $.datepicker.setDefaults({
        showOn: "button",
        buttonImage: "<?php echo $this->theme_url; ?>/dist/img/datepicker.png",
        buttonText: "Date Picker",
        buttonImageOnly: true,
        dateFormat: 'dd-mm-yy'
    });
    $(function() {
        $("#effect_from_date").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '2020:+0',
            minDate: 0
        });
        $("#effect_to_date").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '2020:2025',
            minDate: 0,
            disabled:true
        });
    });
    $("#effect_from_date").on("change", function() {
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
</script>