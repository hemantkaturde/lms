<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Database extends CI_Model
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
}

?>