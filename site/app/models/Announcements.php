<?php

namespace App\Models;

use App\System\DB\DB;
use App\System\Route;

class Announcements extends DB
{
    private $table_name = 'announcementtbl';
    public function __construct()
    {
        parent::__construct('announcementtbl', 'announcement_id');
    }
    
     public function getAnnouncementList($parent_id = 0)
    {
        $pages = $this->select()
            ->from($this->table_name)
            ->order_by("announcement_id")
            ->get_list();
            
        return $pages;
    }
    public function getAnnouncementby($announcement_id = 0, $type = null)
    {
        if ($announcement_id == 0) {
            return $this->getEmptyAnnouncement($type);
        } else {
            return $this->select()->from($this->table_name)->where(['announcement_id' => $announcement_id])->get_one($type);
        }
    }
    
    public function getEmptyAnnouncement($type = null)
    {
        $empty_menu  = [
            'announcement_id' => 0,
            'announcement_name ' => '',
            'announcement_content ' => '',
            'effect_from_date'    =>'',
            'effect_to_date'      => ''
            
        ];
        if ($type == DB_OBJECT) {
            $empty_menu = (object) $empty_menu;
        }
        return $empty_menu;
    }
    public function addAnnouncement($data = array())
    {
      
        return $this->insert($data);

    }
    public function updateAnnouncement($data = array(), $announcement_id = 0)
    {
        return $this->update($data, ['announcement_id' => $announcement_id]);
    }
    

     public function getAnnouncement()
     {
    $fetch_all =  $this->select()
        ->from("announcementtbl ")
        ->order_by('effect_from_date desc')
        ->get_list();
        return $fetch_all;
    }
     public function getHomePageAnnouncementList()
    {
        $fetch_all =  $this->select()
        ->from("announcementtbl ")
        ->where(['p_status'=>1])
        ->where_between('CURRENT_DATE BETWEEN effect_from_date AND effect_to_date')
        ->order_by('creation_date desc')
        ->get_list();
        // echo $this->last_query;
        // exit;
        
    
        return $fetch_all;
    }


    /*****
     * Announcement For Latest News
     * 
     */
    public function getHomePageAnnouncementListLatestNews()
    {
        $fetch_all =  $this->select()
        ->from("announcementtbl ")
        ->where(['p_status'=>1])
        //->wherecondition("effect_from_date > current_date - interval '2 days'")
        ->order_by('effect_from_date desc')
        ->fetchtwo('fetch first 2 rows only')
        ->get_list();
       
        return $fetch_all;
    }
    
    // Publish and Unpublished

    
    
     public function updateAnnouncementState($data = array(), $id = 0)
    {
        return $this->update($data, ['announcement_id' => $id]);
    }

    
    public function deleteAnnouncementStatus($announcement_id = 0)
    {
        $delete_row = $this->delete($announcement_id);
       return $delete_row;
    }

   

    public function copyAnnouncement($announcement_id = 0)
    {
        echo $sql = "INSERT INTO public.announcementtbl (pdf_name, attachment, effect_from_date, effect_to_date, p_status ) 
        SELECT pdf_name, attachment, effect_from_date, effect_to_date, '0'
       FROM public.announcementtbl WHERE announcement_id=$announcement_id";
        return $this->execute( $sql );
       
    }

/***
 * 
 * PHP AJAX Data Table on 18-sep-2022
 * 
 * 
 */

public function deleteAnnouncement($announcement_id = 0)
{
   $delId = explode(",", $announcement_id);
   foreach ($delId as $val) {
       $delete_row =  $this->delete($val);
   }
   return $delete_row;
}
public function totalRecordsWithOutFiltering()
   {
 
       $fetch_all =  $this->select('count(*) as allcount')
           ->from("announcementtbl")
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
           ->from("announcementtbl")
           ->whereconditiondatatable($finalquery)
           ->get_one();
       $count = $fetch_all;
       return $count;
   }
   public function getAnnouncementDetails($year, $month, $effect_from_date, $effect_to_date, $searchQuery)
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
               ->from("Announcementtbl")
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
               ->from("announcementtbl")
               ->whereconditionarchieves($str)
               ->order_by('effect_from_date desc')
               ->get_list();
       }
    //    echo $this->last_query();
    //         exit;
       return  $getlist;
   }

   public function checkAnnouncementId($id)
   {
       $fetch_all =  $this->select('count(*) as checkid')
           ->from("announcementtbl")
           ->where(['announcement_id' => $id])
           ->get_one();
       $count = $fetch_all;
      
       return $count;
   }
   public function archiveAnnouncementStatus($id = 0)
   {
       if (is_array($id)) {
           $id = implode(",", $id);
       }
       $inIDS = explode(",", $id);
       $qMarks = str_repeat('?,', count($inIDS) - 1) . '?';
       $sql = "INSERT INTO archives.announcementarchivestbl (announcement_id, announcement_name, announcement_content, effect_from_date, effect_to_date ) 
       SELECT announcement_id, announcement_name, announcement_content, effect_from_date, effect_to_date
      FROM public.announcementtbl WHERE announcement_id IN ( $qMarks )";
       $delete_row = $this->execute($sql, $inIDS );
       
       $delId = explode(",", $id);
       foreach ($delId as $val) {
           $this->delete($val);
       }
       return $delete_row;
   }

   /***
 * 
 * PHP AJAX Data Table on 18-sep-2022
 * 
 * 
 */

 

}
