<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Course_model extends CI_Model
{
    public $CI="";
    public function __construct(){

        $this->CI =& get_instance();
    }

    function data_insert($table='',$arr=''){

        $this->CI->db->insert($table,$arr);
        return $this->CI->db->insert_id();
    }

    function data_update($table='',$arr='',$field='',$value=''){
        // $this->CI->db->where($field,$value);
        // return $this->CI->db->update($table,$arr);
        $this->db->where($field, $value);
        return  $this->db->delete($table);
    }

    function courseListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.courseId , BaseTbl.course_name, BaseTbl.course_desc, BaseTbl.course_date,BaseTbl.createdDtm, BaseTbl.course_fees, Type.ct_name');
        $this->db->from('tbl_course as BaseTbl');
        $this->db->join('tbl_course_type as Type', 'Type.ct_id = BaseTbl.course_type_id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.course_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.course_desc  LIKE '%".$searchText."%'
                            OR  Type.ct_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.courseId', 'desc');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function courseListing($searchText = '')
    {
        $this->db->select('BaseTbl.courseId , BaseTbl.course_name, BaseTbl.course_desc, BaseTbl.course_date,BaseTbl.createdDtm, BaseTbl.course_fees, Type.ct_name');
        $this->db->from('tbl_course as BaseTbl');
        $this->db->join('tbl_course_type as Type', 'Type.ct_id = BaseTbl.course_type_id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.course_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.course_desc  LIKE '%".$searchText."%'
                            OR  Type.ct_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.courseId', 'desc');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;      
    }
        
        /*
        Get Single course
        */ 
        public function getCourseInfo($courseId)
        {


            $this->db->select('BaseTbl.*,BaseTbl.courseId , BaseTbl.course_name, BaseTbl.course_desc, BaseTbl.course_date, BaseTbl.course_fees, BaseTbl.course_cert_cost, BaseTbl.course_onetime_adm_fees, BaseTbl.course_kit_cost, BaseTbl.course_remark, BaseTbl.course_type_id, BaseTbl.course_books,BaseTbl.trainer_id');
            $this->db->from('tbl_course as BaseTbl');
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->where('BaseTbl.courseId', $courseId);
            $query = $this->db->get();
            
            return $query->result();
        }

        public function courseLinksListing($courseId)
        {
            $this->db->select('BaseTbl.link_id , BaseTbl.course_id, BaseTbl.link_name, BaseTbl.link_url, BaseTbl.link_sdate, BaseTbl.link_ldate');
            $this->db->from('tbl_course_link as BaseTbl');
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->where('BaseTbl.course_id', $courseId);
            $query = $this->db->get();
            
            return $query->result();
        }

        public function getCourseLinkInfo($id)
        {
            $this->db->select('BaseTbl.link_id, BaseTbl.link_name, BaseTbl.link_url, BaseTbl.link_sdate, BaseTbl.link_ldate');
            $this->db->from('tbl_course_link as BaseTbl');
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->where('BaseTbl.link_id', $id);
            $query = $this->db->get();
            
            return $query->result();
        }

        // ====================================
        function courseTypeListingCount($searchText = '')
        {
            $this->db->select('BaseTbl.ct_id , BaseTbl.ct_name');
            $this->db->from('tbl_course_type as BaseTbl');
            if(!empty($searchText)) {
                $likeCriteria = "(BaseTbl.ct_name  LIKE '%".$searchText."%')";
                $this->db->where($likeCriteria);
            }
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->order_by('BaseTbl.ct_id', 'desc');
            $query = $this->db->get();
            
            return $query->num_rows();
        }

        function courseTypeListing($searchText = '')
        {
            $this->db->select('BaseTbl.ct_id , BaseTbl.ct_name');
            $this->db->from('tbl_course_type as BaseTbl');
            if(!empty($searchText)) {
                $likeCriteria = "(BaseTbl.ct_name  LIKE '%".$searchText."%')";
                $this->db->where($likeCriteria);
            }
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->order_by('BaseTbl.ct_id', 'desc');
            // $this->db->limit($page, $segment);
            $query = $this->db->get();
            
            $result = $query->result();
            return $result;      
        }

        /*
        Get Certificate Type
        */ 
        public function getAllCourseTypeInfo()
        {
            $this->db->select('BaseTbl.ct_id , BaseTbl.ct_name');
            $this->db->from('tbl_course_type as BaseTbl');
            $this->db->where('BaseTbl.isDeleted', 0);
            $query = $this->db->get();
            
            return $query->result();
        }

        /*
        Get Single Certificate Type
        */ 
        public function getCourseTypeInfo($courseId)
        {
            $this->db->select('BaseTbl.ct_id , BaseTbl.ct_name');
            $this->db->from('tbl_course_type as BaseTbl');
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->where('BaseTbl.ct_id', $courseId);
            $query = $this->db->get();
            
            return $query->result();
        }
        // ====================================



        public function  getCourseCount($params){
            $roleText = $this->session->userdata('roleText');
            $access = $this->session->userdata('access');
            $userId = $this->session->userdata('userId');
            $jsonstringtoArray = json_decode($access, true);
            $pageUrl =$this->uri->segment(1);

            $this->db->select('*');
            $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
           
            if($roleText=='Trainer'){
                $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.course_id = '.TBL_COURSE.'.courseId');
                $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.trainer_id', $userId);
                $this->db->group_by(TBL_TIMETABLE_TRANSECTIONS.'.course_id');
            } 

            if($params['search']['value'] != "") 
            {
                $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_COURSE.".course_total_fees LIKE '%".$params['search']['value']."%')");
            }


            $this->db->where(TBL_COURSE.'.isDeleted', 0);
            $query = $this->db->get(TBL_COURSE);
            $rowcount = $query->num_rows();
            return $rowcount;

        }

        public function getCoursedata($params){
            $roleText = $this->session->userdata('roleText');
            $access = $this->session->userdata('access');
            $userId = $this->session->userdata('userId');
            $jsonstringtoArray = json_decode($access, true);
            $pageUrl =$this->uri->segment(1);

            $this->db->select('*');
            $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
            if($roleText=='Trainer'){
                $this->db->join(TBL_TIMETABLE_TRANSECTIONS, TBL_TIMETABLE_TRANSECTIONS.'.course_id = '.TBL_COURSE.'.courseId');
                $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.trainer_id', $userId);
                $this->db->group_by(TBL_TIMETABLE_TRANSECTIONS.'.course_id');
            } 
            if($params['search']['value'] != "") 
            {
                $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_COURSE.".course_total_fees LIKE '%".$params['search']['value']."%')");
            }


            $this->db->where(TBL_COURSE.'.isDeleted', 0);
           // $this->db->group_by(TBL_TIMETABLE_TRANSECTIONS.'.course_id');
            $this->db->order_by(TBL_COURSE.'.courseId', 'DESC');
            $this->db->limit($params['length'],$params['start']);
            $query = $this->db->get(TBL_COURSE);
            $fetch_result = $query->result_array();
            $data = array();
            $counter = 0;
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

                      
                        //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='add_links' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/add_links.png  alt='Delete Equipment' title='Delete Equipment'></a> &nbsp"; 
                        //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='view_document' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/view_doc.png alt='Delete Equipment' title='Delete Equipment'></a> &nbsp"; 

                        //$data[$counter]['action'] .= "<a href='".ADMIN_PATH."addcourseListing/".$value['courseId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/attachment.png' alt='Add Attachment' title='Add Attachment'></a> | ";

                        $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addchapters/".$value['courseId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/books.png' alt='Add Topics' title='Add Topics'></a> | ";
                        $data[$counter]['action'] .= "<a href='".ADMIN_PATH."timetableListing/".$value['courseId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/timetable.png' alt='Add Time Table' title='Add Time Table'></a> | ";

                        
                          //  $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course' data-id='".$value['courseId']."' data-toggle='modal' data-target='#editCourse'><img width='20' src=".ICONPATH."/edit.png alt='Edit Equipment' title='Edit Equipment'></a>&nbsp;";
                        if(in_array("coursedit", $jsonstringtoArray)){
                            $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Course' title='Edit Course'></a> | ";
                        }

                        $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addsyllabus/".$value['courseId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/file.png' alt='Add Syllabus' title='Add Syllabus'></a> | ";

    
                        if(in_array("coursedelete", $jsonstringtoArray)){
                            $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_course' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Course' title='Delete Course'></a>&nbsp"; 
                        }

                     $counter++; 
                }
            }

            return $data;
        }
        

    public function saveCoursedata($id,$data){

        if($id != '') {
            $this->db->where('courseId', $id);
            if($this->db->update(TBL_COURSE, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_COURSE, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function checkquniqecoursename($course_name){
        $this->db->select('course_name');
        $this->db->from(TBL_COURSE);
        $this->db->where('isDeleted', 0);
        $this->db->where('course_name', $course_name);
        $query = $this->db->get();
        return $query->result();
    }

    public function checkquniqecoursename_update($courseId,$course_name){
        $this->db->select('courseId,course_name');
        $this->db->from(TBL_COURSE);
        $this->db->where('isDeleted', 0);
        $this->db->where('courseId !=', $courseId);
        $this->db->where('course_name', $course_name);
        $query = $this->db->get();
        return $query->result();
    }


    public function  getCoursetypeCount($params){
        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE_TYPE.'.isDeleted', 0);
        $query = $this->db->get(TBL_COURSE_TYPE);
        $rowcount = $query->num_rows();
        return $rowcount;

    }

    public function getCoursetypedata($params){
        $access = $this->session->userdata('access');
        $jsonstringtoArray = json_decode($access, true);
        
        $this->db->select('*');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(".TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE_TYPE.'.isDeleted', 0);
        $this->db->order_by(TBL_COURSE_TYPE.'.ct_id', 'DESC');
        $this->db->limit($params['length'],$params['start']);
        $query = $this->db->get(TBL_COURSE_TYPE);
        $fetch_result = $query->result_array();
        $data = array();
        $counter = 0;
        if(count($fetch_result) > 0)
        {
            foreach ($fetch_result as $key => $value)
            {
                 $data[$counter]['course_type'] = $value['ct_name'];
                 $data[$counter]['action'] = '';

                 if(in_array("coursetypedit", $jsonstringtoArray)){
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course_type' data-id='".$value['ct_id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Certificate Type' title='Edit Certificate Type'></a> |";
                 }

                 if(in_array("coursetypedelete", $jsonstringtoArray)){
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_course_type' data-id='".$value['ct_id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Certificate Type' title='Delete Certificate Type'></a>"; 
                 }
                $counter++; 
            }
        }

        return $data;
    }


    public function checkquniqecoursetype($course_type_name){
        $this->db->select('ct_name');
        $this->db->from(TBL_COURSE_TYPE);
        $this->db->where('isDeleted', 0);
        $this->db->where('ct_name', $course_type_name);
        $query = $this->db->get();
        return $query->result();
    }



    public function saveCoursetypedata($id,$data){
        if($id != '') {
            $this->db->where('ct_id', $id);
            if($this->db->update(TBL_COURSE_TYPE, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_COURSE_TYPE, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }


    public function checkquniqecoursetypename($coursetype_name){
        $this->db->select('ct_name');
        $this->db->from(TBL_COURSE_TYPE);
        $this->db->where('isDeleted', 0);
        $this->db->where('ct_name', $coursetype_name);
        $query = $this->db->get();
        return $query->result();
    }

    public function checkquniqecoursetypename_update($coursetypeId,$coursetype_name){
        $this->db->select('ct_id,ct_name');
        $this->db->from(TBL_COURSE_TYPE);
        $this->db->where('isDeleted', 0);
        $this->db->where('ct_id !=', $coursetypeId);
        $this->db->where('ct_name', $coursetype_name);
        $query = $this->db->get();
        return $query->result();
    }

    public function checkRelation($id){
        $this->db->select('*');
        $this->db->from(TBL_COURSE);
        $this->db->where('isDeleted', 0);
        $this->db->where('course_type_id', $id);
        $query = $this->db->get();
        return $query->result();
    
    }

    public function checkRelationcourse($id){
        $this->db->select('*');
        $this->db->from(TBL_ENQUIRY);
        $this->db->where('isDeleted', 0);
        $this->db->where('enq_course_id', $id);
        $query = $this->db->get();
        return $query->result();

    }


    public function  getCourseattchmentCount($params,$courseid){
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


    public function getCourseattchmentdata($params,$courseid){
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
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."topicattachmentListing?topic_id=".$value['id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/attachment.png' alt='Add Attachment' title='Add Attachment'></a> | ";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course_topic' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Certificate Type' title='Edit Certificate Type'></a> | ";
                //  $data[$counter]['action'] .= "<a style='cursor: pointer;' class='add_topic_attachment' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/attachment.png alt='Add Attachment' title='Add Attachment'></a> |";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_course_topic' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Certificate Type' title='Delete Certificate Type'></a>"; 
                
                $counter++; 
            }
        }

        return $data;
    }


    public function checkquniqecoursetopicname($topicname,$course_id_1_post){
        $this->db->select('topic_name');
        $this->db->from(TBL_COURSE_TOPICS);
        $this->db->where('isDeleted', 0);
        $this->db->where('topic_name', $topicname);
        $this->db->where('course_id', $course_id_1_post);
        $query = $this->db->get();
        return $query->result();
    }

    public function checkquniqecoursetopicname_nameupdate($course_id_1_post){
        $this->db->select('topic_name');
        $this->db->from(TBL_COURSE_TOPICS);
        $this->db->where('isDeleted', 0);
        $this->db->where('topic_name', $course_id_1_post);
        //$this->db->where('course_id', $course_id_1_post);
        $query = $this->db->get();
        return $query->result();
    }

    public function checkquniqecoursetopicnameupdate($topic_id,$course_id_1_post,$topic_name_1){
        $this->db->select('*');
        $this->db->from(TBL_COURSE_TOPICS);
        $this->db->where('isDeleted', 0);
        $this->db->where('topic_name', $topic_name_1);
        $this->db->where('course_id', $course_id_1_post);
        $this->db->where('id', $topic_id);
        $query = $this->db->get();
        return $query->result();

    }


    public function saveCourseTopicsdata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_COURSE_TOPICS, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_COURSE_TOPICS, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }

    public function updateCourseTopicsdata($id,$course_id,$data){

            $this->db->where('course_id', $course_id);
            $this->db->where('id', $id);
            if($this->db->update(TBL_COURSE_TOPICS, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
       
    }

    public function checktopicsRelation(){
        return FALSE;
    }

   public function get_signle_course_topic($topic_id,$course_id){

        $this->db->select('*');
        $this->db->from('tbl_course_topics');
        $this->db->where('tbl_course_topics.isDeleted', 0);
        //$this->db->where('tbl_enquiry.payment_status', 1);
        $this->db->where('tbl_course_topics.id', $topic_id);
        $this->db->where('tbl_course_topics.course_id', $course_id);
        $query = $this->db->get();
        return $query->result();
   }


   public function get_signle_course_topicattchment($topic_id,$course_id){

    $this->db->select('*');
    $this->db->from('tbl_course_topics');
    $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = tbl_course_topics.course_id');
    $this->db->where('tbl_course_topics.isDeleted', 0);
    //$this->db->where('tbl_enquiry.payment_status', 1);
    $this->db->where('tbl_course_topics.id', $topic_id);
    $this->db->where('tbl_course_topics.course_id', $course_id);
    $query = $this->db->get();
    return $query->result();
  }


 public function getDocumentcount($topic_id,$course_id){
    $this->db->select('*');
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.isDeleted', 0);
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.module_name', 'documents');
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.course_id', $course_id);
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.topic_id', $topic_id);
    $query = $this->db->get(TBL_COURSE_TOPICS_DOCUMENT);
    $rowcount = $query->num_rows();
    return $rowcount;

 }

 public function getVideoscount($topic_id,$course_id){
    $this->db->select('*');
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.isDeleted', 0);
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.module_name', 'videos');
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.course_id', $course_id);
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.topic_id', $topic_id);
    $query = $this->db->get(TBL_COURSE_TOPICS_DOCUMENT);
    $rowcount = $query->num_rows();
    return $rowcount;
    
}

public function getBookscount($topic_id,$course_id){
    $this->db->select('*');
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.isDeleted', 0);
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.module_name', 'books');
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.course_id', $course_id);
    $this->db->where(TBL_COURSE_TOPICS_DOCUMENT.'.topic_id', $topic_id);
    $query = $this->db->get(TBL_COURSE_TOPICS_DOCUMENT);
    $rowcount = $query->num_rows();
    return $rowcount;
    
}


  public function gettimetableCount($params,$courseid){

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


  public function gettimetabledata($params,$courseid){

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

             $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewtimetablelisting?time_table_id=".$value['id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/view_doc.png' alt='Viw TimeTable' title='Viw TimeTable'></a> | ";
             $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_topic_timetable' time-table-id='".$value['id']."' course_id='".$value['course_id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Time Table' title='Delete Time Table'></a>"; 
            
            $counter++; 
        }
    }

    return $data;

  }


  public function insertDocumentData($data){
    if($this->db->insert(TBL_COURSE_TOPICS_DOCUMENT, $data)) {
        return $this->db->insert_id();;
    } else {
        return FALSE;
    }

  }

  public function getFetchtopicdocumentCount($params,$topic_id,$course_id,$type){
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

  public function getFetchtopicdocumentData($params,$topic_id,$course_id,$type){

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
             $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_topic_document' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Topic Document' title='Delete Topic Document'></a>"; 
            
            $counter++; 
        }
    }

    return $data;

  }


  public function checkquniqeTimetable($form_date, $to_date ,$course_id_post){

    $from_date = date('Y-m-d', strtotime($form_date));
    $to_date = date('Y-m-d', strtotime($to_date));

    $this->db->select('*');
    $this->db->where(TBL_TIMETABLE.'.isDeleted', 0);
    $this->db->where(TBL_TIMETABLE.'.course_id', $course_id_post);
    $this->db->where(TBL_TIMETABLE.'.from_date', $from_date);
    $this->db->where(TBL_TIMETABLE.'.to_date', $to_date);
    $query = $this->db->get(TBL_TIMETABLE);
    $rowcount = $query->num_rows();
    return $rowcount;

  }

  public function saveTimetable($id,$data){

        if($this->db->insert(TBL_TIMETABLE, $data)) {
            return $this->db->insert_id();;
        } else {
            return FALSE;
        }
  }


  public function insertBlukTimetabledata($timetabledata){

    if($this->db->insert(TBL_TIMETABLE_TRANSECTIONS, $timetabledata)) {
        return $this->db->insert_id();;
    } else {
        return FALSE;
    }

  }

  public function delete_timetable($course_id,$timetable_id){

        $this->db->where('course_id', $course_id);
        $this->db->where('id', $timetable_id);
        $this->db->delete(TBL_TIMETABLE);
        return true;
       
  }


  public function delete_timetable_topic($course_id,$timetable_id){

    $this->db->where('course_id', $course_id);
    $this->db->where('time_table_id', $timetable_id);
    $this->db->delete(TBL_TIMETABLE_TRANSECTIONS);
    return true;
   
}


  public function getTimetableInfo($course_id,$timetable_id){

    $this->db->select('*');
    $this->db->from(TBL_TIMETABLE);
    $this->db->where(TBL_TIMETABLE.'.isDeleted', 0);
    //$this->db->where('tbl_enquiry.payment_status', 1);
    $this->db->where(TBL_TIMETABLE.'.id', $timetable_id);
    $this->db->where(TBL_TIMETABLE.'.course_id', $course_id);
    $query = $this->db->get();
    return $query->result();

  }

  public function gettimetabletopiclistingCount($params,$time_table_id,$course_id){

    $this->db->select('*');
    $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_TIMETABLE_TRANSECTIONS.'.trainer_id');
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

  public function gettimetabletopiclistingdata($params,$time_table_id,$course_id){
    
    $roleText = $this->session->userdata('roleText');
    $this->db->select('*,a.name as backup_trainer,'.TBL_USER.'.name as real_trainer,'.TBL_TIMETABLE_TRANSECTIONS.'.id as timetableid');
    $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_TIMETABLE_TRANSECTIONS.'.trainer_id');
    $this->db->join(TBL_USER.' as a', 'a.userId = '.TBL_TIMETABLE_TRANSECTIONS.'.backup_trainer','left');
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
             $data[$counter]['trainer'] =  $value['real_trainer'];

             $data[$counter]['backup_trainer'] =  $value['backup_trainer'];
             $data[$counter]['action'] = '';

             if($value['iscancle']==1){

                $data[$counter]['action'] = 'Cancelled';

              //  $data[$counter]['action'] .= "  <a style='cursor: pointer;' class='activate_topic_class' course_id=".$value['course_id']."' time_table_id='".$value['time_table_id']."' data-id='".$value['timetableid']."'><img width='20' src=".ICONPATH."/activate.png alt='Activate Topic class' title='Activate Topic class'></a>"; 

             }else{

                if($roleText!='Trainer'){
                    $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addtopiclinksforonlineattendant?id=".$value['id']."&time_table_id=".$value['time_table_id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/attachment.png' alt='Add Online Meeting Link' title='Add Online Meeting Link'></a>  ";
            
                    $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addbackuptrainer?id=".$value['id']."&time_table_id=".$value['time_table_id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/user.png' alt='Add Backup Trainer' title='Add Backup Trainer'></a>  ";
       
                    $data[$counter]['action'] .= "<a style='cursor: pointer;' class='cancle_class' course_id=".$value['course_id']." time_table_id='".$value['time_table_id']."' data-id='".$value['timetableid']."'><img width='20' src=".ICONPATH."/disable.png alt='Add Links' title='Cancel Topic class'></a>"; 
       
                }

            }
            
            $counter++; 
        }
    }

    return $data;
  }


  public function getAllCourseInfo()
  {
      $this->db->select('BaseTbl.courseId , BaseTbl.course_name');
      $this->db->from('tbl_course as BaseTbl');
      $this->db->where('BaseTbl.isDeleted', 0);
      $this->db->order_by('BaseTbl.courseId', 'DESC');

      $query = $this->db->get();
      
      return $query->result();
  }


  public function getTopicinfo($course_id,$timetable_id,$time_table_transection_id){
    $this->db->select('*');
    $this->db->from(TBL_TIMETABLE_TRANSECTIONS);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.isDeleted', 0);
    //$this->db->where('tbl_enquiry.payment_status', 1);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.id', $time_table_transection_id);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.course_id', $course_id);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.time_table_id', $timetable_id);
    $query = $this->db->get();
    return $query->result();
  }


  public function gettopicmeetinglinkCount($params,$time_table_id,$course_id,$time_table_transection_id){

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

  public function gettopicmeetinglinkData($params,$time_table_id,$course_id,$time_table_transection_id){
   
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
                $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_topic_meeting_document' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Topic Meeting Link' title='Delete Topic Meeting Link'></a>"; 
                $counter++; 
            }
        }

        return $data;

  }

  public function saveTimetablemeetinglinkdata($id,$data){

    if($this->db->insert(TBL_TOPIC_MEETING_LINK, $data)) {
        return $this->db->insert_id();;
    } else {
        return FALSE;
    }

  }


  public function getAllTrainerInfo(){

    $this->db->select('*');
    $this->db->from(TBL_USER);
    $this->db->join(TBL_ROLES, TBL_USER.'.roleId = '.TBL_ROLES.'.roleId');
    $this->db->where(TBL_USER.'.isDeleted', 0);
    $this->db->where(TBL_ROLES.'.role', 'Trainer');
    $query = $this->db->get();
    return $query->result();

  }


  public function getTrianeridby($trainer_name){
    $this->db->select('*');
    $this->db->from(TBL_USER);
    $this->db->join(TBL_ROLES, TBL_USER.'.roleId = '.TBL_ROLES.'.roleId');
    $this->db->where(TBL_USER.'.isDeleted', 0);
    $this->db->where(TBL_USER.'.name', $trainer_name);
    $this->db->where(TBL_ROLES.'.role', 'Trainer');
    $query = $this->db->get();
    return $query->result();
  }


  public function getbackuptrainerfortopics($trainer_id){
    $this->db->select('userId,name,mobile');
    $this->db->from(TBL_USER);
    $this->db->join(TBL_ROLES, TBL_USER.'.roleId = '.TBL_ROLES.'.roleId');
    $this->db->where(TBL_USER.'.isDeleted', 0);
    $this->db->where(TBL_USER.'.userId!=',$trainer_id);
    $this->db->where(TBL_ROLES.'.role', 'Trainer');
    $query = $this->db->get();
    return $query->result();


  }


 public function updateBackuptrianerdata($course_id_form,$time_table_id,$time_table_transection_id,$backup_trainer){

    $data = array('backup_trainer'=>$backup_trainer);
    $this->db->where('course_id', $course_id_form);
    $this->db->where('time_table_id', $time_table_id);
    $this->db->where('id', $time_table_transection_id);
    if($this->db->update(TBL_TIMETABLE_TRANSECTIONS, $data)){
        return TRUE;
    } else {
        return FALSE;
    }

 }

 public function cancletimetableclass($dataid,$time_table_id,$course_id){

    $data = array('iscancle'=>1);
    $this->db->where('course_id', $course_id);
    $this->db->where('time_table_id', $time_table_id);
    $this->db->where('id', $dataid);
    if($this->db->update(TBL_TIMETABLE_TRANSECTIONS, $data)){
        return TRUE;
    } else {
        return FALSE;
    }
 }

 public function getstudentdataforcanclenotification($dataid,$time_table_id,$course_id){

    $this->db->select(TBL_USER.'.name,'.TBL_USER.'.mobile');
    $this->db->where(TBL_ENQUIRY.".enq_course_id LIKE '%".$course_id."%'");
    $this->db->join(TBL_USERS_ENQUIRES, TBL_USERS_ENQUIRES.'.enq_id = '.TBL_ENQUIRY.'.enq_id');
    $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_USERS_ENQUIRES.'.user_id');
    $this->db->where(TBL_USER.'.user_flag', 'student');
    $query = $this->db->get(TBL_ENQUIRY);
    $fetch_result = $query->result_array();

    return $fetch_result;
 }


 public function activstetimetableclass($dataid,$time_table_id,$course_id){

    $data = array('iscancle'=>0);
    $this->db->where('course_id', $course_id);
    $this->db->where('time_table_id', $time_table_id);
    $this->db->where('id', $dataid);
    if($this->db->update(TBL_TIMETABLE_TRANSECTIONS, $data)){
        return TRUE;
    } else {
        return FALSE;
    }


 }

 public function getCoursesyllabusCount($params,$course_id){
    $this->db->select('*');
    $this->db->where(TBL_COURSE_SYLLABUS.'.course_id', $course_id);
    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_COURSE_SYLLABUS.".doc_url LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_COURSE_SYLLABUS.".doc_name LIKE '%".$params['search']['value']."%')");
    }
    $this->db->where(TBL_COURSE_SYLLABUS.'.isDeleted', 0);
    $this->db->order_by(TBL_COURSE_SYLLABUS.'.id', 'DESC');
    $query = $this->db->get(TBL_COURSE_SYLLABUS);
    $rowcount = $query->num_rows();
    return $rowcount;
 }


 public function getCoursesyllabusData($params,$course_id){
    
    $this->db->select('*');
    $this->db->where(TBL_COURSE_SYLLABUS.'.course_id', $course_id);
    $this->db->where(TBL_COURSE_SYLLABUS.'.isDeleted', 0);

    if($params['search']['value'] != "") 
    {
        $this->db->where("(".TBL_COURSE_SYLLABUS.".doc_url LIKE '%".$params['search']['value']."%'");
        $this->db->or_where(TBL_COURSE_SYLLABUS.".doc_name LIKE '%".$params['search']['value']."%')");
    }

    $this->db->order_by(TBL_COURSE_SYLLABUS.'.id', 'DESC');
    $this->db->limit($params['length'],$params['start']);
    $query = $this->db->get(TBL_COURSE_SYLLABUS);
    $fetch_result = $query->result_array();
    $data = array();
    $counter = 0;
    if(count($fetch_result) > 0)
    {
        foreach ($fetch_result as $key => $value)
        {
             $data[$counter]['doc_name'] = $value['doc_name'];
             $data[$counter]['doc_url'] = '<a href="'.$value['doc_url'].'" target="_blank">'.$value['doc_url'].'</a>';
             $data[$counter]['action'] = '';
             $data[$counter]['action'] .= "<a style='cursor: pointer;' class='deletecourseSyllbus' syllbus_id='".$value['id']."' course_id='".$value['course_id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Time Table' title='Delete Time Table'></a>";             
            $counter++; 
        }
    }

    return $data;
 }


 public function uploadCoursesayllabus($data){
    if($this->db->insert(TBL_COURSE_SYLLABUS, $data)) {
        return $this->db->insert_id();;
    } else {
        return FALSE;
    }
  }

  public function checkifdocnamealredayexits($course_id,$doc_name){

    $this->db->select('id,course_id,doc_name,doc_url');
    $this->db->where(TBL_COURSE_SYLLABUS.'.isDeleted', 0);
    $this->db->where(TBL_COURSE_SYLLABUS.'.doc_name', $doc_name);
    $this->db->where(TBL_COURSE_SYLLABUS.'.course_id', $course_id);
    $query = $this->db->get(TBL_COURSE_SYLLABUS);
    $rowcount = $query->num_rows();
    return $rowcount;
  }
  

  public function getcouese_details_for_whatsapp_sms($data_id,$time_table_id,$course_id){

    $this->db->select(TBL_COURSE.'.course_name,'.TBL_TIMETABLE_TRANSECTIONS.'.topic,'.TBL_TIMETABLE_TRANSECTIONS.'.date as timetabledate');
    $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId = '.TBL_TIMETABLE_TRANSECTIONS.'.course_id');
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.time_table_id', $time_table_id);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.id', $data_id);
    $this->db->where(TBL_TIMETABLE_TRANSECTIONS.'.course_id', $course_id);
    $query = $this->db->get(TBL_TIMETABLE_TRANSECTIONS);
    $row_array = $query->row_array();
    return $row_array;
  }

}

?>