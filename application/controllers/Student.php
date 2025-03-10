<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            $this->load->model('examination_model');
            $this->load->model('course_model');
            $this->load->model('comman_model');
            $this->load->model('enquiry_model');
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

                        $file = rand(1000,100000)."-".$_FILES['profile_photo']['name'];
                        $filename = str_replace(' ','_',$file);
        
                        $config['upload_path'] = 'uploads/profile_pic'; 
                        $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                        $config['max_size'] = '10000000000'; // max_size in kb 
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

        public function studentbookissued($id){
            $this->global['pageTitle'] = 'Student Book Issue';
            $data['enq_course_list'] = $this->student_model->getCourseDetailsforBooksAddedornot($id);
            $data['getstudentdetails'] = $this->student_model->getAllstudentdata($id);
            $data['student_id'] = $id;
            $this->loadViews("student/studentbookissued", $this->global, $data, NULL);
        }


        public function update_book_issued(){

            $post_submit = $this->input->post();
            $updatebookissued_response = array();
            if($post_submit){

                $student_id = $this->input->post('student_id');
                $course_check = $this->input->post('course_check');
                $restrict = $this->input->post('restrict');

                $data = array(
                    'book_issued'      => json_encode($course_check),
                    'restrict'      => json_encode($restrict),
                );
                /* Update Course */

                $updatebookissueddata = $this->student_model->updatebookissued($student_id,$data);

                if($updatebookissueddata){
                    $updatebookissued_response['status'] = 'success';
                }

                echo json_encode($updatebookissued_response);
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

            $data['getadditionalcourseInfostudent'] = $this->enquiry_model->getadditionalInfo( $id);



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

        public function attendClasses(){

            $post_submit = $this->input->post();

            if($post_submit){

                $attendance_response = array();

                 if(trim($this->input->post('join_link')) =='YES'){
                    $data = array(
                        'user_id'  => $this->input->post('user_id'),
                        'topic_id' => $this->input->post('topic_id'),
                        'course_id' => $this->input->post('course_id'),
                        'meeting_id' => $this->input->post('meeting_id'),
                        'meeting_link' => $this->input->post('meeting_link'),
                        'attendance_status' => 1,
                        'join_link' => 1,
                    );
                 }
                 else if(trim($this->input->post('print_card')) =='YES'){

                    $data = array(
                        'user_id'  => $this->input->post('user_id'),
                        'topic_id' => $this->input->post('topic_id'),
                        'course_id' => $this->input->post('course_id'),
                        'meeting_id' => $this->input->post('meeting_id'),
                        'meeting_link' => $this->input->post('meeting_link'),
                        'attendance_status' => 1,
                        'print_card' => 1,
                    );

                }else{
                    $data = array(
                        'user_id'  => $this->input->post('user_id'),
                        'topic_id' => $this->input->post('topic_id'),
                        'course_id' => $this->input->post('course_id'),
                        'meeting_id' => $this->input->post('meeting_id'),
                        'meeting_link' => $this->input->post('meeting_link'),
                        'attendance_status' => 1,
                    );
                }


                /*check if data is alreday exits */

               
                $checkifAttendanceaxist = $this->student_model->checkifAttendanceaxist($data);
                if($checkifAttendanceaxist > 0){
                    $attendance_response['status'] = 'success';
                    echo json_encode($attendance_response);
                }else{
                    $saveAttendancedata = $this->student_model->saveAttendancedata($data);

                    if($saveAttendancedata ){
                        $attendance_response['status'] = 'success';
                    }else{
                        $attendance_response['status'] = 'failure';
                    }
                    echo json_encode($attendance_response);

                }
            
            }

        }

        public function studentattendance(){
            $this->global['pageTitle'] = 'view Student Attendance';
            $this->loadViews("student/view_student_Attendance", $this->global, NULL, NULL);

        }

        public function fetchstudentattendancestudentpanel(){

            $params = $_REQUEST;
            $userId =  $this->session->userdata('userId');
            $totalRecords = $this->student_model->getstudentAttendanceCount($params,$userId);
            $queryRecords = $this->student_model->getstudentAttendancedata($params,$userId); 
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
        
        public function studentexamination($id){

            $this->global['pageTitle'] = 'Student Examination';
            $data['course_id'] = $id;
            $this->loadViews("student/view_student_examination", $this->global, $data, NULL);
        }

        public function fetchstudentexamination($course_id){

            $params = $_REQUEST;
            $userId =  $this->session->userdata('userId');
            $totalRecords = $this->student_model->getstudentexaminationCount($params,$userId,$course_id);
            $queryRecords = $this->student_model->getstudentexaminationdata($params,$userId,$course_id); 
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

        public function attendexamination($exam_id){
            $this->global['pageTitle'] = 'Attend Exam';
            $data['exam_detail'] = $this->student_model->getExamdetails($exam_id);
            $data['question_paper'] = $this->student_model->getstudentexamquestionlist($exam_id);
            $this->loadViews("student/attend_exam", $this->global, $data, NULL);
        }

        public function start_exam($exam_id){
            $this->global['pageTitle'] = 'Examination Started';
            $data['exam_detail'] = $this->student_model->getExamdetails($exam_id);
            $data['question_paper'] = $this->student_model->getstudentexamquestionlist($exam_id);
            $data['student_id'] =  $this->session->userdata('userId');
            $data['question_paper'] = $this->student_model->getstudentexamquestionlist($exam_id);

            $course_id = $data['exam_detail'][0]['course_id'];
            $examination_id = $data['exam_detail'][0]['id'];

            $data['getstudent_information'] = $this->student_model->getstudentinformation(trim($this->session->userdata('userId')));
            
            $data['questionPaperListMCQ'] = $this->examination_model->getquestionPaperListMCQInfo($course_id,$examination_id);
            $data['questionPaperListWRITTEN'] = $this->examination_model->getquestionPaperListWRITTENInfo($course_id,$examination_id);
            $data['questionPaperListMATCHPAIR'] = $this->examination_model->getquestionPaperListMATCHPAIRInfo($course_id,$examination_id);
            $this->loadViews("student/start_exam", $this->global, $data, NULL);
        }


        public function submit_examination_db(){

           $exam_answer_data = $this->input->post();

           $savesnswerdata_response =array();
           if($exam_answer_data){

            $examination_id = $this->input->post('examination_id');
            $course_id = $this->input->post('course_id');
            $student_id = $this->input->post('student_id');

            foreach ($exam_answer_data as $key => $value) {

                if($key=='examination_id' || $key=='course_id' ||  $key=='student_id'){


                }else{

                    preg_match_all('!\d+\.*\d*!', $key, $matches);

                    $data = array(
                        'student_id'      => $student_id,
                        'course_id'       => $course_id,
                        'exam_id'         => $examination_id,
                        'question_id'  => $matches[0][0],
                        'question_answer'    => $value,
                        'exam_status' => 'solved',
                    );

                    $saveAnswerdata = $this->student_model->saveAnswerdata('',$data);

                    // if($saveAnswerdata){

                        // $getStudentRecord = $this->student_model->getStudentrecords($student_id);


                        // $name = $getStudentRecord[0]['name']; 
                        // $lastname = $getStudentRecord[0]['lastname']; 
                        // $mobile = $getStudentRecord[0]['mobile']; 
                        // $email = $getStudentRecord[0]['email']; 

                    
                        // $to = $email;
                        // $from = 'admin@iictn.in'; 
                        // $fromName = 'IICTN'; 
                        // //$subject = 'IICTN - Marketing Material '.date('Y-m-d H:i:s');
                        // $subject = 'IICTN Examination Submitted Successfully !! '.date('Y-m-d H:i:s');
                        
                        // $header = "From: IICTN-Marketing Material <admin@iictn.in> \r\n";
                        // //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                        // $header .= "MIME-Version: 1.0\r\n";
                        // $header .= "Content-type: text/html\r\n";
    
    
                        // $htmlContent = '<div>
                        //                     <p>Thank you for submitting your answer sheet, you will be intimated by Email / WhatsApp after the assessment will be done by the examiner.</p>
                        //                     <p>For More Details browse on www.iictn.in / Contact your Counsellor or write us on admin@iictn.org</p>

                        //                 </div>

                        //                 <div>
                        //                     <p><b>Thanks & Regards<b></p>
                        //                     <p><b>Team IICTN</b></p>
                        //                 </div> '; 
                       
                        
                        // $retval = mail($to,$subject,$htmlContent,$header);


                        // if($retval){

                            // /* Send Whats App  Start Here */
                            // $curl = curl_init();
                            // $text = 'Thank you for submitting your answer sheet, you will be intimated by Email / WhatsApp after the assessment will be done by the examiner . For More Details browse on www.iictn.in / Contact your Counsellor or write us on admin@iictn.org';
                            // //$text = 'Dear '.$enq_fullname.' Thank You for your interest in '.$all_course_name.', We have attached the brochure and Syllabus for your reference. Feel free to contact us back, we will be delighted to assist and guide you.For more details, you can also visit our website www.iictn.org';      
                            // $mobile = '91'.$mobile;
                            // $url = "https://marketing.intractly.com/api/send.php?number=".$mobile."&type=text&message=".urlencode($text)."&instance_id=".INSTANCE_ID."&access_token=".ACCESS_TOKEN."";
                
                            // $ch = curl_init();
                            // curl_setopt($ch, CURLOPT_URL, $url);
                            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
                            // // This is what solved the issue (Accepting gzip encoding)
                            // // curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
                            // $response = curl_exec($ch);
                            // curl_close($ch);
                            // // echo $response;

                             
                        // }

                        $savesnswerdata_response['status'] = 'success';
                        $savesnswerdata_response['error'] = array('name'=>'', 'email'=>'', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password'=>'');
        
                //    }

                  
                    
                }
                 
            }

            echo json_encode($savesnswerdata_response);
           }


        }


        public function showexamstatus($exam_id){

            $this->global['pageTitle'] = 'Examination Started';
            $data['exam_detail'] = $this->student_model->getExamdetails($exam_id);
            $data['question_paper'] = $this->student_model->getstudentexamquestionlist($exam_id);
            $data['student_id'] =  $this->session->userdata('userId');

            $course_id = $data['exam_detail'][0]['course_id'];
            $examination_id = $data['exam_detail'][0]['id'];
            
            $data['questionPaperListMCQ'] = $this->examination_model->getquestionPaperListMCQInfo($course_id,$examination_id);
            $data['questionPaperListWRITTEN'] = $this->examination_model->getquestionPaperListWRITTENInfo($course_id,$examination_id);
            $data['questionPaperListMATCHPAIR'] = $this->examination_model->getquestionPaperListMATCHPAIRInfo($course_id,$examination_id);
            $this->loadViews("student/showexamstatus", $this->global, $data, NULL);

        }



        
    public function studentcrtificateListing(){

        $this->global['pageTitle'] = 'Student Certificate Listing';
        $this->loadViews("student/crtificateListingStudentportal", $this->global, NULL, NULL);

    }


    public function fetchallstudentcertificatesstudentPortal(){

        $params = $_REQUEST;
        $totalRecords = $this->student_model->studentcertificateCount($params); 
        $queryRecords = $this->student_model->studentcertificateData($params); 
    
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


    public function updateevbtrnumber(){

        $post_submit =  $this->input->post();

        if(!empty($post_submit)){

                 $save_evbtr_response = array();

                 $certificate_id= $this->input->post('certificate_id');

                 $data = array(
                     //'certificate_id' => $this->input->post('certificate_id'),
                     'evbtrdate' => date('Y-m-d', strtotime($this->input->post('evbtrdate'))),
                     'evbtr' => $this->input->post('evbtr'),
                     'evbtrremark' => $this->input->post('remark'),
                 );

                 $this->form_validation->set_rules('evbtrdate', 'Evbtr Date', 'trim|required');
                 $this->form_validation->set_rules('evbtr', 'EVBTR Number', 'trim|required');

                 if($this->form_validation->run() == FALSE){

                     $save_evbtr_response['status'] = 'failure';
                     $save_evbtr_response['error'] = array('evbtrdate'=>strip_tags(form_error('evbtrdate')),'evbtr'=>strip_tags(form_error('evbtr')));

                 }else{
                         $updateEvbtrNumber = $this->student_model->updateEvbtrNumber($certificate_id,$data);
                         if($updateEvbtrNumber){
                             $save_evbtr_response['status'] = 'success';
                             $save_evbtr_response['error'] = array('evbtrdate'=>'','evbtr'=>'');
                         }
                 }
                 
          }
          echo json_encode($save_evbtr_response);
     }


     public function studentexaminationlist(){
        $userId =  $this->session->userdata('userId');
        $this->global['pageTitle'] = 'Student Examination List';
        $data['getstudentexaminationdata'] = $this->student_model->getstudentexaminListationdata($userId); 
        $this->loadViews("student/studentexaminationlist", $this->global, $data, NULL);

     }


     public function askqquery(){

        $this->global['pageTitle'] = 'Ask A Query';
        $userId =  $this->session->userdata('userId');
        $data['course_List'] = $this->student_model->getstudentcourse($params,$userId); 
        $this->loadViews("student/askqquery", $this->global,$data, NULL);
     }


     public function fetchallstudentquerys(){

        $params = $_REQUEST;
        $userId =  $this->session->userdata('userId');
        $roleText = $this->session->userdata('roleText');

        $totalRecords = $this->student_model->getallstudentquerycount($params,$userId,$roleText); 
        $queryRecords = $this->student_model->getallstudentquerydata($params,$userId,$roleText); 
    
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


     public function getcoursetopic() {
        if($this->input->post('course_id')) {
            $states = $this->student_model->getcoursetopic($this->input->post('course_id'));

            if(count($states) >= 1) {
                    $content = '<option value="">Select Topic</option>';
                foreach($states as $state) {
                    $content = $content.'<option value="'.$state["id"].'">'.$state["topic"].'</option>';
                }
                echo $content;
            } else {
                echo 'failure';
            }
        } else {
            echo 'failure';
        }
    }



     public function addnewquery(){
        $post_submit = $this->input->post();
  
        if(!empty($post_submit)){
            $userId =  $this->session->userdata('userId');

            $addnewquery_response = array();
            $data = array(
                'course_id' => $this->input->post('course_name'),
                'certificate_topic'=> $this->input->post('certificate_topic'),
                'query'=> $this->input->post('query'),
                'student_id'=>$userId
            );

            $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
            $this->form_validation->set_rules('certificate_topic', 'Certificate Topic', 'trim|required');
            $this->form_validation->set_rules('query', 'Query', 'trim|required');

            if($this->form_validation->run() == FALSE){
                $addnewquery_response['status'] = 'failure';
                $addnewquery_response['error'] = array('course_name'=>strip_tags(form_error('course_name')),'certificate_topic'=>strip_tags(form_error('certificate_topic')),'query'=>strip_tags(form_error('query')));
            }else{
                
                $saveCoursedata = $this->student_model->saveQuerydata('',$data);
                if($saveCoursedata){
                    $addnewquery_response['status'] = 'success';
                    $addnewquery_response['error'] = array('course_name'=>strip_tags(form_error('course_name')),'certificate_topic'=>strip_tags(form_error('certificate_topic')) ,'query'=>strip_tags(form_error('query')));
                }
            }
            echo json_encode($addnewquery_response);
        }
     }


     public function delete_query(){

        $post_submit = $this->input->post();
        
        $enquiryInfo = array('isDeleted'=>1,'updatedBy'=> $this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
        $result = $this->database->data_update('tbl_askquery',$enquiryInfo,'id',$this->input->post('id'));

        if ($result > 0) {
             echo(json_encode(array('status'=>TRUE)));

             $process = 'Delete Query';
             $processFunction = 'Student/delete_query';
             $this->logrecord($process,$processFunction);

            }
        else { echo(json_encode(array('status'=>FALSE))); }

     }


        public function viewqueryanswer($query_id){

            $this->global['pageTitle'] = 'Ask A Query Answer';
            $userId =  $this->session->userdata('userId');
            $data['userId'] =  $this->session->userdata('userId');
            $data['query_id'] =  $query_id;
            $data['getquerydatabyid'] =  $this->student_model->getquerydatabyid($query_id);

            $this->loadViews("student/viewqueryanswer", $this->global,$data, NULL);
        }


        public function fetchallstudentquerysanswer($query_id){

            $params = $_REQUEST;
            $userId =  $this->session->userdata('userId');
            $roleText = $this->session->userdata('roleText');
    
            $totalRecords = $this->student_model->getallstudentqueryanswercount($params,$userId,$roleText,$query_id); 
            $queryRecords = $this->student_model->getallstudentqueryanswerdata($params,$userId,$roleText,$query_id); 
        
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


        public function addqueryanswer(){
            $post_submit = $this->input->post();


            if(!empty($post_submit)){

                $addnewqueryanswer_response = array();
                $data = array(
                            'student_id' => $this->input->post('userId'),
                            'query_id'=> $this->input->post('query_id'),
                            'query_answer'=>$this->input->post('query_answer'),
                    );

                $this->form_validation->set_rules('query_answer', 'Query', 'trim|required');


                if($this->form_validation->run() == FALSE){
                            $addnewqueryanswer_response['status'] = 'failure';
                            $addnewqueryanswer_response['error'] = array('query_answer'=>strip_tags(form_error('query_answer')));
                }else{

                    $saveCoursedata = $this->student_model->saveQueryanswerdata('',$data);
                       if($saveCoursedata){
                                $addnewqueryanswer_response['status'] = 'success';
                                $addnewqueryanswer_response['error'] = array('query_answer'=>strip_tags(form_error('query_answer')));
                            }

                    }

                    echo json_encode($addnewqueryanswer_response);
                }


        }


        public function delete_query_answer(){

            $post_submit = $this->input->post();
            $enquiryInfo = array('isDeleted'=>1,'updatedBy'=> $this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->database->data_update('tbl_queryanswers',$enquiryInfo,'id',$this->input->post('id'));
    
            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));
    
                 $process = 'Delete Query Answer';
                 $processFunction = 'Student/delete_query_answer';
                 $this->logrecord($process,$processFunction);
    
                }
            else { echo(json_encode(array('status'=>FALSE))); }

        }



        public function studentreport(){
            $this->global['pageTitle'] = 'Student Report';
            $data['getallstudentlist'] =  $this->student_model->getallstudentlist();
            $data['getCourseList'] =  $this->comman_model->getCourseList();
            $this->loadViews("student/studentreport", $this->global, $data, NULL);
        }


        public function fetchallstudentreportlist(){

            $params = $_REQUEST;

            $totalRecords = $this->student_model->getallstudentreportcount($params); 
            $queryRecords = $this->student_model->getallstudentreportdata($params); 

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


        public function fetchallstudentdataforprintidcard(){

            $post_submit = $this->input->post();

            if($post_submit){

                $attendance_response = array();

                $data = array(
                    'user_id'  => $this->input->post('user_id'),
                    'topic_id' => $this->input->post('topic_id'),
                    'course_id' => $this->input->post('course_id'),
                    'meeting_id' => $this->input->post('meeting_id'),
                    'meeting_link' => $this->input->post('meeting_link'),
                    'attendance_status' => 1,
                );

                $getallstudentdata = $this->student_model->getallstudentdataforshowidcard($data)[0];

                if($getallstudentdata){

                     $fetchall_staudent_data['status'] = 'success';
                     $fetchall_staudent_data['data'] = array('date'=>$getallstudentdata['date'],'classtime'=>$getallstudentdata['classtime'],'course_name'=>$getallstudentdata['course_name'],'title'=>$getallstudentdata['title'],'email'=>$getallstudentdata['email'], 'username'=>$getallstudentdata['username'], 'name'=>$getallstudentdata['name'], 'lastname'=>$getallstudentdata['lastname'],'mobile'=>$getallstudentdata['mobile'],'user_flag'=>$getallstudentdata['user_flag'],'profile_pic'=>$getallstudentdata['profile_pic']);
                }else{

                    $fetchall_staudent_data['status'] = 'failure';
                    $fetchall_staudent_data['error'] = array('evbtrdate'=>strip_tags(form_error('evbtrdate')),'evbtr'=>strip_tags(form_error('evbtr')));                    
                }
                
                echo json_encode($fetchall_staudent_data);

            }

        }


        public function studentreportexporttoexel() {
            $fileName = 'employee.xlsx';  
            $employeeData = $this->student_model->getAllstudentlistexport();
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Id');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Skills');
            $sheet->setCellValue('D1', 'Address');
            $sheet->setCellValue('E1', 'Age');
            $sheet->setCellValue('F1', 'Designation');       
            $rows = 2;
            foreach ($employeeData as $val){
                $sheet->setCellValue('A' . $rows, $val['userId']);
                $sheet->setCellValue('B' . $rows, $val['name']);
                $sheet->setCellValue('C' . $rows, $val['name']);
                $sheet->setCellValue('D' . $rows, $val['name']);
            $sheet->setCellValue('E' . $rows, $val['name']);
                $sheet->setCellValue('F' . $rows, $val['name']);
                $rows++;
            } 

            // $writer = new Xlsx($spreadsheet);
            // $writer->save("upload/".$fileName);
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url()."/upload/".$fileName);    
            
                // header('Content-Type: application/vnd.ms-excel');
				// header("Content-Disposition: attachment;Filename=$fileName.xls");
				// header('Cache-Control: max-age=0');
				// // $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//  //$writer->save('php://output');
				// exit;

                //$writer = new Xlsx($spreadsheet);
        // $writer->save('world.xlsx');
        // return $this->response->download('world.xlsx', null)->setFileName('sample.xlsx');

        // if($extension == 'csv'){          
        //     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        //     $fileName1 = $fileName.'.csv';
        //   } elseif($extension == 'xlsx') {
        //     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        //     $fileName1 = $fileName.'.xlsx';
        //   } else {
        //     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        //     $fileName1 = $fileName.'.xls';
        //   }
          $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
      
          $this->output->set_header('Content-Type: application/vnd.ms-excel');
          $this->output->set_header("Content-type: application/csv");
          $this->output->set_header('Cache-Control: max-age=0');
          $writer->save("uploads/".$fileName);
          /*redirect(HTTP_UPLOAD_PATH.$fileName); */
          $filepath = file_get_contents("/".$fileName1);
          force_download($fileName1, $filepath);

        }    


        public function studentreportexportpdf(){
            $this->global['pageTitle'] = 'Student Report';
            $data['getallstudentlist'] =  $this->student_model->getallstudentlist();
            $data['getCourseList'] =  $this->comman_model->getCourseList();
            $this->loadViews("student/studentreport", $this->global, $data, NULL);
        }
        

        public function leaverequest(){
            $this->global['pageTitle'] = 'view Leave Request';
            $this->loadViews("student/view_leaverequest", $this->global, NULL, NULL);
        }


        public function fetchleaverequestlist(){

            $params = $_REQUEST;

            $totalRecords = $this->student_model->getallleaverequestcount($params); 
            $queryRecords = $this->student_model->getallleaverequestdata($params); 

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


        public function addnewleaverequest(){
            $post_submit = $this->input->post();
            if(!empty($post_submit)){
                $userId =  $this->session->userdata('userId');
                $addnewcoursetopicrequest_response = array();

                $this->form_validation->set_rules('leave_title', 'Leave Title', 'trim|required');
                $this->form_validation->set_rules('leave_from_date', 'Leave From Date', 'trim|required');
                $this->form_validation->set_rules('leave_to_date', 'Leave To Date', 'trim|required');
                $this->form_validation->set_rules('leave_description', 'Leave Description', 'trim');
                //$this->form_validation->set_rules('file', 'Leave Description', 'trim|required');


                $filesize = round($_FILES['file']['size'] / 1024 , 2);
                $file_error="";
                if(!empty($_FILES['file']['size'])){ 
                    if($_FILES['file']['size'] > 0){ 

                        $targetDir = "uploads/leave_request_doc/"; 
                        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif','xls','xlsx','txt'); 
                        $fileName_original = basename($_FILES['file']['name']); 
                        $fileName_original_for_download = $_FILES['file']['name']; 
                        //$fileName =uniqid(rand(), true).'-'.$doc_type.'-'.basename($_FILES['file']['name']); 
                        $fileName =$_FILES['file']['name']; 
                       // $fileName =basename($_FILES['file']['name']); 
                        $targetFilePath = $targetDir.$fileName; 
                        // Check whether file type is valid 
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 


                        if(in_array($fileType, $allowTypes)){ 
                            if(move_uploaded_file($_FILES['file']['tmp_name'], str_replace(' ', '_', $targetFilePath))){ 
                              $doc_url = base_url().str_replace(' ', '_', $targetFilePath);
                            }
                        }

                    }
                    }else{
                        $doc_url ='';
                    }

                        $data = array(
                            'leave_title' => $this->input->post('leave_title'),
                            'leave_from_date'=> $this->input->post('leave_from_date'),
                            'leave_to_date'=>$this->input->post('leave_to_date'),
                            'leave_description'=>$this->input->post('leave_description'),
                            'leave_document' =>$doc_url,
                            'student_id'=>$userId,
                        );
                    
                        if($this->form_validation->run() == FALSE){
                                    $addnewcoursetopicrequest_response['status'] = 'failure';
                                    $addnewcoursetopicrequest_response['error'] = array('leave_title'=>strip_tags(form_error('leave_title')),'leave_from_date'=>strip_tags(form_error('leave_from_date')),'leave_to_date'=>strip_tags(form_error('leave_to_date')),'leave_description'=>strip_tags(form_error('leave_description')),'leave_document'=>$file_error);
                        }else{
                            $saveCoursedata = $this->student_model->savenewcoursetopicrequest('',$data);
                            if($saveCoursedata){
                                        $addnewcoursetopicrequest_response['status'] = 'success';
                                        $addnewcoursetopicrequest_response['error'] = array('leave_title'=>strip_tags(form_error('leave_title')),'leave_from_date'=>strip_tags(form_error('leave_from_date')),'leave_to_date'=>strip_tags(form_error('leave_to_date')),'leave_description'=>strip_tags(form_error('leave_description')),'leave_document'=>$file_error);
                                }
                        }

    
            
                echo json_encode($addnewcoursetopicrequest_response);
            }

        }

        
        public function deleteleaverequestdata(){

            $post_submit = $this->input->post();

            $DeleteLeaverequest = array('isDeleted'=>1,'updatedBy'=> $this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->database->data_update('tbl_leave',$DeleteLeaverequest,'id',$this->input->post('id'));

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Leave Request Delete';
                 $processFunction = 'Enquiry/deleteleaverequestdata';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }

        }

        public function editleaverequest($id){
            $post_submit = $this->input->post();

            if(!empty($post_submit)){
                $userId =  $this->session->userdata('userId');
                $addnewcoursetopicrequest_response = array();

                $this->form_validation->set_rules('leave_title', 'Leave Title', 'trim|required');
                $this->form_validation->set_rules('leave_from_date', 'Leave From Date', 'trim|required');
                $this->form_validation->set_rules('leave_to_date', 'Leave To Date', 'trim|required');
                $this->form_validation->set_rules('leave_description', 'Leave Description', 'trim');

                $leave_id = $this->input->post('leave_id');
                
                $filesize = round($_FILES['file']['size'] / 1024 , 2);
                $file_error="";
                if(!empty($_FILES['file']['size'])){ 
                    if($_FILES['file']['size'] > 0){ 

                        $targetDir = "uploads/leave_request_doc/"; 
                        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif','xls','xlsx','txt'); 
                        $fileName_original = basename($_FILES['file']['name']); 
                        $fileName_original_for_download = $_FILES['file']['name']; 
                        //$fileName =uniqid(rand(), true).'-'.$doc_type.'-'.basename($_FILES['file']['name']); 
                        $fileName =$_FILES['file']['name']; 
                       // $fileName =basename($_FILES['file']['name']); 
                        $targetFilePath = $targetDir.$fileName; 
                        // Check whether file type is valid 
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 


                        if(in_array($fileType, $allowTypes)){ 
                            if(move_uploaded_file($_FILES['file']['tmp_name'], str_replace(' ', '_', $targetFilePath))){ 
                              $doc_url = base_url().str_replace(' ', '_', $targetFilePath);
                            }
                        }

                    }
                }
                        $data = array(
                            'leave_title' => $this->input->post('leave_title'),
                            'leave_from_date'=> $this->input->post('leave_from_date'),
                            'leave_to_date'=>$this->input->post('leave_to_date'),
                            'leave_description'=>$this->input->post('leave_description'),
                            'leave_document' =>$doc_url,
                            'student_id'=>$userId,
                        );
                    
                        if($this->form_validation->run() == FALSE){
                                    $addnewcoursetopicrequest_response['status'] = 'failure';
                                    $addnewcoursetopicrequest_response['error'] = array('leave_title'=>strip_tags(form_error('leave_title')),'leave_from_date'=>strip_tags(form_error('leave_from_date')),'leave_to_date'=>strip_tags(form_error('leave_to_date')),'leave_description'=>strip_tags(form_error('leave_description')),'leave_document'=>$file_error);
                        }else{
                            $saveCoursedata = $this->student_model->savenewcoursetopicrequest($leave_id,$data);
                            if($saveCoursedata){
                                        $addnewcoursetopicrequest_response['status'] = 'success';
                                        $addnewcoursetopicrequest_response['error'] = array('leave_title'=>strip_tags(form_error('leave_title')),'leave_from_date'=>strip_tags(form_error('leave_from_date')),'leave_to_date'=>strip_tags(form_error('leave_to_date')),'leave_description'=>strip_tags(form_error('leave_description')),'leave_document'=>$file_error);
                                }
                        }
            
                echo json_encode($addnewcoursetopicrequest_response);
            }else{
                $this->global['pageTitle'] = 'Edit Leave Request';
                $data['getLeaveRequestdata'] =  $this->student_model->getLeaveRequestdata($id);
                $this->loadViews("student/edit_leaverequest", $this->global, $data, NULL);
            }
        }

        public function deleteaddattachment(){

            $post_submit = $this->input->post();

            $id = $post_submit['id'];
            $data =array('leave_document'=>'');

            $this->db->where('id', $id);
            $this->db->update('tbl_leave', $data);

            if($this->db->trans_complete()){
                echo(json_encode(array('status'=>TRUE)));
                $process = 'Leave Request Delete';
                $processFunction = 'Enquiry/deleteaddattachment';
                $this->logrecord($process,$processFunction);
            }else { echo(json_encode(array('status'=>FALSE))); }
        }

    }

?>