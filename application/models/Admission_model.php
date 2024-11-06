<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admission_model extends CI_Model
{
    function admissionListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_admission as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.id', 'desc');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function admissionListing($searchText = '')
    {
        $this->db->select('BaseTbl.id , BaseTbl.full_name, BaseTbl.adm_source, BaseTbl.admission_mode, BaseTbl.admission_date');
        $this->db->from('tbl_admission as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.full_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.adm_source  LIKE '%".$searchText."%'
                            OR  BaseTbl.admission_mode  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.id', 'desc');
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
                $this->db->or_where(TBL_ADMISSION.".mobile LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_ADMISSION.".address LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_ADMISSION.".createdBy LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_ADMISSION.".email LIKE '%".$params['search']['value']."%')");
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
                $this->db->or_where(TBL_ADMISSION.".mobile LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_ADMISSION.".createdBy LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_ADMISSION.".address LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_ADMISSION.".email LIKE '%".$params['search']['value']."%')");
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

                    $getCourseList = $this->getSelectedCourse($value['enq_id']);

                    if($getCourseList){

                    if($getCourseList[0]->enq_course_id){

                        $course_ids    =   explode(',', $getCourseList[0]->enq_course_id);
                        $total_fees = 0;
                        $course_name = '';
                        $i = 1;
                        foreach($course_ids as $id)
                        {
                            $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                            if($get_course_fees){
                                
                                $total_fees += $get_course_fees[0]->course_total_fees;
                                $course_name .= $i.') '.$get_course_fees[0]->course_name.'<br> ';  
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

                     $data[$counter]['action'] = '';
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' href='".ADMIN_PATH."editadmission/".$value['id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Admission' title='Edit Admission'></a>&nbsp;";
                     //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='view_admission_details' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/view_doc.png alt='View Admission Details' title='View Admission Details'></a>&nbsp;";
                     $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewadmissiondetails/".$value['id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/view_doc.png' alt='View Admission Details' title='View Admission Details'></a>&nbsp;";

                     if($value['cancle_status']==1){
                        //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='print_admission_cancle_reason' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/print.png alt='Cancle Admission' title='Print Admission Cancel reason'></a>&nbsp"; 
                        $data[$counter]['action'] .= "<a style='cursor: pointer;'  href='admissioncancleinfo/index.php?admission_id=".$value['id']."' target='_blank'  class='print_certificate' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/print.png alt='Print Admission Cancle reason' title='Print Admission Cancle reason'></a> "; 

                     }else{
                        $data[$counter]['action'] .= "<a style='cursor: pointer;' class='cancle_admission' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/cancle.png alt='Cancel Admission' title='Cancel Admission'></a>&nbsp";
                        $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_admission' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Admission' title='Delete Admission'></a>&nbsp"; 
 
                     }

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

            $this->db->select(TBL_ADMISSION.'.*,'.TBL_COUNTRY.'.name as countryname,'.TBL_STATES.'.name as statename,'.TBL_CITIES.'.name as cityname,'.TBL_USER.'.name as counsellor,'.TBL_USER.'.mobile as counsellor_mobile');
            $this->db->from(TBL_ADMISSION);
            $this->db->join(TBL_COUNTRY, TBL_ADMISSION.'.country = '.TBL_COUNTRY.'.id');
            $this->db->join(TBL_STATES, TBL_ADMISSION.'.state = '.TBL_STATES.'.id');
            $this->db->join(TBL_CITIES, TBL_ADMISSION.'.city = '.TBL_CITIES.'.id');
            $this->db->join(TBL_USER, TBL_ADMISSION.'.counsellor_name = '.TBL_USER.'.userId');
            $this->db->where(TBL_ADMISSION.'.isDeleted', 0);
            $this->db->where(TBL_ADMISSION.'.id', $id);
            $query = $this->db->get();
            return $query->result();

        }

        public function editDataadmission($id){
            $this->db->select(TBL_ADMISSION.'.*,'.TBL_COUNTRY.'.name as countryname,'.TBL_STATES.'.name as statename,'.TBL_CITIES.'.name as cityname,'.TBL_USER.'.name as counsellor,'.TBL_USER.'.mobile as counsellor_mobile');
            $this->db->from(TBL_ADMISSION);
            $this->db->join(TBL_COUNTRY, TBL_ADMISSION.'.country = '.TBL_COUNTRY.'.id');
            $this->db->join(TBL_STATES, TBL_ADMISSION.'.state = '.TBL_STATES.'.id');
            $this->db->join(TBL_CITIES, TBL_ADMISSION.'.city = '.TBL_CITIES.'.id');
            $this->db->join(TBL_USER, TBL_ADMISSION.'.counsellor_name = '.TBL_USER.'.userId');
            $this->db->where(TBL_ADMISSION.'.isDeleted', 0);
            $this->db->where(TBL_ADMISSION.'.id', $id);
            $query = $this->db->get();
            return $query->result();
        }

        public function counsellor_list(){
            $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role, BaseTbl.user_flag');
            $this->db->from('tbl_users as BaseTbl');
            $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->where('Role.role', 'Counsellor');
            // $this->db->limit($page, $segment);
            $query = $this->db->get();
            $result = $query->result_array();        
            return $result;


        }

        public function getSelectedCourse($enq_id){

            $this->db->select('enq_course_id');
            $this->db->from(TBL_ENQUIRY);
            $this->db->where('enq_id', $enq_id);
            $this->db->where('isDeleted', 0);
            $query = $this->db->get();
            return $query->result();

        }

        
    public function check_unique_admission($full_name,$admission_id,$enq_id){
        $this->db->select('count(*) as count ');
        $this->db->where(TBL_ADMISSION.'.name', trim($full_name));
        $this->db->where(TBL_ADMISSION.'.id', trim($admission_id));
        $this->db->where(TBL_ADMISSION.'.enq_id', trim($enq_id));
        $query = $this->db->get(TBL_ADMISSION);
        return $query->result_array();
    }

    public function check_admission_uinqe_name($full_name){
        $this->db->select('count(*) as count ');
        $this->db->where(TBL_ADMISSION.'.name', trim($full_name));
        $query = $this->db->get(TBL_ADMISSION);
        return $query->result_array();
    }


    public function saveAdmissiondata($id,$data){
        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_ADMISSION, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_ADMISSION, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function UpdateInjquirydata($enquiry_id,$data){
        $this->db->where('enq_number', $enquiry_id);
        if($this->db->update(TBL_ENQUIRY, $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }



    public function upcoming_class_links($userId){
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        $pageUrl =$this->uri->segment(1);
       
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

   
    public function getAttendanceCount($params){

        $roleText = $this->session->userdata('roleText');
        $userId = $this->session->userdata('userId');

        $this->db->select('*');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ATTENDANCE.'.course_id');
        $this->db->join(TBL_USER, TBL_USER.'.userId  = '.TBL_ATTENDANCE.'.user_id');
        $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_ATTENDANCE.'.topic_id');
        // $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.id = '.TBL_ATTENDANCE.'.meeting_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%')");
        }

        if($roleText=='Trainer'){
            $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.trainer_id', $userId);
        } 
        //$this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
        $query = $this->db->get(TBL_ATTENDANCE);
        $rowcount = $query->num_rows();
        return $rowcount;

    }
     

    public function getAttendancedata($params){

        $roleText = $this->session->userdata('roleText');
        $userId = $this->session->userdata('userId');

        $this->db->select('*');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ATTENDANCE.'.course_id');
        $this->db->join(TBL_USER, TBL_USER.'.userId  = '.TBL_ATTENDANCE.'.user_id');
        $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_ATTENDANCE.'.topic_id');
        // $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.id = '.TBL_ATTENDANCE.'.meeting_id');

        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".mobile LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_USER.".email LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%')");
        }
        //$this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
        // $this->db->order_by(TBL_TOPIC_MEETING_LINK.'.id', 'DESC');

        if($roleText=='Trainer'){
            $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.trainer_id', $userId);
        } 

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

    public function total_revenue(){

        if($this->session->userdata('roleText') =='Counsellor'){
            $userId = $this->session->userdata('userId');
            $this->db->where(TBL_ENQUIRY.'.counsellor_id',$userId);
        }

        $this->db->select('sum(totalAmount) as total_revenue');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_number = '.TBL_PAYMENT.'.enquiry_number');
        $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_PAYMENT.'.enquiry_number');
        $this->db->where(TBL_PAYMENT.'.payment_status',1);
        $this->db->where(TBL_PAYMENT.'.paymant_type','regular_invoice');
        $query = $this->db->get(TBL_PAYMENT);
        return $query->result_array();
    }

    public function total_pending(){
        
        if($this->session->userdata('roleText') =='Counsellor'){
            $userId = $this->session->userdata('userId');
            $this->db->where(TBL_ENQUIRY.'.counsellor_id',$userId);
        }

        $this->db->select('sum(tbl_enquiry.final_amount) as total_pending');
        //$this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_number');
        $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_id');

        $this->db->where(TBL_ENQUIRY.'.isDeleted',0);
        $query = $this->db->get(TBL_ENQUIRY);
        return $query->result_array();
    }


    public function total_revenue_add_on(){

        if($this->session->userdata('roleText') =='Counsellor'){
            $userId = $this->session->userdata('userId');
            $this->db->where(TBL_ENQUIRY.'.counsellor_id',$userId);
        }

        $this->db->select('sum(totalAmount) as total_revenue');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_number = '.TBL_PAYMENT.'.enquiry_number');
        // $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_PAYMENT.'.enquiry_number');

        $this->db->where(TBL_PAYMENT.'.payment_status',1);
        $this->db->where(TBL_PAYMENT.'.paymant_type','add_on_course_invoice');
        $query = $this->db->get(TBL_PAYMENT);
        return $query->result_array();
    }

    public function total_pending_add_on(){
        
        if($this->session->userdata('roleText') =='Counsellor'){
            $userId = $this->session->userdata('userId');
    
            $this->db->join(TBL_ENQUIRY, TBL_ADD_ON_COURSE.'.enquiry_id = '.TBL_ENQUIRY.'.enq_id');
            $this->db->where(TBL_ENQUIRY.'.counsellor_id',$userId);
        }

        $this->db->select('sum(tbl_course.course_total_fees) as total_pending');
    
        $this->db->join(TBL_COURSE, TBL_ADD_ON_COURSE.'.course_id = '.TBL_COURSE.'.courseId');
        // $this->db->where(TBL_ADD_ON_COURSE.'.active_status',1);
        $query = $this->db->get(TBL_ADD_ON_COURSE);
        return $query->result_array();
    }


    public function total_discount_add_on(){
        
        if($this->session->userdata('roleText') =='Counsellor'){
            $userId = $this->session->userdata('userId');
    
            $this->db->join(TBL_ENQUIRY, TBL_ADD_ON_COURSE.'.enquiry_id = '.TBL_ENQUIRY.'.enq_id');
            $this->db->where(TBL_ENQUIRY.'.counsellor_id',$userId);
        }

        $this->db->select('sum('.TBL_ADD_ON_COURSE.'.discount	) as total_discount');
    
        $this->db->join(TBL_COURSE, TBL_ADD_ON_COURSE.'.course_id = '.TBL_COURSE.'.courseId');
        // $this->db->where(TBL_ADD_ON_COURSE.'.active_status',1);
        $query = $this->db->get(TBL_ADD_ON_COURSE);
        return $query->result_array();
    }



    public function total_revenueconsellor($userid,$user_flag){

     
        $this->db->select('sum(totalAmount) as total_revenue');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_number = '.TBL_PAYMENT.'.enquiry_number');
        $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_PAYMENT.'.enquiry_number');
        $this->db->where(TBL_PAYMENT.'.payment_status',1);
        $this->db->where(TBL_ENQUIRY.'.counsellor_id',$userid);
        $this->db->where(TBL_PAYMENT.'.paymant_type','regular_invoice');
        $query = $this->db->get(TBL_PAYMENT);
        return $query->result_array();
    }

    public function total_pendingconsellor($userid,$user_flag){
        
    
        $this->db->select('sum(tbl_enquiry.final_amount) as total_pending');
        //$this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_number');
        $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_id');
        $this->db->where(TBL_ENQUIRY.'.counsellor_id',$userid);

        $this->db->where(TBL_ENQUIRY.'.isDeleted',0);
        $query = $this->db->get(TBL_ENQUIRY);
        return $query->result_array();
    }


    public function total_revenue_add_on_consellor($userid,$user_flag){
    
        $this->db->select('sum(totalAmount) as total_revenue');
        $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_number = '.TBL_PAYMENT.'.enquiry_number');
        // $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_PAYMENT.'.enquiry_number');
        $this->db->where(TBL_ENQUIRY.'.counsellor_id',$userid);
        $this->db->where(TBL_PAYMENT.'.payment_status',1);
        $this->db->where(TBL_PAYMENT.'.paymant_type','add_on_course_invoice');
        $query = $this->db->get(TBL_PAYMENT);
        return $query->result_array();
    }

    public function total_pending_add_on_consellor($userid,$user_flag){
        
        $this->db->join(TBL_ENQUIRY, TBL_ADD_ON_COURSE.'.enquiry_id = '.TBL_ENQUIRY.'.enq_id');
        $this->db->select('sum(tbl_course.course_total_fees) as total_pending');
        $this->db->join(TBL_COURSE, TBL_ADD_ON_COURSE.'.course_id = '.TBL_COURSE.'.courseId');
        // $this->db->where(TBL_ADD_ON_COURSE.'.active_status',1);
        $this->db->where(TBL_ENQUIRY.'.counsellor_id',$userid);
        $query = $this->db->get(TBL_ADD_ON_COURSE);
        return $query->result_array();
    }


    public function total_discount_add_on_consellor($userid,$user_flag){
        
    
        $this->db->join(TBL_ENQUIRY, TBL_ADD_ON_COURSE.'.enquiry_id = '.TBL_ENQUIRY.'.enq_id');
        $this->db->where(TBL_ENQUIRY.'.counsellor_id',$userid);

        $this->db->select('sum('.TBL_ADD_ON_COURSE.'.discount	) as total_discount');
    
        $this->db->join(TBL_COURSE, TBL_ADD_ON_COURSE.'.course_id = '.TBL_COURSE.'.courseId');
        // $this->db->where(TBL_ADD_ON_COURSE.'.active_status',1);
        $query = $this->db->get(TBL_ADD_ON_COURSE);
        return $query->result_array();
    }


    

        
    function getexaminationCount($params)
    {
        $this->db->select('*');
        $this->db->from('tbl_examination as BaseTbl');
        $this->db->join('tbl_course as course', 'course.courseId = BaseTbl.course_id');
        $this->db->join('tbl_timetable_transection', 'tbl_timetable_transection.course_id = course.courseId');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_timetable_transection.trainer_id');
        
        if($params['search']['value'] != "") 
        {
            $this->db->where("(course.course_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where("BaseTbl.exam_title LIKE '%".$params['search']['value']."%'");
            $this->db->or_where("BaseTbl.exam_time LIKE '%".$params['search']['value']."%')");
        }

        if($roleText=='Trainer'){
            $userId =  $this->session->userdata('userId');
            $this->db->where('tbl_timetable_transection.trainer_id', $userId);
        } 

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.exam_status', 1);
        $this->db->order_by('BaseTbl.id', 'desc');
        $query = $this->db->get();
        
        return $query->num_rows();
    }


    function getexaminationdata($params)
    {

        $this->db->select('*,BaseTbl.id as exam_id');
        $this->db->from('tbl_examination as BaseTbl');
        $this->db->join('tbl_course as course', 'course.courseId = BaseTbl.course_id');
        $this->db->join('tbl_timetable_transection', 'tbl_timetable_transection.course_id = course.courseId');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_timetable_transection.trainer_id');
        
        
        if($params['search']['value'] != "") 
        {
            $this->db->where("(course.course_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where("BaseTbl.exam_title LIKE '%".$params['search']['value']."%'");
            $this->db->or_where("BaseTbl.exam_time LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.exam_status', 1);

        if($roleText=='Trainer'){
            $userId =  $this->session->userdata('userId');
            $this->db->where('tbl_timetable_transection.trainer_id', $userId);
        } 


        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->group_by('BaseTbl.id');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get();

        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                if($value['exam_status']==1){
                    $status = "Active";
                }else{
                    $status = "Active";
                }

                 $data[$counter]['course_name'] = $value['course_name'];
                 $data[$counter]['exam_title'] = $value['exam_title'];
                 $data[$counter]['exam_status'] = $status;
                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."checkanswersheet?course_id=".$value['courseId']."&&exam_id=".$value['exam_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/view_doc.png' alt='View/Check Student Answer Paper' title='View/Check Student Answer Paper'></a>";
                 $counter++; 
            }
        }

        return $data;
    }


    function studentansersheetCount($params,$course_id,$exam_id)
    {
     
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

        $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $course_id);
        $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.exam_id', $exam_id);
        $this->db->order_by(TBL_STUDENT_ANSWER_SHEET.'.ans_id', 'DESC');
        $this->db->group_by(TBL_STUDENT_ANSWER_SHEET.'.student_id');
        $query = $this->db->get(TBL_STUDENT_ANSWER_SHEET);
        return $query->num_rows();
    }


    function studentansersheetData($params,$course_id,$exam_id)
    {

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

        $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $course_id);
        $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.exam_id', $exam_id);
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
                 
                 if($ans_sheet_status=='Checked'){
                 }else{
                    $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addmarkstoexam?course_id=".$value['courseId']."&&exam_id=".$value['id']."&&student_id=".$value['userId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/view_doc.png' alt='View/Check Student Answer Paper' title='View/Check Student Answer Paper'></a>";
                 }
                 
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


    
public function getExamdetails($course_id,$exam_id,$student_id){

    $this->db->select('*');
    $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_EXAMINATION.'.course_id');
    $this->db->where(TBL_EXAMINATION.'.id', $exam_id);
    $this->db->order_by(TBL_EXAMINATION.'.id', 'ASC');
    $query = $this->db->get(TBL_EXAMINATION);
    $fetch_result = $query->result_array();
    return $fetch_result;

}


public function getstudentexamquestionlist($course_id,$exam_id,$student_id){
    $this->db->select('*');
    $this->db->join(TBL_QUESTION_PAPER, TBL_QUESTION_PAPER.'.examination_id = '.TBL_EXAMINATION.'.id');
    $this->db->join(TBL_STUDENT_ANSWER_SHEET, TBL_QUESTION_PAPER.'.examination_id = '.TBL_STUDENT_ANSWER_SHEET.'.exam_id');
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.exam_id', $exam_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id', $student_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $course_id);
    $this->db->where(TBL_EXAMINATION.'.id', $exam_id);
    $this->db->order_by(TBL_EXAMINATION.'.id', 'ASC');
    $query = $this->db->get(TBL_EXAMINATION);
    $fetch_result = $query->result_array();
    return $fetch_result;
}


public function getuserdetails($student_id){
    $this->db->select('name,lastname,mobile');
    $this->db->where(TBL_USER.'.userid', $student_id);
    $query = $this->db->get(TBL_USER);
    $fetch_result = $query->result_array();
    return $fetch_result;
}


public function getquestionPaperListMCQInfo($course_id,$examination_id,$student_id){
        
    $this->db->select('*');
    $this->db->from(TBL_QUESTION_PAPER);
    $this->db->join(TBL_STUDENT_ANSWER_SHEET, TBL_STUDENT_ANSWER_SHEET.'.question_id ='.TBL_QUESTION_PAPER.'.id');
    // $this->db->where(TBL_QUESTION_PAPER.'.isDeleted', 0);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.exam_id', $examination_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $course_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id', $student_id);
    $this->db->where(TBL_QUESTION_PAPER.'.question_type', 'MCQ');
    $query = $this->db->get();
    return $query->result();

} 

public function getquestionPaperListWRITTENInfo($course_id,$examination_id,$student_id){
        
       
    $this->db->select('*');
    $this->db->from(TBL_QUESTION_PAPER);
    $this->db->join(TBL_STUDENT_ANSWER_SHEET, TBL_STUDENT_ANSWER_SHEET.'.question_id ='.TBL_QUESTION_PAPER.'.id');
    // $this->db->where(TBL_QUESTION_PAPER.'.isDeleted', 0);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.exam_id', $examination_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $course_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id', $student_id);
    $this->db->where(TBL_QUESTION_PAPER.'.question_type', 'WRITTEN');
    $query = $this->db->get();
    return $query->result();

} 


public function getquestionPaperListMATCHPAIRInfo($course_id,$examination_id,$student_id){
        
    $this->db->select('*');
    $this->db->from(TBL_QUESTION_PAPER);
    $this->db->join(TBL_STUDENT_ANSWER_SHEET, TBL_STUDENT_ANSWER_SHEET.'.question_id ='.TBL_QUESTION_PAPER.'.id');
    // $this->db->where(TBL_QUESTION_PAPER.'.isDeleted', 0);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.exam_id', $examination_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $course_id);
    $this->db->where(TBL_STUDENT_ANSWER_SHEET.'.student_id', $student_id);
    $this->db->where(TBL_QUESTION_PAPER.'.question_type', 'MATCH_PAIR');
    $query = $this->db->get();
    return $query->result();

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



function studentcertificateCount($params)
{
 
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

    $this->db->order_by(TBL_STUDENT_ANSWER_SHEET.'.ans_id', 'DESC');
    $this->db->group_by(TBL_STUDENT_ANSWER_SHEET.'.student_id');
    $query = $this->db->get(TBL_STUDENT_ANSWER_SHEET);
    return $query->num_rows();
}


function studentcertificateData($params)
{

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

    $this->db->order_by(TBL_STUDENT_ANSWER_SHEET.'.ans_id', 'DESC');
    $this->db->group_by(TBL_STUDENT_ANSWER_SHEET.'.course_id');
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
             $data[$counter]['course_name'] = $value['course_name'];
             $data[$counter]['mobile'] = $value['mobile'];
             $data[$counter]['exam_status'] = $exam_status;
             $data[$counter]['total_marks'] = $total_marks;
             $data[$counter]['grade'] = $grade;
             $data[$counter]['grade_point'] = $Grade_point;
             $data[$counter]['remark'] = $Remark;
             $data[$counter]['Quntitave_value'] = $Quntitave_value;
             $data[$counter]['ans_sheet_status'] = $ans_sheet_status;
             $data[$counter]['action'] = '';

              if($Quntitave_value=='Fail'){

                 $data[$counter]['action'] .= 'Fail';

              }else{

                $data[$counter]['action'] .= "<a style='cursor: pointer;'  href='marksheet/index.php?student_id=".$value['student_id']."' target='_blank'  class='print_certificate' data-id='".$value['student_id']."'><img width='20' src=".ICONPATH."/marksheet.png alt='Student Marksheet' title='Student Marksheet'></a> "; 
                $data[$counter]['action'] .= "| <a style='cursor: pointer;'  href='certificate/index.php?student_id=".$value['student_id']."' target='_blank'  class='print_certificate' data-id='".$value['student_id']."'><img width='20' src=".ICONPATH."/print.png alt='Print Certificate' title='Print Certificate'></a> "; 
                //$data[$counter]['action'] .= "| <a style='cursor: pointer;' class='addevbtr' rg-id='".$value['student_id']."'  evbtr-no='".$value['evbtr']."'  evbtr-date='".$value['evbtrdate']."'  evbtr-remark='".$value['evbtrremark']."' ><img width='20' src='".ICONPATH."/ivbtr.png' alt='Update EVBTR' title='Update EVBTR'></a>"; 
              }
             $counter++; 
        }
    }

    return $data;
}


    public function getStudentscourseattetendancedetails($sutudentid){

        $this->db->select('count(*) as count,course_name,course_id');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ATTENDANCE.'.course_id');
        $this->db->where(TBL_ATTENDANCE.'.user_id', $sutudentid);
        $this->db->where(TBL_ATTENDANCE.'.attendance_status', 1);
        $this->db->group_by(TBL_ATTENDANCE.'.course_id');
        $query = $this->db->get(TBL_ATTENDANCE);
        $fetch_result = $query->result_array();

        $arraydivision=array();
        
        foreach ($fetch_result as $key => $value) {

           $total_links = $this->upcoming_class_links_barchart($sutudentid,$value['course_id']);

           if(count($total_links) > 0){
            $total_topics = count($total_links);
           }else{
            $total_topics =0;
           }

           if($total_topics > 0){

            $peecentage = $value['count']/$total_topics * 100;
           }else{
            $peecentage = 0;

           }


    
          //$arraydivision['label'] = $value['course_name'];
          //$arraydivision['y'] = $peecentage;
           $arraydivision[] = array('label'=>$value['course_name'],'y'=>$peecentage);
        }
        return $arraydivision;
    }


    public function getlinksforperticularuser($courseid,$sutudentid){

        $this->db->select('count(*) as count');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_ATTENDANCE.'.course_id');
        $this->db->where(TBL_ATTENDANCE.'.course_id', $courseid);
        $this->db->where(TBL_ATTENDANCE.'.user_id', $sutudentid);
        $query = $this->db->get(TBL_ATTENDANCE);
        $fetch_result = $query->result_array();

        return $fetch_result[0];
    }


    public function getstudentEenquiryid($userId){
        $this->db->select('*');
        $this->db->where(TBL_USERS_ENQUIRES.'.user_id', $userId);
        $query = $this->db->get(TBL_USERS_ENQUIRES);
        $fetch_result = $query->result_array();
        return $fetch_result;
    }


    public function getstudentexamrequestdataCount($params){

        $this->db->select('*');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_STUDENT_REQUEST.'.course_id');
        $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_STUDENT_REQUEST.'.student_id');
        $this->db->where(TBL_STUDENT_REQUEST.'.status', 1);
        $this->db->where(TBL_USER.'.user_flag', 'student');
        $query = $this->db->get(TBL_STUDENT_REQUEST);
        $rowcount = $query->num_rows();
        return $rowcount;
    }


    public function getstudentexamrequestdataData($params){

        $this->db->select('*');
        $this->db->from(TBL_STUDENT_REQUEST);
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_STUDENT_REQUEST.'.course_id');
        $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_STUDENT_REQUEST.'.student_id');
        $this->db->where(TBL_STUDENT_REQUEST.'.status', 1);
        $this->db->where(TBL_USER.'.user_flag', 'student');
        $this->db->order_by(TBL_STUDENT_REQUEST.'.id', 'DESC');
        $this->db->limit($params['length'],$params['start']);
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
                    $data[$counter]['permission'] = '<input type="checkbox" onClick="CheckboxCheckUncheck('.$value['id'].')" checked id="permission"/><br />';
                 }else{
                    $data[$counter]['permission'] = '<input type="checkbox" onClick="CheckboxCheckUncheck('.$value['id'].')" id="permission"/><br />';
                 }
               
                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_student_request' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Student Request' title=''Delete Student Request'></a>&nbsp"; 
                 $counter++; 
            }
        }
        return $data;
    }


    public function CheckboxCheckUncheckpermission($id,$permission_value){
        $data =array(
            'permission'=>$permission_value
        );

        $this->db->where('id', $id);
        if($this->db->update(TBL_STUDENT_REQUEST, $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }


    public function upcoming_class_links_barchart($userId,$course_id){
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        $pageUrl =$this->uri->segment(1);
       
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

        if($value==$course_id){

       
        $this->db->select('*,'.TBL_TOPIC_MEETING_LINK.'.id as meeting_id,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topicid,'.TBL_TIMETABLE_TRANSECTIONS.'.timings as classtime');
        $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id');

        $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.course_id = '.TBL_COURSE.'.courseId');
        $this->db->join(TBL_TIMETABLE, TBL_TIMETABLE_TRANSECTIONS.'.time_table_id = '.TBL_TIMETABLE.'.id');

        $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.time_table_transection_id = '.TBL_TIMETABLE_TRANSECTIONS.'.id','left');
    
        $this->db->where(TBL_COURSE.'.isDeleted', 0);
       // $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.date =', $current_date);
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
       
       }
 
       return $data;
    }



    public function getaskaqueryRecord($userId){

        // $userId =  $this->session->userdata('userId');
        // $roleText = $this->session->userdata('roleText');

        $this->db->select('*,'.TBL_ASK_A_QUERY.'.id as queryid,'.TBL_ASK_A_QUERY.'.createdDtm');
        $this->db->join(TBL_COURSE, TBL_ASK_A_QUERY.'.course_id = '.TBL_COURSE.'.courseId');
        $this->db->join(TBL_USER, TBL_ASK_A_QUERY.'.student_id = '.TBL_USER.'.userId');
        $this->db->join(TBL_ASK_A_QUERY_ANSWER, TBL_ASK_A_QUERY_ANSWER.'.query_id = '.TBL_ASK_A_QUERY.'.id');
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
                $data[$counter]['query_answer'] = $value['query_answer'];
                $data[$counter]['queryid'] = $value['queryid'];
                $data[$counter]['course_name'] = $value['course_name'];
                $data[$counter]['topic_name'] = $value['topic'];
                $data[$counter]['name'] = $value['name'];
                $data[$counter]['query'] = $value['query'];
                $data[$counter]['createdDtm'] = $value['createdDtm'];
                $data[$counter]['action'] = '';            
                $counter++; 
            }
        }
       return $data;
    }


    public function cancleadmission($id){
        $data =array(
            'cancle_status'=>1
        );
        $this->db->where('id', $id);
        if($this->db->update(TBL_ADMISSION, $data)){
            return TRUE;
            $sql = "UPDATE tbl_enquiry AS ud JOIN tbl_admission AS u ON ud.enq_id = u.enq_id SET ud.cancle_status=1 WHERE u.id = $id";
                if($this->db->query($sql)){
                    return TRUE;
                }else{
                    return FALSE;
                }

        } else {
            return FALSE;
        }

        // $this->db->join(TBL_ENQUIRY, TBL_ENQUIRY.'.enq_id  = '.TBL_ADMISSION.'.enq_id');
        // $this->db->where(TBL_ADMISSION.'.id ', $id);
       
        // if($this->db->update(TBL_ENQUIRY, $data)){
        //     return TRUE;
        // }else{
        //     return FALSE;
        // }

        
    }

    public function courseRequestDataCount($params,$userId){
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        $pageUrl =$this->uri->segment(1);
       
        $current_date = date('Y-m-d');
       
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
           
        $this->db->select('*,'.TBL_TOPIC_MEETING_LINK.'.id as meeting_id,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topicid,'.TBL_TIMETABLE_TRANSECTIONS.'.timings as classtime,'.TBL_TIMETABLE_TRANSECTIONS.'.date as classdate');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_TIMETABLE_TRANSECTIONS.'.course_id');
        $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id');

      
        $this->db->join(TBL_TIMETABLE, TBL_TIMETABLE_TRANSECTIONS.'.time_table_id = '.TBL_TIMETABLE.'.id');

        $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.time_table_transection_id = '.TBL_TIMETABLE_TRANSECTIONS.'.id','left');
    
        $this->db->where(TBL_COURSE.'.isDeleted', 0);
       // $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.date =', $current_date);
        // $this->db->where(TBL_COURSE.'.courseId IN (SELECT  enq_course_id from  tbl_enquiry join tbl_users_enquires on tbl_enquiry.enq_number=tbl_users_enquires.enq_id where tbl_users_enquires.user_id='.$userId.')');
        $this->db->where(TBL_COURSE.'.courseId', $value);
        // $this->db->order_by(TBL_TIMETABLE_TRANSECTIONS.'.id', 'DESC');
        $query = $this->db->get(TBL_TIMETABLE_TRANSECTIONS);
        $fetch_result = $query->result_array();
       
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                $data[$counter]['courseId'] = $value['courseId'];
                 $counter++; 
            }
        }

         }
       }

    
      return count($data);
    }


    public function courseRequestData($params,$userId){
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        $pageUrl =$this->uri->segment(1);
       
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
           
        $this->db->select('*,'.TBL_TOPIC_MEETING_LINK.'.id as meeting_id,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topicid,'.TBL_TIMETABLE_TRANSECTIONS.'.timings as classtime,'.TBL_TIMETABLE_TRANSECTIONS.'.date as classdate');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_TIMETABLE_TRANSECTIONS.'.course_id');
        $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id');

      
        $this->db->join(TBL_TIMETABLE, TBL_TIMETABLE_TRANSECTIONS.'.time_table_id = '.TBL_TIMETABLE.'.id');

        $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_TOPIC_MEETING_LINK.'.time_table_transection_id = '.TBL_TIMETABLE_TRANSECTIONS.'.id','left');
    
        $this->db->where(TBL_COURSE.'.isDeleted', 0);
       // $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.date =', $current_date);
        // $this->db->where(TBL_COURSE.'.courseId IN (SELECT  enq_course_id from  tbl_enquiry join tbl_users_enquires on tbl_enquiry.enq_number=tbl_users_enquires.enq_id where tbl_users_enquires.user_id='.$userId.')');
        $this->db->where(TBL_COURSE.'.courseId', $value);
        $this->db->limit($params['length'],$params['start']);
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

                    $checkAprrovalstatus = $this->checkAprrovalstatus($userId,$value['topicid']);
                  
                    if($checkAprrovalstatus){

                        if($checkAprrovalstatus['approval_status'] > 0){
                            $request_status ='Approved';
                        }else{
                            $request_status ='In Approval Process ..please wait';
                        }
                       
                    }else{
                        $request_status ='NA';
                    }
                   
                    $data[$counter]['request_status'] =  $request_status;
                    $data[$counter]['action'] = '';
                    $data[$counter]['action'] .= "<a style='cursor: pointer;' class='request_class' data-id='".$value['topicid']."'><img width='20' src=".ICONPATH."/request_new.png alt='Request New Class' title='Request New Class'></a>&nbsp"; 

                 $counter++; 
            }
        }

         }
       }
 
       return $data;

    }


    public function topicrequestDetails($topicid){
        $this->db->select('*,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topictimetbaleid');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_TIMETABLE_TRANSECTIONS.'.course_id');
        $this->db->join(TBL_TIMETABLE, TBL_TIMETABLE.'.id = '.TBL_TIMETABLE_TRANSECTIONS.'.time_table_id');
        $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.id',$topicid);
        $get_enquiry_courses = $this->db->get(TBL_TIMETABLE_TRANSECTIONS);
        $fetch_result_enquiry_courses = $get_enquiry_courses->row_array();

        return $fetch_result_enquiry_courses;
    }

    public function saveclassrequest($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_NEW_COURSE_REQUEST, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_NEW_COURSE_REQUEST, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }

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


    public function courseRequestDataCountadmin($params){
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        $pageUrl =$this->uri->segment(1);
    
        //$this->db->select('*');
         $this->db->select('*,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topicid,'.TBL_TIMETABLE_TRANSECTIONS.'.timings as classtime,'.TBL_TIMETABLE_TRANSECTIONS.'.date as classdate');
         $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_NEW_COURSE_REQUEST.'.time_table_id');
         $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_TIMETABLE_TRANSECTIONS.'.course_id');
         $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id');

        // $this->db->join(TBL_NEW_COURSE_REQUEST, TBL_NEW_COURSE_REQUEST.'.time_table_id = '.TBL_TIMETABLE_TRANSECTIONS.'.id');
    
        // $this->db->join(TBL_TIMETABLE, TBL_TIMETABLE_TRANSECTIONS.'.time_table_id = '.TBL_TIMETABLE.'.id');
        $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_NEW_COURSE_REQUEST.'.student_id');
        // $this->db->where(TBL_COURSE.'.isDeleted', 0);
        $this->db->where(TBL_NEW_COURSE_REQUEST.'.request_sent_status=',1);        
        // $this->db->where(TBL_COURSE.'.courseId', $value);
        $this->db->limit($params['length'],$params['start']);
        $this->db->order_by(TBL_NEW_COURSE_REQUEST.'.id', 'DESC');
        $query = $this->db->get(TBL_NEW_COURSE_REQUEST);
        $fetch_result = $query->num_rows();

    
         return $fetch_result;
    }


    public function courseRequestDataadmin($params){
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        $pageUrl =$this->uri->segment(1);
    
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
        $this->db->limit($params['length'],$params['start']);
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
                    $data[$counter]['action'] = '';
                    $data[$counter]['action'] .= "<a style='cursor: pointer;' class='request_class_admin' data-id='".$value['request_id']."'><img width='20' src=".ICONPATH."/request_new.png alt='Request New Class' title='Request New Class'></a>&nbsp"; 

                 $counter++; 
            }
    //     }

    //      }

   
        }
 
        return $data;

    }


    public function getcoursetopicrequestdetailsadmin($requestid){
        $this->db->select('*,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topictimetbaleid,'.TBL_NEW_COURSE_REQUEST.'.id as request_id,'.TBL_NEW_COURSE_REQUEST.'.remark as request_description');
        $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.id = '.TBL_NEW_COURSE_REQUEST.'.time_table_id');
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_TIMETABLE_TRANSECTIONS.'.course_id');
        $this->db->join(TBL_TIMETABLE, TBL_TIMETABLE.'.id = '.TBL_TIMETABLE_TRANSECTIONS.'.time_table_id');
        $this->db->where(TBL_NEW_COURSE_REQUEST.'.id',$requestid);
        $get_enquiry_courses = $this->db->get(TBL_NEW_COURSE_REQUEST);
        $fetch_result_enquiry_courses = $get_enquiry_courses->row_array();

        return $fetch_result_enquiry_courses;
    }


    public function savewhatsappconfig($id,$data){

            if($id != '') {
                $this->db->where('id', $id);
                if($this->db->update(TBL_SETTINGS, $data)){
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                if($this->db->insert(TBL_SETTINGS, $data)) {
                    return $this->db->insert_id();;
                } else {
                    return FALSE;
                }
            }
    }


    public function get_whatsappconfig_setting(){

        $this->db->select('*');
        $this->db->where(TBL_SETTINGS.'.setting_module','whatsapp_credentials');
        $get_whatsappconfig_setting = $this->db->get(TBL_SETTINGS);
        $get_whatsappconfig_setting_result = $get_whatsappconfig_setting->row_array();
        return $get_whatsappconfig_setting_result;

    }


    public function getdataforexamchecking($userId,$roleText)
    {

     
        $this->db->select('*');
        $this->db->join(TBL_COURSE, TBL_STUDENT_ANSWER_SHEET.'.course_id = '.TBL_COURSE.'.courseId');
        $this->db->join(TBL_EXAMINATION, TBL_STUDENT_ANSWER_SHEET.'.exam_id = '.TBL_EXAMINATION.'.id');
        $this->db->join(TBL_USER, TBL_STUDENT_ANSWER_SHEET.'.student_id = '.TBL_USER.'.userId');
        // $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.course_id = '.TBL_COURSE.'.courseId');

        // if($params['search']['value'] != "") 
        // {
        //     $this->db->where("(course.course_name LIKE '%".$params['search']['value']."%'");
        //     $this->db->or_where("BaseTbl.exam_title LIKE '%".$params['search']['value']."%'");
        //     $this->db->or_where("BaseTbl.exam_time LIKE '%".$params['search']['value']."%')");
        // }

        //$this->db->where(TBL_STUDENT_ANSWER_SHEET.'.course_id', $course_id);
        //$this->db->where(TBL_EXAMINATION.'.course_id', $value);
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
                    // $data[$counter]['total_marks'] = $total_marks;
                    // $data[$counter]['grade'] = $grade;
                    // $data[$counter]['grade_point'] = $Grade_point;
                    // $data[$counter]['remark'] = $Remark;
                    // $data[$counter]['Quntitave_value'] = $Quntitave_value;
                    $data[$counter]['ans_sheet_status'] = $ans_sheet_status;
                    $data[$counter]['action'] = '';
                    
                    if($ans_sheet_status=='Checked'){
                    }else{
                       $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addmarkstoexam?course_id=".$value['courseId']."&&exam_id=".$value['id']."&&student_id=".$value['userId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/view_doc.png' alt='View/Check Student Answer Paper' title='View/Check Student Answer Paper'></a>";
                    }
                 }

                 
                 $counter++; 
            }
        }

        return $data;
        
    }


    
    


}

?>