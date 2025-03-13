<?php
class Common_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        //Your own constructor code
    }


    //============================ Insert Data
    function data_insert($table,$insert_array){
        $this->db->insert($table,$insert_array);
        return $this->db->insert_id();
    }


    //============================ Update Data
    function data_update($table,$set_array,$condition){
        $this->db->update($table,$set_array,$condition);
        return $this->db->affected_rows();
    }


    //============================ Delete Data
    function data_remove($table,$condition){
        return $this->db->delete($table,$condition);
    }

}