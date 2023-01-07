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


if ($_SERVER["REQUEST_METHOD"] == 'POST' ) {

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

    $sql = "INSERT INTO tbl_admission (enq_id,`name`,lastname,gender,mobile, alt_mobile,email,dateofbirth,counsellor_name,`address`,city,`state`,country,pin,source_about,source_ans,accept_terms,registration_type,document_1,document_2,document_3,isDeleted) 
                               VALUES ('$enq_id','$name','$lastname','$gender','$mobile','$alt_mobile','$email','$dateofbirth','$counsellerName','$address','$city','$state','$country','$pin','$source_about','$source_ans','$accept_terms','Weblink','$final_file_student_photo','$final_file_marksheet_photo','$final_file_adhar_photo','0')";

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
                    $Subject = 'IICTN -  Login Link '.date('Y-m-d H:i:s');
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
                                    <td>https://www.iictn.in/</td>
                                </tr>

                                <tr>
                                    <td><b>User Name (First Name  or Email Id or Mobile Number )</b></td>
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

                    $header = "From: IICTN-Login Link <enquiry@iictn.in> \r\n";
                    //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";


                    if($_SERVER['HTTP_HOST']=='localhost'){
                         echo ("<script> window.alert('Succesfully Registerd');window.location.href='success.php?enq=$enq_id';</script>");
                    }else{

                        $retval = mail($to,$Subject,$Body,$header);
                     
                        if($retval){
                            echo ("<script> window.alert('Succesfully Registerd');window.location.href='success.php?enq=$enq_id';</script>");
                        }else{
    
                            echo ("<script> window.alert('No Record Store')");
                        }

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
    
    $conn->close();
}

?>


<!-- check if Admission is allreday Done -->

<?php
$check_admission_is_alreday_exits = "SELECT *  FROM tbl_admission where enq_id=$enq_id and isDeleted=0" ;
$result_check_admission_is_exits = $conn->query($check_admission_is_alreday_exits);


if($result_check_admission_is_exits->num_rows > 0){ ?>


<!DOCTYPE html>
<html>

<head>
    <title>Admission Alreday Done</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
</head>

<body class="">
    <article class="bg-secondary mb-3" style="background-color:#fff !important">
        <div class="card-body text-center">
            <img  src="https://iictn.in/assets/img/logos/iictn_lms.png" width="150px" height="150px" alt="Company Logo"/>

            <h2 class="text-black"><b>!! Admission Alreday Done !!</b><br></h2>
        </div>
        
    </article>
</body>

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
                                <h1 class="h4">Student Registration Form</h1>
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
            
                                            $sql = "SELECT * FROM tbl_users join tbl_roles on tbl_users.roleId=tbl_roles.roleId  where tbl_users.isDeleted='0' and tbl_roles.role='Counsellor'" ;
                                            $result = $conn->query($sql);
                                            while($row = mysqli_fetch_array($result)) { ?>
                                                <option value="<?php echo $row["userId"];?>"><?php echo $row["name"];?>
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
                                                accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                            <small class="text-default">( Upload photo as required on certificate
                                                )</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="file" id="marksheet_photo" name="marksheet_photo"
                                                class="form-control"
                                                accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                            <small class="text-default">( Upload Highest Education Certificate )</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="file" id="adhar_photo" name="adhar_photo" class="form-control"
                                                accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                            <small class="text-default">( Upload Aadhar Copy)</small>
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
                                                <br>
                                                Applicants are advised to note, The selection of the courses and
                                                packages are based on individual’s understanding and due diligence.
                                                Course fee and package can differ from other applicants.
                                                <br>
                                                <br>

                                                <b>MANDATORY DOCUMENTS REQUIRED BEFORE STARTING THE COURSE:</b><br>
                                                a. Passport size colour photograph<br>
                                                b. For Doctors - Medical Registration / For Non-Doctor - Highest
                                                Education Certificate<br>
                                                c. Aadhar Card<br><br>
                                                <br>

                                                1. <b> Fees:</b>If Applicant has paid a registration fee of Rs. 5,000/-
                                                Registration will be valid for 3 months from the date of admission.
                                                Kindly note along with each enrolled course, Applicant has to pay
                                                Applicable exam fee of Rs. 2,600/- plus one time admin fee of Rs.
                                                2,600/- extra. Apron Reissue Fee is Rs. 600/-, Hair Basic Kit is Rs.
                                                7,800/-, Basic Make-up Kit is Rs. 7,800/-, Advance Make-up Kit is Rs.
                                                26,000/- to 1, 00,000/- (Optional).
                                                <br><br>

                                                2. <b>Instalments:</b> Fees can be paid in two installments of two weeks
                                                apart, 75% as the first installment with exam fee extra to begin the
                                                course, if paying in installment, applicants are only allowed to attend
                                                lectures once in a week. Kindly note the book / study materials will be
                                                issued after full payment of the course fees. If, the applicant is
                                                unable to pay the balance fee amount within two months due to whatsoever
                                                reason, the applicant will not be entitled for any refund. The institute
                                                however may be at the sole discretion to accommodate applicant with the
                                                next batch schedule and can guide to convert the course into a short
                                                certificate course or services.
                                                <br><br>
                                                3. <b>Education Loan:</b> Applicants are advised to do their own due
                                                diligence before opting for any education loan service from the
                                                financial institutions provided by IICTN or from any other financial
                                                Institutions, Institute will not be Responsible / Accountable for any
                                                dispute now and in the future.
                                                <br><br>
                                                4. <b>Online / Offline Classes:</b> Kindly cooperate with the faculty
                                                &amp; attend courses as per Institute’s Class timings / Topics /
                                                Trainers &amp; lecturers / Method of teaching / Online and Offline
                                                Platform of Teaching &amp; Time table. Topics once taught will not be
                                                repeated, Topics if missed have to be studied by the applicant
                                                themselves from books / notes provided by the institute. Applicants can
                                                give exams online if their courses have only theory and no practical.
                                                Classes are daily for 1.5 hour for each courses (subjective to course
                                                opted) for which time table is posted in start of every month, Each
                                                course duration will last for 3 months but if due to any medical issues
                                                / marriage etc, course completion validity can be extended to 06 months
                                                if relevant documents are provided by the applicant via email.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;<b>Offline Practical Sessions:</b> Once the
                                                relevant theory class is completed, students can come for offline
                                                practical. Schedule can change any time subject to government
                                                rules/norms from time to time and the institute holds no responsibility
                                                or liability for the same.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;<b>Online Practicals:</b> Once the relevant
                                                theory class is completed , student will be removed from theory group
                                                &amp; added in Online practical group with online / live videos that can
                                                be shared &amp; explained once or twice a week.
                                                <br><br>
                                                5. <b>Machines Use:</b> If Applicant breaks any machine he / she has to
                                                pay Rs. 5,000/- or 30% of the actual cost of the part of the machines on
                                                very next day itself. Thus while Practicals applicants are advised look
                                                after Equipment / Machines carefully.
                                                <br><br>
                                                6. <b>Certificates:</b> In order to secure the certificate, Applicants
                                                should complete theory and practical’s both and clear the examination of
                                                the course (s) with 75% passing mark. Certificate will be awarded after
                                                3 months after institute receives confirmation email of applicant for
                                                completion of the course.It is mandatory to email copy of all bills on
                                                admin@iictn.org when applying for certification as all applicants have
                                                different combinations of courses. Applicants are not allowed to attend
                                                theory and Practical classes after the exams orissuance of
                                                certifications, Please be ethical and start making your professional
                                                commitment only after you have been awarded the certificate.
                                                <br><br>
                                                7. <b>Books / Certificate:</b> canbe couriered or can be collected
                                                personally. Applicable charge of Rs.200/-per courier should be borne by
                                                applicant withinIndia andfor international actual cost of courier must
                                                be borne by the applicant only. Institute will not beresponsible for any
                                                damages / Loss of any documents.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;a. In case of damage / Loss of book - per book
                                                Reissue charges areRs. 600/-
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;b. In case of damage / Loss / Name Changed etc.
                                                of Certificate -per certificateReissue charges are Rs. 5000/-. All the
                                                cost of any reissuing of any documents must be borne by applicant only.
                                                <br><br>
                                                8. <b>Attendance:</b> Minimum attendance required is 85%, failing which
                                                Applicant will not be allowed to appear for the exams. For more than 3
                                                days absence please email documents for leave. However, in case of
                                                sudden illness where prior permission is not possible, a medical
                                                certificate by a doctor must be emailed at admin@iictn.org, Please do
                                                not attend class or be the model for the practical of the courses which
                                                you have notpaid fees / Enrolled otherwise Applicant will have to pay
                                                Rs. 2,600/per lecture extra by next day only.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;a. Course completion validity period is up-to 06
                                                months only, Post 6 months Applicant will be charged Rs. 2,600/- for
                                                each course to finish the pending portion within one month.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;b. Institute is not responsible for cover-up, if
                                                the Applicant misses his / her classes for whatsoever reason or course
                                                duration extends beyond 6 months.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;c. The institute reserves the rights to Change
                                                and Modify the Course Curriculum / location of classes / Class timings /
                                                Topics / Trainers &amp; lecturers / Method of teaching / Online and
                                                Offline Platform of Teaching / Time table may be changed at any given
                                                time subject to the discretion of the management and It shall be abiding
                                                on the Applicant to undergo for the same.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;d. Post 6 months, if applicants wish to learn
                                                full course again, they have to pay 30% of course fee again for study of
                                                that course within 02 months. Please do not take leave during these 02
                                                months.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;e. Applicant authorize and give consent to the
                                                institute that they have been clearly explained and informed by the
                                                trainer / staff / Management that the Practicals Class, Demonstration
                                                class, procedure will be done with due care and the possible effects and
                                                Post care precautions have to take after the procedures.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;f. Applicants are consensually and volunteering
                                                taking the part as a model in practical / demonstration / procedures
                                                during the class at their own will and risk and they will not hold the
                                                trainer, students, owner, associate owner or any other staff of the
                                                Institute responsible for any side effects / injury like redness,
                                                swelling, discoloration of skin, peeling, pain, burn, burning sensation,
                                                or mishap if any during the course of treatment. Further complications
                                                like infection, haemorrhage, bleeding, scaring, contraction, possible
                                                deformities, prolonged healing time over the estimate reaction to any
                                                drug before and after or during Procedures, numbness or itching of the
                                                area have been clearly explained.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;g. I am willingly and voluntarily participating
                                                in the video / photo shoot . I feel privileged to be part of this video
                                                &amp; photo. I allow Institute to use my Photo / Video Testimony /
                                                Lecture / Practical / Demo with other students / Staff / Clients &amp;
                                                also I agree &amp; endorse my consent that my video / photo / credential
                                                can be used by the Institute for Branding, Marketing, Hoardings,
                                                Promotions, Website, Press Releases , Media advertisements , DVD /
                                                Brochures / PPT / books / Online / Offline Purposes. I will not claim
                                                any charges, Royalty or compensations now or any time in future also
                                                from the institute or institute chains or any channel owner etc.
                                                <br><br>
                                                9. <b>Refund Policy:</b> fee refund request will not be entertained and
                                                excepted due to Epidemic / Pandemic / Government regulation / Medical
                                                issues of self or family member in the beginning or anytime during the
                                                duration of the course, even if the duration extends longer than actual
                                                duration and also if Institute is asked to be kept closed due to Govt
                                                Regulation. Thus please do not panic and create nuisance as admission
                                                once granted will not be cancelled as Institute strictly follows no
                                                refund policy. Please note each webinar / lecture cost is Rs 2600/-
                                                <br><br>
                                                10. <b>Products &amp; Vendors:</b> Institute follows strict policy not
                                                to patronize any brand or supplier. Institute’s trainers and consultants
                                                are responsible for courses that applicants have enrolled, While
                                                teaching trainers do use products and machines and talk about the
                                                specifications, brand or supplier etc. But that should not be presumed
                                                as recommendation or sale pitch as if staff is acting as agent on behalf
                                                of suppliers. Many vendors may indulge in wrong doing like providing
                                                defective products, machines or promise urgent delivery, guarantee,
                                                warranty, AMC and may even use staff names to collect huge advance etc.
                                                Applicants must do their own due diligence and survey before purchase of
                                                any product or machines and be responsible for their purchase decision.
                                                We advise you to be careful and vigilant. Any deal by any student with
                                                any supplier or representative citing staff connection / recommendation
                                                will not be entertained by IICTN as per above policies. IICTN will not
                                                be responsible and answerable for the same anytime in the future.
                                                <br><br>
                                                11. <b>Data Protection Policy:</b> Applicants are not allowed to share
                                                any data provided by the management from any online / offline sources .
                                                All Documents/ Contact Details / Study Material / Notes / PPT / Video /
                                                Audio etc. are copyrighted and property of the institute.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;If management finds any applicant having wrong
                                                conduct, misguiding, misleading and mis behaving with other Applicants /
                                                Trainer / Lecturer / Staff as per their own conclusions and or against
                                                the Institute policy in any digital / verbal / online / offline or any
                                                other media, they will be immediately removed from the group without any
                                                prior notice /explanation by the management.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;Also if the mis conduct continues , their
                                                admission will stand cancelled with immediate effect without any
                                                refund&amp; Penalty will be imposed on them. Institute reserves the
                                                right to put defamation case against related applicant for spoiling the
                                                name of the brand if found necessary and all legal expenses will be
                                                borne by students.
                                                <br><br>
                                                12. <b>Job Assistance:</b> Indian Institute of Cosmetology, Trichology
                                                and Nutrition Private Limited (IICTN) is a private body in skills
                                                enhancing courses for the Beauty Health &amp; Wellness sector. The said
                                                institute is neither a college, nor a University or a Deemed University.
                                                Course fees paid by applicant is only to get skill in course.If, IICTN
                                                Staff / Counsellor has promised anything apart from mentioned terms, it
                                                will not be acknowledged by the institute. The applicant understands
                                                that IICTN provides only guidance for job but does not guarantee or
                                                assure any job Nationally / Internationally.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;Success or failure of the individual in Practice
                                                / Job / Business is attributable to the individual’s capabilities and
                                                IICTN shall not be responsible for any lapses / failure. IICTN is to be
                                                indemnified for any claim by the applicant / clients of any kind
                                                whatsoever as IICTN is opposed to all malpractices. These certificates
                                                are awarded for skills and are not a license to practice in the
                                                injectable procedures such as Botox, Fillers and Hair Transplant etc.
                                                Such procedures are to be done under supervision of or by M.B.B.S.
                                                doctor duly qualified or as per prevailing Acts / Regulations.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;If applicant is applying for a job and require
                                                to verify their certificate by Institute or require extra documents like
                                                Marksheet and Appraisal letter than applicant should pay Rs. 10,000/-
                                                Extra.
                                                <br><br>
                                                13. <b>Collaborated Courses Admissions Terms:</b> IICTN vision and
                                                mission are to provide opportunities in specialisations and skill
                                                education which are demographically relevant, in-demand and as per laid
                                                down standards, To meet the mission, IICTN collaborates with University
                                                / Council / Institution and Private organizations for relevant courses,
                                                but Applicants are advised to do their due diligence before opting for
                                                Collaborated courses. Applicant should not hold IICTN responsible for
                                                any guidance of Admission / Study facilitation / Placement in India or
                                                Abroad anytime in the future. Thereafter, the duly filled application
                                                forms along with documents are sent for acceptance and approval, Once
                                                its approved, such applicant can proceed to undertake studies as per
                                                syllabus and schedule.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;Please note If applicant has joined any third
                                                party collaborated institute / university / Council courses through
                                                IICTN, Applicant is advised to coordinate directly to them for any
                                                query, IICTN will not be responsible and answerable for the same.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;Further note, that the time frames for receipt
                                                of certificates are not in control of IICTN for Non-IICTN course. If,
                                                Applicant has any query regarding Fee, Classes, Practicals, Exams,
                                                Certifications and Placement, IICTN advises that the Applicant should
                                                send their queries directly to the related University / Council /
                                                Private organisation onlynow or anytime in future.
                                                <br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;The courses opted at IICTN comes with IICTN
                                                certification and courses from University / Council / Institution and
                                                Private organisation comes with their certification. Certificates will
                                                be issued after clearing theory and practical examinations held at
                                                nominated examination centres.
                                                <br><br>
                                                14. <b>Please Note:</b> National / International Document Verification
                                                &amp; Recruitment agencies have different Systems / Criteria /
                                                Parameters and institute may not fulfil and meet those criteria,
                                                Applicant’s authenticity of certificate verification will be done by
                                                Institute through email only and no other documents of Institute /
                                                Company will be share with Applicant, Recruitment and Document
                                                Verification agency as per confidential policy of the company. Institute
                                                reserves the right to deny any request for the same.
                                                <br><br>
                                                15. <b>Administration:</b> If Applicant has any query regarding Courses
                                                Fee, Learning, Classes, Practicals, Exams or Certifications, Therefore,
                                                we advise that Applicant should send their queries viaWhatsApp /
                                                Telegram on 9820000030 or email <a
                                                    href="mailto:info@iictn.org">info@iictn.org</a> Applicant queries
                                                will be attended in 10 working days as approvals come from management,
                                                Applicant cooperation will be appreciated.
                                                <br><br>
                                                16. <b>Reference:</b> If applicant wishes to refer other student for
                                                courses at IICTN, Institute gives 3% incentive on actual course fees
                                                only to the referrer or the referrer can do workshop worth 10% , To
                                                claim an incentive, applicant must provide joiner’s details prior
                                                (Before the applicant visits or joins us) by email only on <a
                                                    href="mailto:info@iictn.org">info@iictn.org</a> with joinee’s name,
                                                contact Details, Qualification &amp; course suggested to joiner, The
                                                reference should be of the person who has not yet joined IICTN &amp; has
                                                come to know about us, only through referrer. Please do not refer a
                                                colleague or friend who has already joined course with us and referrer
                                                has met the joinee in our premise or outside. Incentive will be given
                                                only after the full payment by the joiner and amount will be given only
                                                on course fee amount, excluding 20% tax, admin and exam fees paid,
                                                Incentive will give on the enrolment of first fee package Joined / Paid
                                                by joinee, joining of further consecutive courses by the reference will
                                                not be considered. Incentives of references for the whole month be
                                                credited to the referrer bank account between 25th to 30th day of the
                                                month along with deduction of TDS. In case of any confusion among the
                                                Institute, Referrer &amp; Reference, incentive will stand cancelled.
                                                <br> <br>

                                                <b>Note:</b> This is a computer generated copy, Applicant signature is
                                                not required. Acceptance of the terms and conditions will be
                                                acknowledged by default and applicants shall abide by the same.<br> <br>

                                                <b>By-Laws:</b> Terms and Conditions are non-negotiable and subject to
                                                change without any prior notice and will be abided by the applicant,
                                                Dispute if any, is subject to Mumbai Jurisdiction only.<br> <br>



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
    </script>

    </script>

    <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
    </div>
</body>

</html>

<?php
}
?>