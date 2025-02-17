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

        if($this->session->userdata('roleText')=='Counsellor'){

            $this->db->where('BaseTbl.counsellor_id', $this->session->userdata('userId'));
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
        $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_ENQUIRY.'.counsellor_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%')");
        }


        if($this->session->userdata('roleText')=='Counsellor'){

            $this->db->where(TBL_ENQUIRY.'.counsellor_id', $this->session->userdata('userId'));
        }

        $this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
        $query = $this->db->get(TBL_ENQUIRY);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getEnquirydata($params){
        $this->db->select('*,'.TBL_ADMISSION.'.enq_id as admissionexits,'.TBL_ENQUIRY.'.enq_id as enquiry_id,'.TBL_USER.'.name as counseller');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
        $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_id','left');
        $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_ENQUIRY.'.counsellor_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%')");
        }

        if($this->session->userdata('roleText')=='Counsellor'){

            $this->db->where(TBL_ENQUIRY.'.counsellor_id', $this->session->userdata('userId'));
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
                 // $data[$counter]['enq_email'] = $value['enq_email'];

                //  if($value['payment_status']=='0'){
                //     $data[$counter]['status'] = 'In Follow up';
                //  }else if($value['payment_status']=='1'){
                //     $data[$counter]['status'] = 'Admitted';
                //  }else{
                //     $data[$counter]['status'] = 'In Follow up';
                //  }

               


                 $course_ids    =   explode(',', $value['enq_course_id']);
             
                 $total_fees = 0;
                 $course_name = '';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                        $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees[0]->course_total_fees;
                            $course_name .= $i.'-'.$get_course_fees[0]->course_name. ' <br>';  
                            $i++;  

                        }else{

                            $total_fees = '';
                            $course_name = '';  
                            $i++;  
                        }
                      
                    }
                 $all_course_name = trim($course_name, ', '); 



                 $data[$counter]['all_course_name'] = $all_course_name ;
                 $data[$counter]['counsellor_name'] = $value['counseller'];

                 if($value['cancle_status']=='1'){
                       $data[$counter]['status'] = 'Cancelled';
                 }else{
                    if(!empty($value['admissionexits'])){
                        $data[$counter]['status'] = 'Admitted';
                    }else{
                        $data[$counter]['status'] = 'In Follow up';
                    }
                 }

                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."payment_details/".$value['enquiry_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/payment.png' alt='Payment Details' title='Payment Details'></a> | ";
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."followup/".$value['enquiry_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/follow_up.png' alt='Follow Up' title='Follow Up'></a> | ";
                //  $data[$counter]['action'] .= "<a style='cursor: pointer;' class='Whats_up_link' data-id='".$value['enquiry_id']."'><img width='20' src=".ICONPATH."/whatsapp.png  alt='Whats Up Link' title='Whats Up Link'></a> | ";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='send_brochure_link' data-id='".$value['enquiry_id']."'><img width='20' src=".ICONPATH."/send-link.png  alt='Send Brochure Link' title='Send Brochure Link'></a> | "; 
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editenquiry/".$value['enquiry_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/edit.png' alt='Edit Enquiry' title='Edit Enquiry'></a> | ";
                 
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."add_on_courses/".$value['enquiry_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/add.png' alt='Add-on courses' title='Add-on courses'></a> | ";


                 if($value['admissionexits']){
                 }else{
                    if($value['cancle_status']=='1'){
                    }else{
                        $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_enquiry' data-id='".$value['enquiry_id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Equipment' title='Delete Enquiry'></a> "; 
                    }
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

    public function checkuniqeenquiryname($mobile_no){
        $this->db->select('enq_fullname');
        $this->db->from(TBL_ENQUIRY);
        $this->db->where('isDeleted', 0);
        $this->db->where('enq_mobile', $mobile_no);
        $query = $this->db->get();
        return $query->result();
    }

    public function checkuniqeenquiryname_update($enq_id,$mobile_no){
        $this->db->select('enq_id,enq_fullname');
        $this->db->from(TBL_ENQUIRY);
        $this->db->where('isDeleted', 0);
        $this->db->where('enq_id =', $enq_id);
        $this->db->where('enq_mobile', $mobile_no);
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


    public function getSyllabusData($id){
        $this->db->select('*');
        $this->db->where(TBL_COURSE_SYLLABUS.'.isDeleted', 0);
        $this->db->where(TBL_COURSE_SYLLABUS.'.course_id', $id);
        $query = $this->db->get(TBL_COURSE_SYLLABUS);
        return $query->result();

    }


    public function saveEnquiryFollowupdata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_ENQUIRY_FOLLOW_UP, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_ENQUIRY_FOLLOW_UP, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }


    public function getEnquiryFollowupCount($params,$id){
        $this->db->select('*');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_ENQUIRY.'.course_type_id','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY_FOLLOW_UP.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY_FOLLOW_UP.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ENQUIRY_FOLLOW_UP.'.enq_id', $id);
        $query = $this->db->get(TBL_ENQUIRY_FOLLOW_UP);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getEnquiryFollowup($params,$id){

        $this->db->select('*');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_ENQUIRY.'.course_type_id','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY_FOLLOW_UP.".date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY_FOLLOW_UP.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ENQUIRY_FOLLOW_UP.'.enq_id', $id);
        $this->db->order_by(TBL_ENQUIRY_FOLLOW_UP.'.id', 'DESC');

        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_ENQUIRY_FOLLOW_UP);
        
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
                 $data[$counter]['enq_number'] = $value['enquiry_number'];
                 $data[$counter]['enq_date'] = date('d-m-Y', strtotime($value['date']));
                 $data[$counter]['remark'] = $value['remark'];
                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_enquiry_followup' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Enquiry Follow' title='Edit Enquiry Follow'></a> "; 
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_enquiry_followup' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Enquiry Follow' title='Delete Enquiry Follow'></a> "; 
                $counter++; 
            }
        }
        return $data;


    }

    public function getsignlefollowupData($followup_id){

        $this->db->select('*');
        $this->db->from('tbl_enquiry_follow_up');
       // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('id', $followup_id);
        $query = $this->db->get();
        return $query->result();


    }

    public function update_enquiry_discount($data,$enquiry_id){

        $this->db->where('enq_id', $enquiry_id);
        if($this->db->update(TBL_ENQUIRY, $data)){
            return TRUE;
        } else {
            return FALSE;
        }
   
       }

    public function getEnquirypaymentInfo($id){

        $this->db->select('*');
        $this->db->from('tbl_payment_transaction');
       // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('tbl_payment_transaction.paymant_type', 'regular_invoice');
        $this->db->where('enquiry_id', $id);
        $this->db->where('payment_status', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
        
    }


    public function gettotalpaidEnquirypaymentInfo($id){

        $this->db->select('sum(totalAmount) as totalpaidAmount');
        $this->db->from('tbl_payment_transaction');
        // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('enquiry_id', $id);
        $this->db->where('payment_status', 1);
        $this->db->where('paymant_type', 'regular_invoice');
        $this->db->group_by('enquiry_id');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
        
    }

    public function insert_manualpayment_details($data,$id=NULL){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_PAYMENT, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_PAYMENT, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }


    }

    
    public function get_enquiry_tarnsaction_details($transaction_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_payment_transaction');
       // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('id', $transaction_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_before_paid_payment($paymentid,$enq_id){

        $this->db->select('sum(totalAmount) as beforepaid');
        $this->db->from('tbl_payment_transaction');
        // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('id !=', $paymentid);
        $this->db->where('id <', $paymentid);
        $this->db->where('enquiry_id', $enq_id);
        $this->db->where('paymant_type', 'regular_invoice');
        $this->db->group_by('enquiry_id', $enq_id);
        $query = $this->db->get();
        return $query->result();

    }

    public function get_before_paid_payment_add_on_course($paymentid,$enq_id,$add_on_course_id){

        $this->db->select('sum(totalAmount) as beforepaid');
        $this->db->from('tbl_payment_transaction');
        // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('id !=', $paymentid);
        $this->db->where('id <', $paymentid);
        $this->db->where('enquiry_id', $enq_id);
        $this->db->where('add_on_course_id', $add_on_course_id);
        $this->db->where('paymant_type', 'add_on_course_invoice');
        $this->db->group_by('enquiry_id', $enq_id);
        $query = $this->db->get();
        return $query->result();

    }

    public function getTaxinvoicesCount($params){
        $this->db->select('*');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_PAYMENT.'.enquiry_id');

        $this->db->where("(".TBL_ENQUIRY.".enq_number LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_PAYMENT.".totalAmount LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_PAYMENT.".payment_mode LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_PAYMENT.".payment_date LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_PAYMENT.".datetime LIKE '%".$params['search']['value']."%')");
        //$this->db->where(TBL_PAYMENT.'.enq_id', $id);
        $this->db->where(TBL_PAYMENT.'.payment_status', 1);
        $this->db->order_by(TBL_PAYMENT.'.payment_status', 1);
        $query = $this->db->get(TBL_PAYMENT);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getTaxinvoices($params){

        $this->db->select('*,'.TBL_PAYMENT.'.id as paymentid');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_PAYMENT.'.enquiry_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY.".enq_number LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PAYMENT.".totalAmount LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PAYMENT.".payment_mode LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PAYMENT.".payment_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_PAYMENT.".datetime LIKE '%".$params['search']['value']."%')");
        }
        //$this->db->where(TBL_ENQUIRY_FOLLOW_UP.'.enq_id', $id);
        $this->db->where(TBL_PAYMENT.'.payment_status', 1);
      
        $this->db->order_by(TBL_PAYMENT.'.id', 'DESC');
      
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_PAYMENT);
        
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {


                if($value['paymant_type']=='regular_invoice'){
                    $get_before_paid_payment = $this->get_before_paid_payment($value['paymentid'],$value['enq_id']);

                    if($get_before_paid_payment){
                        $previous_paymemt =  $get_before_paid_payment[0]->beforepaid;
    
                    }else{
                        $previous_paymemt =0 ;
                        
                    }
    
                    $bal_amount =  $value['final_amount'] - ($value['totalAmount']+$previous_paymemt);
                    $final_amount =  $value['final_amount'];

                }else{

                    $get_before_paid_payment = $this->get_before_paid_payment_add_on_course($value['paymentid'],$value['enq_id'],trim($value['add_on_course_id']));

                    if($get_before_paid_payment){
                        $previous_paymemt =  $get_before_paid_payment[0]->beforepaid;
    
                    }else{
                        $previous_paymemt =0 ;
                        
                    }

                    $get_final_amount_of_add_on_course = $this->get_final_amount_of_add_on_course($value['enq_id'],trim($value['add_on_course_id']));
                    $amount_add_on_course_after_discount =  $get_final_amount_of_add_on_course['course_total_fees'] - $get_final_amount_of_add_on_course['discount'];
                    $bal_amount =   $amount_add_on_course_after_discount  - ($value['totalAmount']+$previous_paymemt);
                    $final_amount =   $amount_add_on_course_after_discount ;
                }

            
                //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
                 $data[$counter]['receipt_no'] = $value['id'];
                 $data[$counter]['enquiry_no'] = $value['enquiry_number'];

                 if($value['razorpay_payment_id']){
                    $payment_date = $value['datetime'];
                 }else{
                    $payment_date = $value['payment_date'];
                 }

                 if($value['paymant_type']=='regular_invoice'){
                    $paymant_type = 'Invoice';
                 }else{
                    $paymant_type = 'Add on';
                 }

                 $data[$counter]['receipt_date'] = date('d-m-Y', strtotime($payment_date));
                 $data[$counter]['enq_fullname'] = $value['enq_fullname'];
                 $data[$counter]['enq_mobile'] = $value['enq_mobile'];
                 $data[$counter]['totalAmount'] = '₹ '.$value['totalAmount'];
                 $data[$counter]['paid_before'] = '₹ '.$previous_paymemt;
                 $data[$counter]['total_amount'] = '₹ '.$final_amount;
                 $data[$counter]['amount_balance'] = '₹ '.$bal_amount;
                 $data[$counter]['payment_mode'] = $value['payment_mode'];
                 $data[$counter]['paymant_type'] = $paymant_type;
                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a style='cursor: pointer;'  href='tax_invoice/index.php?enq_id=".$value['enq_id']."&paymentid=".$value['paymentid']."' target='_blank'  class='print_tax_invoices' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/print.png alt='Print Invoice' title='Print Invoice'></a> "; 
                $counter++; 
            }
        }
        return $data;


    }

    public function check_payment_maount_lessthan_actaul($enquiry_id){
        $this->db->select('final_amount');
        $this->db->where(TBL_ENQUIRY.'.enq_id', $enquiry_id);
        $query = $this->db->get(TBL_ENQUIRY);
        return $query->result_array();
    }


    public function check_payment_maount_lessthan_actaul_add_course($enquiry_id,$add_on_course_id){
        // $this->db->select('final_amount');
        // $this->db->where(TBL_ENQUIRY.'.enq_id', $enquiry_id);
        // $query = $this->db->get(TBL_ENQUIRY);
        // return $query->result_array();

        $this->db->select('sum(totalAmount) as beforepaid');
        $this->db->from('tbl_payment_transaction');
        // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('enquiry_id', $enquiry_id);
        $this->db->where('add_on_course_id', $add_on_course_id);
        $this->db->where('paymant_type', 'add_on_course_invoice');
        $query = $this->db->get();
        $data_1 =  $query->result_array();
        $total_paid_add_course =  $data_1[0]['beforepaid'];

       

    
        $this->db->select(TBL_ADD_ON_COURSE.'.id as addoncourse_id,'.TBL_ADD_ON_COURSE.'.createdDtm as addoncoursedatetime,'.TBL_COURSE.'.course_name,'.TBL_COURSE.'.course_total_fees,'.TBL_ADD_ON_COURSE.'.discount');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ADD_ON_COURSE.'.course_id');
        $this->db->where(TBL_ADD_ON_COURSE.'.enquiry_id', $enquiry_id);
        $this->db->where(TBL_ADD_ON_COURSE.'.id', $add_on_course_id);
        $query_2 = $this->db->get(TBL_ADD_ON_COURSE);
        $total_final_amount = $query_2->result_array();

    

        $coursefinalamount =  $total_final_amount[0]['course_total_fees'] -  $total_final_amount[0]['discount'];
        $pending_amount =  $coursefinalamount - $total_paid_add_course; 

    

        $data[][0] = array('final_amount'=>$pending_amount);

        return $data[0];


    }


    public function save_Add_on_courses($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_ADD_ON_COURSE, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_ADD_ON_COURSE, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function getAddoncourseList($id){
        $this->db->select('*');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ADD_ON_COURSE.'.course_id');
        $this->db->where(TBL_ADD_ON_COURSE.'.enquiry_id', $id);
        $query = $this->db->get(TBL_ADD_ON_COURSE);
        return $query->result_array();
    }

    public function updateenquirywithpush($enquiry_id,$data){
        $this->db->where(TBL_ENQUIRY.'.enq_id', $enquiry_id);
        if($this->db->update(TBL_ENQUIRY,$data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateactiveinactivestatus($main_id,$data){
        $this->db->where(TBL_ADD_ON_COURSE.'.id', $main_id);
        if($this->db->update(TBL_ADD_ON_COURSE,$data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getadditionalInfo($id){
        $this->db->select(TBL_ADD_ON_COURSE.'.id as addoncourse_id,'.TBL_ADD_ON_COURSE.'.createdDtm as addoncoursedatetime,'.TBL_COURSE.'.course_name,'.TBL_COURSE.'.course_total_fees,'.TBL_ADD_ON_COURSE.'.discount,'.TBL_ADD_ON_COURSE.'.enquiry_id');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ADD_ON_COURSE.'.course_id');
        $this->db->where(TBL_ADD_ON_COURSE.'.enquiry_id', $id);
        $query = $this->db->get(TBL_ADD_ON_COURSE);
        return $query->result_array();

    }

    public function save_addon_discount_payment($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_ADD_ON_COURSE, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_ADD_ON_COURSE, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function getAddoncourseListforviewaddoncoursedetails($id){
        $this->db->select('*,'.TBL_ENQUIRY.'.enq_number as enq_number_enq,'.TBL_ADD_ON_COURSE.'.id as add_on_course_id');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ADD_ON_COURSE.'.course_id');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_ADD_ON_COURSE.'.enquiry_id');
        $this->db->where(TBL_ADD_ON_COURSE.'.id', $id);
        $query = $this->db->get(TBL_ADD_ON_COURSE);
        return $query->row_array();
    }


public function getaddoncoursepaymentdetailsCount($params,$id){
        $this->db->select('*');
        $this->db->from('tbl_payment_transaction');
        // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('tbl_payment_transaction.paymant_type', 'regular_invoice');
        $this->db->where('id', $id);
        $this->db->where('payment_status', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getaddoncoursepaymentdetailsData($params,$id){
        $this->db->select('*,tbl_payment_transaction.id as paymentid');
        $this->db->from('tbl_payment_transaction');
        // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('tbl_payment_transaction.paymant_type', 'add_on_course_invoice');
        $this->db->where('add_on_course_id', $id);
        $this->db->where('payment_status', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        $fetch_result = $query->result_array();


        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {

                if($value['payment_status']==1){
                    $status='Completed';
                }else{
                    $status='';
                }

                if($value['razorpay_payment_id']!=NULL){
                    $transaction_id = $value['razorpay_payment_id'];
                    $payment_date = $value['datetime'];
                }else{
                    $transaction_id = 'Manual-Transaction';
                    $payment_date = $value['payment_date'];
                }

           
        
                $data[$counter]['payment_date'] = $payment_date;
                $data[$counter]['transaction_id'] =$transaction_id;
                $data[$counter]['totalAmount'] = '₹ '.$value['totalAmount'];
                $data[$counter]['payment_mode'] =$value['payment_mode'];
                $data[$counter]['status'] =$status;

                $data[$counter]['action'] = '';
                //$data[$counter]['action'] .= "<a style='cursor: pointer;'  href='tax_invoice/index.php?enq_id=".$value['enq_id']."&paymentid=".$value['paymentid']."' target='_blank'  class='print_tax_invoices' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/print.png alt='Print Invoice' title='Print Invoice'></a> ";
                
                
                if($this->session->userdata('roleText')=='Student'){
                    $data[$counter]['action'] .= "<a style='cursor: pointer;'  href='../tax_invoice/index.php?enq_id=".$value['enquiry_id']."&paymentid=".$value['paymentid']."' target='_blank'  class='print_tax_invoices' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/print.png alt='Print Invoice' title='Print Invoice'></a> ";
                }else{

                    $data[$counter]['action'] .= "<a style='cursor: pointer;' class='view_enquiry_tarnsaction' data-toggle='modal' data-target='#view_enquiry_tarnsaction'  data-id='".$value['paymentid']."'><img width='20' src=".ICONPATH."/view_doc.png alt='View Transaction' title='View Transaction'></a>";
               
                    $data[$counter]['action'] .= "<a style='cursor: pointer;'  href='../tax_invoice/index.php?enq_id=".$value['enquiry_id']."&paymentid=".$value['paymentid']."' target='_blank'  class='print_tax_invoices' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/print.png alt='Print Invoice' title='Print Invoice'></a> ";
                
                    $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_enquiry_tarnsaction' data-id=".$value['paymentid']."><img width='20' src=".ICONPATH."/delete.png  alt='Delete Transaction' title='Delete Transaction'></a> ";

                }

             
                $counter++; 
            }
        }
        return $data;


    }


    public function get_final_amount_of_add_on_course($enq_id,$add_on_course_id){

        $this->db->select(TBL_ADD_ON_COURSE.'.id as addoncourse_id,'.TBL_ADD_ON_COURSE.'.createdDtm as addoncoursedatetime,'.TBL_COURSE.'.course_name,'.TBL_COURSE.'.course_total_fees,'.TBL_ADD_ON_COURSE.'.discount');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ADD_ON_COURSE.'.course_id');
        $this->db->where(TBL_ADD_ON_COURSE.'.enquiry_id', $enq_id);
        $this->db->where(TBL_ADD_ON_COURSE.'.id', $add_on_course_id);
        $query = $this->db->get(TBL_ADD_ON_COURSE);
        return $query->row_array();

    }


    public function gettotalpaidamountof_add_on_course($addoncourse_id,$enquiry_id){
        $this->db->select('sum(totalAmount) as totalpaidamount');
        $this->db->from('tbl_payment_transaction');
        // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('tbl_payment_transaction.enquiry_id', $enquiry_id);
        $this->db->where('tbl_payment_transaction.paymant_type', 'add_on_course_invoice');
        $this->db->where('tbl_payment_transaction.add_on_course_id', $addoncourse_id);
        $this->db->group_by('tbl_payment_transaction.add_on_course_id');
        $query = $this->db->get();
        return $query->result();


    }


   public function getallcourseidbycoursename($course_name){
        $this->db->select('courseId');
        $this->db->from(TBL_COURSE);
        $this->db->where_in('course_name', $course_name);
        $query = $this->db->get();
        return $query->result_array();
   }


   public function getEnquiryreportCount($params){
    $this->db->select('*');
    // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_ENQUIRY.'.course_type_id','left');
    $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_ENQUIRY.'.counsellor_id');

    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_USER.".name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ENQUIRY.".enq_email LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%')");
    }


    if($this->session->userdata('roleText')=='Counsellor'){

        $this->db->where(TBL_ENQUIRY.'.counsellor_id', $this->session->userdata('userId'));
    }

    $this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
    $query = $this->db->get(TBL_ENQUIRY);
    $rowcount = $query->num_rows();
    return $rowcount;
}

public function getEnquiryreportdata($params){
    $this->db->select('*,'.TBL_ADMISSION.'.enq_id as admissionexits,'.TBL_ENQUIRY.'.enq_id as enquiry_id,'.TBL_USER.'.name as counseller');
    // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
    $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_id','left');
    $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_ENQUIRY.'.counsellor_id');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_USER.".name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ENQUIRY.".enq_email LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%')");
    }

    if($this->session->userdata('roleText')=='Counsellor'){

        $this->db->where(TBL_ENQUIRY.'.counsellor_id', $this->session->userdata('userId'));
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
             // $data[$counter]['enq_email'] = $value['enq_email'];

            //  if($value['payment_status']=='0'){
            //     $data[$counter]['status'] = 'In Follow up';
            //  }else if($value['payment_status']=='1'){
            //     $data[$counter]['status'] = 'Admitted';
            //  }else{
            //     $data[$counter]['status'] = 'In Follow up';
            //  }

           


             $course_ids    =   explode(',', $value['enq_course_id']);
         
             $total_fees = 0;
             $course_name = '';
             $i = 1;
                foreach($course_ids as $id)
                {
                    $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                    if($get_course_fees){
                        
                        $total_fees += $get_course_fees[0]->course_total_fees;
                        $course_name .= $i.'-'.$get_course_fees[0]->course_name. ' <br>';  
                        $i++;  

                    }else{

                        $total_fees = '';
                        $course_name = '';  
                        $i++;  
                    }
                  
                }
             $all_course_name = trim($course_name, ', '); 



             $data[$counter]['all_course_name'] = $all_course_name ;
             $data[$counter]['counsellor_name'] = $value['counseller'];

             if($value['cancle_status']=='1'){
                   $data[$counter]['status'] = 'Cancelled';
             }else{
                if(!empty($value['admissionexits'])){
                    $data[$counter]['status'] = 'Admitted';
                }else{
                    $data[$counter]['status'] = 'In Follow up';
                }
             }
             
            $counter++; 
        }
    }
    return $data;
}



}

?>