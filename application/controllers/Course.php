<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';
    // require_once APPPATH."/third_party/PHPExcel.php";
    // require_once APPPATH."/third_party/PHPExcel/IOFactory.php";

    class Course extends BaseController
    {
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model(array('login_model', 'course_model', 'database'));
            $this->load->helper(array('form', 'url'));
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

        public function courseListing()
        {
            $this->global['pageTitle'] = 'Course Management';
            $data['course_type'] = $this->course_model->getAllCourseTypeInfo();
            $data['get_trainer'] = $this->course_model->getAllTrainerInfo();

            $this->loadViews("course/courseList",$this->global,$data,NULL);
        }

        public function fetchcourse()
        {

            $params = $_REQUEST;
            $totalRecords = $this->course_model->getCourseCount($params); 
            $queryRecords = $this->course_model->getCoursedata($params); 
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

        public function addcourseListing($id){
            $this->global['pageTitle'] = 'Course Listing Attachment';
            //$data['course_type'] = $this->course_model->getAllCourseTypeInfo();
            $data['getCourseinfo'] = $this->course_model->getCourseInfo($id);
            $this->loadViews("course/courseAttachment",$this->global,$data,NULL);
        }

        function get_signle_courseData($courseId = NULL)
        {
            $courseId = $this->input->post('courseId');
            $data = $this->course_model->getCourseInfo($courseId);
            echo json_encode($data);
        }

        function createcourse(){
            $post_submit = $this->input->post();
            if(!empty($post_submit)){

                $createcourse_response = array();

                if($this->input->post('fees')){
                    $fess  = $this->input->post('fees');
                }else{
                    $fess  = 0;
                }

                if($this->input->post('certificate_cost')){
                    $certificate_cost  = $this->input->post('certificate_cost');
                }else{
                    $certificate_cost  = 0;
                }

                if($this->input->post('one_time_admission_fees')){
                    $one_time_admission_fees  = $this->input->post('one_time_admission_fees');
                }else{
                    $one_time_admission_fees  = 0;
                }


                if($this->input->post('kit_cost')){
                    $kit_cost  = $this->input->post('kit_cost');
                }else{
                    $kit_cost  = 0;
                }

                $total_course_fees  = $this->input->post('total_course_fees');

                $sgst_tax  = $this->input->post('sgst_tax');
                $sgst_tax_value  = $this->input->post('sgst');
                
                $cgst_tax  = $this->input->post('cgst_tax');
                $cgst_tax_value   = $this->input->post('cgst');

                if($this->input->post('course_mode_online')==1){
                    $course_mode_online=1;
                }else{
                    $course_mode_online=0;
                }

                if($this->input->post('course_mode_offline')==1){
                    $course_mode_offline=1;
                }else{
                    $course_mode_offline=0;
                }

                //$total_fess_cost = $fess + $certificate_cost + $one_time_admission_fees + $kit_cost;

                $data = array(
                    'course_name' => $this->input->post('course_name'),
                    'course_fees'=> $this->input->post('fees'),
                    'course_type_id' => $this->input->post('course_type'),
                    'trainer_id' => $this->input->post('trainer'),
                    //'course_desc'=> $this->input->post('description'),
                    'course_cert_cost' => $this->input->post('certificate_cost'),
                    'course_kit_cost'=> $this->input->post('kit_cost'),
                    'course_onetime_adm_fees'=>$this->input->post('one_time_admission_fees'),
                    'course_books'=>$this->input->post('course_books'),
                    //'course_remark' => $this->input->post('remarks'),
                    'course_mode_online'=>$course_mode_online,
                    'course_mode_offline'=>$course_mode_offline,

                    'mainCourse_condition'=>$this->input->post('mainCourse'),
                    'sponsored_condition'=>$this->input->post('sponsored'),
                    'regular_condition'=>$this->input->post('regular'),

                    'course_cgst' => $cgst_tax,
                    'course_cgst_tax_value' => $cgst_tax_value,
                    'course_sgst' => $sgst_tax,
                    'course_sgst_tax_value' => $sgst_tax_value,
                    'course_total_fees' => $total_course_fees
                );

                $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
                $this->form_validation->set_rules('fees', 'Fees', 'trim|required|numeric');
                $this->form_validation->set_rules('course_type', 'Certificate Type', 'trim|required');
                //$this->form_validation->set_rules('description', 'Description', 'trim');
                $this->form_validation->set_rules('certificate_cost', 'Certificate cost', 'trim|numeric');
                $this->form_validation->set_rules('one_time_admission_fees', 'One Time Admission Fees', 'trim|numeric');
                $this->form_validation->set_rules('kit_cost', 'Kit Cost', 'trim|numeric');
                $this->form_validation->set_rules('course_books', 'Course Books', 'trim');
                //$this->form_validation->set_rules('remarks', 'remarks', 'trim');
                $this->form_validation->set_rules('total_course_fees', 'Total Course Fees', 'trim|required');
                $this->form_validation->set_rules('course_mode', 'Course_mode', 'trim');

                if($this->input->post('course_mode_online')!=1 && $this->input->post('course_mode_offline')!=1){
                    $required_checkbox = 'Course Mode Required';
                }else{
                    $required_checkbox = '';
                }

                if($this->input->post('mainCourse') || $this->input->post('sponsored') || $this->input->post('regular')){
                    $course_type_required = '';
                }else{
                   
                    $course_type_required = 'Course Type Required';
                }


                if($this->form_validation->run() == FALSE){
                    $createcourse_response['status'] = 'failure';
                    $createcourse_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'fees'=>strip_tags(form_error('fees')), 'course_type'=>strip_tags(form_error('course_type')), /*'description'=>strip_tags(form_error('description')),*/'certificate_cost'=>strip_tags(form_error('certificate_cost')),'kit_cost'=>strip_tags(form_error('kit_cost')),'one_time_admission_fees'=>strip_tags(form_error('one_time_admission_fees')),'course_books'=>strip_tags(form_error('course_books')),'course_mode'=>$required_checkbox,'course_type_condition'=>$course_type_required);
                }else{

                    /*check If course name is unique*/
                    $check_uniqe =  $this->course_model->checkquniqecoursename(trim($this->input->post('course_name')));

                    if($check_uniqe){
                        $createcourse_response['status'] = 'failure';
                        $createcourse_response['error'] = array('course_name'=>'Course Name Already Exist', 'fees'=>'', 'course_type'=>'', 'description'=>'','certificate_cost'=>'','kit_cost'=>'','one_time_admission_fees'=>'','course_books'=>'','course_type_condition'=>'');
                    }else{
                        $saveCoursedata = $this->course_model->saveCoursedata('',$data);
                        if($saveCoursedata){
                            $createcourse_response['status'] = 'success';
                            $createcourse_response['error'] = array('course_name'=>'', 'fees'=>'', 'course_type'=>'', 'description'=>'','certificate_cost'=>'','kit_cost'=>'','one_time_admission_fees'=>'','course_books'=>'','course_type_condition'=>'');
                        }
                    }
                }
        
                echo json_encode($createcourse_response);
            }
        }

        function updatecourse($courseId){

            $post_submit = $this->input->post();
            if(!empty($post_submit)){

                $createcourse_response = array();

                if($this->input->post('fees')){
                    $fess  = $this->input->post('fees');
                }else{
                    $fess  = 0;
                }


                if($this->input->post('certificate_cost')){
                    $certificate_cost  = $this->input->post('certificate_cost');
                }else{
                    $certificate_cost  = 0;
                }

                if($this->input->post('one_time_admission_fees')){
                    $one_time_admission_fees  = $this->input->post('one_time_admission_fees');
                }else{
                    $one_time_admission_fees  = 0;
                }


                if($this->input->post('kit_cost')){
                    $kit_cost  = $this->input->post('kit_cost');
                }else{
                    $kit_cost  = 0;
                }

               // $total_fess_cost = $fess + $certificate_cost + $one_time_admission_fees + $kit_cost;

                $total_course_fees  = $this->input->post('total_course_fees');

                $sgst_tax  = $this->input->post('sgst_tax');
                $sgst_tax_value  = $this->input->post('sgst');
                
                $cgst_tax  = $this->input->post('cgst_tax');
                $cgst_tax_value   = $this->input->post('cgst');

            
                if($this->input->post('course_mode_online1')==1){
                    $course_mode_online=1;
                }else{
                    $course_mode_online=0;
                }

                if($this->input->post('course_mode_offline1')==1){
                    $course_mode_offline=1;
                }else{
                    $course_mode_offline=0;
                }

                

            
                $data = array(
                    'course_name' => $this->input->post('course_name'),
                    'course_fees'=> $this->input->post('fees'),
                    'course_type_id' => $this->input->post('course_type'),
                    'trainer_id' => $this->input->post('trainer'),
                    //'course_desc'=> $this->input->post('description'),
                    'course_cert_cost' => $this->input->post('certificate_cost'),
                    'course_kit_cost'=> $this->input->post('kit_cost'),
                    'course_onetime_adm_fees'=>$this->input->post('one_time_admission_fees'),
                    'course_books'=>$this->input->post('course_books1'),
                    //'course_remark' => $this->input->post('remarks'),

                    'mainCourse_condition'=>$this->input->post('mainCourseedit'),
                    'sponsored_condition'=>$this->input->post('sponsorededit'),
                    'regular_condition'=>$this->input->post('regularedit'),

                    'course_mode_online'=>$course_mode_online,
                    'course_mode_offline'=>$course_mode_offline,
                    'course_cgst' => $cgst_tax,
                    'course_cgst_tax_value' => $cgst_tax_value,
                    'course_sgst' => $sgst_tax,
                    'course_sgst_tax_value' => $sgst_tax_value,
                    'course_total_fees' => $total_course_fees
                );

                $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
                $this->form_validation->set_rules('fees', 'Fees', 'trim|required|numeric');
                $this->form_validation->set_rules('course_type', 'Certificate Type', 'trim|required');
                //$this->form_validation->set_rules('description', 'Description', 'trim');
                $this->form_validation->set_rules('certificate_cost', 'Certificate cost', 'trim|numeric');
                $this->form_validation->set_rules('one_time_admission_fees', 'One Time Admission Fees', 'trim|numeric');
                $this->form_validation->set_rules('kit_cost', 'Kit Cost', 'trim|numeric');
                $this->form_validation->set_rules('course_books', 'Course Books', 'trim');
                //$this->form_validation->set_rules('remarks', 'remarks', 'trim');

                if($this->input->post('mainCourseedit') || $this->input->post('sponsorededit') || $this->input->post('regularedit')){
                    $course_type_required = '';
                }else{
                   
                    $course_type_required = 'Course Type Required';
                }
              

                if($this->form_validation->run() == FALSE){
                    $createcourse_response['status'] = 'failure';
                    $createcourse_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'fees'=>strip_tags(form_error('fees')), 'course_type'=>strip_tags(form_error('course_type')), /*'description'=>strip_tags(form_error('description')),*/'certificate_cost'=>strip_tags(form_error('certificate_cost')),'kit_cost'=>strip_tags(form_error('kit_cost')),'one_time_admission_fees'=>strip_tags(form_error('one_time_admission_fees')),'course_books'=>strip_tags(form_error('course_books')),'course_mode'=>$required_checkbox);
                }else{

                    if($this->input->post('course_mode_online1') || $this->input->post('course_mode_offline1')){
                        $required_checkbox = '';
                  


                    /*check If course name is unique*/
                    if($courseId == null)
                    {
                        $check_uniqe =  $this->course_model->checkquniqecoursename(trim($this->input->post('course_name')));
                    }
                    else
                    {
                        $check_uniqe =  $this->course_model->checkquniqecoursename_update($courseId, trim($this->input->post('course_name')));
                    }
                    
                    if($check_uniqe){
                        $createcourse_response['status'] = 'failure';
                        $createcourse_response['error'] = array('course_name'=>'Course Name Already Exist', 'fees'=>'', 'course_type'=>'', 'description'=>'','certificate_cost'=>'','kit_cost'=>'','one_time_admission_fees'=>'','course_books'=>'');
                    }else{
                        $saveCoursedata = $this->course_model->saveCoursedata($courseId,$data);
                        if($saveCoursedata){
                            $createcourse_response['status'] = 'success';
                            $createcourse_response['error'] = array('course_name'=>'', 'fees'=>'', 'course_type'=>'', 'description'=>'','certificate_cost'=>'','kit_cost'=>'','one_time_admission_fees'=>'','course_books'=>'');
                        }
                    }

                }else{
                    $required_checkbox = 'Course Mode Required';
                    $createcourse_response['status'] = 'failure';
                    $createcourse_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'fees'=>strip_tags(form_error('fees')), 'course_type'=>strip_tags(form_error('course_type')), /*'description'=>strip_tags(form_error('description')),*/'certificate_cost'=>strip_tags(form_error('certificate_cost')),'kit_cost'=>strip_tags(form_error('kit_cost')),'one_time_admission_fees'=>strip_tags(form_error('one_time_admission_fees')),'course_books'=>strip_tags(form_error('course_books')),'course_mode'=>$required_checkbox);
             
                }

                }
        
                echo json_encode($createcourse_response);
            }
        }

        public function delete_course(){
            $post_submit = $this->input->post();
            if(!empty($post_submit)){
                $deletecourse_response =array();
                // $checkRelation = $this->course_model->checkRelationcourse($this->input->post('id'));
                // if($checkRelation){
                //        $deletecourse_response['status'] = 'linked';
                // }else{
                    $courseInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                    $result = $this->course_model->data_update('tbl_course',$courseInfo,'courseId',$this->input->post('id'));
                    if($result){
                        $deletecourse_response['status'] = 'success';
                        $process = 'Course Delete';
                        $processFunction = 'Course/deleteCourse';
                        $this->logrecord($process,$processFunction);
                    }else
                    {
                        $deletecourse_response['status'] = 'filure';
                    }
              // }
                echo json_encode($deletecourse_response);
            }
        }

        public function courseTypeListing()
        {
            $process = 'Certificate Type Listing';
            $processFunction = 'Course/courseTypeListing';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Certificate Type';
            $this->loadViews("course/courseType", $this->global, NULL , NULL);
        }

        public function fetchcoursetype(){
            $params = $_REQUEST;
            $totalRecords = $this->course_model->getCoursetypeCount($params); 
            $queryRecords = $this->course_model->getCoursetypedata($params); 

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

        public function createcoursetype(){
            $post_submit = $this->input->post();

            if(!empty($post_submit)){
                $createcoursetype_response = array();

                $data = array(
                    'ct_name' => $this->input->post('course_type_name'),
                );
                $this->form_validation->set_rules('course_type_name', 'Certificate Type', 'trim|required');

                if($this->form_validation->run() == FALSE){

                    $createcoursetype_response['status'] = 'failure';
                    $createcoursetype_response['error'] = array('course_type_name'=>strip_tags(form_error('course_type_name')));

                }else{
                       /*check If course name is unique*/
                       $check_uniqe =  $this->course_model->checkquniqecoursetype(trim($this->input->post('course_type_name')));

                       if($check_uniqe){
                           $createcoursetype_response['status'] = 'failure';
                           $createcoursetype_response['error'] = array('course_type_name'=>'Certificate Type Already Exist');
                       }else{
                           $saveCoursetypedata = $this->course_model->saveCoursetypedata('',$data);
                           if($saveCoursetypedata){
                               $createcoursetype_response['status'] = 'success';
                               $createcoursetype_response['error'] = array('course_type_name'=>'');
                           }
                       }
                }
             echo json_encode($createcoursetype_response);
            }
        }

        public function deletecoursetype(){

            $post_submit = $this->input->post();
            if(!empty($post_submit)){
                $deletecourse_response =array();
                // $checkRelation = $this->course_model->checkRelation($this->input->post('id'));

                // if($checkRelation){
                //        $deletecourse_response['status'] = 'linked';
                // }else{
                        $courseInfo = array('isDeleted'=>1);
                        $result = $this->course_model->data_update('tbl_course_type',$courseInfo,'ct_id',$this->input->post('id'));
                        if($result){
                            $deletecourse_response['status'] = 'success';
                            $process = 'Course Delete';
                            $processFunction = 'Course/deleteCourseType';
                            $this->logrecord($process,$processFunction);
                        }else
                        {
                            $deletecourse_response['status'] = 'filure';
                        }
               // }
                echo json_encode($deletecourse_response);
            }

        }

        public function get_signle_coursetypeData($cTypeId = NULL)
        {
            $cTypeId = $this->input->post('coursetypeId');
            $data['courseTypeInfo'] = $this->course_model->getCourseTypeInfo($cTypeId);
            echo json_encode($data);
        }

        public function updatcoursetype($coursetypeid){

            $post_submit = $this->input->post();

            if(!empty($post_submit)){

                $update_response = array();

                $data = array(
                    'ct_name' => $this->input->post('course_type_name_1')
                );

                $this->form_validation->set_rules('course_type_name_1', 'Certificate Type', 'trim|required');

                if($this->form_validation->run() == FALSE){
                    $update_response['status'] = 'failure';
                    $update_response['error'] = array('course_type_name_1'=>strip_tags(form_error('course_type_name_1')));
                }else{

                    /*check If course name is unique*/
                    if($coursetypeid == null)
                    {
                        $check_uniqe =  $this->course_model->checkquniqecoursetypename(trim($this->input->post('course_type_name_1')));
                    }
                    else
                    {
                        $check_uniqe =  $this->course_model->checkquniqecoursetypename_update($coursetypeid, trim($this->input->post('course_type_name_1')));
                    }
                    
                    if($check_uniqe){
                        $update_response['status'] = 'failure';
                        $update_response['error'] = array('course_type_name_1'=>'Certificate Type Already Exist');
                    }else{
                        $saveCoursetypedata = $this->course_model->saveCoursetypedata($coursetypeid,$data);
                        if($saveCoursetypedata){
                            $update_response['status'] = 'success';
                            $update_response['error'] = array('course_type_name_1'=>'');
                        }
                    }
                }
        
                echo json_encode($update_response);
            }

        }

        public function addchapters($id){
            $process = 'Add Course Topics';
            $processFunction = 'Enquiry/enquiryEdit';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Course Topics';
            $data['getCourseinfo'] = $this->course_model->getCourseInfo($id);
            $this->loadViews("course/CourseattachmentListing", $this->global, $data , NULL);
        }

        public function fetchCourseAttchemant($courseid){
            $params = $_REQUEST;
            $totalRecords = $this->course_model->getCourseattchmentCount($params,$courseid); 
            $queryRecords = $this->course_model->getCourseattchmentdata($params,$courseid); 

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

        public function savecoursetopicAttahcment(){
            $post_submit = $this->input->post();
            if($post_submit){
                $topic_attachemnt_response = array();
                $data = array(
                    'course_id' => $this->input->post('course_id_post'),
                    'topic_name' => $this->input->post('topic_name'),
                    'remark' => $this->input->post('remark'),
                );

                $this->form_validation->set_rules('topic_name', 'Certificate Type', 'trim|required');
                $this->form_validation->set_rules('remark', 'Remark', 'trim');

                if($this->form_validation->run() == FALSE){
                    $topic_attachemnt_response['status'] = 'failure';
                    $topic_attachemnt_response['error'] = array('topic_name'=>strip_tags(form_error('topic_name')),'remark'=>strip_tags(form_error('remark')));
                }else{

                      /*check If course name is unique*/
                        $check_uniqe =  $this->course_model->checkquniqecoursetopicname(trim($this->input->post('topic_name')), $this->input->post('course_id_post'));
                        if( $check_uniqe ){
                            $topic_attachemnt_response['status'] = 'failure';
                            $topic_attachemnt_response['error'] = array('topic_name'=>'Topic Already Exits','remark'=>'');
                        }else{

                            $saveCoursetypedata = $this->course_model->saveCourseTopicsdata('',$data);
                            if($saveCoursetypedata){
                                $topic_attachemnt_response['status'] = 'success';
                                $topic_attachemnt_response['error'] = array('topic_name'=>'','remark'=>'');
                            }else{

                                $topic_attachemnt_response['status'] = 'failure';
                                $topic_attachemnt_response['error'] = array('topic_name'=>'','remark'=>'');
                            }

                        } 
                }
                echo json_encode($topic_attachemnt_response);
            }
            
        }

        public function get_signle_course_topic(){
            $topic_id = $this->input->post('topic_id');
            $course_id = $this->input->post('course_id');
            $get_signle_course_topic = $this->course_model->get_signle_course_topic($topic_id,$course_id);
            echo json_encode($get_signle_course_topic);
        }

        public function updatecourseTopics(){

            $post_submit = $this->input->post();
            if($post_submit){

                $update_response = array();

                $topic_id =  $this->input->post('topic_id');
                $course_id_1_post =  $this->input->post('course_id_1_post');

                $data = array(
                    'course_id' => $this->input->post('course_id_1_post'),
                    'topic_name' => $this->input->post('topic_name_1'),
                    'remark' => $this->input->post('remark_1'),
                );

                $this->form_validation->set_rules('topic_name_1', 'Certificate Type', 'trim|required');
                $this->form_validation->set_rules('remark_1', 'Remark', 'trim');

                if($this->form_validation->run() == FALSE){
                    $update_response['status'] = 'failure';
                    $update_response['error'] = array('topic_name_1'=>strip_tags(form_error('topic_name_1')),'remark_1'=>strip_tags(form_error('remark_1')));
                }else{

                        $check_uniqe =  $this->course_model->checkquniqecoursetopicnameupdate($topic_id,$course_id_1_post,trim($this->input->post('topic_name_1')));
                        if($check_uniqe){

                            $updateCoursetypedata_1 = $this->course_model->updateCourseTopicsdata($topic_id,$course_id_1_post,$data);
                            if($updateCoursetypedata_1){
                                $update_response['status'] = 'success';
                                $update_response['error'] = array('topic_name_1'=>'','remark_1'=>'');
                            }else{

                                $update_response['status'] = 'failure';
                                $update_response['error'] = array('topic_name_1'=>'','remark_1'=>'');
                            }
                        }else{
                            $check_uniqe_topic_name_1 =  $this->course_model->checkquniqecoursetopicname_nameupdate(trim($this->input->post('topic_name_1')));

                            if($check_uniqe_topic_name_1){

                                $update_response['status'] = 'failure';
                                $update_response['error'] = array('topic_name_1'=>'Topic Already Exits','remark'=>'');

                            }else{

                                $updateCoursetypedata_2 = $this->course_model->updateCourseTopicsdata($topic_id,$course_id_1_post,$data);
                                if($updateCoursetypedata_2){
                                    $update_response['status'] = 'success';
                                    $update_response['error'] = array('topic_name_1'=>'','remark_1'=>'');
                                }else{
    
                                    $update_response['status'] = 'failure';
                                    $update_response['error'] = array('topic_name_1'=>'','remark_1'=>'');
                                }

                            }
                        }
                }
                echo json_encode($update_response);
            }
        }

        public function deleteCourseTopics(){
            $post_data = $this->input->post('id');

            if(!empty($post_data)){
                $deletecourse_response =array();
                $checkRelation = $this->course_model->checktopicsRelation($this->input->post('id'));

                // if($checkRelation){
                //        $deletecourse_response['status'] = 'linked';
                // }else{
                        $courseInfo = array('isDeleted'=>1);
                        $result = $this->course_model->data_update('tbl_course_topics',$courseInfo,'id',$this->input->post('id'));
                        if($result){
                            $deletecourse_response['status'] = 'success';
                            $process = 'Topics Delete';
                            $processFunction = 'Course/deleteCourseType';
                            $this->global['pageTitle'] = 'Topics Delete';
                            $this->logrecord($process,$processFunction);
                        }else
                        {
                            $deletecourse_response['status'] = 'filure';
                        }
               // }
                echo json_encode($deletecourse_response);
            }
          
        }

        public function topicattachmentListing(){

            $topic_id = $this->input->get('topic_id');
            $course_id = $this->input->get('course_id');
            $data['course_topic_info'] =  $this->course_model->get_signle_course_topicattchment($topic_id,$course_id);

            $data['documents'] =  $this->course_model->getDocumentcount($topic_id,$course_id);
            $data['videos'] =  $this->course_model->getVideoscount($topic_id,$course_id);
            $data['books'] =  $this->course_model->getBookscount($topic_id,$course_id);

            $process = 'Topic Attachment Listing';
            $processFunction = 'Course/topicattachmentListing';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Topic Attachment Listing';
            $this->loadViews("course/topicattachmentListing", $this->global,$data , NULL);
        }

        public function viewalltopicdocuments(){
            $topic_id = $this->input->get('topic_id');
            $course_id = $this->input->get('course_id');
            $data['course_topic_info'] =  $this->course_model->get_signle_course_topicattchment($topic_id,$course_id);
            $data['type'] =  $this->input->get('type');
            $data['topic_id'] =  $topic_id;
            $data['course_id'] =  $course_id;
            $process = 'Topic Attachment Upload Listing';
            $processFunction = 'Course/topicattachmentListing';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Topic Attachment Upload Listing';
            $this->loadViews("course/attachmantListingUploading", $this->global,$data , NULL);
        }

        public function fetchTopicDocument(){

            $topic_id = $this->input->get('topic_id');
            $course_id = $this->input->get('course_id');
            $type =  $this->input->get('type');

            $params = $_REQUEST;
            $totalRecords = $this->course_model->getFetchtopicdocumentCount($params,$topic_id,$course_id,$type); 
            $queryRecords = $this->course_model->getFetchtopicdocumentData($params,$topic_id,$course_id,$type); 

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

        public function uploadSubmit()
        {	


           $course_id =  $_POST['course_id'];
           $topic_id =   $_POST['topic_id'];
           $doc_type =   $_POST['doc_type'];

           if($doc_type!='documents'){

           $upload = 'err'; 

                //   $filesize = round($_FILES['file']['size'] / 1024 , 2); // kilobytes with two digits

                //   if($filesize  > 3000000){
                //     echo $upload= 'big_file';
                //   }else{

                 // if(!empty($_FILES['file']['size'])){ 
                //   if($_FILES['file']['size'] > 0){ 
                    // File upload configuration 
                //     $targetDir = "uploads/topic_documents/".$doc_type.'/'; 
                //     if($doc_type=='documents'){
                //         $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif','xls','xlsx','txt'); 
                //     }

                //     if($doc_type=='videos'){
                //         $allowTypes = array('mp4', 'webm', 'ogv'); 
                //     }

                //     if($doc_type=='books'){
                //         $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif','xls','xlsx','txt'); 
                //     }
                   
                    
                //     $fileName_original = basename($_FILES['file']['name']); 

                //     $fileName_original_for_download = $_FILES['file']['name']; 

                //     //$fileName =uniqid(rand(), true).'-'.$doc_type.'-'.basename($_FILES['file']['name']); 

                //     $fileName =$doc_type.'-'.$_FILES['file']['name']; 
                //    // $fileName =basename($_FILES['file']['name']); 
                //     $targetFilePath = $targetDir.$fileName; 
                    
                //     // Check whether file type is valid 
                //     $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                //     if(in_array($fileType, $allowTypes)){ 
                //         // Upload file to the server 
                //         if(move_uploaded_file($_FILES['file']['tmp_name'], str_replace(' ', '_', $targetFilePath))){ 

                                $data = array(
                                    'course_id'=> $course_id,
                                    'topic_id' => $topic_id,
                                    'doc_type' => $_POST['video_text'],
                                    'module_name' => $doc_type,
                                    // 'file_name' => str_replace(' ', '_',$fileName_original_for_download),
                                    // 'file_name_original' => str_replace(' ', '_',$fileName_original),
                                    // 'file_url' =>  base_url().str_replace(' ', '_', $targetFilePath),
                                    'file_name' =>  $_POST['video_text'],
                                    'file_name_original' =>  $_POST['video_text'],
                                    'file_url' =>  $_POST['video_url'],

                                    'createdBy' => $this->session->userdata('userId')
                                );

                                $insertDocumentData = $this->course_model->insertDocumentData($data); 
                                if($insertDocumentData){

                                    $upload = 'ok'; 
                                }else{

                                    $upload = 'err'; 
                                }
                                 echo $upload; 


                            // $upload = 'ok'; 
                    //     } 
                    // }else{

                        //echo 'type_missmatch';
                    // } 

                   
                // }else{
                //     echo 'empty';
                // } 
           }else{

            $upload = 'err'; 

            $filesize = round($_FILES['file']['size'] / 1024 , 2); // kilobytes with two digits
    
            //   if($filesize  > 3000000){
            //     echo $upload= 'big_file';
            //   }else{
    
            if(!empty($_FILES['file']['size'])){ 
              if($_FILES['file']['size'] > 0){ 
                // File upload configuration 
                $targetDir = "uploads/topic_documents/".$doc_type.'/'; 
                if($doc_type=='documents'){
                    $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif','xls','xlsx','txt'); 
                }
    
                if($doc_type=='videos'){
                    $allowTypes = array('mp4', 'webm', 'ogv'); 
                }
    
                if($doc_type=='books'){
                    $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif','xls','xlsx','txt'); 
                }
               
                
                $fileName_original = basename($_FILES['file']['name']); 
    
                $fileName_original_for_download = $_FILES['file']['name']; 
    
                //$fileName =uniqid(rand(), true).'-'.$doc_type.'-'.basename($_FILES['file']['name']); 
    
                $fileName =$doc_type.'-'.$_FILES['file']['name']; 
               // $fileName =basename($_FILES['file']['name']); 
                $targetFilePath = $targetDir.$fileName; 
                
                // Check whether file type is valid 
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                if(in_array($fileType, $allowTypes)){ 
            //         // Upload file to the server 
                 if(move_uploaded_file($_FILES['file']['tmp_name'], str_replace(' ', '_', $targetFilePath))){ 
    
                            $data = array(
                                'course_id'=> $course_id,
                                'topic_id' => $topic_id,
                                'doc_type' => $_POST['document_name'],
                                'module_name' => $doc_type,
                                'file_name' => str_replace(' ', '_',$fileName_original_for_download),
                                'file_name_original' => str_replace(' ', '_',$fileName_original),
                                'file_url' =>  base_url().str_replace(' ', '_', $targetFilePath),
                                //'file_name' =>  $_POST['video_text'],
                                'file_name_original' =>  $_POST['document_name'],
                                //'file_url' =>  $_POST['video_url'],
                                'createdBy' => $this->session->userdata('userId')
                            );
    
                            $insertDocumentData = $this->course_model->insertDocumentData($data); 
                            if($insertDocumentData){
    
                                $upload = 'ok'; 
                            }else{
    
                                $upload = 'err'; 
                            }
                             echo $upload; 
    
                        // $upload = 'ok'; 
                    }
                 } 
                }else{
    
                    echo 'type_missmatch';
                } 
    
               
            }else{
                echo 'empty';
            } 
           }
            
        }

        public function deleteTopicDocuments(){
            $post_submit = $this->input->post();
            if(!empty($post_submit)){
                $deletecourse_response =array();
              
                    $courseInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                    $result = $this->course_model->data_update('tbl_topic_document',$courseInfo,'id',$this->input->post('id'));
                    if($result){
                        $deletecourse_response['status'] = 'success';
                        $process = 'Document Listing Delete';
                        $processFunction = 'Course/deleteTopicDocuments';
                        $this->logrecord($process,$processFunction);
                    }else
                    {
                        $deletecourse_response['status'] = 'filure';
                    }
               
                echo json_encode($deletecourse_response);
            }
        }

        public function timetableListing($id){
            $process = 'Time Table Listing';
            $processFunction = 'Course/addtimetableListing';
            $data['course_id'] = $id;
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Time Table Listing';
            $data['getCourseinfo'] = $this->course_model->getCourseInfo($id);
            $this->loadViews("course/timetableListing", $this->global, $data , NULL);
        }

        public function fetchTimetable($courseid){

            $params = $_REQUEST;
            $totalRecords = $this->course_model->gettimetableCount($params,$courseid); 
            $queryRecords = $this->course_model->gettimetabledata($params,$courseid); 

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

        public function savenewtimetable(){

        
            ini_set('upload_max_filesize', '100M');
            ini_set('post_max_size', '100M');
            ini_set('max_input_time', 300);
            ini_set('max_execution_time', 300);

            $post_submit = $this->input->post();

            if($post_submit){

                /* Get Triner Details */ 

                $getTrainerDetails = $this->course_model->getCourseInfo(trim($this->input->post('course_id_post')));

                $savetimetable_response = array();
                 if($_FILES['timetable']['error'] == 0)
                    {

                        $fileExt = strtolower(pathinfo($_FILES['timetable']['name'], PATHINFO_EXTENSION));

                        if($fileExt != "xls" && $fileExt != "xlsx")
                        {
                            $savetimetable_response['status'] = "failure";
                            $savetimetable_response['error'] = array('importing'=>'Please upload file with extension xls or xlsx only');
                        }else{

                            $getMonth = date('F', strtotime($this->input->post('form_date')));
                            $getYear = date('Y',  strtotime($this->input->post('form_date')));
            
                            $data = array(
                                'course_id' => $this->input->post('course_id_post'),
                                'trainer_id' => trim($getTrainerDetails[0]->trainer_id),
                                'from_date' => date('Y-m-d', strtotime($this->input->post('form_date'))),
                                'to_date' => date('Y-m-d', strtotime($this->input->post('to_date'))),
                                'month_name' => $getMonth.'-'.$getYear
                            );

            
                            $this->form_validation->set_rules('form_date', 'From Date', 'trim|required');
                            $this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
                           
                                    if($this->form_validation->run() == FALSE){
                                        $savetimetable_response['status'] = 'failure';
                                        $savetimetable_response['error'] = array('form_date'=>strip_tags(form_error('form_date')),'to_date'=>strip_tags(form_error('to_date')));
                                    }else{

                                            /*check If course name is unique*/
                                            $check_uniqe =  $this->course_model->checkquniqeTimetable(trim($this->input->post('form_date')),trim($this->input->post('to_date')),$this->input->post('course_id_post'));
                                            if( $check_uniqe ){
                                                $savetimetable_response['status'] = 'failure';
                                                $savetimetable_response['error'] = array('form_date'=>'From Date Already Exits','to_date'=>'To Date Alreday Exits');
                                            }else{

                                                $saveCoursetimetabledata = $this->course_model->saveTimetable('',$data);
                                                if($saveCoursetimetabledata){


                                                    $filename = str_replace(" ", "_", $_FILES['timetable']['name']).'_'.time().".".$fileExt;
                                                    $fileSavePath = './uploads/ExcelImport/'.$filename;
                                            
                                                    if(move_uploaded_file($_FILES["timetable"]["tmp_name"], $fileSavePath)) 
                                                    {

                                                        $this->load->library('excel');
                                                        $inputFileType = PHPExcel_IOFactory::identify($fileSavePath);
                                                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                                                        $objPHPExcel = $objReader->load($fileSavePath);
                                                        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                                                        $higheshColumn = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
                                                        $higheshRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                                                        if($higheshRow == 1 && $higheshColumn == "A") 
                                                        { 
                                                            unlink($fileSavePath);
                                                            $savetimetable_response['status'] = "failure";
                                                            $savetimetable_response['error'] = array('importing'=>'File is empty');
                                                        }else{

                                                          
                                                            $columnsArr = array('A'=>'Date','B'=>'Timings','C'=>'Topic','D'=>'Trainer');

                                                            $excel_errors='';   
                                                        
                                                            for($i = 2; $i <= count($allDataInSheet); $i++)
                                                            {
                                                                $mandateFields = array('A', 'B', 'C', 'D');

                                                                $getBlankFields =  $this->isFieldEmpty($allDataInSheet[$i],$columnsArr, $mandateFields);

                                                                if(!empty($getBlankFields))
                                                                {
                                                                    // $excel_errors .= "Row ".$i."=> Blank Fields: ".$getBlankFields."\n";
                                                                    $excel_errors .= "Blank Fields: ".$getBlankFields." in Excel Row".$i;
                                                                }
                                                                else
                                                                {
                                                                        //code to perform individual field validation
                                                                    $validationErrors = $this->getValidationErrors($allDataInSheet[$i],$columnsArr);
                                                                    if(!empty($validationErrors))
                                                                        {
                                                                            $excel_errors .= "Row ".$i."=> Validation Errors: ".$validationErrors."\n"."<br>";
                                                                        }                                    
                                                                }

                                                                $excel_errors.="\n\n";

                                                            }

                                                            $excel_errors = rtrim($excel_errors,"\n\n");

                                                            if(!empty($excel_errors))
                                                             {
                                                                unlink($fileSavePath);
                                                                $savetimetable_response['status'] = "failure";
                                                                $savetimetable_response['error'] = array('importing'=>$excel_errors);
                                                                // $createteachers_response['errorfilepath'] = $txtFilePath;
                                                                //$this->session->set_flashdata('error', $excel_errors);
                                                                //redirect('orderListing/'.$vendor_id);

                                                             }else{

                                                                $countofdataupload = count($allDataInSheet);

                                                                $toup = $countofdataupload-1;

                                                                if( $toup > 0) {
        
                                                                    $insertArr = array();
                                                                    //$timetabledata = array();
                                                                    for($i = 2; $i <= count($allDataInSheet); $i++)
                                                                     {
                                                                            $getTrianerid = $this->course_model->getTrianeridby(trim($allDataInSheet[$i]['D']));
                                                                            if(empty($getTrianerid)){

                                                                                $savetimetable_response['status'] = "failure";
                                                                                $savetimetable_response['error'] = array('importing'=>'Kindly Check trainer, topic, date, timing in excel => '.$i);
    
                                                                            }else{
                                                                             
                                                                                $explod_by_from_and_to = explode("to",$allDataInSheet[$i]['B']);

                                                                                if (preg_match('/\bto\b/', $allDataInSheet[$i]['B'])) {

                                                                                // if (strpos($allDataInSheet[$i]['B'], 'to') !== false) {

                                                                            
                                                                                    $start_time = new DateTime($explod_by_from_and_to[0]);
                                                                                    $end_time = new DateTime($explod_by_from_and_to[1]);

                                                                                    // Calculate the difference
                                                                                    $interval = $start_time->diff($end_time);

                                                                                    // Get the hours difference
                                                                                    $hours_difference = $interval->h + ($interval->days * 24);


                                                                                    //$insertArr['vendor_id'] = $vendor_id;
                                                                                    $insertArr['course_id'] =  $this->input->post('course_id_post');
                                                                                    $insertArr['time_table_id'] = $saveCoursetimetabledata;
                                                                                    $insertArr['trainer_id'] = trim($getTrainerDetails[0]->trainer_id);
                                                                                    $insertArr['from_date'] =  date('Y-m-d', strtotime($this->input->post('form_date')));
                                                                                    
                                                                                    $insertArr['to_date'] = date('Y-m-d', strtotime($this->input->post('to_date')));
                                                                                    $date_export_date = $allDataInSheet[$i]['A'];

                                                                                    $formatted_date = DateTime::createFromFormat("d-m-y",$date_export_date)->format("m-d-Y");
                                                                                  
                                                                                    //$formatted_date = str_replace("/", "-", $date_export_date );
                                                                                    $insertArr['date'] = date('Y-m-d', strtotime($formatted_date));


                                                                    
                                                                                    $insertArr['timings'] =$allDataInSheet[$i]['B'];
                                                                                    $insertArr['topic'] = $allDataInSheet[$i]['C'];
                                                                                    $insertArr['trainer_id'] = trim($getTrianerid[0]->userId);
                                                                                    $insertArr['total_hrs'] =  $hours_difference;
                                                                                    $timetabledata[] = $insertArr;

                                                                                    
                                                                                    $passdataToOrderAPi = $this->course_model->insertBlukTimetabledata($insertArr);
                                                                                }else{
                                                                                    $savetimetable_response['status'] = 'failure';
                                                                                    $savetimetable_response['error'] = array('importing'=>'Check Timings Details');
                                                                                }
                                                                        }
                                                                     }

                                                                     if($passdataToOrderAPi){
                                                                        unlink($fileSavePath);
                                                                        $savetimetable_response['status'] = 'success';
                                                                        $savetimetable_response['error'] = array('form_date'=>'','to_date'=>'');
                                                                     }else{

                                                                        $result = $this->course_model->delete_timetable($this->input->post('course_id_post'),$saveCoursetimetabledata);
                                                                        if($result){
                                                                            $deletecourse_response['status'] = 'success';
                                                                            $process = 'Time Table Delete';
                                                                            $processFunction = 'Course/savenewtimetable';
                                                                            $this->global['pageTitle'] = 'Time Table Delete';
                                                                            $this->logrecord($process,$processFunction);
                                                                        }

                                                                     }
                                                                }else{
                                                                    $result = $this->course_model->delete_timetable($this->input->post('course_id_post'),$saveCoursetimetabledata);

                                                                    $savetimetable_response['status'] = 'failure';
                                                                    $savetimetable_response['error'] = array('importing'=>'Blank File');
                                                                }
                                                        
                                                             }

                                                       }
                                                        
                                                    }
                                                    
                                                }else{

                                                    $savetimetable_response['status'] = 'failure';
                                                    $savetimetable_response['error'] = array('form_date'=>'','to_date'=>'');
                                            }

                                        } 
                                    }

                           }

                        
                    }

                echo json_encode($savetimetable_response);
            }
        }

        public function getValidationErrors($arr,$columnsArr)
        {
            $valErrors = ""; 
            // if(!empty($arr['A']) && !preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $arr['A'])) //Email
            // {
            //     $valErrors.= $columnsArr['A']." should contain valid information\n";
            // }
    
            // if(!preg_match('/^[a-zA-Z\s]+$/',$arr['B'])) //Full Name
            // {
            //     $valErrors.= $columnsArr['B']." should contain only alphabets\n";
            // }
    
            // if(strlen($arr['B']) < 2 || strlen($arr['B']) >100) //Full Name
            // {
            //     $valErrors.= $columnsArr['B']." should be min 2 characters & max 100 characters in length\n";
            // }
    
            // if(strlen($arr['C']) != 10) //Mobile length
            // {
            //     $valErrors.= $columnsArr['C']." number should be 10 digit in length\n";
            // }
    
            // if(!is_numeric($arr['C'])) //Mobile numeric check
            // {
            //     $valErrors.= $columnsArr['C']." number should be numeric\n";
            // }
    
            // if((!empty($arr['D']) && strtolower($arr['D']) != 'new') && (!empty($arr['D']) && strtolower($arr['D']) != 'update') && (!empty($arr['D']) && strtolower($arr['D']) != 'delete')) // Action
            // {
            //     $valErrors.= $columnsArr['D']." should contain information as 'new', 'update', or 'delete'.";
            // }
    
            //$valErrors = rtrim($valErrors,"\n");          
            return $valErrors;
        }

        public function isFieldEmpty($arr,$columnsArr,$mandateFields = array())
        {
                $emptyFields = "";
                foreach ($arr as $key => $value) 
                {
                    $value = trim($value);
                    if(!empty($mandateFields)){
                        if(in_array($key, $mandateFields)){
                            if (empty($value))
                            {
                                $emptyFields.= $columnsArr[$key].",";
                            }    
                        }
                    }else{
                        if (empty($value))
                        {
                            $emptyFields.= $columnsArr[$key].",";
                        }
                    }
                }
                $emptyFields = rtrim($emptyFields,",");
                return $emptyFields;
        }

        public function deletetopictimetable(){

            $time_table_id = $this->input->post('time-table-id');
            $course_id = $this->input->post('course_id');
            $result = $this->course_model->delete_timetable($course_id,$time_table_id);

            if($result){
                /*Delete All Courses Topic*/
                $delete_timetable_topic = $this->course_model->delete_timetable_topic($course_id,$time_table_id);

                if($delete_timetable_topic){
                    $deletecourse_response['status'] = 'success';
                    $process = 'Delet Timetable Delete';
                    $processFunction = 'Course/deletetopictimetable';
                    $this->logrecord($process,$processFunction);
                }
            }else
            {
                $deletecourse_response['status'] = 'filure';
            }
       
             echo json_encode($deletecourse_response);
        }

        public function timetablemaster(){

            $this->global['pageTitle'] = 'Course Management';
            $data['course_type'] = $this->course_model->getAllCourseTypeInfo();
            $this->loadViews("course/courseList",$this->global,$data,NULL);

        }

        public function viewtimetablelisting(){

            $time_table_id = $this->input->get('time_table_id');
            $course_id = $this->input->get('course_id');
            $data['time_table_id'] = $time_table_id;
            $data['course_id'] = $course_id;
            $data['getCourseinfo'] = $this->course_model->getCourseInfo($data['course_id']);
            $data['getTimetableInfo'] = $this->course_model->getTimetableInfo($data['course_id'],$data['time_table_id']);
            $this->global['pageTitle'] = 'Detail View Timetable Listing';
            $this->loadViews("course/detailsviewtimetablelisting",$this->global,$data,NULL);
        }



        public function edittimetablerecord(){
            $post_submit =  $this->input->post();
            
            if($post_submit){

                $edittimetable_response = array();

                $course_id_form = $this->input->post('course_id_form');
                $time_table_id = $this->input->post('time_table_id');
                $time_table_transection_id = $this->input->post('time_table_transection_id');
                $backup_trainer = $this->input->post('backup_trainer');



                $this->form_validation->set_rules('date', 'Date', 'trim|required');
                $this->form_validation->set_rules('timing', 'Timing', 'trim|required');
                $this->form_validation->set_rules('topic', 'Topic', 'trim|required');
                $this->form_validation->set_rules('trainer', 'Trainer', 'trim|required');
                $this->form_validation->set_rules('backup_trainer', 'Backup Trainer', 'trim');

                if($this->form_validation->run() == FALSE){

                    $edittimetable_response['status'] = 'failure';
                    $edittimetable_response['error'] = array('backup_trainer'=>strip_tags(form_error('backup_trainer')));
                }else{

 
                    $explod_by_from_and_to = explode("to",trim($this->input->post('timing')));

                    if (preg_match('/\bto\b/', trim($this->input->post('timing')))) {

                    // if (strpos($allDataInSheet[$i]['B'], 'to') !== false) {
                
                        $start_time = new DateTime($explod_by_from_and_to[0]);
                        $end_time = new DateTime($explod_by_from_and_to[1]);

                        // Calculate the difference
                        $interval = $start_time->diff($end_time);

                        // Get the hours difference
                        $hours_difference = $interval->h.':'. $interval->i;
                    }
                    
                    $data = array(
                        'timings'=> trim($this->input->post('timing')),
                        'topic'=> trim($this->input->post('topic')),
                        'total_hrs' =>  $hours_difference,
                        'trainer_id'=> trim($this->input->post('trainer')),
                        'backup_trainer'=> trim($this->input->post('backup_trainer')),
                    );

                    $updatetimetablerecord = $this->course_model->savetimetablerecorddata($time_table_transection_id,$data);
                    if($updatetimetablerecord){
                        $edittimetable_response['status'] = 'success';
                        $edittimetable_response['error'] = array('backup_trainer'=>'');
                    }
                }

                echo json_encode($edittimetable_response);

            }else{
                $time_table_transection_id = $this->input->get('id');
                $time_table_id = $this->input->get('time_table_id');
                $course_id = $this->input->get('course_id'); 
                $data['time_table_transection_id'] = $time_table_transection_id;
                $data['time_table_id'] = $time_table_id;
                $data['course_id'] = $course_id;
                $data['getCourseinfo'] = $this->course_model->getCourseInfo($data['course_id']);
                $data['getTimetableInfo'] = $this->course_model->getTimetableInfo($data['course_id'],$data['time_table_id']);
                $data['getTopicinfo'] = $this->course_model->getTopicinfo($data['course_id'],$data['time_table_id'],$data['time_table_transection_id']);
                $data['gettrainerinfo'] = $this->course_model->getbackuptrainerfortopics($data['getTopicinfo'][0]->trainer_id);
                $data['getAlltrainerinfo'] = $this->course_model->getAllTrainerInfo();
                $this->global['pageTitle'] = 'Edit Timetable Record';
                $this->loadViews("course/edittimetablerecord",$this->global,$data,NULL);
            }


        }



        public function fetchTopicTimetableListing(){

            $time_table_id = $this->input->get('time_table_id');
            $course_id = $this->input->get('course_id');

            $params = $_REQUEST;
            $totalRecords = $this->course_model->gettimetabletopiclistingCount($params,$time_table_id,$course_id); 
            $queryRecords = $this->course_model->gettimetabletopiclistingdata($params,$time_table_id,$course_id); 

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

      
        public function addtopiclinksforonlineattendant(){

            $time_table_transection_id = $this->input->get('id');
            $time_table_id = $this->input->get('time_table_id');
            $course_id = $this->input->get('course_id'); 
            $data['time_table_transection_id'] = $time_table_transection_id;
            $data['time_table_id'] = $time_table_id;
            $data['course_id'] = $course_id;
            $data['getCourseinfo'] = $this->course_model->getCourseInfo($data['course_id']);
            $data['getTimetableInfo'] = $this->course_model->getTimetableInfo($data['course_id'],$data['time_table_id']);
            $data['getTopicinfo'] = $this->course_model->getTopicinfo($data['course_id'],$data['time_table_id'],$data['time_table_transection_id']);
            $this->global['pageTitle'] = 'Add Timetable Topic Link';
            $this->loadViews("course/addtimetabletopiclink",$this->global,$data,NULL);

        }

        public function fetchtopicmeetinglink(){

            $time_table_id = $this->input->get('time_table_id');
            $course_id = $this->input->get('course_id');
            $time_table_transection_id = $this->input->get('id');

            $params = $_REQUEST;
            $totalRecords = $this->course_model->gettopicmeetinglinkCount($params,$time_table_id,$course_id,$time_table_transection_id); 
            $queryRecords = $this->course_model->gettopicmeetinglinkData($params,$time_table_id,$course_id,$time_table_transection_id); 

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


        public function savecoursetopicMeetingLinks(){

           $post_submit =  $this->input->post();
           if(!empty($post_submit)){

                    $savecoursetopicMeeting_response = array();

                    $data = array(
                        'topic_name' => $this->input->post('topic_name'),
                        //'title' => $this->input->post('title'),
                        'link_url' => $this->input->post('new_meeting_link'),
                        'timings' => $this->input->post('timings'),
                        'course_id' => $this->input->post('course_id_form_post'),
                        'time_table_id' => $this->input->post('time_table_id_post'),
                        'time_table_transection_id' => $this->input->post('time_table_transection_id_post'),
                    );

                    $this->form_validation->set_rules('timings', 'Timings', 'trim|required');
                    //$this->form_validation->set_rules('title', 'Title', 'trim|required');
                    $this->form_validation->set_rules('new_meeting_link', 'Link URL', 'trim|required');

                    if($this->form_validation->run() == FALSE){

                        $savecoursetopicMeeting_response['status'] = 'failure';
                        $savecoursetopicMeeting_response['error'] = array('timings'=>strip_tags(form_error('timings')),'new_meeting_link'=>strip_tags(form_error('new_meeting_link')));

                    }else{
                        /*check If course name is unique*/
                        // $check_uniqe =  $this->course_model->checkquniqecoursetype(trim($this->input->post('course_type_name')));

                        // if($check_uniqe){
                        //     $savecoursetopic_response['status'] = 'failure';
                        //     $savecoursetopic_response['error'] = array('course_type_name'=>'Certificate Type Already Exist');
                        // }else{
                            $saveCoursetypedata = $this->course_model->saveTimetablemeetinglinkdata('',$data);
                            if($saveCoursetypedata){
                                $savecoursetopicMeeting_response['status'] = 'success';
                                $savecoursetopicMeeting_response['error'] = array('timings'=>'','new_meeting_link'=>'');
                            }
                       // }
                    }
                    
             }
             echo json_encode($savecoursetopicMeeting_response);
        }
 

        public function delete_topic_meeting_link(){

            $time_table_link_id = $this->input->post('id');

            $post_submit = $this->input->post('id');
            if(!empty($post_submit)){
                $deletecourse_response =array();
              
                    $courseInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                    $result = $this->course_model->data_update('tbl_topic_meeting_link',$courseInfo,'id',$this->input->post('id'));
                    if($result){
                        $deletecourse_response['status'] = 'success';
                        $process = 'Document Topic Link Delete';
                        $processFunction = 'nkCourse/delete_topic_meeting_link';
                        $this->logrecord($process,$processFunction);
                    }else
                    {
                        $deletecourse_response['status'] = 'filure';
                    }
                echo json_encode($deletecourse_response);
            }
        }


        public function addbackuptrainer(){

            $post_submit =  $this->input->post();
            
            if($post_submit){

                $addbackuptrainer_response = array();

                $course_id_form = $this->input->post('course_id_form');
                $time_table_id = $this->input->post('time_table_id');
                $time_table_transection_id = $this->input->post('time_table_transection_id');
                $backup_trainer = $this->input->post('backup_trainer');

                $this->form_validation->set_rules('backup_trainer', 'Backup Trainer', 'trim|required');

                if($this->form_validation->run() == FALSE){

                    $addbackuptrainer_response['status'] = 'failure';
                    $addbackuptrainer_response['error'] = array('backup_trainer'=>strip_tags(form_error('backup_trainer')));
                }else{

                    $updateBackuptrianerdata = $this->course_model->updateBackuptrianerdata($course_id_form,$time_table_id,$time_table_transection_id,$backup_trainer);
                    if($updateBackuptrianerdata){
                        $addbackuptrainer_response['status'] = 'success';
                        $addbackuptrainer_response['error'] = array('backup_trainer'=>'');
                    }
                }

                echo json_encode($addbackuptrainer_response);

            }else{
                $time_table_transection_id = $this->input->get('id');
                $time_table_id = $this->input->get('time_table_id');
                $course_id = $this->input->get('course_id'); 
                $data['time_table_transection_id'] = $time_table_transection_id;
                $data['time_table_id'] = $time_table_id;
                $data['course_id'] = $course_id;
                $data['getCourseinfo'] = $this->course_model->getCourseInfo($data['course_id']);
                $data['getTimetableInfo'] = $this->course_model->getTimetableInfo($data['course_id'],$data['time_table_id']);
                $data['getTopicinfo'] = $this->course_model->getTopicinfo($data['course_id'],$data['time_table_id'],$data['time_table_transection_id']);
                $data['gettrainerinfo'] = $this->course_model->getbackuptrainerfortopics($data['getTopicinfo'][0]->trainer_id);
                $this->global['pageTitle'] = 'Update Trainer To Topic';
                $this->loadViews("course/addbackuptrainer",$this->global,$data,NULL);
            }
        }


        public function cancletimetableclass(){

            $post_submit = $this->input->post();
            if($post_submit){

                $cancle_class_response =array();
                $result = $this->course_model->cancletimetableclass(trim($post_submit['data-id']),trim($post_submit['time_table_id']),trim($post_submit['course_id']));
               //$result=1;
                if($result){

                    $getstudentdata = $this->course_model->getstudentdataforcanclenotification(trim($post_submit['data-id']),trim($post_submit['time_table_id']),trim($post_submit['course_id']));

                    $getcouese_details_for_whatsapp_sms = $this->course_model->getcouese_details_for_whatsapp_sms(trim($post_submit['data-id']),trim($post_submit['time_table_id']),trim($post_submit['course_id']));

                    foreach ($getstudentdata as $key => $value) {

                        //  //  /* Send Whats App  Start Here */
                        //  $curl = curl_init();
                        $text = ' Class Cancel Notification. Following class is cancelled.  Course Name : '.$getcouese_details_for_whatsapp_sms['course_name'].', Course Date : '.$getcouese_details_for_whatsapp_sms['timetabledate'].' , Topic : '.$getcouese_details_for_whatsapp_sms['topic'];
                        //$text = 'Dear '.$enq_fullname.' Thank You for your interest in '.$all_course_name.', We have attached the brochure and Syllabus for your reference. Feel free to contact us back, we will be delighted to assist and guide you.For more details, you can also visit our website www.iictn.org';      
                        $mobile = '91'.$value['mobile'];
                      
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
                        
                    }

                            $cancle_class_response['status'] = 'success';
                            $process = 'Cancle Class';
                            $processFunction = 'Course/cancletimetableclass';
                            $this->logrecord($process,$processFunction);
                }else
                {
                    $cancle_class_response['status'] = 'filure';
                }
                 echo json_encode($cancle_class_response);
            }

        }


        public function activstetimetableclass(){

            $post_submit = $this->input->post();

            if($post_submit){

                $cancle_class_response =array();

                $result = $this->course_model->activstetimetableclass(trim($post_submit['data-id']),trim($post_submit['time_table_id']),trim($post_submit['course_id']));
                if($result){
                    $cancle_class_response['status'] = 'success';
                    $process = 'Cancle Class';
                    $processFunction = 'Course/activstetimetableclass';
                    $this->logrecord($process,$processFunction);
                }else
                {
                    $cancle_class_response['status'] = 'filure';
                }
                 echo json_encode($cancle_class_response);
            }

        }


        public function addsyllabus($course_id){
            $process = 'Add Course Syllabus';
            $processFunction = 'course/addsyllabus';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Course Syllabus';
            $data['page_title'] ='Add Course Syllabus';
            $data['course_id'] = $course_id;
            $data['getCourseinfo'] = $this->course_model->getCourseInfo($course_id);
            $this->loadViews("course/add_syllabus", $this->global, $data , NULL);
        }


        public function fetchallcoursesyllabus($course_id){
            $params = $_REQUEST;
            $totalRecords = $this->course_model->getCoursesyllabusCount($params,$course_id); 
            $queryRecords = $this->course_model->getCoursesyllabusData($params,$course_id); 

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


        public function uploadCoursesayllabus() {	
            $upload = 'err'; 
            $filesize = round($_FILES['file']['size'] / 1024 , 2); // kilobytes with two digits
            if(!empty($_FILES['file']['size'])){ 
              if($_FILES['file']['size'] > 0){ 
                // File upload configuration 
                $targetDir = "uploads/course_syllabus/"; 
                $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif','xls','xlsx','txt'); 
                $fileName_original = basename($_FILES['file']['name']); 
                $fileName_original_for_download = $_FILES['file']['name']; 
                //$fileName =uniqid(rand(), true).'-'.$doc_type.'-'.basename($_FILES['file']['name']); 
                $fileName =$_FILES['file']['name']; 
               // $fileName =basename($_FILES['file']['name']); 
                $targetFilePath = $targetDir.$fileName; 
                // Check whether file type is valid 
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

                $checkifdocnamealredayexits =  $this->course_model->checkifdocnamealredayexits(trim($_POST['course_id']),trim($_POST['document_name'])); 
                if($checkifdocnamealredayexits > 0){
                    echo 'exits';
                }else{
                if(in_array($fileType, $allowTypes)){ 
                 if(move_uploaded_file($_FILES['file']['tmp_name'], str_replace(' ', '_', $targetFilePath))){ 
                            $data = array(
                                'course_id'=>  $_POST['course_id'],
                                'doc_name' =>  $_POST['document_name'],
                                'doc_url' =>  base_url().str_replace(' ', '_', $targetFilePath),
                                'doc_type' => $fileType,
                                'file_name_original' => str_replace(' ', '_',$fileName_original),
                                'file_name' => str_replace(' ', '_',$fileName_original_for_download),
                                'createdBy' => $this->session->userdata('userId')
                            );
    
                            $uploadCoursesayllabus = $this->course_model->uploadCoursesayllabus($data); 
                            if($uploadCoursesayllabus){
                                $upload = 'ok'; 
                            }else{
                                $upload = 'err'; 
                            }
                             echo $upload;
                    }
                 } 
                }
                }else{
                    echo 'type_missmatch';
                } 

            }else{
                echo 'empty';
            }                             
        }


    public function deletecourseSyllbus(){
        $post_submit = $this->input->post('syllbus_id');
        if(!empty($post_submit)){
            $deletecourse_response =array();
          
                $courseInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                $result = $this->course_model->data_update('tbl_course_syllabus',$courseInfo,'id',$this->input->post('syllbus_id'));
                if($result){
                    $deletecourse_response['status'] = 'success';
                    $process = 'Syallbus Topic Link Delete';
                    $processFunction = 'Course/deletecourseSyllbus';
                    $this->logrecord($process,$processFunction);
                }else
                {
                    $deletecourse_response['status'] = 'filure';
                }
            echo json_encode($deletecourse_response);
        }


    }        


    }

?>