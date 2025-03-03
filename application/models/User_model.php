<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role, BaseTbl.user_flag');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where_in('BaseTbl.user_flag', 'user');
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role, BaseTbl.user_flag');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where_in('BaseTbl.user_flag', 'user');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    public function  getUserCount($params){
        $this->db->select('*');
        $this->db->join(TBL_ROLES, TBL_ROLES.'.roleId = '.TBL_USER.'.roleId','left');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_USER.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".username LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ROLES.".role LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_USER.'.isDeleted', 0);
        $this->db->where(TBL_USER.'.user_flag', 'user');
        $query = $this->db->get(TBL_USER);
        $rowcount = $query->num_rows();
        
        return $rowcount;

    }

    public function getUserData($params){
        $this->db->select('*');
        $this->db->join(TBL_ROLES, TBL_ROLES.'.roleId = '.TBL_USER.'.roleId','left');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_USER.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".username LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ROLES.".role LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_USER.'.isDeleted', 0);
        $this->db->where(TBL_USER.'.user_flag', 'user');
        $this->db->order_by(TBL_USER.'.userId', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_USER);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;

        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['name']    = $value['name'];
                 $data[$counter]['email']   = $value['email'];
                 $data[$counter]['username']  = $value['username'];
                 $data[$counter]['mobile']  = $value['mobile'];
                 $data[$counter]['role']    = $value['role'];
                 $data[$counter]['action']  = '';
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_user' data-id='".$value['userId']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit User' title='Edit User'></a>&nbsp;";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_user' data-id='".$value['userId']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete User' title='Delete User'></a>&nbsp"; 
                $counter++; 
            }
        }
        return $data;
    }
    
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
        return $query->result();
    }


    function getUserList()
    {
        $this->db->select('*');
        $this->db->from('tbl_enquiry');
        $this->db->group_by('tbl_enquiry.enq_mobile');
        $query = $this->db->get();
        return $query->result();
    }


    function getAdmissionUserList()
    {
        $this->db->select('*');
        $this->db->from(TBL_ADMISSION);
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_ADMISSION.'.enq_id');
        $this->db->where(TBL_ADMISSION.'.isDeleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    
    function getCounsellorList()
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('roleId','5');
        $query = $this->db->get();
        return $query->result();
    }

    public function saveUserdata($id,$data){

        if($id != '') {
            $this->db->where('userId', $id);
            if($this->db->update(TBL_USER, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_USER, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }
    function checkEmailExists($userId=null,$email=null,$flag=null)
    {
        $this->db->select('email');
        $this->db->from(TBL_USER);
        $this->db->where('isDeleted', 0);
        $this->db->where('email', $email);
        if($flag == "user")
        {
            $this->db->where('user_flag', 'user');
        }else
        {
            $this->db->where('user_flag', 'staff');
        }
        
        if($userId !='')
        {
            $this->db->where('userId !=', $userId);    
        }
        $query = $this->db->get();
        return $query->result();
    }

    function checkquniqemobilenumber($userId=null,$mobile=null,$flag=null)
    {
        $this->db->select('mobile');
        $this->db->from(TBL_USER);
        $this->db->where('isDeleted', 0);
        $this->db->where('mobile', $mobile);
        if($flag == "user")
        {
            $this->db->where('user_flag', 'user');
        }else
        {
            $this->db->where('user_flag', 'staff');
        }
        
        if($userId !='')
        {
            $this->db->where('userId !=', $userId);    
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    public function checkquniqeusername($userId=null,$name=null,$flag=null){
        $this->db->select('name');
        $this->db->from(TBL_USER);
        $this->db->where('isDeleted', 0);
        if($flag == "user")
        {
            $this->db->where('user_flag', 'user');
        }else
        {
            $this->db->where('user_flag', 'staff');
        }
        $this->db->where('name', $name);
        if($userId !='')
        {
            $this->db->where('userId !=', $userId);    
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);        
        $insert_id = $this->db->insert_id();        
        $this->db->trans_complete();        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to get user log history count
     * @param number $userId : This is user id
     */
    	
    function logHistoryCount($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_log as BaseTbl');

        if ($userId == NULL)
        {
            $query = $this->db->get();
            return $query->num_rows();
        }
        else
        {
            $this->db->where('BaseTbl.userId', $userId);
            $query = $this->db->get();
            return $query->num_rows();
        }
    }

    /**
     * This function is used to get user log history
     * @param number $userId : This is user id
     * @return array $result : This is result
     */
    function logHistory($userId)
    {
        $this->db->select('*');        
        $this->db->from('tbl_log as BaseTbl');

        if ($userId == NULL)
        {
            $this->db->order_by('BaseTbl.createdDtm', 'DESC');
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }
        else
        {
            $this->db->where('BaseTbl.userId', $userId);
            $this->db->order_by('BaseTbl.createdDtm', 'DESC');
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * This function is used to get the logs count
     * @return array $result : This is result
     */
    function logsCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_log as BaseTbl');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the users count
     * @return array $result : This is result
     */
    function usersCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getUserStatus($userId)
    {
        $this->db->select('BaseTbl.status');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->limit(1);
        $query = $this->db->get('tbl_users as BaseTbl');

        return $query->row();
    }

    // ====== Staff Listing  
    public function  getStaffCount($params){
        $this->db->select('*');
        $this->db->join(TBL_ROLES, TBL_ROLES.'.roleId = '.TBL_USER.'.roleId','left');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_USER.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ROLES.".role LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_USER.'.isDeleted', 0);
        $this->db->where(TBL_USER.'.user_flag', 'staff');
        $query = $this->db->get(TBL_USER);
        $rowcount = $query->num_rows();
        
        return $rowcount;

    }

    public function getStaffData($params){
        $this->db->select('*');
        $this->db->join(TBL_ROLES, TBL_ROLES.'.roleId = '.TBL_USER.'.roleId','left');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_USER.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ROLES.".role LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_USER.'.isDeleted', 0);
        $this->db->where(TBL_USER.'.user_flag', 'staff');
        $this->db->order_by(TBL_USER.'.userId', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_USER);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;

        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['name']    = $value['name'];
                 $data[$counter]['email']   = $value['email'];
                 $data[$counter]['mobile']  = $value['mobile'];
                 $data[$counter]['role']    = $value['role'];
                 $data[$counter]['action']  = '';
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_staff' data-id='".$value['userId']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit User' title='Edit User'></a>&nbsp;";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_staff' data-id='".$value['userId']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete User' title='Delete User'></a>&nbsp"; 
                $counter++; 
            }
        }
        return $data;
    }
   
    
    public function saveStudentexampermissiondata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_STUDENT_REQUEST, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_STUDENT_REQUEST, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

    }

    public function checkifalreadyexitsExamRequest($course_name,$student_name){
        $this->db->select('*');
        $this->db->where(TBL_STUDENT_REQUEST.'.student_id', $student_name);
        $this->db->where(TBL_STUDENT_REQUEST.'.course_id', $course_name);
        $this->db->limit(1);
        $query = $this->db->get(TBL_STUDENT_REQUEST);
        return $query->row();
    }

}

  