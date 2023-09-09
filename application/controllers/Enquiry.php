<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';

    require_once(APPPATH."third_party/razorpay/razorpay-php/Razorpay.php");  
    use Razorpay\Api\Api;
    use Razorpay\Api\Errors\SignatureVerificationError;

    class Enquiry extends BaseController
    {
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model(array('login_model', 'enquiry_model', 'database','comman_model'));
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
            $data['course_List'] = $this->comman_model->getCourseList();
            $data['city_List'] = $this->comman_model->getCityList();
            $data['counseller_Name'] = $this->comman_model->getCounsellerList();
            $this->global['pageTitle'] = 'Enquiry Management';
            $this->loadViews("enquiry/enquiryList", $this->global, $data , NULL);
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

       public function editenquiry($id){

            $process = 'Enquiry Edit';
            $processFunction = 'Enquiry/enquiryEdit';
            $this->logrecord($process,$processFunction);
            $data['course_List'] = $this->comman_model->getCourseList();
            $data['editDataenquiry'] = $this->enquiry_model->getEnquiryInfo($id);
            $data['state_List'] = $this->comman_model->selectAllStates($data['editDataenquiry'][0]->enq_country,$data['editDataenquiry'][0]->enq_state);
            // $data['city_List'] = $this->comman_model->selectAllCities($data['editDataenquiry'][0]->enq_state,$data['editDataenquiry'][0]->enq_city);
            $data['city_List'] = $this->comman_model->getCityList();
            $data['counseller_Name'] = $this->comman_model->getCounsellerList();
            $this->global['pageTitle'] = 'Enquiry Management';
            $this->loadViews("enquiry/enquiryEdit", $this->global, $data , NULL);

       }
    
        function get_signle_enquiry($enqId = NULL)
        {
            $enqId = $this->input->post('enq_id');
            $data = $this->enquiry_model->getEnquiryInfo($enqId);
            echo json_encode($data);
        }


        public function createenquiry(){
            $post_submit = $this->input->post();

            if(!empty($post_submit)){
                $createenquiry_response = array();
            
                $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|numeric|greater_than[0]|exact_length[10]');
                //$this->form_validation->set_rules('alternate_mobile', 'Alternate Mobile', 'trim');
                $this->form_validation->set_rules('email', 'Email', 'trim');
                //$this->form_validation->set_rules('alternamte_email', 'Alternamte Email', 'trim');
                $this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');
                //$this->form_validation->set_rules('purpose', 'Purpose', 'trim');
                $this->form_validation->set_rules('enq_date', 'Enq Date', 'trim|required');
                //$this->form_validation->set_rules('country', 'Country', 'trim');
                //$this->form_validation->set_rules('state', 'State', 'trim');
                $this->form_validation->set_rules('city', 'City', 'trim');
                $this->form_validation->set_rules('enquiry_type', 'Enquiry Type', 'trim|required');
                $this->form_validation->set_rules('doctor_non_doctor', 'Doctor Non Doctor', 'trim|required');
                $this->form_validation->set_rules('counsellor', 'Counsellor', 'trim|required');

                //$this->form_validation->set_rules('remarks', 'Remarks', 'trim');
                //$this->form_validation->set_rules('course', 'Course', 'trim|required');

                $courses_multipal = $this->security->xss_clean($this->input->post('course'));
                if($courses_multipal){
                    $courses = implode(',', $courses_multipal);

                        $course_ids    =   explode(',', $courses);
                        $total_fees = 0;
                        $course_name = '';
                        $i = 1;
                        foreach($course_ids as $id)
                        {
                            $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                            if($get_course_fees){
                                
                                $total_fees += $get_course_fees[0]->course_total_fees;
                                //$course_name .= $i.') '.$get_course_fees[0]->course_name.'&nbsp&nbsp( Rs '.$get_course_fees[0]->course_total_fees. ') <br> ';  
                                $i++;   
                        
                            }else{
                        
                                $total_fees = '';
                                //$course_name = '';  
                                $i++;  
                            }
                            
                        }


                }else{
                    $courses = '';
                }
               
                if($this->form_validation->run() == FALSE){

                    if($this->input->post('course')){
                        $createenquiry_response['status'] = 'failure';
                        $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'remarks'=>strip_tags(form_error('remarks')),'doctor_non_doctor'=>strip_tags(form_error('doctor_non_doctor')),'counsellor'=>strip_tags(form_error('counsellor')));
                    }else{
                        $createenquiry_response['status'] = 'failure';
                        $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'course'=>'Course Required','remarks'=>strip_tags(form_error('remarks')),'doctor_non_doctor'=>strip_tags(form_error('doctor_non_doctor')),'counsellor'=>strip_tags(form_error('counsellor')));
                    }
                 
                }else{

                    if($this->input->post('course')){

                    $check_enquiry_auto_number =  $this->enquiry_model->getautonumberfromEnquiry();
                    if($check_enquiry_auto_number){
                        if($check_enquiry_auto_number[0]->enq_number){
                            $enq_number =$check_enquiry_auto_number[0]->enq_number +  1;
                        }else{
                            $enq_number = 1;
                        }

                    }else{
                        $enq_number = 1;
                    }
                   

                    $data = array(
                        //'enq_number'=> DATE('Y').DATE('m').DATE('d').DATE('H').DATE('i').DATE('s'),
                        'enq_number'=> $enq_number,
                        'enq_fullname' => $this->input->post('full_name'),
                        'enq_mobile'=> $this->input->post('mobile_no'),
                        //'enq_mobile1' => $this->input->post('alternate_mobile'),
                        'enq_email'=> $this->input->post('email'),
                        //'enq_email1' => $this->input->post('alternamte_email'),
                        'enq_qualification' => $this->input->post('qualification'),
                        //'enq_purpose' => $this->input->post('purpose'),
                        'enq_date' => date('Y-m-d', strtotime($this->input->post('enq_date'))),
                        'doctor_non_doctor'=>$this->input->post('doctor_non_doctor'),
                        //'enq_country'=> $this->input->post('country'),
                        //'enq_state'=>$this->input->post('state'),
                        'enq_city'=>$this->input->post('city'),
                        'total_payment' =>$total_fees,
                        'final_amount' =>$total_fees,
                        'enq_source'=>$this->input->post('enquiry_type'),
                        //'enq_remark' => $this->input->post('remarks'),
                        'enq_course_id' => $courses,
                        'counsellor_id' => $this->input->post('counsellor'),
                    );

                    /*check If course name is unique*/
                    $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname(trim($this->input->post('full_name')));

                    if($check_uniqe){
                        $createenquiry_response['status'] = 'failure';
                        $createenquiry_response['error'] = array('full_name'=>'Name Already Exists', 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                    }else{
                        $saveEnquirydata = $this->enquiry_model->saveEnquirydata('',$data);
                        if($saveEnquirydata){
                            $createenquiry_response['status'] = 'success';
                            $createenquiry_response['error'] = array('full_name'=>'', 'mobile_no'=>'', 'alternate_mobile'=>'', 'email'=>'','alternamte_email'=>'','qualification'=>'','purpose'=>'','enq_date'=>'','country'=>'','state'=>'','city'=>'','remarks'=>'','counsellor'=>'');
                        }
                    }
                  }else{
                    
                    $createenquiry_response['status'] = 'failure';
                    $createenquiry_response['error'] = array('full_name'=>'', 'mobile_no'=>'', 'alternate_mobile'=>'', 'email'=>'','alternamte_email'=>'','qualification'=>'','purpose'=>'','enq_date'=>'','country'=>'','state'=>'','city'=>'','city'=>'course Required','remarks'=>'','counsellor'=>'');
            
                  }
                }
        
                echo json_encode($createenquiry_response);
            }

        }

        public function updateenquiry($id){
            $post_submit = $this->input->post();
            $enq_id = $this->input->post('enq_id');

            if(!empty($post_submit)){
                $createenquiry_response = array();
               
                $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('mobile_no', 'Mobile_no', 'trim|required|numeric|greater_than[0]|exact_length[10]');
                //$this->form_validation->set_rules('alternate_mobile', 'Alternate Mobile', 'trim');
                $this->form_validation->set_rules('email', 'Email', 'trim');
                //$this->form_validation->set_rules('alternamte_email', 'Alternamte Email', 'trim');
                $this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');
                //$this->form_validation->set_rules('purpose', 'Purpose', 'trim');
                $this->form_validation->set_rules('enq_date', 'Enq Date', 'trim|required');
                //$this->form_validation->set_rules('country', 'Country', 'trim');
                //$this->form_validation->set_rules('state', 'State', 'trim');
                $this->form_validation->set_rules('city', 'City', 'trim');
                $this->form_validation->set_rules('enquiry_type', 'Enquiry Type', 'trim|required');
                $this->form_validation->set_rules('doctor_non_doctor', 'Doctor Non Doctor', 'trim|required');
                $this->form_validation->set_rules('counsellor', 'Counsellor', 'trim|required');
                //$this->form_validation->set_rules('remarks', 'Remarks', 'trim');
                //$this->form_validation->set_rules('course', 'Course', 'trim|required');
                


                if($this->form_validation->run() == FALSE){
                    if($this->input->post('course')){
                        $createenquiry_response['status'] = 'failure';
                        //$createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')),'course'=>strip_tags(form_error('course')),'enquiry_type'=>strip_tags(form_error('enquiry_type')));
                        $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'doctor_non_doctor'=>strip_tags(form_error('doctor_non_doctor')),'counsellor'=>strip_tags(form_error('counsellor')));
                    }else{
                        $createenquiry_response['status'] = 'failure';
                        $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'course'=>'Course Required','remarks'=>strip_tags(form_error('remarks')),'doctor_non_doctor'=>strip_tags(form_error('doctor_non_doctor')),'counsellor'=>strip_tags(form_error('counsellor')));
                    }
                }else{
                    
                    if($this->input->post('course')){
                                $courses_multipal = $this->security->xss_clean($this->input->post('course'));
                                if($courses_multipal){
                                    $courses = implode(',', $courses_multipal);

                                    $course_ids    =   explode(',', $courses);
                                    $total_fees = 0;
                                    $course_name = '';
                                    $i = 1;
                                    foreach($course_ids as $id)
                                    {
                                        $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                                        if($get_course_fees){
                                            
                                            $total_fees += $get_course_fees[0]->course_total_fees;
                                            //$course_name .= $i.') '.$get_course_fees[0]->course_name.'&nbsp&nbsp( Rs '.$get_course_fees[0]->course_total_fees. ') <br> ';  
                                            $i++;   
                                    
                                        }else{
                                    
                                            $total_fees = '';
                                            //$course_name = '';  
                                            $i++;  
                                        }
                                        
                                    }
            
                                }else{
                                    $courses = '';
                                }

                                /*check If enquiry name is unique*/
                                $data = array(
                                    'enq_fullname' => $this->input->post('full_name'),
                                    'enq_mobile'=> $this->input->post('mobile_no'),
                                    //'enq_mobile1' => $this->input->post('alternate_mobile'),
                                    'enq_email'=> $this->input->post('email'),
                                    //'enq_email1' => $this->input->post('alternamte_email'),
                                    'enq_qualification' => $this->input->post('qualification'),
                                    //'enq_purpose' => $this->input->post('purpose'),
                                    'enq_date' => date('Y-m-d', strtotime($this->input->post('enq_date'))),
                                    //'enq_country'=> $this->input->post('country'),
                                    //'enq_state'=>$this->input->post('state'),
                                    'enq_city'=>$this->input->post('city'),
                                    'enq_source'=>$this->input->post('enquiry_type'),
                                    //'enq_remark' => $this->input->post('remarks'),
                                    'total_payment' =>$total_fees,
                                    'final_amount' =>$total_fees,
                                    'enq_course_id' => $courses,
                                    'doctor_non_doctor'=>$this->input->post('doctor_non_doctor'),
                                    'counsellor_id' => $this->input->post('counsellor'),
                                );

                                
                                // if($id == null)
                                // {
                                //     $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname(trim($this->input->post('full_name')));
                                // }
                                // else
                                // {
                                //     $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname_update($id, trim($this->input->post('full_name')));
                                // }

                                $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname_update($enq_id, trim($this->input->post('full_name')));
                                //$check_uniqe =  $this->enquiry_model->checkuniqeenquiryname(trim($this->input->post('full_name')));

                                if($check_uniqe){
                                
                                  $saveEnquirydata = $this->enquiry_model->saveEnquirydata($enq_id,$data);
                                  if($saveEnquirydata){
                                      $createenquiry_response['status'] = 'success';
                                      $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')),'counsellor'=>strip_tags(form_error('counsellor')));
                                  }
                              
                                }else{

                                   $createenquiry_response['status'] = 'failure';
                                   $createenquiry_response['error'] = array('full_name'=>'Name Already Exists', 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')),'counsellor'=>strip_tags(form_error('counsellor')));
                                }

                    }else{
                        $createenquiry_response['status'] = 'failure';
                        $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'course'=>'Course Required','remarks'=>strip_tags(form_error('remarks')),'counsellor'=>strip_tags(form_error('counsellor')));
                  }
                }
                
        
                echo json_encode($createenquiry_response);
            }

        }

        // ==== Delete Enquiry
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

        public function sendPaymentLink(){

            $post_submit = $this->input->post();
        
                if($post_submit){
                     $enq_id =$post_submit['id'];
                    //$enq_id =38;
                    $get_equiry_data =  $this->enquiry_model->getEnquiryInfo($enq_id)[0];

                     $course_ids    =   explode(',',$get_equiry_data->enq_course_id);
                    
                     $total_fees = 0;
                     $course_name = ''; 
                     $course_name_without ='';
                     $i = 1;
                        foreach($course_ids as $id)
                        {
                            $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                            $total_fees += $get_course_fees[0]->course_total_fees;
                            $course_name .= $i.'-'.$get_course_fees[0]->course_name. ',';  
                            $course_name_without .= $get_course_fees[0]->course_name. ',';  
                            $i++;  
                        }
                    $all_course_name = trim($course_name, ', '); 
                    $get_equiry_datapayment_transaction =  $this->enquiry_model->gettotalpaidEnquirypaymentInfo($enq_id);
                    $get_equiry_datapayment =  $get_equiry_data->final_amount;
                    if($get_equiry_datapayment_transaction){
                   
                        $total_paybal =$get_equiry_datapayment - $get_equiry_datapayment_transaction[0]->totalpaidAmount;

                    }else{
                        $total_paybal  =$get_equiry_datapayment;
                    }

                
                    $to = $get_equiry_data->enq_email;
                    $Subject = 'IICTN - Admission Payment Link '.date('Y-m-d H:i:s');
                    $Body  = '   <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                                    <title>Invoice details</title>
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                                </head>
                    
                                <body style="margin: 0; padding: 0; background-color:#eaeced " bgcolor="#eaeced">
                                <table bgcolor="#eaeced" cellpadding="0" cellspacing="0" width="100%" style="background-color: #eaeced; ">
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                <tr>
                                    <td>
                                    <table align="center" bgcolor="#ffffff" cellpadding="20" cellspacing="0" width="600" 
                                            style="border-collapse: collapse; background-color: #ffffff; border: 1px solid #f0f0f0;">
                                        <tr style="border-top: 4px solid #ca9331;">
                                        <td align="left" style="padding: 15px 20px 20px;">
                                        <table width="100%">
                                            <tr>
                                            <td><img  src="https://iictn.in/assets/img/logos/iictn_lms.png" width="130px" height="130px" alt="Company Logo"/></td>
                                            <td align="right">
                                                <span>Inquiry Number: '.$get_equiry_data->enq_number.'</span><br>
                                                <span style="padding: 5px 0; display: block;">'.$get_equiry_data->enq_date.'</span>
                                            </td>
                                            </tr>
                                        </table>
                                        
                                        </td>
                                        </tr>
                                        <tr>
                                        <td align="center" style="padding: 20px; border-top: 1px solid #f0f0f0; background: #fafafa;,; ">
                                        <div>Total Course Fee:</div>
                                        <h2 style="margin: 10px 0; color: #333; font-weight: 500; font-size: 48px;">
                                        ₹  '.$total_paybal.'
                                        </h2>
                                        <div style="line-height: 1.4; font-size: 1.2; font-size: 14px; color: #777;"></div>
                                        </td>
                                        </tr>

                                        <tr style="">
                                        <td align="center" style="padding: 15px 20px 20px;">
                                        <table width="80%">
                                            <tr>
                                            <td><b>Full Name</b></td>
                                            <td>'.$get_equiry_data->enq_fullname.'</td>
                                            </tr>

                                            <tr>
                                            <td><b>Mobile Number</b></td>
                                            <td>'.$get_equiry_data->enq_mobile.'</td>
                                            </tr>

                                            <tr>
                                            <td><b>Email id</b></td>
                                            <td>'.$get_equiry_data->enq_email.'</td>
                                            </tr>

                                            <tr>
                                            <td><b>Course</b></td>
                                            <td>'.$all_course_name.'</td>
                                            </tr>
                                        </table>
                                        </td>
                                        </tr>

                                        <tr>
                                        <td align="center" style="padding: 20px 40px;font-size: 16px;line-height: 1.4;color: #333;">
                                        <div> </div>
                                        <div><br></div>
                                        <div style="background: #ca9331; display: inline-block;padding: 15px 25px; color: #fff; border-radius: 6px">

                                        <a href="https://iictn.in/payment/pay.php?enq='.$get_equiry_data->enq_number.'" class="btn btn-sm btn-primary float-right pay_now"
                                        data-amount="1000" data-id="1">Pay Now</a>
                                        
                                        </div>
                                        <div style="color: #777; padding: 5px;"></div>
                                        <div><br></div>
                                        </td>
                                        </tr>
                                        <tr style="border-top: 1px solid #eaeaea;">
                                        <td align="center">
                                            <div style="font-size: 14px;line-height: 1.4;color: #777;">
                                            Regards,<br>
                                            IICTN
                                        </div>
                                        </td>
                                        </tr>
                                    </table>
                                    
                                    </td>
                                </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                                </body>
                        </html>';

                        // $to = "hemantkaturde123@gmail.com";
                        // $subject = "This is subject";
                        
                        // $message = "<b>This is HTML message.</b>";
                        // $message .= "<h1>This is headline.</h1>";
                        
                        $header = "From: IICTN-Payment Link <admin@iictn.in> \r\n";
                        //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                        $header .= "MIME-Version: 1.0\r\n";
                        $header .= "Content-type: text/html\r\n";
                        
                        $retval = mail($to,$Subject,$Body,$header);

                    if($retval){


                        //  /* Send Whats App  Start Here */
                        //  $curl = curl_init();
                          $text = 'Greetings from IICTN !!,  Thank You for your interest in '.$course_name_without;
                          $text .= ', Attached is the Payment Link, Once Payment done you will receive  payment receipt https://iictn.in/payment/pay.php?enq='.$get_equiry_data->enq_number;
                          //$text = 'Dear '.$enq_fullname.' Thank You for your interest in '.$all_course_name.', We have attached the brochure and Syllabus for your reference. Feel free to contact us back, we will be delighted to assist and guide you.For more details, you can also visit our website www.iictn.org';      
                          $mobile = '91'.$get_equiry_data->enq_mobile;
                        
                   
                        $curl = curl_init();

                            $data = [
                            "number" => $mobile,
                            "type" => "text",
                            "message" => $text,
                            "instance_id" => INSTANCE_ID,
                            "access_token" => ACCESS_TOKEN
                            ];
        
        
                        $jsonData = json_encode($data);
                        
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://wa.intractly.com/api/send',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        // CURLOPT_POSTFIELDS =>'{
                        // "number": "917021507157",
                        // "type": "text",
                        // "message": "This is text SMS FORM IICTN",
                        // "instance_id": "64FC5A51A7429",
                        // "access_token": "64e7462031534"
                        // }',
                        CURLOPT_POSTFIELDS =>$jsonData,
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            // 'Cookie: stackpost_session=om27q29u0j0sb3mf95gfk93v50fj6h1n'
                        ),
                        ));
        
                        $response = curl_exec($curl);
                        curl_close($curl);

                        $process = 'Enquiry Link Sent';
                        $processFunction = 'Enquiry/sendEnquiryLink';
                        $this->logrecord($process,$processFunction);
                        echo(json_encode(array('status'=>'success')));
                    }
                }else{
                    echo(json_encode(array('status'=>FALSE)));

                }
        }

        public function pay($id){
            if($id){
               /* check if payment is done or not*/
               $chekcpayornot = $this->enquiry_model->checkifpaymentdoneornot(trim($id));
               if($chekcpayornot[0]->payment_status==1){
                      $this->load->view("payment/paymentdone");
               }else{
                    $process = 'Razorpay Payment ';
                    $processFunction = 'Enquiry/pay';
                    $this->logrecord($process,$processFunction);
                    $this->global['pageTitle'] = 'Razorpay';
                    $data['enquiry_data'] = $this->enquiry_model->getEnquiryInfobyenqnumber(trim($id));

                    $course_ids    =   explode(',',$data['enquiry_data'][0]->enq_course_id);
                    $total_fees = 0;
                    $course_name = '';
                    $i = 1;
                       foreach($course_ids as $id)
                       {
                           $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                           $total_fees += $get_course_fees[0]->course_total_fees;
                           $course_name .= $i.'-'.$get_course_fees[0]->course_name. ',';    
                       }
                   $all_course_name = trim($course_name, ', '); 

                   $data['course_fees'] =$total_fees;
                   $data['course_name'] =$course_name;

                $this->load->view("payment/razorpay", $data );
               }
               
            }else{
               echo 'page not found';
            }
        }


       public function razorpaysuccess(){

        $post_submit = $this->input->post();
        if($post_submit){

            $razorpay_payment_id = $post_submit['razorpay_payment_id'];
            $totalAmount = $post_submit['totalAmount'];
            $product_id = $post_submit['product_id'];
            $enquiry_number = $post_submit['enquiry_number'];

            $sucess_response = array();

            $data = array(
                'razorpay_payment_id' => $razorpay_payment_id,
                'totalAmount'=> $totalAmount,
                'product_id' => $product_id,
                'enquiry_number' => $enquiry_number,
                'payment_status' => 1
            );

            $payment = $this->enquiry_model->payment($data);

            if($payment){
                $enquiry_data = array('payment_status' => 1);
                $update_paymentstatus_enquiry = $this->enquiry_model->update_paymentstatus_enquiry($enquiry_number,$enquiry_data);

                if($update_paymentstatus_enquiry){
                    $process = 'Razorpay Payment  success';
                    $processFunction = 'Enquiry/pay';
                    $this->logrecord($process,$processFunction);

                    //$this->load->view("payment/success");
                    echo(json_encode(array('status'=>true)));

                }else{
                    echo(json_encode(array('status'=>false)));

                }
            }

        }else{

        }
       }

       public function razorthankyou(){
         $enquiry_number =$this->uri->segment(2);    
         $getEquirydata =  $this->enquiry_model->getEnquiryInfobyenquirynumber(trim($enquiry_number))[0];
         $data['enq_fullname'] = $getEquirydata->enq_fullname;
         $data['enq_id']  = $enquiry_number;
         $this->load->view("payment/success",$data);
       }

       public function paymentrecipt($i){

        //$enquiry_number =$this->uri->segment(2);  

        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('genpdf_view',[],true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();

       }

       public function newregistrationstudent(){
         $data['enquiry_number'] =$this->uri->segment(2);
         $this->load->view("admission/admissionform",$data);
       }

       public function newregistrationstudentdetails(){

        $post_submit = $this->input->post();

        if($post_submit){

            $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|numeric|greater_than[0]|exact_length[10]');
            $this->form_validation->set_rules('alt_mobile', 'Alternate Mobile', 'trim');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('dateofbirth', 'Alternamte Email', 'trim');
            $this->form_validation->set_rules('counsellerName', 'CounsellerName', 'trim');
            $this->form_validation->set_rules('address', 'Address', 'trim');
            $this->form_validation->set_rules('country', 'Country', 'trim');
            $this->form_validation->set_rules('state', 'State', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim');
            $this->form_validation->set_rules('pin', 'Pin', 'trim');
            $this->form_validation->set_rules('source_about', 'Source About', 'trim');
            $this->form_validation->set_rules('source_ans', 'Source Ans', 'trim');
            $this->form_validation->set_rules('new_student', 'New Student', 'trim');
        }

       }

       public function followup($id){
            $process = 'Enquiry Follow up';
            $processFunction = 'Enquiry/enquiryEdit';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Enquiry Follow Up';
            $data['enquiry_id'] = $id;
            $data['followDataenquiry'] = $this->enquiry_model->getEnquiryInfo($id);
            $this->loadViews("enquiry/enquiryFollowup", $this->global, $data , NULL);
       }

       public function createFollowup(){
 
        $post_submit = $this->input->post();

        if($post_submit){
            
            $createfollow_response = array();
            $post_submit['enquiry_id'];
            
            $this->form_validation->set_rules('follow_up_date', 'Follow Up Date', 'trim|required');
            $this->form_validation->set_rules('remark', 'Remark', 'trim|required');

            if($this->form_validation->run() == FALSE){

                $createfollow_response['status'] = 'failure';
                $createfollow_response['error'] = array('follow_up_date'=>strip_tags(form_error('follow_up_date')), 'remark'=>strip_tags(form_error('remark')));
        
            }else{
                $data = array(
                    'enq_id' => $this->input->post('enquiry_id'),
                    'date'  => date('Y-m-d', strtotime($this->input->post('follow_up_date'))),
                    'remark' => $this->input->post('remark'),
                    'enquiry_number'=> $this->input->post('enquiry_number'),
                    //'createdBy'=>
                );

                $saveFollowdata = $this->enquiry_model->saveEnquiryFollowupdata('',$data);
                if($saveFollowdata){
                    $createfollow_response['status'] = 'success';
                    $createfollow_response['error'] = array('follow_up_date'=>'', 'remark'=>'');
                }
                   
            }
            echo json_encode($createfollow_response);
        }
     
       }

       public function fetchEnquiryFollowup($id){

            $params = $_REQUEST;
            $totalRecords = $this->enquiry_model->getEnquiryFollowupCount($params,$id);
            $queryRecords = $this->enquiry_model->getEnquiryFollowup($params,$id); 
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

       public function delete_enquiry_followup(){
        $post_submit = $this->input->post();

        $enquiryInfo = array('isDeleted'=>1,'updatedBy'=> $this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
        $result = $this->database->data_update('tbl_enquiry_follow_up',$enquiryInfo,'id',$this->input->post('id'));

        if ($result > 0) {
             echo(json_encode(array('status'=>TRUE)));

             $process = 'Enquiry Follow Up Delete';
             $processFunction = 'Enquiry/delete_enquiry_followup';
             $this->logrecord($process,$processFunction);

            }
        else { echo(json_encode(array('status'=>FALSE))); }


       }

       public function get_signle_followupData(){ 
            $followup_id = $this->input->post('followup_id');
            $data = $this->enquiry_model->getsignlefollowupData($followup_id);
            echo json_encode($data);
       }

       public function updatefollowupdata(){
        $post_submit = $this->input->post();

        if($post_submit){

            $createfollow_response = array();
         
            $enquiry_id = $this->input->post('enquiry_id1');
            $followup_id = $this->input->post('followup_id1');

            $this->form_validation->set_rules('follow_up_date1', 'Follow Up Date', 'trim|required');
            $this->form_validation->set_rules('remark1', 'Remark', 'trim|required');

            if($this->form_validation->run() == FALSE){

                $createfollow_response['status'] = 'failure';
                $createfollow_response['error'] = array('follow_up_date'=>strip_tags(form_error('follow_up_date1')), 'remark'=>strip_tags(form_error('remark1')));
        
            }else{
                $data = array(
                    'enq_id' => $this->input->post('enquiry_id1'),
                    'date'  => date('Y-m-d', strtotime($this->input->post('follow_up_date1'))),
                    'remark' => $this->input->post('remark1'),
                    'enquiry_number'=> $this->input->post('enquiry_number1'),
                    //'createdBy'=>
                );

                $saveFollowdata = $this->enquiry_model->saveEnquiryFollowupdata($followup_id,$data);
                if($saveFollowdata){
                    $createfollow_response['status'] = 'success';
                    $createfollow_response['error'] = array('follow_up_date'=>'', 'remark'=>'');
                }
                   
            }
            echo json_encode($createfollow_response);
          

        }


       }


       public function payment_details($id){

            $process = 'Enquiry Payment Details';
            $processFunction = 'Enquiry/enquiryEdit';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Enquiry Payment Details';
            $data['enquiry_id'] = $id;
            $data['followDataenquiry'] = $this->enquiry_model->getEnquiryInfo($id);
            $data['getEnquirypaymentInfo'] = $this->enquiry_model->getEnquirypaymentInfo($id);
            $data['gettotalpaidEnquirypaymentInfo'] = $this->enquiry_model->gettotalpaidEnquirypaymentInfo($id);
            $this->loadViews("payment/payment_details", $this->global, $data , NULL);

       }


      public function update_discount(){

        $post_submit = $this->input->post();
        
        if(!empty($post_submit)){
            $update_discount_response = array();

            $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required');
            $this->form_validation->set_rules('discounted_amount', 'Discounted Amount', 'trim|required');
            $this->form_validation->set_rules('total_benifit', 'Total Benifit', 'trim|required');
            $this->form_validation->set_rules('final_student_amount', 'Final Student Amount', 'trim|required');
   
            if($this->form_validation->run() == FALSE){
                    $update_discount_response['status'] = 'failure';
                    $update_discount_response['error'] = array('total_amount'=>strip_tags(form_error('total_amount')), 'discounted_amount'=>strip_tags(form_error('discounted_amount')), 'total_benifit'=>strip_tags(form_error('total_benifit')), 'final_student_amount'=>strip_tags(form_error('final_student_amount')));
            }else{

                $enquiry_id =   $this->input->post('enquiry_id');
                $total_amount =   $this->input->post('total_amount');
                $discounted_amount =   $this->input->post('discounted_amount');
                $total_benifit =   $this->input->post('total_benifit');
                $final_student_amount =   $this->input->post('final_student_amount');


                $data = array(
                    'total_payment'=> $total_amount,
                    'discount_amount'=> $discounted_amount,
                    'total_benifit'=> $total_benifit,
                    'final_amount'=> $final_student_amount,                          
                );

                
                $update_enquiry_discount =  $this->enquiry_model->update_enquiry_discount($data,$enquiry_id);


                   if($update_enquiry_discount){
                        $update_discount_response['status'] = 'success';
                        $update_discount_response['error'] = array('total_amount'=>strip_tags(form_error('total_amount')), 'discounted_amount'=>strip_tags(form_error('discounted_amount')), 'total_benifit'=>strip_tags(form_error('total_benifit')), 'final_student_amount'=>strip_tags(form_error('final_student_amount')));
                    }else{
                        $update_discount_response['status'] = 'failure';
                        $update_discount_response['error'] = array('total_amount'=>strip_tags(form_error('total_amount')), 'discounted_amount'=>strip_tags(form_error('discounted_amount')), 'total_benifit'=>strip_tags(form_error('total_benifit')), 'final_student_amount'=>strip_tags(form_error('final_student_amount')));
                    }

                    echo json_encode($update_discount_response);

            }
            
        }
    }


   public function addmanualpayment(){

    $post_submit = $this->input->post();

    if($post_submit){

        $add_manaulpayment_response = array();

        $this->form_validation->set_rules('enquiry_number', 'Enquiry Eumber', 'trim|required');
        $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'trim|required');
        $this->form_validation->set_rules('manual_payment_amount', 'Manual Payment Amount', 'trim|required');
        $this->form_validation->set_rules('payment_date', 'Payment Date', 'trim|required');
        $this->form_validation->set_rules('cheuqe_number', 'Cheuqe Number', 'trim');
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim');
        $this->form_validation->set_rules('prepared_by', 'Prepared By', 'trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if($this->form_validation->run() == FALSE){
            $add_manaulpayment_response['status'] = 'failure';
            $add_manaulpayment_response['error'] = array('enquiry_number'=>strip_tags(form_error('enquiry_number')), 'payment_mode'=>strip_tags(form_error('payment_mode')), 'manual_payment_amount'=>strip_tags(form_error('manual_payment_amount')), 'payment_date'=>strip_tags(form_error('payment_date')),'cheuqe_number'=>strip_tags(form_error('cheuqe_number')),'bank_name'=>strip_tags(form_error('bank_name')),'prepared_by'=>strip_tags(form_error('prepared_by')));
        }else{



                    $check_payment_is_less_than  = $this->enquiry_model->check_payment_maount_lessthan_actaul($this->input->post('enquiry_id'));


                    if($check_payment_is_less_than[0]['final_amount'] < trim($this->input->post('manual_payment_amount')) ){
                        $add_manaulpayment_response['status'] = 'failure';
                        $add_manaulpayment_response['error'] = array('enquiry_number'=>"", 'payment_mode'=>"", 'manual_payment_amount'=>'Payment Amount is Gratter Than Actual Amount', 'payment_date'=>"",'cheuqe_number'=>"",'bank_name'=>"",'prepared_by'=>"");
             

                    }else{

                            $data = array(
                                'enquiry_id'=> $this->input->post('enquiry_id'),
                                'enquiry_number'=>  $this->input->post('enquiry_number'),
                                'totalAmount'=>  $this->input->post('manual_payment_amount'),
                                'payment_status'=> '1',
                                'payment_mode'=> $this->input->post('payment_mode'),
                                'cheuqe_number'=> $this->input->post('cheuqe_number'),
                                'bank_name'=> $this->input->post('bank_name'),
                                'prepared_by'=> $this->input->post('prepared_by'),
                                'description'=> $this->input->post('description'),
                                'payment_date'=>  date('Y-m-d h:i:sa', strtotime($this->input->post('payment_date'))),
                            
                            );
                            
                        
                        $insert_manualpayment_details =  $this->enquiry_model->insert_manualpayment_details($data);

                        if($insert_manualpayment_details){
                                $add_manaulpayment_response['status'] = 'success';
                                $add_manaulpayment_response['error'] = array('enquiry_number'=>strip_tags(form_error('enquiry_number')), 'payment_mode'=>strip_tags(form_error('payment_mode')), 'manual_payment_amount'=>strip_tags(form_error('manual_payment_amount')), 'payment_date'=>strip_tags(form_error('payment_date')),'cheuqe_number'=>strip_tags(form_error('cheuqe_number')),'bank_name'=>strip_tags(form_error('bank_name')),'prepared_by'=>strip_tags(form_error('prepared_by')));
                            }else{
                                $add_manaulpayment_response['status'] = 'failure';
                                $add_manaulpayment_response['error'] = array('enquiry_number'=>strip_tags(form_error('enquiry_number')), 'payment_mode'=>strip_tags(form_error('payment_mode')), 'manual_payment_amount'=>strip_tags(form_error('manual_payment_amount')), 'payment_date'=>strip_tags(form_error('payment_date')),'cheuqe_number'=>strip_tags(form_error('cheuqe_number')),'bank_name'=>strip_tags(form_error('bank_name')),'prepared_by'=>strip_tags(form_error('prepared_by')));
                            }


                    }
            
        }

        echo json_encode($add_manaulpayment_response);
            
    }

   }
   

    public function sendBrochureLink(){
        $post_submit = $this->input->post();

            if($post_submit){
                $enq_id =$post_submit['id'];
                $get_equiry_data =  $this->enquiry_model->getEnquiryInfo($enq_id)[0];

                 $doctor_non_doctor = $get_equiry_data->doctor_non_doctor;
                 $course_ids    =   explode(',',$get_equiry_data->enq_course_id);
                
                 $total_fees = 0;
                 $course_name = '';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                        $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                        $total_fees += $get_course_fees[0]->course_total_fees;
                        $course_name .= $get_course_fees[0]->course_name. ',';  
                        $i++;  
                    }

                    $all_course_name = trim($course_name, ', '); 

                    $to = $get_equiry_data->enq_email;
                    $from = 'admin@iictn.in'; 
                    $fromName = 'IICTN'; 
                    $enq_fullname = $get_equiry_data->enq_fullname;
                    //$subject = 'IICTN - Marketing Material '.date('Y-m-d H:i:s');
                    $subject = 'Greetings from IICTN !! '.date('Y-m-d H:i:s');
                    
                    $header = "From: IICTN-Marketing Material <admin@iictn.in> \r\n";
                    //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";

                     
                     if($doctor_non_doctor=='Doctor'){
                        $file_path ='<a href="https://iictn.in/markating_material/Doctors_Brochure.pdf">Doctors Brochure </a>';
                        $wp_url = 'https://iictn.in/markating_material/Doctors_Brochure.pdf';
                     }else{
                        $file_path =' <a href="https://iictn.in/markating_material/Non_Doctors_Brochure.pdf">Non Doctors_Brochure </a>';
                        $wp_url = 'https://iictn.in/markating_material/Non_Doctors_Brochure.pdf';
                     }


                    $htmlContent = '<div>
                    <p><b>Greetings from IICTN !!</b></p>

                    <p><b>Dear </b> '.$enq_fullname.', </p>
                    <p>Thank You for your interest in <b>'.$all_course_name.'.</b></p>
                    <p>We have attached the brochure and Syllabus for your reference. Feel free to contact us back, we will be delighted to assist and guide you.</p>
                    <p>For more details, you can also visit our website <a href="https://iictn.org/" rel="noopener" target="_blank" >www.iictn.org </a></p>
                       
                    </div>

                    <div>
                        <p><b>Download Below Brochure<b></p>
                        <p>'.$file_path.'</p>
                    </div>

                    <div>
                        <p><b>Thanks & Regards<b></p>
                        <p><b>Team IICTN</b></p>
                    </div>
                    '; 
                    
                    $retval = mail($to,$subject,$htmlContent,$header);
            
                    if($retval){

                                $mobile = '91'.$get_equiry_data->enq_mobile;                      
                                $text = 'Greetings from IICTN !!,  Thank You for your interest in '.$all_course_name;

                                $curl = curl_init();

                                    $data = [
                                    "number" => $mobile,
                                    "type" => "text",
                                    "message" => $text,
                                    "instance_id" => INSTANCE_ID,
                                    "access_token" => ACCESS_TOKEN
                                    ];
                
                
                                $jsonData = json_encode($data);
                                
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://wa.intractly.com/api/send',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                // CURLOPT_POSTFIELDS =>'{
                                // "number": "917021507157",
                                // "type": "text",
                                // "message": "This is text SMS FORM IICTN",
                                // "instance_id": "64FC5A51A7429",
                                // "access_token": "64e7462031534"
                                // }',
                                CURLOPT_POSTFIELDS =>$jsonData,
                                CURLOPT_HTTPHEADER => array(
                                    'Content-Type: application/json',
                                    // 'Cookie: stackpost_session=om27q29u0j0sb3mf95gfk93v50fj6h1n'
                                ),
                                ));
                
                                $response = curl_exec($curl);
                                curl_close($curl);


                               /* Media Link Whatsaap*/
                               /*=========================================================================*/ 
                                $media ='We have attached the brochure and Syllabus for your reference, Feel free to contact us back, we will be delighted to assist and guide you. For more details you can also visit our website www.iictn.org';
                                $data = [
                                    "number" => $mobile,
                                    "type" => "media",
                                    "message" => $media,
                                    "media_url" => $wp_url,
                                    "instance_id" => INSTANCE_ID,
                                    "access_token" => ACCESS_TOKEN
                                ];
                
                
                                $jsonData = json_encode($data);
                                
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://wa.intractly.com/api/send',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                // CURLOPT_POSTFIELDS =>'{
                                // "number": "917021507157",
                                // "type": "text",
                                // "message": "This is text SMS FORM IICTN",
                                // "instance_id": "64FC5A51A7429",
                                // "access_token": "64e7462031534"
                                // }',
                                CURLOPT_POSTFIELDS =>$jsonData,
                                CURLOPT_HTTPHEADER => array(
                                    'Content-Type: application/json',
                                    // 'Cookie: stackpost_session=om27q29u0j0sb3mf95gfk93v50fj6h1n'
                                ),
                                ));
                
                                $response = curl_exec($curl);
                                curl_close($curl);


                
                        /* End here  Send Whats App */

                        $process = 'Enquiry Link Sent';
                        $processFunction = 'Enquiry/sendEnquiryLink';
                        $this->logrecord($process,$processFunction);
                        echo(json_encode(array('status'=>'success')));
                    }

            }else{
                echo(json_encode(array('status'=>FALSE)));

            }
    }

    public function deleteEnquirypaymentTransaction(){


                $post_submit = $this->input->post();

                $enquiryInfo = array('payment_status'=>0);
                $result = $this->database->data_update('tbl_payment_transaction',$enquiryInfo,'id',$this->input->post('id'));

                if ($result > 0) {
                    echo(json_encode(array('status'=>TRUE)));

                    $process = 'Enquiry Payment Delete';
                    $processFunction = 'Enquiry/deleteEnquirypaymentTransaction';
                    $this->logrecord($process,$processFunction);

                    }
                else { echo(json_encode(array('status'=>FALSE))); }



    }

    public function get_enquiry_tarnsaction_details($transaction_id=NUll){

        $transaction_id = $this->input->post('transaction_id');
        $data = $this->enquiry_model->get_enquiry_tarnsaction_details($transaction_id);
        echo json_encode($data);
        
    }

    public function sendManualAdmissionlink(){

        $post_submit = $this->input->post();
        
        if($post_submit){
                    $enq_id =$post_submit['id'];
                    //$enq_id =38;
                    $get_equiry_data =  $this->enquiry_model->getEnquiryInfo($enq_id)[0];

                    $to = $get_equiry_data->enq_email;
                    $from = 'admin@iictn.in'; 
                    $fromName = 'IICTN'; 
                    $enq_fullname = $get_equiry_data->enq_fullname;
                    $subject = 'IICTN - Admission Link '.date('Y-m-d H:i:s');
                    
                    $header = "From: Admission Link <admin@iictn.in> \r\n";
                    //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";


                    $htmlContent = '<div>
                    <p><b>Dear </b> '.$enq_fullname.',</p>
                    <p>Please Follow Below Admission Link.</p></div>
                    
                    <div>
                        <p><b>Admission Link<b></p>
                        <p>https://iictn.in/registration/new-registration-student.php?enq='.$enq_id.'</p>
                    </div>
                    '; 
                    
                    $retval = mail($to,$subject,$htmlContent,$header);
            
                    if($retval){

                         //  /* Send Whats App  Start Here */
                        //  $curl = curl_init();
                        $text = 'Admission Link';
                        $text .= ' https://iictn.in/registration/new-registration-student.php?enq='.$enq_id;
                        //$text = 'Dear '.$enq_fullname.' Thank You for your interest in '.$all_course_name.', We have attached the brochure and Syllabus for your reference. Feel free to contact us back, we will be delighted to assist and guide you.For more details, you can also visit our website www.iictn.org';      
                        $mobile = '91'.$get_equiry_data->enq_mobile;
                      
                        $curl = curl_init();

                                $data = [
                                "number" => $mobile,
                                "type" => "text",
                                "message" => $text,
                                "instance_id" => INSTANCE_ID,
                                "access_token" => ACCESS_TOKEN
                                ];
            
      
                            $jsonData = json_encode($data);
                            
                            curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://wa.intractly.com/api/send',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            // CURLOPT_POSTFIELDS =>'{
                            // "number": "917021507157",
                            // "type": "text",
                            // "message": "This is text SMS FORM IICTN",
                            // "instance_id": "64FC5A51A7429",
                            // "access_token": "64e7462031534"
                            // }',
                            CURLOPT_POSTFIELDS =>$jsonData,
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json',
                                // 'Cookie: stackpost_session=om27q29u0j0sb3mf95gfk93v50fj6h1n'
                            ),
                            ));
            
                            $response = curl_exec($curl);
                            curl_close($curl);

                        $process = 'Enquiry Link Sent';
                        $processFunction = 'Enquiry/sendEnquiryLink';
                        $this->logrecord($process,$processFunction);
                        echo(json_encode(array('status'=>'success')));
                    }
        }else{
            echo(json_encode(array('status'=>FALSE)));

        }

    }


    public function taxinvoices(){
        $process = 'Tax Invoices';
        $processFunction = 'Enquiry/taxinvoices';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Tax Invoices';
        $data['page_title'] ='Tax Invoices';
        $this->loadViews("tax_invoices/tax_invoices_details", $this->global, $data , NULL);
    }


    public function fetchTaxinvoices(){

        $params = $_REQUEST;
        $totalRecords = $this->enquiry_model->getTaxinvoicesCount($params);
        $queryRecords = $this->enquiry_model->getTaxinvoices($params); 
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
            "recordsFiltered" => intval( $totalRecords ),
            "data"            => $data   // total data array
            );

        echo json_encode($json_data);


    }



}

 

?>