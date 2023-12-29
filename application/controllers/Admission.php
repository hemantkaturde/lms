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
            $processFunction = 'Enquiry/editadmission';
            $this->logrecord($process,$processFunction);
            $data['counsellor_list_data'] = $this->admission_model->counsellor_list();
            $data['editDataAdmission'] = $this->admission_model->editDataadmission($id);
            //$data['country_List'] = $this->comman_model->getCourseList();
            $data['state_List'] = $this->comman_model->selectAllStates(101,NULL);
            $data['city_List'] = $this->comman_model->selectAllCitiesForedit(NULL,NULL);
            $this->global['pageTitle'] = 'Update Admission';
            $this->loadViews("admission/editadmission", $this->global, $data , NULL);
        }


        public function updateadmission(){
            $post_submit = $this->input->post();
            if($post_submit){
                $update_admission_response = array();
                $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
                $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
                $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
                $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required');
                $this->form_validation->set_rules('date_of_birth', 'Date Of Birth', 'trim|required');
                $this->form_validation->set_rules('counsellor_name', 'Counsellor Name', 'trim|required');
                $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'trim|required');
                $this->form_validation->set_rules('how_did_you_know', 'How Did You Know', 'trim|required');
                $this->form_validation->set_rules('how_about_us', 'How About Us', 'trim|required');

                $this->form_validation->set_rules('student_photo_existing', 'Student Photo', 'trim|required');
                $this->form_validation->set_rules('edu_certificate_existing', 'Edu Certificate', 'trim|required');
                $this->form_validation->set_rules('adhar_copy_existing', 'Adhar copy', 'trim|required');


                if($this->form_validation->run() == FALSE){
                    $update_admission_response['status'] = 'failure';
                    $update_admission_response['error'] = array('full_name'=>strip_tags(form_error('full_name')),'mobile_number'=>strip_tags(form_error('mobile_number')),'email_address'=>strip_tags(form_error('email_address')),'date_of_birth'=>strip_tags(form_error('date_of_birth')),'counsellor_name'=>strip_tags(form_error('counsellor_name')),'permanent_address'=>strip_tags(form_error('permanent_address')),'how_did_you_know'=>strip_tags(form_error('how_did_you_know')),'how_about_us'=>strip_tags(form_error('how_about_us')),'student_photo'=>strip_tags(form_error('student_photo')),'edu_certificate'=>strip_tags(form_error('edu_certificate')),'adhar_copy'=>strip_tags(form_error('adhar_copy')),'gender'=>strip_tags(form_error('gender')),'lastname'=>strip_tags(form_error('lastname')));
                }else{
                    $check_uniqe  = $this->admission_model->check_unique_admission($this->input->post('full_name'),$this->input->post('admission_id'),$this->input->post('enq_id'));
                    if($check_uniqe > 0){

                        if(!empty($_FILES['student_photo']['name'])){
                            $file = $_FILES['student_photo']['name'];
                            $filename = str_replace(' ','_',$file);
                            $config['upload_path'] = 'uploads/admission'; 
                            $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                            $config['max_size'] = '100000'; // max_size in kb 
                            $config['file_name'] = $filename; 
                            // Load upload library 
                            $this->load->library('upload',$config); 

                            // File upload
                            if($this->upload->do_upload('student_photo')){ 
                                $existing_student_photo = $filename; 
                            }else{
                                $existing_student_photo =trim($this->input->post('student_photo_existing'));
                            }



                        }else{

                            $existing_student_photo= trim($this->input->post('student_photo_existing'));
                        }


                        if(!empty($_FILES['edu_certificate']['name'])){
                            $file = $_FILES['edu_certificate']['name'];
                            $filename = str_replace(' ','_',$file);
                            $config['upload_path'] = 'uploads/admission'; 
                            $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                            $config['max_size'] = '100000'; // max_size in kb 
                            $config['file_name'] = $filename; 
                            // Load upload library 
                            $this->load->library('upload',$config); 
                    
                            // File upload
                            if($this->upload->do_upload('edu_certificate')){ 
                                $existing_certificate_existing = $filename; 
                            }else{
                                $existing_certificate_existing =trim($this->input->post('edu_certificate_existing'));
                            }
                        }else{

                            $existing_certificate_existing= trim($this->input->post('edu_certificate_existing'));
                        }


                        if(!empty($_FILES['adhar_copy']['name'])){
                            $file = $_FILES['adhar_copy']['name'];
                            $filename = str_replace(' ','_',$file);
                            $config['upload_path'] = 'uploads/admission'; 
                            $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                            $config['max_size'] = '100000'; // max_size in kb 
                            $config['file_name'] = $filename; 
                            // Load upload library 
                            $this->load->library('upload',$config); 
                    
                            // File upload
                            if($this->upload->do_upload('adhar_copy')){ 
                                $existing_adhar_copy = $filename; 
                            }else{
                                $existing_adhar_copy =trim($this->input->post('adhar_copy_existing'));
                            }
                        }else{

                            $existing_adhar_copy= trim($this->input->post('adhar_copy_existing'));
                        }
                       

                        $data = array(
                            'name' => $this->input->post('full_name'),
                            'lastname' => $this->input->post('lastname'),
                            'gender' => $this->input->post('gender'),
                            'mobile'=>$this->input->post('mobile_number'),
                            'alt_mobile'=>$this->input->post('alternate_mobile_number'),
                            'email'=>$this->input->post('email_address'),
                            'dateofbirth'=>$this->input->post('date_of_birth'),
                            'counsellor_name'=>$this->input->post('counsellor_name'),
                            'address'=>$this->input->post('permanent_address'),
                            'city'=>$this->input->post('city'),
                            'state'=>$this->input->post('state'),
                            'country'=>$this->input->post('country'),
                            'pin'=>$this->input->post('pin_number'),
                            'source_about'=>$this->input->post('how_did_you_know'),
                            'source_ans'=>$this->input->post('how_about_us'),
                            'document_1'=> $existing_student_photo,
                            'document_2'=> $existing_certificate_existing,
                            'document_3' =>$existing_adhar_copy
                        );


                        $updateAdmissionData = $this->admission_model->saveAdmissiondata($this->input->post('admission_id'),$data);
                        if($updateAdmissionData){

                            $UpdateInjquirydata = array(
                                'enq_fullname' => $this->input->post('full_name'),
                                'enq_mobile' => $this->input->post('mobile_number'),
                            );

                           $updateSimilarDatainEnquiry =  $this->admission_model->UpdateInjquirydata($this->input->post('enq_id'),$UpdateInjquirydata);
                            
                           if($updateSimilarDatainEnquiry){
                               $update_admission_response['status'] = 'success';
                               $update_admission_response['error'] = array('full_name'=>'','mobile_number'=>'','email_address'=>'','date_of_birth'=>'','counsellor_name'=>'','permanent_address'=>'','how_did_you_know'=>'','how_about_us'=>'','adhar_copy'=>'','edu_certificate'=>'','student_photo'=>'','lastname'=>'','gender'=>'');
                           }
                        }

                    }else{

                        $check_admission_uinqe_name = $this->admission_model->check_admission_uinqe_name($this->input->post('full_name'));




                    }
                 

                    $process = 'Update Admission';
                    $processFunction = 'Admission/updateadmission';
                    $this->logrecord($process,$processFunction);

                }

                echo json_encode($update_admission_response);

            }
        }

        public function cancleadmission(){
            $post_submit = $this->input->post();
            if(!empty($post_submit)){
                $cancleadmission_response =array();
                    $courseInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                    $result = $this->admission_model->cancleadmission($this->input->post('id'));
                    if($result){
                        $cancleadmission_response['status'] = 'success';
                        $process = 'Delete Admission';
                        $processFunction = 'Admission/Delete Admission';
                        $this->logrecord($process,$processFunction);
                    }else
                    {
                        $cancleadmission_response['status'] = 'filure';
                    }
            
                echo json_encode($cancleadmission_response);
            }
        }

        public function delete_add_on_course(){
            $post_submit = $this->input->post();
            if(!empty($post_submit)){
                $deleteaddoncourse_response =array();
        
                    $courseInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                    $result = $this->admission_model->data_update('tbl_add_on_courses',$courseInfo,'id',$this->input->post('id'));
                    if($result){
                        $deleteaddoncourse_response['status'] = 'success';
                        $process = 'Delete Add On Course';
                        $processFunction = 'Admission/delete_add_on_course';
                        $this->logrecord($process,$processFunction);
                    }else
                    {
                        $deleteaddoncourse_response['status'] = 'filure';
                    }
            }
                echo json_encode($deleteaddoncourse_response);
            }

        

    }

?>