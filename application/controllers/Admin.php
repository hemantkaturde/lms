<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Admin extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('login_model', 'enquiry_model','user_model','student_model','course_model','database','admission_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        // $this->load->config('additional');
        // $this->load->library('mail');
        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();
        // isLoggedIn / Login control function /  This function used login control
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            redirect('login');
        }
        else
        {
            // isAdmin / Admin role control function / This function used admin role control
            // if($this->isAdmin() == TRUE)
            // {
            //     $this->accesslogincontrol();
            // }
        }
    }
	
    public function index()
    {
        $this->global['pageTitle'] = 'ADMIN : Home page';
        $data['users'] = $this->user_model->userListingCount();
        $data['courses'] = $this->course_model->courseListingCount();
        $data['enquries'] = $this->enquiry_model->enquiryListingCount();
        $data['students'] = $this->student_model->studentListingCount();
        $data['admissions'] = $this->admission_model->admissionListingCount();
        $this->loadViews("dashboard", $this->global, $data , NULL);
    }

     /**
     * This function is used to load the user list
     */
    function userListing()
    {          
            $this->global['pageTitle'] = 'User List';
            $data['role'] = $this->user_model->getUserRoles();
            $this->loadViews("master/users", $this->global, $data, NULL);
    }

    public function fetchUsers(){
        
        $params = $_REQUEST;
        $totalRecords = $this->user_model->getUserCount($params); 
        $queryRecords = $this->user_model->getUserdata($params); 

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

    function get_assets_for_user()
    {
        $data['roles'] = $this->user_model->getUserRoles();
        echo json_encode($data);
    }

    public function createUser()
    {
        $post_submit = $this->input->post();
        if(!empty($post_submit)){

            $createuser_response = array();

            if(!empty($_FILES['profile_photo']['name'])){

                $file = rand(1000,100000)."-".$this->input->post('name').$_FILES['profile_photo']['name'];
                $filename = str_replace(' ','_',$file);

                $config['upload_path'] = 'uploads/profile_pic'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                $config['max_size'] = '1000'; // max_size in kb 
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
                'roleId'    => $this->input->post('role'),
                'user_flag' => $this->input->post('user_flag'),
                'profile_pic' => $profile_pic,
                'username'   => trim($this->input->post('username'))
            );

            $this->form_validation->set_rules('name', 'User Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|numeric');
            $this->form_validation->set_rules('role', 'Role', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');

            if($this->form_validation->run() == FALSE){
                $createuser_response['status'] = 'failure';
                $createuser_response['error'] = array('name'=>strip_tags(form_error('name')), 'email'=>strip_tags(form_error('email')), 'mobile'=>strip_tags(form_error('mobile')), 'role'=>strip_tags(form_error('role')),'password'=>strip_tags(form_error('password')),'confirm_password'=>strip_tags(form_error('confirm_password')));
            }else{

                /*check If course name is unique*/
                $check_uniqe =  $this->user_model->checkquniqeusername('',trim($this->input->post('name')),$this->input->post('user_flag'));
                $check_uniqe1 =  $this->user_model->checkEmailExists('',trim($this->input->post('email')),$this->input->post('user_flag'));
                $check_uniqe2 =  $this->user_model->checkquniqemobilenumber('',trim($this->input->post('mobile')),$this->input->post('user_flag'));


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

    public function updateUser($userId)
    {
        $post_submit = $this->input->post();
        if(!empty($post_submit)){

            if(!empty($_FILES['profile_photo1']['name'])){

                $file = rand(1000,100000)."-".$this->input->post('name1').$_FILES['profile_photo1']['name'];
                $filename = str_replace(' ','_',$file);

                $config['upload_path'] = 'uploads/profile_pic'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                $config['max_size'] = '1000'; // max_size in kb 
                $config['file_name'] = $filename; 
       
                // Load upload library 
                $this->load->library('upload',$config); 
        
                // File upload
                if($this->upload->do_upload('profile_photo1')){ 
                   $profile_pic = $filename; 
                }else{
                    $profile_pic =trim($this->input->post('existing_img'));
                }

            }else{
                $profile_pic = trim($this->input->post('existing_img'));

            }

            $createuser_response = array();
            if(empty($this->input->post('password1')))
            {
                $data = array(
                    'name'      => $this->input->post('name1'),
                    'email'     => $this->input->post('email1'),
                    'mobile'    => $this->input->post('mobile1'),
                    'roleId'    => $this->input->post('role1'),
                    'user_flag' =>$this->input->post('user_flag1'),
                    'profile_pic' => $profile_pic,
                    'username'   => trim($this->input->post('username1'))
                );
            }else{
                $data = array(
                    'name'      => $this->input->post('name1'),
                    'email'     => $this->input->post('email1'),
                    'mobile'    => $this->input->post('mobile1'),
                    'password'  => base64_encode($this->input->post('password1')),
                    'roleId'    => $this->input->post('role1'),
                    'user_flag' =>$this->input->post('user_flag1'),
                    'profile_pic' => $profile_pic,
                    'username'   => trim($this->input->post('username1'))
                );
            }

            $this->form_validation->set_rules('name1', 'User Name', 'trim|required');
            $this->form_validation->set_rules('email1', 'Email', 'trim|required');
            $this->form_validation->set_rules('mobile1', 'Mobile No', 'trim|required|numeric');
            $this->form_validation->set_rules('role1', 'Role', 'trim|required');
            if(!empty($this->input->post('password1')))
            {
                $this->form_validation->set_rules('password1', 'Password', 'trim|required');
                $this->form_validation->set_rules('confirm_password1', 'Confirm Password', 'trim|required|matches[password1]');
            }            

            if($this->form_validation->run() == FALSE){
                $createuser_response['status'] = 'failure';
                $createuser_response['error'] = array('name1'=>strip_tags(form_error('name1')), 'email1'=>strip_tags(form_error('email1')), 'mobile1'=>strip_tags(form_error('mobile1')), 'role1'=>strip_tags(form_error('role1')),'password1'=>strip_tags(form_error('password1')),'confirm_password1'=>strip_tags(form_error('confirm_password1')));
            }else{

                /*check If user name & email is unique*/
                $check_uniqe =  $this->user_model->checkquniqeusername($userId, trim($this->input->post('name1')),$this->input->post('user_flag1'));
                $check_uniqe1 =  $this->user_model->checkEmailExists($userId, trim($this->input->post('email1')),$this->input->post('user_flag1'));
                
                if($check_uniqe){
                    $createuser_response['status'] = 'failure';
                    if(empty($this->input->post('password1')))
                    {
                        $createuser_response['error'] = array('name1'=>'User Name Alreday Exits', 'email1'=>'', 'mobile1'=>'', 'role1'=>'');
                    }else
                    {
                        $createuser_response['error'] = array('name1'=>'User Name Alreday Exits', 'email1'=>'', 'mobile1'=>'', 'role1'=>'','password1'=>'','confirm_password1' =>'');
                    }
                }
                else if($check_uniqe1){
                    $createuser_response['status'] = 'failure';
                    
                    if(empty($this->input->post('password1')))
                    {
                        $createuser_response['error'] = array('name1'=>'', 'email1'=>'Email already Exist', 'mobile1'=>'', 'role1'=>'');
                    }else
                    {
                        $createuser_response['error'] = array('name1'=>'', 'email1'=>'Email already Exist', 'mobile1'=>'', 'role1'=>'','password1'=>'','confirm_password1' =>'');
                    }
                }
                else{
                    $saveUserdata = $this->user_model->saveUserdata($userId,$data);
                    if($saveUserdata){
                        $createuser_response['status'] = 'success';
                        
                        if(empty($this->input->post('password1')))
                        {
                            $createuser_response['error'] = array('name1'=>'', 'email1'=>'', 'mobile1'=>'', 'role1'=>'');
                        }else
                        {
                            $createuser_response['error'] = array('name1'=>'', 'email1'=>'', 'mobile1'=>'', 'role1'=>'','password1'=>'','confirm_password1' =>'');
                        }
                    }
                }
            }
    
            echo json_encode($createuser_response);
        }
    }

    function get_signle_user_for_edit($userId = NULL)
    {
        // $data['roles'] = $this->user_model->getUserRoles();
        $data = $this->user_model->getUserInfo($userId);
        echo json_encode($data);
    }

    function deleteUser()
    {
        $post_submit = $this->input->post();
        if(!empty($post_submit)){
            $userInfo = array('isDeleted'=>1,'updatedBy'=>1, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->course_model->data_update('tbl_users',$userInfo,'userId',$this->input->post('id'));
            if($result){
                $deleteuser_response['status'] = 'success';
                $process = 'User Delete';
                $processFunction = 'Admin/deleteUser';
                $this->logrecord($process,$processFunction);
            }else
            {
                $deleteuser_response['status'] = 'filure';
            }
            echo json_encode($deleteuser_response);
        }
    }
        
     /**
     * This function is used to load the staff list
     */
    // function staffListing()
    // {   
    //         $searchText = $this->security->xss_clean($this->input->post('searchText'));
    //         $data['searchText'] = $searchText;
    //         $data['staffRecords'] = $this->user_model->staffListing($searchText);
            
            
    //         $process = 'Staff Listing';
    //         $processFunction = 'Admin/staffListing';
    //         $this->logrecord($process,$processFunction);

    //         $this->global['pageTitle'] = 'ADMIN : Staff List';
            
    //         $this->loadViews("master/staff", $this->global, $data, NULL);
    // }
    function staffListing()
    {          
            $this->global['pageTitle'] = 'Staff List';
            $data['role'] = $this->user_model->getUserRoles();
            $this->loadViews("master/staff", $this->global, $data, NULL);
    }

    public function fetchStaff(){
        
        $params = $_REQUEST;
        $totalRecords = $this->user_model->getStaffCount($params); 
        $queryRecords = $this->user_model->getStaffdata($params); 

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


    // =======================================


}

?>