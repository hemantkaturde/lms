<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Api extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
         parent::__construct();
         $this->load->model(array('Api_model','enquiry_model','event','user_model','course_model','student_model','admission_model'));
         $this->load->library('form_validation');
    }

    /* Superadmin Part */    

    /*Login */
    public function login(){
        $post_submit = $this->input->post();
        $this->form_validation->set_rules('username', 'User Name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('username' =>strip_tags(form_error('username')),'password' =>strip_tags(form_error('password')));
		}
		else
		{
            $data = array('username' => $this->input->post('username'),'password' => $this->input->post('password'));
            $user_data = $this->Api_model->getAuthtoken($data);

            if($user_data != 'password mismatch' && $user_data != 'Username not available' && $user_data != 'account disable') {
				$status = 'Success';
				$message = 'Authorization data';
				$data = $user_data;
				//logInformationcollection($user_data['id'],$this->input->post('username'),$user_data['mobile_no'],'Login Success', 'API to user app', 'Login',json_encode($data));
			} else if($user_data == 'password mismatch'){
				$status = 'Failure';
				$message = 'You have entered an invalid password';
				$data = '';
			} else if($user_data == 'Username not available'){
				$status = 'Failure';
				$message = 'You have entered invalid Username';
				$data = '';
			} else if($user_data == 'account disable'){
				$status = 'Failure';
				$message = 'Your phone number has been disabled, please contact system admin at 1800-266-4242';
				$data = '';
			}
        }
        $responseData = array('status' => $status,'message'=> $message,'data' => $data);
		setContentLength($responseData);
    }

    /*User Details*/
    public function getuserdetails(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')));
		}
		else
		{	$status = 'Success';
            $message = 'User data';
            $data = array('userid' => $this->input->post('userid'));

            if($userdetails['profile_pic']){

                $profile_pic_image = IMGPATH.'/'.$userdetails['profile_pic'];
            }else{

                $profile_pic_image = 'NULL';
            }

            $user_data =  array('userid' => $userdetails['userId'],'name' => $userdetails['name'],'username'=>$userdetails['username'],'email'=>$userdetails['email'],'user_flag'=>$userdetails['user_flag'],'role'=>$userdetails['role'],'access'=>$userdetails['access'],'profile_pic'=>$profile_pic_image);
			logInformationcollection($userdetails['userId'],$userdetails['username'],$userdetails['mobile'],'User Details Fetched', 'API to user app', 'User Details', $user_data);
        }

        $responseData = array('status' => $status,'message'=> $message,'data' => $user_data);
		setContentLength($responseData);
    }

    /*Menu List*/
    public function getmenu(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')));
		}
		else
		{	$status = 'Success';
            $message = 'Menu List';
            $data = array('userid' => $this->input->post('userid'));

             /* Get All Roles From Roles table */

             /* Role List As Below */
             if(trim($this->input->post('user_flag'))=='Superadmin'){
                $menu_list = array('1'=>'dashboard','2'=>'Inquiry / Leads','3'=>'Tax Invoices','4'=>'Admission','5'=>'Attendance','6'=>'Examination','7'=>'Certificates','8'=>'Student List','9'=>'Users List','10'=>'Course List','11'=>'Certification Type','12'=>'Student Report','13'=>'Student Exam Request');
             }

             if(trim($this->input->post('user_flag'))=='Counsellor'){
                $menu_list = array('1'=>'dashboard','2'=>'Inquiry / Leads','3'=>'Tax Invoices','4'=>'Admission','5'=>'Attendance','6'=>'Examination','7'=>'Certificates','8'=>'Student List','9'=>'Users List','10'=>'Course List','11'=>'Certification Type','12'=>'Student Report','13'=>'Student Exam Request');
             }

             if(trim($this->input->post('user_flag'))=='Student'){
                $menu_list = array('1'=>'dashboard','2'=>'Inquiry / Leads','3'=>'Tax Invoices','4'=>'Admission','5'=>'Attendance','6'=>'Examination','7'=>'Certificates','8'=>'Student List','9'=>'Users List','10'=>'Course List','11'=>'Certification Type','12'=>'Student Report','13'=>'Student Exam Request');
             }

             if(trim($this->input->post('user_flag'))=='Trainer'){

                $menu_list = array('1'=>'dashboard','2'=>'Inquiry / Leads','3'=>'Tax Invoices','4'=>'Admission','5'=>'Attendance','6'=>'Examination','7'=>'Certificates','8'=>'Student List','9'=>'Users List','10'=>'Course List','11'=>'Certification Type','12'=>'Student Report','13'=>'Student Exam Request');
             }

            $menu_data =  array('userid' => $userdetails['userId'],'user_flag'=>$userdetails['user_flag'],'role'=>$userdetails['role'],'access'=>$userdetails['access'],'menu_list'=>$menu_list);
			
            logInformationcollection($userdetails['userId'],$userdetails['username'],$userdetails['mobile'],'Menu Fetched', 'API to user app', 'Get Menu Details', $menu_data);
        }

        $responseData = array('status' => $status,'message'=> $message,'data' => $menu_data);
		setContentLength($responseData);
    }

    /*Dashbaord DetailsList*/
    public function getdashboarddetails(){
       $userdetails = validateServiceRequest();
       $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
       $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

    }

    /*Course List*/
    public function getcourselist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $data = array('userid' =>trim($this->input->post('userid')),'user_flag' =>trim($this->input->post('user_flag')));
            $course_data = $this->Api_model->getCourseData($data);
            if($course_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $course_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }

    /*Course List*/
     public function getcoursetypelist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $courseList_data = $this->Api_model->getCourseTypedata($data);
            if($courseList_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $courseList_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }

    /*Enquiry List*/
    public function getenquirylist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{

            $data = array('userid' =>trim($this->input->post('userid')),'user_flag' =>trim($this->input->post('user_flag')));
            $equiry_data = $this->Api_model->getEnquiryData($data);
            if($equiry_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $equiry_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }

    /*Enquiry List*/
    public function gettaxinvoicelist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $taxinvoice_data = $this->Api_model->getTaxinvoiceData($data);
            if($taxinvoice_data){
                $status = 'Success';
                $message = 'Tax Invoice Data Found';
                $data = $taxinvoice_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }

    /*Admission List*/
    public function getadmissionlist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $admission_data = $this->Api_model->getAdmissionsdata($data);
            if($admission_data){
                $status = 'Success';
                $message = 'Admission Data Found';
                $data = $admission_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }

    /*Attendance List*/
    public function getattendancelist(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $attendance_data = $this->Api_model->getattendancedata($data);
            if($attendance_data){
                $status = 'Success';
                $message = 'Attendance Data Found';
                $data = $attendance_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }
    }

    /*Examination List*/
    public function getexaminationlist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $examination_data = $this->Api_model->getExaminationdata($data);
            if($examination_data){
                $status = 'Success';
                $message = 'Examination Data Found';
                $data = $examination_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }


     /*Examination List*/
     public function getcheckexaminationlist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $data = array('userid' =>trim($this->input->post('userid')),'user_flag' =>trim($this->input->post('user_flag')));

            $examination_data = $this->Api_model->getcheckexaminationlist($data);
            if($examination_data){
                $status = 'Success';
                $message = 'Examination Data Found';
                $data = $examination_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }

    /*Certicate List*/
    public function getcertificatelist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $certificate_data = $this->Api_model->getCertificatedata($data);
            if($certificate_data){
                $status = 'Success';
                $message = 'Certificate Data Found';
                $data = $certificate_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }

    /*Student Portal List*/
    public function getstudentportallist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $studentportal_data = $this->Api_model->getStudentportaldata($data);
            if($studentportal_data){
                $status = 'Success';
                $message = 'Student Portal Data Found';
                $data = $studentportal_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }

    /*Dashbaord Details*/
    public function getdashbaorddetails(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $dashbaord_details_data = $this->Api_model->getDashbaorddata($data);
            if($dashbaord_details_data){
                $status = 'Success';
                $message = 'Dashbaord Portal Data Found';
                $data = $dashbaord_details_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
        }
        setContentLength($responseData);
    }

    /*Staff User List*/
    public function getstaffuserdetails(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{

            $staff_details_data = $this->Api_model->getStaffuserdetails($data);
            if($staff_details_data){
                $status = 'Success';
                $message = 'Staff User Detials Found';
                $data = $staff_details_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
        }

        setContentLength($responseData);
    }

    /*Class request Details*/
    public function getclassrequestdetails(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{

            $view_class_request_details = $this->Api_model->getclassrequestdetails($data);
            if($view_class_request_details){
                $status = 'Success';
                $message = 'Staff User Detials Found';
                $data = $view_class_request_details;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
        }

        setContentLength($responseData);
    }

    /*class for get enquiry sourse*/
    public function getenquirysourselist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
                $status = 'Success';
                $message = 'Sourse List Found';
                $data = array(
                    'Email' =>'Email',                            
                    'Friends' =>'Friends',                           
                    'Google' =>'Google',  
                    'Facebook' =>'Facebook', 
                    'Instagram' =>'Instagram', 
                    'Reference' =>'Reference', 
                    'Social Media'  =>'Social Media', 
                    'Direct' =>'Direct',
                    'Call' =>'Call',
                    'Chat' =>'Chat',
                    'Cold calling' =>'Cold calling',
                    'Ads Campaign' =>'Ads Campaign',
                    'WhatsApp' =>'WhatsApp',
                    'Other' =>'Other'
                );

            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
        }

        setContentLength($responseData);
    }

    /*class for get All Course List*/
    public function getallcourselist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{

            $data = array('userid' =>trim($this->input->post('userid')),'user_flag' =>trim($this->input->post('user_flag')));

            $view_CourseList = $this->Api_model->getCourseList($data);
            if($view_CourseList){
                $status = 'Success';
                $message = 'Course List Detials Found';
                $data = $view_CourseList;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
        }

        setContentLength($responseData);


    }


    /*class for get All city List*/
    public function getallcitylist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{

            $view_cityList = $this->Api_model->getCityList();
            if($view_cityList){
                $status = 'Success';
                $message = 'City List Found';
                $data = $view_cityList;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
        }

        setContentLength($responseData);
    }


    /*class for get All Counsellor List*/
    public function counsellerlist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{

            $getcounsellerlist = $this->Api_model->getcounsellerlist();
            if($getcounsellerlist){
                $status = 'Success';
                $message = 'counseller List Found';
                $data = $getcounsellerlist;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
        }

        setContentLength($responseData);
    }


    /*class for create enquiry*/
    public function createenquiry(){
        $post_submit = $this->input->post();

        if(!empty($post_submit)){
            $createenquiry_response = array();
        
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|numeric|greater_than[0]|exact_length[10]');
            //$this->form_validation->set_rules('alternate_mobile', 'Alternate Mobile', 'trim');
            $this->form_validation->set_rules('email', 'Email', 'trim');
            //$this->form_validation->set_rules('alternamte_email', 'Alternamte Email', 'trim');
            $this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');
            //$this->form_validation->set_rules('purpose', 'Purpose', 'trim');
            $this->form_validation->set_rules('enq_date', 'Enq Date', 'trim|required');
            //$this->form_validation->set_rules('country', 'Country', 'trim');
            //$this->form_validation->set_rules('state', 'State', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim');
            $this->form_validation->set_rules('enquiry_type', 'Enquiry Type', 'trim|required');
            $this->form_validation->set_rules('doctor_non_doctor', 'Doctor Non Doctor', 'trim|required');
            $this->form_validation->set_rules('counsellor', 'Counsellor', 'trim|required');
            $this->form_validation->set_rules('inquiry_from', 'Inquiry_from', 'trim|required');
            //$this->form_validation->set_rules('remarks', 'Remarks', 'trim');
            $this->form_validation->set_rules('course', 'Course', 'trim|required');
            
            $courses_multipal = $this->input->post('course');

            if($courses_multipal){
            
                   $course_name = explode(',',$courses_multipal);
                   $trimmedArray = array_map('trim', $course_name);
                   
                   $getallcourseidbycoursename = $this->enquiry_model->getallcourseidbycoursename($trimmedArray);

                    // $course_ids    =   explode(',', $courses_multipal);
                    $course_ids    =   $getallcourseidbycoursename ;

                    $total_fees = 0;
                    $course_name = '';
                    $i = 1;
                    $courses='';
                    foreach($course_ids as $id)
                    {
                       $courses .= $id['courseId']. ','; 

                       $get_course_fees =  $this->enquiry_model->getCourseInfo($id['courseId']);
                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees[0]->course_total_fees;
                            //$course_name .= $i.') '.$get_course_fees[0]->course_name.'&nbsp&nbsp( Rs '.$get_course_fees[0]->course_total_fees. ') <br> ';  
                            $i++;   
                    
                        }else{
                    
                            $total_fees = '';
                            //$course_name = '';  
                            $i++;  
                        }
                        
                    }


            }else{
                $courses = '';
            }


            
            $result_courses = rtrim($courses, ','); 

            if($this->form_validation->run() == FALSE){

                
                    $createenquiry_response['status'] = 'failure';
                    $createenquiry_response['validation_msg'] = 'Record not Submitted';
                    $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'remarks'=>strip_tags(form_error('remarks')),'doctor_non_doctor'=>strip_tags(form_error('doctor_non_doctor')),'counsellor'=>strip_tags(form_error('counsellor')),'inquiry_from'=>strip_tags(form_error('inquiry_from')));
             
            }else{

                $check_enquiry_auto_number =  $this->enquiry_model->getautonumberfromEnquiry();
                if($check_enquiry_auto_number){
                    if($check_enquiry_auto_number[0]->enq_number){
                        $enq_number =$check_enquiry_auto_number[0]->enq_number +  1;
                    }else{
                        $enq_number = 1;
                    }

                }else{
                    $enq_number = 1;
                }
               

                $data = array(
                    //'enq_number'=> DATE('Y').DATE('m').DATE('d').DATE('H').DATE('i').DATE('s'),
                    'enq_number'=> $enq_number,
                    'enq_fullname' => ucwords($this->input->post('full_name')),
                    'enq_mobile'=> $this->input->post('mobile_no'),
                    //'enq_mobile1' => $this->input->post('alternate_mobile'),
                    'enq_email'=> $this->input->post('email'),
                    //'enq_email1' => $this->input->post('alternamte_email'),
                    'enq_qualification' => $this->input->post('qualification'),
                    //'enq_purpose' => $this->input->post('purpose'),
                    'enq_date' => date('Y-m-d', strtotime($this->input->post('enq_date'))),
                    'doctor_non_doctor'=>$this->input->post('doctor_non_doctor'),
                    //'enq_country'=> $this->input->post('country'),
                    //'enq_state'=>$this->input->post('state'),
                    'enq_city'=>$this->input->post('city'),
                    'total_payment' =>$total_fees,
                    'final_amount' =>$total_fees,
                    'enq_source'=>$this->input->post('enquiry_type'),
                    //'enq_remark' => $this->input->post('remarks'),
                    'enq_course_id' => $result_courses,
                    'counsellor_id' => $this->input->post('counsellor'),
                );

                /*check If course name is unique*/
                $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname(trim($this->input->post('mobile_no')));

                if($check_uniqe){
                    $createenquiry_response['status'] = 'failure';
                    $createenquiry_response['validation_msg'] = 'Mobile Number Already Exists';
                    $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'course'=>'Course Required','remarks'=>strip_tags(form_error('remarks')),'doctor_non_doctor'=>strip_tags(form_error('doctor_non_doctor')),'counsellor'=>strip_tags(form_error('counsellor')),'inquiry_from'=>strip_tags(form_error('inquiry_from')));
                }else{
                    $saveEnquirydata = $this->enquiry_model->saveEnquirydata('',$data);
                    if($saveEnquirydata){
                        $createenquiry_response['status'] = 'success';
                        $createenquiry_response['validation_msg'] = 'Record successfully Submitted';
                        $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'course'=>'','remarks'=>strip_tags(form_error('remarks')),'doctor_non_doctor'=>strip_tags(form_error('doctor_non_doctor')),'counsellor'=>strip_tags(form_error('counsellor')),'inquiry_from'=>strip_tags(form_error('inquiry_from')));
                    }
                }
              
            }
    
            echo json_encode($createenquiry_response);
        }else{

            echo 'no formdata -poasted';
        }

    }

    /*class for create updateenquiry*/
    public function updateenquiry(){
        $post_submit = $this->input->post();
        $enq_id = $this->input->post('enq_id');

        if(!empty($post_submit)){
            $createenquiry_response = array();
           
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('mobile_no', 'Mobile_no', 'trim|required|numeric|greater_than[0]|exact_length[10]');
            //$this->form_validation->set_rules('alternate_mobile', 'Alternate Mobile', 'trim');
            $this->form_validation->set_rules('email', 'Email', 'trim');
            //$this->form_validation->set_rules('alternamte_email', 'Alternamte Email', 'trim');
            $this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');
            //$this->form_validation->set_rules('purpose', 'Purpose', 'trim');
            $this->form_validation->set_rules('enq_date', 'Enq Date', 'trim|required');
            //$this->form_validation->set_rules('country', 'Country', 'trim');
            //$this->form_validation->set_rules('state', 'State', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim');
            $this->form_validation->set_rules('enquiry_type', 'Enquiry Type', 'trim|required');
            $this->form_validation->set_rules('doctor_non_doctor', 'Doctor Non Doctor', 'trim|required');
            $this->form_validation->set_rules('counsellor', 'Counsellor', 'trim|required');
            //$this->form_validation->set_rules('remarks', 'Remarks', 'trim');
            //$this->form_validation->set_rules('course', 'Course', 'trim|required');
            


            if($this->form_validation->run() == FALSE){
                if($this->input->post('course')){
                    $createenquiry_response['status'] = 'failure';
                    //$createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')),'course'=>strip_tags(form_error('course')),'enquiry_type'=>strip_tags(form_error('enquiry_type')));
                    $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'doctor_non_doctor'=>strip_tags(form_error('doctor_non_doctor')),'counsellor'=>strip_tags(form_error('counsellor')));
                }else{
                    $createenquiry_response['status'] = 'failure';
                    $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'course'=>'Course Required','remarks'=>strip_tags(form_error('remarks')),'doctor_non_doctor'=>strip_tags(form_error('doctor_non_doctor')),'counsellor'=>strip_tags(form_error('counsellor')));
                }
            }else{
                
                if($this->input->post('course')){
                            // $courses_multipal = $this->security->xss_clean($this->input->post('course'));

                            // if($courses_multipal){
                            //     $courses = implode(',', $courses_multipal);

                            //     $course_ids    =   explode(',', $courses);
                            //     $total_fees = 0;
                            //     $course_name = '';
                            //     $i = 1;
                            //     foreach($course_ids as $id)
                            //     {
                            //         $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                            //         if($get_course_fees){
                                        
                            //             $total_fees += $get_course_fees[0]->course_total_fees;
                            //             //$course_name .= $i.') '.$get_course_fees[0]->course_name.'&nbsp&nbsp( Rs '.$get_course_fees[0]->course_total_fees. ') <br> ';  
                            //             $i++;   
                                
                            //         }else{
                                
                            //             $total_fees = '';
                            //             //$course_name = '';  
                            //             $i++;  
                            //         }
                                    
                            //     }
        
                            // }else{
                            //     $courses = '';
                            // }

                            $courses_multipal = $this->security->xss_clean($this->input->post('course'));
                            if($courses_multipal){
                               // $courses = implode(',', $courses_multipal);
                
                               //    $this->enquiry_model->getCourseInfo($id);
                
                               //     print_r($courses_multipal);
                               //     exit;
                
                                  $course_name = explode(',', $courses_multipal);

                                  $trimmedArray = array_map('trim', $course_name);
                
                                   $getallcourseidbycoursename = $this->enquiry_model->getallcourseidbycoursename($trimmedArray);
                
                                    // $course_ids    =   explode(',', $courses_multipal);
                                    $course_ids    =   $getallcourseidbycoursename ;
                
                                    $total_fees = 0;
                                    $course_name = '';
                                    $i = 1;
                                    $courses='';
                                    foreach($course_ids as $id)
                                    {
                                       $courses .= $id['courseId'] . ','; 
                
                                       $get_course_fees =  $this->enquiry_model->getCourseInfo($id['courseId']);
                                        if($get_course_fees){
                                            
                                            $total_fees += $get_course_fees[0]->course_total_fees;
                                            //$course_name .= $i.') '.$get_course_fees[0]->course_name.'&nbsp&nbsp( Rs '.$get_course_fees[0]->course_total_fees. ') <br> ';  
                                            $i++;   
                                    
                                        }else{
                                    
                                            $total_fees = '';
                                            //$course_name = '';  
                                            $i++;  
                                        }
                                        
                                    }
                
                
                            }else{
                                $courses = '';
                            }
                

                            $result_courses = rtrim($courses, ','); 

                            /*check If enquiry name is unique*/
                            $data = array(
                                'enq_fullname' => ucwords($this->input->post('full_name')),
                                'enq_mobile'=> $this->input->post('mobile_no'),
                                //'enq_mobile1' => $this->input->post('alternate_mobile'),
                                'enq_email'=> $this->input->post('email'),
                                //'enq_email1' => $this->input->post('alternamte_email'),
                                'enq_qualification' => $this->input->post('qualification'),
                                //'enq_purpose' => $this->input->post('purpose'),
                                'enq_date' => date('Y-m-d', strtotime($this->input->post('enq_date'))),
                                //'enq_country'=> $this->input->post('country'),
                                //'enq_state'=>$this->input->post('state'),
                                'enq_city'=>$this->input->post('city'),
                                'enq_source'=>$this->input->post('enquiry_type'),
                                //'enq_remark' => $this->input->post('remarks'),
                                'total_payment' =>$total_fees,
                                'final_amount' =>$total_fees,
                                'enq_course_id' => $result_courses,
                                'doctor_non_doctor'=>$this->input->post('doctor_non_doctor'),
                                'counsellor_id' => $this->input->post('counsellor'),
                            );

                            
                            // if($id == null)
                            // {
                            //     $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname(trim($this->input->post('full_name')));
                            // }
                            // else
                            // {
                            //     $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname_update($id, trim($this->input->post('full_name')));
                            // }

                            // $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname_update($enq_id, trim($this->input->post('mobile_no')));
                            // //$check_uniqe =  $this->enquiry_model->checkuniqeenquiryname(trim($this->input->post('full_name')));

                            // if($check_uniqe){
                            
                              $saveEnquirydata = $this->enquiry_model->saveEnquirydata($enq_id,$data);
                              if($saveEnquirydata){
                                  $createenquiry_response['status'] = 'success';
                                  $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')),'counsellor'=>strip_tags(form_error('counsellor')));
                              }
                          
                            // }else{

                            //    $createenquiry_response['status'] = 'failure';
                            //    $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('mobile_no')), 'mobile_no'=>'Mobile no Already Exists', 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')),'counsellor'=>strip_tags(form_error('counsellor')));
                            // }

                }else{
                    $createenquiry_response['status'] = 'failure';
                    $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'enquiry_type'=>strip_tags(form_error('enquiry_type')),'course'=>'Course Required','remarks'=>strip_tags(form_error('remarks')),'counsellor'=>strip_tags(form_error('counsellor')));
              }
            }
            
    
            echo json_encode($createenquiry_response);
        }

    }


    /*class for create Add Course*/
    public function createcourse(){
        $post_submit = $this->input->post();
        if(!empty($post_submit)){

            $createcourse_response = array();

            if($this->input->post('fees')){
                $fess  = $this->input->post('fees');
            }else{
                $fess  = 0;
            }

            if($this->input->post('course_cert_cost')){
                $certificate_cost  = $this->input->post('course_cert_cost');
            }else{
                $certificate_cost  = 0;
            }

            if($this->input->post('course_onetime_adm_fees')){
                $one_time_admission_fees  = $this->input->post('course_onetime_adm_fees');
            }else{
                $one_time_admission_fees  = 0;
            }


            if($this->input->post('course_kit_cost')){
                $kit_cost  = $this->input->post('course_kit_cost');
            }else{
                $kit_cost  = 0;
            }

            // $total_course_fees  = $this->input->post('total_course_fees');

            // $sgst_tax  = $this->input->post('sgst_tax');
            // $sgst_tax_value  = $this->input->post('sgst');
            
            // $cgst_tax  = $this->input->post('cgst_tax');
            // $cgst_tax_value   = $this->input->post('cgst');


            $value_before_tax = $fess +  $certificate_cost +  $one_time_admission_fees + $kit_cost;

            $total_tax = $value_before_tax * 18 / 118;

            $sgst_tax_value = $total_tax / 2;
            $cgst_tax_value = $total_tax / 2;

            $sgst_tax  = 9;
            $cgst_tax  = 9;

            $total_course_fees  = $value_before_tax;

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
                'course_cert_cost' => $certificate_cost,
                'course_kit_cost'=>  $kit_cost,
                'course_onetime_adm_fees'=>$one_time_admission_fees,
                'course_books'=>$this->input->post('course_books'),
                //'course_remark' => $this->input->post('remarks'),
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
            $this->form_validation->set_rules('course_type', 'Certificate Type', 'trim');
            //$this->form_validation->set_rules('description', 'Description', 'trim');
            $this->form_validation->set_rules('certificate_cost', 'Certificate cost', 'trim|numeric');
            $this->form_validation->set_rules('one_time_admission_fees', 'One Time Admission Fees', 'trim|numeric');
            $this->form_validation->set_rules('kit_cost', 'Kit Cost', 'trim|numeric');
            $this->form_validation->set_rules('course_books', 'Course Books', 'trim');
            //$this->form_validation->set_rules('remarks', 'remarks', 'trim');
            $this->form_validation->set_rules('total_course_fees', 'Total Course Fees', 'trim');
            $this->form_validation->set_rules('course_mode', 'Course_mode', 'trim');

            if($this->input->post('course_mode_online')!=1 && $this->input->post('course_mode_offline')!=1){
                $required_checkbox = 'Course Mode Required';
            }else{
                $required_checkbox = '';
            }

            if($this->form_validation->run() == FALSE){
                $createcourse_response['status'] = 'failure';
                $createcourse_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'fees'=>strip_tags(form_error('fees')), 'course_type'=>strip_tags(form_error('course_type')), /*'description'=>strip_tags(form_error('description')),*/'certificate_cost'=>strip_tags(form_error('certificate_cost')),'kit_cost'=>strip_tags(form_error('kit_cost')),'one_time_admission_fees'=>strip_tags(form_error('one_time_admission_fees')),'course_books'=>strip_tags(form_error('course_books')),'course_mode'=>$required_checkbox);
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

    /*class for create Edit Course*/
    public function updatecourse(){

        $post_submit = $this->input->post();
        $courseId = $this->input->post('courseid');
        if(!empty($post_submit)){

            $createcourse_response = array();

            if($this->input->post('fees')){
                $fess  = $this->input->post('fees');
            }else{
                $fess  = 0;
            }

            if($this->input->post('course_cert_cost')){
                $certificate_cost  = $this->input->post('course_cert_cost');
            }else{
                $certificate_cost  = 0;
            }

            if($this->input->post('course_onetime_adm_fees')){
                $one_time_admission_fees  = $this->input->post('course_onetime_adm_fees');
            }else{
                $one_time_admission_fees  = 0;
            }


            if($this->input->post('course_kit_cost')){
                $kit_cost  = $this->input->post('course_kit_cost');
            }else{
                $kit_cost  = 0;
            }

           // $total_fess_cost = $fess + $certificate_cost + $one_time_admission_fees + $kit_cost;

            // $total_course_fees  = $this->input->post('total_course_fees');

            // $sgst_tax  = $this->input->post('sgst_tax');
            // $sgst_tax_value  = $this->input->post('sgst');
            
            // $cgst_tax  = $this->input->post('cgst_tax');
            // $cgst_tax_value   = $this->input->post('cgst');


            // $total_course_fees  = 0;

            // $sgst_tax  = 0;
            // $sgst_tax_value  = 0;
            
            // $cgst_tax  = 0;
            // $cgst_tax_value   = 0;

            $value_before_tax = $fess +  $certificate_cost +  $one_time_admission_fees + $kit_cost;

            $total_tax = $value_before_tax * 18 / 118;

            $sgst_tax_value = $total_tax / 2;
            $cgst_tax_value = $total_tax / 2;

            $sgst_tax  = 9;
            $cgst_tax  = 9;

            $total_course_fees  = $value_before_tax;

        
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

            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'course_fees'=> $this->input->post('fees'),
                'course_type_id' => $this->input->post('course_type'),
                'trainer_id' => $this->input->post('trainer'),
                //'course_desc'=> $this->input->post('description'),
                'course_cert_cost' => $certificate_cost,
                'course_kit_cost'=> $kit_cost,
                'course_onetime_adm_fees'=>$one_time_admission_fees,
                'course_books'=>$this->input->post('course_books'),
                //'course_remark' => $this->input->post('remarks'),
                'course_mode_online'=>$course_mode_online,
                'course_mode_offline'=>$course_mode_offline,
                'course_cgst' => $cgst_tax,
                'course_cgst_tax_value' => $cgst_tax_value,
                'course_sgst' => $sgst_tax,
                'course_sgst_tax_value' => $sgst_tax_value,
                'course_total_fees' => $total_course_fees
            );

            $this->form_validation->set_rules('courseid', 'courseId', 'trim|required');
            $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
            $this->form_validation->set_rules('fees', 'Fees', 'trim|required|numeric');
            $this->form_validation->set_rules('course_type', 'Certificate Type', 'trim|required');
            //$this->form_validation->set_rules('description', 'Description', 'trim');
            $this->form_validation->set_rules('course_cert_cost', 'Certificate cost', 'trim|numeric');
            $this->form_validation->set_rules('one_time_admission_fees', 'One Time Admission Fees', 'trim|numeric');
            $this->form_validation->set_rules('course_kit_cost', 'Kit Cost', 'trim|numeric');
            $this->form_validation->set_rules('course_books', 'Course Books', 'trim');
            //$this->form_validation->set_rules('remarks', 'remarks', 'trim');

            
            if($this->form_validation->run() == FALSE){
                $createcourse_response['status'] = 'failure';
                $createcourse_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'fees'=>strip_tags(form_error('fees')), 'course_type'=>strip_tags(form_error('course_type')), /*'description'=>strip_tags(form_error('description')),*/'certificate_cost'=>strip_tags(form_error('certificate_cost')),'kit_cost'=>strip_tags(form_error('kit_cost')),'one_time_admission_fees'=>strip_tags(form_error('one_time_admission_fees')),'course_books'=>strip_tags(form_error('course_books')));
            }else{

                // if($this->input->post('course_mode_online')!=1){
                //  $required_checkbox = '';
              
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

            // }else{
            //     $required_checkbox = 'Course Mode Required';
            //     $createcourse_response['status'] = 'failure';
            //     $createcourse_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'fees'=>strip_tags(form_error('fees')), 'course_type'=>strip_tags(form_error('course_type')), /*'description'=>strip_tags(form_error('description')),*/'certificate_cost'=>strip_tags(form_error('certificate_cost')),'kit_cost'=>strip_tags(form_error('kit_cost')),'one_time_admission_fees'=>strip_tags(form_error('one_time_admission_fees')),'course_books'=>strip_tags(form_error('course_books')),'course_mode'=>$required_checkbox);
         
            // }

            }
    
            echo json_encode($createcourse_response);
        }
    }

    /*class for createcoursetype*/
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

    /*class for updatcoursetype*/
    public function updatcoursetype(){

        $post_submit = $this->input->post();
        $coursetypeid =  $this->input->post('coursetypeid');

        if(!empty($post_submit)){

            $update_response = array();

            $data = array(
                'ct_name' => $this->input->post('course_type_name')
            );

            $this->form_validation->set_rules('course_type_name', 'Certificate Type', 'trim|required');

            if($this->form_validation->run() == FALSE){
                $update_response['status'] = 'failure';
                $update_response['error'] = array('course_type_name'=>strip_tags(form_error('course_type_name')));
            }else{

                /*check If course name is unique*/
                if($coursetypeid == null)
                {
                    $check_uniqe =  $this->course_model->checkquniqecoursetypename(trim($this->input->post('course_type_name')));
                }
                else
                {
                    $check_uniqe =  $this->course_model->checkquniqecoursetypename_update($coursetypeid, trim($this->input->post('course_type_name')));
                }
                
                if($check_uniqe){
                    $update_response['status'] = 'failure';
                    $update_response['error'] = array('course_type_name'=>'Certificate Type Already Exist');
                }else{
                    $saveCoursetypedata = $this->course_model->saveCoursetypedata($coursetypeid,$data);
                    if($saveCoursetypedata){
                        $update_response['status'] = 'success';
                        $update_response['error'] = array('course_type_name'=>'');
                    }
                }
            }
    
            echo json_encode($update_response);
        }

    }

    /*class for create updateenquiry*/
    public function updateprofile(){

        $post_submit = $this->input->post();
        $userId = $this->input->post('userid');

        if(!empty($post_submit)){
            $profileupdate_response = array();

            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric|greater_than[0]|exact_length[10]');
            if($this->input->post('new_password') && $this->input->post('confirm_password')){
                $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
            }

            if($this->form_validation->run() == FALSE){
                $profileupdate_response['status'] = 'failure';
                $profileupdate_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'username'=>strip_tags(form_error('username')), 'mobile'=>strip_tags(form_error('mobile')), 'password'=>strip_tags(form_error('password')),'new_password'=>strip_tags(form_error('new_password')),'confirm_password'=>strip_tags(form_error('confirm_password')));
            }else{


                if(!empty($_FILES['profile_photo']['name'])){

                    $file = rand(1000,100000)."-".$_FILES['profile_photo']['name'];
                    $filename = str_replace(' ','_',$file);
    
                    $config['upload_path'] = 'uploads/profile_pic'; 
                    $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                    $config['max_size'] = '100000'; // max_size in kb 
                    $config['file_name'] = $filename; 
           
                    // Load upload library 
                    $this->load->library('upload',$config); 
            
                    // File upload
                    if($this->upload->do_upload('profile_photo')){ 
                       $profile_pic = $filename; 
                    }else{
                        $profile_pic =trim($this->input->post('existing_img'));
                    }
    
                }else{
                    $profile_pic = trim($this->input->post('existing_img'));
    
                }



                if($this->input->post('new_password') && $this->input->post('confirm_password')){

                    $password = $this->input->post('new_password');

                    $data = array(
                        'name'      => $this->input->post('full_name'),
                        'email'     => $this->input->post('email'),
                        'mobile'    => $this->input->post('mobile'),
                        'password'  => base64_encode($password),
                        'profile_pic' => $profile_pic,
                        'username'   => trim($this->input->post('username'))
                    );

                }else{
                    $data = array(
                        'name'      => $this->input->post('full_name'),
                        'email'     => $this->input->post('email'),
                        'mobile'    => $this->input->post('mobile'),
                        'profile_pic' => $profile_pic,
                        'username'   => trim($this->input->post('username'))
                    );
                }

                    $saveUserdata = $this->user_model->saveUserdata($userId,$data);
                    if($saveUserdata){
                            $profileupdate_response['status'] = 'success';
                            $profileupdate_response['error'] = array('full_name'=>'', 'username'=>'', 'mobile'=>'', 'password'=>'','new_password'=>'','confirm_password'=>'');
                            $profileupdate_response['data'] = array('full_name'=>$this->input->post('full_name'), 'username'=>trim($this->input->post('username')), 'mobile'=>$this->input->post('mobile'), 'password'=>'','new_password'=>'','confirm_password'=>'','profile_pic'=>$profile_pic,'email'=>$this->input->post('email'));

                        }
            }
            echo json_encode($profileupdate_response);
        }

    }


    public function paymentdetails(){

        $post_submit = $this->input->post();
        if(!empty($post_submit)){
                $payment_details = array();
                $id=$this->input->post('enq_id');
                $payment_details['followDataenquiry'] = $this->Api_model->getEnquiryInfo($id);
                $payment_details['getEnquirypaymentInfo'] = $this->Api_model->getEnquirypaymentInfo($id);
                $payment_details['gettotalpaidEnquirypaymentInfo'] = $this->Api_model->gettotalpaidEnquirypaymentInfo($id);
                $payment_details['getadditionalInfo'] = $this->Api_model->getadditionalInfo($id);
                $payment_details['status'] = 'success';
            echo json_encode($payment_details);
        }
    }


    public function getaddoncoursepaymentdetails(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $this->form_validation->set_rules('addoncourse_id', 'Addoncourse Id', 'trim|required');
        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')),'addoncourse_id' =>strip_tags(form_error('addoncourse_id')));
		}else{

            $add_on_course_data = $this->Api_model->getaddoncoursepaymentdetails(trim($this->input->post('addoncourse_id')));
            if($add_on_course_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $add_on_course_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }
    }


    public function sendPaymentLinkaddoncourse(){

        $post_submit = $this->input->post();
    
            if($post_submit){
                 $enq_id =trim($this->input->post('enq_id'));
                 $add_on_course_id =trim($this->input->post('add_on_course_id'));
                //$enq_id =38;
                 $get_equiry_data =  $this->enquiry_model->getEnquiryInfo($enq_id)[0];

                //  $course_ids    =   explode(',',$get_equiry_data->enq_course_id);
                
                 $total_fees = 0;
                 $course_name = ''; 
                 $course_name_without ='';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                        $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                        $total_fees += $get_course_fees[0]->course_total_fees;
                        $course_name .= $i.'-'.$get_course_fees[0]->course_name. ',';  
                        $course_name_without .= $get_course_fees[0]->course_name. ',';  
                        $i++;  
                    }
                $all_course_name = trim($course_name, ', '); 


                $get_final_amount_of_add_on_course =  $this->enquiry_model->get_final_amount_of_add_on_course($enq_id,$add_on_course_id);

                $final_course_amount = $get_final_amount_of_add_on_course['course_total_fees'] - $get_final_amount_of_add_on_course['discount'];

                $all_course_name =$get_final_amount_of_add_on_course['course_name'];


                $get_equiry_datapayment_transaction =  $this->enquiry_model->gettotalpaidamountof_add_on_course($add_on_course_id,$enq_id);
                
                $get_equiry_datapayment =  $final_course_amount;

             
               
                if($get_equiry_datapayment_transaction){
                    $total_paybal = $get_equiry_datapayment - $get_equiry_datapayment_transaction[0]->totalpaidamount;


                }else{
                    $total_paybal  = $get_equiry_datapayment;
                }


                $to = $get_equiry_data->enq_email;
                $email_name ='IICTN-Payment Link';
                $Subject = 'IICTN - Admission Payment Link '.date('Y-m-d H:i:s');
                $Body  = '   <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                                <title>Invoice details</title>
                                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                            </head>
                
                            <body style="margin: 0; padding: 0; background-color:#eaeced " bgcolor="#eaeced">
                            <table bgcolor="#eaeced" cellpadding="0" cellspacing="0" width="100%" style="background-color: #eaeced; ">
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            <tr>
                                <td>
                                <table align="center" bgcolor="#ffffff" cellpadding="20" cellspacing="0" width="600" 
                                        style="border-collapse: collapse; background-color: #ffffff; border: 1px solid #f0f0f0;">
                                    <tr style="border-top: 4px solid #ca9331;">
                                    <td align="left" style="padding: 15px 20px 20px;">
                                    <table width="100%">
                                        <tr>
                                        <td><img  src="https://iictn.in/assets/img/logos/iictn_lms.png" width="130px" height="130px" alt="Company Logo"/></td>
                                        <td align="right">
                                            <span>Inquiry Number: '.$get_equiry_data->enq_number.'</span><br>
                                            <span style="padding: 5px 0; display: block;">'.$get_equiry_data->enq_date.'</span>
                                        </td>
                                        </tr>
                                    </table>
                                    
                                    </td>
                                    </tr>
                                    <tr>
                                    <td align="center" style="padding: 20px; border-top: 1px solid #f0f0f0; background: #fafafa;,; ">
                                    <div>Total Course Fee:</div>
                                    <h2 style="margin: 10px 0; color: #333; font-weight: 500; font-size: 48px;">
                                    ₹  '.$total_paybal.'
                                    </h2>
                                    <div style="line-height: 1.4; font-size: 1.2; font-size: 14px; color: #777;"></div>
                                    </td>
                                    </tr>

                                    <tr style="">
                                    <td align="center" style="padding: 15px 20px 20px;">
                                    <table width="80%">
                                        <tr>
                                        <td><b>Full Name</b></td>
                                        <td>'.$get_equiry_data->enq_fullname.'</td>
                                        </tr>

                                        <tr>
                                        <td><b>Mobile Number</b></td>
                                        <td>'.$get_equiry_data->enq_mobile.'</td>
                                        </tr>

                                        <tr>
                                        <td><b>Email id</b></td>
                                        <td>'.$get_equiry_data->enq_email.'</td>
                                        </tr>

                                        <tr>
                                        <td><b>Course</b></td>
                                        <td>'.$all_course_name.'</td>
                                        </tr>
                                    </table>
                                    </td>
                                    </tr>

                                    <tr>
                                    <td align="center" style="padding: 20px 40px;font-size: 16px;line-height: 1.4;color: #333;">
                                    <div> </div>
                                    <div><br></div>
                                    <div style="background: #ca9331; display: inline-block;padding: 15px 25px; color: #fff; border-radius: 6px">

                                    <a href="https://iictn.in/payment/pay.php?enq='.$get_equiry_data->enq_number.'&&add_on_course_id='.$add_on_course_id.'" class="btn btn-sm btn-primary float-right pay_now"
                                    data-amount="1000" data-id="1">Pay Now</a>
                                    
                                    </div>
                                    <div style="color: #777; padding: 5px;"></div>
                                    <div><br></div>
                                    </td>
                                    </tr>
                                    <tr style="border-top: 1px solid #eaeaea;">
                                    <td align="center">
                                        <div style="font-size: 14px;line-height: 1.4;color: #777;">
                                        Regards,<br>
                                        IICTN
                                    </div>
                                    </td>
                                    </tr>
                                </table>
                                
                                </td>
                            </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            </body>
                    </html>';

                    // $to = "hemantkaturde123@gmail.com";
                    // $subject = "This is subject";
                    
                    // $message = "<b>This is HTML message.</b>";
                    // $message .= "<h1>This is headline.</h1>";
                    
                    $header = "From: IICTN-Payment Link <admin@iictn.in> \r\n";
                    //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";
                    
                    $retval = mail($to,$Subject,$Body,$header);
                    //$retval =  sendmail($to,$Subject,$Body,$email_name,$attachmentList="");
                    //$retval=1;
                if($retval){


                    //  /* Send Whats App  Start Here */
                    //  $curl = curl_init();
                      $text = 'Greetings from IICTN !!,  Thank You for your interest in '.$all_course_name;
                      $text .= ', Attached is the Payment Link, Once Payment done you will receive  payment receipt https://iictn.in/payment/pay.php?enq='.$get_equiry_data->enq_number;
                      //$text = 'Dear '.$enq_fullname.' Thank You for your interest in '.$all_course_name.', We have attached the brochure and Syllabus for your reference. Feel free to contact us back, we will be delighted to assist and guide you.For more details, you can also visit our website www.iictn.org';      
                      $mobile = '+91'.$get_equiry_data->enq_mobile;
                    
                      $whatsaptype = 'payment_link';
                      $url = ' https://iictn.in/payment/pay.php?enq='.$get_equiry_data->enq_number;
                      $Brochure_link ='';
                      $Syllabus ='';

                      $send_wp_sms_media_text =  sendwhatsapp($all_course_name,$Brochure_link,$Syllabus,$url,$mobile,$whatsaptype); 
                      
                    

                    $process = 'Enquiry Link Sent';
                    $processFunction = 'Enquiry/sendEnquiryLink';
                    $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            }else{
                echo(json_encode(array('status'=>FALSE)));

            }
    }


    public function addaddondiscountpayment(){

        $post_submit = $this->input->post();

        if($post_submit){
            $add_addon_discount_response = array();
            $this->form_validation->set_rules('discount_amount', 'Discount Amount', 'trim|required');
            if($this->form_validation->run() == FALSE){
                $add_addon_discount_response['status'] = 'failure';
                $add_addon_discount_response['error'] = array('discount_amount'=>strip_tags(form_error('discount_amount')));
            }else{

                $add_discount_tarnsaction_id = trim($this->input->post('addoncourse_id'));

                $data = array(
                    'discount'=> trim($this->input->post('discount_amount')),
                );

                $save_Add_on_courses_discounr = $this->enquiry_model->save_addon_discount_payment($add_discount_tarnsaction_id ,$data);
                if($save_Add_on_courses_discounr){
                    $add_addon_discount_response['status'] = 'success';
                    $add_addon_discount_response['error'] = array('course'=>'', 'enquiry_id'=>'');
                }

            }

            echo json_encode($add_addon_discount_response);
        }
    }

     /*Course List*/
    public function getcertificatetypelist(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $courseList_data = $this->Api_model->getcertificatetypelist();
            if($courseList_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $courseList_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }


    public function sendBrochureLink(){
        $post_submit = $this->input->post();

            if($post_submit){

                $enq_id =$post_submit['enq_id'];
                $get_equiry_data =  $this->enquiry_model->getEnquiryInfo($enq_id)[0];

                 $doctor_non_doctor = $get_equiry_data->doctor_non_doctor;
                 $course_ids    =   explode(',',$get_equiry_data->enq_course_id);
                
                 $total_fees = 0;
                 $course_name = '';
                 $doc_url_val ='';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                        $get_course_fees =  $this->enquiry_model->getCourseInfo($id);

                        $total_fees += $get_course_fees[0]->course_total_fees;
                        $course_name .= $get_course_fees[0]->course_name. ',';

                        /*For Attchment*/
                        $getSyllabusData = $this->enquiry_model->getSyllabusData($id);

                        foreach($getSyllabusData as $doc_url)
                        {
                            $doc_url_val .= $doc_url->doc_url. ',';
                        }

                        $i++;  
                    }

                    $all_course_name = trim($course_name, ', '); 
                    $all_doc_url_val = trim($doc_url_val, ', '); 

                    if($all_doc_url_val){
                        $syallabus_urls = '<div>
                            <p><b>Download Below Syllabus<b></p>
                            <p>'.$all_doc_url_val.'</p>
                       </div>';
                    }else{
                        $syallabus_urls = '';
                    }

                    $to = $get_equiry_data->enq_email;
                    $from = 'admin@iictn.in'; 
                    $fromName = 'IICTN'; 
                    $enq_fullname = $get_equiry_data->enq_fullname;
                    $email_name ='IICTN Admin '.date('Y-m-d H:i:s');

                    //$email_name ='IICTN-Marketing Material '.date('Y-m-d H:i:s');
                    //$subject = 'IICTN - Marketing Material '.date('Y-m-d H:i:s');
                    $subject = ' IICTN Brochure and Syllabus for '.$enq_fullname;
                    
                   // $header = "From: IICTN-Mumbai Marketing Material <admin@iictn.in> \r\n";
                    $header = "From: IICTN-Admin <admin@iictn.in> \r\n";
                    //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";

                     if($doctor_non_doctor=='Doctor'){
                        $file_path ='<a href="https://iictn.in/markating_material/Doctors_Brochure.pdf">Doctors Brochure </a>';
                        $wp_url = 'https://iictn.in/markating_material/Doctors_Brochure.pdf';
                     }else{
                        $file_path =' <a href="https://iictn.in/markating_material/Non_Doctors_Brochure.pdf">Non Doctors_Brochure </a>';
                        $wp_url = 'https://iictn.in/markating_material/Non_Doctors_Brochure.pdf';
                     }

                   /// $body = '<div> <p><b>Greetings from IICTN !!</b></p>

                    $body = '<div>
                        <p><b>Dear </b> '.$enq_fullname.', </p>
                        <p>Thank You for your interest in <b>'.$all_course_name.'.</b></p>
                        <p>We have attached the brochure and Syllabus for your reference. Feel free to contact us back, we will be delighted to assist and guide you.</p>
                        <p>For more details, you can also visit our website <a href="https://iictn.org/" rel="noopener" target="_blank" >www.iictn.org </a></p>
                        </div>
                        <div>
                             <p><b>Download Below Brochure<b></p>
                             <p>'.$file_path.'</p>
                        </div>
                          '.$syallabus_urls.'
                        <div>
                            <p><b>Thanks & Regards<b></p>
                            <p><b>Team IICTN</b></p>
                        </div>'; 
        
                    //$retval = mail($to,$subject,$htmlContent,$header);
                    //$retval =  sendmail($to,$subject,$body,$email_name,$attachmentList="");

                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    // Additional headers
                    $headers .= 'From: admin@iictn.in' . "\r\n";
                    $retval = mail($to,$subject,$body,$header);

                    //$retval =  1;
                    if($retval){

                        /*Welcome Notification on whatsapp*/
                        $mobile = '+91'.$get_equiry_data->enq_mobile;                      
                        // $text = 'Greetings from IICTN !!,  Thank You for your interest in '.$all_course_name;
                        // $data = ["number" => $mobile,"type" => "text","message" => $text,"instance_id" => INSTANCE_ID,"access_token" => ACCESS_TOKEN];
                        // $jsonData = json_encode($data);
                        // $send_wp_sms_welcomenoti_text =  sendwhatsapp($mobile,$jsonData);

                        /* Media Link Whatsaap*/
                        //  $media = 'Greetings from IICTN !!,  Thank You for your interest in '.$all_course_name.'.';
                        // $media.=' We have attached the brochure and Syllabus for your reference, Feel free to contact us back, we will be delighted to assist and guide you. For more details you can also visit our website www.iictn.org';
                        $Brochure_link =' :'.$wp_url;

                        if($all_doc_url_val){
                            $Syllabus =' :'.$all_doc_url_val;
                        }else{
                            $Syllabus ='';
                        }

                        $whatsaptype = 'markating_material';
                        $url ='';
                     
                        $send_wp_sms_media_text =  sendwhatsapp($all_course_name,$Brochure_link,$Syllabus,$url,$mobile,$whatsaptype);  

                         /* End here  Send Whats App */
                        $process = 'Enquiry Link Sent';
                        $processFunction = 'Enquiry/sendEnquiryLink';
                        $this->logrecord($process,$processFunction);
                        echo(json_encode(array('status'=>'success')));
                    }

            }else{
                echo(json_encode(array('status'=>FALSE)));

            }
    }


    public function sendPaymentLink(){

        $post_submit = $this->input->post();
    
            if($post_submit){
                 $enq_id =$post_submit['enq_id'];
                //$enq_id =38;
                $get_equiry_data =  $this->enquiry_model->getEnquiryInfo($enq_id)[0];

                 $course_ids    =   explode(',',$get_equiry_data->enq_course_id);
                
                 $total_fees = 0;
                 $course_name = ''; 
                 $course_name_without ='';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                        $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                        $total_fees += $get_course_fees[0]->course_total_fees;
                        $course_name .= $i.'-'.$get_course_fees[0]->course_name. ',';  
                        $course_name_without .= $get_course_fees[0]->course_name. ',';  
                        $i++;  
                    }
                $all_course_name = trim($course_name, ', '); 
                $get_equiry_datapayment_transaction =  $this->enquiry_model->gettotalpaidEnquirypaymentInfo($enq_id);
                $get_equiry_datapayment =  $get_equiry_data->final_amount;
                if($get_equiry_datapayment_transaction){
               
                    $total_paybal =$get_equiry_datapayment - $get_equiry_datapayment_transaction[0]->totalpaidAmount;

                }else{
                    $total_paybal  =$get_equiry_datapayment;
                }

            
                $to = $get_equiry_data->enq_email;
                $email_name ='IICTN-Payment Link';
                $Subject = 'IICTN - Admission Payment Link '.date('Y-m-d H:i:s');
                $Body  = '   <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                                <title>Invoice details</title>
                                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                            </head>
                
                            <body style="margin: 0; padding: 0; background-color:#eaeced " bgcolor="#eaeced">
                            <table bgcolor="#eaeced" cellpadding="0" cellspacing="0" width="100%" style="background-color: #eaeced; ">
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            <tr>
                                <td>
                                <table align="center" bgcolor="#ffffff" cellpadding="20" cellspacing="0" width="600" 
                                        style="border-collapse: collapse; background-color: #ffffff; border: 1px solid #f0f0f0;">
                                    <tr style="border-top: 4px solid #ca9331;">
                                    <td align="left" style="padding: 15px 20px 20px;">
                                    <table width="100%">
                                        <tr>
                                        <td><img  src="https://iictn.in/assets/img/logos/iictn_lms.png" width="130px" height="130px" alt="Company Logo"/></td>
                                        <td align="right">
                                            <span>Inquiry Number: '.$get_equiry_data->enq_number.'</span><br>
                                            <span style="padding: 5px 0; display: block;">'.$get_equiry_data->enq_date.'</span>
                                        </td>
                                        </tr>
                                    </table>
                                    
                                    </td>
                                    </tr>
                                    <tr>
                                    <td align="center" style="padding: 20px; border-top: 1px solid #f0f0f0; background: #fafafa;,; ">
                                    <div>Total Course Fee:</div>
                                    <h2 style="margin: 10px 0; color: #333; font-weight: 500; font-size: 48px;">
                                    ₹  '.$total_paybal.'
                                    </h2>
                                    <div style="line-height: 1.4; font-size: 1.2; font-size: 14px; color: #777;"></div>
                                    </td>
                                    </tr>

                                    <tr style="">
                                    <td align="center" style="padding: 15px 20px 20px;">
                                    <table width="80%">
                                        <tr>
                                        <td><b>Full Name</b></td>
                                        <td>'.$get_equiry_data->enq_fullname.'</td>
                                        </tr>

                                        <tr>
                                        <td><b>Mobile Number</b></td>
                                        <td>'.$get_equiry_data->enq_mobile.'</td>
                                        </tr>

                                        <tr>
                                        <td><b>Email id</b></td>
                                        <td>'.$get_equiry_data->enq_email.'</td>
                                        </tr>

                                        <tr>
                                        <td><b>Course</b></td>
                                        <td>'.$all_course_name.'</td>
                                        </tr>
                                    </table>
                                    </td>
                                    </tr>

                                    <tr>
                                    <td align="center" style="padding: 20px 40px;font-size: 16px;line-height: 1.4;color: #333;">
                                    <div> </div>
                                    <div><br></div>
                                    <div style="background: #ca9331; display: inline-block;padding: 15px 25px; color: #fff; border-radius: 6px">

                                    <a href="https://iictn.in/payment/pay.php?enq='.$get_equiry_data->enq_number.'" class="btn btn-sm btn-primary float-right pay_now"
                                    data-amount="1000" data-id="1">Pay Now</a>
                                    
                                    </div>
                                    <div style="color: #777; padding: 5px;"></div>
                                    <div><br></div>
                                    </td>
                                    </tr>
                                    <tr style="border-top: 1px solid #eaeaea;">
                                    <td align="center">
                                        <div style="font-size: 14px;line-height: 1.4;color: #777;">
                                        Regards,<br>
                                        IICTN
                                    </div>
                                    </td>
                                    </tr>
                                </table>
                                
                                </td>
                            </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            </body>
                    </html>';

                    // $to = "hemantkaturde123@gmail.com";
                    // $subject = "This is subject";
                    
                    // $message = "<b>This is HTML message.</b>";
                    // $message .= "<h1>This is headline.</h1>";
                    
                    $header = "From: IICTN-Payment Link <admin@iictn.in> \r\n";
                    //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";

                    $retval = mail($to,$Subject,$Body,$header);
                    //$retval =  sendmail($to,$Subject,$Body,$email_name,$attachmentList="");
                    //$retval=1;
                if($retval){

                    $text = 'Thank You for your interest in '.$course_name_without;
                    $text .= ', Attached is the Payment Link, Once Payment done you will receive  payment receipt https://iictn.in/payment/pay.php?enq='.$get_equiry_data->enq_number;
                      //$text = 'Dear '.$enq_fullname.' Thank You for your interest in '.$all_course_name.', We have attached the brochure and Syllabus for your reference. Feel free to contact us back, we will be delighted to assist and guide you.For more details, you can also visit our website www.iictn.org';      
                    $mobile = '+91'.$get_equiry_data->enq_mobile;

                    $whatsaptype = 'payment_link';

                    $url = ' https://iictn.in/payment/pay.php?enq='.$get_equiry_data->enq_number;
                  
                    $Brochure_link ='';
                    $Syllabus ='';

                    $send_wp_sms_media_text =  sendwhatsapp($course_name_without,$Brochure_link,$Syllabus,$url,$mobile,$whatsaptype); 
                    

                    $process = 'Enquiry Link Sent';
                    $processFunction = 'Enquiry/sendEnquiryLink';
                    $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            }else{
                echo(json_encode(array('status'=>FALSE)));

            }
    }

    public function sendManualAdmissionlink(){

        $post_submit = $this->input->post();
        
        if($post_submit){
                    $enq_id =$post_submit['enq_id'];
                    //$enq_id =38;
                    $get_equiry_data =  $this->enquiry_model->getEnquiryInfo($enq_id)[0];

                    $to = $get_equiry_data->enq_email;
                    $from = 'admin@iictn.in'; 
                    $email_name ='IICTN - Admission Link '.date('Y-m-d H:i:s');
                    $fromName = 'IICTN'; 
                    $enq_fullname = $get_equiry_data->enq_fullname;
                    $subject = 'IICTN - Admission Link '.date('Y-m-d H:i:s');
                    
                    $header = "From: Admission Link <admin@iictn.in> \r\n";
                    //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";

                    $body = '<div><p><b>Dear </b> '.$enq_fullname.',</p><p>Please Follow Below Admission Link.</p></div><div><p><b>Admission Link<b></p><p>https://iictn.in/registration/new-registration-student.php?enq='.$enq_id.'</p></div>'; 

                    //$retval =  sendmail($to,$subject,$body,$email_name,$attachmentList="");
                    $header = "From: IICTN - Admission Link <admin@iictn.in> \r\n";
                    //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";

                    $retval = mail($to,$subject,$body,$header);

                    if($retval){
                        /* Send Whats App  Start Here */
                        //  $curl = curl_init();
                        $text = 'Admission Link';
                        $text .= ' https://iictn.in/registration/new-registration-student.php?enq='.$enq_id;
                        //$text = 'Dear '.$enq_fullname.' Thank You for your interest in '.$all_course_name.', We have attached the brochure and Syllabus for your reference. Feel free to contact us back, we will be delighted to assist and guide you.For more details, you can also visit our website www.iictn.org';      
                        $mobile = '+91'.$get_equiry_data->enq_mobile;
                    
                        $whatsaptype = 'admission_link';

                        $url = ' https://iictn.in/registration/new-registration-student.php?enq='.$enq_id;
                        $Brochure_link ='';
                        $Syllabus ='';
                        $send_wp_sms_media_text =  sendwhatsapp($course_name_without,$Brochure_link,$Syllabus,$url,$mobile,$whatsaptype); 
                        
                        //  if(json_decode($send_wp_sms)->status="success"){
                                $process = 'Enquiry Link Sent';
                                $processFunction = 'Enquiry/sendEnquiryLink';
                                $this->logrecord($process,$processFunction);
                                echo(json_encode(array('status'=>'success')));
                        //    }else{
                        //         echo(json_encode(array('status'=>'failure','error_sms'=>'wp sms not send')));
                        //    }

                    }
        }else{
            echo(json_encode(array('status'=>FALSE)));

        }

    }

    public function gettimetablelist(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $this->form_validation->set_rules('course_id', 'course_id', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $timetableList_data = $this->Api_model->gettimetableList($this->input->post('userid'),$this->input->post('user_flag'),$this->input->post('course_id'));
            if($timetableList_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $timetableList_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }
    }


    public function gettimetabledetailslist(){

        
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $this->form_validation->set_rules('timetable_id', 'Timetable Id', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')),'timetable_id'=>strip_tags(form_error('user_flag')));
        }else{
            $timetableList_data = $this->Api_model->gettimetabledetailslist($this->input->post('timetable_id'),$this->input->post('user_flag'),$this->input->post('userid'));
            if($timetableList_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $timetableList_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }


    }

   public function getchapterslist(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')),'course_id'=>strip_tags(form_error('course_id')));
        }else{
            $chapter_data = $this->Api_model->getchapterslist($this->input->post('course_id'),$this->input->post('user_flag'),$this->input->post('userid'));
            if($chapter_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $chapter_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }


   }


   public function getchaptersdocumentlist(){

    $userdetails = validateServiceRequest();
    $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
    $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
    $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required');
    $this->form_validation->set_rules('topic_id', 'Topic Id', 'trim|required');
    $this->form_validation->set_rules('doc_type', 'Doc Type ', 'trim|required');


    $post_submit = $this->input->post();
    if ($this->form_validation->run() == FALSE)
    {
        $status = 'Failure';
        $message = 'Validation error';
        $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')),'course_id'=>strip_tags(form_error('course_id')),'topic_id'=>strip_tags(form_error('topic_id')),'doc_type'=>strip_tags(form_error('doc_type')));
    }else{
        $getchaptersdocumentlist = $this->Api_model->getchaptersdocumentlist($this->input->post('course_id'),$this->input->post('user_flag'),$this->input->post('userid'),$this->input->post('topic_id'),$this->input->post('doc_type'));
        if($getchaptersdocumentlist){
            $status = 'Success';
            $message = 'Data Found';
            $data = $getchaptersdocumentlist;
        }else{
            $status = 'Failure';
            $message = 'No Data Found';
            $data = '';   
        }
        $responseData = array('status' => $status,'message'=> $message,'data' => $data);
        setContentLength($responseData);
    }
   }


   public function getallstudentlist(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
        }else{
            $student_data = $this->Api_model->getallstudentlist($this->input->post('user_flag'),$this->input->post('userid'));
            if($student_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $student_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }
   }


   public function studentexamrequest(){

    $userdetails = validateServiceRequest();
    $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
    $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

    $post_submit = $this->input->post();
    if ($this->form_validation->run() == FALSE)
    {
        $status = 'Failure';
        $message = 'Validation error';
        $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
    }else{
        $exam_request_data = $this->Api_model->studentexamrequest($this->input->post('user_flag'),$this->input->post('userid'));
        if($exam_request_data){
            $status = 'Success';
            $message = 'Data Found';
            $data = $exam_request_data;
        }else{
            $status = 'Failure';
            $message = 'No Data Found';
            $data = '';   
        }
        $responseData = array('status' => $status,'message'=> $message,'data' => $data);
        setContentLength($responseData);
    }
   }


   public function getsyllabuslist(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')),'course_id'=>strip_tags(form_error('course_id')));
        }else{
            $getsyllabuslist_data = $this->Api_model->getsyllabuslist($this->input->post('course_id'),$this->input->post('user_flag'),$this->input->post('userid'));
            if($getsyllabuslist_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $getsyllabuslist_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }
   }


   public function getrolelist(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
        }else{
            $role_data = $this->Api_model->getUserRolesforappcreateuser($this->input->post('user_flag'),$this->input->post('userid'));
            if($role_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $role_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

   }


   public function createstaff()
   {
       $post_submit = $this->input->post();
       if(!empty($post_submit)){

           $createuser_response = array();

           if(!empty($_FILES['profile_photo']['name'])){

               $file = 'profile_'.rand().$_FILES['profile_photo']['name'];
               $filename = str_replace(' ','_',$file);

               $config['upload_path'] = 'uploads/profile_pic'; 
               $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
               $config['max_size'] = '1000000'; // max_size in kb 
               $config['file_name'] = $filename; 
      
               // Load upload library 
               $this->load->library('upload',$config); 
       
               // File upload
               if($this->upload->do_upload('profile_photo')){ 
                  $profile_pic = $filename; 
               }else{
                   $profile_pic ='';
               }

           }else{
               $profile_pic = '';

           }

           $data = array(
               'name'      => $this->input->post('name'),
               'email'     => $this->input->post('email'),
               'mobile'    => $this->input->post('mobile'),
               'password'  => base64_encode($this->input->post('password')),
               'roleId'    => $this->input->post('roleId'),
               'user_flag' => $this->input->post('user_flag_reg'),
               'profile_pic' => $profile_pic,
               'username'   => trim($this->input->post('username'))
           );

           $this->form_validation->set_rules('name', 'User Name', 'trim|required');
           $this->form_validation->set_rules('email', 'Email', 'trim|required');
           $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|numeric');
           $this->form_validation->set_rules('roleId', 'Role', 'trim|required');
           $this->form_validation->set_rules('password', 'Password', 'trim|required');
           $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
           $this->form_validation->set_rules('username', 'Username', 'trim|required');
           $this->form_validation->set_rules('userid', 'userId', 'trim|required');
           $this->form_validation->set_rules('user_flag_reg', 'user_flag', 'trim|required');


           if($this->form_validation->run() == FALSE){
               $createuser_response['status'] = 'failure';
               $createuser_response['error'] = array('name'=>strip_tags(form_error('name')), 'email'=>strip_tags(form_error('email')), 'mobile'=>strip_tags(form_error('mobile')), 'role'=>strip_tags(form_error('role')),'password'=>strip_tags(form_error('password')),'confirm_password'=>strip_tags(form_error('confirm_password')));
           }else{

               /*check If course name is unique*/
               $check_uniqe =  $this->user_model->checkquniqeusername('',trim($this->input->post('name')),$this->input->post('user_flag_reg'));
               $check_uniqe1 =  $this->user_model->checkEmailExists('',trim($this->input->post('email')),$this->input->post('user_flag_reg'));
               $check_uniqe2 =  $this->user_model->checkquniqemobilenumber('',trim($this->input->post('mobile')),$this->input->post('user_flag_reg'));


               if($check_uniqe){
                   $createuser_response['status'] = 'failure';
                   $createuser_response['error'] = array('name'=>'User Name Alreday Exits', 'email'=>'', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password' =>'');
               }
               else if($check_uniqe1){
                   $createuser_response['status'] = 'failure';
                   $createuser_response['error'] = array('name'=>'', 'email'=>'Email already Exist', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password' =>'');
               }
               else if($check_uniqe2){
                   $createuser_response['status'] = 'failure';
                   $createuser_response['error'] = array('name'=>'', 'email'=>'', 'mobile'=>'Mobile already Exist', 'role'=>'','password'=>'','confirm_password' =>'');
           
               }else{
                   $saveCoursedata = $this->user_model->saveUserdata('',$data);
                   if($saveCoursedata){
                       $createuser_response['status'] = 'success';
                       $createuser_response['error'] = array('name'=>'', 'email'=>'', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password'=>'');
                   }
               }
           }
   
           echo json_encode($createuser_response);
       }
   }

   public function updatestaff()
   {

       $post_submit = $this->input->post();
       if(!empty($post_submit)){

           $userId = $this->input->post('staffid');

           if(!empty($_FILES['profile_photo']['name'])){

               $file = 'profile_'.rand().$_FILES['profile_photo']['name'];
               $filename = str_replace(' ','_',$file);

               $config['upload_path'] = 'uploads/profile_pic'; 
               $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
               $config['max_size'] = '1000000'; // max_size in kb 

               
               $config['file_name'] = $filename; 
      
               // Load upload library 
               $this->load->library('upload',$config); 
       
               // File upload
               if($this->upload->do_upload('profile_photo')){ 
                  $profile_pic = $filename; 
               }else{
                   $profile_pic =trim($this->input->post('existing_img'));
               }

           }else{
               $profile_pic = trim($this->input->post('existing_img'));

           }

         

           $createuser_response = array();
           if(empty($this->input->post('password')))
           {
               $data = array(
                   'name'      => $this->input->post('name'),
                   'email'     => $this->input->post('email'),
                   'mobile'    => $this->input->post('mobile'),
                   'roleId'    => $this->input->post('roleId'),
                   'password'  => base64_encode($this->input->post('password')),
                   'user_flag' =>$this->input->post('user_flag_reg'),
                   'profile_pic' => $profile_pic,
                   'username'   => trim($this->input->post('username'))
               );
           }else{
               $data = array(
                   'name'      => $this->input->post('name'),
                   'email'     => $this->input->post('email'),
                   'mobile'    => $this->input->post('mobile'),
                   'password'  => base64_encode($this->input->post('password')),
                   'roleId'    => $this->input->post('roleId'),
                   'user_flag' =>$this->input->post('user_flag_reg'),
                   'profile_pic' => $profile_pic,
                   'username'   => trim($this->input->post('username'))
               );
           }

           $this->form_validation->set_rules('name', 'User Name', 'trim|required');
           $this->form_validation->set_rules('email', 'Email', 'trim|required');
           $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|numeric');
           $this->form_validation->set_rules('roleId', 'Role', 'trim|required');

        //    $this->form_validation->set_rules('userId', 'userId', 'trim|required');
           $this->form_validation->set_rules('user_flag_reg', 'user_flag', 'trim|required');

           if(!empty($this->input->post('password')))
           {
               $this->form_validation->set_rules('password', 'Password', 'trim|required');
               $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
           }            

           if($this->form_validation->run() == FALSE){
               $createuser_response['status'] = 'failure';
               $createuser_response['error'] = array('name'=>strip_tags(form_error('name')), 'email'=>strip_tags(form_error('email')), 'mobile'=>strip_tags(form_error('mobile')), 'role'=>strip_tags(form_error('role')),'password'=>strip_tags(form_error('password')),'confirm_password'=>strip_tags(form_error('confirm_password')));
           }else{

               /*check If user name & email is unique*/
               $check_uniqe =  $this->user_model->checkquniqeusername($userId, trim($this->input->post('name')),$this->input->post('user_flag_reg'));
               $check_uniqe1 =  $this->user_model->checkEmailExists($userId, trim($this->input->post('email')),$this->input->post('user_flag_reg'));
               
               if($check_uniqe){
                   $createuser_response['status'] = 'failure';
                   if(empty($this->input->post('password')))
                   {
                       $createuser_response['error'] = array('name'=>'User Name Alreday Exits', 'email'=>'', 'mobile'=>'', 'role'=>'');
                   }else
                   {
                       $createuser_response['error'] = array('name'=>'User Name Alreday Exits', 'email'=>'', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password' =>'');
                   }
               }
               else if($check_uniqe1){
                   $createuser_response['status'] = 'failure';
                   
                   if(empty($this->input->post('password')))
                   {
                       $createuser_response['error'] = array('name'=>'', 'email'=>'Email already Exist', 'mobile'=>'', 'role'=>'');
                   }else
                   {
                       $createuser_response['error'] = array('name'=>'', 'email'=>'Email already Exist', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password' =>'');
                   }
               }
               else{
                   $saveUserdata = $this->user_model->saveUserdata($userId,$data);
                   if($saveUserdata){
                       $createuser_response['status'] = 'success';
                       
                       if(empty($this->input->post('password')))
                       {
                           $createuser_response['error'] = array('name'=>'', 'email'=>'', 'mobile'=>'', 'role'=>'');
                       }else
                       {
                           $createuser_response['error'] = array('name'=>'', 'email'=>'', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password' =>'');
                       }
                   }
               }
           }
   
           echo json_encode($createuser_response);
       }
   }


   public function getenquiryfollowuplist(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $this->form_validation->set_rules('enquiry_id', 'Enquiry Id', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('enquiry_id' =>strip_tags(form_error('enquiry_id')),'user_flag' =>strip_tags(form_error('user_flag')),'timetable_id'=>strip_tags(form_error('user_flag')));
        }else{
            $getenquiryfollowuplist_data = $this->Api_model->getenquiryfollowuplist($this->input->post('enquiry_id'),$this->input->post('user_flag'),$this->input->post('userid'));
            if($getenquiryfollowuplist_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $getenquiryfollowuplist_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

   }


   public function addenquiryfollowup(){

     $post_submit = $this->input->post();

     if($post_submit){
        $createfollow_response = array();        
        $this->form_validation->set_rules('follow_up_date', 'Follow Up Date', 'trim|required');
        $this->form_validation->set_rules('remark', 'Remark', 'trim|required');

        if($this->form_validation->run() == FALSE){

            $createfollow_response['status'] = 'failure';
            $createfollow_response['error'] = array('follow_up_date'=>strip_tags(form_error('follow_up_date')), 'remark'=>strip_tags(form_error('remark')));
    
        }else{
            $data = array(
                'enq_id' => $this->input->post('enquiry_id'),
                'date'  => date('Y-m-d', strtotime($this->input->post('follow_up_date'))),
                'remark' => $this->input->post('remark'),
                'enquiry_number'=> $this->input->post('enquiry_number'),
                //'createdBy'=>
            );

            $saveFollowdata = $this->enquiry_model->saveEnquiryFollowupdata('',$data);
            if($saveFollowdata){
                $createfollow_response['status'] = 'success';
                $createfollow_response['error'] = array('follow_up_date'=>'', 'remark'=>'');
            }
               
        }
        echo json_encode($createfollow_response);
    }


   }


    public function editenquiryfollowup(){

        $post_submit = $this->input->post();

        if($post_submit){
        $createfollow_response = array();        
        $this->form_validation->set_rules('follow_up_date', 'Follow Up Date', 'trim|required');
        $this->form_validation->set_rules('remark', 'Remark', 'trim|required');
        $this->form_validation->set_rules('followup_id', 'followup_id', 'trim|required');

        if($this->form_validation->run() == FALSE){

            $createfollow_response['status'] = 'failure';
            $createfollow_response['error'] = array('follow_up_date'=>strip_tags(form_error('follow_up_date')), 'remark'=>strip_tags(form_error('remark')),'followup_id'=>strip_tags(form_error('followup_id')));
    
        }else{
            $data = array(
                'enq_id' => $this->input->post('enquiry_id'),
                'date'  => date('Y-m-d', strtotime($this->input->post('follow_up_date'))),
                'remark' => $this->input->post('remark'),
                'enquiry_number'=> $this->input->post('enquiry_number'),
                //'createdBy'=>
            );
                $followup_id = trim($this->input->post('followup_id'));
                
            $saveFollowdata = $this->enquiry_model->saveEnquiryFollowupdata($followup_id,$data);
            if($saveFollowdata){
                $createfollow_response['status'] = 'success';
                $createfollow_response['error'] = array('follow_up_date'=>'', 'remark'=>'');
            }
                
        }
        echo json_encode($createfollow_response);
        }


    }


   public function createnewaddoncourse(){
        $post_submit = $this->input->post();
        if(!empty($post_submit)){
            $saveaddoncourse_response = array();

            $this->form_validation->set_rules('course', 'Course Name', 'trim|required');
            $this->form_validation->set_rules('enquiry_id', 'Enquiry Id', 'trim|required');
            if($this->form_validation->run() == FALSE){
                $saveaddoncourse_response['status'] = 'failure';
                $saveaddoncourse_response['error'] = array('course'=>strip_tags(form_error('course')), 'enquiry_id'=>strip_tags(form_error('enquiry_id')));
            }else{

                $data = array(
                    'enquiry_id'=>trim($this->input->post('enquiry_id')),
                    'course_id'=> trim($this->input->post('course')),
                    'active_status'=> 0,
                );

                $save_Add_on_courses = $this->enquiry_model->save_Add_on_courses('',$data);
                if($save_Add_on_courses){
                    $saveaddoncourse_response['status'] = 'success';
                    $saveaddoncourse_response['error'] = array('course'=>'', 'enquiry_id'=>'');
                }
            }
            echo json_encode($saveaddoncourse_response);
        }
   }


   public function adddiscounttomaincourse(){

    $post_submit = $this->input->post();
        
    if(!empty($post_submit)){
        $update_discount_response = array();

        $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required');
        $this->form_validation->set_rules('discounted_amount', 'Discounted Amount', 'trim|required');
        // $this->form_validation->set_rules('total_benifit', 'Total Benifit', 'trim|required');
        // $this->form_validation->set_rules('final_student_amount', 'Final Student Amount', 'trim|required');

        if($this->form_validation->run() == FALSE){
                $update_discount_response['status'] = 'failure';
                $update_discount_response['error'] = array('total_amount'=>strip_tags(form_error('total_amount')), 'discounted_amount'=>strip_tags(form_error('discounted_amount')), 'total_benifit'=>strip_tags(form_error('total_benifit')), 'final_student_amount'=>strip_tags(form_error('final_student_amount')));
        }else{


           $final_student_amount =  trim($this->input->post('total_amount')) - trim($this->input->post('discounted_amount'));


            $enquiry_id =   trim($this->input->post('enquiry_id'));
            $total_amount =   trim($this->input->post('total_amount'));
            $discounted_amount =   trim($this->input->post('discounted_amount'));
            // $total_benifit =   $this->input->post('total_benifit');
            // $final_student_amount =   $this->input->post('final_student_amount');
            $total_benifit = trim($this->input->post('discounted_amount'));
            $final_student_amount=$final_student_amount;

            $data = array(
                'total_payment'=> $total_amount,
                'discount_amount'=> $discounted_amount,
                'total_benifit'=> $total_benifit,
                'final_amount'=> $final_student_amount,                          
            );

            
            $update_enquiry_discount =  $this->enquiry_model->update_enquiry_discount($data,$enquiry_id);


               if($update_enquiry_discount){
                    $update_discount_response['status'] = 'success';
                    $update_discount_response['error'] = array('total_amount'=>strip_tags(form_error('total_amount')), 'discounted_amount'=>strip_tags(form_error('discounted_amount')), 'total_benifit'=>strip_tags(form_error('total_benifit')), 'final_student_amount'=>strip_tags(form_error('final_student_amount')));
                }else{
                    $update_discount_response['status'] = 'failure';
                    $update_discount_response['error'] = array('total_amount'=>strip_tags(form_error('total_amount')), 'discounted_amount'=>strip_tags(form_error('discounted_amount')), 'total_benifit'=>strip_tags(form_error('total_benifit')), 'final_student_amount'=>strip_tags(form_error('final_student_amount')));
                }

                echo json_encode($update_discount_response);

        }
        
    }
    
   }


    public function addmanualpayment(){
            $post_submit = $this->input->post();
            if($post_submit){
                $add_manaulpayment_response = array();

                $this->form_validation->set_rules('enquiry_number', 'Enquiry Eumber', 'trim|required');
                $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'trim|required');
                $this->form_validation->set_rules('manual_payment_amount', 'Manual Payment Amount', 'trim|required');
                $this->form_validation->set_rules('payment_date', 'Payment Date', 'trim|required');
                $this->form_validation->set_rules('cheuqe_number', 'Cheuqe Number', 'trim');
                $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim');
                $this->form_validation->set_rules('prepared_by', 'Prepared By', 'trim');
                $this->form_validation->set_rules('description', 'Description', 'trim');

                if($this->form_validation->run() == FALSE){
                    $add_manaulpayment_response['status'] = 'failure';
                    $add_manaulpayment_response['error'] = array('enquiry_number'=>strip_tags(form_error('enquiry_number')), 'payment_mode'=>strip_tags(form_error('payment_mode')), 'manual_payment_amount'=>strip_tags(form_error('manual_payment_amount')), 'payment_date'=>strip_tags(form_error('payment_date')),'cheuqe_number'=>strip_tags(form_error('cheuqe_number')),'bank_name'=>strip_tags(form_error('bank_name')),'prepared_by'=>strip_tags(form_error('prepared_by')));
                }else{

                            $add_on_course_id_post_value =  trim($this->input->post('add_on_course_id'));

                            if($add_on_course_id_post_value){
                                $add_on_course_id =  trim($this->input->post('add_on_course_id'));
                                $paymant_type = 'add_on_course_invoice';

                                $check_payment_is_less_than  = $this->enquiry_model->check_payment_maount_lessthan_actaul_add_course($this->input->post('enquiry_number'),trim($this->input->post('add_on_course_id')));

                            }else{

                                $paymant_type = 'regular_invoice';
                                $add_on_course_id ='';
                                $check_payment_is_less_than  = $this->enquiry_model->check_payment_maount_lessthan_actaul($this->input->post('enquiry_number'));
                            }

                        
                            // if($check_payment_is_less_than[0]['final_amount'] < trim($this->input->post('manual_payment_amount')) ){
                            //     $add_manaulpayment_response['status'] = 'failure';
                            //     $add_manaulpayment_response['error'] = array('enquiry_number'=>"", 'payment_mode'=>"", 'manual_payment_amount'=>'Payment Amount is Greater Than Actual Amount', 'payment_date'=>"",'cheuqe_number'=>"",'bank_name'=>"",'prepared_by'=>"");
                            // }else{

                                    $data = array(
                                        'enquiry_id'=> $this->input->post('enquiry_number'),
                                        'enquiry_number'=>  $this->input->post('enquiry_number'),
                                        'totalAmount'=>  $this->input->post('manual_payment_amount'),
                                        'payment_status'=> '1',
                                        'payment_mode'=> $this->input->post('payment_mode'),
                                        'cheuqe_number'=> $this->input->post('cheuqe_number'),
                                        'bank_name'=> $this->input->post('bank_name'),
                                        'prepared_by'=> $this->input->post('prepared_by'),
                                        'description'=> $this->input->post('description'),
                                        'paymant_type' => $paymant_type,
                                        'add_on_course_id' => trim($add_on_course_id),
                                        'payment_date'=>  date('Y-m-d h:i:sa', strtotime($this->input->post('payment_date'))),
                                    );

                                $insert_manualpayment_details =  $this->enquiry_model->insert_manualpayment_details($data);

                                if($insert_manualpayment_details){
                                        $add_manaulpayment_response['status'] = 'success';
                                        $add_manaulpayment_response['error'] = array('enquiry_number'=>strip_tags(form_error('enquiry_number')), 'payment_mode'=>strip_tags(form_error('payment_mode')), 'manual_payment_amount'=>strip_tags(form_error('manual_payment_amount')), 'payment_date'=>strip_tags(form_error('payment_date')),'cheuqe_number'=>strip_tags(form_error('cheuqe_number')),'bank_name'=>strip_tags(form_error('bank_name')),'prepared_by'=>strip_tags(form_error('prepared_by')));
                                    }else{
                                        $add_manaulpayment_response['status'] = 'failure';
                                        $add_manaulpayment_response['error'] = array('enquiry_number'=>strip_tags(form_error('enquiry_number')), 'payment_mode'=>strip_tags(form_error('payment_mode')), 'manual_payment_amount'=>strip_tags(form_error('manual_payment_amount')), 'payment_date'=>strip_tags(form_error('payment_date')),'cheuqe_number'=>strip_tags(form_error('cheuqe_number')),'bank_name'=>strip_tags(form_error('bank_name')),'prepared_by'=>strip_tags(form_error('prepared_by')));
                                    }

                            // }
                    
                }

                echo json_encode($add_manaulpayment_response);
                    
            }
    }



    public function addcourserequestapproved(){

        $post_submit = $this->input->post();
        if(!empty($post_submit)){

            $topirequest_response = array();
            // $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
            // $this->form_validation->set_rules('course_topic', 'Course Topic', 'trim|required');
            // $this->form_validation->set_rules('request_description', 'Request Description', 'trim|required');
        
            // $this->form_validation->set_rules('time_table_id', 'Time Table Id', 'trim|required');
            $this->form_validation->set_rules('request_id', 'Request id', 'trim|required');
            $this->form_validation->set_rules('updated_status', 'Updated Status', 'trim|required');
            
            if($this->form_validation->run() == FALSE){
        
                $topirequest_response['status'] = 'failure';
                $topirequest_response['error'] = array('request_id'=>strip_tags(form_error('request_id')), 'updated_status'=>strip_tags(form_error('updated_status')));
            }else{

                $data = array(
                    'approval_status'  => 1,
                    'admin_approval_status'  => $this->input->post('updated_status'),
                );

                $request_id = $this->input->post('request_id');

                $topic_class_request = $this->admission_model->saveclassrequest($request_id,$data);

                if($topic_class_request){
                    $topirequest_response['status'] = 'success';
                    $topirequest_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'course_topic'=>strip_tags(form_error('course_topic')), 'request_description'=>strip_tags(form_error('request_description')),'updated_status'=>strip_tags(form_error('updated_status')));
                }else{
                    $topirequest_response['status'] = 'failure';
                    $topirequest_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'course_topic'=>strip_tags(form_error('course_topic')), 'request_description'=>strip_tags(form_error('request_description')),'updated_status'=>strip_tags(form_error('updated_status')));    
                }
            }
            echo json_encode($topirequest_response);
        }
    }



    public function getanswersheetlist(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $this->form_validation->set_rules('exam_id', 'exam_id', 'trim|required');
        $this->form_validation->set_rules('course_id', 'course_id', 'trim|required');
        
        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('exam_id' =>strip_tags(form_error('exam_id')),'user_flag' =>strip_tags(form_error('user_flag')),'timetable_id'=>strip_tags(form_error('user_flag')));
        }else{
            $getanswersheetlist_data = $this->Api_model->getanswersheetlist(trim($this->input->post('course_id')),trim($this->input->post('exam_id')));
            if($getanswersheetlist_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $getanswersheetlist_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }
    }

    


   /* Superadmin Part End Here */   


   /* Trianer Part Start Here */

    /*Trainer Dashbaord Details*/
    public function gettrainerdashboarddetails(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        
        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}
		else
		{	

            $year = null; $month = null; $day = null;

            $year  = (empty($year) || !is_numeric($year))?  date('Y') :  $year;
            $month = (is_numeric($month) &&  $month > 0 && $month < 13)? $month : date('m');
            $day   = (is_numeric($day) &&  $day > 0 && $day < 31)?  $day : date('d');
            
            $date      = $this->event->getDateEvent($year, $month);
            $cur_event = $this->event->getEvent($year, $month, $day);
            
            $getAttendanceCount = $this->Api_model->getAttendanceCountTrainer(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            $getCoursescount = $this->Api_model->getCoursesCountTrainer(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            $getExaminationcount = $this->Api_model->getexaminationCountTrainer(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
           
          
            $getAnsthequerycount = $this->Api_model->getallstudentquerycount(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            $student_answer_sheet_for_checking = $this->Api_model->getexamcheckingdata(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            $getstudentqueryforttopicwisetriner = $this->Api_model->getstudentqueryforttopicwisetriner(trim($this->input->post('userid')),trim($this->input->post('user_flag')));

            $status = 'Success';
            $message = 'Trainer Dashboard data';
            $count_data =  array('userid' => $userdetails['userId'],'attendance_count'=>$getAttendanceCount,'course_count'=>$getCoursescount,'examination_count'=>$getExaminationcount,'ans_the_query_count'=>$getAnsthequerycount);
			logInformationcollection($userdetails['userId'],$userdetails['username'],$userdetails['mobile'],'User Details Fetched', 'API to user app', 'User Details', $user_data);
        }

        $responseData = array('status' => $status,'message'=> $message,'dashbaord_count_data' => $count_data,'todays_class'=>$cur_event,'student_answer_sheet_for_checking'=>$student_answer_sheet_for_checking,'getstudentqueryforttopicwisetriner'=>$getstudentqueryforttopicwisetriner);
		setContentLength($responseData);
    }


     /*Trainer Answer The Query List*/
    public function gettraineranswerthequery(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $studentportal_data = $this->Api_model->getallstudentquerydata(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            if($studentportal_data){
                $status = 'Success';
                $message = 'Answer The Query Data Not Found';
                $data = $studentportal_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }

    /* View Trainer Answer The Query*/
    public function viewtraineranswerthequery(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $this->form_validation->set_rules('query_id', 'Query Id', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')),'query_id' =>strip_tags(form_error('query_id')));
		}else{
            $viewtraineranswerthequery_data = $this->Api_model->viewtraineranswerthequery(trim($this->input->post('userid')),trim($this->input->post('user_flag')),trim($this->input->post('query_id')));
            if($viewtraineranswerthequery_data){
                $status = 'Success';
                $message = 'Answer The Query Data Not Found';
                $data = $viewtraineranswerthequery_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }


    public function addqueryanswer(){
        $post_submit = $this->input->post();

        if(!empty($post_submit)){

            $addnewqueryanswer_response = array();
            $data = array(
                        'student_id' => $this->input->post('userId'),
                        'query_id'=> $this->input->post('query_id'),
                        'query_answer'=>$this->input->post('query_answer'),
                );

            $this->form_validation->set_rules('query_answer', 'Query', 'trim|required');


            if($this->form_validation->run() == FALSE){
                        $addnewqueryanswer_response['status'] = 'failure';
                        $addnewqueryanswer_response['error'] = array('query_answer'=>strip_tags(form_error('query_answer')));
            }else{

                $saveCoursedata = $this->student_model->saveQueryanswerdata('',$data);
                   if($saveCoursedata){
                            $addnewqueryanswer_response['status'] = 'success';
                            $addnewqueryanswer_response['error'] = array('query_answer'=>strip_tags(form_error('query_answer')));
                        }

                }

                echo json_encode($addnewqueryanswer_response);
            }


    }


    public function deleteansawerthequery(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('id', 'Id', 'trim|required');

        $addnewqueryanswer_response = array();
        $addnewqueryanswer_response['status'] = 'success';
        $addnewqueryanswer_response['error'] = array('delete_answer'=>strip_tags(form_error('delete_answer')));
        echo json_encode($addnewqueryanswer_response);

    }

    /* Trianer Part End Here */


     /* Consellor Part Start Here */
     /*Consellor Dashbaord Details*/
    public function getconsellordashboarddetails(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        
        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}
		else
		{	

            $year = null; $month = null; $day = null;

            $year  = (empty($year) || !is_numeric($year))?  date('Y') :  $year;
            $month = (is_numeric($month) &&  $month > 0 && $month < 13)? $month : date('m');
            $day   = (is_numeric($day) &&  $day > 0 && $day < 31)?  $day : date('d');
            
            $date      = $this->event->getDateEvent($year, $month);
            $cur_event = $this->event->getEvent($year, $month, $day);
            
        
            $getCoursescount = $this->Api_model->getCoursesCountCounsellor(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            $getTotalenquirycount = $this->Api_model->getTotalenquirycountCounsellor(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            $getTotalAdmissioncount = $this->Api_model->getTotalAdmissioncountCounsellor(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            $getTotalInvoicecount = $this->Api_model->getTotalInvoicecountCounsellor(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
           
            $getalltotalrevunedetailscounsellor=  $this->Api_model->getalltotalrevunedetailscounsellor(trim($this->input->post('userid')),trim($this->input->post('user_flag')));


            $status = 'Success';
            $message = 'Consellor Dashboard data';
            $count_data =  array('userid' => $userdetails['userId'],'total_courses'=>$getCoursescount,'total_enquires'=>$getTotalenquirycount,'total_admissions'=>$getTotalAdmissioncount,'total_invoices'=>$getTotalInvoicecount);
			logInformationcollection($userdetails['userId'],$userdetails['username'],$userdetails['mobile'],'User Details Fetched', 'API to user app', 'User Details', $user_data);
        }

        $responseData = array('status' => $status,'message'=> $message,'dashbaord_count_data' => $count_data,'todays_class'=>$cur_event,'revenue_details'=>$getalltotalrevunedetailscounsellor);
		setContentLength($responseData);
    }

    /* Consellor Part End Here */


    /* Student Dashbord Details*/
    public function getstudentdashboarddetails(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        
        $post_submit = $this->input->post();
        if($this->form_validation->run() == FALSE)
		{
            $status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
        }else{

            $status = 'Success';
            $message = 'Data Found';
            
            $userId =$this->input->post('userid');
           // $data['getaskaqueryRecord'] = $this->admission_model->getaskaqueryRecord($userId);
            // $upcoming_class_links = $this->admission_model->upcoming_class_links($userId);
            $data['get_student_enquiry_id'] = $this->admission_model->getstudentEenquiryid($userId)[0];
            $data['followDataenquiry'] = $this->enquiry_model->getEnquiryInfo($data['get_student_enquiry_id']['enq_id']);
            $data['gettotalpaidEnquirypaymentInfo'] = $this->enquiry_model->gettotalpaidEnquirypaymentInfo($data['get_student_enquiry_id']['enq_id']);
            //$additional_course_payment_details = $this->enquiry_model->getadditionalInfo($data['get_student_enquiry_id']['enq_id']);
            $examnotification = $this->student_model->getstudentexaminationdatafordashboardnoti($userId);
          
            $total_course_count = $this->Api_model->getstudentCourseCount($userId);
            $getstudentEnquiryCount = $this->Api_model->getstudentEnquiryCount($userId);
            $getTaxinvoicesCountstudent = $this->Api_model->getTaxinvoicesCountstudent($userId);
            $getClassrequestcountstudent = $this->Api_model->getClassrequestcountstudent($userId);
            $getReplyonyourquerystudent = $this->Api_model->getReplyonyourquerystudent($userId);
          
            $payment_details = array('amount_total'=>1000,'amount_paid_by_you'=>200,'pending_amount_by_you'=>500);
            $total_dashbaord_count = array('total_courses'=>$total_course_count,'total_admission'=>$getstudentEnquiryCount,'total_invoices'=>$getTaxinvoicesCountstudent,'total_exam_notification'=>count($examnotification),'total_replay_on_query'=>$getReplyonyourquerystudent,'total_class_request'=>$getClassrequestcountstudent);
           
           
            $additional_course_payment_details = array('total_courses_fees'=>1000,'total_paid_amount'=>5000,'total_pending_amount'=>5000);

        }

        //$responseData = array('status' => $status,'message'=> $message,'additional_course_payment_details' => $additional_course_payment_details,'upcoming_class_links'=>$upcoming_class_links,'exam_notification'=>$examnotification,'payment_details'=>$payment_details,'total_dashbaord_count'=>$total_dashbaord_count);
        $responseData = array('status' => $status,'message'=> $message,'additional_course_payment_details' => $additional_course_payment_details,'exam_notification'=>$examnotification,'payment_details'=>$payment_details,'total_dashbaord_count'=>$total_dashbaord_count);

        setContentLength($responseData);
        
    }


    public function studentupcomingclasslinkslist(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
        }else{


            $userId = trim($this->input->post('userid'));
            $upcoming_class_links = $this->Api_model->upcoming_class_links($userId);
            if($upcoming_class_links){
                $status = 'Success';
                $message = 'Data Found';
                $data = $upcoming_class_links;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }


    public function studentaskaquerylist(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
        }else{
            $studentaskaquerylist_data = $this->Api_model->studentaskaquerylist($this->input->post('user_flag'),$this->input->post('userid'));
            if($studentaskaquerylist_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $studentaskaquerylist_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }


    
    public function viewqueryanswer(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');
        $this->form_validation->set_rules('queryid', 'Query Id', 'trim|required');


        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')),'queryid' =>strip_tags(form_error('queryid')));
        }else{
            $viewqueryanswer_data = $this->Api_model->getquerydatabyid($this->input->post('user_flag'),$this->input->post('userid'),$this->input->post('queryid'));
            if($viewqueryanswer_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $viewqueryanswer_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }


    }


    public function courserequest(){

        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');


        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
        {
            $status = 'Failure';
            $message = 'Validation error';
            $data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
        }else{
            $courserequestr_data = $this->Api_model->studentcourseRequestData($this->input->post('user_flag'),$this->input->post('userid'));
            if($courserequestr_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $courserequestr_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }
    }


    public function getcourseliststudent(){
        $userdetails = validateServiceRequest();
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
        $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');

        $post_submit = $this->input->post();
        if ($this->form_validation->run() == FALSE)
		{
			$status = 'Failure';
			$message = 'Validation error';
			$data = array('userid' =>strip_tags(form_error('userid')),'user_flag' =>strip_tags(form_error('user_flag')));
		}else{
            $course_data = $this->Api_model->getcourseliststudent($this->input->post('userid'));
            if($course_data){
                $status = 'Success';
                $message = 'Data Found';
                $data = $course_data;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }

    }


    public function getcoursetopic() {
        if($this->input->post('course_id')) {
            $topics = $this->student_model->getcoursetopic($this->input->post('course_id'));
            if($topics){
                $status = 'Success';
                $message = 'Data Found';
                $data = $topics;
            }else{
                $status = 'Failure';
                $message = 'No Data Found';
                $data = '';   
            }
            $responseData = array('status' => $status,'message'=> $message,'data' => $data);
            setContentLength($responseData);
        }
    }


    public function addnewquery(){
        $post_submit = $this->input->post();
  
        if(!empty($post_submit)){
            $userId =  $this->input->post('userid');

            $addnewquery_response = array();
            $data = array(
                'course_id' => $this->input->post('course_id'),
                'certificate_topic'=> $this->input->post('certificate_topic_id'),
                'query'=> $this->input->post('query'),
                'student_id'=>$userId
            );

            // $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
            // $this->form_validation->set_rules('certificate_topic', 'Certificate Topic', 'trim|required');
            $this->form_validation->set_rules('query', 'Query', 'trim|required');

            if($this->form_validation->run() == FALSE){
                $addnewquery_response['status'] = 'failure';
                $addnewquery_response['error'] = array('course_name'=>strip_tags(form_error('course_name')),'certificate_topic'=>strip_tags(form_error('certificate_topic')),'query'=>strip_tags(form_error('query')));
            }else{
                
                $saveCoursedata = $this->student_model->saveQuerydata('',$data);
                if($saveCoursedata){
                    $addnewquery_response['status'] = 'success';
                    $addnewquery_response['error'] = array('course_name'=>strip_tags(form_error('course_name')),'certificate_topic'=>strip_tags(form_error('certificate_topic')) ,'query'=>strip_tags(form_error('query')));
                }
            }
            echo json_encode($addnewquery_response);
        }
    }


    public function createcourserequest(){

        $post_submit = $this->input->post();
        if(!empty($post_submit)){
            $topirequest_response = array();
            // $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
            // $this->form_validation->set_rules('course_topic', 'Course Topic', 'trim|required');
            $this->form_validation->set_rules('time_table_id', 'Time Table Id', 'trim|required');
            $this->form_validation->set_rules('student_id', 'Student Id', 'trim|required');
            $this->form_validation->set_rules('request_description', 'Request Description', 'trim|required');

            if($this->form_validation->run() == FALSE){
                $topirequest_response['status'] = 'failure';
                $topirequest_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'course_topic'=>strip_tags(form_error('course_topic')), 'request_description'=>strip_tags(form_error('request_description')));
            }else{
    
                $data = array(
                    'time_table_id'      => $this->input->post('time_table_id'),
                    'student_id'     => $this->input->post('student_id'),
                    'remark'  => $this->input->post('request_description'),
                    'request_sent_status'  => 1,
                );
    
                $topic_class_request = $this->admission_model->saveclassrequest('',$data);
    
                if($topic_class_request){
                     $topirequest_response['status'] = 'success';
                     $topirequest_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'course_topic'=>strip_tags(form_error('course_topic')), 'request_description'=>strip_tags(form_error('request_description')));
                }else{
                    $topirequest_response['status'] = 'failure';
                    $topirequest_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'course_topic'=>strip_tags(form_error('course_topic')), 'request_description'=>strip_tags(form_error('request_description')));    
                }
            }
            echo json_encode($topirequest_response);
        }
    }

    
    public function attendClasses(){

        $post_submit = $this->input->post();
        if($post_submit){
            $attendance_response = array();
             if(trim($this->input->post('join_link')) =='YES'){
                $data = array(
                    'user_id'  => $this->input->post('user_id'),
                    'topic_id' => $this->input->post('topic_id'),
                    'course_id' => $this->input->post('course_id'),
                    'meeting_id' => $this->input->post('meeting_id'),
                    'meeting_link' => $this->input->post('meeting_link'),
                    'attendance_status' => 1,
                    'join_link' => 1,
                );
             }
             else if(trim($this->input->post('print_card')) =='YES'){

                $data = array(
                    'user_id'  => $this->input->post('user_id'),
                    'topic_id' => $this->input->post('topic_id'),
                    'course_id' => $this->input->post('course_id'),
                    'meeting_id' => $this->input->post('meeting_id'),
                    'meeting_link' => $this->input->post('meeting_link'),
                    'attendance_status' => 1,
                    'print_card' => 1,
                );

            }else{
                $data = array(
                    'user_id'  => $this->input->post('user_id'),
                    'topic_id' => $this->input->post('topic_id'),
                    'course_id' => $this->input->post('course_id'),
                    'meeting_id' => $this->input->post('meeting_id'),
                    'meeting_link' => $this->input->post('meeting_link'),
                    'attendance_status' => 1,
                );
            }


            /*check if data is alreday exits */

           
            $checkifAttendanceaxist = $this->student_model->checkifAttendanceaxist($data);
            if($checkifAttendanceaxist > 0){
                $attendance_response['status'] = 'success';
                echo json_encode($attendance_response);
            }else{
                $saveAttendancedata = $this->student_model->saveAttendancedata($data);

                if($saveAttendancedata){
                    if(trim($this->input->post('print_card')) =='YES'){

                     $attendance_response['print_idcard'] = 'https://iictn.in/print_idcard?student_id='.$this->input->post('user_id');

                    }
                    $attendance_response['status'] = 'success';

                    
                }else{
                    $attendance_response['status'] = 'failure';
                }
                echo json_encode($attendance_response);

            }
        
        }

    }


     /* Student API Work Done Here*/


    /*Version API*/
    public function checkappversion(){
         $responseData = array('android_version'=>'1.8','ios_version'=>'1.3');
         setContentLength($responseData);
    }


}

?>