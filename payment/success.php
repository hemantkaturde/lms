
<?php
$enq_id =$_GET['enq'];
include_once('../db/config.php');
$id = $_GET['enq'];
$sql = "SELECT enq_id,enq_fullname FROM tbl_enquiry where enq_id='".$id."' and isDeleted =0" ;
$result = $conn->query($sql);
$row = $result->fetch_assoc();


$sql = "UPDATE tbl_enquiry SET payment_status=1 WHERE enq_id=$id";

if ($conn->query($sql) === TRUE) {
  //echo "Record updated successfully";
} else {
  //echo "Error updating record: " . $conn->error;
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Thank You - Razorpay Payment Success</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
</head>

<body class="">
    <br><br><br><br>
    <article class="bg-secondary mb-3" style="background-color:#ca9331 !important">
        <div class="card-body text-center">
            <img  src="https://iictn.in/assets/img/logos/iictn_lms.png" width="130px" height="130px" alt="Company Logo"/></br>

            <h2 class="text-white">!! Thank You for Joining IICTN !!<br></h2>
            <br>
            <p>Dear <b><?=$row['enq_fullname'];?></b>,</p>
            <p>Please check your Inbox / Spam on your Email with</p>
            <p>The subject name IICTN RECEIPT, We have attached the copy of your</p>
            <!-- <p>Payment Receipt</p> -->
            <p>Payment Receipt : </p>
            <p><a class="" target="_blank"  href="<?php echo SERVER.'paymentrecipt/'.$enq_id; ?>">Download Payment Receipt </a></p>

            <p>Addmission Form : </p>
            <p><a class="" target="_blank"  href="<?php echo SERVER.'new-registration-student/'.$enq_id; ?>">Admission Form Link </a></p>

            <p>Kindly contact your councillors for more Details</p>
            <!-- <p><a class="btn btn-warning" target="_blank" href="https://doctor.iictn.org/"> <br> -->
                <p>Thanks & Regards</p>
                <p><h2><a class="" target="_blank" href="https://doctor.iictn.org/"><b style="color:black">IICTN</b></a></h2></p>
            <i class="fa fa-window-restore "></i></a></p>
        </div>
        <br><br><br>
    </article>
</body>

</html>

<?php
$conn->close();
?>