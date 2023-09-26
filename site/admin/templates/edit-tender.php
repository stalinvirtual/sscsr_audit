<?php 
namespace App\Controllers; 
use App\Helpers\Helpers;

Helpers::urlSecurityAudit();
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
                    <h1>Tender Creation Form</h1>
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

                            <h3 class="card-title"> Tender Creation Form </h3>

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

                        <form class="form-horizontal" method="post" name = "tender_form" id="tenderForm" enctype="multipart/form-data">

                            <div class="card-body">


                                <div class="form-group row">

                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Tender Name <span style='color:red'>*</span></label>

                                    <div class="col-sm-6">
                                        <textarea class="form-control exam_name" name="pdf_name" id="pdf_name" required maxlength="256" rows="5" placeholder="Enter only 256 characters"><?php echo @$current_tender['pdf_name']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="inputEmail3" class="col-sm-2 col-form-label"> Effect From Date  <span style='color:red'>*</span></label>

                                    <div class="col-sm-3">
									<?php
									
									if(@$current_tender['effect_from_date']==""){
										$effect_from_date = "";
									}
									else{
										$effect_from_date = date('d-m-Y', strtotime($current_tender['effect_from_date']));
									}
									if(@$current_tender['effect_to_date']==""){
										$effect_to_date = "";
									}
									else{
										$effect_to_date = date('d-m-Y', strtotime($current_tender['effect_to_date']));
									}
									
									?>

                                        <input class="form-control" type="text" name="effect_from_date" id="effect_from_date" value="<?php echo $effect_from_date; ?>" readonly>
									

                                    </div>

                                </div>
                                <div class="form-group row">

                                    <label for="inputEmail3" class="col-sm-2 col-form-label"> Effect To Date <span style='color:red'>*</span></label>

                                    <div class="col-sm-3">

                                        <input class="form-control" type="text" name="effect_to_date" id="effect_to_date" value="<?php echo $effect_to_date; ?>" readonly>
										

                                    </div>

                                </div>

                                <?php



                                //echo '<pre>';

                                // echo $nomination_id;
                                //print_r($current_nomination); 
                                ?>




                                <div class="form-group row">

                                    <label for="inputEmail3" class="col-sm-2 col-form-label"> Attachment  <span style='color:red'>*</span></label>

                                    <div class="col-sm-6">
                                        <input type="file" id="resume" name="attachment" class="form-control item_quantity" accept="application/pdf" value="<?php echo @$current_tender['attachment']; ?>" />
										 <input name="pdflink" value="<?= @$current_tender['attachment'] ?>" type="hidden"/>
										<p name="attachments"  /><?php echo @$current_tender['attachment']; ?></p>
										
										


                                    </div>

                                </div>

                                <input type="hidden" value="<?php echo $current_tender['tender_id']; ?>" name="id" class="sp_id">

                            </div>

                            <!-- /.card-body -->

                            <div class="card-footer">

                                <input type="submit" class="btn btn-info" name="save_tender" value="Submit" style="margin: 0px 0px 0px -160px;" id="save_tender">
                                <input type="button" class="btn btn-default float-right" onclick="history.back();" style="float: left !important; margin: 0px 0px 0px 310px;" value="Cancel">



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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

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
    $(document).ready(function() {
		
		$('#resume').on( 'change', function() {
   myfile= $( this ).val();
   var ext = myfile.split('.').pop();
   if(ext=="pdf"){
      return true;
   } else{
       swal("Accept Only PDF Files","","warning");
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
                alert(ext);
            } else {
                alert(ext);
            }
        });





    });
</script>