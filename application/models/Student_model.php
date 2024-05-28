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
                $course_id = json_decode($value['book_issued']);
                
                // $course_name = array();
                $course_name ="";
                foreach ($course_id as $key => $bookissued_value) {
                    $course_name .= $this->getCoursenamebyid($bookissued_value)[0]['course_name'].',';        
                }

                 $data[$counter]['name']    = $value['name'];
                 $data[$counter]['mobile']  = $value['mobile'];
                 $data[$counter]['email']   = $value['email'];
                 $data[$counter]['user_flag']   =  rtrim($course_name,','); ;
                 $data[$counter]['action'] .= "";
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."editstudent/".$value['userId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/edit.png' alt='Edit Enquiry' title='Edit Enquiry'></a> | ";
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."studentbookissued/".$value['userId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/books.png' alt='Edit Enquiry' title='Book Issued or Not'></a> | ";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_student' data-id='".$value['userId']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Student' title='Delete Student'></a>"; 

                $counter++; 
            }
        }
        return $data;
    }


    public function getTaxinvoicesCount($params,$userId){
        $this->db->select('*');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_number = '.TBL_PAYMENT.'.enquiry_id');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');

        // if($params['search']['value'] != "") 
        // {
        //     $this->db->where("(".TBL_ENQUIRY_FOLLOW_UP.".date LIKE '%".$params['search']['value']."%'");
        //     $this->db->or_where(TBL_ENQUIRY_FOLLOW_UP.".remark LIKE '%".$params['search']['value']."%')");
        // }
        //$this->db->where(TBL_PAYMENT.'.enq_id', $id);
        $this->db->where(TBL_PAYMENT.'.payment_status', 1);
        $this->db->where(TBL_USERS_ENQUIRES.'.user_id', $userId);
        //$this->db->where(TBL_PAYMENT.'.enquiry_number', $enq_id);
        $this->db->order_by(TBL_PAYMENT.'.payment_status', 1);
        $query = $this->db->get(TBL_PAYMENT);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getTaxinvoices($params,$userId){

        $this->db->select('*,'.TBL_PAYMENT.'.id as paymentid');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_PAYMENT.'.enquiry_id');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');

        $this->db->where(TBL_PAYMENT.'.payment_status', 1);
        $this->db->where(TBL_USERS_ENQUIRES.'.user_id', $userId);
        // $this->db->where(TBL_PAYMENT.'.enquiry_number', $enq_id);
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

                
                // $get_before_paid_payment = $this->get_before_paid_payment($value['paymentid'],$value['enq_id']);

                // if($get_before_paid_payment){
                //     $previous_paymemt =  $get_before_paid_payment[0]->beforepaid;

                // }else{
                //     $previous_paymemt =0 ;
                    
                // }

                // $bal_amount =  $value['final_amount'] - ($value['totalAmount']+$previous_paymemt);
            
                // //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
                //  $data[$counter]['receipt_no'] = $value['id'];
                //  $data[$counter]['enquiry_no'] = $value['enquiry_number'];

                //  if($value['razorpay_payment_id']){
                //     $payment_date = $value['datetime'];
                //  }else{
                //     $payment_date = $value['payment_date'];
                //  }

                //  $data[$counter]['receipt_date'] = date('d-m-Y', strtotime($payment_date));
                //  $data[$counter]['enq_fullname'] = $value['enq_fullname'];
                //  $data[$counter]['enq_mobile'] = $value['enq_mobile'];
                //  $data[$counter]['totalAmount'] = '₹ '.$value['totalAmount'];
                //  $data[$counter]['paid_before'] = '₹ '.$previous_paymemt;
                //  $data[$counter]['total_amount'] = '₹ '.$value['final_amount'];
                //  $data[$counter]['amount_balance'] = '₹ '.$bal_amount;
                //  $data[$counter]['payment_mode'] = $value['payment_mode'];
                //  $data[$counter]['action'] = '';
                //  $data[$counter]['action'] .= "<a style='cursor: pointer;'  href='tax_invoice/index.php?enq_id=".$value['enq_id']."&paymentid=".$value['paymentid']."' target='_blank'  class='print_tax_invoices' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/print.png alt='Edit Enquiry Follow' title='Edit Enquiry Follow'></a> "; 
                // $counter++; 


                
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
                // $data[$counter]['receipt_no'] = $value['id'];
                 $data[$counter]['receipt_no'] = $value['paymentid'];
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

    public function getAllstudentdata($id){

        $this->db->select('*,'.TBL_USER.'.profile_pic as student_profile_pic');
        $this->db->where(TBL_USER.'.userId', $id);
        $this->db->join(TBL_USERS_ENQUIRES, TBL_USERS_ENQUIRES.'.user_id = '.TBL_USER.'.userId');
        $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');
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


    public function getEnquiryCount($params,$userId){
        $this->db->select('*');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_ENQUIRY.'.course_type_id','left');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_number = '.TBL_USERS_ENQUIRES.'.enq_id');
        $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_id','left');
        $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_ENQUIRY.'.counsellor_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
            $this->db->where(TBL_USER.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
        $this->db->where(TBL_USERS_ENQUIRES.'.user_id', $userId);
        $query = $this->db->get(TBL_ENQUIRY);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getEnquirydata($params,$userId){
        $this->db->select('*,'.TBL_ADMISSION.'.enq_id as admissionexits,'.TBL_ENQUIRY.'.enq_id as enquiry_id,'.TBL_ADMISSION.'.id as admission_id,'.TBL_USER.'.name as counseller');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');
        $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_ENQUIRY.'.counsellor_id');

        $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_id','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
            $this->db->where(TBL_USER.".name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
        $this->db->where(TBL_USERS_ENQUIRES.'.user_id', $userId);
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

                // if(!empty($value['admissionexits'])){
                //     $data[$counter]['status'] = 'Admitted';
                // }else{
                //     $data[$counter]['status'] = 'In Follow up';
                // }

                if($value['cancle_status']=='1'){
                    $data[$counter]['status'] = 'Cancelled';
                }else{
                    if(!empty($value['admissionexits'])){
                        $data[$counter]['status'] = 'Admitted';
                    }else{
                        $data[$counter]['status'] = 'In Follow up';
                    }
                }


                 $course_ids    =   explode(',', $value['enq_course_id']);

                 $total_fees = 0;
                 $course_name = '';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                        $get_course_fees =  $this->student_model->getCourseInfo($id);
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
                 // $data[$counter]['total_fees'] = '₹ '.$total_fees ;

                 $data[$counter]['action'] = '';

                 if($value['cancle_status']=='1'){
                   $data[$counter]['action'] .= "<a style='cursor: pointer;'  href='admissioncancleinfo/index.php?admission_id=".$value['id']."' target='_blank'  class='print_certificate' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/print.png alt='Print Admission Cancle reason' title='Print Admission Cancle reason'></a> "; 
                 }
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."studentpaymentdetails/".$value['enquiry_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/payment.png' alt='Student Payment Details' title='Student Payment Details'></a>  ";
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewadmissiondetails/".$value['admission_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/view_doc.png' alt='View Admission Details' title='View Admission Details'></a>&nbsp;";       
                $counter++; 
            }
        }
        return $data;
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


    
    public function  getstudentCourseCount($params,$userId){
        $this->db->select('*');
        $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE.".course_total_fees LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE.'.isDeleted', 0);
        $this->db->where(TBL_COURSE.'.courseId IN (SELECT  enq_course_id from  tbl_enquiry join tbl_users_enquires on tbl_enquiry.enq_id=tbl_users_enquires.enq_id where tbl_users_enquires.user_id='.$userId.')');
        $query = $this->db->get(TBL_COURSE);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getstudentCoursedata($params,$userId){
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        $pageUrl =$this->uri->segment(1);


        $this->db->select(TBL_ENQUIRY.'.enq_course_id,'.TBL_USER.'.book_issued');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');
        $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_USERS_ENQUIRES.'.user_id');
        $this->db->where(TBL_USERS_ENQUIRES.'.user_id',$userId);
        $get_enquiry_courses = $this->db->get(TBL_ENQUIRY);
        $fetch_result_enquiry_courses = $get_enquiry_courses->result_array();

        $data = array();
        $counter = 0;
       foreach ($fetch_result_enquiry_courses as $key => $valueid) {
        
    

         $course_ids    =   explode(',', $valueid['enq_course_id']);

         foreach ($course_ids as $key => $value) {
           
           
        $this->db->select('*');
        $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE.".course_total_fees LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE.'.isDeleted', 0);
        // $this->db->where(TBL_COURSE.'.courseId IN (SELECT  enq_course_id from  tbl_enquiry join tbl_users_enquires on tbl_enquiry.enq_number=tbl_users_enquires.enq_id where tbl_users_enquires.user_id='.$userId.')');
        $this->db->where(TBL_COURSE.'.courseId', $value);

        $this->db->order_by(TBL_COURSE.'.courseId', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_COURSE);
        $fetch_result = $query->result_array();
       
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                    // $data[$counter]['courseId'] = $value['courseId'];
                    $data[$counter]['course_name'] = $value['course_name'];
                    $data[$counter]['course_type'] = $value['ct_name'];
                   // $data[$counter]['course_fees'] = '₹' .$value['course_total_fees'];

                    // if($value['course_books']==1){
                    //     $course_books = 'Books Available';
                    // }else{
                    //     $course_books = '';
                    // }

                   
                    if($value['course_mode_online']==1){

                        $course_mode_online ='Online';
                    }else{

                        $course_mode_online ='';
                    }


                    if($value['course_mode_offline']==1){

                        $course_mode_offline = 'Offline';
                    }else{

                        $course_mode_offline = '';
                    }

                //    print_r($valueid['book_issued']);
                //    exit;

                    $course_id = json_decode($valueid['book_issued']);


                     if($course_id){

                            if (in_array($value['courseId'], $course_id))
                            {
                                $course_issued ='Yes';
                            }
                            else
                            {
                                $course_issued ='No';
                            }
                        
                    }else{
                        $course_issued ='No';
                    }
                    
                    // $course_name = array();
                    // $course_name ="";
                    // foreach ($course_id as $key => $bookissued_value) {
                    //     $course_name .= $this->getCoursenamebyid($bookissued_value)[0]['course_name'].',';        
                    // }


                    $data[$counter]['course_mode'] = $course_mode_online.' '.$course_mode_offline;
                    //$data[$counter]['course_books'] = $course_books;
                    

                    // if($course_name){
                      
                    //     $course_issued= 'Books Received';
                    // }else{
                    //     $course_issued= '';
                    // }

                   // $data[$counter]['course_issued'] =  rtrim($course_name,',');

                    $data[$counter]['course_issued'] =  $course_issued;

                    $data[$counter]['action'] = '';

                    $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewstudentscoursetopis/".$value['courseId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/books.png' alt='View Topics' title='View Topics'></a> ";
                    $data[$counter]['action'] .= "<a href='".ADMIN_PATH."studenttimetableListing/".$value['courseId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/timetable.png' alt='Time Table' title='Time Table'></a> ";

                 $counter++; 
            }
        }

    

         }

         return $data;
       }
 


    }


    public function  getstudentCourseattchmentCount($params,$courseid){
        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE_TOPICS.".topic_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TOPICS.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE_TOPICS.'.isDeleted', 0);
        $this->db->where(TBL_COURSE_TOPICS.'.course_id', $courseid);
        $query = $this->db->get(TBL_COURSE_TOPICS);
        $rowcount = $query->num_rows();
        return $rowcount;

    }


    public function getstudentCourseattchmentdata($params,$courseid){
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        
        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE_TOPICS.".topic_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TOPICS.".remark LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE_TOPICS.'.isDeleted', 0);
        $this->db->where(TBL_COURSE_TOPICS.'.course_id', $courseid);
        $this->db->order_by(TBL_COURSE_TOPICS.'.id', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_COURSE_TOPICS);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['topic_name'] = $value['topic_name'];
                //  $data[$counter]['remark'] = $value['remark'];
                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."studenttopicdocumentslisting?topic_id=".$value['id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/attachment.png' alt='View Attachment' title='View Attachment'></a> ";
                $counter++; 
            }
        }

        return $data;
    }



    public function studentgetFetchtopicdocumentCount($params,$topic_id,$course_id,$type){
        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE_TOPICS_DOCUMENT.".file_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TOPICS_DOCUMENT.".file_name LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.isDeleted', 0);
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.course_id', $course_id);
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.topic_id', $topic_id);
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.module_name', $type);
        $query = $this->db->get(TBL_COURSE_TOPICS_DOCUMENT);
        $rowcount = $query->num_rows();
        return $rowcount;
    
      }
    
      public function studentgetFetchtopicdocumentData($params,$topic_id,$course_id,$type){
    
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        
        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE_TOPICS_DOCUMENT.".file_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TOPICS_DOCUMENT.".file_name LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.isDeleted', 0);
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.course_id', $course_id);
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.topic_id', $topic_id);
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.module_name', $type);
        $this->db->order_by(TBL_COURSE_TOPICS_DOCUMENT.'.id', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_COURSE_TOPICS_DOCUMENT);
        $fetch_result = $query->result_array();
    
    
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 //$data[$counter]['file_name_original'] = $value['file_name_original'];
                 $data[$counter]['doc_type'] = $value['doc_type'];
                 $data[$counter]['file_url'] = "<a  href=".trim($value['file_url'])." target=_blank>".$value['file_url']."</a>";
    
                //  $data[$counter]['video'] ='<iframe width="100" height="100" src="'.trim($value['file_url']).'">
                //     </iframe>';
                 
                 $data[$counter]['action'] = '';
                 //  $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course_topic' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Certificate Type' title='Edit Certificate Type'></a> |";
                 //  $data[$counter]['action'] .= "<a style='cursor: pointer;' class='add_topic_attachment' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/attachment.png alt='Add Attachment' title='Add Attachment'></a> |";
                 //  $data[$counter]['action'] .= "<a href='".ADMIN_PATH."topicattachmentListing?topic_id=".$value['id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/attachment.png' alt='Add Attachment' title='Add Attachment'></a> |";
                 //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_topic_document' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Topic Document' title='Delete Topic Document'></a>"; 
                
                $counter++; 
            }
        }
    
        return $data;
    
      }
    


      public function studentgettimetableCount($params,$courseid){

        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_TIMETABLE.".from_date LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_TIMETABLE.".to_date LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_TIMETABLE.'.isDeleted', 0);
        $this->db->where(TBL_TIMETABLE.'.course_id', $courseid);

        $query = $this->db->get(TBL_TIMETABLE);
        $rowcount = $query->num_rows();
        return $rowcount;

  }


  public function studentgettimetabledata($params,$courseid){

    $access = $this->session->userdata('access');
    $jsonstringtoArray = json_decode($access, true);
    
    $this->db->select('*');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_TIMETABLE.".from_date LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_TIMETABLE.".to_date LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_TIMETABLE.'.course_id', $courseid);
    $this->db->where(TBL_TIMETABLE.'.isDeleted', 0);
    $this->db->order_by(TBL_TIMETABLE.'.id', 'DESC');
    $this->db->limit($params['length'],$params['start']);
    $query = $this->db->get(TBL_TIMETABLE);
    $fetch_result = $query->result_array();
    $data = array();
    $counter = 0;
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {
             $data[$counter]['from_date'] = date('d-m-Y', strtotime($value['from_date']));
             $data[$counter]['to_date'] = date('d-m-Y', strtotime($value['to_date']));
             $data[$counter]['month_name'] = '<b>'.$value['month_name'].'</b>';
             $data[$counter]['action'] = '';

             $data[$counter]['action'] .= "<a href='".ADMIN_PATH."studentviewtimetablelisting?time_table_id=".$value['id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/view_doc.png' alt='Viw TimeTable' title='Viw TimeTable'></a> ";
            //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_topic_timetable' time-table-id='".$value['id']."' course_id='".$value['course_id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Time Table' title='Delete Time Table'></a>"; 
            
            $counter++; 
        }
    }

    return $data;

  }

  
  public function gettstudnetimetabletopiclistingCount($params,$time_table_id,$course_id){

    $this->db->select('*');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_TIMETABLE_TRANSECTIONS.".timings LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_TIMETABLE_TRANSECTIONS.".topic LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.isDeleted', 0);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.course_id', $course_id);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.time_table_id', $time_table_id);
    $query = $this->db->get(TBL_TIMETABLE_TRANSECTIONS);
    $rowcount = $query->num_rows();
    return $rowcount;

  }

   public function gettstudentimetabletopiclistingdata($params,$time_table_id,$course_id){

    $this->db->select('*');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_TIMETABLE_TRANSECTIONS.".timings LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_TIMETABLE_TRANSECTIONS.".topic LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.isDeleted', 0);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.course_id', $course_id);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.time_table_id', $time_table_id);
    $this->db->order_by(TBL_TIMETABLE_TRANSECTIONS.'.id', 'DESC');
    $this->db->limit($params['length'],$params['start']);
    $query = $this->db->get(TBL_TIMETABLE_TRANSECTIONS);
    $fetch_result = $query->result_array();
    $data = array();
    $counter = 0;
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {
             $data[$counter]['date'] = date('d-m-Y', strtotime($value['date']));
             $data[$counter]['timings'] = $value['timings'];
             $data[$counter]['topic'] =  $value['topic'];
             $data[$counter]['action'] = '';


             if($value['iscancle']!=1){
                $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addstudenttopiclinksforonlineattendant?id=".$value['id']."&time_table_id=".$value['time_table_id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/attachment.png' alt='Add Online Meeting Link' title='Add Online Meeting Link'></a>";
             }else{
                $data[$counter]['action'] .='<p>Cancelled</p>';
             }

            //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_topic_document' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/meeting.png alt='Add Links' title='Add Links'></a>"; 
            
            $counter++; 
        }
    }

    return $data;
  }
 
  public function getstudenttopicmeetinglinkCount($params,$time_table_id,$course_id,$time_table_transection_id){

    $this->db->select('*');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_TOPIC_MEETING_LINK.".title LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_TOPIC_MEETING_LINK.".topic_name LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_TOPIC_MEETING_LINK.'.isDeleted', 0);
    $this->db->where(TBL_TOPIC_MEETING_LINK.'.status', 1);
    $this->db->where(TBL_TOPIC_MEETING_LINK.'.course_id', $course_id);
    $this->db->where(TBL_TOPIC_MEETING_LINK.'.time_table_id', $time_table_id);
    $this->db->where(TBL_TOPIC_MEETING_LINK.'.time_table_transection_id', $time_table_transection_id);
    $query = $this->db->get(TBL_TOPIC_MEETING_LINK);
    $rowcount = $query->num_rows();
    return $rowcount;

}

