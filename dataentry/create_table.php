<?php

session_start();
if (!isset($_SERVER['HTTP_REFERER']) && empty($_SERVER['HTTP_REFERER']) || !isset($_SESSION['sess_user'])) {
	header("Location: login.php");
} else {
	

	?>
	<?php

	include('header.php');
	
// Generate a CSRF token and store it in the session
if (!isset($_SESSION['csrf_token']) || !isset($_POST['submit'])) {
    // Generate a new CSRF token and store it in the session
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

 $csrf_token = $_SESSION['csrf_token']; ?>
	<div class="main-grid">
		<div class="panel panel-widget forms-panel">
			<div class="forms">
				<div class="inline-form widget-shadow">
					<div class="form-title">
						<div class="row">
							<div class="col-md-8 form-group">
								<h4>Create Table </h4>
							</div>
							<div class="col-md-3 form-group">
								<a class="btn w3ls-button hvr-icon-sink-away col-24" href="table_details.php">Show Table
									Details</a>
							</div>
						</div>
					</div>

					<div class="form-body">
						<div data-example-id="simple-form-inline">
							<form class="form-horizontal" action="#" method="post" id="creating_master_tables">
								<div class="form-group">
									<label for="examname" class="col-sm-2 control-label">Exam Name<font style="color:red" ;>
											*</font> </label>
									<div class="col-sm-6">
										<select name="examname" id="examname" required="true" class="form-control">
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="exam_year" class="col-sm-2 control-label">Select Year<font style="color:red"
											;>*</font> </label>
									<div class="col-xs-2">
										<input type="text" min="<?php echo date('Y') - 5; ?>"
											max="<?php echo date('Y') + 5; ?>" step="1" name="exam_year" id="exam_year"
											maxlength="4"
											oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
											type="number" class="form-control" value="<?php echo date('Y'); ?>" />
									</div>
									<div id="year_exists" class=" col-sm-4">
									</div>
								</div>
								<div class="form-group showexamcode">
									<label for="exam_year" class="col-sm-2 control-label">Exam Code</label>
									<div class="col-sm-6">
										<p class="examshowcode"></p><span class="qnsround" data-toggle='tooltip' title='This exam code should be match with the excel exam code.'>?</span>
									</div>
								</div>

								<div class="form-group selectedTableFormat">
									<label for="selectedTableFormat" class="col-sm-2 control-label">Table For<font
											style="color:red" ;>*</font> </label>
									<div class="col-sm-6">
										<select name="selectedTableFormat" id="selectedTableFormat" required="true"
											class="form-control">
											<option value=""></option>
											<option value="is_kyas">Application Status</option>
											<option value="is_tier">Written Examination/CBE</option>
											<option value="is_skill">Skill Test</option>
											<option value="is_dme">Detailed Medical Examination</option>
											<option value="is_pet">Physical Standard Test and Physical Endurance Test
											</option>
											<option value="is_dv">Document Verification</option>
										</select>
									</div>
									<div id="table_exits" class=" col-sm-4">
									</div>
								</div>

								<div class="form-group table_columns">
									<label for="selectcolumn" class="col-sm-2 control-label">Table Columns<font
											style="color:red" ;>*</font> </label>
									<div class="col-sm-6">
										<select name="selectcolumn[]" id="parent_filter_select2" required="true"
											class="parent_filter_select2 form-control" multiple="multiple">

										</select>
									</div>
								</div>
								<input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $csrf_token; ?>">
								<button class="btn w3ls-button hvr-icon-down col-5"> Create</button>

							</form>
							<div id="messageTemplate">
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>





	</div>



	<style>
		#overlay {
			background: #ffffff;
			color: #666666;
			position: fixed;
			height: 100%;
			width: 100%;
			z-index: 5000;
			top: 0;
			left: 0;
			float: left;
			text-align: center;
			padding-top: 25%;
			opacity: .80;
		}

		.spinner {
			margin: 0 auto;
			height: 64px;
			width: 64px;
			animation: rotate 0.8s infinite linear;
			border: 5px solid firebrick;
			border-right-color: transparent;
			border-radius: 50%;
		}

		@keyframes rotate {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}

		h2#swal2-title {
			text-align: start;
		}

		.errormsg {
			background: antiquewhite;
		}

		i.fa.fa-exclamation-triangle {
			width: inherit;
		}

		.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
			color: #999;
			cursor: pointer;
			display: none !important;
			font-weight: bold;
			margin-right: 2px;
		}

		p.examshowcode {
			padding: 6px;
			background-color: #00acc1;
			color: white;
			width: max-content;
			font-weight: 700;
		}
		.qnsround{
	display: block;
    width: 18px;
    height: 18px;
    text-align: center;
    line-height: 18px;
    background-color: #141313;
    color: #fff;
	margin-top: -25px;
    margin-left: 141px;
    margin-bottom: 10px;
    border-radius: 50%;
    cursor: pointer;
	}
	.error{
		color:red;
	}
	.swal2-title {
    text-align: center !important;
}
	</style>

	<?php
}
?>
<?php include('footer.php'); ?>


