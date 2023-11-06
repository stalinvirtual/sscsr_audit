<?php
namespace App\Controllers;
use App\System\Route;
$route = new Route();
$adminpage = $route->site_url("IndexController/admin_login");
$nominationpage = $route->site_url("IndexController/nomination");
$selectionpostpage = $route->site_url("IndexController/selectionpost");
$pageunderconstruction = $route->site_url("IndexController/pageunderconstruction");
$admit_card = $route->site_url("IndexController/admitcard");
$know_your_status = $route->site_url("IndexController/knowyourstatus");
$faq = $route->site_url("IndexController/faq");
$dlist = $route->site_url("IndexController/dlist");
$screenReaderAccess = $route->site_url("IndexController/ScreenReaderAccess");
$candidateCorner = $route->site_url("IndexController/candidateCorner");
$base_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $base_url."IndexController/admin_login";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SSCSR - Staff Selection Commission</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="SSCSR - Staff Selection Commission" />
	<meta
		http-equiv="Content-Security-Policy: default-src 'none'; script-src 'self'; connect-src 'self'; img-src 'self'; style-src 'self';">
	<base href="<?php echo $this->base_url; ?>" />
	<!--css -->
	<link rel="shortcut icon" type="image/png" href="img/logo.png" />
	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="css/cubeportfolio.min.css" rel="stylesheet" />
	<link href="css/style.css" rel="stylesheet" />
	<link href="css/monthly.css" rel="stylesheet" />
	<link href="css/slick/slick.css" rel="stylesheet" />
	<link href="css/slick/slick-theme.css" rel="stylesheet" />
	<link href="css/sitemap.css" rel="stylesheet" />
	<link id="t-colors" href="skins/default.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="assets/datatable/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="assets/datatable/css/responsive.dataTables.min.css">
	<link rel="stylesheet" href="assets/datatable/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="assets/datatable/css/responsive.bootstrap4.css">
	<link rel="stylesheet" href="assets/datatable/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="assets/datatable/css/select.dataTables.min.css">
	<link rel="stylesheet" href="assets/datatable/css/dataTables.checkboxes.css">
	<link href="css/select2.min.css" rel="stylesheet" />
	<style>
		.form-control {
			height: 39px !important;
		}
	</style>
