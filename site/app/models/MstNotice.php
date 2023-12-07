<?php

namespace App\Models;

use App\System\DB\DB;
use App\System\Route;

class MstNotice extends DB
{
    private $table_name = 'public.mstnoticetbl';
    public function __construct()
    {
        parent::__construct('public.mstnoticetbl', 'notice_id');
    }
    public function getMstNotices($parent_id = 0)
    {
        $result = $this->select()
            ->from($this->table_name)
            ->get_list();
        return $result;
    }
    public function getMstNotice($id = 0, $type = null)
    {
        if ($id == 0) {
            return $this->getEmptyMstNotice($type);
        } else {
            return $this->select()->from($this->table_name)->where(['notice_id' => $id])->get_one($type);
        }
    }
    public function getEmptyMstNotice($type = null)
    {
        $empty_menu  = [
            'notice_id' => 0,
            'notice_name' => '',
            'effect_from_date' => '',
            'creation_date' => '',
            'effect_to_date' => '',

            'p_status ' => '',
            'category_id ' => '',
        ];
        if ($type == DB_OBJECT) {
            $empty_menu = (object) $empty_menu;
        }
        return $empty_menu;
    }
    public function addMstNotice($data = array())
    {
        return $this->insert($data);
    }
    public function updateMstNotice($data = array(), $id = 0)
    {
        return $this->update($data, ['notice_id' => $id]);
    }
    public function lastInsertedId($parent_id = 0)
    {
        $fetch_row  = $this->select('max(notice_id)')
            ->from("public.mstnoticetbl")
            ->get_one(DB_ASSOC);
        $lastinsertid = (array)$fetch_row;
        return $lastinsertid;
    }
    public function getMstNoticeListAdmin($parent_id = 0)
    {
        $fetch_all =  $this->select('P.*,category.category_name,phase.phase_name')
            ->from("public.mstnoticetbl P ")
            ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
            ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
            ->order_by('notice_id desc')
            ->get_list();
        $lastinsertid = (object)$fetch_all;
        return $lastinsertid;
    }
    public function getMstNoticeList($parent_id = 0)
    {
        $fetch_all =  $this->select('P.*,category.category_name,phase.phase_name')
            ->from("mstselectionposttbl P ")
            ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
            ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
            ->where(['P.p_status' => '1'])
            ->order_by('selection_post_id desc')
            ->get_list();
        $lastinsertid = (object)$fetch_all;
        return $lastinsertid;
    }
    /******
     * 
     * SP For Latest News
     */
    public function getMstNoticeListLatestNews($parent_id = 0)
    {
        $fetch_all =  $this->select('P.*,category.category_name,phase.phase_name')
            ->from("mstselectionposttbl P ")
            ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
            ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
            ->where(['P.p_status' => '1'])
            ->where_between('CURRENT_DATE BETWEEN effect_from_date AND effect_to_date')
            ->order_by('P.creation_date desc')
            // ->fetchtwo('fetch first 2 rows only')
            ->get_list();
        $lastinsertid = (object)$fetch_all;
        return $lastinsertid;
    }
    public function getHomeMstNoticeList($parent_id = 0)
    {
        $fetch_all =  $this->select('P.*,category.category_name')
        ->from("public.mstnoticetbl P ")
        ->join("mstcategory category ","P.category_id = category.category_id ","JOIN")
        ->where(['p_status' => 1])
        ->where_between('CURRENT_DATE BETWEEN effect_from_date AND effect_to_date')
        
        ->order_by('P.creation_date desc')
        //->fetchtwo('fetch first 2 rows only')
        ->get_list();
        return  $fetch_all;
    }
    // Publish and Unpublished
    public function updateMstNoticeState($data = array(), $id = 0)
    {
        return $this->update($data, ['notice_id' => $id]);
    }
    /***
     * 
     * PHP AJAX Data Table on 18-sep-2022
     * 
     * 
     */

    public function deleteMstNotice($sp_id = 0)
    {
        $delId = explode(",", $sp_id);
        foreach ($delId as $val) {
            $delete_row =  $this->delete($val);
        }
        return $delete_row;
    }
    public function totalRecordsWithOutFiltering()
    {

        $fetch_all =  $this->select('count(*) as allcount')
            ->from("public.mstnoticetbl")
            ->get_one();
        $count = $fetch_all;
        return $count;
    }