public function getstudenttopicmeetinglinkData($params,$time_table_id,$course_id,$time_table_transection_id){

    $this->db->select('*');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_TOPIC_MEETING_LINK.".title LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_TOPIC_MEETING_LINK.".topic_name LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_TOPIC_MEETING_LINK.'.isDeleted', 0);
    $this->db->where(TBL_TOPIC_MEETING_LINK.'.status', 1);
    $this->db->where(TBL_TOPIC_MEETING_LINK.'.course_id', $course_id);
    $this->db->where(TBL_TOPIC_MEETING_LINK.'.time_table_id', $time_table_id);
    $this->db->where(TBL_TOPIC_MEETING_LINK.'.time_table_transection_id', $time_table_transection_id);
    $this->db->limit($params['length'],$params['start']);
    $query = $this->db->get(TBL_TOPIC_MEETING_LINK);
    $fetch_result = $query->result_array();
    $data = array();
    $counter = 0;
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {
            $data[$counter]['topic_name'] = $value['topic_name'];
            $data[$counter]['timings'] =  $value['timings'];
            $data[$counter]['link_url'] = '<a href="'.$value['link_url'].'" target="_blank">'.$value['link_url'].'</a>'; ;
            $data[$counter]['action'] = '';
            //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_topic_meeting_document' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Topic Meeting Link' title='Delete Topic Meeting Link'></a>"; 
            $counter++; 
        }
    }

    return $data;

}


