<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class EmailSetting_model extends CI_Model
{
    function emailtemplateListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.etempId , BaseTbl.etemp_name, BaseTbl.etemp_desc, BaseTbl.etemp_module');
        $this->db->from('tbl_email_template as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.etemp_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.etemp_desc  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.etempId', 'desc');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function emailtemplateListing($searchText = '')
    {
        $this->db->select('BaseTbl.etempId , BaseTbl.etemp_name, BaseTbl.etemp_desc, BaseTbl.etemp_module');
        $this->db->from('tbl_email_template as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.etemp_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.etemp_desc  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.etempId', 'desc');
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }

    function getTemplateInfo($templateId)
    {
        $this->db->select('BaseTbl.etempId , BaseTbl.etemp_name, BaseTbl.etemp_desc, BaseTbl.etemp_module');
        $this->db->from('tbl_email_template as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.etempId', $templateId);
        $query = $this->db->get();
        
        return $query->result();
    }

    //  ====== SMTP SETTING ============== 

    function emailsmtpListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.smtpId, BaseTbl.smtp_host, BaseTbl.smtp_username, BaseTbl.smtp_password, BaseTbl.smtp_port, BaseTbl.smtp_protocol');
        $this->db->from('tbl_email_smtp as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.smtp_host  LIKE '%".$searchText."%'
                            OR  BaseTbl.smtp_username  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.smtpId', 'desc');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function emailsmtpListing($searchText = '')
    {
        $this->db->select('BaseTbl.smtpId, BaseTbl.smtp_host, BaseTbl.smtp_username, BaseTbl.smtp_password, BaseTbl.smtp_port, BaseTbl.smtp_protocol');
        $this->db->from('tbl_email_smtp as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.smtp_host  LIKE '%".$searchText."%'
                            OR  BaseTbl.smtp_username  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.smtpId', 'desc');
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }

    function getSmtpInfo($smtpId)
    {
        $this->db->select('*');
        $this->db->from('tbl_email_smtp as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.smtpId', $smtpId);
        $query = $this->db->get();
        
        return $query->result();
    }


    public function  getTemplateCount($params){
        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_EMAIL_SMTP.".smtp_host LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_EMAIL_SMTP.".smtp_port LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_EMAIL_SMTP.".smtp_protocol LIKE '%".$params['search']['value']."%')");
            $this->db->or_where(TBL_EMAIL_SMTP.".smtp_username LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_EMAIL_SMTP.'.isDeleted', 0);
        $query = $this->db->get(TBL_EMAIL_SMTP);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getTemplatedata($params){
        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_EMAIL_SMTP.".smtp_host LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_EMAIL_SMTP.".smtp_port LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_EMAIL_SMTP.".smtp_protocol LIKE '%".$params['search']['value']."%')");
            $this->db->or_where(TBL_EMAIL_SMTP.".smtp_username LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_EMAIL_SMTP.'.isDeleted', 0);
        $this->db->order_by(TBL_EMAIL_SMTP.'.smtpId ', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_EMAIL_SMTP);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;

        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['smtp_host']    = $value['smtp_host'];
                 $data[$counter]['smtp_port']   = $value['smtp_port'];
                 $data[$counter]['smtp_protocol']  = $value['smtp_protocol'];
                 $data[$counter]['smtp_username']    = $value['smtp_username'];
                 $data[$counter]['smtp_password']    = $value['smtp_password'];
                 $data[$counter]['action']  = '';
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_smtp' data-id='".$value['smtpId']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit User' title='Edit User'></a> | ";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_smtp' data-id='".$value['smtpId']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete User' title='Delete User'> "; 
                $counter++; 
            }
        }
        return $data;
    }


    public function saveSmtpdata($id,$data){

        if($id != '') {
            $this->db->where('smtpId', $id);
            if($this->db->update(TBL_EMAIL_SMTP, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_EMAIL_SMTP, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    
    public function data_update($table='',$arr='',$field='',$value=''){
        // $this->CI->db->where($field,$value);
        // return $this->CI->db->update($table,$arr);
        $this->db->where($field, $value);
        return  $this->db->delete($table);
    }


}

?>