<?php 

include_once('../db/config.php');  

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
$url = "https://";   
else  
$url = "http://";   
// Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'];   
// Append the requested resource location to the URL   
$url.= $_SERVER['REQUEST_URI'];    

$studentid = $_GET['studentid'];

if($_SERVER['HTTP_HOST'] == 'localhost')
{
	$scheme = 'http://';
}
else
{
	$scheme = 'https://';
}
$ark_root  = $scheme.$_SERVER['HTTP_HOST'];
$ark_root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']); ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Summary Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<style>

h3{
  color:#d2ae6d;
}

@media print {
  #print_btn {
    visibility: hidden;
  }
}

</style>

<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

</script>

<body id="printableArea">
  <div class="jumbotron text-center" style="background-color: #ffffff; margin-bottom: 1rem;">
    <img src="iictn_banner.jpg" alt="Banner" class="img-fluid" style="max-width: 100%; height: auto;">
    <br><br>
    <button type="button" id="print_btn" class="btn btn-info" onclick="printDiv('printableArea')" style="background: #ca9331; border-color: #ca9331;">
      <i class="fa fa-print"></i> Print
    </button>
  </div>
<?php
/*Basic Information Start Here */
$getStudentdetails = "SELECT userId,`name`,mobile,email,profile_pic FROM tbl_users where userId=$studentid and isDeleted=0 and user_flag='student'" ;
$resultStudentDetails = $conn->query($getStudentdetails);
$rowDataStudent = $resultStudentDetails->fetch_assoc();

$userid=$rowDataStudent['userId'];

$getStudentadmissionDetails = "SELECT tbl_admission.document_1 FROM tbl_users_enquires join tbl_admission on tbl_users_enquires.enq_id= tbl_admission.enq_id where tbl_users_enquires.user_id=$userid" ;
$resultStudentadmissionDetails = $conn->query($getStudentadmissionDetails);
$rowDataStudentadminssiondetails = $resultStudentadmissionDetails->fetch_assoc();


if($_SERVER['HTTP_HOST']=='localhost'){
  $base  = "http://".$_SERVER['HTTP_HOST'];
 // $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

  $img_url = $base.'/lms_2/uploads/admission/'.$rowDataStudentadminssiondetails['document_1'];
}else{
  $base  = "https://".$_SERVER['HTTP_HOST'];
 // $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
  $img_url = $base.'/uploads/admission/'.$rowDataStudentadminssiondetails['document_1'];
}

?>

<div class="container">
  <div class="row">
    <div class="col-md-4 col-12 text-center">
      <h3></h3>
      <?php if ($img_url) { ?>
        <img src="<?= $img_url ?>" class="img-fluid" style="display: block; margin: 0 auto;" width="200" height="180">
      <?php } else { ?>
        <img src="defult_user.png" class="img-fluid" style="display: block; margin: 0 auto;" width="200" height="180">
      <?php } ?>
    </div>
    <div class="col-md-8 col-12">
      <h3>Student Information</h3>
      <table class="table table-borderless">
        <tr>
          <td><b>Student Name</b></td>
          <td><p><?= $rowDataStudent['name']; ?></p></td>
        </tr>
        <tr>
          <td><b>Mobile Number</b></td>
          <td><p><?= $rowDataStudent['mobile']; ?></p></td>
        </tr>
        <tr>
          <td><b>Email Id</b></td>
          <td><p><?= $rowDataStudent['email']; ?></p></td>
        </tr>
        <tr>
          <td><b>Status</b></td>
          <td><p>Admitted</p></td>
        </tr>
      </table>
    </div>
  </div>
</div>


<?php
 /*Enquiry Details Start Here */
$getStudentEnquirydetails = "SELECT tbl_enquiry.enq_number,tbl_enquiry.enq_fullname,tbl_enquiry.createdDtm,tbl_enquiry.enq_mobile,tbl_enquiry.enq_email,tbl_users_enquires.user_id,tbl_enquiry.enq_course_id,tbl_users.name as counsellor
                              FROM tbl_enquiry JOIN tbl_users_enquires on tbl_enquiry.enq_id=tbl_users_enquires.enq_id 
                              JOIN tbl_users on tbl_users.userId=tbl_enquiry.counsellor_id 
                              WHERE tbl_users_enquires.user_id=$studentid";
