<?php
class Content_model extends CI_Model
{

    //============================ Main construct
    public function __construct()
    {
        parent::__construct();
        //Your own constructor code
    }


    //============================ User role
    function get_user_role($table){
        $active = 1;
        $q = $this->db->query("Select $table.*
								FROM $table
								WHERE (user_type_id = 2) AND (user_role_status = $active)
								ORDER BY user_role_id ASC;");
        return $q;
    }


    //============================ Content List
    function get_content($table, $keyword, $limit, $start)
    {
        $user_id = $_SESSION['user_id'];
        if($_SESSION['user_type'] == 1)
        {
            $where = "";
            if($keyword != "")
                $where = "WHERE content_title LIKE '%$keyword%'";
            $q = $this->db->query("Select $table.*, user_table.user_id, user_table.user_username
								FROM $table
								INNER JOIN user_table
								ON $table.content_user_id = user_table.user_id  
								$where
								ORDER BY content_id DESC
								LIMIT $limit OFFSET $start;");

        }else{
            $where = "WHERE content_user_id = '$user_id'";
            if($keyword != "")
                $where = "WHERE content_title LIKE '%$keyword%' AND content_user_id = '$user_id'";
            $q = $this->db->query("Select $table.*, user_table.user_id, user_table.user_username
								FROM $table
								INNER JOIN user_table
								ON $table.content_user_id = user_table.user_id  
								$where
								ORDER BY content_id DESC
								LIMIT $limit OFFSET $start;");
        }

        return $q;
    }


    //============================ Content type
    function get_content_type($table)
    {
        $q = $this->db->query("Select $table.*
								FROM $table
								WHERE content_type_status = 1
								ORDER BY content_type_id ASC;");
        return $q;
    }


    //============================ Content count
    public function get_total_content_count($table, $keyword) {
        $user_id = $_SESSION['user_id'];
        if($_SESSION['user_type'] == 1)
        {
            $where = "";
            if($keyword != "")
                $where = "WHERE content_title LIKE '%$keyword%'";

            $q = $this->db->query("Select $table.*
								FROM $table
								$where
								;");

        }else{
            $where = "WHERE content_user_id = '$user_id'";
            if($keyword != "")
                $where = "WHERE content_title LIKE '%$keyword%' AND content_user_id = '$user_id'";

            $q = $this->db->query("Select $table.*
								FROM $table
								$where
								;");
        }

        return $q->num_rows();
    }


    //============================ Get content, content with content_id
    function get_content_content($table, $content_id)
    {
        $query = $this->db->query("Select $table.* FROM $table
								WHERE content_id = $content_id;");
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get content image with content_id
    function get_content_image($table, $content_id){
        $this->db->select('content_image');
        $query = $this->db->get_where($table, array('content_id'=>$content_id));
        return $query->result()[0];
    }


    //============================ Content List
    function get_website_list($table)
    {
        $user_id = $_SESSION['user_id'];
        $where = "";
        if($_SESSION['user_type'] != 1)
            $where = "WHERE content_user_id = '$user_id'";
        $q = $this->db->query("Select $table.content_id, $table.content_title, user_table.user_username
								FROM $table
								INNER JOIN user_table
								ON $table.content_user_id = user_table.user_id  
								$where
								ORDER BY content_id DESC;");
        return $q;
    }
}