</head>
</head>
<body>
	<?php //echo phpinfo();?>
	<div id="wrapper" class="admitcard-preview-wrapper">
		<section class="buttons">
			<div class="container" id="main">
				<div class="row">
					<div class="col-lg-3">
						<div style="margin-top:50px">
						</div>
					</div>
					<div class="col-lg-6" style='margin-top:10%'>
						<div>
							<div class="row">
								<div class="wrapper">
									<?php
									if (isset($errorMsg) && !empty($errorMsg)) {
										echo '<div class="alert alert-danger errormsg">';
										echo $errorMsg;
										echo '</div>';
										//unset($errorMsg);
									}
									$route = new Route();
									//$loadcaptcha = $route->site_url("Api/loadcaptcha");
									?>
									<div style="text-align:center;margin-bottom:20px ">( cgle 2019 / 91000299330 /
										29-07-1995 ) </div>
									<form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
										style="max-width:585px !important;" target="_blank" id="admit_card_preview_from">
										<label for="exampleInputEmail1">Select Exam Name</label>
										<select name="examname" id="examname" 
											class="form-control col-md-3 col-sm-2">
											<option value="" selected="selected">Select Exam Name</option>
										</select>
										<br>
										<br>
										<label for="exampleInputEmail1">Register Number <span class="qnsround"
												data-toggle='tooltip'
												title='Cut,Copy,Paste is not allowed . Type it Manually'>?</span></label>
										<input type="text" class="form-control" maxlength="11"
											placeholder="Register Number" name="register_number" id="register_number"
											value="" autocomplete="off" />
										<br>
										<div class='roll_pp_div' style='display:none'>
											<label for="exampleInputEmail1">Roll Number <span class="qnsround"
													data-toggle='tooltip'
													title='Cut,Copy,Paste is not allowed . Type it Manually'>?</span></label>
											<input type="text" class="form-control" maxlength="11"
												placeholder="Roll Number" name="roll_number" id="roll_number" value=""
												autocomplete="off" />
											<br>
										</div>
										<div class="post_preference_div_select" style="display: none;">
											<label for="exampleInputEmail1">Post No(s)</label>
											<select class="form-control" name="post_preference_one"
												id="post_preference_one">
											</select>
											<br>
										</div>
										<!-- <label for="exampleInputEmail1">Date of Birth</label>
							  <input type="date" class="form-control" placeholder="DOB " name="dob" 
							  required="" id = "password" autocomplete="off"  min ="1980-01-01" max="2005-01-01"/>  -->
										<div class="form-group row">
											<div class="col-xs-4">
												<label for="exampleInputEmail1">Date of Birth</label>
												<input type="text" class="form-control placeholder_font_size" name="dob"
													id="dob" value="" autocomplete="off" readonly >
											</div>
										</div>
										<br>
										<button class="btn btn-lg btn-sscsrthemecolor btn-block" type="submit"
											name="admit_card">Preview</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div style="margin-bottom:50px">
						</div>
					</div>
				</div>
			</div>
		</section>
		<style>
			.select2-selection__rendered {
				line-height: 31px !important;
				/* white-space: inherit !important; */
			}
			.select2-container .select2-selection--single {
				height: 56px !important;
				/* white-space: inherit !important; */
			}
			.select2-selection__arrow {
				height: 56px !important;
			}
			.ui-datepicker select.ui-datepicker-month,
			.ui-datepicker select.ui-datepicker-year {
				color: black !important;
			}
			.ui-datepicker-trigger {
				position: relative;
				margin-left: 155px;
				margin-top: -67px;
				height: 20px;
			}
	#examname-error {
		/* Adjust the value as needed */
		display: block;
		color: red;
		position: relative;
		top: 85px;
		}
		.error{
			color: red;
		}
		#dob-error {
		white-space: nowrap;
		}
		.select2-container {
    width: 100% !important;
}
		</style>
		
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
	<script src="js/jquery.min.js"></script> 
	<script src="js/select2.js"></script>
	<script src="js/select2.min.js"></script>
	<link href="css/lightgallery.css" rel="stylesheet">
	<script src="js/lightgallery-all.min.js"></script>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/jquery-ui.js"></script>
	<script src="js/jquery.validate.min.js" crossorigin="anonymous"></script>
	<!-- <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet"> -->
	<!-- <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script> -->
	
	
	<style>
		.qnsround {
			display: inline-block;
			width: 18px;
			height: 18px;
			text-align: center;
			line-height: 18px;
			background-color: #141313;
			color: #fff;
			margin-top: 2px;
			margin-left: 5px;
			border-radius: 50%;
			cursor: pointer;
		}
	</style>
	<script>
		$(document).ready(function () {
			//  $("[data-toggle='tooltip']").tooltip();
			$.datepicker.setDefaults({
				showOn: "button",
				buttonImage: "img/datepicker.png",
				buttonText: "Date Picker",
				buttonImageOnly: true,
				dateFormat: 'dd-mm-yy'
			});
			$(function () {
				$("#dob").datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: '1965:2015'
				});
			});
			var baseurl = '<?php echo $this->route->site_url("IndexController/getTierBasedExamDetailsCardPreview/q/2"); ?>';
			$('#examname').select2();
			$('#examname').select2({
				placeholder: 'Select Exam Name',
				ajax: {
					url: baseurl,
					dataType: 'json',
					data: function (data) {
						return {
							q: data.term // search term
						};
					},
					processResults: function (data) {
						return {
							results: data
						};
					},
					cache: true
				}
			});
			$('#examname').on('change', function () {
				$('#roll_number').val('');
				$('#register_number').val('');
				$('#password').val('');
				$("#dob").datepicker("setDate", "");
				let admitcardExamName = $('#examname option:selected').val();
				var strshortened = admitcardExamName.slice(0, 5);
				if (strshortened == "phase") {
					let exam_name = admitcardExamName.split('_');
					let exam_type = exam_name[4];
					if (exam_type == 'tier' || exam_type == 'skill') {
						$('.roll_pp_div').show();
						$('.post_preference_div_select').hide();
						$('#post_preference_one').empty();
					} else if (exam_type == 'dv') {
						$('.roll_pp_div').show();
						$('.post_preference_div_select').show();
					}
				} else {
					$('.roll_pp_div').hide();
				}
			});
			$('#roll_number').on("cut copy paste", function (e) {
				e.preventDefault();
			});
			$('#register_number').on("cut copy paste", function (e) {
				e.preventDefault();
			});
			$("#roll_number").keyup(function () {
				$('#post_preference_one').empty();
				var roll_no = $(this).val().trim();
				let examname = $('#examname option:selected').val();
				let exam_name = examname.split('_');
				let exam_type = exam_name[4];
				//debugger;
				if (roll_no != '' && exam_type == 'dv') {
					var baseurl = '<?php echo $this->route->site_url("IndexController/getPostPreferenceValue"); ?>';
					//debugger;
					$.ajax({
						url: baseurl,
						type: 'post',
						data: {
							roll_no: roll_no,
							examname: examname
						},
						dataType: "json",
						success: function (response) {
							var html = '';
							$.each(response, function (i) {
								html += '<option value="' + response[i] + '">' +
									response[i] + '</option>';
							})
							$('#post_preference_one').empty().append(html);
						}
					});
				} else {
					$("#post_preference_one").html("");
				}
			});
		});
		$(document).ready(function() {
		$("#admit_card_preview_from").validate({
			rules: {
				examname: {
					required: true,
				},
				register_number: {
					required: true,
					maxlength: 11,
					digits:true
				},
				roll_number: {
					required: true,
					maxlength: 10,
					digits:true
				},
				dob: {
          			required: true,
          			//isBeforeCurrentDate: true
        		}
			},
			messages: {
				examname: {
					required: "Please select a exam name",
				},
				register_number: {
					required: "Please enter your register number",
					maxlength: "Your register No must be maximum 11 characters long",
					digits: "Please enter digits only"
				},
				roll_number: {
					required: "Please enter your roll number",
					maxlength: "Your register No must be maximum 10 characters long",
					digits: "Please enter digits only"
				},
				dob: {
          			required: "Please enter your date of birth"
        		}
			},
			errorPlacement: function(error, element) {
                if (element.attr("name") === "dob") {
                    // Place the error message after the image tag
                    error.insertAfter(element.next("img.ui-datepicker-trigger"));
                } else {
                    // Use the default error placement for other fields
                    error.insertAfter(element);
                }
            },
			submitHandler: function(form) {
				form.submit();
			}
		});
    });
	</script>
</body>
</html>