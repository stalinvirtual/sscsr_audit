<?php
namespace App\Models;
use App\System\DB\DB;
use App\System\Route;
use App\Helpers\Helpers;
class Exam extends DB
{
    private $table_name = 'exam_data';
    public function __construct()
    {
        parent::__construct('exam_data', 'id');
    }
    public function getExams($parent_id = 0)
    {
        $pages = $this->select()
            ->from($this->table_name)
            ->order_by("id")
            ->get_list();
        return $pages;
    }
    public function getExam($id = 0, $type = null)
    {
        if ($id == 0) {
            return $this->getEmptyExam($type);
        } else {
            return $this->select()->from($this->table_name)->where(['id' => $id])->get_one($type);
        }
    }
    // public function getMenuByAlias($alias)
    // {
    //     echo $alias . " ===";
    //     $menu =  $this->select()->from($this->table_name)->where(['m_menu_link' => $alias])->get_one();
    //     echo $this->last_query;
    //     return $menu;
    // }
    public function getEmptyExam($type = null)
    {
        $empty_menu  = [
            'id' => 0,
            'exam_name' => '',
            'exam_code' => '',
            'exam_date' => '',
            'exam_time' => ''
        ];
        if ($type == DB_OBJECT) {
            $empty_menu = (object) $empty_menu;
        }
        return $empty_menu;
    }
    public function addExam($data = array())
    {
        return $this->insert($data);
    }
    public function updateExam($data = array(), $id = 0)
    {
        return $this->update($data, ['id' => $id]);
    }
    public function getExamfromExamDetailsTbl($numberofrecords, $search)
    {
        if ($search == '') {
            $sql  = $this->select("DISTINCT em.exam_name, dbm.table_exam_year, dbm.table_type, dbm.table_name,dbm.table_exam_short_name,dbm.table_id")
                ->from("exam_master em ")
                ->join("sscsr_db_table_master dbm ", "em.exam_short_name = dbm.table_exam_short_name", "JOIN")
                ->where(['dbm.status' => '1', 'dbm.table_type' => 'kyas'])
                //->like('dbm.table_exam_short_name',$q)
                ->order_by("dbm.table_id desc")
                ->limit($numberofrecords)
                ->get_list();
        } else {
            $sql  = $this->select("DISTINCT em.exam_name, dbm.table_exam_year, dbm.table_type, dbm.table_name,dbm.table_exam_short_name,dbm.table_id")
                ->from("exam_master em ")
                ->join("sscsr_db_table_master dbm ", "em.exam_short_name = dbm.table_exam_short_name", "JOIN")
                ->where(['dbm.status' => '1', 'dbm.table_type' => 'kyas'])
                ->like('dbm.table_exam_short_name', $search)
                ->order_by("dbm.table_id desc")
                ->limit($numberofrecords)
                ->get_list();
        }
        //echo $this->last_query;
        $lastinsertid = $sql;
        $lastinsertid = (object)$lastinsertid;
        return $lastinsertid;
    }
    public function getTierBasedTblCity($numberofrecords, $search)
    {
        if ($search == '') {
            $sql  = $this->select("DISTINCT em.exam_name, dbm.table_exam_year, dbm.table_type, dbm.table_name,dbm.table_exam_short_name,dtm.tier_id as tier_id,tm.tier_name as tier_name,dtm.id as tableid,dtm.created_on,dbm.table_id")
                ->from("exam_master em ")
                ->join("sscsr_db_table_master dbm ", "em.exam_short_name = dbm.table_exam_short_name and dbm.status='0'", "JOIN")
                ->join("sscsr_db_table_city_tier_master dtm", "dbm.table_name = dtm.table_name", "JOIN")
                ->join("tier_master tm", "cast(dtm.tier_id as char(255)) =  cast(tm.tier_id as char(255))", "JOIN")
                ->where(['dtm.status' => '1', 'dtm.stop_status' => '0'])
                ->order_by("dbm.table_id desc")
                ->limit($numberofrecords)
                ->get_list();
        } else {
            $sql  = $this->select("DISTINCT em.exam_name, dbm.table_exam_year, dbm.table_type, dbm.table_name,dbm.table_exam_short_name,dtm.tier_id as tier_id,tm.tier_name as tier_name,dtm.id as tableid,dtm.created_on,dbm.table_id")
                ->from("exam_master em ")
                ->join("sscsr_db_table_master dbm ", "em.exam_short_name = dbm.table_exam_short_name and dbm.status='0'", "JOIN")
                ->join("sscsr_db_table_city_tier_master dtm", "dbm.table_name = dtm.table_name", "JOIN")
                ->join("tier_master tm", "cast(dtm.tier_id as char(255)) =  cast(tm.tier_id as char(255))", "JOIN")
                ->where(['dtm.status' => '1', 'dtm.stop_status' => '0'])
                ->like('dbm.table_exam_short_name', $search)
                ->order_by("dbm.table_id desc")
                ->limit($numberofrecords)
                ->get_list();
        }
        $lastinsertid = $sql;
        $lastinsertid = (object)$lastinsertid;
        return $lastinsertid;
    }
    // Admit Card Dropdown
    public function getTierBasedTblCard($numberofrecords, $search)
    {
        if ($search == '') {
            $sql  = $this->select("DISTINCT em.exam_name, dbm.table_exam_year, dbm.table_type, dbm.table_name,dbm.table_exam_short_name,dtm.tier_id as tier_id,tm.tier_name as tier_name,dtm.id as tableid,dtm.created_on,dbm.table_id")
                ->from("exam_master em ")
                ->join("sscsr_db_table_master dbm ", "em.exam_short_name = dbm.table_exam_short_name and dbm.status='0'", "JOIN")
                ->join("sscsr_db_table_tier_master dtm", "dbm.table_name = dtm.table_name", "JOIN")
                ->join("tier_master tm", "cast(dtm.tier_id as char(255)) =  cast(tm.tier_id as char(255))", "JOIN")
                ->where(['dtm.status' => '1', 'dtm.stop_status' => '1'])
                ->order_by("dbm.table_id desc")
                ->limit($numberofrecords)
                ->get_list();
        } else {
            // echo $search;
            $sql  = $this->select("DISTINCT em.exam_name, dbm.table_exam_year, dbm.table_type, dbm.table_name,dbm.table_exam_short_name,dtm.tier_id as tier_id,tm.tier_name as tier_name,dtm.id as tableid,dtm.created_on,dbm.table_id")
                ->from("exam_master em ")
                ->join("sscsr_db_table_master dbm ", "em.exam_short_name = dbm.table_exam_short_name and dbm.status='0'", "JOIN")
                ->join("sscsr_db_table_tier_master dtm", "dbm.table_name = dtm.table_name", "JOIN")
                ->join("tier_master tm", "cast(dtm.tier_id as char(255)) =  cast(tm.tier_id as char(255))", "JOIN")
                ->where(['dtm.status' => '1', 'dtm.stop_status' => '1'])
                ->like('em.exam_name', $search)
                ->order_by("dbm.table_id desc")
                ->limit($numberofrecords)
                ->get_list();
        }
        // echo $this->last_query;
        // exit;
        $lastinsertid = $sql;
        $lastinsertid = (object)$lastinsertid;
        return $lastinsertid;
    }
    public function getTierBasedTblCardPreview($numberofrecords, $search)
    {
        if ($search == '') {
            $sql  = $this->select("DISTINCT em.exam_name, dbm.table_exam_year, dbm.table_type, dbm.table_name,dbm.table_exam_short_name,dtm.tier_id as tier_id,tm.tier_name as tier_name,dtm.id as tableid,dbm.table_id")
                ->from("exam_master em ")
                ->join("sscsr_db_table_master dbm ", "em.exam_short_name = dbm.table_exam_short_name and dbm.status='0'", "JOIN")
                ->join("sscsr_db_table_tier_master dtm", "dbm.table_name = dtm.table_name", "JOIN")
                ->join("tier_master tm", "cast(dtm.tier_id as char(255)) =  cast(tm.tier_id as char(255))", "JOIN")
                ->order_by("dbm.table_id desc")
                ->limit($numberofrecords)
                ->get_list();
        } else {
            $sql  = $this->select("DISTINCT em.exam_name, dbm.table_exam_year, dbm.table_type, dbm.table_name,dbm.table_exam_short_name,dtm.tier_id as tier_id,tm.tier_name as tier_name,dtm.id as tableid,dbm.table_id")
                ->from("exam_master em ")
                ->join("sscsr_db_table_master dbm ", "em.exam_short_name = dbm.table_exam_short_name and dbm.status='0'", "JOIN")
                ->join("sscsr_db_table_tier_master dtm", "dbm.table_name = dtm.table_name", "JOIN")
                ->join("tier_master tm", "cast(dtm.tier_id as char(255)) =  cast(tm.tier_id as char(255))", "JOIN")
                ->wherelike('dbm.table_exam_short_name', $search)
                ->order_by("dbm.table_id desc")
                ->limit($numberofrecords)
                ->get_list();
        }
        $lastinsertid = $sql;
        $lastinsertid = (object)$lastinsertid;
        return $lastinsertid;
    }
    public function getTierBasedTblPreview($q)
    {
        $sql  = $this->select("DISTINCT em.exam_name, dbm.table_exam_year, dbm.table_type, dbm.table_name,dbm.table_exam_short_name,dtm.tier_id as tier_id,tm.tier_name as tier_name,dtm.id as tableid")
            ->from("exam_master em ")
            ->join("sscsr_db_table_master dbm ", "em.exam_short_name = dbm.table_exam_short_name and dbm.status='0'", "JOIN")
            ->join("sscsr_db_table_tier_master dtm", "dbm.table_name = dtm.table_name", "JOIN")
            ->join("tier_master tm", "cast(dtm.tier_id as char(255)) =  cast(tm.tier_id as char(255))", "JOIN")
            //->where(['dtm.status' => '1'])
            ->like('dbm.table_exam_short_name', $q)
            ->order_by("dbm.table_exam_year desc,dtm.tier_id asc")
            ->get_list();
        //echo $this->last_query;
        $lastinsertid = $sql;
        $lastinsertid = (object)$lastinsertid;
        return $lastinsertid;
    }
    public function getTierBasedMaster($numberofrecords, $search)
    {
        if ($search == '') {
            $fetch_all =  $this->select('tier_id, tier_name')
                ->from("tier_master ")
                ->order_by('tier_id desc')
                ->limit($numberofrecords)
                ->get_list();
        } else {
            $fetch_all =  $this->select('tier_id, tier_name')
                ->from("tier_master ")
                ->wherelike('tier_name', $search)
                ->order_by('tier_id desc')
                ->limit($numberofrecords)
                ->get_list();
        }
        $lastinsertid = $fetch_all;
        $lastinsertid = (object)$lastinsertid;
        return $lastinsertid;
    }
    public function getKyas($data_array)
    {
        $originalDate = $data_array['dob'];
        $newDate = date("d-m-Y", strtotime($originalDate));
        $table_name = $data_array['table_name'];
        $reg_no = $data_array['register_number'];
        $table_name = Helpers::cleanData($table_name);
        $reg_no = Helpers::cleanData($reg_no);
        $newDate = Helpers::cleanData($newDate);
        $sql  = $this->select()
            ->from($table_name)
            ->where(['reg_no' => $reg_no, 'dob' => $newDate])
            ->get_one();
        $getKyasDetails = $sql;
        return $getKyasDetails;
    }
    public function getCountKyas($data_array)
    {
        $originalDate = $data_array['dob'];
        $newDate = date("d-m-Y", strtotime($originalDate));
        $table_name = $data_array['table_name'];
        $reg_no = $data_array['register_number'];
        $table_name = Helpers::cleanData($table_name);
        $reg_no = Helpers::cleanData($reg_no);
        $newDate = Helpers::cleanData($newDate);
        $sql  = $this->select('count(*)')
            ->from($table_name)
            ->where(['reg_no' => $reg_no, 'dob' => $newDate])
            ->get_one();
        $getKyasDetails = $sql;
        return $getKyasDetails;
    }
    public function printr($data)
    {
        echo '<pre>';
        print_r($data);
        exit;
    }
    public function examNamebyYear($table_name)
    {
        $data = explode('_', $table_name);
        if ($data[0] == 'phase') {
            $exam_short_name =  $data[0] . "_" . $data[1] . "_" . $data[2];
        } else {
            $exam_short_name =  $data[0];
        }
        $exam_short_name = Helpers::cleanData($exam_short_name);
        $sql  = $this->select('exam_name,exam_short_name')
            ->from('exam_master')
            ->where(['exam_short_name' => $exam_short_name])
            ->get_one();
        $getKyasDetails = $sql;
        return $getKyasDetails;
    }
}
