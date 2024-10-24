<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
    function loginMe($username, $password)
    {


        $this->db->select('BaseTbl.enq_id,BaseTbl.userId, BaseTbl.password, BaseTbl.name,BaseTbl.status,BaseTbl.roleId, Roles.role,Roles.access,BaseTbl.profile_pic,BaseTbl.username');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
       
        // $this->db->where('BaseTbl.email', $email);
        
        $likeCriteria = "(BaseTbl.email  LIKE '%".$username."%' OR  BaseTbl.username  LIKE '%".$username."%' OR  BaseTbl.mobile  LIKE '%".$username."%')";
        $this->db->where($likeCriteria);

        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        $user = $query->result();
        
        if(!empty($user)){
            if(trim($password)== base64_decode($user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    /**
     * This function used to check email exists or not
     * @param {string} $email : This is users email id
     * @return {boolean} $result : TRUE/FALSE
     */
    function checkEmailExist($email)
    {
        $this->db->select('userId');
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');

        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }


    /**
     * This function used to insert reset password data
     * @param {array} $data : This is reset password data
     * @return {boolean} $result : TRUE/FALSE
     */
    function resetPasswordUser($data)
    {
        $result = $this->db->insert('tbl_reset_password', $data);

        if($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * This function is used to get customer information by email-id for forget password email
     * @param string $email : Email id of customer
     * @return object $result : Information of customer
     */
    function getCustomerInfoByEmail($email)
    {
        $this->db->select('userId, email, name');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('email', $email);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function used to check correct activation deatails for forget password.
     * @param string $email : Email id of user
     * @param string $activation_id : This is activation string
     */
    function checkActivationDetails($email, $activation_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_reset_password');
        $this->db->where('email', $email);
        $this->db->where('activation_id', $activation_id);
        $query = $this->db->get();
        return $query->num_rows;
    }

    // This function used to create new password by reset link
    function createPasswordUser($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', array('password'=>getHashedPassword($password)));
        $this->db->delete('tbl_reset_password', array('email'=>$email));
    }

     /**
     * This function used to save login information of user
     * @param array $loginInfo : This is users login information
     */
    // function loginsert($logInfo)
    // {
    //     $this->db->trans_start();
    //     $this->db->insert('tbl_log', $logInfo);
    //     $this->db->trans_complete();
    // }

    /**
     * This function is used to get last login info by user id
     * @param number $userId : This is user id
     * @return number $result : This is query result
     */
    // function lastLoginInfo($userId)
    // {
    //     $this->db->select('BaseTbl.createdDtm');
    //     $this->db->where('BaseTbl.userId', $userId);
    //     $this->db->order_by('BaseTbl.id', 'DESC');
    //     $this->db->limit(1);
    //     $query = $this->db->get('tbl_log as BaseTbl');

    //     return $query->row();
    // }
}

?>