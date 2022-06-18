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
            $this->load->model('login_model');
            $this->load->model('course_model');
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

        public function courseListing()
        {
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            // $this->load->library('pagination');
            
            // $count = $this->role_model->roleListingCount($searchText);

			// $returns = $this->paginationCompress ( "roleListing/", $count, 10 );
            
            $data['course'] = $this->course_model->courseListing($searchText);
            // $data['userRecords'] = $this->role_model->roleListing($searchText, $returns["page"], $returns["segment"]);
            $process = 'Course Listing';
            $processFunction = 'Course/courseListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Courses';
            $this->loadViews("course/courseList", $this->global, $data , NULL);
        }

        function get_signle_courseData($courseId = NULL)
        {
            $data['courseInfo'] = $this->course_model->getCourseInfo($courseId);
            echo json_encode($data);
        }

        public function course_insert($id)
        {
            $this->load->library('form_validation');
        
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('course_name'))));
                $desc = $this->security->xss_clean($this->input->post('course_desc'));
                $date = $this->security->xss_clean($this->input->post('course_date'));
                if($id == 0)
                {
                    $courseInfo = array('course_name'=>$name, 'course_desc'=>$desc, 'course_date'=> date('Y-m-d', strtotime($date)),
                                'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                        
                    // $result = $this->user_model->addNewUser($userInfo);
                    $result = $this->course_model->data_insert('tbl_course', $courseInfo);
                    if($result > 0)
                    {
                    $process = 'Course Insert';
                    $processFunction = 'Course/courseInsert';
                    $this->logrecord($process,$processFunction);
                       echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }else
                {
                    $courseInfo = array('course_name'=>$name, 'course_desc'=>$desc, 'course_date'=> date('Y-m-d', strtotime($date)),
                                'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));

                    $result = $this->course_model->data_update('tbl_course',$courseInfo,'courseId',$id);
                    
                    if($result == true)
                    {
                        $process = 'Course Update';
                        $processFunction = 'Course/course_insert';
                        $this->logrecord($process,$processFunction);
                        echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }            
        }

        // ==== Delete Course
        public function deleteCourse($id)
        {
            $courseInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->course_model->data_update('tbl_course',$courseInfo,'courseId',$id);

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Course Delete';
                 $processFunction = 'Course/deleteCourse';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }

        // ===============================  
        public function courseLinks($id = null)
        {
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            // $this->load->library('pagination');
            
            // $count = $this->role_model->roleListingCount($searchText);

			// $returns = $this->paginationCompress ( "roleListing/", $count, 10 );
            $data['id'] = $id;
            $data['courselink'] = $this->course_model->courseLinksListing($id, $searchText);
            $course = $this->course_model->getCourseInfo($id);
            $data['courseName'] = $course[0]->course_name;
            // print_r($data['courseName']);exit;

            $process = 'Course Links Listing';
            $processFunction = 'Course/courseLinks';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Course Links';
            $this->loadViews("course/courseLinks", $this->global, $data , NULL);
        }

        public function get_course_link($linkId)
        {
            $data['linkInfo'] = $this->course_model->getCourseLinkInfo($linkId);
            echo json_encode($data);
        }

        public function course_link_insert($linkId, $courseId)
        {
            $this->load->library('form_validation');
        
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('link_name'))));
                $url = $this->security->xss_clean($this->input->post('link_url'));
                $sdate = $this->security->xss_clean($this->input->post('link_sdate'));
                $ldate = $this->security->xss_clean($this->input->post('link_ldate'));
                if($linkId == 0)
                {
                    $courseInfo = array('course_id'=>$courseId, 'link_name'=>$name, 'link_url'=>$url, 'link_date'=>date('Y-m-d'),'link_sdate'=>$sdate,'link_ldate'=>$ldate );
                        
                    // $result = $this->user_model->addNewUser($userInfo);
                    $result = $this->database->data_insert('tbl_course_link', $courseInfo);
                    if($result > 0)
                    {
                    $process = 'Course Link Insert';
                    $processFunction = 'Course/course_link_insert';
                    $this->logrecord($process,$processFunction);
                       echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }else
                {
                    $courseInfo = array( 'link_name'=>$name, 'link_url'=>$url, 'link_sdate'=>$sdate, 'link_ldate'=>$ldate);

                    $result = $this->course_model->data_update('tbl_course_link',$courseInfo,'link_id',$linkId);
                    
                    if($result == true)
                    {
                        $process = 'Course Link Update';
                        $processFunction = 'Course/course_link_insert';
                        $this->logrecord($process,$processFunction);
                        echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }            
        }

        // ==== Delete Course
        public function deleteCourseLink($id)
        {
            $courselinkInfo = array('isDeleted'=>1);
            $result = $this->course_model->data_update('tbl_course_link',$courselinkInfo,'link_id',$id);

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Course Link Delete';
                 $processFunction = 'Course/deleteCourseLink';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }

        // ===============================

        public function courseTypeListing()
        {
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            // $this->load->library('pagination');
            
            // $count = $this->role_model->roleListingCount($searchText);

			// $returns = $this->paginationCompress ( "roleListing/", $count, 10 );
            
            $data['course_type'] = $this->course_model->courseTypeListing($searchText);
            // $data['userRecords'] = $this->role_model->roleListing($searchText, $returns["page"], $returns["segment"]);
            $process = 'Course Type Listing';
            $processFunction = 'Course/courseTypeListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Course Type';
            $this->loadViews("course/courseType", $this->global, $data , NULL);
        }

        function get_signle_courseTypeData($cTypeId = NULL)
        {
            $data['courseTypeInfo'] = $this->course_model->getCourseTypeInfo($cTypeId);
            echo json_encode($data);
        }

        public function course_type_insert($id)
        {
            $this->load->library('form_validation');
        
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('ct_name'))));
                if($id == 0)
                {
                    $ctInfo = array('ct_name'=>$name);
                        
                    // $result = $this->user_model->addNewUser($userInfo);
                    $result = $this->course_model->data_insert('tbl_course_type', $ctInfo);
                    if($result > 0)
                    {
                    $process = 'Course Type Insert';
                    $processFunction = 'Course/course_type_insert';
                    $this->logrecord($process,$processFunction);
                       echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }else
                {
                    $ctInfo = array('ct_name'=>$name);

                    $result = $this->course_model->data_update('tbl_course_type',$ctInfo,'ct_id',$id);
                    
                    if($result == true)
                    {
                        $process = 'Course Type Update';
                        $processFunction = 'Course/course_type_insert';
                        $this->logrecord($process,$processFunction);
                        echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }            
        }

        // ==== Delete Course Type
        public function deleteCourseType($id)
        {
            $courseInfo = array('isDeleted'=>1);
            $result = $this->course_model->data_update('tbl_course_type',$courseInfo,'ct_id',$id);

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Course Type Delete';
                 $processFunction = 'Course/deleteCourseType';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
        // ===============================

    }

?>