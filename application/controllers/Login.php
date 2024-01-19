<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Login extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }

    /**
     * This function is used to open error /404 not found page
     */
    public function error()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            $process = 'Hata';
            $processFunction = 'Login/error';
            $this->logrecord($process,$processFunction);
            redirect('pageNotFound');
        }
    }

    /**
     * This function is used to access denied page
     */
    public function noaccess() {
        
        $this->global['pageTitle'] = 'ADMIN : Access Denied';
        $this->datas();
        $this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'access' );
		$this->load->view ( 'includes/footer' );
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            redirect('/dashboard');
        }
    }

    public function login()
    {
        $this->load->view('login');
    }

    public function loginMe()
    {
        $post_submit = $this->input->post();
        if($post_submit){
 
                $this->load->library('form_validation');
                $this->form_validation->set_rules('username', 'username', 'required|trim');
                $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
            
                if($this->form_validation->run() == FALSE)
                {
                    $this->load->view('login');
                }
                else
                {
                    $username = $this->security->xss_clean($this->input->post('username'));
                    $password = $this->input->post('password');
                    $result = $this->login_model->loginMe($username, $password);

                    if(count($result) > 0)
                    {
                        foreach ($result as $res)
                        {
                            // $lastLogin = $this->login_model->lastLoginInfo($res->userId);
                            $process = 'Login';
                            $processFunction = 'Login/loginMe';

                            $sessionArray = array('userId'=>$res->userId,                    
                                                    'role'=>$res->roleId,
                                                    'roleText'=>$res->role,
                                                    'name'=>$res->name,
                                                    // 'lastLogin'=> $lastLogin->createdDtm,
                                                    'status'=> $res->status,
                                                    'access' => $res->access,
                                                    'profile_pic' => $res->profile_pic,
                                                    'username' => $res->username,
                                                    'enq_id' => $res->enq_id,
                                                    'isLoggedIn' => TRUE
                                            );

                            $this->session->set_userdata($sessionArray);
                            //unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
                            $this->logrecord($process,$processFunction);
                            echo 1;
                        }
                    }
                    else
                    {
                        echo 0;
                    }
                }
           }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

}

?>