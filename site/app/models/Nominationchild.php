<?php

namespace App\Models;

use App\System\DB\DB;
use App\System\Route;

class Nominationchild extends DB
{
    private $table_name = 'mstnominationchildtbl';
    public function __construct()
    {
        parent::__construct('mstnominationchildtbl', 'nomination_child_id');
    }
    public function getNominationchild($parent_id = 0)
    {
        $nominationchildtbllist = $this->select()
            ->from($this->table_name)
            ->where(['status' => 1])
            ->get_list();
        return $nominationchildtbllist;
    }

/******
 * 
 * 
 * Nomination List For Latest News
 * 
 * 
 */

public function getNominationchildLatestNews($parent_id = 0)
{
    $nominationchildtbllist = $this->select()
        ->from($this->table_name)
        ->where(['status' => 1])
        ->get_list();
    return $nominationchildtbllist;
}




    public function addNominationchild($data = array())
    {

        return $this->insert($data);
    }
    public function updateNominationChild($data = array(), $id = 0)
    {



        return $this->update($data, ['nomination_child_id' => $id]);
    }
    public function updateState($data = array(), $id = 0)
    {
        return $this->update($data, ['nomination_child_id' => $id]);
    }
    public function getNominationArchieveschild($parent_id = 0)
   {
       $nominationchildtbllist = $this->select()
           ->from($this->table_name)
           ->where(['status' => 1])
           ->get_list();
       return $nominationchildtbllist;
   }
   public function getMimeTypeByFileName($fileName)
    {
        //SELECT mime_type FROM your_table_name WHERE file_name = :file_name
        $result =  $this->select('mimetype')
        ->from("public.mstnominationchildtbl")
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
