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
</head>

<style>

h3{
  color:#d2ae6d;
}

</style>

<body>
    <div class="jumbotron text-center" style="background-color: #ffffff; !important;margin-bottom:1rm !important">
    <img src="iictn_banner.jpg" alt="" width="850" height="120">
    </div>
<?php
/*Basic Information Start Here */
$getStudentdetails = "SELECT userId,`name`,mobile,email FROM tbl_users where userId=$studentid and isDeleted=0 and user_flag='student'" ;
$resultStudentDetails = $conn->query($getStudentdetails);
$rowDataStudent = $resultStudentDetails->fetch_assoc();
?>

<div class="container">
  <div class="row">
    <div class="col-sm-4">
      <h3></h3>
      <img src="defult_user.png" style=" display: block;margin-left: auto;margin-right: auto;" width="200" height="180">
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
                    <td><?=$get_course_fees['course_cert_cost']?></td>
                    <td><?=$get_course_fees['course_kit_cost']?></td>
                    <td><?=$get_course_fees['course_onetime_adm_fees']?></td>
                    <td><?=$get_course_fees['course_cgst_tax_value']?></td>
                    <td><?=$get_course_fees['course_sgst_tax_value']?></td>
                    <td><?=$get_course_fees['course_total_fees']?></td>
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
                    <td><?=$total_fees?></td>
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
