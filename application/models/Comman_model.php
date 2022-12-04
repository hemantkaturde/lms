<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Comman_model extends CI_Model
{
        public function selectAllStates($country_id,$state_id = '')
        {
            $this->db->select('*');
            $this->db->where('country_id', $country_id);
            $this->db->order_by('name','ASC');
            $query_result = $this->db->get(TBL_STATES)->result_array();
            if($state_id != '') {
                foreach($query_result as $key => $value) {
                    if($value['id'] == $state_id) {
                        $query_result[$key]['selected'] = 'selected';
                    } else {
                        $query_result[$key]['selected'] = '';
                    }
                }
            }
            return $query_result;
        }

        public function selectAllCities($state_id,$city_id = '')
        {
            $this->db->select('*');
            $this->db->where('state_id', $state_id);
            $this->db->order_by('name','ASC');
            $query_result = $this->db->get(TBL_CITIES)->result_array();
            if($city_id != '') {
                foreach($query_result as $key => $value) {
                    if($value['id'] == $city_id) {
                        $query_result[$key]['selected'] = 'selected';
                    } else {
                        $query_result[$key]['selected'] = '';
                    }
                }
            }
            return $query_result;
        }


        public function selectAllCitiesForedit($state_id,$city_id = '')
        {
            $this->db->select('*');
           // $this->db->where('state_id', $state_id);
            $this->db->order_by('name','ASC');
            $query_result = $this->db->get(TBL_CITIES)->result_array();
            if($city_id != '') {
                foreach($query_result as $key => $value) {
                    if($value['id'] == $city_id) {
                        $query_result[$key]['selected'] = 'selected';
                    } else {
                        $query_result[$key]['selected'] = '';
                    }
                }
            }
            return $query_result;
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



}

?>