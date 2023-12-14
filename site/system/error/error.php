<?php
namespace App\Controllers;

use App\System\Route; 
/***
 * 
 * code added on july 5th 2022
 * 
 */


header("X-Frame-Options:DENY");
header("X-Content-Type-Options:nosniff");
header("X-XSS-Protection:0; mode=block");
header("Access-Control-Allow-Origin:*");
header("content-secuity-policy:default-src 'self'");
header( "Set-Cookie: HttpOnly");
header( "Set-Cookie: name=value; HttpOnly");
header_remove("X-Powered-By");
ini_set('expose_php','off');


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
$base_url =  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//$base_url =  "http://14.139.183.34//projects/sscsr/site/";
//$base_url =   "https://rtionline.tn.gov.in/security_audit/";
//echo $base_url;

/***
 * 
 * code added on july 5th 2022
 * 
 */



?>
<html>
<head>
	<meta charset="utf-8">
	<title>SSCSR - Staff Selection Commission</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="SSCSR - Staff Selection Commission" />
	<meta http-equiv="Content-Security-Policy: default-src 'none'; script-src 'self'; connect-src 'self'; img-src 'self'; style-src 'self';">
	    <base href="<?php echo $this->base_url; ?>" />
	<!--css -->
	<link rel="shortcut icon" type="image/png" href="img/logo.png"/>
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

</style>
	
</head>
</head>
<body>
<div id="wrapper">
	<div>
		<!-- start header -->
		<header class="">
			<div class="top">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-sm-6 col-xs-12 col-md-6 toprowclass">
							<button type="button" class="btn btn-default headergigw">&nbsp;SSCSR | GOVERMENT OF INDIA</button>
						</div>
						<div class=" col-lg-6  col-sm-6 col-xs-12 col-md-6  search_btn">
							
							<div id="font-setting-buttons">
									<div class="btn-group">											
										<button type="button" class="btn btn-default headergigw" id="skip_to_main_content" title="Skip to Main Content" >Skip To Main Content</button>
										<button type="button" class="btn btn-default headergigw" title="Site Map" id="sitemap"><i class="fa fa-sitemap" aria-hidden="true" ></i></button>
										<button type="button" class="btn btn-default change-me headergigw" title="Contrast"><i class="fa fa-adjust" aria-hidden="true"></i></button>
										<button type="button" class="btn btn-default increase-me headergigw" title="Font Size Increase"><i class="fa fa-font" aria-hidden="true">+</i></button>
										<button type="button" class="btn btn-default reset-me headergigw" title="Normal Font Size"><i class="fa fa-font" aria-hidden="true"></i></button>
										<button type="button" class="btn btn-default decrease-me headergigw" title="Font Size Decrease" ><i class="fa fa-font" aria-hidden="true">-</i></button>
										<button class="btn btn-default headergigw dropdown"><a href="<?php echo $screenReaderAccess; ?>" rel = "noopener noreferrer" target="_blank" style="color:white">Screen Reader Access</a></button>										
									</div>
							</div>	
							
						</div>
					</div>
				</div>
			</div>			
			<div class="navbar navbar-default ">
				<div class="container headruler">
					<div class="col-md-1 col-lg-1">
						<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a href="#"><img src="img/logo.png" class="sitelogo"/></a>
						</div>
					</div>
					<div class="col-md-7 col-lg-7">
						<a href="#"><h3 class="ipab">कर्मचारी चयन आयोग <br>STAFF SELECTION COMMISSION</h3></a>
						<a href="#"><h4 class="goverment">Southern Region, Chennai</h4></a>
					</div>

					
					<div class="container" >
						<div class="row">
								<div class="row">
								
									<div class="col-xs-2" style="    margin-left: 20px;">
										<a href="IndexController/candidateCorner"><img src="images/header-icons/result.png" width="80px" style="margin-top:20px;" class="shortcut_icon"/><h6>Candidate Corner </h6></a>
									</div>
									<div class="col-xs-2">
										<a href="#"><img src="img/emblem-dark.png" class="emblem"/></a>
									</div>
							</div>
						</div>
					</div>
					
				</div>				
			</div>
		</header>
		<!-- end header -->
		<?php  //echo '<pre>';
		
		//echo "#########Stalin";

         //print_r($data); 

         ## echo $renderedMenu; ##
		 
		 ?>
		

		<div class="navbar buttons">
			<div class="container">
				<div class="navbar-collapse collapse ">
					<?php echo $data['renderedMenu'];?>
					
				</div>
			</div>
		</div>
		
	</div>
	
	
	<section class="buttons">
			<div class="container">
				<div class="row breadcrumbruler">
					<div class="col-lg-12">
						<ul class="breadcrumb">
							<li><a href="index.php" class="breadcrumb_text_color">Home</a><i class="icon-angle-right"></i></li>
							<li><a href="page_not_found.php" class="bread"> Page URL is not Found </a><i class="icon-angle-right"></i></li>
						</ul>
					</div>
				</div>
			</div>
		<div class="container" id="main">
				<div class="row">
					
					<div class="col-lg-12">
						<div style="margin-bottom:50px">
							
							<div class="row">
							
								<div class="col-lg-2">
									<i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:100px"></i>
								</div>
								<div class="col-lg-10">
									<h3 style="text-align:center" ><?php echo $data['error_message '];?></h3>
								</div>
							</div>	
							<div class="row">
								<div class="col-lg-4">
								</div>
								<div class="col-lg-4">
									<p><a href="index.php"><button style="border: none;outline: 0;display: inline-block;padding: 8px;color: white;background-color: #00446d;text-align: center;cursor: pointer;width: 100%;font-size: 18px;">Back to Home</button></a></p>
								</div>
								<div class="col-lg-4">
								</div>
							</div>	
						</div>
					</div>
				
				</div>
		</div>
		
		</section>
	
	<!--  Page is not Found-->

	
	<?php
