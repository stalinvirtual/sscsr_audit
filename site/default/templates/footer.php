<?php 
namespace App\Controllers;
use App\Helpers\Helpers;
$encryptionKey = bin2hex(random_bytes(32)); 
$encryptedValue = Helpers::encryptData("2", $encryptionKey);
?>
<section class="section5 buttons">
	<div class="container-fluid bgColor">
		<div class="row" style="background:#a94442;">
			<div class="col-sm-5 col-lg-5">
			</div>
			<div class="col-sm-7 col-lg-7">
				<div class="footerClass">
					<?php echo $renderedFooterMenu; ?>
				</div>
			</div>
		</div>
		<div class="row footerFont">
			<div class="col-sm-1 col-lg-1 ">
			</div>
			<div class="col-sm-2 col-lg-2  nicLogo">
				<img src="exam_assets/niclogo.png"
					alt="National Informatics Centre opens a new window" width="150"></a>
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
	$(document).ready(function () {
		//Mobile Menu Design
		jQuery(".butttons").on('click', function (e) {
			e.preventDefault();
			jQuery(".navbar-collapse").toggleClass('show');
		});
		// main menu click events
		jQuery('.navbar-nav li a').on('click', function (e) {
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
		$(function () {
			$("#dob").datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: '1965:2015'
			});
		});
		$("[data-toggle='tooltip']").tooltip(); // Initialize Tooltip
		$("#sscsr_site_logo").hover(
			function () {
				var title = $(this).attr("data-title");
				$('<div/>', {
					text: title,
					class: 'box'
				}).appendTo(this);
			},
			function () {
				$(document).find("div.box").remove();
			}
		);
		$('.panel-body').hide();
		$(document).on('click', '.panel-heading span.clickable', function (e) {
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
		var baseurl = '<?php echo $this->route->site_url("IndexController/getExamDetails/q/$encryptedValue"); ?>';
		$('#examname').select2();
		$('#examname').select2({
			language: {
				searching: function () {
					return 'Loading Exam...'; // Custom loading text
				},
			},
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
			$('#username').val('');
			$("#dob").datepicker("setDate", "");
		});
		// Know your status
		// Selection Posts Start
		var baseurl = '<?php echo $this->route->site_url("IndexController/getPhaseDetails/q/$encryptedValue"); ?>';
		$('#phasename').select2();
		$('#phasename').select2({
			placeholder: 'Select Phase Name',
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
		// var baseurl = '<?php //echo $this->route->site_url("IndexController/getGalleryYears/q/2"); 
		?> ';  
		
		//Selection Posts End 
		//  Admit card Exam Name AJAX
		var baseurl = '<?php echo $this->route->site_url("IndexController/getTierBasedExamDetailsCard/q/$encryptedValue"); ?>';
		$('#admitcard_examname').select2();
		$('#admitcard_examname').select2({
			language: {
				searching: function () {
					return 'Loading Exam...'; // Custom loading text
				},
			},
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
		var baseurl2 = '<?php echo $this->route->site_url("IndexController/getTierBasedExamDetailsCardPreview/q/$encryptedValue"); ?>';
		$('#admitcard_preview_examname').select2();
		$('#admitcard_preview_examname').select2({
			language: {
				searching: function () {
					return 'Loading Exam...'; // Custom loading text
				},
			},
			placeholder: 'Select Exam Name',
			ajax: {
				url: baseurl2,
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
		var baseurl = '<?php echo $this->route->site_url("IndexController/getTierBasedExamDetailsCity/q/$encryptedValue"); ?>';
		$('#city_examname').select2();
		$('#city_examname').select2({
			language: {
				searching: function () {
					return 'Loading Exam...'; // Custom loading text
				},
			},
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
		$('#city_examname').on('change', function () {
			$('#username').val('');
			$("#dob").datepicker("setDate", "");
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
					success: function (response) {
						//debugger;
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
		$('#admitcard_examname').on('change', function () {
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
		var baseurl = '<?php echo $this->route->site_url("IndexController/getTierMaster/q/$encryptedValue"); ?>';
		$('#tier_id').select2();
		$('#tier_id').select2({
			placeholder: 'Select Tier Name',
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
				success: function (response) {
					var html = '';
					$.each(response, function (index, value) {
						var imagepath = "gallery/" + value.id;
						var event_id = value.text.split(",");
						html += '<div class="col-md-6 col-lg-3 "> <div class="card border-0 "> <div class="card-body img-container"><img  style="cursor:pointer" id ="' + event_id[1] + '" src="' + imagepath + '" alt="Card Image" width="200" height="200" class="card-img-top  leImage">  <h6 class="eventClass">' + event_id[0] + '</h6> </div> </div> </div>';
					});
					html += "</ul></li>";
					$('#imgGallery').html(html);
					// //light Box Pluggin
					$(".leImage").on("click", function () {
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
							success: function (response) {
								$('#gallery_year').hide();
								$('#yearId').hide();
								var html = "";
								html += '<button class="btn btn-primary style_btn" onclick="location.reload();" style="background:#a94442">Go Back</button><ul id="lightgallery" class="list-unstyled row">';
								$.each(response, function (index, value) {
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
		$("#gallery_year").on('change', function (e) {
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
			success: function (response) {
				var html = '';
				html += '<ul id="lightgallery" class="list-unstyled row">';
				$.each(response, function (index, value) {
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