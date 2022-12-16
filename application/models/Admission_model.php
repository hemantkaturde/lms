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
                     $data[$counter]['action'] = '';
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' href='".ADMIN_PATH."editadmission/".$value['id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Admission' title='Edit Admission'></a>&nbsp;";
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
            $this->db->where('enq_number', $enq_id);
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
        $this->db->join(TBL_USERS_ENQUIRES, TBL_ENQUIRY.'.enq_number = '.TBL_USERS_ENQUIRES.'.enq_id');
        $this->db->where(TBL_USERS_ENQUIRES.'.user_id',$userId);
        $get_enquiry_courses = $this->db->get(TBL_ENQUIRY);
        $fetch_result_enquiry_courses = $get_enquiry_courses->result_array();

        $data = array();
        $counter = 0;
         foreach ($fetch_result_enquiry_courses as $key => $value) {

         $course_ids    =   explode(',', $value['enq_course_id']);

         foreach ($course_ids as $key => $value) {
           
           
        $this->db->select('*,'.TBL_TOPIC_MEETING_LINK.'.id as meeting_id,'.TBL_TIMETABLE_TRANSECTIONS.'.id as topicid');
        $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
        $this->db->join(TBL_TOPIC_MEETING_LINK, TBL_COURSE.'.courseId = '.TBL_TOPIC_MEETING_LINK.'.course_id');
        $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TOPIC_MEETING_LINK.'.time_table_transection_id = '.TBL_TIMETABLE_TRANSECTIONS.'.id');
        $this->db->where(TBL_COURSE.'.isDeleted', 0);
        $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.date =', $current_date);
        // $this->db->where(TBL_COURSE.'.courseId IN (SELECT  enq_course_id from  tbl_enquiry join tbl_users_enquires on tbl_enquiry.enq_number=tbl_users_enquires.enq_id where tbl_users_enquires.user_id='.$userId.')');
        $this->db->where(TBL_COURSE.'.courseId', $value);

        $this->db->order_by(TBL_COURSE.'.courseId', 'DESC');
        $query = $this->db->get(TBL_COURSE);
        $fetch_result = $query->result_array();
       
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                    // $data[$counter]['courseId'] = $value['courseId'];
                    $data[$counter]['course_name'] = $value['course_name'];
                    $data[$counter]['title'] = $value['topic'];
                    $data[$counter]['timings'] = $value['timings'];
                    $data[$counter]['link_url'] = $value['link_url'];
                    $data[$counter]['createdDtm'] = $value['createdDtm'];
                    $data[$counter]['date'] = $value['date'];
                    $data[$counter]['meeting_id'] = $value['meeting_id'];
                    $data[$counter]['topicid'] = $value['topicid'];
                    $data[$counter]['userid'] =  $userId;
                    $data[$counter]['courseId'] = $value['courseId'];
                    $data[$counter]['action'] = '';
                 $counter++; 
            }
        }

         }

         return $data;
       }
 


    }

   
    public function getAttendanceCount($params){

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
        $query = $this->db->get(TBL_ATTENDANCE);
        $rowcount = $query->num_rows();
        return $rowcount;

    }
     

    public function getAttendancedata($params){

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
}

?>