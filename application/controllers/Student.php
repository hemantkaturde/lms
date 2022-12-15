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
            $this->load->model('student_model');
            $this->load->model('course_model');
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

            $userId =  $this->session->userdata('userId');
            $params = $_REQUEST;
            $totalRecords = $this->student_model->getTaxinvoicesCount($params,$userId);
            $queryRecords = $this->student_model->getTaxinvoices($params,$userId); 
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


        public function studentadmissions(){
            $this->global['pageTitle'] = 'Student Admission and Enquiry Listing';
            $this->loadViews("student/student_admienq_listing", $this->global, NULL, NULL);
        }

     
        public function fetchstudentadmissions(){
            $params = $_REQUEST;
            $userId =  $this->session->userdata('userId');
            $totalRecords = $this->student_model->getEnquiryCount($params,$userId); 
            $queryRecords = $this->student_model->getEnquirydata($params,$userId); 
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
    

        public function studentpaymentdetails($id){

            $process = 'Student Enquiry Payment Details';
            $processFunction = 'Student/studentpaymentdetails';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Student Enquiry Payment Details';
            $data['enquiry_id'] = $id;
            $data['followDataenquiry'] = $this->enquiry_model->getEnquiryInfo($id);
            $data['getEnquirypaymentInfo'] = $this->enquiry_model->getEnquirypaymentInfo($id);
            $data['gettotalpaidEnquirypaymentInfo'] = $this->enquiry_model->gettotalpaidEnquirypaymentInfo($id);
            $this->loadViews("student/student_payment_details", $this->global, $data , NULL);
        }


        public function studentcourses(){

            $this->global['pageTitle'] = 'Student Courses List';
            $this->loadViews("student/studentcoureslisting", $this->global, NULL, NULL);
        }

        public function fetchstudentcourse()
        {

            $params = $_REQUEST;
            $userId =  $this->session->userdata('userId');
            $totalRecords = $this->student_model->getstudentCourseCount($params,$userId); 
            $queryRecords = $this->student_model->getstudentCoursedata($params,$userId); 
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

        public function viewstudentscoursetopis($id){
            $process = 'View Student Course Infromation';
            $processFunction = 'student/viewstudentscoursetopis';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'View Student Course Infromation';
            $data['getCourseinfo'] = $this->course_model->getCourseInfo($id);
            $this->loadViews("student/studentcourseattchmentlist", $this->global, $data , NULL);
        }


        public function fetchstudnetCourseAttchemant($courseid){
            $params = $_REQUEST;
            $totalRecords = $this->student_model->getstudentCourseattchmentCount($params,$courseid); 
            $queryRecords = $this->student_model->getstudentCourseattchmentdata($params,$courseid); 

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

        public function studenttopicdocumentslisting(){

            $topic_id = $this->input->get('topic_id');
            $course_id = $this->input->get('course_id');
            $data['course_topic_info'] =  $this->course_model->get_signle_course_topicattchment($topic_id,$course_id);

            $data['documents'] =  $this->course_model->getDocumentcount($topic_id,$course_id);
            $data['videos'] =  $this->course_model->getVideoscount($topic_id,$course_id);
            $data['books'] =  $this->course_model->getBookscount($topic_id,$course_id);

            $process = 'Student Topic Attachment Listing';
            $processFunction = 'Student/studenttopicdocumentslisting';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Student Topic Attachment Listing';
            $this->loadViews("student/studenttopicdocumentattchlisting", $this->global,$data , NULL);
        }


        public function studentviewalltopicdocuments(){
            $topic_id = $this->input->get('topic_id');
            $course_id = $this->input->get('course_id');
            $data['course_topic_info'] =  $this->course_model->get_signle_course_topicattchment($topic_id,$course_id);
            $data['type'] =  $this->input->get('type');
            $data['topic_id'] =  $topic_id;
            $data['course_id'] =  $course_id;
            $process = 'Studnet Topic Attachment Upload Listing';
            $processFunction = 'Course/topicattachmentListing';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Studnet Topic Attachment Upload Listing';
            $this->loadViews("student/viewalltopicdoc", $this->global,$data , NULL);
        }



        public function studentfetchTopicDocument(){

            $topic_id = $this->input->get('topic_id');
            $course_id = $this->input->get('course_id');
            $type =  $this->input->get('type');

            $params = $_REQUEST;
            $totalRecords = $this->student_model->studentgetFetchtopicdocumentCount($params,$topic_id,$course_id,$type); 
            $queryRecords = $this->student_model->studentgetFetchtopicdocumentData($params,$topic_id,$course_id,$type); 

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


        public function studenttimetableListing($id){
            $process = 'Studnet Time Table Listing';
            $processFunction = 'Course/addtimetableListing';
            $data['course_id'] = $id;
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Studnet Time Table Listing';
            $data['getCourseinfo'] = $this->course_model->getCourseInfo($id);
            $this->loadViews("student/studenttimetablelisting", $this->global, $data , NULL);
        }


        public function fetchstudentTimetable($courseid){

            $params = $_REQUEST;
            $totalRecords = $this->student_model->studentgettimetableCount($params,$courseid); 
            $queryRecords = $this->student_model->studentgettimetabledata($params,$courseid); 

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



        public function studentviewtimetablelisting(){

            $time_table_id = $this->input->get('time_table_id');
            $course_id = $this->input->get('course_id');
            $data['time_table_id'] = $time_table_id;
            $data['course_id'] = $course_id;
            $data['getCourseinfo'] = $this->course_model->getCourseInfo($data['course_id']);
            $data['getTimetableInfo'] = $this->course_model->getTimetableInfo($data['course_id'],$data['time_table_id']);
            $this->global['pageTitle'] = 'Detail Student View Timetable Listing';
            $this->loadViews("student/studenttimelist",$this->global,$data,NULL);
        }


        public function fetchStudentTopicTimetableListing(){

            $time_table_id = $this->input->get('time_table_id');
            $course_id = $this->input->get('course_id');

            $params = $_REQUEST;
            $totalRecords = $this->student_model->gettstudnetimetabletopiclistingCount($params,$time_table_id,$course_id); 
            $queryRecords = $this->student_model->gettstudentimetabletopiclistingdata($params,$time_table_id,$course_id); 

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


        public function addstudenttopiclinksforonlineattendant(){

            $time_table_transection_id = $this->input->get('id');
            $time_table_id = $this->input->get('time_table_id');
            $course_id = $this->input->get('course_id'); 
            $data['time_table_transection_id'] = $time_table_transection_id;
            $data['time_table_id'] = $time_table_id;
            $data['course_id'] = $course_id;
            $data['getCourseinfo'] = $this->course_model->getCourseInfo($data['course_id']);
            $data['getTimetableInfo'] = $this->course_model->getTimetableInfo($data['course_id'],$data['time_table_id']);
            $data['getTopicinfo'] = $this->course_model->getTopicinfo($data['course_id'],$data['time_table_id'],$data['time_table_transection_id']);
            $this->global['pageTitle'] = 'View Student Timetable Topic Link';
            $this->loadViews("student/viewstudenttopiclinks",$this->global,$data,NULL);

        }


        
        public function fetchstudenttopicmeetinglink(){

            $time_table_id = $this->input->get('time_table_id');
            $course_id = $this->input->get('course_id');
            $time_table_transection_id = $this->input->get('id');

            $params = $_REQUEST;
            $totalRecords = $this->student_model->getstudenttopicmeetinglinkCount($params,$time_table_id,$course_id,$time_table_transection_id); 
            $queryRecords = $this->student_model->getstudenttopicmeetinglinkData($params,$time_table_id,$course_id,$time_table_transection_id); 

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


    }

?>