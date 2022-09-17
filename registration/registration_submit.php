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
      echo ("<script> window.alert('Succesfully Registerd');window.location.href='success.php?enq=$enq_id';</script>");
        //echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
    
}


?>