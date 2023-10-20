<?php

namespace App\Controllers;

use App\System\Route;
use App\Helpers\Helpers;
use App\Helpers\PdfHelper;
use App\Models\Exam as Exam;
use App\Models\Menu as Menu;
use App\Models\Users as User;
use App\Models\Phase as Phase;
use App\Helpers\PdfHelperEmail;
use App\Helpers\PdfHelperDVExam;
use App\Helpers\PhpMailerHelper;
use App\Models\Notice as Notice;
use App\Models\Tender as Tender;
use App\Helpers\PdfHelperDMEExam;
use App\Helpers\PdfHelperPETExam;
use App\Models\Gallery as Gallery;
use App\Helpers\PdfHelperSkillTest;
use App\Models\Category as Category;
use App\Models\Examtype as Examtype;
use App\Models\Admitcard as Admitcard;
use App\Controllers\FrontEndController;
use App\Models\Nomination as Nomination;
use App\Models\Debarredlists as Debarredlists;
use App\Models\Selectionpost as Selectionpost;
use App\Models\ImportantLinks as ImportantLinks;
use App\Models\Knowyourstatus as Knowyourstatus;
use App\Models\Nominationchild as Nominationchild;
use App\Models\Selectionpostschild as Selectionpostschild;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//error_reporting(0);
class IndexController extends FrontEndController
{
	public function __construct($param_data = array())
	{
		parent::__construct($param_data);
		$menu = new Menu();
		//for header published menus
		ob_start();
		\App\Helpers\Helpers::showMenuLinks($menu->getMenusForPublish());
		$menuStr = ob_get_clean();
		//echo $menuStr;
		$this->data['renderedMenu'] = $menuStr;
		//for footer published menus
		ob_start();
		\App\Helpers\Helpers::showFooterMenuLinks($menu->getFooterMenusForPublish());
		$footermenuStr = ob_get_clean();
		// echo $menuStr;
		$this->data['renderedFooterMenu'] = $footermenuStr;
	}
	public function index()
	{
		// login
		$data = $this->login();
		$data['nominations'] = Helpers::getNomination();
		$data['nominationchildlist'] = Helpers::getNominationChildList();
		//Nomination List For Latest News
		$data['nominations_latest_news'] = Helpers::getNominationLatestNews();
		$data['nominationchildlist_latest_news'] = Helpers::getNominationChildListNews();
		//Nomination List For Latest News
		/*****
		 * 
		 * SP List For Latest News
		 * 
		 */
		$data['selectionposts_latest_news'] = Helpers::getSelectionPostLatestNews();
		$data['selectpostschildlist_latest_news'] = Helpers::getSelectionPostChildLatestNews();
		/*****
		 * 
		 * SP List For Latest News
		 * 
		 */
		/****
		 * Notices For Latest News
		 */
		$data['notices_latest_news'] = Helpers::getNoticeLatestNews();
		/***
		 * Tender For Latest News
		 * 
		 */
		$data['tenders_latest_news'] = Helpers::getTenderLatestNews();
		/***
		 * Announcements For Latest News
		 * 
		 */
		$data['announcements_latest_news'] = Helpers::getAnnouncementsLatestNews();
		$data['notices'] = Helpers::getNotice();
		// Important links and Gallery
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$jsonData = json_encode($data, JSON_PRETTY_PRINT);
		$filePath = 'Json/data_record.json';
		file_put_contents($filePath, $jsonData);
		$this->render("home", $data);
	}
	public function adminlogin()
	{
		$data = $this->login();
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("admin_login", $data);
	}
	public function login()
	{
		$errorMsg = "";

		

			if (isset($_POST['login'])) {
				if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
					// Token mismatch, handle the error (e.g., log it or display an error message)
					$errorMsg ="CSRF token verification failed.";
				}
				// check captcha here
				if (false == $this->checkCaptcha($_POST['captcha_code'])) {
					$errorMsg = "Invalid Captcha";
					return ['errorMsg' => $errorMsg];
				}
				if (!empty($_POST['username']) && !empty($_POST['password'])) {
					$decyptedusername = Helpers::encrypt_with_cryptoJS_and_decrypt_with_php($_POST['username']);
					$decyptedpassword = Helpers::encrypt_with_cryptoJS_and_decrypt_with_php($_POST['password']);
					$username = Helpers::cleanData(trim($decyptedusername));
					$password = Helpers::cleanData(trim($decyptedpassword));
					$md5Password = md5($password);
					$user = new User();
					if ($user->authenticate($username, $md5Password)) {
						$route = new Route();
						//print_r($_SESSION);
						$route->redirect($route->site_url("Admin/dashboard/?action=listnominations"));
					} else {
						$errorMsg = "Wrong Username or password";
					}
				} else {
					$errorMsg = "Invalid credentials";
				}
			}
		//CSRF Token else end
		if (isset($_GET['logout']) && $_GET['logout'] == true) {
			session_destroy();
			$route = new Route();
			$route->redirect($route->get_app_url());
		}
		if (isset($_GET['lmsg']) && $_GET['lmsg'] == true) {
			$errorMsg = "Login required to access dashboard";
		}
		return ['errorMsg' => $errorMsg];
	}
	public function admitcard($data = array())
	{

	

		
		$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
		$lastUriSegment = array_pop($uriSegments);
		//$data = $this->getadmitcard(); 	
		$data = Helpers::getAdmitCardDetails();
		$tablename = @$data['tableName']; // si_2019_tier
		$tierId = @$data['tier_id']; //1
		$regNo = @$data['regNo']; //10000328837
		$examname = explode('_', $tablename);
		// si2019_1_10000328837
		$updateId = @$examname[0] . @$examname[1] . '_' . @$tierId . '_' . @$regNo;
		//echo $updateId;
		//$this->printr($data);
		date_default_timezone_set("Asia/Calcutta");
		$updated_time = $date = date("Y-m-d H:i:s");
		@$cnt = $data['count'];
		if ($cnt >= 1) {
			switch ($data['exam_type']) {
				case "tier":
					//if exam type is written exam -start
					$ipaddress = $_SERVER['REMOTE_ADDR'];
					$acprint_data = [
						'ac_printed' => '1',
						'updated_on' => $updated_time,
						'ipaddress' => $ipaddress
					];
					$admitcard_model = new \App\Models\Admitcard();
					if ($admitcard_model->updateAcPrint($tablename, $acprint_data, $updateId)) {
						PdfHelper::genereateAndDownloadAdminCard($data);
					}
					//if exam type is written exam -end
					break;
				case "skill":
					$ipaddress = $_SERVER['REMOTE_ADDR'];
					$acprint_data = [
						'ac_printed' => '1',
						'updated_on' => $updated_time,
						'ipaddress' => $ipaddress
					];
					$admitcard_model = new \App\Models\Admitcard();
					if ($admitcard_model->updateAcPrint($tablename, $acprint_data, $updateId)) {
						PdfHelperSkillTest::genereateAndSkillTestDownloadAdminCard($data);
					}
					break;
				case "pet":
					$ipaddress = $_SERVER['REMOTE_ADDR'];
					$acprint_data = [
						'ac_printed' => '1',
						'updated_on' => $updated_time,
						'ipaddress' => $ipaddress
					];
					$admitcard_model = new \App\Models\Admitcard();
					if ($admitcard_model->updateAcPrint($tablename, $acprint_data, $updateId)) {
						PdfHelperPETExam::genereateAndPETDownloadAdminCard($data);
					}
					break;
				case "dme":
					$ipaddress = $_SERVER['REMOTE_ADDR'];
					$acprint_data = [
						'ac_printed' => '1',
						'updated_on' => $updated_time,
						'ipaddress' => $ipaddress
					];
					$admitcard_model = new \App\Models\Admitcard();
					if ($admitcard_model->updateAcPrint($tablename, $acprint_data, $updateId)) {
						PdfHelperDMEExam::genereateAndDMEDownloadAdminCard($data);
					}
					break;
				default:
					//if exam type is DV -start
					$ipaddress = $_SERVER['REMOTE_ADDR'];
					$acprint_data = [
						'ac_printed' => '1',
						'updated_on' => $updated_time,
						'ipaddress' => $ipaddress
					];
					$admitcard_model = new \App\Models\Admitcard();
					if ($admitcard_model->updateAcPrint($tablename, $acprint_data, $updateId)) {
						PdfHelperDVExam::genereateAndDVDownloadAdminCard($data);
					}
					//if exam type is DV -endf
			}
		}
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("admit_card", $data);
	}
	/**** Admit card Preview    ******/
	public function admitcardpreview($data = array())
	{
		$data = Helpers::getAdmitCardPreviewDetails();
		//$this->printr($data);
		@$cnt = $data['count'];
		if ($cnt >= 1) {
			switch ($data['exam_type']) {
				case "tier":
					//if exam type is written exam -start
					PdfHelper::genereateAndDownloadAdminCard($data);
					//if exam type is written exam -end
					break;
				case "skill":
					PdfHelperSkillTest::genereateAndSkillTestDownloadAdminCard($data);
					break;
				case "pet":
					PdfHelperPETExam::genereateAndPETDownloadAdminCard($data);
					break;
				case "dme":
					PdfHelperDMEExam::genereateAndDMEDownloadAdminCard($data);
					break;
				default:
					//if exam type is DV -start
					PdfHelperDVExam::genereateAndDVDownloadAdminCard($data);
					//if exam type is DV -end
			}
		}
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("admitcard_preview", $data);
	}
	/**** Admit card Preview    ******/
	public function knowyourstatus($data = array())
	{
		$data = $this->getknowyourstatus();
		@$cnt = $data['count']->count;
		if ($cnt == 1) {
			$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
			$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
			$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
			$this->render("kyas_results", $data);
			exit;
		}
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("know_your_status", $data);
	}
	public function faq($data = array())
	{
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$data['faq_for_websites'] = Helpers::getFaqForWebsites();
		$this->render("faq", $data);
	}
	public function gallerypage($data = array())
	{
		$events = new Gallery();
		$yearBasedEvents = $events->getHomePhotoGalleryList();
		$data['yearBasedEvents'] = $yearBasedEvents;
		$distinctyears = $events->DistinctedYears();
		$data['distinctyears'] = $distinctyears;
		$this->render("gallery", $data);
	}
	public function candidateCorner($data = array())
	{
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("candidate_corner", $data);
	}
	public function getadmitcard()
	{
		Helpers::getAdmitCardDetails("admitcard");
	}
	public function getknowyourstatus()
	{
		$errorMsg = "";
		
			if (isset($_POST['kyas'])) {
		
				if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
					// Token mismatch, handle the error (e.g., log it or display an error message)
					$errorMsg ="CSRF token verification failed.";
				}
				$register_number = trim($_POST['register_number']);
				$dob = trim($_POST['dob']);
				$table_name = trim($_POST['table_name']);
				$data_array = array(
					"register_number" => $register_number,
					"dob" => $dob,
					"table_name" => $table_name
				);
				$data = explode('_', $table_name);
				if ($data[0] == 'phase') {
					$exam_year = strtoupper($data[3]);
				} else {
					$exam_year = strtoupper($data[1]);
				}
				$kyas = new Exam();
				//$this->printr($kyasresults);
				if ($kyas->getKyas($data_array)) {
					$kyasresults = $kyas->getKyas($data_array);
					$kyascount = $kyas->getCountKyas($data_array);
					$examname_by_year = $kyas->examNamebyYear($table_name);
					return ['kyasresults' => $kyasresults, 'count' => $kyascount, 'examname' => $examname_by_year, 'year' => $exam_year];
				} else {
					$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
				}
			}
		 // CSRF Token IF end

		return ['errorMsg' => $errorMsg];
	}
	public function nomination()
	{
		$data['nominations'] = Helpers::getNomination();
		$data['nominationchildlist'] = Helpers::getNominationChildList();
		$data['categorylist'] = Helpers::getCategory();
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("nomination", $data);
	}
	public function notice()
	{
		$data['notices'] = Helpers::getNotice();
		$data['categorylist'] = Helpers::getCategory();
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("notice", $data);
	}
	public function tender()
	{
		$data['tenders'] = Helpers::getTender();
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("tender", $data);
	}
	public function selectionpost()
	{
		$data['selectionposts'] = Helpers::getSelectionPost();
		$data['selectpostschildlist'] = Helpers::getSelectionPostChild();
		$data['categorylist'] = Helpers::getCategorySelectionPostsList();
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("selection_posts", $data);
	}
	public function pageunderconstruction($data = array())
	{
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("page_under_construction", $data);
	}
	private function checkCaptcha($captcha_code)
	{
		if ($captcha_code == $_SESSION['captcha_code']) {
			return true;
		} else {
			return false;
		}
	}
	public function chairmen()
	{
		echo "I am chairmen page";
	}
	public function getExamDetails()
	{
		//get matched data 
		try {
			$exam = new Exam();
			$q = isset($_GET['q']) ? $_GET['q'] : "";
			$exam_details = $exam->getExamfromExamDetailsTbl($q);
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData = [];
		foreach ($exam_details as $insdata) {
			$examname = $insdata->exam_name . ',' . $insdata->table_exam_year . '(' . $insdata->table_type . ') ';
			$searchData[] =
				array(
					'id' => $insdata->table_name,
					'text' => $examname
				);
		}
		echo json_encode($searchData);
	}
	/************************
	 ***  Admit card Exam Name Ajax
	 */
	public function getTierBasedExamDetailsCity()
	{
		//get matched data 
		try {
			$exam = new Exam();
			$q = isset($_GET['q']) ? $_GET['q'] : "";
			$exam_details = $exam->getTierBasedTblCity($q);
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData = [];
		foreach ($exam_details as $insdata) {
			//$textData = $insdata->exam_name." (".$insdata->table_exam_short_name.")"." (".$insdata->table_exam_year.")";
			//$textData = $insdata->exam_name." (".$insdata->table_exam_short_name.")"." (".$insdata->table_exam_year.")";
			$examname = $insdata->exam_name . ',' . $insdata->table_exam_year . '(' . $insdata->table_type . ') (' . $insdata->tier_name . ')';
			//'',.r.'('.$insdata->tier_name.') ';
			$searchData[] =
				array(
					'id' => $insdata->tableid,
					'text' => $examname
				);
		}
		echo json_encode($searchData);
	}
	public function getTierBasedExamDetailsCardPreview()
	{
		//get matched data 
		try {
			$exam = new Exam();
			$q = isset($_GET['q']) ? $_GET['q'] : "";
			$exam_details = $exam->getTierBasedTblCardPreview($q);
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData = [];
		foreach ($exam_details as $insdata) {
			//$textData = $insdata->exam_name." (".$insdata->table_exam_short_name.")"." (".$insdata->table_exam_year.")";
			//$textData = $insdata->exam_name." (".$insdata->table_exam_short_name.")"." (".$insdata->table_exam_year.")";
			$examname = $insdata->exam_name . ',' . $insdata->table_exam_year . '(' . $insdata->table_type . ') (' . $insdata->tier_name . ')';
			//'',.r.'('.$insdata->tier_name.') ';
			$searchData[] =
				array(
					'id' => $insdata->tableid,
					'text' => $examname
				);
		}
		echo json_encode($searchData);
	}
	public function getTierBasedExamDetailsCard()
	{
		//get matched data 
		try {
			$exam = new Exam();
			$q = isset($_GET['q']) ? $_GET['q'] : "";
			$exam_details = $exam->getTierBasedTblCard($q);
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData = [];
		foreach ($exam_details as $insdata) {
			//$textData = $insdata->exam_name." (".$insdata->table_exam_short_name.")"." (".$insdata->table_exam_year.")";
			//$textData = $insdata->exam_name." (".$insdata->table_exam_short_name.")"." (".$insdata->table_exam_year.")";
			$examname = $insdata->exam_name . ',' . $insdata->table_exam_year . '(' . $insdata->table_type . ') (' . $insdata->tier_name . ')';
			//'',.r.'('.$insdata->tier_name.') ';
			$searchData[] =
				array(
					'id' => $insdata->tableid,
					'text' => $examname
				);
		}
		echo json_encode($searchData);
	}
	public function getTierBasedExamDetailsPreview()
	{
		//get matched data 
		try {
			$exam = new Exam();
			$q = isset($_GET['q']) ? $_GET['q'] : "";
			$exam_details = $exam->getTierBasedTblPreview($q);
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData = [];
		foreach ($exam_details as $insdata) {
			//$textData = $insdata->exam_name." (".$insdata->table_exam_short_name.")"." (".$insdata->table_exam_year.")";
			//$textData = $insdata->exam_name." (".$insdata->table_exam_short_name.")"." (".$insdata->table_exam_year.")";
			$examname = $insdata->exam_name . ',' . $insdata->table_exam_year . '(' . $insdata->table_type . ') (' . $insdata->tier_name . ')';
			//'',.r.'('.$insdata->tier_name.') ';
			$searchData[] =
				array(
					'id' => $insdata->tableid,
					'text' => $examname
				);
		}
		echo json_encode($searchData);
	}
	/************************
	 ***  getTierMaster
	 */
	public function getTierMaster()
	{
		//get matched data 
		try {
			$exam = new Exam();
			$q = isset($_GET['q']) ? $_GET['q'] : "";
			$exam_details = $exam->getTierBasedMaster($q);
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData = [];
		foreach ($exam_details as $insdata) {
			$textData = $insdata->tier_name;
			$searchData[] =
				array(
					'id' => $insdata->tier_id,
					'text' => $textData
				);
		}
		echo json_encode($searchData);
	}
	public function getPhaseDetails()
	{
		//get matched data 
		try {
			$phase = new Phase();
			$q = isset($_GET['q']) ? $_GET['q'] : "";
			$phase_details = $phase->getPhasefromPhaseDetailsTbl($q);
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData = [];
		foreach ($phase_details as $insdata) {
			$searchData[] =
				array(
					'id' => $insdata->phase_id,
					'text' => $insdata->phase_name
				);
		}
		echo json_encode($searchData);
	}
	//get gallery distinct years
	public function getGalleryYears()
	{
		//get matched data 
		try {
			$Gallery = new Gallery();
			$q = isset($_GET['q']) ? $_GET['q'] : "";
			$gallery_event_years = $Gallery->getGalleryDistinctedYears($q);
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData = [];
		foreach ($gallery_event_years as $insdata) {
			$searchData[] =
				array(
					'id' => $insdata->year,
					'text' => $insdata->year
				);
		}
		echo json_encode($searchData);
	}
	//get year based gallery events 
	public function getYearBasedEvents()
	{
		//get matched data 
		try {
			$Gallery = new Gallery();
			//$q = isset($_POST['year']) ? $_POST['year'] : "2022";
			$year = $_POST['year'];
			$gallery_event_by_years = $Gallery->getGalleryEventsByYears($year);
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData;
		foreach ($gallery_event_by_years as $insdata) {
			$searchData[] =
				array(
					'id' => $insdata->gallery_id,
					'text' => $insdata->event_name
				);
		}
		//print_r($gallery_event_by_years);
		echo json_encode($searchData);
	}
	public function EventBasedLightBox()
	{
		$id = $_POST['id'];
		//get matched data 
		try {
			$Gallery = new Gallery();
			$fetchRecordsObject = $Gallery->EventBasedLightBox($id);
			$eventbasedRecords = (array) $fetchRecordsObject;
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData;
		foreach ($eventbasedRecords as $insdata) {
			$searchData[] =
				array(
					'id' => $insdata->image_path,
					'text' => $insdata->event_name . "," . $insdata->year
				);
		}
		echo json_encode($searchData);
	}
	// //getGalleryidBasedImages
	public function GalleryidBasedImagesWithLightBox()
	{
		$year = htmlspecialchars($_POST['year']);
		try {
			$Gallery = new Gallery();
			$fetchRecordsObject = $Gallery->photoGalleryGroup($year);
			$fetchRecords = (array) $fetchRecordsObject;
		} catch (Exception $Ex) {
			// file deepcode ignore ServerLeak: <please specify a reason of ignoring this>
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData = array();
		foreach ($fetchRecords as $insdata) {
			$fetchRecordsObject = $Gallery->photoGalleryGroupforOneRecord($insdata->event_id);
			$oneRecord = (array) $fetchRecordsObject;
			$searchData[] =
				array(
					'id' => $oneRecord['image_path'],
					'text' => $insdata->event_name . "," . $insdata->event_id
				);
		}
		echo json_encode($searchData);
	}
	public function GalleryidBasedImages()
	{
		//get matched data 
		try {
			$Gallery = new Gallery();
			$q = (isset($_POST['gallery_id'])) ? $_POST['gallery_id'] : "on";
			$gallery_id_based_images = $Gallery->getGalleryidBasedImagesModel($q);
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData = "";
		foreach ($gallery_id_based_images as $insdata) {
			$searchData[] =
				array(
					'id' => $insdata->image_path,
					'text' => $insdata->event_name . "," . $insdata->year
				);
		}
		echo json_encode($searchData);
	}
	public function GalleryidBasedEvents()
	{
		$year = $_POST['year'];
		//get matched data 
		try {
			$Gallery = new Gallery();
			$fetchRecordsObject = $Gallery->GalleryidBasedEvents($year);
			$fetchRecords = (array) $fetchRecordsObject;
			//echo '<pre>';
			//print_r($fetchRecords);
			//exit;
		} catch (Exception $Ex) {
			echo "Error" . $sql . "</br>" . $Ex;
		}
		$searchData;
		foreach ($fetchRecords as $insdata) {
			$searchData[] =
				array(
					'id' => $insdata->gallery_id,
					'text' => $insdata->event_name
				);
		}
		echo json_encode($searchData);
	}
	public function dlist()
	{
		$data['dlist_details'] = Helpers::getDList();
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("debarred_list", $data);
	}
	public function ScreenReaderAccess()
	{
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("screen_reader_access", $data);
	}
	public function pdfgeneration($data = array())
	{
		$data['name'] = "stalin";
		$this->render("pdf_template", $data);
	}
	public function printr($data)
	{
		echo '<pre>';
		print_r($data);
		exit;
	}
	/**
	 * @author Stalin
	 * @method : Know Your Roll Number
	 */
	public function knowyourrollno($data = array())
	{
		$data = $this->getKnowYourRollNo();
		@$cnt = $data['count'];
		if ($cnt >= 1) {
			$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
			$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
			$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
			$this->render("kyrn_results", $data);
			exit;
		}
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("know_your_roll_no", $data);
	}
	public function getKnowYourRollNo()
	{
		$errorMsg = "";
		if (isset($_POST['admit_card'])) {
			$register_number = trim($_POST['register_number']);
			$dob = trim($_POST['dob']);
			$examname = trim($_POST['examname']);
			$examname = explode('_', $examname);
			$exam_value = $examname[0] . '_' . $examname[1] . '_' . $examname[2];
			$tier_id = $examname[3];
			$data_array = array(
				"table_name" => $exam_value,
				"register_number" => $register_number,
				"dob" => $dob,
				"tier_id" => $tier_id
			);
			$admitcard = new Admitcard();
			if ($admitcard->getAdmitcard($data_array)) {
				$admitcardresults = $admitcard->getAdmitcard($data_array);
				$kyas = new Exam();
				$table_name = trim($exam_value);
				$examname_by_year = $kyas->examNamebyYear($table_name);
				$data = explode('_', $exam_value);
				$exam_year = strtoupper($data[1]);
				//$exam_name = $admitcard->getExamName($examname );
				$count = count($admitcardresults);
				return ['admitcardresults' => $admitcardresults, 'count' => $count, 'examname' => $examname_by_year, 'year' => $exam_year];
			} else {
				$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
			}
		}
		return ['errorMsg' => $errorMsg];
	}
	/**
	 * @author Stalin
	 * @method : Know Your Roll Number
	 */
	/**
	 * @author Stalin
	 * @method : Know Your Venue Details
	 */
	public function knowyourvenuedetails($data = array())
	{
		$data = $this->getKnowYourVenueDetails();
		@$cnt = $data['count'];
		if ($cnt >= 1) {
			$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
			$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
			$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
			$this->render("kyvd_results", $data);
			exit;
		}
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("know_your_venue_details", $data);
	}
	public function getKnowYourVenueDetails()
	{
		$errorMsg = "";

		
			if (isset($_POST['admit_card'])) {
				if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
					// Token mismatch, handle the error (e.g., log it or display an error message)
					$errorMsg ="CSRF token verification failed.";
				}
				$register_number = trim($_POST['register_number']);
				$dob = trim($_POST['dob']);
				$examname = trim($_POST['examname']);
				$examname = explode('_', $examname);
				// $examname = explode('_',$examname);
				// $exam_value = $examname[0].'_'.$examname[1].'_'.$examname[2];
				// $exam_type = $examname[2];
				// $tier_id = $examname[3];
				if ($examname[0] == 'phase') {
					$exam_value = $examname[0] . '_' . $examname[1] . '_' . $examname[2] . '_' . $examname[3] . '_' . $examname[4];
					$exam_type = $examname[4];
					$tier_id = $examname[5];
				} else {
					$exam_value = $examname[0] . '_' . $examname[1] . '_' . $examname[2];
					$exam_type = $examname[2];
					$tier_id = $examname[3];
				}
				$roll_no = isset($_POST['roll_number']) ? trim($_POST['roll_number']) : null;
				$post_preference = isset($_POST['post_preference_one']) ? trim($_POST['post_preference_one']) : null;
				//$roll_no =  trim($_POST['dob'])? "Adult" : "Not Adult"
				$data_array = array(
					"table_name" => $exam_value,
					"register_number" => $register_number,
					"dob" => $dob,
					"tier_id" => $tier_id,
					"roll_no" => $roll_no,
					"post_preference" => $post_preference
				);
				// echo "<pre>";
				// print_r($data_array);
				// exit;
				$admitcard = new Admitcard();
				if ($admitcard->getAdmitcardforTierPreview($data_array)) {
					$admitcardresults = $admitcard->getAdmitcardforTierPreview($data_array);
					$kyas = new Exam();
					$table_name = trim($exam_value);
					$examname_by_year = $kyas->examNamebyYear($table_name);
					$data = explode('_', $exam_value);
					if ($data[0] == 'phase') {
						$exam_year = strtoupper($data[3]);
					} else {
						$exam_year = strtoupper($data[1]);
					}
					//$exam_name = $admitcard->getExamName($examname );
					$array = (array) $admitcardresults;
					$count = count($array);
					return ['admitcardresults' => $admitcardresults, 'count' => $count, 'examname' => $examname_by_year, 'year' => $exam_year, "exam_type" => $exam_type];
				} else {
					$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
				}
			}
		

		return ['errorMsg' => $errorMsg];
	}
	/**
	 * @author Stalin
	 * @method : Know Your Venue Details
	 */
	public function emailIntegration()
	{
		//$sendEmail = PhpMailerHelper::AdminCardofBulkEmail();
		$selectedTableFormat = $_POST['selectedTableFormat'];
		$selectedTableFormatValue = explode('_', $selectedTableFormat);
		$exam_type = $selectedTableFormatValue[1];
		$table_name = $_POST['examname'] . "_" . $_POST['exam_year'] . "_" . $exam_type;
		$tier_id = $_POST['selectedtier'];
		$data_array = array(
			"table_name" => $table_name,
			"tier_id" => $tier_id,
			"selectedTableFormat" => $selectedTableFormat,
			"exam_type" => $exam_type,
		);
		$data = Helpers::getAdmitCardbyEmailIntegration($data_array);
		@$cnt = $data['count'];
		if ($cnt >= 1) {
			switch ($data_array['exam_type']) {
				case "tier":
					//if exam type is written exam -start
					PdfHelperEmail::genereateAndDownloadAdminCardEmail($data);
					$sendEmail = PhpMailerHelper::AdminCardofBulkEmail($data_array);
					//if exam type is written exam -end
					break;
				case "skill":
					PdfHelperSkillTest::genereateAndSkillTestDownloadAdminCard($data);
					break;
				case "pet":
					PdfHelperPETExam::genereateAndPETDownloadAdminCard($data);
					break;
				case "dme":
					PdfHelperDMEExam::genereateAndDMEDownloadAdminCard($data);
					break;
				default:
					//if exam type is DV -start
					PdfHelperDVExam::genereateAndDVDownloadAdminCard($data);
					//if exam type is DV -end
			}
		}
	}
	public function nominationarchives()
	{
		$data['nominations'] = Helpers::getNominationArchives();
		$data['nominationchildlist'] = Helpers::getNominationChildListArchives();
		$data['selectionpostsarchieves'] = Helpers::getSelectionPostsArchievesListforAdmin();
		$data['selectionpostsarchieveschildlist'] = Helpers::getSelectionPostsArchievesChildListforAdmin();
		$data['noticesarchiveslist'] = Helpers::getNoticeListArchivesforAdmin();
		$data['tenderarchiveslist'] = Helpers::getTenderListArchivesforAdmin();
		$data['categorylist'] = Helpers::getCategory();
		$data['categorylistsp'] = Helpers::getCategorySelectionPostsList();
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("archives", $data);
	}
	public function getPostPreferenceValue()
	{
		$roll_no = $_POST['roll_no'];
		$examname = trim($_POST['examname']);
		$examnameArray = explode('_', $examname);
		$table_name = $examnameArray[0] . '_' . $examnameArray[1] . '_' . $examnameArray[2] . '_' . $examnameArray[3] . '_' . $examnameArray[4];
		$type = $examnameArray[4];
		if ($roll_no != "" && $type == 'dv') {
			$modelClass = new Admitcard();
			$colmasterdetails = $modelClass->getPostPreference($table_name, $roll_no);
			$t = $colmasterdetails[0]->post_preference;
			$array = explode(",", $t);
			echo json_encode($array);
		}
	}
	public function sitemap()
	{
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$this->render("sitemap", $data);
	}
	public function viewall()
	{
		$data['nominations_latest_news'] = Helpers::getNominationLatestNews();
		$data['nominationchildlist_latest_news'] = Helpers::getNominationChildListNews();
		$data['selectionposts_latest_news'] = Helpers::getSelectionPostLatestNews();
		$data['selectpostschildlist_latest_news'] = Helpers::getSelectionPostChildLatestNews();
		$data['notices_latest_news'] = Helpers::getNoticeLatestNews();
		$data['tenders_latest_news'] = Helpers::getTenderLatestNews();
		$data['announcements_latest_news'] = Helpers::getAnnouncementsLatestNews();
		$data['ilinkforFirstFourRow'] = Helpers::getImporantLinksFirstFourRow();
		$data['ilinkforAfterFirstFourRow'] = Helpers::getImporantLinksAfterFourRow();
		$data['gallery_id_based_images'] = Helpers::getGalleryidBasedImages();
		$data['notices'] = Helpers::getNotice();
		$this->render("view_all", $data);
	}
	public function getadmitcardCount()
	{
			$data = $_POST;
			$data_array = array(
				'examname' =>$_POST['examname'],
				'register_number' =>$_POST['register_number'],
				'roll_number' =>$_POST['roll_number'],
				'dob' =>$_POST['dob']
			);
			$admit_card_model = new Admitcard();
			$admit_card_model_details = $admit_card_model->getAdmitcardforTierCount($data_array);
			$response =  $admit_card_model_details;
			$json_response = json_encode($response);
			header('Content-Type: application/json');
			echo $json_response;
		//Helpers::gethelperadmitcardCount($data);
	}
}
