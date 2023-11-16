<?php
namespace App\Controllers;
use App\System\Route;
echo $this->get_header();
$route = new Route();
$whats_newpage = $route->site_url("IndexController/viewall");
$selectionpostpage = $route->site_url("IndexController/selectionpost");
$noticepage = $route->site_url("IndexController/notice");
$tenderpage = $route->site_url("IndexController/tender");
?>
<section id="featured" class="bg">
	<!-- start slider -->
	<div class="container-fluid">
		<div class="row">
			<section class="section1 buttons" id="main">
				<div class="container">
					<div class="row">


						<div class="col-lg-5">
							<h3>About SSCSR</h3>
							<p>
								The Staff Selection Commission is functioning under the Department of Personnel & Training, Government of India. Initially known as Subordinate Services Commission, it was set up on 1 July 1976 primarily to make recruitment on zonal basis for non-technical Group C posts under the Central Government, except the post for which recruitment was made by Railway Service Commission and the industrial establishments. The functions of the Staff Selection Commission have been enlarged from time to time and now it carries out the recruitment for Group B posts also under the Central Government. Thus, the Commission recruits for the major work force of the Central Government. This segment constitutes the most vital part of the Government machinery; the posts for which it makes recruitment are at the grass root level which interact with the public and interfaces with the implementation of the Government’s policies.

							</p>
						</div>
						
						<!-- Whats New-->
						<div class=" col-lg-7">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#one" data-toggle="tab"><i class="icon-briefcase"></i><b>Whats New </b></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="one">
			<marquee behavior="scroll" direction="up" scrollamount="3" onmouseover="this.stop();" onmouseout="this.start();" style="height:200px">
				<ul>
					<?php

$current_date = date('Y-m-d');
// Nominations
$nominations_li = array(); // Array to store li values for nominations
if (count($nominations_latest_news) > 0) {
    foreach ($nominations_latest_news as $sn => $nomination) {
        $nomination_date = date('Y-m-d', strtotime($nomination->effect_from_date));
        $li = '<li style="padding:5px">';
        
        $pdfCount = 0; // Counter for PDFs
        foreach ($nominationchildlist_latest_news as $key => $childlist) {
            if ($nomination->nomination_id == $childlist->nomination_id) {
                $pdfCount++;
                $uploadPath = 'nominations' . '/' . $childlist->attachment;
                $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                $li .= '<a style="color:blue;text-decoration:underline" href="' . $file_location . '" rel = "noopener noreferrer" target="_blank">' . $nomination->exam_name."_".$childlist->pdf_name . "(Nomination)" . '</a> |';
            }
        }
        
		if ($current_date == $nomination_date) {
            $li .= '<img src="images/new.gif" style="width:40px">';
        }
        
        $li .= '</li>';
        
        if ($current_date == $nomination_date && $pdfCount > 1) {
            echo $li; // Display the li for the current date and more than one PDF is available
        } else {
            $nominations_li[$nomination_date] = $li;
        }
    }
}

// Selection Posts
$selectionposts_li = array(); // Array to store li values for nominations
if (count($selectionposts_latest_news) > 0) {
    foreach ($selectionposts_latest_news as $sn => $selectionpost) {
		$sp_date = date('Y-m-d', strtotime($selectionpost->effect_from_date));
        $li = '<li style="padding:5px">';
        
        $pdfCount = 0; // Counter for PDFs
        foreach ($selectpostschildlist_latest_news as $key => $childlist) {
			if ($selectionpost->selection_post_id == $childlist->selection_post_id) {
                $pdfCount++;
				$uploadPath = 'selectionposts' . '/' . $childlist->attachment;
                $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                $li .= '<a style="color:blue;text-decoration:underline" href="' . $file_location . '" rel = "noopener noreferrer" target="_blank">' . $selectionpost->exam_name."_".$childlist->pdf_name . "(Selection Post)" . '</a> |';
            }
        }
        
		if ($current_date == $sp_date) {
            $li .= '<img src="images/new.gif" style="width:40px">';
        }
        
        if ($current_date == $sp_date && $pdfCount > 1) {
            echo $li; // Display the li for the current date and more than one PDF is available
        } else {
            $selectionposts_li[$sp_date] = $li;
        }
    }
}