namespace App\Controllers;

use App\System\Route;

$route = new Route();
$gallerypage = $route->site_url("IndexController/gallerypage");
$nominationpage = $route->site_url("IndexController/nomination");
$selectionpostpage = $route->site_url("IndexController/selectionpost");
$faq = $route->site_url("IndexController/faq");
?>

</div>
</div>
<section class=" " style="background:#faebeb ;margin-bottom:1px; border: 3px solid #faebeb;">
	<div class="customer-logos slider" style="background:#fff;border-radius: 10px; width:100%;">
	<div class="slide"><a href="https://www.pmindia.gov.in/en/" rel="noopener noreferrer" target="_blank"
				class="thumbnail page-permission"
				aria-label="Government of Tamil Nadu - External site that opens in a new window"><img
					src="images/logo_pmindia.png" height="100px" alt="Image"
					class="img-responsive1" title=" Department for Promotion of Industry and Internal Trade"></a></div>
	
	<div class="slide"><a href="https://digitalindia.gov.in/" rel="noopener noreferrer" target="_blank"
				class="thumbnail page-permission"
				aria-label="Government of Tamil Nadu - External site that opens in a new window"><img
					src="images/logo_digital_india.png" height="100px" alt="Image"
					class="img-responsive1" title=" Department for Promotion of Industry and Internal Trade"></a></div>
	<div class="slide"><a href="https://www.makeinindia.com/" rel="noopener noreferrer" target="_blank"
				class="thumbnail page-permission"
				aria-label="Government of Tamil Nadu - External site that opens in a new window"><img
					src="images/logo_make_in_india.png" height="100px" alt="Image"
					class="img-responsive1" title=" Department for Promotion of Industry and Internal Trade"></a></div>
		<div class="slide"><a href="https://www.india.gov.in/" rel="noopener noreferrer" target="_blank"
				class="thumbnail page-permission"
				aria-label="Government of Tamil Nadu - External site that opens in a new window"><img
					src="images/logo_india_gov.png" height="100px" alt="Image"
					class="img-responsive1" title="150 Years of Celebrating The Mahatma"></a></div>

		<div class="slide"><a href="http://www.ipindia.nic.in/index.htm" rel="noopener noreferrer" target="_blank"
				class="thumbnail page-permission"
				aria-label="Government of Tamil Nadu - External site that opens in a new window"><img src="images/logo_data_gov.png
