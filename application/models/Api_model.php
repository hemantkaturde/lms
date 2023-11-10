<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model
{

    public function getAuthtoken($data) {
		
		try{
            extract($data);

            $this->db->select('BaseTbl.isDeleted');
            $this->db->from('tbl_users as BaseTbl');
            $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId'); 
            $likeCriteria = "(BaseTbl.email  LIKE '%".$username."%' OR  BaseTbl.username  LIKE '%".$username."%' OR  BaseTbl.mobile  LIKE '%".$username."%')";
            $this->db->where($likeCriteria);
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->limit(1);
            $query = $this->db->get();
            $user_data = $query->row();

            if($user_data){
                if($user_data->isDeleted == 0){
                    $this->db->select('BaseTbl.enq_id,BaseTbl.userId, BaseTbl.password, BaseTbl.email ,BaseTbl.name,BaseTbl.status,BaseTbl.roleId, Roles.role,Roles.access,BaseTbl.profile_pic,BaseTbl.username,BaseTbl.password,BaseTbl.mobile,BaseTbl.user_flag');
                    $this->db->from('tbl_users as BaseTbl');
                    $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId'); 
                    $likeCriteria = "(BaseTbl.email  LIKE '%".$username."%' OR  BaseTbl.username  LIKE '%".$username."%' OR  BaseTbl.mobile  LIKE '%".$username."%')";
                    $this->db->where($likeCriteria);
                    $this->db->limit(1);
                    $query = $this->db->get();
                    $get_actual_user_data = $query->row();

                    if(trim($password)== base64_decode($get_actual_user_data->password)){
                        $authtoken = uniqueAlphaNumericString(30); //30 digit authtoken
                        $this->db->where('userId',$get_actual_user_data->userId);
                        $this->db->update(TBL_USER, array(
                            'authtoken' => $authtoken,
                            'updatedDtm' => DATEANDTIME
                        ));
                        return array('authtoken' => $authtoken,'id' => $get_actual_user_data->userId,'name' => $get_actual_user_data->name,'email' => $get_actual_user_data->email, 'username' => $get_actual_user_data->username,'mobile_no' => $get_actual_user_data->mobile,'user_flag' =>  $get_actual_user_data->user_flag);
                    } else {
                        return "password mismatch";
                    }
                }else{
                    return "account disable";
                }
            }else{
                return "Username not available";
            }

        }catch (Exception $e) {
            return $e->getMessage();
        }
    }

}

?>