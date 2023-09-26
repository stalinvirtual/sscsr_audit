<?php
echo $this->get_header();

function filesize_formatted($path)
{
    $size = filesize($path);
    $units = array(
        'B',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB',
        'EB',
        'ZB',
        'YB'
    );
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}
?>
<section class="buttons">
    <div class="container">
        <div class="row breadcrumbruler">
            <div class="col-lg-12">
                <ul class="breadcrumb">
                    <li><a href="<?php echo $this->base_url; ?>" class="breadcrumb_text_color">Home</a><i
                            class="icon-angle-right"></i></li>
                    <li><a href="<?php echo $this->base_url; ?>IndexController/viewall" class="bread">What's New</a><i
                            class="icon-angle-right"></i></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row rowClass">
            <div class="col-lg-12">
                <h2>What's new</h2>
            </div>
        </div>
    </div>

    <div class="container" id="main">
        <div class="row">
            <div class="col-lg-12">

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <ul class="list-group" style="padding:0px ">
                    <?php
                    $current_date = date('Y-m-d');
                    $all_content = array(); // Initialize an array to store all the content
                    
                    // Nominations
                    $nominations_li = array(); // Array to store li values for nominations
                    if (count((array) $nominations_latest_news) > 0) {
                     
                    
                        foreach ($nominations_latest_news as $sn => $nomination) {
                            $nomination_date = date('Y-m-d', strtotime($nomination->effect_from_date));
                            $li = '<li  class="card">';
                            $timestamp = strtotime($nomination_date);
                            $month = date('M', $timestamp);
                            $day = date('d', $timestamp);
                            $year = date('Y', $timestamp);
                            $li .= '<div class="eachNotification ">
    <span>' . $month . '<i>' . $day . '</i>' . $year . '</span><p class="English">';

                            $pdfCount = 0; // Counter for PDFs
                            $pdfs_for_nomination = array(); // Array to store PDF links for the current nomination
                            foreach ($nominationchildlist_latest_news as $key => $childlist) {
                                if ($nomination->nomination_id == $childlist->nomination_id) {
                                    $uploadPath = 'nominations' . '/' . $childlist->attachment;
                                    $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                                    $pdfs_for_nomination[] = '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $nomination->exam_name . "_" . $childlist->pdf_name . "(Nomination)" . '</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                    <small style="font-family:Calibri;">
                        (' . filesize_formatted($uploadPath) . ')
                    </small>';
                                    $pdfCount++;
                                }
                            }

                            // Combine PDF links for the current nomination with " | " separator
                            $li .= implode(' | ', $pdfs_for_nomination);

                            if ($current_date == $nomination_date) {
                                $li .= '<img src="images/new.gif" style="width:40px">';
                            }

                            $li .= '</li>';

                            if ($current_date == $nomination_date && $pdfCount > 0) {
                                echo $li; // Display the li for the current date and more than one PDF is available
                            } else {
                               // $nominations_li[$nomination_date] = $li;
                                echo $li;
                            }
                            $all_content[] = array(
                                'date' => $nomination_date,
                                'content' => $li
                            );
                        }

                        // ... (existing code below)
                    
                    }

                    // Selection Posts
                    $selectionposts_li = array(); // Array to store li values for nominations
                    if (count((array) $selectionposts_latest_news) > 0) {
                        // ... (existing code above)
                    
                        foreach ($selectionposts_latest_news as $sn => $selectionpost) {
                            $sp_date = date('Y-m-d', strtotime($selectionpost->effect_from_date));
                            $li = '<li  class="card">';
                            $timestamp = strtotime($sp_date);
                            $month = date('M', $timestamp);
                            $day = date('d', $timestamp);
                            $year = date('Y', $timestamp);
                            $li .= '<div class="eachNotification ">
    <span>' . $month . '<i>' . $day . '</i>' . $year . '</span><p class="English">';

                            $pdfCount = 0; // Counter for PDFs
                            $pdfs_for_selectionpost = array(); // Array to store PDF links for the current selection post
                            foreach ($selectpostschildlist_latest_news as $key => $childlist) {
                                if ($selectionpost->selection_post_id == $childlist->selection_post_id) {
                                    $pdfCount++;
                                    $uploadPath = 'selectionposts' . '/' . $childlist->attachment;
                                    $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                                    $pdfs_for_selectionpost[] = '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $selectionpost->exam_name . "_" . $childlist->pdf_name . "(Selection Post)" . '</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
            <small style="font-family:Calibri;">
                (' . filesize_formatted($uploadPath) . ')
            </small>';
                                }
                            }

                            // Combine PDF links for the current selection post with " | " separator
                            $li .= implode(' | ', $pdfs_for_selectionpost);

                            if ($current_date == $sp_date) {
                                $li .= '<img src="images/new.gif" style="width:40px">';
                            }

                            $li .= '</li>';

                            if ($current_date == $sp_date && $pdfCount > 0) {
                                echo $li; // Display the li for the current date and more than one PDF is available
                            } else {
                                $selectionposts_li[$sp_date] = $li;
                            }
                            $all_content[] = array(
                                'date' => $sp_date,
                                'content' => $li
                            );
                        }

                        // ... (existing code below)
                    
                    }

                    // Notices
                    $notices_li = array(); // Array to store li values for notices
                    if (count((array) $notices_latest_news) > 0) {
                        foreach ($notices_latest_news as $sn => $noticelist) {
                            $nl_date = date('Y-m-d', strtotime($noticelist->effect_from_date));
                            $li = '<li  class="card">';
                            $timestamp = strtotime($nl_date);
                            $month = date('M', $timestamp);
                            $day = date('d', $timestamp);
                            $year = date('Y', $timestamp);
                            $li .= '<div class="eachNotification ">
                            <span>' . $month . '<i>' . $day . '</i>' . $year . '</span><p class="English">';

                            $uploadPath = 'notices' . '/' . $noticelist->attachment;
                            $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                            $li .= '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $noticelist->pdf_name . '(Notice)</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                            <small style="font-family:Calibri;">
                                (' . filesize_formatted($uploadPath) . ')
                            </small>';

                            if ($current_date == $nl_date) {
                                $li .= '<img src="images/new.gif" style="width:40px">';
                                $li .= '</li>';
                            } else {
                                $li .= '</li>';
                            }

                            // Avoid adding the pipe symbol for the last notice
                            $is_last_notice = end($notices_latest_news) === $noticelist;
                            if ($current_date == $nl_date && !$is_last_notice) {
                                echo $li; // Display the li for the current date and it's not the last notice
                            } else {
                                // $notices_li[$nl_date] = $li;
                                echo $li; 
                            }
                            
                            $all_content[] = array(
                                'date' => $nl_date,
                                'content' => $li
                            );
                        }
                    }

                    // Tenders
                    $tenders_li = array(); // Array to store li values for tenders
                    if (count((array) $tenders_latest_news) > 0) {
                        foreach ($tenders_latest_news as $sn => $tendercreationlist) {
                            $tender_date = date('Y-m-d', strtotime($tendercreationlist->effect_from_date));
                            $li = '<li  class="card">';
                            $timestamp = strtotime($tender_date);
                            $month = date('M', $timestamp);
                            $day = date('d', $timestamp);
                            $year = date('Y', $timestamp);
                            $li .= '<div class="eachNotification ">
                            <span>' . $month . '<i>' . $day . '</i>' . $year . '</span><p class="English">';

                            $uploadPath = 'tender' . '/' . $tendercreationlist->attachment;
                            $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                            $li .= '<a class="card-link" href="' . $file_location . '" target="_blank">' . $tendercreationlist->pdf_name . '(Tender)</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                            <small style="font-family:Calibri;">
                                (' . filesize_formatted($uploadPath) . ')
                            </small>';

                            if ($current_date == $tender_date) {
                                $li .= '<img src="images/new.gif" style="width:40px">';
                                $li .= '</li>';
                            } else {
                                $li .= '</li>';
                            }

                            // Avoid adding the pipe symbol for the last tender
                            $is_last_tender = end($tenders_latest_news) === $tendercreationlist;
                            if ($current_date == $tender_date && !$is_last_tender) {
                                echo $li; // Display the li for the current date and it's not the last tender
                            } else {
                                // $tenders_li[$tender_date] = $li;
                                echo $li; 
                            }
                            $all_content[] = array(
                                'date' => $tender_date,
                                'content' => $li
                            );
                        }
                    }


                    // Announcements
                    $announcement_li = array();
                    if (count((array) $announcements_latest_news) > 0) {
                        foreach ($announcements_latest_news as $sn => $announcement_list) {
                            $announcement_date = date('Y-m-d', strtotime($announcement_list->effect_from_date));
                            $li = '<li  class="card">';
                            $timestamp = strtotime($announcement_date);
                            $month = date('M', $timestamp);
                            $day = date('d', $timestamp);
                            $year = date('Y', $timestamp);
                            $li .= '<div class="eachNotification  " id="anounce">
                             <span>' . $month . '<i>' . $day . '</i>' . $year . '</span><p class="English">';


                            $allowed_tags = '<a>';
                            $clean_text = strip_tags($announcement_list->announcement_content, $allowed_tags);


                            $li .= $clean_text;

                            if ($current_date == $announcement_date) {

                                $li .= '<img src="images/new.gif" style="width:40px">';
                                $li .= '</li>';
                            } else {
                                $li .= '</li>';
                            }
                            // Avoid adding the pipe symbol for the last tender
                            $is_last_announcement = end($announcements_latest_news) === $announcement_list;
                            if ($current_date == $announcement_date && !$is_last_announcement) {
                                echo $li; // Display the li for the current date and it's not the last tender
                            } else {
                                // $tenders_li[$announcement_date] = $li;
                                echo $li; 
                            }
                            $all_content[] = array(
                                'date' => $announcement_date,
                                'content' => $li
                            );
                        } //fireach
                    } //count
                    

                    // Sort the content based on date in descending order
                    usort($all_content, function ($a, $b) {
                        return strtotime($b['date']) - strtotime($a['date']);
                    });

                    $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                    $urlPath = trim($urlPath, '/');
                    $pathSegments = explode('/', $urlPath);
                    $current_page = end($pathSegments);
                    if ($current_page == "viewall") {
                        $current_page = 1;
                    } else {
                        $current_page = intval($current_page);
                    }
                    $itemsPerPage = 5; // Number of items to display per page
                    $startIndex = ($current_page - 1) * $itemsPerPage;
                    
                    $endIndex = $startIndex + $itemsPerPage;
                  
                  

                    // Display the content for the current page
                    // for ($i = $startIndex; $i < $endIndex && $i < count($all_content); $i++) {
                    //     echo $all_content[$i]['content'];
                    // }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Pagination -->
                <ul class="pagination">
                    <?php
                    $totalPages = ceil(count($all_content) / $itemsPerPage);
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $isActive = ($current_page == $i) ? 'active' : '';
                        echo '<li class="page-item ' . $isActive . '"><a class="page-link" href="IndexController/viewall/' . $i . '">' . $i . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<style>
    .card {
        width: 100%;
        height: 95px;
        background-color: #fff;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        border-radius: 5px;
        padding: 20px;
        margin: 10px 0px 10px 0px;
        transition: box-shadow 0.3s ease-in-out;
        list-style: none;
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
        padding-top: 20px;
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

    .eachNotification p {
        vertical-align: top;
        float: left;
        width: 92%;
        padding-top: 20px;
        line-height: 22px;
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
    $(document).ready(function () {

        $('#anounce a ').addClass('card-link').attr('target', '_blank');
    });
</script>
<?php include "footer2.php"; ?>
<?php echo $this->get_footer(); ?>