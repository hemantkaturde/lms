<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model
{

    public function __construct()
    {
         parent::__construct();
         $this->load->model(array('user_model','enquiry_model','course_model','student_model','admission_model','event'));
         //$this->load->library('form_validation');
    }
    /*get Authtoken*/
    public function getAuthtoken($data) {
		
		try{
            extract($data);

            $this->db->select('BaseTbl.isDeleted');
            $this->db->from('tbl_users as BaseTbl');
            $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId'); 
            $likeCriteria = "(BaseTbl.email  LIKE '%".$username."%' OR  BaseTbl.username  LIKE '%".$username."%' OR  BaseTbl.mobile  LIKE '%".$username."%')";
            $this->db->where($likeCriteria);
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->limit(1);
            $query = $this->db->get();
            $user_data = $query->row();

            if($user_data){
                if($user_data->isDeleted == 0){
                    $this->db->select('BaseTbl.enq_id,BaseTbl.userId, BaseTbl.password, BaseTbl.email ,BaseTbl.name,BaseTbl.status,BaseTbl.roleId, Roles.role,Roles.access,BaseTbl.profile_pic,BaseTbl.username,BaseTbl.password,BaseTbl.mobile,BaseTbl.user_flag');
                    $this->db->from('tbl_users as BaseTbl');
                    $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId'); 
                    $likeCriteria = "(BaseTbl.email  LIKE '%".$username."%' OR  BaseTbl.username  LIKE '%".$username."%' OR  BaseTbl.mobile  LIKE '%".$username."%')";
                    $this->db->where($likeCriteria);
                    $this->db->limit(1);
                    $query = $this->db->get();
                    $get_actual_user_data = $query->row();

                    if(trim($password)== base64_decode($get_actual_user_data->password)){
                        $authtoken = uniqueAlphaNumericString(30); //30 digit authtoken
                        $this->db->where('userId',$get_actual_user_data->userId);
                        $this->db->update(TBL_USER, array(
                            'authtoken' => $authtoken,
                            'updatedDtm' => DATEANDTIME
                        ));
                        return array('authtoken' => $authtoken,'id' => $get_actual_user_data->userId,'name' => $get_actual_user_data->name,'email' => $get_actual_user_data->email, 'username' => $get_actual_user_data->username,'mobile_no' => $get_actual_user_data->mobile,'user_flag' =>  $get_actual_user_data->role);
                    } else {
                        return "password mismatch";
                    }
                }else{
                    return "account disable";
                }
            }else{
                return "Username not available";
            }

        }catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /*get All Enquiry List*/
    public function getEnquiryData($data){

        try{
            //extract($data);

            $this->db->select('*,'.TBL_ENQUIRY.'.enq_id as id,'.TBL_ENQUIRY.'.enq_id as enq_id,'.TBL_ADMISSION.'.enq_id as admission_status,'.TBL_ENQUIRY.'.enq_number,'.TBL_USER.'.name as counseller,'.TBL_ENQUIRY.'.enq_fullname,'.TBL_ENQUIRY.'.enq_mobile,'.TBL_ENQUIRY.'.enq_email,'.TBL_ENQUIRY.'.doctor_non_doctor,'.TBL_ENQUIRY.'.enq_course_id,'.TBL_CITIES.'.name city_name,'.TBL_ENQUIRY.'.counsellor_id');
            // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
            $this->db->join(TBL_CITIES, TBL_CITIES.'.id = '.TBL_ENQUIRY.'.enq_city');
            $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_id','left');
            $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_ENQUIRY.'.counsellor_id');
            $this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
            $this->db->order_by(TBL_ENQUIRY.'.enq_id', 'DESC');
            $query = $this->db->get(TBL_ENQUIRY);
            $fetch_result = $query->result_array();

            $data = array();
            $counter = 0;
            if(count($fetch_result) > 0)
            {
                foreach ($fetch_result as $key => $value)
                {

                 $data[$counter]['id'] = $value['enq_id'];
                 $data[$counter]['enq_number'] = $value['enq_number'];
                 $data[$counter]['enq_date'] = date('d-m-Y', strtotime($value['enq_date']));
                 $data[$counter]['enq_city'] = $value['enq_city'];
                 $data[$counter]['city_names'] = $value['city_name'];
                 $data[$counter]['enq_fullname'] = $value['enq_fullname'];
                 $data[$counter]['enq_mobile'] = $value['enq_mobile'];
                 $data[$counter]['enq_email'] = $value['enq_email'];
                 $data[$counter]['enq_qualification'] = $value['enq_qualification'];
                 $data[$counter]['doctor_non_doctor'] = $value['doctor_non_doctor'];
                 $data[$counter]['enq_source'] = $value['enq_source'];
                
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
                
                        $get_course_fees =  $this->getCourseInfo($id);
                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees[0]->course_total_fees;
                            $course_name .= $get_course_fees[0]->course_name.',';  
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
                 $data[$counter]['counsellor_id'] = $value['counsellor_id'];

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

            return $data;
        }

        }catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /*get All Course List*/
    public function getCourseData($data){
        $this->db->select('BaseTbl.courseId , BaseTbl.course_name, BaseTbl.course_desc, BaseTbl.course_date,BaseTbl.createdDtm, BaseTbl.course_fees, Type.ct_name,BaseTbl.course_total_fees,BaseTbl.course_books,BaseTbl.course_mode_online,BaseTbl.course_mode_offline,BaseTbl.course_cert_cost,BaseTbl.course_onetime_adm_fees,BaseTbl.course_kit_cost,BaseTbl.course_cgst_tax_value,BaseTbl.course_sgst_tax_value,BaseTbl.course_total_fees,Type.ct_id as course_type_id');
        $this->db->from('tbl_course as BaseTbl');
        $this->db->join('tbl_course_type as Type', 'Type.ct_id = BaseTbl.course_type_id','left');
       
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.courseId', 'desc');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;      
    }

    /*get All Course List*/
    public function getCourseTypedata($data){
        $this->db->select('BaseTbl.ct_id , BaseTbl.ct_name');
        $this->db->from('tbl_course_type as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.ct_id', 'desc');
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;      
    }

    /*get All Invoice List*/
    public function getTaxinvoiceData(){

        
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
                 $data[$counter]['invoice_url'] = base_url()."tax_invoice/index.php?enq_id=".$value['enq_id']."&paymentid=".$value['paymentid'];
                 //$data[$counter]['action'] = '';
                 //$data[$counter]['action'] .= "<a style='cursor: pointer;'  href='tax_invoice/index.php?enq_id=".$value['enq_id']."&paymentid=".$value['paymentid']."' target='_blank'  class='print_tax_invoices' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/print.png alt='Print Invoice' title='Print Invoice'></a> "; 
                $counter++; 
            }
        }
        return $data;
    }

    /*Get Admission List */
    public function getAdmissionsdata($data){

        $this->db->select('*');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
    
        $this->db->where(TBL_ADMISSION.'.isDeleted', 0);
        $this->db->order_by(TBL_ADMISSION.'.enq_id', 'DESC');
        $query = $this->db->get(TBL_ADMISSION);
        $fetch_result = $query->result_array();
        
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {

                $getCourseList = $this->getSelectedCourse($value['enq_id']);

                if($getCourseList){

                if($getCourseList[0]->enq_course_id){

                    $course_ids    =   explode(',', $getCourseList[0]->enq_course_id);
                    $total_fees = 0;
                    $course_name = '';
                    $i = 1;
                    foreach($course_ids as $id)
                    {
                        $get_course_fees =  $this->getCourseInfo($id);
                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees[0]->course_total_fees;
                            $course_name .= $i.') '.$get_course_fees[0]->course_name.'\n ';  
                            $i++;   
                    
                        }else{
                    
                            $total_fees = '';
                            $course_name = '';  
                            $i++;  
                        }
                        
                    }
                    $all_course_name = trim($course_name, ', '); 

                }else{

                    $all_course_name = ''; 

                }
            }else{
                $all_course_name = ''; 
            }

    
               
            //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
                 $data[$counter]['enq_id'] = $value['enq_id'];
                 $data[$counter]['mobile'] = $value['mobile'];
                 $data[$counter]['createdDtm'] = $value['createdDtm'];
                 $data[$counter]['name'] = $value['name'];
                 $data[$counter]['email'] = $value['email'];
                // $data[$counter]['address'] = $value['address'];
                 $data[$counter]['courses'] = $all_course_name;
                
                 if($value['cancle_status']==1){
                   $data[$counter]['admission_status'] = 'Cancelled';
                 }else{
                    $data[$counter]['admission_status'] = 'Admitted';
                 }

                $counter++; 
            }
        }
        return $data;
    }

    /*Get Examination List*/
    public function getExaminationdata($data){
        $this->db->select('*');
        $this->db->from('tbl_examination as BaseTbl');
        $this->db->join('tbl_course as course', 'course.courseId = BaseTbl.course_id');
    
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.id', 'DESC');
        $query = $this->db->get();

        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 if($value['exam_status']==1){
                    $exam_status ='Active';
                 }else{
                    $exam_status ='In-Active';
                 }

                 $data[$counter]['course_name'] = $value['course_name'];
                 $data[$counter]['exam_title'] = $value['exam_title'];
                 $data[$counter]['exam_time'] = $value['exam_time'];
                 $data[$counter]['total_marks'] = $value['total_marks'];
                 $data[$counter]['exam_status'] = $exam_status;
                 $counter++; 
            }
        }

        return $data;

    }


    /*Get Attendance List*/
    public function getattendancedata($data){
       
        $this->db->select('*');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ATTENDANCE.'.course_id');
        $this->db->join(TBL_USER, TBL_USER.'.userId  = '.TBL_ATTENDANCE.'.user_id');
        $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_ATTENDANCE.'.topic_id');
        // $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.id = '.TBL_ATTENDANCE.'.meeting_id');       
        $this->db->order_by(TBL_TIMETABLE_TRANSECTIONS.'.id', 'DESC');

        $query = $this->db->get(TBL_ATTENDANCE);
        $fetch_result = $query->result_array();

        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
                 $data[$counter]['name'] = $value['name'];
                 $data[$counter]['mobile_number'] = $value['mobile'];
                 $data[$counter]['email_address'] = $value['email'];
                 $data[$counter]['course_name'] = $value['course_name'];
                 $data[$counter]['topic'] = $value['topic'];
                 $data[$counter]['class_date'] =  date('d-m-Y', strtotime($value['date']));
                 //$data[$counter]['enq_date'] = date('d-m-Y', strtotime($value['enq_date']));
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


    /*Get All Certificate List*/
    public function getCertificatedata($params)
    {

        $this->db->select('*');
        $this->db->join(TBL_COURSE, TBL_STUDENT_ANSWER_SHEET.'.course_id = '.TBL_COURSE.'.courseId');
        $this->db->join(TBL_EXAMINATION, TBL_STUDENT_ANSWER_SHEET.'.exam_id = '.TBL_EXAMINATION.'.id');
        $this->db->join(TBL_USER, TBL_STUDENT_ANSWER_SHEET.'.student_id = '.TBL_USER.'.userId');
        $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.question_status', 'checked');
        $this->db->order_by(TBL_STUDENT_ANSWER_SHEET.'.ans_id', 'DESC');
        $this->db->group_by(TBL_STUDENT_ANSWER_SHEET.'.student_id');
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
                $data[$counter]['course_name'] = '';
                
                if($Quntitave_value=='Fail'){

                    $data[$counter]['action'] .= 'Fail';
                }else{

                    $data[$counter]['marksheet_pdf'] = base_url()."marksheet/index.php?student_id=".$value['student_id'];
                    $data[$counter]['certificate_pdf'] = base_url()."certificate/index.php?student_id=".$value['student_id'];

                    //$data[$counter]['marksheet_pdf'] .= "<a style='cursor: pointer;'  href='marksheet/index.php?student_id=".$value['student_id']."' target='_blank'  class='print_certificate' data-id='".$value['student_id']."'><img width='20' src=".ICONPATH."/marksheet.png alt='Student Marksheet' title='Student Marksheet'></a> "; 
                    //$data[$counter]['certificate_pdf'] .= "| <a style='cursor: pointer;'  href='certificate/index.php?student_id=".$value['student_id']."' target='_blank'  class='print_certificate' data-id='".$value['student_id']."'><img width='20' src=".ICONPATH."/print.png alt='Print Certificate' title='Print Certificate'></a> "; 
                }
                $counter++; 
            }
        }

        return $data;
    }

    /*Get All Student Portal List */
    public function getStudentportaldata($params)
    {
        $this->db->select('*');
        $this->db->join(TBL_ROLES, TBL_ROLES.'.roleId = '.TBL_USER.'.roleId','left');
      
        $this->db->where(TBL_USER.'.isDeleted', 0);
        $this->db->where(TBL_USER.'.user_flag', 'student');
        $this->db->order_by(TBL_USER.'.userId', 'DESC');
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
                $data[$counter]['book_issued']   =  rtrim($course_name,'\n'); ;
                $counter++; 
            }
        }
        return $data;
    }
  

     /*Get All Certificate List*/
     public function getDashbaorddata($params)
     {

        $year  = (empty($year) || !is_numeric($year))?  date('Y') :  $year;
		$month = (is_numeric($month) &&  $month > 0 && $month < 13)? $month : date('m');
		$day   = (is_numeric($day) &&  $day > 0 && $day < 31)?  $day : date('d');
		
		$date      = $this->event->getDateEvent($year, $month);
		$cur_event = $this->event->getEvent($year, $month, $day);
	
        $data_response['calenderclasslist'] = $datacalenderclasslist;


        $dataCount['users'] = $this->user_model->userListingCount();
        $dataCount['courses'] = $this->course_model->courseListingCount();
        $dataCount['enquries'] = $this->enquiry_model->enquiryListingCount();
        $dataCount['students'] = $this->student_model->totalstudentCount();
        $dataCount['admissions'] = $this->admission_model->admissionListingCount();
        $dataCount['total_invoices'] = $this->getTaxinvoicesCount();
        $data_response['dashbaordcount'] = $dataCount;

        if($this->admission_model->total_revenue()[0]['total_revenue']!=null){
            $dataMaincourse['total_revenue'] = intval($this->admission_model->total_revenue()[0]['total_revenue']);
        }else{
            $dataMaincourse['total_revenue'] = 0;
        }

        if($this->admission_model->total_pending()[0]['total_pending']!=null){
            $dataMaincourse['total_pending'] =  intval($this->admission_model->total_pending()[0]['total_pending']);
        }else{
            $dataMaincourse['total_pending'] = 0;
        }

        $dataMaincourse['total_pending_amt'] = $dataMaincourse['total_pending'] - $dataMaincourse['total_revenue'];
        //$dataMaincourse['total_pending_amt'] = 20;



        
        $data_response['dashbaordtotalMaincourese'] = $dataMaincourse;

        if($this->admission_model->total_revenue_add_on()[0]['total_revenue']!=null){
            $dataAddoncourse['total_revenue_add_on'] = $this->admission_model->total_revenue_add_on()[0]['total_revenue'];
        }else{
            $dataAddoncourse['total_revenue_add_on'] = 0;
        }
       
        if($this->admission_model->total_discount_add_on()[0]['total_discount']!=null){
            $dataAddoncourse['total_discount'] = $this->admission_model->total_discount_add_on()[0]['total_discount'];
        }else{
            $dataAddoncourse['total_discount'] = 0;
        }
       
        if($this->admission_model->total_pending_add_on()[0]['total_pending']!=null){
            $total_pending_Add_on_single = $this->admission_model->total_pending_add_on()[0]['total_pending'];
        }else{
            $total_pending_Add_on_single = 0;
        }


        $dataAddoncourse['total_course_fees'] =  $total_pending_Add_on_single - $dataAddoncourse['total_discount'];
        $dataAddoncourse['total_pending_amt_add_on'] = $dataAddoncourse['total_course_fees'] - $dataAddoncourse['total_revenue_add_on'];
        $data_response['dashbaordtotaladdoncourese'] = $dataAddoncourse;
        return $data_response;

     }


     /*Get All Staff Details List */
    public function getStaffuserdetails($params)
    {
        $this->db->select('*');
        $this->db->join(TBL_ROLES, TBL_ROLES.'.roleId = '.TBL_USER.'.roleId','left');
        $this->db->where(TBL_USER.'.isDeleted', 0);
        $this->db->where(TBL_USER.'.user_flag', 'user');
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
                 $data[$counter]['email']   = $value['email'];
                 $data[$counter]['username']  = $value['username'];
                 $data[$counter]['mobile']  = $value['mobile'];
                 $data[$counter]['role']    = $value['role'];
                 $data[$counter]['password']    = base64_decode($value['password']);
                 $data[$counter]['roleId']    = $value['roleId'];
                 $data[$counter]['userId']    = $value['userId'];
                 if($value['profile_pic']){
                    $data[$counter]['profile_pic']    = 'https://iictn.in/uploads/profile_pic/'.$value['profile_pic'];
                 }else{
                    $data[$counter]['profile_pic']    = '';
                 }
                
                 $counter++; 
            }
        }
        return $data;
    }
  

     /*Get All Staff Details List */
     public function getclassrequestdetails($params)
     {

         //$this->db->select('*');
         $this->db->select('*,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topicid,'.TBL_TIMETABLE_TRANSECTIONS.'.timings as classtime,'.TBL_TIMETABLE_TRANSECTIONS.'.date as classdate,'.TBL_NEW_COURSE_REQUEST.'.id as request_id,'.TBL_NEW_COURSE_REQUEST.'.time_table_id,'.TBL_NEW_COURSE_REQUEST.'.student_id as stuid');
         $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_NEW_COURSE_REQUEST.'.time_table_id');
         $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_TIMETABLE_TRANSECTIONS.'.course_id');
         $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id');

        // $this->db->join(TBL_NEW_COURSE_REQUEST, TBL_NEW_COURSE_REQUEST.'.time_table_id = '.TBL_TIMETABLE_TRANSECTIONS.'.id');
    
        $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_NEW_COURSE_REQUEST.'.student_id');
        // $this->db->where(TBL_COURSE.'.isDeleted', 0);
        $this->db->where(TBL_NEW_COURSE_REQUEST.'.request_sent_status=',1);        
        // $this->db->where(TBL_COURSE.'.courseId', $value);
        $this->db->order_by(TBL_NEW_COURSE_REQUEST.'.id', 'DESC');
        $query = $this->db->get(TBL_NEW_COURSE_REQUEST);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                    $checkattendance = $this->checkifAttendanceisexits($userId,$value['courseId'],$value['topicid']);
                    if($checkattendance){
                        $attendance_alreday_exits = 'Attended' ;
                    }else{
                        $attendance_alreday_exits = 'Not Attended' ;
                    }
                    $data[$counter]['time_table_id'] = $value['time_table_id'];
                    $data[$counter]['student_id'] = $value['stuid'];
                    $data[$counter]['name'] = $value['name'];
                    $data[$counter]['mobile'] = $value['mobile'];
                    $data[$counter]['title'] = $value['topic'];
                    $data[$counter]['course_name'] = $value['course_name'];
                    $data[$counter]['classdate'] = $value['classdate'];
                    $data[$counter]['classtime'] = $value['classtime'];
                    $data[$counter]['request_id'] =  $value['request_id'];
                    $data[$counter]['attendance_alreday_exits'] =  $attendance_alreday_exits;

                
                        if($value['admin_approval_status']){
                            $request_status = $value['admin_approval_status'];
                        }else{
                            $request_status ='In Approval Process ..please wait';
                        }
                   
                   
                    $data[$counter]['request_status'] =  $request_status;
                    
                 $counter++; 
            }
    //     }

    //      }

   
        }
 
        return $data;

     }



    /*=========================================================================================================================*/
    /* Sub Query Add On List*/
    public function getCourseInfo($id){
        $this->db->select('courseId,course_total_fees,course_name');
        $this->db->from('tbl_course');
        $this->db->where('tbl_course.isDeleted', 0);
        //$this->db->where('tbl_enquiry.payment_status', 1);
        $this->db->where('tbl_course.courseId', $id);
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

    public function get_final_amount_of_add_on_course($enq_id,$add_on_course_id){

        $this->db->select(TBL_ADD_ON_COURSE.'.id as addoncourse_id,'.TBL_ADD_ON_COURSE.'.createdDtm as addoncoursedatetime,'.TBL_COURSE.'.course_name,'.TBL_COURSE.'.course_total_fees,'.TBL_ADD_ON_COURSE.'.discount');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ADD_ON_COURSE.'.course_id');
        $this->db->where(TBL_ADD_ON_COURSE.'.enquiry_id', $enq_id);
        $this->db->where(TBL_ADD_ON_COURSE.'.id', $add_on_course_id);
        $query = $this->db->get(TBL_ADD_ON_COURSE);
        return $query->row_array();

    }


    public function getSelectedCourse($enq_id){

        $this->db->select('enq_course_id');
        $this->db->from(TBL_ENQUIRY);
        $this->db->where('enq_id', $enq_id);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->result();

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

    public function getCoursenamebyid($course_id){

        $this->db->select('course_name');
        $this->db->where(TBL_COURSE.'.courseId', $course_id);
        $this->db->where(TBL_COURSE.'.isDeleted', 0);
        $query = $this->db->get(TBL_COURSE);
        $fetch_result = $query->result_array();
        return $fetch_result;
    
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


    public function getCourseList()
    {
        $this->db->select('*');
        $this->db->from('tbl_course as BaseTbl');
        $this->db->join('tbl_course_type as Type', 'Type.ct_id = BaseTbl.course_type_id','left');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.courseId', 'desc');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function getCityList()
    {
        $this->db->select('*');
        $this->db->order_by('name','ASC');
        $query_result = $this->db->get(TBL_CITIES)->result_array();
        return $query_result;
    }


    
    public function getCounsellerList()
    {
        // $this->db->select('*');
        // $this->db->join('tbl_roles as Type', 'tbl_users.userId = tbl_roles.roleId');
        // $this->db->where('tbl_users.isDeleted', 0);
        // $this->db->where('tbl_roles.role','Counsellor');
        // $this->db->order_by('tbl_users.name','ASC');
        // $query_result = $this->db->get('tbl_users')->result_array();
        // return $query_result;

        $this->db->select('BaseTbl.userId,BaseTbl.name');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('Role.role', 'Counsellor');
        $this->db->order_by('BaseTbl.name','ASC');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result_array();        
        return $result;
    }



    /*Trainer Data Start Here*/
    public function getAttendanceCountTrainer($userid,$user_flag)
    {
            $this->db->select('*');
            $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ATTENDANCE.'.course_id');
            $this->db->join(TBL_USER, TBL_USER.'.userId  = '.TBL_ATTENDANCE.'.user_id');
            $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_ATTENDANCE.'.topic_id');
            $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.trainer_id', $userId);
            $this->db->order_by(TBL_TIMETABLE_TRANSECTIONS.'.id', 'DESC');
            $query = $this->db->get(TBL_ATTENDANCE);
            $fetch_result = $query->num_rows();
            return $fetch_result;
    }


    public function getCoursesCountTrainer($userid,$user_flag)
       {
            $this->db->select('*');
            $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
            $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.course_id = '.TBL_COURSE.'.courseId');
            $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.trainer_id', $userid);
            $this->db->group_by(TBL_TIMETABLE_TRANSECTIONS.'.course_id');
            $this->db->where(TBL_COURSE.'.isDeleted', 0);
            $query = $this->db->get(TBL_COURSE);
            $rowcount = $query->num_rows();
            return $rowcount;

       }



    public function getexaminationCountTrainer($userid,$user_flag)
       {
           $this->db->select('*');
           $this->db->from('tbl_examination as BaseTbl');
           $this->db->join('tbl_course as course', 'course.courseId = BaseTbl.course_id');
           $this->db->join('tbl_timetable_transection', 'tbl_timetable_transection.course_id = course.courseId');
           $this->db->join('tbl_users', 'tbl_users.userId = tbl_timetable_transection.trainer_id');
           $this->db->where('tbl_timetable_transection.trainer_id', $userId);
           $this->db->where('BaseTbl.isDeleted', 0);
           $this->db->where('BaseTbl.exam_status', 1);
           $this->db->order_by('BaseTbl.id', 'desc');
           $query = $this->db->get();
           return $query->num_rows();
       }



       public function  getallstudentquerycount($userId,$user_flag){

            $getTrainercourseis = $this->gettrainercourseIds($userId);
            $course_id =array();
            foreach ($getTrainercourseis as $key => $value) {
                $course_id[]= $value['course_id'];
                 
            }
    
            if( $getTrainercourseis){
                $this->db->where_in(TBL_COURSE.'.courseId', $course_id);
    
            }else{
                return 0;
    
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
    
    
    public function getallstudentquerydata($userId,$user_flag){
    
    
            $getTrainercourseis = $this->gettrainercourseIds($userId);
            $course_id =array();
            foreach ($getTrainercourseis as $key => $value) {
                $course_id[]= $value['course_id'];
                 
            }
    
            if( $getTrainercourseis){
                $this->db->where_in(TBL_COURSE.'.courseId', $course_id);
    
            }else{
                return true;
    
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
                 $data[$counter]['queryid'] = $value['queryid'];
                 $data[$counter]['course_name'] = $value['course_name'];
                 $data[$counter]['topic_name'] = $value['topic'];
                 $data[$counter]['query'] = $value['query'];          
                $counter++; 
            }
        }
    
        return $data;
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


    public function getEnquiryInfo($enqId)
    {

        $this->db->select('enq_id as id,enq_fullname,enq_mobile,enq_email,enq_source,tbl_enquiry.createdDtm as enquiry_date,doctor_non_doctor');
        $this->db->join('tbl_course', 'tbl_course.courseId = tbl_enquiry.enq_course_id');
        $this->db->join('tbl_course_type', 'tbl_course.course_type_id = tbl_course_type.ct_id');
        $this->db->from('tbl_enquiry');
        // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('tbl_enquiry.enq_id', $enqId);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function getEnquirypaymentInfo($id){

        $this->db->select('payment_date,razorpay_payment_id as transection_id,totalAmount as amount,payment_mode,payment_status');
        $this->db->from('tbl_payment_transaction');
        //$this->db->where('tbl_enquiry.isDeleted', 0);
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
        $totalpaidAmount =$query->row_array();
       
        $this->db->select('sum(total_payment) as total_course_fees');
        $this->db->join('tbl_course', 'tbl_course.courseId = tbl_enquiry.enq_course_id');
        $this->db->join('tbl_course_type', 'tbl_course.course_type_id = tbl_course_type.ct_id');
        $this->db->from('tbl_enquiry');
        // $this->db->where('tbl_enquiry.isDeleted', 0);
        $this->db->where('tbl_enquiry.enq_id', $id);
        $query1 = $this->db->get();
        $total_course_fees =$query1->row_array();

        $payment_details = array();

        $payment_details['total_course_fees'] =$total_course_fees['total_course_fees'];
        $payment_details['totalpaidAmount'] =$totalpaidAmount['totalpaidAmount'];
        $payment_details['total_discount'] =$total_course_fees['discount_amount'];
        $payment_details['totalpending'] = $total_course_fees['total_course_fees'] - $totalpaidAmount['totalpaidAmount'];
        return $payment_details;
        
    }


    public function getadditionalInfo($id){
        $this->db->select(TBL_ADD_ON_COURSE.'.id as addoncourse_id,'.TBL_ADD_ON_COURSE.'.createdDtm as addoncoursedatetime,'.TBL_COURSE.'.course_name,'.TBL_COURSE.'.course_total_fees,'.TBL_ADD_ON_COURSE.'.discount,'.TBL_ADD_ON_COURSE.'.enquiry_id');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ADD_ON_COURSE.'.course_id');
        $this->db->where(TBL_ADD_ON_COURSE.'.enquiry_id', $id);
        $query = $this->db->get(TBL_ADD_ON_COURSE);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['addoncourse_id'] = $value['addoncourse_id'];
                 $data[$counter]['addoncoursedatetime'] = $value['addoncoursedatetime'];
                 $data[$counter]['course_name'] = $value['course_name'];   
                 $data[$counter]['course_total_fees'] = $value['course_total_fees']; 
                 $data[$counter]['discount'] = $value['discount']; 
                 $data[$counter]['final_amount'] = $value['course_total_fees']-$value['discount']; 
                 $data[$counter]['enquiry_id'] = $value['enquiry_id']; 
                 
                $counter++; 
            }
        }
    
        return $data;

    }


    public function getcertificatetypelist(){

        $this->db->select('ct_id,ct_name');
        $this->db->where(TBL_COURSE_TYPE.'.ct_status',0);
        $query = $this->db->get(TBL_COURSE_TYPE);
        return $query->result_array();

    }


    public function viewtraineranswerthequery($userid,$user_flag,$query_id){
        $this->db->select('*');
        $this->db->where(TBL_ASK_A_QUERY_ANSWER.'.query_id', $query_id);
        //$this->db->where(TBL_ASK_A_QUERY_ANSWER.'.student_id', $userId);
        $this->db->order_by(TBL_ASK_A_QUERY_ANSWER.'.id', 'DESC');
        $query = $this->db->get(TBL_ASK_A_QUERY_ANSWER);
        $fetch_result = $query->result_array();
    
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['query_id'] = $value['query_id'];
                 $data[$counter]['student_id'] = $value['student_id'];
                 $data[$counter]['query_answer'] = $value['query_answer'];
                 $counter++; 
            }
        }
        return $data;
    }



    public function gettimetableList($userid,$user_flag,$course_id){
            
            $this->db->select('*');
            $this->db->where(TBL_TIMETABLE.'.course_id', $course_id);
            $this->db->where(TBL_TIMETABLE.'.isDeleted', 0);
            $this->db->order_by(TBL_TIMETABLE.'.id', 'DESC');
            $query = $this->db->get(TBL_TIMETABLE);
            $fetch_result = $query->result_array();
            $data = array();
            $counter = 0;
            if(count($fetch_result) > 0)
            {
                foreach ($fetch_result as $key => $value)
                {
                     $data[$counter]['timetableid'] =$value['id'];
                     $data[$counter]['month_name'] = $value['month_name'];   
                     $data[$counter]['from_date'] = date('d-m-Y', strtotime($value['from_date']));
                     $data[$counter]['to_date'] = date('d-m-Y', strtotime($value['to_date']));
                    
                     $counter++; 
                }
            }
        
            return $data;
        
    }


    public function gettimetabledetailslist($timetable_id,$user_flag,$userid){


        $this->db->select('*,b.name as backuptrainer,tbl_users.name as trainername');
        $this->db->join('tbl_users', 'tbl_users.userId = '.TBL_TIMETABLE_TRANSECTIONS.'.trainer_id');
        $this->db->join('tbl_users b', 'b.userId = '.TBL_TIMETABLE_TRANSECTIONS.'.backup_trainer','left');
        $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.time_table_id', $timetable_id);
        $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.isDeleted', 0);
        $this->db->order_by(TBL_TIMETABLE_TRANSECTIONS.'.id', 'DESC');
        $query = $this->db->get(TBL_TIMETABLE_TRANSECTIONS);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['id'] =$value['id'];
                 $data[$counter]['topic'] = $value['topic'];   
                 $data[$counter]['from_date'] = date('d-m-Y', strtotime($value['from_date']));
                 $data[$counter]['to_date'] = date('d-m-Y', strtotime($value['to_date']));
                 $data[$counter]['class_date'] = date('d-m-Y', strtotime($value['date']));
                 $data[$counter]['timings'] = $value['timings'];
                 $data[$counter]['trainer'] = $value['trainername'];
                 if($value['backuptrainer']){
                    $data[$counter]['backuptrainer'] = $value['backuptrainer'];
                 }else{
                    $data[$counter]['backuptrainer'] ='';
                 }
               

                 $counter++; 
            }
        }
    
        return $data;


    }


    public function getchapterslist($course_id,$user_flag,$userid){

        $this->db->select('*');
        $this->db->where(TBL_COURSE_TOPICS.'.course_id', $course_id);
        $this->db->where(TBL_COURSE_TOPICS.'.isDeleted', 0);
        $this->db->order_by(TBL_COURSE_TOPICS.'.id', 'DESC');
        $query = $this->db->get(TBL_COURSE_TOPICS);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['chapter_id'] =$value['id'];
                 $data[$counter]['course_id'] =$value['course_id'];
                 $data[$counter]['topic_name'] = $value['topic_name'];
                 $counter++; 
            }
        }
    
        return $data;

    }

    public function getchaptersdocumentlist($course_id,$user_flag,$userid,$topic_id,$doc_type){

        $this->db->select('*');
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.course_id', $course_id);
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.topic_id', $topic_id);
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.module_name', $doc_type);
        $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.isDeleted', 0);
        $this->db->order_by(TBL_COURSE_TOPICS_DOCUMENT.'.id', 'DESC');
        $query = $this->db->get(TBL_COURSE_TOPICS_DOCUMENT);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['doc_id'] =$value['id'];
                 $data[$counter]['course_id'] =$value['course_id'];
                 $data[$counter]['topic_id'] = $value['topic_id'];
                 $data[$counter]['doc_type'] = $value['doc_type'];
                 $data[$counter]['module_name'] = $value['module_name'];
                 $data[$counter]['file_name_original'] = $value['file_name_original'];
                 $data[$counter]['file_url'] = $value['file_url'];
                 $counter++; 
            }
        }
    
        return $data;

    }


    public function getallstudentlist($user_flag,$userid){

        $this->db->select('*');
        //$this->db->where(TBL_COURSE_TOPICS.'.course_id', $courseid);
        $this->db->where(TBL_USER.'.user_flag', 'student');
        $this->db->order_by(TBL_USER.'.userId', 'DESC');
        $query = $this->db->get(TBL_USER);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['userId'] =$value['userId'];
                 $data[$counter]['name'] =$value['name'].'-'.$value['mobile'];
                 $data[$counter]['user_flag'] = $value['user_flag'];
                 $data[$counter]['report_url'] = ADMIN_PATH.'report/student_report.php?studentid='.$value['userId'];
                 $counter++; 
            }
        }
    
        return $data;
    }


    public function studentexamrequest($user_flag,$userid){

        $this->db->select('*');
        $this->db->from(TBL_STUDENT_REQUEST);
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_STUDENT_REQUEST.'.course_id');
        $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_STUDENT_REQUEST.'.student_id');
        $this->db->where(TBL_STUDENT_REQUEST.'.status', 1);
        $this->db->where(TBL_USER.'.user_flag', 'student');
        $this->db->order_by(TBL_STUDENT_REQUEST.'.id', 'DESC');
        $query = $this->db->get();

        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['student_name'] = $value['name'];
                 $data[$counter]['course_name'] = $value['course_name'];

                 if($value['permission']==1){
                    $data[$counter]['permission'] = 1;
                 }else{
                    $data[$counter]['permission'] = 0;
                 }
               
                $counter++; 
            }
        }
        return $data;
    }


      /*Get All Certificate List*/
      public function getalltotalrevunedetailscounsellor($userid,$user_flag)
      {


        $dataMaincourse['total_revenue'] = 0;
        $dataMaincourse['total_pending'] = 0;
        $dataMaincourse['total_pending_amt'] = 0;
        $data_response['dashbaordtotalMaincourese'] = $dataMaincourse;
        

        //  $dataMaincourse['total_revenue'] = $this->admission_model->total_revenue()[0]['total_revenue'];
        //  $dataMaincourse['total_pending'] = $this->admission_model->total_pending()[0]['total_pending'];
        //  $dataMaincourse['total_pending_amt'] = $dataMaincourse['total_pending'] - $dataMaincourse['total_revenue'];
        //  $data_response['dashbaordtotalMaincourese'] = $dataMaincourse;
 
         $dataAddoncourse['total_revenue_add_on'] = $this->admission_model->total_revenue_add_on()[0]['total_revenue'];
         $dataAddoncourse['total_discount'] = $this->admission_model->total_discount_add_on()[0]['total_discount'];
         $total_pending_Add_on_single = $this->admission_model->total_pending_add_on()[0]['total_pending'];
         $dataAddoncourse['total_course_fees'] =  $total_pending_Add_on_single - $dataAddoncourse['total_discount'];
         $dataAddoncourse['total_pending_amt_add_on'] = $dataAddoncourse['total_course_fees'] - $dataAddoncourse['total_revenue_add_on'];
         $data_response['dashbaordtotaladdoncourese'] = $dataAddoncourse;
         return $data_response;
 
      }


      public function getsyllabuslist($course_id,$user_flag,$userid)
      {
        $this->db->select('*');
        $this->db->where(TBL_COURSE_SYLLABUS.'.course_id', $course_id);
        $this->db->where(TBL_COURSE_SYLLABUS.'.isDeleted', 0);
    
        $this->db->order_by(TBL_COURSE_SYLLABUS.'.id', 'DESC');
        $query = $this->db->get(TBL_COURSE_SYLLABUS);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['course_id'] = $value['course_id'];
                 $data[$counter]['doc_name'] = $value['doc_name'];
                 $data[$counter]['doc_url'] = $value['doc_url'];
                 $counter++; 
            }
        }
    
        return $data;

      }



      public function getexamcheckingdata($userId,$user_flag)
      {
  
       
          $this->db->select('*');
          $this->db->join(TBL_COURSE, TBL_STUDENT_ANSWER_SHEET.'.course_id = '.TBL_COURSE.'.courseId');
          $this->db->join(TBL_EXAMINATION, TBL_STUDENT_ANSWER_SHEET.'.exam_id = '.TBL_EXAMINATION.'.id');
          $this->db->join(TBL_USER, TBL_STUDENT_ANSWER_SHEET.'.student_id = '.TBL_USER.'.userId');
    
          $this->db->order_by(TBL_STUDENT_ANSWER_SHEET.'.ans_id', 'DESC');
          $this->db->group_by(TBL_STUDENT_ANSWER_SHEET.'.student_id');
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
  
                          }else if($total_marks >= 70 && $total_marks <= 79){
  
                              $grade ='B+';
                              $Grade_point='8';
                              $Remark ='Pass';
                              $Quntitave_value='Very Good';
  
                          }else if($total_marks >= 60 && $total_marks <= 69){
  
                              $grade ='B';
                              $Grade_point='7';
                              $Remark ='Pass';
                              $Quntitave_value='Good';
  
                          }else if($total_marks >= 50 && $total_marks <= 59){
  
                              $grade ='C';
                              $Grade_point='6';
                              $Remark ='Pass';
                              $Quntitave_value='Above Average';
  
                          }else if($total_marks >= 40 && $total_marks <= 49){
  
                              $grade ='D';
                              $Grade_point='5';
                              $Remark ='Pass';
                              $Quntitave_value='Average';
  
                          }else if($total_marks >= 40 && $total_marks <= 44){
  
                              $grade ='D';
                              $Grade_point='4';
                              $Remark ='Pass';
                              $Quntitave_value='Poor';
  
                          } else if($total_marks <= 40){
  
                              $grade ='D';
                              $Grade_point='0';
                              $Remark ='Fail';
                              $Quntitave_value='Fail';
  
                          }
  
                  }else{
                      $total_marks='NA';
                      $ans_sheet_status ='Checking Pending';
                      $grade ='NA';
                      $Grade_point='NA';
                      $Remark ='NA';
                      $Quntitave_value='NA';
                  }
  
  
                   if($ans_sheet_status!='Checked'){
  
                      $data[$counter]['name'] = $value['name'].' '.$value['lastname'];
                      $data[$counter]['mobile'] = $value['mobile'];
                      $data[$counter]['course_name'] = $value['course_name'];
                      $data[$counter]['exam_status'] = $exam_status;
                      $data[$counter]['ans_sheet_status'] = $ans_sheet_status;
                      $data[$counter]['course_id'] = $value['courseId'];
                      $data[$counter]['exam_id'] = $value['id'];
                      $data[$counter]['student_id'] = $value['userId'];

                    //   $data[$counter]['redirecturl'] = '';
                      
                    //   if($ans_sheet_status=='Checked'){
                    //   }else{
                    //      $data[$counter]['redirecturl'] .= "<a href='".ADMIN_PATH."addmarkstoexam?course_id=".$value['courseId']."&&exam_id=".$value['id']."&&student_id=".$value['userId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/view_doc.png' alt='View/Check Student Answer Paper' title='View/Check Student Answer Paper'></a>";
                    //   }
                   }
  
                   
                   $counter++; 
              }
          }
  
          return $data;
          
      }



      public function getstudentqueryforttopicwisetriner($userId,$roleText){
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


    public function studentaskaquerylist($user_flag,$userId){

        $this->db->select('*,'.TBL_ASK_A_QUERY.'.id as queryid');
        $this->db->join(TBL_COURSE, TBL_ASK_A_QUERY.'.course_id = '.TBL_COURSE.'.courseId');
        $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_ASK_A_QUERY.'.certificate_topic');
        $this->db->where(TBL_ASK_A_QUERY.'.student_id', $userId);

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
                $data[$counter]['topic_name'] = $value['topic'];
                $data[$counter]['query'] = $value['query'];
                $data[$counter]['queryid'] = $value['queryid'];
                $counter++; 
            }
        }

        return $data;
    }



    public function getquerydatabyid($user_flag,$userId,$query_id){

    $this->db->select('*');
   
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
             $counter++; 
        }
    }
    return $data;
    }



    public function studentcourseRequestData($user_flag,$userId){
        // $access = $this->session->userdata('access');
        // $jsonstringtoArray = json_decode($access, true);
        // $pageUrl =$this->uri->segment(1);
       
        $current_date = date('Y-m-d');
       
        $this->db->select('enq_course_id,user_id');
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_id = '.TBL_USERS_ENQUIRES.'.enq_id');
        $this->db->where(TBL_USERS_ENQUIRES.'.user_id',$userId);
        $get_enquiry_courses = $this->db->get(TBL_ENQUIRY);
        $fetch_result_enquiry_courses = $get_enquiry_courses->result_array();

        $data = array();
        $counter = 0;
         foreach ($fetch_result_enquiry_courses as $key => $value2) {

         $course_ids    =   explode(',', $value2['enq_course_id']);

         foreach ($course_ids as $key => $value) {
           
        $this->db->select('*,'.TBL_TOPIC_MEETING_LINK.'.id as meeting_id,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topicid,'.TBL_TIMETABLE_TRANSECTIONS.'.timings as classtime,'.TBL_TIMETABLE_TRANSECTIONS.'.date as classdate,'.TBL_TIMETABLE_TRANSECTIONS.'.time_table_id as tt_id');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_TIMETABLE_TRANSECTIONS.'.course_id');
        $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id');

      
        $this->db->join(TBL_TIMETABLE, TBL_TIMETABLE_TRANSECTIONS.'.time_table_id = '.TBL_TIMETABLE.'.id');

        $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.time_table_transection_id = '.TBL_TIMETABLE_TRANSECTIONS.'.id','left');
    
        $this->db->where(TBL_COURSE.'.isDeleted', 0);
       // $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.date =', $current_date);
        // $this->db->where(TBL_COURSE.'.courseId IN (SELECT  enq_course_id from  tbl_enquiry join tbl_users_enquires on tbl_enquiry.enq_number=tbl_users_enquires.enq_id where tbl_users_enquires.user_id='.$userId.')');
        $this->db->where(TBL_COURSE.'.courseId', $value);
        $this->db->order_by(TBL_TIMETABLE_TRANSECTIONS.'.id', 'DESC');
        $query = $this->db->get(TBL_TIMETABLE_TRANSECTIONS);
        $fetch_result = $query->result_array();
       
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                    $checkattendance = $this->checkifAttendanceisexits($userId,$value['courseId'],$value['topicid']);
                    if($checkattendance){
                        $attendance_alreday_exits = 'Attended' ;
                    }else{
                        $attendance_alreday_exits = 'Not Attended' ;
                    }
                    // $data[$counter]['courseId'] = $value['courseId'];
                    $data[$counter]['title'] = $value['topic'];
                    $data[$counter]['course_name'] = $value['course_name'];
                    $data[$counter]['classdate'] = $value['classdate'];
                    $data[$counter]['classtime'] = $value['classtime'];
                    $data[$counter]['attendance_alreday_exits'] =  $attendance_alreday_exits;

                    $data[$counter]['time_table_id'] = $value['tt_id'];
                    $data[$counter]['student_id'] =  $value2['user_id'];


                    $checkAprrovalstatus = $this->checkAprrovalstatus($userId,$value['topicid']);
                  
                    if($checkAprrovalstatus){

                        if($checkAprrovalstatus['admin_approval_status'] > 0){
                            $request_status ='Approved';
                        }else{
                            $request_status ='In Approval Process ..please wait';
                        }
                       
                    }else{
                        $request_status ='NA';
                    }
                   
                    $data[$counter]['request_status'] =  $request_status;
                    // $data[$counter]['action'] = '';
                    // $data[$counter]['action'] .= "<a style='cursor: pointer;' class='request_class' data-id='".$value['topicid']."'><img width='20' src=".ICONPATH."/request_new.png alt='Request New Class' title='Request New Class'></a>&nbsp"; 

                 $counter++; 
            }
        }

         }
       }
 
       return $data;

    }


    public function checkAprrovalstatus($userId,$topicid){

        $this->db->select('*');
        $this->db->where(TBL_NEW_COURSE_REQUEST.'.time_table_id', $topicid);
         $this->db->where(TBL_NEW_COURSE_REQUEST.'.student_id', $userId);
        $this->db->limit(1);
        $query = $this->db->get(TBL_NEW_COURSE_REQUEST);
        $fetch_result = $query->row_array();
        return $fetch_result;

    }

    public function getUserRolesforappcreateuser($user_flag,$userid)
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
        return $query->result();
    }


    
    public function getcourseliststudent($student_name){

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


public function getenquiryfollowuplist($enquiry_id,$user_flag,$userid){

         $this->db->select('*');
        // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_ENQUIRY.'.course_type_id','left');
        $this->db->where(TBL_ENQUIRY_FOLLOW_UP.'.enq_id', $enquiry_id);
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
                 $data[$counter]['followup_id'] = $value['id'];
                 $data[$counter]['enq_id'] = $value['enq_id'];
                 $data[$counter]['enq_number'] = $value['enquiry_number'];
                 $data[$counter]['enq_date'] = date('d-m-Y', strtotime($value['date']));
                 $data[$counter]['remark'] = $value['remark'];
             $counter++; 
            }
        }
        return $data;

}


