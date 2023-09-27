<?php
namespace App\Controllers;
use App\Helpers\Helpers;
echo $this->get_header(); ?>
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
        <form class="form-horizontal" method="post" name = "announcement_form" id="announcementForm" enctype="multipart/form-data">
<div class="card-body">
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Announcement Name  <span style='color:red'>*</span></label>
    <div class="col-sm-10">
      <input class="form-control" type="text" name="announcement_name" id="announcement_name" required value="<?php echo @$current_announcement['announcement_name']; ?>">
    </div>
  </div>
 
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label"> Announcement Content  <span style='color:red'>*</span></label>
    <div class="col-sm-10">
      <textarea class="form-control" type="text" name="announcement_content" id="announcement_content" required><?php echo @$current_announcement['announcement_content']; ?>
      </textarea>
      <script src="dist/js/jquery.min.js"></script>
<script src="dist/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script  type="text/javascript">
        CKEDITOR.replace('announcement_content', {
            filebrowserUploadUrl:'<?php echo $list_ckeditor_link_file; ?>',
filebrowserImageUploadUrl: '<?php echo $list_ckeditor_link_image; ?>',
filebrowserUploadMethod: 'form',
        });
    </script>

    </div>
  </div>
  <div class="form-group row">
<label for="inputEmail3" class="col-sm-2 col-form-label"> Effect From Date  <span style='color:red'>*</span></label>
<div class="col-sm-3">
<?php
if(@$current_announcement['effect_from_date']==""){
    $effect_from_date = "";
}
else{
    $effect_from_date = date('d-m-Y', strtotime($current_announcement['effect_from_date']));
}
if(@$current_announcement['effect_to_date']==""){
    $effect_to_date = "";
}
else{
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
  <input type="submit" class="btn btn-info" name="save_announcement" value="Submit"  style="margin: 0px 0px 0px -160px;">
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

<script src="dist/js/jquery.validate.min.js" crossorigin="anonymous"></script>
<script src="dist/js/sweetalert.min.js"></script>
<link href="dist/css/jquery-ui.css" rel="stylesheet">
<script src="dist/js/jquery-ui.js"></script>

<script>
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
 }
 );
$("#effect_to_date").datepicker({
    changeMonth: true, 
    changeYear: true, 
    yearRange: '2020:2025',
    minDate: 0
 }
);
});
</script>