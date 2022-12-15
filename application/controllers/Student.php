<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';

    class Student extends BaseController
    {
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model('login_model');
            $this->load->model('student_model');
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

        public function studentListing()
        {
            $this->global['pageTitle'] = 'Student Listing';
            $this->loadViews("student/studentList", $this->global, NULL, NULL);
        }


        public function fetchstudentlist(){
            $params = $_REQUEST;
            $totalRecords = $this->student_model->getStudentCount($params); 
            $queryRecords = $this->student_model->getStudentData($params); 
    
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

        public function billinginfo(){

            $this->global['pageTitle'] = 'Billing Info';
            $this->loadViews("student/billing_info", $this->global, NULL, NULL);
        }

        
        public function fetchBillinginfo(){

            $enq_id =  $this->session->userdata('enq_id');
            
            $params = $_REQUEST;
            $totalRecords = $this->student_model->getTaxinvoicesCount($params,$enq_id);
            $queryRecords = $this->student_model->getTaxinvoices($params,$enq_id); 
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

        public function editstudent($id){

            $process = 'Student Edit';
            $processFunction = 'student/editstudent';
            $this->logrecord($process,$processFunction);
            $data['student_infromation'] = $this->student_model->getAllstudentdata($id);
            $this->global['pageTitle'] = 'Student Edit';
            $this->loadViews("student/studentedit", $this->global, $data , NULL);

        }

        public function update_student(){

            $post_submit = $this->input->post();
            $student_id = $this->input->post('student_id');

        
            if(!empty($post_submit)){
                $editstudent_response = array();

                $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required|numeric|greater_than[0]|exact_length[10]');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('username', 'Username', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

                if($this->form_validation->run() == FALSE){
                    $editstudent_response['status'] = 'failure';
                    $editstudent_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_number'=>strip_tags(form_error('mobile_number')), 'email'=>strip_tags(form_error('email')), 'username'=>strip_tags(form_error('username')),'password'=>strip_tags(form_error('password')),'confirm_password'=>strip_tags(form_error('confirm_password')));
                }else{



                    if(!empty($_FILES['profile_photo']['name'])){

                        $file = rand(1000,100000)."-".$this->input->post('name').$_FILES['profile_photo']['name'];
                        $filename = str_replace(' ','_',$file);
        
                        $config['upload_path'] = 'uploads/profile_pic'; 
                        $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                        $config['max_size'] = '1000'; // max_size in kb 
                        $config['file_name'] = $filename; 
               
                        // Load upload library 
                        $this->load->library('upload',$config); 
                
                        // File upload
                        if($this->upload->do_upload('profile_photo')){ 
                           $profile_pic = $filename; 
                        }else{
                            $profile_pic =$this->input->post('existing_img');
                        }
        
                    }else{
                        $profile_pic = $this->input->post('existing_img');
                    }
        
                    $data = array(
                        'name'      => $this->input->post('full_name'),
                        'mobile'    => $this->input->post('mobile_number'),
                        'email'     => $this->input->post('email'),
                        'username'   => trim($this->input->post('username')),
                        'password'  => base64_encode($this->input->post('password')),
                        'profile_pic' => $profile_pic,
                    );

                    $saveStudantdata = $this->student_model->saveStudentdata($student_id,$data);
                    if($saveStudantdata){

                        
                        $editstudent_response['status'] = 'success';
                        $editstudent_response['error'] = array('full_name'=>'', 'mobile_number'=>'', 'email'=>'', 'username'=>'','password'=>'','confirm_password'=>'');
                    }
                }

                echo json_encode($editstudent_response);

            }

        }

        public function deleteStudent(){

            $post_submit = $this->input->post();
            $enquiryInfo = array('isDeleted'=>1,'updatedBy'=> $this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->database->data_update('tbl_users',$enquiryInfo,'userId',$this->input->post('id'));

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Delete Students';
                 $processFunction = 'Student/deleteStudent';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }

        }

    }

?>