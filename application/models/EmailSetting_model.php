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
        $this->db->select('BaseTbl.smtpId, BaseTbl.smtp_host, BaseTbl.smtp_username, BaseTbl.smtp_password, BaseTbl.smtp_port, BaseTbl.smtp_protocol');
        $this->db->from('tbl_email_smtp as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.smtpId', $smtpId);
        $query = $this->db->get();
        
        return $query->result();
    }

}

?>