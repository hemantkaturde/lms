<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Enquiry_model extends CI_Model
{
    function enquiryListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.enq_id , BaseTbl.enq_fullname, BaseTbl.enq_mobile, BaseTbl.enq_email, BaseTbl.enq_qualification, BaseTbl.enq_source, BaseTbl.enq_date');
        $this->db->from('tbl_enquiry as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.enq_fullname  LIKE '%".$searchText."%'
                            OR  BaseTbl.enq_mobile  LIKE '%".$searchText."%'
                            OR  BaseTbl.enq_email  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.enq_id', 'desc');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function enquiryListing($searchText = '')
    {
        $this->db->select('BaseTbl.enq_id , BaseTbl.enq_fullname, BaseTbl.enq_mobile, BaseTbl.enq_email, BaseTbl.enq_qualification, BaseTbl.enq_source, BaseTbl.enq_date');
        $this->db->from('tbl_enquiry as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.enq_fullname  LIKE '%".$searchText."%'
                            OR  BaseTbl.enq_mobile  LIKE '%".$searchText."%'
                            OR  BaseTbl.enq_email  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.enq_id', 'desc');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;      
    }
        
        /*
        Get Single course
        */ 
        public function getEnquiryInfo($enqId)
        {
            $this->db->select('BaseTbl.* ');
            $this->db->from('tbl_enquiry as BaseTbl');
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->where('BaseTbl.enq_id', $enqId);
            $query = $this->db->get();
            
            return $query->result();
        }
}

?>