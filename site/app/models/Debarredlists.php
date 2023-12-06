<?php
namespace App\Models;
use App\System\DB\DB;
use App\System\Route;
class Debarredlists extends DB
{
    private $table_name = 'debarredliststbl';
    public function __construct()
    {
        parent::__construct('debarredliststbl', 'debarred_lists_id');
    }
    public function getDlists($parent_id = 0)
    {
        $pages = $this->select()
            ->from($this->table_name)
            ->order_by("debarred_lists_id desc")
            ->get_list();
        return $pages;
    }
    public function getDlist($id = 0, $type = null)
    {
        if ($id == 0) {
            return $this->getEmptyDlist($type);
        } else {
            return $this->select()->from($this->table_name)->where(['debarred_lists_id' => $id])->get_one($type);
        }
    }
    // public function getMenuByAlias($alias)
    // {
    //     echo $alias . " ===";
    //     $menu =  $this->select()->from($this->table_name)->where(['m_menu_link' => $alias])->get_one();
    //     echo $this->last_query;
    //     return $menu;
    // }
    public function getEmptyDlist($type = null)
    {
        $empty_menu  = [
            'debarred_lists_id' => 0,
            'pdf_name' => '',
            'attachment' => '',
			'effect_from_date' => '',
			'effect_to_date' => '',
            'status' => '',
        ];
        if ($type == DB_OBJECT) {
            $empty_menu = (object) $empty_menu;
        }
        return $empty_menu;
    }
    public function addDlist($data = array())
    {
        return $this->insert($data);
    }
    public function updateDlist($data = array(), $id = 0)
    {
        return $this->update($data, ['debarred_lists_id' => $id]);
    }
    public function getCountAdmitcard($app_no, $dob,$examname)
    {
        $app_no = $this->cleanData($app_no );
        $getcandidaterecord  = $this->select("count(*)")
        ->from("ssc_candidate_details_by_exam")
        ->where(['app_no' => $app_no])
        ->get_one();
        return $getcandidaterecord;
    }
	public function getDebarredLists(){
		$dlist  = $this->select()
				   ->from("debarredliststbl")
				   ->where(['p_status' => '1'])
				    ->order_by("debarred_lists_id desc")
				   ->get_list();
        return $dlist;
	}
	// Publish and Unpublished
	 public function updateDebarredlistState($data = array(), $id = 0)
    {
        return $this->update($data, ['debarred_lists_id' => $id]);
    }
    function cleanData($val)
    {
        return pg_escape_string($val);
    }
    public function deleteDebarredList($dl_id = 0)
    {
        $delete_row = $this->delete($dl_id);
       return $delete_row;
    }
    public function totalRecordsWithOutFiltering()
   {
       $fetch_all =  $this->select('count(*) as allcount')
           ->from("debarredliststbl")
           ->get_one();
       $count = $fetch_all;
       return $count;
   }
   public function totalRecordsWithFiltering($searchQuery)
   {
       if ($searchQuery == " ") {
           $finalquery = <<<HTML
     '1'
HTML;
       }
       else{
           $finalquery = <<<HTML
           '1' and $searchQuery
HTML;
       }
       $fetch_all =  $this->select('count(*) as allcount')
           ->from("debarredliststbl")
           ->whereconditiondatatable($finalquery)
           ->get_one();
       $count = $fetch_all;
       return $count;
   }
   public function getDlistDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery,$row,$rowperpage)
   {
       if ($month == 'All') {
           if ($searchQuery == " ") {
               $str = <<<TEXT
               to_char("effect_to_date", 'YYYY')='$year'
TEXT;
           } else {
               $str = <<<TEXT
               to_char("effect_to_date", 'YYYY')='$year' and  $searchQuery
TEXT;
           }
           $getlist =  $this->select('*')
               ->from("public.debarredliststbl")
               ->whereconditionarchieves($str)
               ->order_by('effect_from_date desc')
            ->limitPagination($rowperpage,$row)
               ->get_list();
       } else {
           if ($searchQuery == " ") {
               $str = <<<TEXT
               to_char("effect_to_date", 'MM')='$month' and
               to_char("effect_to_date", 'YYYY')='$year' and
               effect_from_date >='$effect_from_date' and
               effect_to_date <= '$effect_to_date'
TEXT;
           }
           else{
               $str = <<<TEXT
               to_char("effect_to_date", 'MM')='$month' and
               to_char("effect_to_date", 'YYYY')='$year' and
               effect_from_date >='$effect_from_date' and
               effect_to_date <= '$effect_to_date'  $searchQuery
TEXT;
           }
           $getlist =  $this->select('*')
               ->from("public.debarredliststbl")
               ->whereconditionarchieves($str)
               ->order_by('effect_from_date desc')
               ->limitPagination($rowperpage,$row)
               ->get_list();
       }
       return  $getlist;
   }
   public function getDlistDetailsAll($year, $month, $effect_from_date, $effect_to_date, $searchQuery)
   {
       if ($month == 'All') {
           if ($searchQuery == " ") {
               $str = <<<TEXT
               to_char("effect_to_date", 'YYYY')='$year'
TEXT;
           } else {
               $str = <<<TEXT
               to_char("effect_to_date", 'YYYY')='$year' and  $searchQuery
TEXT;
           }
           $getlist =  $this->select('*')
               ->from("public.debarredliststbl")
               ->whereconditionarchieves($str)
               ->order_by('effect_from_date desc')
               ->get_list();
       } else {
           if ($searchQuery == " ") {
               $str = <<<TEXT
               to_char("effect_to_date", 'MM')='$month' and
               to_char("effect_to_date", 'YYYY')='$year' and
               effect_from_date >='$effect_from_date' and
               effect_to_date <= '$effect_to_date'
TEXT;
           }
           else{
               $str = <<<TEXT
               to_char("effect_to_date", 'MM')='$month' and
               to_char("effect_to_date", 'YYYY')='$year' and
               effect_from_date >='$effect_from_date' and
               effect_to_date <= '$effect_to_date'  $searchQuery
TEXT;
           }
           $getlist =  $this->select('*')
               ->from("public.debarredliststbl")
               ->whereconditionarchieves($str)
               ->order_by('effect_from_date desc')
               ->get_list();
       }
       return  $getlist;
   }
   public function checkDlistId($id)
   {
       $fetch_all =  $this->select('count(*) as checkid')
           ->from("debarredliststbl")
           ->where(['debarred_lists_id' => $id])
           ->get_one();
       $count = $fetch_all;
       return $count;
   }
   public function archiveDlistStatus($dlist_id = 0)
   {
       if (is_array($dlist_id)) {
           $dlist_id = implode(",", $dlist_id);
       }
       $inIDS = explode(",", $dlist_id);
       $qMarks = str_repeat('?,', count($inIDS) - 1) . '?';
       $sql = "INSERT INTO archives.dlistarchivestbl (debarred_lists_id, pdf_name,effect_from_date, effect_to_date, p_status, date_archived ) 
       SELECT debarred_lists_id, pdf_name,effect_from_date, effect_to_date, '0', NOW()
      FROM public.debarredliststbl WHERE debarred_lists_id IN ( $qMarks )";
       $delete_row = $this->insert_archieves($sql, $inIDS);
       $delId = explode(",", $dlist_id);
       foreach ($delId as $val) {
           $this->delete($val);
       }
       return $delete_row;
   }
   public function deleteDlist($dlist_id = 0)
    {
    $delId = explode(",", $dlist_id);
    foreach ($delId as $val) {
        $delete_row =  $this->delete($val);
    }
    return $delete_row;
    }
    public function updateDlistState($data = array(), $id = 0)
    {
        return $this->update($data, ['debarred_lists_id' => $id]);
    }
}