public function saveAttendancedata($data){

    if($this->db->insert(TBL_ATTENDANCE, $data)) {
        return $this->db->insert_id();
    } else {
        return FALSE;
    }
    
}


public function checkifAttendanceaxist($data){
        $this->db->select('*');
        $this->db->from(TBL_ATTENDANCE);
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('topic_id', $data['topic_id']);
        $this->db->where('course_id', $data['course_id']);
        //$this->db->where('meeting_id', $data['meeting_id']);
    
       // $this->db->where('id', $data['meeting_link']);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
}



public function getstudentAttendanceCount($params,$userId){

    $this->db->select('*');
    $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ATTENDANCE.'.course_id');
    $this->db->join(TBL_USER, TBL_USER.'.userId  = '.TBL_ATTENDANCE.'.user_id');
    $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_ATTENDANCE.'.topic_id');
    //$this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.id = '.TBL_ATTENDANCE.'.meeting_id');

    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_USER.'.userId', $userId);
    $query = $this->db->get(TBL_ATTENDANCE);
    $rowcount = $query->num_rows();
    return $rowcount;

}
 

public function getstudentAttendancedata($params,$userId){

    $this->db->select('*');
    $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ATTENDANCE.'.course_id');
    $this->db->join(TBL_USER, TBL_USER.'.userId  = '.TBL_ATTENDANCE.'.user_id');
    $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_ATTENDANCE.'.topic_id');
    //$this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.id = '.TBL_ATTENDANCE.'.meeting_id');

    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%')");
    }
    //$this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
    $this->db->where(TBL_USER.'.userId', $userId);
    //$this->db->order_by(TBL_TOPIC_MEETING_LINK.'.id', 'DESC');
    $this->db->order_by(TBL_TIMETABLE_TRANSECTIONS.'.id', 'DESC');

    $this->db->limit($params['length'],$params['start']);
    $query = $this->db->get(TBL_ATTENDANCE);
    $fetch_result = $query->result_array();

    $data = array();
    $counter = 0;
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {
            //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
             $data[$counter]['class_date'] =  date('d-m-Y', strtotime($value['date']));
             $data[$counter]['name'] = $value['name'];
             $data[$counter]['course_name'] = $value['course_name'];
             //$data[$counter]['enq_date'] = date('d-m-Y', strtotime($value['enq_date']));
             $data[$counter]['topic'] = $value['topic'];
             $data[$counter]['timings'] = $value['timings'];

             if($value['attendance_status']==1){
                  $attendance_flag= 'Attended';
             }

             $data[$counter]['attendance_flag'] =$attendance_flag;

            $counter++; 
        }
    }
    return $data;
}


