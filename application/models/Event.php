<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Event extends CI_Model{ 
    function __construct() { 
        // Set table name 
        $this->table = 'events'; 
    } 
     

    // for get all event date in one month
	function getDateEvent($year, $month){
		$year  = ($month < 10 && strlen($month) == 1) ? "$year-0$month" : "$year-$month";
		$query = $this->db->select('event_date, total_events')->from('events')->like('event_date', $year, 'after')->get();
		if($query->num_rows() > 0){
			$data = array();
			foreach($query->result_array() as $row){
				$ddata = explode('-',$row['event_date']);
				$data[(int) end($ddata)] = $row['total_events'];
			}
			return $data;
		}else{
			return false;
		}
	}

    // get event detail for selected date
	function getEvent($year, $month, $day){
		$day   = ($day < 10 && strlen($day) == 1)? "0$day" : $day;
		$year  = ($month < 10 && strlen($month) == 1) ? "$year-0$month-$day" : "$year-$month-$day";
		$query = $this->db->select('idevent as id, event_time as time, event')->order_by('event_time')->get_where('event_detail', array('event_date' => $year));
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return null;
		}
	}
   


}