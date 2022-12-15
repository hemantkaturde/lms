<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends CI_Model
{
    function studentListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.studentId , BaseTbl.student_fname, BaseTbl.student_lname, BaseTbl.student_mobile, BaseTbl.student_gender, BaseTbl.student_dob, BaseTbl.student_address,BaseTbl.student_course');
        $this->db->from('tbl_student as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.student_fname  LIKE '%".$searchText."%'
                            OR  BaseTbl.student_lname  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.studentId', 'desc');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function studentListing($searchText = '')
    {
        $this->db->select('BaseTbl.studentId , BaseTbl.student_fname, BaseTbl.student_lname, BaseTbl.student_mobile, BaseTbl.student_gender, BaseTbl.student_dob, BaseTbl.student_address,BaseTbl.student_course');
        $this->db->from('tbl_student as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.student_fname  LIKE '%".$searchText."%'
                            OR  BaseTbl.student_lname  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.studentId', 'desc');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;      
    }
        
        /*
        Get Single course
        */ 
        public function getStudentInfo($studentId)
        {
            $this->db->select('BaseTbl.studentId , BaseTbl.student_fname, BaseTbl.student_lname, BaseTbl.student_mobile, BaseTbl.student_gender, BaseTbl.student_dob, BaseTbl.student_address,BaseTbl.student_course');
            $this->db->from('tbl_student as BaseTbl');
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->where('BaseTbl.studentId', $studentId);
            $query = $this->db->get();
            
            return $query->result();
        }

        public function getCourses()
        {
            $this->db->select('courseId, course_name');
            $this->db->from('tbl_course');
            $this->db->where('isDeleted',0);
            $query = $this->db->get();
            
            return $query->result();
        }



        
    public function  getStudentCount($params){
        $this->db->select('*');
        $this->db->join(TBL_ROLES, TBL_ROLES.'.roleId = '.TBL_USER.'.roleId','left');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_USER.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".username LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ROLES.".role LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_USER.'.isDeleted', 0);
        $this->db->where(TBL_USER.'.user_flag', 'student');
        $query = $this->db->get(TBL_USER);
        $rowcount = $query->num_rows();
        
        return $rowcount;

    }

    public function getStudentData($params){
        $this->db->select('*');
        $this->db->join(TBL_ROLES, TBL_ROLES.'.roleId = '.TBL_USER.'.roleId','left');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_USER.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".username LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ROLES.".role LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_USER.'.isDeleted', 0);
        $this->db->where(TBL_USER.'.user_flag', 'student');
        $this->db->order_by(TBL_USER.'.userId', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_USER);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;

        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['name']    = $value['name'];
                 $data[$counter]['mobile']  = $value['mobile'];
                 $data[$counter]['email']   = $value['email'];
                 $data[$counter]['user_flag']   = $value['user_flag'];
                 $data[$counter]['action']  = '';
                 $data[$counter]['action'] .= "";
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editstudent/".$value['userId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/edit.png' alt='Edit Enquiry' title='Edit Enquiry'></a> | ";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_student' data-id='".$value['userId']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Student' title='Delete Student'></a>"; 

                $counter++; 
            }
        }
        return $data;
    }


    public function getTaxinvoicesCount($params,$enq_id){
        $this->db->select('*');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_PAYMENT.'.enquiry_id');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_id = '.TBL_ENQUIRY.'.enq_id');

        // if($params['search']['value'] != "") 
        // {
        //     $this->db->where("(".TBL_ENQUIRY_FOLLOW_UP.".date LIKE '%".$params['search']['value']."%'");
        //     $this->db->or_where(TBL_ENQUIRY_FOLLOW_UP.".remark LIKE '%".$params['search']['value']."%')");
        // }
        //$this->db->where(TBL_PAYMENT.'.enq_id', $id);
        $this->db->where(TBL_PAYMENT.'.payment_status', 1);
        $this->db->where(TBL_USERS_ENQUIRES.'.enq_number', $enq_id);
        $this->db->order_by(TBL_PAYMENT.'.payment_status', 1);
        $query = $this->db->get(TBL_PAYMENT);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getTaxinvoices($params,$enq_id){

        $this->db->select('*,'.TBL_PAYMENT.'.id as paymentid');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_PAYMENT.'.enquiry_id');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_id = '.TBL_ENQUIRY.'.enq_id');

        // if($params['search']['value'] != "") 
        // {
        //     $this->db->where("(".TBL_ENQUIRY_FOLLOW_UP.".date LIKE '%".$params['search']['value']."%'");
        //     $this->db->or_where(TBL_ENQUIRY_FOLLOW_UP.".remark LIKE '%".$params['search']['value']."%')");
        // }
        //$this->db->where(TBL_ENQUIRY_FOLLOW_UP.'.enq_id', $id);
        $this->db->where(TBL_PAYMENT.'.payment_status', 1);
        $this->db->where(TBL_USERS_ENQUIRES.'.enq_number', $enq_id);
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

                
                $get_before_paid_payment = $this->get_before_paid_payment($value['paymentid'],$value['enq_id']);

                if($get_before_paid_payment){
                    $previous_paymemt =  $get_before_paid_payment[0]->beforepaid;

                }else{
                    $previous_paymemt =0 ;
                    
                }

                $bal_amount =  $value['final_amount'] - ($value['totalAmount']+$previous_paymemt);
            
                //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
                 $data[$counter]['receipt_no'] = $value['id'];
                 $data[$counter]['enquiry_no'] = $value['enquiry_number'];

                 if($value['razorpay_payment_id']){
                    $payment_date = $value['datetime'];
                 }else{
                    $payment_date = $value['payment_date'];
                 }

                 $data[$counter]['receipt_date'] = date('d-m-Y', strtotime($payment_date));
                 $data[$counter]['enq_fullname'] = $value['enq_fullname'];
                 $data[$counter]['enq_mobile'] = $value['enq_mobile'];
                 $data[$counter]['totalAmount'] = '₹ '.$value['totalAmount'];
                 $data[$counter]['paid_before'] = '₹ '.$previous_paymemt;
                 $data[$counter]['total_amount'] = '₹ '.$value['final_amount'];
                 $data[$counter]['amount_balance'] = '₹ '.$bal_amount;
                 $data[$counter]['payment_mode'] = $value['payment_mode'];
                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a style='cursor: pointer;'  href='tax_invoice/index.php?enq_id=".$value['enq_id']."&paymentid=".$value['paymentid']."' target='_blank'  class='print_tax_invoices' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/print.png alt='Edit Enquiry Follow' title='Edit Enquiry Follow'></a> "; 
                $counter++; 
            }
        }
        return $data;


    }

    public function get_before_paid_payment($paymentid,$enq_id){

        $this->db->select('sum(totalAmount) as beforepaid');
        $this->db->from('tbl_payment_transaction');
        // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('id !=', $paymentid);
        $this->db->where('id <', $paymentid);
        $this->db->where('enquiry_id', $enq_id);
        $this->db->group_by('enquiry_id', $enq_id);
        $query = $this->db->get();
        return $query->result();

    }

    public function getAllstudentdata($id){

        $this->db->select('*');
        $this->db->where(TBL_USER.'.userId', $id);
        $query = $this->db->get(TBL_USER);
        return $query->result();

    }


    public function saveStudentdata($id,$data){

        if($id != '') {
            $this->db->where('userId', $id);
            if($this->db->update(TBL_USER, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_USER, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }


}

?>