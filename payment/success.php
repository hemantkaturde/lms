
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

// Recipient 
$to = 'hemantkaturde123@gamil.com'; 
 
// Sender 
$from = 'hemantkaturde123@gamil.com'; 
$fromName = 'hemant katurde'; 
 
// Email subject 
$subject = 'PHP Email with Attachment by CodexWorld';  
 
// Attachment file 
$file = "/codexworld.pdf"; 
 
// Email body content 
$htmlContent = ' 
    <h3>PHP Email with Attachment by CodexWorld</h3> 
    <p>This email is sent from the PHP script with attachment.</p> 
'; 
 
// Header for sender info 
$headers = "From: $fromName"." <".$from.">"; 
 
// Boundary  
$semi_rand = md5(time());  
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
 
// Headers for attachment  
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 
// Multipart boundary  
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";  
 
// Preparing attachment 
if(!empty($file) > 0){ 
    if(is_file($file)){ 
        $message .= "--{$mime_boundary}\n"; 
        $fp =    @fopen($file,"rb"); 
        $data =  @fread($fp,filesize($file)); 
 
        @fclose($fp); 
        $data = chunk_split(base64_encode($data)); 
        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" .  
        "Content-Description: ".basename($file)."\n" . 
        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" .  
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
    } 
} 
$message .= "--{$mime_boundary}--"; 
$returnpath = "-f" . $from; 
 
// Send email 
$mail = mail($to, $subject, $message, $headers, $returnpath);  
 
// Email sending status 
echo $mail?"<h1>Email Sent Successfully!</h1>":"<h1>Email sending failed.</h1>"; 


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
    <article class="bg-secondary mb-3" style="background-color:#fff !important">
        <div class="card-body text-center">
            <img  src="https://iictn.in/assets/img/logos/iictn_lms.png" width="150px" height="150px" alt="Company Logo"/>

            <h2 class="text-black"><b>!! Thank You for Joining IICTN !!</b><br></h2>
            <br>
            <p>Dear <b><?=$row['enq_fullname'];?></b>,</p>
            <p>Please check your Inbox / Spam on your Email with</p>
            <p>The subject name IICTN RECEIPT, We have attached the copy of your</p>
            <!-- <p>Payment Receipt</p> -->
            <p><b>Payment Receipt : </b></p>
            <p><a class="" target="_blank"  href="<?php echo 'https://iictn.in/registration/paymentrecipt.php/'.$enq_id; ?>">Download Payment Receipt </a></p>

            <p><b>Addmission Form : </b></p>
            <p><a class="" target="_blank"  href="<?php echo 'https://iictn.in/registration/new-registration-student.php?enq='.$enq_id; ?>">Admission Form Link </a></p>

            <p>Kindly contact your councillors for more Details</p>
            <!-- <p><a class="btn btn-warning" target="_blank" href="https://doctor.iictn.org/"> <br> -->
                <p><b>Thanks & Regards</b></p>
                <p><h2><a class="" target="_blank" href="https://doctor.iictn.org/"><b style="color:black">IICTN</b></a></h2></p>
            <i class="fa fa-window-restore "></i></a></p>
        </div>
        
    </article>
</body>

</html>

<?php
$conn->close();
?>