// Notices
$notices_li = array(); // Array to store li values for notices
if (count($notices_latest_news) > 0) {
    foreach ($notices_latest_news as $sn => $noticelist) {
        $nl_date = date('Y-m-d', strtotime($noticelist->effect_from_date));
        $li = '<li style="padding:5px">';
       
        $uploadPath = 'notices' . '/' . $noticelist->attachment;
        $file_location = $this->route->get_base_url() . "/" . $uploadPath;
        $li.= '<a style="color:blue;text-decoration:underline" href="' . $file_location . '" rel = "noopener noreferrer" target="_blank">' . $noticelist->pdf_name . '(Notice)</a>';
		if ($current_date == $nl_date) {
            $p = '<img src="images/new.gif" style="width:40px">';
			$li.= '</li>';
        }
		else{
			$li.= '</li>';
		}
        if ($current_date == $nl_date) {
            echo $li; // Display the li for the current date
            
        } else {
            $notices_li[$nl_date] = $li;
        }
    }
}
// Tenders
$tenders_li = array(); // Array to store li values for tenders
if (count($tenders_latest_news) > 0) {
    foreach ($tenders_latest_news as $sn => $tendercreationlist) {
        $tender_date = date('Y-m-d', strtotime($tendercreationlist->effect_from_date));
        $li = '<li style="padding:5px">';
       
        $uploadPath = 'tender' . '/' . $tendercreationlist->attachment;
        $file_location = $this->route->get_base_url() . "/" . $uploadPath;
        $li.= '<a style="color:blue;text-decoration:underline" href="' . $file_location . '" rel = "noopener noreferrer" target="_blank">' . $tendercreationlist->pdf_name . '(Tender)</a>';
		if ($current_date == $tender_date) {
            $p = '<img src="images/new.gif" style="width:40px">';
			$li.= '</li>';
        }
		else{
			$li.= '</li>';
		}
      
        if ($current_date == $tender_date) {
            echo $li; // Display the li for the current date
            
        } else {
            $tenders_li[$tender_date] = $li;
        }
    }
}
// Display li values for other dates
foreach ($nominations_li as $li) {
    echo $li;
}
foreach ($selectionposts_li as $li) {
    echo $li;
}
foreach ($notices_li as $li) {
    echo $li;
}
foreach ($tenders_li as $li) {
    echo $li;
}
?>
				</ul>
			</marquee>
			
				<div style="margin:10px;padding:10px">
				<div class="btnClass">
										<a href='<?php echo $whats_newpage; ?>' rel = "noopener noreferrer" target="_blank">
											<button class="GFG btn-secondary">
												View All
											</button>
										</a>
									</div>
				</div>
			
			
		</div>
		
	</div>
</div>


						<!-- Whats New-->
						
						
					

					</div>
				</div>
			</section>


			<?php include "footer2.php"; ?>

		</div>
	</div>
</Section>
<style>
	.announcements {
		-webkit-box-shadow: 0px 0px 5px 0px rgb(0 0 0 / 15%);
		-moz-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.15);
		box-shadow: 0px 0px 5px 0px rgb(0 0 0 / 15%);
		padding: 15px;
		border-radius: 5px;
		position: relative;
		margin-bottom: 20px;
		/* border: 2px solid #3D8943; */
		background-color: #ede6e6;

		margin-right: 20px;

		font-weight: 600;
	}

	.announcements .date {
		position: relative;
		bottom: 15px;
		font-size: 9pt;
		font-weight: lighter;
		text-align: end;
		top: 25px;
	}

	.GFG {
		position: relative;
		left: 10px;
		bottom: -4px;
		font-size: 9pt;
		font-weight: lighter;
		color: #fdf9f9 !important;
		background-color: #0c0c0c !important;
		border-radius: 100px !important;

	}

	.btnClass {
		margin: 10px;
	}

	.price-hp {
		position: relative;
		bottom: 7px;
	}

	.mainClass {
		background-color: #ede6e6;
		border-radius: 5px;
		padding: 15px;
	}

	.dateClass {
		float: right;
	}

	.btn-secondary {
		color: #fff;
		background-color: #6c757d !important;
		/* border-color: #6c757d; */
		box-shadow: none;
		border: none !important;
	}

	.btn-info {
		color: #fff;
		background-color: #17a2b8 !important;
		/* border-color: #17a2b8; */
		box-shadow: none;
		border: none !important;
	}

	.btn-primary {
		color: #fff;
		background-color: #007bff !important;
		/* border-color: #007bff; */
		box-shadow: none;
		border: none !important;
	}

	.btn-warning {
		color: #fff;
		background-color: #ffc107 !important;
		/* border-color: #ffc107; */
		box-shadow: none;
		border: none !important;
	}


	.nom_class {
		display: flex;
		flex-direction: column;
		color: #fff;
		font-family: arial;
		list-style: none;
		padding: 0;
		border-radius: 5px;
		padding: 6px;
	}

	.nom_class li {
		background: #285b97;
		border-radius: 3px;
		display: flex;
		flex-direction: row-reverse;
		justify-content: space-between;
		padding: 5px 10px 5px 5px;
		margin: 5px;
	}

	.nom_span_class {
		display: flex;
		padding: 3px 6px;
		justify-content: flex-start;
		color: #285b97;
		font-size: 10px;
		align-self: flex-start;
		text-transform: uppercase;
		background: #acd2ff;
		border-radius: 2px;
		letter-spacing: 1px;
	}
</style>

<?php echo $this->get_footer(); ?>