<script type="text/javascript" language="javascript">
	$(document).ready(function () {
// alert($('#csrf_token').val());
// alert(jsVariable);
		const d = new Date();

		d.getMonth() + 1; // Month	[mm]	(1 - 12)
		d.getDate();

		var current_yearbelow5 = d.getFullYear() - 5; // Day		[dd]	(1 - 31)
		var current_yearabove5 = d.getFullYear() + 5; // Day		[dd]	(1 - 31)


		$('.alert').hide();
		$('#examname').select2();
		$('.selectedTableFormat').hide();
		$('.showexamcode').hide();
		$('.table_columns').hide();
		$('#examname').select2({
			placeholder: 'Select Exam Name',
			ajax: {
				url: 'search_exam.php',
				dataType: 'json',
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});
		$('#selectedTableFormat').select2({
			placeholder: 'Please select any one exam name',
			ajax: {
				url: 'search_exam.php',
				dataType: 'json',
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});

		$('#examname').on('change', function () {
			//debugger;
			$('.table_columns').hide();
			$('#table_exits').html("");

			$('.selectedTableFormat').show();
			$('.showexamcode').show();
			var examshocode = $('#examname option:selected').val() + $("#exam_year").val();
			$('.examshowcode').html('<span>' + examshocode.toLowerCase() + '<span>');
			$("#selectedTableFormat").val('');
			$('#selectedTableFormat').select2({
				placeholder: 'Please select table format',
			});
		});

		$("#exam_year").keyup(function () {
			$('#table_exits').removeClass("errormsg");
			$('#table_exits').html("");
			$('.selectedTableFormat').hide();
			$('#parent_filter_select2').hide();

			$('.showexamcode').hide();

			year = $("#exam_year").val();

			if (year >= current_yearbelow5 && year <= current_yearabove5) {
				$("#year_exists").removeClass("errormsg");
				$('#year_exists').html("");

				$('.selectedTableFormat').show();
				$('.showexamcode').show();
				var examshocode = $('#examname option:selected').val() + $("#exam_year").val();
				$('.examshowcode').html('<span>' + examshocode.toLowerCase() + '<span>');

				$('#selectedTableFormat').select2({
					placeholder: "Select a Table Type",
					allowClear: true,
				});
				$("#selectedTableFormat").val('').trigger('change');


			} else {
				$("#year_exists").addClass("errormsg");
				$('#year_exists').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'> <span  style='color: red;font-size:15px;'>Please type year between <b>" + current_yearbelow5 + "-" + current_yearabove5 + "</b></span></i>");
			}
		});
		$("#exam_year").keydown(function () {
			$('#table_exits').removeClass("errormsg");
			$('#table_exits').html("");
			$('.selectedTableFormat').hide();
			$('.showexamcode').hide();
			$('#parent_filter_select2').hide();

			year = $("#exam_year").val();

			if (year >= current_yearbelow5 && year <= current_yearabove5) {
				$('.selectedTableFormat').show();
				$('.showexamcode').show();
				var examshocode = $('#examname option:selected').val() + $("#exam_year").val();
				$('.examshowcode').html('<span>' + examshocode.toLowerCase() + '<span>');

				$('#selectedTableFormat').select2({
					placeholder: "Select a Table Type",
					allowClear: true,
				});
				$("#selectedTableFormat").val('').trigger('change');


			} else {
				$('#year_exists').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'> <span  style='color: red;font-size:15px;'>Please type year between <b>" + current_yearbelow5 + "-" + current_yearabove5 + "</b></span></i>");
			}

		});



		//in multiselect select all/un select all
		$.fn.select2.amd.define('select2/selectAllAdapter', [
			'select2/utils',
			'select2/dropdown',
			'select2/dropdown/attachBody'
		], function (Utils, Dropdown, AttachBody) {


			function SelectAll() { }
			SelectAll.prototype.render = function (decorated) {
				var self = this,
					$rendered = decorated.call(this),
					$selectAll = $(
						'<button class="btn btn-xs btn-default" type="button" style="margin-left:6px;"><i class="fa fa-check-square-o"></i> Select All</button>'
					),
					$unselectAll = $(
						'<button class="btn btn-xs btn-default" type="button" style="margin-left:6px;"><i class="fa fa-square-o"></i> Unselect All</button>'
					),
					$btnContainer = $('<div style="margin-top:3px;">').append($selectAll).append($unselectAll);
				if (!this.$element.prop("multiple")) {
					// this isn't a multi-select -> don't add the buttons!
					return $rendered;
				}
				$rendered.find('.select2-dropdown').prepend($btnContainer);
				$selectAll.on('click', function (e) {

					var $results = $rendered.find('.select2-results__option[aria-selected=false]');
					//	debugger;
					$results.each(function () {
						//debugger;
						self.trigger('select', {
							data: $(this).data('data')
						});
					});
					self.trigger('close');
				});
				$unselectAll.on('click', function (e) {
					var $results = $rendered.find('.select2-results__option[aria-selected=true]');
					$results.each(function () {
						self.trigger('unselect', {
							data: $(this).data('data')
						});
					});
					self.trigger('close');
				});
				return $rendered;
			};

			return Utils.Decorate(
				Utils.Decorate(
					Dropdown,
					AttachBody
				),
				SelectAll
			);

		});

		$('#parent_filter_select2').select2({
			placeholder: 'Please select any one table format',
		});



		$('#selectedTableFormat').on('change', function () {

			$('#parent_filter_select2').select2().empty();
			var examname = $('#examname option:selected').val();
			var table_format = $('#selectedTableFormat option:selected').val();
			var exam_year = $('#exam_year').val();
			/* if(table_format=='is_kyas'){
					var tablefor ='Application Status Table <br> Already Exists';
				}else{
					var tablefor ='Tier Based Exam Details Table <br> Already Exists';
				} */
			console.log(table_format);

			var formdata = new FormData(document.getElementById("creating_master_tables"));
			//check the table is already exits or not		
			$.ajax({
				url: 'check_table_isexists.php',
				data: formdata,
				method: "POST",
				dataType: 'json',
				contentType: false,
				processData: false,
				success: function (response) {

					if (response == 1) {

						$('#table_exits').addClass("errormsg");
						$('#table_exits').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'> <span  style='color: red;font-size:15px;'><b>Application Status Table Already Exists</span></i>");
						$('#parent_filter_select2').select2({
							placeholder: 'Please select the correct table',
						});
						$('.table_columns').hide();

					} else if (response == 2) {
						$('#table_exits').addClass("errormsg");
						$('#table_exits').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'> <span  style='color: red;font-size:15px;'><b>Application Status Table Not Exists</span></i>");
						$('#parent_filter_select2').select2({
							placeholder: 'Please select the Application Status',
						});
					} else if (response == 3) {
						$('#table_exits').addClass("errormsg");
						$('#table_exits').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'> <span  style='color: red;font-size:15px;'><b>Written Examination/CBE Table Already Exists</span></i>");
						$('#parent_filter_select2').select2({
							placeholder: 'Please select the correct table',
						});
						$('.table_columns').hide();
					} else if (response == 4) {
						$('#table_exits').addClass("errormsg");
						$('#table_exits').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'> <span  style='color: red;font-size:15px;'><b>Written Examination/CBE Table Not Exists</span></i>");
						$('#parent_filter_select2').select2({
							placeholder: 'Please select the correct table',
						});
						$('.table_columns').hide();
					} else if (response == 5) {
						$('#table_exits').addClass("errormsg");
						$('#table_exits').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'> <span  style='color: red;font-size:15px;'><b>Skill Exam Table Is Already Exists</span></i>");
						$('#parent_filter_select2').select2({
							placeholder: 'Please select the correct table',
						});
						$('.table_columns').hide();
					} else if (response == 7) {
						$('#table_exits').addClass("errormsg");
						$('#table_exits').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'> <span  style='color: red;font-size:15px;'><b>PET Exam Table Is Already Exists</span></i>");
						$('#parent_filter_select2').select2({
							placeholder: 'Please select the correct table',
						});
						$('.table_columns').hide();
					} else if (response == 9) {
						$('#table_exits').addClass("errormsg");
						$('#table_exits').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'> <span  style='color: red;font-size:15px;'><b>DV Exam Table Is Already Exists</span></i>");
						$('#parent_filter_select2').select2({
							placeholder: 'Please select the correct table',
						});
						$('.table_columns').hide();

					} else if (response == 11) {
						$('#table_exits').addClass("errormsg");
						$('#table_exits').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'> <span  style='color: red;font-size:15px;'><b>DME Exam Table Is Already Exists</span></i>");
						$('#parent_filter_select2').select2({
							placeholder: 'Please select the correct table',
						});
						$('.table_columns').hide();

					} else {
						//if not exists
						$('.table_columns').show();
						$('#table_exits').removeClass("errormsg");
						$('#table_exits').html("");
						$('#parent_filter_select2').select2({
							placeholder: 'Select table columns',
							dropdownAdapter: $.fn.select2.amd.require('select2/selectAllAdapter'),
							ajax: {
								data: {
									table_format: table_format
								},
								method: "POST",
								url: 'search_table_columns.php',
								dataType: 'json',
								processResults: function (data) {
									return {
										results: data
									};
								},
								cache: true

							}
						});
					}


				}
			});

		});


		// $('#creating_master_tables').on('submit', function (event) {
		// 	event.preventDefault();
		// 	var examname = $('#examname option:selected').val();
		// 	var table_format = $('#selectedTableFormat option:selected').val();
		// 	var exam_year = $('#exam_year').val();


		// 	if (table_format == 'is_kyas') {
		// 		var tablefor = 'Application Status Details';
		// 	} else {
		// 		var tablefor = 'Tier Based Exam Details';
		// 	}



		// 	if (examname != '' && table_format != '' && exam_year != '') {


		// 		swal.fire({
		// 			title: '<strong>Do you want to create?</strong>',
		// 			html: '<b>' + examname + '</b>,( year <b>' + exam_year + '</b> ) table for ' + tablefor,
		// 			showCloseButton: true,
		// 			confirmButtonText: 'Yes',
		// 			cancelButtonText: 'No',
		// 			confirmButtonClass: 'some-class',
		// 			cancelButtonClass: 'some-other-class',
		// 			showCancelButton: true
		// 		}).then(function (result) {
		// 			if (result.value) {
		// 				var formdata = new FormData(document.getElementById("creating_master_tables"));

		// 				$.ajax({
		// 					url: "create_table_ajax.php",
		// 					method: "POST",
		// 					data: formdata,
		// 					dataType: "json",
		// 					contentType: false,
		// 					processData: false,
		// 				}).done(function (data) {

		// 					if (data.response.code == '1') {
		// 						swal.queue([{
		// 							showCloseButton: true,
		// 							title: data.response.title,
		// 							text: data.response.message,
		// 							icon: data.response.status,
		// 							confirmButtonText: 'Show Table Excel Structure',
		// 							showLoaderOnConfirm: true,
		// 							preConfirm: function () {
		// 								return new Promise(function (resolve) {
		// 									$.post('created_table_structure.php', {
		// 										examname: examname,
		// 										selectedTableFormat: table_format,
		// 										exam_year: exam_year
		// 									})
		// 										.done(function (data) {
		// 											$('#messageTemplate').html(data);
		// 											resolve()
		// 										})
		// 								})
		// 							}
		// 						}]);

		// 					} else {

		// 						swal.fire({
		// 							showCloseButton: true,
		// 							title: data.response.title,
		// 							text: data.response.message,
		// 							icon: data.response.status,
		// 						});

		// 					}

		// 				});

		// 			} else {
		// 				console.log('button B pressed')
		// 			}
		// 		})




		// 	} else {
		// 		alert("Please fill the reqired ( *) fields !")
		// 	}
		// });


//validation

$("#creating_master_tables").validate({
			rules: {
				examname: {
					required: true
				},
				exam_year: {
					required: true,
					digits: true,
					min: <?php echo date('Y') - 5; ?>,
			max: <?php echo date('Y') + 5; ?>
			},
		selectedTableFormat: {
		required: true
	},
		"selectcolumn[]": "required"
		},
		messages: {
		examname: {
			required: "Please select an Exam Name."
		},
		exam_year: {
			required: "Please enter a valid Year.",
			digits: "Please enter a valid Year.",
			min: "Year must be at least <?php echo date('Y') - 5; ?>.",
			max: "Year must be at most <?php echo date('Y') + 5; ?>."
		},
		selectedTableFormat: {
			required: "Please select a Table Format."
		},
		"selectcolumn[]": "Please select at least one table column"
	},
		errorPlacement: function (error, element) {
			if (element.attr("name") === "examname") {
				// Place the error message after the image tag
				error.insertAfter(element.next("span.select2"));
			} else if (element.attr("name") === "selectedtier") {
				// Place the error message after the Select2 element
				error.insertAfter(element.next("span.select2"));
			}
			else if (element.attr("name") === "selectedTableFormat") {
				// Place the error message after the Select2 element
				error.insertAfter(element.next("span.select2"));
			}
			else if (element.attr("name") === "selectcolumn[]") {
				// Place the error message after the Select2 element
				error.insertAfter(element.next("span.select2"));
			}
			else {
				// Use the default error placement for other fields
				error.insertAfter(element);
			}
		},
		submitHandler: function (form) {
			
			var examname = $('#examname option:selected').val();
			var table_format = $('#selectedTableFormat option:selected').val();
			var exam_year = $('#exam_year').val();
			if (table_format == 'is_kyas') {
				var tablefor = 'Application Status Details';
			} else {
				var tablefor = 'Tier Based Exam Details';
			}
			if (examname != '' && table_format != '' && exam_year != '') {
				swal.fire({
					title: '<strong>Do you want to create?</strong>',
					html: '<b>' + examname + '</b>,( year <b>' + exam_year + '</b> ) table for ' + tablefor,
					showCloseButton: true,
					confirmButtonText: 'Yes',
					cancelButtonText: 'No',
					confirmButtonClass: 'some-class',
					cancelButtonClass: 'some-other-class',
					showCancelButton: true
				}).then(function (result) {
					if (result.value) {
						//debugger;
						var formdata = new FormData(document.getElementById("creating_master_tables"));
						$.ajax({
							url: "create_table_ajax.php",
							method: "POST",
							data: formdata,
							dataType: "json",
							contentType: false,
							processData: false,
						}).done(function (data) {
							if (data.response.code == '1') {
								swal.fire({
									showCloseButton: true,
									title: data.response.title,
									text: data.response.message,
									icon: data.response.status,
									confirmButtonText: 'Show Table Excel Structure',
									showLoaderOnConfirm: true,
									preConfirm: function () {
										return new Promise(function (resolve) {
											$.post('created_table_structure.php', {
												examname: examname,
												selectedTableFormat: table_format,
												exam_year: exam_year
											})
												.done(function (data) {
													$('#messageTemplate').html(data);
													resolve()
												})
										})
									}
								});
							} else {
								swal.fire({
									showCloseButton: true,
									title: data.response.title,
									text: data.response.message,
									icon: data.response.status,
								});
							}
						});
					}
				})
			}
		}
	});


	});
</script>