<?php 
namespace App\Controllers;
use App\System\Route;
echo $this->get_header();
$route = new Route();
$candidateCorner = $route->site_url("IndexController/candidateCorner");
$admitcard = $route->site_url("IndexController/admitcard");
$knowyourstatus = $route->site_url("IndexController/knowyourstatus");
$knowyourrollno= $route->site_url("IndexController/knowyourrollno");
$knowyourvenuedetails = $route->site_url("IndexController/knowyourvenuedetails");

?>
<!--<section class="section9">
		</section>-->
<section class="buttons sectionClass">
		<div class="container">
			<div class="row breadcrumbruler">
				<div class="col-lg-12">
					<ul class="breadcrumb" style="margin-left:35px;">
						<li><a href="index.php" class="breadcrumb_text_color">Home</a><i class="icon-angle-right"></i></li>
						<li><a href="<?php echo $candidateCorner;?>" class="breadcrumb_text_color">Candidate Corner</a><i class="icon-angle-right"></i></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container" >
		<div class="row rowClass">
		<div class="col-lg-1"></div>
			<div class="col-lg-10">
				<h2>Candidate Corner</h2>
			</div>
			<div class="col-lg-1"></div>
		</div>  
	</div>
	<BR>
   <div class="container marginbot50" id="main">
		<div class="row">
		<div class="col-lg-1"></div>
			<div class="col-lg-10">
				<div>
					<ul>
						<li class="cbp-item graphic">
							
							<a href="<?php echo $knowyourstatus;?>"  rel = "noopener noreferrer" target="_blank"><h4 class="ccn">Know<br>your<br>Application<br>status</h4></a>
                        </li>
						<li class="cbp-item graphic">
							<a href="<?php echo $knowyourvenuedetails;?>" rel = "noopener noreferrer"  target="_blank"><h4 class="ccn">Know your<br>Date and City of Exam</h4></a>
						</li>
						<li class="cbp-item graphic">
							<a href="<?php echo $admitcard;?>" rel = "noopener noreferrer"  target="_blank"><h4 class="ccn">Admit Card <br>or<br> Call Letter</h4></a>
						</li>
					</ul>
				</div>
				<div class="col-lg-1"></div>
			</div>
		</div>
	</div>
   </section>
	<?php include "footer2.php";?>
	<?php include "footer.php";?>
	
	<style>
	/* entire container, keeps perspective */

.graphic{
	list-style-type: none;  
	background: #efc87c;
    border-radius: 40px;
	width: 200px;
    height: 200px;
}
.ccn {
	font-size: 22px;
    text-align: center;
    padding: 41px;
}
.cbp-l-caption-buttonRight{
    background-color: #a94442;
    color: #FFF;
    display: inline-block;
    font: 28px sans-serif;
    text-decoration: none;
    width: 120px !important;
    text-align: center;
    margin: 40px;
    padding: 40px !important;
}
	</style>