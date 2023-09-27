<!-- session -->
<?php
require_once("config/db.php");
require_once("functions.php");
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
							<div class="col-md-12 form-group">
								<h4>Admit Card Preview</h4>
							</div>
						</div>
					</div>
					<div class="form-body">
						<div class="row">
							<div class="col-md-12 form-group videoWrapper" style="background:#faebeb">

<object width="100%" height="650px" data="/sscsr_audit/site/IndexController/admitcardpreview" ></object>
							</div>
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


<style>
	.videoWrapper {
		position: relative;
		padding-bottom: 56.25%;
		/* 16:9 */
		padding-top: 25px;
		height: 0;
	}

	.videoWrapper iframe {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
	}
	.admitcard-preview-wrapper{
		background: #fff !important;
	}
</style>