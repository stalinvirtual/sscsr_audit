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
    return number_format($size / pow(1024, $power), 2, ".", ",") . " " . $units[$power];
}
?>

<div class="container buttons" style="background:#fff;margin-top:10px;max-width: 88%;">
    <div class="row" style="margin:10px">
        <div class="col-md-3">
            <div class="gandhi">
                <figure><img src="images/gandhi.png" alt=""></figure>
                <p class="gandhi-quote"><span class="match english" style="">"If I have the belief that I
                        can do it, I shall surely acquire the capacity to do it even if I may not have it at
                        the beginning."</span></p>
                <h4 class="gandhi-name"><span class="match english" style="text-align:right">- Mahatma Gandhi</span></h4>
            </div>
            <div class="home-lt-cntnt">
                <img src="images/Azadi_ka_amrit_mahotsav_75.jpg" alt=""></span><span class="match hindi"><img src="images/Azadi_ka_amrit_mahotsav_75_hin.jpg" alt=""></span>
            </div>
            <div class="home-lt-cntnt">
                <img src="images/national_career_service.png" alt="">
            </div>
        </div>
        <div class="col-md-6">
            <!-- Whats New-->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#one" data-toggle="tab"><i class="icon-briefcase"></i><b>What's
                            New </b></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="one">
                    <!-- marque Start-->
                    <marquee behavior="scroll" direction="up" scrollamount="3" onmouseover="this.stop();" onmouseout="this.start();" style="height: 580px">
                        <ul class="marquee-card-style" style="padding:10px">
                            <?php
                            $current_date = date("Y-m-d");
                            // Initialize an array to store all the content with date as key
                            $all_content = [];

                            // Nominations
                            $nominations_li = []; // Array to store li values for nominations
                            if (count((array) $nominations_latest_news) > 0) {
                                foreach ($nominations_latest_news as $sn => $nomination) {
                                    $nomination_date = date("Y-m-d", strtotime($nomination->effect_from_date));
                                    $nomination_creation_date =  date("Y-m-d H:i:s", strtotime($nomination->creation_date));
                                    $li = '<li class=" card">';
                                    $timestamp = strtotime($nomination_date);
                                    $month = date("M", $timestamp);
                                    $day = date("d", $timestamp);
                                    $year = date("Y", $timestamp);
                                    $li .= '<div class="eachNotification ">
                                <span>' . $month . "<i>" . $day . "</i>" . $year . '</span><p class="English"><hr class="hrClass">';

                                    $pdfCount = 0; // Counter for PDFs
                                    $pdfs_for_nomination = array();
                                    foreach ($nominationchildlist_latest_news as $key => $childlist) {
                                        if ($nomination->nomination_id == $childlist->nomination_id) {
                                            $pdfCount++;
                                            $uploadPath = "nominations" . "/" . $childlist->attachment;
                                            $file_location = $this
                                                ->route
                                                ->get_base_url() . "/" . $uploadPath;
                                            $pdfs_for_nomination[] = '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $nomination->exam_name . "_" . $childlist->pdf_name . "(Nomination)" . '</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                                    <small style="font-family:Calibri;">
                                        (' . filesize_formatted($uploadPath) . ')
                                    </small> ';
                                        }
                                    }
                                    $li .= implode(' , ', $pdfs_for_nomination);

                                    if ($current_date == $nomination_date) {
                                        $li .= '<img src="images/new.gif" style="width:40px">';
                                    }

                                    $li .= "</li>";

                                    // if ($current_date == $nomination_date && $pdfCount > 0) {
                                    //     // Display the li for the current date and more than one PDF is available
                                    //     echo $li;
                                    // } else {
                                    // Store the li in the all_content array with date as key
                                    if (!isset($all_content[$nomination_date])) {
                                        $all_content[$nomination_date] = [];
                                    }
                                    // Check if less than 2 items are already displayed for this date
                                    if (count($all_content[$nomination_date]) < 10) {
                                        $all_content[$nomination_date][] = [
                                            'date' => $nomination_date,
                                            'creation_date' => $nomination_creation_date,
                                            'content' => $li,
                                        ];
                                    }
                                    // }
                                }
                            }

                            // Selection Posts
                            $selectionposts_li = []; // Array to store li values for nominations
                            if (count((array) $selectionposts_latest_news) > 0) {
                                foreach ($selectionposts_latest_news as $sn => $selectionpost) {
                                    $sp_date = date("Y-m-d", strtotime($selectionpost->effect_from_date));
                                    $selectionpost_creation_date =  date("Y-m-d H:i:s", strtotime($selectionpost->creation_date));
                                    $li = '<li class="card">';
                                    $timestamp = strtotime($sp_date);
                                    $month = date("M", $timestamp);
                                    $day = date("d", $timestamp);
                                    $year = date("Y", $timestamp);
                                    $li .= '<div class="eachNotification ">
                                   <span>' . $month . "<i>" . $day . "</i>" . $year . '</span><p class="English"><hr class="hrClass">';

                                    $pdfCount = 0; // Counter for PDFs
                                    $pdfs_for_selectionpost = array();
                                    foreach ($selectpostschildlist_latest_news as $key => $childlist) {
                                        if ($selectionpost->selection_post_id == $childlist->selection_post_id) {
                                            $pdfCount++;
                                            $uploadPath = "selectionposts" . "/" . $childlist->attachment;
                                            $file_location = $this
                                                ->route
                                                ->get_base_url() . "/" . $uploadPath;
                                            $pdfs_for_selectionpost[] = '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $selectionpost->exam_name . "_" . $childlist->pdf_name . "(Selection Post)" . '</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                                    <small style="font-family:Calibri;">
                                        (' . filesize_formatted($uploadPath) . ')
                                    </small> ';
                                        }
                                    }
                                    $li .= implode(' , ', $pdfs_for_selectionpost);

                                    if ($current_date == $sp_date) {
                                        $li .= '<img src="images/new.gif" style="width:40px">';
                                    }
                                    $li .= "</li>";
                                    // if ($current_date == $sp_date && $pdfCount > 0) {
                                    //     // Display the li for the current date and more than one PDF is available
                                    //     echo $li;
                                    // } else {
                                    // Store the li in the all_content array with date as key
                                    if (!isset($all_content[$sp_date])) {
                                        $all_content[$sp_date] = [];
                                    }
                                    // Check if less than 2 items are already displayed for this date
                                    if (count($all_content[$sp_date]) < 10) {
                                        $all_content[$sp_date][] = [
                                            'date' => $sp_date,
                                            'creation_date' => $selectionpost_creation_date,
                                            'content' => $li,
                                        ];
                                    }
                                    //}
                                }
                            }

                            // Notices
                            $notice_li = []; // Array to store li values for nominations
                            if (count((array) $notice_latest_news) > 0) {
                                foreach ($notice_latest_news as $sn => $notice) {
                                    $notice_date = date("Y-m-d", strtotime($notice->effect_from_date));
                                    $notice_creation_date =  date("Y-m-d H:i:s", strtotime($notice->creation_date));
                                    $li = '<li class=" card">';
                                    $timestamp = strtotime($notice_date);
                                    $month = date("M", $timestamp);
                                    $day = date("d", $timestamp);
                                    $year = date("Y", $timestamp);
                                    $li .= '<div class="eachNotification ">
                                <span>' . $month . "<i>" . $day . "</i>" . $year . '</span><p class="English"><hr class="hrClass">';

                                    $pdfCount = 0; // Counter for PDFs
                                    $pdfs_for_notice = array();
                                    foreach ($noticechildlist_latest_news as $key => $childlist) {
                                        if ($notice->notice_id == $childlist->notice_id) {
                                            $pdfCount++;
                                            $uploadPath = "notices" . "/" . $childlist->attachment;
                                            $file_location = $this
                                                ->route
                                                ->get_base_url() . "/" . $uploadPath;
                                            $pdfs_for_notice[] = '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $notice->notice_name . "_" . $childlist->pdf_name . "(Notice)" . '</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                                    <small style="font-family:Calibri;">
                                        (' . filesize_formatted($uploadPath) . ')
                                    </small> ';
                                        }
                                    }
                                    $li .= implode(' , ', $pdfs_for_notice);

                                    if ($current_date == $notice_date) {
                                        $li .= '<img src="images/new.gif" style="width:40px">';
                                    }

                                    $li .= "</li>";

                                    
                                    // Store the li in the all_content array with date as key
                                    if (!isset($all_content[$notice_date])) {
                                        $all_content[$notice_date] = [];
                                    }
                                    // Check if less than 2 items are already displayed for this date
                                    if (count($all_content[$notice_date]) < 10) {
                                        $all_content[$notice_date][] = [
                                            'date' => $notice_date,
                                            'creation_date' => $notice_creation_date,
                                            'content' => $li,
                                        ];
                                    }
                                    // }
                                }
                            }


                            // $notices_li = []; // Array to store li values for notices
                            // if (count((array) $notices_latest_news) > 0) {
                            //     foreach ($notices_latest_news as $sn => $noticelist) {
                            //         $nl_date = date("Y-m-d", strtotime($noticelist->effect_from_date));
                            //         $notice_creation_date =  date("Y-m-d H:i:s", strtotime($noticelist->creation_date));
                            //         $li = '<li class="card">';
                            //         $timestamp = strtotime($nl_date);
                            //         $month = date("M", $timestamp);
                            //         $day = date("d", $timestamp);
                            //         $year = date("Y", $timestamp);
                            //         $li .= '<div class="eachNotification ">
                            //         <span>' . $month . "<i>" . $day . "</i>" . $year . '</span><p class="English"><hr class="hrClass">';

                            //         $uploadPath = "notices" . "/" . $noticelist->attachment;
                            //         $file_location = $this
                            //             ->route
                            //             ->get_base_url() . "/" . $uploadPath;
                            //         $li .= '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $noticelist->pdf_name . '(Notice)</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                            //      <small style="font-family:Calibri;">
                            //     (' . filesize_formatted($uploadPath) . ')
                            //       </small>';
                            //         if ($current_date == $nl_date) {
                            //             $li .= '<img src="images/new.gif" style="width:40px">';
                            //             $li .= "</li>";
                            //         } else {
                            //             $li .= "</li>";
                            //         }

                            //         // if ($current_date == $nl_date) {
                            //         //     // Display the li for the current date
                            //         //     echo $li;
                            //         // } else {
                            //         // Store the li in the all_content array with date as key
                            //         if (!isset($all_content[$nl_date])) {
                            //             $all_content[$nl_date] = [];
                            //         }
                            //         // Check if less than 2 items are already displayed for this date
                            //         if (count($all_content[$nl_date]) < 10) {
                            //             $all_content[$nl_date][] = [
                            //                 'date' => $nl_date,
                            //                 'creation_date' => $notice_creation_date,
                            //                 'content' => $li,
                            //             ];
                            //             // }
                            //         }
                            //     }
                            // }

                            // Tenders
                            $tenders_li = []; // Array to store li values for tenders
                            if (count((array) $tenders_latest_news) > 0) {
                                foreach ($tenders_latest_news as $sn => $tendercreationlist) {
                                    $tender_date = date("Y-m-d", strtotime($tendercreationlist->effect_from_date));
                                    $tendercreation_creation_date =  date("Y-m-d H:i:s", strtotime($tendercreationlist->creation_date));
                                    $li = '<li class="card">';
                                    $timestamp = strtotime($tender_date);
                                    $month = date("M", $timestamp);
                                    $day = date("d", $timestamp);
                                    $year = date("Y", $timestamp);
                                    $li .= '<div class="eachNotification ">
                                 <span>' . $month . "<i>" . $day . "</i>" . $year . '</span><p class="English"><hr class="hrClass">';

                                    $uploadPath = "tender" . "/" . $tendercreationlist->attachment;
                                    $file_location = $this
                                        ->route
                                        ->get_base_url() . "/" . $uploadPath;
                                    $li .= '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $tendercreationlist->pdf_name . '(Tender)</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                                <small style="font-family:Calibri;">
                                (' . filesize_formatted($uploadPath) . ')
                                </small>';
                                    if ($current_date == $tender_date) {
                                        $li .= '<img src="images/new.gif" style="width:40px">';
                                        $li .= "</li>";
                                    } else {
                                        $li .= "</li>";
                                    }

                                    // if ($current_date == $tender_date) {
                                    //     // Display the li for the current date
                                    //     echo $li;
                                    // } else {
                                    // Store the li in the all_content array with date as key
                                    if (!isset($all_content[$tender_date])) {
                                        $all_content[$tender_date] = [];
                                    }
                                    // Check if less than 2 items are already displayed for this date
                                    if (count($all_content[$tender_date]) < 10) {
                                        $all_content[$tender_date][] = [
                                            'date' => $tender_date,
                                            'creation_date' => $tendercreation_creation_date,
                                            'content' => $li,
                                        ];
                                    }
                                    // }
                                }
                            }

                            //Anouncement
                            $announcement_li = []; // Array to store li values for tenders
                            if (count((array) $announcements_latest_news) > 0) {
                                foreach ($announcements_latest_news as $sn => $announcement_list) {
                                    $announcement_date = date("Y-m-d", strtotime($announcement_list->effect_from_date));
                                    $announcement_creation_date =  date("Y-m-d H:i:s", strtotime($announcement_list->creation_date));
                                    $li = '<li class="card">';
                                    $timestamp = strtotime($announcement_date);
                                    $month = date("M", $timestamp);
                                    $day = date("d", $timestamp);
                                    $year = date("Y", $timestamp);
                                    $li .= '<div class="eachNotification  " id="anounce" style="margin-top:15px">
                                                <span>' . $month . "<i>" . $day . "</i>" . $year . "</span><p class='English'><hr class='hrClass'>";
                                    // $allowed_tags = "<a class='card-link'>";
                                    // $clean_text = strip_tags($announcement_list->announcement_content, $allowed_tags);

                                    // // echo $clean_text;
                                    // $li .= $clean_text;
                                    $allowed_tags = '<a>';
                                    $clean_text = strip_tags($announcement_list->announcement_content, $allowed_tags);


                                    $li .= $clean_text;

                                    if ($current_date == $announcement_date) {
                                        $li .= '<img src="images/new.gif" style="width:40px">';
                                        $li .= "</li>";
                                    } else {
                                        $li .= "</li>";
                                    }

                                    // if ($current_date == $announcement_date) {
                                    //     // Display the li for the current date
                                    //     echo $li;
                                    // } else {
                                    // Store the li in the all_content array with date as key
                                    if (!isset($all_content[$announcement_date])) {
                                        $all_content[$announcement_date] = [];
                                    }
                                    // Check if less than 2 items are already displayed for this date
                                    if (count($all_content[$announcement_date]) < 10) {
                                        $all_content[$announcement_date][] = [
                                            'date' => $announcement_date,
                                            'creation_date' => $announcement_creation_date,
                                            'content' => $li,
                                        ];
                                        // }
                                    }
                                }
                            }
                            //Anou8ncement
                            //Anouncement


                             krsort($all_content);

                            foreach ($all_content as $date => $contentList) {
                                usort($contentList, function ($a, $b) {
                                    return strtotime($b['creation_date']) - strtotime($a['creation_date']);
                                });

                                $all_content[$date] = $contentList;
                            }
                            // krsort($all_content);
                            // echo '<pre>';
                            // print_r($all_content);
                            // exit;

                            // Loop through the sorted all_content array and display the content
                            foreach ($all_content as $date => $contentList) {
                                foreach ($contentList as $contentData) {
                                    echo $contentData['content'];
                                }
                            }
                            ?>
                        </ul>
                    </marquee>

                        <!-- marque Start-->

                        <!-- View All Button-->
                        <div>
                            <div class="btnClass">
                                <a href='<?php echo $whats_newpage; ?>' class="btn btn-primary" target="_blank">

                                    View All

                                </a>
                            </div>
                        </div>
                        <!-- View All Button-->

                </div>
            </div>



            <!-- Whats New-->

        </div>
        <div class="col-md-3 gallery_margin">


            <div class="current-event">
                <div style=";border-radius:20px; ">
                    <h3 class="photogalleryClass" style="color:#a94442">Photo Gallery</h3>
                    <div class="gallery">

                        <?php
                        $t = (array) $gallery_id_based_images;
                        $gallery_count = count($t);
                        if ($gallery_count > 0) {
                            for ($i = 0; $i < $gallery_count; $i++) {
                                if ($i == 1) {
                                    break;
                                }
                                $path = "gallery/" . $t[$i]->image_path;
                                echo '<section class="card">
								<a href="IndexController/gallerypage" target="_blank" >
													<figure>
													<img src="' . $path . '" alt="" />
													<figcaption>Image-1 <small>Description</small></figcaption>
												  </figure>
												  </a>
												  </section>';
                            }
                        }
                        ?>

                    </div>
                </div>
                <div class="cbp-l-loadMore-button" style="text-align:center">
                    <a href="IndexController/gallerypage" target="_blank" class="btn btn-primary">VIEW ALL</a>
                </div>

            </div>
            <br>

            <div class="current-event">
                <div class=" home-important-style">

                    <h4 style="text-align: center; color:#a94442">Important Links</h4>
                    <?php
                    foreach (@$ilinkforFirstFourRow as $sn => $firstFourRow) { ?>
                        <div class="item">
                            <i class="fa fa-link" aria-hidden="true"></i>
                            <div class="filename">
                                <?php if($firstFourRow->link_name == 'Archives'){?>
                                    <a  target='_blank' href="<?= $firstFourRow->menu_link ?>"><?= $firstFourRow->link_name ?></a>
                                    <?php }else{?>
                                    <a class=" page-permission" target='_blank' href="<?= $firstFourRow->menu_link ?>"><?= $firstFourRow->link_name ?></a>
                                    <?php }?>
                                </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <br>

        </div>
    </div>
</div>

<?php include "footer2.php"; ?>
<style>
    a.btn-primary {
        color: #fff;
        background-color: #a94442 !important;

        box-shadow: none;
        border: none !important;
    }

    img {
        max-width: 100%;
        height: auto;
        vertical-align: middle;
    }

    .nav-tabs>li {
        float: none !important;
    }

    .nav-tabs>li.active>a,
    .nav-tabs>li.active>a:hover,
    .nav-tabs>li.active>a:focus {
        color: #fff !important;
        background-color: #a94442;
    }

    .home-lt-cntnt {
        display: flex;
        justify-content: center;
        /* background: #fff; */
        margin-bottom: 15px;
        /* padding: 5px; */
        border-radius: 5px;
        /* margin-left: 28px; */
        box-shadow: 0px 2px 5px 3px #bebdbd;
    }

    .current-event {
        /* padding: 12px 10px; */
        /* background: #fff; */
        /* border-radius: 5px; */
    }

    .current-event a img {
        width: 100%;
    }

    .gandhi {
        /* margin-bottom: 8px; */
        background: #e2e3dd;
        /* padding: 0 5px; */
        /* margin-left: 28px;    */
        border-radius: 10px;
        box-shadow: 0px 2px 5px 3px #bebdbd;
    }

    .gandhi figure {
        display: flex;
        justify-content: center;
        margin-bottom: 5px;
    }

    .gandhi-quote {
        font-size: 13px;
        font-style: italic;
        text-align: center;
        margin-bottom: 10px;
        padding: 10px;
    }

    .gandhi-name {
        text-align: end;
        padding-right: 10px;
    }

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







    .marquee-card-style .card {
        width: 100%;
        height: 95px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        border-radius: 5px;
        padding: 8px 20px 20px 20px;
        margin: 10px 0px 10px 0px;
        transition: box-shadow 0.3s ease-in-out;
        list-style: none;
        /* border: 1px solid black; */
    }

    .marquee-card-style .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .marquee-card-style .card-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .marquee-card-style .card-description {
        font-size: 16px;
        color: #333;
        margin-bottom: 15px;
    }

    .marquee-card-style .card-link {
        color: #007bff !important;

    }

    .marquee-card-style .card-link:hover {
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

    .home-rw {
        /* margin-top: 5px; */
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

    .home-important-style .container {
        max-width: 345px;
        margin: auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
        font-weight: 600;
    }

    .home-important-style h1 {
        font-size: 32px;
        text-align: center;
        font-weight: 500;
        margin-bottom: 24px;
    }

    .home-important-style .item {
        /* border: 2px solid #222222; */
        padding: 5px;
        border-radius: 8px;
        display: flex;
        gap: 16px;
        align-items: center;
        will-change: transform;
        background-color: #a94442;
        transition: all 0.3s ease-in-out;
        margin-top: 16px;
    }

    .home-important-style .item:hover {
        /* border-color: #7e3af2; */
        transform: scale(1.025);
    }



    .home-important-style .item button {
        all: unset;
        margin-left: auto;
        background-color: #7e3af2;
        padding: 12px 16px;
        border-radius: 6px;
        color: #ffffff;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .eachNotification a {
        color: #007BFF !important;

    }

    .home-important-style .item button:hover {
        background-color: #7126f1;
    }

    .home-important-style .item .filedata {
        display: flex;
        gap: 4px;
        font-size: 12px;
        margin-top: 8px;
        color: #888888;
    }

    .home-important-style .filename p {
        margin: 0px auto;
        font-family: sans-serif;
        color: #fff;
    }

    .home-important-style .item .fa {
        color: #fff;
    }

    .gallery .card {
        flex: 0 0 300px;
        margin: 10px;
        border: 1px solid #ccc;
        box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3);
        text-align: center;
    }


    .gallery .texts {
        padding: 5px;
        margin-bottom: 10px;
    }

    .gallery .texts button {
        border: none;
        padding: 5px 15px;
        background: #566270;
        color: #fff;
        font-weight: 600;
        transition: all 0.3s ease-in;
    }

    .gallery .texts button:hover {
        background: #E0E3DA;
        color: #566270;
        cursor: pointer;
    }

    .filename a {
        color: #fff !important;
    }

    .navbar-collapse,
    .dropdown-menu {
        display: none;
    }

    /* Show the navigation and submenus when the menu button is clicked */
    .navbar-collapse.show,
    .dropdown-menu.show {
        display: block;
    }

    .show {
        display: block !important;
    }
</style>

<?php echo $this->get_footer(); ?>