<style>
  .form-control{
        width:90% !important;
    }
    .ui-datepicker-trigger{
        margin: -25px 2px 3px 245px;
    }
    </style>
<div class="container-fluid">
    <!-- Container Start-->
    <div class="row">
        <div class="col-12">
            <form class="form-horizontal" method="post" id="dlist_arc_form" enctype="multipart/form-data">
                <div class="container">
                    <div class="form-group row">
                        <!-- Form Group Row Start-->
                        <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Year : </label>
                            <select name="dlist_year" class="form-control" id="dlist_year">
                            <?php foreach ($searchyears as $key => $searchyear) :
                                            
                                            ?>
                                                <option  value="<?php echo $searchyear->searchyear_id; ?>"><?php echo $searchyear->search_year; ?></option>
                                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Month : </label>
                            <select name="dlist_month" class="form-control" id="dlist_month">
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
                    </div><!-- Form Group Row End-->
                    <div class="form-group row " id="dlist_from_and_to_date_container" style="display: none;">
                        <!-- Form Group Row Start-->
                        <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">From Date : </label>
                            <input class="form-control" type="text" name="effect_from_date" id="effect_from_date" value="" readonly>
                        </div>
                        <div class="col-sm-3">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">To Date :</label>
                            <input class="form-control" type="text" name="effect_to_date" id="effect_to_date" value="" readonly>
                        </div>
                    </div><!-- Form Group Row End-->
                    <div class="form-group row">
                        <!-- Form Group Row Start-->
                        <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="button" id="dlist_form_submit_btn" class="btn btn-success form_submit_btn">Submit</button>
                            <button type="button" id="dlist_form_reset_btn" class="btn btn-secondary form_reset_btn">Reset</button>
                        </div>
                    </div><!-- Form Group Row End-->
                </div>
                <!-- /.card-body -->
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div><!-- Container-fluid-->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <?php
                if ($is_publisher == 1) {
                } else { ?>
                    <form id="frm-example" action="<?php echo $common_dlist_archive; ?>" method="POST">
                        <div class="card-header">
                            <h3 class="card-title"><a href="<?php echo $create_debarred_lists_link; ?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus-sign"></span> Add Debarred List </a></h3>
                            <h3 class="card-title" style="margin-right: 10px;"><button class="btn btn-primary action-btn" data-action="delete" type="button">Delete</button>
                            </h3>
                            <h3 class="card-title" style="margin-right: 10px;"><button class="btn btn-primary action-btn" data-action="archive" type="button">Archives</button>
                            </h3>
                            <input type="hidden" name="action" id="action" />
                            <input type="hidden" name="ids" id="ids" />
                        </div>
                    <?php } ?>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="dlisttbl" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 2%"><input name="select_all" value="1" type="checkbox"></th>
                                    <th>Debarred Name</th>
                                    <th> Pdf File</th>
                                    <th style="width: 10%">From Date</th>
                                    <th style="width: 10%">To Date</th>
                                    <th style="width: 1%">Status</th>
                                    <th style="width: 12%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<link type="text/css" href="<?php echo $this->theme_url; ?>/dist/css/dataTables.checkboxes.css" rel="stylesheet" />
