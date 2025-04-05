<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Event extends CI_Model{ 
    function __construct() { 
        // Set table name 
        $this->table = 'events'; 
    } 
     
    // for get all event date in one month
	function getDateEvent($year, $month){
		$year  = ($month < 10 && strlen($month) == 1) ? "$year-0$month" : "$year-$month";
		$query = $this->db->select(TBL_TIMETABLE_TRANSECTIONS.'.date as event_date, count(time_table_id) as total_events ')
		                     ->from(TBL_TIMETABLE)
							 ->join(TBL_TIMETABLE_TRANSECTIONS,TBL_TIMETABLE.'.id = '.TBL_TIMETABLE_TRANSECTIONS.'.time_table_id')
							 ->like(TBL_TIMETABLE_TRANSECTIONS.'.date', $year, 'after')
							 ->group_by(TBL_TIMETABLE_TRANSECTIONS.'.date')->get();
	
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
		//$query = $this->db->select('idevent as id, event_time as time, event')->order_by('event_time')->get_where(TBL_TIMETABLE_TRANSECTIONS, array('event_date' => $year));

		$query = $this->db->select(TBL_TIMETABLE_TRANSECTIONS.'.id as id,'.TBL_TIMETABLE_TRANSECTIONS.'.timings as time,'.TBL_TIMETABLE_TRANSECTIONS.'.topic as event,'.TBL_USER.'.name as trainer,a.name as backup_trainername,'.TBL_TOPIC_MEETING_LINK.'.link_url as topic_link')
		                     ->from(TBL_TIMETABLE)
							 ->join(TBL_TIMETABLE_TRANSECTIONS,TBL_TIMETABLE.'.id = '.TBL_TIMETABLE_TRANSECTIONS.'.time_table_id')
							 ->join(TBL_TOPIC_MEETING_LINK,TBL_TOPIC_MEETING_LINK.'.time_table_transection_id = '.TBL_TIMETABLE_TRANSECTIONS.'.id','left')
							 ->join(TBL_USER,TBL_USER.'.userId  = '.TBL_TIMETABLE_TRANSECTIONS.'.trainer_id')
							 ->join(TBL_USER.' as a','a.userId  = '.TBL_TIMETABLE_TRANSECTIONS.'.backup_trainer','left')
							 ->join(TBL_ROLES,TBL_ROLES.'.roleId = '.TBL_USER.'.roleId')
							 ->where(TBL_TIMETABLE_TRANSECTIONS.'.date',$year)
							 ->where(TBL_ROLES.'.role','Trainer')
							 ->get();

		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return null;
		}
	}
   


}