<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Auth extends CI_Controller {

    //============================ Main construct
    public function __construct() {
        parent::__construct();

        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/User_model");
        $this->load->model("Shared_model");
    }


    //============================ Hash password
    private function hash_password($user_password){
        //return password_hash($password, PASSWORD_BCRYPT);
        $salt_password = "dF$.50^&D10?#^dA2z";
        return $hash_password = sha1(md5($user_password.$salt_password));
    }


    //============================ Verify hash password
    private function verify_hash_password($user_password, $existingHashFromDb){
        return password_verify($user_password, $existingHashFromDb);
    }


    //============================ Check user is login or not
    private function is_login() {
        // Don't show the auth if user is login
        if (isset($_SESSION['user_username']) && isset($_SESSION['user_type']))
        {
            redirect(base_url()."dashboard/Dashboard");

        }elseif (!isset($_SESSION['user_username']) && isset($_SESSION['user_type'])){
            redirect(base_url()."dashboard/Auth");
        }
    }


    //============================ Show login page
    public function index() {
        $this->is_login();
        $data['pageTitle'] = $this->lang->line("user_login");
        $data['showCaptcha'] = $this->Shared_model->generate_captcha();
        $this->load->view('dashboard/auth/login_view', $data);
    }


    //============================ Show register page
    public function register() {
        $this->is_login();
        $this->load->model("dashboard/Page_model");
        $this->load->model("dashboard/Settings_model");
        $data["pageContent"] = $this->Page_model->get_page_content('page_table', 1)->result()[0];
        $data["settingContent"] = $this->Settings_model->get_setting_content('setting_table', 1)->result()[0];
        $data['pageTitle'] = $this->lang->line("register_a_new_membership");
        $data['showCaptcha'] = $this->Shared_model->generate_captcha();
        $this->load->view('dashboard/auth/register_view', $data);
    }


    //============================ Validate and store registration data in database
    public function new_user_registration() {
        $this->form_validation->set_rules('user_username', $this->lang->line("Username"), 'trim|required|xss_clean|min_length[5]',
            array(
                'required'      => $this->lang->line("field_is_required"),
                'min_length'      => $this->lang->line("must_be_minimum_characters")));
        $this->form_validation->set_rules('user_email', $this->lang->line("Email"), 'trim|required|xss_clean|valid_email',
            array(
                'required'      => $this->lang->line("field_is_required"),
                'valid_email'     => $this->lang->line("is_not_valid_an_email_address"),
            ));
        $this->form_validation->set_rules('user_password', $this->lang->line("Password"), 'trim|required|xss_clean|min_length[8]',
            array(
                'required'      => $this->lang->line("field_is_required"),
                'min_length'      => $this->lang->line("must_be_minimum_characters")
            ));
        $this->form_validation->set_rules('user_confirm_password', $this->lang->line("Confirm Password"), 'trim|required|xss_clean|matches[user_password]',
            array(
                'required'      => $this->lang->line("field_is_required"),
                'matches'     => $this->lang->line("the_password_confirmation_field_does_not_match_the_password_field")
            )
        );
        $this->form_validation->set_rules('user_referral', $this->lang->line("Referral ID"), 'trim|xss_clean');
        $this->form_validation->set_rules('terms', $this->lang->line("TOS"), 'trim|required|xss_clean',
            array(
                'required'      => $this->lang->line("the_TOS_field_is_required")));
        $this->form_validation->set_rules('captcha', $this->lang->line("Security Captcha"), 'trim|required|xss_clean|min_length[5]|max_length[10]',
            array(
                'required'      => $this->lang->line("field_is_required"),
                'min_length'      => $this->lang->line("must_be_minimum_characters"),
                'max_length'      => $this->lang->line("must_be_maximum_characters")
            ));

        if ($this->form_validation->run() == FALSE) {
            $data['pageTitle'] = $this->lang->line("register_a_new_membership");
            $data['showCaptcha'] = $this->Shared_model->generate_captcha();
            $this->load->model("dashboard/Settings_model");
            $data["settingContent"] = $this->Settings_model->get_setting_content('setting_table', 1)->result()[0];
            $this->load->view('dashboard/auth/register_view', $data);

        } else {
            //First, delete old CAPTCHA:
            $expiration = time() - 900; // Two hour limit
            $this->db->query("DELETE FROM captcha_table WHERE captcha_time < $expiration");

            //Then see if a captcha exists:
            $sql = 'SELECT COUNT(*) AS count FROM captcha_table WHERE captcha_word = ? AND captcha_ip_address = ? AND captcha_time > ?';
            $clean_captcha = $this->Shared_model->number2english($_POST['captcha']);
            $binds = array($clean_captcha, $this->input->ip_address(), $expiration);
            $query = $this->db->query($sql, $binds);
            $row = $query->row();
            if ($row->count == 0) {
                $msg = $this->lang->line("Security CAPTCHA is incorrect.");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'danger');
                redirect(base_url() . 'dashboard/Auth/register');
                $this->db->close();
                die();

            } else {
                $user_password = $this->input->post('user_password');
                $dataArray = array(
                    "user_username" => $this->input->post('user_username'),
                    "user_email" => $this->input->post('user_email'),
                    "user_password" => $this->hash_password($user_password),
                    "user_referral" => $this->input->post('user_referral'),
                    "user_reg_date" => now(),
                );

                //Check Username is exist or not
                $user_username = $dataArray['user_username'];
                $check_username = $this->User_model->check_username('user_table', $user_username);
                if ($check_username == FALSE) {
                    $msg = $user_username." ".$this->lang->line("is_exist_in_our_system");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Auth/register');
                    $this->db->close();
                    die();
                }
                //Check Email is exist or not
                $user_email = $dataArray['user_email'];
                $check_email = $this->User_model->check_email('user_table', $user_email);
                if ($check_email == FALSE) {
                    $msg = $user_email." ".$this->lang->line("is_exist_in_our_system");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Auth/register');
                    $this->db->close();
                    die();
                }
                //Check Referral ID is exist or not
                $user_referral = $dataArray['user_referral'];
                if (!empty($user_referral))
                {
                    $check_referral = $this->User_model->check_referral('user_table', $user_referral);
                    if ($check_referral == FALSE) {
                        $msg = $this->lang->line("This Referral ID is not exist in our system: ").$user_referral;
                        $this->session->set_flashdata('msg',$msg);
                        $this->session->set_flashdata('msgType','warning');
                        redirect(base_url().'dashboard/Auth/register');
                        $this->db->close();
                        die();
                    }
                }

                //Insert $dataArray to DB
                $result = $this->Common_model->data_insert("user_table",$dataArray);
                if ($result == TRUE) {
                    //Send welcome email to new user
                    $login_url = base_url()."dashboard/Auth";
                    $to = $user_email;
                    $cc = false; //To send a copy of email
                    $subject = $this->lang->line("New Account Information");
                    $message = $this->lang->line("email_new_account_information")
                        .$message = "- ".$this->lang->line("Login URL").": <a href='$login_url'>$login_url</a><br>- ".$this->lang->line("Username").": ".$user_username."<br>- ".$this->lang->line("Password").": ".$user_password."<br><br>";
                    $this->Shared_model->send_email($to, $cc, $subject, $message);

                    //Insert data into activity_table
                    $this->db->select('user_id');
                    $q = $this->db->get_where('user_table', array('user_username'=> $user_username));
                    $last_id = $q->result()[0]->user_id;
                    $dataArray = array(
                        "activity_user_id" => $last_id,
                        "activity_time" => now(),
                        "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                        "activity_ip" => $this->input->ip_address(),
                        "activity_desc" => $this->lang->line("User joined."),
                    );
                    $this->Common_model->data_insert("activity_table",$dataArray);

                    $data['message_display'] = $this->lang->line("registration_successfully");
                    $data['pageTitle'] = $this->lang->line("user_login");
                    $data['showCaptcha'] = $this->Shared_model->generate_captcha();
                    $this->load->view('dashboard/auth/login_view', $data);

                } else {
                    $data['message_display'] = $this->lang->line("something_wrong");
                    $data['pageTitle'] = $this->lang->line("register_a_new_membership");
                    $data['showCaptcha'] = $this->Shared_model->generate_captcha();
                    $this->load->model("dashboard/Settings_model");
                    $data["settingContent"] = $this->Settings_model->get_setting_content('setting_table', 1)->result()[0];
                    $this->load->view('dashboard/auth/register_view', $data);
                }
            }
        }


    }


    //============================ User login process
    public function user_login_process() {
        $this->form_validation->set_rules('user_username', $this->lang->line("Username"), 'trim|required|xss_clean|min_length[5]',
            array(
                'required'      => $this->lang->line("field_is_required"),
                'min_length'      => $this->lang->line("must_be_minimum_characters")));
        $this->form_validation->set_rules('user_password', $this->lang->line("Password"), 'trim|required|xss_clean|min_length[8]',
            array(
                'required'      => $this->lang->line("field_is_required"),
                'min_length'      => $this->lang->line("must_be_minimum_characters")
            ));
        $this->form_validation->set_rules('captcha', $this->lang->line("Security Captcha"), 'trim|required|xss_clean|min_length[5]|max_length[10]',
            array(
                'required'      => $this->lang->line("field_is_required"),
                'min_length'      => $this->lang->line("must_be_minimum_characters"),
                'max_length'      => $this->lang->line("must_be_maximum_characters")
            ));
        $this->form_validation->set_rules('rememberme', $this->lang->line("Remember Me"), 'trim|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if(isset($this->session->userdata['user_username'])){
                redirect(base_url().'dashboard/Dashboard');
            }else{
                $data['showCaptcha'] = $this->Shared_model->generate_captcha();
                $this->load->view('dashboard/auth/login_view', $data);
            }

        } else {
            //First, delete old CAPTCHA:
            $expiration = time() - 900; // 900 sec limit
            $this->db->query("DELETE FROM captcha_table WHERE captcha_time < $expiration");

            //Then see if a captcha exists:
            $sql = 'SELECT COUNT(*) AS count FROM captcha_table WHERE captcha_word = ? AND captcha_ip_address = ? AND captcha_time > ?';
            $clean_captcha = $this->Shared_model->number2english($_POST['captcha']);
            $binds = array($clean_captcha, $this->input->ip_address(), $expiration);
            $query = $this->db->query($sql, $binds);
            $row = $query->row();
            if ($row->count == 0)
            {
                $msg = $this->lang->line("Security CAPTCHA is incorrect.");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Auth');
                $this->db->close();
                die();

            } else {
                //Captcha is correct
                $user_username = $this->input->post('user_username');
                $user_password = $this->input->post('user_password');
                $remember_me = $this->input->post('rememberme');
                if ($remember_me == "on")
                    $expired_time = (86400); // 1 Day
                else
                    $expired_time = 3600; // 1 hour

                if ($this->User_model->auth_user_information('user_table', $user_username, $this->hash_password($user_password)) == true)
                {
                    //Success Login
                    $result = $this->User_model->read_user_information('user_table', $user_username);
                    if ($result != false) {
                        //Check PC is exist
                        //...

                        //Set user session
                        $session_data = array(
                            'user_id' => $result[0]->user_id,
                            'user_username' => $result[0]->user_username,
                            'user_email' => $result[0]->user_email,
                            'user_mobile' => $result[0]->user_mobile,
                            'user_role_id' => $result[0]->user_role_id,
                            'user_type' => $result[0]->user_type,
                            'expired_time' => $expired_time
                        );
                        $this->session->set_userdata($session_data);
                        $this->session->mark_as_temp(array('user_id'  => $expired_time, 'user_username' => $expired_time, 'user_email' => $expired_time, 'user_mobile' => $expired_time,
                            'user_role_id' => $expired_time, 'user_type' => $expired_time, 'expired_time' => $expired_time));

                        //Insert data into activity_table
                        $dataArray = array(
                            "activity_user_id" => $result[0]->user_id,
                            "activity_time" => now(),
                            "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                            "activity_ip" => $this->input->ip_address(),
                            "activity_login_status" => 1,
                            "activity_desc" => $this->lang->line("User login into the Dashboard."),
                        );
                        $this->Common_model->data_insert("activity_table",$dataArray);

                        redirect(base_url().'dashboard/Dashboard');

                    }

                } else {
                    $msg = $this->lang->line("Invalid Username or Password.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Auth');
                    $this->db->close();
                    die();
                }
            }

        }
    }


    //============================ User logout process
    public function user_logout_process() {
        //Clear session
        unset(
            $_SESSION['user_id'],
            $_SESSION['user_username'],
            $_SESSION['user_email'],
            $_SESSION['user_mobile'],
            $_SESSION['user_role_id'],
            $_SESSION['user_type']
        );

        $msg = $this->lang->line("Successfully Logout!");
        $this->session->set_flashdata('msg',$msg);
        $this->session->set_flashdata('msgType','success');
        redirect(base_url().'dashboard/Auth');
        $this->db->close();
        die();
    }


    //============================ Forgot password
    public function forgot_password() {
        if(isset($_POST['user_email']))
        {
            $this->form_validation->set_rules('user_email', $this->lang->line("Email"), 'trim|required|xss_clean|valid_email|min_length[3]|max_length[60]',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'min_length'      => $this->lang->line("must_be_minimum_characters"),
                    'max_length'      => $this->lang->line("must_be_maximum_characters"),
                    'valid_email'     => $this->lang->line("is_not_valid_an_email_address")));
            $this->form_validation->set_rules('captcha', $this->lang->line("Security Captcha"), 'trim|required|xss_clean|min_length[5]|max_length[10]',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'min_length'      => $this->lang->line("must_be_minimum_characters"),
                    'max_length'      => $this->lang->line("must_be_maximum_characters")
                ));

            if ($this->form_validation->run() == FALSE) {
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'danger');
                redirect(base_url() . "dashboard/Auth/forgot_password");

            }else{
                //Check if user_email is exist or not
                $user_email = $this->input->post('user_email');
                $check_email = $this->User_model->check_email('user_table', $user_email);
                if ($check_email == FALSE) {
                    //First, delete old CAPTCHA:
                    $expiration = time() - 900; // 900 sec limit
                    $this->db->query("DELETE FROM captcha_table WHERE captcha_time < $expiration");

                    //Then see if a captcha exists:
                    $sql = 'SELECT COUNT(*) AS count FROM captcha_table WHERE captcha_word = ? AND captcha_ip_address = ? AND captcha_time > ?';
                    $clean_captcha = $this->Shared_model->number2english($_POST['captcha']);
                    $binds = array($clean_captcha, $this->input->ip_address(), $expiration);
                    $query = $this->db->query($sql, $binds);
                    $row = $query->row();
                    if ($row->count == 0)
                    {
                        $msg = $this->lang->line("Security CAPTCHA is incorrect.");
                        $this->session->set_flashdata('msg',$msg);
                        $this->session->set_flashdata('msgType','danger');
                        redirect(base_url().'dashboard/Auth/forgot_password');
                        $this->db->close();
                        die();

                    } else {
                        //Captcha is correct
                        //Set user session
                        $session_data = array(
                            'forgot_password_user_email' => $user_email,
                        );
                        $this->session->set_userdata($session_data);
                        $this->session->mark_as_temp(array('user_email'  => 300));

                        //Encrypted email address
                        $encode_user_email = $this->encrypt->encode($user_email);

                        $to = $user_email;
                        $cc = false; //To send a copy of email
                        $subject = $this->lang->line("Reset Password Link");
                        $reset_link = base_url()."dashboard/Auth/reset_password_process/".$encode_user_email;
                        $message = $this->lang->line("email_reset_password_link")
                            .$message = "<br><br><a target='_blank' href='$reset_link'>$reset_link</a> <br><br>";
                        $this->Shared_model->send_email($to, $cc, $subject, $message);

                        $msg = $this->lang->line("Please check your email and click on the Reset Password link.");
                        $this->session->set_flashdata('msg',$msg);
                        $this->session->set_flashdata('msgType','success');
                        redirect(base_url().'dashboard/Auth');
                        $this->db->close();
                        die();
                    }

                }else{
                    $msg = $user_email." ".$this->lang->line("is not exist in our system.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','danger');
                    redirect(base_url().'dashboard/Auth/forgot_password');
                    $this->db->close();
                    die();
                }
            }
        }

        $this->is_login();
        $data['showCaptcha'] = $this->Shared_model->generate_captcha();
        $data['pageTitle'] = $this->lang->line("Forgot Password");
        $data['showCaptcha'] = $this->Shared_model->generate_captcha();
        $this->load->view('dashboard/auth/forgot_password_view', $data);
    }


    //============================ Forgot password process
    public function reset_password_process()
    {
        $encode_email = $this->uri->segment(4);
        $decode_email = $this->encrypt->decode($encode_email);

        if(isset($_SESSION['forgot_password_user_email']))
        {
            if ($_SESSION['forgot_password_user_email'] == $decode_email)
            {
                //Generate random password and reset it
                $this->load->helper('string');
                $new_user_password = random_string('alnum', 8);
                $q = $this->User_model->reset_password_process($decode_email, $this->hash_password($new_user_password));
                if ($q == TRUE)
                {
                    //Send new password to user_email
                    $to = $decode_email;
                    $cc = false; //To send a copy of email
                    $subject = $this->lang->line("Your New Password");
                    $message = $this->lang->line("email_your_new_password_is")
                        .$message = "<span style='font-weight: 700; color: #444;'>$new_user_password</span> <br><br>";
                    $this->Shared_model->send_email($to, $cc, $subject, $message);

                    $msg = $this->lang->line("Your new password sent to your email address.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Auth');

                }else{
                    $msg = $this->lang->line("Error!");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','danger');
                    redirect(base_url().'dashboard/Auth/forgot_password');
                }

            }else{
                $msg = $this->lang->line("Forgot password's link is not valid!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Auth/forgot_password');
            }

        }else{
            $msg = $this->lang->line("Forgot password's link is not valid!");
            $this->session->set_flashdata('msg',$msg);
            $this->session->set_flashdata('msgType','danger');
            redirect(base_url().'dashboard/Auth/forgot_password');
        }
    }

}