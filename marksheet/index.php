<?php

// include composer packages
include "vendor/autoload.php";
include "../db/config.php";
include "phpqrcode/qrlib.php" ;

$student_id = $_GET['student_id'];


    /* get Student Details */
    $result = $conn->query("SELECT *,tbl_examination.createdDtm as examdate,tbl_examination.id  as examid,tbl_users.userid as user_id_auto from  tbl_users  
                         join tbl_student_answer_sheet on tbl_users.userid = tbl_student_answer_sheet.student_id
                         join tbl_course on tbl_student_answer_sheet.course_id = tbl_course.courseId
                         join tbl_course_type on tbl_course_type.ct_id = tbl_course.courseId
                         join tbl_users_enquires on tbl_users_enquires.user_id = tbl_users.userid
                         join tbl_admission on tbl_admission.enq_id = tbl_users_enquires.enq_id
                         join tbl_examination on tbl_examination.course_id = tbl_course.courseId
                         where tbl_users.userid=$student_id and tbl_users.isDeleted=0 
                         and tbl_users.user_flag='student' group by tbl_student_answer_sheet.student_id");

    $result_arry = $result->fetch_assoc();
    $student_name = $result_arry['name'].' '.$result_arry['lastname'];
    $course_name = $result_arry['course_name'];
    $dateofbirth = $result_arry['dateofbirth'];
    $mobile = $result_arry['mobile'];
    $examdate = $result_arry['examdate'];

    $courseId = $result_arry['courseId'];
    $examid = $result_arry['examid'];
    $userid = $result_arry['user_id_auto'];




    //$result_marsheet_details = $conn->query("SELECT * from tbl_student_answer_sheet where course_id= $courseId and exam_id=$examid and student_id=$userid group by tbl_student_answer_sheet.student_id");


    $get_total_marks = $conn->query("SELECT sum(marks) as totalmarks from tbl_student_answer_sheet where course_id= $courseId and exam_id=$examid and student_id=$userid group by tbl_student_answer_sheet.student_id");
    $total_marks = $get_total_marks->fetch_assoc();


    if($total_marks['totalmarks']){
        $total_marks=  $total_marks['totalmarks'];
        $ans_sheet_status ='Checked';
    }else{
        $total_marks=0;
        $ans_sheet_status ='Checking Pending';
    }

    if($total_marks >= 90 ){

        $grade ='A+';
        $Grade_point='10';
        $Remark ='Pass';
        $Quntitave_value='Outstanding';

    }else if($total_marks >= 80 && $total_marks <= 89){

        $grade ='A';
        $Grade_point='9';
        $Remark ='Pass';
        $Quntitave_value='Excellent';

    } else if($total_marks >= 70 && $total_marks <= 79){

        $grade ='B+';
        $Grade_point='8';
        $Remark ='Pass';
        $Quntitave_value='Very Good';

    } else if($total_marks >= 60 && $total_marks <= 69){

        $grade ='B';
        $Grade_point='7';
        $Remark ='Pass';
        $Quntitave_value='Good';

    }
    else if($total_marks >= 50 && $total_marks <= 59){

        $grade ='C';
        $Grade_point='6';
        $Remark ='Pass';
        $Quntitave_value='Above Average';

    }
    else if($total_marks >= 40 && $total_marks <= 49){

        $grade ='D';
        $Grade_point='5';
        $Remark ='Pass';
        $Quntitave_value='Average';

    }

    else if($total_marks >= 40 && $total_marks <= 44){

        $grade ='D';
        $Grade_point='4';
        $Remark ='Pass';
        $Quntitave_value='Poor';

    }

    else if($total_marks <= 40){

        $grade ='D';
        $Grade_point='0';
        $Remark ='Fail';
        $Quntitave_value='Fail';

    }



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
$pdf->SetXY(168, 154);
$new_date = date("Y-m-d",strtotime($examdate));
$pdf->Cell(0, 5,  $Remark, 0, 0, 'L');



$pdf->SetFontSize('10','B'); 
$pdf->SetXY(16, 176);
$pdf->Cell(0, 10,  '1', 0, 0, 'L');

$pdf->SetFontSize('10','B'); 
$pdf->SetXY(25, 176);
$pdf->Cell(0, 10,  $course_name, 0, 0, 'L');


$pdf->SetFontSize('10','B'); 
$pdf->SetXY(130, 176);
$pdf->Cell(0, 10,  $total_marks, 0, 0, 'L');




$pdf->SetFontSize('10','B'); 
$pdf->SetXY(185, 176);
$pdf->Cell(0, 10,  $grade , 0, 0, 'L');


$pdf->SetFontSize('20');
$pdf->SetXY(165.50,232);

$pdf->Output('marksheet.pdf','I');


?>