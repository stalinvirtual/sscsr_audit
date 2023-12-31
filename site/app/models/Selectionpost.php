<?php
namespace App\Models;

use App\System\DB\DB;
use App\System\Route;

class Selectionpost extends DB
{
    private $table_name = 'mstselectionposttbl';
    public function __construct()
    {
        parent::__construct('mstselectionposttbl', 'selection_post_id');
    }
    public function getNominations($parent_id = 0)
    {
        $nominations = $this->select()
            ->from($this->table_name)
            ->get_list();
        return $nominations;
    }
    public function getSelectionpost($id = 0, $type = null)
    {
        if ($id == 0) {
            return $this->getEmptySelectionpost($type);
        } else {
            return $this->select()->from($this->table_name)->where(['selection_post_id' => $id])->get_one($type);
        }
    }
    // public function getMenuByAlias($alias)
    // {
    //     echo $alias . " ===";
    //     $menu =  $this->select()->from($this->table_name)->where(['m_menu_link' => $alias])->get_one();
    //     echo $this->last_query;
    //     return $menu;
    // }
    public function getEmptySelectionpost($type = null)
    {
        $empty_menu = [
            'selection_post_id' => 0,
            'exam_name' => '',
            'department_id' => '',
            'post_id' => '',
            'category_id' => '',
            'phase_id' => '',
            'effect_from_date' => '',
            'effect_to_date' => ''
        ];
        if ($type == DB_OBJECT) {
            $empty_menu = (object) $empty_menu;
        }
        return $empty_menu;
    }
    public function addSelectionpost($data = array())
    {
        return $this->insert($data);
    }
    public function updateSelectionpost($data = array(), $id = 0)
    {
        return $this->update($data, ['selection_post_id' => $id]);
    }
    // public function deleteMenu($menu_id = 0)
    // {
    //     if ($menu_id == 1) { // Home or Root menu cannot be deleted
    //         return false;
    //     }
    //     // delete the children menu too
    //     return $this->where("WHERE m_menu_id = $menu_id OR m_parent_id = $menu_id")->delete();
    // }
    public function lastInsertedId($parent_id = 0)
    {
        $fetch_row = $this->select('max(selection_post_id)')
            ->from("mstselectionposttbl")
            ->get_one(DB_ASSOC);
        $lastinsertid = (array) $fetch_row;
        return $lastinsertid;
    }
    public function getSelectionPostListAdmin($parent_id = 0)
    {
        $fetch_all = $this->select('P.*,category.category_name,phase.phase_name')
            ->from("mstselectionposttbl P ")
            ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
            ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
            ->order_by('selection_post_id desc')
            ->get_list();
        $lastinsertid = (object) $fetch_all;
        return $lastinsertid;
    }
    public function getSelectionPostList($parent_id = 0)
    {
        $fetch_all = $this->select('P.*,category.category_name,phase.phase_name')
            ->from("mstselectionposttbl P ")
            ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
            ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
            ->where(['P.p_status' => '1'])
            ->order_by('selection_post_id desc')
            ->get_list();
        $lastinsertid = (object) $fetch_all;
        return $lastinsertid;
    }
    /******
     * 
     * SP For Latest News
     */
    public function getSelectionPostListLatestNews($parent_id = 0)
    {
        $fetch_all = $this->select('P.*,category.category_name,phase.phase_name')
            ->from("mstselectionposttbl P ")
            ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
            ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
            ->where(['P.p_status' => '1'])
            ->where_between('CURRENT_DATE BETWEEN effect_from_date AND effect_to_date')
            ->order_by('P.creation_date desc')
            // ->fetchtwo('fetch first 2 rows only')
            ->get_list();
        $lastinsertid = (object) $fetch_all;
        return $lastinsertid;
    }
    public function getHomeSelectionPostList($parent_id = 0)
    {
        $fetch_all = $this->select('P.*,category.category_name,phase.phase_name')
            ->from("mstselectionposttbl P ")
            ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
            ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
            ->where(['p_status' => '1'])
            ->order_by('P.effect_from_date desc limit 10')
            ->get_list();
        $lastinsertid = (object) $fetch_all;
        return $lastinsertid;
    }
    // Publish and Unpublished
    public function updateSelectionpostState($data = array(), $id = 0)
    {
        return $this->update($data, ['selection_post_id' => $id]);
    }
    /***
     * 
     * PHP AJAX Data Table on 18-sep-2022
     * 
     * 
     */
    public function deleteSelectionPost($sp_id = 0)
    {
       
        $delId = explode(",", $sp_id);
        foreach ($delId as $val) {
            $delete_row = $this->delete($val);
        }
        return $delete_row;
    }
    public function totalRecordsWithOutFiltering()
    {
        $fetch_all = $this->select('count(*) as allcount')
            ->from("mstselectionposttbl P ")
            ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
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
        } else {
            $finalquery = <<<HTML
           '1' and $searchQuery
HTML;
        }
        $fetch_all = $this->select('count(*) as allcount')
            ->from("mstselectionposttbl P ")
            ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
            ->whereconditiondatatable($finalquery)
            ->get_one();
        $count = $fetch_all;
        return $count;
    }
    public function getSelectionPostDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery, $row, $rowperpage)
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
            $getlist = $this->select('P.*,category.category_name,phase.phase_name')
                ->from("mstselectionposttbl P ")
                ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
                ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
                ->whereconditionarchieves($str)
                ->order_by('P.creation_date desc')
                ->limitPagination($rowperpage, $row)
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
            $getlist = $this->select('P.*,category.category_name,phase.phase_name')
                ->from("mstselectionposttbl P ")
                ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
                ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
                ->whereconditionarchieves($str)
                ->order_by('P.creation_date desc')
                ->limitPagination($rowperpage, $row)
                ->get_list();
        }
        //echo $this->last_query;
        return $getlist;
    }
    public function getSelectionPostDetailsAll($year, $month, $effect_from_date, $effect_to_date, $searchQuery)
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
            $getlist = $this->select('P.*,category.category_name,phase.phase_name')
                ->from("mstselectionposttbl P ")
                ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
                ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
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
            $getlist = $this->select('P.*,category.category_name,phase.phase_name')
                ->from("mstselectionposttbl P ")
                ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
                ->join("mstphasemaster phase ", "P.phase_id = phase.phase_id ", "JOIN")
                ->whereconditionarchieves($str)
                ->order_by('P.creation_date desc')
                ->get_list();
        }
        //echo $this->last_query;
        return $getlist;
    }
    public function checkSelectionpostId($id)
    {
        $fetch_all = $this->select('count(*) as checkid')
            ->from("mstselectionposttbl P ")
            ->join("mstcategory category ", "P.category_id = category.category_id ", "JOIN")
            ->where(['selection_post_id' => $id])
            ->get_one();
        $count = $fetch_all;
        return $count;
    }
    public function archiveSelectionPostStatus($selection_post_id = 0)
    {


        if (is_array($selection_post_id)) {
            $selection_post_id = implode(",", $selection_post_id);
        }
        $inIDS = explode(",", $selection_post_id);
        $qMarks = str_repeat('?,', count($inIDS) - 1) . '?';
        $sql = "INSERT INTO archives.mstselectionpostarchivestbl (
            selection_post_id,
            exam_name,
            department_id,
            post_id,
            category_id,
            phase_id,
            p_status,
            effect_from_date,
            effect_to_date,
            data_archived
        )
        SELECT
            selection_post_id,
            exam_name,
            department_id,
            post_id,
            category_id,
            phase_id,
            '0' AS p_status,
            effect_from_date,
            effect_to_date,
            NOW() AS data_archived
        FROM
            public.mstselectionposttbl
        WHERE
            selection_post_id IN ($qMarks);";

        $delete_row = $this->insert_archieves($sql, $inIDS);
       
        
        $sql1 = "INSERT INTO archives.mstselectionpostarchiveschildtbl(selection_post_child_id,
        selection_post_id, pdf_name, attachment, status)
        SELECT selection_post_child_id,selection_post_id, pdf_name, attachment, '0'
      FROM public.mstselectionpostchildtbl WHERE selection_post_id IN ($qMarks);";
 

        $childtable_insert = $this->insert_archieves($sql1, $inIDS);
       
        $delId = explode(",", $selection_post_id);
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
}
