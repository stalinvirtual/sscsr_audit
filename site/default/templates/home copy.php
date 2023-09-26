<?php
namespace App\Controllers;
use App\System\Route;
echo $this->get_header();
$route = new Route();
$whats_newpage = $route->site_url("IndexController/viewall");
$selectionpostpage = $route->site_url("IndexController/selectionpost");
$noticepage = $route->site_url("IndexController/notice");
$tenderpage = $route->site_url("IndexController/tender");
function filesize_formatted($path)
{
    $size = filesize($path);
    $units = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power) , 2, ".", ",") . " " . $units[$power];
}
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
				<ul style="padding:10px">
                                    <?php
                    $current_date = date("Y-m-d");
                    // Initialize an array to store all the content with date as key
                    $all_content = [];

                    // Nominations
                    $nominations_li = []; // Array to store li values for nominations
                    if (count($nominations_latest_news) > 0)
                    {
                        foreach ($nominations_latest_news as $sn => $nomination)
                        {
                            $nomination_date = date("Y-m-d", strtotime($nomination->effect_from_date));
                            $li = '<li class="card">';
                            $timestamp = strtotime($nomination_date);
                            $month = date("M", $timestamp);
                            $day = date("d", $timestamp);
                            $year = date("Y", $timestamp);
                            $li .= '<div class="eachNotification ">
                            <span>' . $month . "<i>" . $day . "</i>" . $year . '</span><p class="English">';

                            $pdfCount = 0; // Counter for PDFs
                            foreach ($nominationchildlist_latest_news as $key => $childlist)
                            {
                                if ($nomination->nomination_id == $childlist->nomination_id)
                                {
                                    $pdfCount++;
                                    $uploadPath = "nominations" . "/" . $childlist->attachment;
                                    $file_location = $this
                                        ->route
                                        ->get_base_url() . "/" . $uploadPath;
                                    $li .= '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $nomination->exam_name . "_" . $childlist->pdf_name . "(Nomination)" . '</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                                    <small style="font-family:Calibri;">
                                        (' . filesize_formatted($uploadPath) . ')
                                    </small> |';
                                }
                            }

                            if ($current_date == $nomination_date)
                            {
                                $li .= '<img src="images/new.gif" style="width:40px">';
                            }

                            $li .= "</li>";

                            if ($current_date == $nomination_date && $pdfCount > 1)
                            {
                                // Display the li for the current date and more than one PDF is available
                                echo $li;
                            }
                            else
                            {
                                // Store the li in the all_content array with date as key
                                if (!isset($all_content[$nomination_date]))
                                {
                                    $all_content[$nomination_date] = [];
                                }
                                // Check if less than 2 items are already displayed for this date
                                if (count($all_content[$nomination_date]) < 2)
                                {
                                    $all_content[$nomination_date][] = $li;
                                }
                            }
                        }
                    }

                    // Selection Posts
                    $selectionposts_li = []; // Array to store li values for nominations
                    if (count($selectionposts_latest_news) > 0)
                    {
                        foreach ($selectionposts_latest_news as $sn => $selectionpost)
                        {
                            $sp_date = date("Y-m-d", strtotime($selectionpost->effect_from_date));
                            $li = '<li class="card">';
                            $timestamp = strtotime($sp_date);
                            $month = date("M", $timestamp);
                            $day = date("d", $timestamp);
                            $year = date("Y", $timestamp);
                            $li .= '<div class="eachNotification ">
                            <span>' . $month . "<i>" . $day . "</i>" . $year . '</span><p class="English">';

                            $pdfCount = 0; // Counter for PDFs
                            foreach ($selectpostschildlist_latest_news as $key => $childlist)
                            {
                                if ($selectionpost->selection_post_id == $childlist->selection_post_id)
                                {
                                    $pdfCount++;
                                    $uploadPath = "selectionposts" . "/" . $childlist->attachment;
                                    $file_location = $this
                                        ->route
                                        ->get_base_url() . "/" . $uploadPath;
                                    $li .= '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $selectionpost->exam_name . "_" . $childlist->pdf_name . "(Selection Post)" . '</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                                    <small style="font-family:Calibri;">
                                        (' . filesize_formatted($uploadPath) . ')
                                    </small> |';
                                }
                            }

                            if ($current_date == $sp_date)
                            {
                                $li .= '<img src="images/new.gif" style="width:40px">';
                            }

                            if ($current_date == $sp_date && $pdfCount > 1)
                            {
                                // Display the li for the current date and more than one PDF is available
                                echo $li;
                            }
                            else
                            {
                                // Store the li in the all_content array with date as key
                                if (!isset($all_content[$sp_date]))
                                {
                                    $all_content[$sp_date] = [];
                                }
                                // Check if less than 2 items are already displayed for this date
                                if (count($all_content[$sp_date]) < 2)
                                {
                                    $all_content[$sp_date][] = $li;
                                }
                            }
                        }
                    }

                    // Notices
                    $notices_li = []; // Array to store li values for notices
                    if (count($notices_latest_news) > 0)
                    {
                        foreach ($notices_latest_news as $sn => $noticelist)
                        {
                            $nl_date = date("Y-m-d", strtotime($noticelist->effect_from_date));
                            $li = '<li class="card">';
                            $timestamp = strtotime($nl_date);
                            $month = date("M", $timestamp);
                            $day = date("d", $timestamp);
                            $year = date("Y", $timestamp);
                            $li .= '<div class="eachNotification ">
                            <span>' . $month . "<i>" . $day . "</i>" . $year . '</span><p class="English">';

                            $uploadPath = "notices" . "/" . $noticelist->attachment;
                            $file_location = $this
                                ->route
                                ->get_base_url() . "/" . $uploadPath;
                            $li .= '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $noticelist->pdf_name . '(Notice)</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                            <small style="font-family:Calibri;">
                                (' . filesize_formatted($uploadPath) . ')
                            </small>';
                            if ($current_date == $nl_date)
                            {
                                $p = '<img src="images/new.gif" style="width:40px">';
                                $li .= "</li>";
                            }
                            else
                            {
                                $li .= "</li>";
                            }

                            if ($current_date == $nl_date)
                            {
                                // Display the li for the current date
                                echo $li;
                            }
                            else
                            {
                                // Store the li in the all_content array with date as key
                                if (!isset($all_content[$nl_date]))
                                {
                                    $all_content[$nl_date] = [];
                                }
                                // Check if less than 2 items are already displayed for this date
                                if (count($all_content[$nl_date]) < 2)
                                {
                                    $all_content[$nl_date][] = $li;
                                }
                            }
                        }
                    }

                    // Tenders
                    $tenders_li = []; // Array to store li values for tenders
                    if (count($tenders_latest_news) > 0)
                    {
                        foreach ($tenders_latest_news as $sn => $tendercreationlist)
                        {
                            $tender_date = date("Y-m-d", strtotime($tendercreationlist->effect_from_date));
                            $li = '<li class="card">';
                            $timestamp = strtotime($tender_date);
                            $month = date("M", $timestamp);
                            $day = date("d", $timestamp);
                            $year = date("Y", $timestamp);
                            $li .= '<div class="eachNotification ">
                            <span>' . $month . "<i>" . $day . "</i>" . $year . '</span><p class="English">';

                            $uploadPath = "tender" . "/" . $tendercreationlist->attachment;
                            $file_location = $this
                                ->route
                                ->get_base_url() . "/" . $uploadPath;
                            $li .= '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $tendercreationlist->pdf_name . '(Tender)</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                            <small style="font-family:Calibri;">
                                (' . filesize_formatted($uploadPath) . ')
                            </small>';
                            if ($current_date == $tender_date)
                            {
                                $p = '<img src="images/new.gif" style="width:40px">';
                                $li .= "</li>";
                            }
                            else
                            {
                                $li .= "</li>";
                            }

                            if ($current_date == $tender_date)
                            {
                                // Display the li for the current date
                                echo $li;
                            }
                            else
                            {
                                // Store the li in the all_content array with date as key
                                if (!isset($all_content[$tender_date]))
                                {
                                    $all_content[$tender_date] = [];
                                }
                                // Check if less than 2 items are already displayed for this date
                                if (count($all_content[$tender_date]) < 2)
                                {
                                    $all_content[$tender_date][] = $li;
                                }
                            }
                        }
                    }

                    //Anouncement
                    $announcement_li = []; // Array to store li values for tenders
                    if (count($announcements_latest_news) > 0)
                    {
                        foreach ($announcements_latest_news as $sn => $announcement_list)
                        {
                            $announcement_date = date("Y-m-d", strtotime($announcement_list->effect_from_date));
                            $li = '<li class="card">';
                            $timestamp = strtotime($announcement_date);
                            $month = date("M", $timestamp);
                            $day = date("d", $timestamp);
                            $year = date("Y", $timestamp);
                            $li .= '<div class="eachNotification  " id="anounce">
                                                <span>' . $month . "<i>" . $day . "</i>" . $year . "</span>";
                            $allowed_tags = "<a>";
                            $clean_text = strip_tags($announcement_list->announcement_content, $allowed_tags);

                            // echo $clean_text;
                            $li .= $announcement_list->announcement_name . " - " . $clean_text;

                            if ($current_date == $announcement_date)
                            {
                                $li .= '<img src="images/new.gif" style="width:40px">';
                                $li .= "</li>";
                            }
                            else
                            {
                                $li .= "</li>";
                            }

                            if ($current_date == $announcement_date)
                            {
                                // Display the li for the current date
                                echo $li;
                            }
                            else
                            {
                                // Store the li in the all_content array with date as key
                                if (!isset($all_content[$announcement_date]))
                                {
                                    $all_content[$announcement_date] = [];
                                }
                                // Check if less than 2 items are already displayed for this date
                                if (count($all_content[$announcement_date]) < 2)
                                {
                                    $all_content[$announcement_date][] = $li;
                                }
                            }
                        }
                    }
                    //Anou8ncement
                    //Anouncement
                    // Sort the content based on date in descending order
                    krsort($all_content);

                    // Display li values for other dates
                    foreach ($all_content as $li_list)
                    {
                        // Display the first two items for each date
                        echo $li_list[0];
                        if (isset($li_list[1]))
                        {
                            echo $li_list[1];
                        }
                    }
                    ?>
                    </ul>


			</marquee>
			
				<div style="margin:10px;padding:10px">
				<div class="btnClass">
										<a href='<?php echo $whats_newpage; ?>' target="_blank">
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






	
	.card {
           width: 100%;
           height: 95px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			/* box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; */
            border-radius: 5px;
            padding: 20px;
            margin: 10px 0px 10px 0px;
            transition: box-shadow 0.3s ease-in-out;
            list-style: none;
			/* border: 1px solid black; */
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-description {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
        }

        .card-link {
            color: #007bff !important;
           
        }

        .card-link:hover {
            text-decoration: underline;
        }
           .eachNotification span {
    color: darkblue;
    font-size: 11px;
    padding-right: 9px;
    float: left;
    width: 8%;
    text-align: center;
}
.leftsideNotifications_New ul li p {
    margin-bottom: 0px;
}
.eachNotification p {
    vertical-align: top;
    float: left;
    width: 92%;
    padding-top: 4px;
    line-height: 22px;
}
#forScrollNews {
    overflow-y: scroll;
}
.scrollingNotifications_New {
    height: 700px;
    overflow: hidden;
}
.scrollingNotifications_New {
    padding: 10px 0px;
}
.scrollingNotifications_New ul {
list-style: none;
}
.leftsideNotifications_New ul {
    left: 0px;
    right: 0px;
    padding: 0px 10px;
    
}
.leftsideNotifications_New ul li {
    line-height: 25px;
}
.leftsideNotifications_New ul li {
    border-bottom: 1px solid #ddd;
    padding: 5px 0px 5px;
}



.eachNotification span i {
    font-weight: 600;
    font-style: normal;
    font-size: 17px;
    display: block;
    margin-top: -8px;
    margin-bottom: -8px;
}
.leftsideNotifications_New ul li p {
    margin-bottom: 0px;
}

.eachNotification p a {
    color: #222;
    font: 500 14px 'Roboto', sans-serif;
}
img.file-icon {
    width: auto !important;
    padding: 3px;
}
.leftsideNotifications_New ul li {
    border-bottom: 1px solid #ddd;
    padding: 5px 0px 5px;
}
</style>
<script>
    $(document).ready(function(){
        
 $('#anounce a ').addClass('card-link').attr('target' ,'_blank');
});
</script>
<?php echo $this->get_footer(); ?>