$resultStudentEnquirydetails = $conn->query($getStudentEnquirydetails);
//$rowDataStudentEnquirydetails = $resultStudentEnquirydetails->fetch_array();
?>
<div class="container">
  <div class="row">
    <div class="col-12">
      <h3>Enquiry Details</h3>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Enquiry No.</th>
              <th>Enquiry Date</th>
              <th>Student Name</th>
              <th>Mobile No.</th>
              <th>Email Id</th>
              <th>Courses</th>
              <th>Counsellor</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            while ($row = $resultStudentEnquirydetails->fetch_array()) { 
              $course_ids = explode(',', $row['enq_course_id']);
              $total_fees = 0;
              $course_name = '';
              $i = 1;

              foreach ($course_ids as $id) {
                $getStudentEnquiryCourses = "SELECT * FROM tbl_course WHERE courseId = $id";
                $resultStudentEnquiryCourses = $conn->query($getStudentEnquiryCourses);
                $get_course_fees = $resultStudentEnquiryCourses->fetch_array();

                if ($get_course_fees) {
                  $total_fees += $get_course_fees['course_total_fees'];
                  $course_name .= $i . '-' . $get_course_fees['course_name'] . ' <br>';
                  $i++;  
                } else {
                  $total_fees = '';
                  $course_name = '';
                  $i++;
                }
              }
              $all_course_name = trim($course_name, ', '); 
            ?>
            <tr>
              <td><?= $row['enq_number'] ?></td>
              <td><?= $row['createdDtm'] ?></td>
              <td><?= $row['enq_fullname'] ?></td>
              <td><?= $row['enq_mobile'] ?></td>
              <td><?= $row['enq_email'] ?></td>
              <td><?= $all_course_name ?></td>
              <td><?= $row['counsellor'] ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<?php
 /*Enquiry Details Start Here */
$getStudentEnquirydetails = "SELECT tbl_enquiry.enq_number,tbl_enquiry.enq_fullname,tbl_enquiry.createdDtm,tbl_enquiry.enq_mobile,tbl_enquiry.enq_email,tbl_users_enquires.user_id,tbl_enquiry.enq_course_id,tbl_users.name as counsellor
                              FROM tbl_enquiry JOIN tbl_users_enquires on tbl_enquiry.enq_id=tbl_users_enquires.enq_id 
                              JOIN tbl_users on tbl_users.userId=tbl_enquiry.counsellor_id 
                              WHERE tbl_users_enquires.user_id=$studentid";
$resultStudentEnquirydetails = $conn->query($getStudentEnquirydetails);
//$rowDataStudentEnquirydetails = $resultStudentEnquirydetails->fetch_array();
?>
<div class="container">
  <div class="row">
    <div class="col-12">
      <h3>Total Fees Details</h3>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Courses Name</th>
              <th>Courses Fees</th>
              <th>Certificate Cost</th>
              <th>Apron Cost/Courier Charges</th>
              <th>One Time Admission Fees</th>
              <th>CGST (9%)</th>
              <th>SGST (9%)</th>
              <th>Total Course Fees</th>
            </tr>
          </thead>
          <tbody> 
            <?php 
            while ($row = $resultStudentEnquirydetails->fetch_array()) { 
              $course_ids = explode(',', $row['enq_course_id']);
              $total_fees = 0;
              $course_name = '';
              $i = 1;

              foreach ($course_ids as $id) {
                $getStudentEnquiryCourses = "SELECT * FROM tbl_course WHERE courseId = $id";
                $resultStudentEnquiryCourses = $conn->query($getStudentEnquiryCourses);
                $get_course_fees = $resultStudentEnquiryCourses->fetch_array();

                if ($get_course_fees) {
                  $total_fees += $get_course_fees['course_total_fees'];
                  $course_name .= $i . '-' . $get_course_fees['course_name'] . ' <br>';
                  $i++;  
                } else {
                  $total_fees = '';
                  $course_name = '';  
                  $i++;  
                }
              ?>
              <tr>
                <td><?= $get_course_fees['course_name'] ?></td>
                <td><?= '₹ ' . $get_course_fees['course_fees'] ?></td>
                <td><?= '₹ ' . $get_course_fees['course_cert_cost'] ?></td>
                <td><?= '₹ ' . $get_course_fees['course_kit_cost'] ?></td>
                <td><?= '₹ ' . $get_course_fees['course_onetime_adm_fees'] ?></td>
                <td><?= $get_course_fees['course_cgst_tax_value'] ?></td>
                <td><?= $get_course_fees['course_sgst_tax_value'] ?></td>
                <td><?= '₹ ' . $get_course_fees['course_total_fees'] ?></td>
              </tr>
              <?php } ?>

              <tr>
                <td><b>Total Course Fees</b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><b><?= '₹ ' . $total_fees ?></b></td>
              </tr>
              <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>





<?php
 /*Enquiry Details Start Here */
$getStudentEnquirydetails = "SELECT tbl_enquiry.final_amount,tbl_enquiry.discount_amount,tbl_enquiry.enq_number,tbl_enquiry.enq_id,tbl_enquiry.enq_fullname,tbl_enquiry.createdDtm,tbl_enquiry.enq_mobile,tbl_enquiry.enq_email,tbl_users_enquires.user_id,tbl_enquiry.enq_course_id,tbl_users.name as counsellor
                              FROM tbl_enquiry JOIN tbl_users_enquires on tbl_enquiry.enq_id=tbl_users_enquires.enq_id 
                              JOIN tbl_users on tbl_users.userId=tbl_enquiry.counsellor_id 
                              WHERE tbl_users_enquires.user_id=$studentid";
$resultStudentEnquirydetails = $conn->query($getStudentEnquirydetails);
//$rowDataStudentEnquirydetails = $resultStudentEnquirydetails->fetch_array();
?>
<div class="container">
  <div class="row">
    <div class="col-12">
      <h3>Paid Fees Details</h3>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Course Name</th>
              <th>Total Course Fees</th>
              <th>Discount</th>
              <th>Final Amount</th>
              <th>Total Paid Fees</th>
              <th>Total Pending Fees</th>
              <th>Invoice Type</th>
            </tr>
          </thead>
          <tbody> 
            <?php 
            while ($row = $resultStudentEnquirydetails->fetch_array()) { 
              $enq_number = $row['enq_number'];
              $enq_id = $row['enq_id'];

              $total_fees = 0;
              $course_name = '';
              $total_paid_fees = 0;
              $total_discount_amount = 0;
              $final_amount = 0;
              $amount_after_dicount = 0;
              $i = 1;
              $course_ids = explode(',', $row['enq_course_id']);

              foreach ($course_ids as $id) {
                // Check course id in Add on course
                $checkif_courese_id_in_add_on = "SELECT tbl_add_on_courses.course_id
                                                 FROM tbl_enquiry
                                                 JOIN tbl_users ON tbl_users.userId = tbl_enquiry.counsellor_id
                                                 JOIN tbl_add_on_courses ON tbl_add_on_courses.enquiry_id = tbl_enquiry.enq_id
                                                 WHERE tbl_add_on_courses.enquiry_id = $enq_number";
                $checkifcourseinaddon = $conn->query($checkif_courese_id_in_add_on);

                $add_on_course_ids = array();
                while ($row11 = $checkifcourseinaddon->fetch_array()) { 
                  $add_on_course_ids[] = $row11['course_id'];
                }

                // Check if $id exists in $add_on_course_ids
                if (!in_array($id, $add_on_course_ids)) {
                  $getStudentEnquiryCourses = "SELECT * FROM tbl_course WHERE courseId = $id";
                  $resultStudentEnquiryCourses = $conn->query($getStudentEnquiryCourses);
                  $get_course_fees = $resultStudentEnquiryCourses->fetch_array();

                  $getStudentEnquiryPaidfees = "SELECT SUM(totalAmount) AS totalAmount FROM tbl_payment_transaction WHERE paymant_type = 'regular_invoice' AND enquiry_id = $enq_id GROUP BY enquiry_id";
                  $resultStudentEnquiryPaidfees = $conn->query($getStudentEnquiryPaidfees);
                  $get_course_Paidfees = $resultStudentEnquiryPaidfees->fetch_assoc();

                  $total_paid_fees += $get_course_Paidfees['totalAmount'];
                  $total_discount_amount += $row['discount_amount'];
                  $amount_after_dicount += $row['final_amount'];
                  $final_amount += $amount_after_dicount - $total_paid_fees;

                  if ($get_course_fees) {
                    $total_fees += $get_course_fees['course_total_fees'];
                    $course_name .= $i . '-' . $get_course_fees['course_name'] . ' <br>';
                    $i++;
                  } else {
                    $total_fees = '';
                    $course_name = '';
                    $i++;
                  }
                }
              }
            ?>
            <tr>
              <td><?= $course_name ?></td>
              <td><?= '₹ ' . $total_fees ?></td>
              <td><?= '₹ ' . $total_discount_amount ?></td>
              <td><?= '₹ ' . $amount_after_dicount ?></td>
              <td><?= '₹ ' . $total_paid_fees ?></td>
              <td><?= '₹ ' . $final_amount ?></td>
              <td>Invoice</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<?php
 /*Enquiry Details Start Here */
$getStudentEnquirydetails_add_on = "SELECT tbl_add_on_courses.enquiry_id addon_course_add_on_id_enquiry, tbl_add_on_courses.id  as add_on_course_id,tbl_add_on_courses.discount,tbl_add_on_courses.course_id,tbl_enquiry.final_amount,tbl_enquiry.discount_amount,tbl_enquiry.enq_number,tbl_enquiry.enq_id,tbl_enquiry.enq_fullname,tbl_enquiry.createdDtm,tbl_enquiry.enq_mobile,tbl_enquiry.enq_email,tbl_users_enquires.user_id,tbl_enquiry.enq_course_id,tbl_users.name as counsellor
                              FROM tbl_enquiry JOIN tbl_users_enquires on tbl_enquiry.enq_id=tbl_users_enquires.enq_id 
                              JOIN tbl_users on tbl_users.userId=tbl_enquiry.counsellor_id 
                              JOIN tbl_add_on_courses on tbl_add_on_courses.enquiry_id=tbl_enquiry.enq_id 
                              WHERE tbl_users_enquires.user_id=$studentid";
$resultStudentEnquirydetails_add_on = $conn->query($getStudentEnquirydetails_add_on);
//$rowDataStudentEnquirydetails = $resultStudentEnquirydetails->fetch_array();
?>
<div class="container">
  <div class="row">
    <div class="col-12">
    <h3>Add On Course Paid Fees Details</h3>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Course Name</th>
              <th>Total Course Fees</th>
              <th>Discount</th>
              <th>Final Amount</th>
              <th>Total Paid Fees</th>
              <th>Total Pending Fees</th>
              <th>Invoice Type</th>
            </tr>
          </thead>
          <tbody> 
            <?php 
            while ($row_add_on = $resultStudentEnquirydetails_add_on->fetch_array()) {
              $course_id_add_on = $row_add_on['course_id'];
              $add_on_course_id = $row_add_on['add_on_course_id'];
              $addon_course_add_on_id_enquiry = $row_add_on['addon_course_add_on_id_enquiry'];

              $getStudentEnquiryCourses = "SELECT * FROM tbl_course where courseId=$course_id_add_on";
              $resultStudentEnquiryCourses = $conn->query($getStudentEnquiryCourses);
              $get_course_fees = $resultStudentEnquiryCourses->fetch_array();

              if($row_add_on['discount']){
                $discount = $row_add_on['discount'];
              }else{
                $discount = 0;
              }

              $final_amount =  $get_course_fees['course_total_fees'] - $row_add_on['discount'];

              $total_pending_fess_addon= "SELECT sum(totalAmount) as totalAmount FROM tbl_payment_transaction where paymant_type='add_on_course_invoice' and add_on_course_id =$add_on_course_id and enquiry_id=$addon_course_add_on_id_enquiry";
              $total_pending_fess_addon_result = $conn->query($total_pending_fess_addon);
              $add_on_total_paid = $total_pending_fess_addon_result->fetch_array();

              if($add_on_total_paid['totalAmount']){
                $total_paid = $add_on_total_paid['totalAmount'];
              }else{
                $total_paid = 0;
              }

              $total_pending =  $final_amount - $total_paid;
            ?>
            <tr>
              <td><?= $get_course_fees['course_name']; ?></td>
              <td><?= '₹ '.$get_course_fees['course_total_fees']; ?></td>
              <td><?= '₹ '.$discount; ?></td>
              <td><?= '₹ '.$final_amount; ?></td>
              <td><?= '₹ '.$total_paid; ?></td>
              <td><?= '₹ '.$total_pending; ?></td>
              <td>Add On</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>





<?php
 /*Enquiry Details Start Here */
$getStudentEnquirydetails = "SELECT tbl_payment_transaction.paymant_type,tbl_enquiry.enq_number,tbl_payment_transaction.datetime,tbl_payment_transaction.razorpay_payment_id,tbl_payment_transaction.payment_mode,tbl_payment_transaction.totalAmount,tbl_users_enquires.user_id,tbl_enquiry.enq_course_id,tbl_users.name as counsellor
                              FROM tbl_enquiry JOIN tbl_users_enquires on tbl_enquiry.enq_id=tbl_users_enquires.enq_id 
                              JOIN tbl_users on tbl_users.userId=tbl_enquiry.counsellor_id 
                              JOIN tbl_payment_transaction on tbl_payment_transaction.enquiry_id=tbl_users_enquires.enq_id 
                              WHERE tbl_users_enquires.user_id=$studentid order by tbl_payment_transaction.id desc";
$resultStudentEnquirydetails = $conn->query($getStudentEnquirydetails);
//$rowDataStudentEnquirydetails = $resultStudentEnquirydetails->fetch_array();
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Transaction Details</h3>
            <div class="table-responsive"> <!-- Added this div for responsiveness -->
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Enquiry No.</th>
                            <th>Payment Date</th>
                            <th>Transaction Id</th>
                            <th>Payment Mode</th>
                            <th>Payment Amount</th>
                            <th>Invoice Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while ($row = $resultStudentEnquirydetails->fetch_array()) { 
                            $course_ids = explode(',', $row['enq_course_id']);
                            $total_fees = 0;
                            $course_name = '';
                            $i = 1;
                            foreach ($course_ids as $id) {
                                $getStudentEnquiryCourses = "SELECT * FROM tbl_course WHERE courseId=$id";
                                $resultStudentEnquiryCourses = $conn->query($getStudentEnquiryCourses);
                                $get_course_fees = $resultStudentEnquiryCourses->fetch_array();

                                if ($get_course_fees) {
                                    $total_fees += $get_course_fees['course_total_fees'];
                                    $course_name .= $i.'-'.$get_course_fees['course_name'].'<br>';  
                                    $i++;  
                                } else {
                                    $total_fees = '';
                                    $course_name = '';  
                                    $i++;  
                                }
                            }
                            $all_course_name = trim($course_name, ', '); 

                            if ($row['paymant_type'] == 'regular_invoice') {
                                $paymant_type = 'Invoice';
                            } else {
                                $paymant_type = 'Add on';
                            }
                        ?>
                        <tr>
                            <td><?=$row['enq_number']?></td>
                            <td><?=$row['datetime']?></td>
                            <td><?=$row['razorpay_payment_id']?></td>
                            <td><?=$row['payment_mode']?></td>
                            <td><?=$row['totalAmount']?></td>
                            <td><?=$paymant_type?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div> <!-- End of responsive div -->
        </div>
    </div>
</div>


</body>
</html>
