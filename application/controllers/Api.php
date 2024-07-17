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
         $this->load->model(array('Api_model','enquiry_model','event','user_model'));
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

            $user_data =  array('userid' => $userdetails['userId'],'name' => $userdetails['name'],'email'=>$userdetails['email'],'user_flag'=>$userdetails['user_flag'],'role'=>$userdetails['role'],'access'=>$userdetails['access'],'profile_pic'=>$profile_pic_image);
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
                    'enq_course_id' => $courses,
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
                        }
            }
            echo json_encode($profileupdate_response);
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




}

?>