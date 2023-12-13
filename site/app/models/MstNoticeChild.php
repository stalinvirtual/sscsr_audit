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
            //->where(['status' => 1])
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
    // public function deleteNoticechild($id = 0)
    // {
    //     return $this->delete( ['notice_child_id' => $id]);
    // }
    public function deleteNoticechild($id = 0)
    {
        $delId = explode(",", $id);
        foreach ($delId as $val) {
            $delete_row =  $this->delete($val);
        }
        return $delete_row;
    }
    public function getNoticechildforhome($parent_id = 0)
	{
		$noticechildlist = $this->select()
			->from($this->table_name)
			//->where(['status' => 1])
			->get_list();
		return $noticechildlist;
	}

    public function getNoticeArchieveschild($parent_id = 0)
    {
        $nominationchildtbllist = $this->select()
            ->from('archives.mstnoticearchiveschildtbl')
            //->where(['status' => 1])
            ->get_list();
        return $nominationchildtbllist;
    }
    public function getMimeTypeByFileNamenotice($fileName)
    {
        //SELECT mime_type FROM your_table_name WHERE file_name = :file_name
        $result =  $this->select('mimetype')
        ->from("public.mstnoticechildtbl")
        ->where(['mimetype' => 'application/pdf'])
        ->get_list();
        $result = (array)$result;
        // echo '<pre>';
        // print_r( $result );
        // exit;

        // Check if there is a result
        if ($result && !empty($result[0]->mimetype)) {
            return $result[0]->mimetype;
        } else {
            // Return a default value or handle accordingly
            return null;
        }
    }
}
