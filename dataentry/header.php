<?php
 header("Access-Control-Allow-Origin: 10.163.2.181:8080");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header('Content-Type: text/html; charset=utf-8');
header("X-Frame-Options:DENY");
header("X-Content-Type-Options: nosniff");

header("X-XSS-Protection:1; mode=block");
// header("Content-Security-Policy: default-src 'self';");
header("Set-Cookie: HttpOnly");
header("Set-Cookie: name=value; HttpOnly");
header_remove("X-Powered-By");
ini_set('expose_php', 'off');


?>
<!DOCTYPE html>

<head>
	<title>SSCSR</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" type="image/png" sizes="16x16" href="images/logo/logo.png">
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);
		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>

	<!-- bootstrap-css -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- //bootstrap-css -->
	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<!-- font CSS -->
	<link href="css/fonts.googleapis.css" rel='stylesheet' type='text/css'>
	<!-- font-awesome icons -->
	<link rel="stylesheet" href="css/font.css" type="text/css" />
	<!-- //datatable -->

	<script src="js/jquery.js"></script>
	<script src="js/modernizr.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script src="js/screenfull.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="css/responsive.dataTables.min.css">
	<link rel="stylesheet" href="css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="css/responsive.bootstrap4.css">
	<link rel="stylesheet" href="css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="css/select.dataTables.min.css">
	<link rel="stylesheet" href="css/dataTables.checkboxes.css">
	<style>
		.canvasjs-chart-credit {
			display: none;
		}

		.toolbar {
			float: right;
		}

		nav.main-menu {
			overflow-y: scroll !important;
		}
	</style>
	<link href="css/select2.min.css" rel="stylesheet" />
	<!-- <script src="js/select2.js"></script>
<script src="js/select2.min.js"></script> -->
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.responsive.min.js"></script>
	<script src="js/dataTables.buttons.min.js"></script>
	<script src="js/buttons.flash.min.js"></script>
	<script src="js/jszip.min.js"></script>
	<script src="js/pdfmake.min.js"></script>
	<script src="js/vfs_fonts.js"></script>
	<script src="js/buttons.html5.min.js"></script>
	<script src="js/buttons.print.min.js"></script>
	<script src="js/buttons.colVis.min.js"></script>
	<script src="js/dataTables.checkboxes.min.js"></script>
	<script src="js/ColReorderWithResize.js"></script>
	<script src="js/select2.full.min.js"></script>
	<script src="js/jqueryui.js"></script>
	<!---  Sweet Alert  -->
	<script src="js/sweetalert.min.js"></script>
	<script src="js/sweetalert2.js"></script>
	<!---  Sweet Alert  -->
	<!-- //for select2 listbox-->
	<link href="css/select2.min.css" rel="stylesheet" />
	<script src="js/select2.js"></script>
	<script src="js/select2.min.js"></script>
	<!-- //dashboard links-->
	<link rel="stylesheet" href="css/dashboard.css">
	<link rel="stylesheet" href="css/Chart.css">
	<link rel="stylesheet" href="css/fontawesome/css/all.css">

	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<style>
		.footer {
			position: fixed;
			bottom: 0;
			width: 100%;
		}

		.table tfoot input {
			width: 100%;
			box-sizing: border-box;
		}

		.table tfoot {
			display: table-header-group;
		}

		.brand {
			float: left;
			font-size: 18px;
			line-height: 20px;
		}

		.close {
			float: right;
			font-size: 21px;
			font-weight: bold;
			line-height: 1;
			color: #000;
			text-shadow: 0 1px 0 #fff;
			position: relative;
			z-index: 9999 !important;
			top: 66px !important;
			right: 50px !important;
			font-size: 37px;
			padding-right: 10px;
			opacity: 1;
		}
	</style>
	<script>
		$(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);
			if (!screenfull.enabled) {
				return false;
			}
			$('#toggle').click(function () {
				screenfull.toggle($('#container')[0]);
			});
		});
	</script>
	<!-- charts -->
	<script src="js/raphael-min.js"></script>
	<script src="js/morris.js"></script>
	<link rel="stylesheet" href="css/morris.css">
	<!-- //charts -->
	<!--skycons-icons-->
	<script src="js/skycons.js"></script>
	<!--//skycons-icons-->
</head>

<body class="dashboard-page">
	<!--//theme-style-->
	<nav class="main-menu scrollable">
		<li>
			<div class="brand" style="background:white;">
				<a href="#"><img class="logo img-responsive" src="images/logo/logo.png">
					<p style=" font-size: 16px; padding-top:14px; text-align:center">
						STAFF SELECTION COMMISSION
					</p>
					<p style=" font-size: 12px;text-align:center">
						Southern Region, Chennai
					</p>
				</a>
			</div>
		</li>
		<ul>
			<!-- <li>
				<a href="index.php">
				<img class="menu-icon" src="images/icons/dashboard.png"></i>
					<span class="nav-text">
					Dashboard
					</span>
				</a>
			</li> -->
			<!-- <li>
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-edit"></i>
					<p>
						Dashboard
						<i class="fas fa-angle-left right"></i>
					</p>
				</a>
				<ul class="nav nav-treeview" style="display: none;">
					<li class="nav-item">
						<a href="index.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>DashBoard</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Archieves </p>
						</a>
					</li>
				</ul>
			</li> -->
			<li>
				<a href="add_exam.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/add_exam.png"></i>
						Add Exam
					</span>
				</a>
			</li>
			<li>
				<a href="create_table.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/create_table.png"></i>
						Create Table
					</span>
				</a>
			</li>
			<li>
				<a href="upload_excel_file.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/excel_upload.png"></i>
						Excel Upload
					</span>
				</a>
			</li>
			<!-- <li>
				<a href="column_master.php">
					<img class="menu-icon" src="images/icons/column_master.png"></i>
					<span class="nav-text">
						Column Master
					</span>
				</a>
			</li>  -->
			<li>
				<a href="kyas_status_master.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/application_status.png">
						Publish App. Status
					</span>
				</a>
			</li>
			<li>
				<a href="know_your_city_master.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/application_status.png">
						Publish City. Status
					</span>
				</a>
			</li>
			<li>
				<a href="admitcard_preview.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/admitcard_preview.png"></i>
						Admit Card Preview
					</span>
				</a>
			</li>
			<li>
				<a href="exam_tier_master.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/publish_admitcard.png"></i>
						Publish Admit Card
					</span>
				</a>
			</li>
			<li>
				<a href="upload_admitcard_important_instructions.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/add_instruction.png"></i>
						Add Instruction
					</span>
				</a>
			</li>
			<li>
				<a href="admit_card_download_datatable.php">
					<!-- <a href="list_download_admitcard.php"> -->

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/application_status.png"></i>
						Admit card downloaded data
					</span>
				</a>
			</li>
			<li>
				<a href="admitcard_mail.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/send_mail.png"></i>
						Send Mail
					</span>
				</a>
			</li>
			<li>
				<a href="logout.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/logout.png"></i>
						Logout
					</span>
				</a>
			</li>
			<li>
				<a href="reset.php">

					<span class="nav-text">
						<img class="menu-icon" src="images/icons/reset.png"></i>
						Reset Password
					</span>
				</a>
			</li>
		</ul>
	</nav>
	<section class="wrapper scrollable">
		<div style=" font-size: 12px;position: relative;
	top: 17px;
	left: 88%;"><span class="material-icons" id="so" style="color: #a94442;font-size:14px;font-weight: bold; ">
			</span>
		</div>