<?php
namespace App\Helpers;
require_once(__DIR__ . "/../../dompdf/vendor/autoload.php");
require(__DIR__ . "/../../dompdf/autoload.inc.php");
require(__DIR__ . "/../../dompdf/vendor/dompdf/dompdf/src/Dompdf.php");
//require(__DIR__ . "/../../dompdf/vendor/setasign/Fpdi/Fpdi.php");
//  require(__DIR__ . "/../../fpdi2/src/autoload.php");
// require(__DIR__ . "/../../fpdi2/src/fpdf/fpdf.php");
//  use setasign\Fpdi\Fpdi;
//  use setasign\Fpdi\PdfReader;
//echo __DIR__ . "/../../dompdf/vendor/autoload.php";
require("functions.php");
use Dompdf\Dompdf;
class PdfHelper extends Dompdf
{
   public static $PDF_TEMPLATE_PATH = __DIR__ . "/../../pdf/templates";
   public static function genereateAndDownloadAdminCard($data)
   {
      ob_start();
      $document = new Dompdf();
      // global $base_url;
      // echo '@@@@@'. $base_url;
      // exit;


      // echo '<pre>';
      // print_r($data['admitcardresults']);
      // exit;




      $exam_short_name = $data['exam_name']->table_exam_short_name;
      $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
      $tier_id = $data['tier_id'];
      $pdfname = $data['pdf_name'];
      foreach ($data['admitcardresults'] as $value) {
         if ($value["col_name"] == "paper1") {
            $paper1 = $value["col_value"];
         }
         if ($value["col_name"] == "paper2") {
            $paper2 = $value["col_value"];
         }
         if ($value["col_name"] == "paper3") {
            $paper3 = $value["col_value"];
         }
         if ($value["col_name"] == "paper4") {
            $paper4 = $value["col_value"];
         }
         if ($value["col_name"] == "reg_no") {
            $file_name = $value["col_value"];
         }
         if ($value["col_name"] == "pet_date") {
            $pet_col_description = $value["col_description"];
            $date = $value["col_value"];
            //$pet_date = getDobFormat($date);
         }
         if ($value["col_name"] == "dob") {
            $dob_col_description = $value["col_description"];
            $date = $value["col_value"];
            //$dob_date = getDobFormat($date);
         }
         switch ($value["is_tier_order"]) {
            case "1":
               //ac_main_title 
               $key1 = $value["col_description"];
               $value1 = $value["col_value"];
               break;
            case "2":
               //ac_sub_title
               $key2 = $value["col_description"];
               $value2 = $value["col_value"];
               break;
            case "3":
               //reg_no
               $key3 = $value["col_description"];
               $value3 = $value["col_value"];
               break;
            case "4":
               //roll_no
               $key4 = $value["col_description"];
               $value4 = $value["col_value"];
               break;
            case "5":
               // ticket_no
               $key5 = $value["col_description"];
               $value5 = $value["col_value"];
               break;
            case "6":
               //scribe_opted_medium
               $key6 = $value["col_description"];
               $value6 = $value["col_value"];
               break;
            case "7":
               // password_for_examination
               $key7 = $value["col_description"];
               $value7 = $value["col_value"];
               //echo $value7;
               break;
            case "8":
               //gender
               $key8 = $value["col_description"];
               $value8 = $value["col_value"];
               break;
            case "9":
               // post_preference
               $key9 = $value["col_description"];
               $value9 = $value["col_value"];
               break;
            case "10":
               //repotime
               $key10 = $value["col_description"];
               $value10 = valueAdded($value["col_value"]);
               break;
            case "62":
               //repotime1
               $key62 = $value["col_description"];
               $value62 = valueAdded($value["col_value"]);
               break;
            case "63":
               //repotime2
               $key63 = $value["col_description"];
               $value63 = valueAdded($value["col_value"]);
               break;
            case "64":
               //gateclose1
               $key64 = $value["col_description"];
               $value64 = valueAdded($value["col_value"]);
               break;
            case "65":
               //gateclose2
               $key65 = $value["col_description"];
               $value65 = valueAdded($value["col_value"]);
               break;
            case "66":
               //repotime_admit1
               $key66 = $value["col_description"];
               $value66 = valueAdded($value["col_value"]);
               break;
            case "67":
               //repotime_admit2
               $key67 = $value["col_description"];
               $value67 = $value["col_value"];
               break;
            case "68":
               //gateclose_admit1
               $key68 = $value["col_description"];
               $value68 = valueAdded($value["col_value"]);
               break;
            case "69":
               //gateclose_admit2
               $key69 = $value["col_description"];
               $value69 = $value["col_value"];
               break;
            case "11":
               //gateclose
               $key11 = $value["col_description"];
               $value11 = valueAdded($value["col_value"]);
               break;
            case "12":
               //cand_name
               $key12 = $value["col_description"];
               $value12 = $value["col_value"];
               break;
            case "13":
               // new_name
               $key13 = $value["col_description"];
               $value13 = $value["col_value"];
               break;
            case "14":
               $value14 = $value["col_description"] . " : " . $value["col_value"] != "" && $value["col_value"] != 'NA' ? $value["col_value"] : "photo_not_exists.png";
               $full_photo_path = photoPath($data);
               $photo_path = $full_photo_path . $value14;
               //    echo $photo_path;
               //   exit;
               $ch = curl_init($photo_path);
               curl_setopt($ch, CURLOPT_NOBODY, true);
               curl_exec($ch);
               $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
               curl_close($ch);
               if ($retcode == 200) {
                  $photo_path = $photo_path;
               } else {
                  $base_url = $GLOBALS['site_url'];
                  $local_path = $base_url . "/sscsr/site/";
                  $photo_path = $local_path . "exam_assets/photo_not_exists.png";
               }
               break;
            case "15":
               //DOB
               $key15 = $value["col_description"];
               $value15 = $value["col_value"];
               $dob_date = getDobFormat($value15);
               break;
            case "16":
               //category
               $key16 = $value["col_description"];
               $value16 = $value["col_value"];
               break;
            case "17":
               //sign_id
               $value17 = $value["col_description"] . " : " . $value["col_value"] != "" && $value["col_value"] != 'NA' ? $value["col_value"] : "sign_not_exits.png";
               // $full_sign_path = signPath($data);
               // $sign_path = $full_sign_path.$value17;
               // //echo $sign_path;
               // if(file_exists($sign_path)){
               //     $sign_path = $sign_path;
               // }
               $full_sign_path = signPath($data);
               $sign_path = $full_sign_path . $value17;
               // echo $sign_path;
               // exit;
               $ch = curl_init($sign_path);
               curl_setopt($ch, CURLOPT_NOBODY, true);
               curl_exec($ch);
               $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
               curl_close($ch);
               if ($retcode == 200) {
                  $sign_path = $sign_path;
               } else {
                  $base_url = $GLOBALS['site_url'];
                  $local_path = $base_url . "/sscsr/site/";
                  $sign_path = $local_path . "exam_assets/sign_not_exits.png";
               }
               break;
            case "18":
               //present_state
               @$v_value18 .= $value["col_value"] . ", ";
               $value18 = $v_value18;
               break;
            case "19":
               //venue1_title
               $key19 = $value["col_description"];
               $value19 = $value["col_value"];
               break;
            case "20":
               //venue1_address
               $key20 = $value["col_description"];
               $value20 = $value["col_value"];
               break;
            case "21":
               //venue2_title
               $key21 = $value["col_description"];
               $value21 = $value["col_value"] == "NA" ? "" : $value["col_value"];
               break;
            case "22":
               //venue2_address
               $key22 = $value["col_description"];
               $value22 = $value["col_value"] == "NA" ? "" : $value["col_value"];
               break;
            case "23":
               //paper1
               $value23 = valueAdded($value["col_value"]);
               break;
            case "24":
               //subject1
               $value24 = valueAdded($value["col_value"]);
               break;
            case "25":
               //date1
               $value25 = valueAdded($value["col_value"]);
               break;
            case "26":
               //shift1
               $value26 = valueAdded($value["col_value"]);
               break;
            case "27":
               //time1
               $value27 = valueAdded($value["col_value"]);
               break;
            case "28":
               //mark1
               $value28 = valueAdded($value["col_value"]);
               break;
            case "29":
               //paper2
               $value29 = valueAdded($value["col_value"]);
               break;
            case "30":
               //subject2
               $value30 = valueAdded($value["col_value"]);
               break;
            case "31":
               //date2
               $value31 = valueAdded($value["col_value"]);
               break;
            case "32":
               //shift2
               $value32 = valueAdded($value["col_value"]);
               break;
            case "33":
               //time2
               $value33 = valueAdded($value["col_value"]);
               break;
            case "34":
               //mark2
               $value34 = $value["col_value"];
               break;
            case "35":
               //paper3
               $value35 = valueAdded($value["col_value"]);
               break;
            case "36":
               //subject3
               $value36 = valueAdded($value["col_value"]);
               break;
            case "37":
               //date3
               $value37 = valueAdded($value["col_value"]);
               break;
            case "38":
               //shift3
               $value38 = valueAdded($value["col_value"]);
               break;
            case "39":
               //time3
               $value39 = valueAdded($value["col_value"]);
               break;
            case "40":
               //mark3
               $value40 = valueAdded($value["col_value"]);
               break;
            case "41":
               //paper4
               $value41 = valueAdded($value["col_value"]);
               break;
            case "42":
               //subject4
               $value42 = valueAdded($value["col_value"]);
               break;
            case "43":
               //date4
               $value43 = valueAdded($value["col_value"]);
               break;
            case "44":
               //shift4
               $value44 = valueAdded($value["col_value"]);
               break;
            case "45":
               //time4
               $value45 = valueAdded($value["col_value"]);
               break;
            case "46":
               //mark4
               $value46 = valueAdded($value["col_value"]);
               break;
            case "47":
               //exam city
               $key47 = $value["col_description"];
               $value47 = $value["col_value"];
               break;
            case "48":
               //Paper5
               $value48 = valueAdded($value["col_value"]);
               break;
            case "49":
               //Subject5
               $value49 = valueAdded($value["col_value"]);
               break;
            case "50":
               //Date5
               $value50 = valueAdded($value["col_value"]);
               break;
            case "51":
               //Shift5
               $value51 = valueAdded($value["col_value"]);
               break;
            case "52":
               //Time5
               $value52 = valueAdded($value["col_value"]);
               break;
            case "53":
               //Mark5
               $value53 = valueAdded($value["col_value"]);
               break;
            case "54":
               //Paper6
               $value54 = valueAdded($value["col_value"]);
               break;
            case "55":
               //Subject6
               $value55 = valueAdded($value["col_value"]);
               break;
            case "56":
               //Date6
               $value56 = valueAdded($value["col_value"]);
               break;
            case "57":
               //Shift6
               $value57 = valueAdded($value["col_value"]);
               break;
            case "58":
               //Time6
               $value58 = valueAdded($value["col_value"]);
               break;
            case "59":
               //Mark6
               $value59 = valueAdded($value["col_value"]);
               break;
            case "83":
               //Identification Mark
               $key83 = $value["col_description"];
               $value83 = $value["col_value"] == "NA" ? "" : $value["col_value"];
               break;
            case "85":
               //Language
               $key85 = $value["col_description"];
               $value85 = $value["col_value"] == "NA" ? "NA" : $value["col_value"];
               break;
            case "84":
               //Compensatory Time 
               $key84 = $value["col_description"];
               $value84 = $value["col_value"] == "NA" ? "" : $value["col_value"];
               break;
            default:
            //echo "Your favorite color is neither red, blue, nor green!";
         }
      }
      $reporting_time_label = "Reporting Time";
      $venue_detail_gate_close_label = "Venue Entry/Gate Closing Time";
      if ($tier_id == 1) {
         $reporting_time = $value66;
         $venue_detail_gate_close = $value68;
      } else {
         if ($value67 == trim("NA")) {
            $reporting_time = "Shift 1 : " . $value66 . "<br>";
         } else {
            $reporting_time = "Shift 1 : " . $value66 . "<br><div style='margin-left:113px'>Shift 2 : " . $value67 . "</div>";
         }
         if ($value69 == trim("NA")) {
            $venue_detail_gate_close = "Shift 1 : " . $value68 . "<br>";
         } else {
            $venue_detail_gate_close = "Shift 1 : " . $value68 . "<br><div style='margin-left:213px'>Shift 2 : " . $value69 . "</div>";
         }
      }
      $headerImg = $GLOBALS['pdf_header_image_server_path'] . "header.png";
      $paper1 = $value23;
      $suject1 = $value24;
      $date1 = $value25;
      $shift1 = $value26;
      $time1 = $value27;
      $mark1 = $value28;
      $barcode_Value = 'RollNo=' . $value4;
      $qrcode_Value = 'RollNo=';
      $qrcode_Value .= $value4 . ",";
      $qrcode_Value .= 'Reg No=';
      $qrcode_Value .= $value3. ',';
      $qrcode_Value .= 'Name=';
      $qrcode_Value .= $value12 . ',';
      $qrcode_Value .= 'DOB=';
      $qrcode_Value .= $value15 . ',';
      $qrcode_Value .= 'Gender=';
      $qrcode_Value .= $value8. ',';
      $qrcode_Value .= 'Category=';
      $qrcode_Value .= $value16 . ',';
      $qrcode_Value .= 'Identification Mark=';
      $qrcode_Value .= $value83. ',';
      $qrcode_Value .= 'Date of Exam=';
      $qrcode_Value .= trim($date1) . ',';
      $qrcode_Value .= 'Batch of Exam=';
      $qrcode_Value .= $shift1;
     
      
  
      $barcode = '<img  width="60%" style="padding-bottom:9px;height:47px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode_Value, $generator::TYPE_CODE_128, 3, 50)) . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
      $qrcode = '<img  style="width:70px;height:70px;" src="' . (new \chillerlan\QRCode\QRCode)->render($qrcode_Value) . '" alt="QR Code" />';
      //echo 'http://" . $_SERVER["SERVER_NAME"]."/dompdf/fonts/Bamini.ttf';
      // echo $GLOBALS['pdf_header_image_server_path'];
      //   $headingText = explode('_',$value1);
      //   if($headingText[0] == 'phase' || $headingText[0] == 'Phase'){
      //         $title = "";
      //         $title  .= ucfirst($headingText[0])."_";
      //         $title  .=  $headingText[1]."_";
      //         //$title  .=  $headingText[2];
      //       $f4 = substr( $headingText[2],0,1);
      //       if($f4 == 'g'){
      //         $title  .= "Graduation";
      //         $title .=  "(".substr( $headingText[2],1,4).")";
      //       }
      //       elseif($f4 == 'm'){
      //         $title  .= "Matriculation";
      //         $title .=  "(".substr( $headingText[2],1,4).")";
      //       }
      //       elseif($f4 == 'h'){
      //         $title  .= "Higher";
      //         $title .=  "(".substr( $headingText[2],1,4).")";
      //       }
      //   }
      //   else{
      //   }
      //   $headingText = explode('/',$value1);
      //   $headingText[0] = $title;
      //    $value1 = $headingText[0] ." / ".$headingText[1];
      // echo $photo_path;
      // exit;
      //   echo '22'.$value6;
      //   exit;
      if (empty($value5)) {
         $value5 = 'NA';
      } else {
         $value5 = $value5;
      }
      $headingText = explode('_', $value1);
      if ($headingText[0] == 'phase') {
         $title = "";
         $title .= ucfirst($headingText[0]) . "_";
         $title .= $headingText[1] . "_";
         $f4 = substr($headingText[2], 0, 1);
         if ($f4 == 'g') {
            $title .= "Graduation";
            $title .= "-" . substr($headingText[2], 1, 4);
            $headingText = explode('/', $value1);
            $headingText[0] = $title;
            $subtitle = "";
            $subtitle = "(" . ucfirst($data['exam_type']) . " Exam" . ")" . "(Tier- " . $data['tier_id'] . ")";
            $value1 = $headingText[0] . $subtitle . " / " . $headingText[1];
         } elseif ($f4 == 'm') {
            $title .= "Matriculation";
            $title .= "-" . substr($headingText[2], 1, 4);
            $headingText = explode('/', $value1);
            $headingText[0] = $title;
            $subtitle = "";
            $subtitle = "(" . ucfirst($data['exam_type']) . " Exam" . ")" . "(Tier- " . $data['tier_id'] . ")";
            $value1 = $headingText[0] . $subtitle . " / " . $headingText[1];
         } elseif ($f4 == 'h') {
            $title .= "Higher";
            $title .= "-" . substr($headingText[2], 1, 4);
            $headingText = explode('/', $value1);
            $headingText[0] = $title;
            $subtitle = "";
            $subtitle = "(" . ucfirst($data['exam_type']) . " Exam" . ")" . "(Tier- " . $data['tier_id'] . ")";
            $value1 = $headingText[0] . $subtitle . " / " . $headingText[1];
         }
      } else {
         $value1 = $value1;
      }
      $cnt = strlen($value7);
      if ($cnt == 8) {
         $value7 = $value7;
      } else {
         $value7 = "0" . $value7;
      }
      $headerImg = 'http://10.163.2.181:8080/sscsr_audit/site/exam_assets/header.png';
      // echo $headerImg;
      // exit;
      $output = '
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
         <style>
         #pptbl {
            font-family: arial, sans-serif;
            border:1px solid black;
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed; /* Fixed table layout to ensure fixed cell widths */
          }
          #pptbl th {
            text-align: left;
            padding-left: 8px;
            max-width: 100px; /* Set the maximum width for th element */
            word-wrap: break-word; /* Allow text to wrap inside th */
          }
          #pptbl td {
            text-align: left;
            max-width: 100px; /* Set the maximum width for td element */
            word-wrap: break-word;
            font-size:12px;/* Allow text to wrap inside td */
          }
      .tableClass td, .tableClass th  {
      border:1px solid black;
      border-collapse: collapse;
      }
      .tableClass   {
      border:1px solid black;
      border-collapse: collapse;
      }
      body{
      font-family: Arial, Helvetica, sans-serif;    
      font-size:10 ;       
      }
      td {
      text-align: center;
      padding: 6px;
      }
      .header-class{
      border:1px solid black;
      height:100px;
      padding-left:5px;
      
      }
      div p{
      padding-left:50px;
      }
      .headerClass{
      color:red;
      }
      .fontSizeClass{
      font-size:10 ;
      }
      *{
         font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;    
        // font-size:12px;
      }
      .outer-table{
         width:100%;
         font-size:12px;
      }
      .outer-table, .outer-table td, .outer-table th{
         border:1px solid #000;
         border-collapse:collapse; 
         text-align:center;  
      }
      .inner-table {
         width:100%;
         border:0px;
         border-collapse:collapse; 
         table-layout:fixed;
         font-size:11px !important;
      }
      .inner-table tr{
         border-spacing:-1px;  
      }
      .inner-table td{
         border-spacing:-1px;
         padding:3px;
         text-align:left;  
         word-wrap:break-word;
      }
      .page-break{
         page-break-before : always;
      }
      .headingClass{
         text-align:center;
         line-height: 1.25;
         font-size:15px !important;
         text-decoration: underline;
      }
   </style>
   <div class="header-class">
      <img src=' . $headerImg . ' style="width:100%; ">
   </div>
   <div class="headingClass"><b>e-ADMISSION CERTIFICATE</b></div>
   <div class="headingClass"><b>' . $value1 . '</b></div>
   <div class="headingClass" style="padding-bottom:3px"><b>' . $value2 . '</b></div>
   <table class= "tableClass" style="width:100%;height:40px !important">
      <tr>
         <td rowspan="2" width="50%" class="fontSizeClass" style="padding-top:9px !important">' . $barcode . '' . $qrcode . '</td>
         <td  width="50%" style="text-align: left" class="fontSizeClass"><b>' . $key3 . ': </b> ' . $value3 . '</td>
      </tr>
      <tr>
         <td style="text-align: left" class="fontSizeClass"><b>' . $key5 . ' : </b> ' . $value5 . ' </td>
      </tr>
   </table>
   <!-- Roll Number and Scribe -->
   <table  class= "tableClass" style="width:100%">
      <tr style="height:200px">
         <td  style="text-align: left" width="50%" class="fontSizeClass"><b>' . $key4 . ' : </b>' . $value4 . ' </td>
         <td  style="text-align: left" width="24%" class="fontSizeClass"><b>' . $key6 . ' : </b> ' . $value6 . ' </td>
         <td  style="text-align: left" width="26%" class="fontSizeClass"><b>' . $key84 . ' : </b> ' . $value84 . ' </td>
      </tr>
   </table>
   <!-- Roll Number and Scribe -->
   <!-- Password For Examination and Gender -->
   <table  class= "tableClass" style="width:100%">
      <tr style="padding:10px">
         <td  style="text-align: left" width="50%" class="fontSizeClass"><b>' . $key7 . ': </b>' . $value7 . '</td>
         <td  style="text-align: left" width="24%" class="fontSizeClass"><b>' . $key8 . ': </b> ' . $value8 . ' </td>
         <td  style="text-align: left" width="26%" class="fontSizeClass"><b>' . $key85 . ' : </b> ' . $value85 . ' </td>
      </tr>
   </table>
   <!-- Password For Examination and Gender -->
   <!-- Reporting Time and Entry Closing time -->
   <table  style="width:100%" class= "tableClass">
      <tr style="height:200px !important">
         <td  style="text-align: left" width="50%"><b>' . $reporting_time_label . ' : </b> ' . $reporting_time . ' </td>
         <td  style="text-align: left"><b>' . $venue_detail_gate_close_label . ' : </b> ' . $venue_detail_gate_close . ' </td>
      </tr>
   </table>
   <!-- Reporting Time and Entry Closing time -->
   <!-- Candidate Name,New or Changed Name , Photo  -->
   <table style="width:100.5%;height:100px;margin-left:-2px !important"; class= "tableClass2">
      <tr>
         <td style="width:79%; vertical-align: text-top;text-align:left;border:1px solid black;border-collapse: collapse;">
            <div style="text-align:left;line-height: 2"><b>' . $key12 . '</b></div>
            <div style=" text-align:left;line-height: 2">' . $value12 . '</div>
            <div style="text-align:left;line-height: 2"><b>New or Changed Name</b></div>
            <div style=" text-align:left;line-height: 2">' . $value12 . '</div>
         </td>
         <td style="width:21%;border:1px solid black;border-collapse: collapse;"><img src=' . $photo_path . ' width="150" height="130"></td>
      </tr>
   </table>
   <!-- Candidate Name,New or Changed Name , Photo  -->
   <!-- DOB ,Category,Sign  --->
   <table  style="width:100%" class= "tableClass">
      <tr style="height:200px !important">
         <td  style="text-align: left" width="40%"><b>' . $key15 . ': </b> ' . $value15 . '</td>
         <td  style="text-align: left" width="30%"><b>' . $key16 . ': </b> ' . $value16 . ' </td>
         <td  style="text-align: left" width="21.5%">';
      $ch = curl_init($sign_path);
      curl_setopt($ch, CURLOPT_NOBODY, true);
      curl_exec($ch);
      $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      if ($retcode == 200) {
         $sign_path = $sign_path;
         $output .= '<img src=' . $sign_path . ' width="130" height="30">';
      }
      if ($value21 == "") {
         $value21 = "";
      } else {
         $value21 = $value21 . ",";
      }
      if ($value22 == "NA") {
         $value22 = "";
      } else {
         $value22 = $value22;
      }
      $output .= '
      </td>
      </tr>
   </table>
   <!-- DOB ,Category,Sign  --->
   <!-- Post Preference  --->
   <!-- <table  style="width:100%" class= "tableClass">
      <tr style="height:100px !important">
         <td  style="text-align: left" width="36%"><b>' . $key9 . ': </b> ' . $value9 . ' </td>
      </tr>
   </table> -->
   <!-- Post Preference --->
   <!-- Candidate \'s Address-->
   <table  style="width:100%"; class= "tableClass">
   <tr>
      <td style="width:75%; vertical-align: text-top;text-align:left;border:0px solid black;border-collapse: collapse;">
         <b>  ' . $key83 . ' :</b>  ' . $value83 . ' 
      </td>
   </tr>