<script src="<?php echo $this->theme_url; ?>/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->theme_url; ?>/dist/js/dataTables.checkboxes.min.js"></script>
<script>
    $(document).ready(function() {
        $("#dlist_from_and_to_date_container").hide();
        let baseurl = '<?php echo $this->route->site_url("Admin/ajaxResponseForDlistDataTableLoad"); ?>';
        $("#dlist_arc_form").on('click', function(event) {
            //debugger;
            event.preventDefault();
            $('#dlisttbl').dataTable().fnDestroy();
            var formData = {
                year: $("#dlist_year option:selected").text(),
                month: $("#dlist_month option:selected").val(),
                effect_from_date: $("#effect_from_date").val(),
                effect_to_date: $("#effect_to_date").val(),
            };
            var userDataTable = $('#dlisttbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': baseurl,
                data: formData,
            },
            'columns': [{
                    data: 'debarred_lists_id'
                },
                {
                    data: 'pdf_name'
                },
                {
                    data: 'attachment'
                },
                {
                    data: 'effect_from_date'
                },
                {
                    data: 'effect_to_date'
                },
                {
                    data: 'p_status'
                },
                {
                    data: 'action'
                },
            ],
            'columnDefs': [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            'select': {
                'style': 'multi'
            },
        });
        });
        $('#dlist_form_reset_btn').click(function(e) {
             e.preventDefault();
             $('input[type=text]').val('');
             $('#dlist_month').val('All')
             $('#dlist_from_and_to_date_container').hide();
         });
        jQuery("#dlist_arc_form").trigger('click');
        // Check Box
        $('#dlisttbl').on('change', 'input[type="checkbox"]', function() {
            let selectedCheckboxCount = $("#dlisttbl input[type=\"checkbox\"]:checked").length;
            if (selectedCheckboxCount > 0) {
                console.log($(".deletebtn"))
                $(".deletebtn").attr('disabled', "disabled");
                $(".archivebtn").attr('disabled', "disabled");
            } else {
                $(".deletebtn").removeAttr('disabled');
                $(".archivebtn").removeAttr('disabled');
            }
        });
        // Handle form submission event
        $(".action-btn").on('click', function(e) {
            e.preventDefault;
            //debugger;
            $("#action").val($(this).data('action'));
            let action_value = $("#action").val();
            // make the form submit
            var rows_selected = $('#dlisttbl').DataTable().column(0).checkboxes.selected();
            let form = "#frm-example";
            let rowIds = "";
            if (rows_selected.length == 0) {
                swal({title:"Please select atleast one checkbox"});
                return false;
            } else {
                let title = action_value[0].toUpperCase() +action_value.slice(1);
                swal({title:"Do You Want to " +   title +'?', 
                    buttons: {
                        yes: {
                            text: "Ok",
                            value: "yes"
                        },
                        No: {
                            text: "Cancel",
                            value: "No",
                            buttonColor: "#000000",
                        }
                    }
                }).then((value) => {
                    if (value === "yes") { //yes start
                        $.each(rows_selected, function(index, rowId) {
                            // Create a hidden element
                            rowIds += `${rowId},`;
                            // $(form).append(
                            //     $('<input>')
                            //         .attr('type', 'hidden1')
                            //         .attr('name', 'id[]')
                            //         .val(rowId)
                            // );
                            // $('#frm-example').trigger('submit');
                        });
                        rowIds = rowIds.substring(0, rowIds.length - 1);
                        $(form).find("#ids").val(rowIds);
                        $(form).submit();
                    } // yes End
                    return false;
                });
            }
        });
        // Delete record
        $('#dlisttbl').on('click', '.deletebtn', function(e) {
            e.preventDefault()
            var id = $(this).data('id');
            swal({
                title: 'Do You Want to Delete ?', 
                buttons: {
                    yes: {
                        text: "Ok",
                        value: "yes"
                    },
                    No: {
                        text: "Cancel",
                        value: "No",
                        buttonColor: "#000000",
                    }
                }
            }).then((value) => {
                if (value === "yes") { //yes start
                    // AJAX request
                    $.ajax({
                        url: baseurl,
                        type: 'post',
                        data: {
                            request: 4,
                            id: id
                        },
                        success: function(response) {
                            if (response == 1) {
                                swal({title:"Record has been deleted successfully" });
                                // Reload DataTable
                                $('#dlisttbl').DataTable().ajax.reload();
                                $('.alert-success').html('');
                            } else {
                                swal("Invalid ID.");
                            }
                        }
                    });
                } // yes End
                return false;
            });
        });
        // Archive record
        $('#dlisttbl').on('click', '.archivebtn', function(e) {
            e.preventDefault()
            var id = $(this).data('id');
            swal({title:"Do You Want to Archive ?", 
                buttons: {
                    yes: {
                        text: "Ok",
                        value: "yes"
                    },
                    No: {
                        text: "Cancel",
                        value: "No",
                        buttonColor: "#000000",
                    }
                }
            }).then((value) => {
                if (value === "yes") { //yes start
                    // AJAX request
                    $.ajax({
                        url: baseurl,
                        type: 'post',
                        data: {
                            request: 5,
                            id: id
                        },
                        success: function(response) {
                            if (response == 1) {
                                swal({title:"Record has been archived successfully"});
                                // Reload DataTable
                                $('#dlisttbl').DataTable().ajax.reload();
                            } else {
                                swal("Invalid ID.");
                            }
                        }
                    });
                } // yes End
                return false;
            });
        });
        // Publish record
        $('#dlisttbl').on('click', '.publishbtn', function(e) {
            e.preventDefault()
            var id = $(this).data('id');
            swal({title:"Do You Want to Publish ?", 
                buttons: {
                    yes: {
                        text: "Ok",
                        value: "yes"
                    },
                    No: {
                        text: "Cancel",
                        value: "No",
                        buttonColor: "#000000",
                    }
                }
            }).then((value) => {
                if (value === "yes") { //yes start
                    // AJAX request
                    $.ajax({
                        url: baseurl,
                        type: 'post',
                        data: {
                            request: 6,
                            id: id
                        },
                        success: function(response) {
                            if (response == 1) {
                                swal({title:"Record has been published successfully"});
                                // Reload DataTable
                                $('#dlisttbl').DataTable().ajax.reload();
                                $('.alert-success').hide();
                            } else {
                                swal("Invalid ID.");
                            }
                        }
                    });
                } // yes End
                return false;
            });
        });
        //DatePicker
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
                    yearRange: '2020:+0'
                }
            );
            $("#effect_to_date").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '2020:+0'
            });
        });
        //year Onchange
        $("#dlist_year").on('change', function(e) {
            let year = $(this).val();
            let monthoutput = $("#dlist_month").val();
            // let monthvalue = month == 'All' ?'01':month;
            //month == 'All' ?'01':month;
            if (monthoutput == 'All') {
                monthvalue = '01';
                $("#dlist_from_and_to_date_container").hide();
            } else {
                $("#dlist_from_and_to_date_container").show();
                monthvalue = monthoutput;
                $("#effect_from_date").datepicker("setDate", `01-${monthvalue}-${year}`);
                $("#effect_to_date").datepicker("setDate", `01-${monthvalue}-${year}`);
                console.log(`01-${monthvalue}-${year}`)
            }
        });
        //Nomination Month onchange
        $("#dlist_month").on('change', function(e) {
            let month = $(this).val();
            let year = $("#dlist_year").val();
            if (month == 'All') {
                monthvalue = '01';
                $("#dlist_from_and_to_date_container").hide();
            } else {
               // debugger;
                $("#dlist_from_and_to_date_container").show();
                monthvalue = month;
                $("#effect_from_date").datepicker("setDate", `01-${monthvalue}-${year}`);
                $("#effect_to_date").datepicker("setDate", `01-${monthvalue}-${year}`);
                console.log(`01-${monthvalue}-${year}`)
            }
        });
    });
</script>
<style>
    .dt-checkboxes-select-all [type="checkbox"]{
        position: relative;
        left: 10px;
    }
</style>