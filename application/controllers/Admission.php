<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';

    class Admission extends BaseController
    {
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model('login_model');
            $this->load->model('admission_model');
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

        public function admissionListing()
        {
            $process = 'Admission Listing';
            $processFunction = 'Admission/admissionListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'Admission Listing';
            $this->loadViews("admission/admissionList", $this->global, NULL , NULL);
        }
        
        function get_signle_admission($admissionId = NULL)
        {
            $data['admInfo'] = $this->admission_model->getAdmissionInfo($admissionId);
            echo json_encode($data);
        }

        public function admission_insert($id)
        {
            $this->load->library('form_validation');
        
                $name = $this->security->xss_clean($this->input->post('full_name'));
                $enq_date = $this->security->xss_clean($this->input->post('adm_date'));
                $source = $this->security->xss_clean($this->input->post('source'));
                $remark = $this->security->xss_clean($this->input->post('remark'));
                $alt_mobile = $this->security->xss_clean($this->input->post('alt_mobile'));

                if(!empty($_FILES['photo']))
	  			{
	    			if($_FILES['photo']['error'] == 0)
	    			{
	      				$path =  $_FILES['photo']['name'];
	      				$ext = pathinfo($path, PATHINFO_EXTENSION);
	      				$fileName = 'passportsizephoto_'.time().'.'.$ext;
	      				$config['upload_path'] = './uploads/admission/';
	      				$config['allowed_types'] = 'jpg|jpeg|png|gif';
	      				$config['max_size'] = '102400';
	      				$config['detect_mime'] = 'true';
	      				$config['overwrite'] = 'true';
	      				$config['file_name'] = $fileName;

	      				$this->load->library('upload', $config);
	      				$this->upload->initialize($config);

	      				if (!$this->upload->do_upload('photo'))
	      				{
	        				$photo = '';
	      				}
	      				else
	      				{
	        				$photo = $fileName;
	      				}
	    			}
	    			else
	    			{
	      				$photo = '';
	    			}
	  			} 

                if(!empty($_FILES['adhar_card']))
	  			{
	    			if($_FILES['adhar_card']['error'] == 0)
	    			{
	      				$path =  $_FILES['adhar_card']['name'];
	      				$ext = pathinfo($path, PATHINFO_EXTENSION);
	      				$fileName = 'adhar_card_'.time().'.'.$ext;
	      				$config['upload_path'] = './uploads/admission/';
	      				$config['allowed_types'] = 'jpg|jpeg|png|gif';
	      				$config['max_size'] = '102400';
	      				$config['detect_mime'] = 'true';
	      				$config['overwrite'] = 'true';
	      				$config['file_name'] = $fileName;

	      				$this->load->library('upload', $config);
	      				$this->upload->initialize($config);

	      				if (!$this->upload->do_upload('adhar_card'))
	      				{
	        				$adhar_card = '';
	      				}
	      				else
	      				{
	        				$adhar_card = $fileName;
	      				}
	    			}
	    			else
	    			{
	      				$adhar_card = "NULL";
	    			}
	  			} 

                  if(!empty($_FILES['pan_card']))
	  			{
	    			if($_FILES['pan_card']['error'] == 0)
	    			{
	      				$path =  $_FILES['pan_card']['name'];
	      				$ext = pathinfo($path, PATHINFO_EXTENSION);
	      				$fileName = 'pan_card_'.time().'.'.$ext;
	      				$config['upload_path'] = './uploads/admission/';
	      				$config['allowed_types'] = 'jpg|jpeg|png|gif';
	      				$config['max_size'] = '102400';
	      				$config['detect_mime'] = 'true';
	      				$config['overwrite'] = 'true';
	      				$config['file_name'] = $fileName;

	      				$this->load->library('upload', $config);
	      				$this->upload->initialize($config);

	      				if (!$this->upload->do_upload('pan_card'))
	      				{
	        				$pan_card = '';
	      				}
	      				else
	      				{
	        				$pan_card = $fileName;
	      				}
	    			}
	    			else
	    			{
	      				$pan_card = '';
	    			}
	  			} 
                if($id == 0)
                {
                    $admInfo = array('mobile'=>$mobile,'alt_mobile'=>$alt_mobile,'full_name'=>$name, 'admission_date'=> date('Y-m-d', strtotime($enq_date)), 'adm_source'=>$source, 'admission_remark'=>$remark,
                                'adm_passportsize_photo'=>$photo, 'adm_adhar_photo'=>$adhar_card,'adm_pan_photo'=>$pan_card,
                                'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                        
                    // $result = $this->user_model->addNewUser($userInfo);
                    $result = $this->database->data_insert('tbl_admission', $admInfo);
                    if($result > 0)
                    {
                    $process = 'Admission Insert';
                    $processFunction = 'Admission/admission_insert';
                    $this->logrecord($process,$processFunction);
                       echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }else
                {
                    $admInfo = array('mobile'=>$mobile,'alt_mobile'=>$alt_mobile,'full_name'=>$name, 'admission_date'=> date('Y-m-d', strtotime($enq_date)),'adm_source'=>$source, 'admission_remark'=>$remark,
                                'adm_passportsize_photo'=>$photo, 'adm_adhar_photo'=>$adhar_card,'adm_pan_photo'=>$pan_card,
                                'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));

                    $result = $this->database->data_update('tbl_admission',$admInfo,'admissionId',$id);
                    
                    if($result == true)
                    {
                        $process = 'Admission Update';
                        $processFunction = 'Admission/admission_insert';
                        $this->logrecord($process,$processFunction);
                        echo true;
                    }
                    else
                    {
                        echo false;
                    }
                }            
        }

        public function deleteAdmission(){
                $post_submit = $this->input->post();
                if(!empty($post_submit)){
                    $deleteadmission_response =array();
                    $checkRelation = $this->admission_model->checkRelationadmission($this->input->post('id'));
                    if($checkRelation){
                        $deleteadmission_response['status'] = 'linked';
                    }else{
                        $courseInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                        $result = $this->admission_model->data_update('tbl_admission',$courseInfo,'id',$this->input->post('id'));
                        if($result){
                            $deleteadmission_response['status'] = 'success';
                            $process = 'Delete Admission';
                            $processFunction = 'Admission/Delete Admission';
                            $this->logrecord($process,$processFunction);
                        }else
                        {
                            $deleteadmission_response['status'] = 'filure';
                        }
                }
                    echo json_encode($deleteadmission_response);
                }
        }

        public function fetchadmissions(){

                $params = $_REQUEST;
                $totalRecords = $this->admission_model->getAdmissionsCount($params); 
                $queryRecords = $this->admission_model->getAdmissionsdata($params); 
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

        public function viewadmissiondetails($id){
            $process = 'View Admission Details';
            $processFunction = 'Admission/viewadmissiondetails';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'View Admission Details';
            $data['view_admission_details'] = $this->admission_model->viewAdmissionDetails($id);
            $this->loadViews("admission/viewAdmissiondetails", $this->global, $data , NULL);
        }

        public function editadmission($id){

            
            $process = 'Admission Edit';
            $processFunction = 'Enquiry/enquiryEdit';
            $this->logrecord($process,$processFunction);
            // $data['course_List'] = $this->comman_model->getCourseList();
            // $data['editDataenquiry'] = $this->enquiry_model->getEnquiryInfo($id);
            // $data['state_List'] = $this->comman_model->selectAllStates($data['editDataenquiry'][0]->enq_country,$data['editDataenquiry'][0]->enq_state);
            // $data['city_List'] = $this->comman_model->selectAllCities($data['editDataenquiry'][0]->enq_state,$data['editDataenquiry'][0]->enq_city);
            $this->global['pageTitle'] = 'Admission Management';
            $this->loadViews("enquiry/enquiryEdit", $this->global, $data , NULL);


        }


    }

?>