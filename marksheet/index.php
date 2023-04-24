<?php

// include composer packages
include "vendor/autoload.php";
include "../db/config.php";
include "phpqrcode/qrlib.php" ;

$student_id = $_GET['student_id'];


 /* get Student Details */
 $result = $conn->query("SELECT *,tbl_examination.createdDtm as examdate from  tbl_users  
                         join tbl_student_answer_sheet on tbl_users.userid = tbl_student_answer_sheet.student_id
                         join tbl_course on tbl_student_answer_sheet.course_id = tbl_course.courseId
                         join tbl_course_type on tbl_course_type.ct_id = tbl_course.courseId
                         join tbl_users_enquires on tbl_users_enquires.user_id = tbl_users.userid
                         join tbl_admission on tbl_admission.enq_id = tbl_users_enquires.enq_id
                         join tbl_examination on tbl_examination.course_id = tbl_course.courseId

                         where tbl_users.userid=$student_id and tbl_users.isDeleted=0 and tbl_users.user_flag='student' group by tbl_student_answer_sheet.student_id");

 $result_arry = $result->fetch_assoc();
 $student_name = $result_arry['name'].' '.$result_arry['lastname'];
 $course_name = $result_arry['course_name'];
 $dateofbirth = $result_arry['dateofbirth'];
 $mobile = $result_arry['mobile'];
 $examdate = $result_arry['examdate'];



$pdf = new \setasign\Fpdi\Fpdi();

$pagecount = $pdf->setSourceFile('marksheet.pdf');

$tpl = $pdf->importPage(1);
$pdf->AddPage();

$pdf->useTemplate($tpl);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('10','B');
$pdf->SetXY(52, 132);
$pdf->Cell(0, 5,  $mobile.'/'.date("y",strtotime("-1 year")).'-'.date("y").'/WEB/MUM', 0, 0, 'L');


$pdf->SetFontSize('10','B'); 
$pdf->SetXY(52, 139.8);
$pdf->Cell(0, 5,  $student_name, 0, 0, 'L');


$pdf->SetFontSize('10','B'); 
$pdf->SetXY(52, 146.8);
$pdf->Cell(0, 5,  $dateofbirth , 0, 0, 'L');



$pdf->SetFontSize('10','B');
$pdf->SetXY(168, 139.5);
$new_date = date("Y-m-d",strtotime($examdate));
$pdf->Cell(0, 5,  $new_date, 0, 0, 'L');


$pdf->SetFontSize('10','B'); 
$pdf->SetXY(52, 139.8);
$pdf->Cell(0, 5,  $student_name, 0, 0, 'L');


$pdf->SetFontSize('10','B'); 
$pdf->SetXY(52, 146.8);
$pdf->Cell(0, 5,  $dateofbirth , 0, 0, 'L');


$pdf->SetFontSize('10','B'); 
$pdf->SetXY(16, 176);
$pdf->Cell(0, 10,  '1', 0, 0, 'L');

$pdf->SetFontSize('10','B'); 
$pdf->SetXY(25, 176);
$pdf->Cell(0, 10,  $course_name, 0, 0, 'L');




$pdf->SetFontSize('20');
$pdf->SetXY(165.50,232);

$pdf->Output('marksheet.pdf','I');


?>