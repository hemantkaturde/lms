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
            $this->db->select('*');
            $this->db->join('tbl_course', 'tbl_course.courseId = tbl_enquiry.enq_course_id');
            $this->db->join('tbl_course_type', 'tbl_course.course_type_id = tbl_course_type.ct_id');
            $this->db->from('tbl_enquiry');
           // $this->db->where('tbl_enquiry.isDeleted', 0);
            $this->db->where('tbl_enquiry.enq_id', $enqId);
            $query = $this->db->get();
            return $query->result();
        }



    public function getEnquiryCount($params){
        $this->db->select('*');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_ENQUIRY.'.course_type_id','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
        $query = $this->db->get(TBL_ENQUIRY);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getEnquirydata($params){
        $this->db->select('*');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
        $this->db->order_by(TBL_ENQUIRY.'.enq_id', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_ENQUIRY);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {

                //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
                 $data[$counter]['enq_number'] = $value['enq_number'];
                 $data[$counter]['enq_date'] = date('d-m-Y', strtotime($value['enq_date']));
                 $data[$counter]['enq_fullname'] = $value['enq_fullname'];
                 $data[$counter]['enq_mobile'] = $value['enq_mobile'];
                 $data[$counter]['enq_email'] = $value['enq_email'];

                 if($value['payment_status']=='0'){
                    $data[$counter]['status'] = 'In Follow up';
                 }else if($value['payment_status']=='1'){
                    $data[$counter]['status'] = 'Admitted';
                 }else{
                    $data[$counter]['status'] = 'In Follow up';
                 }
               
                 $course_ids    =   explode(',', $value['enq_course_id']);

                 $total_fees = 0;
                 $course_name = '';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                        $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                        $total_fees += $get_course_fees[0]->course_total_fees;
                        $course_name .= $i.'-'.$get_course_fees[0]->course_name. ',';  
                        $i++;  
                    }
                 $all_course_name = trim($course_name, ', '); 
                 $data[$counter]['total_fees'] = '₹ '.$total_fees ;

                 $data[$counter]['action'] = '';
                //  $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_enquiry' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Enquiry' title='Edit Equipment'></a>&nbsp;";
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editenquiry/".$value['enq_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/edit.png' alt='Edit Enquiry' title='Edit Enquiry'></a>&nbsp;";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='view_enquiry_details' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/view_doc.png alt='View Enquiry Details' title='View Enquiry Details'></a>&nbsp;";
                 
                 if($value['payment_status']!=1){
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='Follow Up' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/follow_up.png  alt='Follow Up' title='Follow Up'></a> &nbsp";
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='Follow Up' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/whatsapp.png  alt='Whats Up Link' title='Whats Up Link'></a> &nbsp";
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='send_payment_link' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/send-link.png  alt='Send Payment Link' title='Send Payment Link'></a> &nbsp"; 
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_enquiry' data-id='".$value['enq_id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Equipment' title='Delete Equipment'></a>&nbsp"; 
                 }
                
                $counter++; 
            }
        }
        return $data;
    }

    public function saveEnquirydata($id,$data){

        if($id != '') {
            $this->db->where('enq_id', $id);
            if($this->db->update(TBL_ENQUIRY, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_ENQUIRY, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function checkuniqeenquiryname($enq_fullname){
        $this->db->select('enq_fullname');
        $this->db->from(TBL_ENQUIRY);
        $this->db->where('isDeleted', 0);
        $this->db->where('enq_fullname', $enq_fullname);
        $query = $this->db->get();
        return $query->result();
    }

    public function checkuniqeenquiryname_update($enq_id,$enq_fullname){
        $this->db->select('enq_id,enq_fullname');
        $this->db->from(TBL_ENQUIRY);
        $this->db->where('isDeleted', 0);
        $this->db->where('enq_id !=', $enq_id);
        $this->db->where('enq_fullname', $enq_fullname);
        $query = $this->db->get();
        return $query->result();
    }

    public function getautonumberfromEnquiry(){

        $this->db->select('enq_number');
        $this->db->from(TBL_ENQUIRY);
        $this->db->where('isDeleted', 0);
        $this->db->order_by('enq_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }


    public function getEnquiryInfobyenqnumber($enqId){

            // $this->db->select('BaseTbl.* ');
            // $this->db->from('tbl_enquiry as BaseTbl');
            // $this->db->where('BaseTbl.isDeleted', 0);
            // $this->db->where('BaseTbl.enq_number', $enqId);
            // $query = $this->db->get();
            // return $query->result();

            $this->db->select('*');
            $this->db->join('tbl_course', 'tbl_course.courseId = tbl_enquiry.enq_course_id');
            $this->db->join('tbl_course_type', 'tbl_course.course_type_id = tbl_course_type.ct_id');
            $this->db->from('tbl_enquiry');
            $this->db->where('tbl_enquiry.isDeleted', 0);
            $this->db->where('tbl_enquiry.enq_number', $enqId);
            $query = $this->db->get();
            return $query->result();

    }


    public function payment($data){

            if($this->db->insert(TBL_PAYMENT, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
    }

    public function update_paymentstatus_enquiry($enquiry_number,$enquiry_data){
        $this->db->where('enq_number', $enquiry_number);
        if($this->db->update(TBL_ENQUIRY, $enquiry_data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function checkifpaymentdoneornot($id){

        $this->db->select('tbl_enquiry.payment_status');
        $this->db->from('tbl_enquiry');
        $this->db->where('tbl_enquiry.isDeleted', 0);
        //$this->db->where('tbl_enquiry.payment_status', 1);
        $this->db->where('tbl_enquiry.enq_number', $id);
        $query = $this->db->get();
        return $query->result();
    }


    public function getEnquiryInfobyenquirynumber($enquiry_number){

        $this->db->select('*');
        $this->db->from('tbl_enquiry');
        $this->db->where('tbl_enquiry.isDeleted', 0);
        //$this->db->where('tbl_enquiry.payment_status', 1);
        $this->db->where('tbl_enquiry.enq_number', $enquiry_number);
        $query = $this->db->get();
        return $query->result();
        
    }


    public function getCourseInfo($id){
        $this->db->select('courseId,course_total_fees,course_name');
        $this->db->from('tbl_course');
        $this->db->where('tbl_course.isDeleted', 0);
        //$this->db->where('tbl_enquiry.payment_status', 1);
        $this->db->where('tbl_course.courseId', $id);
        $query = $this->db->get();
        return $query->result();

    }


}

?>