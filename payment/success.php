
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

  $name        = "Name goes here";
  $email       = "someome@anadress.com";
  $to          = "hemantkaturde123@gmail.com";
  $from        = "hemantkaturde123@gmail.com";
  $subject     = "Here is your attachment";
  $mainMessage = "Hi, here's the file.";
  $fileatt     = "./codexworld.pdf"; //file location
  $fileatttype = "application/pdf";
  $fileattname = "codexworld.pdf"; //name that you want to use to send or you can use the same name
  $headers = "From: $from";
  
  // File
  $file = fopen($fileatt, 'rb');
  $data = fread($file, filesize($fileatt));
  fclose($file);
  
  // This attaches the file
  $semi_rand     = md5(time());
  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
  $headers      .= "\nMIME-Version: 1.0\n" .
    "Content-Type: multipart/mixed;\n" .
    " boundary=\"{$mime_boundary}\"";
    $message = "This is a multi-part message in MIME format.\n\n" .
    "--{$mime_boundary}\n" .
    "Content-Type: text/plain; charset=\"iso-8859-1\n" .
    "Content-Transfer-Encoding: 7bit\n\n" .
    $mainMessage  . "\n\n";
  
  $data = chunk_split(base64_encode($data));
  $message .= "--{$mime_boundary}\n" .
    "Content-Type: {$fileatttype};\n" .
    " name=\"{$fileattname}\"\n" .
    "Content-Disposition: attachment;\n" .
    " filename=\"{$fileattname}\"\n" .
    "Content-Transfer-Encoding: base64\n\n" .
  $data . "\n\n" .
   "--{$mime_boundary}--\n";
  
  // Send the email
  if(mail($to, $subject, $message, $headers)) {
  
    echo "The email was sent.";
  
  }
  else {
  
    echo "There was an error sending the mail.";
  }






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