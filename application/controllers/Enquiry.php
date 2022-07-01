<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';

    require_once(APPPATH."third_party/razorpay/razorpay-php/Razorpay.php");  
    use Razorpay\Api\Api;
    use Razorpay\Api\Errors\SignatureVerificationError;


    class Enquiry extends BaseController
    {
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model(array('login_model', 'enquiry_model', 'database'));
            $this->load->library('form_validation');
            $this->load->library('mail');
            // $this->load->library('dbOperations');
            // Datas -> libraries ->BaseController / This function used load user sessions
            $this->datas();
            // isLoggedIn / Login control function /  This function used login control
            $isLoggedIn = $this->session->userdata('isLoggedIn');
            if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
            {
                redirect('login');
            }
        }

        public function enquirylisting()
        {
            $process = 'Enquiry Listing';
            $processFunction = 'Enquiry/enquirylisting';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Enquiry Management';
            $this->loadViews("enquiry/enquiryList", $this->global, NULL , NULL);
        }


        public function fetchenquiry(){

            $params = $_REQUEST;
            $totalRecords = $this->enquiry_model->getEnquiryCount($params); 
            $queryRecords = $this->enquiry_model->getEnquirydata($params); 
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
    

        function get_signle_enquiry($enqId = NULL)
        {
            $enqId = $this->input->post('enq_id');
            $data = $this->enquiry_model->getEnquiryInfo($enqId);
            echo json_encode($data);
        }


        public function createenquiry(){
            $post_submit = $this->input->post();

            if(!empty($post_submit)){
                $createenquiry_response = array();

                    $check_enquiry_auto_number =  $this->enquiry_model->getautonumberfromEnquiry()[0];
                    if($check_enquiry_auto_number->enq_number){
                        $enq_number =$check_enquiry_auto_number->enq_number +  1;
                    }else{
                        $enq_number = 1;
                    }

                $data = array(
                    //'enq_number'=> DATE('Y').DATE('m').DATE('d').DATE('H').DATE('i').DATE('s'),
                    'enq_number'=> $enq_number,
                    'enq_fullname' => $this->input->post('full_name'),
                    'enq_mobile'=> $this->input->post('mobile_no'),
                    'enq_mobile1' => $this->input->post('alternate_mobile'),
                    'enq_email'=> $this->input->post('email'),
                    'enq_email1' => $this->input->post('alternamte_email'),
                    'enq_qualification' => $this->input->post('qualification'),
                    'enq_purpose' => $this->input->post('purpose'),
                    'enq_date' => date('Y-m-d', strtotime($this->input->post('enq_date'))),
                    'enq_country'=> $this->input->post('country'),
                    'enq_state'=>$this->input->post('state'),
                    'enq_city'=>$this->input->post('city'),
                    'enq_source'=>$this->input->post('enquiry_type'),
                    'enq_remark' => $this->input->post('remarks')
                );

                $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('mobile_no', 'Mobile_no', 'trim|required|numeric|greater_than[0]|exact_length[10]');
                $this->form_validation->set_rules('alternate_mobile', 'Alternate Mobile', 'trim');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('alternamte_email', 'Alternamte Email', 'trim');
                $this->form_validation->set_rules('qualification', 'Qualification', 'trim');
                $this->form_validation->set_rules('purpose', 'Purpose', 'trim');
                $this->form_validation->set_rules('enq_date', 'Enq Date', 'trim');
                $this->form_validation->set_rules('country', 'Country', 'trim');
                $this->form_validation->set_rules('state', 'State', 'trim');
                $this->form_validation->set_rules('city', 'City', 'trim');
                $this->form_validation->set_rules('enquiry_type', 'Enquiry Type', 'trim');
                $this->form_validation->set_rules('remarks', 'Remarks', 'trim');


                if($this->form_validation->run() == FALSE){
                    $createenquiry_response['status'] = 'failure';
                    $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                }else{

                    /*check If course name is unique*/
                    $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname(trim($this->input->post('full_name')));

                    if($check_uniqe){
                        $createenquiry_response['status'] = 'failure';
                        $createenquiry_response['error'] = array('full_name'=>'Name Already Exists', 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                    }else{
                        $saveEnquirydata = $this->enquiry_model->saveEnquirydata('',$data);
                        if($saveEnquirydata){
                            $createenquiry_response['status'] = 'success';
                            $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                        }
                    }
                }
        
                echo json_encode($createenquiry_response);
            }

        }

        public function updateenquiry($id= null){
            $post_submit = $this->input->post();

            if(!empty($post_submit)){
                $createenquiry_response = array();
                $data = array(
                    'enq_fullname' => $this->input->post('full_name'),
                    'enq_mobile'=> $this->input->post('mobile_no'),
                    'enq_mobile1' => $this->input->post('alternate_mobile'),
                    'enq_email'=> $this->input->post('email'),
                    'enq_email1' => $this->input->post('alternamte_email'),
                    'enq_qualification' => $this->input->post('qualification'),
                    'enq_purpose' => $this->input->post('purpose'),
                    'enq_date' => date('Y-m-d', strtotime($this->input->post('enq_date'))),
                    'enq_country'=> $this->input->post('country'),
                    'enq_state'=>$this->input->post('state'),
                    'enq_city'=>$this->input->post('city'),
                    'enq_source'=>$this->input->post('enquiry_type'),
                    'enq_remark' => $this->input->post('remarks')
                );

                $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('mobile_no', 'Mobile_no', 'trim|required|numeric|greater_than[0]|exact_length[10]');
                $this->form_validation->set_rules('alternate_mobile', 'Alternate Mobile', 'trim');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('alternamte_email', 'Alternamte Email', 'trim');
                $this->form_validation->set_rules('qualification', 'Qualification', 'trim');
                $this->form_validation->set_rules('purpose', 'Purpose', 'trim');
                $this->form_validation->set_rules('enq_date', 'Enq Date', 'trim');
                $this->form_validation->set_rules('country', 'Country', 'trim');
                $this->form_validation->set_rules('state', 'State', 'trim');
                $this->form_validation->set_rules('city', 'City', 'trim');
                $this->form_validation->set_rules('enquiry_type', 'Enquiry Type', 'trim');
                $this->form_validation->set_rules('remarks', 'Remarks', 'trim');


                if($this->form_validation->run() == FALSE){
                    $createenquiry_response['status'] = 'failure';
                    $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                }else{

                    /*check If enquiry name is unique*/
                    
                    if($id == null)
                    {
                        $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname(trim($this->input->post('full_name')));
                    }
                    else
                    {
                        $check_uniqe =  $this->enquiry_model->checkuniqeenquiryname_update($id, trim($this->input->post('full_name')));
                    }

                    if($check_uniqe){
                        $createenquiry_response['status'] = 'failure';
                        $createenquiry_response['error'] = array('full_name'=>'Name Already Exists', 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                    }else{
                        $saveEnquirydata = $this->enquiry_model->saveEnquirydata($id,$data);
                        if($saveEnquirydata){
                            $createenquiry_response['status'] = 'success';
                            $createenquiry_response['error'] = array('full_name'=>strip_tags(form_error('full_name')), 'mobile_no'=>strip_tags(form_error('mobile_no')), 'alternate_mobile'=>strip_tags(form_error('alternate_mobile')), 'email'=>strip_tags(form_error('email')),'alternamte_email'=>strip_tags(form_error('alternamte_email')),'qualification'=>strip_tags(form_error('qualification')),'purpose'=>strip_tags(form_error('purpose')),'enq_date'=>strip_tags(form_error('enq_date')),'country'=>strip_tags(form_error('country')),'state'=>strip_tags(form_error('state')),'city'=>strip_tags(form_error('city')),'remarks'=>strip_tags(form_error('remarks')));
                        }
                    }
                }
        
                echo json_encode($createenquiry_response);
            }

        }

        // ==== Delete Enquiry
        public function deleteEnquiry()
        {
            $post_submit = $this->input->post();

            $enquiryInfo = array('isDeleted'=>1,'updatedBy'=> $this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->database->data_update('tbl_enquiry',$enquiryInfo,'enq_id',$this->input->post('id'));

            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Enquiry Delete';
                 $processFunction = 'Enquiry/deleteEnquiry';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
        }

        public function sendPaymentLink(){
            $post_submit = $this->input->post();
                if($post_submit){
                    $get_equiry_data =  $this->enquiry_model->getEnquiryInfo(trim($post_submit['id']))[0];
                    $to = $get_equiry_data->enq_email;
                    $Subject = 'IICTN - Admission Payment Link '.date('Y-m-d H:i:s');
                    $Body  = '   <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                                    <title>Invoice details</title>
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                                </head>
                    
                                <body style="margin: 0; padding: 0; background-color:#eaeced " bgcolor="#eaeced">
                                <table bgcolor="#eaeced" cellpadding="0" cellspacing="0" width="100%" style="background-color: #eaeced; ">
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                <tr>
                                    <td>
                                    <table align="center" bgcolor="#ffffff" cellpadding="20" cellspacing="0" width="600" 
                                            style="border-collapse: collapse; background-color: #ffffff; border: 1px solid #f0f0f0;">
                                        <tr style="border-top: 4px solid #ff0000;">
                                        <td align="left" style="padding: 15px 20px 20px;">
                                        <table width="100%">
                                            <tr>
                                            <td><img  src="https://iictn.in/assets/img/logos/iictn_lms.png" width="130px" height="130px" alt="Company Logo"/></td>
                                            <td align="right">
                                                <span>Enquiry Number: 1234</span><br>
                                                <span style="padding: 5px 0; display: block;">'.$get_equiry_data->createdDtm.'</span>
                                            </td>
                                            </tr>
                                        </table>
                                        
                                        </td>
                                        </tr>
                                        <tr>
                                        <td align="center" style="padding: 20px; border-top: 1px solid #f0f0f0; background: #fafafa;,; ">
                                        <div>Total Course Fee:</div>
                                        <h2 style="margin: 10px 0; color: #333; font-weight: 500; font-size: 48px;">
                                        ₹ 500
                                        </h2>
                                        <div style="line-height: 1.4; font-size: 1.2; font-size: 14px; color: #777;">For Abc company, Issued on 1 Sept, 2017<br>by XYZ company</div>
                                        </td>
                                        </tr>

                                        <tr style="">
                                        <td align="center" style="padding: 15px 20px 20px;">
                                        <table width="80%">
                                            <tr>
                                            <td>Full Name</td>
                                            <td>'.$get_equiry_data->enq_fullname.'</td>
                                            </tr>

                                            <tr>
                                            <td>Mobile Number</td>
                                            <td>'.$get_equiry_data->enq_mobile.'</td>
                                            </tr>

                                            <tr>
                                            <td>Email id</td>
                                            <td>'.$get_equiry_data->enq_email.'</td>
                                            </tr>

                                            <tr>
                                            <td>Course</td>
                                            <td>fff</td>
                                            </tr>
                                        </table>
                                        </td>
                                        </tr>

                                        <tr>
                                        <td align="center" style="padding: 20px 40px;font-size: 16px;line-height: 1.4;color: #333;">
                                        <div>Note: For sales and marketing activity in July 2017 </div>
                                        <div><br></div>
                                        <div style="background: #ff0000; display: inline-block;padding: 15px 25px; color: #fff; border-radius: 6px">

                                        <a href="'.base_url().'pay/'.$get_equiry_data->enq_number.'" class="btn btn-sm btn-primary float-right pay_now"
                                        data-amount="1000" data-id="1">Pay Now</a>
                                        
                                        </div>
                                        <div style="color: #777; padding: 5px;">Due by 30 Sept, 2017</div>
                                        <div><br></div>
                                        </td>
                                        </tr>
                                        <tr style="border-top: 1px solid #eaeaea;">
                                        <td align="center">
                                            <div style="font-size: 14px;line-height: 1.4;color: #777;">
                                            Regards,<br>
                                            IICTN
                                        </div>
                                        </td>
                                        </tr>
                                    </table>
                                    
                                    </td>
                                </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                                </body>
                        </html>';
                            
                    $sendmail= $this->mail->sendMail($get_equiry_data->enq_fullname,$to,$Subject,$Body);

                    if($sendmail){
                        $process = 'Enquiry Link Sent';
                        $processFunction = 'Enquiry/sendEnquiryLink';
                        $this->logrecord($process,$processFunction);
                        echo(json_encode(array('status'=>'success')));
                    }
                }else{
                    echo(json_encode(array('status'=>FALSE)));

                }
        }


        public function pay($id){
            if($id){

            
               $process = 'Razorpay Payment ';
               $processFunction = 'Enquiry/pay';
               $this->logrecord($process,$processFunction);
               $this->global['pageTitle'] = 'Razorpay';
               $data['enquiry_data'] = $this->enquiry_model->getEnquiryInfobyenqnumber(trim($id));
               $this->load->view("payment/razorpay", $data );
            }else{
               echo 'page not found';
            }
       }


       public function razorpaysuccess(){

        $post_submit = $this->input->post();
        if($post_submit){

            $razorpay_payment_id = $post_submit['razorpay_payment_id'];
            $totalAmount = $post_submit['totalAmount'];
            $product_id = $post_submit['product_id'];
            $enquiry_number = $post_submit['enquiry_number'];

            $sucess_response = array();

            $data = array(
                'razorpay_payment_id' => $razorpay_payment_id,
                'totalAmount'=> $totalAmount,
                'product_id' => $product_id,
                'enquiry_number' => $enquiry_number,
                'payment_status' => 1
            );

            $payment = $this->enquiry_model->payment($data);

            if($payment){
                $enquiry_data = array('payment_status' => 1);
                $update_paymentstatus_enquiry = $this->enquiry_model->update_paymentstatus_enquiry($enquiry_number,$enquiry_data);

                if($update_paymentstatus_enquiry){
                    $process = 'Razorpay Payment  success';
                    $processFunction = 'Enquiry/pay';
                    $this->logrecord($process,$processFunction);

                    //$this->load->view("payment/success");

                }else{

                }
            }

        }else{

        }
       }


       public function razorthankyou(){

         $this->load->view("payment/success");

       }



    }

?>