public function getTaxinvoicesCount(){
    $this->db->select('*');
    $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id = '.TBL_PAYMENT.'.enquiry_id');
    //$this->db->where(TBL_PAYMENT.'.enq_id', $id);
    $this->db->where(TBL_PAYMENT.'.payment_status', 1);
    $query = $this->db->get(TBL_PAYMENT);
    $rowcount = $query->num_rows();
    return $rowcount;
}



public function upcoming_class_links($userId){
    

    $current_date = date('Y-m-d');
   
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
       
    $this->db->select('*,'.TBL_TOPIC_MEETING_LINK.'.id as meeting_id,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topicid,'.TBL_TIMETABLE_TRANSECTIONS.'.timings as classtime');
    $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id');

    $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.course_id = '.TBL_COURSE.'.courseId');
    $this->db->join(TBL_TIMETABLE, TBL_TIMETABLE_TRANSECTIONS.'.time_table_id = '.TBL_TIMETABLE.'.id');

    $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.time_table_transection_id = '.TBL_TIMETABLE_TRANSECTIONS.'.id','left');

    $this->db->where(TBL_COURSE.'.isDeleted', 0);
     $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.date', $current_date);
    // $this->db->where(TBL_COURSE.'.courseId IN (SELECT  enq_course_id from  tbl_enquiry join tbl_users_enquires on tbl_enquiry.enq_number=tbl_users_enquires.enq_id where tbl_users_enquires.user_id='.$userId.')');
    $this->db->where(TBL_COURSE.'.courseId', $value);

    $this->db->order_by(TBL_TIMETABLE_TRANSECTIONS.'.id', 'DESC');
    $query = $this->db->get(TBL_COURSE);
    $fetch_result = $query->result_array();
   
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {
                $checkattendance = $this->checkifAttendanceisexits($userId,$value['courseId'],$value['topicid']);

                if($checkattendance){

                    $attendance_alreday_exits = 1 ;

                }else{
                    $attendance_alreday_exits = 0 ;
                }
             
                // $data[$counter]['courseId'] = $value['courseId'];
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
                $data[$counter]['iscancle'] = $value['iscancle'];
                $data[$counter]['attendance_alreday_exits'] =  $attendance_alreday_exits;
                $data[$counter]['action'] = '';
             $counter++; 
        }
    }

     }

   
   }

   return $data;

}



        
}

?>