    public function totalRecordsWithFiltering($searchQuery)
    {


        if ($searchQuery == " ") {
            $finalquery = "'1'";
        } else {

            $finalquery = " '1' and $searchQuery";
        }
        $fetch_all =  $this->select('count(*) as allcount')
            ->from("public.mstnoticetbl P")
            ->join("mstcategory c ", "P.category_id = c.category_id ", "JOIN")
            ->whereconditiondatatable($finalquery)
            ->get_one();
        $count = $fetch_all;
        return $count;
    }
    public function getMstNoticeDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery,$row,$rowperpage)
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
            $getlist =  $this->select('P.*,c.*')
                ->from("mstnoticetbl P")
                ->join("mstcategory c ", "P.category_id = c.category_id ", "JOIN")
                ->whereconditionarchieves($str)
                ->order_by('P.creation_date desc')
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
            } else {
                $str = <<<TEXT
               to_char("effect_to_date", 'MM')='$month' and
               to_char("effect_to_date", 'YYYY')='$year' and
               effect_from_date >='$effect_from_date' and
               effect_to_date <= '$effect_to_date'  $searchQuery
TEXT;
            }
            $getlist =  $this->select('P.*,c.*')
                ->from("mstnoticetbl P")
                ->join("mstcategory c ", "P.category_id = c.category_id ", "JOIN")
                ->whereconditionarchieves($str)
                ->order_by('P.creation_date desc')
                ->limitPagination($rowperpage,$row)
                ->get_list();
        }
        //echo $this->last_query;
        return  $getlist;
    }
    public function getMstNoticeDetailsAll($year, $month, $effect_from_date, $effect_to_date, $searchQuery)
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
            $getlist =  $this->select('P.*,c.*')
                ->from("mstnoticetbl P")
                ->join("mstcategory c ", "P.category_id = c.category_id ", "JOIN")
                ->whereconditionarchieves($str)
                ->order_by('P.creation_date desc')
                ->get_list();
        } else {
            if ($searchQuery == " ") {
                $str = <<<TEXT
               to_char("effect_to_date", 'MM')='$month' and
               to_char("effect_to_date", 'YYYY')='$year' and
               effect_from_date >='$effect_from_date' and
               effect_to_date <= '$effect_to_date'
TEXT;
            } else {
                $str = <<<TEXT
               to_char("effect_to_date", 'MM')='$month' and
               to_char("effect_to_date", 'YYYY')='$year' and
               effect_from_date >='$effect_from_date' and
               effect_to_date <= '$effect_to_date'  $searchQuery
TEXT;
            }
            $getlist =  $this->select('P.*,c.*')
                ->from("mstnoticetbl P")
                ->join("mstcategory c ", "P.category_id = c.category_id ", "JOIN")
                ->whereconditionarchieves($str)
                ->order_by('P.creation_date desc')
                ->get_list();
        }
        //echo $this->last_query;
        return  $getlist;
    }

    public function checkMstNoticeId($id)
    {
        $fetch_all =  $this->select('count(*) as checkid')
            ->from("public.mstnoticetbl")
            ->where(['notice_id' => $id])
            ->get_one();
        $count = $fetch_all;
        return $count;
    }
    public function archiveMstNoticeStatus($notice_id = 0)
    {
        if (is_array($notice_id)) {
            $notice_id = implode(",", $notice_id);
        }
        $inIDS = explode(",", $notice_id);
        $qMarks = str_repeat('?,', count($inIDS) - 1) . '?';
        $sql = "INSERT INTO archives.mstnoticearchivestbl (
        notice_id,
        notice_name,
        category_id,
        effect_from_date, 
        effect_to_date,
        p_status, 
        date_archived 
        ) 
       SELECT 
       notice_id, 
       notice_name, 
       category_id,
       effect_from_date, 
       effect_to_date, 
       '0',
        NOW()
      FROM public.mstnoticetbl WHERE notice_id IN ($qMarks)";
        $delete_row = $this->insert_archieves($sql, $inIDS);
        $sql1 = "INSERT INTO archives.mstnoticearchiveschildtbl(
        notice_id, pdf_name, attachment, status)
        SELECT notice_id, pdf_name, attachment, '0'
      FROM public.mstnoticechildtbl WHERE notice_id IN ($qMarks)";
        $childtable_insert =  $this->insert_archieves($sql1, $inIDS);
        $delId = explode(",", $notice_id);
        foreach ($delId as $val) {
            $this->delete($val);
        }
        return $childtable_insert;
    }
    /***
     * 
     * PHP AJAX Data Table on 18-sep-2022
     * 
     * 
     */

     public function getMstNoticelistforhome()
     {
         $fetch_all =  $this->select('P.*,category.category_name')
         ->from("mstnoticetbl P ")
         ->join("mstcategory category ","P.category_id = category.category_id ","JOIN")
         ->where(['p_status' => 1])
         ->order_by('P.effect_from_date desc')
         ->get_list();
         return  $fetch_all;
     }

     public function getHomeNoticesarchiveList($parent_id = 0)
     {
         $fetch_all =  $this->select('P.*,category.category_name')
             ->from("archives.mstnoticearchivestbl P ")
             ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
            // ->where(['p_status' => '1'])
             ->order_by('P.date_archived desc')
             ->get_list();
           
         $lastinsertid = (object)$fetch_all;
         return $lastinsertid;
     }

   

    
}
