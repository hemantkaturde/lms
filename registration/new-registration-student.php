<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<?php
include_once('../db/config.php'); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
$url = "https://";   
else  
$url = "http://";   
// Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'];   
// Append the requested resource location to the URL   
$url.= $_SERVER['REQUEST_URI'];    
//$enq_id = substr($url, strrpos($url, '/') + 1);  
$enq_id  = $_GET['enq'];

// print_r($_GET['enq']);
// exit;

if($_SERVER['HTTP_HOST'] == 'localhost')
{
	$scheme = 'http://';
}
else
{
	$scheme = 'https://';
}
$ark_root  = $scheme.$_SERVER['HTTP_HOST'];
$ark_root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);


if ($_SERVER["REQUEST_METHOD"] == 'POST' ) { ?>
  <?php

    /*All post params here*/
    $enq_id = $_REQUEST["enq_id"];
    $name   = $_REQUEST["name"];
    $lastname   = $_REQUEST["lastname"];
    $gender   = $_REQUEST["gender"];
    $mobile = $_REQUEST["mobile"];
    $alt_mobile = $_REQUEST["alt_mobile"];
    $email = $_REQUEST["email"];
    $dateofbirth = $_REQUEST["dateofbirth"];
    $counsellerName = $_REQUEST["counsellerName"];
    $address = $_REQUEST["address"];
    $country = $_REQUEST["country"];
    $state =$_REQUEST["state"];
    $city = $_REQUEST["city"];
    $pin=  $_REQUEST["pin"];
    $aadhaarnumber=  $_REQUEST["aadhaarnumber"];
    
    if($_FILES['student_photo']['name']){
        $file = rand(1000,100000)."-".$name.'-'.$_FILES['student_photo']['name'];
        $file_loc = $_FILES['student_photo']['tmp_name'];
        $file_size = $_FILES['student_photo']['size'];
        $file_type = $_FILES['student_photo']['type'];
        $folder="../uploads/admission/";
        /* new file size in KB */
        $new_size = $file_size/1024;  
        /* new file size in KB */
        /* make file name in lower case */
        $new_file_name = strtolower($file);
        /* make file name in lower case */
        $final_file_student_photo=str_replace(' ','-',$new_file_name);
        move_uploaded_file($file_loc,$folder.$final_file_student_photo);
    }else{
        $final_file_student_photo ="";
    }


    if($_FILES['marksheet_photo']['name']){
        $file = rand(1000,100000)."-".$name.'-'.$_FILES['marksheet_photo']['name'];
        $file_loc = $_FILES['marksheet_photo']['tmp_name'];
        $file_size = $_FILES['marksheet_photo']['size'];
        $file_type = $_FILES['marksheet_photo']['type'];
        $folder="../uploads/admission/";
        /* new file size in KB */
        $new_size = $file_size/1024;  
        /* new file size in KB */
        /* make file name in lower case */
        $new_file_name = strtolower($file);
        /* make file name in lower case */
        $final_file_marksheet_photo=str_replace(' ','-',$new_file_name);
        move_uploaded_file($file_loc,$folder.$final_file_marksheet_photo);
    }else{
        $final_file_marksheet_photo ="";
    }


    if($_FILES['adhar_photo']['name']){
        $file = rand(1000,100000)."-".$name.'-'.$_FILES['adhar_photo']['name'];
        $file_loc = $_FILES['adhar_photo']['tmp_name'];
        $file_size = $_FILES['adhar_photo']['size'];
        $file_type = $_FILES['adhar_photo']['type'];
        $folder="../uploads/admission/";
        /* new file size in KB */
        $new_size = $file_size/1024;  
        /* new file size in KB */
        /* make file name in lower case */
        $new_file_name = strtolower($file);
        /* make file name in lower case */
        $final_file_adhar_photo=str_replace(' ','-',$new_file_name);
        move_uploaded_file($file_loc,$folder.$final_file_adhar_photo);
    }else{
        $final_file_adhar_photo ="";
    }

    $source_about=  $_REQUEST["source_about"];
    $source_ans=  $_REQUEST["source_ans"];
    $accept_terms =$_REQUEST["accept_terms"];

    $sql = "INSERT INTO tbl_admission (enq_id,`name`,lastname,gender,mobile, alt_mobile,email,dateofbirth,counsellor_name,`address`,city,`state`,country,pin,source_about,source_ans,accept_terms,registration_type,document_1,document_2,document_3,aadhaarnumber,isDeleted) 
                               VALUES ('$enq_id','$name','$lastname','$gender','$mobile','$alt_mobile','$email','$dateofbirth','$counsellerName','$address','$city','$state','$country','$pin','$source_about','$source_ans','$accept_terms','Weblink','$final_file_student_photo','$final_file_marksheet_photo','$final_file_adhar_photo','$aadhaarnumber','0')";

    if ($conn->query($sql) === TRUE) {

    
        $username = strtok($name, " ");
        $year = date("Y"); 
        $password = base64_encode('iictn'.'@'.$year);

        $main_pass = 'iictn'.'@'.$year;

        $sql_create_user = "INSERT INTO tbl_users (email,username,`password`,`name`,lastname,gender,mobile,user_flag,enq_id,roleId,createdBy,isDeleted) 
                              VALUES ('$email','$username',' $password','$name','$lastname','$gender','$mobile','student','$enq_id','3','1','0')"; 
                 
            
                if ($conn->query($sql_create_user) === TRUE) {
                    $last_id = $conn->insert_id;

                     /*Insert Table Enquiry Realtion In LMS*/

                    $insert_last_enquiry = "INSERT INTO tbl_users_enquires (user_id,enq_id) 
                                          VALUES ('$last_id','$enq_id')";
                                          
                    if($conn->query($insert_last_enquiry)=== TRUE){

                    $to = $email;
                    $email_name ="IICTN - Login Id and Password";
                    $Subject = 'IICTN - Login Id and Password '.date('Y-m-d H:i:s');
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
                            <tr style="border-top: 4px solid #ca9331;">
                            <td align="left" style="padding: 15px 20px 20px;">
                            <table width="100%">
                                <tr>
                                <td><img  src="https://iictn.in/assets/img/logos/iictn_lms.png" width="130px" height="130px" alt="Company Logo"/></td>
                                <td align="right">
                                 
                                </td>
                                </tr>
                            </table>
                            
                            </td>
                            </tr>
                            <tr>
                            <td align="center" style="padding: 20px; border-top: 1px solid #f0f0f0; background: #fafafa;,; ">
                            <div>Login Details:</div>
                            <div style="line-height: 1.4; font-size: 1.2; font-size: 14px; color: #777;"></div>
                            </td>
                            </tr>

                            <tr style="">
                            <td align="center" style="padding: 15px 20px 20px;">
                            <table width="100%">

                                <tr>
                                    <td><b>Login Link</b></td>
                                    <td>https://iictn.in/</td>
                                </tr>

                                <tr>
                                    <td><b>User Name (First Name  or Email Id or Mobile Number)</b></td>
                                    <td>'.$username.' or '.$email.' or '.$mobile.'</td>
                                </tr>

                                <tr>
                                    <td><b>Password</b></td>
                                    <td>'.$main_pass.'</td>
                                </tr>
                            </table>
                            </td>
                            </tr>

                            <tr>
                            <td align="center" style="padding: 20px 40px;font-size: 16px;line-height: 1.4;color: #333;">
                            <div> </div>
                            <div><br></div>
                            <div style="background: #ca9331; display: inline-block;padding: 15px 25px; color: #fff; border-radius: 6px">

                            <a href="https://iictn.in/" class="btn btn-sm btn-primary float-right pay_now"
                            data-amount="1000" data-id="1">Login Link</a>
                            
                            </div>
                            <div style="color: #777; padding: 5px;"></div>
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

                    $header = "From: IICTN-Login Link <admin@iictn.in> \r\n";
                    //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";

                    $retval = mail($to,$Subject,$Body,$header);

                        if($retval){

                            /* Send Whats App  Start Here */
                            $curl = curl_init();
                            $text = 'Login Link : https://iictn.in/ , Username (First Name  or Email Id or Mobile Number) : '.$username .' Password :'.$main_pass;
                            //$text = 'Dear '.$enq_fullname.' Thank You for your interest in '.$all_course_name.', We have attached the brochure and Syllabus for your reference. Feel free to contact us back, we will be delighted to assist and guide you.For more details, you can also visit our website www.iictn.org';      
                            $mobile_number = '+91'.$mobile;
                            //$url = "https://marketing.intractly.com/api/send.php?number=".$mobile."&type=text&message=".urlencode($text)."&instance_id=64FC5A51A7429&access_token=64e7462031534";

                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://app.wanotifier.com/api/v1/notifications/hYMnNEBv4E?key=rvs0h0gPYwSr9m8jbmAzdvGT9UDz8J',
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
                                        "'.$username.'",
                                        "'.$main_pass.'"
                                    ]
                                },
                                "recipients": [
                                    {
                                        "whatsapp_number": "'.$mobile_number.'",
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

                            echo ("<script> window.alert('Succesfully Registered');window.location.href='success.php?enq=$enq_id';</script>");
                        }else{
    
                            echo ("<script> window.alert('No Record Store')");
                        }
                    
                }else{
                    echo "Error: " . $sql . "<br>" . $conn->error;

                }

            }else{
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

             

    //   echo ("<script> window.alert('Succesfully Registerd');window.location.href='success.php?enq=$enq_id';</script>");
    //     echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close(); ?>

    <script type="text/javascript">
       $(".loader_ajax").hide();
    </script>
<?php
}
?>


<!-- check if Admission is allreday Done -->

<?php
$check_admission_is_alreday_exits = "SELECT *  FROM tbl_admission where enq_id=$enq_id and isDeleted=0" ;
$result_check_admission_is_exits = $conn->query($check_admission_is_alreday_exits);


if($result_check_admission_is_exits->num_rows > 0){ ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admission Form Submitted</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        @media (max-width: 768px) {
            h2 {
                font-size: 22px;
            }

            img {
                width: 100px;
                height: 100px;
            }

            .card-body {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            h2 {
                font-size: 18px;
            }

            img {
                width: 80px;
                height: 80px;
            }

            .card-body {
                padding: 15px;
            }
        }
    </style>
</head>

<body class="">
    <article class="bg-secondary mb-3" style="background-color:#fff !important">
        <div class="card-body text-center">
            <img src="https://iictn.in/assets/img/logos/iictn_lms.png" width="150px" height="150px" alt="Company Logo" class="img-fluid">
            <h2 class="text-black"><b>!! Admission Form Already Submitted !!</b><br></h2>
        </div>
    </article>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>
</html>





<?php }else{ ?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Registration - IICTN Registration </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://iictn.org.in/admission/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://iictn.org.in/admission/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom icon font-->
    <link rel="stylesheet" href="https://iictn.org.in/admission/css/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="https://iictn.org.in/admission/css/grasp_mobile_progress_circle-1.0.0.min.css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet"
        href="https://iictn.org.in/admission/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="https://iictn.org.in/admission/css/style.default.css" id="theme-stylesheet">
    <link id="new-stylesheet" rel="stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="https://iictn.org.in/admission/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="https://iictn.org.in/admission/admin-registration/favicon.png">
    <style type="text/css">
    ol.important {
        color: #F30;
        font-size: 13px;
        margin: 0px 0 0 20px;
    }

    ol.important li {
        line-height: 24px;
        list-style: decimal;
    }

    #terms {
        display: block;
        position: fixed;
        width: 100%;
        height: 100%;
        background: url(https://iictn.org.in/admission/admin-registration/fancybox/fancy_title_over.png);
        z-index: 1000;
        padding: 0;
        box-sizing: border-box;
    }

    .terms {
        background: #fff;
        margin: 5%;
        width: 90%;
        height: 85%;
        box-sizing: border-box;
        overflow: scroll;
        padding: 10px;
        border-radius: 5px;
    }

    .center_logo {
        width: 600px;
        margin: 0 auto;
    }

    .center_logo img {
        width: 600px;
        margin: 0 auto;
    }

    .text-info {
        color: #000000 !important;
    }

    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }

    .loader_ajax {background-color: #242424;bottom: 0;height: 100%;left: 0;opacity: 0.9;position: fixed;top: 0;width: 100%;z-index: 999;}
	.loader_ajax_inner {background: transparent url("bg.png") no-repeat scroll center center;height: 44px;left: 50%;margin: -22px 0 0 -22px;position: absolute;top: 50%;width: 44px;}
	.loader_ajax img {margin: 9px 0 0 8px;width: 28px;}
    </style>
</head>

<body>
    <!-- Side Navbar -->
    <div id="terms" style="display:none;"><img class="close"
            src="https://iictn.org.in/admin-registration/fancybox/fancy_close.png">
        <div class="terms"></div>
    </div>
    <div class="page home-page" style="width:100%;">
        <!-- navbar-->
        <header class="header">
            <nav class="navbar" style="background:#fff;">
                <div class="container-fluid">
                    <div class="navbar-holder d-flex align-items-center justify-content-between">
                        <div class="navbar-header">
                            <img src="https://iictn.org.in/images/iictn-logo-arrow.png" alt="iictn logo" width="100%;"
                                class="center">
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- Header Section-->
        <section class="forms">
            <div class="container-fluid">
                <header>
                </header>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-header d-flex align-items-center"
                                style="background: rgb(191,150,48);background: linear-gradient(180deg, rgba(191,150,48,1) 0%, rgba(240,224,130,1) 100%, rgba(227,201,160,1) 100%);; color:#fff;">
                                <h1 class="h4">Student Admission Form</h1>
                            </div>

                            <div class="card-body">
                                <form class="form-horizontal" name="registration_form_details"
                                    id="registration_form_details" action="" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    <input type="hidden" class="form-control" id="enq_id" name="enq_id"
                                        value="<?php echo $enq_id;?>">
                                    <div class="form-group row">
                                        <label class="col-sm-12 form-control-label text-info">PERSONAL DETAILS </label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="First Name*" Required>
                                            <span class="text-default">( As Required In Certificates )</span>
                                        </div>


                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="lastname" name="lastname"
                                                placeholder="Last Name*" Required>
                                            <span class="text-default">( As Required In Certificates )</span>
                                        </div>


                                        <div class="col-sm-2">
                                          <select id="gender" name="gender" class="form-control" Required>
                                            <option value="">Gender</option>
                                              <option value="Male" >Male</option>
                                              <option value="Female">Female</option>
                                          </select>
                                        </div> 

                                        <!-- <div class="col-sm-2">
                                          <select id="marital_status" name="marital_status" class="form-control">
                                            <option value="">Marital Status</option>
                                              <option>Married</option>
                                              <option>Single</option>
                                          </select>
                                        </div> -->

                                        <div class="col-lg-2">
                                            <input type="number" id="mobile" name="mobile" value="" class="form-control"
                                                placeholder="Mobile Number*" Required>
                                        </div>

                                        <div class="col-lg-2">
                                            <input type="number" id="alt_mobile" name="alt_mobile" class="form-control"
                                                placeholder="Alternate Contact No." Required>
                                            <small class="text-default">( incase of emergency )</small>
                                        </div>

                                        <div class="col-sm-3">
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Email Address*" Required>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="date" id="dateofbirth" name="dateofbirth"
                                                class="form-control hasDatepicker" placeholder="">
                                                <span class="text-default">( Date Of Birth )</span>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="text" id="aadhaarnumber" name="aadhaarnumber"
                                                class="form-control" placeholder="Aadhaar Number*" Required>
                                                <span class="text-default">( Aadhaar Number )</span>
                                        </div>
                                    </div>

                                    <!---<div class="form-group row">
                                      <div class="col-lg-3">
                                      <input type="number" id="alt_mobile" name="alt_mobile" class="form-control" placeholder="Alternate Contact No.">
                                                      <small class="text-default">( incase of emergency )</small>
                                                  </div>
                                                <div class="col-sm-3">
                                                  <select id="gender" name="gender" class="form-control">
                                                    <option value="">Gender</option>
                                                      <option>Male</option>
                                                      <option>Female</option>
                                                  </select>
                                                </div>
                                    
                                                
                                              <div class="col-sm-3">
                                                    <input type="number" id="age" name="age" class="form-control" placeholder="Age">
                                                  </div>
                                              </div>-->

                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label text-info">COUNSELLOR NAME</label>
                                        <!-- <div class="col-sm-3">
                                            <input type="text" id="counsellerName" name="counsellerName"  class="form-control" placeholder="Your Counsellor Name*">
                                        </div> -->
                                        <div class="col-sm-3">
                                            <select class="form-control counsellerName" id="counsellerName"
                                                name="counsellerName">
                                                <option value="">Select Your Counsellor Name*</option>
                                                <?php
                                                    $check_counsellor_name = "SELECT * FROM tbl_enquiry where enq_id=".$enq_id;
                                                    $result_check_counsellor = $conn->query($check_counsellor_name);
                                                    $row_counsellor_name = mysqli_fetch_assoc($result_check_counsellor);
                                        

            
                                            $sql = "SELECT * FROM tbl_users join tbl_roles on tbl_users.roleId=tbl_roles.roleId  where tbl_users.isDeleted='0' and tbl_roles.role='Counsellor'" ;
                                            $result = $conn->query($sql);
                                            while($row = mysqli_fetch_array($result)) { ?>
                                                <option value="<?php echo $row["userId"];?>" <?php if($row_counsellor_name['counsellor_id']==$row["userId"]){ echo 'selected';}  ?> ><?php echo $row["name"];?>
                                                </option>
                                                <?php
                                            }
                                        ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label text-info">PERMANENT ADDRESS</label>
                                        <div class="col-sm-10">
                                            <textarea id="address" name="address" class="form-control"></textarea>
                                        </div>


                                        <label class="col-sm-2 form-control-label text-info"></label>
                                        <div class="col-sm-2">
                                            <!-- <input type="text" id="city" name="city" class="form-control"
                                                placeholder="city"> -->
                                            <select class="form-control country" id="country" name="country">
                                                <option value="">Select Country</option>
                                                <option value="101">India</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <!-- <input type="text" id="state" name="state" class="form-control"  placeholder="state"> -->
                                            <select class="form-control state" name="state" id="state">
                                                <option st-id="" value="">Select State</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <!-- <input type="text" id="state" name="state" class="form-control"  placeholder="state"> -->
                                            <select class="form-control" name="city" id="city">
                                                <option st-id="" value="">Select City</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="text" id="pin" name="pin" class="form-control"
                                                placeholder="pin">
                                        </div>

                                    </div>
                                    <div class="line"></div>

                                    <div class="form-group row has-success">
                                        <label class="col-sm-12 form-control-label text-info">UPLOAD DOCUMENTS</label>
                                        <div class="col-sm-4">
                                            <input type="file" id="student_photo" name="student_photo"
                                                class="form-control"
                                                accept="image/jpeg,image/png">
                                            <small class="text-default">( Upload photo as required on certificate
                                                ) Kindly upload files in png, jpeg, jpg format</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="file" id="marksheet_photo" name="marksheet_photo"
                                                class="form-control"
                                                accept="image/jpeg,image/png">
                                            <small class="text-default">( Upload Highest Education Certificate ) Kindly upload files in png, jpeg, jpg format</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="file" id="adhar_photo" name="adhar_photo" class="form-control"
                                                accept="image/jpeg,image/png">
                                            <small class="text-default">( Upload Aadhar Copy) Kindly upload files in png, jpeg, jpg format</small>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="form-group row has-success">
                                        <label class="col-sm-12 form-control-label text-info">HOW DID YOU KNOW ABOUT
                                            US</label>
                                        <div class="col-sm-6">
                                            <select id="source_about" name="source_about" class="form-control" Required>
                                                <option value="">Source*</option>
                                                <option value="Google">Google</option>
                                                <option value="Facebook">Facebook</option>
                                                <option value="Instagram">Instagram</option>
                                                <option value="Reference">Reference</option>
                                                <option value="Social Media">Social Media</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="source_ans" name="source_ans" class="form-control"
                                                placeholder="how did you know about us">
                                        </div>
                                    </div>
                                    <div class="line"></div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h5 style="color:red;"></h5>
                                            <div
                                                style="height:300px;overflow: scroll;font-size:0.9rem;font-size:10px;color:grey;">
                                                <b>PLEASE READ TERMS &amp; CONDITION CAREFULLY </b>
                                                <body style="color: black;">
                                                    <p>Greetings !!!</p>
                                                    <p style="text-align:justify;"> Welcome to Destination for Excellence from 19 years. Dr. Jhoumer Jaiitly, Founder,
                                                        Head of Faculty & CMD is a renowned iconic personality in the Health & Wellness industry with over 24 years of
                                                        experience. <b>The Indian Institute of Cosmetology, Trichology, and Nutrition Private Limited (IICTN)</b>, is an
                                                        industry leader to provide course consultations and career guidance, offering a range of programs aimed at
                                                        enhancing and upgrading skills, from empowerment to employment. The curriculum and lectures are designed to meet
                                                        global standards and industry requirements, Featuring extensive hands-on training, supplemented by in-depth
                                                        theoretical knowledge of Course, Business Fundamentals and Legal framework. Additionally, IICTN facilitates
                                                        admissions for degree programs from universities and colleges for Beauty, Health, & Wellness industries.</p>
                                                    <p style="text-align:justify;"> Applicants are advised to note that the selection of courses and packages is based
                                                        on individual understanding, choice, and due diligence before opting for courses offered and facilitated by our
                                                        counsellors. By doing so, they consent to having understood the current scheme, discounted offers, fee package,
                                                        fee breakdown, fee installment policy, and related terms. Please note that course fees and packages may differ
                                                        from other applicants.</p>
                                                    <p>Please review the Joining Instructions, Terms and Conditions, and Company Policies. If you have any questions,
                                                        kindly respond to this email within 24 hours. If no response is received, your consent to the terms and
                                                        conditions will be acknowledged by default.</p>
                                                    <h3 style="font-size:11px;"><u>INSTITUTE OFFERS TWO OPTIONS FOR LEARNING:</u></h3>
                                                    <p><b>Option 1 - </b><u>Offline Course -:</u> Applicants will attend theory by online class of the course and can
                                                        attend practical sessions within 6 months at IICTN Mumbai centre or designated centre in other cities from
                                                        time to time. If the applicant does not complete the practical sessions within this period, the course will
                                                        automatically convert to Option 2.</p>
                                                    <p><b>Option 2 - </b><u>Offline Course -:</u> Applicants will not attend practical sessions at the institute but
                                                        will have access to live practical demonstrations or online sessions. No pre-recorded lectures will be
                                                        provided. If the applicant wishes to switch to an option 1 - offline course, they can do so by paying an
                                                        additional fee of Rs. 6,000/- per course.</p>
                                                    <p style="text-align:justify;">In the case of pregnancy or medical issues affecting the applicant or their family
                                                        members, the applicant may request a hold or extension of the course duration by submitting relevant supporting
                                                        documents, duly signed and stamped by the doctor and hospital (Management reserves the right to verify the
                                                        authenticity of the documents). Please note that fee refund requests at any stage of the course will not be
                                                        considered or accepted under any circumstances, and our refund policy will strictly apply. </p>
                                                    <h3 style="font-size:11px;"><u>JOINING INSTRUCTIONS</u></h3>
                                                    <p style="text-align:justify;">1. Applicants must fill out their correct details on the admission form link, along
                                                        with uploading all mandatory required documents in color format. click on admission link:
                                                        https://iictn.org.i/admission (ignore if already filled and submitted).</p>
                                                    <p style="text-align:justify;">2. Applicants must Fill and submit the Admission form to enable themselves to be
                                                        added to online / offline study groups to start the course.</a>
                                                    <p style="text-align:justify;">3. Documentation: All required documents are mandatory and must be submitted in one
                                                        go within 7 working days from the receipt of the fee paid to IICTN. Please note that document submission is only
                                                        accepted via email at bills.iictn@gmail.com; any other form of submission will not be acknowledged or accepted
                                                        under any circumstances. Failure to comply may result in delays in admission, cancellation, or penalties
                                                        (minimum Rs. 3000/-), for which IICTN will not be held liable. If applicants require further clarification, they
                                                        are advised to contact the Administration Team or their consultant. Applicant adherence to the processes and
                                                        timelines detailed above is mandatory</a>
                                                    <p style="text-align:justify;">
                                                        MANDATORY DOCUMENTS LIST FOR ADMISSION:
                                                    <p>1. Photo (Passport Size)</p>
                                                    <p>2. Aadhar (both side)</p>
                                                    <p>3. Active Mobile Number</p>
                                                    <p>4. Valid Email ID</p>
                                                    <p>5. 10th Marksheet </p>
                                                    <p>6. 12th Marksheet </p>
                                                    <p>7. Graduation Marksheet</p>
                                                    <p>8. Students Signature</p>
                                                    <p>9. Degree Certificate / All Semester Marksheet & Internship Certificate 10. Excel Sheet filled by the applicant
                                                        with correct details</p>
                                                    </p>
                                                    <p style="text-align:justify;">The applicant hereby affirms that all details provided and documents uploaded or
                                                        submitted through our online or digital admission form, as well as any information shared via email, are
                                                        accurate, authentic, and in compliance with the institute's requirements. The applicant acknowledges that in the
                                                        event any information or documents are found to be inaccurate, misleading, or fraudulent, the applicant will
                                                        bear full responsibility. The institute and its management will not be held liable for any consequences arising
                                                        from such discrepancies at any point in the future.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        We kindly request that you refrain from ignoring calls, raising concerns, or citing medical reasons when
                                                        management or your counsellor contacts you regarding any pending documents or outstanding fees. Please note that
                                                        if the payment is overdue by more than 30 days, the applicant will be temporarily removed from the group and
                                                        re-added once pending fee is paid.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        4. Study material will be dispatched within 7 working days only after the full fee of the course is received for
                                                        the particular course.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        5. Applications: Applicants must download such as Telegram, Zoom, Google Meet application to start the course..
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        6. Once the applicant has joined the Telegram group, ensure that notifications are turned on for all
                                                        communications. Set reminders for classes (30 minutes before each session). The monthly timetable is shared in
                                                        the respective course group on Telegram only; kindly take a screenshot and save it in your phone gallery.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        7. No information will be shared individually with any students regarding classes, exams, or practical sessions.
                                                        Students must remain active in the course groups to stay informed and updated.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        8. Study Links: The study link will be sent in the course’s group from one day to 10 minutes before the start of
                                                        the lecture. Applicants are advised to attend classes from a location with good network coverage. Please be
                                                        ensure that both your background audio and video are turned off during the lecture to avoid disturbance along
                                                        with your audio on mute.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        9. Queries: Any queries, besides course topics, should be discussed via WhatsApp with your counsellor instead of
                                                        asking in the study groups. Counsellors are available between 10 am to 6 pm, Monday to Saturday. Please wait up
                                                        to 7 working days for a response.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        10. Post-Lecture Queries: After the lecture, applicants can write their topic or course related queries in the
                                                        chat box. This allows everyone in the class to benefit from the discussion. Please refrain from personally
                                                        messaging trainers after the class, as they are scheduled for back-to-back sessions.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        11. Practical Sessions: Practical sessions will be conducted at the IICTN Mumbai head office only. Applicants
                                                        from outside Mumbai should email their schedule to bills.iictn@gmail.com to inform the institute of their
                                                        intended dates for attending practical classes. The institute will confirm practical session details via email,
                                                        WhatsApp, or Telegram within 15 working days. Please note: The diet course does not have practical sessions, as
                                                        it is only a theory course.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        12. Group Conduct: Do not send forwarded messages or share social, news, emergency, festival, or promotional
                                                        content in the groups. Personal queries should not be posted in the group; kindly contact the admin team or your
                                                        counselor directly for such matters. Course study links will be shared exclusively in the Telegram group.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        12. Group Conduct: Do not send forwarded messages or share social, news, emergency, festival, or promotional
                                                        content in the groups. Personal queries should not be posted in the group; kindly contact the admin team or your
                                                        counselor directly for such matters. Course study links will be shared exclusively in the Telegram group.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        13. Please study and thoroughly understand the topics and subjects covered in the curriculum lectures. Kindly
                                                        note that no videos of live lectures, Practical sessions will be shared and provided.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        14. Books / Certificates can be couriered or collected personally. Within India, the applicant must bear the
                                                        applicable courier charge of Rs. 300 per courier, and for international shipments, the applicant must bear the
                                                        actual cost of the courier. The Institute will not be responsible for any damages or loss of any documents. In
                                                        the event of damage, loss, or the need for an updated version of a book, per-book reissue
                                                        charges are Rs. 1500/-.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        15. We follow a modular study pattern, meaning that an applicant's class will begin with the topic being covered
                                                        in the selected course on that day. Once the full cycle of the course module has been completed, the applicant
                                                        should either leave the group or will be removed by the management.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        16. IICTN Exam & Certification:
                                                        <li>Upon completion of the course, applicants are required to email the administration to request their exam
                                                            papers.</li>
                                                        <li>IICTN exams are not conducted on a batch basis but rather upon individual request when students are
                                                            prepared.</li>
                                                        <li>The completed exam sheet must be submitted to the administration via the applicant's registered email
                                                            address only.</li>
                                                        <li>After submitting the exam sheet, applicants must initiate the certificate process by contacting the
                                                            administration team and requesting the certificate format for submission.</li>
                                                        <li>Certification: IICTN Certificates will be issued within 3 to 6 months after the receipt of the exam
                                                            completion and exam sheet submission by applicant or as determined by the Management.</li>
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        17. (B&WSSC – NCVET) Government Exam & Certification: Please note that the dates and timelines for the receipt
                                                        of exams and certificates issued by the B&WSSC are not under the control of IICTN.
                                                        <li> Applicants are advised to register for the government exam only when they are fully prepared. Attendance is
                                                            mandatory.</li>
                                                        <li>Exams are conducted on a batch-wise basis, primarily every month, and are not administered individually.
                                                        </li>
                                                        <li>Offline theory exams must be completed using the designated application.</li>
                                                        <li>A half-hour viva and practical exam will be conducted individually for each applicant.</li>
                                                        <li>Government exams are overseen by external government examiners, and a 100% passing rate is required.</li>
                                                        <li>Failure to pass on the first attempt will result in a certification noting the need for a second attempt.
                                                        </li>
                                                        <li>Failure to attend the exam for any reason, including medical emergencies, will result in a ₹5,100 penalty.
                                                            This penalty is strictly enforced and non-negotiable.</li>
                                                        <li>Certification: Certificates will be issued within 3 months or as determined by the respective
                                                            Body’s Schedule.</li>
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        18. University Exam & Certification: Please note that the dates and timelines for the receipt of exams and
                                                        certificates issued by the university are not under the control of IICTN.
                                                        <li>University exams are scheduled every six months, primarily in July and December.</li>
                                                        <li>It is iUniversity exams are conducted over a span of 10 daysmperative that applicants submit all required
                                                            documentation within 2 to 3 days of the request to avoid delays in exam scheduling.</li>
                                                        <li>University exams are conducted over a span of 10 days</li>
                                                        <li>The exams include topics related to Spoken English, Computer Knowledge, Nutrition, and Safety Measures, in
                                                            addition to the curriculum pursued.</li>
                                                        <li>University Certification: Certificates will be issued after 9 months or as determined by the respective
                                                            body’s schedule.</li>
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        19. To use the prefix "Dr." before your name on certificates or any other documents issued by IICTN, applicants
                                                        must submit a copy of their medical registration.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        20. The institute will not be responsible or liable if applicants fail to collect their certificates,
                                                        marksheets, or any other documents within 9 months, whether they pertain to IICTN or any other collaborating
                                                        entities, after IICTN has received the documents.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        21. IICTN each course's validity and duration will last as per the syllabus, or up to six months; after six
                                                        months, applicants will be charged extra fees of 30% including applicable taxes for each course to finish the
                                                        pending portion only within the period of 30 days / within one month.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        22. As per company policy, once granted, admission cannot be canceled. The institute strictly adheres to a
                                                        no-refund policy, and fee refund requests will not be addressed or accepted for any reason and circumstances,
                                                        including epidemics, pandemics, government regulations, dissatisfaction with topics, class timings and days,
                                                        trainers and lecturers, or personal or family medical issues at the beginning of the course or at any time
                                                        during its duration.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        23. The Institute will not address or accept any requests beyond those mentioned in this document, the final
                                                        invoice, and the admission form. We recognize only the course(s) specified on your final invoice, which has been
                                                        sent to your email by IICTN management based on your course selection and full fee payment received. If there
                                                        are any outstanding fees, the applicant will only be eligible for IICTN-issued courses and certifications and
                                                        will not be eligible for those from any collaborative body, even if mentioned on the invoice.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        24. If the applicant fails to submit the admission form (offline, online, or digitally) before or after the
                                                        course starts, all terms, conditions, and policies will apply by default, and the applicant must
                                                        comply with them.
                                                    </p>

                                                    <h1 style="text-align: center; text-transform: capitalize; text-decoration: underline;">
                                                        TERMS, CONDITIONS & POLICIES
                                                    </h1>
                                                    <p style="text-align:justify;">
                                                        25. Administration: If Applicant has any query regarding Courses Fee, Learning, Classes, Practicals, Exams or
                                                        Certifications, Therefore, we advise that Applicant should send their queries via WhatsApp / Telegram on
                                                        9820000030 or email on admin@iictn.org / bills.iictn@gmail.com Applicant queries will be attended in 10 working
                                                        days subject to approvals from the management, Applicant cooperation will be appreciated.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        26. Fees: As per policy, full course fees must be paid in advance, whether for an IICTN course or a
                                                        collaborative body’s course, even if the course or package is opted for under a discounted scheme or separately.
                                                        In addition, if the applicant has paid less than Rs. 5,000, it will be considered only as a registration or
                                                        booking amount. This amount will be valid for 3 months from the date of payment and is non-refundable and
                                                        non-transferable.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        27. Fee Installments: Fees can be paid in two installments, spaced two weeks apart, with 75% paid as the first
                                                        installment, plus an additional exam fee to begin the course. However, if paying in installments, applicants are
                                                        permitted to attend lectures only once a week. Please note that books and study materials will be issued after
                                                        full payment of the course fees. If the applicant is unable to pay the remaining balance within 3 months for any
                                                        reason, they will not be entitled to a refund. However, at its sole discretion, the institute may accommodate
                                                        applicants in the next batch or advise on converting the course into a short certificate program or other
                                                        services.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        28. Fees Breakdown: Please note that the actual cost of each course is Rs. 78,000. The original cost of each
                                                        online and offline session (webinar or lecture) is Rs. 2,600. However, the fee charged by IICTN may vary based
                                                        on the current discount scheme or package, which can be significantly lower. The discounted course fee includes
                                                        taxes (GST 18%), a one-time administration fee of ₹2,600, exam fees of ₹2,600 per course, certification fees of
                                                        ₹2,600 per course, book fees of ₹1,500 per course, plus training fees, etc. Additionally, for each sponsored
                                                        course by IICTN, only a separate certification fee of ₹2,600 is applicable, and other fees such as
                                                        administration, book, training, and exam fees are not charged for each sponsored course, as specified in your
                                                        invoice copy.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        The fee structures and breakdown provided above are intended for transparency to prevent any misunderstandings
                                                        regarding fees. In the event of any discrepancies or disputes, only the specified breakdown, original course
                                                        fee, and the cost of each online/offline lecture will be considered binding. Applicants must adhere to these
                                                        terms.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        29. Education Loan: Applicants are advised to do their own due diligence before opting for any education loan
                                                        service from any financial institutions and platform provided by the institute or from any other financial
                                                        institutions. The Institute will not be responsible, answerable, or accountable for any dispute that arises now
                                                        or in the future.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        30. Online / Offline Classes: Kindly cooperate with the faculty and attend course lectures as per the
                                                        institute’s class timings, topics, trainers and lecturers, methods of teaching, online and offline platforms of
                                                        teaching, and timetable. Topics once taught will not be repeated; if missed, they have to be studied by the
                                                        applicant themselves from study material in any form, such as printable, digital, book, PPTs, notes, video,
                                                        audio, online or offline, once shared and provided by the institute. Classes and lectures are weekly or
                                                        fortnightly for 1.5 hours for each course (subject to the course opted), for which a timetable is posted or
                                                        shared in respective Telegram groups at the start of every month. Each course duration will last as per the
                                                        syllabus, or for 3 months, whichever is earlier, but if, due to any medical issues, marriage, etc., the course
                                                        completion validity has expired, it can be extended to another 3 months if relevant supporting documents are
                                                        provided by the applicant via email at admin@iictn.org or bills.iictn@gmail.com Applicants can give exams online
                                                        if their courses have only theory and no practical.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        31. Machines Use: If Applicant breaks any machine, he / she has to pay Rs. 5,000/- or 30% of the actual cost of
                                                        the part of the machines on the very next day itself. Thus, while Practicals applicants are advised to look
                                                        after for Equipment / Machines carefully.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        32. Certificates: In order to secure the certificate, applicants should complete the theory and practical
                                                        portions of both and clear the examination of the course(s) with a 75% passing mark. A certificate will be
                                                        issued three months after the institute receives the applicant's course completion confirmation email by the
                                                        applicant email id only. It is mandatory to email a copy of all bills and final Invoice copy to
                                                        bills.iictn@gmail.com when applying for certification. Applicants are not allowed to attend theory and practical
                                                        classes after the exams or issuance of certifications, please be ethical and start making your professional
                                                        commitment only after you have been awarded the certificate. The institute reserves the right to change, modify,
                                                        or update the format of the certificate at any given time, subject to the discretion of the management.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        33. Workshop Certificate: A workshop certificate will be awarded on the last day of the workshop to only those
                                                        applicants who have made their full fee 15 days in advance before the start of the workshop. If the applicant
                                                        has only made a partial payment and attended the workshop, they must pay their outstanding fees in order to
                                                        receive their workshop certificate. Applicants who clear their dues after the workshop are only eligible to
                                                        receive their workshop certificate 15 working days after receiving their pending dues. Courier charges must be
                                                        borne solely by the applicants.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        34. Books / Certificate Collection: It can be couriered or collected personally. Within India, the applicant
                                                        must bear the applicable courier charge of Rs. 300 per courier, and for international shipments, the applicant
                                                        must bear the actual cost of the courier. The Institute will not be responsible for any damages or loss of any
                                                        documents.
                                                        <li>In the event of damage, loss, or the need for an updated version of a book, per-book reissue charges are Rs.
                                                            1500/-.</li>
                                                        <li>In the event of damage, loss, name change, etc., per certificate reissue charges are Rs. 2600/-.</li>
                                                        <li>Fees for any reissuing of any documents should be paid in advance and must be borne by the applicant only.
                                                        </li>
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        35. Attendance: The minimum attendance required is 85%, failing which the applicant will not be allowed to
                                                        appear for the exams. For more than 3 days' absence, please email documents for leave. However, in cases of
                                                        sudden illness where prior permission is not possible, a medical certificate from a doctor must be emailed to
                                                        admin@iictn.org or mumbai.iictn@gmail.com.
                                                        <li>Each course's validity and duration will last as per the syllabus, or up to six months; after six months,
                                                            applicants will be charged 30% course fees for each course to finish the pending portion within one month.
                                                        </li>
                                                        <li>The institute is not responsible for covering up if the applicant misses his or her classes for whatever
                                                            reason or if the course duration extends beyond 6 months.</li>
                                                        <li>The institute reserves the right to change and modify the course curriculum, location of classes, class
                                                            timings, topics, trainers and lecturers, method of teaching, online and offline platforms of teaching, and
                                                            timetable at any given time, subject to the discretion of the management, and it shall be the applicant's
                                                            responsibility to undergo the same.</li>
                                                        <li>After 6 months, if applicants wish to learn the full course again, they have to pay 30% of the course fee
                                                            again for the study of that course within 2 months. Please do not take leave during these two months.</li>
                                                        <li>The applicant authorises and gives consent to the institute, stating that they have been clearly explained
                                                            and informed by the trainer, staff, and management that the practical class, demonstration class, and
                                                            procedure will be done with due care and that the possible effects and post-care precautions have to be
                                                            taken after the procedures.</li>
                                                        <li>Applicants are consensually and voluntarily taking part as models in practical, demonstrations, and
                                                            procedures during the class at their own will and risk and will not hold the trainer, owner, associate
                                                            owner, or any other staff of the institute responsible for any side effects or injuries.</li>
                                                        <li>Applicants voluntarily participating in the video and photo shoot consent to their usage for marketing and
                                                            promotional activities without claiming royalties or charges.</li>
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        36. Collaborative Course Terms: The vision and mission of IICTN are to provide opportunities for specialization
                                                        and skill education that are demographically relevant, in demand, and in accordance with established standards.
                                                        To achieve this mission, IICTN collaborates with universities, councils, institutions, and private organisations
                                                        to offer relevant courses and opportunities. However, applicants are advised to conduct their due diligence
                                                        before enrolling in a collaborative body’s courses. The applicant should not hold IICTN responsible for any
                                                        guidance related to admission, study facilitation, or placement in India or abroad at any time in the future.
                                                        IICTN is merely facilitating the details and processes regarding fees, admission, exams, marksheets, and the
                                                        certification process, as clearly explained by the counsellors before opting for any collaborative courses.
                                                        Having provided your consent and expressed satisfaction with this understanding, IICTN will not be held
                                                        responsible for any delays in admission, exams, certifications, or course discontinuation.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        Please note that the dates and time frames for the receipt of exams and certificates issued by the collaborating
                                                        body are not under the control of IICTN. Any delays regarding exams and certificates are subject to the terms
                                                        and conditions of the collaborating body and will be the sole responsibility of that entity. If an applicant has
                                                        any queries regarding exams, marksheets, or certifications, IICTN advises that the applicant should send their
                                                        inquiries directly to the related body, while keeping IICTN in the loop to maintain transparency. IICTN assures
                                                        the best possible support for our students but will not be held liable or accountable for any delays in the
                                                        process of admission, examination, or issuance of marksheets and certifications by the collaborating entities.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        The duly completed application forms, along with the mandatory documents required by the collaborating body,
                                                        will be submitted for acceptance and approval of admission. Once approved, the applicant may proceed to
                                                        undertake studies and exams according to the parameters and protocols of the related body.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        37. Certifications: The courses offered at IICTN come with IICTN certification, while courses from collaborating
                                                        entities come with their respective certifications. Certificates will be issued only after the completion of the
                                                        course and successful completion of the examinations. IICTN will not be responsible or accountable for the
                                                        quality, design, or format of any online or offline documents from the collaborating universities, councils,
                                                        institutions, or private organizations.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        38. Job Assistance: Indian Institute of Cosmetology, Trichology and Nutrition Private Limited (IICTN) is a
                                                        private body that offers skills-enhancing courses for the beauty, health, and wellness sectors. The said
                                                        institute is neither a college nor a university, nor is it a deemed university. The course fees paid by
                                                        applicants are only for the purpose of learning the course. If, IICTN Staff / Counsellor has promised anything
                                                        apart from mentioned terms, it will not be acknowledged by the institute.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        Success or failure of the individual in practice, a job, or business is attributable to the individual’s
                                                        capabilities, and IICTN shall not be responsible for any lapses or failures. IICTN is to be indemnified for any
                                                        claim by the applicant or client of any kind whatsoever, as IICTN is opposed to malpractice. The certificates
                                                        are awarded for course learning and are not a licence to practise injectable procedures such as Botox, Fillers,
                                                        and Hair Transplant etc. The procedures must be carried out in accordance with applicable government laws,
                                                        regulations, and guidelines.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        If an applicant is applying for a job and the institute needs to verify their certificate or if they need
                                                        additional documents such as a marksheet, appraisal letter, or syllabus of the related course, they must pay an
                                                        additional charge of Rs. 10,000/-.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        39. Documents Verifications: National and international document verification and recruitment agencies have
                                                        different systems, criteria, and parameters, and an institute may not fulfil or meet those criteria. The
                                                        institute will verify the authenticity of the applicant's certificate only via email, and no other documents of
                                                        the institute or company will be shared with the applicant, recruitment agency, or document verification agency
                                                        in accordance with the company's data protection and confidentiality policy. The institute reserves the right to
                                                        deny any request for the same.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        40. Refund Policy: According to company policy, once admission is granted, it cannot be cancelled. The institute
                                                        strictly adheres to a no-refund policy for any reason. Any study materials in any form including printable,
                                                        digital, books, PPTs, notes, videos, audios, or online and offline lectures once shared with the applicant or
                                                        accessed by the applicant through any method or platform, will be considered delivered. Additionally, if the
                                                        applicant has been added to the course group and a topic or relevant class has commenced, or if the applicant
                                                        has attended even a single offline or online theory or practical class, it will be acknowledged by the
                                                        institute. The terms stated above under the fee section will apply in such cases.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        Furthermore, fee refund requests will not be addressed or accepted under any circumstances, including epidemics,
                                                        pandemics, civil wars, world wars, government regulations, medical issues affecting the applicant or a family
                                                        member, or the sudden demise of the student, whether occurring at the beginning or at any time during the
                                                        course, even if the duration extends beyond the actual course duration. This policy also applies if the
                                                        institute is required to remain closed due to regulations from central or state governments or local
                                                        authorities, or for any other reason. Therefore, we kindly ask that applicants refrain from creating panic or
                                                        disturbances. If government rules and regulations change for any reason, the institute accepts no responsibility
                                                        or liability for any refunds or compensation for the same.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        41. Products & Vendors Policy: The institute follows a strict policy not to patronise any brand or supplier. The
                                                        institute’s trainers and consultants are responsible for the courses that applicants have enrolled in. While
                                                        teaching, trainers do use products and machines and talk about the specifications, brand, supplier, etc.
                                                        However, this should not be interpreted as a recommendation or sales pitch by staff acting as an agent on behalf
                                                        of suppliers. Many vendors may indulge in wrongdoing, like providing defective products or machines, or
                                                        promising urgent delivery, a guarantee, a warranty, or an AMC, and may even use staff names to collect any
                                                        advances, etc. Applicants must do their own due diligence and survey before purchasing any product or machine
                                                        and be responsible for their purchase decision. We advise you to be careful and vigilant. Any deal by any
                                                        student with any supplier or representative citing staff connection or recommendation will not be entertained by
                                                        the institute as per the above policies. Institute will not be held accountable or responsible for the same in
                                                        the future.
                                                    </p>

                                                    <p style="text-align:justify;">
                                                        42. Referral Incentives Policy: If an applicant refers other applicants to the institute for courses, the
                                                        institute offers an 8% incentive on actual course fees only to the referrer, or the referrer can take a workshop
                                                        or service at the institute for a 10% incentive. To claim an incentive, the applicant must provide the joiner's
                                                        details well in advance (before the applicant visits or joins us) by email only at info@iictn.org with the
                                                        joiner’s name, contact details, qualifications, and course suggested to the joiner. The reference should be of
                                                        the person who has not yet joined the institute and has come to know about us only through the referrer. Please
                                                        do not refer a colleague or friend who has already enrolled in a course with us and whose referrer has met the
                                                        joinee in our premises or outside, or even visited with the referrer during their own first or other previous or
                                                        later inquiries and enrollment in the institute, as it will not be conceded under our incentive policy. The
                                                        incentive will be given only after the full payment is made by the joiner, and the amount will be given only on
                                                        the course fee amount, excluding 20% tax and levies, admin, and exam fees. The incentive will be given on the
                                                        enrollment of the first fee package. If joined or paid for by the joinee only, the joining of further
                                                        consecutive courses by the reference will not be considered. Incentives for referrals for the entire month are
                                                        credited to the referrer's bank account between the 25th and 30th of the next month, after TDS is deducted. The
                                                        incentive will be cancelled if there is any confusion between the institute, referrer, and reference.
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        43. Data Protection Policy: Applicants are strictly prohibited from using their personal electronic devices such
                                                        as laptops, mobile phones, tablets, cameras, headphones, etc. and are also restricted from recording videos,
                                                        short clips, clicking photographs, taking screenshots, etc. during their online or offline theory classes or
                                                        lectures, practical sessions, or treatments, etc. They are also not allowed to share any data provided by the
                                                        institute, trainers, or management through any online or offline sources. All documents, contact details, study
                                                        materials, notes, PPTs, videos, audios, etc. are copyrighted and the sole property of the institute.
                                                        <li>Applicants are strongly advised and prohibited from sharing or exchanging their personal details like mobile
                                                            numbers, personal email ids, online and offline social media accounts with trainers or lecturers, and from
                                                            inviting any staff of the institute for seminars, workshops, chief guests, personal and client treatment,
                                                            consultation, training, personal and professional ceremonies, the inauguration or opening of their centre,
                                                            or by any other means. As per policy, institute staff are strictly restricted from sharing personal details
                                                            like mobile numbers, online and offline social media platforms, and attending any of the above-mentioned
                                                            events and activities without prior written or email approval from the board members of the institute. If
                                                            the institute finds you indulging in any of the above-mentioned events, activities, knowingly or
                                                            unknowingly, from any open or confidential source, it will be considered anti-organisational activity, and
                                                            the applicant's admission will be cancelled with immediate effect without any refund or compensation; for
                                                            pass-out applicants, their certificate will be cancelled and nullified with immediate effect, and they are
                                                            bound to submit their original certificate to the institute within 48 hours. The institute reserves the
                                                            right to take any appropriate online and offline applicant awareness action as well as legal action against
                                                            the related applicant and staff, and all the losses and legal expenses will be recovered from the applicant.
                                                        </li>
                                                        <li>Furthermore, as per the employee protection policy, applicants are strictly advised to maintain the most
                                                            civilised manners and ethics throughout their entire course(s) duration and are strictly prohibited from
                                                            having any personal relationship or affair with any permanent, contractual, or probationary employee,
                                                            vendor, dealer, business associate, etc., of the Institute / company. If these things happen or are found
                                                            for any reason, the company has the right to cancel your admission and terminate the employment of any
                                                            related employees with immediate effect, without any refund, partial or full, and without any compensation.
                                                            The company has the right to take other appropriate action against both parties.</li>
                                                        <li>If management finds any applicant having wrong conduct, misguiding, misleading, and misbehaving with other
                                                            applicants, trainers, lecturers, or staff as per their own conclusions and/or against the Institute policy
                                                            in any digital, verbal, online, offline, or any other media, they will be immediately removed from the group
                                                            without any prior notice or explanation by the management.</li>
                                                        <li>If the misbehaviour continues, their admission will be revoked with immediate effect, with no refund or
                                                            compensation, and they will be charged the monetary penalty. The institute reserves the right to file a
                                                            defamation case against a related applicant for spoiling the brand name if found necessary, and all legal
                                                            expenses will be borne by applicants.</li>
                                                    </p>
                                                    <p style="text-align:justify;">
                                                        44. Indemnity: Applicants, their family, relatives, friends, or any other associates agree to release, defend,
                                                        indemnify, and hold harmless the company and its directors, board members, staff, employees, trainers,
                                                        lecturers, visiting faculty, vendors, dealers, business associates, and so on, whether permanent, contractual,
                                                        or probationary, from and against any claims, liabilities, damages, losses, expenses, and compensation arising
                                                        out of or in any way related to the use of our resources, methods, practice, services, treatment or any other
                                                        reason whatsoever weather.
                                                    </p>
                                                </body>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row has-warning">
                                        <div class="col-sm-12">
                                            <div>
                                                <input id="accept_terms" class="accept_terms" name="accept_terms"
                                                    type="checkbox">

                                                <!--<label for="accept_terms">I Accept <a class="show_terms" href="">Terms & Condition</a> Of IICTN</label>-->
                                                <label for="accept_terms">I Accept Terms &amp; Condition Of
                                                    IICTN</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-4 offset-sm-2">
                                            <button type="reset" class="btn btn-secondary">Reset Form</button>
                                            <!-- <button type="submit" name="new_student" id="submit" class="btn btn-primary">Submit Registration Form</button>-->
                                            <button type="submit" name="new_student" id="submit" value="submit"
                                                class="btn btn-primary submit">Submit
                                                Registration Form</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Updates Section -->

        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <p>IICTN Studentd Registration © 2019</p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <!--<p>Powered by Agency Moksa</p>-->
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- Javascript files-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://iictn.org.in/admission/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"> </script>
    <script src="https://iictn.org.in/admission/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://iictn.org.in/admission/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="https://iictn.org.in/admission/js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="https://iictn.org.in/admission/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script
        src="https://iictn.org.in/admission/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js">
    </script>
    <script src="https://iictn.org.in/admission/js/charts-home.js"></script>
    <script src="https://iictn.org.in/admission/js/front.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.submit').prop("disabled", true);
        });

        $(function() {
            $("#dateofbirth").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: "-14Y 0D",
                changeMonth: true,
                changeYear: true
            });
            /*$( "#pass_year" ).datepicker();
            $('#pass_year').datepicker( {
                changeMonth: true,
                changeYear: true,
                dateFormat: 'MM yy',
                onClose: function(dateText, inst) { 
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            });
            */
            for (i = new Date().getFullYear(); i > 1947; i--) {
                $('#pass_year').append($('<option />').val(i).html(i));
            }
        });


        $(".accept_terms").click(function() {
            if ($(this).prop("checked") == true) {
                $('.submit').prop("disabled", false);
            } else if ($(this).prop("checked") == false) {
                $('.submit').prop("disabled", true);
            } else {
                $('.submit').prop("disabled", true);
            }
        });


        $(document).ready(function() {
            $('#country').on('change', function() {
                var country_id = this.value;
                $.ajax({
                    url: '<?php echo $ark_root;?>states-by-country.php',
                    type: "POST",
                    data: {
                        country_id: country_id
                    },
                    cache: false,
                    success: function(result) {
                        $("#state").html(result);
                        $('#city').html('<option value="">Select State First</option>');
                    }
                });


            });
            $('#state').on('change', function() {
                var state_id = this.value;
                $.ajax({
                    url: '<?php echo $ark_root;?>cities-by-state.php',
                    type: "POST",
                    data: {
                        state_id: state_id
                    },
                    cache: false,
                    success: function(result) {
                        $("#city").html(result);
                    }
                });
            });
        });

     
        $(document).ready(function() {
            $("#registration_form_details").on("submit", function(){
                $(".loader_ajax").show();
            });
        });
</script>
     


    </script>


    <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
    </div>
</body>

</html>

    <div class="loader_ajax" style="display:none;">
	    <div class="loader_ajax_inner"><img src="preloader_ajax.gif"></div>
        <p style="margin-left: 34%;margin-top: 25%;font-size: xx-large;">Please wait your form is submitting...</p>
	</div>

<?php
}
?>