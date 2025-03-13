<?php
class Shared_model extends CI_Model {

    //============================ Main construct
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
	}


    //============================ Check user is login or not
    private function is_login() {
        if (!isset($_SESSION['user_username']) && !isset($_SESSION['user_type']))
        {
            redirect(base_url()."dashboard/Auth");
            die();
        }
    }



    //============================ Send Email
	public function send_email($to, $cc, $subject, $message)
	{
	    //https://www.codeigniter.com/user_guide/libraries/email.html
	    // Send Email Guide
        /* $this->load->model("Shared_model");
          $to = $user_email;
        $cc = false;  //To send a copy of email
        $subject = $email_subject;
        $message = $email_body;
        $this->Shared_model->send_email($to, $cc, $subject, $message);*/

		//Connect to email setting table
		$q = $this->db->get_where('email_setting_table', array('email_setting_id'=> 1));
		$from = $q->result()[0]->email_setting_fromemail;

		//Check if send email is enable or not
		if ($q->result()[0]->email_setting_status == 1)
		{
			//Email content
            $direction = $this->lang->line("app_direction");
			$htmlMSG = "<div style='margin:15px 30px 15px 30px; padding:1px 8px 1px 8px; line-height: 23px; border:1px solid #CCCCCC; -webkit-border-radius: 1px; -moz-border-radius: 1px; border-radius: 1px; background-color:#F9F9F9; direction: $direction; font-family:Tahoma, Helvetica, sans-serif; font-size:13.5px; box-shadow: 0px 0px 5px #E9E9E9'>";
			$htmlMSG.= "<p><b>".$subject."</b></p>";
			$htmlMSG.= "<p style='padding-bottom: 7px;'>".$message."</p>";
			$htmlMSG.= "<p style='padding-top: 10px; border-top:1px solid #D4D4D4'>".html_entity_decode($q->result()[0]->email_setting_signature)."</p></div>";
			
			if($q->result()[0]->email_setting_mailtype == "smtp")
			{
				// ----------- SMTP Email ------------
				$config['protocol'] = 'smtp';
				$config['smtp_host'] = $q->result()[0]->email_setting_smtphost;
				$config['smtp_port'] = $q->result()[0]->email_setting_smtpport;
				$config['smtp_user'] = $q->result()[0]->email_setting_smtpuser;
				$config['smtp_pass'] = $this->encrypt->decode($q->result()[0]->email_setting_smtppass);
				if ($q->result()[0]->email_setting_crypto != "none") { $config['smtp_crypto'] = $q->result()[0]->email_setting_crypto; }
				$config['mailtype'] = 'html';
				$config['charset'] = 'utf-8';

                $this->load->library('email');
				$this->email->initialize($config);
				
				$this->email->set_newline("\r\n");
				$this->email->from($from, $q->result()[0]->email_setting_fromname);
				$this->email->to($to);
				if ($q->result()[0]->email_setting_cc == true) { $this->email->cc($q->result()[0]->email_setting_cc); }
				$this->email->subject($subject);
				$this->email->message($htmlMSG);
				$result = $this->email->send();
				if($result){
					//echo "SMTP Mail sent successfully...";
				}
				else{
					//echo "SMTP Error in mail sending...";
				}
				
			}
			// ---------- PHP Mail -----------
			elseif ($q->result()[0]->email_setting_mailtype == "mail" or $q->result()[0]->email_setting_mailtype == "sendmail"){
				
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: <$from>" . "\r\n";
				if(@mail($to,$subject,$htmlMSG,$headers))
				{
					//echo "PHP mail sending...";
				}else{
					//echo "PHP mail error in mail sending...";
				}
				
			}
			
		} //.end of if send email is enable
	}


    
    //============================ Generate CAPTCHA
    public function generate_captcha() {
        $this->load->helper('captcha');
        //Generate CAPTCHA
        $vals = array(
            'word' => rand(10000,99999),
            'word_length' => 5,  // To set length of captcha word.
            'img_path'      => './assets/captcha/',
            'img_url'       => base_url().'assets/captcha/',
            'img_width'     => 120,
            'img_height'    => 36,
            'expiration'    => 900,
            'font_size'     => 21,

            // White background and border, black text and red grid
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(50, 50, 50),
                'grid' => array(160, 160, 160)
            )
        );
        $cap = create_captcha($vals);
        //Insert CAPTCHA word into the DB
        $dataArray = array(
            'captcha_time'  => $cap['time'],
            'captcha_ip_address'    => $this->input->ip_address(),
            'captcha_word'          => $cap['word']
        );
        $this->Common_model->data_insert("captcha_table", $dataArray);

        return $cap['image'];
    }


    //============================ English Number 2 Arabic
    function number2farsi($srting)
    {
        $en_num = array('0','1','2','3','4','5','6','7','8','9');
        $fa_num = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
        return str_replace($en_num, $fa_num, $srting);
    }


    //============================ Arabic Number 2 English
    function number2english($srting)
    {
        $fa_num = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
        $en_num = array('0','1','2','3','4','5','6','7','8','9');
        return str_replace($fa_num, $en_num, $srting);
    }


    //============================ Check user permission
    public function check_permission($table, $user_role_id, $last_segment)
    {
        $this->is_login();
        if($_SESSION['user_role_id'] != 1)
        {
            $q = $this->db->query("SELECT user_role_permission
                               FROM $table
                               WHERE (user_role_id = $user_role_id);");
            $user_role_permission = $q->row()->user_role_permission;

            $user_permission = (explode(' ',$user_role_permission));
            $allow_access = array_search($last_segment, $user_permission);
            if (empty($allow_access))
            {
                //Deny Access
                $msg = $this->lang->line("You have no permission to access this page.");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Dashboard/message');
                $this->db->close();
                die();
            }else
                return "Allow";
        }
    }



	//============================ Send push notification via OneSignal
    function send_push_notification_one_signal($content_id, $push_notification_title, $push_notification_message, $push_notification_image, $push_notification_external_link)
    {
        //Connect to setting table
        $q = $this->db->get_where('content_table', array('content_id'=> $content_id));
        $content_onesignal_app_id = $this->encrypt->decode($q->result()[0]->content_onesignal_app_id);
        $content_onesignal_rest_api_key = $this->encrypt->decode($q->result()[0]->content_onesignal_rest_api_key);
        define("ONESIGNAL_APP_ID", $content_onesignal_app_id);
        define("ONESIGNAL_REST_KEY", $content_onesignal_rest_api_key);
		
		if($push_notification_external_link != "") $external_link =  $push_notification_external_link;
        else $external_link = false;

		$push_notification_image_url = "";
        if($push_notification_image != "") $push_notification_image_url = base_url()."assets/upload/notification/$push_notification_image";

        $content      = array(
            "en" => $push_notification_message
        );


        if($external_link == false)
		{
			if($push_notification_image != "")
			{
				$fields = array(
					'app_id' => ONESIGNAL_APP_ID,
					'included_segments' => array('All'),
					'data' => array("foo" => "bar"),
					'headings'=> array("en" => $push_notification_title),
					'contents' => $content,
					"big_picture" => $push_notification_image_url
				);

			}else{
				$fields = array(
					'app_id' => ONESIGNAL_APP_ID,
					'included_segments' => array('All'),
					'data' => array("foo" => "bar"),
					'headings'=> array("en" => $push_notification_title),
					'contents' => $content
				);
			}


		}else{
			if($push_notification_image != "")
			{
				$fields = array(
					'app_id' => ONESIGNAL_APP_ID,
					'included_segments' => array('All'),
					'data' => array("foo" => "bar"),
					'url' => $external_link,
					'headings'=> array("en" => $push_notification_title),
					'contents' => $content,
					"big_picture" => $push_notification_image_url
				);

			}else{
				$fields = array(
					'app_id' => ONESIGNAL_APP_ID,
					'included_segments' => array('All'),
					'data' => array("foo" => "bar"),
					'url' => $external_link,
					'headings'=> array("en" => $push_notification_title),
					'contents' => $content
				);
			}
		}
			

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.ONESIGNAL_REST_KEY
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }


	//============================ Send push notification via OneSignal
    function send_push_notification_one_signal_specific_user($push_notification_title, $push_notification_message, $push_notification_external_link, $push_notification_player_id)
    {
        //Connect to setting table
        $q = $this->db->get_where('setting_table', array('setting_id'=> 1));
        $setting_one_signal_app_id = $this->encrypt->decode($q->result()[0]->setting_one_signal_app_id);
        $setting_one_signal_rest_api_key = $this->encrypt->decode($q->result()[0]->setting_one_signal_rest_api_key);
        define("ONESIGNAL_APP_ID", $setting_one_signal_app_id);
        define("ONESIGNAL_REST_KEY", $setting_one_signal_rest_api_key);

        if($push_notification_external_link != "") $external_link =  $push_notification_external_link;
        else $external_link = false;

        $content      = array(
            "en" => $push_notification_message
        );


        if($external_link == false)
        {
            $fields = array(
                'app_id' => ONESIGNAL_APP_ID,
                'include_player_ids' => $push_notification_player_id,
                'data' => array("foo" => "bar"),
                //'url' => $external_link,
                'headings'=> array("en" => $push_notification_title),
                'contents' => $content
            );

        }else{
            $fields = array(
                'app_id' => ONESIGNAL_APP_ID,
                'include_player_ids' => $push_notification_player_id,
                'data' => array("foo" => "bar"),
                'url' => $external_link,
                'headings'=> array("en" => $push_notification_title),
                'contents' => $content
            );
        }


        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.ONESIGNAL_REST_KEY
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