public function  getstudentexaminationCount($params,$userId,$course_id){

    $this->db->select('enq_course_id');
    $this->db->join(TBL_USERS_ENQUIRES, TBL_USERS_ENQUIRES.'.enq_id = '.TBL_ENQUIRY.'.enq_id');
    $this->db->where(TBL_USERS_ENQUIRES.'.user_id',$userId);
    $get_enquiry_courses = $this->db->get(TBL_ENQUIRY);
    $fetch_result_enquiry_courses = $get_enquiry_courses->result_array();

    $data = array();
    $counter = 0;
    foreach ($fetch_result_enquiry_courses as $key => $value) {
        
        $course_ids    =   explode(',', $value['enq_course_id']);
        foreach ($course_ids as $key => $value) {
        
        $this->db->select('*');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_EXAMINATION.'.course_id');
        if($params['search']['value'] != "") 
        {
          $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
          $this->db->or_where(TBL_EXAMINATION.".exam_title LIKE '%".$params['search']['value']."%'");
          $this->db->or_where(TBL_EXAMINATION.".exam_time LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_EXAMINATION.'.isDeleted', 0);
        $this->db->where(TBL_EXAMINATION.'.course_id', $value);
        $this->db->where(TBL_COURSE.'.courseId', $course_id);

        $this->db->order_by(TBL_EXAMINATION.'.id', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_EXAMINATION);
        $rowcount = $query->num_rows();
    
    }
    return $rowcount;

    }


}

public function getstudentexaminationdata($params,$userId,$course_id){

    /*check if user Having Direct Access to attend Exam*/
    $this->db->select('enq_course_id');
    $this->db->join(TBL_USERS_ENQUIRES, TBL_USERS_ENQUIRES.'.enq_id = '.TBL_ENQUIRY.'.enq_id');
    $this->db->where(TBL_USERS_ENQUIRES.'.user_id',$userId);
    $get_enquiry_courses = $this->db->get(TBL_ENQUIRY);
    $fetch_result_enquiry_courses = $get_enquiry_courses->result_array();

    $data = array();
    $counter = 0;
   
    foreach ($fetch_result_enquiry_courses as $key => $value) {

        $course_ids    =   explode(',', $value['enq_course_id']);
        foreach ($course_ids as $key => $value) {

        // $this->db->select('count(*) as attendance');
        // $this->db->where(TBL_ATTENDANCE.'.user_id', $userId);
        // $this->db->where(TBL_ATTENDANCE.'.course_id', $value);
        // $this->db->where(TBL_ATTENDANCE.'.attendance_status', 1);
        // $query = $this->db->get(TBL_ATTENDANCE);
        // $attendance[] = $query->result_array();

        // $this->db->select('count(*) as topic');
        // $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.course_id', $value);
        // $query = $this->db->get(TBL_TIMETABLE_TRANSECTIONS);
        // $topic[] = $query->result_array();


        $this->db->select('*');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_EXAMINATION.'.course_id');
        // $this->db->join(TBL_STUDENT_ANSWER_SHEET, TBL_STUDENT_ANSWER_SHEET.'.exam_id = '.TBL_EXAMINATION.'.id');
        // $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id', $userId);
        // $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $value);

        if($params['search']['value'] != "") 
        {
          $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
          $this->db->or_where(TBL_EXAMINATION.".exam_title LIKE '%".$params['search']['value']."%'");
          $this->db->or_where(TBL_EXAMINATION.".exam_time LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_EXAMINATION.'.isDeleted', 0);
        $this->db->where(TBL_EXAMINATION.'.course_id', $value);
        $this->db->where(TBL_COURSE.'.courseId', $course_id);
        $this->db->order_by(TBL_EXAMINATION.'.id', 'DESC');
       // $this->db->group_by(TBL_STUDENT_ANSWER_SHEET.'.student_id');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_EXAMINATION);
        $fetch_result = $query->result_array();


        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {  

                    /*check Here Exam is completed or not*/

                    $check_exam_completed_or_pending = $this->checkexamiscompletedornot($userId,$value['id'],$value['course_id']);

                    if($check_exam_completed_or_pending){
                        $exam_status ='<b style="color:green">Exam Completed</b>';
                        $exam_status_for_condition ='Exam Completed';
                        $exam_status_count =1;
                    }else{
                        $exam_status ='<b style="color:red"></b>';

                        $exam_status_for_condition ='';
                        $exam_status_count =0;
                    }

                    $data[$counter]['course_name'] = $value['course_name'];
                    $data[$counter]['exam_title'] = $value['exam_title'];
                    $data[$counter]['exam_time'] = $value['exam_time'];
                    $data[$counter]['status'] = $exam_status;
                    $data[$counter]['action'] = '';
                  
                    if($exam_status_count=='1'){
                        $data[$counter]['action'] .= "<a href='".ADMIN_PATH."showexamstatus/".$value['id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/status.png' alt='Show Exam Status' title='Show Exam Status'></a> ";
                    }else{
                        $data[$counter]['action'] .= "<a href='".ADMIN_PATH."attendexamination/".$value['id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/exam.png' alt='Start Examination' title='Start Examination'></a> ";
                    }
                  
                $counter++; 
            }
        }

    }        
    }

    return $data; 
}

public function getstudentexamquestionlist($exam_id){
    $this->db->select('*');
    $this->db->join(TBL_QUESTION_PAPER, TBL_QUESTION_PAPER.'.examination_id = '.TBL_EXAMINATION.'.id');
    $this->db->where(TBL_EXAMINATION.'.id', $exam_id);
    $this->db->order_by(TBL_EXAMINATION.'.id', 'ASC');
    $query = $this->db->get(TBL_EXAMINATION);
    $fetch_result = $query->result_array();
    return $fetch_result;
}

public function getExamdetails($exam_id){

    $this->db->select('*');
    $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_EXAMINATION.'.course_id');
    $this->db->where(TBL_EXAMINATION.'.id', $exam_id);
    $this->db->order_by(TBL_EXAMINATION.'.id', 'ASC');
    $query = $this->db->get(TBL_EXAMINATION);
    $fetch_result = $query->result_array();
    return $fetch_result;

}


public function saveAnswerdata($id,$data){
    if($id != '') {
        $this->db->where('id', $id);
        if($this->db->update(TBL_STUDENT_ANSWER_SHEET, $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        if($this->db->insert(TBL_STUDENT_ANSWER_SHEET, $data)) {
            return $this->db->insert_id();;
        } else {
            return FALSE;
        }
    }
}


public function checkexamiscompletedornot($userId,$exam_id,$course_id){

    $this->db->select('*');
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id', $userId);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.exam_id', $exam_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $course_id);
    $query = $this->db->get(TBL_STUDENT_ANSWER_SHEET);
    $fetch_result = $query->result_array();
    return $fetch_result;

}

public function updateAnswerdata($student_id,$course_id,$examination_id,$question_id,$data){


        //$this->db->where('id', $id);
        $this->db->where('question_id', $question_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('exam_id', $examination_id);
        $this->db->where('student_id', $student_id);
        if($this->db->update(TBL_STUDENT_ANSWER_SHEET, $data)){
            return TRUE;
        } else {
            return FALSE;
        }
}


function studentcertificateCount($params)
{

    $userId =  $this->session->userdata('userId');

 
    $this->db->select('*');
    $this->db->join(TBL_COURSE, TBL_STUDENT_ANSWER_SHEET.'.course_id = '.TBL_COURSE.'.courseId');
    $this->db->join(TBL_EXAMINATION, TBL_STUDENT_ANSWER_SHEET.'.exam_id = '.TBL_EXAMINATION.'.id');
    $this->db->join(TBL_USER, TBL_STUDENT_ANSWER_SHEET.'.student_id = '.TBL_USER.'.userId');


    if($params['search']['value'] != "") 
    {
        $this->db->where("(course.course_name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where("BaseTbl.exam_title LIKE '%".$params['search']['value']."%'");
        $this->db->or_where("BaseTbl.exam_time LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.question_status', 'checked');
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id',  $userId);

    $this->db->order_by(TBL_STUDENT_ANSWER_SHEET.'.ans_id', 'DESC');
    $this->db->group_by(TBL_STUDENT_ANSWER_SHEET.'.student_id');
    $query = $this->db->get(TBL_STUDENT_ANSWER_SHEET);
    return $query->num_rows();
}


function studentcertificateData($params)
{

    $userId =  $this->session->userdata('userId');

    $this->db->select('*');
    $this->db->join(TBL_COURSE, TBL_STUDENT_ANSWER_SHEET.'.course_id = '.TBL_COURSE.'.courseId');
    $this->db->join(TBL_EXAMINATION, TBL_STUDENT_ANSWER_SHEET.'.exam_id = '.TBL_EXAMINATION.'.id');
    $this->db->join(TBL_USER, TBL_STUDENT_ANSWER_SHEET.'.student_id = '.TBL_USER.'.userId');

    if($params['search']['value'] != "") 
    {
        $this->db->where("(course.course_name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where("BaseTbl.exam_title LIKE '%".$params['search']['value']."%'");
        $this->db->or_where("BaseTbl.exam_time LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.question_status', 'checked');

    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id',  $userId);

    $this->db->order_by(TBL_STUDENT_ANSWER_SHEET.'.ans_id', 'DESC');
    $this->db->group_by(TBL_STUDENT_ANSWER_SHEET.'.student_id');
    $this->db->limit($params['length'],$params['start']);
    $query = $this->db->get(TBL_STUDENT_ANSWER_SHEET);
    $fetch_result = $query->result_array();

    $data = array();
    $counter = 0;
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {
           $chekc_student_exam_status =  $this->getexamstatus($value['courseId'],$value['id'],$value['userId']);

            if($chekc_student_exam_status[0]['exam_status']){
                $exam_status = 'Completed';
            }else{
                $exam_status = 'Pending';
            }

            $total_marks =  $this->gettotalmarks($value['courseId'],$value['id'],$value['userId']);

            if($total_marks[0]['totalmarks']){
                $total_marks=  $total_marks[0]['totalmarks'];
                $ans_sheet_status ='Checked';
            }else{
                $total_marks=0;
                $ans_sheet_status ='Checking Pending';
            }

            if($total_marks >= 90 ){

                $grade ='A+';
                $Grade_point='10';
                $Remark ='Pass';
                $Quntitave_value='Outstanding';

            }else if($total_marks >= 80 && $total_marks <= 89){

                $grade ='A';
                $Grade_point='9';
                $Remark ='Pass';
                $Quntitave_value='Excellent';

            } else if($total_marks >= 70 && $total_marks <= 79){

                $grade ='B+';
                $Grade_point='8';
                $Remark ='Pass';
                $Quntitave_value='Very Good';

            } else if($total_marks >= 60 && $total_marks <= 69){

                $grade ='B';
                $Grade_point='7';
                $Remark ='Pass';
                $Quntitave_value='Good';

            }
            else if($total_marks >= 50 && $total_marks <= 59){

                $grade ='C';
                $Grade_point='6';
                $Remark ='Pass';
                $Quntitave_value='Above Average';

            }
            else if($total_marks >= 40 && $total_marks <= 49){

                $grade ='D';
                $Grade_point='5';
                $Remark ='Pass';
                $Quntitave_value='Average';

            }

            else if($total_marks >= 40 && $total_marks <= 44){

                $grade ='D';
                $Grade_point='4';
                $Remark ='Pass';
                $Quntitave_value='Poor';

            }

            else if($total_marks <= 40){

                $grade ='D';
                $Grade_point='0';
                $Remark ='Fail';
                $Quntitave_value='Fail';

            }

             $data[$counter]['name'] = $value['name'].' '.$value['lastname'];
             $data[$counter]['mobile'] = $value['mobile'];
             $data[$counter]['exam_status'] = $exam_status;
             $data[$counter]['total_marks'] = $total_marks;
             $data[$counter]['grade'] = $grade;
             $data[$counter]['grade_point'] = $Grade_point;
             $data[$counter]['remark'] = $Remark;
             $data[$counter]['Quntitave_value'] = $Quntitave_value;
             $data[$counter]['ans_sheet_status'] = $ans_sheet_status;
             $data[$counter]['action'] = '';
             $data[$counter]['action'] .= "<a style='cursor: pointer;'  href='marksheet/index.php?student_id=".$value['student_id']."' target='_blank'  class='print_certificate' data-id='".$value['student_id']."'><img width='20' src=".ICONPATH."/marksheet.png alt='Student Marksheet' title='Student Marksheet'></a> "; 
             $data[$counter]['action'] .= "<a style='cursor: pointer;'  href='certificate/index.php?student_id=".$value['student_id']."' target='_blank'  class='print_certificate' data-id='".$value['student_id']."'><img width='20' src=".ICONPATH."/print.png alt='Print Certificate' title='Print Certificate'></a> "; 

             //$data[$counter]['action'] .= "<a href='".ADMIN_PATH."addmarkstoexam?course_id=".$value['courseId']."&&exam_id=".$value['id']."&&student_id=".$value['userId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/view_doc.png' alt='View/Check Student Answer Paper' title='View/Check Student Answer Paper'></a>";
             
             $counter++; 
        }
    }

    return $data;
}


public function getexamstatus($courseId,$exam_id,$userId){
    $this->db->select('*');
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $courseId);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.exam_id', $exam_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id', $userId);
    $this->db->group_by(TBL_STUDENT_ANSWER_SHEET.'.student_id');
    $query = $this->db->get(TBL_STUDENT_ANSWER_SHEET);
    $fetch_result = $query->result_array();

    return $fetch_result;
}

public function gettotalmarks($courseId,$exam_id,$userId){
    $this->db->select('sum(marks) as totalmarks');
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $courseId);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.exam_id', $exam_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id', $userId);
    $this->db->group_by(TBL_STUDENT_ANSWER_SHEET.'.student_id');
    $query = $this->db->get(TBL_STUDENT_ANSWER_SHEET);
    $fetch_result = $query->result_array();

    return $fetch_result;
}


public function updateEvbtrNumber($certificate_id,$data){

    $this->db->where('userId', $certificate_id);
    if($this->db->update(TBL_USER, $data)){
        return TRUE;
    } else {
        return FALSE;
    }
}

public function getCourseDetailsforBooksAddedornot($id){

    $this->db->select('enq_course_id,book_issued');
    $this->db->join(TBL_USERS_ENQUIRES, TBL_USERS_ENQUIRES.'.user_id = '.TBL_USER.'.userId');
    $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');
    $this->db->where(TBL_USER.'.userId', $id);
    $this->db->where(TBL_USERS_ENQUIRES.'.user_id', $id);

    $query = $this->db->get(TBL_USER);
    $fetch_result = $query->result_array();

    return $fetch_result;
 
   
}


public function updatebookissued($student_id,$data){

    $this->db->where('userId', $student_id);
    if($this->db->update(TBL_USER, $data)){
        return TRUE;
    } else {
        return FALSE;
    }

}

public function getCoursenamebyid($course_id){

    $this->db->select('course_name');
    $this->db->where(TBL_COURSE.'.courseId', $course_id);
    $this->db->where(TBL_COURSE.'.isDeleted', 0);
    $query = $this->db->get(TBL_COURSE);
    $fetch_result = $query->result_array();
    return $fetch_result;

}


public function getStudentrecords($student_id){

    $this->db->select('email,mobile');
    $this->db->where(TBL_USER.'.userid', $student_id);
    $this->db->where(TBL_USER.'.isDeleted', 0);
    $this->db->where(TBL_USER.'.user_flag', 'student');
    $query = $this->db->get(TBL_USER);
    $fetch_result = $query->result_array();
    return $fetch_result;
}



public function getstudentexaminListationdata($userId){
    $this->db->select('enq_course_id');
    $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');
    $this->db->where(TBL_USERS_ENQUIRES.'.user_id',$userId);
    $get_enquiry_courses = $this->db->get(TBL_ENQUIRY);
    $fetch_result_enquiry_courses = $get_enquiry_courses->result_array();

    $data = array();
    $counter = 0;
    foreach ($fetch_result_enquiry_courses as $key => $value) {
        
        $course_ids    =   explode(',', $value['enq_course_id']);
        foreach ($course_ids as $key => $value) {


        $this->db->select('count(*) as count');
        $this->db->where(TBL_ATTENDANCE.'.user_id', $userId);
        $this->db->where(TBL_ATTENDANCE.'.course_id', $value);
        $this->db->where(TBL_ATTENDANCE.'.attendance_status', 1);
        $query = $this->db->get(TBL_ATTENDANCE);
        $fetch_time_table_attendance = $query->result_array();

    
        $this->db->select('count(*) as count');
        $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.course_id', $value);
        $query = $this->db->get(TBL_TIMETABLE_TRANSECTIONS);
        $fetch_topic_table_attendance = $query->result_array();

        $this->db->select('*');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_EXAMINATION.'.course_id');
        // $this->db->join(TBL_STUDENT_ANSWER_SHEET, TBL_STUDENT_ANSWER_SHEET.'.exam_id = '.TBL_EXAMINATION.'.id');
        // $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id', $userId);
        // $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $value);

        $this->db->where(TBL_EXAMINATION.'.isDeleted', 0);
        $this->db->where(TBL_EXAMINATION.'.course_id', $value);

        $this->db->order_by(TBL_EXAMINATION.'.id', 'DESC');
        $this->db->group_by(TBL_COURSE.'.courseId');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_EXAMINATION);
        $fetch_result = $query->result_array();


        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {  

                    /*check Here Exam is completed or not*/

                    $check_exam_completed_or_pending = $this->checkexamiscompletedornot($userId,$value['id'],$value['course_id']);

                    if($check_exam_completed_or_pending){
                        $exam_status ='<b style="color:green">Exam Completed</b>';
                        $exam_status_count =1;
                    }else{
                        $exam_status ='<b style="color:red">Pending</b>';
                        $exam_status_count =0;
                    }
                    $data[$counter]['courseId'] = $value['courseId'];
                    $data[$counter]['course_name'] = $value['course_name'];
                    $data[$counter]['exam_title'] = $value['exam_title'];
                    $data[$counter]['exam_time'] = $value['exam_time'];
                    $data[$counter]['status'] = $exam_status;
                    $data[$counter]['action'] = '';
                   
                $counter++; 
            }
        }

    }
        // if($fetch_time_table_attendance[0]['count'] == $fetch_topic_table_attendance[0]['count']){
        //     return $data; 
        // }else{
           
        //     return array(); 
        // }

            return $data; 
        
    }
}



public function getstudentcourse($params,$userId){


    $this->db->select('enq_course_id');
    $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');
    $this->db->where(TBL_USERS_ENQUIRES.'.user_id',$userId);
    $get_enquiry_courses = $this->db->get(TBL_ENQUIRY);
    $fetch_result_enquiry_courses = $get_enquiry_courses->result_array();

    $data = array();
    $counter = 0;
    foreach ($fetch_result_enquiry_courses as $key => $value) {
        
        $course_ids    =   explode(',', $value['enq_course_id']);
        foreach ($course_ids as $key => $value) {

         $this->db->select('*');
         $this->db->where(TBL_COURSE.'.isDeleted', 0);
         $this->db->where(TBL_COURSE.'.courseId', $value);
         $query = $this->db->get(TBL_COURSE);
         $fetch_result = $query->result_array();


        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {  

                    $data[$counter]['courseId'] = $value['courseId'];
                    $data[$counter]['course_name'] = $value['course_name'];
                  
                $counter++; 
            }
        }

    }
        
            return $data; 
    }
}




public function  getallstudentquerycount($params,$userId,$roleText){

    if($roleText=='Trainer'){
        $getTrainercourseis = $this->gettrainercourseIds($userId);
        $course_id =array();
        foreach ($getTrainercourseis as $key => $value) {
            $course_id[]= $value['course_id'];
             
        }

        if( $getTrainercourseis){
            $this->db->where_in(TBL_COURSE.'.courseId', $course_id);

        }else{
            return array();

        }

            
       }else{
            $this->db->where(TBL_ASK_A_QUERY.'.student_id', $userId);
       }

      

    $this->db->select('*');
    $this->db->join(TBL_COURSE, TBL_ASK_A_QUERY.'.course_id = '.TBL_COURSE.'.courseId');
    $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_ASK_A_QUERY.'.certificate_topic');

    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ASK_A_QUERY.".query LIKE '%".$params['search']['value']."%')");
    }

    $this->db->where(TBL_ASK_A_QUERY.'.status', 1);

    $this->db->order_by(TBL_ASK_A_QUERY.'.id', 'DESC');
    $this->db->limit($params['length'],$params['start']);
    $query = $this->db->get(TBL_ASK_A_QUERY);
    $rowcount = $query->num_rows();
    return $rowcount;

}


