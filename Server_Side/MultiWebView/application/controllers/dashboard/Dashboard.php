<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
    //============================ Main construct
    function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/Dashboard_model");
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


    //============================ Show dashboard
    public function index()
    {
        $user_id = $_SESSION['user_id'];
        $this->load->model("dashboard/Settings_model");
        $data["settingContent"] = $this->Settings_model->get_setting_content('setting_table', 1)->row();
        $data["usersCount"] = $this->Dashboard_model->all_users_count();
        $data["contentCount"] = $this->Dashboard_model->all_content_count();
        $data["contentUserCount"] = $this->Dashboard_model->all_content_user_count();
        $data["rolesCount"] = $this->Dashboard_model->all_roles_count();
        $this->load->model("dashboard/User_model");
        $data["userContent"] = $this->User_model->get_user_content('user_table', $_SESSION['user_id'])->row();
        $data["usersActivity"] = $this->User_model->get_all_activity('activity_table', 15)->result();
        @$data["usersUserActivity"] = $this->User_model->get_user_activity('activity_table', $user_id, 15)->result();
        $data["pageTitle"] = $this->lang->line("app_name");
        $this->load->view('dashboard/dashboard_view', $data);
    }


    //============================ Show message
    public function message()
    {
        $data["pageTitle"] = $this->lang->line("System Message!");
        $this->load->view('dashboard/common/message_view', $data);
    }
}