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
                        return array('authtoken' => $authtoken,'id' => $get_actual_user_data->userId,'name' => $get_actual_user_data->name,'email' => $get_actual_user_data->email, 'username' => $get_actual_user_data->username,'mobile_no' => $get_actual_user_data->mobile,'user_flag' =>  $get_actual_user_data->user_flag);
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

            $this->db->select(TBL_ENQUIRY.'.enq_id as enq_id,'.TBL_ADMISSION.'.enq_id as admission_status,'.TBL_ENQUIRY.'.enq_number,'.TBL_USER.'.name as counseller,'.TBL_ENQUIRY.'.enq_fullname,'.TBL_ENQUIRY.'.enq_mobile,'.TBL_ENQUIRY.'.enq_email,'.TBL_ENQUIRY.'.doctor_non_doctor,'.TBL_ENQUIRY.'.enq_course_id');
            // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
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
                
                        $get_course_fees =  $this->getCourseInfo($id);
                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees[0]->course_total_fees;
                            $course_name .= $i.'-'.$get_course_fees[0]->course_name.',';  
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

            return $data;
        }

        }catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /*get All Course List*/
    public function getCourseData($data){
        $this->db->select('BaseTbl.courseId , BaseTbl.course_name, BaseTbl.course_desc, BaseTbl.course_date,BaseTbl.createdDtm, BaseTbl.course_fees, Type.ct_name,BaseTbl.course_total_fees');
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
                 $data[$counter]['address'] = $all_course_name;
                
                 if($value['cancle_status']==1){
                   $data[$counter]['cancel'] = 'Cancelled';
                 }else{
                    $data[$counter]['cancel'] = 'Admitted';
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
        $dataCount['students'] = $this->student_model->studentListingCount();
        $dataCount['admissions'] = $this->admission_model->admissionListingCount();
        $dataCount['total_invoices'] = $this->enquiry_model->getTaxinvoicesCount(NULL);
        $data_response['dashbaordcount'] = $dataCount;

        $dataMaincourse['total_revenue'] = $this->admission_model->total_revenue()[0]['total_revenue'];
        $dataMaincourse['total_pending'] = $this->admission_model->total_pending()[0]['total_pending'];
        $dataMaincourse['total_pending_amt'] = $dataMaincourse['total_pending'] - $dataMaincourse['total_revenue'];
        $data_response['dashbaordtotalMaincourese'] = $dataMaincourse;

        $dataAddoncourse['total_revenue_add_on'] = $this->admission_model->total_revenue_add_on()[0]['total_revenue'];
        $dataAddoncourse['total_discount'] = $this->admission_model->total_discount_add_on()[0]['total_discount'];
        $total_pending_Add_on_single = $this->admission_model->total_pending_add_on()[0]['total_pending'];
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
                 $counter++; 
            }
        }
        return $data;
    }
  

     /*Get All Staff Details List */
     public function getclassrequestdetails($params)
     {

         //$this->db->select('*');
         $this->db->select('*,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topicid,'.TBL_TIMETABLE_TRANSECTIONS.'.timings as classtime,'.TBL_TIMETABLE_TRANSECTIONS.'.date as classdate,'.TBL_NEW_COURSE_REQUEST.'.id as request_id');
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
                    $data[$counter]['name'] = $value['name'];
                    $data[$counter]['mobile'] = $value['mobile'];
                    $data[$counter]['title'] = $value['topic'];
                    $data[$counter]['course_name'] = $value['course_name'];
                    $data[$counter]['classdate'] = $value['classdate'];
                    $data[$counter]['classtime'] = $value['classtime'];
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
}

?>