<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model
{

    /*get Authtoken*/
    public function getAuthtoken($data) {
		
		try{
            extract($data);

            $this->db->select('BaseTbl.isDeleted');
            $this->db->from('tbl_users as BaseTbl');
            $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId'); 
            $likeCriteria = "(BaseTbl.email  LIKE '%".$username."%' OR  BaseTbl.username  LIKE '%".$username."%' OR  BaseTbl.mobile  LIKE '%".$username."%')";
            $this->db->where($likeCriteria);
            $this->db->where('BaseTbl.isDeleted', 0);
            $this->db->limit(1);
            $query = $this->db->get();
            $user_data = $query->row();

            if($user_data){
                if($user_data->isDeleted == 0){
                    $this->db->select('BaseTbl.enq_id,BaseTbl.userId, BaseTbl.password, BaseTbl.email ,BaseTbl.name,BaseTbl.status,BaseTbl.roleId, Roles.role,Roles.access,BaseTbl.profile_pic,BaseTbl.username,BaseTbl.password,BaseTbl.mobile,BaseTbl.user_flag');
                    $this->db->from('tbl_users as BaseTbl');
                    $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId'); 
                    $likeCriteria = "(BaseTbl.email  LIKE '%".$username."%' OR  BaseTbl.username  LIKE '%".$username."%' OR  BaseTbl.mobile  LIKE '%".$username."%')";
                    $this->db->where($likeCriteria);
                    $this->db->limit(1);
                    $query = $this->db->get();
                    $get_actual_user_data = $query->row();

                    if(trim($password)== base64_decode($get_actual_user_data->password)){
                        $authtoken = uniqueAlphaNumericString(30); //30 digit authtoken
                        $this->db->where('userId',$get_actual_user_data->userId);
                        $this->db->update(TBL_USER, array(
                            'authtoken' => $authtoken,
                            'updatedDtm' => DATEANDTIME
                        ));
                        return array('authtoken' => $authtoken,'id' => $get_actual_user_data->userId,'name' => $get_actual_user_data->name,'email' => $get_actual_user_data->email, 'username' => $get_actual_user_data->username,'mobile_no' => $get_actual_user_data->mobile,'user_flag' =>  $get_actual_user_data->user_flag);
                    } else {
                        return "password mismatch";
                    }
                }else{
                    return "account disable";
                }
            }else{
                return "Username not available";
            }

        }catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /*get All Enquiry List*/
    public function getEnquiryData($data){

        try{
            //extract($data);

            $this->db->select(TBL_ENQUIRY.'.enq_id as enq_id,'.TBL_ADMISSION.'.enq_id as admission_status,'.TBL_ENQUIRY.'.enq_number,'.TBL_USER.'.name as counseller,'.TBL_ENQUIRY.'.enq_fullname,'.TBL_ENQUIRY.'.enq_mobile,'.TBL_ENQUIRY.'.enq_email,'.TBL_ENQUIRY.'.doctor_non_doctor,'.TBL_ENQUIRY.'.enq_course_id');
            // $this->db->join(TBL_COURSE_TYPE, TBL_COURSE_TYPE.'.ct_id = '.TBL_COURSE.'.course_type_id','left');
            $this->db->join(TBL_ADMISSION, TBL_ADMISSION.'.enq_id = '.TBL_ENQUIRY.'.enq_id','left');
            $this->db->join(TBL_USER, TBL_USER.'.userId = '.TBL_ENQUIRY.'.counsellor_id');
            $this->db->where(TBL_ENQUIRY.'.isDeleted', 0);
            $this->db->order_by(TBL_ENQUIRY.'.enq_id', 'DESC');
            $query = $this->db->get(TBL_ENQUIRY);
            $fetch_result = $query->result_array();

            $data = array();
            $counter = 0;
            if(count($fetch_result) > 0)
            {
                foreach ($fetch_result as $key => $value)
                {

                 $data[$counter]['enq_number'] = $value['enq_number'];
                 $data[$counter]['enq_date'] = date('d-m-Y', strtotime($value['enq_date']));
                 $data[$counter]['enq_fullname'] = $value['enq_fullname'];
                 $data[$counter]['enq_mobile'] = $value['enq_mobile'];
                 $data[$counter]['enq_email'] = $value['enq_email'];

                 if($value['payment_status']=='0'){
                    $data[$counter]['status'] = 'In Follow up';
                 }else if($value['payment_status']=='1'){
                    $data[$counter]['status'] = 'Admitted';
                 }else{
                    $data[$counter]['status'] = 'In Follow up';
                 }

                 $course_ids    =   explode(',', $value['enq_course_id']);
             
                 $total_fees = 0;
                 $course_name = '';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                
                        $get_course_fees =  $this->getCourseInfo($id);
                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees[0]->course_total_fees;
                            $course_name .= $i.'-'.$get_course_fees[0]->course_name.',';  
                            $i++;  

                        }else{

                            $total_fees = '';
                            $course_name = '';  
                            $i++;  
                        }
                      
                    }
                 $all_course_name = trim($course_name, ', '); 

                 $data[$counter]['all_course_name'] = $all_course_name ;
                 $data[$counter]['counsellor_name'] = $value['counseller'];

                 if($value['cancle_status']=='1'){
                       $data[$counter]['status'] = 'Cancelled';
                 }else{
                    if(!empty($value['admissionexits'])){
                        $data[$counter]['status'] = 'Admitted';
                    }else{
                        $data[$counter]['status'] = 'In Follow up';
                    }
                 }

                $counter++; 
            }

            return $data;
        }

        }catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /*get All Course List*/
    public function getCourseData($data){
        $this->db->select('BaseTbl.courseId , BaseTbl.course_name, BaseTbl.course_desc, BaseTbl.course_date,BaseTbl.createdDtm, BaseTbl.course_fees, Type.ct_name,BaseTbl.course_total_fees');
        $this->db->from('tbl_course as BaseTbl');
        $this->db->join('tbl_course_type as Type', 'Type.ct_id = BaseTbl.course_type_id','left');
       
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.courseId', 'desc');
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;      
    }

    /*get All Course List*/
    public function getCourseTypedata($data){
        $this->db->select('BaseTbl.ct_id , BaseTbl.ct_name');
        $this->db->from('tbl_course_type as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.ct_id', 'desc');
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;      
    }




     
     /* Sub Query Add On List*/
    public function getCourseInfo($id){
        $this->db->select('courseId,course_total_fees,course_name');
        $this->db->from('tbl_course');
        $this->db->where('tbl_course.isDeleted', 0);
        //$this->db->where('tbl_enquiry.payment_status', 1);
        $this->db->where('tbl_course.courseId', $id);
        $query = $this->db->get();
        return $query->result();
    }

}

?>