public function getallstudentquerydata($params,$userId,$roleText){


    if($roleText=='Trainer'){
        $getTrainercourseis = $this->gettrainercourseIds($userId);
        $course_id =array();
        foreach ($getTrainercourseis as $key => $value) {
            $course_id[]= $value['course_id'];
             
        }

        if( $getTrainercourseis){
            $this->db->where_in(TBL_COURSE.'.courseId', $course_id);

        }else{
            return array();

        }

       }else{
            $this->db->where(TBL_ASK_A_QUERY.'.student_id', $userId);
       }


    $this->db->select('*,'.TBL_ASK_A_QUERY.'.id as queryid');
    $this->db->join(TBL_COURSE, TBL_ASK_A_QUERY.'.course_id = '.TBL_COURSE.'.courseId');
    $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_ASK_A_QUERY.'.certificate_topic');

    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ASK_A_QUERY.".query LIKE '%".$params['search']['value']."%')");
    }

    $this->db->where(TBL_ASK_A_QUERY.'.status', 1);
    // $this->db->where(TBL_ASK_A_QUERY.'.student_id', $userId);
    $this->db->order_by(TBL_ASK_A_QUERY.'.id', 'DESC');
    $this->db->limit($params['length'],$params['start']);
    $query = $this->db->get(TBL_ASK_A_QUERY);
    $fetch_result = $query->result_array();
    $data = array();
    $counter = 0;
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {
             $data[$counter]['course_name'] = $value['course_name'];
             $data[$counter]['topic_name'] = $value['topic'];
             $data[$counter]['query'] = $value['query'];
             $data[$counter]['action'] = '';
             $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewqueryanswer/".$value['queryid']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/process.png' alt='View Answers' title='View Answers'></a> ";
            
            //  if($roleText!='Trainer'){
            //     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_query' data-id='".$value['queryid']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Query' title='Delete Query'></a> "; 
            //  }
             
            $counter++; 
        }
    }

    return $data;
}


