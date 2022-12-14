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

    }

?>