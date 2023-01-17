<?php

// include composer packages
include "vendor/autoload.php";
include "../db/config.php";

 $student_id = $_GET['student_id'];

 $result = $conn->query("SELECT * from  tbl_users  
                         join tbl_student_answer_sheet on tbl_users.userid = tbl_student_answer_sheet.student_id
                         join tbl_course on tbl_student_answer_sheet.course_id = tbl_course.courseId
                         where tbl_users.userid=$student_id and tbl_users.isDeleted=0 and tbl_users.user_flag='student' group by tbl_student_answer_sheet.student_id");

 $result_arry = $result->fetch_assoc();
 $student_name = $result_arry['name'].' '.$result_arry['lastname'];
 $course_name = $result_arry['course_name'];
 $profile_pic = $result_arry['profile_pic'];

 
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
$pdf->SetFontSize('30'); // set font size
$pdf->SetXY(10, 160); // set the position of the box
$pdf->Cell(0, 10,  $student_name, 0, 0, 'C'); // add the text, align to Center of cell

// add the reason for certificate
// note the reduction in font and different box position
$pdf->SetFontSize('20');
$pdf->SetXY(10, 140);
$pdf->Cell(0, 10,  $course_name, 0, 0, 'C');

// the day
$pdf->SetFontSize('20');
$pdf->SetXY(165.50,232);
// $pdf->Cell(20, 10, date('d'), 0, 0, 'C');

if($profile_pic){

$profile_pic_img = "../uploads/profile_pic/".$profile_pic;


$pdf->Cell(8, 8, $pdf->Image($profile_pic_img, $pdf->GetX(), $pdf->GetY(), 23.78), 0, 0, 'L', false );
}


// // the month
// $pdf->SetXY(160,122);
// $pdf->Cell(30, 10, date('M'), 0, 0, 'C');

// // the year, aligned to Left
// $pdf->SetXY(200,122);
// $pdf->Cell(20, 10, date('y'), 0, 0, 'L');

// render PDF to browser
$pdf->Output();