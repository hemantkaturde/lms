<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';

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

                //$total_fess_cost = $fess + $certificate_cost + $one_time_admission_fees + $kit_cost;

                $data = array(
                    'course_name' => $this->input->post('course_name'),
                    'course_fees'=> $this->input->post('fees'),
                    'course_type_id' => $this->input->post('course_type'),
                    'course_desc'=> $this->input->post('description'),
                    'course_cert_cost' => $this->input->post('certificate_cost'),
                    'course_kit_cost'=> $this->input->post('kit_cost'),
                    'course_onetime_adm_fees'=>$this->input->post('one_time_admission_fees'),
                    'course_books'=>$this->input->post('course_books'),
                    'course_remark' => $this->input->post('remarks'),
                    'course_mode'=>$this->input->post('course_mode'),
                    'course_cgst' => $cgst_tax,
                    'course_cgst_tax_value' => $cgst_tax_value,
                    'course_sgst' => $sgst_tax,
                    'course_sgst_tax_value' => $sgst_tax_value,
                    'course_total_fees' => $total_course_fees
                );

                $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
                $this->form_validation->set_rules('fees', 'Fees', 'trim|required|numeric');
                $this->form_validation->set_rules('course_type', 'Course Type', 'trim|required');
                $this->form_validation->set_rules('description', 'Description', 'trim');
                $this->form_validation->set_rules('certificate_cost', 'Certificate cost', 'trim|numeric');
                $this->form_validation->set_rules('one_time_admission_fees', 'One Time Admission Fees', 'trim|numeric');
                $this->form_validation->set_rules('kit_cost', 'Kit Cost', 'trim|numeric');
                $this->form_validation->set_rules('course_books', 'Course Books', 'trim');
                $this->form_validation->set_rules('remarks', 'remarks', 'trim');
                $this->form_validation->set_rules('total_course_fees', 'Total Course Fees', 'trim|required');
                $this->form_validation->set_rules('course_mode', 'Course_mode', 'trim');

                if($this->form_validation->run() == FALSE){
                    $createcourse_response['status'] = 'failure';
                    $createcourse_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'fees'=>strip_tags(form_error('fees')), 'course_type'=>strip_tags(form_error('course_type')), 'description'=>strip_tags(form_error('description')),'certificate_cost'=>strip_tags(form_error('certificate_cost')),'kit_cost'=>strip_tags(form_error('kit_cost')),'one_time_admission_fees'=>strip_tags(form_error('one_time_admission_fees')),'course_books'=>strip_tags(form_error('course_books')));
                }else{

                    /*check If course name is unique*/
                    $check_uniqe =  $this->course_model->checkquniqecoursename(trim($this->input->post('course_name')));

                    if($check_uniqe){
                        $createcourse_response['status'] = 'failure';
                        $createcourse_response['error'] = array('course_name'=>'Course Name Already Exist', 'fees'=>'', 'course_type'=>'', 'description'=>'','certificate_cost'=>'','kit_cost'=>'','one_time_admission_fees'=>'','course_books'=>'');
                    }else{
                        $saveCoursedata = $this->course_model->saveCoursedata('',$data);
                        if($saveCoursedata){
                            $createcourse_response['status'] = 'success';
                            $createcourse_response['error'] = array('course_name'=>'', 'fees'=>'', 'course_type'=>'', 'description'=>'','certificate_cost'=>'','kit_cost'=>'','one_time_admission_fees'=>'','course_books'=>'');
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


                $data = array(
                    'course_name' => $this->input->post('course_name'),
                    'course_fees'=> $this->input->post('fees'),
                    'course_type_id' => $this->input->post('course_type'),
                    'course_desc'=> $this->input->post('description'),
                    'course_cert_cost' => $this->input->post('certificate_cost'),
                    'course_kit_cost'=> $this->input->post('kit_cost'),
                    'course_onetime_adm_fees'=>$this->input->post('one_time_admission_fees'),
                    'course_books'=>$this->input->post('course_books'),
                    'course_remark' => $this->input->post('remarks'),
                    'course_mode'=>$this->input->post('course_mode'),
                    'course_cgst' => $cgst_tax,
                    'course_cgst_tax_value' => $cgst_tax_value,
                    'course_sgst' => $sgst_tax,
                    'course_sgst_tax_value' => $sgst_tax_value,
                    'course_total_fees' => $total_course_fees
                );

                $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
                $this->form_validation->set_rules('fees', 'Fees', 'trim|required|numeric');
                $this->form_validation->set_rules('course_type', 'Course Type', 'trim|required');
                $this->form_validation->set_rules('description', 'Description', 'trim');
                $this->form_validation->set_rules('certificate_cost', 'Certificate cost', 'trim|numeric');
                $this->form_validation->set_rules('one_time_admission_fees', 'One Time Admission Fees', 'trim|numeric');
                $this->form_validation->set_rules('kit_cost', 'Kit Cost', 'trim|numeric');
                $this->form_validation->set_rules('course_books', 'Course Books', 'trim');
                $this->form_validation->set_rules('remarks', 'remarks', 'trim');

                if($this->form_validation->run() == FALSE){
                    $createcourse_response['status'] = 'failure';
                    $createcourse_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'fees'=>strip_tags(form_error('fees')), 'course_type'=>strip_tags(form_error('course_type')), 'description'=>strip_tags(form_error('description')),'certificate_cost'=>strip_tags(form_error('certificate_cost')),'kit_cost'=>strip_tags(form_error('kit_cost')),'one_time_admission_fees'=>strip_tags(form_error('one_time_admission_fees')),'course_books'=>strip_tags(form_error('course_books')));
                }else{

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
                }
        
                echo json_encode($createcourse_response);
            }
        }

        public function delete_course(){
            $post_submit = $this->input->post();
            if(!empty($post_submit)){
                $deletecourse_response =array();
                $checkRelation = $this->course_model->checkRelationcourse($this->input->post('id'));
                if($checkRelation){
                       $deletecourse_response['status'] = 'linked';
                }else{
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
               }
                echo json_encode($deletecourse_response);
            }
        }

        public function courseTypeListing()
        {
            $process = 'Course Type Listing';
            $processFunction = 'Course/courseTypeListing';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Course Type';
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
                $this->form_validation->set_rules('course_type_name', 'Course Type', 'trim|required');

                if($this->form_validation->run() == FALSE){

                    $createcoursetype_response['status'] = 'failure';
                    $createcoursetype_response['error'] = array('course_type_name'=>strip_tags(form_error('course_type_name')));

                }else{
                       /*check If course name is unique*/
                       $check_uniqe =  $this->course_model->checkquniqecoursetype(trim($this->input->post('course_type_name')));

                       if($check_uniqe){
                           $createcoursetype_response['status'] = 'failure';
                           $createcoursetype_response['error'] = array('course_type_name'=>'Course Type Already Exist');
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
                $checkRelation = $this->course_model->checkRelation($this->input->post('id'));

                if($checkRelation){
                       $deletecourse_response['status'] = 'linked';
                }else{
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
                }
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

                $this->form_validation->set_rules('course_type_name_1', 'Course Type', 'trim|required');

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
                        $update_response['error'] = array('course_type_name_1'=>'Course Type Already Exist');
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

                $this->form_validation->set_rules('topic_name', 'Course Type', 'trim|required');
                $this->form_validation->set_rules('remark', 'Remark', 'trim');

                if($this->form_validation->run() == FALSE){
                    $topic_attachemnt_response['status'] = 'failure';
                    $topic_attachemnt_response['error'] = array('topic_name'=>strip_tags(form_error('topic_name')),'remark'=>strip_tags(form_error('remark')));
                }else{

                      /*check If course name is unique*/
                        $check_uniqe =  $this->course_model->checkquniqecoursetopicname(trim($this->input->post('topic_name')));
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

                $this->form_validation->set_rules('topic_name_1', 'Course Type', 'trim|required');
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
                            $check_uniqe_topic_name_1 =  $this->course_model->checkquniqecoursetopicname(trim($this->input->post('topic_name_1')));

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

                if($checkRelation){
                       $deletecourse_response['status'] = 'linked';
                }else{
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
                }
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
           $course_id = $this->input->post('course_id');
           $topic_id =  $this->input->post('topic_id');
           $doc_type =  $this->input->post('doc_type');
           $upload = 'err'; 

                //   $filesize = round($_FILES['file']['size'] / 1024 , 2); // kilobytes with two digits

                //   if($filesize  > 3000000){
                //     echo $upload= 'big_file';
                //   }else{

                 // if(!empty($_FILES['file']['size'])){ 
                  if($_FILES['file']['size'] > 0){ 
                    // File upload configuration 
                    $targetDir = "uploads/topic_documents/".$doc_type.'/'; 
                    if($doc_type=='documents'){
                        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif'); 
                    }

                    if($doc_type=='videos'){
                        $allowTypes = array('mp4', 'webm', 'ogv'); 
                    }

                    if($doc_type=='books'){
                        $allowTypes = array('pdf', 'doc', 'docx'); 
                    }
                   
                    
                    $fileName_original = basename($_FILES['file']['name']); 
                    $fileName =uniqid(rand(), true).'-'.$doc_type.'-'.basename($_FILES['file']['name']); 
                    $targetFilePath = $targetDir.$fileName; 
                    
                    // Check whether file type is valid 
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                    if(in_array($fileType, $allowTypes)){ 
                        // Upload file to the server 
                        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){ 

                                $data = array(
                                    'course_id'=> $course_id,
                                    'topic_id' => $topic_id,
                                    'doc_type' => $fileType,
                                    'module_name' => $doc_type,
                                    'file_name' => $fileName,
                                    'file_name_original' => $fileName_original,
                                    'file_url' =>  base_url().$targetFilePath,
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
                    }else{

                        echo 'type_missmatch';
                    } 

                   
                }else{
                    echo 'empty';
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


    }

?>