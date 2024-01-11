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
    <div class="jumbotron text-center" style="background-color: #ffffff; !important;margin-bottom:1rm !important">
    <img src="iictn_banner.jpg" alt="" width="850" height="120">
       <!-- <input type="button" class="btn btn-success" id="print_btn" onclick="printDiv('printableArea')" /> </input> -->
       <button type="button" id="print_btn" class="btn btn-info" onclick="printDiv('printableArea')"  style="background: #ca9331 !important;border: 1px #ca9331 !important;"><i class="fa fa-print"></i> Print</button>

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
    <div class="col-sm-4">
      <h3></h3>
      <?php
        if($img_url) 
        { ?>
             <img src="<?=$img_url?>" style=" display: block;margin-left: auto;margin-right: auto;" width="200" height="180">
      <?php  }else{ ?>
             <img src="defult_user.png" style=" display: block;margin-left: auto;margin-right: auto;" width="200" height="180">
      <?php } ?>
    </div>
    <div class="col-sm-8">
      <h3>Student information</h3>
      <table>
        <tr> 
            <td>
                <p><b>Student Name</b></p>
            </td>
            <td>
               <p style="margin-left:10px"><?=$rowDataStudent['name']; ?> </p>
            </td>
        </tr>
        <tr>
             <td>
                <p><b>Mobile Number</b></p>
             </td>
            <td>
               <p style="margin-left:10px"><?=$rowDataStudent['mobile']; ?></p>
            </td>
        </tr>
        <tr>
             <td>
                <p><b>Email Id</b></p>
            </td>
            <td>
               <p style="margin-left:10px"><?=$rowDataStudent['email']; ?></p>
            </td>
        </tr> 
        <tr>
            <td>
                <p><b>Status</b></p>
            </td>
            <td>
               <p style="margin-left:10px"><?php echo 'Admitted'; ?></p>
            </td>
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
    <div class="col-sm-12">
      <h3>Enquiry Details</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Enquiry No.</th>
                    <th>Enquiry Date</th>
                    <th>Student Name</th>
                    <th>Mobile No. </th>
                    <th>Email Id</th>
                    <th>Courses</th>
                    <th>Counsellor</th>
                </tr>
            </thead>
            <tbody> 
                <?php 
                while ($row = $resultStudentEnquirydetails->fetch_array()) { 
              
                 $course_ids    =   explode(',', $row['enq_course_id']);
             
                 $total_fees = 0;
                 $course_name = '';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                      $getStudentEnquiryCourses = "SELECT * FROM tbl_course where courseId=$id";
                      $resultStudentEnquiryCourses = $conn->query($getStudentEnquiryCourses);

                      $get_course_fees = $resultStudentEnquiryCourses->fetch_array();

                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees['course_total_fees'];
                            $course_name .= $i.'-'.$get_course_fees['course_name']. ' <br>';  
                            $i++;  

                        }else{

                            $total_fees = '';
                            $course_name = '';  
                            $i++;  
                        }
                      
                    }
                 $all_course_name = trim($course_name, ', '); 
                  
                ?>
                <tr>
                    <td><?=$row['enq_number']?></td>
                    <td><?=$row['createdDtm']?></td>
                    <td><?=$row['enq_fullname']?></td>
                    <td><?=$row['enq_mobile']?></td>
                    <td><?=$row['enq_email']?></td>
                    <td><?=$all_course_name?></td>
                    <td><?=$row['counsellor']?></td>
                </tr>
                <?php } ?>
            </tbody>
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
    <div class="col-sm-12">
      <h3>Total Fees Details</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Courses Name</th>
                    <th>Courses Fees</th>
                    <th>Certificate Cost</th>
                    <th>Apron Cost/Courier Charges</th>
                    <th>One time admission fees</th>
                    <th>CGST (9 %)</th>
                    <th>SGST (9 %)</th>
                    <th>Total Course Fees</th>
                </tr>
            </thead>
            <tbody> 
                <?php 
                while ($row = $resultStudentEnquirydetails->fetch_array()) { 
              
                 $course_ids    =   explode(',', $row['enq_course_id']);
             
                 $total_fees = 0;
                 $course_name = '';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                      $getStudentEnquiryCourses = "SELECT * FROM tbl_course where courseId=$id";
                      $resultStudentEnquiryCourses = $conn->query($getStudentEnquiryCourses);

                      $get_course_fees = $resultStudentEnquiryCourses->fetch_array();

                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees['course_total_fees'];
                            $course_name .= $i.'-'.$get_course_fees['course_name']. ' <br>';  
                            $i++;  

                        }else{

                            $total_fees = '';
                            $course_name = '';  
                            $i++;  
                        }

                        ?>

                <tr>
                    <td><?=$get_course_fees['course_name']?></td>
                    <td><?=$get_course_fees['course_fees']?></td>
                    <td><?='₹ '.$get_course_fees['course_cert_cost']?></td>
                    <td><?='₹ '.$get_course_fees['course_kit_cost']?></td>
                    <td><?='₹ '.$get_course_fees['course_onetime_adm_fees']?></td>
                    <td><?=$get_course_fees['course_cgst_tax_value']?></td>
                    <td><?=$get_course_fees['course_sgst_tax_value']?></td>
                    <td><?='₹ '.$get_course_fees['course_total_fees']?></td>
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
                    <td><b><?='₹ '.$total_fees?></b></td>
                </tr>
                
                <?php } ?>
            </tbody>
        </table>
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
    <div class="col-sm-12">
      <h3>Paid Fees Details</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Total Course Fees	</th>
                    <th>Discount</th>
                    <th>Final Amount</th>
                    <th>Total Paid Fees</th>
                    <th>Total Pending Fees</th>
                </tr>
            </thead>
            <tbody> 
                <?php 
                while ($row = $resultStudentEnquirydetails->fetch_array()) { 
              
                 $course_ids    =   explode(',', $row['enq_course_id']);
                 $total_fees = 0;
                 $course_name = '';
                 $total_paid_fees =0;
                 $total_discount_amount =0;
                 $final_amount =0;
                 $amount_after_dicount =0;
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                      $getStudentEnquiryCourses = "SELECT * FROM tbl_course where courseId=$id";
                      $resultStudentEnquiryCourses = $conn->query($getStudentEnquiryCourses);
                      $get_course_fees = $resultStudentEnquiryCourses->fetch_array();

                      $enq_number =$row['enq_number'];
                      $enq_id =$row['enq_id'];
                      $getStudentEnquiryPaidfees = "SELECT  sum(totalAmount)  as totalAmount  FROM tbl_payment_transaction where enquiry_id=$enq_id group by enquiry_id";
                      $resultStudentEnquiryPaidfees = $conn->query($getStudentEnquiryPaidfees);
                      $get_course_Paidfees = $resultStudentEnquiryPaidfees->fetch_assoc();

                      
                      $total_paid_fees +=  $get_course_Paidfees['totalAmount'];
                      $total_discount_amount +=  $row['discount_amount'];

                      $amount_after_dicount += $row['final_amount'];

                      $final_amount +=  $amount_after_dicount - $total_paid_fees;

                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees['course_total_fees'];
                            $course_name .= $i.'-'.$get_course_fees['course_name']. ' <br>';  
                           
                            $i++;  

                        }else{

                            $total_fees = '';
                            $course_name = '';  
                           // $total_paid_fees ='';
                            $i++;  
                        }

                        ?>

              <?php } ?>
                <tr>
                    <td><?='₹ '.$total_fees?></td>
                    <td><?='₹ '.$total_discount_amount?></td>
                    <td><?='₹ '.$amount_after_dicount?></td>
                    <td><?='₹ '.$total_paid_fees?></td>
                    <td><?='₹ '.$final_amount?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
  </div>
