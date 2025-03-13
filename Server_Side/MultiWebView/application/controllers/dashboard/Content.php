<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends Admin_Controller
{
    //============================ Main construct
    function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/Content_model");
        $this->load->model("dashboard/User_model");
        $this->load->model("Shared_model");
    }


    //============================ Check user is login or not
    private function is_login() {
        if (!isset($_SESSION['user_username']) && !isset($_SESSION['user_type']))
        {
            redirect(base_url()."dashboard/Auth");
            die();
        }
    }


    //============================ Content list
    public function content_list()
    {
        $keyword = $content_type = "";
        if(isset($_GET['keyword'])) $keyword = $_GET['keyword'];
        if(isset($_GET['content_type'])) $content_type = $_GET['content_type'];

        // Start Pagination
        // Load For Pagination
        //$this->load->helper("url");
        $this->load->library("pagination");

        $config = array();
        $config['base_url'] = base_url() . "dashboard/Content/content_list/";
        $config['total_rows'] = $this->Content_model->get_total_content_count('content_table', $keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 3;
        $config['display_pages'] = TRUE;

        $config['full_tag_open'] = '<div style="text-align: center"><ul class="pagination pagination-sm no-margin">';
        $config['full_tag_close'] = '</ul></div>';

        //$config['prev_link'] = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
        $config['prev_link'] = '<';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        //$config['next_link'] = '<i class="fa fa-angle-left" aria-hidden="true"></i>';
        $config['next_link'] = '>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        //$config['first_link'] = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        //$config['last_link'] = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        //To pass GET parametrs (keywords)
        if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

        $config["num_links"] = round( $config["total_rows"] / $config["per_page"] );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["Links"] = $this->pagination->create_links();
        // .End Pagination

        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["contentList"] = $this->Content_model->get_content('content_table', $keyword, $config["per_page"], $page)->result();
        $data["pageTitle"] = $this->lang->line("Content List");
        if($_SESSION['user_type'] == 1)
            $this->load->view('dashboard/content/content_list_view', $data);
        else
            $this->load->view('dashboard/content/content_list_user_view', $data);
    }


    //============================ Add content
    public function add_content()
    {
        if(isset($_POST['content_title']))
        {
            //For uploading
            $config['upload_path']          = 'assets/upload/content/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('content_image'))
            {
                $error = array('error' => $this->upload->display_errors());
                //print_r($error);
                $new_content_image = "content.png";

            } else {
                // [ Resize avatar image ]
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/upload/content/'.$this->upload->data()['file_name'];
                $config['new_image'] = 'assets/upload/content/'.$this->upload->data()['file_name'];
                $config['maintain_ratio'] = TRUE;
                /*$config['width'] = 128;
                $config['height'] = 128;*/
                $config['overwrite'] = TRUE;
                $this->load->library('image_lib',$config);
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $data = array('upload_data' => $this->upload->data());
                $new_content_image =  $this->upload->data()['file_name'];
            }

            $this->form_validation->set_rules('content_user_id', 'content_user_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_title', $this->lang->line("Title"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_sub_title', $this->lang->line("Sub Title"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_url', $this->lang->line("Main URL"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_url1', 'content_url1', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url1_text', 'content_url1_text', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url2', 'content_url2', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url2_text', 'content_url2_text', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url3', 'content_url3', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url3_text', 'content_url3_text', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url4', 'content_url4', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url4_text', 'content_url4_text', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url5', 'content_url5', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url5_text', 'content_url5_text', 'trim|xss_clean');
            $this->form_validation->set_rules('content_email', $this->lang->line("Email"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_orientation', $this->lang->line("Orientation"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_loader', $this->lang->line("Loader"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_primary_color', 'content_primary_color', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_dark_color', 'content_dark_color', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_accent_color', 'content_accent_color', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_access', $this->lang->line("Access to content"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_image', $this->lang->line("Main Image"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_rtl', 'content_rtl', 'trim|xss_clean');
            $this->form_validation->set_rules('content_fullscreen', 'content_fullscreen', 'trim|xss_clean');
            $this->form_validation->set_rules('content_toolbar', 'content_toolbar', 'trim|xss_clean');
            $this->form_validation->set_rules('content_banner_ads', 'content_banner_ads', 'trim|xss_clean');
            $this->form_validation->set_rules('content_interstitial_ads', 'content_interstitial_ads', 'trim|xss_clean');
            $this->form_validation->set_rules('content_admob_app_id', 'content_admob_app_id', 'trim|xss_clean');
            $this->form_validation->set_rules('content_admob_banner_unit_id', 'content_admob_banner_unit_id', 'trim|xss_clean');
            $this->form_validation->set_rules('content_admob_interstitial_unit_id', 'content_admob_interstitial_unit_id', 'trim|xss_clean');
            $this->form_validation->set_rules('content_onesignal_app_id', 'content_onesignal_app_id', 'trim|xss_clean');
            $this->form_validation->set_rules('content_onesignal_rest_api_key', 'content_onesignal_rest_api_key', 'trim|xss_clean');
            $this->form_validation->set_rules('content_menu', 'content_menu', 'trim|xss_clean');
            $this->form_validation->set_rules('content_status', $this->lang->line("Status"), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Content/add_content');

            } else {
                if ($this->input->post('content_rtl') == 'on') $content_rtl = 1; else $content_rtl = 0;
                if ($this->input->post('content_fullscreen') == 'on') $content_fullscreen = 1; else $content_fullscreen = 0;
                if ($this->input->post('content_toolbar') == 'on') $content_toolbar = 1; else $content_toolbar = 0;
                if ($this->input->post('content_banner_ads') == 'on') $content_banner_ads = 1; else $content_banner_ads = 0;
                if ($this->input->post('content_interstitial_ads') == 'on') $content_interstitial_ads = 1; else $content_interstitial_ads = 0;
				if ($this->input->post('content_menu') == 'on') $content_menu = 1; else $content_menu = 0;
                if ($this->input->post('content_status') == 'on') $content_status = 1; else $content_status = 0;
                $content_property1 = "p1";
                $content_property2 = "p2";
                $content_viewed = 0;
                $content_featured = 0;
                $content_special = 0;
                $content_publish_date = now();
                $content_expired_date = time() + (86400 * 365) * 25; //Lifetime (25 Years)

                $dataArray = array(
                    "content_user_id" => $this->input->post('content_user_id'),
                    "content_title" => $this->input->post('content_title'),
                    "content_sub_title" => $this->input->post('content_sub_title'),
                    "content_url" => $this->input->post('content_url'),
                    "content_url1" => $this->input->post('content_url1'),
                    "content_url1_text" => $this->input->post('content_url1_text'),
                    "content_url2" => $this->input->post('content_url2'),
                    "content_url2_text" => $this->input->post('content_url2_text'),
                    "content_url3" => $this->input->post('content_url3'),
                    "content_url3_text" => $this->input->post('content_url3_text'),
                    "content_url4" => $this->input->post('content_url4'),
                    "content_url4_text" => $this->input->post('content_url4_text'),
                    "content_url5" => $this->input->post('content_url5'),
                    "content_url5_text" => $this->input->post('content_url5_text'),
                    "content_email" => $this->input->post('content_email'),
                    "content_orientation" => $this->input->post('content_orientation'),
                    "content_loader" => $this->input->post('content_loader'),
                    "content_primary_color" => $this->input->post('content_primary_color'),
                    "content_dark_color" => $this->input->post('content_dark_color'),
                    "content_accent_color" => $this->input->post('content_accent_color'),
                    "content_access" => $this->input->post('content_access'),
                    "content_image" => $new_content_image,
                    "content_featured" => $content_featured,
                    "content_special" => $content_special,
                    "content_property1" => $content_property1,
                    "content_property2" => $content_property2,
                    "content_viewed" => $content_viewed,
                    "content_publish_date" => $content_publish_date,
                    "content_expired_date" => $content_expired_date,
                    "content_rtl" => $content_rtl,
                    "content_fullscreen" => $content_fullscreen,
                    "content_toolbar" => $content_toolbar,
                    "content_banner_ads" => $content_banner_ads,
                    "content_interstitial_ads" => $content_interstitial_ads,
                    "content_admob_app_id" => $this->input->post('content_admob_app_id'),
                    "content_admob_banner_unit_id" => $this->input->post('content_admob_banner_unit_id'),
                    "content_admob_interstitial_unit_id" => $this->input->post('content_admob_interstitial_unit_id'),
                    "content_menu" => $content_menu,
                    "content_onesignal_app_id" => $this->encrypt->encode($this->input->post('content_onesignal_app_id')),
                    "content_onesignal_rest_api_key" => $this->encrypt->encode($this->input->post('content_onesignal_rest_api_key')),
                    "content_status" => $content_status
                );

                //Insert $dataArray to DB
                $result = $this->Common_model->data_insert("content_table",$dataArray);
                if ($result == TRUE) {
                    $msg = $this->lang->line("Website added successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Content/content_list');

                } else {
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Content/content_list');
                }
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["fetchUsers"] = $this->User_model->fetch_users('user_table')->result();
        $data["userRole"] = $this->Content_model->get_user_role('user_role_table')->result();
        $data["pageTitle"] = $this->lang->line("Add Content");
        if($_SESSION['user_type'] == 1)
            $this->load->view('dashboard/content/add_content_view', $data);
        else
            $this->load->view('dashboard/content/add_content_user_view', $data);
    }


    //============================ Delete content
    public function delete_content(){
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        if(isset($_POST['content_id'])) {
            $this->form_validation->set_rules('content_id', 'content_id', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Content/content_list');

            } else {
                $content_id = $this->input->post('content_id');

                //Remove content image from disk
                $q = $this->Content_model->get_content_image("content_table",$content_id);
                if ($q->content_image != 'content.png')
                {
                    $content_image = "assets/upload/content/".$q->content_image;
                    unlink($content_image);
                }

                $result = $this->Common_model->data_remove("content_table",array("content_id"=>$content_id));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Website deleted successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Content/content_list');

                }else{
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Content/content_list');
                }
            }
        }
    }


    //============================ Edit content
    public function edit_content()
    {
        if(isset($_POST['content_title']))
        {
            //For uploading
            $config['upload_path']          = 'assets/upload/content/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('content_image'))
            {
                $error = array('error' => $this->upload->display_errors());
                //print_r($error);
                $new_content_image = "content.png";

            } else {
                // [ Resize avatar image ]
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/upload/content/'.$this->upload->data()['file_name'];
                $config['new_image'] = 'assets/upload/content/'.$this->upload->data()['file_name'];
                $config['maintain_ratio'] = TRUE;
                /*$config['width'] = 128;
                $config['height'] = 128;*/
                $config['overwrite'] = TRUE;
                $this->load->library('image_lib',$config);
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $data = array('upload_data' => $this->upload->data());
                $new_content_image =  $this->upload->data()['file_name'];
            }

            $this->form_validation->set_rules('content_user_id', 'content_user_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_title', $this->lang->line("Title"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_sub_title', $this->lang->line("Sub Title"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_url', $this->lang->line("Main URL"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_url1', 'content_url1', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url1_text', 'content_url1_text', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url2', 'content_url2', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url2_text', 'content_url2_text', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url3', 'content_url3', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url3_text', 'content_url3_text', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url4', 'content_url4', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url4_text', 'content_url4_text', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url5', 'content_url5', 'trim|xss_clean');
            $this->form_validation->set_rules('content_url5_text', 'content_url5_text', 'trim|xss_clean');
            $this->form_validation->set_rules('content_email', $this->lang->line("Email"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_orientation', $this->lang->line("Orientation"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_loader', $this->lang->line("Loader"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_primary_color', 'content_primary_color', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_dark_color', 'content_dark_color', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_accent_color', 'content_accent_color', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_access', $this->lang->line("Access to content"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_image', $this->lang->line("Main Image"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_rtl', 'content_rtl', 'trim|xss_clean');
            $this->form_validation->set_rules('content_fullscreen', 'content_fullscreen', 'trim|xss_clean');
            $this->form_validation->set_rules('content_toolbar', 'content_toolbar', 'trim|xss_clean');
            $this->form_validation->set_rules('content_banner_ads', 'content_banner_ads', 'trim|xss_clean');
            $this->form_validation->set_rules('content_interstitial_ads', 'content_interstitial_ads', 'trim|xss_clean');
            $this->form_validation->set_rules('content_admob_app_id', 'content_admob_app_id', 'trim|xss_clean');
            $this->form_validation->set_rules('content_admob_banner_unit_id', 'content_admob_banner_unit_id', 'trim|xss_clean');
            $this->form_validation->set_rules('content_admob_interstitial_unit_id', 'content_admob_interstitial_unit_id', 'trim|xss_clean');
            $this->form_validation->set_rules('content_onesignal_app_id', 'content_onesignal_app_id', 'trim|xss_clean');
            $this->form_validation->set_rules('content_onesignal_rest_api_key', 'content_onesignal_rest_api_key', 'trim|xss_clean');
            $this->form_validation->set_rules('content_menu', 'content_menu', 'trim|xss_clean');
            $this->form_validation->set_rules('content_status', $this->lang->line("Status"), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Content/content_list');

            } else {

                if ($this->input->post('content_rtl') == 'on') $content_rtl = 1; else $content_rtl = 0;
                if ($this->input->post('content_fullscreen') == 'on') $content_fullscreen = 1; else $content_fullscreen = 0;
                if ($this->input->post('content_toolbar') == 'on') $content_toolbar = 1; else $content_toolbar = 0;
                if ($this->input->post('content_banner_ads') == 'on') $content_banner_ads = 1; else $content_banner_ads = 0;
                if ($this->input->post('content_interstitial_ads') == 'on') $content_interstitial_ads = 1; else $content_interstitial_ads = 0;
                if ($this->input->post('content_menu') == 'on') $content_menu = 1; else $content_menu = 0;
                if ($this->input->post('content_status') == 'on') $content_status = 1; else $content_status = 0;

                //Check if content_image submit or not
                if ($new_content_image == "content.png")
                {
                    $dataArray = array(
                        "content_user_id" => $this->input->post('content_user_id'),
                        "content_title" => $this->input->post('content_title'),
                        "content_sub_title" => $this->input->post('content_sub_title'),
                        "content_url" => $this->input->post('content_url'),
                        "content_url1" => $this->input->post('content_url1'),
                        "content_url1_text" => $this->input->post('content_url1_text'),
                        "content_url2" => $this->input->post('content_url2'),
                        "content_url2_text" => $this->input->post('content_url2_text'),
                        "content_url3" => $this->input->post('content_url3'),
                        "content_url3_text" => $this->input->post('content_url3_text'),
                        "content_url4" => $this->input->post('content_url4'),
                        "content_url4_text" => $this->input->post('content_url4_text'),
                        "content_url5" => $this->input->post('content_url5'),
                        "content_url5_text" => $this->input->post('content_url5_text'),
                        "content_email" => $this->input->post('content_email'),
                        "content_orientation" => $this->input->post('content_orientation'),
                        "content_loader" => $this->input->post('content_loader'),
                        "content_primary_color" => $this->input->post('content_primary_color'),
                        "content_dark_color" => $this->input->post('content_dark_color'),
                        "content_accent_color" => $this->input->post('content_accent_color'),
                        "content_access" => $this->input->post('content_access'),
                        //"content_image" => $new_content_image,
                        "content_rtl" => $content_rtl,
                        "content_fullscreen" => $content_fullscreen,
                        "content_toolbar" => $content_toolbar,
                        "content_banner_ads" => $content_banner_ads,
                        "content_interstitial_ads" => $content_interstitial_ads,
                        "content_admob_app_id" => $this->input->post('content_admob_app_id'),
                        "content_admob_banner_unit_id" => $this->input->post('content_admob_banner_unit_id'),
                        "content_admob_interstitial_unit_id" => $this->input->post('content_admob_interstitial_unit_id'),
                        "content_onesignal_app_id" => $this->encrypt->encode($this->input->post('content_onesignal_app_id')),
                        "content_onesignal_rest_api_key" => $this->encrypt->encode($this->input->post('content_onesignal_rest_api_key')),
                        "content_menu" => $content_menu,
                        "content_status" => $content_status,
                    );
                }else{
                    //Remove old category_image from disk
                    if($this->input->post('content_old_image') != "content.png")
                    {
                        $content_old_image = "assets/upload/content/".$this->input->post('content_old_image');
                        unlink($content_old_image);
                    }
                    $dataArray = array(
                        "content_user_id" => $this->input->post('content_user_id'),
                        "content_title" => $this->input->post('content_title'),
                        "content_sub_title" => $this->input->post('content_sub_title'),
                        "content_url" => $this->input->post('content_url'),
                        "content_url1" => $this->input->post('content_url1'),
                        "content_url1_text" => $this->input->post('content_url1_text'),
                        "content_url2" => $this->input->post('content_url2'),
                        "content_url2_text" => $this->input->post('content_url2_text'),
                        "content_url3" => $this->input->post('content_url3'),
                        "content_url3_text" => $this->input->post('content_url3_text'),
                        "content_url4" => $this->input->post('content_url4'),
                        "content_url4_text" => $this->input->post('content_url4_text'),
                        "content_url5" => $this->input->post('content_url5'),
                        "content_url5_text" => $this->input->post('content_url5_text'),
                        "content_email" => $this->input->post('content_email'),
                        "content_orientation" => $this->input->post('content_orientation'),
                        "content_loader" => $this->input->post('content_loader'),
                        "content_primary_color" => $this->input->post('content_primary_color'),
                        "content_dark_color" => $this->input->post('content_dark_color'),
                        "content_accent_color" => $this->input->post('content_accent_color'),
                        "content_access" => $this->input->post('content_access'),
                        "content_image" => $new_content_image,
                        "content_rtl" => $content_rtl,
                        "content_fullscreen" => $content_fullscreen,
                        "content_toolbar" => $content_toolbar,
                        "content_banner_ads" => $content_banner_ads,
                        "content_interstitial_ads" => $content_interstitial_ads,
                        "content_admob_app_id" => $this->input->post('content_admob_app_id'),
                        "content_admob_banner_unit_id" => $this->input->post('content_admob_banner_unit_id'),
                        "content_admob_interstitial_unit_id" => $this->input->post('content_admob_interstitial_unit_id'),
                        "content_onesignal_app_id" => $this->encrypt->encode($this->input->post('content_onesignal_app_id')),
                        "content_onesignal_rest_api_key" => $this->encrypt->encode($this->input->post('content_onesignal_rest_api_key')),
                        "content_menu" => $content_menu,
                        "content_status" => $content_status,
                    );
                }

                //Update $dataArray to DB
                $result = $this->Common_model->data_update("content_table",$dataArray,array("content_id"=>$this->input->post('content_id')));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Website edited successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Content/content_list');

                }else {
                    redirect(base_url().'dashboard/Content/content_list');
                }
            }

        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $content_id = $this->uri->segment(4);

        //Check if this content not for this user
        if($_SESSION['user_type'] != 1)
        {
            $user_id = $_SESSION['user_id'];
            $q = $this->db->query("Select *
				FROM content_table
				WHERE (content_id = $content_id) AND (content_user_id = '$user_id')");
            if ($q->num_rows() == 0)
            {
                //Deny Access
                $msg = $this->lang->line("You have no permission to access this page.");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Dashboard/message');
                $this->db->close();
                die();
            }
        }

        @$data["contentContent"] = $this->Content_model->get_content_content('content_table', $content_id)->result()[0];
        $data["userRole"] = $this->Content_model->get_user_role('user_role_table')->result();
        $data["pageTitle"] = $this->lang->line("Edit Content");
        $data["fetchUsers"] = $this->User_model->fetch_users('user_table')->result();
        if($_SESSION['user_type'] == 1)
            $this->load->view('dashboard/content/edit_content_view', $data);
        else
            $this->load->view('dashboard/content/edit_content_user_view', $data);
    }
}