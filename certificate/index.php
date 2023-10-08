<?php

// include composer packages
include "vendor/autoload.php";
include "../db/config.php";
include "phpqrcode/qrlib.php" ;
    

 $student_id = $_GET['student_id'];

 $result = $conn->query("SELECT * from  tbl_users  
                         join tbl_student_answer_sheet on tbl_users.userid = tbl_student_answer_sheet.student_id
                         join tbl_course on tbl_student_answer_sheet.course_id = tbl_course.courseId
                         join tbl_course_type on tbl_course_type.ct_id = tbl_course.course_type_id
                         where tbl_users.userid=$student_id and tbl_users.isDeleted=0 and tbl_users.user_flag='student' group by tbl_student_answer_sheet.student_id");

 $result_arry = $result->fetch_assoc();
 $student_name = $result_arry['name'].' '.$result_arry['lastname'];
 $course_name = $result_arry['course_name'];
 $profile_pic = $result_arry['profile_pic'];


 $mobile = $result_arry['mobile'];
 $evbtr = $result_arry['evbtr'];

 $admision_date = $result_arry['createdDtm'];

 $ct_name = $result_arry['ct_name'];

 $userid=$result_arry['userId'];

 
// Create new Landscape PDF
// $pdf = new FPDI('l');

// $pdf = new \setasign\Fpdi\Fpdi('l');
$pdf = new \setasign\Fpdi\Fpdi();

// Reference the PDF you want to use (use relative path)
$pagecount = $pdf->setSourceFile( 'certificate.pdf' );

// Import the first page from the PDF and add to dynamic PDF
$tpl = $pdf->importPage(1);
$pdf->AddPage();

// Use the imported page as the template
$pdf->useTemplate($tpl);

// Set the default font to use
$pdf->SetFont('Helvetica');

// adding a Cell using:
// $pdf->Cell( $width, $height, $text, $border, $fill, $align);



// First box - the user's Name
$pdf->SetFontSize('25','B'); // set font size
$pdf->SetXY(10, 162); // set the position of the box
$pdf->Cell(0, 10,  $student_name, 0, 0, 'C'); // add the text, align to Center of cell

// First box - the user's Name
$pdf->SetFontSize('10'); // set font size
$pdf->SetXY(110, 205); // set the position of the box
$pdf->Cell(0, 1,  $evbtr, 0, 0, 'C'); // add the text, align to Center of cell


// add the reason for certificate
// note the reduction in font and different box position

$pdf->SetFontSize('30');
$pdf->SetXY(10, 125);
$pdf->MultiCell(190,11,$course_name, '0', 'C', 0);

// the day
$pdf->SetFontSize('20');
$pdf->SetXY(165.50,232);
// $pdf->Cell(20, 10, date('d'), 0, 0, 'C');

$getStudentadmissionDetails = "SELECT tbl_admission.document_1 FROM tbl_users_enquires join tbl_admission on tbl_users_enquires.enq_id= tbl_admission.enq_id where tbl_users_enquires.user_id=$userid" ;
$resultStudentadmissionDetails = $conn->query($getStudentadmissionDetails);
$rowDataStudentadminssiondetails = $resultStudentadmissionDetails->fetch_assoc();


$profile_pic_admission = $rowDataStudentadminssiondetails['document_1'];

if($profile_pic_admission){
    $profile_pic_img = "../uploads/admission/".$profile_pic_admission;

    if(file_exists($profile_pic_img)) 
    {
        $pdf->Cell(20, 10, $pdf->Image($profile_pic_img, $pdf->GetX(), $pdf->GetY(), 25.00,33.00), 0, 0, 'L', false );
    }   
}


if($_SERVER['HTTP_HOST']=='localhost'){
    $base  = "http://".$_SERVER['HTTP_HOST'];
    $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

}else{
    $base  = "https://".$_SERVER['HTTP_HOST'];
    $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

}


$pdf->SetFontSize('20');
$pdf->SetXY(15,232);

$content = $base.'certificate_overview.php?student_id='.$student_id;
QRcode::png($content,'QR_CODE.png') ;

$orcode_file = "QR_CODE.png";
$pdf->Cell(8, 8, $pdf->Image($orcode_file, $pdf->GetX(), $pdf->GetY(), 23.78), 0, 0, 'L', false );


$pdf->SetFontSize('10');
$pdf->SetXY(42,270.2);
$pdf->Cell(0, 1,  $admision_date, 0, 0, 'L');


$pdf->SetFontSize('10');
$pdf->SetXY(42,275.6);
$pdf->Cell(0, 1,  date('Y-m-d H:i:s'), 0, 0, 'L');

$pdf->SetFontSize('10');
$pdf->SetXY(145,275.6);
$pdf->Cell(0, 1,  $mobile.'/'.date("y",strtotime("-1 year")).'-'.date("y").'/WEB/MUM', 0, 0, 'L');


// // the month
// $pdf->SetXY(160,122);
// $pdf->Cell(30, 10, date('M'), 0, 0, 'C');

// // the year, aligned to Left
// $pdf->SetXY(200,122);
// $pdf->Cell(20, 10, date('y'), 0, 0, 'L');

// render PDF to browser
$pdf->Output();


?>