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
								Sitemap
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
            Sitemap
			</h3>
		</div>
		<div class = "col-lg-1"></div>
	</div>
</div>
	<div class = "container" style="margin-bottom: 10px;">
		<div class = "row">
		<div class = "col-lg-1"></div>
			<div class = "col-lg-10" style="background:#fff; ">
            <h2 class="heading3">Primary menu</h2>
            <ul class="sitemap">
                <li><a href="">Home</a>

                <li><a href="">About</a>
                    <ul>
                        <li><a href="">Committees</a></li>
                        <li><a href="">Record Retension Schedule</a></li>
                        <li><a href="">Citizens Charter</a></li>
                        <li><a href="">Regional Network</a></li>
                        <li><a href="">Background</a></li>
                        <li><a href="contactus">Directory/Contact Us</a></li>
                        <li><a href="">Organisation Chart</a></li>
                        <li><a href="">Setup of Commission</a></li>
                        <li><a href="">Exam</a></li>
                        <li><a href="">Function</a></li>
                    </ul>
                </li>
                <li><a href="">Recruitment</a>
                    <ul>
                        <li><a href="https://ssc.nic.in/SSCFileServer/PortalManagement/UploadedFiles/calender2019_25012019.pdf">Calender of Examination</a></li>
                        <li><a href="https://ssc.nic.in/Portal/SchemeExamination">Scheme of Examinations</a></li>
                        <li><a href="https://ssc.nic.in/Portal/CertificatesFormat">Format of certificates</a></li>
                        <li><a href="IndexController/notice">Notice of Recruitment</a></li>
                        <li><a href="https://ssc.nic.in/Portal/TentativeVacancy">Tentative Vacancy</a></li>
                    </ul>
                </li>

                <li><a href="IndexController/selectionpost">Selection Post</a></li>
                <li><a href="IndexController/nomination">Nomination</a></li>


                <li><a href="">User department</a>
                    <ul>
                        <li><a href="">Annual Typing Test and Proficiency Test</a></li>
                        <li><a href="">Requisition for selection post</a></li>
                    </ul>
                </li>
                <li><a href="IndexController/dlist">Debarred Lists</a></li>
                <li><a href="">RTI</a>
                    <ul>
                        <li><a href="">RTI Act</a></li>
                        <li><a href="">CPIO / Appellete Authority Lists</a></li>
                        <li><a href="">Details of RTI Applications & Reply</a></li>
                        <li><a href="">Proactive disclosure under RTI</a></li>
                    </ul>
                </li>
                <li><a href="IndexController/tender">Tender</a></li>
                <li><a href="IndexController/faq">FAQ</a></li>
                <li><a href="">Download</a>
                    <ul>
                        <li><a href="">Format of Certificates</a></li>
                    </ul>
                </li>

                </li>
            </ul>
   
            <h2 class="heading3">Footer menu</h2>
            <ul class="sitemap">
                <li><a href="contactus">Help</a></li>
                <li><a href="contactus">Contact US</a></li>
                 <li><a href="websitepolicy">Website Policy</a></li>
                 <li><a href="contactus">Contact US</a></li>
                    </ul>

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
		display: flex;  
  flex-wrap: wrap;
	}

	.pageContentClass table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100%;
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