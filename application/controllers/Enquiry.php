<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';

    class Enquiry extends BaseController
    {
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model(array('login_model', 'enquiry_model', 'database'));
            $this->load->library('form_validation');
            $this->load->library('mail');
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

        public function enquirylisting()
        {
            $process = 'Enquiry Listing';
            $processFunction = 'Enquiry/enquirylisting';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Enquiry Management';
            $this->loadViews("enquiry/enquiryList", $this->global, NULL , NULL);
        }


        public function fetchenquiry(){

            $params = $_REQUEST;
            $totalRecords = $this->enquiry_model->getEnquiryCount($params); 
            $queryRecords = $this->enquiry_model->getEnquirydata($params); 
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
    

        function get_signle_enquiry($enqId = NULL)
        {
            $enqId = $this->input->post('enq_id');
            $data = $this->enquiry_model->getEnquiryInfo($enqId);
            echo json_encode($data);
        }

        public function enquiry_insert($id)
        {
            $this->load->library('form_validation');
        
                $name = $this->security->xss_clean($this->input->post('full_name'));
                $mobile = $this->security->xss_clean($this->input->post('mobile_no'));
                $mobile1 = $this->security->xss_clean($this->input->post('alternate_mobile'));
                $email = $this->security->xss_clean($this->input->post('email'));
                $email1 = $this->security->xss_clean($this->input->post('alternamte_email'));
                $qualification = $this->security->xss_clean($this->input->post('qualification'));
                $country = $this->security->xss_clean($this->input->post('country'));
                $state = $this->security->xss_clean($this->input->post('state'));
                $city = $this->security->xss_clean($this->input->post('city'));
                $purpose = $this->security->xss_clean($this->input->post('purpose'));
                $enq_date = $this->security->xss_clean($this->input->post('enq_date'));
                $source = $this->security->xss_clean($this->input->post('enquiry_type'));
                $remark = $this->security->xss_clean($this->input->post('remark'));

                if($id == 0)
                {
                    $enquiryInfo = array('enq_fullname'=>$name, 'enq_mobile'=>$mobile, 'enq_mobile1'=>$mobile1, 'enq_date'=> date('Y-m-d', strtotime($enq_date)),
                                'enq_email'=>$email, 'enq_email1'=>$email1,'enq_qualification'=> $qualification, 'enq_purpose'=>$purpose, 'enq_country'=>$country,'enq_state'=> $state, 'enq_city'=> $city,
                                'enq_source'=>$source, 'enq_remark'=>$remark,
                                'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                        
                    // $result = $this->user_model->addNewUser($userInfo);
                    $result = $this->database->data_insert('tbl_enquiry', $enquiryInfo);
                    if($result > 0)
                    {
                    $process = 'Enquiry Insert';
                    $processFunction = 'Enquiry/enquiry_insert';
                    $this->logrecord($process,$processFunction);
                       echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }else
                {
                    $enquiryInfo = array('enq_fullname'=>$name, 'enq_mobile'=>$mobile, 'enq_mobile1'=>$mobile1, 'enq_date'=> date('Y-m-d', strtotime($enq_date)),
                                'enq_email'=>$email, 'enq_email1'=>$email1,'enq_qualification'=> $qualification, 'enq_purpose'=>$purpose, 'enq_country'=>$country,'enq_state'=> $state, 'enq_city'=> $city,
                                'enq_source'=>$source, 'enq_remark'=>$remark,
                                'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));

                    $result = $this->database->data_update('tbl_enquiry',$enquiryInfo,'enq_id',$id);
                    
                    if($result == true)
                    {
                        $process = 'Enquiry Update';
                        $processFunction = 'Enquiry/enquiry_insert';
                        $this->logrecord($process,$processFunction);
                        echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }            
        }


        public function createenquiry(){
            $post_submit = $this->input->post();

            if(!empty($post_submit)){
                $createenquiry_response = array();
                $data = array(
                    'enq_fullname' => $this->input->post('full_name'),
                    'enq_mobile'=> $this->input->post('mobile_no'),
                    'enq_mobile1' => $this->input->post('alternate_mobile'),
                    'enq_email'=> $this->input->post('email'),
                    'enq_email1' => $this->input->post('alternamte_email'),
                    'enq_qualification' => $this->input->post('qualification'),
                    'enq_purpose' => $this->input->post('purpose'),
                    'enq_date' => date('Y-m-d', strtotime($this->input->post('enq_date'))),
                    'enq_country'=> $this->input->post('country'),
                    'enq_state'=>$this->input->post('state'),
                    'enq_city'=>$this->input->post('city'),
                    'enq_source'=>$this->input->post('enquiry_type'),
                    'enq_remark' => $this->input->post('remarks')
                );

                $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('mobile_no', 'Mobile_no', 'trim|required|numeric|greater_than[0]|exact_length[10]');
                $this->form_validation->set_rules('alternate_mobile', 'Alternate Mobile', 'trim');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('alternamte_email', 'Alternamte Email', 'trim');
                $this->form_validation->set_rules('qualification', 'Qualification', 'trim');
                $this->form_validation->set_rules('purpose', 'Purpose', 'trim');
                $this->form_validation->set_rules('enq_date', 'Enq Date', 'trim');
                $this->form_validation->set_rules('country', 'Country', 'trim');
                $this->form_validation->set_rules('state', 'State', 'trim');
                $this->form_validation->set_rules('city', 'City', 'trim');
                $this->form_validation->set_rules('enquiry_type', 'Enquiry Type', 'trim');
                $this->form_validation->set_rules('remarks', 'Remarks', 'trim');


                if($this->form_validation->run() == FALSE){
                    $createenquiry_response['status'] = 'failure';
                    $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                }else{

                    /*check If course name is unique*/
                    $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname(trim($this->input->post('full_name')));

                    if($check_uniqe){
                        $createenquiry_response['status'] = 'failure';
                        $createenquiry_response['error'] = array('full_name'=>'Name Already Exists', 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                    }else{
                        $saveEnquirydata = $this->enquiry_model->saveEnquirydata('',$data);
                        if($saveEnquirydata){
                            $createenquiry_response['status'] = 'success';
                            $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                        }
                    }
                }
        
                echo json_encode($createenquiry_response);
            }

        }

        public function updateenquiry($id= null){
            $post_submit = $this->input->post();

            if(!empty($post_submit)){
                $createenquiry_response = array();
                $data = array(
                    'enq_fullname' => $this->input->post('full_name'),
                    'enq_mobile'=> $this->input->post('mobile_no'),
                    'enq_mobile1' => $this->input->post('alternate_mobile'),
                    'enq_email'=> $this->input->post('email'),
                    'enq_email1' => $this->input->post('alternamte_email'),
                    'enq_qualification' => $this->input->post('qualification'),
                    'enq_purpose' => $this->input->post('purpose'),
                    'enq_date' => date('Y-m-d', strtotime($this->input->post('enq_date'))),
                    'enq_country'=> $this->input->post('country'),
                    'enq_state'=>$this->input->post('state'),
                    'enq_city'=>$this->input->post('city'),
                    'enq_source'=>$this->input->post('enquiry_type'),
                    'enq_remark' => $this->input->post('remarks')
                );

                $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('mobile_no', 'Mobile_no', 'trim|required|numeric|greater_than[0]|exact_length[10]');
                $this->form_validation->set_rules('alternate_mobile', 'Alternate Mobile', 'trim');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('alternamte_email', 'Alternamte Email', 'trim');
                $this->form_validation->set_rules('qualification', 'Qualification', 'trim');
                $this->form_validation->set_rules('purpose', 'Purpose', 'trim');
                $this->form_validation->set_rules('enq_date', 'Enq Date', 'trim');
                $this->form_validation->set_rules('country', 'Country', 'trim');
                $this->form_validation->set_rules('state', 'State', 'trim');
                $this->form_validation->set_rules('city', 'City', 'trim');
                $this->form_validation->set_rules('enquiry_type', 'Enquiry Type', 'trim');
                $this->form_validation->set_rules('remarks', 'Remarks', 'trim');


                if($this->form_validation->run() == FALSE){
                    $createenquiry_response['status'] = 'failure';
                    $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                }else{

                    /*check If enquiry name is unique*/
                    
                    if($id == null)
                    {
                        $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname(trim($this->input->post('full_name')));
                    }
                    else
                    {
                        $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname_update($id, trim($this->input->post('full_name')));
                    }

                    if($check_uniqe){
                        $createenquiry_response['status'] = 'failure';
                        $createenquiry_response['error'] = array('full_name'=>'Name Already Exists', 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                    }else{
                        $saveEnquirydata = $this->enquiry_model->saveEnquirydata($id,$data);
                        if($saveEnquirydata){
                            $createenquiry_response['status'] = 'success';
                            $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                        }
                    }
                }
        
                echo json_encode($createenquiry_response);
            }

        }

        // ==== Delete Course
        public function deleteEnquiry()
        {
            $post_submit = $this->input->post();

            $enquiryInfo = array('isDeleted'=>1,'updatedBy'=> $this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->database->data_update('tbl_enquiry',$enquiryInfo,'enq_id',$this->input->post('id'));

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Enquiry Delete';
                 $processFunction = 'Enquiry/deleteEnquiry';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }

        // ==== Delete Course
        public function sendEnquiryLink()
        {
            $post_submit = $this->input->post();

            $name = "Snehal More";
            $to = "snehasmore3@gmail.com";
            $Subject = 'Test Email -'.date('Y-m-d H:i:s');

            $Body  = 'Demo Content';

            $sendmail= $this->mail->sendMail($name,$to,$Subject,$Body);

            // $result = $this->database->data_update('tbl_enquiry',$enquiryInfo,'enq_id',$this->input->post('id'));

            if (!empty($sendmail)) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Enquiry Link Sent';
                 $processFunction = 'Enquiry/sendEnquiryLink';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

?>