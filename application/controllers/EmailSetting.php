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
            $this->load->library('form_validation');
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

            $process = 'Email SMTP Listing';
            $processFunction = 'emailSetting/emailsmtpListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'SMTP Configuration';
            $this->loadViews("emailSetting/emailsmtpList", $this->global, NULL , NULL);
        }

        function get_single_emailSmtp($smtpId = NULL)
        {
            $data = $this->emailSetting_model->getSmtpInfo($smtpId);
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

        public function fetchSmtpsetting(){
            $params = $_REQUEST;
            $totalRecords = $this->emailSetting_model->getTemplateCount($params); 
            $queryRecords = $this->emailSetting_model->getTemplatedata($params); 

            $data = array();
            foreach ($queryRecords as $key => $value)
            {
                $i = 0;
                foreach($value as $v)
                {
                    $data[$key][$i] = $v;
                    $i++;
                }
            }
            $json_data = array(
                "draw"            => intval( $params['draw'] ),   
                "recordsTotal"    => intval( $totalRecords ),  
                "recordsFiltered" => intval($totalRecords),
                "data"            => $data   // total data array
                );
            echo json_encode($json_data);
        }

        public function createemailsmtp(){

            $post_submit = $this->input->post();
            if(!empty($post_submit)){
                $createsmtp_response = array();
                $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required');
                $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|required');
                $this->form_validation->set_rules('protocol', 'Protocol', 'trim|required');
                $this->form_validation->set_rules('smtp_username', 'SMTP Username', 'trim|required');
                $this->form_validation->set_rules('smtp_password', 'SMTP Password', 'trim|required');
                $this->form_validation->set_rules('from_name', 'From Name', 'trim|required');
                $this->form_validation->set_rules('email_name', 'Email Name', 'trim|required');
                $this->form_validation->set_rules('cc_email', 'CC Email', 'trim');
                $this->form_validation->set_rules('bcc_email', 'Bcc Email', 'trim');

                if($this->form_validation->run() == FALSE){
                    $createsmtp_response['status'] = 'failure';
                    $createsmtp_response['error'] = array('smtp_host'=>strip_tags(form_error('smtp_host')), 'smtp_port'=>strip_tags(form_error('smtp_port')), 'protocol'=>strip_tags(form_error('protocol')), 'smtp_username'=>strip_tags(form_error('smtp_username')),'smtp_password'=>strip_tags(form_error('smtp_password')),'from_name'=>strip_tags(form_error('from_name')),'email_name'=>strip_tags(form_error('email_name')),'cc_email'=>strip_tags(form_error('cc_email')),'bcc_email'=>strip_tags(form_error('bcc_email')));
                }else{

                    $data = array(
                        'smtp_host' => $this->input->post('smtp_host'),
                        'smtp_port'=> $this->input->post('smtp_port'),
                        'smtp_protocol' => $this->input->post('protocol'),
                        'smtp_username'=> $this->input->post('smtp_username'),
                        'smtp_password' => $this->input->post('smtp_password'),
                        'from_name' => $this->input->post('from_name'),
                        'email_name' => $this->input->post('email_name'),
                        'cc_email' => $this->input->post('cc_email'),
                        'bcc_email'=> $this->input->post('bcc_email'),
                    );

                    $saveSmtpdata = $this->emailSetting_model->saveSmtpdata('',$data);
                    if($saveSmtpdata){
                        $createsmtp_response['status'] = 'success';
                        $createsmtp_response['error'] = array('smtp_host'=>'', 'smtp_port'=>'', 'protocol'=>'', 'smtp_username'=>'','smtp_password'=>'','from_name'=>'','email_name'=>'','cc_email'=>'','bcc_email'=>'');
                    }else{
                        $createsmtp_response['status'] = 'failure';
                        $createsmtp_response['error'] = array('smtp_host'=>'', 'smtp_port'=>'', 'protocol'=>'', 'smtp_username'=>'','smtp_password'=>'','from_name'=>'','email_name'=>'','cc_email'=>'','bcc_email'=>'');
                    }

                }
                echo json_encode($createsmtp_response);
            }

        }

        public function deletesmtp(){
            $post_submit = $this->input->post();
            if(!empty($post_submit)){
                $deletesmtp_response =array();
                    $Info = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                    $result = $this->emailSetting_model->data_update('tbl_email_smtp',$Info,'smtpId',$this->input->post('id'));
                    if($result){
                        $deletesmtp_response['status'] = 'success';
                        $process = 'Delete SMTP';
                        $processFunction = 'EmailSetting/Delete SMTP';
                        $this->logrecord($process,$processFunction);
                    }else
                    {
                        $deletesmtp_response['status'] = 'filure';
                    }
          
                echo json_encode($deletesmtp_response);
            }
        }

        public function updateSMTP(){
            $post_submit = $this->input->post();
            if(!empty($post_submit)){
                $createsmtp_response = array();
                $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required');
                $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|required');
                $this->form_validation->set_rules('protocol', 'Protocol', 'trim|required');
                $this->form_validation->set_rules('smtp_username', 'SMTP Username', 'trim|required');
                $this->form_validation->set_rules('smtp_password', 'SMTP Password', 'trim|required');
                $this->form_validation->set_rules('from_name', 'From Name', 'trim|required');
                $this->form_validation->set_rules('email_name', 'Email Name', 'trim|required');
                $this->form_validation->set_rules('cc_email', 'CC Email', 'trim');
                $this->form_validation->set_rules('bcc_email', 'Bcc Email', 'trim');

                if($this->form_validation->run() == FALSE){
                    $createsmtp_response['status'] = 'failure';
                    $createsmtp_response['error'] = array('smtp_host'=>strip_tags(form_error('smtp_host')), 'smtp_port'=>strip_tags(form_error('smtp_port')), 'protocol'=>strip_tags(form_error('protocol')), 'smtp_username'=>strip_tags(form_error('smtp_username')),'smtp_password'=>strip_tags(form_error('smtp_password')),'from_name'=>strip_tags(form_error('from_name')),'email_name'=>strip_tags(form_error('email_name')),'cc_email'=>strip_tags(form_error('cc_email')),'bcc_email'=>strip_tags(form_error('bcc_email')));
                }else{

                    $data = array(
                        'smtp_host' => $this->input->post('smtp_host'),
                        'smtp_port'=> $this->input->post('smtp_port'),
                        'smtp_protocol' => $this->input->post('protocol'),
                        'smtp_username'=> $this->input->post('smtp_username'),
                        'smtp_password' => $this->input->post('smtp_password'),
                        'from_name' => $this->input->post('from_name'),
                        'email_name' => $this->input->post('email_name'),
                        'cc_email' => $this->input->post('cc_email'),
                        'bcc_email'=> $this->input->post('bcc_email'),
                    );

                    $saveSmtpdata = $this->emailSetting_model->saveSmtpdata($this->input->post('smtpId'),$data);
                    if($saveSmtpdata){
                        $createsmtp_response['status'] = 'success';
                        $createsmtp_response['error'] = array('smtp_host'=>'', 'smtp_port'=>'', 'protocol'=>'', 'smtp_username'=>'','smtp_password'=>'','from_name'=>'','email_name'=>'','cc_email'=>'','bcc_email'=>'');
                    }else{
                        $createsmtp_response['status'] = 'failure';
                        $createsmtp_response['error'] = array('smtp_host'=>'', 'smtp_port'=>'', 'protocol'=>'', 'smtp_username'=>'','smtp_password'=>'','from_name'=>'','email_name'=>'','cc_email'=>'','bcc_email'=>'');
                    }

                }
                echo json_encode($createsmtp_response);
            }
        }

    }

?>