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
            $this->db->select('BaseTbl.*,BaseTbl.courseId , BaseTbl.course_name, BaseTbl.course_desc, BaseTbl.course_date, BaseTbl.course_fees, BaseTbl.course_cert_cost, BaseTbl.course_onetime_adm_fees, BaseTbl.course_kit_cost, BaseTbl.course_remark, BaseTbl.course_type_id, BaseTbl.course_books');
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
        Get course type
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
        Get Single course type
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
            $this->db->select('*');
            $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');

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
            $access = $this->session->userdata('access');
            $jsonstringtoArray = json_decode($access, true);
        
            $this->db->select('*');
            $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
            if($params['search']['value'] != "") 
            {
                $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_COURSE.".course_total_fees LIKE '%".$params['search']['value']."%')");
            }
            $this->db->where(TBL_COURSE.'.isDeleted', 0);
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
                     $data[$counter]['action'] = '';
                     //  $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course' data-id='".$value['courseId']."' data-toggle='modal' data-target='#editCourse'><img width='20' src=".ICONPATH."/edit.png alt='Edit Equipment' title='Edit Equipment'></a>&nbsp;";
                     if(in_array("coursedit", $jsonstringtoArray)){
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Course' title='Edit Course'></a> | ";
                     }

                     if(in_array("coursedelete", $jsonstringtoArray)){
                     $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_course' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Course' title='Delete Course'></a> | "; 
                     }
                     //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='add_links' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/add_links.png  alt='Delete Equipment' title='Delete Equipment'></a> &nbsp"; 
                     //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='view_document' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/view_doc.png alt='Delete Equipment' title='Delete Equipment'></a> &nbsp"; 

                     $data[$counter]['action'] .= "<a href='".ADMIN_PATH."addchapters/".$value['courseId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/books.png' alt='Add Topics' title='Add Topics'></a> | ";
                     $data[$counter]['action'] .= "<a href='".ADMIN_PATH."timetableListing/".$value['courseId']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/timetable.png' alt='Add Time Table' title='Add Time Table'></a>&nbsp;";

                     //$data[$counter]['action'] .= "<a style='cursor: pointer;' class='add_attachment' data-id='".$value['courseId']."'><img width='20' src=".ICONPATH."/attechment.png alt='Delete Course' title='Add Attachment'></a>"; 
                     
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
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course_type' data-id='".$value['ct_id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Course Type' title='Edit Course Type'></a> |";
                 }

                 if(in_array("coursetypedelete", $jsonstringtoArray)){
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_course_type' data-id='".$value['ct_id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Course Type' title='Delete Course Type'></a>"; 
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
            $this->db->or_where(TBL_COURSE_TOPICS.".ct_name LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE_TOPICS.'.isDeleted', 0);
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
            $this->db->or_where(TBL_COURSE_TOPICS.".ct_name LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where(TBL_COURSE_TOPICS.'.isDeleted', 0);
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
                 $data[$counter]['remark'] = $value['remark'];
                 $data[$counter]['action'] = '';
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course_topic' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Course Type' title='Edit Course Type'></a> |";
                //  $data[$counter]['action'] .= "<a style='cursor: pointer;' class='add_topic_attachment' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/attachment.png alt='Add Attachment' title='Add Attachment'></a> |";
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."topicattachmentListing?topic_id=".$value['id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/attachment.png' alt='Add Attachment' title='Add Attachment'></a> |";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_course_topic' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Course Type' title='Delete Course Type'></a>"; 
                
                $counter++; 
            }
        }

        return $data;
    }


    public function checkquniqecoursetopicname($topicname){
        $this->db->select('topic_name');
        $this->db->from(TBL_COURSE_TOPICS);
        $this->db->where('isDeleted', 0);
        $this->db->where('topic_name', $topicname);
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
             $data[$counter]['from_date'] = $value['from_date'];
             $data[$counter]['to_date'] = $value['to_date'];
             $data[$counter]['month_name'] = $value['month_name'];
             $data[$counter]['action'] = '';
             $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course_topic' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Course Type' title='Edit Course Type'></a> |";
             $data[$counter]['action'] .= "<a href='".ADMIN_PATH."topicattachmentListing?topic_id=".$value['id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/attachment.png' alt='Add Attachment' title='Add Attachment'></a> |";
             $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_course_topic' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Course Type' title='Delete Course Type'></a>"; 
            
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
        $this->db->or_where(TBL_COURSE_TOPICS_DOCUMENT.".module_name LIKE '%".$params['search']['value']."%')");
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
        $this->db->or_where(TBL_COURSE_TOPICS_DOCUMENT.".module_name LIKE '%".$params['search']['value']."%')");
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
             $data[$counter]['file_name_original'] = $value['file_name_original'];
             $data[$counter]['doc_type'] = $value['doc_type'];
             $data[$counter]['file_url'] = "<a  href=".$value['file_url']." target=_blank>".$value['file_url']."</a>";
             
             $data[$counter]['action'] = '';
             //  $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_course_topic' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Course Type' title='Edit Course Type'></a> |";
             //  $data[$counter]['action'] .= "<a style='cursor: pointer;' class='add_topic_attachment' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/attachment.png alt='Add Attachment' title='Add Attachment'></a> |";
             //  $data[$counter]['action'] .= "<a href='".ADMIN_PATH."topicattachmentListing?topic_id=".$value['id']."&course_id=".$value['course_id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/attachment.png' alt='Add Attachment' title='Add Attachment'></a> |";
             $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_topic_document' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Topic Document' title='Delete Topic Document'></a>"; 
            
            $counter++; 
        }
    }

    return $data;

  }


}

?>