
<?php
$enq_id =$_GET['enq'];
include_once('../db/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';


$id = $_GET['enq'];
$sql = "SELECT enq_id,enq_fullname,enq_email,enq_mobile FROM tbl_enquiry where enq_id='".$id."' and isDeleted =0" ;
$result = $conn->query($sql);
$row = $result->fetch_assoc();


$get_last_payment = "SELECT * FROM tbl_payment_transaction where enquiry_id='".$enq_id."' and payment_mode='Online-Razorpay' order by id desc limit 1"  ;
$result_last_payment = $conn->query($get_last_payment);
$row_last_payment = $result_last_payment->fetch_assoc();

$sql = "UPDATE tbl_enquiry SET payment_status=1 WHERE enq_id=$id";
if ($conn->query($sql) === TRUE) {
    $to = $row['enq_email'];
    
    $Subject = 'IICTN - Payment Receipt '.date('Y-m-d H:i:s');
    $email_name = 'IICTN-Payment Receipt';

    $Body   = '<p><b>WELCOME TO IICTN !! </b></p>';
    $Body  .='<p> We have received your Payment.</p>';
    $Body  .='<p> Transaction id: '.$row_last_payment['razorpay_payment_id'].'</p>';
    $Body  .= '<p>Click On the Below Link to fill Admission Form</p>';
    $Body  .= '<p><B>Admission Link</B>: https://iictn.in/registration/new-registration-student.php?enq='. $row['enq_id'].'</p>';
    $Body  .= '<p>Click to Download Payment Receipt</p>';
    $Body  .= '<p><B>Payment Receipt</B> : https://iictn.in/tax_invoice/index.php?enq_id='.$row['enq_id'].'&paymentid='.$row_last_payment['id'].'</p>';
    $Body  .= '<p>For more details kindly contact your Counsellor or write us on admin@iictn.org</p>';
    $Body  .= '<div><b>Thanks & Regards</b><br>';
    $Body  .= '<div><b>Team IICTN</b>';
    $header = "From: IICTN-Team <admin@iictn.in> \r\n";
    //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $retval = mail($to,$Subject,$Body,$header);  

    if($retval){
                /* Send Whats App  Start Here */
               // $curl = curl_init();
                $wp_url = 'https://iictn.in/tax_invoice/index.php?enq_id='.$row['enq_id'].'&paymentid='.$row_last_payment['id'];  
                $text = 'WELCOME TO IICTN !!,  We have received your Payment. Transaction id :'.$row_last_payment['razorpay_payment_id'] .', Download Tax-Invoice Using Following Link '.$wp_url. ' || Admission Link https://iictn.in/registration/new-registration-student.php?enq='.$row['enq_id'];

                $admission_link = 'https://iictn.in/registration/new-registration-student.php?enq='.$row['enq_id'];
                $mobile = '+91'.$row['enq_mobile'];
                // $url = "https://marketing.intractly.com/api/send.php?number=".$mobile."&type=text&message=".urlencode($text)."&instance_id=64FC5A51A7429&access_token=64e7462031534";

                $curl = curl_init();
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://app.wanotifier.com/api/v1/notifications/ctEBZRNvvL?key=rvs0h0gPYwSr9m8jbmAzdvGT9UDz8J',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'{
                    "data": {
                        "body_variables": [
                            "'.$row_last_payment['razorpay_payment_id'].'",
                            "'.$wp_url.'",
                            "'.$admission_link.'"
                        ]
                    },
                    "recipients": [
                        {
                            "whatsapp_number": "'.$mobile.'",
                            "first_name": "John",
                            "last_name": "Doe",
                            "attributes": {
                                "custom_attribute_1": "Value 1",
                                "custom_attribute_2": "Value 2",
                                "custom_attribute_3": "Value 3"
                            },
                            "lists": [
                                "Default"
                            ],
                            "tags": [
                                "new lead",
                                "notification sent"
                            ],
                            "replace": false
                        }
                    ]
                }',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Cookie: PHPSESSID=tdsrj23llm8jvqlsc81bocgvoh'
                  ),
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);
                echo $response;
    }

  
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
            <!-- <p><a class="" target="_blank"  href="<?php echo 'https://iictn.in/registration/paymentrecipt.php?enq='.$enq_id; ?>">Download Payment Receipt </a></p> -->

            <p><a class="" target="_blank"  href="<?php echo 'https://iictn.in/tax_invoice/index.php?enq_id='.$enq_id.'&paymentid='.$row_last_payment['id']; ?>">Download Payment Receipt </a></p>

            <p><b>Admission Form : </b></p>
            <p><a class="" target="_blank"  href="<?php echo 'https://iictn.in/registration/new-registration-student.php?enq='.$enq_id; ?>">Admission Form Link </a></p>

            <p>Kindly contact your Counsellors for more Details</p>
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