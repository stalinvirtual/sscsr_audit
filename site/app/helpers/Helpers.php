<?php
namespace App\Helpers;
#use App\Models\Instructions;
use App\Models\MstNotice;
use App\Models\Post;
use App\System\Route;
use App\Models\Faq as Faq;
use App\Models\Loginusers;
use App\Models\Users;
use App\Models\Exam as Exam;
use App\Models\GalleryChild;
use App\Models\EventCategory;
use App\Models\NoticeArchives;
use App\Models\Phase as Phase;
use App\Models\TenderArchives;
use App\Models\Notice as Notice;
use App\Models\Tender as Tender;
use App\Models\Gallery as Gallery;
use App\Models\Category as Category;
use App\Models\Examtype as Examtype;
use App\Models\Admitcard as Admitcard;
use App\Models\Department as Department;
use App\Models\Nomination as Nomination;
use App\Models\Debarredlists as Debarredlists;
use App\Models\Selectionpost as Selectionpost;
use App\Models\ImportantLinks as ImportantLinks;
use App\Models\Knowyourstatus as Knowyourstatus;
use App\Models\Nominationchild as Nominationchild;
use App\Models\NominationArchieves as NominationArchieves;
use App\Models\Selectionpostschild as Selectionpostschild;
use App\Models\SelectionpostArchives as SelectionpostArchives;
use App\Models\NominationArchieveschild as NominationArchieveschild;
use App\Models\SelectionpostschildArchives as SelectionpostschildArchives;
use App\Models\PhaseMaster as PhaseMaster;
use App\Models\Announcements as Announcements;
use App\Models\SearchYear as SearchYear;
use App\Models\Instructions as Instructions;
use App\Models\Loginflag as Loginflag;
use App\Models\MstNoticeChild as MstNoticeChild;
class Helpers
{
	/** helper methods / functions */
	static function urlSecurityAudit()
	{
		if (!isset($_SERVER['HTTP_REFERER']) || !isset($_SESSION['user']['username'])) {
			// redirect them to your desired location
			session_destroy();
			$route = new Route();
			$route->redirect($route->get_app_url());
			exit;
		}
	}
	static function e($value)
	{
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}
	static function cleanData($input)
	{
		// Trim whitespace
		$input = trim($input);
		// Remove backslashes
		$input = stripslashes($input);
		// Use htmlspecialchars to encode special characters
		$input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
		// Your additional validation logic goes here
		// For example, checking if the input follows a specific pattern
		return $input;
	}
	// menu in options
	static function showMenuOptions($menus, $default_parent_id = 0, $current_menu_id = 0, $parent_id = 0, $chr = '')
	{
		foreach ($menus as $key => $item) {
			if ($item->menu_parent_id == $parent_id) {
				if ($item->id == $default_parent_id) {
					$selected = " selected=\"selected\" ";
				} else {
					$selected = "";
				}
				if ($item->id == $current_menu_id) {
					$disabled = " disabled=\"disabled\" ";
				} else {
					$disabled = "";
				}
				echo '<option ' . $selected . $disabled . ' value="' . $item->id . '">';
				echo $chr . $item->menu_name;
				echo '</option>';
				unset($menus[$key]);
				self::showMenuOptions($menus, $default_parent_id, $current_menu_id, $item->id, $chr . "|---");
			}
		}
	}
	// menu in links
	static function showMenuLinks($menus, $parent_id = 0, $level = 0)
	{
		$menu_children = array();
		foreach ($menus as $key => $item) {
			if ($item->menu_parent_id == $parent_id) {
				$menu_children[] = $item;
				unset($menus[$key]);
			}
		}
		if (count($menu_children) > 0) {
			if ($parent_id == 0) {
				$ulclass = "nav navbar-nav navrulerclass";
				$liclass = 'dropdown';
				$extraDivStart = "";
				$extraDivEnd = "";
			} else {
				$ulclass = "dropdown-menu";
				$liclass = 'dropdown';
			}
			echo '<ul class="' . $ulclass . " level-" . $level . '">';
			foreach ($menu_children as $key => $item) {
				echo '<li id="menu-' . $item->id . '" class="' . $liclass . '">';
				if ($item->is_redirect_popup == 0) {
					echo '<a href="' . $item->menu_full_url . '" >' . $item->menu_name . '</a>';
				} else {
					echo '<a href="' . $item->menu_full_url . '" rel = "noopener noreferrer" target="_blank" class="thumbnail page-permission" aria-label="Government of Tamil Nadu - External site that opens in a new window">' . $item->menu_name . '</a>';
				}
				self::showMenuLinks($menus, $item->id, $level++);
				echo '</li>';
			}
			echo '</ul>';
		}
	}
	// menu in links
	static function showFooterMenuLinks($menus, $parent_id = 0, $level = 0)
	{
		$menu_children = array();
		foreach ($menus as $key => $item) {
			if ($item->menu_parent_id == $parent_id) {
				$menu_children[] = $item;
				unset($menus[$key]);
			}
		}
		//echo '<pre>';print_r($menu_children);
		if ($menu_children) {
			if ($parent_id == 0) {
				$ulclass = "nav navbar-nav navrulerclass";
				$liclass = 'dropdown';
				$extraDivStart = "";
				$extraDivEnd = "";
			} else {
				$ulclass = "dropdown-menu";
				$liclass = '';
				//$extraDivStart = '<div class="sub-nav col-1 ">';
				//$extraDivEnd = "</div>";
			}
			// echo $extraDivStart;
			echo '<ul class="nav navbar-nav"  style="margin-left: 35px;">';
			//echo $level;
			//exit;
			/* if($level != 0){
					$angle='&nbsp;<i class="fa fa-angle-down"></i>';
				}
				else{
					$angle='';
				} */
			foreach ($menu_children as $key => $item) {
				//	$menu_children.count() != 0 ? $angle='&nbsp;<i class="fa fa-angle-down"></i>' : $angle='';
				echo '<li><a href="' . $item->menu_full_url . '"  class="footerClassLi" >' . $item->menu_name . "</a>";
				self::showFooterMenuLinks($menus, $item->id, $level++);
				echo '</li>';
			}
			echo '</ul>';
			// echo $extraDivEnd;
		}
		/*  if ($menu_children) {
            if ($parent_id == 0) {
                $ulclass = "nav navbar-nav ";
                $liclass = 'dropdown';
                $extraDivStart = "";
                $extraDivEnd = "";
            } else {
               /*  $ulclass = "";
                $liclass = 'dropdown';
                $extraDivStart = '<div class="dropdown-menus">';
                $extraDivEnd = "</div>";
				$name = ""; 
				$ulclass = "sub-nav-group ";
                $liclass = '';
                $extraDivStart = '<div class="sub-nav col-1">';
                $extraDivEnd = "</div>";
            }
            echo $extraDivStart;
            echo '<ul class="' . $ulclass .  '">';
            foreach ($menu_children as $key => $item) {
                echo '<li class="' . $liclass . '"><a href="' . $item->menu_full_url . '" id="accessible-megamenu-1620300104514-2" aria-haspopup="true" aria-controls="accessible-megamenu-1620300104514-3" aria-expanded="false" class="">' . $item->menu_name ."</a>";
                self::showMenuLinks($menus, $item->id, $level++);
                echo '</li>';
            }
            echo '</ul>';
            echo $extraDivEnd;
        } */
	}
	static function getImporantLinksFirstFourRow()
	{
		$ilink = new ImportantLinks();
		$ilinkforFirstFourRow = $ilink->getHomePageImportantLinksListFirstFourRowsOnly();
		return $ilinkforFirstFourRow;
	}
	static function getImporantLinksAfterFourRow()
	{
		$ilink = new ImportantLinks();
		$ilinkforAfterFirstFourRow = $ilink->getHomePageImportantLinksListAfterFirstFourRowsOnly();
		return $ilinkforAfterFirstFourRow;
	}
	static function getGalleryidBasedImages()
	{
		$Gallery = new Gallery();
		$q =  "on";
		$gallery_id_based_images = $Gallery->getGalleryidBasedImagesModel($q);
		return $gallery_id_based_images;
	}
	static function getInstructions()
	{
		$instructions_model = new Instructions();
		$getInstructionsList = $instructions_model->getInstructions();
		return $getInstructionsList;
	}
	static function getNomination()
	{
		$nomination = new Nomination();
		$nominations = $nomination->getHomeNominationsList();
		return $nominations;
	}
	static function getNominationChildList()
	{
		$nominationchildclass = new Nominationchild();
		$nominationchildlist = $nominationchildclass->getNominationchild();
		return $nominationchildlist;
	}
	/****
	 * 
	 * Nomination Archives
	 * 
	 */
	static function getNominationArchives()
	{
		$nomination = new NominationArchieves();
		$nominations = $nomination->getHomeNominationsList();
		return $nominations;
	}
	static function getNominationChildListArchives()
	{
		$nominationchildclass = new NominationArchieveschild();
		$nominationchildlist = $nominationchildclass->getNominationArchieveschild();
		return $nominationchildlist;
	}
	/****
	 * 
	 * Nomination Archives
	 * 
	 */
	/******
	 * 
	 * Nomination List For Latest News
	 * date: 14-07-2022
	 * 
	 */
	static function getNominationLatestNews()
	{
		$nomination = new Nomination();
		$nominations = $nomination->getHomeNominationsListLatestNews();
		return $nominations;
	}
	static function getNominationChildListNews()
	{
		$nominationchildclass = new Nominationchild();
		$nominationchildlist = $nominationchildclass->getNominationchildLatestNews();
		return $nominationchildlist;
	}
	static function getMstNoticeLatestNews()
	{
		$mstnotice = new MstNotice();
		$result = $mstnotice->getHomeMstNoticeList();
		return $result;
	}
	static function getMstNoticeChildListNews()
	{
		$modelchildclass = new MstNoticeChild();
		$result = $modelchildclass->getMstNoticeChildLatestNews();
		return $result;
	}
	/******
	 * 
	 * Nomination List For Latest News
	 * 
	 * 
	 */
	/****
	 *
	 * Nomination Archieves
	 *
	 */
	static function getNominationArchievesListforAdmin()
	{
		$nomination = new NominationArchieves();
		$nominations = $nomination->getNominationsArchievesList();
		return  $nominations;
	}
	static function getNominationArchievesChildListforAdmin()
	{
		$nominationchildclass = new NominationArchieveschild();
		$nominationchildlist = $nominationchildclass->getNominationArchieveschild();
		return  $nominationchildlist;
	}
	/*****
	 * 
	 * Selection Posts
	 * 
	 * 
	 * 
	 */
	static function getSelectionPostsArchievesListforAdmin()
	{
		$nomination = new SelectionpostArchives();
		$nominations = $nomination->getSelectionPostListAdmin();
		return  $nominations;
	}
	static function getSelectionPostsArchievesChildListforAdmin()
	{
		$nominationchildclass = new SelectionpostschildArchives();
		$nominationchildlist = $nominationchildclass->getSelectionpostschild();
		return  $nominationchildlist;
	}
	/*****
	 * 
	 * Selection Posts
	 * 
	 * 
	 * 
	 */
	static function getNotice()
	{
		$notice = new Notice();
		$notices = $notice->getNotice();
		return $notices;
	}
	/****
	 * 
	 * Notice For Latest News
	 * 
	 */
	/***
	 *
	 * #faq
	 */
	static function getFaqListforAdmin()
	{
		$faqmodel = new Faq();
		$faqlists = $faqmodel->getFaqList();
		return $faqlists;
	}
	static function getNoticeLatestNews()
	{
		$notice = new Notice();
		$notices = $notice->getNoticeLatestNews();
		return $notices;
	}
	static function getCategory()
	{
		$category = new Category();
		$categorylist = $category->getCategoryNominations();
		return $categorylist;
	}
	static function getTender()
	{
		$tender = new Tender();
		$tenders = $tender->getHomePageTenderList();
		return $tenders;
	}
	/***
	 * 
	 * Tender For Latest News
	 */
	static function getTenderLatestNews()
	{
		$tender = new Tender();
		$tenders = $tender->getHomePageTenderListLatestNews();
		return $tenders;
	}
	/***
	 * 
	 * Announcements For Latest News
	 */
	static function getAnnouncementsLatestNews()
	{
		$announcement = new Announcements();
		$announcements = $announcement->getHomePageAnnouncementList();
		return $announcements;
	}
	static function getSelectionPost()
	{
		$selectionpost = new Selectionpost();
		$selectionposts = $selectionpost->getSelectionPostList();
		return $selectionposts;
	}
	static function getSelectionPostChild()
	{
		$selectionpostchildclass = new Selectionpostschild();
		$selectpostschildlist = $selectionpostchildclass->getSelectionpostschild();
		return $selectpostschildlist;
	}
	/*******
	 * 
	 * Sp List For Latest News
	 * 
	 * 
	 * 
	 */
	static function getSelectionPostLatestNews()
	{
		$selectionpost = new Selectionpost();
		$selectionposts = $selectionpost->getSelectionPostListLatestNews();
		return $selectionposts;
	}
	static function getSelectionPostChildLatestNews()
	{
		$selectionpostchildclass = new Selectionpostschild();
		$selectpostschildlist = $selectionpostchildclass->getSelectionpostschildLatestNews();
		return $selectpostschildlist;
	}
	static function getCategorySelectionPostsList()
	{
		$category = new Category();
		$categorylist = $category->getCategorySelectionPosts();
		return  $categorylist;
	}
	static function getDList()
	{
		$dlist  = new Debarredlists();
		$dlist_details = $dlist->getDebarredLists();
		return  $dlist_details;
	}
	/****
	 * 
	 * Faq For Websites
	 */
	static function getFaqForWebsites()
	{
		$faq  = new Faq();
		$faq_details = $faq->getFaqDatails();
		return  $faq_details;
	}
	static function validateAndSanitizeHelper($input)
	{
		// Trim whitespace
		$input = trim($input ?? '');
		// Remove backslashes
		$input = stripslashes($input);
		// Use htmlspecialchars to encode special characters
		$input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
		// Your additional validation logic goes here
		// For example, checking if the input follows a specific pattern
		return $input;
	}
	static function getAdmitCardDetails()
	{
		$_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		$errorMsg = "";
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Verify CSRF token
			if (isset($_POST['examname'])) {
				if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
					// Token mismatch, handle the error (e.g., log it or display an error message)
					$errorMsg = "CSRF token verification failed.";
				}
				$register_number     = self::validateAndSanitizeHelper($_POST['register_number']);
				$dob   = self::validateAndSanitizeHelper($_POST['dob']);
				$examname = self::validateAndSanitizeHelper($_POST['examname']);
				$examname = explode('_', $examname);
				if ($examname[0] == 'phase') {
					$exam_value = $examname[0] . '_' . $examname[1] . '_' . $examname[2] . '_' . $examname[3] . '_' . $examname[4];
					$exam_type = $examname[4];
					$tier_id = $examname[5];
				} else {
					$exam_value = $examname[0] . '_' . $examname[1] . '_' . $examname[2];
					$exam_type = $examname[2];
					$tier_id = $examname[3];
				}
				$roll_no_new = self::validateAndSanitizeHelper($_POST['roll_number']);
				$roll_no =  isset($roll_no_new) ? $roll_no_new : null;
				// $post_preference_new = self::validateAndSanitizeHelper($_POST['post_preference_one']);
				// $post_preference =  isset($post_preference_new) ? $post_preference_new : null;
				$data_array = array(
					"table_name" => $exam_value,
					"register_number" => $register_number,
					"dob" => $dob,
					"tier_id" => $tier_id,
					"roll_no" => $roll_no
				);
				$tableName = $exam_value;
				$admitcard = new Admitcard();
				switch ($exam_type) {
					case "tier":
						//if exam type is written exam -start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListTIER();
						//	$admitcard->savetest();
						if ($admitcard->getAdmitcardforTierCount($data_array)) {
							//	exit;
							//ob_start();
							if ($admitcard->getAdmitcardforTier($data_array)) {
								//exit;
								$admitcardresults = $admitcard->getAdmitcardforTier($data_array);
								//$this->printr($admitcardresults);
								$array = json_decode(json_encode($admitcardresults), true);
								$exam_name = $admitcard->getExamName($exam_value);
								@$count = count((array)$admitcardresults);
								$arrays = [];
								foreach ($data as $val) {
									foreach (array_keys($array) as $res) {
										if ($res == $val->col_name) {
											$col_value =  $array[$res];
										}
										if ($res == 'pdf_attachment') {
											$pdf_name =  $array[$res];
										}
										if ($res == 'candidate_address') {
											$candidate_address =  $array[$res];
										}
										if ($res == 'exam_code') {
											$exam_year =  substr($array[$res], -4);
										}
									}
									$arrays[] = array(
										"col_name" => $val->col_name,
										"col_description" => $val->col_description,
										"is_tier" => $val->is_tier,
										"is_tier_order" => $val->is_tier_order,
										"col_value" => $col_value
									);
								}
								$datavalue = (object)$arrays;
								return ['admitcardresults' => $datavalue, 'year_of_exam' => $exam_year, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
							} else {
								$modelClass 		  = new Admitcard();
								$data_from_fetch_tier 		 		  =  $modelClass->getNoTier($data_array);
								$examDateObj    	  = $data_from_fetch_tier->date1;
								$currentDateObj 	  = $data_from_fetch_tier->current_date;
								//$currentDateObj 	  = "2023-10-18";
								$downloadStartDateObj = $data_from_fetch_tier->enabledate;
								$no_of_days           = $data_from_fetch_tier->no_of_days;
								if ($currentDateObj > $examDateObj) {
									$errorMsg   =  'Your scheduled date of Exam was over. You cannot download e-admit card';
								} elseif ($currentDateObj < $downloadStartDateObj) {
									$exam_date = date("d-m-Y", strtotime($examDateObj));
									$download_date = date("d-m-Y", strtotime($downloadStartDateObj));
									$errorMsg = "Your date of Exam $exam_date. You can download your e-admit card from $download_date ";
								} else {
									$errorMsg   = 'Exam is scheduled for a future date';
								}
							}
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						//ob_end_flush(); 
						break;
					case "skill":
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListSKILLTEST();  //1
						if ($admitcard->getAdmitcardforTierCount($data_array)) { //2
							if ($admitcard->getAdmitcardforSkillTest($data_array)) { //3
								$admitcardresults = $admitcard->getAdmitcardforSkillTest($data_array);
								//$this->printr($admitcardresults);
								$array = json_decode(json_encode($admitcardresults), true);
								$exam_name = $admitcard->getExamName($exam_value);
								@$count = count((array)$admitcardresults);
								$arrays = [];
								foreach ($data as $val) {
									foreach (array_keys($array) as $res) {
										if ($res == $val->col_name) {
											$col_value =  $array[$res];
										}
										if ($res == 'pdf_attachment') {
											$pdf_name =  $array[$res];
										}
										if ($res == 'candidate_address') {
											$candidate_address =  $array[$res];
										}
										if ($res == 'exam_code') {
											$exam_year =  substr($array[$res], -4);
										}
									}
									$arrays[] = array(
										"col_name" => $val->col_name,
										"col_description" => $val->col_description,
										"is_skill" => $val->is_skill, //4
										"is_skill_order" => $val->is_skill_order,
										"col_value" => $col_value
									);
								}
								$datavalue = (object)$arrays;
								return ['admitcardresults' => $datavalue, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, 'year_of_exam' => $exam_year, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
							} else {
								$modelClass 			  = new Admitcard();
								$data 		 		  =  $modelClass->getNoSkillTest($data_array); //5
								$examDateObj    	  = $data->skill_test_date; //6
								$currentDateObj 	  = $data->current_date; //7
								$downloadStartDateObj = $data->enableDate;
								$no_of_days           = $data->no_of_days;
								if ($currentDateObj > $examDateObj) {
									$errorMsg   =  'Your scheduled date of Exam was over. You cannot download e-admit card';
								} elseif ($currentDateObj < $downloadStartDateObj) {
									$exam_date = date("d-m-Y", strtotime($examDateObj));
									$download_date = date("d-m-Y", strtotime($downloadStartDateObj));
									$errorMsg = "Your date of Exam $exam_date. You can download your e-admit card from $download_date ";
								} else {
									$errorMsg   = 'Exam is scheduled for a future date';
								}
							}
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						break;
					case "pet":
						// If exam Type is PET Start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListPET();
						if ($admitcard->getAdmitcardforTierCount($data_array)) {
							if ($admitcard->getAdmitcardforPET($data_array)) {
								$admitcardresults = $admitcard->getAdmitcardforPET($data_array);
								/* echo "<pre>";
				print_r($admitcardresults);
				exit; */
								$array = json_decode(json_encode($admitcardresults), true);
								$exam_name = $admitcard->getExamName($exam_value);
								@$count = count((array)$admitcardresults);
								$arrays = [];
								foreach ($data as $val) {
									foreach (array_keys($array) as $res) {
										if ($res == $val->col_name) {
											$col_value =  $array[$res];
										}
										if ($res == 'pdf_attachment') {
											@$pdf_name =  $array[$res];
										}
										if ($res == 'candidate_address') {
											$candidate_address =  $array[$res];
										}
									}
									$arrays[] = array(
										"col_name" => $val->col_name,
										"col_description" => $val->col_description,
										"is_pet" => $val->is_pet,
										"is_pet_order" => $val->is_pet_order,
										"col_value" => $col_value
									);
								}
								$datavalue = (object)$arrays;
								$exam_year = $exam_name->table_exam_year;
								return ['admitcardresults' => $datavalue, 'year_of_exam' => $exam_year, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
							} else {
								$modelClass 			  = new Admitcard();
								$data 		 		  =  $modelClass->getNoPET($data_array);
								$examDateObj    	  = $data->pet_date;
								$currentDateObj 	  = $data->current_date;
								$downloadStartDateObj = $data->enabledate;
								$no_of_days           = $data->no_of_days;
								if ($currentDateObj > $examDateObj) {
									$errorMsg   =  'Your scheduled date of Exam was over. You cannot download e-admit card';
								} elseif ($currentDateObj < $downloadStartDateObj) {
									$exam_date = date("d-m-Y", strtotime($examDateObj));
									$download_date = date("d-m-Y", strtotime($downloadStartDateObj));
									$errorMsg = "Your date of Exam $exam_date. You can download your e-admit card from $download_date ";
								} else {
									$errorMsg   = 'Exam is scheduled for a future date';
								}
							}
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						// If exam Type is PET End
						break;
					case "dme":
						// If exam Type is DME Start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListDME();
						if ($admitcard->getAdmitcardforTierCount($data_array)) {
							if ($admitcard->getAdmitcardforDME($data_array)) {
								$admitcardresults = $admitcard->getAdmitcardforDME($data_array);
								// echo "<pre>";
								// print_r($admitcardresults);
								// exit; 
								$array = json_decode(json_encode($admitcardresults), true);
								$exam_name = $admitcard->getExamName($exam_value);
								$count = count((array)$admitcardresults);
								$arrays = [];
								foreach ($data as $val) {
									foreach (array_keys($array) as $res) {
										if ($res == $val->col_name) {
											$col_value =  $array[$res];
										}
										if ($res == 'pdf_attachment') {
											$pdf_name =  $array[$res];
										}
										if ($res == 'candidate_address') {
											$candidate_address =  $array[$res];
										}
									}
									$arrays[] = array(
										"col_name" => $val->col_name,
										"col_description" => $val->col_description,
										"is_dme" => $val->is_dme,
										"is_dme_order" => $val->is_dme_order,
										"col_value" => $col_value
									);
								}
								$datavalue = (object)$arrays;
								//$this->printr($datavalue);
								$exam_year = $exam_name->table_exam_year;
								return ['admitcardresults' => $datavalue, 'year_of_exam' => $exam_year, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
							} else {
								$modelClass 			  = new Admitcard();
								$data 		 		  =  $modelClass->getNoDME($data_array);
								$examDateObj    	  = $data->date_of_dme;
								$currentDateObj 	  = $data->current_date;
								$downloadStartDateObj = $data->enabledate;
								$no_of_days           = $data->no_of_days;
								if ($currentDateObj > $examDateObj) {
									$errorMsg   =  'Your scheduled date of Exam was over. You cannot download e-admit card';
								} elseif ($currentDateObj < $downloadStartDateObj) {
									$exam_date = date("d-m-Y", strtotime($examDateObj));
									$download_date = date("d-m-Y", strtotime($downloadStartDateObj));
									$errorMsg = "Your date of Exam $exam_date. You can download your e-admit card from $download_date ";
								} else {
									$errorMsg   = 'Exam is scheduled for a future date';
								}
							}
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						// If exam Type is DME End
						break;
					default:
						//if exam type is DV -start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListDV();
						if ($admitcard->getAdmitcardforTierCount($data_array)) {
							if ($admitcard->getAdmitcardforDV($data_array)) {
								$admitcardresults = $admitcard->getAdmitcardforDV($data_array);
								$array = json_decode(json_encode($admitcardresults), true);
								$exam_name = $admitcard->getExamName($exam_value);
								$count = count((array)$admitcardresults);
								$arrays = [];
								foreach ($data as $val) {
									foreach (array_keys($array) as $res) {
										if ($res == $val->col_name) {
											$col_value =  $array[$res];
										}
										if ($res == 'pdf_attachment') {
											$pdf_name =  $array[$res];
										}
									}
									$arrays[] = array(
										"col_name" => $val->col_name,
										"col_description" => $val->col_description,
										"is_dv" => $val->is_dv,
										"is_dv_order" => $val->is_dv_order,
										"col_value" => $col_value
									);
								}
								$datavalue = (object)$arrays;
								$exam_year = $exam_name->table_exam_year;
								//$this->printr($datavalue);
								return [
									'admitcardresults' => $datavalue,
									'year_of_exam' => $exam_year,
									'count' => $count,
									"exam_name" => $exam_name,
									"pdf_name" => @$pdf_name,
									"exam_type" => $exam_type,
									"tier_id" => $tier_id,
									"tableName" => $tableName,
									"regNo" => $register_number,
									"post_preference" => $post_preference
								];
							} else {
								$modelClass 			  = new Admitcard();
								$data 		 		  =  $modelClass->getNoDV($data_array);
								$examDateObj    	  = $data->dv_date;
								$currentDateObj 	  = $data->current_date;
								//$currentDateObj 	  = "2023-10-22" ;
								$downloadStartDateObj = $data->enabledate;
								$no_of_days           = $data->no_of_days;
								if ($currentDateObj > $examDateObj) {
									$errorMsg   =  'Your scheduled date of Exam was over. You cannot download e-admit card';
								} elseif ($currentDateObj < $downloadStartDateObj) {
									$exam_date = date("d-m-Y", strtotime($examDateObj));
									$download_date = date("d-m-Y", strtotime($downloadStartDateObj));
									$errorMsg = "Your date of Exam $exam_date. You can download your e-admit card from $download_date ";
								} else {
									$errorMsg   = 'Exam is scheduled for a future date';
								}
							}
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						//if exam type is DV -end
				} // Switch Case End
			}
		}
		return ['errorMsg' => $errorMsg];
	}
	static function getAdmitCardPreviewDetails()
	{
		$_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		//echo $data;
		$errorMsg = "";
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['admit_card'])) {
				if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
					// Token mismatch, handle the error (e.g., log it or display an error message)
					$errorMsg = "CSRF token verification failed.";
				}
				$register_number     = self::validateAndSanitizeHelper($_POST['register_number']);
				$dob   = self::validateAndSanitizeHelper($_POST['dob']);
				$examname = self::validateAndSanitizeHelper($_POST['examname']);
				$examname = explode('_', $examname);
				if ($examname[0] == 'phase') {
					$exam_value = $examname[0] . '_' . $examname[1] . '_' . $examname[2] . '_' . $examname[3] . '_' . $examname[4];
					$exam_type = $examname[4];
					$tier_id = $examname[5];
				} else {
					$exam_value = $examname[0] . '_' . $examname[1] . '_' . $examname[2];
					$exam_type = $examname[2];
					$tier_id = $examname[3];
				}
				//echo $exam_value;exit;
				$roll_no_new = self::validateAndSanitizeHelper($_POST['roll_number']);
				$roll_no =  isset($roll_no_new) ? $roll_no_new : null;
				$post_preference_new = self::validateAndSanitizeHelper($_POST['post_preference_one']);
				$post_preference =  isset($post_preference_new) ? $post_preference_new : null;
				$data_array = array(
					"table_name" => $exam_value,
					"register_number" => $register_number,
					"dob" => $dob,
					"tier_id" => $tier_id,
					"roll_no" => $roll_no,
					"post_preference" => $post_preference
				);
				$tableName = $exam_value;
				$admitcard = new Admitcard();
				switch ($exam_type) {
					case "tier":
						//if exam type is written exam -start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListTIER();
						//  $this->printr($data);
						if ($admitcard->getAdmitcardforTierPreview($data_array)) {
							// $admitcardresults = $admitcard->getAdmitcardforDV($data_array);
							// $array = json_decode(json_encode($admitcardresults), true);
							// $exam_name = $admitcard->getExamName($exam_value);
							// $count = count((array)$admitcardresults);
							// $arrays = [];
							$admitcardresults = $admitcard->getAdmitcardforTierPreview($data_array);
							//echo '<pre>';
							//print_r();
							$array = json_decode(json_encode($admitcardresults), true);
							$exam_name = $admitcard->getExamName($exam_value);
							@$count = count((array)$admitcardresults);
							$arrays = [];
							foreach ($data as $val) {
								foreach (array_keys($array) as $res) {
									if ($res == $val->col_name) {
										$col_value =  $array[$res];
									}
									if ($res == 'pdf_attachment') {
										$pdf_name =  $array[$res];
									}
									if ($res == 'candidate_address') {
										$candidate_address =  $array[$res];
									}
									if ($res == 'exam_code') {
										$exam_year =  substr($array[$res], -4);
									}
								}
								$arrays[] = array(
									"col_name" => $val->col_name,
									"col_description" => $val->col_description,
									"is_tier" => $val->is_tier,
									"is_tier_order" => $val->is_tier_order,
									"col_value" => $col_value
								);
							}
							$datavalue = (object)$arrays;
							return ['admitcardresults' => $datavalue, 'year_of_exam' => $exam_year, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						//if exam type is written exam -end
						break;
					case "skill":
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListSKILLTEST();
						if ($admitcard->getAdmitcardforSkillTestPreview($data_array)) {
							$admitcardresults = $admitcard->getAdmitcardforSkillTestPreview($data_array);
							//$this->printr($admitcardresults);
							$array = json_decode(json_encode($admitcardresults), true);
							$exam_name = $admitcard->getExamName($exam_value);
							@$count = count((array)$admitcardresults);
							$arrays = [];
							foreach ($data as $val) {
								foreach (array_keys($array) as $res) {
									if ($res == $val->col_name) {
										$col_value =  $array[$res];
									}
									if ($res == 'pdf_attachment') {
										$pdf_name =  $array[$res];
									}
									if ($res == 'candidate_address') {
										$candidate_address =  $array[$res];
									}
									if ($res == 'exam_code') {
										$exam_year =  substr($array[$res], -4);
									}
								}
								$arrays[] = array(
									"col_name" => $val->col_name,
									"col_description" => $val->col_description,
									"is_skill" => $val->is_skill,
									"is_skill_order" => $val->is_skill_order,
									"col_value" => $col_value
								);
							}
							$datavalue = (object)$arrays;
							return ['admitcardresults' => $datavalue, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, 'year_of_exam' => $exam_year, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						break;
					case "pet":
						// If exam Type is PET Start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListPET();
						if ($admitcard->getAdmitcardforPETPreview($data_array)) {
							$admitcardresults = $admitcard->getAdmitcardforPETPreview($data_array);
							/* echo "<pre>";
					print_r($admitcardresults);
					exit; */
							$array = json_decode(json_encode($admitcardresults), true);
							$exam_name = $admitcard->getExamName($exam_value);
							@$count = count((array)$admitcardresults);
							$arrays = [];
							foreach ($data as $val) {
								foreach (array_keys($array) as $res) {
									if ($res == $val->col_name) {
										$col_value =  $array[$res];
									}
									if ($res == 'pdf_attachment') {
										@$pdf_name =  $array[$res];
									}
									if ($res == 'candidate_address') {
										$candidate_address =  $array[$res];
									}
								}
								$arrays[] = array(
									"col_name" => $val->col_name,
									"col_description" => $val->col_description,
									"is_pet" => $val->is_pet,
									"is_pet_order" => $val->is_pet_order,
									"col_value" => $col_value
								);
							}
							$datavalue = (object)$arrays;
							$exam_year = $exam_name->table_exam_year;
							return ['admitcardresults' => $datavalue, 'year_of_exam' => $exam_year, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						// If exam Type is PET End
						break;
					case "dme":
						// If exam Type is DME Start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListDME();
						if ($admitcard->getAdmitcardforDMEPreview($data_array)) {
							$admitcardresults = $admitcard->getAdmitcardforDMEPreview($data_array);
							// echo "<pre>";
							// print_r($admitcardresults);
							// exit; 
							$array = json_decode(json_encode($admitcardresults), true);
							$exam_name = $admitcard->getExamName($exam_value);
							$count = count((array)$admitcardresults);
							$arrays = [];
							foreach ($data as $val) {
								foreach (array_keys($array) as $res) {
									if ($res == $val->col_name) {
										$col_value =  $array[$res];
									}
									if ($res == 'pdf_attachment') {
										$pdf_name =  $array[$res];
									}
									if ($res == 'candidate_address') {
										$candidate_address =  $array[$res];
									}
								}
								$arrays[] = array(
									"col_name" => $val->col_name,
									"col_description" => $val->col_description,
									"is_dme" => $val->is_dme,
									"is_dme_order" => $val->is_dme_order,
									"col_value" => $col_value
								);
							}
							$datavalue = (object)$arrays;
							//$this->printr($datavalue);
							$exam_year = $exam_name->table_exam_year;
							return ['admitcardresults' => $datavalue, 'year_of_exam' => $exam_year, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						// If exam Type is DME End
						break;
					default:
						//if exam type is DV -start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListDV();
						if ($admitcard->getAdmitcardforDVPreview($data_array)) {
							$admitcardresults = $admitcard->getAdmitcardforDVPreview($data_array);
							$array = json_decode(json_encode($admitcardresults), true);
							$exam_name = $admitcard->getExamName($exam_value);
							$count = count((array)$admitcardresults);
							$arrays = [];
							foreach ($data as $val) {
								foreach (array_keys($array) as $res) {
									if ($res == $val->col_name) {
										$col_value =  $array[$res];
									}
									if ($res == 'pdf_attachment') {
										$pdf_name =  $array[$res];
									}
								}
								$arrays[] = array(
									"col_name" => $val->col_name,
									"col_description" => $val->col_description,
									"is_dv" => $val->is_dv,
									"is_dv_order" => $val->is_dv_order,
									"col_value" => $col_value
								);
							}
							$datavalue = (object)$arrays;
							$exam_year = $exam_name->table_exam_year;
							//$this->printr($datavalue);
							return [
								'admitcardresults' => $datavalue,
								'year_of_exam' => $exam_year,
								'count' => $count,
								"exam_name" => $exam_name,
								"pdf_name" => @$pdf_name,
								"exam_type" => $exam_type,
								"tier_id" => $tier_id,
								"tableName" => $tableName,
								"regNo" => $register_number,
								"post_preference" => $post_preference
							];
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						//if exam type is DV -end
				} // Switch Case End
			}
		}
		return ['errorMsg' => $errorMsg];
	}
	static function getNominationListforAdmin()
	{
		$nomination = new Nomination();
		$nominations = $nomination->getNominationsList();
		return  $nominations;
	}
	static function getNominationChildListforAdmin()
	{
		$nominationchildclass = new Nominationchild();
		$nominationchildlist = $nominationchildclass->getNominationchild();
		return  $nominationchildlist;
	}
	static function getNoticeChildListforAdmin()
	{
		$noticechildclass = new MstNoticeChild();
		$result = $noticechildclass->getMstNoticeChild();
		return  $result;
	}
	static function getCategoryListforAdmin()
	{
		$category = new Category();
		$categories = $category->getCategorySelectionPosts();
		return $categories;
	}
	static function getDepartmentListforAdmin()
	{
		$department = new Department();
		$departments = $department->getDepartment();
		return $departments;
	}
	static function getPhaseListforAdmin()
	{
		$phase = new Phase();
		$phases = $phase->getPhase();
		return $phases;
	}
	static function getSearchyearforAdmin()
	{
		$searchyear = new SearchYear();
		$searchyears = $searchyear->getSearchyearList();
		return $searchyears;
	}
	static function getPostListforAdmin()
	{
		$post = new Post();
		$posts = $post->getPost();
		return $posts;
	}
	static function getSelectionpostListforAdmin()
	{
		$selectionpost = new Selectionpost();
		$selectionposts = $selectionpost->getSelectionPostListAdmin();
		return $selectionposts;
	}
	static function getSelectionpostchildListforAdmin()
	{
		$selectionpostchildclass = new Selectionpostschild();
		$selectpostschildlist = $selectionpostchildclass->getSelectionpostschild();
		return  $selectpostschildlist;
	}
	static function getDebarredListforAdmin()
	{
		$debarredlistsclass = new Debarredlists();
		$debarredgetlists = $debarredlistsclass->getDlists();
		return  $debarredgetlists;
	}
	static function getUserCreationforAdmin()
	{
		$usercreationclass = new Loginusers();
		$usercreationlists = $usercreationclass->getUsers();
		return  $usercreationlists;
	}
	static function getCategoryCreationListforAdmin()
	{
		$categorycreationclass = new Category();
		$categorycreationlists = $categorycreationclass->getCategory();
		return $categorycreationlists;
	}
	static function getNoticeListforAdmin()
	{
		$noticecreationclass = new Notice();
		$noticecreationlists = $noticecreationclass->getNoticeDashboard();
		return $noticecreationlists;
	}
	static function getNoticeListArchivesforAdmin()
	{
		$noticecreationarchivesclass = new NoticeArchives();
		$noticecreationlists = $noticecreationarchivesclass->getNoticeDashboard();
		return $noticecreationlists;
	}
	static function getTenderListforAdmin()
	{
		$tendercreationclass = new Tender();
		$tendercreationlists = $tendercreationclass->getTender();
		return $tendercreationlists;
	}
	static function getTenderListArchivesforAdmin()
	{
		$tendercreationclass = new TenderArchives();
		$tendercreationlists = $tendercreationclass->getTender();
		return $tendercreationlists;
	}
	static function getImportantLinksListforAdmin()
	{
		$importantlinkscreationclass = new ImportantLinks();
		$importantlinkscreationlists = $importantlinkscreationclass->getImportantLinks();
		return  $importantlinkscreationlists;
	}
	static function getEventCategoryListforAdmin()
	{
		$eventcategorymodel = new EventCategory();
		$eventcategorygetlists = $eventcategorymodel->getEventCategoriesList();
		return  $eventcategorygetlists;
	}
	static function getloginuserListforAdmin()
	{
		$loginusermodel = new LoginFlag();
		$loginuserlists = $loginusermodel->getLoginList();
		return  $loginuserlists;
	}
	static function getPhaseMasterListforAdmin()
	{
		$phasemastermodel = new PhaseMaster();
		$phasemastergetlists = $phasemastermodel->getPhaseMasterList();
		return  $phasemastergetlists;
	}
	static function getSearchYearListforAdmin()
	{
		$searchyearmodel = new SearchYear();
		$searchyeargetlists = $searchyearmodel->getSearchyearListDisplay();
		return  $searchyeargetlists;
	}
	static function getPhotoGalleryListforAdmin()
	{
		$gallerymodel = new Gallery();
		$gallerymodelgetlists = $gallerymodel->getGalleryList();
		return   $gallerymodelgetlists;
	}
	static function getPhotoGalleryChildListforAdmin()
	{
		$gallerymodelchild = new GalleryChild();
		$gallerymodelchildlist = $gallerymodelchild->getGalleryChildList();
		return    $gallerymodelchildlist;
	}
	static function encrypt_with_cryptoJS_and_decrypt_with_php($encrypted_data)
	{
		// we use the same key and IV
		$key = hex2bin("0123456789abcdef0123456789abcdef");
		$iv =  hex2bin("abcdef9876543210abcdef9876543210");
		// we receive the encrypted string from the post
		$decrypted = openssl_decrypt($encrypted_data, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
		// finally we trim to get our original string
		$decryptedStr = preg_replace("/[^0-9A-Za-z]/", "", trim($decrypted));
		return $decryptedStr;
	}
	static function getAdmitCardbyEmailIntegration($data_array)
	{
		$errorMsg = "";
		$_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['admit_card'])) {
				$register_number     = self::validateAndSanitizeHelper($_POST['register_number']);
				$dob   = self::validateAndSanitizeHelper($_POST['dob']);
				$examname = self::validateAndSanitizeHelper($_POST['examname']);
				$examname = explode('_', $examname);
				if ($examname[0] == 'phase') {
					$exam_value = $examname[0] . '_' . $examname[1] . '_' . $examname[2] . '_' . $examname[3] . '_' . $examname[4];
					$exam_type = $examname[4];
					$tier_id = $examname[5];
				} else {
					$exam_value = $examname[0] . '_' . $examname[1] . '_' . $examname[2];
					$exam_type = $examname[2];
					$tier_id = $examname[3];
				}
				$roll_no_new = self::validateAndSanitizeHelper($_POST['roll_number']);
				$roll_no =  isset($roll_no_new) ? $roll_no_new : null;
				$post_preference_new = self::validateAndSanitizeHelper($_POST['post_preference_one']);
				$post_preference =  isset($post_preference_new) ? $post_preference_new : null;
				$data_array = array(
					"table_name" => $exam_value,
					"register_number" => $register_number,
					"dob" => $dob,
					"tier_id" => $tier_id,
					"roll_no" => $roll_no,
					"post_preference" => $post_preference
				);
				$tableName = $exam_value;
				$admitcard = new Admitcard();
				switch ($exam_type) {
					case "tier":
						//if exam type is written exam -start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListTIER();
						// $this->printr($data);
						if ($admitcard->getAdmitcardforTierPreview($data_array)) {
							$admitcardresults = $admitcard->getAdmitcardforTierPreview($data_array);
							$array = json_decode(json_encode($admitcardresults), true);
							$exam_name = $admitcard->getExamName($exam_value);
							@$count = count((array)$admitcardresults);
							$arrays = [];
							foreach ($data as $val) {
								foreach (array_keys($array) as $res) {
									if ($res == $val->col_name) {
										$col_value =  $array[$res];
									}
									if ($res == 'pdf_attachment') {
										$pdf_name =  $array[$res];
									}
									if ($res == 'candidate_address') {
										$candidate_address =  $array[$res];
									}
									if ($res == 'exam_code') {
										$exam_year =  substr($array[$res], -4);
									}
								}
								$arrays[] = array(
									"col_name" => $val->col_name,
									"col_description" => $val->col_description,
									"is_tier" => $val->is_tier,
									"is_tier_order" => $val->is_tier_order,
									"col_value" => $col_value
								);
							}
							$datavalue = (object)$arrays;
							return ['admitcardresults' => $datavalue, 'year_of_exam' => $exam_year, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						//if exam type is written exam -end
						break;
					case "skill":
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListSKILLTEST();
						if ($admitcard->getAdmitcardforSkillTestPreview($data_array)) {
							$admitcardresults = $admitcard->getAdmitcardforSkillTestPreview($data_array);
							$array = json_decode(json_encode($admitcardresults), true);
							$exam_name = $admitcard->getExamName($exam_value);
							@$count = count((array)$admitcardresults);
							$arrays = [];
							foreach ($data as $val) {
								foreach (array_keys($array) as $res) {
									if ($res == $val->col_name) {
										$col_value =  $array[$res];
									}
									if ($res == 'pdf_attachment') {
										$pdf_name =  $array[$res];
									}
									if ($res == 'candidate_address') {
										$candidate_address =  $array[$res];
									}
									if ($res == 'exam_code') {
										$exam_year =  substr($array[$res], -4);
									}
								}
								$arrays[] = array(
									"col_name" => $val->col_name,
									"col_description" => $val->col_description,
									"is_skill" => $val->is_skill,
									"is_skill_order" => $val->is_skill_order,
									"col_value" => $col_value
								);
							}
							$datavalue = (object)$arrays;
							return ['admitcardresults' => $datavalue, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, 'year_of_exam' => $exam_year, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						break;
					case "pet":
						// If exam Type is PET Start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListPET();
						if ($admitcard->getAdmitcardforPET($data_array)) {
							$admitcardresults = $admitcard->getAdmitcardforPET($data_array);
							/* echo "<pre>";
							print_r($admitcardresults);
							exit; */
							$array = json_decode(json_encode($admitcardresults), true);
							$exam_name = $admitcard->getExamName($exam_value);
							@$count = count((array)$admitcardresults);
							$arrays = [];
							foreach ($data as $val) {
								foreach (array_keys($array) as $res) {
									if ($res == $val->col_name) {
										$col_value =  $array[$res];
									}
									if ($res == 'pdf_attachment') {
										@$pdf_name =  $array[$res];
									}
									if ($res == 'candidate_address') {
										$candidate_address =  $array[$res];
									}
								}
								$arrays[] = array(
									"col_name" => $val->col_name,
									"col_description" => $val->col_description,
									"is_pet" => $val->is_pet,
									"is_pet_order" => $val->is_pet_order,
									"col_value" => $col_value
								);
							}
							$datavalue = (object)$arrays;
							$exam_year = $exam_name->table_exam_year;
							return ['admitcardresults' => $datavalue, 'year_of_exam' => $exam_year, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						// If exam Type is PET End
						break;
					case "dme":
						// If exam Type is DME Start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListDME();
						if ($admitcard->getAdmitcardforDME($data_array)) {
							$admitcardresults = $admitcard->getAdmitcardforDME($data_array);
							// echo "<pre>";
							// print_r($admitcardresults);
							// exit; 
							$array = json_decode(json_encode($admitcardresults), true);
							$exam_name = $admitcard->getExamName($exam_value);
							$count = count((array)$admitcardresults);
							$arrays = [];
							foreach ($data as $val) {
								foreach (array_keys($array) as $res) {
									if ($res == $val->col_name) {
										$col_value =  $array[$res];
									}
									if ($res == 'pdf_attachment') {
										$pdf_name =  $array[$res];
									}
									if ($res == 'candidate_address') {
										$candidate_address =  $array[$res];
									}
								}
								$arrays[] = array(
									"col_name" => $val->col_name,
									"col_description" => $val->col_description,
									"is_dme" => $val->is_dme,
									"is_dme_order" => $val->is_dme_order,
									"col_value" => $col_value
								);
							}
							$datavalue = (object)$arrays;
							//$this->printr($datavalue);
							$exam_year = $exam_name->table_exam_year;
							return ['admitcardresults' => $datavalue, 'year_of_exam' => $exam_year, 'count' => $count, "exam_name" => $exam_name, "pdf_name" => @$pdf_name, "exam_type" => $exam_type, "candidate_address" => $candidate_address, "tier_id" => $tier_id, "tableName" => $tableName, "regNo" => $register_number];
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						// If exam Type is DME End
						break;
					default:
						//if exam type is DV -start
						$modelClass = new Admitcard();
						$data =  $modelClass->getQueryListDV();
						if ($admitcard->getAdmitcardforDVPreview($data_array)) {
							$admitcardresults = $admitcard->getAdmitcardforDVPreview($data_array);
							$array = json_decode(json_encode($admitcardresults), true);
							$exam_name = $admitcard->getExamName($exam_value);
							$count = count((array)$admitcardresults);
							$arrays = [];
							foreach ($data as $val) {
								foreach (array_keys($array) as $res) {
									if ($res == $val->col_name) {
										$col_value =  $array[$res];
									}
									if ($res == 'pdf_attachment') {
										$pdf_name =  $array[$res];
									}
								}
								$arrays[] = array(
									"col_name" => $val->col_name,
									"col_description" => $val->col_description,
									"is_dv" => $val->is_dv,
									"is_dv_order" => $val->is_dv_order,
									"col_value" => $col_value
								);
							}
							$datavalue = (object)$arrays;
							$exam_year = $exam_name->table_exam_year;
							//$this->printr($datavalue);
							return [
								'admitcardresults' => $datavalue,
								'year_of_exam' => $exam_year,
								'count' => $count,
								"exam_name" => $exam_name,
								"pdf_name" => @$pdf_name,
								"exam_type" => $exam_type,
								"tier_id" => $tier_id,
								"tableName" => $tableName,
								"regNo" => $register_number,
								"post_preference" => $post_preference
							];
						} else {
							$errorMsg = "Your credentials are NOT correct. Please try with correct credentials";
						}
						//if exam type is DV -end
				} // Switch Case End
			}
		}
		return ['errorMsg' => $errorMsg];
	}
	static function getArchives($category, $modelClassName, $functionName)
	{
		$category = Helpers::$functionName();
		$date = date("Y-m-d");
		$count = count((array)$category);
		if ($count > 0) {  // Tender  count if start
			switch ($modelClassName) {
				case "Tender":
					foreach ($category as $sn => $categorylist) : // Foreach Start
						$due_date = date('Y-m-d', strtotime($categorylist->effect_from_date));
						$pdf_name = $categorylist->pdf_name;
						$attachment = $categorylist->attachment;
						$id = date('Y-m-d', strtotime($categorylist->tender_id));
						if ($categorylist->p_status == '1') { // Status Check start if
							if (strtotime($due_date) < strtotime($date)) { // Date Comparison start if
								$tender_id = 0;
								$category_data = [
									'pdf_name' => $pdf_name,
									'attachment' => $attachment,
									'date_archived' => $due_date,
									'p_status' => '0'
								];
								$tendersarchives =  new \App\Models\TenderArchives();
								if ($tender_id == 0) { //tender is 0
									if ($tendersarchives->addTender($category_data)) { // Insert Tender Archives Start 
										$tendersarchives =  new \App\Models\TenderArchives();
									}  // Insert Tender Archives End 
									$tendersarchives =  new \App\Models\Tender();
									if ($tendersarchives->deleteTenderStatus($categorylist->tender_id)) { //Delete  Tender Start 
										$noticesarchives =  new \App\Models\TenderArchives();
									}  // Delete Tender End 
								} //tender is 0
							} // Date Comparison End if
						} // Status Check end if
					endforeach;  // Foreach End
					$tendercreationlists_new = Helpers::$functionName();
					$tendercreationlistsarchives = Helpers::getTenderListArchivesforAdmin();
					break;
				case "SelectionpostArchives":
					$model = new SelectionpostArchives();
					break;
				case "NoticeArchives":
					$model = new NoticeArchives();
					break;
				default:
					echo "Your favorite color is neither red, blue, nor green!";
			}
		}  // Tender  count if End
		$array = array(
			"creation_lists_new" => @$tendercreationlists_new,
			"creation_lists_archives" => @$tendercreationlistsarchives
		);
		return  $array;
	}
	static function flagoutput($status)
	{
		$flag = "";
		if ($status == 1) {
			$flag .= '<i class="fa fa-flag" aria-hidden="true"  style="color:green"></i>';
		} else {
			$flag .=  '<i class="fa fa-flag" aria-hidden="true" style="color:red"></i>';
		}
		return $flag;
	}
	static function roleBased()
	{
		$user = new Users();
		$is_superadmin = $user->is_superadmin(); // super admin 
		$data['is_superadmin'] = $is_superadmin; // super admin 
		$is_admin = $user->is_admin(); // admin 
		$data['is_admin'] = $is_admin; // admin 
		$is_uploader = $user->is_uploader(); //uploader
		$data['is_uploader'] = $is_uploader; //uploader
		$is_publisher = $user->is_publisher();  // publisher
		$data['is_publisher'] = $is_publisher;  // publisher
		return $data;
	}
	static function iconOperation(
		$edit_tender_link_str,
		$delete_tender_link_str,
		$archive_tender_link_str,
		$primaryid,
		$idname,
		$publishbaseurl,
		$archivesbaseurl,
		$redirecturl,
		$status,
		$model
	) {
		$actionoutput = "";
		$actionoutput .= <<<TEXT
                <form method="post">       
        TEXT;
		$actionoutput .=  '<a href=" ' . $edit_tender_link_str . '" name="menu_update" class="iconSize" > 
                <button type="button" title="Edit" class="btn btn-secondary iconWidth" ><i class="fas fa-edit"></i></button>
                </a>';
		$actionoutput .= <<<TEXT
        <a href=" $delete_tender_link_str" 
        onclick="return confirmationdelete(event)" 
        class="iconSize" name="delete">
        <button type="button" title="Delete" class="btn btn-danger iconWidth"><i class="fas fa-trash"></i></button>
        </a>
        TEXT;
		$actionoutput .= <<<TEXT
		<button type="button" title="Publish" class="btn btn-primary iconWidth"><i class="fa fa-archive archives-button" 
		style="" id="$primaryid" onclick="archivesButton(
			'archives-button',
			'$idname',
			'$archivesbaseurl',
			'$redirecturl', 
			'$model',   
			'$primaryid'
		)"></i></button>
	TEXT;
		// $actionoutput .= <<<TEXT
		// <a href=" $archive_tender_link_str" 
		// onclick="return confirmationarchive(event)" 
		// class="iconSize" name="archive">
		// <button type="button" title="Archive" class="btn btn-info iconWidth"><i class="fas fa-archive"></i></button>
		// </a>
		// TEXT;
		if (@$_GET['status'] == 0 &&  $status != 1) {
			$actionoutput .= <<<TEXT
            <button type="button" title="Publish" class="btn btn-primary iconWidth"><i class="fa fa-eye tender-publish-button" 
            style="" id="$primaryid" onclick="publishButton(
                'tender-publish-button',
                '$idname',
                '$archivesbaseurl',
                '$redirecturl', 
                '$model',  
                '$primaryid'
            )"></i></button>
        TEXT;
		}
		$actionoutput .= <<<TEXT
        <input type="hidden" value=" $primaryid " name="id" id="$idname">
        TEXT;
		$actionoutput .= "</form>";
		return $actionoutput;
	}
	static function encryptData($data, $key)
	{
		$iv = random_bytes(16);
		$encryptedData = base64_encode(openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv));
		return urlencode($iv . ':' . $encryptedData); // Concatenate IV and encrypted data, then URL encode
	}
	// Decryption function
	static function decryptData($data, $key)
	{
		$data = urldecode($data);
		list($iv, $encryptedData) = explode(':', $data, 2);
		return openssl_decrypt(base64_decode($encryptedData), 'aes-256-cbc', $key, 0, $iv);
	}
}
