<?php
namespace App\Controllers;
use App\System\Route;
use App\Helpers\Helpers;
use App\Models\Candidate;
use App\Models\Faq as Faq;
use App\Models\Menu as Menu;
use App\Models\Page as Page;
use App\Models\Post as Post;
use App\Models\Users as User;
use App\Models\Phase as Phase;
use App\Models\TenderArchives;
use App\Models\Notice as Notice;
use App\Models\Tender as Tender;
use App\Models\Announcements as Announcements;
use App\Models\Gallery as Gallery;
use App\Models\Category as Category;
use App\Controllers\BackEndController;
use App\Models\Department as Department;
use App\Models\Loginusers as Loginusers;
use App\Models\Nomination as Nomination;
use App\Models\NominationArchieveschild;
use App\Models\GalleryChild as GalleryChild;
use App\Models\Debarredlists as Debarredlists;
use App\Models\EventCategory as EventCategory;
use App\Models\Selectionpost as Selectionpost;
use App\Models\ImportantLinks as ImportantLinks;
use App\Models\NoticeArchives as NoticeArchives;
use App\Models\Nominationchild as Nominationchild;
use App\Models\NominationArchieves as NominationArchieves;
use App\Models\Selectionpostschild as Selectionpostschild;
use App\Models\SelectionpostArchives as SelectionpostArchives;
use App\Models\SelectionpostschildArchives as SelectionpostschildArcirclechives;
use App\Models\PhaseMaster as PhaseMaster;
use App\Models\SearchYear as SearchYear;
use App\Models\Instructions as Instructions;
use App\Models\MstNotice as MstNotice;
use App\Models\MstNoticeChild as MstNoticeChild;
use App\Models\Exam as Exam;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class Admin extends BackEndController
{
    public $links = array(
        "gallery_link" => "Admin/dashboard/?action=listofphotogallery",
        "event_category_link" => "Admin/dashboard/?action=listofeventcategories",
        "important_link" => "Admin/dashboard/?action=listofimportantlinks",
        "tender_link" => "Admin/dashboard/?action=listoftenders",
        "notice_link" => "Admin/dashboard/?action=listofnotices",
        "announcement_link" => "Admin/dashboard/?action=listofannouncements",
        "instructions_link" => "Admin/dashboard/?action=listofinstructions",
        "category_link" => "Admin/dashboard/?action=listofcategory",
        "photogallery_link" => "Admin/dashboard/?action=listphotogallery",
        "list_exams_link" => "Admin/dashboard/?action=listexams",
        "menus_reorder_link" => "Admin/dashboard/?action=listmenuorders",
        "category_reorder_nomination_link" => "Admin/dashboard/?action=listnominationreorders",
        "category_reorder_sp_link" => "Admin/dashboard/?action=listselectionpostreorders",
        "sub_menus_reorder_link" => "Admin/dashboard/?action=listsubmenuorders",
        "sub_menus_reorder_link_new" => "Admin/dashboard/?action=listsubmenuordersnew",
        "create_exam_link" => "Admin/editexam",
        "edit_exam_link" => "Admin/editexam/{id}",
        "delete_exam_link" => "Admin/deleteexam/{id}",
        "view_exam_link" => "Admin/viewexam/{id}",
        "list_menu_link" => "Admin/dashboard/?action=listmenus",
        "create_menu_link" => "Admin/editmenu",
        "edit_menu_link" => "Admin/editmenu/{id}",
        "view_menu_link" => "Admin/viewmenu/{id}",
        "delete_menu_link" => "Admin/deletemenu/{id}",
        "published_menus_list_link" => "Admin/dashboard/?action=listmenus&&status=1",
        "unpublished_menus_list_link" => "Admin/dashboard/?action=listmenus&&status=0",
        "list_page_link" => "Admin/dashboard/?action=listpages",
        "create_page_link" => "Admin/editpage",
        "edit_page_link" => "Admin/editpage/{id}",
        "view_page_link" => "Admin/viewpage/{id}",
        "delete_page_link" => "Admin/deletepage/{id}",
        ##### page  published & Page unpublished ######
        "published_pages_list_link" => "Admin/dashboard/?action=listpages&&status=1",
        "unpublished_pages_list_link" => "Admin/dashboard/?action=listpages&&status=0",
        ##### page  published & Page unpublished ######
        "create_candidate_link" => "Admin/editcandidate",
        "edit_candidate_link" => "Admin/editcandidate/{id}",
        "delete_candidate_link" => "Admin/deletecandidate/{id}",
        "view_candidate_link" => "Admin/viewcandidate/{id}",
        "list_nomination_link" => "Admin/dashboard/?action=listnominations",
        "list_nomination_archives_link" => "Admin/dashboard/?action=listnominationsarchieves",
        "nomination_archieves" => "Admin/dashboard/?action=listnomination_archieves",
        "sp_archieves_by_month" => "Admin/dashboard/?action=sp_archieves_by_month",
        "list_notices_archives_link" => "Admin/dashboard/?action=listnoticesarchieves",
        "notices_archieves_by_month" => "Admin/dashboard/?action=notices_archieves_by_month",
        "list_tender_archives_link" => "Admin/dashboard/?action=listtenderarchieves",
        "tender_archieves_by_month" => "Admin/dashboard/?action=tender_archieves_by_month",
        "announcement_archieves_by_month" => "Admin/dashboard/?action=announcement_archieves_by_month",
        "instructions_archieves_by_month" => "Admin/dashboard/?action=instructions_archieves_by_month",
        "common_nomination_archive" => "Admin/commonNominationArchive",
        "common_sp_archive" => "Admin/commonSelectionPostArchive",
        "common_tender_archive" => "Admin/commonTenderArchive",
        "common_dlist_archive" => "Admin/commonDlistArchive",
        "common_announcement_archive" => "Admin/commonAnnouncementArchive",
        "common_instructions_archive" => "Admin/commonInstructionsArchive",
        "common_notice_archive" => "Admin/commonNoticeArchive",
        "tender_boy" => "Admin/ArchiveTest",
        "common_gallery_archive" => "Admin/commonGalleryArchive",
        "create_nomination_link" => "Admin/editnomination",
        "edit_nomination_link" => "Admin/editnomination/{id}",
        "delete_nomination_link" => "Admin/deletenomination/{id}",
        "list_selection_posts_link" => "Admin/dashboard/?action=listselectionposts",
        "list_selection_posts_archives_link" => "Admin/dashboard/?action=listselectionpostsarchives",
        "create_selection_post_link" => "Admin/editselectionpost",
        "edit_selection_post_link" => "Admin/editselectionpost/{id}",
        "delete_selection_post_link" => "admin/deleteselectionpost/{id}",
        "list_ckeditor_link_file" => "Admin/dashboard/?action=listckeditor&type=file",
        "list_ckeditor_link_image" => "Admin/dashboard/?action=listckeditor&type=image",
        "list_debarred_lists_link" => "Admin/dashboard/?action=listdebarredlists",
        "create_debarred_lists_link" => "Admin/editdebarredlists",
        "edit_debarred_lists_link" => "Admin/editdebarredlists/{id}",
        "delete_debarred_lists_link" => "admin/deletedebarredlists/{id}",
        "list_of_login_user_details" => "Admin/dashboard/?action=listofloginusers",
        "create_login_user_link" => "Admin/editloginuser",
        "edit_login_user_link" => "Admin/editloginuser/{id}",
        "delete_login_user_link" => "admin/deleteloginuser/{id}",
        "list_of_category" => "Admin/dashboard/?action=listofcategory",
        "create_category_link" => "Admin/editcategory",
        "edit_category_link" => "Admin/editcategory/{id}",
        "delete_category_link" => "admin/deletecategory/{id}",
        "list_of_notices" => "Admin/dashboard/?action=listofnotices",
        "create_notice_link" => "Admin/editnotice",
        "edit_notice_link" => "Admin/editnotice/{id}",
        "delete_notice_link" => "admin/deletenotice/{id}",
        /*****
         * #
         * FAQ
         *
         */
        "list_of_faq" => "Admin/dashboard/?action=listoffaq",
        "create_faq_link" => "Admin/editfaq",
        "edit_faq_link" => "Admin/editfaq/{id}",
        "delete_faq_link" => "admin/deletefaq/{id}",
        /*****
         *
         * FAQ
         *
         */
        "list_of_tenders" => "Admin/dashboard/?action=listoftenders",
        "create_tender_link" => "Admin/edittender",
        "edit_tender_link" => "Admin/edittender/{id}",
        "delete_tender_link" => "admin/deletetender/{id}",
        //Announcement
        "list_of_announcements" => "Admin/dashboard/?action=listofannouncements",
        "create_announcement_link" => "Admin/editannouncements",
        "edit_announcement_link" => "Admin/editannouncements/{id}",
        "delete_announcement_link" => "admin/deleteannouncement/{id}",
        //Important Instructions
        "list_of_instructions" => "Admin/dashboard/?action=listofinstructions",
        "create_instructions_link" => "Admin/editinstructions",
        "edit_instructions_link" => "Admin/editinstructions/{id}",
        "delete_instructions_link" => "admin/deleteinstructions/{id}",
        "common_archives__link" => "admin/archiveBtnFunction/{id}",
        "copy_tender_link" => "admin/copy-tender/{id}",
        "list_of_importantlinks" => "Admin/dashboard/?action=listofimportantlinks",
        "create_important_link" => "Admin/editimportantlink",
        "edit_important_link" => "Admin/editimportantlink/{id}",
        "delete_important_link" => "admin/deleteimportantlink/{id}",
        //Event Category 
        "list_of_event_categories" => "Admin/dashboard/?action=listofeventcategories",
        "create_event_category_link" => "Admin/editeventcategory",
        "edit_event_category_link" => "Admin/editeventcategory/{id}",
        "delete_event_category_link" => "admin/deleteeventcategory/{id}",
        //Event Category 
        //Phase Master
        "list_of_phase_master" => "Admin/dashboard/?action=listofphasemaster",
        "create_phase_master_link" => "Admin/editphasemaster",
        "edit_phase_master_link" => "Admin/editphasemaster/{id}",
        "delete_phase_master_link" => "admin/deletephasemaster/{id}",
        //Phase Master
        //Photo Gallery
        "list_of_gallery" => "Admin/dashboard/?action=listofgallery",
        "create_gallery_link" => "Admin/editgallery",
        "edit_gallery_link" => "Admin/editgallery/{id}",
        "delete_gallery_link" => "admin/deletegallery/{id}",
        //Photo Category 
        //SearchYear
        "list_of_search_year" => "Admin/dashboard/?action=listofsearchyear",
        "create_search_year_link" => "Admin/editsearchyear",
        "edit_search_year_link" => "Admin/editsearchyear/{id}",
        "delete_search_year_link" => "admin/deletesearchyear/{id}",
    );
    public function __construct($param_data = array())
    {
        parent::__construct($param_data);
        $this->setTheme("admin");
        // since al admin pages are authorized, redirect if the session is gone
        if (!isset($_SESSION['user'])) {
            $this->logout();
        }
    }
    public function index()
    {
        $this->dashboard();
    }
    public function dashboard()
    {
        // check for add menu
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        if ($is_admin) {
        }
        $menu = new Menu();
        $status = isset($_GET['status']) ? $_GET['status'] : 0;
        #####  Menu Publish and Unpublished  Start #####
        if ($status == null || $status == 0) {
            $menus = $menu->getMenus();
        } else {
            $menus = $menu->getAllPublishedMenus();
        }
        $data['menus'] = $menus;
        // echo '<pre>';
        // print_r($data['menus']);
        // exit;
        #####  Menu Publish and Unpublished End #####
        #####  Page Publish and Unpublished #####
        $page = new Page();
        if ($status == null || $status == 0) {
            $pages = $page->getPagesUnpublished();
        } else {
            $pages = $page->getPagesPublished();
        }
        $data['pages'] = $pages;
        // echo '<pre>';
        //  print_r($data['pages']);
        #####  Page Publish and Unpublished #####
        $data['nominations'] = Helpers::getNominationListforAdmin();
        $date = date("Y-m-d");
        $nominationCount = count((array) $data['nominations']);
        /****
         * 
         * Nomination Archieves
         * 
         * 
         */
        $data['nominations_new'] = Helpers::getNominationListforAdmin();
        $data['nominationchildlist'] = Helpers::getNominationChildListforAdmin();
        // $data['nominationsarchieves'] = Helpers::getNominationArchievesListforAdmin();
        // $data['nominationarchieveschildlist'] = Helpers::getNominationArchievesChildListforAdmin();
        // echo '<pre>';
        //print_r($data['nominationarchieveschildlist']);
        /*****
         * 
         * Selection Post Archives
         * 
         */
        $data['selectionposts'] = Helpers::getSelectionpostListforAdmin();
        $data['selectposts_new'] = Helpers::getSelectionpostListforAdmin();
        $data['selectpostschildlist'] = Helpers::getSelectionpostchildListforAdmin();
        $data['selectionpostsarchieves'] = Helpers::getSelectionPostsArchievesListforAdmin();
        $data['selectionpostsarchieveschildlist'] = Helpers::getSelectionPostsArchievesChildListforAdmin();
        $data['noticecreationlists'] = Helpers::getNoticeListforAdmin();
        $data['noticecreationlists_new'] = Helpers::getNoticeListforAdmin();
        $data['noticecreationlistsarchives'] = Helpers::getNoticeListArchivesforAdmin();
        // $tendercreationlists = Helpers::getArchives("tendercreationlists","Tender","getTenderListforAdmin");
        //$creation_lists_new =  $tendercreationlists["creation_lists_new"] ;
        //  $data['creation_lists_new'] = $tendercreationlists["creation_lists_new"] ;
        //  $data['creation_lists_archives'] = $tendercreationlists["creation_lists_archives"] ;
        $data['categories'] = Helpers::getCategoryListforAdmin();
        $data['departments'] = Helpers::getDepartmentListforAdmin();
        $data['phases'] = Helpers::getPhaseListforAdmin();
        $data['searchyears'] = Helpers::getSearchyearforAdmin();
        $data['posts'] = Helpers::getPostListforAdmin();
        $data['debarredgetlists'] = Helpers::getDebarredListforAdmin();
        $data['usercreationlists'] = Helpers::getUserCreationforAdmin();
        $data['categorycreationlists'] = Helpers::getCategoryCreationListforAdmin();
        /****
         *
         * #faq
         */
        $data['faqlists'] = Helpers::getFaqListforAdmin();
        $data['importantlinkscreationlists'] = Helpers::getImportantLinksListforAdmin();
        $data['eventcategorygetlists'] = Helpers::getEventCategoryListforAdmin();
        $data['phasemastergetlists'] = Helpers::getPhaseMasterListforAdmin();
        $data['searchyeargetlists'] = Helpers::getSearchYearListforAdmin();
        $data['gallerymodelgetlists'] = Helpers::getPhotoGalleryListforAdmin();
        $data['gallerymodelchildlist'] = Helpers::getPhotoGalleryChildListforAdmin();
        $data['user_role_id'] = (int) $loginUser['roleid'];
        $data['logged_user'] = $loginUser;
        //$data['status']  = $status;
        $this->prepare_menus($data);
        if (isset($_SESSION['notification'])) {
            $notification_data = $_SESSION['notification'];
            $data = array_merge($data, $notification_data);
            unset($_SESSION['notification']);
        }
        $this->render("dashboard", $data);
    }
    private function prepare_menus(&$data)
    {
        $link_routes = [];
        $route = new \App\System\Route();
        foreach ($this->links as $key => $route_str) {
            $link_routes[$key] = $route->site_url($route_str);
        }
        $data = array_merge($data, $link_routes);
    }
    public function editMenu()
    {
        $data = [];
        $this->saveMenu();
        $user = new User();
        $page = new Page();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $is_admin = $user->is_admin();
        $data['is_admin'] = $is_admin;
        $data['logged_user'] = $loginUser;
        $data['pages'] = $page->getPages();
        ob_start();
        if ($is_admin) {
        }
        $menu = new Menu();
        // chek if the id is available in the params 
        $menu_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_menu = $menu->getMenu($menu_id, DB_ASSOC);
        $data['current_menu'] = $current_menu;
        // echo   '<pre>';
        // print_r( $data['current_menu']);
        // exit;
        $menus = $menu->getMenusDropdown();
        $data['menus'] = $menus;
        \App\Helpers\Helpers::showMenuOptions($menus, $current_menu['menu_parent_id'], $current_menu['id']);
        $data['renderedMenuOptions'] = ob_get_clean();
        $this->prepare_menus($data);
        $this->render("edit-menu", $data);
    }
    public function viewMenu()
    {
        $data = [];
        $this->saveMenu();
        $user = new User();
        $page = new Page();
        $loginUser = $user->getUser();
        $is_admin = $user->is_admin();
        $data['is_admin'] = $is_admin;
        $data['logged_user'] = $loginUser;
        $data['pages'] = $page->getPages();
        ob_start();
        if ($is_admin) {
        }
        $menu = new Menu();
        // chek if the id is available in the params 
        $menu_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_menu = $menu->getMenu($menu_id, DB_ASSOC);
        $data['current_menu'] = $current_menu;
        $menus = $menu->getMenus();
        $data['menus'] = $menus;
        \App\Helpers\Helpers::showMenuOptions($menus, $current_menu['menu_parent_id'], $current_menu['id']);
        $data['renderedMenuOptions'] = ob_get_clean();
        $this->prepare_menus($data);
        $this->render("view-menu", $data);
    }
    private function saveMenu()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save-menu'])) {
                if (@htmlentities($_POST['is_redirect_popup']) == 'on') {
                    $is_redirect_popup = 1;
                } else {
                    $is_redirect_popup = 0;
                }
                $menu_id = isset($_POST['id']) ? $_POST['id'] : 0;
                if (isset($_FILES['attachment']) && $_FILES['attachment']['name'] != "") {
                    //pdf upload function
                    $file = rand(1000, 100000) . "-" . $_FILES['attachment']['name'];
                    $file_loc = $_FILES['attachment']['tmp_name'];
                    $file_size = $_FILES['attachment']['size'];
                    $file_type = $_FILES['attachment']['type'];
                    $folder = './uploads/';
                    $new_size = $file_size / 1024;
                    /* make file name in lower case */
                    $new_file_name = strtolower($file);
                    /* make file name in lower case */
                    $final_file = str_replace(' ', '-', $new_file_name);
                    if (move_uploaded_file($file_loc, $folder . $final_file)) { // echo "File is valid, and was successfully uploaded.\n";
                    } else {
                        echo "File size greater than 300kb!\n\n";
                    }
                    //pdf upload function
                } else {
                    $final_file = "";
                }
                $menu_type = $this->validateAndSanitizeAdmin($_POST['menu_type']);
                // echo $menu_type;
                if ($menu_type == 1) {
                    $page = new Page();
                    $menu_page_id_value = $this->validateAndSanitizeAdmin($_POST['menu_page_id']);
                    $menu_page_id = (int) $menu_page_id_value;
                    $data['pages'] = $page->pageDetails($menu_page_id);
                    // print_r($data['pages']);
                    $page_title = $data['pages']['title'];
                    $page_title_remove_whitespace = str_replace(' ', '', $page_title);
                    $page_title_lowercase = strtolower($page_title_remove_whitespace);
                    $menu_link = $page_title_lowercase;
                    $menu_name = $this->validateAndSanitizeAdmin($_POST['menu_name']);
                } else if ($menu_type == 2) {
                    $menu_link = $this->validateAndSanitizeAdmin($_POST['menu_link']);
                    $menu_name = $this->validateAndSanitizeAdmin($_POST['menu_name']);
                } else if ($menu_type == 3) {
                    $menu_link = "";
                    $menu_name = $this->validateAndSanitizeAdmin($_POST['menu_name']);
                } else {
                    $menu_name = $this->validateAndSanitizeAdmin($_POST['menu_name']) . '&nbsp;<i class="fa fa-angle-down"></i>';
                    $menu_link = $this->validateAndSanitizeAdmin($_POST['menu_link']);
                }
                $menu = new \App\Models\Menu();
                $lastinsertedid = $menu->lastInsertedID();
                if ($final_file == '') {
                    $final_file = $this->validateAndSanitizeAdmin($_POST['pdflink']);
                }
                if ($menu_id == 0) {
                    $menu_order = $lastinsertedid->max + 1;
                    $menu_data = [
                        'menu_parent_id' => $this->validateAndSanitizeAdmin($_POST['menu_parent_id']),
                        'menu_name' => $menu_name,
                        'menu_link' => $menu_link,
                        'menu_type' => $this->validateAndSanitizeAdmin($_POST['menu_type']),
                        'menu_page_id' => (int) $this->validateAndSanitizeAdmin($_POST['menu_page_id']),
                        'menu_route' => $this->validateAndSanitizeAdmin($_POST['menu_route']),
                        'menu_order' => $menu_order,
                        'status' => 0,
                        'attachment' => $final_file,
                        'is_footer_menu' => Helpers::cleanData($_POST['is_footer_menu']),
                        'is_redirect_popup' => $is_redirect_popup,
                    ];
                } else {
                    $menu_data = [
                        'menu_parent_id' => Helpers::cleanData($_POST['menu_parent_id']),
                        'menu_name' => $menu_name,
                        'menu_link' => $menu_link,
                        'menu_type' => Helpers::cleanData($_POST['menu_type']),
                        'menu_page_id' => (int) Helpers::cleanData($_POST['menu_page_id']),
                        'menu_route' => Helpers::cleanData($_POST['menu_route']),
                        'status' => 0,
                        'attachment' => $final_file,
                        'is_footer_menu' => Helpers::cleanData($_POST['is_footer_menu']),
                        'is_redirect_popup' => $is_redirect_popup,
                    ];
                }
                if ($menu_id == 0) { // insert new menu 
                    if ($menu->addMenu($menu_data)) {
                        $message = "Menu Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding menu";
                        $message_type = "warning";
                    }
                } else { // update menu
                    if ($menu->updateMenu($menu_data, $menu_id)) {
                        $message = "Menu Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Menu";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listmenus&&status=0"));
            }
        }
    }
    public function listPages()
    {
        // check for add menu
        $user = new User();
        $loginUser = $user->getUser();
        $is_admin = $user->is_admin();
        $data['is_admin'] = $is_admin;
        if ($is_admin) {
        }
        $page = new Page();
        $pages = $page->getPages();
        $data['pages'] = $pages;
        $data['user_role_id'] = (int) $loginUser['roleid'];
        $data['logged_user'] = $loginUser;
        $this->prepare_menus($data);
        if (isset($_SESSION['notification'])) {
            $notification_data = $_SESSION['notification'];
            $data = array_merge($data, $notification_data);
            unset($_SESSION['notification']);
        }
        $this->render("dashboard", $data);
    }
    public function editPage()
    {
        $data = [];
        $this->savePage();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        //  ob_start();
        $page = new Page();
        // chek if the id is available in the params 
        $page_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_page = $page->getPage($page_id, DB_ASSOC);
        $data['current_page'] = $current_page;
        $pages = $page->getPages();
        $data['pages'] = $pages;
        $this->prepare_menus($data);
        $this->render("edit-page", $data);
    }
    private function savePage()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save-page'])) {
                $page_id = isset($_POST['page_id']) ? $_POST['page_id'] : 0;
                $page = new \App\Models\Page();
                $page_data = [
                    'page_content' => $this->validateAndSanitizeAdmin($_POST['page_content']),
                    'title' => $this->validateAndSanitizeAdmin($_POST['title']),
                    'status' => 0,
                ];
                if ($page_id == 0) {
                    // insert new menu 
                    if ($page->addPage($page_data)) {
                        $message = "Page Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Page";
                        $message_type = "warning";
                    }
                } else { // update menu
                    $page_data = [
                        'page_content' => Helpers::cleanData($_POST['page_content']),
                        'title' => Helpers::cleanData($_POST['title']),
                        'status' => 0,
                        'last_content' => Helpers::cleanData($_POST['page_content']),
                    ];
                    /* echo "<pre>";
                print_r($page_data);
                exit; */
                    if ($page->updatePage($page_data, $page_id)) {
                        $message = "Page Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Menu";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listpages&&status=0"));
            }
        }
    }
    public function deletePage()
    {
        $data = [];
        $message = $message_type = "";
        $page_id = $this->data['params'][0];
        $page = new Page();
        if ($page->deletePage($page_id)) {
            $message = "Page Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting page ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listpages&&status=0"));
    }
    /**
     * delete menu
     */
    public function deleteMenu()
    {
        $data = [];
        $message = $message_type = "";
        $menu_id = $this->data['params'][0];
        $menu = new \App\Models\Menu();
        if ($menu->deleteMenu($menu_id)) {
            $message = "Menu Deleted successfully";
            $message_type = "success";
        } else {
            if ($menu_id == 1) {
                $message = "You cannot delete Root Menu";
                $message_type = "danger";
            } else {
                $message = "Error deleting menu";
                $message_type = "warning";
            }
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listmenus"));
    }
    /**
     * logout admin
     */
    public function logout()
    {
        session_destroy();
        $this->route->redirect($this->route->get_app_url());
    }
    // List Exams start
    public function listExams()
    {
        // check for add menu
        $user = new User();
        $loginUser = $user->getUser();
        $is_admin = $user->is_admin();
        $data['is_admin'] = $is_admin;
        if ($is_admin) {
        }
        $exam = new Exam();
        $exams = $exam->getExams();
        // echo '<pre>';
        // print_r($exams);
        $data['exams'] = $exams;
        $data['user_role_id'] = (int) $loginUser['roleid'];
        $data['logged_user'] = $loginUser;
        $this->prepare_menus($data);
        if (isset($_SESSION['notification'])) {
            $notification_data = $_SESSION['notification'];
            $data = array_merge($data, $notification_data);
            unset($_SESSION['notification']);
        }
        $this->render("dashboard", $data);
    }
    public function editExam()
    {
        $data = [];
        $this->saveExam();
        $user = new User();
        $loginUser = $user->getUser();
        $is_admin = $user->is_admin();
        $data['is_admin'] = $is_admin;
        $data['logged_user'] = $loginUser;
        ob_start();
        if ($is_admin) {
        }
        $exam = new Exam();
        // chek if the id is available in the params 
        $exam_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_exam = $exam->getExam($exam_id, DB_ASSOC);
        $data['current_exam'] = $current_exam;
        $exams = $exam->getExams();
        $data['exams'] = $exams;
        $this->prepare_menus($data);
        $this->render("edit-exam", $data);
    }
    private function saveExam()
    {
        $message = $message_type = "";
        if (isset($_POST['save-exam'])) {
            $exam_id = isset($_POST['id']) ? $_POST['id'] : 0;
            $exam = new \App\Models\Exam();
            $exam_data = [
                'exam_name' => Helpers::cleanData($_POST['exam_name']),
                'exam_code' => Helpers::cleanData($_POST['exam_code']),
                'exam_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['exam_date']))),
                'exam_time' => Helpers::cleanData($_POST['exam_time'])
            ];
            if ($exam_id == 0) {
                // insert new menu 
                if ($exam->addExam($exam_data)) {
                    $message = "Exam  Added successfully";
                    $message_type = "success";
                } else {
                    $message = "Error adding Exam";
                    $message_type = "warning";
                }
            } else { // update menu
                if ($exam->updateExam($exam_data, $exam_id)) {
                    $message = "Exam Updated successfully";
                    $message_type = "success";
                } else {
                    $message = "Error updating Exam";
                    $message_type = "warning";
                }
            }
            $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
            $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listexams"));
        }
    }
    public function menusreorderlinks()
    {
        $user = new User();
        $loginUser = $user->getUser();
        $is_admin = $user->is_admin();
        $data['is_admin'] = $is_admin;
        if ($is_admin) {
            $exam = new Exam();
            $exams = $exam->getExams();
            $data['exams'] = $exams;
        }
        $data['user_role_id'] = (int) $loginUser['roleid'];
        $data['logged_user'] = $loginUser;
        $this->prepare_menus($data);
        if (isset($_SESSION['notification'])) {
            $notification_data = $_SESSION['notification'];
            $data = array_merge($data, $notification_data);
            unset($_SESSION['notification']);
        }
        $this->render("dashboard", $data);
    }
    public function ajaxresponsemenuorder()
    {
        if (isset($_POST["action"])) {
            if (Helpers::cleanData($_POST["action"]) == 'fetch_data') {
                $menu = new Menu();
                $ret = $menu->reorderMenus();
                $data = $ret;
                echo json_encode($data);
            }
            if ($_POST['action'] == 'update') {
                for ($count = 0; $count < count($_POST["page_id_array"]); $count++) {
                    $menu = new \App\Models\Menu();
                    $menu_data = [
                        'menu_order' => $count + 1
                    ];
                    if ($menu->updatereorderMenu($menu_data, Helpers::cleanData($_POST["page_id_array"][$count]))) {
                        $message = "Menu Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Menu";
                        $message_type = "warning";
                    }
                }
            }
        }
    }
    /****
     * 
     * Nomination Reorder
     * 
     */
    public function ajaxresponsenominationorder()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == 'fetch_data') {
                $nomination = new Category();
                $ret = $nomination->reorderNomination();
                $data = $ret;
                echo json_encode($data);
            }
            if (Helpers::cleanData($_POST['action']) == 'update') {
                for ($count = 0; $count < count($_POST["page_id_array"]); $count++) {
                    $nomination = new \App\Models\Category();
                    $nomination_data = [
                        'nomination_order' => $count + 1
                    ];
                    if ($nomination->updatereorderNomination($nomination_data, Helpers::cleanData($_POST["page_id_array"][$count]))) {
                        $message = "Menu Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Menu";
                        $message_type = "warning";
                    }
                }
            }
        }
    }
    /****
     * 
     * Selection Post Reorder
     * 
     */
    public function ajaxresponseselectionpostreorder()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == 'fetch_data') {
                $sp = new Category();
                $ret = $sp->reorderSelectionPost();
                $data = $ret;
                echo json_encode($data);
            }
            if ($_POST['action'] == 'update') {
                for ($count = 0; $count < count($_POST["page_id_array"]); $count++) {
                    $sp = new \App\Models\Category();
                    $sp_data = [
                        'selection_post_order' => $count + 1
                    ];
                    if ($sp->updatereorderSelectionPost($sp_data, Helpers::cleanData($_POST["page_id_array"][$count]))) {
                        $message = "Menu Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Menu";
                        $message_type = "warning";
                    }
                }
            }
        }
    }
    public function ajaxresponsesubmenuorder()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == 'fetch_data') {
                $menu = new Menu();
                $ret = $menu->reorderSubMenus();
                $data = $ret;
                echo json_encode($data);
            }
            if ($_POST['action'] == 'update') {
                for ($count = 0; $count < count($_POST["page_id_array"]); $count++) {
                    $menu = new \App\Models\Menu();
                    $menu_data = [
                        'menu_order' => $count + 1
                    ];
                    if ($menu->updatereorderSubMenu($menu_data, Helpers::cleanData($_POST["page_id_array"][$count]))) {
                        $message = "Menu Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Menu";
                        $message_type = "warning";
                    }
                }
            }
        }
    }
    /******
     * 
     * Submenu Reorder New
     * 
     * 
     */
    public function ajaxresponsesubmenuordernew()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == 'fetch_data') {
                $menu_id = Helpers::cleanData($_POST["menu_id"]);
                if ($menu_id != 0) {
                    $message = 'selected';
                } else {
                    $message = "";
                }
                $menu = new Menu();
                $ret = $menu->reorderSubMenusNew();
                //echo '<pre>';
                //print_r($ret);
                echo '<option value="">Select Menu </option>';
                foreach ($ret as $val) { ?>
                                        <option value="<?php echo $val->menu_parent_id; ?>" <?php if ($val->menu_parent_id == $menu_id) {
                                               echo $message;
                                           } ?>><?php echo $val->parent_name; ?></option>
                                    <?php }
            }
        }
    }
    public function ajaxresponsesubmenuordernewbyId()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == 'fetch_data') {
                $id = Helpers::cleanData($_POST["id"]);
                $menu = new Menu();
                $ret = $menu->reorderSubMenusNewById($id);
                $data = $ret;
                echo json_encode($data);
            }
            if ($_POST['action'] == 'update') {
                for ($count = 0; $count < count($_POST["page_id_array"]); $count++) {
                    $menu = new \App\Models\Menu();
                    $menu_data = [
                        'menu_order' => $count + 1
                    ];
                    if ($menu->updatereorderSubMenuNew($menu_data, Helpers::cleanData($_POST["page_id_array"][$count]))) {
                        $message = "Menu Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Menu";
                        $message_type = "warning";
                    }
                }
            }
        }
    }
    public function ajaxresponse()
    {
        $menuid = Helpers::cleanData($_POST['menuid']);
        $menu = new Menu();
        $menu_data = [
            'status' => true,
        ];
        if ($menu->updateState($menu_data, $menuid)) {
            $message = 1;
            $message_title = "Menu Published successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }

    public function ajaxresponsemenuunpublish()
    {
        $menuid = Helpers::cleanData($_POST['menuid']);
        $menu = new Menu();
        $menu_data = [
            'status' => 0,
        ];
        if ($menu->updateState($menu_data, $menuid)) {
            $message = 1;
            $message_title = "Menu UnPublished successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    //Nominations
    // List Exams start
    public function listNominations()
    {
        // check for add menu
        $user = new User();
        $loginUser = $user->getUser();
        $is_admin = $user->is_admin();
        $data['is_admin'] = $is_admin;
        if ($is_admin) {
        }
        $data['user_role_id'] = (int) $loginUser['roleid'];
        $data['logged_user'] = $loginUser;
        $this->prepare_menus($data);
        if (isset($_SESSION['notification'])) {
            $notification_data = $_SESSION['notification'];
            $data = array_merge($data, $notification_data);
            unset($_SESSION['notification']);
        }
        $this->render("dashboard", $data);
    }
    public function validateAndSanitizeAdmin($input)
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
    public function editNomination()
    {
        $data = [];
        $this->saveNomination();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        $nomination = new Nomination();
        // chek if the id is available in the params 
        $nomination_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_nomination = $nomination->getNomination($nomination_id, DB_ASSOC);
        $data['current_nomination'] = $current_nomination;
        $nominations = $nomination->getNominations();
        $data['nominations'] = $nominations;
        $category = new Category();
        $categories = $category->getCategoryNominations();
        $data['categories'] = $categories;
        $nominationchildclass = new Nominationchild();
        $nominationchildlist = $nominationchildclass->getNominationchild();
        $data['nominationchildlist'] = $nominationchildlist;
        $data['nomination_id'] = $nomination_id;
        $this->prepare_menus($data);
        $this->render("edit-nomination", $data);
    }
    private function saveNomination()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save-nomination'])) {
                $nomination_id = isset($_POST['id']) ? $_POST['id'] : 0;
                $nomination = new \App\Models\Nomination();
                $examname = str_replace("'", "''", Helpers::cleanData($_POST['exam_name']));
                $nomination_data = [
                    'exam_name' => $examname,
                    'category_id' => Helpers::cleanData($_POST['category_id']),
                    'effect_from_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date']))),
                    'effect_to_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date']))),
                    'creation_date' => date('Y-m-d H:i:s'),
                ];
                if ($nomination_id == 0) {
                    // insert new menu 
                    if ($nomination->addNomination($nomination_data)) {
                        $lastinsertsql = $nomination->lastInsertedId();
                        $lastinsertedid = $lastinsertsql['max'];
                        if (count($_FILES) > 0) { //uploaded File 
                            foreach ($_FILES['pdf_file']['name'] as $i => $name) {
                                $item_name = Helpers::cleanData($_POST['pdf_name'][$i]);
                                $tmp_name = $_FILES['pdf_file']['tmp_name'][$i];

                                $mimeType = mime_content_type($tmp_name);
                                if ($mimeType !== 'application/pdf') {
                                    $this->deleteNomination($lastinsertedid);
                                } 


                                $error = $_FILES['pdf_file']['error'][$i];
                                $size = $_FILES['pdf_file']['size'][$i];
                                $type = $_FILES['pdf_file']['type'][$i];
                                $folder = './nominations/';
                                $file = rand(1000, 100000) . "-" . $_FILES['pdf_file']['name'][$i];
                                $new_file_name = strtolower($file);
                                $final_file = str_replace(' ', '-', $new_file_name);
                                if (move_uploaded_file($tmp_name, $folder . $final_file)) { // echo "File is valid, and was successfully uploaded.\n";
                                } else {
                                    echo "File size greater than 300kb!\n\n";
                                }
                                $nominationchild = new \App\Models\Nominationchild();
                                $nomination_child_data = [
                                    'nomination_id' => $lastinsertedid,
                                    'pdf_name' => $item_name,
                                    'attachment' => $final_file,
                                    'status' => 1
                                ];
                                $nominationchild->addNominationchild($nomination_child_data);
                            }
                        } //uploaded File
                        $message = "Nomination Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Nomination";
                        $message_type = "warning";
                    }
                } else { // update menu
                    $nomination_data = [
                        'exam_name' => $examname,
                        'category_id' => Helpers::cleanData($_POST['category_id']),
                        'effect_from_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date']))),
                        'effect_to_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date']))),
                        'creation_date' => date('Y-m-d H:i:s'),
                        'p_status' => '0',
                    ];
                    if ($nomination->updateNomination($nomination_data, $nomination_id)) {


                        // echo '<pre>';
                        // print_r($_FILES);
                        // exit;











                        foreach ($_FILES['pdf_file']['name'] as $i => $name) {
                            if ($_FILES['pdf_file']['size'][$i] != 0 || $_POST['pdf_name'][$i] != '') {
                                $item_name = Helpers::cleanData($_POST['pdf_name'][$i]);
                                $old_item_name = Helpers::cleanData($_POST['old_pdf_files'][$i]);
                                $child_id = isset($_POST['nomination_child_id'][$i]) ? $_POST['nomination_child_id'][$i] : 0;
                                $tmp_name = $_FILES['pdf_file']['tmp_name'][$i];
                               // $tmp_name = $_FILES['pdf_file']['tmp_name'][$i];
                              //  $mimeType = mime_content_type($tmp_name);
                        
                                // if ($mimeType !== 'application/pdf') {
                                //     $message = "File is not a PDF";
                                //     $message_type = "warning";
                        
                                //     // Set the error message in the session or handle it appropriately
                                //     $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                        
                                //     // Redirect or take necessary actions
                                //     $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listnominations"));
                                // }
                                $error = $_FILES['pdf_file']['error'][$i];
                                $size = $_FILES['pdf_file']['size'][$i];
                                $type = $_FILES['pdf_file']['type'][$i];
                                $folder = './nominations/';
                                if ($_FILES['pdf_file']['name'][$i] == '') {
                                    $file = $old_item_name;
                                } else {
                                    $file = rand(1000, 100000) . "-" . $_FILES['pdf_file']['name'][$i];
                                }
                                $new_file_name = strtolower($file);
                                $final_file = str_replace(' ', '-', $new_file_name);
                                move_uploaded_file($tmp_name, $folder . $final_file);
                                $nominationchild = new \App\Models\Nominationchild();
                                $nomination_child_data = [
                                    'nomination_id' => $nomination_id,
                                    'pdf_name' => $item_name,
                                    'attachment' => $final_file,
                                    'status' => 1
                                ];
                                if ($child_id == 0) {
                                    $nominationchild->addNominationchild($nomination_child_data);
                                } else {
                                    $nominationchild->updateNominationChild($nomination_child_data, $child_id);
                                }
                            } //Validation
                        }
                        $message = "Nomination Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Nomination";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listnominations"));
            }
        }
    }
    public function deleteNomination($page_id)
    {
        $data = [];
        $message = $message_type = "";
       // $page_id = $this->data['params'][0];
        $nomination = new Nomination();
        if ($nomination->deleteNomination($page_id)) {
            $message = "File is not PDF";
            $message_type = "warning";
        } else {
            $message = "Error deleting Nomination ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listnominations"));
    }
    ######### Author:Stalin ####
    ######### Date : 13 july-2021 ###
    ######## Selection Posts #######
    public function editselectionpost()
    {
        $data = [];
        $this->saveSelectionpost();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        ob_start();
        if ($is_admin) {
        }
        $selectionpost = new Selectionpost();
        // chek if the id is available in the params 
        $selectionpost_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_selectionpost = $selectionpost->getselectionpost($selectionpost_id, DB_ASSOC);
        $data['current_selectionpost'] = $current_selectionpost;
        $selectionposts = $selectionpost->getSelectionpost();
        $data['selectionposts'] = $selectionposts;
        $category = new Category();
        $categories = $category->getCategorySelectionPosts();
        $data['categories'] = $categories;
        $phase = new PhaseMaster();
        $phases = $phase->getPhaseMasterListDropdown();
        $data['phases'] = $phases;
        $selectionpostchildclass = new Selectionpostschild();
        $selectionpostchildlist = $selectionpostchildclass->getSelectionpostschild();
        $data['selectionpostchildlist'] = $selectionpostchildlist;
        $data['selectionpost_id'] = $selectionpost_id;
        $this->prepare_menus($data);
        $this->render("edit-selectionpost", $data);
    }
    private function saveSelectionpost()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['selectionpost'])) {
                // echo "<pre>";
                // print_r($_POST);
                // exit;
                $selectionpost_id = isset($_POST['id']) ? $_POST['id'] : 0;
                // echo  $selectionpost_id;
                // exit;
                $selectionpost = new \App\Models\Selectionpost();
                $examname = str_replace("'", "''", Helpers::cleanData($_POST['exam_name']));
                $selectionpost_data = [
                    'exam_name' => $examname,
                    'category_id' => Helpers::cleanData($_POST['category_id']),
                    'phase_id' => Helpers::cleanData($_POST['phase_id']),
                    'effect_from_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date']))),
                    'effect_to_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date']))),
                    'creation_date' => date('Y-m-d H:i:s'),
                ];
                if ($selectionpost_id == 0) {
                    // insert new menu 
                    if ($selectionpost->addselectionpost($selectionpost_data)) {
                        $lastinsertsql = $selectionpost->lastInsertedId();
                        $lastinsertedid = $lastinsertsql['max'];
                        foreach ($_FILES['pdf_file']['name'] as $i => $name) {
                            $item_name = Helpers::cleanData($_POST['pdf_name'][$i]);
                            $tmp_name = $_FILES['pdf_file']['tmp_name'][$i];
                            $error = $_FILES['pdf_file']['error'][$i];
                            $size = $_FILES['pdf_file']['size'][$i];
                            $type = $_FILES['pdf_file']['type'][$i];
                            $folder = './selectionposts/';
                            $file = rand(1000, 100000) . "-" . $_FILES['pdf_file']['name'][$i];
                            $new_file_name = strtolower($file);
                            $final_file = str_replace(' ', '-', $new_file_name);
                            if (move_uploaded_file($tmp_name, $folder . $final_file)) { // echo "File is valid, and was successfully uploaded.\n";
                            } else {
                                echo "File size greater than 300kb!\n\n";
                            }
                            $selectionpostchild = new \App\Models\Selectionpostschild();
                            $selectionpost_child_data = [
                                'selection_post_id' => $lastinsertedid,
                                'pdf_name' => $item_name,
                                'attachment' => $final_file,
                                'status' => 1
                            ];
                            $selectionpostchild->addSelectionpostchild($selectionpost_child_data);
                        }
                        $message = "Selectionpost Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding selectionpost";
                        $message_type = "warning";
                    }
                } else { // update menu   //Update by stalin    
                    $selectionpost = new \App\Models\Selectionpost();

                    // Update Selectionpost details
                    $selectionpost_data = [
                        'exam_name' => $examname,
                        'category_id' => Helpers::cleanData($_POST['category_id']),
                        'phase_id' => Helpers::cleanData($_POST['phase_id']),
                        'effect_from_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date']))),
                        'effect_to_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date']))),
                        'creation_date' => date('Y-m-d H:i:s'),
                        'p_status' => '0',
                    ];
                    
                    if ($selectionpost->updateSelectionpost($selectionpost_data, $selectionpost_id)) {
                        // Loop through each row
                        foreach ($_POST['pdf_name'] as $i => $pdf_name) {
                            $child_id = isset($_POST['selectionpost_child_id'][$i]) ? $_POST['selectionpost_child_id'][$i] : 0;
                            
                            // Check if PDF file needs to be updated
                            $update_file = isset($_FILES['pdf_file']['size'][$i]) && $_FILES['pdf_file']['size'][$i] != 0;
                    
                            if ($update_file) {
                                // File upload logic
                                $tmp_name = $_FILES['pdf_file']['tmp_name'][$i];
                                $error = $_FILES['pdf_file']['error'][$i];
                                $size = $_FILES['pdf_file']['size'][$i];
                                $type = $_FILES['pdf_file']['type'][$i];
                                $folder = './selectionposts/';
                                $file = rand(1000, 100000) . "-" . $_FILES['pdf_file']['name'][$i];
                                $new_file_name = strtolower($file);
                                $final_file = str_replace(' ', '-', $new_file_name);
                                
                                if (move_uploaded_file($tmp_name, $folder . $final_file)) {
                                    // File was uploaded successfully
                                } else {
                                    echo "File size greater than 300kb!\n\n";
                                }
                            }
                    
                            // Update PDF name
                            $selectionpostchild = new \App\Models\Selectionpostschild();
                            $selectionpost_child_data = [
                                'selection_post_id' => $selectionpost_id,
                                'pdf_name' => Helpers::cleanData($pdf_name),
                                'status' => 1
                            ];
                    
                            if ($update_file) {
                                // Update attachment only if the file was updated
                                $selectionpost_child_data['attachment'] = $final_file;
                            }
                    
                            if ($child_id == 0) {
                                $selectionpostchild->addSelectionpostchild($selectionpost_child_data);
                            } else {
                                $selectionpostchild->updateSelectionpostchild($selectionpost_child_data, $child_id);
                            }
                        }
                    
                        $message = "Selectionpost Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating selectionpost";
                        $message_type = "warning";
                    }
                    //Update by stalin
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listselectionposts"));
            }
        }
    }
    public function deleteSelectionpost()
    {
        $data = [];
        $message = $message_type = "";
        $sp_id = $this->data['params'][0];
        $sp = new Selectionpost();
        if ($sp->deleteSelectionPost($sp_id)) {
            $message = "Selection Post Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Selection Post ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listselectionposts"));
    }
    public function ajaxresponseforselectionpostsforremovingfileupload()
    {
        $pdf_id = Helpers::cleanData($_POST['pdf_id']);
        $sp_id = Helpers::cleanData($_POST['sp_id']);
        // echo $cid;
        $spchild = new \App\Models\Selectionpostschild();
        $menu_data = [
            'status' => 0,
        ];
        if ($spchild->updateState($menu_data, $pdf_id)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
        //$this->route->redirect($this->route->site_url("admin/dashboard"));
    }

    public function ajaxresponsefornoticeforremovingfileupload()
    {
        $pdf_id = Helpers::cleanData($_POST['pdf_id']);
        $notice_id = Helpers::cleanData($_POST['notice_id']);
        // echo $cid;
        $noticechild = new \App\Models\MstNoticeChild();
        $menu_data = [
            'status' => 0,
        ];
        if ($noticechild->updateState($menu_data, $pdf_id)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
        //$this->route->redirect($this->route->site_url("admin/dashboard"));
    }

    public function ajaxresponseforgalleryforremovingfileupload()
    {
        $gallery_id = Helpers::cleanData($_POST['gallery_id']);
        $image_id = Helpers::cleanData($_POST['image_id']);
        // echo $cid;
        $gallerychild = new \App\Models\GalleryChild();
       
        $menu_data = [
            'status' => 0,
        ];
        if ($gallerychild->updateState($menu_data, $image_id)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
        //$this->route->redirect($this->route->site_url("admin/dashboard"));
    }
    ######### Author:Stalin ####
    ######### Date : 13 july-2021 ###
    ######## Selection Posts #######
    public function ajaxresponseforfileupload()
    {
        $pdf_id = Helpers::cleanData($_POST['pdf_id']);
        $nomination_id = Helpers::cleanData($_POST['nomination_id']);
        // echo $cid;
        $nominationchild = new \App\Models\Nominationchild();
     
        $menu_data = [
            'status' => 0,
        ];
        if ($nominationchild->updateState($menu_data, $pdf_id)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
        //$this->route->redirect($this->route->site_url("admin/dashboard"));
    }
    public function printr($data = array())
    {
        echo '<pre>';
        print_r($data);
        exit;
    }
    //Debarredlists Starts
    public function editdebarredlists()
    {
        $data = [];
        $this->saveDlist();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        $dlist = new Debarredlists();
        // chek if the id is available in the params 
        $dlist_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_dlist = $dlist->getDlist($dlist_id, DB_ASSOC);
        $data['current_dlist'] = $current_dlist;
        $dlists = $dlist->getDlists();
        $data['dlists'] = $dlists;
        $this->prepare_menus($data);
        $this->render("edit-debarredlist", $data);
    }
    private function saveDlist()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_dlist'])) {
                $dlist_id = isset($_POST['id']) ? $_POST['id'] : 0;
                if (isset($_FILES['attachment']) && $_FILES['attachment']['name'] != "") {
                    //pdf upload function
                    $file = rand(1000, 100000) . "-" . $_FILES['attachment']['name'];
                    $file_loc = $_FILES['attachment']['tmp_name'];
                    $file_size = $_FILES['attachment']['size'];
                    $file_type = $_FILES['attachment']['type'];
                    $folder = './debarredlists/';
                    $new_size = $file_size / 1024;
                    /* make file name in lower case */
                    $new_file_name = strtolower($file);
                    /* make file name in lower case */
                    $final_file = str_replace(' ', '-', $new_file_name);
                    if (move_uploaded_file($file_loc, $folder . $final_file)) { // echo "File is valid, and was successfully uploaded.\n";
                    } else {
                        echo "File size greater than 300kb!\n\n";
                    }
                    //pdf upload function
                } else {
                    $final_file = "";
                }
                if ($final_file == '') {
                    $final_file = Helpers::cleanData($_POST['pdflink']);
                }
                $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
                $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
                $dlist_data = [
                    'pdf_name' => Helpers::cleanData($_POST['pdf_name']),
                    'attachment' => $final_file,
                    'effect_from_date' => $effect_from_date,
                    'effect_to_date' => $effect_to_date,
                    'p_status' => '0'
                ];
                /* echo "<pre>";
            print_r($menu_data);
            exit; */
                $dlist = new \App\Models\Debarredlists();
                if ($dlist_id == 0) { // insert new menu 
                    if ($dlist->addDlist($dlist_data)) {
                        $message = "Debarred List  Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Debarred List";
                        $message_type = "warning";
                    }
                } else { // update menu
                    if ($dlist->updateDlist($dlist_data, $dlist_id)) {
                        $message = "Debarred List Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Debarred List";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listdebarredlists"));
            }
        }
    }
    public function deletedebarredlists()
    {
        $data = [];
        $message = $message_type = "";
        $dl_id = $this->data['params'][0];
        $dl = new Debarredlists();
        if ($dl->deleteDebarredList($dl_id)) {
            $message = "Debarred List Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Debarred List ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listdebarredlists"));
    }
    //Debarredlists End
    //Tenderlists Starts
    public function edittender()
    {
        $data = [];
        $this->saveTender();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        $tenderlists = new Tender();
        // chek if the id is available in the params 
        $tenderid = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_tender = $tenderlists->getTenderby($tenderid, DB_ASSOC);
        $data['current_tender'] = $current_tender;
        /* 	
        $tlists = $tlist->getDlists();
        $data['dlists'] = $dlists; */
        $this->prepare_menus($data);
        $this->render("edit-tender", $data);
    }
    private function saveTender()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_tender'])) {
                $tenderid = isset($_POST['id']) ? $_POST['id'] : 0;
                if (isset($_FILES['attachment']) && $_FILES['attachment']['name'] != "") {
                    //pdf upload function
                    $file = rand(1000, 100000) . "-" . $_FILES['attachment']['name'];
                    $file_loc = $_FILES['attachment']['tmp_name'];
                    $file_size = $_FILES['attachment']['size'];
                    $file_type = $_FILES['attachment']['type'];
                    $folder = './tender/';
                    $new_size = $file_size / 1024;
                    /* make file name in lower case */
                    $new_file_name = strtolower($file);
                    /* make file name in lower case */
                    $final_file = str_replace(' ', '-', $new_file_name);
                    if (move_uploaded_file($file_loc, $folder . $final_file)) { // echo "File is valid, and was successfully uploaded.\n";
                    } else {
                        echo "File size greater than 300kb!\n\n";
                    }
                    //pdf upload function
                } else {
                    $final_file = "";
                }
                if ($final_file == '') {
                    $final_file = Helpers::cleanData($_POST['pdflink']);
                }
                $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
                $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
                $tenderlist_data = [
                    'pdf_name' => Helpers::cleanData($_POST['pdf_name']),
                    'attachment' => $final_file,
                    'effect_from_date' => $effect_from_date,
                    'effect_to_date' => $effect_to_date,
                    'p_status' => '0',
                    'creation_date' => date('Y-m-d H:i:s')
                ];
                /* echo "<pre>";
            print_r($menu_data);
            exit; */
                $tender = new \App\Models\Tender();
                if ($tenderid == 0) { // insert new menu 
                    if ($tender->addTender($tenderlist_data)) {
                        $message = "Tender  Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Tender";
                        $message_type = "warning";
                    }
                } else { // update menu
                    if ($tender->updateTender($tenderlist_data, $tenderid)) {
                        $message = "Tender Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Tender";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listoftenders"));
            }
        }
    }
    public function deleteTender()
    {
        $data = [];
        $message = $message_type = "";
        $tender_id = $this->data['params'][0];
        $tender = new Tender();
        if ($tender->deleteTenderStatus($tender_id)) {
            $message = "Tender   Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Tender ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=tender_archieves_by_month"));
    }
    public function copyTender()
    {
        $data = [];
        $message = $message_type = "";
        $tender_id = $this->data['params'][0];
        $tender = new Tender();
        if ($tender->copyTender($tender_id)) {
            $message = "Tender   copied successfully";
            $message_type = "success";
        } else {
            $message = "Error copying Tender ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listoftenders"));
    }
    public function archiveTender()
    {
        $data = [];
        $message = $message_type = "";
        $tender_id = $this->data['params'][0];
        $tender = new Tender();
        if ($tender->archiveTenderStatus($tender_id)) {
            $message = "Tender   Archived successfully";
            $message_type = "success";
        } else {
            $message = "Error Archiving Tender ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=tender_archieves_by_month"));
    }
    public function deleteimportantlink()
    {
        $data = [];
        $message = $message_type = "";
        $il_id = $this->data['params'][0];
        $il = new ImportantLinks();
        if ($il->deleteImportantLinksStatus($il_id)) {
            $message = "Important Links Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Important Links ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofimportantlinks&&status=0"));
    }
    //Tenderlists End
    #######################   Important Links Start #####################
    public function editimportantlink()
    {
        $data = [];
        $this->saveImportantLink();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        $importantlinks = new ImportantLinks();
        // chek if the id is available in the params 
        $importantlinkid = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_importantlink = $importantlinks->getImportantLinksby($importantlinkid, DB_ASSOC);
        $data['current_importantlink'] = $current_importantlink;
        /* 	
        $tlists = $tlist->getDlists();
        $data['dlists'] = $dlists; */
        $this->prepare_menus($data);
        $this->render("edit-importantlinks", $data);
    }
    private function saveImportantLink()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_important_link'])) {
                $ilid = isset($_POST['id']) ? $_POST['id'] : 0;
                $creation_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['creation_date'])));
                $illist_data = [
                    'link_name' => Helpers::cleanData($_POST['link_name']),
                    'menu_link' => Helpers::cleanData($_POST['menu_link']),
                    'creation_date' => $creation_date,
                    'status' => '0'
                ];
                /* echo "<pre>";
            print_r($illist_data);
            exit; */
                $il = new \App\Models\ImportantLinks();
                if ($ilid == 0) { // insert new menu 
                    if ($il->addImportantLinks($illist_data)) {
                        $message = "Important Link Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Important Link";
                        $message_type = "warning";
                    }
                } else { // update menu
                    if ($il->updateImportantLinks($illist_data, $ilid)) {
                        $message = "Important Link Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Important Link";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofimportantlinks"));
            }
        }
    }
    #################   Important Links  End    ###################
    ####### Login Users Edit Form#########
    public function editloginuser()
    {
        $data = [];
        $this->saveLoginuser();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        ob_start();
        if ($is_admin) {
        }
        $userlist = new Loginusers();
        // chek if the id is available in the params 
        $user_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_userlist = $userlist->getUserlist($user_id, DB_ASSOC);
        $data['current_userlist'] = $current_userlist;
        #####  Get Roles  ########
        $role = new User();
        $roles = $role->getRolesList();
        $data['roles'] = $roles;
        #####  Get Roles  ########
        $this->prepare_menus($data);
        $this->render("edit-user-creation", $data);
    }
    private function saveLoginuser()
    {
        $message = $message_type = "";
        if (isset($_POST['save_user'])) {
            $user_id = isset($_POST['id']) ? $_POST['id'] : 0;
            $userlist = new \App\Models\Loginusers();
            if ($user_id == 0) { //insert
                $userlist_data = [
                    'username' => Helpers::cleanData($_POST['username']),
                    'email' => Helpers::cleanData($_POST['email']),
                    'phone_number' => Helpers::cleanData($_POST['phone_number']),
                    'password' => md5(Helpers::cleanData($_POST['password'])),
                    'user_role_id' => Helpers::cleanData($_POST['user_role_id']),
                    'created_on' => date('Y-m-d H:i:s'),
                    'last_login' => date('Y-m-d H:i:s'),
                    'status' => "false"
                ];
                /* echo '<pre>';
                        print_r($userlist_data);
                        exit; */
                // insert new menu 
                if ($userlist->addUserlist($userlist_data)) {
                    $message = "User Added successfully";
                    $message_type = "success";
                } else {
                    $message = "Error adding User";
                    $message_type = "warning";
                }
            } else { // update menu
                $userlist = new \App\Models\Loginusers();
                $userlist_data = [
                    'username' => Helpers::cleanData($_POST['username']),
                    'email' => Helpers::cleanData($_POST['email']),
                    'phone_number' => Helpers::cleanData($_POST['phone_number']),
                    'user_role_id' => Helpers::cleanData($_POST['user_role_id']),
                    'created_on' => date('Y-m-d H:i:s'),
                    'last_login' => date('Y-m-d H:i:s'),
                    'status' => "false"
                ];
                if ($userlist->updateUserlist($userlist_data, $user_id)) {
                    $message = "User Updated successfully";
                    $message_type = "success";
                } else {
                    $message = "Error updating User";
                    $message_type = "warning";
                }
            }
            $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
            $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofloginusers"));
        }
    }
    ####### Login Users Edit Form#########
    ######   Category   #################
    public function editcategory()
    {
        $data = [];
        $this->saveCategory();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        ob_start();
        if ($is_admin) {
        }
        $categorylist = new Category();
        // chek if the id is available in the params 
        $category_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_category_details = $categorylist->getCategoryby($category_id, DB_ASSOC);
        $data['current_category_details'] = $current_category_details;
        #####  Get Roles  ########
        $role = new User();
        $roles = $role->getRolesList();
        $data['roles'] = $roles;
        #####  Get Roles  ########
        $this->prepare_menus($data);
        $this->render("edit-category", $data);
    }
    private function saveCategory()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_category'])) {
                if (isset($_POST['id']) && !empty($_POST['id'])) {
                    $category_id = $_POST['id'];
                } else {
                    $category_id = 0;
                }
                $categorylist = new \App\Models\Category();
                if ($_POST['categoryforwhat'] == 'selection_post') {
                    $sp = 1;
                    $nm = 0;
                } else {
                    $sp = 0;
                    $nm = 1;
                }
                if ($category_id == 0) { //insert
                    $string = htmlspecialchars(strip_tags($_POST['category_name']));
                    $categorylist_data = [
                        'category_name' => Helpers::cleanData($string),
                        'show_in_selection_post' => $sp,
                        'show_in_nomination' => $nm,
                        'creation_date' => date('Y-m-d H:i:s'),
                        'status' => 0
                    ];
                    // insert new menu 
                    if ($categorylist->addCategory($categorylist_data)) {
                        $message = "Category Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Category";
                        $message_type = "warning";
                    }
                } else { // update menu
                    $categorylist = new \App\Models\Category();
                    $categorylist_data = [
                        'category_name' => Helpers::cleanData($_POST['category_name']),
                        'show_in_selection_post' => $sp,
                        'show_in_nomination' => $nm,
                        'creation_date' => date('Y-m-d H:i:s'),
                        //'status' =>$status
                    ];
                    if ($categorylist->updateCategory($categorylist_data, $category_id)) {
                        $message = "Category Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Category";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofcategory"));
            }
        }
    }
    public function deleteCategory()
    {
        $data = [];
        $message = $message_type = "";
        $category_id = $this->data['params'][0];
        $category = new Category();
        if ($category->deleteCategory($category_id)) {
            $message = "Category Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Category ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofcategory"));
    }
    public function deleteGallery()
    {
        $data = [];
        $message = $message_type = "";
        $gallery_id = $this->data['params'][0];
        $gallery = new Gallery();
        if ($gallery->deleteGallery($gallery_id)) {
            $message = "Gallery Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Gallery ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofphotogallery"));
    }
    ###### Category #####################
    #############################  Notices  start  ############################
    public function editnotice()
    {
        $data = [];
        $this->saveNotice();
        $user = new User();
        $loginUser = $user->getUser();
        $is_admin = $user->is_admin();
        $data['is_admin'] = $is_admin;
        $data['logged_user'] = $loginUser;
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        ob_start();
        if ($is_admin) {
        }
        /**
         * Mst Notice
         * 
         */
        $notice = new MstNotice();
        // chek if the id is available in the params 
        $notice_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_notice = $notice->getMstNotice($notice_id, DB_ASSOC);
        $data['current_notice'] = $current_notice;
        $notices = $notice->getMstNotices();
        $data['notices'] = $notices;
        $category = new Category();
        $categories = $category->getCategoryNominations();
        $data['categories'] = $categories;
        $noticechildclass = new MstNoticeChild();
        $noticechildlist = $noticechildclass->getMstNoticeChild();
        $data['noticechildlist'] = $noticechildlist;
        $data['notice_id'] = $notice_id;
        /**
         * Mst Notice
         * 
         */
        $this->prepare_menus($data);
        $this->render("edit-notice", $data);
    }
    private function saveNotice()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_notice'])) {
                $notice_id = isset($_POST['id']) ? $_POST['id'] : 0;
                $notice = new \App\Models\MstNotice();
                $notice_name = trim(htmlspecialchars($_POST['notice_name']));
                $notice_data = [
                    'notice_name' => $notice_name,
                    'category_id' => trim(htmlspecialchars($_POST['category_id'])),
                    'effect_from_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date']))),
                    'effect_to_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date']))),
                    'creation_date' => date('Y-m-d H:i:s'),
                ];
                if ($notice_id == 0) {
                    // insert new menu 
                    if ($notice->addMstNotice($notice_data)) {
                        $lastinsertsql = $notice->lastInsertedId();
                        $lastinsertedid = $lastinsertsql['max'];
                        if (count($_FILES) > 0) { //uploaded File 
                            foreach ($_FILES['pdf_file']['name'] as $i => $name) {
                                $item_name = Helpers::cleanData($_POST['pdf_name'][$i]);
                                $item_name = htmlspecialchars($item_name);
                                $tmp_name = $_FILES['pdf_file']['tmp_name'][$i];
                                $error = $_FILES['pdf_file']['error'][$i];
                                $size = $_FILES['pdf_file']['size'][$i];
                                $type = $_FILES['pdf_file']['type'][$i];
                                $folder = './notices/';
                                $file = rand(1000, 100000) . "-" . $_FILES['pdf_file']['name'][$i];
                                $new_file_name = strtolower($file);
                                $final_file = str_replace(' ', '-', $new_file_name);
                                if (move_uploaded_file($tmp_name, $folder . $final_file)) { // echo "File is valid, and was successfully uploaded.\n";
                                } else {
                                    echo "File size greater than 300kb!\n\n";
                                }
                                $noticechild = new \App\Models\MstNoticeChild();
                                $notice_child_data = [
                                    'notice_id' => $lastinsertedid,
                                    'pdf_name' => $item_name,
                                    'attachment' => $final_file,
                                    'status' => 0
                                ];
                                $noticechild->addMstNoticeChild($notice_child_data);
                            }
                        } //uploaded File
                        $message = "Notice Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Notice";
                        $message_type = "warning";
                    }
                } else { // update menu
                    $notice_data = [
                        'notice_name' => $notice_name,
                        'category_id' => trim(htmlspecialchars($_POST['category_id'])),
                        'effect_from_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date']))),
                        'effect_to_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date']))),
                        'creation_date' => date('Y-m-d H:i:s'),
                        'p_status' => '0',
                    ];
                    // echo '<pre>';
                    // print_r($_POST);
                    // exit;
                    if ($notice->updateMstNotice($notice_data, $notice_id)) {
                        foreach ($_FILES['pdf_file']['name'] as $i => $name) {
                            if ($_FILES['pdf_file']['size'][$i] != 0 || $_POST['pdf_name'][$i] != '') {
                                $item_name = Helpers::cleanData($_POST['pdf_name'][$i]);
                                $old_item_name = Helpers::cleanData($_POST['old_pdf_files'][$i]);
                                $item_name = htmlspecialchars($item_name);
                                $child_id = isset($_POST['notice_child_id'][$i]) ? $_POST['notice_child_id'][$i] : 0;
                                $tmp_name = $_FILES['pdf_file']['tmp_name'][$i];
                                $error = $_FILES['pdf_file']['error'][$i];
                                $size = $_FILES['pdf_file']['size'][$i];
                                $type = $_FILES['pdf_file']['type'][$i];
                                $folder = './notices/';
                                if ($_FILES['pdf_file']['name'][$i] == '') {
                                    $file = $old_item_name;
                                } else {
                                    $file = rand(1000, 100000) . "-" . $_FILES['pdf_file']['name'][$i];
                                }
                                $new_file_name = strtolower($file);
                                $final_file = str_replace(' ', '-', $new_file_name);
                                if (move_uploaded_file($tmp_name, $folder . $final_file)) { // echo "File is valid, and was successfully uploaded.\n";
                                } else {
                                    echo "File size greater than 300kb!\n\n";
                                }
                                $noticechild = new \App\Models\MstNoticeChild();
                                $notice_child_data = [
                                    'notice_id' => $notice_id,
                                    'pdf_name' => $item_name,
                                    'attachment' => $final_file,
                                    'status' => 1
                                ];
                                if ($child_id == 0) {
                                    $noticechild->addMstNoticeChild($notice_child_data);
                                } else {
                                    $noticechild->updateMstNoticeChild($notice_child_data, $child_id);
                                }
                            } //Validation
                        }
                        $message = "Notice Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Notice";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofnotices"));
            }
        }
    }
    public function deleteNotice()
    {
        $data = [];
        $message = $message_type = "";
        $notice_id = $this->data['params'][0];
        $notice = new Notice();
        if ($notice->deleteNoticeStatus($notice_id)) {
            $message = "Notice  Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Notice ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofnotices"));
    }
    ###################### Notices End #################################
    public function ajaxresponseforpage()
    {
        $pageid = Helpers::cleanData($_POST['pageid']);
        // echo $cid;
        $page = new Page();
        $page_data = [
            'status' => true,
        ];
        if ($page->updatePageState($page_data, $pageid)) {
            $message = 1;
            $message_title = "Page Published successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforpageunpublish()
    {
        $pageid = Helpers::cleanData($_POST['pageid']);
        // echo $cid;
        $page = new Page();
        $page_data = [
            'status' => 0,
        ];
        if ($page->updatePageState($page_data, $pageid)) {
            $message = 1;
            $message_title = "Page UnPublished successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforNomination()
    {
        $nomination_id = Helpers::cleanData($_POST['nomination_id']);
        // echo $nomination_id;
        $nomination = new Nomination();
        $nomination_data = [
            'p_status' => '1',
        ];
        if ($nomination->updateNominationState($nomination_data, $nomination_id)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
    }
    /*****
     * 
     * Nomination Archives Publish Button
     */
    public function ajaxresponseforNominationArchives()
    {
        $nomination_id = Helpers::cleanData($_POST['nomination_id']);
        // echo $nomination_id;
        $nomination = new NominationArchieves();
        $nomination_data = [
            'p_status' => '1',
        ];
        if ($nomination->updateNominationArchivesState($nomination_data, $nomination_id)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforSelectionPost()
    {
        $selection_post_id = Helpers::cleanData($_POST['selection_post_id']);
        // echo $cid;
        $selectionpost = new Selectionpost();
        $selection_post_data = [
            'p_status' => '1',
        ];
        if ($selectionpost->updateSelectionpostState($selection_post_data, $selection_post_id)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforDebarredList()
    {
        $debarred_lists_id = Helpers::cleanData($_POST['debarred_lists_id']);
        // echo $cid;
        $debarred_lists = new Debarredlists();
        $debarred_lists_data = [
            'p_status' => '1',
        ];
        if ($debarred_lists->updateDebarredlistState($debarred_lists_data, $debarred_lists_id)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
        //$this->route->redirect($this->route->site_url("Admin/dashboard"));
    }
    public function ajaxresponseforNotice()
    {
        $notice_id = Helpers::cleanData($_POST['notice_id']);
        // echo $cid;
        $notice_model = new Notice();
        $notice_data = [
            'p_status' => '1',
        ];
        if ($notice_model->updateNoticeState($notice_data, $notice_id)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
    }
    /***
     * Faq  Publish Button
     * 
     */
    public function ajaxresponseforFaq()
    {
        $faq_id = Helpers::cleanData($_POST['faq_id']);
        // echo $cid;
        $faq_model = new Faq();
        $faq_data = [
            'p_status' => '1',
        ];
        if ($faq_model->updateFaqState($faq_data, $faq_id)) {
            $message = 1;
            $message_title = "FAQ Published successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforFaqunpublish()
    {
        $faq_id = Helpers::cleanData($_POST['faq_id']);
        // echo $cid;
        $faq_model = new Faq();
        $faq_data = [
            'p_status' => '0',
        ];
        if ($faq_model->updateFaqState($faq_data, $faq_id)) {
            $message = 1;
            $message_title = "FAQ UnPublished successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforTender()
    {
        $tender_id = Helpers::cleanData($_POST['tender_id']);
        // echo $cid;
        $tender_model = new Tender();
        $tender_data = [
            'p_status' => '1',
        ];
        if ($tender_model->updateTenderState($tender_data, $tender_id)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
        //$this->route->redirect($this->route->site_url("Admin/dashboard"));
    }
    ################  Ajax Response For Important Links  Start ##############
    public function ajaxresponseforImportantLinks()
    {
        $importantlink_id = Helpers::cleanData($_POST['importantlink_id']);
        // echo $cid;
        $il_model = new ImportantLinks();
        $il_data = [
            'status' => '1',
        ];
        if ($il_model->updateImportantLinksState($il_data, $importantlink_id)) {
            $message = 1;
            $message_title = "Important Link Published successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforImportantLinksunpublish()
    {
        $importantlink_id = Helpers::cleanData($_POST['importantlink_id']);
        // echo $cid;
        $il_model = new ImportantLinks();
        $il_data = [
            'status' => '0',
        ];
        if ($il_model->updateImportantLinksState($il_data, $importantlink_id)) {
            $message = 1;
            $message_title = "Important Link UnPublished successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    ################  Ajax Response For Important Links  End ##############
    ################  Ajax Response For Event Category  Start ##############
    public function ajaxresponseforEventCategory()
    {
        $ec_id = Helpers::cleanData($_POST['ec_id']);
        // echo $cid;
        $ec_model = new EventCategory();
        $ec_data = [
            'status' => '1',
        ];
        if ($ec_model->updateEventCategoryState($ec_data, $ec_id)) {
            $message = 1;
            $message_title = "Event Category Published successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforEventCategoryunpublish()
    {
        $ec_id = Helpers::cleanData($_POST['ec_id']);
        // echo $cid;
        $ec_model = new EventCategory();
        $ec_data = [
            'status' => '0',
        ];
        if ($ec_model->updateEventCategoryState($ec_data, $ec_id)) {
            $message = 1;
            $message_title = "Event Category UnPublished successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    ################  Ajax Response For Event Category   End ##############
    public function ajaxresponseforPhaseMaster()
    {
        $phasemaster_id = htmlspecialchars($_POST['pm_id']);
        // echo $cid;
        $pm_model = new PhaseMaster();
        $pm_data = [
            'status' => '1',
        ];
        if ($pm_model->updatePhaseMasterState($pm_data, $phasemaster_id)) {
            $message = 1;
            $message_title = "Phase Master Published successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforphaseunpublish()
    {
        $phasemaster_id = htmlspecialchars($_POST['phaseid']);
        // echo $cid;
        $pm_model = new PhaseMaster();
        $pm_data = [
            'status' => '0',
        ];
        if ($pm_model->updatePhaseMasterState($pm_data, $phasemaster_id)) {
            $message = 1;
            $message_title = "Phase Master UnPublished successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforNarchieves()
    {
        $year = Helpers::cleanData($_POST['nom_year']);
        $month = Helpers::cleanData($_POST['nom_month']);
        $model = new NominationArchieves();
        $model_archieves = $model->nominationArchieves($year, $month);
        $arrayValue = json_decode(json_encode($model_archieves), true);
        if (count($arrayValue) > 0) {
            foreach ($arrayValue as $row) {
                @$array['data'][] = array($row['exam_name'], $row['category_name'], $row['date_archived']);
            }
            $string = json_encode($array);
            $dataList = substr($string, 1, -1);
            echo "{" . str_replace('}', ']', str_replace('{', '[', $dataList)) . "}";
        } else {
            echo 'null';
        }
    }
    /*****
     * 
     * 
     * Selection Post Archives By Month
     * 
     * 
     * 
     */
    public function ajaxresponseforSelectionPostarchievesByMonth()
    {
        $year = Helpers::cleanData($_POST['sp_year']);
        $month = Helpers::cleanData($_POST['sp_month']);
        $model = new SelectionpostArchives();
        $model_archieves = $model->selectionPostArchievesByMonth($year, $month);
        $arrayValue = json_decode(json_encode($model_archieves), true);
        if (count($arrayValue) > 0) {
            foreach ($arrayValue as $row) {
                @$array['data'][] = array($row['exam_name'], $row['category_name'], $row['date_archived']);
            }
            $string = json_encode($array);
            $dataList = substr($string, 1, -1);
            echo "{" . str_replace('}', ']', str_replace('{', '[', $dataList)) . "}";
        } else {
            echo 'null';
        }
    }
    /*****
     * 
     * 
     * Selection Post Archives By Month
     * 
     * 
     * 
     */
    /*****
     * 
     * 
     * Notice Archives By Month
     * 
     * 
     * 
     */
    public function ajaxresponseforNoticearchievesByMonth()
    {
        $year = Helpers::cleanData($_POST['notice_year']);
        $month = Helpers::cleanData($_POST['notice_month']);
        $model = new NoticeArchives();
        $model_archieves = $model->noticeArchievesByMonth($year, $month);
        $arrayValue = json_decode(json_encode($model_archieves), true);
        if (count($arrayValue) > 0) {
            foreach ($arrayValue as $row) {
                @$array['data'][] = array($row['pdf_name'], $row['category_name'], $row['date_archived']);
            }
            $string = json_encode($array);
            $dataList = substr($string, 1, -1);
            echo "{" . str_replace('}', ']', str_replace('{', '[', $dataList)) . "}";
        } else {
            echo 'null';
        }
    }
    /*****
     * 
     * 
     *  Archives By Month
     * 
     * 
     * 
     */
    public function ajaxresponseforArchievesByMonth()
    {
        $year = Helpers::cleanData($_POST['year']);
        $month = Helpers::cleanData($_POST['month']);
        $elink = Helpers::cleanData($_POST['elink']);
        $dlink = Helpers::cleanData($_POST['dlink']);
        $alink = Helpers::cleanData($_POST['alink']);
        $effect_from_date = Helpers::cleanData($_POST['effect_from_date']);
        $effect_to_date = Helpers::cleanData($_POST['effect_to_date']);
        $modelName = Helpers::cleanData($_POST['model']);
        switch ($modelName) {
            case "Gallery":
                $model = new Gallery();
                break;
            case "SelectionpostArchives":
                $model = new SelectionpostArchives();
                break;
            case "Nomination":
                $model = new Nomination();
                $functionName = "get" . $modelName . "Details";
                $idname = 'nomination_id';
                $model_archieves = $model->$functionName($year, $month, $effect_from_date, $effect_to_date);
                $arrayValue = json_decode(json_encode($model_archieves), true);
                $user = new User();
                $is_superadmin = $user->is_superadmin(); // super admin 
                $data['is_superadmin'] = $is_superadmin; // super admin 
                $is_admin = $user->is_admin(); // admin 
                $data['is_admin'] = $is_admin; // admin 
                $is_uploader = $user->is_uploader(); //uploader
                $data['is_uploader'] = $is_uploader; //uploader
                $is_publisher = $user->is_publisher(); // publisher
                $data['is_publisher'] = $is_publisher;
                if (count($arrayValue) > 0) {
                    foreach ($arrayValue as $row):
                        $delete_nomination_link_str = str_replace("{id}", $row['nomination_id'], $dlink);
                        $edit_nomination_link_str = str_replace("{id}", $row['nomination_id'], $elink);
                        $archive_nomination_link_str = str_replace("{id}", $row['nomination_id'], $alink);
                        $nominationchildclass = new Nominationchild();
                        $nominationchildlist = $nominationchildclass->getNominationchild();
                        $output = "";
                        foreach ($nominationchildlist as $key => $childlist):
                            $selected = "";
                            if ($row['nomination_id'] == $childlist->nomination_id) {
                                $selected = "selected=\"selected\"";
                                $uploadPath = 'nominations' . '/' . $childlist->attachment;
                                $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                                $output .= <<<HTML
            <a href='$file_location' rel = "noopener noreferrer"  target="_blank"> $childlist->pdf_name</a>,<br>
HTML;
                            }
                            ?>
                                                <?php endforeach; ?>
                                                <?php $flagValue = Helpers::flagoutput($row['p_status']);
                                                $rolebasedValue = Helpers::roleBased();
                                                if ($rolebasedValue['is_superadmin'] == 1) {
                                                    $primaryid = $row['nomination_id'];
                                                    $publishbaseurl = $this->route->site_url("Admin/ajaxresponseforPublish");
                                                    $archivesbaseurl = $this->route->site_url("Admin/ajaxresponseforArchives");
                                                    $redirecturl = $this->route->site_url("Admin/dashboard/?action=listnominations&&status=0");
                                                    $status = $row['p_status'];
                                                    $actionoutputValue = Helpers::iconOperation($edit_nomination_link_str, $delete_nomination_link_str, $archive_nomination_link_str, $primaryid, $idname, $publishbaseurl, $archivesbaseurl, $redirecturl, $status, "Nomination");
                                                } else if ($rolebasedValue['is_admin'] == 1) {
                                                    $primaryid = $row['nomination_id'];
                                                    $publishbaseurl = $this->route->site_url("Admin/ajaxresponseforPublish");
                                                    $archivesbaseurl = $this->route->site_url("Admin/ajaxresponseforArchives");
                                                    $redirecturl = $this->route->site_url("Admin/dashboard/?action=listnominations&&status=0");
                                                    $status = $row['p_status'];
                                                    $actionoutputValue = Helpers::iconOperation($edit_nomination_link_str, $delete_nomination_link_str, $archive_nomination_link_str, $primaryid, $idname, $publishbaseurl, $archivesbaseurl, $redirecturl, $status, "Nomination");
                                                } elseif ($rolebasedValue['is_uploader'] == 1) {
                                                    $primaryid = $row['nomination_id'];
                                                    $publishbaseurl = $this->route->site_url("Admin/ajaxresponseforPublish");
                                                    $archivesbaseurl = $this->route->site_url("Admin/ajaxresponseforArchives");
                                                    $redirecturl = $this->route->site_url("Admin/dashboard/?action=listnominations&&status=0");
                                                    $status = $row['p_status'];
                                                    $actionoutputValue = Helpers::iconOperation($edit_nomination_link_str, $delete_nomination_link_str, $archive_nomination_link_str, $primaryid, $idname, $publishbaseurl, $archivesbaseurl, $redirecturl, $status, "Nomination");
                                                } else {
                                                    // if (@$_GET['status'] == 0 && $row['p_status'] != 1) {
                                                    //     echo '<i class="fa fa-eye nomination-publish-button" style="color:#007bff"></i>';
                                                    // }
                                                }
                                                // echo  $output;
                                                // $outputarray =explode(" ",$output);
                                                // $outputarray = array($output);
                                                // print_r( $outputarray);
                                                @$array['data'][] = array($primaryid, $row['exam_name'], $row['category_name'], $output, $row['effect_from_date'], $row['effect_to_date'], $flagValue, $actionoutputValue);
                    endforeach;
                    //echo '<pre>';
                    //print_r($array);
                    $string = json_encode($array);
                    $dataList = substr($string, 1, -1);
                    echo "{" . str_replace('}', ']', str_replace('{', '[', $dataList)) . "}";
                } else {
                    echo 'null';
                }
                break;
            case "Tender":
                $model = new Tender();
                $functionName = "get" . $modelName . "Details";
                $idname = 'tender_id';
                $model_archieves = $model->$functionName($year, $month, $effect_from_date, $effect_to_date);
                $arrayValue = json_decode(json_encode($model_archieves), true);
                if (count($arrayValue) > 0) {
                    foreach ($arrayValue as $row) {
                        $delete_tender_link_str = str_replace("{id}", $row['tender_id'], $dlink);
                        $edit_tender_link_str = str_replace("{id}", $row['tender_id'], $elink);
                        $archive_tender_link_str = str_replace("{id}", $row['tender_id'], $alink);
                        $uploadPath = 'tender' . '/' . $row['attachment'];
                        $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                        $output = "";
                        $output .= '<a href=" ' . $file_location . '" rel = "noopener noreferrer" target="_blank">' . $row["attachment"] . ' </a>';
                        ?>
                        <?php
                        $flagValue = Helpers::flagoutput($row['p_status']);
                        $rolebasedValue = Helpers::roleBased();
                        if ($rolebasedValue['is_admin'] == 1) {
                            $primaryid = $row['tender_id'];
                            $publishbaseurl = $this->route->site_url("Admin/ajaxresponseforPublish");
                            $archivesbaseurl = $this->route->site_url("Admin/ajaxresponseforArchives");
                            $redirecturl = $this->route->site_url("Admin/dashboard/?action=tender_archieves_by_month&&status=0");
                            $status = $row['p_status'];
                            $actionoutputValue = Helpers::iconOperation($edit_tender_link_str, $delete_tender_link_str, $archive_tender_link_str, $primaryid, $idname, $publishbaseurl, $archivesbaseurl, $redirecturl, $status, "Tender");
                        }
                        @$array['data'][] = array($row['tender_id'], $row['pdf_name'], $output, $row['effect_from_date'], $row['effect_to_date'], $flagValue, $actionoutputValue);
                    }
                    $string = json_encode($array);
                    $dataList = substr($string, 1, -1);
                    echo "{" . str_replace('}', ']', str_replace('{', '[', $dataList)) . "}";
                } else {
                    echo 'null';
                }
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }
    }
    /*****
     * 
     * 
     * Selection Post Archives By Month
     * 
     * 
     * 
     */
    ################  Ajax Response For  Category  Start ##############
    public function ajaxresponseforPublish()
    {
        $rowid = Helpers::cleanData($_POST['rowid']);
        $modelClassName = Helpers::cleanData($_POST['modelClassName']);
        // $favcolor = "red";
        switch ($modelClassName) {
            case "Gallery":
                $model = new Gallery();
                break;
            case "SelectionpostArchives":
                $model = new SelectionpostArchives();
                break;
            case "NoticeArchives":
                $model = new NoticeArchives();
                break;
            case "TenderArchives":
                $model = new TenderArchives();
                break;
            case "Tender":
                $model = new Tender();
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }
        $functionName = "update" . $modelClassName . "State";
        //  echo $functionName;
        //  exit;
        $data = [
            'p_status' => '1',
        ];
        if ($model->$functionName($data, $rowid)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
    }
    ################  Ajax Response For  Category   End ##############
    public function ajaxresponseforArchives()
    {
        $rowid = Helpers::cleanData($_POST['rowid']);
        $modelClassName = Helpers::cleanData($_POST['modelClassName']);
        // echo  $rowid;
        // echo  $modelClassName;
        //sa exit;
        // $favcolor = "red";
        switch ($modelClassName) {
            case "Nomination":
                $model = new Nomination();
                $redirectUrl = 'listnominations';
                break;
            case "SelectionpostArchives":
                $model = new SelectionpostArchives();
                break;
            case "NoticeArchives":
                $model = new NoticeArchives();
                break;
            case "TenderArchives":
                $model = new TenderArchives();
                break;
            case "Tender":
                $model = new Tender();
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }
        $functionName = "archive" . $modelClassName . "Status";
        $tenderlist_data = $_POST['rowid'];
        //  echo $functionName;
        if ($model->$functionName($tenderlist_data)) {
            $message = $modelClassName . "  Archived successfully";
            $status = 'success';
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message, "status" => $status));
        }
        // $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        // $redirectUrlPath = "Admin/dashboard/?action=".$redirectUrl;
        // echo  $redirectUrlPath ;
        // $this->route->redirect($this->route->site_url( $redirectUrlPath));
        // exit;
    }
    ################  Ajax Response For  Category  Start ##############
    public function ajaxresponseforCategory()
    {
        $cat_id = Helpers::cleanData($_POST['cat_id']);
        // echo $cid;
        $category_model = new Category();
        $category_data = [
            'status' => '1',
        ];
        if ($category_model->updateCategoryState($category_data, $cat_id)) {
            $message = 1;
            $message_title = "Category  has been Published successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }

    public function ajaxresponseforCategoryUnpublish()
    {
        $cat_id = Helpers::cleanData($_POST['cat_id']);
        // echo $cid;
        $category_model = new Category();
        $category_data = [
            'status' => '0',
        ];
        if ($category_model->updateCategoryState($category_data, $cat_id)) {
            $message = 1;
            $message_title = "Category  has been UnPublished successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    ################  Ajax Response For  Category   End ##############
    /*  Check Username Availability with jQuery and AJAX  Start*/
    public function ajaxResponseforUserNameAlreadyExists()
    {
        $username = Helpers::cleanData($_POST['username']);
        // echo $cid;
        $user_lists = new Loginusers();
        if ($user_lists->usernameAlreadyExists($username)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
    }
    /*  Check Username Availability with jQuery and AJAX  Start*/
    /*  Check Email Availability with jQuery and AJAX  Start*/
    public function ajaxResponseforEmailAlreadyExists()
    {
        $email = Helpers::cleanData($_POST['email']);
        // echo $cid;
        $user_lists = new Loginusers();
        if ($user_lists->emailAlreadyExists($email)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
    }
    /*  Check Email Availability with jQuery and AJAX  Start*/
    /*  Check Phone Number Availability with jQuery and AJAX  Start*/
    public function ajaxResponseforPhoneNumberAlreadyExists()
    {
        $phone_number = Helpers::cleanData($_POST['phone_number']);
        // echo $cid;
        $user_lists = new Loginusers();
        if ($user_lists->phonenumberAlreadyExists($phone_number)) {
            $message = 1;
            header('Content-Type: application/json');
            echo json_encode(array("message" => $message));
        }
    }
    /*  Check Phone Number Availability with jQuery and AJAX  Start*/
    #######################   Event Category Start #####################
    public function editEventCategory()
    {
        $data = [];
        $this->saveEventCategory();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        $eventcategory = new EventCategory();
        // chek if the id is available in the params 
        $eventcategoryid = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_eventcategory = $eventcategory->getEventCategoryby($eventcategoryid, DB_ASSOC);
        $data['current_eventcategory'] = $current_eventcategory;
        $this->prepare_menus($data);
        $this->render("edit-eventcategory", $data);
    }
    private function saveEventCategory()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_event_category'])) {
                $event_id = isset($_POST['id']) ? $_POST['id'] : 0;
                $creation_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['creation_date'])));
                $event_category_data = [
                    'event_name' => Helpers::cleanData($_POST['event_name']),
                    'creation_date' => $creation_date,
                    'status' => '0'
                ];
       
                $event = new \App\Models\EventCategory();
                if ($event_id == '') { // insert new menu 
                    if ($event->addEventCategory($event_category_data)) {
                        $message = "Event Category Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Event Category ";
                        $message_type = "warning";
                    }
                } else { // update menu
                    if ($event->updateEventCategory($event_category_data, $event_id)) {
                        $message = "Event Category Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Event Category ";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofeventcategories"));
            }
        }
    }
    public function deleteeventcategory()
    {
        $data = [];
        $message = $message_type = "";
        $eventcategory_id = $this->data['params'][0];
        $eventcategory = new EventCategory();
        if ($eventcategory->deleteEventCategory($eventcategory_id)) {
            $message = "Event Category Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Event Category ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofeventcategories"));
    }
    #######################   Event Category End #####################
    #############################  FAQ  start  ############################
    public function editfaq()
    {
        $data = [];
        $this->saveFaq();
        $user = new User();
        $loginUser = $user->getUser();
        $is_admin = $user->is_admin();
        $data['is_admin'] = $is_admin;
        $data['logged_user'] = $loginUser;
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        ob_start();
        if ($is_admin) {
        }
        $faq = new Faq();
        // chek if the id is available in the params 
        $faq_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_faq = $faq->getFaqby($faq_id, DB_ASSOC);
        $data['current_faq'] = $current_faq;
        $faqs = $faq->getFaqList();
        $data['faqs'] = $faqs;
        $this->prepare_menus($data);
        $this->render("edit-faq", $data);
    }
    private function saveFaq()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_faq'])) {
                $faq_id = isset($_POST['id']) ? $_POST['id'] : 0;
                $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
                $faq_title = Helpers::cleanData($_POST['faq_title']);
                $faq_title_cs = Helpers::e($faq_title);
                $faq_content = Helpers::cleanData($_POST['faq_content']);
                $faq_content_cs = Helpers::e($faq_content);
                $faqlist_data = [
                    'faq_title' => $faq_title_cs,
                    'faq_content' => $faq_content_cs,
                    'effect_from_date' => $effect_from_date,
                    'p_status' => '0'
                ];
                /* echo "<pre>";
            print_r($menu_data);
            exit; */
                $faqlist = new \App\Models\Faq();
                if ($faq_id == 0) { // insert new menu 
                    if ($faqlist->addFaq($faqlist_data)) {
                        $message = "Faq   Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Faq";
                        $message_type = "warning";
                    }
                } else { // update menu
                    if ($faqlist->updateFaq($faqlist_data, $faq_id)) {
                        $message = "Faq Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Faq";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listoffaq"));
            }
        }
    }
    public function deleteFaq()
    {
        $data = [];
        $message = $message_type = "";
        $faq_id = $this->data['params'][0];
        $faq = new Faq();
        if ($faq->deleteFaqStatus($faq_id)) {
            $message = "Faq  Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Faq ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listoffaq"));
    }
    #############################  FAQ  End  ############################
    #######################   Gallery Start #####################
    public function editGallery()
    {
        $data = [];
        $this->saveGallery();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        $gallery_model = new Gallery();
        // chek if the id is available in the params 
        $gallery_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_gallery = $gallery_model->getGallery($gallery_id, DB_ASSOC);
        $data['current_gallery'] = $current_gallery;
        $gallery_child_model = new GalleryChild();
        $gallery_child_list = $gallery_child_model->getGalleryChildList();
        $data['gallery_child_list'] = $gallery_child_list;
        //$nominations = $nomination->getNominations();
        //$data['nominations'] = $nominations;
        $data['gallery_id'] = $gallery_id;
        $eventcategory_model = new EventCategory();
        $eventcategories = $eventcategory_model->getEventCategoriesList();
        $data['eventcategories'] = $eventcategories;
        $eventcategoriesdropdown = $eventcategory_model->getEventCategoriesListDropdown();
        $data['eventcategoriesdropdown'] = $eventcategoriesdropdown;
        $this->prepare_menus($data);
        $this->render("edit-gallery", $data);
    }
    private function saveGallery()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_gallery'])) {
                $gallery_id = isset($_POST['gallery_id']) ? $_POST['gallery_id'] : 0;
                $gallery_model = new \App\Models\Gallery();
                $gallery_data = [
                    'year' => Helpers::cleanData($_POST['year']),
                    'event_id' => Helpers::cleanData($_POST['event_id']),
                    // 'effect_from_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date']))),
                    //'effect_to_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date']))),
                    'p_status' => '0',
                ];
                if ($gallery_id == 0) {
                    // insert new menu 
                    if ($gallery_model->addGallery($gallery_data)) {
                        $lastinsertsql = $gallery_model->lastInsertedId();
                        $lastinsertedid = $lastinsertsql['max'];
                        foreach ($_FILES['image_file']['name'] as $i => $name) {
                            $tmp_name = $_FILES['image_file']['tmp_name'][$i];
                            $error = $_FILES['image_file']['error'][$i];
                            $size = $_FILES['image_file']['size'][$i];
                            $type = $_FILES['image_file']['type'][$i];
                            $folder = './gallery/';
                            $file = rand(1000, 100000) . "-" . $_FILES['image_file']['name'][$i];
                            $new_file_name = strtolower($file);
                            $final_file = str_replace(' ', '-', $new_file_name);
                            if (move_uploaded_file($tmp_name, $folder . $final_file)) { // echo "File is valid, and was successfully uploaded.\n";
                            } else {
                                echo "File size greater than 300kb!\n\n";
                            }
                            $gallery_model_child = new \App\Models\GalleryChild();
                            $gallery_child_data = [
                                'gallery_id' => $lastinsertedid,
                                'image_path' => $final_file,
                                'status' => '0'
                            ];
                            $gallery_model_child->addGalleryChild($gallery_child_data);
                        }
                        $message = "Gallery Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Gallery";
                        $message_type = "warning";
                    }
                } else { // update menu
                    $gallery_data = [
                        'year' => Helpers::cleanData($_POST['year']),
                        'event_id' => Helpers::cleanData($_POST['event_id']),
                        //'effect_from_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date']))),
                        // 'effect_to_date' => date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date']))),
                        'p_status' => '0',
                    ];
                    if ($gallery_model->updateGallery($gallery_data, $gallery_id)) {
                        foreach ($_FILES['image_file']['name'] as $i => $name) {
                            if ($_FILES['image_file']['size'][$i] != 0 ) {
                                $child_id = isset($_POST['image_id'][$i]) ? $_POST['image_id'][$i] : 0;
                                $tmp_name = $_FILES['image_file']['tmp_name'][$i];
                                $error = $_FILES['image_file']['error'][$i];
                                $size = $_FILES['image_file']['size'][$i];
                                $type = $_FILES['image_file']['type'][$i];
                                $folder = './gallery/';
                                $file = rand(1000, 100000) . "-" . $_FILES['image_file']['name'][$i];
                                $new_file_name = strtolower($file);
                                $final_file = str_replace(' ', '-', $new_file_name);
                                if (move_uploaded_file($tmp_name, $folder . $final_file)) { // echo "File is valid, and was successfully uploaded.\n";
                                } else {
                                    echo "File size greater than 300kb!\n\n";
                                }
                                $gallery_model_child = new \App\Models\GalleryChild();
                                $lastinsertsql = $gallery_model->lastInsertedId();
                                $lastinsertedid = $lastinsertsql['max'];
                                $gallery_child_data = [
                                    'gallery_id' => $lastinsertedid,
                                    'image_path' => $final_file,
                                    'status' => 1
                                ];
                                if ($child_id == 0) {
                                    $gallery_model_child->addGalleryChild($gallery_child_data);
                                } else {
                                    $gallery_model_child->updateGalleryChild($gallery_child_data, $child_id);
                                }
                            } //Validation
                        }
                        $message = "Gallery Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Gallery";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofphotogallery"));
            }
        }
    }
    #######################   Gallery  End #####################
    public function ajaxResponseForDataTableLoad()
    {
        $request = 1;
        if (isset($_POST['request'])) {
            $request = Helpers::cleanData($_POST['request']);
        }
        if ($request == 1) {
            ## Read value
            $draw = Helpers::cleanData($_POST['draw']);
            $row = Helpers::cleanData($_POST['start']);
            $rowperpage = Helpers::cleanData($_POST['length']); // Rows display per page
            $columnIndex = Helpers::cleanData($_POST['order'][0]['column']); // Column index
            $columnName = Helpers::cleanData($_POST['columns'][$columnIndex]['data']); // Column name
            $columnSortOrder = Helpers::cleanData($_POST['order'][0]['dir']); // asc or desc
            $searchValue = Helpers::cleanData($_POST['search']['value']); // Search value
            ## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = "   exam_name ilike '%" . $searchValue . "%' or 
                category_name ilike '%" . $searchValue . "%' or 
                TO_CHAR(effect_from_date, 'yyyy-mm-dd') like'%" . $searchValue . "%'  or
                TO_CHAR(effect_to_date, 'yyyy-mm-dd') like'%" . $searchValue . "%' 
                 ";
            }
            ## Total number of records without filtering
            $model = new Nomination();
            $year = trim(Helpers::cleanData($_POST['year']));
            $month = trim(Helpers::cleanData($_POST['month']));
            $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
            $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
            $totalRecordsWithoutFiltering = $model->totalRecordsWithOutFiltering();
            $totalRecords = $totalRecordsWithoutFiltering->allcount;
            ## Total number of records with filtering
            $totalRecordsWithFiltering = $model->totalRecordsWithFiltering($searchQuery);
            $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
            if ($rowperpage == -1) {
                $fetchRecordsObject = $model->getNominationDetailsAll($year, $month, $effect_from_date, $effect_to_date, $searchQuery);
            } else {
                $fetchRecordsObject = $model->getNominationDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery, $row, $rowperpage);
            }
            $fetchRecords = (array) $fetchRecordsObject;
            $nominationchildlist = Helpers::getNominationChildListforAdmin();
            $edit_nomination_link = $this->links['edit_nomination_link'];
            $data = array();
            foreach ($fetchRecords as $rowval) {
                $edit_nomination_link_str = str_replace("{id}", $rowval->nomination_id, $edit_nomination_link);
                $baseurl = $this->route->site_url($edit_nomination_link_str);
                $updateButton = "<a href= '" . $baseurl . "' name='menu_update' class='iconSize'> 
         <button type='button' title='Edit' class='btn btn-secondary iconWidth updateUser'><i class='fas fa-edit'></i></button>
         </a>";
                // Delete Button
                $deleteButton = "<button title='Delete' class='btn btn-sm btn-danger iconWidth deletebtn' style='height:30px'  data-id='" . $rowval->nomination_id . "'><i class='fa fa-trash'></i></button>";
                // $archivesButton = "<button  title='Archive' style='height:30px' class='btn btn-sm btn-primary archivebtn' data-id='" . $rowval->nomination_id . "'><i class='fa  fa-archive'></i></button>";
                if ($rowval->p_status != 1) {
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                    $user = new User();
                    $loginUser = $user->getUser();
                    $is_superadmin = $user->is_superadmin();
                    $is_admin = $user->is_admin();
                    $is_uploader = $user->is_uploader();
                    $is_publisher = $user->is_publisher();
                    $array = array(
                        "super_admin" => $user->is_superadmin() ? $user->is_superadmin() : "",
                        "admin" => $user->is_admin() ? $user->is_admin() : "",
                        "uploader" => $user->is_uploader() ? $user->is_uploader() : "",
                        "publisher" => $user->is_publisher() ? $user->is_publisher() : "",
                    );
                    if ($array['uploader'] == 1) {
                        $action = $updateButton . " " . $deleteButton;
                    } else if ($array['publisher'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->nomination_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $publishButton;
                    } else if ($array['admin'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->nomination_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $updateButton . " " . $deleteButton . " " . $publishButton;
                    } else {
                    }
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                } else {
                    // $action = "<p style='color:green'>Published</p>";
                    $unpublishButton = "<button  title='Un Publish' style='height:24px' class='btn btn-sm btn-danger unpublishbtn iconWidth' data-id='" . $rowval->nomination_id . "'><i class='fa  fa-eye'></i></button>";
                    $green_text = "<p style='color:green'>Published</p>";
                    $action = $green_text . $unpublishButton;
                }
                $pdfPath = "";
                $pdfLinks = []; // Initialize an array to store the PDF links
                foreach ($nominationchildlist as $key => $childlist) {
                    $selected = "";
                    if ($rowval->nomination_id == $childlist->nomination_id) {
                        $selected = "selected=\"selected\"";
                        $uploadPath = 'nominations' . '/' . $childlist->attachment;
                        $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                        // Add the PDF link to the array
                        $pdfLinks[] = "<a href=\"$file_location\" target=\"_blank\">$childlist->pdf_name</a>";
                    }
                }
                // Join the PDF links with commas
                $pdfPath = implode(', ', $pdfLinks);
                $flag = "";
                if ($rowval->p_status == 1) {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true"  style="color:green"></i>';
                } else {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true" style="color:red"></i>';
                }
                $data[] = array(
                    "nomination_id" => $rowval->nomination_id,
                    "exam_name" => $rowval->exam_name,
                    "category_name" => $rowval->category_name,
                    "pdf_name" => $pdfPath,
                    "effect_from_date" => $rowval->effect_from_date,
                    "effect_to_date" => $rowval->effect_to_date,
                    "p_status" => $flag,
                    "action" => $action,
                );
            }
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            echo json_encode($response);
            exit;
        } //request 1
        // Delete Nomination
        if ($request == 4) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Nomination();
            $checkId = $model->checkNominationId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $deleteQuery = $model->deleteNomination($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Archive Nomination
        if ($request == 5) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Nomination();
            $checkId = $model->checkNominationId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $archiveQuery = $model->archiveNominationStatus($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Publish Nomination
        if ($request == 6) {
            $id = Helpers::cleanData($_POST['id']);
            $nomination_data = [
                'p_status' => '1',
            ];
            // Check id
            ## Fetch records
            $model = new Nomination();
            $checkId = $model->checkNominationId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateNominationState($nomination_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Un Publish Nomination
        if ($request == 7) {
            $id = Helpers::cleanData($_POST['id']);
            $nomination_data = [
                'p_status' => '0',
            ];
            // Check id
            ## Fetch records
            $model = new Nomination();
            $checkId = $model->checkNominationId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateNominationState($nomination_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
    }
    public function commonNominationArchive()
    {
        if (!empty(Helpers::cleanData($_POST["action"]))) {
            $nomination = new Nomination();
            $nomination_list_data = Helpers::cleanData($_POST['ids']);
            if (Helpers::cleanData($_POST["action"]) == 'archive') {
                if ($nomination->archiveNominationStatus($nomination_list_data)) {
                    $message = "Nomination  Archived successfully";
                    $message_type = "success";
                }
            } else {
                if ($nomination->deleteNomination($nomination_list_data)) {
                    $message = "Nomination  Deleted successfully";
                    $message_type = "success";
                }
            }
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listnominations"));
    }
    /***
     * 
     * Selection Post
     *    */
    public function ajaxResponseForSpDataTableLoad()
    {
        $request = 1;
        if (isset($_POST['request'])) {
            $request = Helpers::cleanData($_POST['request']);
        }
        if ($request == 1) {
            ## Read value
            $draw = Helpers::cleanData($_POST['draw']);
            $row = Helpers::cleanData($_POST['start']);
            $rowperpage = Helpers::cleanData($_POST['length']); // Rows display per page
            $columnIndex = Helpers::cleanData($_POST['order'][0]['column']); // Column index
            $columnName = Helpers::cleanData($_POST['columns'][$columnIndex]['data']); // Column name
            $columnSortOrder = Helpers::cleanData($_POST['order'][0]['dir']); // asc or desc
            $searchValue = Helpers::cleanData($_POST['search']['value']); // Search value
            ## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = "   exam_name ilike '%" . $searchValue . "%' or 
              category_name ilike '%" . $searchValue . "%' or 
              TO_CHAR(effect_from_date, 'yyyy-mm-dd') like'%" . $searchValue . "%'  or
              TO_CHAR(effect_to_date, 'yyyy-mm-dd') like'%" . $searchValue . "%' 
               ";
            }
            ## Total number of records without filtering
            $model = new Selectionpost();
            $year = trim(Helpers::cleanData($_POST['year']));
            $month = trim(Helpers::cleanData($_POST['month']));
            $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
            $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
            $totalRecordsWithoutFiltering = $model->totalRecordsWithOutFiltering();
            $totalRecords = $totalRecordsWithoutFiltering->allcount;
            ## Total number of records with filtering
            $totalRecordsWithFiltering = $model->totalRecordsWithFiltering($searchQuery);
            $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
            if ($rowperpage == -1) {
                $fetchRecordsObject = $model->getSelectionPostDetailsAll($year, $month, $effect_from_date, $effect_to_date, $searchQuery);
            }else{
                $fetchRecordsObject = $model->getSelectionPostDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery,$row,$rowperpage);
            }
            $fetchRecords = (array) $fetchRecordsObject;
            // echo '<pre>';
            // print_r( $fetchRecords );
            // exit;
            $selectpostschildlist = Helpers::getSelectionpostchildListforAdmin();
            $edit_selection_post_link = $this->links['edit_selection_post_link'];
            $data = array();
            foreach ($fetchRecords as $rowval) {
                $edit_selection_post_link_str = str_replace("{id}", $rowval->selection_post_id, $edit_selection_post_link);
                $baseurl = $this->route->site_url($edit_selection_post_link_str);
                $updateButton = "<a href= '" . $baseurl . "' name='menu_update' class='iconSize'> 
       <button type='button' title='Edit' class='btn btn-secondary iconWidth updateUser'><i class='fas fa-edit'></i></button>
       </a>";
                // Delete Button
                $deleteButton = "<button title='Delete' class='btn btn-sm btn-danger iconWidth deletebtn' style='height:30px'  data-id='" . $rowval->selection_post_id . "'><i class='fa fa-trash'></i></button>";
                //$archivesButton = "<button  title='Archive' style='height:30px' class='btn btn-sm btn-primary archivebtn' data-id='" . $rowval->selection_post_id . "'><i class='fa  fa-archive'></i></button>";
                if ($rowval->p_status != 1) {
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                    $user = new User();
                    $loginUser = $user->getUser();
                    $is_superadmin = $user->is_superadmin();
                    $is_admin = $user->is_admin();
                    $is_uploader = $user->is_uploader();
                    $is_publisher = $user->is_publisher();
                    $array = array(
                        "super_admin" => $user->is_superadmin() ? $user->is_superadmin() : "",
                        "admin" => $user->is_admin() ? $user->is_admin() : "",
                        "uploader" => $user->is_uploader() ? $user->is_uploader() : "",
                        "publisher" => $user->is_publisher() ? $user->is_publisher() : "",
                    );
                    if ($array['uploader'] == 1) {
                        $action = $updateButton . " " . $deleteButton;
                    } else if ($array['publisher'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->selection_post_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $publishButton;
                    } else if ($array['admin'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->selection_post_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $updateButton . " " . $deleteButton . " " . $publishButton;
                    } else {
                    }
                } else {
                    $unpublishButton = "<button  title='Un Publish' style='height:24px' class='btn btn-sm btn-danger sp_unpublishbtn iconWidth' data-id='" . $rowval->selection_post_id . "'><i class='fa  fa-eye'></i></button>";
                    $green_text = "<p style='color:green'>Published</p>";
                    $action = $green_text . $unpublishButton;
                }
                $pdfPath = "";
                $pdfLinks = []; // Initialize an array to store the PDF links
                foreach ($selectpostschildlist as $key => $childlist) {
                    $selected = "";
                    if ($rowval->selection_post_id == $childlist->selection_post_id) {
                        $selected = "selected=\"selected\"";
                        $uploadPath = 'selectionposts' . '/' . $childlist->attachment;
                        $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                        // Add the PDF link to the array
                        $pdfLinks[] = "<a href=\"$file_location\" target=\"_blank\">$childlist->pdf_name</a>";
                    }
                }
                // Join the PDF links with commas
                $pdfPath = implode(', ', $pdfLinks);
                $flag = "";
                if ($rowval->p_status == 1) {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true"  style="color:green"></i>';
                } else {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true" style="color:red"></i>';
                }
                $data[] = array(
                    "selection_post_id" => $rowval->selection_post_id,
                    "exam_name" => $rowval->exam_name,
                    "category_name" => $rowval->category_name,
                    "phase_name" => $rowval->phase_name,
                    "pdf_name" => $pdfPath,
                    "effect_from_date" => $rowval->effect_from_date,
                    "effect_to_date" => $rowval->effect_to_date,
                    "p_status" => $flag,
                    "action" => $action,
                );
            }
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            echo json_encode($response);
            exit;
        } //request 1
        // Delete Nomination
        if ($request == 4) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Selectionpost();
            $checkId = $model->checkSelectionpostId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $deleteQuery = $model->deleteSelectionPost($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Archive Nomination
        if ($request == 5) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Selectionpost();
            $checkId = $model->checkSelectionpostId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $archiveQuery = $model->archiveSelectionPostStatus($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Publish Nomination
        if ($request == 6) {
            $id = Helpers::cleanData($_POST['id']);
            $sp_data = [
                'p_status' => '1',
            ];
            // Check id
            ## Fetch records
            $model = new Selectionpost();
            $checkId = $model->checkSelectionpostId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateSelectionpostState($sp_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Un Publish Selection Post
        if ($request == 7) {
            $id = Helpers::cleanData($_POST['id']);
            $sp_data = [
                'p_status' => '0',
            ];
            // Check id
            ## Fetch records
            $model = new Selectionpost();
            $checkId = $model->checkSelectionpostId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateSelectionpostState($sp_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
    }
    public function commonSelectionPostArchive()
    {
        if (!empty(Helpers::cleanData($_POST["action"]))) {
            $sp = new Selectionpost();
            $sp_list_data = Helpers::cleanData($_POST['ids']);
            if (Helpers::cleanData($_POST["action"]) == 'archive') {
                if ($sp->archiveSelectionPostStatus($sp_list_data)) {
                    $message = " Selection Post Archived successfully";
                    $message_type = "success";
                }
            } else {
                if ($sp->deleteSelectionPost($sp_list_data)) {
                    $message = " Selection Post  Deleted successfully";
                    $message_type = "success";
                }
            }
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listselectionposts"));
    }
    /*****
     *
     * Selection Post 
     *
     */
    /*****
     * 
     * 
     * Tender 
     * 
     */
    public function ajaxResponseForTenderDataTableLoad()
    {
        $request = 1;
        if (isset($_POST['request'])) {
            $request = Helpers::cleanData($_POST['request']);
        }
        if ($request == 1) {
            ## Read value
            $draw = Helpers::cleanData($_POST['draw']);
            $row = Helpers::cleanData($_POST['start']);
            $rowperpage = Helpers::cleanData($_POST['length']); // Rows display per page
            $columnIndex = Helpers::cleanData($_POST['order'][0]['column']); // Column index
            $columnName = Helpers::cleanData($_POST['columns'][$columnIndex]['data']); // Column name
            $columnSortOrder = Helpers::cleanData($_POST['order'][0]['dir']); // asc or desc
            $searchValue = Helpers::cleanData($_POST['search']['value']); // Search value
            ## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = "   pdf_name ilike '%" . $searchValue . "%' or 
              TO_CHAR(effect_from_date, 'yyyy-mm-dd') like'%" . $searchValue . "%'  or
              TO_CHAR(effect_to_date, 'yyyy-mm-dd') like'%" . $searchValue . "%' 
               ";
            }
            ## Total number of records without filtering
            $model = new Tender();
            $year = trim(Helpers::cleanData($_POST['year']));
            $month = trim(Helpers::cleanData($_POST['month']));
            $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
            $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
            $totalRecordsWithoutFiltering = $model->totalRecordsWithOutFiltering();
            $totalRecords = $totalRecordsWithoutFiltering->allcount;
            ## Total number of records with filtering
            $totalRecordsWithFiltering = $model->totalRecordsWithFiltering($searchQuery);
            $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
            if ($rowperpage == -1) {
                $fetchRecordsObject = $model->getTenderDetailsAll($year, $month, $effect_from_date, $effect_to_date, $searchQuery);
            }else{
                $fetchRecordsObject = $model->getTenderDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery,$row,$rowperpage);
            }
           
            $fetchRecords = (array) $fetchRecordsObject;
            $edit_tender_link = $this->links['edit_tender_link'];
            $data = array();
            foreach ($fetchRecords as $rowval) {
                $edit_tender_link_str = str_replace("{id}", $rowval->tender_id, $edit_tender_link);
                $baseurl = $this->route->site_url($edit_tender_link_str);
                $updateButton = "<a href= '" . $baseurl . "' name='menu_update' class='iconSize'> 
       <button type='button' title='Edit' class='btn btn-secondary iconWidth updateUser'><i class='fas fa-edit'></i></button>
       </a>";
                // Delete Button
                $deleteButton = "<button title='Delete' class='btn btn-sm btn-danger iconWidth deletebtn' style='height:30px'  data-id='" . $rowval->tender_id . "'><i class='fa fa-trash'></i></button>";
                //$archivesButton = "<button  title='Archive' style='height:30px' class='btn btn-sm btn-primary archivebtn' data-id='" . $rowval->tender_id . "'><i class='fa  fa-archive'></i></button>";
                if ($rowval->p_status != 1) {
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                    $user = new User();
                    $loginUser = $user->getUser();
                    $is_superadmin = $user->is_superadmin();
                    $is_admin = $user->is_admin();
                    $is_uploader = $user->is_uploader();
                    $is_publisher = $user->is_publisher();
                    $array = array(
                        "super_admin" => $user->is_superadmin() ? $user->is_superadmin() : "",
                        "admin" => $user->is_admin() ? $user->is_admin() : "",
                        "uploader" => $user->is_uploader() ? $user->is_uploader() : "",
                        "publisher" => $user->is_publisher() ? $user->is_publisher() : "",
                    );
                    if ($array['uploader'] == 1) {
                        $action = $updateButton . " " . $deleteButton . " ";
                    } else if ($array['publisher'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->tender_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $publishButton;
                    } else if ($array['admin'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->tender_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $updateButton . " " . $deleteButton . " " . $publishButton;
                    } else {
                    }
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                } else {
                    $unpublishButton = "<button  title='Un Publish' style='height:24px' class='btn btn-sm btn-danger tender_unpublishbtn iconWidth' data-id='" . $rowval->tender_id . "'><i class='fa  fa-eye'></i></button>";
                    $green_text = "<p style='color:green'>Published</p>";
                    $action = $green_text . $unpublishButton;
                    // $action = "<p style='color:green'>Published</p>";
                }
                $pdfPath = "";
                $selected = "";
                $selected = "selected=\"selected\"";
                $uploadPath = 'tender' . '/' . $rowval->attachment;
                $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                $pdfPath .= <<<TEXT
              <a href="$file_location " rel = "noopener noreferrer" target="_blank">$rowval->pdf_name </a><br>
TEXT;
                $flag = "";
                if ($rowval->p_status == 1) {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true"  style="color:green"></i>';
                } else {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true" style="color:red"></i>';
                }
                $data[] = array(
                    "tender_id" => $rowval->tender_id,
                    "pdf_name" => $rowval->pdf_name,
                    "attachment" => $pdfPath,
                    "effect_from_date" => $rowval->effect_from_date,
                    "effect_to_date" => $rowval->effect_to_date,
                    "p_status" => $flag,
                    "action" => $action,
                );
            }
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            echo json_encode($response);
            exit;
        } //request 1
        // Delete Tender
        if ($request == 4) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Tender();
            $checkId = $model->checkTenderId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $deleteQuery = $model->deleteTender($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Archive Tender
        if ($request == 5) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Tender();
            $checkId = $model->checkTenderId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $archiveQuery = $model->archiveTenderStatus($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Publish Tender
        if ($request == 6) {
            $id = Helpers::cleanData($_POST['id']);
            $tender_data = [
                'p_status' => '1',
            ];
            // Check id
            ## Fetch records
            $model = new Tender();
            $checkId = $model->checkTenderId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateTenderState($tender_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Un Publish Tender
        if ($request == 7) {
            $id = Helpers::cleanData($_POST['id']);
            $tender_data = [
                'p_status' => '0',
            ];
            // Check id
            ## Fetch records
            $model = new Tender();
            $checkId = $model->checkTenderId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateTenderState($tender_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
    }
    public function commonTenderArchive()
    {
        if (!empty(Helpers::cleanData($_POST["action"]))) {
            $tender = new Tender();
            $tender_list_data = Helpers::cleanData($_POST['ids']);
            if (Helpers::cleanData($_POST["action"]) == 'archive') {
                if ($tender->archiveTenderStatus($tender_list_data)) {
                    $message = " Tender Archived successfully";
                    $message_type = "success";
                }
            } else {
                if ($tender->deleteTender($tender_list_data)) {
                    $message = " Tender  Deleted successfully";
                    $message_type = "success";
                }
            }
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listoftenders"));
    }
    /*****
     * 
     * 
     * Tender 
     * 
     */
    /**
     * 
     * Notice
     * 
     */
    public function ajaxResponseForNoticeDataTableLoad()
    {
        $request = 1;
        if (isset($_POST['request'])) {
            $request = Helpers::cleanData($_POST['request']);
        }
        if ($request == 1) {
            ## Read value
            $draw = Helpers::cleanData($_POST['draw']);
            $row = Helpers::cleanData($_POST['start']);
            $rowperpage = Helpers::cleanData($_POST['length']); // Rows display per page
            $columnIndex = Helpers::cleanData($_POST['order'][0]['column']); // Column index
            $columnName = Helpers::cleanData($_POST['columns'][$columnIndex]['data']); // Column name
            $columnSortOrder = Helpers::cleanData($_POST['order'][0]['dir']); // asc or desc
            $searchValue = Helpers::cleanData($_POST['search']['value']); // Search value
            ## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = "   notice_name ilike '%" . $searchValue . "%' or 
                category_name ilike '%" . $searchValue . "%' or 
                TO_CHAR(effect_from_date, 'yyyy-mm-dd') like'%" . $searchValue . "%'  or
                TO_CHAR(effect_to_date, 'yyyy-mm-dd') like'%" . $searchValue . "%' 
                 ";
            }
            ## Total number of records without filtering
            $model = new MstNotice();
            $year = trim(Helpers::cleanData($_POST['year']));
            $month = trim(Helpers::cleanData($_POST['month']));
            $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
            $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
            ;
            $totalRecordsWithoutFiltering = $model->totalRecordsWithOutFiltering();
            $totalRecords = $totalRecordsWithoutFiltering->allcount;
            ## Total number of records with filtering
            $totalRecordsWithFiltering = $model->totalRecordsWithFiltering($searchQuery);
            $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
            if ($rowperpage == -1) {
                $fetchRecordsObject = $model->getMstNoticeDetailsAll($year, $month, $effect_from_date, $effect_to_date, $searchQuery);
            }else{
                $fetchRecordsObject = $model->getMstNoticeDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery,$row,$rowperpage);
            }
           
            // echo '<pre>';
            // print_r( $fetchRecordsObject);
            // exit;
            $fetchRecords = (array) $fetchRecordsObject;
            $noticechildlist = Helpers::getNoticeChildListforAdmin();
            // echo '<pre>';
            // print_r( $noticechildlist);
            // exit;
            $edit_notice_link = $this->links['edit_notice_link'];
            $data = array();
            foreach ($fetchRecords as $rowval) {
                $edit_notice_link_str = str_replace("{id}", $rowval->notice_id, $edit_notice_link);
                $baseurl = $this->route->site_url($edit_notice_link_str);
                $updateButton = "<a href= '" . $baseurl . "' name='menu_update' class='iconSize'> 
         <button type='button' title='Edit' class='btn btn-secondary iconWidth updateUser'><i class='fas fa-edit'></i></button>
         </a>";
                // Delete Button
                $deleteButton = "<button title='Delete' class='btn btn-sm btn-danger iconWidth deletebtn' style='height:30px'  data-id='" . $rowval->notice_id . "'><i class='fa fa-trash'></i></button>";
                // $archivesButton = "<button  title='Archive' style='height:30px' class='btn btn-sm btn-primary archivebtn' data-id='" . $rowval->nomination_id . "'><i class='fa  fa-archive'></i></button>";
                if ($rowval->p_status != 1) {
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                    $user = new User();
                    $loginUser = $user->getUser();
                    $is_superadmin = $user->is_superadmin();
                    $is_admin = $user->is_admin();
                    $is_uploader = $user->is_uploader();
                    $is_publisher = $user->is_publisher();
                    $array = array(
                        "super_admin" => $user->is_superadmin() ? $user->is_superadmin() : "",
                        "admin" => $user->is_admin() ? $user->is_admin() : "",
                        "uploader" => $user->is_uploader() ? $user->is_uploader() : "",
                        "publisher" => $user->is_publisher() ? $user->is_publisher() : "",
                    );
                    if ($array['uploader'] == 1) {
                        $action = $updateButton . " " . $deleteButton;
                    } else if ($array['publisher'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->notice_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $publishButton;
                    } else if ($array['admin'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->notice_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $updateButton . " " . $deleteButton . " " . $publishButton;
                    } else {
                    }
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                } else {
                    $unpublishButton = "<button  title='Un Publish' style='height:30px;margin-left:10px' class='btn btn-sm btn-danger notice_unpublishbtn iconWidth' data-id='" . $rowval->notice_id . "'><i class='fa  fa-eye'></i></button>";
                    $green_text = "<p style='color:green;margin-top:8px'>Published</p></div>";
                    $action =  $green_text . $unpublishButton ;
                }
                $pdfPath = "";
                $pdfLinks = []; // Initialize an array to store the PDF links
                foreach ($noticechildlist as $key => $childlist) {
                    $selected = "";
                    if ($rowval->notice_id == $childlist->notice_id) {
                        $selected = "selected=\"selected\"";
                        $uploadPath = 'notices' . '/' . $childlist->attachment;
                        $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                        // Add the PDF link to the array
                        $pdfLinks[] = "<a href=\"$file_location\" target=\"_blank\">$childlist->pdf_name</a>";
                    }
                }
                // Join the PDF links with commas
                $pdfPath = implode(', ', $pdfLinks);
                $flag = "";
                if ($rowval->p_status == 1) {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true"  style="color:green"></i>';
                } else {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true" style="color:red"></i>';
                }
                $data[] = array(
                    "notice_id" => $rowval->notice_id,
                    "notice_name" => $rowval->notice_name,
                    "category_name" => $rowval->category_name,
                    "pdf_name" => $pdfPath,
                    "effect_from_date" => $rowval->effect_from_date,
                    "effect_to_date" => $rowval->effect_to_date,
                    "p_status" => $flag,
                    "action" => $action,
                );
            }
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            echo json_encode($response);
            exit;
        } //request 1
        // Delete Notice
        if ($request == 4) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new MstNotice();
            $checkId = $model->checkMstNoticeId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $deleteQuery = $model->deleteMstNotice($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Archive Notice
        if ($request == 5) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new MstNotice();
            $checkId = $model->checkMstNoticeId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $archiveQuery = $model->archiveMstNoticeStatus($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Publish Notice
        if ($request == 6) {
            $id = Helpers::cleanData($_POST['id']);
            $notice_data = [
                'p_status' => '1',
            ];
            // Check id
            ## Fetch records
            $model = new MstNotice();
            $checkId = $model->checkMstNoticeId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateMstNoticeState($notice_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Un Publish Notice
        if ($request == 7) {
            $id = Helpers::cleanData($_POST['id']);
            $notice_data = [
                'p_status' => '0',
            ];
            // Check id
            ## Fetch records
            $model = new MstNotice();
            $checkId = $model->checkMstNoticeId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateMstNoticeState($notice_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
    }
    public function ajaxResponseForNoticeDataTableLoad1()
    {
        $request = 1;
        if (isset($_POST['request'])) {
            $request = Helpers::cleanData($_POST['request']);
        }
        if ($request == 1) {
            ## Read value
            $draw = Helpers::cleanData($_POST['draw']);
            $row = Helpers::cleanData($_POST['start']);
            $rowperpage = Helpers::cleanData($_POST['length']); // Rows display per page
            $columnIndex = Helpers::cleanData($_POST['order'][0]['column']); // Column index
            $columnName = Helpers::cleanData($_POST['columns'][$columnIndex]['data']); // Column name
            $columnSortOrder = Helpers::cleanData($_POST['order'][0]['dir']); // asc or desc
            $searchValue = Helpers::cleanData($_POST['search']['value']); // Search value
            ## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = "   notice_name ilike '%" . $searchValue . "%' or 
              c.category_name ilike '%" . $searchValue . "%' or                  
              TO_CHAR(effect_from_date, 'yyyy-mm-dd') like'%" . $searchValue . "%'  or
              TO_CHAR(effect_to_date, 'yyyy-mm-dd') like'%" . $searchValue . "%' 
               ";
            }
            //echo $searchQuery;
            ## Total number of records without filtering
            $model = new MstNotice();
            $year = trim(Helpers::cleanData($_POST['year']));
            $month = trim(Helpers::cleanData($_POST['month']));
            $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
            $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
            ;
            $totalRecordsWithoutFiltering = $model->totalRecordsWithOutFiltering();
            $totalRecords = $totalRecordsWithoutFiltering->allcount;
            ## Total number of records with filtering
            $totalRecordsWithFiltering = $model->totalRecordsWithFiltering($searchQuery);
            $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
            $fetchRecordsObject = $model->getMstNoticeDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery);
            $fetchRecords = (array) $fetchRecordsObject;
            $edit_notice_link = $this->links['edit_notice_link'];
            $data = array();
            foreach ($fetchRecords as $rowval) {
                $edit_notice_link_str = str_replace("{id}", $rowval->notice_id, $edit_notice_link);
                $baseurl = $this->route->site_url($edit_notice_link_str);
                $updateButton = "<a href= '" . $baseurl . "' name='menu_update' class='iconSize'> 
       <button type='button' title='Edit' class='btn btn-secondary iconWidth updateUser'><i class='fas fa-edit'></i></button>
       </a>";
                // Delete Button
                $deleteButton = "<button title='Delete' class='btn btn-sm btn-danger iconWidth deletebtn' style='height:30px'  data-id='" . $rowval->notice_id . "'><i class='fa fa-trash'></i></button>";
                // $archivesButton = "<button  title='Archive' style='height:30px' class='btn btn-sm btn-primary archivebtn' data-id='" . $rowval->notice_id . "'><i class='fa  fa-archive'></i></button>";
                if ($rowval->p_status != 1) {
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                    $user = new User();
                    $loginUser = $user->getUser();
                    $is_superadmin = $user->is_superadmin();
                    $is_admin = $user->is_admin();
                    $is_uploader = $user->is_uploader();
                    $is_publisher = $user->is_publisher();
                    $array = array(
                        "super_admin" => $user->is_superadmin() ? $user->is_superadmin() : "",
                        "admin" => $user->is_admin() ? $user->is_admin() : "",
                        "uploader" => $user->is_uploader() ? $user->is_uploader() : "",
                        "publisher" => $user->is_publisher() ? $user->is_publisher() : "",
                    );
                    if ($array['uploader'] == 1) {
                        $action = $updateButton . " " . $deleteButton . " ";
                    } else if ($array['publisher'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->notice_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $publishButton;
                    } else if ($array['admin'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->notice_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $updateButton . " " . $deleteButton . " " . $publishButton;
                    } else {
                    }
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                } else {
                    $action = "<p style='color:green'>Published</p>";
                }
                $pdfPath = "";
                $selected = "";
                $selected = "selected=\"selected\"";
                $uploadPath = 'notice' . '/' . $rowval->attachment;
                $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                $pdfPath .= <<<TEXT
              <a href="$file_location " rel = "noopener noreferrer" target="_blank">$rowval->pdf_name </a><br>
TEXT;
                $flag = "";
                if ($rowval->p_status == 1) {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true"  style="color:green"></i>';
                } else {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true" style="color:red"></i>';
                }
                $data[] = array(
                    "notice_id" => $rowval->notice_id,
                    "pdf_name" => $rowval->pdf_name,
                    "attachment" => $pdfPath,
                    "category_name" => $rowval->category_name,
                    "effect_from_date" => $rowval->effect_from_date,
                    "effect_to_date" => $rowval->effect_to_date,
                    "p_status" => $flag,
                    "action" => $action,
                );
            }
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            echo json_encode($response);
            exit;
        } //request 1
        // Delete Notice
        if ($request == 4) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new MstNotice();
            $checkId = $model->checkMstNoticeId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $deleteQuery = $model->deleteMstNotice($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Archive Notice
        if ($request == 5) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new MstNotice();
            $checkId = $model->checkMstNoticeId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $archiveQuery = $model->archiveMstNoticeStatus($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Publish Notice
        if ($request == 6) {
            $id = Helpers::cleanData($_POST['id']);
            $notice_data = [
                'p_status' => '1',
            ];
            // Check id
            ## Fetch records
            $model = new MstNotice();
            $checkId = $model->checkMstNoticeId($id);
            echo $checkIdCount = $checkId->checkid;
            exit;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateMstNoticeState($notice_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
    }
    public function commonNoticeArchive()
    {
        if (!empty(Helpers::cleanData($_POST["action"]))) {
            $notice = new MstNotice();
            $notice_list_data = Helpers::cleanData($_POST['ids']);
            if (Helpers::cleanData($_POST["action"]) == 'archive') {
                if ($notice->archiveMstNoticeStatus($notice_list_data)) {
                    $message = " Notice Archived successfully";
                    $message_type = "success";
                }
            } else {
                if ($notice->deleteMstNotice($notice_list_data)) {
                    $message = " Notice  Deleted successfully";
                    $message_type = "success";
                }
            }
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofnotices"));
    }
    /**
     * 
     * Notice
     * 
     */
    /**
     * 
     * Gallery
     * 
     */
    public function ajaxResponseForGalleryDataTableLoad()
    {
        $request = 1;
        if (isset($_POST['request'])) {
            $request = Helpers::cleanData($_POST['request']);
        }
        if ($request == 1) {
            ## Read value
            $draw = Helpers::cleanData($_POST['draw']);
            $row = Helpers::cleanData($_POST['start']);
            $rowperpage = Helpers::cleanData($_POST['length']); // Rows display per page
            $columnIndex = Helpers::cleanData($_POST['order'][0]['column']); // Column index
            $columnName = Helpers::cleanData($_POST['columns'][$columnIndex]['data']); // Column name
            $columnSortOrder = Helpers::cleanData($_POST['order'][0]['dir']); // asc or desc
            $searchValue = Helpers::cleanData($_POST['search']['value']); // Search value
            ## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = "   event_name ilike '%" . $searchValue . "%' or   ";
            }
            //echo $searchQuery;
            ## Total number of records without filtering
            $model = new Gallery();
            $year = trim(Helpers::cleanData($_POST['year']));
            //  $month = trim(Helpers::cleanData($_POST['month']));
            //  $effect_from_date =  date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date']))); 
            //  $effect_to_date =  date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));; 
            $totalRecordsWithoutFiltering = $model->totalRecordsWithOutFiltering($year);
            $totalRecords = $totalRecordsWithoutFiltering->allcount;
            ## Total number of records with filtering
            $totalRecordsWithFiltering = $model->totalRecordsWithFiltering($searchQuery, $year);
            $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
            $fetchRecordsObject = $model->getGalleryDetails($year, $searchQuery);
            $fetchRecords = (array) $fetchRecordsObject;
            $edit_gallery_link = $this->links['edit_gallery_link'];
            $data = array();
            $gallerychildlist = $model->getGallerychild();
            ####  Foreach Start ####
            foreach ($fetchRecords as $rowval) {
                $edit_gallery_link_str = str_replace("{id}", $rowval->gallery_id, $edit_gallery_link);
                $baseurl = $this->route->site_url($edit_gallery_link_str);
                $updateButton = "<a href= '" . $baseurl . "' name='menu_update' class='iconSize'> 
     <button type='button' title='Edit' class='btn btn-secondary iconWidth updateUser'><i class='fas fa-edit'></i></button>
     </a>";
                // Delete Button
                $deleteButton = "<button title='Delete' class='btn btn-sm btn-danger iconWidth deletebtn' style='height:30px'  data-id='" . $rowval->gallery_id . "'><i class='fa fa-trash'></i></button>";
                // $archivesButton = "<button  title='Archive' style='height:30px' class='btn btn-sm btn-primary archivebtn' data-id='" . $rowval->gallery_id . "'><i class='fa  fa-archive'></i></button>";
                if ($rowval->p_status != 1) {
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                    $user = new User();
                    $loginUser = $user->getUser();
                    $is_superadmin = $user->is_superadmin();
                    $is_admin = $user->is_admin();
                    $is_uploader = $user->is_uploader();
                    $is_publisher = $user->is_publisher();
                    $array = array(
                        "super_admin" => $user->is_superadmin() ? $user->is_superadmin() : "",
                        "admin" => $user->is_admin() ? $user->is_admin() : "",
                        "uploader" => $user->is_uploader() ? $user->is_uploader() : "",
                        "publisher" => $user->is_publisher() ? $user->is_publisher() : "",
                    );
                    if ($array['uploader'] == 1) {
                        $action = $updateButton . " " . $deleteButton;
                    } else if ($array['publisher'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->gallery_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $publishButton;
                    } else if ($array['admin'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->gallery_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $updateButton . " " . $deleteButton . " " . $publishButton;
                    } else {
                    }
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                } else {
                   // $action = "<p style='color:green'>Published</p>";
                    $unpublishButton = "<button  title='Un Publish' style='height:24px' class='btn btn-sm btn-danger unpublishbtn iconWidth' data-id='" . $rowval->gallery_id . "'><i class='fa  fa-eye'></i></button>";
                    $green_text = "<p style='color:green'>Published</p>";
                    $action = $green_text . $unpublishButton;
                }
                $pdfPath = "";
                foreach ($gallerychildlist as $key => $childlist) {
                    $selected = "";
                    if ($rowval->gallery_id == $childlist->gallery_id) {
                        $selected = "selected=\"selected\"";
                        $uploadPath = 'gallery' . '/' . $childlist->image_path;
                        $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                        $pdfPath .= <<<TEXT
            <a href="$file_location " rel = "noopener noreferrer"  target="_blank">$childlist->image_path </a>,<br>
TEXT;
                    }
                }
                $flag = "";
                if ($rowval->p_status == 1) {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true"  style="color:green"></i>';
                } else {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true" style="color:red"></i>';
                }
                $data[] = array(
                    "gallery_id" => $rowval->gallery_id,
                    "event_name" => $rowval->event_name,
                    "image_path" => $pdfPath,
                    "p_status" => $flag,
                    "action" => $action,
                );
            }
            ####  Foreach Start ####
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            echo json_encode($response);
            exit;
        } //request 1
        // Delete Notice
        if ($request == 4) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Gallery();
            $checkId = $model->checkGalleryId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $deleteQuery = $model->deleteGallery($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Archive Notice
        if ($request == 5) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Gallery();
            $checkId = $model->checkGalleryId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $archiveQuery = $model->archiveGalleryStatus($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Publish Notice
        if ($request == 6) {
            $id = Helpers::cleanData($_POST['id']);
            $gallery_data = [
                'p_status' => '1',
            ];
            // Check id
            ## Fetch records
            $model = new Gallery();
            $checkId = $model->checkGalleryId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateGalleryState($gallery_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
          // Un Publish Nomination
          if ($request == 7) {
            $id = Helpers::cleanData($_POST['id']);
            $gallery_data = [
                'p_status' => '0',
            ];
            // Check id
            ## Fetch records
            $model = new Gallery();
            $checkId = $model->checkGalleryId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateGalleryState($gallery_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
    }
    public function commonGalleryArchive()
    {
        if (!empty(Helpers::cleanData($_POST["action"]))) {
            $notice = new Gallery();
            $notice_list_data = Helpers::cleanData($_POST['ids']);
            if (Helpers::cleanData($_POST["action"]) == 'archive') {
                if ($notice->archiveGalleryStatus($notice_list_data)) {
                    
                    $message = " Gallery  Archived successfully";
                    $message_type = "success";
                }
            } else {
                if ($notice->deleteGallery($notice_list_data)) {
                    $message = " Gallery  Deleted successfully";
                    $message_type = "success";
                }
            }
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofphotogallery"));
    }
    /**
     * 
     * Gallery
     * 
     */
    /**
     * Author: Stalin
     * 
     * created on : 28-07-2023
     * 
     * Module : Phase Master
     * 
     */
    public function editphasemaster()
    {
        $data = [];
        $this->savephasemaster();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        $phasemaster = new PhaseMaster();
        // chek if the id is available in the params 
        $phaseid = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_phasemaster = $phasemaster->getPhaseMasterby($phaseid, DB_ASSOC);
        $data['current_phasemaster'] = $current_phasemaster;
        $this->prepare_menus($data);
        $this->render("edit-phasemaster", $data);
    }
    private function savephasemaster()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_phase_master'])) {
                $phase_id = isset($_POST['id']) ? $_POST['id'] : 0;
                $creation_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['creation_date'])));
                $phase_master_data = [
                    'phase_name' => Helpers::cleanData($_POST['phase_name']),
                    'creation_date' => $creation_date,
                    'status' => '0'
                ];
                $phasemaster = new \App\Models\PhaseMaster();
                if ($phase_id == 0) { // insert new menu 
                    if ($phasemaster->addPhaseMaster($phase_master_data)) {
                        $message = "Phase Master Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Phase Master ";
                        $message_type = "warning";
                    }
                } else { // update menu
                    if ($phasemaster->updatePhaseMaster($phase_master_data, $phase_id)) {
                        $message = "Phase Master Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Phase Master ";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofphasemaster"));
            }
        }
    }
    public function deletephasemaster()
    {
        $data = [];
        $message = $message_type = "";
        $phase_id = $this->data['params'][0];
        $phasemaster = new PhaseMaster();
        if ($phasemaster->deletePhaseMaster($phase_id)) {
            $message = "Phase Master Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Phase Master ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofphasemaster"));
    }
    /**
     * Author: Stalin
     * 
     * created on : 28-07-2023
     * 
     * Module : Phase Master
     * 
     */
    public function ajaxResponseForAnnouncementDataTableLoad()
    {
        $request = 1;
        if (isset($_POST['request'])) {
            $request = Helpers::cleanData($_POST['request']);
        }
        if ($request == 1) {
            ## Read value
            $draw = Helpers::cleanData($_POST['draw']);
            $row = Helpers::cleanData($_POST['start']);
            $rowperpage = Helpers::cleanData($_POST['length']); // Rows display per page
            $columnIndex = Helpers::cleanData($_POST['order'][0]['column']); // Column index
            $columnName = Helpers::cleanData($_POST['columns'][$columnIndex]['data']); // Column name
            $columnSortOrder = Helpers::cleanData($_POST['order'][0]['dir']); // asc or desc
            $searchValue = Helpers::cleanData($_POST['search']['value']); // Search value
            ## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = "   pdf_name ilike '%" . $searchValue . "%' or 
             TO_CHAR(effect_from_date, 'yyyy-mm-dd') like'%" . $searchValue . "%'  or
             TO_CHAR(effect_to_date, 'yyyy-mm-dd') like'%" . $searchValue . "%' 
              ";
            }
            ## Total number of records without filtering
            $model = new Announcements();
            $year = trim(Helpers::cleanData($_POST['year']));
            $month = trim(Helpers::cleanData($_POST['month']));
            $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
            $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
            ;
            $totalRecordsWithoutFiltering = $model->totalRecordsWithOutFiltering();
            $totalRecords = $totalRecordsWithoutFiltering->allcount;
            ## Total number of records with filtering
            $totalRecordsWithFiltering = $model->totalRecordsWithFiltering($searchQuery);
            $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
            if($rowperpage == -1){
                $fetchRecordsObject = $model->getAnnouncementDetailsAll($year, $month, $effect_from_date, $effect_to_date, $searchQuery);
            }else{
                $fetchRecordsObject = $model->getAnnouncementDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery,$row,$rowperpage);
 
            }
            $fetchRecords = (array) $fetchRecordsObject;
            $edit_announcement_link = $this->links['edit_announcement_link'];
            $data = array();
            foreach ($fetchRecords as $rowval) {
                $edit_announcement_link_str = str_replace("{id}", $rowval->announcement_id, $edit_announcement_link);
                $baseurl = $this->route->site_url($edit_announcement_link_str);
                $updateButton = "<a href= '" . $baseurl . "' name='menu_update' class='iconSize'> 
      <button type='button' title='Edit' class='btn btn-secondary iconWidth updateUser'><i class='fas fa-edit'></i></button>
      </a>";
                // Delete Button
                $deleteButton = "<button title='Delete' class='btn btn-sm btn-danger iconWidth deletebtn' style='height:30px'  data-id='" . $rowval->announcement_id . "'><i class='fa fa-trash'></i></button>";
                //$archivesButton = "<button  title='Archive' style='height:30px' class='btn btn-sm btn-primary archivebtn' data-id='" . $rowval->announcement_id . "'><i class='fa  fa-archive'></i></button>";
                if ($rowval->p_status != 1) {
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                    $user = new User();
                    $loginUser = $user->getUser();
                    $is_superadmin = $user->is_superadmin();
                    $is_admin = $user->is_admin();
                    $is_uploader = $user->is_uploader();
                    $is_publisher = $user->is_publisher();
                    $array = array(
                        "super_admin" => $user->is_superadmin() ? $user->is_superadmin() : "",
                        "admin" => $user->is_admin() ? $user->is_admin() : "",
                        "uploader" => $user->is_uploader() ? $user->is_uploader() : "",
                        "publisher" => $user->is_publisher() ? $user->is_publisher() : "",
                    );
                    if ($array['uploader'] == 1) {
                        $action = $updateButton . " " . $deleteButton;
                    } else if ($array['publisher'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->announcement_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $publishButton;
                    } else if ($array['admin'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->announcement_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $updateButton . " " . $deleteButton . " " . $publishButton;
                    } else {
                    }
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                } else {
                    //$action = "<p style='color:green'>Published</p>";
                    $unpublishButton = "<button  title='Un Publish' style='height:24px' class='btn btn-sm btn-danger unpublishbtn iconWidth' data-id='" . $rowval->announcement_id . "'><i class='fa  fa-eye'></i></button>";
                    $green_text = "<p style='color:green'>Published</p>";
                    $action = $green_text . $unpublishButton;
                }
                $data[] = array(
                    "announcement_id" => $rowval->announcement_id,
                    "announcement_name" => $rowval->announcement_name,
                    "announcement_content" => $rowval->announcement_content,
                    "effect_from_date" => $rowval->effect_from_date,
                    "effect_to_date" => $rowval->effect_to_date,
                    "action" => $action,
                );
            }
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            echo json_encode($response);
            exit;
        } //request 1
        // Che
        // Delete Announcement
        if ($request == 4) {
            $id = Helpers::cleanData($_POST['id']);
            // echo $id;
            // exit;
            // Check id
            ## Fetch records
            $model = new Announcements();
            $checkId = $model->checkAnnouncementId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $deleteQuery = $model->deleteAnnouncement($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Archive Announcement
        if ($request == 5) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Announcements();
            $checkId = $model->checkAnnouncementId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $archiveQuery = $model->archiveAnnouncementStatus($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Publish Announcement
        if ($request == 6) {
            $id = Helpers::cleanData($_POST['id']);
            $announcement_data = [
                'p_status' => '1',
            ];
            // Check id
            ## Fetch records
            $model = new Announcements();
            $checkId = $model->checkAnnouncementId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateAnnouncementState($announcement_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }

          // Un Publish Nomination
          if ($request == 7) {
            $id = Helpers::cleanData($_POST['id']);
            $announcement_data = [
                'p_status' => '0',
            ];
            // Check id
            ## Fetch records
            $model = new Announcements();
            $checkId = $model->checkAnnouncementId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateAnnouncementState($announcement_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }

    }
    public function editAnnouncements()
    {
        $data = [];
        $this->saveAnnouncement();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        $announcementlists = new Announcements();
        // chek if the id is available in the params 
        $announcement_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_announcement = $announcementlists->getAnnouncementby($announcement_id, DB_ASSOC);
        $data['current_announcement'] = $current_announcement;
        $this->prepare_menus($data);
        $this->render("edit-announcements", $data);
    }
    private function saveAnnouncement()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_announcement'])) {
                $announcement_id = isset($_POST['announcement_id']) ? $_POST['announcement_id'] : 0;
                $announcement_name = $_POST['announcement_name'];
                $announcement_content = $_POST['announcement_content'];
                $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
                $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
                $announcementlist_data = [
                    "announcement_name" => $announcement_name,
                    "announcement_content" => $announcement_content,
                    "effect_from_date" => $effect_from_date,
                    "effect_to_date" => $effect_to_date,
                    'creation_date' => date('Y-m-d H:i:s'),
                ];
                $announcement = new \App\Models\Announcements();
                if ($announcement_id == 0) { // insert new menu 
                    if ($announcement->addAnnouncement($announcementlist_data)) {
                        $message = "Announcement  Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Announcement";
                        $message_type = "warning";
                    }
                } else { // update menu
                    if ($announcement->updateAnnouncement($announcementlist_data, $announcement_id)) {
                        $message = "Announcement Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Announcement";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofannouncements"));
            }
        }
    }
    public function deleteAnnouncement()
    {
        $data = [];
        $message = $message_type = "";
        $announcement_id = $this->data['params'][0];
        $announcement = new Announcements();
        if ($announcement->deleteAnnouncementStatus($announcement_id)) {
            $message = "Announcement   Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting announcement ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=announcement_archieves_by_month"));
    }
    public function archiveAnnouncement()
    {
        $data = [];
        $message = $message_type = "";
        $announcement_id = $this->data['params'][0];
        $announcement = new Announcements();
        if ($announcement->archiveAnnouncementStatus($announcement_id)) {
            $message = "Announcement   Archived successfully";
            $message_type = "success";
        } else {
            $message = "Error Archiving Announcement ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=announcement_archieves_by_month"));
    }
    public function commonAnnouncementArchive()
    {
        if (!empty(Helpers::cleanData($_POST["action"]))) {
            $announcement = new Announcements();
            $announcement_list_data = Helpers::cleanData($_POST['ids']);
            // echo '<pre>';
            // print_r($_POST);
            // exit;
            if (Helpers::cleanData($_POST["action"]) == 'archive') {
                if ($announcement->archiveAnnouncementStatus($announcement_list_data)) {
                    $message = " Announcements Archived successfully";
                    $message_type = "success";
                }
            } else {
                if ($announcement->deleteAnnouncement($announcement_list_data)) {
                    $message = " Announcements  Deleted successfully";
                    $message_type = "success";
                }
            }
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofannouncements"));
    }
    /*****
     * 
     * 
     * Debarred List 
     * 
     */
    public function ajaxResponseForDlistDataTableLoad()
    {
        $request = 1;
        if (isset($_POST['request'])) {
            $request = Helpers::cleanData($_POST['request']);
        }
        if ($request == 1) {
            ## Read value
            $draw = Helpers::cleanData($_POST['draw']);
            $row = Helpers::cleanData($_POST['start']);
            $rowperpage = Helpers::cleanData($_POST['length']); // Rows display per page
            $columnIndex = Helpers::cleanData($_POST['order'][0]['column']); // Column index
            $columnName = Helpers::cleanData($_POST['columns'][$columnIndex]['data']); // Column name
            $columnSortOrder = Helpers::cleanData($_POST['order'][0]['dir']); // asc or desc
            $searchValue = Helpers::cleanData($_POST['search']['value']); // Search value
            ## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = "   pdf_name ilike '%" . $searchValue . "%'  
               ";
            }
            ## Total number of records without filtering
            $model = new Debarredlists();
            $year = trim(Helpers::cleanData($_POST['year']));
            $month = trim(Helpers::cleanData($_POST['month']));
            $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
            $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
            ;
            $totalRecordsWithoutFiltering = $model->totalRecordsWithOutFiltering();
            $totalRecords = $totalRecordsWithoutFiltering->allcount;
            ## Total number of records with filtering
            $totalRecordsWithFiltering = $model->totalRecordsWithFiltering($searchQuery);
            $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
            if($rowperpage == -1){
                $fetchRecordsObject = $model->getDlistDetailsAll($year, $month, $effect_from_date, $effect_to_date, $searchQuery);

            }else{
                $fetchRecordsObject = $model->getDlistDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery,$row,$rowperpage);

            }
            $fetchRecords = (array) $fetchRecordsObject;
            $edit_debarred_lists_link = $this->links['edit_debarred_lists_link'];
            $data = array();
            foreach ($fetchRecords as $rowval) {
                $edit_debarred_lists_link_str = str_replace("{id}", $rowval->debarred_lists_id, $edit_debarred_lists_link);
                $baseurl = $this->route->site_url($edit_debarred_lists_link_str);
                $updateButton = "<a href= '" . $baseurl . "' name='menu_update' class='iconSize'> 
       <button type='button' title='Edit' class='btn btn-secondary iconWidth updateUser'><i class='fas fa-edit'></i></button>
       </a>";
                // Delete Button
                $deleteButton = "<button title='Delete' class='btn btn-sm btn-danger iconWidth deletebtn' style='height:30px'  data-id='" . $rowval->debarred_lists_id . "'><i class='fa fa-trash'></i></button>";
                //$archivesButton = "<button  title='Archive' style='height:30px' class='btn btn-sm btn-primary archivebtn' data-id='" . $rowval->debarred_lists_id . "'><i class='fa  fa-archive'></i></button>";
                if ($rowval->p_status != 1) {
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                    $user = new User();
                    $loginUser = $user->getUser();
                    $is_superadmin = $user->is_superadmin();
                    $is_admin = $user->is_admin();
                    $is_uploader = $user->is_uploader();
                    $is_publisher = $user->is_publisher();
                    $array = array(
                        "super_admin" => $user->is_superadmin() ? $user->is_superadmin() : "",
                        "admin" => $user->is_admin() ? $user->is_admin() : "",
                        "uploader" => $user->is_uploader() ? $user->is_uploader() : "",
                        "publisher" => $user->is_publisher() ? $user->is_publisher() : "",
                    );
                    if ($array['uploader'] == 1) {
                        $action = $updateButton . " " . $deleteButton . " ";
                    } else if ($array['publisher'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->debarred_lists_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $publishButton;
                    } else if ($array['admin'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->debarred_lists_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $updateButton . " " . $deleteButton . " " . $publishButton;
                    } else {
                    }
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                } else {
                    // $action = "<p style='color:green'>Published</p>";
                    $unpublishButton = "<button  title='Unpublish' style='height:24px' class='btn btn-sm btn-danger dl_unpublishbtn iconWidth' data-id='" . $rowval->debarred_lists_id . "'><i class='fa  fa-eye'></i></button>";
                    $green_text = "<p style='color:green'>Published</p>";
                    $action = $green_text . $unpublishButton;
                }
                $pdfPath = "";
                $selected = "";
                $selected = "selected=\"selected\"";
                $uploadPath = 'debarredlists' . '/' . $rowval->attachment;
                $file_location = $this->route->get_base_url() . "/" . $uploadPath;
                $pdfPath .= <<<TEXT
              <a href="$file_location " rel = "noopener noreferrer"  target="_blank">$rowval->pdf_name </a><br>
TEXT;
                $flag = "";
                if ($rowval->p_status == 1) {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true"  style="color:green"></i>';
                } else {
                    $flag .= '<i class="fa fa-flag" aria-hidden="true" style="color:red"></i>';
                }
                $data[] = array(
                    "debarred_lists_id" => $rowval->debarred_lists_id,
                    "pdf_name" => $rowval->pdf_name,
                    "attachment" => $pdfPath,
                    "effect_from_date" => $rowval->effect_from_date,
                    "effect_to_date" => $rowval->effect_to_date,
                    "p_status" => $flag,
                    "action" => $action,
                );
            }
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            echo json_encode($response);
            exit;
        } //request 1
        // Delete Dlist
        if ($request == 4) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Debarredlists();
            $checkId = $model->checkDlistId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $deleteQuery = $model->deleteDlist($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Archive Dlist
        if ($request == 5) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Debarredlists();
            $checkId = $model->checkDlistId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $archiveQuery = $model->archiveDlistStatus($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Publish Dlist
        if ($request == 6) {
            $id = Helpers::cleanData($_POST['id']);
            $dlist_data = [
                'p_status' => '1',
            ];
            // Check id
            ## Fetch records
            $model = new Debarredlists();
            $checkId = $model->checkDlistId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateDlistState($dlist_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Unpublish Dlist
        if ($request == 7) {
            $id = Helpers::cleanData($_POST['id']);
            $dlist_data = [
                'p_status' => '0',
            ];
            // Check id
            ## Fetch records
            $model = new Debarredlists();
            $checkId = $model->checkDlistId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateDlistState($dlist_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
    }
    public function commonDlistArchive()
    {
        if (!empty(Helpers::cleanData($_POST["action"]))) {
            $dlist = new Debarredlists();
            $dlist_list_data = Helpers::cleanData($_POST['ids']);
            if (Helpers::cleanData($_POST["action"]) == 'archive') {
                if ($dlist->archiveDlistStatus($dlist_list_data)) {
                    $message = " Debarred List Archived successfully";
                    $message_type = "success";
                }
            } else {
                if ($dlist->deleteDlist($dlist_list_data)) {
                    $message = " Debarred List   Deleted successfully";
                    $message_type = "success";
                }
            }
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listdebarredlists"));
    }
    /*****
     * 
     * 
     * Debarredlists 
     * 
     */
    //search Year
    public function editsearchyear()
    {
        $data = [];
        $this->savesearchyear();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        $searchyear = new SearchYear();
        // chek if the id is available in the params 
        $searchyear_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_searchyear = $searchyear->getSearchyearby($searchyear_id, DB_ASSOC);
        $data['current_searchyear'] = $current_searchyear;
        $this->prepare_menus($data);
        $this->render("edit-searchyear", $data);
    }
    private function savesearchyear()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_searchyear'])) {
                $searchyear_id = isset($_POST['searchyear_id']) ? $_POST['searchyear_id'] : 0;
                $creation_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['creation_date'])));
                $searchyear_data = [
                    'search_year' => Helpers::cleanData($_POST['search_year']),
                    'creation_date' => $creation_date,
                    'status' => '0'
                ];
                $searchyear = new \App\Models\SearchYear();
                if ($searchyear_id == 0) { // insert new menu 
                    //  echo "@@@";
                    if ($searchyear->addSearchyear($searchyear_data)) {
                        $message = "Search Year Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Search Year ";
                        $message_type = "warning";
                    }
                } else { // update menu
                    // echo '####';
                    if ($searchyear->updateSearchyear($searchyear_data, $searchyear_id)) {
                        $message = "Search Year Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Search Year ";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofsearchyear"));
            }
        }
    }
    public function deletesearchyear()
    {
        $data = [];
        $message = $message_type = "";
        $searchyear_id = $this->data['params'][0];
        $searchyear = new \App\Models\SearchYear();
        if ($searchyear->deleteSearchyear($searchyear_id)) {
            $message = "Search Year Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Search Year ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofsearchyear"));
    }
    public function ajaxresponseforsearchyear()
    {
        $searchyear_id = htmlspecialchars($_POST['searchyear_id']);
        // echo $cid;
        $searchyear = new SearchYear();
        $searchyear_data = [
            'status' => '1',
        ];
        if ($searchyear->updateSearchYearState($searchyear_data, $searchyear_id)) {
            $message = 1;
            $message_title = "Search Year Published successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    public function ajaxresponseforsearchyearunpublish()
    {
        $searchyear_id = htmlspecialchars($_POST['searchyear_id']);
        // echo $cid;
        $searchyear = new SearchYear();
        $searchyear_data = [
            'status' => '0',
        ];
        if ($searchyear->updateSearchYearState($searchyear_data, $searchyear_id)) {
            $message = 1;
            $message_title = "Search Year UnPublished Successfully";
            $message_type = "success";
            header('Content-Type: application/json');
            $_SESSION['notification'] = ['message' => $message_title, 'message_type' => $message_type];
            echo json_encode(array("message" => $message));
        }
    }
    /**
     * Author: Stalin Thomas
     * 
     * created on : 26-10-2023
     * 
     * Module : Important instructions Master
     * 
     */
    public function ajaxResponseForInstructionsDataTableLoad()
    {
        $request = 1;
        if (isset($_POST['request'])) {
            $request = Helpers::cleanData($_POST['request']);
        }
        if ($request == 1) {
            ## Read value
            $draw = Helpers::cleanData($_POST['draw']);
            $row = Helpers::cleanData($_POST['start']);
            $rowperpage = Helpers::cleanData($_POST['length']); // Rows display per page
            $columnIndex = Helpers::cleanData($_POST['order'][0]['column']); // Column index
            $columnName = Helpers::cleanData($_POST['columns'][$columnIndex]['data']); // Column name
            $columnSortOrder = Helpers::cleanData($_POST['order'][0]['dir']); // asc or desc
            $searchValue = Helpers::cleanData($_POST['search']['value']); // Search value
            ## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = "   pdf_name ilike '%" . $searchValue . "%' or 
            TO_CHAR(effect_from_date, 'yyyy-mm-dd') like'%" . $searchValue . "%'  or
            TO_CHAR(effect_to_date, 'yyyy-mm-dd') like'%" . $searchValue . "%' 
             ";
            }
            ## Total number of records without filtering
            $model = new Instructions();
            $year = trim(Helpers::cleanData($_POST['year']));
            $month = trim(Helpers::cleanData($_POST['month']));
            $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
            $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
            ;
            $totalRecordsWithoutFiltering = $model->totalRecordsWithOutFiltering();
            $totalRecords = $totalRecordsWithoutFiltering->allcount;
            ## Total number of records with filtering
            $totalRecordsWithFiltering = $model->totalRecordsWithFiltering($searchQuery);
            $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
            $fetchRecordsObject = $model->getInstructionsDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery);
            $fetchRecords = (array) $fetchRecordsObject;
            $edit_instructions_link = $this->links['edit_instructions_link'];
            $data = array();
            foreach ($fetchRecords as $rowval) {
                $edit_instructions_link_str = str_replace("{id}", $rowval->ins_id, $edit_instructions_link);
                $baseurl = $this->route->site_url($edit_instructions_link_str);
                $updateButton = "<a href= '" . $baseurl . "' name='menu_update' class='iconSize'> 
     <button type='button' title='Edit' class='btn btn-secondary iconWidth updateUser'><i class='fas fa-edit'></i></button>
     </a>";
                // Delete Button
                $deleteButton = "<button title='Delete' class='btn btn-sm btn-danger iconWidth deletebtn' style='height:30px'  data-id='" . $rowval->ins_id . "'><i class='fa fa-trash'></i></button>";
                //$archivesButton = "<button  title='Archive' style='height:30px' class='btn btn-sm btn-primary archivebtn' data-id='" . $rowval->ins_id . "'><i class='fa  fa-archive'></i></button>";
                if ($rowval->p_status != 1) {
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                    $user = new User();
                    $loginUser = $user->getUser();
                    $is_superadmin = $user->is_superadmin();
                    $is_admin = $user->is_admin();
                    $is_uploader = $user->is_uploader();
                    $is_publisher = $user->is_publisher();
                    $array = array(
                        "super_admin" => $user->is_superadmin() ? $user->is_superadmin() : "",
                        "admin" => $user->is_admin() ? $user->is_admin() : "",
                        "uploader" => $user->is_uploader() ? $user->is_uploader() : "",
                        "publisher" => $user->is_publisher() ? $user->is_publisher() : "",
                    );
                    if ($array['uploader'] == 1) {
                        $action = $updateButton . " " . $deleteButton;
                    } else if ($array['publisher'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->ins_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $publishButton;
                    } else if ($array['admin'] == 1) {
                        $publishButton = "<button  title='Publish' style='height:30px' class='btn btn-sm btn-success publishbtn iconWidth' data-id='" . $rowval->ins_id . "'><i class='fa  fa-eye'></i></button>";
                        $action = $updateButton . " " . $deleteButton . " " . $publishButton;
                    } else {
                    }
                    /****
                     * Role Checking
                     * 
                     * 
                     */
                } else {
                    //$action = "<p style='color:green'>Published</p>";
                    $unpublishButton = "<button  title='Un Publish' style='height:24px' class='btn btn-sm btn-danger unpublishbtn iconWidth' data-id='" . $rowval->ins_id . "'><i class='fa  fa-eye'></i></button>";
                    $green_text = "<p style='color:green'>Published</p>";
                    $action = $green_text . $unpublishButton;
                }
                $data[] = array(
                    "ins_id" => $rowval->ins_id,
                    "ins_name" => $rowval->ins_name,
                    "ins_content" => $rowval->ins_content,
                    "effect_from_date" => $rowval->effect_from_date,
                    "effect_to_date" => $rowval->effect_to_date,
                    "action" => $action,
                );
            }
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            echo json_encode($response);
            exit;
        } //request 1
        // Che
        // Delete Instructions
        if ($request == 4) {
            $id = Helpers::cleanData($_POST['id']);
            // echo $id;
            // exit;
            // Check id
            ## Fetch records
            $model = new Instructions();
            $checkId = $model->checkInstructionsId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $deleteQuery = $model->deleteInstructions($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Archive Instructions
        if ($request == 5) {
            $id = Helpers::cleanData($_POST['id']);
            // Check id
            ## Fetch records
            $model = new Instructions();
            $checkId = $model->checkInstructionsId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $archiveQuery = $model->archiveInstructionsStatus($id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // Publish Instructions
        if ($request == 6) {
            $id = Helpers::cleanData($_POST['id']);
            $ins_data = [
                'p_status' => '1',
            ];
            // Check id
            ## Fetch records
            $model = new Instructions();
            $checkId = $model->checkInstructionsId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateInstructionsState($ins_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        // UnPublish Instructions
        if ($request == 7) {
            $id = Helpers::cleanData($_POST['id']);
            $ins_data = [
                'p_status' => '0',
            ];
            // Check id
            ## Fetch records
            $model = new Instructions();
            $checkId = $model->checkInstructionsId($id);
            $checkIdCount = $checkId->checkid;
            if ($checkIdCount > 0) {
                $publishQuery = $model->updateInstructionsState($ins_data, $id);
                echo 1;
                exit;
            } else {
                echo 0;
                exit;
            }
        }
    }
    public function editInstructions()
    {
        $data = [];
        $this->saveInstructions();
        $user = new User();
        $loginUser = $user->getUser();
        ########  Role checking ########
        $is_superadmin = $user->is_superadmin(); // super admin 
        $data['is_superadmin'] = $is_superadmin; // super admin 
        $is_admin = $user->is_admin(); // admin 
        $data['is_admin'] = $is_admin; // admin 
        $is_uploader = $user->is_uploader(); //uploader
        $data['is_uploader'] = $is_uploader; //uploader
        $is_publisher = $user->is_publisher(); // publisher
        $data['is_publisher'] = $is_publisher; // publisher
        ########  Role Checking ########
        $data['logged_user'] = $loginUser;
        $instructionslists = new Instructions();
        // chek if the id is available in the params 
        $ins_id = (isset($this->data['params'][0])) ? $this->data['params'][0] : 0;
        $current_instructions = $instructionslists->getInstructionsby($ins_id, DB_ASSOC);
        $data['current_instructions'] = $current_instructions;
        $this->prepare_menus($data);
        $this->render("edit-instructions", $data);
    }
    private function saveInstructions()
    {
        $message = $message_type = "";
        if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if (isset($_POST['save_instructions'])) {
                $ins_id = isset($_POST['ins_id']) ? $_POST['ins_id'] : 0;
                $ins_name = $_POST['ins_name'];
                $ins_content = $_POST['ins_content'];
                $effect_from_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_from_date'])));
                $effect_to_date = date('Y-m-d', strtotime(Helpers::cleanData($_POST['effect_to_date'])));
                $instructionslist_data = [
                    "ins_name" => $ins_name,
                    "ins_content" => $ins_content,
                    "effect_from_date" => $effect_from_date,
                    "effect_to_date" => $effect_to_date,
                    'creation_date' => date('Y-m-d H:i:s'),
                ];
                $instructions = new \App\Models\Instructions();
                if ($ins_id == 0) { // insert new menu 
                    if ($instructions->addInstructions($instructionslist_data)) {
                        $message = "Instructions  Added successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error adding Instructions";
                        $message_type = "warning";
                    }
                } else { // update menu
                    if ($instructions->updateInstructions($instructionslist_data, $ins_id)) {
                        $message = "Instructions Updated successfully";
                        $message_type = "success";
                    } else {
                        $message = "Error updating Instructions";
                        $message_type = "warning";
                    }
                }
                $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
                $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofinstructions"));
            }
        }
    }
    public function deleteInstructions()
    {
        $data = [];
        $message = $message_type = "";
        $ins_id = $this->data['params'][0];
        $instructions = new Instructions();
        if ($instructions->deleteInstructionsStatus($ins_id)) {
            $message = "Instructions   Deleted successfully";
            $message_type = "success";
        } else {
            $message = "Error deleting Instructions ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=instructions_archieves_by_month"));
    }
    public function archiveInstructions()
    {
        $data = [];
        $message = $message_type = "";
        $ins_id = $this->data['params'][0];
        $instructions = new Instructions();
        if ($instructions->archiveInstructionsStatus($ins_id)) {
            $message = "Instructions   Archived successfully";
            $message_type = "success";
        } else {
            $message = "Error Archiving Instructions ";
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=instructions_archieves_by_month"));
    }
    public function commonInstructionsArchive()
    {
        if (!empty(Helpers::cleanData($_POST["action"]))) {
            $instructions = new Instructions();
            $instructions_list_data = Helpers::cleanData($_POST['ids']);
            // echo '<pre>';
            // print_r($_POST);
            // exit;
            if (Helpers::cleanData($_POST["action"]) == 'archive') {
                if ($instructions->archiveInstructionsStatus($instructions_list_data)) {
                    $message = " Instructions Archived successfully";
                    $message_type = "success";
                }
            } else {
                if ($instructions->deleteInstructions($instructions_list_data)) {
                    $message = " Instructions  Deleted successfully";
                    $message_type = "success";
                }
            }
        }
        $_SESSION['notification'] = ['message' => $message, 'message_type' => $message_type];
        $this->route->redirect($this->route->site_url("Admin/dashboard/?action=listofinstructions"));
    }
    /**
     * Author: Stalin Thomas
     * 
     * created on : 26-10-2023
     * 
     * Module : Important instructions Master
     * 
     */
}
