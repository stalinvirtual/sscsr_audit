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
							<div class="col-md-12 form-group">
								<h4>SSCSR Column Details</h4>
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
			url: "load_column_details.php",
			method: "GET",
			success: function (data) {
				$('#examdata').html(data);
			}
		});


	});
</script>