</div>

<?php
 /*Enquiry Details Start Here */
$getStudentEnquirydetails = "SELECT tbl_enquiry.enq_number,tbl_payment_transaction.datetime,tbl_payment_transaction.razorpay_payment_id,tbl_payment_transaction.payment_mode,tbl_payment_transaction.totalAmount,tbl_users_enquires.user_id,tbl_enquiry.enq_course_id,tbl_users.name as counsellor
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
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Enquiry No.</th>
                    <th>Payment Date</th>
                    <th>Transaction Id</th>
                    <th>payment_mode</th>
                    <th>Payment Amount</th>
                </tr>
            </thead>
            <tbody> 
                <?php 
                while ($row = $resultStudentEnquirydetails->fetch_array()) { 
              
                 $course_ids    =   explode(',', $row['enq_course_id']);
             
                 $total_fees = 0;
                 $course_name = '';
                 $i = 1;
                    foreach($course_ids as $id)
                    {
                      $getStudentEnquiryCourses = "SELECT * FROM tbl_course where courseId=$id";
                      $resultStudentEnquiryCourses = $conn->query($getStudentEnquiryCourses);

                      $get_course_fees = $resultStudentEnquiryCourses->fetch_array();

                        if($get_course_fees){
                            
                            $total_fees += $get_course_fees['course_total_fees'];
                            $course_name .= $i.'-'.$get_course_fees['course_name']. ' <br>';  
                            $i++;  

                        }else{

                            $total_fees = '';
                            $course_name = '';  
                            $i++;  
                        }
                      
                    }
                 $all_course_name = trim($course_name, ', '); 
                  
                ?>
                <tr>
                    <td><?=$row['enq_number']?></td>
                    <td><?=$row['datetime']?></td>
                    <td><?=$row['razorpay_payment_id']?></td>
                    <td><?=$row['payment_mode']?></td>
                    <td><?=$row['totalAmount']?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
  </div>
</div>










</body>
</html>
