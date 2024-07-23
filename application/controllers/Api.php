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
         $this->load->model(array('Api_model','enquiry_model','event','user_model','course_model'));
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

            $view_CourseList = $this->Api_model->getCourseList();
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
            
            $courses_multipal = $this->security->xss_clean($this->input->post('course'));
            if($courses_multipal){
               // $courses = implode(',', $courses_multipal);

               //    $this->enquiry_model->getCourseInfo($id);

               //     print_r($courses_multipal);
               //     exit;

                  $course_name = explode(',', $courses_multipal);

                   $getallcourseidbycoursename = $this->enquiry_model->getallcourseidbycoursename($course_name);

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
                
                                   $getallcourseidbycoursename = $this->enquiry_model->getallcourseidbycoursename($course_name);
                
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

            // $total_course_fees  = $this->input->post('total_course_fees');

            // $sgst_tax  = $this->input->post('sgst_tax');
            // $sgst_tax_value  = $this->input->post('sgst');
            
            // $cgst_tax  = $this->input->post('cgst_tax');
            // $cgst_tax_value   = $this->input->post('cgst');

            $total_course_fees  = 0;

            $sgst_tax  = 0;
            $sgst_tax_value  = 0;
            
            $cgst_tax  = 0;
            $cgst_tax_value   = 0;


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
                'course_cert_cost' => $this->input->post('certificate_cost'),
                'course_kit_cost'=> $this->input->post('kit_cost'),
                'course_onetime_adm_fees'=>$this->input->post('one_time_admission_fees'),
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
            $this->form_validation->set_rules('course_type', 'Certificate Type', 'trim|required');
            //$this->form_validation->set_rules('description', 'Description', 'trim');
            $this->form_validation->set_rules('certificate_cost', 'Certificate cost', 'trim|numeric');
            $this->form_validation->set_rules('one_time_admission_fees', 'One Time Admission Fees', 'trim|numeric');
            $this->form_validation->set_rules('kit_cost', 'Kit Cost', 'trim|numeric');
            $this->form_validation->set_rules('course_books', 'Course Books', 'trim');
            //$this->form_validation->set_rules('remarks', 'remarks', 'trim');
            $this->form_validation->set_rules('total_course_fees', 'Total Course Fees', 'trim|required');
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
        $courseId = $this->input->post('courseId');
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

            // $total_course_fees  = $this->input->post('total_course_fees');

            // $sgst_tax  = $this->input->post('sgst_tax');
            // $sgst_tax_value  = $this->input->post('sgst');
            
            // $cgst_tax  = $this->input->post('cgst_tax');
            // $cgst_tax_value   = $this->input->post('cgst');


            $total_course_fees  = 0;

            $sgst_tax  = 0;
            $sgst_tax_value  = 0;
            
            $cgst_tax  = 0;
            $cgst_tax_value   = 0;


        
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
                'course_cert_cost' => $this->input->post('certificate_cost'),
                'course_kit_cost'=> $this->input->post('kit_cost'),
                'course_onetime_adm_fees'=>$this->input->post('one_time_admission_fees'),
                'course_books'=>$this->input->post('course_books1'),
                //'course_remark' => $this->input->post('remarks'),
                'course_mode_online'=>$course_mode_online,
                'course_mode_offline'=>$course_mode_offline,
                'course_cgst' => $cgst_tax,
                'course_cgst_tax_value' => $cgst_tax_value,
                'course_sgst' => $sgst_tax,
                'course_sgst_tax_value' => $sgst_tax_value,
                'course_total_fees' => $total_course_fees
            );

            $this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
            $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
            $this->form_validation->set_rules('fees', 'Fees', 'trim|required|numeric');
            $this->form_validation->set_rules('course_type', 'Certificate Type', 'trim|required');
            //$this->form_validation->set_rules('description', 'Description', 'trim');
            $this->form_validation->set_rules('certificate_cost', 'Certificate cost', 'trim|numeric');
            $this->form_validation->set_rules('one_time_admission_fees', 'One Time Admission Fees', 'trim|numeric');
            $this->form_validation->set_rules('kit_cost', 'Kit Cost', 'trim|numeric');
            $this->form_validation->set_rules('course_books', 'Course Books', 'trim');
            //$this->form_validation->set_rules('remarks', 'remarks', 'trim');

            
    
            if($this->form_validation->run() == FALSE){
                $createcourse_response['status'] = 'failure';
                $createcourse_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'fees'=>strip_tags(form_error('fees')), 'course_type'=>strip_tags(form_error('course_type')), /*'description'=>strip_tags(form_error('description')),*/'certificate_cost'=>strip_tags(form_error('certificate_cost')),'kit_cost'=>strip_tags(form_error('kit_cost')),'one_time_admission_fees'=>strip_tags(form_error('one_time_admission_fees')),'course_books'=>strip_tags(form_error('course_books')),'course_mode'=>$required_checkbox);
            }else{

                if($this->input->post('course_mode')!=1 && $this->input->post('course_mode')!=1){
                 $required_checkbox = '';
              
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

            }else{
                $required_checkbox = 'Course Mode Required';
                $createcourse_response['status'] = 'failure';
                $createcourse_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'fees'=>strip_tags(form_error('fees')), 'course_type'=>strip_tags(form_error('course_type')), /*'description'=>strip_tags(form_error('description')),*/'certificate_cost'=>strip_tags(form_error('certificate_cost')),'kit_cost'=>strip_tags(form_error('kit_cost')),'one_time_admission_fees'=>strip_tags(form_error('one_time_admission_fees')),'course_books'=>strip_tags(form_error('course_books')),'course_mode'=>$required_checkbox);
         
            }

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


            $status = 'Success';
            $message = 'Trainer Dashboard data';
            $count_data =  array('userid' => $userdetails['userId'],'attendance_count'=>$getAttendanceCount,'course_count'=>$getCoursescount,'examination_count'=>$getExaminationcount,'ans_the_query_count'=>$getAnsthequerycount);
			logInformationcollection($userdetails['userId'],$userdetails['username'],$userdetails['mobile'],'User Details Fetched', 'API to user app', 'User Details', $user_data);
        }

        $responseData = array('status' => $status,'message'=> $message,'dashbaord_count_data' => $count_data,'todays_class'=>$cur_event);
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

    

    /* Trianer Part End Here */

     /* Consellor Part Start Here */
     /*Trainer Dashbaord Details*/
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
            
            $getAttendanceCount = $this->Api_model->getAttendanceCountTrainer(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            $getCoursescount = $this->Api_model->getCoursesCountTrainer(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            $getExaminationcount = $this->Api_model->getexaminationCountTrainer(trim($this->input->post('userid')),trim($this->input->post('user_flag')));
            $getAnsthequerycount = $this->Api_model->getallstudentquerycount(trim($this->input->post('userid')),trim($this->input->post('user_flag')));


            $status = 'Success';
            $message = 'Consellor Dashboard data';
            $count_data =  array('userid' => $userdetails['userId'],'total_courses'=>10,'total_enquires'=>20,'total_admissions'=>30);
			logInformationcollection($userdetails['userId'],$userdetails['username'],$userdetails['mobile'],'User Details Fetched', 'API to user app', 'User Details', $user_data);
        }

        $responseData = array('status' => $status,'message'=> $message,'dashbaord_count_data' => $count_data,'todays_class'=>$cur_event);
		setContentLength($responseData);
    }

    /* Consellor Part End Here */



}

?>