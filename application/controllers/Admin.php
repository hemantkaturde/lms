<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Admin extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('login_model','examination_model','enquiry_model','user_model','student_model','course_model','database','admission_model','event'));
        $this->load->helper(array('form', 'url'));
        $this->load->library('calendar', $this->_setting());
        $this->load->library('form_validation');
        // $this->load->config('additional');
        // $this->load->library('mail');
        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();
        // isLoggedIn / Login control function /  This function used login control
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            redirect('login');
        }
        else
        {
            // isAdmin / Admin role control function / This function used admin role control
            // if($this->isAdmin() == TRUE)
            // {
            //     $this->accesslogincontrol();
            // }
        }
    }
	
    public function index($year = null, $month = null, $day = null)
    {
        $this->global['pageTitle'] = 'ADMIN : Home page';
        $year  = (empty($year) || !is_numeric($year))?  date('Y') :  $year;
		$month = (is_numeric($month) &&  $month > 0 && $month < 13)? $month : date('m');
		$day   = (is_numeric($day) &&  $day > 0 && $day < 31)?  $day : date('d');
		
		$date      = $this->event->getDateEvent($year, $month);
		$cur_event = $this->event->getEvent($year, $month, $day);
		$data      = array(
						'notes' => $this->calendar->generate($year, $month, $date),
						'year'  => $year, 
						'mon'   => $month,
						'month' => $this->_month($month),
						'day'   => $day,
						'events'=> $cur_event
					);

        $data['users'] = $this->user_model->userListingCount();
        $data['courses'] = $this->course_model->courseListingCount();
        $data['enquries'] = $this->enquiry_model->enquiryListingCount();
        $data['students'] = $this->student_model->studentListingCount();
        $data['admissions'] = $this->admission_model->admissionListingCount();
        $data['total_invoices'] = $this->enquiry_model->getTaxinvoicesCount(NULL);
       
        $data['total_revenue'] = $this->admission_model->total_revenue()[0]['total_revenue'];
        $data['total_pending'] = $this->admission_model->total_pending()[0]['total_pending'];
        $data['total_pending_amt'] = $data['total_pending'] - $data['total_revenue'];


        $data['total_revenue_add_on'] = $this->admission_model->total_revenue_add_on()[0]['total_revenue'];
        $data['total_discount'] = $this->admission_model->total_discount_add_on()[0]['total_discount'];
        $data['total_pending'] = $this->admission_model->total_pending_add_on()[0]['total_pending'];

        $data['total_pending_add_on'] =  $data['total_discount'] - $data['total_pending'];

        $data['total_pending_amt_add_on'] = $data['total_pending_add_on'] - $data['total_revenue_add_on'];

        if($this->session->userdata('roleText') =='Counsellor'){
            $userId = $this->session->userdata('userId');

            $where = ' where tbl_enquiry.enq_id="'.$userId.'"';

        }else{

            $where = '';
        }

    

        $query =  $this->db->query('SELECT tbl_admission.createdDtm AS `date`, COUNT(tbl_admission.id) as count FROM `tbl_admission` join tbl_enquiry ON tbl_enquiry.enq_id=tbl_admission.enq_id '.$where.' GROUP BY DATE(tbl_admission.createdDtm) ORDER BY tbl_admission.id ASC'); 
        $records = $query->result_array();

        $data1 = [];
        foreach($records as $row) {
         $data1[] = ['date' => $row['date'], 'count' =>$row['count']];
        }

    

        $data['chart_data'] = json_encode($data1);
        if($this->session->userdata('roleText') =='Trainer'){
            $userId = $this->session->userdata('userId');
            $data['getstudentqueryforttopicwisetriner'] = $this->student_model->trinerNoti($userId,trim($this->session->userdata('roleText')));
            $this->loadViews("trainer_dashbaord", $this->global, $data , NULL);
        }else if($this->session->userdata('roleText') =='Student'){

            $this->global['pageTitle'] = 'Student Dashbaord';
            $userId = $this->session->userdata('userId');


            $data['getaskaqueryRecord'] = $this->admission_model->getaskaqueryRecord($userId);
            $data['upcoming_class_links'] = $this->admission_model->upcoming_class_links($userId);
            $data['getStudentscourseattetendancedetails'] = $this->admission_model->getStudentscourseattetendancedetails($userId);
            $data['get_student_enquiry_id'] = $this->admission_model->getstudentEenquiryid($userId)[0];
            $data['followDataenquiry'] = $this->enquiry_model->getEnquiryInfo($data['get_student_enquiry_id']['enq_id']);
            $data['getEnquirypaymentInfo'] = $this->enquiry_model->getEnquirypaymentInfo($data['get_student_enquiry_id']['enq_id']);
            $data['gettotalpaidEnquirypaymentInfo'] = $this->enquiry_model->gettotalpaidEnquirypaymentInfo($data['get_student_enquiry_id']['enq_id']);

            $data['getadditionalcourseInfostudent'] = $this->enquiry_model->getadditionalInfo($data['get_student_enquiry_id']['enq_id']);

            $this->loadViews("student/student_dashboard", $this->global, $data , NULL);
        }else{
            $this->loadViews("dashboard", $this->global, $data , NULL);
        }
    }

     /**
     * This function is used to load the user list
     */
    function userListing()
    {          
            $this->global['pageTitle'] = 'User List';
            $data['role'] = $this->user_model->getUserRoles();
            $this->loadViews("master/users", $this->global, $data, NULL);
    }

    public function fetchUsers(){
        
        $params = $_REQUEST;
        $totalRecords = $this->user_model->getUserCount($params); 
        $queryRecords = $this->user_model->getUserdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

    function get_assets_for_user()
    {
        $data['roles'] = $this->user_model->getUserRoles();
        echo json_encode($data);
    }

    public function createUser()
    {
        $post_submit = $this->input->post();
        if(!empty($post_submit)){

            $createuser_response = array();

            if(!empty($_FILES['profile_photo']['name'])){

                $file = 'profile_'.$this->input->post('name').$_FILES['profile_photo']['name'];
                $filename = str_replace(' ','_',$file);

                $config['upload_path'] = 'uploads/profile_pic'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                $config['max_size'] = '1000'; // max_size in kb 
                $config['file_name'] = $filename; 
       
                // Load upload library 
                $this->load->library('upload',$config); 
        
                // File upload
                if($this->upload->do_upload('profile_photo')){ 
                   $profile_pic = $filename; 
                }else{
                    $profile_pic ='';
                }

            }else{
                $profile_pic = '';

            }

            $data = array(
                'name'      => $this->input->post('name'),
                'email'     => $this->input->post('email'),
                'mobile'    => $this->input->post('mobile'),
                'password'  => base64_encode($this->input->post('password')),
                'roleId'    => $this->input->post('role'),
                'user_flag' => $this->input->post('user_flag'),
                'profile_pic' => $profile_pic,
                'username'   => trim($this->input->post('username'))
            );

            $this->form_validation->set_rules('name', 'User Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|numeric');
            $this->form_validation->set_rules('role', 'Role', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');

            if($this->form_validation->run() == FALSE){
                $createuser_response['status'] = 'failure';
                $createuser_response['error'] = array('name'=>strip_tags(form_error('name')), 'email'=>strip_tags(form_error('email')), 'mobile'=>strip_tags(form_error('mobile')), 'role'=>strip_tags(form_error('role')),'password'=>strip_tags(form_error('password')),'confirm_password'=>strip_tags(form_error('confirm_password')));
            }else{

                /*check If course name is unique*/
                $check_uniqe =  $this->user_model->checkquniqeusername('',trim($this->input->post('name')),$this->input->post('user_flag'));
                $check_uniqe1 =  $this->user_model->checkEmailExists('',trim($this->input->post('email')),$this->input->post('user_flag'));
                $check_uniqe2 =  $this->user_model->checkquniqemobilenumber('',trim($this->input->post('mobile')),$this->input->post('user_flag'));


                if($check_uniqe){
                    $createuser_response['status'] = 'failure';
                    $createuser_response['error'] = array('name'=>'User Name Alreday Exits', 'email'=>'', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password' =>'');
                }
                else if($check_uniqe1){
                    $createuser_response['status'] = 'failure';
                    $createuser_response['error'] = array('name'=>'', 'email'=>'Email already Exist', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password' =>'');
                }
                else if($check_uniqe2){
                    $createuser_response['status'] = 'failure';
                    $createuser_response['error'] = array('name'=>'', 'email'=>'', 'mobile'=>'Mobile already Exist', 'role'=>'','password'=>'','confirm_password' =>'');
            
                }else{
                    $saveCoursedata = $this->user_model->saveUserdata('',$data);
                    if($saveCoursedata){
                        $createuser_response['status'] = 'success';
                        $createuser_response['error'] = array('name'=>'', 'email'=>'', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password'=>'');
                    }
                }
            }
    
            echo json_encode($createuser_response);
        }
    }

    public function updateUser($userId)
    {
        $post_submit = $this->input->post();
        if(!empty($post_submit)){

        
            if(!empty($_FILES['profile_photo1']['name'])){

                $file = 'profile_'.$this->input->post('name1').$_FILES['profile_photo1']['name'];
                $filename = str_replace(' ','_',$file);

                $config['upload_path'] = 'uploads/profile_pic'; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                $config['max_size'] = '1000000'; // max_size in kb 

                
                $config['file_name'] = $filename; 
       
                // Load upload library 
                $this->load->library('upload',$config); 
        
                // File upload
                if($this->upload->do_upload('profile_photo1')){ 
                   $profile_pic = $filename; 
                }else{
                    $profile_pic =trim($this->input->post('existing_img'));
                }

            }else{
                $profile_pic = trim($this->input->post('existing_img'));

            }

          

            $createuser_response = array();
            if(empty($this->input->post('password1')))
            {
                $data = array(
                    'name'      => $this->input->post('name1'),
                    'email'     => $this->input->post('email1'),
                    'mobile'    => $this->input->post('mobile1'),
                    'roleId'    => $this->input->post('role1'),
                    'user_flag' =>$this->input->post('user_flag1'),
                    'profile_pic' => $profile_pic,
                    'username'   => trim($this->input->post('username1'))
                );
            }else{
                $data = array(
                    'name'      => $this->input->post('name1'),
                    'email'     => $this->input->post('email1'),
                    'mobile'    => $this->input->post('mobile1'),
                    'password'  => base64_encode($this->input->post('password1')),
                    'roleId'    => $this->input->post('role1'),
                    'user_flag' =>$this->input->post('user_flag1'),
                    'profile_pic' => $profile_pic,
                    'username'   => trim($this->input->post('username1'))
                );
            }

            $this->form_validation->set_rules('name1', 'User Name', 'trim|required');
            $this->form_validation->set_rules('email1', 'Email', 'trim|required');
            $this->form_validation->set_rules('mobile1', 'Mobile No', 'trim|required|numeric');
            $this->form_validation->set_rules('role1', 'Role', 'trim|required');
            if(!empty($this->input->post('password1')))
            {
                $this->form_validation->set_rules('password1', 'Password', 'trim|required');
                $this->form_validation->set_rules('confirm_password1', 'Confirm Password', 'trim|required|matches[password1]');
            }            

            if($this->form_validation->run() == FALSE){
                $createuser_response['status'] = 'failure';
                $createuser_response['error'] = array('name1'=>strip_tags(form_error('name1')), 'email1'=>strip_tags(form_error('email1')), 'mobile1'=>strip_tags(form_error('mobile1')), 'role1'=>strip_tags(form_error('role1')),'password1'=>strip_tags(form_error('password1')),'confirm_password1'=>strip_tags(form_error('confirm_password1')));
            }else{

                /*check If user name & email is unique*/
                $check_uniqe =  $this->user_model->checkquniqeusername($userId, trim($this->input->post('name1')),$this->input->post('user_flag1'));
                $check_uniqe1 =  $this->user_model->checkEmailExists($userId, trim($this->input->post('email1')),$this->input->post('user_flag1'));
                
                if($check_uniqe){
                    $createuser_response['status'] = 'failure';
                    if(empty($this->input->post('password1')))
                    {
                        $createuser_response['error'] = array('name1'=>'User Name Alreday Exits', 'email1'=>'', 'mobile1'=>'', 'role1'=>'');
                    }else
                    {
                        $createuser_response['error'] = array('name1'=>'User Name Alreday Exits', 'email1'=>'', 'mobile1'=>'', 'role1'=>'','password1'=>'','confirm_password1' =>'');
                    }
                }
                else if($check_uniqe1){
                    $createuser_response['status'] = 'failure';
                    
                    if(empty($this->input->post('password1')))
                    {
                        $createuser_response['error'] = array('name1'=>'', 'email1'=>'Email already Exist', 'mobile1'=>'', 'role1'=>'');
                    }else
                    {
                        $createuser_response['error'] = array('name1'=>'', 'email1'=>'Email already Exist', 'mobile1'=>'', 'role1'=>'','password1'=>'','confirm_password1' =>'');
                    }
                }
                else{
                    $saveUserdata = $this->user_model->saveUserdata($userId,$data);
                    if($saveUserdata){
                        $createuser_response['status'] = 'success';
                        
                        if(empty($this->input->post('password1')))
                        {
                            $createuser_response['error'] = array('name1'=>'', 'email1'=>'', 'mobile1'=>'', 'role1'=>'');
                        }else
                        {
                            $createuser_response['error'] = array('name1'=>'', 'email1'=>'', 'mobile1'=>'', 'role1'=>'','password1'=>'','confirm_password1' =>'');
                        }
                    }
                }
            }
    
            echo json_encode($createuser_response);
        }
    }

    function get_signle_user_for_edit($userId = NULL)
    {
        // $data['roles'] = $this->user_model->getUserRoles();
        $data = $this->user_model->getUserInfo($userId);
        echo json_encode($data);
    }

    function deleteUser()
    {
        $post_submit = $this->input->post();
        if(!empty($post_submit)){
            $userInfo = array('isDeleted'=>1,'updatedBy'=>1, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->course_model->data_update('tbl_users',$userInfo,'userId',$this->input->post('id'));
            if($result){
                $deleteuser_response['status'] = 'success';
                $process = 'User Delete';
                $processFunction = 'Admin/deleteUser';
                $this->logrecord($process,$processFunction);
            }else
            {
                $deleteuser_response['status'] = 'filure';
            }
            echo json_encode($deleteuser_response);
        }
    }
        
     /**
     * This function is used to load the staff list
     */
    // function staffListing()
    // {   
    //         $searchText = $this->security->xss_clean($this->input->post('searchText'));
    //         $data['searchText'] = $searchText;
    //         $data['staffRecords'] = $this->user_model->staffListing($searchText);
            
            
    //         $process = 'Staff Listing';
    //         $processFunction = 'Admin/staffListing';
    //         $this->logrecord($process,$processFunction);

    //         $this->global['pageTitle'] = 'ADMIN : Staff List';
            
    //         $this->loadViews("master/staff", $this->global, $data, NULL);
    // }
    function staffListing()
    {          
            $this->global['pageTitle'] = 'Staff List';
            $data['role'] = $this->user_model->getUserRoles();
            $this->loadViews("master/staff", $this->global, $data, NULL);
    }

    public function fetchStaff(){
        
        $params = $_REQUEST;
        $totalRecords = $this->user_model->getStaffCount($params); 
        $queryRecords = $this->user_model->getStaffdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }


    // =======================================
	// setting for calendar
	function _setting(){
		return array(
			'start_day' 		=> 'monday',
			'show_next_prev' 	=> true,
			'next_prev_url' 	=> site_url('evencal/index'),
			'month_type'   		=> 'long',
            'day_type'     		=> 'short',
			'template' 			=> '{table_open}<table class="date">{/table_open}
								   {heading_row_start}&nbsp;{/heading_row_start}
								   {heading_previous_cell}<caption><a href="{previous_url}" class="prev_date" title="Previous Month"></a>{/heading_previous_cell}
								   {heading_title_cell}{heading}{/heading_title_cell}
								   {heading_next_cell}<a href="{next_url}" class="next_date"  title="Next Month"></a></caption>{/heading_next_cell}
								   {heading_row_end}<col class="weekday" span="5"><col class="weekend_sat"><col class="weekend_sun">{/heading_row_end}
								   {week_row_start}<thead><tr>{/week_row_start}
								   {week_day_cell}<th>{week_day}</th>{/week_day_cell}
								   {week_row_end}</tr></thead><tbody>{/week_row_end}
								   {cal_row_start}<tr>{/cal_row_start}
								   {cal_cell_start}<td>{/cal_cell_start}
								   {cal_cell_content}<div class="date_event detail" val="{day}"><span class="date">{day}</span><span class="event d{day}">{content}</span></div>{/cal_cell_content}
								   {cal_cell_content_today}<div class="active_date_event detail" val="{day}"><span class="date">{day}</span><span class="event d{day}">{content}</span></div>{/cal_cell_content_today}
								   {cal_cell_no_content}<div class="no_event detail" val="{day}"><span class="date">{day}</span><span class="event d{day}">&nbsp;</span></div>{/cal_cell_no_content}
								   {cal_cell_no_content_today}<div class="active_no_event detail" val="{day}"><span class="date">{day}</span><span class="event d{day}">&nbsp;</span></div>{/cal_cell_no_content_today}
								   {cal_cell_blank}&nbsp;{/cal_cell_blank}
								   {cal_cell_end}</td>{/cal_cell_end}
								   {cal_row_end}</tr>{/cal_row_end}
								   {table_close}</tbody></table>{/table_close}');
	}


    function _month($month){
		$month = (int) $month;
		switch($month){
			case 1 : $month = 'January'; Break;
			case 2 : $month = 'February'; Break;
			case 3 : $month = 'March'; Break;
			case 4 : $month = 'April'; Break;
			case 5 : $month = 'May'; Break;
			case 6 : $month = 'June'; Break;
			case 7 : $month = 'July'; Break;
			case 8 : $month = 'August'; Break;
			case 9 : $month = 'September'; Break;
			case 10 : $month = 'October'; Break;
			case 11 : $month = 'November'; Break;
			case 12 : $month = 'December'; Break;
		}
		return $month;
	}

    function _days($day){
		$day = (int) $day;
		switch($day){
			case 1 : $month = 'Monday'; Break;
			case 2 : $month = 'Tuesday'; Break;
			case 3 : $month = 'Wednesday'; Break;
			case 4 : $month = 'Thusrday'; Break;
			case 5 : $month = 'Friday'; Break;
			case 6 : $month = 'Saturday'; Break;
			case 7 : $month = 'Friday'; Break;
		}
		return $day;
	}

    	
	// get detail event for selected date
	function detail_event(){		
		$this->form_validation->set_rules('year', 'Year', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('mon', 'Month', 'trim|required|is_natural_no_zero|less_than[13]');
		$this->form_validation->set_rules('day', 'Day', 'trim|required|is_natural_no_zero|less_than[32]');
		
		if ($this->form_validation->run() == FALSE){
			echo json_encode(array('status' => false, 'title_msg' => 'Error', 'msg' => 'Please insert valid value'));
		}else{
			$data = $this->event->getEvent($this->input->post('year', true), $this->input->post('mon', true), $this->input->post('day', true));
			if($data == null){
				echo json_encode(array('status' => false, 'title_msg' => 'No Class', 'msg' => 'There\'s no Class in this date'));
			}else{			
				echo json_encode(array('status' => true, 'data' => $data));
			}
		}
	}


    public function profilesetting(){
        $this->global['pageTitle'] = 'Profile';
        $userId = $this->session->userdata('userId');
        $data['profile_details'] = $this->user_model->getUserInfo($userId);
        $this->loadViews("profile", $this->global, $data, NULL);
    }

    public function updateprofile(){

        $post_submit = $this->input->post();
        $userId = $this->input->post('userid');

        if(!empty($post_submit)){
            $profileupdate_response = array();

            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric|greater_than[0]|exact_length[10]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if($this->input->post('new_password') && $this->input->post('confirm_password')){
                $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
            }

            if($this->form_validation->run() == FALSE){
                $profileupdate_response['status'] = 'failure';
                $profileupdate_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'username'=>strip_tags(form_error('username')), 'mobile'=>strip_tags(form_error('mobile')), 'password'=>strip_tags(form_error('password')),'new_password'=>strip_tags(form_error('new_password')),'confirm_password'=>strip_tags(form_error('confirm_password')));
            }else{


                if(!empty($_FILES['profile_photo']['name'])){

                    $file = rand(1000,100000)."-".$_FILES['profile_photo']['name'];
                    $filename = str_replace(' ','_',$file);
    
                    $config['upload_path'] = 'uploads/profile_pic'; 
                    $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                    $config['max_size'] = '100000'; // max_size in kb 
                    $config['file_name'] = $filename; 
           
                    // Load upload library 
                    $this->load->library('upload',$config); 
            
                    // File upload
                    if($this->upload->do_upload('profile_photo')){ 
                       $profile_pic = $filename; 
                    }else{
                        $profile_pic =trim($this->input->post('existing_img'));
                    }
    
                }else{
                    $profile_pic = trim($this->input->post('existing_img'));
    
                }



                if($this->input->post('new_password') && $this->input->post('confirm_password')){

                    $password = $this->input->post('new_password');

                }else{

                    $password = $this->input->post('password');
                }


                $data = array(
                    'name'      => $this->input->post('full_name'),
                    'email'     => $this->input->post('email'),
                    'mobile'    => $this->input->post('mobile'),
                    'password'  => base64_encode($password),
                    'profile_pic' => $profile_pic,
                    'username'   => trim($this->input->post('username'))
                );

                    $saveUserdata = $this->user_model->saveUserdata($userId,$data);
                    if($saveUserdata){
                            $profileupdate_response['status'] = 'success';
                            $profileupdate_response['error'] = array('full_name'=>'', 'username'=>'', 'mobile'=>'', 'password'=>'','new_password'=>'','confirm_password'=>'');
                        }
            }
            echo json_encode($profileupdate_response);
        }

    }
	

   public function attendance(){
    $this->global['pageTitle'] = 'Attendance';
    $this->loadViews("attendance/view_attendance", $this->global, NULL, NULL);

   }


   public function fetchstudentattendance(){

    $params = $_REQUEST;
    $totalRecords = $this->admission_model->getAttendanceCount($params);
    $queryRecords = $this->admission_model->getAttendancedata($params); 
    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );

    echo json_encode($json_data);
 }


 public function examcheckingList(){
    $this->global['pageTitle'] = 'Check Exam';
    $this->loadViews("student/checkexam", $this->global, NULL, NULL);
 }

 public function fetchExamcheckListing(){
            $params = $_REQUEST;
            $totalRecords = $this->admission_model->getexaminationCount($params); 
            $queryRecords = $this->admission_model->getexaminationdata($params); 

            $data = array();
            foreach ($queryRecords as $key => $value)
            {
                $i = 0;
                foreach($value as $v)
                {
                    $data[$key][$i] = $v;
                    $i++;
                }
            }
            $json_data = array(
                "draw"            => intval( $params['draw'] ),   
                "recordsTotal"    => intval( $totalRecords ),  
                "recordsFiltered" => intval($totalRecords),
                "data"            => $data   // total data array
                );
    
            echo json_encode($json_data);

 }


 public function checkanswersheet(){

    $course_id = $this->input->get('course_id');
    $exam_id = $this->input->get('exam_id');    
    $data['exam_id'] = $this->input->get('exam_id');
    $data['course_id'] = $this->input->get('course_id'); 

    $this->global['pageTitle'] = 'View Student Result Listing';
    $data['examination_info'] = $this->examination_model->getSingleExaminationInfo($exam_id);
    $course_id = $data['examination_info'][0]->course_id;
    $examination_id = $data['examination_info'][0]->id;
   
    $this->loadViews("student/CheckstudentAnswerSheet", $this->global, $data, NULL);
 }


 public function fetchallstudentansersheet(){

    $course_id = $this->input->get('course_id');
    $exam_id = $this->input->get('exam_id'); 

    $params = $_REQUEST;
    $totalRecords = $this->admission_model->studentansersheetCount($params,$course_id,$exam_id); 
    $queryRecords = $this->admission_model->studentansersheetData($params,$course_id,$exam_id); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );

    echo json_encode($json_data);
 }



 public function addmarkstoexam(){

    $course_id = $this->input->get('course_id');
    $exam_id = $this->input->get('exam_id');   
    $student_id = $this->input->get('student_id');  

    $data['exam_id'] = $this->input->get('exam_id');
    $data['course_id'] = $this->input->get('course_id');
    $data['student_id'] = $this->input->get('student_id'); 

    $this->global['pageTitle'] = 'Submit Marks';
    $data['exam_detail'] = $this->admission_model->getExamdetails($course_id,$exam_id,$student_id);
    $data['question_paper'] = $this->admission_model->getstudentexamquestionlist($course_id,$exam_id,$student_id);
    $data['get_userdetails'] = $this->admission_model->getuserdetails($student_id);

    $course_id = $data['exam_detail'][0]['course_id'];
    $examination_id = $data['exam_detail'][0]['id'];
    
    $data['questionPaperListMCQ'] = $this->admission_model->getquestionPaperListMCQInfo($course_id,$examination_id,$student_id);
    $data['questionPaperListWRITTEN'] = $this->admission_model->getquestionPaperListWRITTENInfo($course_id,$examination_id,$student_id);
    $data['questionPaperListMATCHPAIR'] = $this->admission_model->getquestionPaperListMATCHPAIRInfo($course_id,$examination_id,$student_id);

    $this->loadViews("student/examchecking", $this->global, $data, NULL);
   
 }


 public function submit_examination_answer_db(){

    $exam_answer_data = $this->input->post();

    $given_marks=0;
    foreach ($exam_answer_data as $key => $value) {
        if($key=='examination_id' || $key=='course_id' ||  $key=='student_id'){

        }else{
            (int)$given_marks+= (int)$value;
        }

    }

    if($given_marks > 100){
        $savesnswerdata_response =array();
        $savesnswerdata_response['status'] = 'failure';
        $savesnswerdata_response['error'] = array('exam'=>'Total marks cannot be more than 100');
    
        echo json_encode($savesnswerdata_response);
    }else{

        $savesnswerdata_response =array();
        if($exam_answer_data){

            $examination_id = $this->input->post('examination_id');
            $course_id = $this->input->post('course_id');
            $student_id = $this->input->post('student_id');

            foreach ($exam_answer_data as $key => $value) {
                if($key=='examination_id' || $key=='course_id' ||  $key=='student_id'){

                }else{

                    preg_match_all('!\d+\.*\d*!', $key, $matches);

                    $question_id =$matches[0][0];

                        $updateddatetime = date('Y-m-d h:i:s', time());
                        $data = array(
                            'marks'    => $value,
                            'question_status' => 'checked',
                            'updatedDtm' => $updateddatetime,
                        );
                        
                        $updateAnswerdata = $this->student_model->updateAnswerdata($student_id,$course_id,$examination_id,$question_id,$data);

                        if($updateAnswerdata){
                            
                            $savesnswerdata_response['status'] = 'success';
                            $savesnswerdata_response['error'] = array('name'=>'', 'email'=>'', 'mobile'=>'', 'role'=>'','password'=>'','confirm_password'=>'');
                        
                        }
                }
            }

            echo json_encode($savesnswerdata_response);

        }

    }

 }


 public function crtificateListing(){

        $this->global['pageTitle'] = 'Certificate Listing';
        $this->loadViews("student/crtificateListing", $this->global, NULL, NULL);

 }


 public function fetchallstudentcertificates(){

        $params = $_REQUEST;
        $totalRecords = $this->admission_model->studentcertificateCount($params); 
        $queryRecords = $this->admission_model->studentcertificateData($params); 
    
        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
    
        echo json_encode($json_data);
 }
    
 public function studentexamrequest(){
    $this->global['pageTitle'] = 'Student Exam Request';
    $data['getallstudentlist'] =  $this->student_model->getallstudentlist();
    $this->loadViews("student/studentexamrequest", $this->global, $data, NULL);
 }


 public function allowstudentexamrequest(){
    $post_submit = $this->input->post();
    if(!empty($post_submit)){
        $allowstudentexamrequest_response = array();

        $this->form_validation->set_rules('student_name', 'Student Name', 'trim|required');
        $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');

        if($this->form_validation->run() == FALSE){
            $allowstudentexamrequest_response['status'] = 'failure';
            $allowstudentexamrequest_response['error'] = array('student_name'=>strip_tags(form_error('student_name')), 'course_name'=>strip_tags(form_error('course_name')));
        }else{

               $data = array(
                'student_id'      => $this->input->post('student_name'),
                'course_id'     => $this->input->post('course_name'),
                'permission'     => 1
               );

               /*Check If student data is alreayd exits */
                $checkifalreadyexitsExamRequest = $this->user_model->checkifalreadyexitsExamRequest(trim($this->input->post('course_name')),trim($this->input->post('student_name')));
                if($checkifalreadyexitsExamRequest) {

                    $allowstudentexamrequest_response['status'] = 'failure';
                    $allowstudentexamrequest_response['error'] = array('student_name'=>'Request Already Exists');
                 }else{
                    $saveStudentexampermissiondata = $this->user_model->saveStudentexampermissiondata('',$data);
                    if($saveStudentexampermissiondata){
                            $allowstudentexamrequest_response['status'] = 'success';
                            $allowstudentexamrequest_response['error'] = array('student_name'=>'', 'course_name'=>'');
                    }

                 }
        }
        echo json_encode($allowstudentexamrequest_response);
    }

 }
 

 public function getstudentcourselist(){
    $student_name=$this->input->post('student_name');
    if($student_name) {
        $getstudentDetails = $this->student_model->getstudentcourselist($student_name);
        if(count($getstudentDetails) >= 1) {
            $content = $content.'<option value="">Select Course Name</option>';
            foreach($getstudentDetails as $value) {
                $content = $content.'<option value="'.$value["courseId"].'">'.$value["course_name"].'</option>';
            }
            echo $content;
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }
 }


 public function fetchstudentexamrequestdata(){

    $params = $_REQUEST;
    $totalRecords = $this->admission_model->getstudentexamrequestdataCount($params); 
    $queryRecords = $this->admission_model->getstudentexamrequestdataData($params); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );

    echo json_encode($json_data);

 }

 public function deletestudentrequest(){
  
    $post_submit = $this->input->post('id');
    if(!empty($post_submit)){
        $deletecourse_response =array();
      
            $courseInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->course_model->data_update('tbl_student_exam_request',$courseInfo,'id',$this->input->post('id'));
            if($result){
                $deletecourse_response['status'] = 'success';
                $process = 'Delete Student Request';
                $processFunction = 'Course/deletestudentrequest';
                $this->logrecord($process,$processFunction);
            }else
            {
                $deletecourse_response['status'] = 'filure';
            }
        echo json_encode($deletecourse_response);
    }
    
 }


 public function CheckboxCheckUncheckpermission(){

    $post_submit = $this->input->post();

    if($post_submit){
        $checkboxCheckUncheckpermission_response =array();
        $CheckboxCheckUncheckpermission = $this->admission_model->CheckboxCheckUncheckpermission($this->input->post('id'),$this->input->post('permission_value'));

        if($CheckboxCheckUncheckpermission){
            $checkboxCheckUncheckpermission_response['status'] = 'success';
        }else{
            $checkboxCheckUncheckpermission_response['status'] = 'filure';
        }
    }
    echo json_encode($checkboxCheckUncheckpermission_response);

 }


 public function courseRequest(){
    $this->global['pageTitle'] = 'Course Request';
    $this->loadViews("student/courseRequest", $this->global, NULL, NULL);
 }


 public function fetchcourseRequest(){

        $userId = $this->session->userdata('userId');

        $params = $_REQUEST;
        $totalRecords = $this->admission_model->courseRequestDataCount($params,$userId); 
        $queryRecords = $this->admission_model->courseRequestData($params,$userId); 
    
        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
    
        echo json_encode($json_data);

    //$data['upcoming_class_links'] = $this->admission_model->upcoming_class_links($userId);
 }


 public function addnewcoursetopicrequest(){

    $post_submit = $this->input->post();
    if(!empty($post_submit)){
        $topirequest_response = array();
        $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
        $this->form_validation->set_rules('course_topic', 'Course Topic', 'trim|required');
        $this->form_validation->set_rules('request_description', 'Request Description', 'trim|required');
       
        $this->form_validation->set_rules('time_table_id', 'Time Table Id', 'trim|required');
        $this->form_validation->set_rules('student_id', 'Student Id', 'trim|required');
        
        if($this->form_validation->run() == FALSE){
            $topirequest_response['status'] = 'failure';
            $topirequest_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'course_topic'=>strip_tags(form_error('course_topic')), 'request_description'=>strip_tags(form_error('request_description')));
        }else{

            $data = array(
                'time_table_id'      => $this->input->post('time_table_id'),
                'student_id'     => $this->input->post('student_id'),
                'remark'  => $this->input->post('request_description'),
                'request_sent_status'  => 1,
            );

            $topic_class_request = $this->admission_model->saveclassrequest('',$data);

            if($topic_class_request){
                 $topirequest_response['status'] = 'success';
                 $topirequest_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'course_topic'=>strip_tags(form_error('course_topic')), 'request_description'=>strip_tags(form_error('request_description')));
            }else{
                $topirequest_response['status'] = 'failure';
                $topirequest_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'course_topic'=>strip_tags(form_error('course_topic')), 'request_description'=>strip_tags(form_error('request_description')));    
            }
        }
        echo json_encode($topirequest_response);
    }
 }


 public function getcoursetopicrequestdetails(){
    $post_submit = $this->input->post();
    if(!empty($post_submit)){
        $topic_request_details = $this->admission_model->topicrequestDetails(trim($this->input->post('id')));
        if($topic_request_details){
          echo json_encode($topic_request_details);
        }
    }

 }

 public function viewclassrequest(){
    $this->global['pageTitle'] = 'View Class Request Admin';
    $this->loadViews("student/viewclassrequest", $this->global, NULL, NULL);
 }

 public function fetchcourseRequestadmin(){

    $params = $_REQUEST;
    $totalRecords = $this->admission_model->courseRequestDataCountadmin($params); 
    $queryRecords = $this->admission_model->courseRequestDataadmin($params); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );

    echo json_encode($json_data);
 }


 public function getcoursetopicrequestdetailsadmin(){
    $post_submit = $this->input->post();
    if(!empty($post_submit)){
        $topic_request_details = $this->admission_model->getcoursetopicrequestdetailsadmin(trim($this->input->post('id')));
        if($topic_request_details){
          echo json_encode($topic_request_details);
        }
    }

 }


 public function addnewcoursetopicrequestapproved(){

    $post_submit = $this->input->post();
    if(!empty($post_submit)){

        $topirequest_response = array();
        // $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required');
        // $this->form_validation->set_rules('course_topic', 'Course Topic', 'trim|required');
        // $this->form_validation->set_rules('request_description', 'Request Description', 'trim|required');
       
        // $this->form_validation->set_rules('time_table_id', 'Time Table Id', 'trim|required');
        $this->form_validation->set_rules('request_id', 'Request id', 'trim|required');
        $this->form_validation->set_rules('updated_status', 'Updated Status', 'trim|required');
        
        if($this->form_validation->run() == FALSE){
    
            $topirequest_response['status'] = 'failure';
            $topirequest_response['error'] = array('request_id'=>strip_tags(form_error('request_id')), 'updated_status'=>strip_tags(form_error('updated_status')));
        }else{

            $data = array(
                'approval_status'  => 1,
                'admin_approval_status'  => $this->input->post('updated_status'),
            );

            $request_id = $this->input->post('request_id');

            $topic_class_request = $this->admission_model->saveclassrequest($request_id,$data);

            if($topic_class_request){
                 $topirequest_response['status'] = 'success';
                 $topirequest_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'course_topic'=>strip_tags(form_error('course_topic')), 'request_description'=>strip_tags(form_error('request_description')),'updated_status'=>strip_tags(form_error('updated_status')));
            }else{
                $topirequest_response['status'] = 'failure';
                $topirequest_response['error'] = array('course_name'=>strip_tags(form_error('course_name')), 'course_topic'=>strip_tags(form_error('course_topic')), 'request_description'=>strip_tags(form_error('request_description')),'updated_status'=>strip_tags(form_error('updated_status')));    
            }
        }
        echo json_encode($topirequest_response);
    }
 }


 public function settings(){
    $this->global['pageTitle'] = 'Settings';
    $data['get_whatsappconfig_setting'] = $this->admission_model->get_whatsappconfig_setting();
    $this->loadViews("settings", $this->global, $data, NULL);
 }

 public function whatappconfigupdate(){

    $post_submit = $this->input->post();
    if(!empty($post_submit)){
        $whatappconfigupdate_response = array();
        
        $this->form_validation->set_rules('instance_id', 'Instance Id', 'trim|required');
        $this->form_validation->set_rules('access_token', 'Access Token', 'trim|required');
        $this->form_validation->set_rules('whatsapp_config_id', 'Whats_config_id', 'trim|required');

        if($this->form_validation->run() == FALSE){
            $whatappconfigupdate_response['status'] = 'failure';
            $whatappconfigupdate_response['error'] = array('instance_id'=>strip_tags(form_error('instance_id')), 'access_token'=>strip_tags(form_error('access_token')));    
        }else{


        $instance_id = $this->input->post('instance_id');
        $access_token = $this->input->post('access_token');
        $whatsapp_config_id = $this->input->post('whatsapp_config_id');

        $data = array(
            'setting_module'   => 'whatsapp_credentials',
            'INSTANCE_ID'      => $instance_id,
            'ACCESS_TOKEN'     => $access_token,
        );

        $save_whatsapp_config = $this->admission_model->savewhatsappconfig($whatsapp_config_id,$data);

        if($save_whatsapp_config){
             $whatappconfigupdate_response['status'] = 'success';
             $whatappconfigupdate_response['error'] = array('instance_id'=>strip_tags(form_error('instance_id')), 'access_token'=>strip_tags(form_error('access_token')));
        }else{
             $whatappconfigupdate_response['status'] = 'failure';
             $whatappconfigupdate_response['error'] = array('instance_id'=>strip_tags(form_error('instance_id')), 'access_token'=>strip_tags(form_error('access_token')));    
        }

       
    }
    echo json_encode($whatappconfigupdate_response);
    }
 }


}

?>