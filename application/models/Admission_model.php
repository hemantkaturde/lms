<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admission_model extends CI_Model
{
    function admissionListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.admissionId , BaseTbl.full_name, BaseTbl.adm_source, BaseTbl.admission_mode, BaseTbl.admission_date');
        $this->db->from('tbl_admission as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.full_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.adm_source  LIKE '%".$searchText."%'
                            OR  BaseTbl.admission_mode  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.admissionId', 'desc');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function admissionListing($searchText = '')
    {
        $this->db->select('BaseTbl.admissionId , BaseTbl.full_name, BaseTbl.adm_source, BaseTbl.admission_mode, BaseTbl.admission_date');
        $this->db->from('tbl_admission as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.full_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.adm_source  LIKE '%".$searchText."%'
                            OR  BaseTbl.admission_mode  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.admissionId', 'desc');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;      
    }
        
        /*
        Get Single course
        */ 
        public function getAdmissionInfo($admissionId)
        {
            $this->db->select('BaseTbl.* ');
            $this->db->from('tbl_admission as BaseTbl');
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->where('BaseTbl.admissionId', $admissionId);
            $query = $this->db->get();
            
            return $query->result();
        }

        public function getAdmissionsCount($params){
            $this->db->select('*');
            // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_ENQUIRY.'.course_type_id','left');
    
            if($params['search']['value'] != "") 
            {
                $this->db->where("(".TBL_ADMISSION.".name LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_ADMISSION.".name LIKE '%".$params['search']['value']."%')");
            }
            $this->db->where(TBL_ADMISSION.'.isDeleted', 0);
            $query = $this->db->get(TBL_ADMISSION);
            $rowcount = $query->num_rows();
            return $rowcount;


        }

        public function getAdmissionsdata($params){

            $this->db->select('*');
            // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
            if($params['search']['value'] != "") 
            {
                $this->db->where("(".TBL_ADMISSION.".name LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_ADMISSION.".name LIKE '%".$params['search']['value']."%')");
            }
            $this->db->where(TBL_ADMISSION.'.isDeleted', 0);
            $this->db->order_by(TBL_ADMISSION.'.enq_id', 'DESC');
            $this->db->limit($params['length'],$params['start']);
            $query = $this->db->get(TBL_ADMISSION);
            $fetch_result = $query->result_array();
            $data = array();
            $counter = 0;
            if(count($fetch_result) > 0)
            {
                foreach ($fetch_result as $key => $value)
                {
    
                    //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
                     $data[$counter]['mobile'] = $value['mobile'];
                     $data[$counter]['createdDtm'] = $value['createdDtm'];
                     $data[$counter]['name'] = $value['name'];
                     $data[$counter]['email'] = $value['email'];
                     $data[$counter]['address'] = $value['address'];
    
                
                     $data[$counter]['action'] = '';
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_enquiry' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Equipment' title='Edit Equipment'></a>&nbsp;";
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='view_enquiry_details' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/view_doc.png alt='View Enquiry Details' title='View Enquiry Details'></a>&nbsp;";
                    // $data[$counter]['action'] .= "<a style='cursor: pointer;' class='Follow Up' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/follow_up.png  alt='Follow Up' title='Follow Up'></a> &nbsp";
                    // $data[$counter]['action'] .= "<a style='cursor: pointer;' class='Follow Up' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/whatsapp.png  alt='Whats Up Link' title='Whats Up Link'></a> &nbsp";
                    // $data[$counter]['action'] .= "<a style='cursor: pointer;' class='send_payment_link' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/send-link.png  alt='Send Payment Link' title='Send Payment Link'></a> &nbsp"; 
                    $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_enquiry' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Equipment' title='Delete Equipment'></a>&nbsp"; 
                    
                    
                    $counter++; 
                }
            }
            return $data;
        }
}

?>