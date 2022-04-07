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
}

?>