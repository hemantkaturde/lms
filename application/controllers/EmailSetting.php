<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';

    class EmailSetting extends BaseController
    {
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model('login_model');
            $this->load->model('emailSetting_model');
            $this->load->model('database');
            // $this->load->library('dbOperations');
            // Datas -> libraries ->BaseController / This function used load user sessions
            $this->datas();
            // isLoggedIn / Login control function /  This function used login control
            $isLoggedIn = $this->session->userdata('isLoggedIn');
            if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
            {
                redirect('login');
            }
        }

        public function emailtemplateListing()
        {
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            // $this->load->library('pagination');
            
            // $count = $this->role_model->roleListingCount($searchText);

			// $returns = $this->paginationCompress ( "roleListing/", $count, 10 );
            
            $data['template'] = $this->emailSetting_model->emailtemplateListing($searchText);
            // $data['userRecords'] = $this->role_model->roleListing($searchText, $returns["page"], $returns["segment"]);
            $process = 'Email Template Listing';
            $processFunction = 'emailSetting/emailtemplateListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Email Template';
            $this->loadViews("emailSetting/emailTemplateList", $this->global, $data , NULL);
        }

        function get_single_emailTemplate($etempId = NULL)
        {
            $data['templateInfo'] = $this->emailSetting_model->getTemplateInfo($etempId);
            echo json_encode($data);
        }

        public function template_insert($id)
        {
            $this->load->library('form_validation');
        
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('template_name'))));
                $module = $this->security->xss_clean($this->input->post('template_module'));
                $desc = $this->security->xss_clean($this->input->post('template_desc'));
                if($id == 0)
                {
                    $templateInfo = array('etemp_name'=>$name, 'etemp_desc'=>$desc, 'etemp_module'=> $module,
                                'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                        
                    // $result = $this->user_model->addNewUser($userInfo);
                    $result = $this->database->data_insert('tbl_email_template', $templateInfo);
                    if($result > 0)
                    {
                    $process = 'Email Template Insert';
                    $processFunction = 'EmailSetting/template_insert';
                    $this->logrecord($process,$processFunction);
                       echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }else
                {
                    $courseInfo = array('etemp_name'=>$name, 'etemp_desc'=>$desc, 'etemp_module'=> $module,
                                'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));

                    $result = $this->database->data_update('tbl_email_template',$courseInfo,'etempId',$id);
                    
                    if($result == true)
                    {
                        $process = 'Email Template Update';
                        $processFunction = 'EmailSetting/template_insert';
                        $this->logrecord($process,$processFunction);
                        echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }            
        }

        // ==== Delete Course
        public function deleteTemplate($id)
        {
            $templateInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->database->data_update('tbl_email_template',$templateInfo,'etempId',$id);

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Template Delete';
                 $processFunction = 'EmailSetting/deleteTemplate';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }

        // ===============================  
        //  SMTP Setting
        public function emailsmtpListing()
        {
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            // $this->load->library('pagination');
            
            // $count = $this->role_model->roleListingCount($searchText);

			// $returns = $this->paginationCompress ( "roleListing/", $count, 10 );
            
            $data['smtp'] = $this->emailSetting_model->emailsmtpListing($searchText);
            // $data['userRecords'] = $this->role_model->roleListing($searchText, $returns["page"], $returns["segment"]);
            $process = 'Email SMTP Listing';
            $processFunction = 'emailSetting/emailsmtpListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Email SMTP';
            $this->loadViews("emailSetting/emailsmtpList", $this->global, $data , NULL);
        }

        function get_single_emailSmtp($smtpId = NULL)
        {
            $data['smtpInfo'] = $this->emailSetting_model->getSmtpInfo($smtpId);
            echo json_encode($data);
        }

        public function smtp_insert($id)
        {
            $this->load->library('form_validation');
        
                $host = ucwords(strtolower($this->security->xss_clean($this->input->post('host_name'))));
                $protocol = $this->security->xss_clean($this->input->post('protocol'));
                $port = $this->security->xss_clean($this->input->post('smtp_port'));
                $username = $this->security->xss_clean($this->input->post('smtp_username'));
                $password = $this->security->xss_clean($this->input->post('smtp_pass'));
                if($id == 0)
                {
                    $smtpInfo = array('smtp_host'=>$host, 'smtp_protocol'=>$protocol, 'smtp_port'=> $port, 'smtp_username'=>$username, 'smtp_password'=> $password,
                                'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                        
                    // $result = $this->user_model->addNewUser($userInfo);
                    $result = $this->database->data_insert('tbl_email_smtp', $smtpInfo);
                    if($result > 0)
                    {
                    $process = 'Email SMTP Insert';
                    $processFunction = 'EmailSetting/smtp_insert';
                    $this->logrecord($process,$processFunction);
                       echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }else
                {
                    $courseInfo = array('smtp_host'=>$host, 'smtp_protocol'=>$protocol, 'smtp_port'=> $port, 'smtp_username'=>$username, 'smtp_password'=> $password,
                                'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));

                    $result = $this->database->data_update('tbl_email_smtp',$courseInfo,'smtpId',$id);
                    
                    if($result == true)
                    {
                        $process = 'Email SMTP Update';
                        $processFunction = 'EmailSetting/template_insert';
                        $this->logrecord($process,$processFunction);
                        echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }            
        }

        // ==== Delete Course
        public function deleteSmtp($id)
        {
            $smtpInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->database->data_update('tbl_email_smtp',$smtpInfo,'smtpId',$id);

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Template Delete';
                 $processFunction = 'EmailSetting/deleteSmtp';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }


        // ===============================

    }

?>