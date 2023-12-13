<?php

namespace App\Models;

use App\System\DB\DB;
use App\System\Route;

class Selectionpostschild extends DB
{
    private $table_name = 'mstselectionpostchildtbl';
    public function __construct()
    {
        parent::__construct('mstselectionpostchildtbl', 'selection_post_child_id');
    }
    public function getSelectionpostschild($parent_id = 0)
    {
        $nominationchildtbllist = $this->select()
            ->from($this->table_name)
            ->where(['status' => 1])
            ->get_list();
        return $nominationchildtbllist;
    }



    /*****
     * 
     * 
     * SP For Latest News
     * 
     */
    public function getSelectionpostschildLatestNews($parent_id = 0)
    {
        $nominationchildtbllist = $this->select()
            ->from($this->table_name)
            ->where(['status' => 1])
            ->get_list();
        return $nominationchildtbllist;
    }
    public function addSelectionpostchild($data = array())
    {

        return $this->insert($data);
    }
    public function updateSelectionpostchild($data = array(), $id = 0)
    {



        return $this->update($data, ['selection_post_child_id' => $id]);
    }
    public function updateState($data = array(), $id = 0)
    {
        return $this->update($data, ['selection_post_child_id' => $id]);
    }
    public function getMimeTypeByFileNamesp($fileName)
    {
        //SELECT mime_type FROM your_table_name WHERE file_name = :file_name
        $result =  $this->select('mimetype')
        ->from("public.mstselectionpostchildtbl")
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
