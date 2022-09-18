<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';
    // require_once APPPATH."/third_party/PHPExcel.php";
    // require_once APPPATH."/third_party/PHPExcel/IOFactory.php";

    class Examination extends BaseController
    {
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model(array('login_model', 'examination_model', 'database','course_model'));
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

        public function examinationlisting()
        {
            $this->global['pageTitle'] = 'Examination Management';
            $data['course_name'] = $this->course_model->getAllCourseInfo();
            $this->loadViews("examination/examinationList",$this->global,$data,NULL);
        }

        public function fetchExaminationListing(){
            $params = $_REQUEST;
            $totalRecords = $this->examination_model->getexaminationCount($params); 
            $queryRecords = $this->examination_model->getexaminationdata($params); 

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

        public function createExamination(){
            $post_submit = $this->input->post();
            if(!empty($post_submit)){

                $examination_response = array();

                $data = array(
                    'course_id' => $this->input->post('course_name'),
                    'exam_title' => $this->input->post('examination_title'),
                    'exam_time' => $this->input->post('examination_time'),
                    'exam_status' => $this->input->post('examination_status'),
                );

                $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
                $this->form_validation->set_rules('examination_title', 'Examination Title', 'trim|required');
                $this->form_validation->set_rules('examination_time', 'Examination Time', 'trim|required');
                $this->form_validation->set_rules('examination_status', 'Examination Status', 'trim|required');

                if($this->form_validation->run() == FALSE){

                    $examination_response['status'] = 'failure';
                    $examination_response['error'] = array('course_name'=>strip_tags(form_error('course_name')),'examination_title'=>strip_tags(form_error('examination_title')),'examination_time'=>strip_tags(form_error('examination_time')),'examination_status'=>strip_tags(form_error('examination_status')));

                }else{

                    $check_uniqe =  $this->examination_model->checkquniqeExamination(trim($this->input->post('course_name')),trim($this->input->post('examination_title')));
                    if($check_uniqe){
                        $examination_response['status'] = 'failure';
                        $examination_response['error'] = array('course_name'=>'Course Name Already Exist','examination_title'=>'Examination Title Alreday Exist');
                    }else{

                        $saveCoursetypedata = $this->examination_model->saveExaminationedata('',$data);
                        if($saveCoursetypedata){
                            $examination_response['status'] = 'success';
                            $examination_response['error'] = array('course_type_name'=>'');
                        }

                    }

                }
                echo json_encode($examination_response);

            }

        }

        function get_signle_examinationData($exam_id = NULL)
        {
            $exam_id = $this->input->post('exam_id');
            $data = $this->examination_model->getSingleExaminationInfo($exam_id);
            echo json_encode($data);
        }

    
        public function updateExamination($id){
            $post_submit = $this->input->post();

            if(!empty($post_submit)){
                $updateexamination_response = array();

                $course_name  = $this->input->post('course_name');
                $examination_title  = $this->input->post('examination_title');
                $examination_time  = $this->input->post('examination_time');
                $examination_status  = $this->input->post('examination_status');

                $data = array(
                    'course_id' => $this->input->post('course_name'),
                    'exam_title'=> $this->input->post('examination_title'),
                    'exam_time' => $this->input->post('examination_time'),
                    'exam_status'=> $this->input->post('examination_status'),
                );

                $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
                $this->form_validation->set_rules('examination_title', 'Examination Title', 'trim|required');
                $this->form_validation->set_rules('examination_time', 'Examination Time', 'trim|required');
                $this->form_validation->set_rules('examination_status', 'Examination Status', 'trim');
             
                if($this->form_validation->run() == FALSE){
                    $updateexamination_response['status'] = 'failure';
                    $updateexamination_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'examination_title'=>strip_tags(form_error('examination_title')), 'examination_time'=>strip_tags(form_error('examination_time')),'examination_status'=>strip_tags(form_error('examination_status')));

                }else{

                     $check_uniqe =  $this->examination_model->checkquniqeExaminationwithidupdate($id, trim($this->input->post('course_name')),trim($this->input->post('examination_title')));

                    if($check_uniqe){
                       $saveExaminationedata = $this->examination_model->saveExaminationedata($id,$data);
                       if($saveExaminationedata){
                           $updateexamination_response['status'] = 'success';
                           $updateexamination_response['error'] = array('course_name'=>'', 'examination_title'=>'', 'examination_time'=>'', 'examination_status'=>'');
                       }
                 
                    }else{

                        $check_uniqe_exam =  $this->examination_model->checkquniqeExaminationupdate(trim($this->input->post('course_name')),trim($this->input->post('examination_title')));
                      
                        if($check_uniqe_exam){

                            $updateexamination_response['status'] = 'failure';
                            $updateexamination_response['error'] = array('course_name'=>'Course Name Already Exist', 'examination_title'=>'Examination Title Alreday Exists', 'examination_time'=>'', 'examination_status'=>'');
                        }else{

                            $saveExaminationedata = $this->examination_model->saveExaminationedata($id,$data);
                            if($saveExaminationedata){
                                $updateexamination_response['status'] = 'success';
                                $updateexamination_response['error'] = array('course_name'=>'', 'examination_title'=>'', 'examination_time'=>'', 'examination_status'=>'');
                            }

                        }


                    }

                }

            }
            echo json_encode($updateexamination_response);

        }
 
        public function viewquestionpaper($id){
            $this->global['pageTitle'] = 'View Question Paper';
            $data['examination_info'] = $this->examination_model->getSingleExaminationInfo($id);
            $this->loadViews("examination/view_questionpaper",$this->global,$data,NULL);
        }



        public function uploadquestionpaper(){

            ini_set('upload_max_filesize', '100M');
            ini_set('post_max_size', '100M');
            ini_set('max_input_time', 300);
            ini_set('max_execution_time', 300);

            $post_submit = $this->input->post();

            if($post_submit){

                $uploadquestionpaper_response = array();
                if($_FILES['questionpaper']['error'] == 0)
                   {

                    $fileExt = strtolower(pathinfo($_FILES['questionpaper']['name'], PATHINFO_EXTENSION));

                        if($fileExt != "xls" && $fileExt != "xlsx")
                        {
                            $uploadquestionpaper_response['status'] = "failure";
                            $uploadquestionpaper_response['error'] = array('importing'=>'Please upload file with extension xls or xlsx only');
                        }else{


                            $data = array(
                                'examination_id' => $this->input->post('examination_id'),
                                'course_id' => $this->input->post('course_id'),
                            );

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



                                    $columnsArr = array('A'=>'Question List','B'=>'Option 1','C'=>'Option 2','D'=>'Option 3','E'=>'Option 4','F'=>'Answer','G'=>'Marks','H'=>'Question Type (MCQ,WRITTEN,MATCH_PAIR)');

                                    $excel_errors='';   
                                
                                    for($i = 2; $i <= count($allDataInSheet); $i++)
                                    {
                                        $mandateFields = array('A', 'B', 'C');

                                        $getBlankFields =  $this->isFieldEmpty($allDataInSheet[$i],$columnsArr, $mandateFields);

                                        if(!empty($getBlankFields))
                                        {
                                            $excel_errors .= "Row ".$i."=> Blank Fields: ".$getBlankFields."\n";
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
                                                    //$insertArr['vendor_id'] = $vendor_id;
                                                    $insertArr['course_id'] =  $this->input->post('course_id_post');
                                                    $insertArr['time_table_id'] = $saveCoursetimetabledata;
                                                    $insertArr['from_date'] =  date('Y-m-d', strtotime($this->input->post('form_date')));
                                                    $insertArr['to_date'] = date('Y-m-d', strtotime($this->input->post('to_date')));
                                                    $insertArr['date'] = date('Y-m-d', strtotime($allDataInSheet[$i]['A']));
                                                    $insertArr['timings'] =$allDataInSheet[$i]['B'];
                                                    $insertArr['topic'] = $allDataInSheet[$i]['C'];
                                                    $timetabledata[] = $insertArr;
                                                    $passdataToOrderAPi = $this->course_model->insertBlukTimetabledata($insertArr);
                                             }

                                             if($passdataToOrderAPi){
                                                unlink($fileSavePath);
                                                $savetimetable_response['status'] = 'success';
                                                $savetimetable_response['error'] = array('form_date'=>'','to_date'=>'');
                                             }
                                        }else{
                                            //$result = $this->course_model->delete_timetable($this->input->post('course_id_post'),$saveCoursetimetabledata);

                                            $uploadquestionpaper_response['status'] = 'failure';
                                            $uploadquestionpaper_response['error'] = array('importing'=>'Blank File');
                                        }
                                     }


                                }

                            }

                        }
                        
                        $uploadquestionpaper_response['status'] = 'failure';
                        $uploadquestionpaper_response['error'] = array('form_date'=>'','to_date'=>'');

                   }

            }
        }


    }

?>
