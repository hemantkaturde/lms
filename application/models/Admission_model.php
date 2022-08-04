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
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_admission' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Admission' title='Edit Admission'></a>&nbsp;";
                    // $data[$counter]['action'] .= "<a style='cursor: pointer;' class='view_admission_details' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/view_doc.png alt='View Admission Details' title='View Admission Details'></a>&nbsp;";
                     $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewadmissiondetails/".$value['id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/view_doc.png' alt='View Admission Details' title='View Admission Details'></a>&nbsp;";
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_admission' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Admission' title='Delete Admission'></a>&nbsp"; 
                    $counter++; 
                }
            }
            return $data;
        }
       
        public function checkRelationadmission($id){

            $this->db->select('*');
            $this->db->from(TBL_PAYMENT);
            $this->db->where('payment_status', 1);
            $this->db->where('enquiry_number', $id);
            $query = $this->db->get();
            return $query->result();
        }

        public function data_update($table='',$arr='',$field='',$value=''){
            // $this->CI->db->where($field,$value);
            // return $this->CI->db->update($table,$arr);
            $this->db->where($field, $value);
            return  $this->db->delete($table);
        }

        public function viewAdmissionDetails($id){

            $this->db->select('*');
            $this->db->from(TBL_ADMISSION);
            $this->db->where('isDeleted', 0);
            $this->db->where('id', $id);
            $query = $this->db->get();
            return $query->result();

        }


}

?>