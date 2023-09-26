<?php

namespace App\Models;

use App\System\DB\DB;
use App\System\Route;

class PhaseMaster extends DB
{
    private $table_name = 'mstphasemaster';
    public function __construct()
    {
        parent::__construct('mstphasemaster', 'phase_id');
    }
	

	
	 public function getPhaseMasterList($parent_id = 0)
    {
        $importantLinks_list  = $this->select()
        ->from("mstphasemaster")
        ->order_by("phase_id desc")
        ->get_list();
       
       return $importantLinks_list;
    }
    

    public function getPhaseMasterListDropdown($parent_id = 0)
    {
        $importantLinks_list  = $this->select()
        ->from("mstphasemaster")
        ->where(['status'=>1])
        ->order_by("phase_id desc")
        ->get_list();
       
       return $importantLinks_list;
    }
	
	
	
	
	
	public function getPhaseMasterby($id = 0, $type = null)
    {
        if ($id == 0) {
            return $this->getEmptyPhaseMaster($type);
        } else {
            return $this->select()->from($this->table_name)->where(['phase_id' => $id])->get_one($type);
        }
    }
	
	  public function getEmptyPhaseMaster($type = null)
    {
        $empty_event_category  = [
            'phase_id' => 0,
            'phase_name ' => '',
			'creation_date ' => '',
            'status ' => '',
        ];
        if ($type == DB_OBJECT) {
            $empty_event_category = (object) $empty_event_category;
        }
        return $empty_event_category;
    }
	
	 public function addPhaseMaster($data = array())
    {

        return $this->insert($data);
    }
    public function updatePhaseMaster($data = array(), $id = 0)
    {
        return $this->update($data, ['phase_id' => $id]);
    }
	


    public function deletePhaseMaster($phase_id = 0)
    {
        $delete_row = $this->delete($phase_id);
       return $delete_row;
    }

    // Publish and Unpublished
	
	 public function updatePhaseMasterState($data = array(), $id = 0)
     {
         return $this->update($data, ['phase_id' => $id]);
     }
}