public function saveQuerydata($id,$data){

    if($id != '') {
        $this->db->where('id', $id);
        if($this->db->update(TBL_ASK_A_QUERY, $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        if($this->db->insert(TBL_ASK_A_QUERY, $data)) {
            return $this->db->insert_id();;
        } else {
            return FALSE;
        }
    }

}



public function gettrainercourseIds($userId){

    $this->db->select('course_id');
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.trainer_id', $userId);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.isDeleted', 0);
    // $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.isdeleted', 0);
    $query = $this->db->get(TBL_TIMETABLE_TRANSECTIONS);
    $fetch_result = $query->result_array();
    return $fetch_result;

}



public function getallstudentquerydatfornotification($userId,$roleText){


    if($roleText=='Trainer'){
        $getTrainercourseis = $this->gettrainercourseIds($userId);
        $course_id =array();
        foreach ($getTrainercourseis as $key => $value) {
            $course_id[]= $value['course_id'];
             
        }

        if( $getTrainercourseis){
            $this->db->where_in(TBL_COURSE.'.courseId', $course_id);

        }else{
            return array();

        }

            
       }else{
            $this->db->where(TBL_ASK_A_QUERY.'.student_id', $userId);
       }


    $this->db->select('*,'.TBL_ASK_A_QUERY.'.id as queryid');
    $this->db->join(TBL_COURSE, TBL_ASK_A_QUERY.'.course_id = '.TBL_COURSE.'.courseId');
    $this->db->join(TBL_USER, TBL_ASK_A_QUERY.'.student_id = '.TBL_USER.'.userId');

    $this->db->where(TBL_ASK_A_QUERY.'.status', 1);
    // $this->db->where(TBL_ASK_A_QUERY.'.student_id', $userId);
    $this->db->order_by(TBL_ASK_A_QUERY.'.id', 'DESC');

    $query = $this->db->get(TBL_ASK_A_QUERY);
    $fetch_result = $query->result_array();
    $data = array();
    $counter = 0;
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {
             $data[$counter]['course_name'] = $value['course_name'];
             $data[$counter]['courseId'] = $value['courseId'];
             $data[$counter]['name'] = $value['name'];
             $data[$counter]['query'] = $value['query'];
             $data[$counter]['queryid'] = $value['queryid'];
             
            $counter++; 
        }
    }

    return $data;
}



