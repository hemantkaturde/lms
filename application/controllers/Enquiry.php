<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';

    class Enquiry extends BaseController
    {
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model('login_model');
            $this->load->model('enquiry_model');
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

        public function enquiryListing()
        {
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            // $this->load->library('pagination');
            
            // $count = $this->role_model->roleListingCount($searchText);

			// $returns = $this->paginationCompress ( "roleListing/", $count, 10 );
            
            $data['enquiry'] = $this->enquiry_model->enquiryListing($searchText);
            // $data['userRecords'] = $this->role_model->roleListing($searchText, $returns["page"], $returns["segment"]);
            $process = 'Enquiry Listing';
            $processFunction = 'Enquiry/enquiryListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Enquiry';
            $this->loadViews("enquiry/enquiryList", $this->global, $data , NULL);
        }

        function get_signle_enquiry($enqId = NULL)
        {
            $data['enquiryInfo'] = $this->enquiry_model->getEnquiryInfo($enqId);
            echo json_encode($data);
        }

        // function student_assets()
        // {
        //     $data['courses'] = $this->student_model->getCourses();
        //     echo json_encode($data);
        // }

        public function enquiry_insert($id)
        {
            $this->load->library('form_validation');
        
                $name = $this->security->xss_clean($this->input->post('name'));
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $mobile1 = $this->security->xss_clean($this->input->post('mobile1'));
                $email = $this->security->xss_clean($this->input->post('email'));
                $email1 = $this->security->xss_clean($this->input->post('email1'));
                $qualification = $this->security->xss_clean($this->input->post('qualification'));
                $country = $this->security->xss_clean($this->input->post('country'));
                $state = $this->security->xss_clean($this->input->post('state'));
                $city = $this->security->xss_clean($this->input->post('city'));
                $purpose = $this->security->xss_clean($this->input->post('purpose'));
                $enq_date = $this->security->xss_clean($this->input->post('enq_date'));
                $source = $this->security->xss_clean($this->input->post('source'));
                $remark = $this->security->xss_clean($this->input->post('remark'));

                if($id == 0)
                {
                    $enquiryInfo = array('enq_fullname'=>$name, 'enq_mobile'=>$mobile, 'enq_mobile1'=>$mobile1, 'enq_date'=> date('Y-m-d', strtotime($enq_date)),
                                'enq_email'=>$email, 'enq_email1'=>$email1,'enq_qualification'=> $qualification, 'enq_purpose'=>$purpose, 'enq_country'=>$country,'enq_state'=> $state, 'enq_city'=> $city,
                                'enq_source'=>$source, 'enq_remark'=>$remark,
                                'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                        
                    // $result = $this->user_model->addNewUser($userInfo);
                    $result = $this->database->data_insert('tbl_enquiry', $enquiryInfo);
                    if($result > 0)
                    {
                    $process = 'Enquiry Insert';
                    $processFunction = 'Enquiry/enquiry_insert';
                    $this->logrecord($process,$processFunction);
                       echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }else
                {
                    $enquiryInfo = array('enq_fullname'=>$name, 'enq_mobile'=>$mobile, 'enq_mobile1'=>$mobile1, 'enq_date'=> date('Y-m-d', strtotime($enq_date)),
                                'enq_email'=>$email, 'enq_email1'=>$email1,'enq_qualification'=> $qualification, 'enq_purpose'=>$purpose, 'enq_country'=>$country,'enq_state'=> $state, 'enq_city'=> $city,
                                'enq_source'=>$source, 'enq_remark'=>$remark,
                                'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));

                    $result = $this->database->data_update('tbl_enquiry',$enquiryInfo,'enq_id',$id);
                    
                    if($result == true)
                    {
                        $process = 'Enquiry Update';
                        $processFunction = 'Enquiry/enquiry_insert';
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
        public function deleteEnquiry($id)
        {
            $enquiryInfo = array('isDeleted'=>1,'updatedBy'=> $this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->database->data_update('tbl_enquiry',$enquiryInfo,'enq_id',$id);

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Enquiry Delete';
                 $processFunction = 'Enquiry/deleteEnquiry';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }

        // ===============================       

    }

?>