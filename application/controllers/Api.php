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
         $this->load->model(array('Api_model'));
         $this->load->library('form_validation');
    }

    /**
     * This is Login Function Access by Mobile 
    */
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
            $user_data =  array('userid' => $userdetails['userId'],'name' => $userdetails['name'],'email'=>$userdetails['email'],'user_flag'=>$userdetails['user_flag'],'role'=>$userdetails['role'],'access'=>$userdetails['access'],'profile_pic'=>IMGPATH.$userdetails['profile_pic']);
			logInformationcollection($userdetails['userId'],$userdetails['username'],$userdetails['mobile'],'User Details Fetched', 'API to user app', 'User Details', $user_data);
        }

        $responseData = array('status' => $status,'message'=> $message,'data' => $user_data);
		setContentLength($responseData);
    }

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

    public function getdashboarddetails(){
       $userdetails = validateServiceRequest();
       $this->form_validation->set_rules('userid', 'Userid', 'trim|required');
       $this->form_validation->set_rules('user_flag', 'User Flag', 'trim|required');


    }

}

?>