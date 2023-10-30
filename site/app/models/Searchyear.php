<?php

namespace App\Models;

use App\System\DB\DB;
use App\System\Route;

class SearchYear extends DB
{
    private $table_name = 'mstsearchyear';
    public function __construct()
    {
        parent::__construct('mstsearchyear', 'searchyear_id');
    }
	
	
	 public function getSearchyearList($parent_id = 0)
    {
        $importantLinks_list  = $this->select()
        ->from("mstsearchyear")
        ->where(['status'=>1])
        ->order_by("search_year asc")
        ->get_list();
       
       return $importantLinks_list;
    }
    public function getSearchyearListDisplay($parent_id = 0)
    {
        $importantLinks_list  = $this->select()
        ->from("mstsearchyear")
        ->order_by("searchyear_id desc")
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
	
	
	
	
	
	public function getSearchyearby($id = 0, $type = null)
    {
        if ($id == 0) {
            return $this->getEmptySearchyear($type);
        } else {
            return $this->select()->from($this->table_name)->where(['searchyear_id' => $id])->get_one($type);
        }
    }
	
	  public function getEmptySearchyear($type = null)
    {
        $empty_event_category  = [
            'searchyear_id' => 0,
            'search_year ' => '',
			'creation_date ' => '',
            'status ' => '',
        ];
        if ($type == DB_OBJECT) {
            $empty_event_category = (object) $empty_event_category;
        }
        return $empty_event_category;
    }
	
	 public function addSearchyear($data = array())
    {
        return $this->insert($data);
    }
    public function updateSearchyear($data = array(), $id = 0)
    {
        return $this->update($data, ['searchyear_id' => $id]);
    }
	
    public function deleteSearchyear($searchyear_id = 0)
    {
        $delete_row = $this->delete($searchyear_id);
       return $delete_row;
    }

    // Publish and Unpublished
	
	 public function updateSearchYearState($data = array(), $id = 0)
     {
         return $this->update($data, ['searchyear_id' => $id]);
     }
  
}