" alt="Image" height="100px" class="img-responsive1" title="Controller General of Patents, Designs & Trade Marks"></a>
		</div>

		<div class="slide"><a href="http://copyright.gov.in/Default.aspx" rel="noopener noreferrer" target="_blank"
				class="thumbnail page-permission"
				aria-label="Government of Tamil Nadu - External site that opens in a new window"><img
					src="images/logo_esanad.png" alt="Image" height="100px"
					class="img-responsive1" title="Copyright Office"></a></div>

		<div class="slide"><a href="https://indiacode.nic.in/" class="thumbnail page-permission"
				rel="noopener noreferrer" target="_blank"
				aria-label="Government of Tamil Nadu - External site that opens in a new window"><img
					src="images/logo_mygov.png" height="100px" alt="Image"
					class="img-responsive1" title="India Code Portal"></a></div>
		
	</div>

</section>




<style>
	#wrapper {
			min-height: 75%;
		}
		.flex-wrapper {
			display: flex;
			min-height: 100vh;
			flex-direction: column;
			justify-content: space-between;
		}
	.slide {
		width: 155px !important;
	}
	/* .slick-list .draggable{
height:120px !important;
	} */
	.thumbnail img{
		height:100px !important;
	}

	.cbp-l-loadMore-button {
		padding: 10px;
	}

	a.btn-primary {
		color: #fff;
		background-color: #a94442 !important;
		box-shadow: none;
		border: none !important;
	}

	.imp_links {
		margin-top: -20px;
		/* background: #faebeb; */
		border-radius: 20px;
		width: 75%;

		margin-left: 43px;
		height: 303px;
	}

	.imp_links ul {
		list-style-type: none;
	}

	.imp_links ul li {
		line-height: 10px;
	}
</style>
<?php
namespace App\Controllers;
use App\Helpers\Helpers;

$encryptionKey = bin2hex(random_bytes(32));
$encryptedValue = Helpers::encryptData("2", $encryptionKey);
$getExamDetailsUrl = $this->route->site_url("IndexController/getExamDetails");
$userId = 2;
$encodedUserId = base64_encode($userId);
?>
<section class="section5 buttons">
	<div class="container-fluid bgColor">
		<div class="row" style="background:#a94442;">
			<div class="col-sm-5 col-lg-5">
			</div>
			<div class="col-sm-7 col-lg-7">
				<div class="footerClass">
					<?php echo $data['renderedFooterMenu']; ?>
				</div>
			</div>
		</div>
		<div class="row footerFont">
			<div class="col-sm-1 col-lg-1 ">
			</div>
			<div class="col-sm-2 col-lg-2  nicLogo">
				<img src="exam_assets/niclogo.png" alt="National Informatics Centre opens a new window" width="150"></a>
			</div>
			<div class="col-sm-7 col-lg-7 footer_content_div">
				<p> This portal is designed, developed, hosted and maintained by National Informatics
					Centre(NIC)<br>Ministry of Electronics & Information Technology, Government of India, Tamil Nadu
					State Center, Chennai - 600 090.
					<br>Last Modified:
					<?php echo date('M d,Y'); ?> | This portal is best viewed in chrome and firefox browser(Latest
					Version).
				</p>
			</div>
			<div class="col-sm-2 col-lg-2 ">
			</div>
		</div>
	</div>
