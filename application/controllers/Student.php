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
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            // $this->load->library('pagination');
            
            // $count = $this->role_model->roleListingCount($searchText);

			// $returns = $this->paginationCompress ( "roleListing/", $count, 10 );
            
            $data['student'] = $this->student_model->studentListing($searchText);
            // $data['userRecords'] = $this->role_model->roleListing($searchText, $returns["page"], $returns["segment"]);
            $process = 'Student Listing';
            $processFunction = 'Student/studentListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Student';
            $this->loadViews("student/studentList", $this->global, $data , NULL);
        }

        function get_signle_student($studentId = NULL)
        {
            $data['studentInfo'] = $this->student_model->getStudentInfo($studentId);
            echo json_encode($data);
        }

        function student_assets()
        {
            $data['courses'] = $this->student_model->getCourses();
            echo json_encode($data);
        }

        public function student_insert($id)
        {
            $this->load->library('form_validation');
        
                $fname = $this->security->xss_clean($this->input->post('fname'));
                $lname = $this->security->xss_clean($this->input->post('lname'));
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $dob = $this->security->xss_clean($this->input->post('dob'));
                $address = $this->security->xss_clean($this->input->post('address'));
                $courses1 = $this->security->xss_clean($this->input->post('course'));
                $courses = implode(',', $courses1);
                // print_r($courses);
                // exit;

                if($id == 0)
                {
                    $studentInfo = array('student_fname'=>$fname, 'student_lname'=>$lname, 'student_mobile'=>$mobile, 'student_dob'=> date('Y-m-d', strtotime($dob)),'student_address'=>$address, 'student_course'=>$courses,
                                'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                        
                    // $result = $this->user_model->addNewUser($userInfo);
                    $result = $this->database->data_insert('tbl_student', $studentInfo);
                    if($result > 0)
                    {
                    $process = 'Student Insert';
                    $processFunction = 'Student/student_insert';
                    $this->logrecord($process,$processFunction);
                       echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }else
                {
                    $studentInfo = array('student_fname'=>$fname, 'student_lname'=>$lname, 'student_mobile'=>$mobile, 'student_dob'=> date('Y-m-d', strtotime($dob)),'student_address'=>$address, 'student_course'=>$courses,
                                'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));

                    $result = $this->database->data_update('tbl_student',$studentInfo,'studentId',$id);
                    
                    if($result == true)
                    {
                        $process = 'Student Update';
                        $processFunction = 'Student/student_insert';
                        $this->logrecord($process,$processFunction);
                        echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }            
        }

        // // ==== Delete Course
        public function deleteStudent($id)
        {
            $studentInfo = array('isDeleted'=>1,'updatedBy'=> $this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->database->data_update('tbl_student',$studentInfo,'studentId',$id);

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Student Delete';
                 $processFunction = 'Student/deleteStudent';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }

        // ===============================       

    }

?>