public function trinerNoti($userId,$roleText){
        $getTrainercourseis = $this->gettrainercourseIds($userId);;

        $course_id =array();
        foreach ($getTrainercourseis as $key => $value) {
            $course_id[]= $value['course_id'];
             
        }
        if( $getTrainercourseis){
            $this->db->where_in(TBL_COURSE.'.courseId', $course_id);

        }else{
            return array();

        }

    $this->db->select('*,'.TBL_ASK_A_QUERY.'.id as queryid,'.TBL_ASK_A_QUERY.'.createdDtm as datequery');
    $this->db->join(TBL_COURSE, TBL_ASK_A_QUERY.'.course_id = '.TBL_COURSE.'.courseId');
    $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_ASK_A_QUERY.'.certificate_topic');
    $this->db->join(TBL_USER, TBL_ASK_A_QUERY.'.student_id = '.TBL_USER.'.userId');
    $this->db->where(TBL_ASK_A_QUERY.'.status', 1);
    $this->db->where(TBL_ASK_A_QUERY.'.id NOT IN (SELECT `query_id` FROM '.TBL_ASK_A_QUERY_ANSWER.')', NULL, TRUE);

    // $this->db->where(TBL_ASK_A_QUERY.'.student_id', $userId);
    $this->db->order_by(TBL_ASK_A_QUERY.'.id', 'DESC');

    $query = $this->db->get(TBL_ASK_A_QUERY);
    $fetch_result = $query->result_array();
    $data = array();
    $counter = 0;
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {
             $data[$counter]['queryid'] = $value['queryid'];
             $data[$counter]['course_name'] = $value['course_name'];
             $data[$counter]['topic_name'] = $value['topic'];
             $data[$counter]['name'] = $value['name'];
             $data[$counter]['query'] = $value['query'];
             $data[$counter]['datequery'] = $value['datequery'];
            $counter++; 
        }
    }

    return $data;
}



public function getquerydatabyid($query_id){

    $this->db->select('*,'.TBL_ASK_A_QUERY.'.id as queryid');
    $this->db->join(TBL_COURSE, TBL_ASK_A_QUERY.'.course_id = '.TBL_COURSE.'.courseId');
    $this->db->join(TBL_USER, TBL_ASK_A_QUERY.'.student_id = '.TBL_USER.'.userId');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ASK_A_QUERY.".query LIKE '%".$params['search']['value']."%')");
    }

    $this->db->where(TBL_ASK_A_QUERY.'.status', 1);
    $this->db->where(TBL_ASK_A_QUERY.'.id', $query_id);
    $query = $this->db->get(TBL_ASK_A_QUERY);
    $fetch_result = $query->result_array();
    return $fetch_result;
}


public function getallstudentqueryanswercount($params,$userId,$roleText,$query_id){
    $this->db->select('*');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_ASK_A_QUERY_ANSWER.".query_answer LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ASK_A_QUERY_ANSWER.".query_answer LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_ASK_A_QUERY_ANSWER.'.query_id', $query_id);
   // $this->db->where(TBL_ASK_A_QUERY_ANSWER.'.student_id', $userId);
    $query = $this->db->get(TBL_ASK_A_QUERY_ANSWER);
    $rowcount = $query->num_rows();
    return $rowcount;
}

public function getallstudentqueryanswerdata($params,$userId,$roleText,$query_id){
    $this->db->select('*');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_ASK_A_QUERY_ANSWER.".query_answer LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_ASK_A_QUERY_ANSWER.".query_answer LIKE '%".$params['search']['value']."%')");
    }

    $this->db->where(TBL_ASK_A_QUERY_ANSWER.'.query_id', $query_id);
    //$this->db->where(TBL_ASK_A_QUERY_ANSWER.'.student_id', $userId);
    $this->db->order_by(TBL_ASK_A_QUERY_ANSWER.'.id', 'DESC');
    $this->db->limit($params['length'],$params['start']);
    $query = $this->db->get(TBL_ASK_A_QUERY_ANSWER);
    $fetch_result = $query->result_array();

    $data = array();
    $counter = 0;
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {

            //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
             $data[$counter]['query_answer'] = $value['query_answer'];
             if($roleText=='Trainer'){
                $data[$counter]['action'] = '';
                $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_query_answer' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Query Answer' title='Delete Query Answer'></a> "; 
             }
             $counter++; 
        }
    }
    return $data;
}



public function saveQueryanswerdata($id,$data){
    if($id != '') {
        $this->db->where('id', $id);
        if($this->db->update(TBL_ASK_A_QUERY_ANSWER, $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        if($this->db->insert(TBL_ASK_A_QUERY_ANSWER, $data)) {
            return $this->db->insert_id();;
        } else {
            return FALSE;
        }
    }

}



public function  getallstudentreportcount($params){
    $this->db->select('*');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_USER.".name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_USER.".mobile LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_USER.".username LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_USER.".email LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_USER.'.isDeleted', 0);
    $this->db->where(TBL_USER.'.user_flag', 'student');
    $query = $this->db->get(TBL_USER);
    $rowcount = $query->num_rows();
    
    return $rowcount;

}

public function getallstudentreportdata($params){
    $this->db->select('*');
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_USER.".name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_USER.".mobile LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_USER.".username LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_USER.".email LIKE '%".$params['search']['value']."%')");
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
             $data[$counter]['user_flag']   =  $value['email'];
            $counter++; 
        }
    }
    return $data;
}


public function getallstudentlist(){

    $this->db->select('*');
    $this->db->where(TBL_USER.'.isDeleted', 0);
    $this->db->where(TBL_USER.'.user_flag', 'student');
    $query = $this->db->get(TBL_USER);
    $fetch_result = $query->result_array();
    return $fetch_result;

}


