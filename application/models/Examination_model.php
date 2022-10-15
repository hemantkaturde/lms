<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Examination_model extends CI_Model
{
    public $CI="";
    public function __construct(){

        $this->CI =& get_instance();
    }


    
    function getexaminationCount($params)
    {
        $this->db->select('*');
        $this->db->from('tbl_examination as BaseTbl');
        $this->db->join('tbl_course as course', 'course.courseId = BaseTbl.course_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(course.course_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where("BaseTbl.exam_title LIKE '%".$params['search']['value']."%'");
            $this->db->or_where("BaseTbl.exam_time LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.id', 'desc');
        $query = $this->db->get();
        
        return $query->num_rows();
    }


    function getexaminationdata($params)
    {
        $this->db->select('*');
        $this->db->from('tbl_examination as BaseTbl');
        $this->db->join('tbl_course as course', 'course.courseId = BaseTbl.course_id');
        if($params['search']['value'] != "") 
        {
            $this->db->where("(course.course_name LIKE '%".$params['search']['value']."%'");
            $this->db->or_where("BaseTbl.exam_title LIKE '%".$params['search']['value']."%'");
            $this->db->or_where("BaseTbl.exam_time LIKE '%".$params['search']['value']."%')");
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.id', 'DESC');
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
                    $exam_status ='Active';
                 }else{
                    $exam_status ='In-Active';
                 }

                 $data[$counter]['course_name'] = $value['course_name'];
                 $data[$counter]['exam_title'] = $value['exam_title'];
                 $data[$counter]['exam_time'] = $value['exam_time'];
                 $data[$counter]['exam_status'] = $exam_status;
                 $data[$counter]['action'] = '';

                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='edit_examination' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/edit.png alt='Edit Course' title='Edit Course'></a> | ";
                 $data[$counter]['action'] .= "<a href='".ADMIN_PATH."viewquestionpaper/".$value['id']."' style='cursor: pointer;'><img width='20' src='".ICONPATH."/examination.png' alt='View/ADD Question Paper' title='View/ADD Question Paper'></a> | ";
                 $data[$counter]['action'] .= "<a style='cursor: pointer;' class='delete_examination' data-id='".$value['id']."'><img width='20' src=".ICONPATH."/delete.png alt='Delete Examination' title='Delete Examination'></a> "; 
              
                 $counter++; 
            }
        }

        return $data;
    }

    public function checkquniqeExamination($course_name,$examination_title){

        $this->db->select('exam_title');
        $this->db->from(TBL_EXAMINATION);
        $this->db->where('isDeleted', 0);
        $this->db->where('exam_title', $examination_title);
        $this->db->where('course_id', $course_name);
        $query = $this->db->get();
        return $query->result();
    }


    public function saveExaminationedata($id,$data){

        if($id != '') {
            $this->db->where('id', $id);
            if($this->db->update(TBL_EXAMINATION, $data)){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if($this->db->insert(TBL_EXAMINATION, $data)) {
                return $this->db->insert_id();;
            } else {
                return FALSE;
            }
        }
    }


    public function getSingleExaminationInfo($exam_id)
    {
            $this->db->select('*,'.TBL_EXAMINATION.'.course_id as c_id');
            $this->db->from(TBL_EXAMINATION);
            $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId ='.TBL_EXAMINATION.'.course_id');
            $this->db->where(TBL_EXAMINATION.'.isDeleted', 0);
            $this->db->where(TBL_EXAMINATION.'.id', $exam_id);
            $query = $this->db->get();
            return $query->result();
    }


    public function checkquniqeExaminationupdate($course_name,$examination_title){
        $this->db->select('*');
        $this->db->from(TBL_EXAMINATION);
        $this->db->where(TBL_EXAMINATION.'.isDeleted', 0);
        $this->db->where(TBL_EXAMINATION.'.course_id', $course_name);
        $this->db->where(TBL_EXAMINATION.'.exam_title', $examination_title);
        $query = $this->db->get();
        return $query->result();


    }

    public function checkquniqeExaminationwithidupdate($id,$course_name,$examination_title){

        $this->db->select('*');
        $this->db->from(TBL_EXAMINATION);
        $this->db->where(TBL_EXAMINATION.'.isDeleted', 0);
        $this->db->where(TBL_EXAMINATION.'.id', $id);
        $this->db->where(TBL_EXAMINATION.'.course_id', $course_name);
        $this->db->where(TBL_EXAMINATION.'.exam_title', $examination_title);
        $query = $this->db->get();
        return $query->result();

    }


    function data_update($table='',$arr='',$field='',$value=''){
        // $this->CI->db->where($field,$value);
        // return $this->CI->db->update($table,$arr);
        $this->db->where($field, $value);
        return  $this->db->delete($table);
    }


    public function getExaminationinfo($id){

        $this->db->select('*');
        $this->db->from(TBL_EXAMINATION);
        $this->db->join(TBL_COURSE, TBL_COURSE.'.courseId ='.TBL_EXAMINATION.'.course_id');
        $this->db->where(TBL_EXAMINATION.'.isDeleted', 0);
        $this->db->where(TBL_EXAMINATION.'.id', $id);
        $query = $this->db->get();
        return $query->result();

    }

    public function insertBlukquestionpaperdata($timetabledata){
        if($this->db->insert(TBL_QUESTION_PAPER, $timetabledata)) {
            return $this->db->insert_id();;
        } else {
            return FALSE;
        }
    
      }

    public function getquestionPaperListMCQInfo($course_id,$examination_id){
        
        $this->db->select('*');
        $this->db->from(TBL_QUESTION_PAPER);
        //$this->db->join(TBL_COURSE, TBL_COURSE.'.courseId ='.TBL_QUESTION_PAPER.'.course_id');
        // $this->db->where(TBL_QUESTION_PAPER.'.isDeleted', 0);
        $this->db->where(TBL_QUESTION_PAPER.'.examination_id', $examination_id);
        $this->db->where(TBL_QUESTION_PAPER.'.examination_id', $examination_id);
        $this->db->where(TBL_QUESTION_PAPER.'.question_type', 'MCQ');
        $query = $this->db->get();
        return $query->result();

    } 


    public function getquestionPaperListWRITTENInfo($course_id,$examination_id){
        
        $this->db->select('*');
        $this->db->from(TBL_QUESTION_PAPER);
        //$this->db->join(TBL_COURSE, TBL_COURSE.'.courseId ='.TBL_QUESTION_PAPER.'.course_id');
        // $this->db->where(TBL_QUESTION_PAPER.'.isDeleted', 0);
        $this->db->where(TBL_QUESTION_PAPER.'.examination_id', $examination_id);
        $this->db->where(TBL_QUESTION_PAPER.'.examination_id', $examination_id);
        $this->db->where(TBL_QUESTION_PAPER.'.question_type', 'WRITTEN');
        $query = $this->db->get();
        return $query->result();

    } 


    

    public function getquestionPaperListMATCHPAIRInfo($course_id,$examination_id){
        
        $this->db->select('*');
        $this->db->from(TBL_QUESTION_PAPER);
        //$this->db->join(TBL_COURSE, TBL_COURSE.'.courseId ='.TBL_QUESTION_PAPER.'.course_id');
        // $this->db->where(TBL_QUESTION_PAPER.'.isDeleted', 0);
        $this->db->where(TBL_QUESTION_PAPER.'.examination_id', $examination_id);
        $this->db->where(TBL_QUESTION_PAPER.'.examination_id', $examination_id);
        $this->db->where(TBL_QUESTION_PAPER.'.question_type', 'MATCH_PAIR');
        $query = $this->db->get();
        return $query->result();

    } 


}

?>