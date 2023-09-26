<?php
echo $this->get_header();
?>


<section class="mt-4 mb-2 faq tn-style">
	<div class="container pb-2">
		<div class="row">
			<div class="col-lg-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li><a href="index.php" class="breadcrumb_text_color">Home</a><i class="icon-angle-right"></i>
						</li>
						<li><a href="#" class="bread">
								<?php echo $page->title; ?>
							</a><i class="icon-angle-right"></i></li>
					</ol>
				</nav>
			</div>
		</div>
		<div class = "container" >
		<div class = "row">
		<div class = "col-lg-1"></div>
			<div class = "col-lg-10 breadcrumb-title">
			<h3 class="lang" style="text-align:center; color : white ;">
				<?php echo $page->title; ?>
			</h3>
		</div>
		<div class = "col-lg-1"></div>
	</div>
</div>
	<div class = "container" style="margin-bottom: 10px;">
		<div class = "row">
		<div class = "col-lg-1"></div>
			<div class = "col-lg-10" style="background:#fff; ">
			<?php

 if ($page->page_content == '' && $page->status == 0) {
	echo $page->last_content;
} else if ($page->page_content != '' && $page->status == 1) { ?>

	<div class="pageContentClass ">
		<?php echo $page->page_content; ?>
	</div>
 <?php } else {
	echo "Somthing Went Wront!...";
 }
?>
			</div>
			<div class = "col-lg-1"></div>
		</div>
	</div>


	
</section>
<style>
	.container.form {
		height: auto;
		background: #faebeb;
		margin: 10px 479px 10px 285px;
		width:auto;
	}
	.breadcrumb-content.pageContentClass p{
		/* display: flex;  
  flex-wrap: wrap; */
  overflow-x:hidden;
  inline-size: 150px;
    overflow-wrap: break-word;
	}
	.pageContentClass a {
		color: #428bca !important;
		text-decoration: underline !important;
		
  flex-wrap: wrap;
	}

	.pageContentClass table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100% !important;
	}

	.pageContentClass td,
	.pageContentClass th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
	}

	.pageContentClass tr:nth-child(even) {
		background-color: #dddddd;
	}
</style>

<?php include "footer2.php"; ?>
<?php echo $this->get_footer(); ?>