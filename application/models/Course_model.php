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

        $this->CI->db->where($field,$value);
        return $this->CI->db->update($table,$arr);
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
            $this->db->select('BaseTbl.courseId , BaseTbl.course_name, BaseTbl.course_desc, BaseTbl.course_date, BaseTbl.course_fees, BaseTbl.course_cert_cost, BaseTbl.course_onetime_adm_fees, BaseTbl.course_kit_cost, BaseTbl.course_remark, BaseTbl.course_type_id, BaseTbl.course_books');
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
                $this->db->or_where(TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%')");
            }
            $this->db->where(TBL_COURSE.'.isDeleted', 1);
            $query = $this->db->get(TBL_COURSE);
            $rowcount = $query->num_rows();
            return $rowcount;

        }

        public function getCoursedata($params){
            $this->db->select('*');
            $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
            if($params['search']['value'] != "") 
            {
                $this->db->where("(".TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_COURSE_TYPE.".ct_name LIKE '%".$params['search']['value']."%'");
                $this->db->or_where(TBL_COURSE.".course_name LIKE '%".$params['search']['value']."%')");
            }
            $this->db->where(TBL_COURSE.'.isDeleted', 1);
            $this->db->limit($params['length'],$params['start']);
            $query = $this->db->get(TBL_COURSE);
            $fetch_result = $query->result_array();
            $data = array();
            $counter = 0;
            if(count($fetch_result) > 0)
            {
                foreach ($fetch_result as $key => $value)
                {

                    //  $data[$counter]['row-index'] = 'row_'.$value['courseId'];
                     $data[$counter]['course_name'] = $value['course_name'];
                     $data[$counter]['course_type'] = $value['ct_name'];
                    //  $data[$counter]['course_desc'] = $value['course_desc'];
                     $data[$counter]['course_date'] = $value['course_date'];
                    
                   
            
                    // $data[$counter]['equipment_name'] = $value['equipment_name'];
                    $data[$counter]['action'] = '';
                    // if(in_array("hospital/editequipment", $this->session->userdata('adminuser_access'))){
                        $data[$counter]['action'] .= "<a style='cursor: pointer;' href='".$value['course_date']."'><img width='20' src='".ADMIN_IMAGES_PATH."edit.png' alt='Edit Equipment' title='Edit Equipment'></a>&nbsp;";
                        // }
    
                    // if(in_array("hospital/deletequipment", $this->session->userdata('adminuser_access')))
                    // {
                        $data[$counter]['action'] .= "<a style='cursor: pointer;' class='deletequipments' rg-id=''><img width='20' src='' alt='Delete Equipment' title='Delete Equipment'></a>"; 
                    // }
    
                    $counter++; 
                }
            }

            return $data;
        }
}

?>