<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Admin (AdminController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Samet Aydın / sametay153@gmail.com
 * @version : 1.0
 * @since : 27.02.2018
 */
class Role extends BaseController
{
      /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('role_model');
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

     /**
     * This function is used to load the role list
     */

    function roleListing()
    {   
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            // $this->load->library('pagination');
            
            // $count = $this->role_model->roleListingCount($searchText);

			// $returns = $this->paginationCompress ( "roleListing/", $count, 10 );
            
            $data['userRecords'] = $this->role_model->roleListing($searchText);
            // $data['userRecords'] = $this->role_model->roleListing($searchText, $returns["page"], $returns["segment"]);
            
            $process = 'Role List';
            $processFunction = 'Role/roleListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'ADMIN : Role List';
            
            $this->loadViews("role/role", $this->global, $data, NULL);
    }

    /**
     * ADD NEW ROLE
     */
    function addRole()
    {
        $this->global['pageTitle'] = 'ADMIN : ADD ROLE';
        $this->loadViews("role/addRole", $this->global,NULL);
    }

    // INSERT NEW ROLE
    function addNewRole()
    {
        $this->load->library('form_validation');
            
        $this->form_validation->set_rules('role','Role','trim|required|max_length[128]');

        // $this->form_validation->set_rules('checkbox','Assign Roles Checkbox','trim|required|max_length[128]');
            
        if($this->form_validation->run() == FALSE)
        {
            $this->addRole();
        }
        else
        {
            $access_chk=$_POST['checkbox'];
        
            $role = $this->security->xss_clean($this->input->post('role'));
            $discription = $this->security->xss_clean($this->input->post('discription'));
            $roletype = $this->security->xss_clean($this->input->post('roletype'));
            $roleInfo = array(
                'role'=>$role, 
                'discription'=>$discription, 
                'role_type'=>$roletype, 
                'createdBy'=>$this->vendorId, 
                'access'=>json_encode($access_chk),
                'createdBy'=>'', 
                'createdDtm'=>date('Y-m-d H:i:s'));
                                    
            $result = $this->role_model->addNewRole($roleInfo);
            if($result > 0)
            {
                $process = 'Role / Role Adding';
                $processFunction = 'Role/addNewRole';
                $this->logrecord($process,$processFunction);
                // $this->session->set_flashdata('success', 'Role Successfully Created');
            }
            else
            {
                // $this->session->set_flashdata('error', 'Role Failed to Create');
                echo false;
            }
                
            // redirect('roleListing');
            echo true;
        }
    }

    //  EDIT ROLE PAGE
    
    function editRole($roleId = NULL)
    {
        if($roleId == null)
        {
            redirect('roleListing');
        }
                
        $data['roleInfo'] = $this->role_model->getRoleInfo($roleId);
        $this->global['pageTitle'] = 'ADMIN : Role Edit';
        $this->loadViews("role/editRole", $this->global, $data, NULL);
    }

    // UPDATE ROLE RECORD    
    function editRoleRecord($roleId)
    {
        $this->load->library('form_validation');
                
        // $roleId = $this->input->post('roleId');
        $this->form_validation->set_rules('role','Role','trim|required|max_length[128]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->editRole($Id);
        }
        else
        {
            $role = $this->security->xss_clean($this->input->post('role'));
            $discription = $this->security->xss_clean($this->input->post('discription'));
            $roletype = $this->security->xss_clean($this->input->post('roletype'));
            $access_chk=$_POST['checkbox'];
                    
            $roleInfo = array();
            
            $roleInfo = array(
                'role'=>$role, 
                'discription'=>$discription,
                'role_type'=>$roletype,
                'updatedBy'=>$this->vendorId,
                'access'=>json_encode($access_chk), 
                'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->role_model->editRoleInfo($roleInfo, $roleId);
                    
            if($result == true)
            {
                        $process = 'Role Update';
                        $processFunction = 'Role/editRole';
                        $this->logrecord($process,$processFunction);
    
                        // $this->session->set_flashdata('success', 'Role Successfully Updated');
                        echo true;
                    }
                    else
                    {
                        // $this->session->set_flashdata('error', 'Please Check Details Properly');
                        echo false;
                    }
                    
                    // redirect('roleListing');
                }
        }

    // === DELETE VENDOR ======
    function deleteRole($roleId)
    {
            // $roleId = $this->input->post('roleId');
            $roleInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->role_model->deleteRoleRecord($roleId, $roleInfo);
            
            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Role Deletion';
                 $processFunction = 'Role/deleteRole';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
    }
}