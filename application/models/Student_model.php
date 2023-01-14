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
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_number = '.TBL_PAYMENT.'.enquiry_id');
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


    public function getEnquiryCount($params,$userId){
        $this->db->select('*');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_ENQUIRY.'.course_type_id','left');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_number = '.TBL_USERS_ENQUIRES.'.enq_id');
        $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_id','left');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_ENQUIRY.".enq_mobile LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
        $this->db->where(TBL_USERS_ENQUIRES.'.user_id', $userId);
        $query = $this->db->get(TBL_ENQUIRY);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function getEnquirydata($params,$userId){
        $this->db->select('*,'.TBL_ADMISSION.'.enq_id as admissionexits,'.TBL_ENQUIRY.'.enq_id as enquiry_id');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_number = '.TBL_USERS_ENQUIRES.'.enq_id');
        $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_id','left');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_ENQUIRY.".enq_fullname LIKE '%".$params['search']['value']."%'");
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

                if(!empty($value['admissionexits'])){
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
                        $get_course_fees =  $this->student_model->getCourseInfo($id);
                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees[0]->course_total_fees;
                            $course_name .= $i.'-'.$get_course_fees[0]->course_name. ',';  
                            $i++;  

                        }else{

                            $total_fees = '';
                            $course_name = '';  
                            $i++;  
                        }
                      
                    }
                 $all_course_name = trim($course_name, ', '); 

                 // $data[$counter]['total_fees'] = '₹ '.$total_fees ;

                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."studentpaymentdetails/".$value['enquiry_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/payment.png' alt='Student Payment Details' title='Student Payment Details'></a>  ";
                                 
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
        $this->db->where(TBL_COURSE.'.courseId IN (SELECT  enq_course_id from  tbl_enquiry join tbl_users_enquires on tbl_enquiry.enq_number=tbl_users_enquires.enq_id where tbl_users_enquires.user_id='.$userId.')');
        $query = $this->db->get(TBL_COURSE);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getstudentCoursedata($params,$userId){
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        $pageUrl =$this->uri->segment(1);


        $this->db->select('enq_course_id');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_number = '.TBL_USERS_ENQUIRES.'.enq_id');
        $this->db->where(TBL_USERS_ENQUIRES.'.user_id',$userId);
        $get_enquiry_courses = $this->db->get(TBL_ENQUIRY);
        $fetch_result_enquiry_courses = $get_enquiry_courses->result_array();

        $data = array();
        $counter = 0;
       foreach ($fetch_result_enquiry_courses as $key => $value) {
        
    

         $course_ids    =   explode(',', $value['enq_course_id']);

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
                    $data[$counter]['course_fees'] = '₹' .$value['course_total_fees'];

                    if($value['course_books']==1){
                        $course_books = 'Books Available';
                    }else{
                        $course_books = '';
                    }

                   
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


                    $data[$counter]['course_mode'] = $course_mode_online.' '.$course_mode_offline;
                    $data[$counter]['course_books'] = $course_books;

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

             $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addstudenttopiclinksforonlineattendant?id=".$value['id']."&time_table_id=".$value['time_table_id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/attachment.png' alt='Add Online Meeting Link' title='Add Online Meeting Link'></a>";

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
        $this->db->where('meeting_id', $data['meeting_id']);
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
    $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.id = '.TBL_ATTENDANCE.'.meeting_id');

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
    $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.id = '.TBL_ATTENDANCE.'.meeting_id');

    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%')");
    }
    //$this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
    $this->db->where(TBL_USER.'.userId', $userId);
    $this->db->order_by(TBL_TOPIC_MEETING_LINK.'.id', 'DESC');
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


public function  getstudentexaminationCount($params,$userId){

    $this->db->select('enq_course_id');
    $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_number = '.TBL_USERS_ENQUIRES.'.enq_id');
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

        $this->db->order_by(TBL_EXAMINATION.'.id', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_EXAMINATION);
        $rowcount = $query->num_rows();
    
    }
    return $rowcount;

    }


}

public function getstudentexaminationdata($params,$userId){

    $this->db->select('enq_course_id');
    $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_number = '.TBL_USERS_ENQUIRES.'.enq_id');
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

        $this->db->order_by(TBL_EXAMINATION.'.id', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_EXAMINATION);
        $fetch_result = $query->result_array();
    
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {  
                    $data[$counter]['course_name'] = $value['course_name'];
                    $data[$counter]['exam_title'] = $value['exam_title'];
                    $data[$counter]['exam_time'] = $value['exam_time'];
                    $data[$counter]['status'] = '';
                    $data[$counter]['action'] = '';
                    $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewstudentscoursetopis/".$value['courseId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/books.png' alt='View Topics' title='View Topics'></a> ";
                $counter++; 
            }
        }

    }
        return $data;
    }



}



}

?>