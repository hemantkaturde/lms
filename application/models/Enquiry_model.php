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



    public function getEnquiryCount(){
        $this->db->select('*');
        $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE.'.isDeleted', 0);
        $query = $this->db->get(TBL_COURSE);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getEnquirydata(){
        $this->db->select('*');
        $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE.'.isDeleted', 0);
        $this->db->order_by(TBL_COURSE.'.courseId', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_COURSE);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {

                //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
                 $data[$counter]['course_name'] = $value['course_name'];
                 $data[$counter]['course_type'] = $value['ct_name'];
                 $data[$counter]['course_fees'] = $value['course_fees'];
                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Equipment' title='Edit Equipment'></a>&nbsp;";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_course' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Equipment' title='Delete Equipment'></a>&nbsp"; 
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='add_links' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/add_links.png  alt='Delete Equipment' title='Delete Equipment'></a> &nbsp"; 
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='view_document' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/view_doc.png alt='Delete Equipment' title='Delete Equipment'></a> &nbsp"; 
            
                $counter++; 
            }
        }

        return $data;
    }


   public function checkuniqeenquiryname(){

    
    
   }

     
}

?>