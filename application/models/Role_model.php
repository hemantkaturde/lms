<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends CI_Model
{
    public function getRoleCount($params){
        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ROLES.".role LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ROLES.".discription LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ROLES.'.isDeleted', 0);
        $query = $this->db->get(TBL_ROLES);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getRoledata($params){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ROLES.".role LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ROLES.".discription LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ROLES.'.isDeleted', 0);

        $this->db->order_by(TBL_ROLES.'.roleId ', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_ROLES);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['role'] = $value['role'];
                 $data[$counter]['discription'] = $value['discription'];
                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editRole/".$value['roleId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/edit.png' alt='Edit Role' title='Edit Role'></a>&nbsp;";
                
                if($value['roleId']==1 || $value['roleId']==2  || $value['roleId']==3 || $value['roleId']==4 || $value['roleId']==5 || $value['roleId']==6){

                }else{
                    $data[$counter]['action'] .= "<a style='cursor: pointer;' class='deleteRole' data-id='".$value['roleId']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Role' title='Delete Role'></a>&nbsp"; 
                }
                $counter++; 
            }
        }
        return $data;
    }

   public function checkquniqerolename($role){
        $this->db->select('role');
        $this->db->from(TBL_ROLES);
        $this->db->where('isDeleted', 0);
        $this->db->where('role', $role);
        $query = $this->db->get();
        return $query->result();
   }


   public function saveRoledata($id,$data){

    if($id != '') {
        $this->db->where('roleId', $id);
        if($this->db->update(TBL_ROLES, $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        if($this->db->insert(TBL_ROLES, $data)) {
            return $this->db->insert_id();;
        } else {
            return FALSE;
        }
    }
}


public function  getRoledataedit($roleId){

    $this->db->select('*');
    $this->db->from(TBL_ROLES);
    $this->db->where('isDeleted', 0);
    $this->db->where('roleid', $roleId);
    $query = $this->db->get();
    return $query->result();
}


public function  checkquniqeRolenameupdate($roleId ,$role){
    $this->db->select('*');
    $this->db->from(TBL_ROLES);
    $this->db->where('isDeleted', 0);
    $this->db->where('roleid', $roleId);
    $this->db->where('role', $roleId);
    $query = $this->db->get();
    return $query->result();
}

public function deleteRole($id){
    $this->db->where('roleid', $id);
    $this->db->delete(TBL_ROLES);
    return true;
}

public function checkRelation($id){

    $this->db->select('*');
    $this->db->from(TBL_USER);
    $this->db->where('isDeleted', 0);
    $this->db->where('roleid', $id);
    $query = $this->db->get();
    return $query->result();

}

}