public function courseLinksListing($courseId)
{
    $this->db->select('*');
    $this->db->where(TBL_USER.'.isDeleted', 0);
    $this->db->where(TBL_USER.'.user_flag', 'student');
    $query = $this->db->get(TBL_USER);
    $fetch_result = $query->result_array();
    return $fetch_result;
}


public function getallstudentdataforshowidcard($data){

     $user_id = $data['user_id'];
     $topic_id = $data['topic_id'];
     $course_id = $data['course_id'];
    // $this->db->select('*');
    // $this->db->join(TBL_USERS_ENQUIRES, TBL_USER.'.userId = '.TBL_USERS_ENQUIRES.'.user_id');
    // $this->db->join(TBL_ENQUIRY, TBL_USERS_ENQUIRES.'.enq_id = '.TBL_ENQUIRY.'.enq_id');
    // //$this->db->join(TBL_USERS_ENQUIRES, TBL_USER.'.userId = '.TBL_USERS_ENQUIRES.'.user_id');

    // $this->db->where(TBL_USER.'.isDeleted', 0);
    // $this->db->where(TBL_USER.'.user_flag', 'student');
    // $this->db->where(TBL_USER.'.userId', $user_id);
    // $query = $this->db->get(TBL_USER);
    // $fetch_result = $query->result_array();
    // return $fetch_result;

    $this->db->select('enq_course_id,'.TBL_USER.'.*');
    $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');
    $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_USERS_ENQUIRES.'.user_id');
    $this->db->where(TBL_USER.'.userId',$user_id);
    $get_enquiry_courses = $this->db->get(TBL_USERS_ENQUIRES);
    $fetch_result_enquiry_courses = $get_enquiry_courses->result_array();

    $data = array();
    $counter = 0;
     foreach ($fetch_result_enquiry_courses as $key => $value_enquiry) {

     $course_ids    =   explode(',', $value_enquiry['enq_course_id']);

     foreach ($course_ids as $key => $value) {
       
        $this->db->select('*,'.TBL_TOPIC_MEETING_LINK.'.id as meeting_id,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topicid,'.TBL_TIMETABLE_TRANSECTIONS.'.timings as classtime');
        $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id');

        $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.course_id = '.TBL_COURSE.'.courseId');
        $this->db->join(TBL_TIMETABLE, TBL_TIMETABLE_TRANSECTIONS.'.time_table_id = '.TBL_TIMETABLE.'.id');

        $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.time_table_transection_id = '.TBL_TIMETABLE_TRANSECTIONS.'.id','left');

        $this->db->where(TBL_COURSE.'.isDeleted', 0);
        $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.id', $topic_id);
        $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.course_id', $course_id);
        // $this->db->where(TBL_COURSE.'.courseId IN (SELECT  enq_course_id from  tbl_enquiry join tbl_users_enquires on tbl_enquiry.enq_number=tbl_users_enquires.enq_id where tbl_users_enquires.user_id='.$userId.')');
        $this->db->where(TBL_COURSE.'.courseId', $value);

        $this->db->order_by(TBL_COURSE.'.courseId', 'DESC');
        $query = $this->db->get(TBL_COURSE);
        $fetch_result = $query->result_array();

    
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                
                    $data[$counter]['name'] = $value_enquiry['name'];
                    $data[$counter]['lastname'] = $value_enquiry['lastname'];
                    $data[$counter]['profile_pic'] = $value_enquiry['profile_pic'];
                    $data[$counter]['mobile'] = $value_enquiry['mobile'];

                    $data[$counter]['course_name'] = $value['course_name'];
                    $data[$counter]['title'] = $value['topic'];
                    $data[$counter]['classtime'] = $value['classtime'];
                    $data[$counter]['link_url'] = $value['link_url'];
                    $data[$counter]['createdDtm'] = $value['createdDtm'];
                    $data[$counter]['date'] = $value['date'];
                    $data[$counter]['meeting_id'] = $value['meeting_id'];
                    $data[$counter]['topicid'] = $value['topicid'];
                    $data[$counter]['userid'] =  $userId;
                    $data[$counter]['courseId'] = $value['courseId'];
                    // $data[$counter]['attendance_alreday_exits'] =  $attendance_alreday_exits;
                    $data[$counter]['action'] = '';
                    $counter++; 
            }
        }
    }

    
  }

  return $data;
}



public function checkifAttendanceisexits($userId,$courseId,$topicid){

    $this->db->select('*');
    $this->db->where(TBL_ATTENDANCE.'.course_id', $courseId);
    $this->db->where(TBL_ATTENDANCE.'.topic_id', $topicid);
    $this->db->where(TBL_ATTENDANCE.'.user_id', $userId);
    $this->db->limit(1);
    $query = $this->db->get(TBL_ATTENDANCE);
    $fetch_result = $query->result_array();

    return $fetch_result;

}


public function getAllstudentlistexport() {
    $this->db->select(array('userId', 'name', 'email', 'mobile', 'profile_pic', 'gender'));
    $this->db->from(TBL_USER);
    $this->db->limit(10);  
    $query = $this->db->get();
    return $query->result_array();
}


public function getcoursetopic($course_id)
{
    $this->db->select('*');
    $this->db->where('course_id', $course_id);
    $this->db->where('iscancle', 0);
    $this->db->where('isdeleted', 0);
    $this->db->order_by('topic','ASC');
    $query_result = $this->db->get(TBL_TIMETABLE_TRANSECTIONS)->result_array();
    if($state_id != '') {
        foreach($query_result as $key => $value) {
            if($value['id'] == $state_id) {
                $query_result[$key]['selected'] = 'selected';
            } else {
                $query_result[$key]['selected'] = '';
            }
        }
    }
    return $query_result;
}

public function getstudentinformation($student_id){
    
    $this->db->select('userId,email,name,lastname,mobile');
    $this->db->from(TBL_USER);
    $this->db->where('userId', $student_id);
    $query = $this->db->get();
    $query->result_array();
    return $query->result_array();
}

public function getstudentcourselist($student_name){

    $this->db->select('enq_course_id');
    $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');
    $this->db->where(TBL_USERS_ENQUIRES.'.user_id', $student_name);
    $query = $this->db->get(TBL_USERS_ENQUIRES);
    $fetch_result_enquiry_courses = $query->result_array();

    $data = array();
    $counter = 0;
     foreach ($fetch_result_enquiry_courses as $key => $value) {

     $course_ids    =   explode(',', $value['enq_course_id']);

        foreach ($course_ids as $key => $value) {

              $getCourseInfo = $this->getcourseinfobyid($value);

              $data[$counter]['courseId'] = $getCourseInfo[0]->courseId;
              $data[$counter]['course_name'] = $getCourseInfo[0]->course_name;
              $counter++; 
        }
    }

    return $data;
   

}


public function getcourseinfobyid($course_id){
        $this->db->select('courseId,course_name');
        $this->db->from(TBL_COURSE);
        $this->db->where('isDeleted', 0);
        $this->db->where('courseId', $course_id);
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

public function get_final_amount_of_add_on_course($enq_id,$add_on_course_id){

    $this->db->select(TBL_ADD_ON_COURSE.'.id as addoncourse_id,'.TBL_ADD_ON_COURSE.'.createdDtm as addoncoursedatetime,'.TBL_COURSE.'.course_name,'.TBL_COURSE.'.course_total_fees,'.TBL_ADD_ON_COURSE.'.discount');
    $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ADD_ON_COURSE.'.course_id');
    $this->db->where(TBL_ADD_ON_COURSE.'.enquiry_id', $enq_id);
    $this->db->where(TBL_ADD_ON_COURSE.'.id', $add_on_course_id);
    $query = $this->db->get(TBL_ADD_ON_COURSE);
    return $query->row_array();

}


}

?>