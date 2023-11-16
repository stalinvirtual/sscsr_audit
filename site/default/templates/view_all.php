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
                    <li><a href="<?php echo $this->base_url; ?>" class="breadcrumb_text_color">Home</a><i class="icon-angle-right"></i></li>
                    <li><a href="<?php echo $this->base_url; ?>IndexController/viewall" class="bread">What's New</a><i class="icon-angle-right"></i></li>
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
                    // Sample data (replace this with your retrieved data)
                    $jsonFile = 'Json/data_record.json';
                    $jsonData = file_get_contents($jsonFile);
                    $data = json_decode($jsonData, true);
                    $itemsPerPage = 5;
                    $currentDate = date("Y-m-d");
                    $totalItems = count($data['nominations_latest_news']) + count($data['selectionposts_latest_news']) + count($data['tenders_latest_news']) + count($data['notice_latest_news'])  + count($data['announcements_latest_news']);
                    $totalPages = ceil($totalItems / $itemsPerPage);

                    // Get the current page number from the query parameter
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    $offset = ($page - 1) * $itemsPerPage;

                    // Combine the announcements and nominations data
                    $combinedData = array_merge($data['nominations_latest_news'], $data['selectionposts_latest_news'], $data['tenders_latest_news'], $data['notice_latest_news'], $data['announcements_latest_news']);

                    usort($combinedData, function ($a, $b) {
                        $insertionComparison = strcmp($b['creation_date'], $a['creation_date']);

                        if ($insertionComparison !== 0) {
                            return $insertionComparison;
                        }

                        // If insertion timestamps are equal, compare creation dates
                        return strtotime($b['creation_date']) - strtotime($a['creation_date']);
                    });
                    $combinedDataChild = array_merge($data['nominationchildlist_latest_news'], $data['selectpostschildlist_latest_news'],$data['noticechildlist_latest_news']);

                    // Get the subset of data for the current page
                    $currentPageData = array_slice($combinedData, $offset, $itemsPerPage);
                    foreach ($currentPageData as $entry) {
          
                        $Date = date("Y-m-d", strtotime($entry['effect_from_date']));
                        $li = '<li class="card">';
                        $timestamp = strtotime($Date);
                        $month = date("M", $timestamp);
                        $day = date("d", $timestamp);
                        $year = date("Y", $timestamp);
                        $li .= '<div class="eachNotification" id="announce">
                        <span>' . $month . "<i>" . $day . "</i>" . $year . "</span><p class='English'><hr class='hrClass'>";

                        if (isset($entry['announcement_content'])) {
                            $allowedTags = '<a>';
                            $cleanText = strip_tags($entry['announcement_content'], $allowedTags);
                            $li .=   $cleanText ;
                        } elseif (isset($entry['exam_name'])) {


                            $combinedDataChild = array_merge($data['nominationchildlist_latest_news'], $data['selectpostschildlist_latest_news']);

                            $pdfCount = 0; // Counter for PDFs
                            $pdfs_for_nomination = array();
                            $pdfs_for_selectionpost = array();
                            foreach ($combinedDataChild as $childlist) {
                                if ($entry['nomination_id']) {
                                    if ($entry['nomination_id'] == $childlist['nomination_id']) {


                                        $pdfCount++;
                                        $uploadPath = "nominations" . "/" . $childlist['attachment'];
                                        $file_location = $this
                                            ->route
                                            ->get_base_url() . "/" . $uploadPath;
                                        $pdfs_for_nomination[] = '<a  class="card-link" href="' . $file_location . '" rel = "noopener noreferrer" target="_blank">' . $entry['exam_name'] . "_" . $childlist['pdf_name'] . "(Nomination)" . '</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                                    <small style="font-family:Calibri;">
                                        (' . filesize_formatted($uploadPath) . ')
                                    </small> ';
                                    }
                                } else if ($entry['selection_post_id']) {

                                    if ($entry['selection_post_id'] == $childlist['selection_post_id']) {
                                        $pdfCount++;
                                        $uploadPath = "selectionposts" . "/" . $childlist['attachment'];
                                        $file_location = $this
                                            ->route
                                            ->get_base_url() . "/" . $uploadPath;
                                        $pdfs_for_selectionpost[] = '<a  class="card-link" href="' . $file_location . '" rel = "noopener noreferrer"  target="_blank">' . $entry['exam_name'] . "_" . $childlist['pdf_name'] . "(Selection Post)" . '</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                                <small style="font-family:Calibri;">
                                    (' . filesize_formatted($uploadPath) . ')
                                </small> ';
                                    }
                                }
                               
                            }
                            $li .= implode(' , ', $pdfs_for_nomination);
                            $li .= implode(' , ', $pdfs_for_selectionpost);
                            $li .= implode(' , ', $pdfs_for_notice);

                        }
                        elseif (isset($entry['notice_name'])) {


                            $combinedDataChild = $data['noticechildlist_latest_news'];

                            $pdfCount = 0; // Counter for PDFs
                            $pdfs_for_notice = array();
                           
                            foreach ($combinedDataChild as $childlist) {
                               

                                    if ($entry['notice_id'] == $childlist['notice_id']) {
                                        $pdfCount++;
                                        $uploadPath = "notices" . "/" . $childlist['attachment'];
                                        $file_location = $this
                                            ->route
                                            ->get_base_url() . "/" . $uploadPath;
                                        $pdfs_for_notice[] = '<a  class="card-link" href="' . $file_location . '" rel = "noopener noreferrer" target="_blank">' . $entry['notice_name'] . "_" . $childlist['pdf_name'] . "(Selection Post)" . '</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                                <small style="font-family:Calibri;">
                                    (' . filesize_formatted($uploadPath) . ')
                                </small> ';
                                    }
                                
                               
                            }
                           
                            $li .= implode(' , ', $pdfs_for_notice);

                        } elseif (isset($entry['pdf_name'])) {
                            if ($entry['tender_id']) {

                                $uploadPath = "tender" . "/" . $entry['attachment'];
                                $file_location = $this
                                    ->route
                                    ->get_base_url() . "/" . $uploadPath;
                                $li .= '<a  class="card-link" href="' . $file_location . '" rel = "noopener noreferrer" target="_blank">' . $entry['pdf_name'] . '(Tender)</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                            <small style="font-family:Calibri;">
                            (' . filesize_formatted($uploadPath) . ')
                            </small>';
                            } 
                            // elseif ($entry['notice_id']) {

                            //     $uploadPath = "notices" . "/" . $entry['attachment'];
                            //     $file_location = $this
                            //         ->route
                            //         ->get_base_url() . "/" . $uploadPath;
                            //     $li .= '<a  class="card-link" href="' . $file_location . '" target="_blank">' . $entry['pdf_name'] . '(Notice)</a> <img class="file-icon" alt="" title="pdf document. opens in new tab" src="exam_assets/pdficon.png">
                            //  <small style="font-family:Calibri;">
                            // (' . filesize_formatted($uploadPath) . ')
                            //   </small>';
                            // }
                        }


                        if ($currentDate == $Date) {
                            $li .= '<img src="images/new.gif" style="width: 40px">';
                            $li .= "</li>";
                        } else {
                            $li .= "</li>";
                        }
                        echo $li;
                    }

                    // Generate pagination links
                    echo '<ul class="pagination">';
                    for ($page = 1; $page <= $totalPages; $page++) {
                        $activeClass = ($page === $page) ? 'active' : ''; // Fix here, change $currentPage to $page
                        $urlPath = $_SERVER['PHP_SELF'];
                        echo '<li class="' . $activeClass . '"><a href="IndexController/viewall/?page=' . $page . '">' . $page . '</a></li>';
                    }
                    echo '</ul>';
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
        font-weight: 600;

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
        /* color: #222; */
        font: 500 14px 'Roboto', sans-serif;
    }

    .eachNotification p a:hover {
        color: #428bca;
        text-decoration: underline;
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
    $(document).ready(function() {

        $('#anounce a ').addClass('card-link').attr('target', '_blank');
    });
</script>
<?php include "footer2.php"; ?>
<?php echo $this->get_footer(); ?>