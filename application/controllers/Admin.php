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
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('course_model');
        $this->load->model('student_model');
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
        $data['students'] = $this->student_model->studentListingCount();
        $this->loadViews("dashboard", $this->global, $data , NULL);
    }

     /**
     * This function is used to load the user list
     */
    function userListing()
    {          
            $this->global['pageTitle'] = 'ADMIN : User List';
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
            
            $data = array(
                'name'      => $this->input->post('name'),
                'email'     => $this->input->post('email'),
                'mobile'    => $this->input->post('mobile'),
                'password'  => $this->input->post('password'),
                'roleId'    => $this->input->post('role'),
                'user_flag' =>$this->input->post('user_flag')
            );

            $this->form_validation->set_rules('name', 'User Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|numeric');
            $this->form_validation->set_rules('role', 'Role', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

            if($this->form_validation->run() == FALSE){
                $createuser_response['status'] = 'failure';
                $createuser_response['error'] = array('name'=>strip_tags(form_error('name')), 'email'=>strip_tags(form_error('email')), 'mobile'=>strip_tags(form_error('mobile')), 'role'=>strip_tags(form_error('role')),'password'=>strip_tags(form_error('password')),'confirm_password'=>strip_tags(form_error('confirm_password')));
            }else{

                /*check If course name is unique*/
                $check_uniqe =  $this->user_model->checkquniqeusername(trim($this->input->post('name')));
                $check_uniqe1 =  $this->user_model->checkEmailExists(trim($this->input->post('email')));

                if($check_uniqe){
                    $createuser_response['status'] = 'failure';
                    $createuser_response['error'] = array('name'=>'User Name Alreday Exits', 'email'=>'', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password' =>'');
                }
                else if($check_uniqe1){
                    $createuser_response['status'] = 'failure';
                    $createuser_response['error'] = array('name'=>'', 'email'=>'Email already Exist', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password' =>'');
                }
                else{
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

            $createuser_response = array();
            if(empty($this->input->post('password1')))
            {
                $data = array(
                    'name'      => $this->input->post('name1'),
                    'email'     => $this->input->post('email1'),
                    'mobile'    => $this->input->post('mobile1'),
                    'roleId'    => $this->input->post('role1'),
                    'user_flag' =>$this->input->post('user_flag1')
                );
            }else{
                $data = array(
                    'name'      => $this->input->post('name1'),
                    'email'     => $this->input->post('email1'),
                    'mobile'    => $this->input->post('mobile1'),
                    'password'  => getHashedPassword($this->input->post('password1')),
                    'roleId'    => $this->input->post('role1'),
                    'user_flag' =>$this->input->post('user_flag1')
                );
            }

            $this->form_validation->set_rules('name1', 'User Name', 'trim|required');
            $this->form_validation->set_rules('email1', 'Email', 'trim|required');
            $this->form_validation->set_rules('mobile1', 'Mobile No', 'trim|required|numeric');
            $this->form_validation->set_rules('role1', 'Role', 'trim|required');
            if(!empty($this->input->post('password1')))
            {
                $this->form_validation->set_rules('password1', 'Password', 'trim|required');
                $this->form_validation->set_rules('confirm_password1', 'Confirm Password', 'trim|required|matches[password]');
            }            

            if($this->form_validation->run() == FALSE){
                $createuser_response['status'] = 'failure';
                $createuser_response['error'] = array('name1'=>strip_tags(form_error('name1')), 'email1'=>strip_tags(form_error('email1')), 'mobile1'=>strip_tags(form_error('mobile1')), 'role1'=>strip_tags(form_error('role1')),'password1'=>strip_tags(form_error('password1')),'confirm_password1'=>strip_tags(form_error('confirm_password1')));
            }else{

                /*check If user name & email is unique*/
                
                        $check_uniqe =  $this->user_model->checkquniqeusername_update($userId, trim($this->input->post('name1')));
                        $check_uniqe1 =  $this->user_model->checkEmailExists_update($userId, trim($this->input->post('email1')));
                
                
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

    function addNewUser()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'ADMIN : ADD USER';

        $this->loadViews("master/addNewUser", $this->global, $data, NULL);
    }

    function user_insert($id)
    {
        $this->load->library('form_validation');
            
        // $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        // $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
        // $this->form_validation->set_rules('password','Password','required|max_length[20]');
        // $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        // $this->form_validation->set_rules('role','Role','trim|required|numeric');
        // $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        // if($this->form_validation->run() == FALSE)
        // {
        //     $this->addNew();
        // }
        // else
        // {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
            $roleId = $this->input->post('role');
            if($this->input->post('user_flag') == "user")
            {
                $flag = $this->input->post('user_flag');
            }
            else if($this->input->post('user_flag') == "staff")
            {
                $flag = $this->input->post('user_flag');
            }

            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            if($id == 0)
            {
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                                'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'), 'user_flag' => $flag,);
                    
                $result = $this->user_model->addNewUser($userInfo);
            
                if($result > 0)
                {
                $process = 'User Ekleme';
                $processFunction = 'Admin/addNewUser';
                $this->logrecord($process,$processFunction);

                // $this->session->set_flashdata('success', 'UserCreated Successsfully');
                   echo true;
                }
                else
                {
                // $this->session->set_flashdata('error', 'User oluşturma başarısız');
                    echo false;
                }
            }else
            {

                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$name,
                                    'mobile'=>$mobile, 'status'=>0, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile,'status'=>0, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                
                $result = $this->user_model->editUser($userInfo, $id);
                
                if($result == true)
                {
                    $process = 'User Update';
                    $processFunction = 'Admin/editUser';
                    $this->logrecord($process,$processFunction);
                    echo true;
                    // $this->session->set_flashdata('success', 'User başarıyla güncellendi');
                }
                else
                {
                    echo false;
                    // $this->session->set_flashdata('error', 'User Update başarısız');
                }
            }
            // redirect('userListing');
        // }
        
    }

    /**
    * This function is used load user edit information
    * @param number $userId : Optional : This is user id
    */
    function get_signle_user_for_edit($userId = NULL)
    {
        // $data['roles'] = $this->user_model->getUserRoles();
        $data = $this->user_model->getUserInfo($userId);
        echo json_encode($data);
    }

    function editOld($userId = NULL)
    {
        if($userId == null)
        {
            redirect('userListing');
        }
        
        $data['roles'] = $this->user_model->getUserRoles();
        $data['userInfo'] = $this->user_model->getUserInfo($userId);

        $this->global['pageTitle'] = 'ADMIN : User Edit';
        
        $this->loadViews("master/addNewUser", $this->global, $data, NULL);
    }

    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId)
    {
            // $userId = $this->input->post('userId');
            // $userId = $this->input->get('id');
            // print_r($userId);
            // exit;
            $userInfo = array('isDeleted'=>1,'updatedBy'=>1, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->user_model->deleteUser($userId, $userInfo);

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'User Silme';
                 $processFunction = 'Admin/deleteUser';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
    }
    
    
     /**
     * This function is used to load the staff list
     */
    function staffListing()
    {   
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
   //          $this->load->library('pagination');
            
   //          $count = $this->user_model->userListingCount($searchText);

			// $returns = $this->paginationCompress( "userListing/", $count, 10);
            
            // $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            $data['staffRecords'] = $this->user_model->staffListing($searchText);
            
            
            $process = 'Staff Listing';
            $processFunction = 'Admin/staffListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Staff List';
            
            $this->loadViews("master/staff", $this->global, $data, NULL);
    }

    // =======================================


}

?>