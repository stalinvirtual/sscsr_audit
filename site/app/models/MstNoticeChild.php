<?php

namespace App\Models;

use App\System\DB\DB;
use App\System\Route;

class MstNoticeChild extends DB
{
    private $table_name = 'public.mstnoticechildtbl';
    public function __construct()
    {
        parent::__construct('public.mstnoticechildtbl', 'notice_child_id');
    }
    public function getMstNoticeChild($parent_id = 0)
    {
        $result = $this->select()
            ->from($this->table_name)
          //  ->where(['status' => 1])
            ->get_list();
        return $result;
    }



    /*****
     * 
     * 
     * SP For Latest News
     * 
     */
    public function getMstNoticeChildLatestNews($parent_id = 0)
    {
        $result = $this->select()
            ->from($this->table_name)
            // ->where(['status' => 1])
            ->get_list();
        return $result;
    }
    public function addMstNoticeChild($data = array())
    {

        return $this->insert($data);
    }
    public function updateMstNoticeChild($data = array(), $id = 0)
    {



        return $this->update($data, ['notice_child_id' => $id]);
    }
    public function updateState($data = array(), $id = 0)
    {
        return $this->update($data, ['notice_child_id' => $id]);
    }
}
