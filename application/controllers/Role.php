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
        $this->load->model(array('login_model', 'role_model', 'database'));
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

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

    
    function roleListing()
    {   
            $process = 'Role Listing';
            $processFunction = 'Role/roleListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'Role Listing';
            $this->loadViews("role/role", $this->global, NULL , NULL);
    }

    public function fetchroleListing(){
            $params = $_REQUEST;
            $totalRecords = $this->role_model->getRoleCount($params); 
            $queryRecords = $this->role_model->getRoledata($params); 

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
  
    function addRole()
    {
        $this->global['pageTitle'] = 'Add New Role';
        $this->loadViews("role/addRole", $this->global,NULL);
    }
    
    public function createRole(){
        $post_submit = $this->input->post();

        if($post_submit){
            if(!empty($post_submit)){
                $createrole_response = array();
                $now_date = date('Y-m-d H:i:s');
                $data = array(
                    'role' => $this->input->post('role'),
                    'discription'=> $this->input->post('discription'),
                    'role_type'=> $this->input->post('roletype'),
                    'access'=>json_encode($this->input->post('checkbox')),
                    'isDeleted'=>0,
                    'createdBy'=> $this->session->userdata('userId'),
                    'createdDtm'=> $now_date

                );

                $this->form_validation->set_rules('role', 'Role', 'trim|required');
                $this->form_validation->set_rules('discription', 'Description', 'trim|required');
                $this->form_validation->set_rules('roletype', 'Role Type', 'trim|required');
                //$this->form_validation->set_rules('checkbox', 'Roles', 'trim|required');

                if($this->form_validation->run() == FALSE){
                    $createrole_response['status'] = 'failure';
                    if($this->input->post('checkbox')){
                        $createrole_response['error'] = array('role'=>strip_tags(form_error('role')), 'discription'=>strip_tags(form_error('discription')), 'roletype'=>strip_tags(form_error('roletype')));
                    }else{
                        $createrole_response['error'] = array('role'=>strip_tags(form_error('role')), 'discription'=>strip_tags(form_error('discription')), 'roletype'=>strip_tags(form_error('roletype')), 'checkbox'=>'Roles is Required');
                    }
                 
                }else{

                    if($this->input->post('checkbox')){

                     /*check If course name is unique*/
                     $check_uniqe =  $this->role_model->checkquniqerolename(trim($this->input->post('role')));
                     if($check_uniqe){
                         $createrole_response['status'] = 'failure';
                         $createrole_response['error'] = array('role'=>'Role Alreday Exits', 'discription'=>'', 'roletype'=>'', 'checkbox'=>'');
                        }else{
                         $saveCoursedata = $this->role_model->saveRoledata('',$data);
                         if($saveCoursedata){
                             $createrole_response['status'] = 'success';
                             $createrole_response['error'] = array('role'=>'', 'discription'=>'', 'roletype'=>'', 'checkbox'=>'');
                        }
                     }
                    }else{
                             $createrole_response['status'] = 'failure';
                             $createrole_response['error'] = array('role'=>'', 'discription'=>'', 'roletype'=>'', 'checkbox'=>'Roles is Required');
                    }
                }

                echo json_encode($createrole_response);

            }
        }
    }

    public function editRole($roleId = NULL)
    {
        $getRolldata['roleInfo'] = $this->role_model->getRoledataedit($roleId);
        $this->global['pageTitle'] = 'Edit Role';
        $this->loadViews("role/editRole", $this->global, $getRolldata, NULL);
    }

    public function editRolerecord($roleId){
        $post_submit = $this->input->post();
        $roleId = $this->input->post('roleId');

        if($post_submit){
            if(!empty($post_submit)){
                $editerole_response = array();
                $now_date = date('Y-m-d H:i:s');
                $data = array(
                    'role' => $this->input->post('role'),
                    'discription'=> $this->input->post('discription'),
                    'role_type'=> $this->input->post('roletype'),
                    'access'=>json_encode($this->input->post('checkbox')),
                    'isDeleted'=>0,
                    'updatedBy'=> $this->session->userdata('userId'),
                    'updatedDtm'=> $now_date

                );

                $this->form_validation->set_rules('role', 'Role', 'trim|required');
                $this->form_validation->set_rules('discription', 'Description', 'trim|required');
                $this->form_validation->set_rules('roletype', 'Role Type', 'trim|required');
                //$this->form_validation->set_rules('checkbox', 'Roles', 'trim|required');

                if($this->form_validation->run() == FALSE){
                    $editerole_response['status'] = 'failure';
                    if($this->input->post('checkbox')){
                        $editerole_response['error'] = array('role'=>strip_tags(form_error('role')), 'discription'=>strip_tags(form_error('discription')), 'roletype'=>strip_tags(form_error('roletype')));
                    }else{
                        $editerole_response['error'] = array('role'=>strip_tags(form_error('role')), 'discription'=>strip_tags(form_error('discription')), 'roletype'=>strip_tags(form_error('roletype')), 'checkbox'=>'Roles is Required');
                    }
                 
                }else{

                    if($this->input->post('checkbox')){

                     /*check If course name is unique*/
                     $check_uniqe =  $this->role_model->checkquniqeRolenameupdate($roleId,trim($this->input->post('role')));
                     if($check_uniqe){
                                $saveCoursedata = $this->role_model->saveRoledata($roleId,$data);
                                if($saveCoursedata){
                                    $editerole_response['status'] = 'success';
                                    $editerole_response['error'] = array('role'=>'', 'discription'=>'', 'roletype'=>'', 'checkbox'=>'');
                                }
                        }else{
                                $check_uniqe_update =  $this->role_model->getRoledataedit(trim($this->input->post('role')));
                                if($check_uniqe_update){
                                        $editerole_response['status'] = 'failure';
                                        $editerole_response['error'] = array('role'=>'Role Alreday Exits', 'discription'=>'', 'roletype'=>'', 'checkbox'=>'');
                                }else{
                                    $saveCoursedata = $this->role_model->saveRoledata($roleId,$data);
                                    if($saveCoursedata){
                                        $editerole_response['status'] = 'success';
                                        $editerole_response['error'] = array('role'=>'', 'discription'=>'', 'roletype'=>'', 'checkbox'=>'');
                                    }
                                }                        
                        }
                    }else{
                             $editerole_response['status'] = 'failure';
                             $editerole_response['error'] = array('role'=>'', 'discription'=>'', 'roletype'=>'', 'checkbox'=>'Roles is Required');
                    }
                }

                echo json_encode($editerole_response);

            }
        }

    }

    public function deleteRole(){
        $post_submit = $this->input->post();
        if(!empty($post_submit)){
             $deleterole_response =array();
             /* check if Linked With Other Records*/
             $checkRelation = $this->role_model->checkRelation($this->input->post('id'));
             if($checkRelation){
                $deleterole_response['status'] = 'linked';
             }else{
                    $deleteRoledata = $this->role_model->deleteRole($this->input->post('id'));
                    if($deleteRoledata){
                        $deleterole_response['status'] = 'success';
                        $process = 'Course Delete';
                        $processFunction = 'Course/deleteCourseType';
                        $this->logrecord($process,$processFunction);
                    }else{
                        $deleterole_response['status'] = 'filure';

                    }
             }
            echo json_encode($deleterole_response);
        }
    }

}