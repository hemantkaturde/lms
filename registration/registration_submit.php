<?php
include_once('../db/config.php');

if($_SERVER['HTTP_HOST'] == 'localhost')
{
	$REQUEST_METHOD = 'POST';
}
else
{
	$REQUEST_METHOD = 'GET';
}


if ($_SERVER["REQUEST_METHOD"] == $REQUEST_METHOD ) {

    /*All post params here*/
    $enq_id = $_REQUEST["enq_id"];
    $name   = $_REQUEST["name"];
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

    $sql = "INSERT INTO tbl_admission (enq_id,`name`, mobile, alt_mobile,email,dateofbirth,counsellor_name,`address`,city,`state`,country,pin,source_about,source_ans,accept_terms,registration_type,document_1,document_2,document_3,isDeleted) 
                               VALUES ('$enq_id','$name','$mobile','$alt_mobile','$email','$dateofbirth','$counsellerName','$address','$city','$state','$country','$pin','$source_about','$source_ans','$accept_terms','Weblink','$final_file_student_photo','$final_file_marksheet_photo','$final_file_adhar_photo','0')";

    if ($conn->query($sql) === TRUE) {

        $username = strtolower(strtok($name, " "));
        $year = date("Y"); 
        $password = base64_encode($name.'@'.$year);

        $sql_create_user = "INSERT INTO tbl_users (email,username,`password`,`name`,mobile,user_flag,roleId,createdBy,isDeleted) 
                              VALUES ('$email','$username',' $password','$name','$mobile','student','3','1','0')"; 
                              

                if ($conn->query($sql) === TRUE) {

                          


                    $to = $email;

                    $Subject = 'IICTN - Login Link '.date('Y-m-d H:i:s');
                    
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
                                    <span style="padding: 5px 0; display: block;">'.$get_equiry_data->enq_date.'</span>
                                </td>
                                </tr>
                            </table>
                            
                            </td>
                            </tr>
                            <tr>
                            <td align="center" style="padding: 20px; border-top: 1px solid #f0f0f0; background: #fafafa;,; ">
                            <div style="line-height: 1.4; font-size: 1.2; font-size: 14px; color: #777;"></div>
                            </td>
                            </tr>

                            <tr style="">
                            <td align="center" style="padding: 15px 20px 20px;">
                            <table width="80%">
                                <tr>
                                <td><b>Username</b></td>
                                <td>'.$username.'</td>
                                </tr>

                                <tr>
                                <td><b>Passwordr</b></td>
                                <td>'.$password.'</td>
                                </tr>
                            </table>
                            </td>
                            </tr>

                            <tr>
                            <td align="center" style="padding: 20px 40px;font-size: 16px;line-height: 1.4;color: #333;">
                            <div> </div>
                            <div><br></div>
                            <div style="background: #ca9331; display: inline-block;padding: 15px 25px; color: #fff; border-radius: 6px">

                            <a href="https://www.iictn.in/" class="btn btn-sm btn-primary float-right pay_now"
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

            $header = "From: IICTN-Payment <enquiry@iictn.in> \r\n";
            //$header .= "Cc:ahemantkaturde123@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            
            $retval = mail($to,$Subject,$Body,$header);



                    echo ("<script> window.alert('Succesfully Registerd');window.location.href='success.php?enq=$enq_id';</script>");

                }else{
                    echo "Error: " . $sql . "<br>" . $conn->error;

                }


      //echo ("<script> window.alert('Succesfully Registerd');window.location.href='success.php?enq=$enq_id';</script>");
        //echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
    
}


?>