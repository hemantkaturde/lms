<?php

// include composer packages
include "vendor/autoload.php";
include "../db/config.php";
include "phpqrcode/qrlib.php" ;
    

 $student_id = $_GET['student_id'];

 $result = $conn->query("SELECT * from  tbl_users  
                         join tbl_student_answer_sheet on tbl_users.userid = tbl_student_answer_sheet.student_id
                         join tbl_course on tbl_student_answer_sheet.course_id = tbl_course.courseId
                         where tbl_users.userid=$student_id and tbl_users.isDeleted=0 and tbl_users.user_flag='student' group by tbl_student_answer_sheet.student_id");

 $result_arry = $result->fetch_assoc();
 $student_name = $result_arry['name'].' '.$result_arry['lastname'];
 $course_name = $result_arry['course_name'];
 $profile_pic = $result_arry['profile_pic'];
 $mobile = $result_arry['mobile'];
 $evbtr = $result_arry['evbtr'];

 
// Create new Landscape PDF
// $pdf = new FPDI('l');

// $pdf = new \setasign\Fpdi\Fpdi('l');
$pdf = new \setasign\Fpdi\Fpdi();

// Reference the PDF you want to use (use relative path)
$pagecount = $pdf->setSourceFile( 'certificate_qr_code_sheet.pdf' );

// Import the first page from the PDF and add to dynamic PDF
$tpl = $pdf->importPage(1);
$pdf->AddPage();

// Use the imported page as the template
$pdf->useTemplate($tpl);

// Set the default font to use
$pdf->SetFont('Helvetica');



// First box - the user's Name
$pdf->SetFontSize('12'); // set font size
$pdf->SetXY(156, 76); // set the position of the box
$pdf->Cell(0, 10,  date("d-m-Y"), 0, 0, 'C'); // add the text, align to Center of cell



// First box - the user's Name
$pdf->SetFontSize('12'); // set font size
$pdf->SetXY(15, 150); // set the position of the box
$pdf->Cell(0, 10,  $student_name, 0, 0, 'C'); // add the text, align to Center of cell



// First box - the user's Name
$pdf->SetFontSize('12'); // set font size
$pdf->SetXY(0, 158); // set the position of the box
$pdf->Cell(0, 10,  $course_name, 0, 0, 'C'); // add the text, align to Center of cell

$Roll_no = $mobile.'/'.date("y",strtotime("-1 year")).'-'.date("y").'/WEB/MUM';


// First box - the user's Name
$pdf->SetFontSize('12'); // set font size
$pdf->SetXY(34, 167); // set the position of the box
$pdf->Cell(0, 10,  $Roll_no, 0, 0, 'C'); // add the text, align to Center of cell


// render PDF to browser
$pdf->Output('Certificate_overview.pdf','I');

