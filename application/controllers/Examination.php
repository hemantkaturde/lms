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

        public function viewquestionpaper($id){
            $this->global['pageTitle'] = 'View Question Paper';
            $data['examination_info'] = $this->examination_model->getExaminationinfo($id);
            $this->loadViews("examination/view_questionpaper",$this->global,$data,NULL);
        }



        

    }

?>
