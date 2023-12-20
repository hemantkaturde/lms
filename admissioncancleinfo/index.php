<?php

// include composer packages
include "vendor/autoload.php";
include "../db/config.php";
    

 $admission_id = $_GET['admission_id'];

 $result = $conn->query("SELECT tbl_admission.name,tbl_admission.lastname,tbl_admission.email,tbl_admission.mobile,sum(tbl_payment_transaction.totalAmount) as totalpaidAmount,tbl_payment_transaction.payment_date,tbl_payment_transaction.payment_mode,tbl_payment_transaction.datetime,tbl_enquiry.createdDtm,tbl_users.name as counsellor from  tbl_admission 
  join tbl_enquiry on tbl_enquiry.enq_id = tbl_admission.enq_id 
  join tbl_payment_transaction on tbl_payment_transaction.enquiry_id =tbl_enquiry.enq_id
  left join tbl_users on tbl_admission.counsellor_name = tbl_users.userId
  where tbl_admission.id=$admission_id");

 $result_arry = $result->fetch_assoc();
 $student_name = $result_arry['name'].' '.$result_arry['lastname'];
 $adhar_number = '1251254556555125';
 $email = $result_arry['email'];
 $mobile = $result_arry['mobile'];
 $totalpaidAmount = $result_arry['totalpaidAmount'];

 $payment_date = $result_arry['datetime'];
 $payment_mode = $result_arry['payment_mode'];
 $createdDtm = $result_arry['createdDtm'];
 $counsellor = $result_arry['counsellor'];
 
 
// Create new Landscape PDF
// $pdf = new FPDI('l');

// $pdf = new \setasign\Fpdi\Fpdi('l');
$pdf = new \setasign\Fpdi\Fpdi();

// Reference the PDF you want to use (use relative path)
$pagecount = $pdf->setSourceFile( 'admission_cancellation.pdf' );

// Import the first page from the PDF and add to dynamic PDF
$tpl = $pdf->importPage(1);
$pdf->AddPage();

// Use the imported page as the template
$pdf->useTemplate($tpl);

// Set the default font to use
$pdf->SetFont('Helvetica');

// adding a Cell using:
//$pdf->Cell( $width, $height, $text, $border, $fill, $align);

$pdf->SetFontSize('8');
$pdf->SetXY(85, 47);
$pdf->Cell(80, 8,  $student_name, 0, 0, 'L');


$pdf->SetFontSize('8');
$pdf->SetXY(85, 51.5);
$pdf->Cell(80, 8, $adhar_number, 0, 0, 'L');


$pdf->SetFontSize('8');
$pdf->SetXY(85, 55.5);
$pdf->Cell(80, 8, $email, 0, 0, 'L');


$pdf->SetFontSize('8');
$pdf->SetXY(85, 60);
$pdf->Cell(80, 8, $mobile, 0, 0, 'L');

$pdf->SetFontSize('8');
$pdf->SetXY(85, 64.3);
$pdf->Cell(80, 8,  $totalpaidAmount, 0, 0, 'L');


$pdf->SetFontSize('8');
$pdf->SetXY(85, 68.5);
$pdf->Cell(80, 8, $payment_date, 0, 0, 'L');


$pdf->SetFontSize('8');
$pdf->SetXY(85, 72.5);
$pdf->Cell(80, 8, $payment_mode, 0, 0, 'L');


$pdf->SetFontSize('8');
$pdf->SetXY(85, 98);
$pdf->Cell(80, 8, $createdDtm, 0, 0, 'L');


$pdf->SetFontSize('8');
$pdf->SetXY(85, 102);
$pdf->Cell(80, 8, $counsellor, 0, 0, 'L');


// render PDF to browser
$pdf->Output();


?>