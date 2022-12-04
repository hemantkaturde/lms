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
                 $data[$counter]['action'] .= ""; 
                $counter++; 
            }
        }
        return $data;
    }
}

?>