</section>
</div>
<a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.appear.js"></script>
<script src="js/stellar.js"></script>
<script src="js/classie.js"></script>
<script src="js/uisearch.js"></script>
<script src="js/google-code-prettify/prettify.js"></script>
<script src="js/animate.js"></script>
<script src="js/custom.js"></script>
<script src="js/jquery.font-accessibility.min.js"></script>
<script src="js/monthly.js"></script>
<script src="js/slick.js"></script>
<script src="js/jQuery.print.js"></script>
<script src="js/custom_script.js"></script>
<script src="js/select2.js"></script>
<script src="js/select2.min.js"></script>
<link href="css/lightgallery.css" rel="stylesheet">
<script src="js/lightgallery-all.min.js"></script>
<link href="css/jquery-ui_new.css" rel="stylesheet">
<script src="js/jquery-ui_new.js"></script>
<script src="js/jquery.validate.min.js" crossorigin="anonymous"></script>
<script>
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
	$(document).ready(function() {
		//Mobile Menu Design
		jQuery(".butttons").on('click', function(e) {
			e.preventDefault();
			jQuery(".navbar-collapse").toggleClass('show');
		});
		// main menu click events
		jQuery('.navbar-nav li a').on('click', function(e) {
			console.log($(this).parent().find('ul.dropdown-menu').length);
			jQuery('.navbar-nav li ul.dropdown-menu').removeClass('show');
			if (window.current_menu_id) {
				if (window.current_menu_id == $(this).parent().attr('id')) {
					jQuery(`.navbar-nav li#${window.current_menu_id} ul.dropdown-menu`).addClass('show');
				}
			}
			var $el = $(this).parent().find('ul.dropdown-menu');
			if ($el.length > 0) { // submenu available
				e.preventDefault();
				$el.toggleClass('show');
				if ($el.hasClass('show')) {
					window.current_menu_id = $(this).parent().attr('id');
				} else {
					window.current_menu_id = "";
				}
			}
		})
		$.datepicker.setDefaults({
			showOn: "button",
			buttonImage: "img/datepicker.png",
			buttonText: "Date Picker",
			buttonImageOnly: true,
			dateFormat: 'dd-mm-yy'
		});
		$(function() {
			$("#dob").datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: '1965:2015'
			});
		});
		$("[data-toggle='tooltip']").tooltip(); // Initialize Tooltip
		$("#sscsr_site_logo").hover(
			function() {
				var title = $(this).attr("data-title");
				$('<div/>', {
					text: title,
					class: 'box'
				}).appendTo(this);
			},
			function() {
				$(document).find("div.box").remove();
			}
		);
		$('.panel-body').hide();
		$(document).on('click', '.panel-heading span.clickable', function(e) {
			var $this = $(this);
			if (!$this.hasClass('panel-collapsed')) {
				$this.parents('.panel').find('.panel-body').slideDown();
				$this.addClass('panel-collapsed');
				$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
			} else {
				$this.parents('.panel').find('.panel-body').slideUp();
				$this.removeClass('panel-collapsed');
				$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
			}
		})
		// Know your status
		var baseurl = '<?php echo $getExamDetailsUrl; ?>';
		
		$("#examname").select2({
			language: {
				searching: function() {
					return 'Loading Exam...'; // Custom loading text
				},
			},
			placeholder: 'Select Exam Name',
			ajax: {
				url: baseurl,
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term // search term
					};
				},
				processResults: function(response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
		$('#examname').on('change', function() {
			$('#username').val('');
			$("#dob").datepicker("setDate", "");
		});
		// Know your status
		// Selection Posts Start
		var phasename_baseurl = '<?php echo $this->route->site_url("IndexController/getPhaseDetails"); ?>';
	
		$("#phasename").select2({
			language: {
				searching: function() {
					return 'Loading Phase...'; // Custom loading text
				},
			},
			placeholder: 'Select Phase Name',
			ajax: {
				url: phasename_baseurl,
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term // search term
					};
				},
				processResults: function(response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
		//Selection Posts End 
		//  Admit card Exam Name AJAX
		var baseurl = '<?php echo $this->route->site_url("IndexController/getTierBasedExamDetailsCard"); ?>';
		//$('#admitcard_examname').select2();
		$("#admitcard_examname").select2({
			language: {
				searching: function() {
					return 'Loading Exam...'; // Custom loading text
				},
			},
			placeholder: 'Select Exam Name',
			ajax: {
				url: baseurl,
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term // search term
					};
				},
				processResults: function(response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
		var baseurl2 = '<?php echo $this->route->site_url("IndexController/getTierBasedExamDetailsCardPreview"); ?>';
	///	$('#admitcard_preview_examname').select2();
		$("#admitcard_preview_examname").select2({
			language: {
				searching: function() {
					return 'Loading Exam...'; // Custom loading text
				},
			},
			placeholder: 'Select Exam Name',
			ajax: {
				url: baseurl,
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term // search term
					};
				},
				processResults: function(response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
		var baseurl = '<?php echo $this->route->site_url("IndexController/getTierBasedExamDetailsCity"); ?>';
		//$('#city_examname').select2();
		$("#city_examname").select2({
			language: {
				searching: function() {
					return 'Loading Exam...'; // Custom loading text
				},
			},
			placeholder: 'Select Exam Name',
			ajax: {
				url: baseurl,
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term // search term
					};
				},
				processResults: function(response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
		$('#city_examname').on('change', function() {
			$('#username').val('');
			$("#dob").datepicker("setDate", "");
		});
		$('#roll_number').on("cut copy paste", function(e) {
			e.preventDefault();
		});
		$('#register_number').on("cut copy paste", function(e) {
			e.preventDefault();
		});
		$("#roll_number").keyup(function() {
			$('#post_preference_one').empty();
			var roll_no = $(this).val().trim();
			let examname = $('#admitcard_examname option:selected').val();
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
					success: function(response) {
						//debugger;
						var html = '';
						$.each(response, function(i) {
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
		$('#admitcard_examname').on('change', function() {
			$('#roll_number').val('');
			$('#register_number').val('');
			$('#password').val('');
			$("#dob").datepicker("setDate", "");
			let admitcardExamName = $('#admitcard_examname option:selected').val();
			//debugger;
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
		//  Admit card Exam Name AJAX
		//  Admit card Exam Name AJAX
		var baseurl = '<?php echo $this->route->site_url("IndexController/getTierMaster"); ?>';
		$('#tier_id').select2();
		$("#tier_id").select2({
			language: {
				searching: function() {
					return 'Loading Tier...'; // Custom loading text
				},
			},
			placeholder: 'Select Tier Name',
			ajax: {
				url: baseurl,
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term // search term
					};
				},
				processResults: function(response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
		//  Admit card Exam Name AJAX
		//Photo Gallery
		let year = new Date().getFullYear()
		photogalleryFunction(year);
		//$("#gallery_year").trigger('change');
		function photogalleryFunction(year) {
			//var gallery_id = 	$('#gallery_events ').find('input[name="searchRadio"]:checked').val();
			var baseurl = '<?php echo $this->route->site_url("IndexController/GalleryidBasedImagesWithLightBox"); ?>';
			$.ajax({
				type: "POST",
				url: baseurl,
				data: {
					year: year
				},
				dataType: "json",
				success: function(response) {
					var html = '';
					$.each(response, function(index, value) {
						var imagepath = "gallery/" + value.id;
						var event_id = value.text.split(",");
						html += '<div class="col-md-6 col-lg-3 "> <div class="card border-0 "> <div class="card-body img-container"><img  style="cursor:pointer" id ="' + event_id[1] + '" src="' + imagepath + '" alt="Card Image" width="200" height="200" class="card-img-top  leImage">  <h6 class="eventClass">' + event_id[0] + '</h6> </div> </div> </div>';
					});
					html += "</ul></li>";
					$('#imgGallery').html(html);
					// //light Box Pluggin
					$(".leImage").on("click", function() {
						//$('#imgGallery').html('');
						var id = this.id;
						var baseurl = '<?php echo $this->route->site_url("IndexController/EventBasedLightBox"); ?>';
						$.ajax({
							type: "POST",
							url: baseurl,
							data: {
								id: id
							},
							dataType: "json",
							success: function(response) {
								$('#gallery_year').hide();
								$('#yearId').hide();
								var html = "";
								html += '<button class="btn btn-primary style_btn" onclick="location.reload();" style="background:#a94442">Go Back</button><ul id="lightgallery" class="list-unstyled row">';
								$.each(response, function(index, value) {
									var imagepath = "gallery/" + value.id;
									var event_id = value.text.split(",");
									html += '<li class="col-lg-3 " data-src="' + imagepath + '" data-sub-html="<p>' + event_id[0] + '</p>"><a href=""><img class="img-responsive" style="border: 4px solid #949191;;width:200px;height:200px;margin:10px" src="' + imagepath + '"></a></li>';
								});
								html += "</ul></li>";
								$('#imgGallery').html(html);
								$('#lightgallery').lightGallery({
									mode: "lg-slide",
									cssEasing: "ease",
									easing: "linear",
									speed: 600,
									height: "100%",
									width: "100%",
									addClass: "",
									startClass: "lg-start-zoom",
									backdropDuration: 150,
									hideBarsDelay: 6000,
									useLeft: false,
									closable: true,
									loop: true,
									escKey: true,
									keyPress: true,
									controls: true,
									slideEndAnimatoin: true,
									hideControlOnEnd: false,
									mousewheel: true,
									getCaptionFromTitleOrAlt: true,
									appendSubHtmlTo: ".lg-sub-html",
									subHtmlSelectorRelative: false,
									preload: 1,
									showAfterLoad: true,
									selector: "",
									selectWithin: "",
									nextHtml: "",
									prevHtml: "",
									index: false,
									iframeMaxWidth: "100%",
									download: true,
									counter: true,
									appendCounterTo: ".lg-toolbar",
									swipeThreshold: 50,
									enableSwipe: true,
									enableDrag: true,
									dynamic: false,
									dynamicEl: [],
									galleryId: 1
								});
							}
						});
					});
					//light Box pluggin
				} // Success Function
			}); // ajax End
		}
		$("#gallery_year").on('change', function(e) {
			let year = $(this).val();
			photogalleryFunction(year);
		});
	});
	function photogalleryFunction(gallery_id) {
		//var gallery_id = 	$('#gallery_events ').find('input[name="searchRadio"]:checked').val();
		var baseurl = '<?php echo $this->route->site_url("IndexController/GalleryidBasedImagesWithLightBox"); ?>';
		$.ajax({
			type: "POST",
			url: baseurl,
			data: {
				gallery_id: gallery_id
			},
			dataType: "json",
			success: function(response) {
				var html = '';
				html += '<ul id="lightgallery" class="list-unstyled row">';
				$.each(response, function(index, value) {
					var imagepath = "gallery/" + value.id;
					//html += '<li class="cbp-item web-design logo"><div class="cbp-caption"><div class="cbp-caption-defaultWrap"><img src="'+ imagepath +'" style="height:100%" alt="" class="img-responsive" /></div><div class="cbp-caption-activeWrap"><div class="cbp-l-caption-alignCenter"><div class="cbp-l-caption-body"><a href="'+ imagepath +'" class="cbp-lightbox cbp-l-caption-buttonRight" data-title="SSCSR Image-2">view larger</a></div></div></div></div></li>';
					html += '<li class="col-xs-6 col-sm-4 col-md-3" data-src="' + imagepath + '" data-sub-html="<p>' + value.text + '</p>"><a href=""><img class="img-responsive"  style="border: 10px solid black;height:200px;margin:10px" src="' + imagepath + '"></a></li>';
				});
				html += "</ul></li>";
				//$('#grid-container').css('height','auto');
				$('#imgGallery').html(html);
				//light Box Pluggin
				$('#lightgallery').lightGallery({
					mode: "lg-slide",
					cssEasing: "ease",
					easing: "linear",
					speed: 600,
					height: "100%",
					width: "100%",
					addClass: "",
					startClass: "lg-start-zoom",
					backdropDuration: 150,
					hideBarsDelay: 6000,
					useLeft: false,
					closable: true,
					loop: true,
					escKey: true,
					keyPress: true,
					controls: true,
					slideEndAnimatoin: true,
					hideControlOnEnd: false,
					mousewheel: true,
					getCaptionFromTitleOrAlt: true,
					appendSubHtmlTo: ".lg-sub-html",
					subHtmlSelectorRelative: false,
					preload: 1,
					showAfterLoad: true,
					selector: "",
					selectWithin: "",
					nextHtml: "",
					prevHtml: "",
					index: false,
					iframeMaxWidth: "100%",
					download: true,
					counter: true,
					appendCounterTo: ".lg-toolbar",
					swipeThreshold: 50,
					enableSwipe: true,
					enableDrag: true,
					dynamic: false,
					dynamicEl: [],
					galleryId: 1
				});
				//light Box pluggin
			} // Success Function
		}); // ajax End
	}
</script>
</body>
</html>