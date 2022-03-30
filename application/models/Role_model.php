<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends CI_Model
{

     /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function roleListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.roleid, BaseTbl.role, BaseTbl.discription');
        $this->db->from('tbl_roles as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.role  LIKE '%".$searchText."%'
                            OR  BaseTbl.discription  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.roleid', 'desc');
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
    function roleListing($searchText = '')
    {
        $this->db->select('BaseTbl.roleid, BaseTbl.role, BaseTbl.discription');
        $this->db->from('tbl_roles as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.role  LIKE '%".$searchText."%'
                            OR  BaseTbl.discription  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.roleid', 'desc');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    // ======= INSERT VENDOR ========
    function addNewRole($roleInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_roles', $roleInfo);    
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    //  ========= UPDATE ROLE INFO =======
    function getRoleInfo($roleId)
    {
        $this->db->select('roleId, role, discription,access,role_type');
        $this->db->from('tbl_roles');
        $this->db->where('isDeleted', 0);
        $this->db->where('roleId', $roleId);
        $query = $this->db->get();
        return $query->result();
    }
    // EDIT RECORD
    function editRoleInfo($roleInfo, $roleId)
    {
        $this->db->where('roleId', $roleId);
        $this->db->update('tbl_roles', $roleInfo);
        
        return TRUE;
    }

    // DELETE RECORD
    function deleteRoleRecord($roleId,$roleInfo)
    {
        $this->db->where('roleId', $roleId);
        $this->db->update('tbl_roles', $roleInfo); 
        return $this->db->affected_rows();
    }


}