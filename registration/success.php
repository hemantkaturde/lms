
<?php
$enq_id =$_GET['enq'];
include_once('../db/config.php');
$id = $_GET['enq'];
$sql = "SELECT name FROM tbl_admission where enq_id='".$id."' and isDeleted =0" ;
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>
<!-- <!DOCTYPE html>
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
            <p>Dear <b><?=$row['name'];?></b>,</p>
            <p>You are successfully Admitted In IICTN</p>
            <p>Please Contact to Administration</p>
           
          
            <p><a class="" target="_blank"  href="<?php echo 'https://iictn.in/registration/paymentrecipt.php/?enq='.$enq_id; ?>">Download Payment Receipt </a></p>

            <p><b>Addmission Form : </b></p> -->
            <!-- <p><a class="" target="_blank"  href="<?php echo 'https://iictn.in/registration/new-registration-student.php?enq='.$enq_id; ?>">Admission Form Link </a></p> -->

            <!-- <p>Kindly contact your Counsellors for more Details</p> -->
            <!-- <p><a class="btn btn-warning" target="_blank" href="https://doctor.iictn.org/"> <br> -->
                <!-- <p><b>Thanks & Regards</b></p> -->
                <!-- <p><h2><a class="" target="_blank" href="https://doctor.iictn.org/"><b style="color:black">IICTN</b></a></h2></p>
            <i class="fa fa-window-restore "></i></a></p> -->
        <!-- </div>
        
    </article>
</body>

</html> -->

<!DOCTYPE html>
<html>

<head>
    <title>Thank You - Razorpay Payment Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <style>
        @media (max-width: 768px) {
            .card-body {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            img {
                width: 100px;
                height: 100px;
            }

            p {
                font-size: 16px;
            }
        }

        @media (max-width: 576px) {
            h2 {
                font-size: 20px;
            }

            img {
                width: 80px;
                height: 80px;
            }

            p {
                font-size: 14px;
            }
        }
    </style>
</head>

<body class="">
    <article class="bg-secondary mb-3" style="background-color:#fff !important">
        <div class="card-body text-center">
            <img src="https://iictn.in/assets/img/logos/iictn_lms.png" width="150px" height="150px" alt="Company Logo"
                class="img-fluid">

            <h2 class="text-black"><b>!! Thank You for Joining IICTN !!</b></h2>
            <br>
            <p>Dear <b><?=$row['name'];?></b>,</p>
            <p>You are successfully Admitted In IICTN</p>
            <p>Please Contact the Administration for further details.</p>
        </div>
    </article>
</body>

</html>

<?php
$conn->close();
?>