</table>
   <table  style="width:100%"; class= "tableClass">
      <tr>
         <td style="width:75%; vertical-align: text-top;text-align:left;border:0px solid black;border-collapse: collapse;">
            <b> Candidate\'s Address :</b>  ' . $data['candidate_address'] . ' 
         </td>
      </tr>
      <tr>
      <!--  <td style="width:75%; vertical-align: text-top;text-align:left;border:0px solid black;border-collapse: collapse;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            ' . $data['candidate_address'] . '
          </td>-->
      </tr>
   </table>
   <!-- Candidate\'s Address -->
   <!-- Examination Venue-->
   <table  style="width:100%"; class= "tableClass">
      <tr>
         <td style="width:75%; vertical-align: text-top;text-align:left;border:0px solid black;border-collapse: collapse;">
            <b> Examination Venue :<br> ' . $value19 . ' </b>   ' . $value20 . ' 
         </td>
      </tr>
      <tr>
      <td style="width:75%; vertical-align: text-top;text-align:left;border:0px solid black;border-collapse: collapse;">
      <b>' . $value21 . ' </b> ' . $value22 . '
   </td>
      </tr>
   <!-- <tr>
         <td style="width:75%; vertical-align: text-top;text-align:left;border:0px solid black;border-collapse: collapse;">
         </td>
      </tr>--> 
     <!-- <tr>
         <td style="width:75%; vertical-align: text-top;text-align:left;border:0px solid black;border-collapse: collapse;">
            ' . $value20 . '
         </td>
      </tr>
      <tr>
         <td style="width:75%; vertical-align: text-top;text-align:left;border:0px solid black;border-collapse: collapse;">
            ' . $value21 . '  , ' . $value22 . '
         </td>
      </tr>-->
     <!-- <tr>
         <td style="width:75%; vertical-align: text-top;text-align:left;border:0px solid black;border-collapse: collapse;">
         ' . $value22 . '
         </td>
      </tr>-->
   </table>
   <!-- Examination Venue -->
   ';
      $tblName = $data['tableName'];
      $tblSplit = explode('_', $tblName);
      if ($tblSplit[0] == "phase") {
         if ($value9 != "") {
            $stringValue = substr($value9, 0, 175);
            $stringValue .= ' etc';
            // Count the number of posts using explode(",")
            $posts = explode(",", $value9);
            $postsCount = count($posts);
            if ($postsCount > 20) {
               $final_text = $stringValue . " - " . $postsCount . " Posts";
            } else {
               $final_text = $value9;
            }
            $output .= '
         <!--Post Preference-->
      <table  style="width:100%"; id= "pptbl">
         <tr>
            <td><div style="font-size:12px"><b>Post No(s):</b></div>' . $final_text . '
            </td>
         </tr>
      </table>
      <!-- Post Preference -->
      ';
         }
      }
      $tableArray = array(
         "Date" => $date1,
         "Shift" => $shift1,
         "Time" => $time1,
         "Paper/Session" => $paper1,
         "Subject" => $suject1,
         // Assuming there's a typo in "$subject1"
         "Marks" => $mark1
      );
      if ($tier_id == 1 || $tier_id == 3) {
         $theader = $tcell = "<tr>";
         


 
         $marks_array = explode(',', $tableArray["Marks"]);
         $subjects = explode(',', $tableArray["Subject"]);
         foreach ($subjects as $index => $subject) {
            $tcell .= '<tr>';
            if ($index === 0) {
               $tcell .= '<td rowspan="' . count($subjects) . '">' . $tableArray["Date"] . '</td>';
               $tcell .= '<td rowspan="' . count($subjects) . '">' . $tableArray["Shift"] . '</td>';
               $tcell .= '<td style="font: size 11px;" rowspan="' . count($subjects) . '">' . $tableArray["Time"] . '</td>';
               $tcell .= '<td rowspan="' . count($subjects) . '">' . $tableArray["Paper/Session"] . '</td>';
            }
            $tcell .='<td style="text-align:left">' . $subject . '</td>';
            $tcell .= '<td>' . $marks_array[$index] . '</td>';
            $tcell .= '</tr>';
        }
         // foreach ($tableArray as $title => $value) {
         //    $theader .= "<th>$title</th>";
         //    $items = explode(",", $value);
         //    if (count($items) > 1) {
         //       $value = "<table class='inner-table' >";
         //       $stalin = array();
         //       foreach ($items as $item) {
         //          $value .= "<tr><td>$item</td></tr>";
         //          $stalin[] = $item;
         //       }
         //       $value .= "</table>";
         //    }
         //    $tcell .= "<td style='font-size:12px;'>$value</td>";
         // }
         $th1 = '<tr>
         <th width="8%">Exam Date</th>
         <th width="5%">Shift</th>
         <th width="13%">Exam Time</th>
         <th width="10%">Paper/Session</th>
         <th style="width:25%;">Subjects</th>
         <th style="width:6%;">Marks</th>';
         $output .= "<table class='outer-table' style='width:100%; word-wrap: break-word; table-layout: fixed;'>{$th1}{$tcell}{$tfoot}</table>";
         //exit;
      } else if ($tier_id == 2) {
         //Paper 1 
         $paper1 = trim($value23);
         $suject1 = $value24;
         $date1 = date("d-m-Y", strtotime($value25));
         $shift1 = $value26;
         $time1 = $value27;
         if ($value28 == trim("NA") || $value28 == "-") {
            $mark1 = $value28;
         } else {
            $mark1 = (int) $value28;
         }
         //Paper 2 
         $paper2 = trim($value29);
         $suject2 = $value30;
         $date2 = date("d-m-Y", strtotime($value31));
         $shift2 = $value32;
         $time2 = $value33;
         if ($value34 == trim("NA") || $value34 == "-") {
            $mark2 = $value34;
         } else {
            $mark2 = (int) $value34;
         }
         //Paper3
         $paper3 = trim($value35);
         $suject3 = $value36;
         $date3 = date("d-m-Y", strtotime($value37));
         $shift3 = $value38;
         $time3 = $value39;
         if ($value40 == trim("NA") || $value40 == "-") {
            $mark3 = $value40;
         } else {
            $mark3 = (int) $value40;
         }
         //Paper 4
         $paper4 = trim($value41);
         $suject4 = $value42;
         $date4 = date("d-m-Y", strtotime($value43));
         $shift4 = $value44;
         $time4 = $value45;
         if ($value46 == trim("NA") || $value46 == "-") {
            $mark4 = $value46;
         } else {
            $mark4 = (int) $value46;
         }
         //Paper 5
         $paper5 = trim($value48);
         $suject5 = $value49;
         $date5 = date("d-m-Y", strtotime($value50));
         $shift5 = $value51;
         $time5 = $value52;
         if ($value53 == trim("NA") || $value53 == "-") {
            $mark5 = $value53;
         } else {
            $mark5 = (int) $value53;
         }
         //Paper 6
         $paper6 = trim($value54);
         $suject6 = $value55;
         $date6 = date("d-m-Y", strtotime($value56));
         $shift6 = $value57;
         $time6 = $value58;
         if ($value59 == trim("NA") || $value59 == "-") {
            $mark6 = $value59;
         } else {
            $mark6 = (int) $value59;
         }
         $tableArray2old = array(
            array($date1, $shift1, $time1, $paper1, $suject1, $mark1),
            array($date2, $shift2, $time2, $paper2, $suject2, $mark2),
            array($date3, $shift3, $time3, $paper3, $suject3, $mark3),
            array($date4, $shift4, $time4, $paper4, $suject4, $mark4),
            array($date5, $shift5, $time5, $paper5, $suject5, $mark5),
            array($date6, $shift6, $time6, $paper6, $suject6, $mark6)
         );
         // Create a new array to store the filtered rows
         foreach ($tableArray2old as $row) {
            if ($row[3] !== "NA") {
               $tableArray2[] = $row;
            }
         }
         array_multisort(array_column($tableArray2, 0), SORT_ASC, $tableArray2);
         $output .= '<table  style="width:100%" class= "tableClass">
         <tr>
            <th width="8%">Exam Date</th>
            <th width="3%">Shift</th>
            <th width="12%">Exam Time</th>
            <th width="5%">Paper/<br>Session</th>
            <th width="25%" >Subject</th>
            <th width="4%">Marks</th>
         </tr>';
         $keys = array_keys($tableArray2);
         foreach ($tableArray2 as $row) {
            $output .= "<tr>
            <td>" . $row[0] . "</td>
            <td>" . $row[1] . "</td>
            <td>" . $row[2] . "</td>
            <td>" . $row[3] . "</td>
            <td style='text-align:left'>" . $row[4] . "</td>
            <td>" . $row[5] . "</td>
            </tr>";
         }
         // foreach ($tableArray2 as $key => $mks){
         //    $output  .= "<tr>
         //    <td>".$mks[$key][0]."</td>
         //    <td>".$mks[$key][1]."</td>
         //    <td>".$mks[$key][2]."</td>
         //    <td>".$mks[$key][3]."</td>
         //    <td>".$mks[$key][4]."</td>
         //    <td>".$mks[$key][5]."</td>
         //    </tr>";
         // }
         $output .= '</table>
         <br>';
      }
      echo "<table class='outer-table' style='width:100%'>{$theader}{$tcell}{$tfoot}</table>";
      $output .= '<div class="page-break"></div>
         <div class="myDiv">
         <img src=' . $last_line . ' style="width:100%;height:130px">
         </div>';
     //  echo $output;
     //  exit;
      $data = ob_get_clean();
      $document->loadHtml($output);
      $document->set_option('isRemoteEnabled', true);
      $document->set_option('isFontSubsettingEnabled', true);
      $document->setPaper('A4', 'portait');
      $document->render();
      //First Pdf insert 
      $output = $document->output();

      
      $admitcardpdf = self::$PDF_TEMPLATE_PATH . "/" . $file_name . ".pdf";
      file_put_contents($admitcardpdf, $output);
      $pdf = new \Clegginabox\PDFMerger\PDFMerger;
      $pdf->addPDF($admitcardpdf, '1');
      if ($pdfname == "") {
      } else {
         $pdfPath = $GLOBALS['local_instructions_path'];
         // echo  $pdfPath;
         // exit;
         $pdf_file = $pdfPath . $pdfname;
         $pdf->addPDF($pdf_file);
      }
      $pdf->merge('browser', $value3 . '.pdf', 'P');
      //First Pdf insert 
   }
}