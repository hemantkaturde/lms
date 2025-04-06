<?php
ob_start();
// include composer packages
include "vendor/autoload.php";
include "../db/config.php";
$enq_id = $_GET['enq_id'];
$paymentid = $_GET['paymentid'];
$result = $conn->query("SELECT *,tbl_users.name as counsellor_name,ab.name as conser_name,tbl_payment_transaction.id as invoice_number  FROM tbl_payment_transaction  
                           join tbl_enquiry on tbl_payment_transaction.enquiry_id =tbl_enquiry.enq_id
                           left join tbl_users ab on tbl_enquiry.counsellor_id = ab.userId 
                           left join tbl_admission on tbl_admission.enq_id = tbl_enquiry.enq_id 
                           left join tbl_users on tbl_admission.counsellor_name = tbl_users.userId
                           where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id=$paymentid");
$result_arry = $result->fetch_assoc();
$enquiry_course_ids = $result_arry['enq_course_id'];
$paymant_type = $result_arry['paymant_type'];
$add_on_course_id = $result_arry['add_on_course_id'];
$enquiry_id = $result_arry['enquiry_id'];
$gst_number = $result_arry['gst_number'];
$gst_holder_name = $result_arry['gst_holder_name'];
if ($paymant_type == 'regular_invoice') {
    $course_ids = explode(',', $enquiry_course_ids);
    $total_fees = 0;
    $course_name = '';
    $i = 1;
    foreach ($course_ids as $id) {
        $get_course_id_from_add_course = $conn->query("SELECT * from tbl_add_on_courses where enquiry_id=$enquiry_id");
        $get_add_on_course_id = $get_course_id_from_add_course->fetch_assoc();
        // print_r($get_add_on_course_id['course_id']);
        // print_r($id);
        // exit;
        if ($get_add_on_course_id['course_id'] == $id) {
            // echo $id.'.55555555';
            
        } else {
            $result = $conn->query("SELECT * FROM tbl_course where courseId=$id");
            $get_course_fees = $result->fetch_assoc();
            if ($get_course_fees) {

                if($get_course_fees['mainCourse_condition']=='Main'){
                    $course_type_condition = '';
                }else{
                    $course_type_condition = '-'.$get_course_fees['sponsored_condition'];
                }

                $total_fees+= $get_course_fees['course_total_fees'];
                $course_name.= $i . ') ' . $get_course_fees['course_name'] . ' ( Rs ' . $get_course_fees['course_total_fees'] . ' )  '.$course_type_condition.'  <br>';
                $i++;
            } else {
                $total_fees = '';
                $course_name = '';
                $i++;
            }
            if ($get_course_fees['course_mode_online'] == 1) {
                $course_mode_online = 'Online';
            } else {
                $course_mode_online = '';
            }
            if ($get_course_fees['course_mode_offline'] == 1) {
                $course_mode_offline = 'Offline';
            } else {
                $course_mode_offline = '';
            }
        }
    }
    $all_course_name = trim($course_name, ', ');
    $total_amount_payment_transection = $result_arry['totalAmount'];
} else {
    $result_add_on_course = $conn->query("SELECT * from tbl_add_on_courses  join tbl_course on tbl_add_on_courses.course_id = tbl_course.courseId  where tbl_add_on_courses.id=$add_on_course_id and tbl_add_on_courses.enquiry_id=$enquiry_id");
    $result_arry_add_on_course = $result_add_on_course->fetch_assoc();
    if ($result_arry_add_on_course['course_mode_online'] == 1) {
        $course_mode_online = 'Online';
    } else {
        $course_mode_online = '';
    }
    if ($result_arry_add_on_course['course_mode_offline'] == 1) {
        $course_mode_offline = 'Offline';
    } else {
        $course_mode_offline = '';
    }
    $all_course_name = $result_arry_add_on_course['course_name'];
    //$total_amount_payment_transection = $result_arry_add_on_course['course_total_fees']-$result_arry_add_on_course['discount'];
    $final_amount = $result_arry_add_on_course['course_total_fees'] - $result_arry_add_on_course['discount'];
    $total_amount_payment_transection = $result_arry['totalAmount'];
}

$startYear = date("y"); // Current year in 2 digits
$endYear = date("y", strtotime("+1 year")); // Next year in 2 digits
$financial_year = $startYear . '-' . $endYear;

if($result_arry['conser_name']){
    $couns_name= $result_arry['conser_name'];
}else{
    $couns_name= $result_arry['counsellor_name'];
}



$excluding_GST = $total_amount_payment_transection * 100 / 118;
      
$cgst_amount = $excluding_GST * 9 /100;
$sgst_amount = $excluding_GST * 9 /100;

$paid_amount = $total_amount_payment_transection-$excluding_GST;

if($paymant_type=='regular_invoice'){

    $result_previous_amount = $conn->query("SELECT sum(totalAmount) as totalAmount FROM tbl_payment_transaction where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id!=$paymentid and tbl_payment_transaction.id < $paymentid  and paymant_type='regular_invoice'");
    $result_arry_result_previous_amount = $result_previous_amount->fetch_assoc();
  

    if($result_arry_result_previous_amount['totalAmount']){
    $abv = $result_arry_result_previous_amount['totalAmount'];
    }else{
    $abv = 0;
    }
}else{
    $result_previous_amount = $conn->query("SELECT sum(totalAmount) as totalAmount FROM tbl_payment_transaction where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id!=$paymentid and tbl_payment_transaction.id < $paymentid and add_on_course_id=$add_on_course_id and paymant_type='add_on_course_invoice'");
    $result_arry_result_previous_amount = $result_previous_amount->fetch_assoc();
  

    if($result_arry_result_previous_amount['totalAmount']){
    $abv = $result_arry_result_previous_amount['totalAmount'];
    }else{
    $abv = 0;
    }
}

if($paymant_type=='regular_invoice'){
    $current_value = $conn->query("SELECT sum(totalAmount) as totalAmountcureent FROM tbl_payment_transaction where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id=$paymentid and paymant_type='regular_invoice'");
    $current_value_amount = $current_value->fetch_assoc();
    $currentbal = $result_arry['final_amount']-($current_value_amount['totalAmountcureent']+$abv);
    //$currentbal =  $total_amount_payment_transection-($current_value_amount['totalAmountcureent']+$abv);
   
  }else{

    $current_value = $conn->query("SELECT sum(totalAmount) as totalAmountcureent FROM tbl_payment_transaction where tbl_payment_transaction.enquiry_id=$enq_id and tbl_payment_transaction.id=$paymentid and add_on_course_id=$add_on_course_id and paymant_type='add_on_course_invoice'");
    $current_value_amount = $current_value->fetch_assoc();
    $currentbal =  $final_amount-($current_value_amount['totalAmountcureent']+$abv);
  }


  if($paymant_type=='regular_invoice'){
    $total_inc_amount= $result_arry['final_amount'];

  }else{
    $total_inc_amount= $final_amount;

  }


if($result_arry['prepared_by']){
    $prepared_by= $result_arry['prepared_by'];
}else{
    $prepared_by = 'Auto Generated';
}



  $no = floor($total_amount_payment_transection);
  $point = round($number - $no, 2) * 100;
  $hundred = null;
  $digits_1 = strlen($no);
  $i = 0;
  $str = array();
  $words = array('0' => '', '1' => 'One', '2' => 'Two',
   '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
   '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
   '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
   '13' => 'Thirteen', '14' => 'Fourteen',
   '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
   '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
   '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
   '60' => 'Sixty', '70' => 'Seventy',
   '80' => 'Eighty', '90' => 'Ninety');
  $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
  while ($i < $digits_1) {
    $divider = ($i == 2) ? 10 : 100;
    $number = floor($no % $divider);
    $no = floor($no / $divider);
    $i += ($divider == 10) ? 1 : 2;
    if ($number) {
       $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
       $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
       $str [] = ($number < 21) ? $words[$number] .
           " " . $digits[$counter] . $plural . " " . $hundred
           :
           $words[floor($number / 10) * 10]
           . " " . $words[$number % 10] . " "
           . $digits[$counter] . $plural . " " . $hundred;
    } else $str[] = null;
 }
 $str = array_reverse($str);
 $result = implode('', $str);
 $points = ($point) ?
   "." . $words[$point / 10] . " " . 
         $words[$point = $point % 10] : '';
 $words = $result . "Rupees Only";


$mpdf = new \Mpdf\Mpdf();
$html = '<html><body>
<style>
td{border-right:1px solid #000;font-size:11px;border-bottom:1px solid #000;padding:4px}table{border-left:1px solid #000}p,ol li{font-size:10px}
</style>
<div style="background:url(../www/image/orange_line.png) repeat-x;width:96%; margin-left:2%;">
<img src="iictn-logo-v.png" width="70%;" style="margin-left:0%;">

<h4 align="center" style="font-size:11px;margin-top:15px">Tax Invoice</h4>
<div style="float:left;width:45%;font-size:11px;"><b>Date : </b>'.date('d-m-Y', strtotime($result_arry['datetime'])).'</div>
<div style="float:right;width:45%;text-align:right;font-size:11px;"><b>Invoice No:
        Web/'.$financial_year.'/'.$result_arry['invoice_number'].'</b></div>
<p>
<div style="float:right;width:45%;text-align:right;font-size:11px;"><b>GSTIN - 27AADCI0005P1ZN</b></div>
</p>
<table width="100%" cellspacing="0" cellpadding="3">
    <tr>
        <td style="width:19%;border-top:1px solid black;">
            <div align="left"><b>Paid by </b></div>
        </td>
        <td style="border-top:1px solid black;padding-left:20px;text-transform: capitalize;">
            <div align="left">'.$result_arry['enq_fullname'].'</div>
        </td>
    </tr>
    <tr>
        <td style="width:19%;">
            <div align="left"><b>Description</b></div>
        </td>
        <td style="padding-left:20px;">
            <div align="left"></div>
        </td>
    </tr>
    <tr>
        <td style="width:19%;">
            <div align="left"><b>Email</b></div>
        </td>
        <td style="padding-left:20px;">
            <div align="left">'.$result_arry['enq_email'].'</div>
        </td>
    </tr>
    <tr>
        <td style="width:19%;">
            <div align="left"><b>Mobile</b></div>
        </td>
        <td style="padding-left:20px;">
            <div align="left">'.$result_arry['enq_mobile'].'</div>
        </td>
    </tr>
    <tr>
        <td style="width:19%;">
            <div align="left"><b>Counsellor Name</b></div>
        </td>
        <td style="padding-left:20px;">
            <div align="left">'.$couns_name.'</div>
        </td>
    </tr>
    <tr>
        <td style="width:19%;">
            <div align="left"><b>Payment Mode</b></div>
        </td>
        <td style="padding-left:20px;">
            <div align="left">'.$result_arry['payment_mode'].'</div>
        </td>
    </tr>
    <tr>
        <?php $str1=str_replace("#","<br>",$selected_courses); ?>
        <td style="width:19%;">
            <div align="left"><b>Joined Courses</b></div>
        </td>
        <td style="padding-left:20px;">
            <div align="left">'.$all_course_name.'</div>
        </td>
    </tr>
 
    <tr>
        <td colspan="2" style="padding: 0; border: none;">
        <table  cellspacing="0" cellpadding="0" style=" width: 100%;">
            <tr>
            <td style="width: 75%; font-weight: bold;">GST Holder Name : '.$gst_holder_name.'</td>
            <td style="width: 25%; font-weight: bold;">GST No. : '.$gst_number.'</td>
            </tr>
        </table>
        </td>
   </tr>

    <tr>
        <td colspan="2" style="padding: 0; border: none;">
        <table  cellspacing="0" cellpadding="6" style=" width: 100%;">
            <tr>
            <td style="width: 100%; font-weight: bold;">Note : To claim GST credits or setoffs, fees must be paid through an account linked with GST-registered account holder only.</td>
            </tr>
        </table>
        </td>
   </tr>
   

    
</table>
<table width="100%" cellspacing="0" cellpadding="3">
    <tr>
        <td>Total Amount [Incl. of (Admin Fee, Exam Fees, Book, 18% GST & Tuition/Training fee) for each course]*</td>
        <td rowspan="1" align="center" style="background-color:#c7a25b;"><b> INR. </b></td>
    </tr>
    <tr>
        <td rowspan="1" align="right" width="80%;" style="border-bottom:0px;border-top:0px;"><b> Paid Amount </b></td>
        <td>'.round($excluding_GST,2).'</td>
    </tr>
    <tr>
        <td rowspan="1" align="right" style="border-bottom:0px;border-top:0px;"><b> CGST 9% </b></td>
        <td>'. round($cgst_amount,2).'</td>
    </tr>
    <tr>
        <td rowspan="1" align="right" style="border-bottom:0px;border-top:0px;"><b> SGST 9% </b></td>
        <td>'.round($sgst_amount,2).'</td>
    </tr>
    <tr>
        <td rowspan="1" align="right" style="border-bottom:0px;border-top:0px;"><b> Amount Receivable</b></td>
        <td>'.$total_amount_payment_transection.'</td>
    </tr>
    <tr>
        <td rowspan="1" align="right"><b> Paid Before </b></td>
        <td>'.$abv.'</td>
    </tr>
    <tr>
        <td rowspan="1" align="right"><b> Balance Amount </b></td>
        <td>'. $currentbal.'</td>
    </tr>

    <tr>
        <td rowspan="1" align="right"><b> Total Amount </b>(Incl. of Course fee + 18% GST+ Admin Fee) </td>
        <td>'.$total_inc_amount.'</td>
    </tr>
    <tr>
        <td rowspan="1" align="right"><b> Bill Prepared By : </b></td>
        <td>'.$prepared_by.'</td>
    </tr>
    <tr>
        <td colspan="2" style="background-color:#c7a25b;"><b>Amount in word:</b> '.$words.'</td>
    </tr>
</table>
<div class="terms_conditions">

    <h4 style="text-transform: capitalize; text-decoration: underline;text-align:center">
        Invoice Terms & Conditions
    </h4>
    <p style="text-align:justify;">
        Applicants are advised to note that the selection of courses and packages is based on individual understanding,
        choice, and due diligence before opting for courses offered and facilitated by our counselors. By doing so, they
        consent to having understood the current scheme, discounted offers, fee package, fee breakdown, fee installment
        policy, and related terms. Please note that course fees and packages may differ from other applicants.
    </p>

    <p style="text-align:justify;">
        1. Applicants must fill out their correct details on admission form link, along with uploading all mandatory
        required documents in color.
    </p>

    <h5 style="text-decoration: underline;text-align:center">MANDATORY DOCUMENTS LIST FOR ADMISSION:</h5>

    <!--<div style="text-align: justify; display: inline-block; margin: 0 auto; font-weight: 800;">-->
    <!--    <p>1. Photo (Passport Size)</p>-->
    <!--    <p>2. Aadhar (both side)</p>-->
    <!--    <p>3. Active Mobile Number</p>-->
    <!--    <p>4. Valid Email ID</p>-->
    <!--    <p>5. 10th Marksheet</p>-->
    <!--    <p>6. 12th Marksheet</p>-->
    <!--    <p>7. Graduation Marksheet</p>-->
    <!--    <p>8. Students Signature</p>-->
    <!--    <p>9. Degree Certificate / All Semester Marksheet & Internship Certificate</p>-->
    <!--    <p>10. Excel Sheet filled by the applicant with correct details</p>-->
    <!--</div>-->

    <table
        style="width: 80%; margin: 0 auto; border-collapse: collapse; text-align: left; font-weight: 700;margin-bottom:10px">
        <tbody>
            <tr>
                <td style="padding: 8px;">1. Photo (Passport Size)</td>
                <td style="padding: 8px;">2. Aadhar (both side)</td>
                <td style="padding: 8px;">3. Active Mobile Number</td>
                <td style="padding: 8px;">4. Valid Email ID</td>
            </tr>
            <tr>
                <td style="padding: 8px;">5. 10th Marksheet</td>
                <td style="padding: 8px;">6. 12th Marksheet</td>
                <td style="padding: 8px;">7. Graduation Marksheet</td>
                <td style="padding: 8px;">8. Students Signature</td>
            </tr>
            <tr>
                <td style="padding: 8px;" colspan="3">9. Degree Certificate / All Semester Marksheet & Internship
                    Certificate</td>
                <td style="padding: 8px;">10. Excel Sheet filled by the applicant with correct details</td>
            </tr>
        </tbody>
         
    </table>

    <p style="text-align:justify;">
        2. Students must fill and submit the Admission form to enable themselves to be added to online/offline study
        groups to start the course.
    </p>

    <p style="text-align:justify;">
        3. The applicant must download Telegram, Zoom, Google Meet before starting an online class or lecture.
    </p>

    <p style="text-align:justify;">
        4. Study material will be dispatched within 72 hours only after the full course fee is received.
    </p>

    <p style="text-align:justify;">
        5. To put prefix "Dr." before their name on their certificates issued from IICTN, the applicant must submit a
        copy of their doctor`s medical registration.
    </p>

    <p style="text-align:justify;">
        6. IICTN each course`s validity and duration will last as per the syllabus, or up to six months; after six
        months, applicants will be charged extra fees of 30% incl GST for each course to finish the pending portion only
        within the period of 30 days / within one month.
    </p>

    <p style="text-align:justify;">
        7. We only acknowledge the course(s) that have been mentioned on your final invoice sent on your email id by
        IICTN management.
    </p>

    <p style="text-align:justify;">
        8. Study and understand the lectures carefully. (No videos of live lectures or Practicals will be shared)
    </p>

    <p style="text-align:justify;">
        9. Books / Certificate can be couriered or collected personally. Within India, the applicant must bear the
        applicable courier charge of Rs. 300 per courier, and for international shipments, the applicant must bear the
        actual cost of the courier. The Institute will not be responsible for any damages or loss of any documents. In
        the event of damage, loss, or the need for an updated version of a book, per-book reissue charges are Rs.
        1500/-.
    </p>

    <p style="text-align:justify;">
        10. We follow a modular study pattern, which means that an applicant`s class will begin with the topic the
        selected course is conducting on that day, and when the full cycle of the course module has been covered or
        completed, the applicant should leave the group or will be removed from the group by management.
    </p>

    <p style="text-align:justify;">
        11. Applicants will be awarded the certificate within a period of 60 working days, only after passing the exam,
        along with a full fee paid receipt submitted by the applicant via email at admin@iictn.org.
    </p>

    <p style="text-align:justify;">
        12. Applicants are strictly prohibited from sharing any data provided by management, whether obtained online or
        offline. All documents, contact details, study materials, notes, PPTs, videos, audios, etc. are copyrighted and
        the property of the institute.
    </p>

    <p style="text-align:justify;">
        13. The institute reserves the right to change, modify, and update the course curriculum, location of classes,
        class timings, topics, trainers and lecturers, method of teaching, online and offline platform of teaching, and
        timetable at any given time, subject to the sole discretion of the management, and it shall be incumbent on the
        applicant to undergo the same.
    </p>

    <p style="text-align:justify;">
        14. Applicants are advised to do their due diligence before opting for any education loan service from the
        financial institutions provided by the institute or from any other financial institutions. The institute will
        not be responsible or accountable for any dispute now or in the future.
    </p>

    <p style="text-align:justify;">
        15. Applicants enrolled in any collaborative university, council, or government course facilitated by IICTN are
        advised to coordinate directly with the relevant body for their queries or in case of any discrepancies, while
        keeping IICTN in the loop to maintain transparency. IICTN assures the best possible support for the applicant
        but will not be held liable or accountable for any delays in the process of admission, examination, or issuance
        of marksheets and certifications by collaborated entities.
    </p>

    <p style="text-align:justify;">
        16. As per company policy, once granted, admission cannot be canceled. The institute strictly adheres to a
        no-refund policy, and fee refund requests will not be entertained or accepted for any reason, including
        epidemics, pandemics, government regulations, dissatisfaction with topics, class timings and days, trainers and
        lecturers, or personal or family medical issues at the beginning of the course or at any time during its
        duration.
    </p>

    <p style="text-align:justify;">
        Please read the Terms and Conditions carefully. The Institute will not entertain or accept any requests or
        promises outside of those mentioned in this document, the final invoice copy, and the admission form.
        Furthermore, if for any reason, applicants fail to complete and submit their admission form to the Institute and
        management, whether offline, online, or digitally, before or after the commencement of their course, all terms,
        conditions, and policies will still apply. Acceptance of these terms will be acknowledged by default, and
        applicants shall abide by them.
    </p>

    <p style="text-align:justify;">
        <b>Note:</b> This is a computer-generated copy; the applicant`s signature is not required. Acceptance of the
        terms and
        conditions will be acknowledged and accepted by default, and the applicant shall abide by the same.
    </p>

    <p style="text-align:justify;">
        <b>By-Laws:</b> Terms, conditions, and policies are non-negotiable, subject to change at any time without prior
        notice,
        and will be abided by the applicant. Any dispute is subject to Mumbai jurisdiction only.
    </p>

</div>
</div>
</body>

</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('Tax_invoice.pdf', 'D'); // Outputs the PDF