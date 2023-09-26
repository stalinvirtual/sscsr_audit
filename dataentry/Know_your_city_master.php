<!-- session -->
<?php
require_once("config/db.php");
session_start();
if (!isset($_SERVER['HTTP_REFERER']) || !isset($_SESSION['sess_user'])) {
    header("Location: login.php");
} else {
    ?>
    <!-- header -->
    <?php include('header.php'); ?>
    <div class="main-grid">






        <div class="panel panel-widget forms-panel">
            <div class="forms">
                <div class="inline-form widget-shadow">
                    <div class="form-title">
                        <div class="row">
                            <div class="col-md-9 form-group">
                                <h4> Publish Know Your City Master Status </h4>
                            </div>
                            <div class="col-md-2 form-group">
                                <!--<button class="btn w3ls-button hvr-icon-float-away col-24" data-toggle="modal" data-target="#addStudent"> Add Column</button>-->
                            </div>
                        </div>
                    </div>


                    <div class="form-body">
                        <div id="examdata">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<?php include('footer.php'); ?>











<script type="text/javascript">
    $(document).ready(function () {








        // load exam   
        $.ajax({
            url: "Load_kyc_master_details.php",
            method: "GET",
            success: function (data) {
                $('#examdata').html(data);
            }
        });



        /*  Check Username Availability with jQuery and AJAX  Start*/


        $("#column_name").keyup(function () {


            var column_name = $(this).val().trim();




            if (column_name != '') {


                $.ajax({
                    url: 'column_already_exists.php',
                    type: 'post',
                    data: {
                        column_name: column_name
                    },
                    dataType: "json",
                    success: function (response) {

                        if (response == "") {
                            $('#uname_response').html(response);
                        } else {
                            $('#uname_response').html(response);
                            $("#column_name").val('');
                        }


                        //$("#column_name").val('');


                    }
                });
            } else {
                $("#uname_response").html("");
            }


        });




        /*  Check Username Availability with jQuery and AJAX End*/
















    });
</script>