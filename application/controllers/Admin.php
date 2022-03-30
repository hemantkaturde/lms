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
        $this->loadViews("dashboard", $this->global, '' , NULL);
    }

     /**
     * This function is used to load the user list
     */
    function userListing()
    {   
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
   //          $this->load->library('pagination');
            
   //          $count = $this->user_model->userListingCount($searchText);

			// $returns = $this->paginationCompress( "userListing/", $count, 10);
            
            // $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            $data['userRecords'] = $this->user_model->userListing($searchText);
            
            $process = 'User Listeleme';
            $processFunction = 'Admin/userListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : User List';
            
            $this->loadViews("master/users", $this->global, $data, NULL);
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
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            if($id == 0)
            {
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                                'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'), 'user_flag' => "user",);
                    
                $result = $this->user_model->addNewUser($userInfo);
            
                if($result > 0)
                {
                $process = 'User Ekleme';
                $processFunction = 'Admin/addNewUser';
                $this->logrecord($process,$processFunction);

                // $this->session->set_flashdata('success', 'UserCreated Successsfully');
                echo 1;
                }
                else
                {
                // $this->session->set_flashdata('error', 'User oluşturma başarısız');
                    echo 0;
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
                    echo 1;
                    // $this->session->set_flashdata('success', 'User başarıyla güncellendi');
                }
                else
                {
                    echo 0;
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
    function deleteUser()
    {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'User Silme';
                 $processFunction = 'Admin/deleteUser';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
    }

}

?>