<?php
class Settings_model extends CI_Model {

    //============================ Main construct
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }


    //============================ Get general setting content
    function get_setting_content($table, $setting_id){
        $query = $this->db->get_where($table, array('setting_id'=>$setting_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get currency content
    function get_currency_content($table, $currency_id){
        $query = $this->db->get_where($table, array('currency_id'=>$currency_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get email setting content
    function get_email_setting_content($table, $email_setting_id){
        $query = $this->db->get_where($table, array('email_setting_id'=>$email_setting_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get sms setting content
    function get_sms_setting_content($table, $sms_setting_id){
        $query = $this->db->get_where($table, array('sms_setting_id'=>$sms_setting_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get api key content
    function get_api_key_content($table, $api_id){
        $query = $this->db->get_where($table, array('api_id'=>$api_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }



    //============================ Get PC
    function get_pc($table, $setting_id){
        $query = $this->db->get_where($table, array('setting_id'=>$setting_id));
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }
}